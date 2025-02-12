<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/jobsApply.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    <div class="content-area">
        <div class="header">
            <h1>Application Form for <?php echo $data['job']->Title; ?></h1>
        </div>
        <p>Please fill out the details below to submit your application</p>
        
        <div class="form-section">
            <!-- Form Container -->
            <div class="form-container">
        <form action="<?php echo URLROOT; ?>/student/submit_application/<?php echo $data['job']->JobID; ?>" 
              method="POST" 
              enctype="multipart/form-data"
              class="application-form">
            
            <?php 
            $fields = $data['fields'];
            if ($fields): 
                foreach ($fields as $fieldName => $fieldConfig): 
            ?>
                <div class="form-group">
                    <label for="<?php echo $fieldName; ?>"><?php echo $fieldConfig['label']; ?> *</label>
                    
                    <?php switch($fieldConfig['type']):
                        case 'textarea': ?>
                            <textarea 
                                id="<?php echo $fieldName; ?>"
                                name="<?php echo $fieldName; ?>"
                                rows="4"
                                required
                            ></textarea>
                            <?php break;

                        case 'select': ?>
                            <select 
                                id="<?php echo $fieldName; ?>"
                                name="<?php echo $fieldName; ?>"
                                required
                            >
                                <option value="">Select <?php echo $fieldConfig['label']; ?></option>
                                <?php foreach($fieldConfig['options'] as $option): ?>
                                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php break;

                        case 'file': ?>
                            <input 
                                type="file"
                                id="<?php echo $fieldName; ?>"
                                name="<?php echo $fieldName; ?>"
                                accept="<?php echo $fieldConfig['accept']; ?>"
                                required
                            >
                            <?php break;

                        default: ?>
                            <input 
                                type="<?php echo $fieldConfig['type']; ?>"
                                id="<?php echo $fieldName; ?>"
                                name="<?php echo $fieldName; ?>"
                                required
                            >
                    <?php endswitch; ?>
                    
                    <span class="error-message" id="<?php echo $fieldName; ?>-error"></span>
                </div>
            <?php 
                endforeach;
            endif; 
            ?>

            <p class="form-notice">Please note that once you submit, the application will be directly sent to the recruiter.</p>
            
            <button type="submit" class="submit-button">SUBMIT</button>
        </form>
    </div>

            <!-- Job Information Card -->
            <div class="job-card">
                <div class="job-logo">
                    <img src="<?php echo URLROOT; ?>/images/upeka.jpg" alt="Burger King Logo">
                </div>
                <div class="job-details">
                    <h3>Female Promotion Assistant</h3>
                    <p>Piliyandala</p>
                    <p>Rs. 2500 (per day)</p>
                    <p>2 hours ago</p>
                    <p class="job-rating"><i class="fa fa-star"></i> 4.8</p>
                    <p>Piliyandala</p>
                    <table class="table">
                        <tr><td>Education:</td><td>Ordinary Level</td></tr>
                        <!-- <tr><td>Experience:</td><td>No Experience</td></tr> -->
                        <tr><td>Salary Range:</td><td>Rs. 2500 (per day)</td></tr>
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