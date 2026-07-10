document.addEventListener('DOMContentLoaded', function () {
    var section = document.querySelector('.chat-space-section');
    if (!section) return;

    var buttons = section.querySelectorAll('[data-chat-filter]');
    var cards = section.querySelectorAll('.chat-thread-card');

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var filter = btn.getAttribute('data-chat-filter');
            buttons.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            cards.forEach(function (card) {
                var type = card.getAttribute('data-chat-type');
                var visible = filter === 'all' || type === filter;
                card.classList.toggle('hidden', !visible);
            });
        });
    });
});
