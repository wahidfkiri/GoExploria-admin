/**
 * Partners Master User Go Exploria - Original Animations
 */
document.addEventListener('DOMContentLoaded', function() {
    // Animation au chargement
    const section = document.querySelector('.partners-section');
    if (section) {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            section.style.opacity = '1';
            section.style.transform = 'translateY(0)';
        }, 300);
    }
    
    // Animation des badges
    const badges = document.querySelectorAll('.logo-badge');
    badges.forEach((badge, index) => {
        badge.style.opacity = '0';
        badge.style.transform = 'scale(0.8) translateY(20px)';
        
        setTimeout(() => {
            badge.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            badge.style.opacity = '1';
            badge.style.transform = 'scale(1) translateY(0)';
        }, 300 + (index * 150));
    });
    
    // Animation des cartes de fonctionnalités
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateX(0)';
        }, 800 + (index * 200));
    });
    
    // Animation des logos partenaires
    const partnerLogos = document.querySelectorAll('.partner-logo');
    partnerLogos.forEach((logo, index) => {
        logo.style.opacity = '0';
        logo.style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            logo.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            logo.style.opacity = '1';
            logo.style.transform = 'scale(1)';
        }, 1200 + (index * 100));
    });
    
    // Gestion des clics sur les boutons
    document.querySelectorAll('.cta-button, .footer-button').forEach(button => {
        button.addEventListener('click', function() {
            const buttonText = this.textContent.trim();
            
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
            
            if (buttonText.includes('démo') || buttonText.includes('Découvrir')) {
                alert("Fonctionnalité de démonstration - À intégrer avec votre système de rendez-vous ou démo en ligne.");
            } else if (buttonText.includes('contact') || buttonText.includes('contacter')) {
                alert("Fonctionnalité de contact - À intégrer avec votre formulaire de contact ou système de tickets.");
            }
        });
    });
    
    // Effet de compteur pour les statistiques du dashboard
    const statValues = document.querySelectorAll('.stat-value');
    statValues.forEach(stat => {
        const originalText = stat.textContent;
        if (originalText.match(/[\d.,]+/)) {
            const numericValue = parseFloat(originalText.replace(/[^\d.,]/g, '').replace(',', '.'));
            const symbol = originalText.replace(/[\d.,]/g, '');
            
            stat.textContent = '0' + symbol;
            
            let current = 0;
            const increment = numericValue / 30;
            const timer = setInterval(() => {
                current += increment;
                if (current >= numericValue) {
                    clearInterval(timer);
                    stat.textContent = originalText;
                } else {
                    stat.textContent = Math.floor(current) + symbol;
                }
            }, 50);
        }
    });
});
