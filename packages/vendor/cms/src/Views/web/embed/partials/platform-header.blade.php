{{-- ═══════════════════════════════════════════════════════════════════════
     Header GoExploria Business — VERSION DÉDIÉE à l'affichage des sites
     d'établissements dans le shell plateforme.

     Point d'intégration STABLE et isolé : ce fichier n'est utilisé QUE par
     le shell `cms::web.embed.platform-shell`. Il rend les composants
     canoniques de la plateforme (VerticalMenu + Header home-v2) pour
     conserver EXACTEMENT le même design et le même comportement que la
     page `/`. Si un fork total est requis un jour, il se fait ICI sans
     impacter le reste de la plateforme.

     Le header vit dans le DOCUMENT PARENT ; le site de l'établissement vit
     dans l'iframe (document séparé). Leurs menus mobiles sont donc isolés
     par construction : aucun sélecteur / JS partagé possible.
     ═══════════════════════════════════════════════════════════════════════ --}}
@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')
@include('cms::web.embed.partials.platform-header')