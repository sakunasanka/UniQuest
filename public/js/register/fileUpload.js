// Select all file-drop areas
document.querySelectorAll(".file-drop-area").forEach((dropArea) => {
    const button = dropArea.querySelector(".browse-btn");
    const input = dropArea.querySelector("input[type='file']");
    const fileNameDisplay = dropArea.querySelector(".file-name");

    // Trigger file input click when "Browse File" button is clicked
    button.onclick = (e) => {
        input.click();
    };

    // When a file is selected from the dialog
    input.addEventListener("change", (e) => {
        const file = e.target.files[0];
        displayFileName(file, fileNameDisplay);
        showPreviewOrFileName(file, dropArea);
    });

    // Display file name and change color
    function displayFileName(file, fileNameElement) {
        if (file) {
            fileNameElement.textContent = file.name;
            fileNameElement.style.color = "#333"; // Set color to #333 after selection
        } else {
            fileNameElement.textContent = "No file selected";
            fileNameElement.style.color = ""; // Reset to default if no file is selected
        }
    }

    // Show preview for images or display file name for other formats
    function showPreviewOrFileName(file, dropArea) {
        const previewContainer = dropArea.querySelector(".profile-pic-preview");

        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = () => {
                // Display the image preview
                const img = document.createElement("img");
                img.src = reader.result;
                img.alt = "File Preview";

                // Clear any previous content and add the new image
                previewContainer.innerHTML = "";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        } else {
            // If not an image (e.g., PDF), remove the image preview if present
            previewContainer.innerHTML = "<p>File selected: " + file.name + "</p>";
        }
    }

    // Drag-and-drop functionality for each drop area
    dropArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropArea.classList.add("active");
    });

    dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("active");
    });

    dropArea.addEventListener("drop", (e) => {
        e.preventDefault();
        dropArea.classList.remove("active");

        const file = e.dataTransfer.files[0];
        displayFileName(file, fileNameDisplay);
        showPreviewOrFileName(file, dropArea);
    });
});
