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

      function prevSlide() {
          currentSlide = (currentSlide - 1 + slides.length) % slides.length;
          showSlide(currentSlide);
      }

      // Add control buttons
      const controls = document.createElement('div');
      controls.className = 'absolute bottom-4 left-0 right-0 flex justify-center gap-2';
      controls.innerHTML = `
          <button class="prev-slide bg-white/50 hover:bg-white/75 p-2 rounded-full">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
              </svg>
          </button>
          <button class="next-slide bg-white/50 hover:bg-white/75 p-2 rounded-full">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
          </button>
      `;
      
      document.querySelector('.hero-section').appendChild(controls);

      // Add event listeners
      document.querySelector('.prev-slide').addEventListener('click', prevSlide);
      document.querySelector('.next-slide').addEventListener('click', nextSlide);

      showSlide(0);
      setInterval(nextSlide, 5000);
  }
};

document.addEventListener('DOMContentLoaded', () => heroSlider.init());
