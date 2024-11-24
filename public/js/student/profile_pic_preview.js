document.addEventListener("DOMContentLoaded", () => {
    const profilePicInput = document.getElementById("profilePic");
    const profilePicPreview = document.getElementById("profilePicPreview");
    const profilePicError = document.getElementById("profilePicError"); // Error message span
    const defaultImage = profilePicPreview.src; // Store the default image URL

    profilePicInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        profilePicError.textContent = ""; // Clear previous error message

        if (file) {
            // Validate file size (5MB = 5242880 bytes)
            if (file.size > 5242880) {
                profilePicError.textContent = "The file size should be under 5MB.";
                profilePicInput.value = ""; // Clear the file input
                profilePicPreview.src = defaultImage; // Reset to the default image
                return;
            }

            // Validate file type
            const validImageTypes = ["image/jpeg", "image/png"];
            if (!validImageTypes.includes(file.type)) {
                profilePicError.textContent = "Please upload a valid image file (JPG or PNG).";
                profilePicInput.value = ""; // Clear the file input
                profilePicPreview.src = defaultImage; // Reset to the default image
                return;
            }

            // Preview the uploaded image
            const reader = new FileReader();
            reader.onload = () => {
                profilePicPreview.src = reader.result; // Set the uploaded image as preview
            };
            reader.readAsDataURL(file);
        } else {
            // Reset to the default image if no file is selected
            profilePicPreview.src = defaultImage;
        }
    });
});
