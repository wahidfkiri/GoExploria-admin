<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Merge the destination tree from the original GoExploria SQL dump into the
 * normalized destination tables used by GoExploria Business.
 *
 * Run with LEGACY_GOEXPLORIA_SQL pointing at the old SQL dump. This seeder is
 * intentionally additive: it matches by normalized name + parent, never
 * deletes rows, and only fills blank fields on an existing destination.
 */
class LegacyDestinationsSeeder extends Seeder
{
    private array $tables = [];
    private array $indexes = [];
    private array $continentIds = [];
    private array $countryIds = [];
    private array $countryCenters = [];
    private array $countryCentersByName = [];
    private array $locationIds = [];
    private array $types = [];
    private array $typeIdByNameCountry = [];
    private array $childrenTypes = [];
    private array $stats = [
        'continents_inserted' => 0,
        'continents_matched' => 0,
        'countries_inserted' => 0,
        'countries_matched' => 0,
        'countries_without_reference_point' => 0,
        'locations_inserted' => 0,
        'locations_matched' => 0,
        'locations_skipped' => 0,
        'legacy_locations_missing_coordinates' => 0,
        'legacy_locations_invalid_coordinates' => 0,
    ];

    public function run(): void
    {
        $file = env('LEGACY_GOEXPLORIA_SQL');
        if (!$file || !is_file($file) || !is_readable($file)) {
            throw new RuntimeException(
                'Set LEGACY_GOEXPLORIA_SQL to the readable path of goexploria.com.sql before running this seeder.'
            );
        }

        foreach (['continents', 'countries', 'provinces', 'regions', 'secteurs', 'villes', 'arrondissements', 'quartiers'] as $table) {
            if (!Schema::hasTable($table)) {
                throw new RuntimeException("Destination table [{$table}] is missing. Run the project migrations first.");
            }
        }

        DB::transaction(function () use ($file): void {
            $this->loadCountryCenters();
            $sourceContinents = iterator_to_array($this->readTable($file, 'continents'), false);
            $sourceCountries = iterator_to_array($this->readTable($file, 'countries'), false);
            $sourceTypes = iterator_to_array($this->readTable($file, 'locations_types'), false);

            $this->loadIndexes();
            $this->mergeContinents($sourceContinents);
            $this->mergeCountries($sourceCountries);
            $this->loadTypes($sourceTypes);
            $this->mergeLocations($file);
        });

        foreach ($this->stats as $name => $value) {
            $this->command?->line(str_pad($name, 34) . $value);
        }
    }

    private function loadIndexes(): void
    {
        $this->tables = [
            'continents' => ['parent' => [], 'columns' => ['id', 'name', 'code']],
            'countries' => ['parent' => ['continent_id'], 'columns' => ['id', 'name', 'code', 'iso2', 'continent_id']],
            'provinces' => ['parent' => ['country_id'], 'columns' => ['id', 'name', 'country_id']],
            'regions' => ['parent' => ['province_id'], 'columns' => ['id', 'name', 'province_id']],
            'secteurs' => ['parent' => ['region_id'], 'columns' => ['id', 'name', 'region_id']],
            'villes' => ['parent' => ['region_id'], 'columns' => ['id', 'name', 'region_id', 'secteur_id', 'province_id', 'country_id']],
            'arrondissements' => ['parent' => ['ville_id'], 'columns' => ['id', 'name', 'ville_id', 'secteur_id']],
            'quartiers' => ['parent' => ['ville_id', 'arrondissement_id'], 'columns' => ['id', 'name', 'ville_id', 'arrondissement_id']],
        ];

        foreach ($this->tables as $table => $config) {
            $columns = array_values(array_filter($config['columns'], fn ($column) => Schema::hasColumn($table, $column)));
            foreach (DB::table($table)->select($columns)->orderBy('id')->cursor() as $row) {
                $this->remember($table, (array) $row);
            }
        }
    }

    private function mergeContinents(array $rows): void
    {
        foreach ($rows as $row) {
            $id = (string) ($row['id'] ?? '');
            $name = trim((string) ($row['name'] ?? ''));
            if ($id === '' || $name === '') continue;

            $code = strtoupper(trim((string) ($row['code'] ?? '')));
            $existing = $this->findExisting('continents', $name, []);
            if (!$existing && $code !== '') {
                foreach (DB::table('continents')->select('id', 'name', 'code')->cursor() as $candidate) {
                    if (strtoupper((string) $candidate->code) === $code) {
                        $existing = (array) $candidate;
                        break;
                    }
                }
            }

            $values = $this->available('continents', [
                'name' => $name,
                'code' => $code ?: null,
                'is_active' => true,
            ]);
            $target = $this->mergeRecord('continents', $name, [], $values, $existing);
            $this->continentIds[$id] = $target['id'];
            $this->stats[$target['inserted'] ? 'continents_inserted' : 'continents_matched']++;
        }
    }

    private function mergeCountries(array $rows): void
    {
        foreach ($rows as $row) {
            $id = (string) ($row['id'] ?? '');
            $name = trim((string) ($row['name'] ?? ''));
            if ($id === '' || $name === '') continue;

            $continentId = $this->continentIds[(string) ($row['continent_id'] ?? '')] ?? null;
            if (!$continentId) {
                $this->stats['locations_skipped']++;
                continue;
            }

            $iso2 = strtoupper(trim((string) ($row['code'] ?? '')));
            $existing = $this->findExisting('countries', $name, ['continent_id' => $continentId]);
            if (!$existing && $iso2 !== '') {
                foreach (DB::table('countries')->select('id', 'name', 'code', 'iso2', 'continent_id')->cursor() as $candidate) {
                    if (strtoupper((string) $candidate->iso2) === $iso2) {
                        $existing = (array) $candidate;
                        break;
                    }
                }
            }

            $iso3 = $existing ? strtoupper((string) ($existing['code'] ?? '')) : $this->iso3($iso2);
            $center = $this->countryCenters[$iso3] ?? $this->countryCentersByName[$this->key($name)] ?? null;
            $values = $this->available('countries', [
                'name' => $name,
                'code' => $iso3 ?: ($this->iso3($iso2) ?: ($iso2 ?: null)),
                'iso2' => $iso2 ?: null,
                'continent_id' => $continentId,
                'latitude' => $center['latitude'] ?? null,
                'longitude' => $center['longitude'] ?? null,
                'is_active' => filter_var($row['is_activated'] ?? true, FILTER_VALIDATE_BOOL),
            ]);
            if (!$center) $this->stats['countries_without_reference_point']++;
            $target = $this->mergeRecord('countries', $name, ['continent_id' => $continentId], $values, $existing);
            $this->countryIds[$id] = $target['id'];
            $this->stats[$target['inserted'] ? 'countries_inserted' : 'countries_matched']++;
        }
    }

    private function loadCountryCenters(): void
    {
        $path = database_path('seeders/data/country-centers-natural-earth.json');
        if (!is_file($path)) return;
        $payload = json_decode((string) file_get_contents($path), true);
        foreach (($payload['points'] ?? []) as $iso3 => $point) {
            if (!is_array($point) || !is_numeric($point['latitude'] ?? null) || !is_numeric($point['longitude'] ?? null)) continue;
            $this->countryCenters[strtoupper((string) $iso3)] = [
                'latitude' => (string) $point['latitude'],
                'longitude' => (string) $point['longitude'],
            ];
            if (!empty($point['name'])) $this->countryCentersByName[$this->key((string) $point['name'])] = $this->countryCenters[strtoupper((string) $iso3)];
        }
    }

    private function loadTypes(array $rows): void
    {
        foreach ($rows as $row) {
            $id = (string) ($row['id'] ?? '');
            if ($id === '') continue;
            $type = [
                'id' => $id,
                'name' => trim((string) ($row['name'] ?? '')),
                'parent_id' => $this->nullableInt($row['parent_id'] ?? null),
                'country_id' => (string) ($row['country_id'] ?? ''),
                'level' => (int) ($row['level'] ?? 0),
            ];
            $this->types[$id] = $type;
            $key = $type['country_id'] . ':' . $this->key($type['name']);
            $this->typeIdByNameCountry[$key] = $id;
        }
    }

    private function mergeLocations(string $file): void
    {
        $cityParents = [];
        foreach ($this->readTable($file, 'locations') as $row) {
            $parent = (string) ($row['parent_id'] ?? '');
            $childType = $this->types[(string) ($row['type_id'] ?? '')] ?? null;
            if ($parent !== '' && $parent !== 'NULL' && $childType
                && str_contains($this->key($childType['name']), 'arrondissement')) {
                $cityParents[$parent] = true;
            }
        }

        $pending = [];
        foreach ($this->readTable($file, 'locations') as $row) {
            if (!$this->processLocationRow($row, $cityParents)) $pending[(string) ($row['id'] ?? '')] = $row;
        }

        // A later-parent reference is unusual but possible in hand-edited dumps.
        do {
            $progress = false;
            foreach ($pending as $id => $row) {
                $parentId = $this->nullableInt($row['parent_id'] ?? null);
                if ($parentId !== null && !isset($this->locationIds[(string) $parentId])) continue;
                unset($pending[$id]);
                $this->processLocationRow($row, $cityParents);
                $progress = true;
            }
        } while ($progress && $pending);

        $this->stats['locations_skipped'] += count($pending);
    }

    private function processLocationRow(array $row, array $cityParents): bool
    {
        $id = (string) ($row['id'] ?? '');
        $parentId = $this->nullableInt($row['parent_id'] ?? null);
        if ($parentId !== null && !isset($this->locationIds[(string) $parentId])) return false;

        $type = $this->types[(string) ($row['type_id'] ?? '')] ?? null;
        $role = $type ? $this->roleFor($type) : null;
        if (isset($cityParents[$id]) && $role === 'secteur') $role = 'ville';
        // Root-level localities with no finer administrative class occupy the
        // province slot in the target schema, the first level below a country.
        if ($parentId === null && $role === 'ville') $role = 'province';
        if (!$type || !$role) { $this->stats['locations_skipped']++; return true; }

        $countryId = $this->countryIds[$type['country_id']] ?? null;
        if (!$countryId) { $this->stats['locations_skipped']++; return true; }
        $parent = $parentId === null ? null : ($this->locationIds[(string) $parentId] ?? null);
        $target = $this->mergeLocation($row, $type, $role, $parent, $countryId);
        if (!$target) { $this->stats['locations_skipped']++; return true; }

        $this->locationIds[$id] = $target['id'];
        $this->stats[$target['inserted'] ? 'locations_inserted' : 'locations_matched']++;
        if (!$this->validCoordinatePair($row)) $this->stats['legacy_locations_missing_coordinates']++;
        return true;
    }

    private function mergeLocation(array $row, array $type, string $role, ?array $parent, int $countryId): ?array
    {
        $name = trim((string) ($row['name'] ?? ''));
        if ($name === '') return null;

        $parentRole = $parent['role'] ?? null;
        $parentId = $parent['id'] ?? null;
        $provinceId = $role === 'province' ? null : $this->ancestorId($parent, 'province');
        $regionId = $role === 'region' ? null : $this->ancestorId($parent, 'region');
        $sectorId = $role === 'secteur' ? null : $this->ancestorId($parent, 'secteur');
        $villeId = $role === 'ville' ? null : $this->ancestorId($parent, 'ville');
        $arrId = $role === 'quartier' ? $this->ancestorId($parent, 'arrondissement') : null;

        if ($role === 'province') {
            $parents = ['country_id' => $countryId];
            $table = 'provinces';
            $values = [
                'name' => $name, 'country_id' => $countryId,
                'population' => $this->number($row['population'] ?? null),
                'area' => $this->number($row['superficie'] ?? null),
                'latitude' => $this->coordinate($row['latitude'] ?? null, true),
                'longitude' => $this->coordinate($row['longitude'] ?? null, false),
                'description' => $this->nullableText($row['description'] ?? null),
                'is_active' => filter_var($row['is_activated'] ?? true, FILTER_VALIDATE_BOOL),
            ];
        } elseif ($role === 'region') {
            $provinceId ??= $parentRole === 'province' ? $parentId : null;
            if (!$provinceId) return null;
            $parents = ['province_id' => $provinceId];
            $table = 'regions';
            $values = [
                'name' => $name, 'province_id' => $provinceId,
                'population' => $this->number($row['population'] ?? null),
                'area' => $this->number($row['superficie'] ?? null),
                'latitude' => $this->coordinate($row['latitude'] ?? null, true),
                'longitude' => $this->coordinate($row['longitude'] ?? null, false),
                'description' => $this->nullableText($row['description'] ?? null),
                'is_active' => filter_var($row['is_activated'] ?? true, FILTER_VALIDATE_BOOL),
            ];
        } elseif ($role === 'secteur') {
            $regionId ??= $parentRole === 'region' ? $parentId : null;
            if (!$regionId) return null;
            $parents = ['region_id' => $regionId];
            $table = 'secteurs';
            $values = [
                'name' => $name, 'region_id' => $regionId,
                'classification' => $type['name'] ?: null,
                'population' => $this->number($row['population'] ?? null),
                'area' => $this->number($row['superficie'] ?? null),
                'latitude' => $this->coordinate($row['latitude'] ?? null, true),
                'longitude' => $this->coordinate($row['longitude'] ?? null, false),
                'description' => $this->nullableText($row['description'] ?? null),
                'is_active' => filter_var($row['is_activated'] ?? true, FILTER_VALIDATE_BOOL),
            ];
        } elseif ($role === 'ville') {
            if ($parentRole === 'province' && !$regionId) {
                $regionId = $this->ensureRegion($countryId, $parentId, 'Autres destinations');
            }
            $regionId ??= $parentRole === 'region' ? $parentId : null;
            if (!$regionId) return null;
            $provinceId ??= $this->provinceForRegion($regionId);
            if (!$provinceId) return null;
            $parents = ['region_id' => $regionId, 'secteur_id' => $sectorId];
            $table = 'villes';
            $values = [
                'name' => $name, 'region_id' => $regionId,
                'secteur_id' => $sectorId,
                'province_id' => $provinceId, 'country_id' => $countryId,
                'classification' => $type['name'] ?: 'Localité',
                'population' => $this->number($row['population'] ?? null),
                'area' => $this->number($row['superficie'] ?? null),
                'latitude' => $this->coordinate($row['latitude'] ?? null, true),
                'longitude' => $this->coordinate($row['longitude'] ?? null, false),
                'description' => $this->nullableText($row['description'] ?? null),
                'is_active' => filter_var($row['is_activated'] ?? true, FILTER_VALIDATE_BOOL),
            ];
        } elseif ($role === 'arrondissement') {
            if (!$villeId && $parentRole === 'ville') $villeId = $parentId;
            if (!$villeId) return null;
            $parents = ['ville_id' => $villeId];
            $table = 'arrondissements';
            $values = [
                'name' => $name, 'ville_id' => $villeId,
                'classification' => $type['name'] ?: 'Arrondissement',
                'population' => $this->number($row['population'] ?? null),
                'area' => $this->number($row['superficie'] ?? null),
                'latitude' => $this->coordinate($row['latitude'] ?? null, true),
                'longitude' => $this->coordinate($row['longitude'] ?? null, false),
                'description' => $this->nullableText($row['description'] ?? null),
                'is_active' => filter_var($row['is_activated'] ?? true, FILTER_VALIDATE_BOOL),
            ];
        } elseif ($role === 'quartier') {
            if (!$villeId && $parentRole === 'ville') $villeId = $parentId;
            if (!$villeId) return null;
            $parents = ['ville_id' => $villeId, 'arrondissement_id' => $arrId];
            $table = 'quartiers';
            $values = [
                'name' => $name, 'ville_id' => $villeId,
                'arrondissement_id' => $arrId,
                'classification' => $type['name'] ?: 'Quartier',
                'population' => $this->number($row['population'] ?? null),
                'area' => $this->number($row['superficie'] ?? null),
                'latitude' => $this->coordinate($row['latitude'] ?? null, true),
                'longitude' => $this->coordinate($row['longitude'] ?? null, false),
                'description' => $this->nullableText($row['description'] ?? null),
                'is_active' => filter_var($row['is_activated'] ?? true, FILTER_VALIDATE_BOOL),
            ];
        } else {
            return null;
        }

        $existing = $this->findExisting($table, $name, $parents);
        $result = $this->mergeRecord($table, $name, $parents, $this->available($table, $values), $existing);
        return ['id' => $result['id'], 'role' => $role, 'inserted' => $result['inserted'], 'parent' => $parent];
    }

    private function roleFor(array $type): ?string
    {
        $name = $this->key($type['name']);
        $level = $type['level'];
        if (str_contains($name, 'quartier')) return 'quartier';
        if (str_contains($name, 'arrondissement')) return 'arrondissement';
        if (str_contains($name, 'secteur')) return $level <= 1 ? 'province' : 'secteur';
        if (str_contains($name, 'province') || str_contains($name, 'etat') || str_contains($name, 'state')) return 'province';
        if (str_contains($name, 'departement') || str_contains($name, 'district')) return $level <= 1 ? 'province' : 'region';
        if (str_contains($name, 'region')) return $level <= 1 ? 'province' : 'region';
        if (str_contains($name, 'ville') || str_contains($name, 'municipal') || str_contains($name, 'city')) return 'ville';
        return $level === 1 ? 'province' : null;
    }

    private function ensureRegion(int $countryId, int $provinceId, string $name): int
    {
        $key = 'regions|' . $this->key($name) . '|province_id=' . $provinceId;
        if (isset($this->indexes[$key])) return $this->indexes[$key]['id'];
        $result = $this->mergeRecord('regions', $name, ['province_id' => $provinceId], $this->available('regions', [
            'name' => $name, 'province_id' => $provinceId,
            'classification' => 'Région de rattachement', 'is_active' => true,
        ]));
        return $result['id'];
    }

    private function provinceForRegion(int $regionId): ?int
    {
        $row = DB::table('regions')->where('id', $regionId)->value('province_id');
        return $row ? (int) $row : null;
    }

    private function ancestorId(?array $parent, string $role): ?int
    {
        while ($parent) {
            if (($parent['role'] ?? null) === $role) return (int) $parent['id'];
            $parent = $parent['parent'] ?? null;
        }
        return null;
    }

    private function mergeRecord(string $table, string $name, array $parents, array $values, ?array $existing = null): array
    {
        $existing ??= $this->findExisting($table, $name, $parents);
        $inserted = false;
        if (!$existing) {
            $values['created_at'] = now();
            $values['updated_at'] = now();
            $id = (int) DB::table($table)->insertGetId($values);
            $existing = ['id' => $id] + $values;
            $inserted = true;
        } else {
            $patch = [];
            foreach ($values as $column => $value) {
                if ($value !== null && (!array_key_exists($column, $existing) || $existing[$column] === null || $existing[$column] === '')) {
                    $patch[$column] = $value;
                }
            }
            if ($patch) {
                $patch['updated_at'] = now();
                DB::table($table)->where('id', $existing['id'])->update($patch);
                $existing = array_merge($existing, $patch);
            }
        }
        $this->remember($table, $existing);
        return ['id' => (int) $existing['id'], 'inserted' => $inserted];
    }

    private function findExisting(string $table, string $name, array $parents): ?array
    {
        $key = $this->indexKey($table, $name, $parents);
        return $this->indexes[$key] ?? null;
    }

    private function remember(string $table, array $row): void
    {
        if (!isset($row['name'], $row['id'])) return;
        $parents = [];
        foreach ($this->tables[$table]['parent'] ?? [] as $field) $parents[$field] = $row[$field] ?? null;
        $key = $this->indexKey($table, (string) $row['name'], $parents);
        $this->indexes[$key] ??= $row;
    }

    private function indexKey(string $table, string $name, array $parents): string
    {
        $parts = [$table, $this->key($name)];
        foreach ($this->tables[$table]['parent'] ?? [] as $field) $parts[] = $field . '=' . (string) ($parents[$field] ?? '');
        return implode('|', $parts);
    }

    private function available(string $table, array $values): array
    {
        return array_filter($values, fn ($value, $column) => Schema::hasColumn($table, $column), ARRAY_FILTER_USE_BOTH);
    }

    private function readTable(string $file, string $wanted): \Generator
    {
        $handle = fopen($file, 'rb');
        if (!$handle) throw new RuntimeException("Cannot open legacy SQL dump: {$file}");
        try {
            while (($line = fgets($handle)) !== false) {
                if (!preg_match('/^INSERT INTO `([^`]+)`\s*\((.*?)\)\s*VALUES\s*(.*)$/is', $line, $match)) continue;
                if ($match[1] !== $wanted) continue;
                $columns = array_map(static fn ($column) => trim($column, " `\t\r\n"), explode(',', $match[2]));
                $body = $match[3];
                $quote = false; $escape = false; $done = false;
                while (!$done) {
                    $length = strlen($body);
                    for ($i = 0; $i < $length; $i++) {
                        $character = $body[$i];
                        if ($quote) {
                            if ($escape) $escape = false;
                            elseif ($character === "\\") $escape = true;
                            elseif ($character === "'") $quote = false;
                        } elseif ($character === "'") $quote = true;
                        elseif ($character === ';') { $body = substr($body, 0, $i); $done = true; break; }
                    }
                    if (!$done) {
                        $next = fgets($handle);
                        if ($next === false) throw new RuntimeException("Unterminated INSERT for {$wanted} in legacy SQL dump.");
                        $body .= $next;
                    }
                }
                foreach ($this->parseTuples($body, $columns) as $row) yield $row;
            }
        } finally {
            fclose($handle);
        }
    }

    private function parseTuples(string $sql, array $columns): \Generator
    {
        $count = strlen($sql); $depth = 0; $quote = false; $escape = false; $field = ''; $fields = [];
        for ($i = 0; $i < $count; $i++) {
            $c = $sql[$i];
            if ($quote) {
                if ($escape) {
                    $field .= match ($c) { 'n' => "\n", 'r' => "\r", 't' => "\t", '0' => "\0", 'Z' => "\x1a", default => $c };
                    $escape = false;
                } elseif ($c === "\\") $escape = true;
                elseif ($c === "'") {
                    if (($sql[$i + 1] ?? '') === "'") { $field .= "'"; $i++; }
                    else $quote = false;
                } else $field .= $c;
                continue;
            }
            if ($c === "'") { $quote = true; continue; }
            if ($c === '(') { if ($depth++ === 0) { $field = ''; $fields = []; } else $field .= $c; continue; }
            if ($depth === 0) continue;
            if ($c === ',') { $fields[] = trim($field); $field = ''; continue; }
            if ($c === ')') {
                $fields[] = trim($field); $field = ''; $depth--;
                $row = [];
                foreach ($columns as $index => $column) {
                    $value = $fields[$index] ?? null;
                    $row[$column] = $value === null || strtoupper($value) === 'NULL' ? null : $value;
                }
                yield $row;
                continue;
            }
            $field .= $c;
        }
    }

    private function iso3(string $iso2): ?string
    {
        if ($iso2 === '') return null;
        if (class_exists(\Locale::class)) {
            $code = strtoupper(\Locale::getISO3Country('en_' . $iso2));
            if (strlen($code) === 3 && ctype_alpha($code)) return $code;
        }
        return null;
    }

    private function key(string $value): string
    {
        return preg_replace('/[^a-z0-9]+/', '', Str::lower(Str::ascii(trim($value)))) ?? '';
    }

    private function number(mixed $value): int|float|null
    {
        if ($value === null || $value === '' || !is_numeric($value)) return null;
        return str_contains((string) $value, '.') ? (float) $value : (int) $value;
    }

    private function nullableInt(mixed $value): ?int
    {
        return $value === null || $value === '' || strtoupper((string) $value) === 'NULL' ? null : (int) $value;
    }

    private function nullableText(mixed $value): ?string
    {
        $value = trim((string) ($value ?? ''));
        return $value === '' ? null : $value;
    }

    private function coordinate(mixed $value, bool $latitude): ?string
    {
        if ($value === null || $value === '' || !is_numeric($value)) return null;
        $number = (float) $value;
        $limit = $latitude ? 90 : 180;
        if (abs($number) > $limit) { $this->stats['legacy_locations_invalid_coordinates']++; return null; }
        return rtrim(rtrim(sprintf('%.8F', $number), '0'), '.');
    }

    private function validCoordinatePair(array $row): bool
    {
        $lat = $row['latitude'] ?? null; $lng = $row['longitude'] ?? null;
        return is_numeric($lat) && is_numeric($lng) && abs((float) $lat) <= 90 && abs((float) $lng) <= 180;
    }
}
