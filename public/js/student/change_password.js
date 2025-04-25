document.addEventListener("DOMContentLoaded", function () {
    let toggles = document.querySelectorAll(".changep_password-toggle");

    // Handle password visibility toggle
    toggles.forEach(toggle => {
        toggle.addEventListener("click", function () {
            let input = this.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
                this.innerHTML = "&#128064;"; // Open eye
            } else {
                input.type = "password";
                this.innerHTML = "&#128065;"; // Closed eye
            }
        });
    });

    // Listen for form submission
    document.getElementById("changePasswordForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent page reload

        let formData = new FormData(this);

        fetch(window.location.origin + "/UniQuest/user/change_password", { // Use absolute path
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "error") {
                    // console.log(data.errors); // Debugging

                    // Clear previous error messages
                    document.querySelectorAll(".error-msg").forEach(el => el.innerText = "");

                    // Display errors
                    for (const field in data.errors) {
                        let errorElement = document.getElementById(field + "_err");
                        if (errorElement) {
                            errorElement.innerText = data.errors[field];
                        }
                    }
                } else if (data.status === "success") {
                    // showPopup(data.message, "success");
                    // document.getElementById("changePasswordForm").reset(); // Reset form
                    // setTimeout(() => {
                    //     ToggleChangePasswordForm(); // Close popup after success
                    // }, 2000);

                    // document.getElementById("error").innerHTML = "Password changed successfully. Redirecting to login page...";

                    // Close the popup
                    // ToggleChangePasswordForm();


                    //redirect to login page
                    window.location.href = window.location.origin + "/UniQuest/login";
                }
            })
            .catch(error => {
                console.error("Error:", error);
                document.getElementById("error").innerHTML = "An error occurred. Please try again later.";
            });
    });
});

// Function to toggle the change password popup
function ToggleChangePasswordForm() {
    let popup = document.getElementById("popup-changepw");
    popup.classList.toggle("active");
}

// Show the message in the popup
// function showPopup(message, status) {
//     let popup = document.querySelector(".popup-container");
//     let popupMessage = document.querySelector(".popup p");
//     let popupTitle = document.querySelector(".popup h2");

//     if (!popupMessage) {
//         popupMessage = document.createElement("p");
//         document.querySelector(".popup .content").appendChild(popupMessage);
//     }

//     popupTitle.innerText = (status === "success") ? "Success!" : "Error!";
//     popupMessage.innerText = message;
//     popup.classList.add("show-popup");

//     // Hide popup after 3 seconds
//     setTimeout(() => popup.classList.remove("show-popup"), 1000);
// }
