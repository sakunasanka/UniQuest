document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-stars label');
    const radioInputs = document.querySelectorAll('.rating-stars input[type="radio"]');
    let selectedRating = document.querySelector('.rating-stars input[type="radio"]:checked')?.value || 0;

    // Initialize stars based on PHP value
    stars.forEach((star, i) => {
        star.style.color = (i < selectedRating) ? '#f5b301' : '#ccc';
    });

    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const index = Array.from(stars).indexOf(star);
            stars.forEach((s, i) => {
                s.style.color = i <= index ? '#f5b301' : '#ccc';
            });
        });

        star.addEventListener('mouseout', function() {
            stars.forEach((s, i) => {
                s.style.color = i < selectedRating ? '#f5b301' : '#ccc';
            });
        });

        star.addEventListener('click', function() {
            const clickedIndex = Array.from(stars).indexOf(star);
            selectedRating = clickedIndex + 1;
            
            // Update the corresponding radio input
            radioInputs[clickedIndex].checked = true;
            
            // Update star colors
            stars.forEach((s, i) => {
                s.style.color = i < selectedRating ? '#f5b301' : '#ccc';
            });
        });
    });
});