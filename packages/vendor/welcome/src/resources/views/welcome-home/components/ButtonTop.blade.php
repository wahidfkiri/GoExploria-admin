
     <style>
        /* Style pour le bouton retour en haut */
        .back-to-top {
            position: fixed;
            bottom: 110px;
            right: 40px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #107583;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            transform: translateY(-10px);
        }
        
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
    </style>
    <!-- Bouton retour en haut -->
    <button class="back-to-top" id="backToTop" aria-label="Retour en haut">
        <i class="fas fa-arrow-up"></i>
    </button>
     <script>
    // Script pour le bouton retour en haut
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopButton = document.getElementById('backToTop');
        
        // Afficher/masquer le bouton selon le défilement
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        // Retour en haut avec animation fluide
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
    });
    </script>