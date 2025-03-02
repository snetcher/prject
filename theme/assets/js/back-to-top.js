/**
 * Back to Top Button Script
 * 
 * This script creates and manages a "back to top" button that appears when the user
 * scrolls down the page. When clicked, it smoothly scrolls the page back to the top.
 * 
 * Features:
 * - Dynamically creates a button element
 * - Shows/hides based on scroll position
 * - Smooth scrolling animation
 * - Accessible with proper aria-label
 */

document.addEventListener('DOMContentLoaded', function() {
    // Create button
    const backToTop = document.createElement('button');
    backToTop.classList.add('back-to-top');
    backToTop.setAttribute('aria-label', 'Scroll to top');
    document.body.appendChild(backToTop);

    // Scroll to top function
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    // Click handler
    backToTop.addEventListener('click', scrollToTop);

    // Show/hide button on scroll
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });
}); 