{{-- Video Modal Component - Lecteur vidéo réutilisable pour toute la plateforme --}}
<div class="video-modal" id="videoModal" style="display: none;">
    <div class="video-modal-overlay"></div>
    <div class="video-modal-content">
        <button class="video-modal-close" id="closeVideoModal">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="video-modal-body">
            {{-- Lecteur vidéo principal --}}
            <div class="video-modal-main">
                <div class="video-modal-video-wrapper">
                    <iframe 
                        id="videoModalPlayer"
                        class="video-modal-video"
                        src=""
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
                
                {{-- Informations de la vidéo --}}
                <div class="video-modal-info">
                    <div class="video-modal-badge-wrapper">
                        <span class="video-modal-badge" id="videoModalBadge">GENERAL</span>
                    </div>
                    <h2 class="video-modal-title" id="videoModalTitle">Titre de la vidéo</h2>
                    <p class="video-modal-date" id="videoModalDate">DATE</p>
                    <p class="video-modal-description" id="videoModalDescription">Description de la vidéo sélectionnée.</p>
                </div>
            </div>

            {{-- Playlist à droite --}}
            <div class="video-modal-playlist">
                <div class="video-modal-playlist-header">
                    <h3 class="video-modal-playlist-title">Playlist</h3>
                </div>
                <ul class="video-modal-playlist-items" id="videoModalPlaylistItems">
                    {{-- Les items seront générés dynamiquement --}}
                </ul>
            </div>
        </div>
    </div>
</div>
