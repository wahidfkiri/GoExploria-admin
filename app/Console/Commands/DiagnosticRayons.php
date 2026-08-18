<?php

namespace App\Console\Commands;

use App\Models\Etablissement;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Vendor\Cms\Support\TemplateCategories;

/**
 * Pourquoi la section « Nos rayons » d'un site reste-t-elle sur ses cartes de
 * démonstration ?
 *
 * L'hydratation est silencieuse par conception : si elle ne peut rien
 * afficher, le gabarit garde sa démonstration plutôt que de laisser un trou
 * sur un site en ligne. Le revers est qu'on ne sait pas POURQUOI. Cette
 * commande déroule la chaîne dans l'ordre et s'arrête au premier maillon
 * rompu.
 *
 *     php artisan cms:diagnostic-rayons 9626
 */
class DiagnosticRayons extends Command
{
    protected $signature = 'cms:diagnostic-rayons {etablissement : identifiant de l\'établissement}';

    protected $description = 'Explique pourquoi la section « Nos rayons » d\'un site n\'affiche pas les vrais rayons';

    public function handle(): int
    {
        $id = (int) $this->argument('etablissement');
        $this->newLine();
        $this->line("Diagnostic de la section « Nos rayons » — établissement {$id}");
        $this->newLine();

        // ── 1. La colonne de rattachement ───────────────────────────────
        if (! Schema::hasColumn('product_categories', 'etablissement_id')) {
            $this->echec('La colonne product_categories.etablissement_id est ABSENTE.');
            $this->line('   Sans elle, aucun rayon ne peut appartenir à un établissement,');
            $this->line('   et la requête d\'hydratation échoue — la section garde sa démo.');
            $this->newLine();
            $this->line('   À faire :');
            $this->line('   php artisan migrate --path=database/migrations/2026_08_17_120000_add_etablissement_id_to_product_categories_table.php');

            return self::FAILURE;
        }
        $this->reussite('Colonne product_categories.etablissement_id présente.');

        // ── 2. L'établissement ──────────────────────────────────────────
        $etablissement = Etablissement::find($id);
        if (! $etablissement) {
            $this->echec("Établissement {$id} introuvable.");

            return self::FAILURE;
        }
        $this->reussite("Établissement trouvé : « {$etablissement->name} ».");

        // ── 3. Ses rayons ───────────────────────────────────────────────
        $total = ProductCategory::where('etablissement_id', $id)->count();
        $actifs = ProductCategory::where('etablissement_id', $id)->where('is_active', true)->count();

        if ($total === 0) {
            $this->echec('Aucun rayon rattaché à cet établissement.');
            $this->line('   À faire : créez-les dans l\'espace entreprise (onglet E-commerce),');
            $this->line('   ou lancez : php artisan db:seed --class=MarcheCatalogueSeeder');

            return self::FAILURE;
        }
        $this->reussite("{$total} rayon(s), dont {$actifs} actif(s).");

        if ($actifs === 0) {
            $this->echec('Tous les rayons sont désactivés : rien à afficher.');
            $this->line('   À faire : réactivez-en depuis l\'interrupteur du tableau des rayons.');

            return self::FAILURE;
        }

        $produits = Product::where('etablissement_id', $id)
            ->where('is_public', true)->where('is_available_for_sale', true)->count();
        $this->reussite("{$produits} produit(s) publié(s) et en vente.");

        // ── 4. La page installée porte-t-elle le marqueur ? ─────────────
        $pages = $this->pagesDeLEtablissement($id);

        if ($pages === null) {
            $this->avertir('Tables du CMS introuvables sur cette base : contrôle de la page ignoré.');
        } elseif ($pages['total'] === 0) {
            $this->echec('Aucune page CMS pour cet établissement.');

            return self::FAILURE;
        } elseif ($pages['avecMarqueur'] === 0) {
            $this->echec('Aucune page ne contient le marqueur data-gx-categories.');
            $this->line('   La page installée date d\'AVANT l\'ajout du marqueur au gabarit :');
            $this->line('   mettre à jour le template ne met pas à jour les pages déjà');
            $this->line('   installées, qui en sont des copies.');
            $this->newLine();
            $this->line('   À faire : réinstallez le template sur ce site, ou ajoutez');
            $this->line('   l\'attribut data-gx-categories à la grille depuis l\'éditeur.');

            return self::FAILURE;
        } else {
            $this->reussite("{$pages['avecMarqueur']} page(s) sur {$pages['total']} portent le marqueur.");
        }

        // ── 5. Ce que l'hydratation produirait vraiment ─────────────────
        $gabarit = '<div data-gx-categories data-gx-categories-limit="8">'
            . '<a data-gx-category><b data-gx-field="name">Rayon de démonstration</b></a></div>';
        $rendu = TemplateCategories::hydrate($gabarit, $id);
        $rendus = substr_count($rendu, 'data-gx-category-id');

        if ($rendus === 0) {
            $this->echec('L\'hydratation ne produit aucun rayon malgré les données.');
            $this->line('   Consultez storage/logs pour la ligne « TemplateCategories ».');

            return self::FAILURE;
        }

        $this->reussite("L'hydratation produit {$rendus} rayon(s).");
        $this->newLine();
        $this->info(' Tout est en place. Si le site affiche encore la démonstration,');
        $this->info(' videz le cache : php artisan cache:clear && php artisan view:clear');

        return self::SUCCESS;
    }

    /**
     * @return array{total:int,avecMarqueur:int}|null  null si le CMS est ailleurs
     */
    private function pagesDeLEtablissement(int $id): ?array
    {
        foreach (['cms', config('database.default')] as $connexion) {
            try {
                if (! Schema::connection($connexion)->hasTable('cms_pages')) {
                    continue;
                }

                $contenus = DB::connection($connexion)->table('cms_pages')
                    ->where('etablissement_id', $id)
                    ->whereNull('deleted_at')
                    ->pluck('content');

                return [
                    'total' => $contenus->count(),
                    'avecMarqueur' => $contenus->filter(
                        fn ($c) => str_contains((string) $c, 'data-gx-categories')
                    )->count(),
                ];
            } catch (\Throwable $e) {
                continue;
            }
        }

        return null;
    }

    private function reussite(string $texte): void
    {
        $this->line('  <fg=green>ok</>    ' . $texte);
    }

    private function echec(string $texte): void
    {
        $this->line('  <fg=red;options=bold>ARRÊT</> ' . $texte);
    }

    private function avertir(string $texte): void
    {
        $this->line('  <fg=yellow>note</>  ' . $texte);
    }
}
