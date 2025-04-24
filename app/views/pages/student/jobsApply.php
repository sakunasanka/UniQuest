<?php require APPROOT . '/views/components/header.php'; ?>
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
                        // Create a mapping between form field names and userdetails keys
                        $fieldMapping = [
                            'fullname' => ['firstname', 'lastname'], // Combine first and last name
                            'photo' => 'profilepic',
                            'email' => 'email',
                            'contact' => 'contactno',
                            'nic' => 'nic_no',
                            'dob' => 'dob',
                            'address' => ['streetno', 'addressline1', 'addressline2', 'city'],
                            'gender' => 'gender',
                        ];

                        foreach ($fields as $fieldName => $fieldConfig):
                            $isRequired = isset($fieldConfig['required']) && $fieldConfig['required'];

                            // Get the value based on the mapping
                            $fieldValue = '';
                            if (isset($fieldMapping[$fieldName])) {
                                if (is_array($fieldMapping[$fieldName])) {
                                    // Handle combined fields (like firstname + lastname)
                                    $values = [];
                                    foreach ($fieldMapping[$fieldName] as $userDetailKey) {
                                        if (isset($data['userdetails'][$userDetailKey])) {
                                            $values[] = $data['userdetails'][$userDetailKey];
                                        }
                                    }
                                    $fieldValue = implode(' ', $values);
                                } else {
                                    // Handle direct mapping
                                    $userDetailKey = $fieldMapping[$fieldName];
                                    if (isset($data['userdetails'][$userDetailKey])) {
                                        $fieldValue = $data['userdetails'][$userDetailKey];
                                    }
                                }
                            }
                    ?>
                            <div class="form-group">
                                <label for="<?php echo $fieldName; ?>">
                                    <?php echo $fieldConfig['label']; ?>
                                    <span class="required-asterik" <?php if ($isRequired) echo 'style="display:inline;"'; ?>>*</span>
                                </label>

                                <?php switch ($fieldConfig['type']):
                                    case 'textarea': ?>
                                        <textarea
                                            id="<?php echo $fieldName; ?>"
                                            name="<?php echo $fieldName; ?>"
                                            rows="5"
                                            <?php if ($isRequired) echo 'required'; ?>><?php echo htmlspecialchars($fieldValue); ?></textarea>
                                    <?php break;

                                    case 'select': ?>
                                        <select
                                            id="<?php echo $fieldName; ?>"
                                            name="<?php echo $fieldName; ?>"
                                            <?php if ($isRequired) echo 'required'; ?>>
                                            <option value="">Select <?php echo $fieldConfig['label']; ?></option>
                                            <?php foreach ($fieldConfig['options'] as $option): ?>
                                                <option value="<?php echo $option; ?>" <?php if ($option == $fieldValue) echo 'selected'; ?>>
                                                    <?php echo $option; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php break;

                                    case 'file': ?>
                                        <input
                                            type="file"
                                            id="<?php echo $fieldName; ?>"
                                            name="<?php echo $fieldName; ?>"
                                            accept="<?php echo $fieldConfig['accept']; ?>"
                                            <?php if ($isRequired) echo 'required'; ?>>
                                        <!-- <?php if ($fieldValue): ?>
                                            <div class="current-file">
                                                Current file: <?php echo basename($fieldValue); ?>
                                            </div>
                                        <?php endif; ?> -->
                                    <?php break;

                                    default: ?>
                                        <input
                                            type="<?php echo $fieldConfig['type']; ?>"
                                            id="<?php echo $fieldName; ?>"
                                            name="<?php echo $fieldName; ?>"
                                            value="<?php echo htmlspecialchars($fieldValue); ?>"
                                            <?php if ($isRequired) echo 'required'; ?>>
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
                <?php  if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'Student'):?>
                    <div class="card-icons">
                        <i class="fa fa-share-alt" aria-hidden="true" onclick="shareJob(<?php echo $post->JobID; ?>, '<?php echo $post->Category; ?>')"></i>                     
                        <i class="<?php echo in_array($post->JobID, $data['bookmarkedJobIds']) ? 'fa-solid' : 'fa-regular'; ?> fa-bookmark" onclick="toggleBookmark(this); bookmarkJob(<?php echo $post->JobID; ?>, this)"></i>
                    </div>
                <?php else:?>
                    <div class="card-icons">
                    <i class="fa fa-share-alt" aria-hidden="true" onclick="shareJob(<?php echo $post->JobID; ?>, '<?php echo $post->Category; ?>')"></i>
                    </div>
                <?php endif;?> 
                <div class="job-logo">
                    <img src="<?php echo empty($data['post']->CompanyLogo)
                                    ? URLROOT . '/images/profile_pic_preview.png'
                                    : UPLOADROOT . '/profile_pictures/company/' . $data['post']->CompanyLogo; ?>"
                        alt="Burger King Logo">
                </div>
                <div class="job-details">
                    <h3><?php echo $data['post']->Title; ?></h3>
                    <p><b>@<span><?php echo $data['post']->CompanyName; ?></b></span></p>
                    
                    <p><?php echo converttimetoreadableformat($post->jobs_create_at); ?></p>
                    <p class="job-rating"><i class="fa fa-star"></i> <?php echo $data['displayRating']; ?></p>
                    <p><?php echo $data['post']->City; ?></p>
                    <table class="table">
                        <tr><td>Salary:</td><td>Rs.<?php echo $data['post']->SalaryRange; ?> <?php echo $data['post']->SalaryType; ?></td></tr>
                        <tr><td>Category:</td><td><?php echo $data['post']->Category; ?></td></tr>
                        <tr><td>Applicants:</td><td>26</td></tr>
                    </table>

                    <div class="social-media-icons">
                        <?php if (!empty($post->Website)): ?>
                            <?php $website = (strpos($post->Website, 'http') === 0) ? $post->Website : 'https://' . $post->Website; ?>
                            <a href="<?php echo htmlspecialchars($website); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Company website">
                                <i class="fas fa-globe"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($post->LinkedIn)): ?>
                            <?php $linkedin = (strpos($post->LinkedIn, 'http') === 0) ? $post->LinkedIn : 'https://www.linkedin.com/' . ltrim($post->LinkedIn, '/'); ?>
                            <a href="<?php echo htmlspecialchars($linkedin); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="LinkedIn profile">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($post->Facebook)): ?>
                            <?php $facebook = (strpos($post->Facebook, 'http') === 0) ? $post->Facebook : 'https://www.facebook.com/' . ltrim($post->Facebook, '/'); ?>
                            <a href="<?php echo htmlspecialchars($facebook); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Facebook page">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="buttons">
                    <button onclick="goToCompanyDescription(<?php echo $post->CompanyID; ?>)" class="apply-btn">View Company</button>
                </div>
            </div>  
        </div>
    </div>

</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

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
    
function goToMakeComplaint(jobId) {
    window.location.href = "/UniQuest/student/make_complain/" + jobId;
}

function goToApplyPage(jobId) {
    window.location.href = "/UniQuest/student/jobsApplyform/" + jobId;
}

function goToReport(jobId) {
    window.location.href = "/UniQuest/service_provider/report/" + jobId;
}

function toggleBookmark(icon, jobId) {
icon.classList.toggle("fa-regular");
icon.classList.toggle("fa-solid");
icon.classList.toggle("icon-active");
}

// Function to bookmark a job
function bookmarkJob(jobId, iconElement) {
    // Create a new FormData object to send the jobId
    const formData = new FormData();
    formData.append('job_id', jobId); // Append the job ID to the request data

    // Create a new XMLHttpRequest to send the data to the server

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo URLROOT; ?>/jobs/toggleBookmark', true);

    // Set up the callback for when the request completes
    xhr.onload = function() {
        if (xhr.status === 200) {
            iconElement.classList.toggle('bookmarked'); // Toggle the bookmark icon
        } else {
            Flash.show('Failed to bookmark company', 'error');
        }
    };

    // Send the request with the form data
    xhr.send(formData);
}

function shareJob(jobId, jobType) {
    const jobURL = `${window.location.origin}/UniQuest/jobs/jobsdescription/${jobId}`;
    
    navigator.clipboard.writeText(jobURL).then(() => {
        if (jobType === 'Part-time') {
            Flash.show('Job link copied to clipboard!', 'success');
        } else if (jobType === 'Internship') {
            Flash.show('Internship link copied to clipboard!', 'success');
        } else {
            Flash.show('Link copied to clipboard!', 'success');
        }
    }).catch(err => {
        Flash.show('Failed to copy link', 'error');
    });
}

function goToCompanyDescription($companyID) {
    window.location.href = "/UniQuest/jobs/companydescription/"+$companyID;
}

function goToApplications(jobId) {
    window.location.href = "/UniQuest/service_provider/new_applications/" + jobId;
}
</script>