<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsApply.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    <div class="content-area">
        <div class="header">
            <h1>Apply for this job</h1>
        </div>
        <p>Please fill out the details below to submit your application</p>
        
        <div class="form-section">
            <!-- Form Container -->
            <div class="form-container">
                <form action="submitApplication.php" method="POST">
                    <div class="form-group">
                        <label for="fullName">Full Name *</label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>

                    <div class="form-group">
                        <label for="mobileNumber">Mobile Number *</label>
                        <input type="text" id="mobileNumber" name="mobileNumber" required>
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="nic">NIC *</label>
                        <input type="text" id="nic" name="nic" required>
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="address">Address *</label>
                        <input type="text" id="address" name="address" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender *</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="education">Education qualifications*</label>
                        <textarea id="education" name="education" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="ageCheck">Are you 18+ years old? *</label>
                        <select id="ageCheck" name="ageCheck" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    
                    <p>Please note that once you hit the submit button, the application will be directly sent to the recruiter.</p>
                    
                    <button type="submit" class="submit-button">SUBMIT</button>
                </form>
            </div>

            <!-- Job Information Card -->
            <div class="job-card">
                <div class="job-logo">
                    <img src="<?php echo URLROOT; ?>/images/Burger-logo.png" alt="Burger King Logo">
                </div>
                <div class="job-details">
                    <h3>Delivery Rider</h3>
                    <p>Negombo / Ja Ela / Kiribathgoda</p>
                    <p>Rs. 2,000 (per day)</p>
                    <p>9 days left</p>
                    <p class="job-rating"><i class="fa fa-star"></i> 4.8</p>
                    <p>Colombo, Western Province</p>
                    <table class="table">
                        <tr><td>Education:</td><td>Ordinary Level</td></tr>
                        <tr><td>Experience:</td><td>No Experience</td></tr>
                        <tr><td>Salary Range:</td><td>Any</td></tr>
                    </table>
                    
                    <div class="social-media-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    let isValid = true;

    // Validate Mobile Number
    const mobileInput = document.getElementById("mobileNumber");
    const mobilePattern = /^[0-9]{10}$/; // 10-digit number
    if (!mobilePattern.test(mobileInput.value)) {
        showError(mobileInput, "Please enter a valid 10-digit mobile number.");
        isValid = false;
    } else {
        hideError(mobileInput);
    }

    // Validate Email
    const emailInput = document.getElementById("email");
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailInput.value)) {
        showError(emailInput, "Please enter a valid email address.");
        isValid = false;
    } else {
        hideError(emailInput);
    }

    // Validate NIC
    const nicInput = document.getElementById("nic");
    const nicPattern = /^[0-9]{9}[vV]$|^[0-9]{12}$/;
    if (!nicPattern.test(nicInput.value)) {
        showError(nicInput, "Please enter a valid NIC number.");
        isValid = false;
    } else {
        hideError(nicInput);
    }

    // Submit form if valid
    if (isValid) {
        alert("Application submitted successfully!");
        this.submit();
    }
});

// Show error message
function showError(input, message) {
    let errorElement = input.nextElementSibling;
    if (!errorElement) {
        errorElement = document.createElement("span");
        errorElement.classList.add("error-message");
        input.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;
    errorElement.style.display = "block";
    input.style.borderColor = "red";
}

// Hide error message
function hideError(input) {
    const errorElement = input.nextElementSibling;
    if (errorElement) {
        errorElement.style.display = "none";
    }
    input.style.borderColor = "#ddd"; // Reset border color
}
</script>  

<?php require APPROOT . '/views/components/footer.php'; ?>
