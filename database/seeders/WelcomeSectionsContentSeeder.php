<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

/**
 * Remplit welcome_sections.html_content / css_content / js_content à partir du
 * rendu des composants Blade de la page /welcome, afin de pouvoir les éditer
 * dans l'éditeur GrapeJS de l'admin.
 *
 * DOIT être lancé depuis le projet FRONT (GoExploria) car lui seul sait rendre
 * les vues `welcome-home.*` :
 *     php artisan db:seed --class=Database\\Seeders\\WelcomeSectionsContentSeeder
 *
 * Idempotent : ré-exécutable, il écrase le contenu et repasse la section en
 * `content_source = 'builder'` quand le rendu produit du HTML.
 */
class WelcomeSectionsContentSeeder extends Seeder
{
    public function run(): void
    {
        if (! $this->tableReady()) {
            $this->command->error("La table 'welcome_sections' est introuvable. Lancez d'abord la migration côté admin.");
            return;
        }

        $sections = DB::table('welcome_sections')->orderBy('id')->get();
        $this->command->info("Extraction du contenu de {$sections->count()} section(s)…");

        $ok = 0; $empty = 0; $failed = 0;

        foreach ($sections as $section) {
            if (empty($section->view)) {
                $this->command->warn("• #{$section->id} {$section->name} — pas de vue, ignorée");
                continue;
            }

            if (! View::exists($section->view)) {
                $this->command->warn("• #{$section->id} {$section->name} — vue introuvable ({$section->view})");
                $failed++;
                continue;
            }

            try {
                $rendered = $this->renderSafely($section->view);
            } catch (\Throwable $e) {
                $this->command->warn("• #{$section->id} {$section->name} — ERREUR: " . $this->short($e->getMessage()));
                $failed++;
                continue;
            }

            [$html, $css, $js] = $this->splitContent($rendered);

            if (trim(strip_tags($html)) === '' && trim($html) === '') {
                // Rien d'exploitable (souvent : section dépendante de données absentes)
                $this->command->warn("• #{$section->id} {$section->name} — rendu vide, laissée en 'view'");
                $empty++;
                continue;
            }

            DB::table('welcome_sections')->where('id', $section->id)->update([
                'html_content'   => $html,
                'css_content'    => $css !== '' ? $css : null,
                'js_content'     => $js !== '' ? $js : null,
                'content_source' => 'builder',
                'updated_at'     => now(),
            ]);

            $this->command->line("• #{$section->id} {$section->name} — OK (html " . strlen($html) . " / css " . strlen($css) . " / js " . strlen($js) . ")");
            $ok++;
        }

        $this->command->info("Terminé : {$ok} insérée(s), {$empty} vide(s) (gardées en 'view'), {$failed} échec(s).");
    }

    private function tableReady(): bool
    {
        try {
            return DB::getSchemaBuilder()->hasTable('welcome_sections');
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Rend une vue en capturant proprement la sortie, y compris pour les
     * composants qui « flushent » eux-mêmes leur tampon (ob_end_flush) au
     * lieu de retourner le HTML — sinon leur contenu partirait vers stdout.
     */
    private function renderSafely(string $view): string
    {
        $baseLevel = ob_get_level();
        ob_start(); // tampon de secours : récupère tout ce que la vue flushe

        $rendered = '';
        try {
            $rendered = (string) View::make($view)->render();
        } finally {
            // Referme les tampons superflus laissés ouverts par la vue.
            while (ob_get_level() > $baseLevel + 1) {
                $rendered .= (string) ob_get_clean();
            }
            $flushed = (string) ob_get_clean(); // ferme mon tampon de secours
        }

        // Si la vue a flushé son contenu (rendu retourné vide), on prend le flush.
        if (trim($rendered) === '' && trim($flushed) !== '') {
            return $flushed;
        }

        // Sinon on garde le rendu (et on ignore un flush résiduel dupliqué).
        return $rendered !== '' ? $rendered : $flushed;
    }

    /**
     * Sépare le HTML rendu en [html (sans style/script), css, js].
     * - css = concat du contenu des <style> inline
     * - js  = concat du contenu des <script> inline (sans src=)
     */
    private function splitContent(string $rendered): array
    {
        $css = '';
        $js  = '';

        // Extraire les <style>…</style>
        $html = preg_replace_callback('/<style\b[^>]*>([\s\S]*?)<\/style>/i', function ($m) use (&$css) {
            $css .= trim($m[1]) . "\n\n";
            return '';
        }, $rendered);

        // Extraire les <script>…</script> INLINE (ignore ceux avec src=)
        $html = preg_replace_callback('/<script\b([^>]*)>([\s\S]*?)<\/script>/i', function ($m) use (&$js) {
            if (stripos($m[1], 'src=') !== false) {
                return $m[0]; // garder les scripts externes dans le HTML
            }
            $js .= trim($m[2]) . "\n\n";
            return '';
        }, $html);

        // Retirer les fragments PHP bruts laissés par les composants à
        // auto-buffering (self ob_start + ob_get_clean + echo translate) :
        // leur rendu renvoie vide et le flux capturé contient un fragment PHP
        // parasite en tête, invalide en HTML/GrapeJS.
        $html = preg_replace('/<\?php[\s\S]*?\?' . '>/', '', $html);
        $html = preg_replace('/<\?=?[\s\S]*?\?' . '>/', '', $html);

        // Nettoyage léger : BOM + lignes vides multiples
        $html = str_replace("\xEF\xBB\xBF", '', $html);
        $html = preg_replace("/\n{3,}/", "\n\n", trim($html));

        return [$html, trim($css), trim($js)];
    }

    private function short(string $msg): string
    {
        return mb_strlen($msg) > 120 ? mb_substr($msg, 0, 120) . '…' : $msg;
    }
}
