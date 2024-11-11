document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-stars label');

    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const index = Array.from(stars).indexOf(star);
            // Color stars from left to right on hover
            stars.forEach((s, i) => {
                if (i <= index) {
                    s.style.color = '#f5b301';  // Gold color
                } else {
                    s.style.color = '#ccc';  // Default gray color
                }
            });
        });

        // Handle click event to select rating
        star.addEventListener('click', function() {
            const rating = this.previousElementSibling.value;
            stars.forEach(s => {
                if (s.previousElementSibling.value <= rating) {
                    s.style.color = '#f5b301';  // Gold color for selected stars
                } else {
                    s.style.color = '#ccc';  // Default gray color for unselected stars
                }
            });
        });
    });
});
