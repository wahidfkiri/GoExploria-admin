@php
    $tr = static function (string $text): string {
        $locale = app()->getLocale();
        if ($locale === 'fr') return $text;
        static $maps = [];
        if (!array_key_exists($locale, $maps)) {
            $path = lang_path($locale . DIRECTORY_SEPARATOR . 'home-v2-components-map.php');
            $maps[$locale] = is_file($path) ? (require $path) : [];
        }
        return $maps[$locale][$text] ?? $text;
    };
@endphp

<section class="avis-clients-section" id="avis-clients">
    <div class="resto-header-block">
        <div class="resto-header-main">
            <div class="resto-header-logo-left">
                <a href="#" class="resto-accord-btn" title="Avis Clients">
                    <div class="logo-wrapper">
                        <i class="fas fa-comments"></i>
                    </div>
                    <span class="resto-accord-btn-label">Avis Clients</span>
                    <span class="resto-accord-btn-cta"><i class="fas fa-heart"></i> Trusted</span>
                </a>
            </div>
            <div class="resto-header-center">
                <h1 class="resto-header-title">{{ $tr('ESPACE AVIS CLIENTS') }}</h1>
                <h2 class="resto-header-eyebrow">3 méthodes pour créer un lien d’avis Google et optimiser vos fiches</h2>
                <!-- <p class="resto-header-subtitle">{{ $tr('Témoignages authentiques de voyageurs, familles et entreprises partenaires.') }}</p> -->
            </div>
            
            <div class="resto-header-logo-right">
                
                <a href="{{url('avis-clients')}}" title="En savoir plus" target="_blank" rel="noopener noreferrer">
                    <!-- <i class="fas fa-circle-info"></i>
                    <span>Go Next Level</span> -->
                    <img
                    class="bt-next-level-image"
                    src="{{ asset('images/Next-level.png') }}"
                    alt="Next Level"
                    loading="lazy"
                >
                </a>
            </div>
        </div>
        <div class="resto-header-shimmer"></div>
    </div>

    <div class="avis-row avis-row-style-a">
        <article class="avis-card avis-card-a">
            <div class="avis-top">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=120&h=120&fit=crop" alt="Client 1">
                <div>
                    <h3>Julie Tremblay</h3>
                    <p>Voyageuse - Québec</p>
                </div>
            </div>
            <div class="avis-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <p class="avis-text">{{ $tr('Service exceptionnel, réservation simple et suggestions parfaites pour notre séjour en famille.') }}</p>
        </article>

        <article class="avis-card avis-card-a">
            <div class="avis-top">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=120&h=120&fit=crop" alt="Client 2">
                <div>
                    <h3>Marc Bouchard</h3>
                    <p>Entrepreneur - Montréal</p>
                </div>
            </div>
            <div class="avis-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
            <p class="avis-text">{{ $tr('La visibilité de notre entreprise a augmenté rapidement. Excellente équipe, très proactive.') }}</p>
        </article>

        <article class="avis-card avis-card-a">
            <div class="avis-top">
                <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=120&h=120&fit=crop" alt="Client 3">
                <div>
                    <h3>Sophie Gagnon</h3>
                    <p>Créatrice - Saguenay</p>
                </div>
            </div>
            <div class="avis-stars">&#9733;&#9733;&#9733;&#9733;&#9734;</div>
            <p class="avis-text">{{ $tr('Très belle plateforme pour découvrir des activités locales et partager nos expériences.') }}</p>
        </article>
    </div>

    <div class="avis-row avis-row-style-google">
        <article class="avis-card avis-card-google">
            <div class="avis-google-head">
                <span class="avis-google-mark">G</span>
                <div>
                    <h3>Goexploria Business</h3>
                    <p>Google Workspace review</p>
                </div>
            </div>
            <div class="avis-google-score">
                <strong>4.9</strong>
                <span>&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            </div>
            <p class="avis-text">{{ $tr('Excellent suivi client, collaboration fluide et organisation des projets très efficace.') }}</p>
            <div class="avis-foot">
                <span>Montréal</span>
                <span>Il y a 2 jours</span>
            </div>
        </article>

        <article class="avis-card avis-card-google">
            <div class="avis-google-head">
                <span class="avis-google-mark">G</span>
                <div>
                    <h3>Atelier Nomade</h3>
                    <p>Google Workspace review</p>
                </div>
            </div>
            <div class="avis-google-score">
                <strong>5.0</strong>
                <span>&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            </div>
            <p class="avis-text">{{ $tr('Le tableau de suivi partagé et les retours en temps réel nous ont beaucoup aidés.') }}</p>
            <div class="avis-foot">
                <span>Québec</span>
                <span>Il y a 1 semaine</span>
            </div>
        </article>

        <article class="avis-card avis-card-google">
            <div class="avis-google-head">
                <span class="avis-google-mark">G</span>
                <div>
                    <h3>Studio Horizon</h3>
                    <p>Google Workspace review</p>
                </div>
            </div>
            <div class="avis-google-score">
                <strong>4.8</strong>
                <span>&#9733;&#9733;&#9733;&#9733;&#9734;</span>
            </div>
            <p class="avis-text">{{ $tr('Communication claire, livraison rapide, et une vraie valeur ajoutée sur notre visibilité.') }}</p>
            <div class="avis-foot">
                <span>Lyon</span>
                <span>Il y a 3 semaines</span>
            </div>
        </article>
    </div>

    <div class="avis-row avis-row-style-b">
        <article class="avis-card avis-card-b">
            <span class="avis-badge">Top Note</span>
            <h3>Famille Dufour</h3>
            <p class="avis-text">{{ $tr('Nous avons trouvé un hébergement et des activités en 10 minutes. Expérience fluide et moderne.') }}</p>
            <div class="avis-foot">
                <span>Charlevoix</span>
                <span class="avis-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            </div>
        </article>

        <article class="avis-card avis-card-b">
            <span class="avis-badge">Recommandé</span>
            <h3>Agence Nova Travel</h3>
            <p class="avis-text">{{ $tr('Les modules marketing et médias nous font gagner du temps. Les résultats sont mesurables.') }}</p>
            <div class="avis-foot">
                <span>Paris</span>
                <span class="avis-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
            </div>
        </article>

        <article class="avis-card avis-card-b">
            <span class="avis-badge">Nouveau client</span>
            <h3>Karim El Amrani</h3>
            <p class="avis-text">{{ $tr('Interface claire, support rapide et une vraie qualité de contenu pour choisir nos destinations.') }}</p>
            <div class="avis-foot">
                <span>Casablanca</span>
                <span class="avis-stars">&#9733;&#9733;&#9733;&#9733;&#9734;</span>
            </div>
        </article>
    </div>

</section>

<style>
.avis-clients-section{
  padding:32px 40px 56px;
  background:linear-gradient(180deg,#f7fbff 0%,#ffffff 100%);
}
.avis-row{
  display:grid;
  grid-template-columns:repeat(3,minmax(0,1fr));
  gap:18px;
  margin-top:18px;
}
.avis-card{
  border-radius:16px;
  box-shadow:0 10px 30px rgba(17,32,64,.12);
  border:1px solid rgba(18,34,66,.08);
  min-height:190px;
}
.avis-row-style-a .avis-card-a{
  background:#fff;
  padding:16px;
}
.avis-top{
  display:flex;
  gap:12px;
  align-items:center;
}
.avis-top img{
  width:56px;
  height:56px;
  border-radius:50%;
  object-fit:cover;
}
.avis-top h3{
  margin:0;
  font-size:16px;
  color:#102442;
}
.avis-top p{
  margin:4px 0 0;
  font-size:12px;
  color:#5a6d87;
}
.avis-stars{
  margin-top:10px;
  color:#f59e0b;
  letter-spacing:1px;
  font-size:15px;
}
.avis-text{
  margin:10px 0 0;
  font-size:14px;
  line-height:1.6;
  color:#2a3d5c;
}
.avis-row-style-b .avis-card-b{
  background:linear-gradient(160deg,#14243f 0%,#233e66 100%);
  color:#fff;
  padding:18px;
  position:relative;
  overflow:hidden;
}
.avis-row-style-b .avis-card-b::after{
  content:'';
  position:absolute;
  width:120px;
  height:120px;
  right:-35px;
  top:-35px;
  border-radius:50%;
  background:rgba(255,255,255,.08);
}
.avis-badge{
  display:inline-block;
  background:rgba(255,255,255,.18);
  border:1px solid rgba(255,255,255,.28);
  border-radius:999px;
  font-size:11px;
  padding:4px 10px;
  margin-bottom:8px;
}
.avis-row-style-b h3{
  margin:0;
  font-size:17px;
}
.avis-row-style-b .avis-text{
  color:#deebff;
}
.avis-foot{
  margin-top:14px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  font-size:13px;
}
.avis-row-style-google .avis-card-google{
  background:#fff;
  padding:16px;
  border:1px solid #d9e3f2;
  box-shadow:0 8px 24px rgba(19,41,78,.10);
}
.avis-google-head{
  display:flex;
  align-items:center;
  gap:10px;
}
.avis-google-mark{
  width:34px;
  height:34px;
  border-radius:50%;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  font-weight:800;
  color:#fff;
  background:conic-gradient(from 180deg,#ea4335,#fbbc05,#34a853,#4285f4,#ea4335);
}
.avis-row-style-google h3{
  margin:0;
  font-size:16px;
  color:#123157;
}
.avis-row-style-google p{
  margin:3px 0 0;
  font-size:12px;
  color:#6580a5;
}
.avis-google-score{
  margin-top:10px;
  display:flex;
  align-items:baseline;
  gap:8px;
}
.avis-google-score strong{
  font-size:22px;
  color:#0f2c50;
}
.avis-google-score span{
  color:#f59e0b;
  letter-spacing:1px;
}
@@media (max-width:1024px){
  .avis-clients-section{padding:28px 16px 46px;}
  .avis-row{grid-template-columns:repeat(2,minmax(0,1fr));}
}
@@media (max-width:640px){
  .avis-row{grid-template-columns:1fr;}
}
</style>
