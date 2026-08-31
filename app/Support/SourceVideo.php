<?php

namespace App\Support;

/*
 * ATTENTION — copie du fichier de l'espace entreprise
 * (admin.goexploriabusiness.com, meme chemin).
 *
 * Le site public et le back-office sont deux depots distincts. La
 * reconnaissance de la source doit donner le MEME resultat des deux cotes :
 * l'admin enregistre `video_type`, le site le relit pour choisir entre une
 * iframe et une balise <video>. Une divergence afficherait un lecteur vide.
 *
 * Toute evolution des extensions ou des motifs YouTube doit etre reportee.
 */

/**
 * Reconnaît la provenance d'une adresse vidéo.
 *
 * Les points vidéo de la carte acceptent deux sources : une vidéo YouTube,
 * ou l'adresse directe d'un fichier (.mp4 et compagnie). Le back-office, les
 * modèles et le site public doivent trancher de la même façon — d'où cette
 * classe unique plutôt qu'une expression régulière recopiée à trois endroits,
 * qui finirait par diverger.
 */
final class SourceVideo
{
    public const YOUTUBE = 'youtube';
    public const FICHIER = 'file';

    /**
     * Extensions acceptées pour une vidéo servie en direct.
     *
     * Volontairement limitée à ce qu'une balise <video> sait lire sans
     * greffon. Un `.mkv` ou un `.avi` afficherait un lecteur vide.
     *
     * @var list<string>
     */
    public const EXTENSIONS = ['mp4', 'webm', 'ogv', 'ogg', 'm4v', 'mov'];

    /**
     * Type de la source : self::YOUTUBE, self::FICHIER, ou null si l'adresse
     * n'est ni l'un ni l'autre.
     */
    public static function typeDe(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        if (self::identifiantYoutube($url) !== null) {
            return self::YOUTUBE;
        }

        return self::estFichier($url) ? self::FICHIER : null;
    }

    /**
     * Vrai si l'adresse désigne un fichier vidéo lisible par une balise
     * <video>. La chaîne de requête est ignorée : beaucoup de stockages
     * signés ajoutent « ?token=… » après l'extension.
     */
    public static function estFichier(?string $url): bool
    {
        $chemin = parse_url(trim((string) $url), PHP_URL_PATH);

        if (! is_string($chemin) || $chemin === '') {
            return false;
        }

        $extension = strtolower((string) pathinfo($chemin, PATHINFO_EXTENSION));

        return $extension !== '' && in_array($extension, self::EXTENSIONS, true);
    }

    /**
     * Identifiant d'une vidéo YouTube, ou null.
     *
     * Couvre watch?v=, youtu.be, /embed/, /shorts/ et /live/.
     */
    public static function identifiantYoutube(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        $motifs = [
            '~youtube\.com/watch\?(?:.*&)?v=([A-Za-z0-9_-]{11})~i',
            '~youtu\.be/([A-Za-z0-9_-]{11})~i',
            '~youtube\.com/(?:embed|shorts|live|v)/([A-Za-z0-9_-]{11})~i',
        ];

        foreach ($motifs as $motif) {
            if (preg_match($motif, $url, $trouve) === 1) {
                return $trouve[1];
            }
        }

        return null;
    }

    /**
     * Type MIME à poser sur la balise <source>. Deviné depuis l'extension :
     * sans lui, certains navigateurs refusent de précharger.
     */
    public static function mime(?string $url): ?string
    {
        $chemin = parse_url(trim((string) $url), PHP_URL_PATH);

        if (! is_string($chemin)) {
            return null;
        }

        return match (strtolower((string) pathinfo($chemin, PATHINFO_EXTENSION))) {
            'mp4', 'm4v' => 'video/mp4',
            'webm'       => 'video/webm',
            'ogv', 'ogg' => 'video/ogg',
            'mov'        => 'video/quicktime',
            default      => null,
        };
    }
}
