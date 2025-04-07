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
                <form action="<?php echo URLROOT; ?>/student/jobsApply/<?php echo $data['job']->JobID; ?>" 
            method="POST" 
            enctype="multipart/form-data"
            class="application-form">

            <?php 
            $fields = $data['fields'];
            if ($fields): 
                foreach ($fields as $fieldName => $fieldConfig): 
                    $isRequired = isset($fieldConfig['required']) && $fieldConfig['required'];
            ?>
                <div class="form-group">
                    <label for="<?php echo $fieldName; ?>">
                        <?php echo $fieldConfig['label']; ?>
                        <span class="required-asterik" <?php if ($isRequired) echo 'style="display:inline;"'; ?>>*</span>
                    </label>
                    
                    <?php switch($fieldConfig['type']):
                        case 'textarea': ?>
                            <textarea 
                                id="<?php echo $fieldName; ?>"
                                name="<?php echo $fieldName; ?>"
                                rows="4"
                                <?php if ($isRequired) echo 'required'; ?>
                            ></textarea>
                            <?php break;

                        case 'select': ?>
                            <select 
                                id="<?php echo $fieldName; ?>"
                                name="<?php echo $fieldName; ?>"
                                <?php if ($isRequired) echo 'required'; ?>                  
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
                                <?php if ($isRequired) echo 'required'; ?>
                            >
                            <?php break;

                        default: ?>
                            <input 
                                type="<?php echo $fieldConfig['type']; ?>"
                                id="<?php echo $fieldName; ?>"
                                name="<?php echo $fieldName; ?>"
                                <?php if ($isRequired) echo 'required'; ?>
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
    let isValid = true;
    const formElements = this.elements;

    // Clear all previous errors
    document.querySelectorAll('.error-message').forEach(el => {
        el.style.display = 'none';
    });

    // Validate all required fields
    for (let i = 0; i < formElements.length; i++) {
        const field = formElements[i];
        if (field.hasAttribute('required') && !field.value.trim()) {
            showError(field, "This field is required");
            isValid = false;
        }
    }

    // Special validation for specific fields if they exist
    const mobileInput = document.getElementById("contact");
    if (mobileInput && mobileInput.value) {
        const mobilePattern = /^[0-9]{10}$/;
        if (!mobilePattern.test(mobileInput.value)) {
            showError(mobileInput, "Please enter a valid 10-digit mobile number.");
            isValid = false;
        }
    }

    const emailInput = document.getElementById("email");
    if (emailInput && emailInput.value) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            showError(emailInput, "Please enter a valid email address.");
            isValid = false;
        }
    }

    const nicInput = document.getElementById("nic");
    if (nicInput && nicInput.value) {
        const nicPattern = /^[0-9]{9}[vV]$|^[0-9]{12}$/;
        if (!nicPattern.test(nicInput.value)) {
            showError(nicInput, "Please enter a valid NIC number.");
            isValid = false;
        }
    }

    

    // Date of Birth Validation
    const dobInput = document.getElementById("dob");
        if (dobInput && dobInput.value) {
            const dobPattern = /^\d{4}-\d{2}-\d{2}$/; // YYYY-MM-DD format
            if (!dobPattern.test(dobInput.value)) {
                showError(dobInput, "Please enter a valid date of birth in YYYY-MM-DD format.");
                isValid = false;
            } else {
                const dob = new Date(dobInput.value);
                const today = new Date();
                const age = today.getFullYear() - dob.getFullYear();

                // Check if the user is at least 18 years old
                if (age < 18 || (age === 18 && today < new Date(today.setFullYear(dob.getFullYear() + 18)))) {
                    showError(dobInput, "You must be at least 18 years old to apply.");
                    isValid = false;
                }
            }
        }

        // Prevent submission only if invalid
        if (!isValid) {
            event.preventDefault();
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

function showError(input, message) {
    let errorElement = document.getElementById(input.name + '-error') || input.nextElementSibling;
    if (!errorElement || !errorElement.classList.contains('error-message')) {
        errorElement = document.createElement("span");
        errorElement.classList.add("error-message");
        errorElement.id = input.name + '-error';
        input.parentNode.appendChild(errorElement);
    }
    errorElement.textContent = message;
    errorElement.style.display = "block";
    input.style.borderColor = "red";
}
</script>  

<?php require APPROOT . '/views/components/footer.php'; ?>