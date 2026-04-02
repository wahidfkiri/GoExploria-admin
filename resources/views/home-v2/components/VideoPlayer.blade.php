{{-- Video Player Component - Galerie Multimédia Premium --}}
<section class="video-player-v2-section">
    <div class="video-player-v2-container">
        {{-- Header avec logo center top et boutons modifiés --}}
        <div class="video-player-v2-header">
            {{-- Logo au centre --}}
            <div class="video-player-v2-logo">
                <img src="{{ asset('GO-EXPLORIA-MY-TUBE.png') }}" alt="Go Exploria" class="video-player-v2-brand-logo">
            </div>

            {{-- Titre original à gauche --}}
            <div class="video-player-v2-header-left">
                <div class="video-player-v2-play-circle">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                </div>
                <h1 class="video-player-v2-main-title">CRÉEZ DE VOTRE CHAÎNE VIDÉO GO EXPLORIA MYTUBE / DIFFUSION INTERNATIONAL ICI</h1>
            </div>

            {{-- Boutons à droite --}}
            <div class="video-player-v2-header-right">
                <a href="" class="video-player-v2-upload-btn" id="uploadVideoBtn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/>
                    </svg>
                    <span>Upload</span>
                </a>
                <a href="{{route('pages.video-player')}}" class="events-vedette-v2-more-btn">
                En savoir
                <span class="events-vedette-v2-plus-icon">+</span>
                </a>
            </div>
        </div>

        <div class="video-player-v2-content">
            {{-- Lecteur vidéo principal --}}
            <div class="video-player-v2-main">
                <div class="video-player-v2-wrapper">
                    <video 
                        id="mainVideoPlayer" 
                        class="video-player-v2-video"
                    >
                        <source src="{{ asset('home2/videos/hero-video-1.mp4.mp4') }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                </div>
                
                {{-- Contrôles en dehors de la vidéo --}}
                <div class="video-player-v2-controls" id="videoControls">
                    <div class="video-player-v2-progress-bar" id="progressBar">
                        <div class="video-player-v2-progress-filled" id="progressFilled"></div>
                    </div>
                    <div class="video-player-v2-controls-bottom">
                        <div class="video-player-v2-controls-left">
                            <button class="video-player-v2-control-btn play-btn" id="playPauseBtn">
                                <svg class="play-icon" width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                <svg class="pause-icon" width="28" height="28" viewBox="0 0 24 24" fill="currentColor" style="display: none;">
                                    <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/>
                                </svg>
                            </button>
                            <button class="video-player-v2-control-btn" id="volumeBtn">
                                <svg class="volume-on-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/>
                                </svg>
                                <svg class="volume-off-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" style="display: none;">
                                    <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/>
                                </svg>
                            </button>
                            <span class="video-player-v2-time" id="timeDisplay">0:00 / 0:00</span>
                        </div>
                        <div class="video-player-v2-controls-right">
                            <span class="video-player-v2-counter" id="mediaCounter">1 / 5</span>
                            <button class="video-player-v2-control-btn" id="fullscreenBtn">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="video-player-v2-info">
                    <h2 class="video-player-v2-title" id="videoTitle">Paysage Montagneux</h2>
                    <p class="video-player-v2-description" id="videoDescription">Un magnifique panorama de montagnes enneigées au coucher du soleil.</p>
                </div>
            </div>

            {{-- Playlist à droite --}}
            <div class="video-player-v2-playlist">
                <div class="video-player-v2-playlist-header">
                    <h3 class="video-player-v2-playlist-title">Playlist</h3>
                </div>
                <ul class="video-player-v2-playlist-items" id="playlistItems">
                    {{-- Item 1 - Vidéo Hero 1 --}}
                    <li class="video-player-v2-playlist-item active" data-type="video" data-src="{{ asset('home2/videos/hero-video-1.mp4.mp4') }}" data-title="Paysage Montagneux" data-description="Un magnifique panorama de montagnes enneigées au coucher du soleil." data-poster="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400">
                        <div class="video-player-v2-playlist-thumbnail">
                            <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=150&h=100&fit=crop" alt="Paysage Montagneux">
                            <span class="video-player-v2-playlist-badge">Image</span>
                        </div>
                        <div class="video-player-v2-playlist-info">
                            <h4 class="video-player-v2-playlist-name">Paysage Montagneux</h4>
                            <p class="video-player-v2-playlist-type">Image</p>
                        </div>
                    </li>

                    {{-- Item 2 - Vidéo Hero 2 --}}
                    <li class="video-player-v2-playlist-item" data-type="video" data-src="{{ asset('home2/videos/hero-video-2.mp4.mp4') }}" data-title="Forêt Tropicale" data-description="Explorez la beauté luxuriante d'une forêt tropicale dense." data-poster="https://images.unsplash.com/photo-1511497584788-876760111969?w=400">
                        <div class="video-player-v2-playlist-thumbnail">
                            <img src="https://images.unsplash.com/photo-1511497584788-876760111969?w=150&h=100&fit=crop" alt="Forêt Tropicale">
                            <span class="video-player-v2-playlist-badge">Vidéo • 0:15</span>
                            <div class="video-player-v2-play-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="video-player-v2-playlist-info">
                            <h4 class="video-player-v2-playlist-name">Forêt Tropicale</h4>
                            <p class="video-player-v2-playlist-type">Vidéo • 0:15</p>
                        </div>
                    </li>

                    {{-- Item 3 - Vidéo Hero 3 --}}
                    <li class="video-player-v2-playlist-item" data-type="video" data-src="{{ asset('home2/videos/hero-video-3.mp4.mp4') }}" data-title="Ville Nocturne" data-description="Découvrez l'énergie vibrante d'une métropole illuminée la nuit." data-poster="https://images.unsplash.com/photo-1514565131-fce0801e5785?w=400">
                        <div class="video-player-v2-playlist-thumbnail">
                            <img src="https://images.unsplash.com/photo-1514565131-fce0801e5785?w=150&h=100&fit=crop" alt="Ville Nocturne">
                            <span class="video-player-v2-playlist-badge">Image</span>
                        </div>
                        <div class="video-player-v2-playlist-info">
                            <h4 class="video-player-v2-playlist-name">Ville Nocturne</h4>
                            <p class="video-player-v2-playlist-type">Image</p>
                        </div>
                    </li>

                    {{-- Item 4 - Vidéo supplémentaire --}}
                    <li class="video-player-v2-playlist-item" data-type="video" data-src="{{ asset('home2/videos/hero-video-1.mp4.mp4') }}" data-title="Océan et Vagues" data-description="Laissez-vous bercer par le son apaisant des vagues de l'océan." data-poster="https://images.unsplash.com/photo-1505142468610-359e7d316be0?w=400">
                        <div class="video-player-v2-playlist-thumbnail">
                            <img src="https://images.unsplash.com/photo-1505142468610-359e7d316be0?w=150&h=100&fit=crop" alt="Océan et Vagues">
                            <span class="video-player-v2-playlist-badge">Vidéo • 0:12</span>
                            <div class="video-player-v2-play-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="white">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="video-player-v2-playlist-info">
                            <h4 class="video-player-v2-playlist-name">Océan et Vagues</h4>
                            <p class="video-player-v2-playlist-type">Vidéo • 0:12</p>
                        </div>
                    </li>

                    {{-- Item 5 - Vidéo supplémentaire --}}
                    <li class="video-player-v2-playlist-item" data-type="video" data-src="{{ asset('home2/videos/hero-video-2.mp4.mp4') }}" data-title="Désert et Ciel Étoilé" data-description="Admirez la majesté d'un ciel étoilé au-dessus du désert." data-poster="https://images.unsplash.com/photo-1509316785289-025f5b846b35?w=400">
                        <div class="video-player-v2-playlist-thumbnail">
                            <img src="https://images.unsplash.com/photo-1509316785289-025f5b846b35?w=150&h=100&fit=crop" alt="Désert et Ciel Étoilé">
                            <span class="video-player-v2-playlist-badge">Image</span>
                        </div>
                        <div class="video-player-v2-playlist-info">
                            <h4 class="video-player-v2-playlist-name">Désert et Ciel Étoilé</h4>
                            <p class="video-player-v2-playlist-type">Image</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>