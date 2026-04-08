// FILTRES PAR CATÉGORIE
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.email-product-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            cards.forEach(card => {
                if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
                    card.classList.remove('hide');
                    // Animation d'apparition
                    card.style.animation = 'fadeInUp 0.4s ease forwards';
                } else {
                    card.classList.add('hide');
                }
            });
        });
    });
    
    // Preview email - simulation
    const previewBtns = document.querySelectorAll('.preview-email-btn');
    previewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const productTitle = this.closest('.card-content').querySelector('.product-title').textContent;
            alert(`📧 Aperçu de l'email pour : ${productTitle}\n\nCette fonctionnalité ouvrira un modal avec le template email complet.`);
        });
    });
});

// Animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);