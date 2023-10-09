document.addEventListener('DOMContentLoaded', function() {
    var rssLinks = document.querySelectorAll('.wp-block-rss a');
    rssLinks.forEach(function(link) {
        link.setAttribute('target', '_blank');
    });
});