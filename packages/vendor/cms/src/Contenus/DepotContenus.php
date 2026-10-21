<?php

namespace Vendor\Cms\Contenus;

use RuntimeException;

/**
 * Dépôt de fichiers des contenus, partagé par l'admin et le front.
 *
 * Les objets sont IMMUABLES et nommés par leur empreinte SHA-256 :
 *   {racine}/objets/3f/a2/3fa2c9…e1.css
 * Deux contenus identiques (la feuille d'un template recopiée dans dix
 * pages) ne font qu'un fichier, et réenregistrer sans rien changer n'écrit
 * rien. Un objet n'est jamais modifié : on en dépose un autre.
 *
 * Écriture atomique : fichier temporaire dans {racine}/tmp (même système de
 * fichiers) puis rename(). Un lecteur ne voit jamais un fichier à moitié écrit.
 *
 * Le front est configuré en lecture seule (cms.contenus.ecriture = false) :
 * deposer() y lève une exception, en plus des droits Unix du dossier.
 */
class DepotContenus
{
    public const EXTENSIONS = ['html', 'css'];

    public function __construct(
        protected string $racine,
        protected bool $ecriture = true,
        protected int $tailleMax = 8 * 1024 * 1024,
    ) {
        $this->racine = rtrim($racine, '/\\');

        if ($this->racine === '') {
            throw new RuntimeException('Racine du dépôt de contenus vide (cms.contenus.racine).');
        }
    }

    public static function depuisConfig(): self
    {
        return new self(
            (string) config('cms.contenus.racine'),
            (bool) config('cms.contenus.ecriture', true),
            (int) config('cms.contenus.taille_max', 8 * 1024 * 1024),
        );
    }

    public function racine(): string
    {
        return $this->racine;
    }

    public static function empreinte(string $contenu): string
    {
        return hash('sha256', $contenu);
    }

    public function chemin(string $empreinte, string $extension): string
    {
        if (! preg_match('/^[0-9a-f]{64}$/', $empreinte) || ! in_array($extension, self::EXTENSIONS, true)) {
            throw new RuntimeException("Référence de contenu invalide : {$empreinte}.{$extension}");
        }

        return $this->racine . '/objets/' . substr($empreinte, 0, 2) . '/' . substr($empreinte, 2, 2)
            . '/' . $empreinte . '.' . $extension;
    }

    public function existe(string $empreinte, string $extension): bool
    {
        return is_file($this->chemin($empreinte, $extension));
    }

    public function lire(string $empreinte, string $extension): string
    {
        $chemin = $this->chemin($empreinte, $extension);
        $contenu = is_file($chemin) ? file_get_contents($chemin) : false;

        if ($contenu === false) {
            throw new RuntimeException("Objet de contenu introuvable : {$chemin}");
        }

        return $contenu;
    }

    /** Dépose un contenu et rend son empreinte. Sans effet s'il existe déjà. */
    public function deposer(string $contenu, string $extension): string
    {
        if (! $this->ecriture) {
            throw new RuntimeException('Dépôt de contenus en lecture seule sur ce projet.');
        }

        if (strlen($contenu) > $this->tailleMax) {
            throw new RuntimeException('Contenu trop volumineux (' . strlen($contenu) . ' octets).');
        }

        $empreinte = self::empreinte($contenu);
        $chemin = $this->chemin($empreinte, $extension);

        if (is_file($chemin)) {
            return $empreinte;
        }

        $this->creerDossier(dirname($chemin));
        $this->creerDossier($this->racine . '/tmp');

        $temporaire = $this->racine . '/tmp/' . $empreinte . '.' . bin2hex(random_bytes(6));

        if (file_put_contents($temporaire, $contenu, LOCK_EX) !== strlen($contenu)) {
            @unlink($temporaire);

            throw new RuntimeException("Écriture impossible dans {$this->racine}/tmp (disque plein ou droits ?)");
        }

        @chmod($temporaire, 0640);

        if (! @rename($temporaire, $chemin)) {
            @unlink($temporaire);

            // Un autre processus a pu déposer le même objet entre-temps.
            if (! is_file($chemin)) {
                throw new RuntimeException("Impossible de placer l'objet {$chemin}");
            }
        }

        return $empreinte;
    }

    /** Contrôle d'installation : la racine existe-t-elle, et peut-on écrire ? */
    public function etat(): array
    {
        return [
            'racine' => $this->racine,
            'existe' => is_dir($this->racine),
            'lisible' => is_dir($this->racine) && is_readable($this->racine),
            'ecriture_configuree' => $this->ecriture,
            'inscriptible' => $this->ecriture && is_dir($this->racine) && is_writable($this->racine),
            'libre' => is_dir($this->racine) ? @disk_free_space($this->racine) : null,
        ];
    }

    protected function creerDossier(string $dossier): void
    {
        if (is_dir($dossier)) {
            return;
        }

        // 02750 : setgid (les sous-dossiers gardent le groupe partagé),
        // le groupe (front) lit sans pouvoir écrire.
        if (! @mkdir($dossier, 02750, true) && ! is_dir($dossier)) {
            throw new RuntimeException("Impossible de créer le dossier {$dossier}");
        }
    }
}
