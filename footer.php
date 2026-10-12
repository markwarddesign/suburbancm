<?php
if (function_exists('block_template_part')) {
    block_template_part('footer');
} else {
    get_template_part('template-parts/footer');
}
?>

<?php 
  echo do_blocks('<!-- wp:suburbancm/cta-1 {"buttonText":"Contact Our Team","buttonUrl":"/contact","align":"full"} /-->');
  echo do_blocks('<!-- wp:suburbancm/cta-2 {"primaryButtonUrl":"/contact","secondaryButtonUrl":"/services","align":"full"} /-->');
?>
<footer class="bg-[#111111] text-[#a38f50]">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center">
      <p class="text-sm">&copy; 2025 SuburbanCM | General Contracting & Construction Management. All rights reserved.</p>
      <div class="mt-4 flex justify-center space-x-6">
        <a href="#" class="hover:text-[#e4d198] transition-colors duration-200 ease-in-out">Privacy Policy</a>
        <a href="#" class="hover:text-[#e4d198] transition-colors duration-200 ease-in-out">Terms of Service</a>
      </div>
    </div>
</footer>

</body>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    
    // --- Animation Logic ---
    // Load Animations
    const loadAnimatedElements = document.querySelectorAll('[data-animate-on-load]');
    // ... (rest of your load animation JS - unchanged) ...
    loadAnimatedElements.forEach((el, index) => {
      setTimeout(() => {
        el.style.opacity = '1';
        el.style.transform = 'translateY(0)';
      }, 50 * index);
    });
    // Scroll Animations
    const scrollAnimatedElements = document.querySelectorAll('.animate-on-scroll');
    // ... (rest of your scroll animation JS - unchanged) ...
    if ("IntersectionObserver" in window) {
      let observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            if (entry.target.classList.contains('scale-95')) {
              entry.target.style.transform = 'scale(1)';
            } else {
              entry.target.style.transform = 'translateY(0)';
            }
            entry.target.classList.remove('animate-on-scroll');
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.1
      });
      scrollAnimatedElements.forEach(el => {
        observer.observe(el);
      });
    } else {
      scrollAnimatedElements.forEach(el => {
        el.style.opacity = '1';
        el.style.transform = 'none';
      });
    }
    // --- Slider Logic (Placeholder) ---
    // ... (rest of your slider JS - unchanged) ...
  });
</script>



<?php wp_footer(); ?>

</body>
</html>
