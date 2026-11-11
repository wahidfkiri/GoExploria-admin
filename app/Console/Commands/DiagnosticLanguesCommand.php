<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Vendor\Cms\Support\LanguesSite;

/**
 * Diagnostic des adresses par langue d'un établissement (sites multilingues).
 *
 *   php artisan langues:diagnostic 2
 *   php artisan langues:diagnostic 2 --chemin=/company/2/en/page/menu
 *
 * Dit si les routes /{langue} sont chargées (code à jour, cache des routes
 * vidé), quelles langues l'établissement propose et publie, et ce que
 * deviendra l'adresse testée.
 */
class DiagnosticLanguesCommand extends Command
{
    protected $signature = 'langues:diagnostic {etablissement : identifiant de l\'établissement}
                            {--chemin= : adresse à tester, ex. /company/2/en/page/menu}';

    protected $description = 'Explique pourquoi une adresse /company/{id}/{langue}/… répond ou non.';

    public function handle(): int
    {
        $id = (int) $this->argument('etablissement');

        $routes = collect(Route::getRoutes()->getRoutes())
            ->filter(fn ($r) => str_starts_with((string) $r->getName(), 'cms.company.langue.'))
            ->count();
        $this->line('Routes par langue chargées : ' . ($routes ? "oui ($routes)" : 'NON — git pull du front puis php artisan optimize:clear'));

        $config = LanguesSite::pour($id);
        $this->line('Langue principale : ' . $config['principale']);
        $this->line('Langues proposées : ' . implode(', ', $config['actives']));
        $this->line('Langues publiées  : ' . implode(', ', $config['visibles']));
        if (count($config['visibles']) < 2) {
            $this->warn('Une seule langue publiée : cochez « Publiée » pour une autre langue dans Configuration → Langues du site, puis enregistrez.');
        }

        $chemin = (string) ($this->option('chemin') ?: '/company/' . $id . '/en');
        try {
            $route = Route::getRoutes()->match(Request::create($chemin));
            $this->line("Adresse $chemin → route « " . $route->getName() . ' »');
            if (preg_match('#^/company/\d+/(' . LanguesSite::motif() . ')(?=/|$)#', $chemin, $m)) {
                $langue = $m[1];
                $this->line(match (true) {
                    $langue === $config['principale'] => "« $langue » est la langue principale : redirection 301 vers l'adresse sans préfixe.",
                    LanguesSite::estVisible($config, $langue) => "« $langue » est publiée : la page s'affiche dans cette langue.",
                    default => "« $langue » n'est PAS publiée : redirection 302 vers la langue principale.",
                });
            }
        } catch (\Throwable $e) {
            $this->error("Adresse $chemin : aucune route (" . class_basename($e) . '). '
                . 'Seuls l\'accueil et les pages (/page/…) ont une adresse par langue.');
        }

        return self::SUCCESS;
    }
}
