<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Adds the Canadian destination tree captured from the former GoExploria data.
 * The bundled manifest makes this seeder independent from the old SQL dump.
 * Existing rows are matched by normalized name and their parent IDs.
 */
class CanadaManualDestinationsSeeder extends Seeder
{
    private array $resolved = [];
    private array $indexes = [];
    private array $tables = [
        'provinces' => ['country_id'], 'regions' => ['province_id'],
        'secteurs' => ['region_id'], 'villes' => ['region_id', 'secteur_id'],
        'arrondissements' => ['ville_id'], 'quartiers' => ['ville_id', 'arrondissement_id'],
    ];
    private array $stats = ['inserted' => 0, 'matched' => 0, 'skipped' => 0];

    public function run(): void
    {
        $manifest = database_path('seeders/data/canada-legacy-destinations.json');
        if (!is_file($manifest)) throw new RuntimeException('Canada destination manifest is missing.');
        foreach (array_keys($this->tables) as $table) {
            if (!Schema::hasTable($table)) throw new RuntimeException("Destination table [{$table}] is missing.");
        }

        $country = DB::table('countries')->where('iso2', 'CA')->orWhere('code', 'CAN')->first();
        if (!$country) throw new RuntimeException('Canada (ISO2 CA / ISO3 CAN) must exist before seeding destinations.');

        $payload = json_decode((string) file_get_contents($manifest), true, 512, JSON_THROW_ON_ERROR);
        $types = $payload['types'] ?? [];
        $pending = $payload['locations'] ?? [];
        foreach ($pending as $child) {
            $childType = $types[(string) ($child['type_id'] ?? '')] ?? [];
            if (($child['parent_id'] ?? null) !== null && $this->role($childType) === 'arrondissement') {
                $this->childArrondissement[(string) $child['parent_id']] = true;
            }
        }
        $this->loadIndexes();

        DB::transaction(function () use ($types, &$pending, $country): void {
            do {
                $progress = false;
                foreach ($pending as $key => $row) {
                    $parentId = $this->nullableInt($row['parent_id'] ?? null);
                    if ($parentId !== null && !isset($this->resolved[(string) $parentId])) continue;
                    unset($pending[$key]);
                    $type = $types[(string) ($row['type_id'] ?? '')] ?? null;
                    if (!$type || !$this->process($row, $type, $country->id)) {
                        $this->stats['skipped']++;
                    }
                    $progress = true;
                }
            } while ($progress && $pending);
            $this->stats['skipped'] += count($pending);
        });

        foreach ($this->stats as $name => $count) $this->command?->line("Canada destinations {$name}: {$count}");
    }

    private function process(array $row, array $type, int $countryId): bool
    {
        $id = (string) ($row['id'] ?? '');
        $name = trim((string) ($row['name'] ?? ''));
        if ($id === '' || $name === '') return false;
        $role = $this->role($type);
        $parent = isset($row['parent_id']) ? ($this->resolved[(string) $row['parent_id']] ?? null) : null;
        if (isset($this->childArrondissement[$id]) && $role === 'secteur') $role = 'ville';
        if (!$role) return false;

        if ($role === 'province') {
            $code = $this->provinceCode($name);
            $parents = ['country_id' => $countryId];
            $table = 'provinces';
            $values = ['name' => $name, 'country_id' => $countryId, 'code' => $code];
        } elseif ($role === 'region') {
            $province = $this->ancestor($parent, 'province') ?? ($parent['role'] === 'province' ? $parent : null);
            if (!$province) return false;
            $parents = ['province_id' => $province['id']]; $table = 'regions';
            $values = ['name' => $name, 'province_id' => $province['id']];
        } else {
            $province = $this->ancestor($parent, 'province');
            $region = $this->ancestor($parent, 'region');
            $sector = $this->ancestor($parent, 'secteur');
            $ville = $this->ancestor($parent, 'ville');
            if ($role === 'secteur') {
                $region ??= $parent['role'] === 'region' ? $parent : null;
                if (!$region) return false;
                $parents = ['region_id' => $region['id']]; $table = 'secteurs';
                $values = ['name' => $name, 'region_id' => $region['id'], 'classification' => $type['name'] ?? 'Secteur'];
            } elseif ($role === 'ville') {
                $region ??= $parent['role'] === 'region' ? $parent : null;
                if (!$region && ($parent['role'] ?? null) === 'province') $region = $this->ensureRegion($parent['id'], 'Autres destinations');
                if (!$region) return false;
                $province ??= $this->provinceForRegion($region['id']);
                if (!$province) return false;
                $parents = ['region_id' => $region['id'], 'secteur_id' => $sector['id'] ?? null]; $table = 'villes';
                $values = ['name' => $name, 'region_id' => $region['id'], 'secteur_id' => $sector['id'] ?? null,
                    'province_id' => $province['id'], 'country_id' => $countryId, 'classification' => $type['name'] ?? 'Localité'];
            } elseif ($role === 'arrondissement') {
                if (!$ville && ($parent['role'] ?? null) === 'ville') $ville = $parent;
                if (!$ville) return false;
                $parents = ['ville_id' => $ville['id']]; $table = 'arrondissements';
                $values = ['name' => $name, 'ville_id' => $ville['id'], 'classification' => $type['name'] ?? 'Arrondissement'];
            } elseif ($role === 'quartier') {
                if (!$ville && ($parent['role'] ?? null) === 'ville') $ville = $parent;
                if (!$ville) return false;
                $arr = $this->ancestor($parent, 'arrondissement');
                $parents = ['ville_id' => $ville['id'], 'arrondissement_id' => $arr['id'] ?? null]; $table = 'quartiers';
                $values = ['name' => $name, 'ville_id' => $ville['id'], 'arrondissement_id' => $arr['id'] ?? null,
                    'classification' => $type['name'] ?? 'Quartier'];
            } else return false;
        }

        foreach (['population' => 'population', 'superficie' => 'area', 'latitude' => 'latitude', 'longitude' => 'longitude', 'description' => 'description'] as $source => $target) {
            $value = $row[$source] ?? null;
            if ($value !== null && $value !== '' && ($target !== 'description' || trim((string) $value) !== '')) $values[$target] = $value;
        }
        $values['is_active'] = filter_var($row['is_activated'] ?? true, FILTER_VALIDATE_BOOL);
        $values = array_filter($values, fn ($value, $column) => Schema::hasColumn($table, $column), ARRAY_FILTER_USE_BOTH);
        $existing = $this->find($table, $name, $parents);
        if ($existing) {
            $this->stats['matched']++;
            $targetId = (int) $existing['id'];
        } else {
            $now = now(); $values['created_at'] = $now; $values['updated_at'] = $now;
            $targetId = (int) DB::table($table)->insertGetId($values);
            $this->stats['inserted']++;
            $existing = ['id' => $targetId] + $values;
            $this->remember($table, $existing);
        }
        $this->resolved[$id] = ['id' => $targetId, 'role' => $role, 'parent' => $parent];
        return true;
    }

    private array $childArrondissement = [];

    private function role(array $type): ?string
    {
        $key = $this->key((string) ($type['name'] ?? '')); $level = (int) ($type['level'] ?? 0);
        if (str_contains($key, 'quartier')) return 'quartier';
        if (str_contains($key, 'arrondissement')) return 'arrondissement';
        if (str_contains($key, 'secteur')) return $level <= 1 ? 'province' : 'secteur';
        if (str_contains($key, 'province') || str_contains($key, 'etat') || str_contains($key, 'state')) return 'province';
        if (str_contains($key, 'departement') || str_contains($key, 'district') || str_contains($key, 'region')) return $level <= 1 ? 'province' : 'region';
        if (str_contains($key, 'ville') || str_contains($key, 'municipal') || str_contains($key, 'city')) return 'ville';
        return $level === 1 ? 'province' : null;
    }

    private function loadIndexes(): void
    {
        foreach ($this->tables as $table => $parents) {
            $columns = array_values(array_filter(array_merge(['id', 'name', 'code'], $parents), fn ($c) => Schema::hasColumn($table, $c)));
            foreach (DB::table($table)->select($columns)->orderBy('id')->get() as $row) $this->remember($table, (array) $row);
        }
    }

    private function find(string $table, string $name, array $parents): ?array
    {
        $key = $this->indexKey($table, $name, $parents);
        if (isset($this->indexes[$key])) return $this->indexes[$key];
        if ($table === 'provinces') {
            $code = $this->provinceCode($name);
            if ($code) foreach ($this->indexes as $candidate) if (($candidate['_table'] ?? null) === $table && strtoupper((string) ($candidate['code'] ?? '')) === $code) return $candidate;
        }
        return null;
    }

    private function remember(string $table, array $row): void
    {
        if (!isset($row['id'], $row['name'])) return;
        $row['_table'] = $table;
        $parents = []; foreach ($this->tables[$table] as $field) $parents[$field] = $row[$field] ?? null;
        $this->indexes[$this->indexKey($table, (string) $row['name'], $parents)] ??= $row;
    }

    private function indexKey(string $table, string $name, array $parents): string
    {
        $parts = [$table, $this->key($name)];
        foreach ($this->tables[$table] as $field) $parts[] = $field . '=' . (string) ($parents[$field] ?? '');
        return implode('|', $parts);
    }

    private function ancestor(?array $node, string $role): ?array
    {
        while ($node) { if (($node['role'] ?? null) === $role) return $node; $node = $node['parent'] ?? null; }
        return null;
    }

    private function ensureRegion(int $provinceId, string $name): array
    {
        $parents = ['province_id' => $provinceId];
        if ($existing = $this->find('regions', $name, $parents)) return ['id' => (int) $existing['id'], 'role' => 'region', 'parent' => null];
        $values = ['name' => $name, 'province_id' => $provinceId, 'classification' => 'Région de rattachement', 'is_active' => true];
        $values = array_filter($values, fn ($value, $column) => Schema::hasColumn('regions', $column), ARRAY_FILTER_USE_BOTH);
        $now = now(); $values['created_at'] = $now; $values['updated_at'] = $now;
        $id = (int) DB::table('regions')->insertGetId($values); $row = ['id' => $id] + $values; $this->remember('regions', $row);
        return ['id' => $id, 'role' => 'region', 'parent' => null];
    }

    private function provinceForRegion(int $regionId): ?array
    {
        $id = DB::table('regions')->where('id', $regionId)->value('province_id');
        return $id ? ['id' => (int) $id, 'role' => 'province', 'parent' => null] : null;
    }

    private function provinceCode(string $name): ?string
    {
        $codes = ['Alberta'=>'AB','Colombie-Britannique'=>'BC','British Columbia'=>'BC','Ile-du-Prince-Edouard'=>'PE','Île-du-Prince-Édouard'=>'PE',
            'Manitoba'=>'MB','Nouveau-Brunswick'=>'NB','Nouvelle-Ecosse'=>'NS','Nouvelle-Écosse'=>'NS','Ontario'=>'ON','Québec'=>'QC','Quebec'=>'QC',
            'Saskatchewan'=>'SK','Terre-Neuve-et-Labrador'=>'NL','Territoires du Nord-Ouest'=>'NT','Northwest Territories'=>'NT','Nunavut'=>'NU','Yukon'=>'YT'];
        return $codes[$name] ?? null;
    }

    private function key(string $value): string { return preg_replace('/[^a-z0-9]+/', '', Str::lower(Str::ascii(trim($value)))) ?? ''; }
    private function nullableInt(mixed $value): ?int { return $value === null || $value === '' ? null : (int) $value; }
}
