<?php

namespace App\Console\Commands;

use App\Http\Middleware\InjectAdsBottomBanner;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Dit pourquoi la bannière publicitaire de bas de page (zone
 * « banner_bottom_full ») ne paraît pas — ou paraît.
 *
 * À lancer SUR LE SERVEUR du site, qui seul voit la vraie base :
 *
 *   php artisan ads:diagnostic-banniere
 *   php artisan ads:diagnostic-banniere --url=/travel-destination/country/canada
 *
 * Chaque annonce de la zone est passée au crible un critère après l'autre, et
 * la commande nomme celui qui l'écarte. Elle finit par exécuter le VRAI
 * middleware sur une page d'essai : si la bannière n'y est pas, le dernier
 * message dit où la chaîne s'est interrompue.
 */
class DiagnosticBanniereBas extends Command
{
    protected $signature = 'ads:diagnostic-banniere {--url=/ : Chemin de la page à simuler}';

    protected $description = "Explique pourquoi la bannière publicitaire de bas de page s'affiche ou non";

    public function handle(): int
    {
        $chemin = '/' . ltrim((string) $this->option('url'), '/');

        $this->line('');
        $this->info('1. Configuration');
        $zone = config('ads.bottom_banner_zone', 'banner_bottom_full');
        $active = (bool) config('ads.bottom_banner_enabled', true);
        $this->ligne('zone visée', $zone);
        $this->ligne('bannière activée', $active ? 'oui' : 'NON (ads.bottom_banner_enabled = false)', $active);
        $this->ligne('adresse de l\'admin', (string) config('ads.admin_url'), (string) config('ads.admin_url') !== '');
        $this->ligne('middleware écrit dans bootstrap/app.php', $this->middlewareDeclare() ? 'oui' : 'NON', $this->middlewareDeclare());
        $actif = $this->middlewareActif();
        $this->ligne(
            "middleware actif à l'exécution",
            $actif ? 'oui' : 'NON — code en place mais pas pris en compte : rechargez PHP (sudo systemctl reload php8.3-fpm) ou videz OPcache',
            $actif
        );

        $this->newLine();
        $this->info('2. La zone en base');
        try {
            $placement = DB::table('ad_placements')->where('code', $zone)->first();
        } catch (\Throwable $e) {
            $this->error('   Base injoignable : ' . $e->getMessage());

            return self::FAILURE;
        }

        if (! $placement) {
            $this->ligne('zone trouvée', 'NON — lancez le seeder côté admin : php artisan db:seed --class=AdsBottomBannerPlacementSeeder', false);

            return self::SUCCESS;
        }

        $this->ligne('zone trouvée', "#{$placement->id} « {$placement->nom} »");
        $this->ligne('zone active', $placement->is_active ? 'oui' : 'NON (case « Actif » de l\'emplacement)', (bool) $placement->is_active);
        $this->ligne('annonces en rotation (max_ads)', (string) $placement->max_ads);

        $this->newLine();
        $this->info("3. Les annonces de la zone, une par une (page simulée : {$chemin})");

        $contexte = $this->contexte($chemin);
        $etab = preg_match('~^/company/(\d+)(/|$)~', $chemin, $m) ? (int) $m[1] : null;
        $this->ligne('famille de pages', $contexte ?? 'aucune (seules les annonces sans restriction y paraissent)');
        $this->ligne('établissement de la page', $etab ? (string) $etab : 'aucun');

        $liens = DB::table('ad_placement')->where('placement_id', $placement->id)->get();

        if ($liens->isEmpty()) {
            $this->ligne('annonces rattachées', 'AUCUNE — cochez cette zone dans la fiche de l\'annonce', false);

            return self::SUCCESS;
        }

        $retenues = 0;

        foreach ($liens as $lien) {
            $ad = DB::table('ads')->where('id', $lien->ad_id)->first();

            if (! $ad) {
                continue;
            }

            $raisons = $this->raisons($ad, $lien, $contexte, $etab);
            $this->newLine();

            if ($raisons === []) {
                $retenues++;
                $this->line("   <fg=green>✔</> #{$ad->id} « {$ad->titre} » ({$ad->type}) : affichée");
                continue;
            }

            $this->line("   <fg=red>✘</> #{$ad->id} « {$ad->titre} » ({$ad->type}) : écartée");
            foreach ($raisons as $raison) {
                $this->line('       · ' . $raison);
            }
        }

        $this->newLine();
        $this->info('4. Rendu réel (le vrai middleware sur une page d\'essai)');

        $requete = Request::create($chemin, 'GET');
        app()->instance('request', $requete);
        $page = '<html><body><main>essai</main></body></html>';

        try {
            $reponse = (new InjectAdsBottomBanner())->handle(
                $requete,
                fn () => new Response($page, 200, ['Content-Type' => 'text/html; charset=UTF-8'])
            );
            $html = (string) $reponse->getContent();
        } catch (\Throwable $e) {
            $this->error('   Le middleware a levé une erreur : ' . $e->getMessage());

            return self::FAILURE;
        }

        $posee = str_contains($html, 'data-gxbb');
        $this->ligne('bannière posée dans la page', $posee ? 'OUI' : 'NON', $posee);

        $this->newLine();

        if ($posee) {
            $this->info('   Verdict : la bannière est produite par le serveur.');
            $this->line('   Si le site ne la montre toujours pas, c\'est en aval : cache de pages,');
            $this->line('   CDN, ou une feuille de style qui la masque.');
        } elseif ($retenues === 0) {
            $this->warn('   Verdict : aucune annonce ne passe les filtres (voir les raisons ci-dessus).');
        } else {
            $this->warn('   Verdict : des annonces sont éligibles mais rien n\'est posé.');
            $this->line('   Regardez storage/logs : le partiel journalise les erreurs de rendu.');
        }

        $this->newLine();

        return self::SUCCESS;
    }

    /** Les critères qui écartent une annonce, dans l'ordre où la requête les applique. */
    private function raisons(object $ad, object $lien, ?string $contexte, ?int $etab): array
    {
        $raisons = [];
        $aujourdhui = now()->toDateString();

        if (! $lien->is_active) {
            $raisons[] = 'le lien avec la zone est désactivé (table ad_placement)';
        }

        if ($ad->status !== 'active') {
            $raisons[] = "statut « {$ad->status} » au lieu de « active »";
        }

        if (! empty($ad->deleted_at)) {
            $raisons[] = 'annonce supprimée';
        }

        if ($ad->start_date && $ad->start_date > $aujourdhui) {
            $raisons[] = "ne commence que le {$ad->start_date}";
        }

        if ($ad->end_date && $ad->end_date < $aujourdhui) {
            $raisons[] = "terminée depuis le {$ad->end_date}";
        }

        if ($ad->budget_total !== null && $ad->budget_total <= $ad->budget_spent) {
            $raisons[] = "budget épuisé ({$ad->budget_spent} / {$ad->budget_total})";
        }

        $lieux = $this->liste($ad->display_locations ?? null);
        if ($lieux !== [] && (! $contexte || ! in_array($contexte, $lieux, true))) {
            $raisons[] = 'limitée aux pages « ' . implode(', ', $lieux) . ' » : '
                . ($contexte ? "cette page est « {$contexte} »" : 'cette page n\'appartient à aucune de ces familles');
        }

        $cibles = $this->liste($ad->target_etablissements ?? null);
        if ($cibles !== [] && $etab && ! in_array((string) $etab, array_map('strval', $cibles), true)) {
            $raisons[] = 'réservée aux établissements ' . implode(', ', $cibles) . " : celui-ci est le {$etab}";
        }

        $visuel = match ($ad->type) {
            'image' => trim((string) $ad->image_path) !== '',
            'video' => trim((string) ($ad->video_url ?: $ad->destination_url)) !== '',
            'html' => trim((string) $ad->html_content) !== '',
            default => trim((string) ($ad->titre . $ad->text_content)) !== '',
        };

        if (! $visuel) {
            $raisons[] = 'aucun visuel exploitable pour ce type d\'annonce';
        }

        return $raisons;
    }

    private function liste($valeur): array
    {
        if (is_array($valeur)) {
            return $valeur;
        }

        $valeur = trim((string) $valeur);

        if ($valeur === '' || $valeur === '[]' || $valeur === 'null') {
            return [];
        }

        $decode = json_decode($valeur, true);

        return is_array($decode) ? $decode : [];
    }

    /** Même règle que le middleware : la famille de pages du chemin. */
    private function contexte(string $chemin): ?string
    {
        if ($chemin === '/') {
            return 'home';
        }

        if (preg_match('~^/(activity|activites)(/|$)~', $chemin)) {
            return 'activities';
        }

        if (preg_match('~^/company/\d+(/|$)~', $chemin)) {
            return 'etablissements';
        }

        if (preg_match('~^/travel-destination/([a-z]+)(/|$)~', $chemin, $m)) {
            $type = $m[1] === 'ville' ? 'city' : $m[1];

            return in_array($type, ['continent', 'country', 'province', 'region', 'secteur', 'city', 'arrondissement', 'quartier'], true)
                ? $type
                : null;
        }

        return null;
    }

    /**
     * Le middleware est-il dans la pile RÉELLEMENT chargée par PHP ?
     *
     * Le fichier peut être à jour sur le disque alors que le processus sert
     * encore l'ancienne version compilée (OPcache sans revalidation). C'est
     * exactement le cas qui laisse croire à un déploiement raté.
     */
    private function middlewareActif(): bool
    {
        try {
            $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
            $propriete = new \ReflectionProperty($kernel, 'middleware');
            $propriete->setAccessible(true);

            return in_array(InjectAdsBottomBanner::class, (array) $propriete->getValue($kernel), true);
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function middlewareDeclare(): bool
    {
        $fichier = base_path('bootstrap/app.php');

        return is_readable($fichier)
            && str_contains((string) file_get_contents($fichier), 'InjectAdsBottomBanner');
    }

    private function ligne(string $libelle, string $valeur, ?bool $bon = null): void
    {
        $marque = $bon === null ? ' ' : ($bon ? '<fg=green>✔</>' : '<fg=red>✘</>');
        $this->line(sprintf('   %s %-32s %s', $marque, $libelle, $valeur));
    }
}
