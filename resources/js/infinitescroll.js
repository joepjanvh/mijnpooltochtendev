document.addEventListener('DOMContentLoaded', function() {
    let options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.40
    };

    let observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                Livewire.dispatch('loadMore');
            }
        });
    }, options);

    let trigger = document.getElementById('load-more-trigger');
    observer.observe(trigger);
});