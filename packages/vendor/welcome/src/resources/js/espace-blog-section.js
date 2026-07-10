document.addEventListener('DOMContentLoaded', function () {
    var section = document.querySelector('.blog-space-section');
    if (!section) return;

    var buttons = section.querySelectorAll('[data-blog-filter]');
    var cards = section.querySelectorAll('.blog-post-card');
    var featured = section.querySelector('.blog-featured-story');
    var miniPosts = section.querySelectorAll('.blog-mini-post');

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var filter = btn.getAttribute('data-blog-filter');
            buttons.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            cards.forEach(function (card) {
                var type = card.getAttribute('data-blog-type');
                var visible = filter === 'all' || type === filter;
                card.classList.toggle('hidden', !visible);
            });

            miniPosts.forEach(function (post) {
                var type = post.getAttribute('data-blog-type');
                var visible = filter === 'all' || type === filter;
                post.classList.toggle('hidden', !visible);
            });

            if (featured) {
                var featuredType = featured.getAttribute('data-blog-type');
                var showFeatured = filter === 'all' || featuredType === filter;
                featured.classList.toggle('hidden', !showFeatured);
            }
        });
    });
});
