/**
 * Header Visibility Controller Script
 * 
 * This script manages the visibility of the site header based on scroll direction.
 * It implements a "smart header" that hides when scrolling down and appears when
 * scrolling up, improving the user experience by providing more screen space
 * while maintaining easy access to navigation.
 * 
 * Features:
 * - Shows header at the top of the page
 * - Hides header when scrolling down
 * - Shows header when scrolling up
 * - Uses threshold to prevent unwanted toggling
 * - Optimized with passive event listeners
 */

document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.site-header');
    const scrollThreshold = 100; // Minimum scroll distance to trigger
    let lastScrollTop = 0;
    
    // Initial state
    header.classList.add('visible');
    
    // Show header at the very top of the page
    if (window.scrollY === 0) {
        header.classList.add('visible');
    }
    
    window.addEventListener('scroll', function() {
        // If scrolled more than threshold
        if (window.scrollY > scrollThreshold) {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            
            if (currentScroll > lastScrollTop) {
                // Scrolling down
                header.classList.remove('visible');
            } else {
                // Scrolling up
                header.classList.add('visible');
            }
            
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        } else {
            // At the top
            header.classList.add('visible');
        }
    }, { passive: true });
}); 