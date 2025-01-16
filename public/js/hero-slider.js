const heroSlider = {
    init() {
        const slides = document.querySelectorAll('.hero-slide');
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach(slide => slide.classList.add('hidden'));
            slides[index].classList.remove('hidden');
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        showSlide(0);
        setInterval(nextSlide, 5000);
    }
};

document.addEventListener('DOMContentLoaded', () => heroSlider.init());
