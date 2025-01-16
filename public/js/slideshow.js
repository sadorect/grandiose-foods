document.addEventListener('DOMContentLoaded', function() {
    setInterval(() => {
        const slideshow = document.querySelector('[x-data]').__x.$data;
        slideshow.currentSlide = slideshow.currentSlide === 0 ? 1 : 0;
    }, 5000);
});
