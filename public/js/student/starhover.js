document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-stars label');
    let selectedRating = 0; // To store the selected rating

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

        // Reset color on mouse out, maintaining selected rating if any
        star.addEventListener('mouseout', function() {
            stars.forEach((s, i) => {
                if (i < selectedRating) {
                    s.style.color = '#f5b301';  // Gold color for selected stars
                } else {
                    s.style.color = '#ccc';  // Default gray color for unselected stars
                }
            });
        });

        // Handle click event to select rating
        star.addEventListener('click', function() {
            selectedRating = Array.from(stars).indexOf(star) + 1; // Update selected rating
            stars.forEach((s, i) => {
                if (i < selectedRating) {
                    s.style.color = '#f5b301';  // Gold color for selected stars
                } else {
                    s.style.color = '#ccc';  // Default gray color for unselected stars
                }
            });
        });
    });
});