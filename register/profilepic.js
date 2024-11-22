document.getElementById('profilePic').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Profile Preview';
            img.style.width = '100px';
            img.style.height = '100px';
            document.getElementById('profile-pic-preview').innerHTML = img;
            
        }
        reader.readAsDataURL(file);
    }
});
