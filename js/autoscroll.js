// JavaScript for auto-scrolling gallery
document.addEventListener("DOMContentLoaded", function() {
    var gallery = document.querySelector('.gallery');
    var speed = 50; // Speed modifier, lower value will scroll faster
    var scrollPos = 0; // Initial scroll position
    var animation; // To hold the requestAnimationFrame

    function autoScroll() {
        gallery.scrollLeft = scrollPos; // Update the scroll position

        // Check for reaching the end of the gallery and reset to start
        if (scrollPos >= gallery.scrollWidth - gallery.clientWidth) {
            scrollPos = 0; // Reset position
        } else {
            scrollPos += 1; // Move the position further for scrolling
        }

        animation = requestAnimationFrame(autoScroll); // Continue the animation
    }

    autoScroll(); // Start the auto scroll

    // Pause on hover
    gallery.addEventListener('mouseenter', function() {
        cancelAnimationFrame(animation); // Stop the scrolling
    });

    gallery.addEventListener('mouseleave', function() {
        autoScroll(); // Resume the auto scroll
    });
});
