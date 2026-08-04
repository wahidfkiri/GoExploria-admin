<?php

namespace App\Http\Controllers;

use App\Models\SitePage;
use Illuminate\Support\Facades\Schema;
use Throwable;

/**
 * Pages fixes du site (/valeurs, …).
 *
 * Le contenu vient soit de la vue Blade d'origine, soit de l'éditeur visuel de
 * l'administration lorsque la page y a été reprise. La vue reste responsable de
 * l'en-tête et du pied de page : seul le corps est remplacé.
 */
class SitePageController extends Controller
{
    /**
     * Résout la page éditable correspondant à un slug.
     *
     * Renvoie null si la table n'existe pas encore ou si la base est
     * injoignable : la page s'affiche alors avec son contenu d'origine, ce qui
     * vaut mieux qu'une erreur sur un site public.
     */
    public static function resolve(string $slug): ?SitePage
    {
        try {
            if (! Schema::hasTable('site_pages')) {
                return null;
            }

            return SitePage::active()->where('slug', $slug)->first();
        } catch (Throwable $e) {
            return null;
        }
    }

    public function valeurs()
    {
        return view('home-v2.pages.valeurs', [
            'sitePage' => self::resolve('valeurs'),
        ]);
    }
}
