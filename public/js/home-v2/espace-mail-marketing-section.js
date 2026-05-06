document.addEventListener('DOMContentLoaded', function () {
    var section = document.querySelector('.mail-space-section');
    if (!section) return;

    var buttons = section.querySelectorAll('[data-campaign-target]');
    var cards = section.querySelectorAll('.mail-campaign-card');

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var filter = btn.getAttribute('data-campaign-target');
            buttons.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            cards.forEach(function (card) {
                var type = card.getAttribute('data-campaign-type');
                var visible = filter === 'all' || type === filter;
                card.classList.toggle('hidden', !visible);
            });
        });
    });
});
