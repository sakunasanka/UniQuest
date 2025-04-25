<?php require APPROOT . '/views/components/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/view_complaint.css">

<!-- Sidebar and Content Layout -->
<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/all_complaints'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>Complaint Management</h1>
            </button>
        </div>

        <!-- User Details and File Preview Section -->
        <div class="user-layout">
            <!-- Left Side: User Details -->
            <div class="user-details">
                <div class="complaint-header">
                    <h2>Complaint Details</h2>
                    <span class="status <?php echo $data['complaint']->Status; ?>"><?php echo $data['complaint']->Status; ?></span>
                </div>
                <div class="profile-pic">
                    <div class="profile-card" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $data['complaint']->StudentID; ?>'">
                        <img
                            src="<?php echo empty($data['complaint']->StudentProfilePic)
                                        ? URLROOT . '/images/profile_pic_preview.png'
                                        : UPLOADROOT . '/profile_pictures/student/' . $data['complaint']->StudentProfilePic; ?>"
                            alt="Profile Picture">
                        <strong>Student </strong>
                    </div>
                    <div class="profile-card" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $data['complaint']->CompanyID; ?>'">
                        <img
                            src="<?php echo empty($data['complaint']->CompanyLogo)
                                        ? URLROOT . '/images/profile_pic_preview.png'
                                        : UPLOADROOT . '/profile_pictures/company/' . $data['complaint']->CompanyLogo; ?>"
                            alt="Profile Picture">
                        <strong>Company </strong>
                    </div>
                </div>
                <div class="detail-row">
                    <strong>Job Post </strong>
                    <span class="col">:</span>
                    <span><a href="<?php echo URLROOT; ?>/admin/job_detail/<?php echo $data['complaint']->JobID; ?>">
                            <?php echo $data['complaint']->JobTitle ?>
                        </a></span>
                </div>
                <div class="detail-row">
                    <strong>Complained Date </strong>
                    <span class="col">:</span>
                    <span><?php echo substr($data['complaint']->ComplainedDate, 0, 10); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Complaint Discription </strong>
                    <span class="col">:</span>
                </div>
                <div class="detail-row">
                    <span>
                        <?php echo $data['complaint']->Complaint ?>
                    </span>
                </div>
                <div class="form-row">
                    <?php if ($data['complaint']->Status == 'Pending') : ?>
                        <div class="btn-row">
                            <button class="approve-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/start_review/<?php echo $data['complaint']->ComplaintID; ?>'" style="width: auto;">Start Review</button>
                        </div>
                    <?php elseif ($data['complaint']->Status == 'In-Review') : ?>
                        <form action="<?php echo URLROOT; ?>/admin/handle_complaint_action/<?php echo $data['complaint']->ComplaintID; ?>" method="POST" class="complaint-action-form">
                            <div class="btn-row">
                                <!-- hidden inputs for jobid and company id -->
                                <input type="hidden" name="jobID" value="<?php echo $data['complaint']->JobID; ?>">
                                <input type="hidden" name="companyID" value="<?php echo $data['complaint']->CompanyID; ?>">
                                <input type="hidden" name="companyEmail" value="<?php echo $data['complaint']->CompanyEmail; ?>">
                                <input type="hidden" name="studentID" value="<?php echo $data['complaint']->StudentID; ?>">
                                <input type="hidden" name="jobTitle" value="<?php echo $data['complaint']->JobTitle; ?>">
                            </div>
                            <div class="btn-row">
                                <textarea id="note" name="note" rows="1" placeholder="Add Note" class="note-field"></textarea>
                            </div>
                            <div class="btn-row" style="justify-content: space-between;">
                                <label class="check-btn" for="deactivate_job">
                                    <input type="checkbox" name="deactivate_job" id="deactivate_job" value="1">
                                    Deactivate <br> Job
                                </label>
                                <label class="check-btn" for="deactivate_company">
                                    <input type="checkbox" name="deactivate_company" id="deactivate_company" value="1">
                                    Deactivate <br> Company
                                </label>
                                <label class="check-btn" for="send_warning">
                                    <input type="checkbox" name="send_warning" id="send_warning" value="1">
                                    Send <br> Warning
                                </label>
                                <label class="check-btn" for="restrict_posting">
                                    <input type="checkbox" name="restrict_posting" id="restrict_posting" value="1">
                                    Restrict <br> Posting
                                </label>
                            </div>
                            <div class="btn-row">
                                <div class="action-group">
                                    <select class="reason-select approve" name="reasonID">
                                        <option disabled selected>Select Reason</option>
                                        <?php foreach ($data['reasons']['resolve'] as $reason) : ?>
                                            <option value="<?php echo $reason->ReasonID; ?>"><?php echo $reason->ReasonName; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="resolve_submit" class="approve-btn">Resolve</button>
                                </div>
                            </div>
                            <div class="btn-row">
                                <div class="action-group">
                                    <select class="reason-select reject" name="reasonID">
                                        <option value="" disabled selected>Select Reason</option>
                                        <?php foreach ($data['reasons']['reject'] as $reason) : ?>
                                            <option value="<?php echo $reason->ReasonID; ?>"><?php echo $reason->ReasonName; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" name="reject_submit" class="reject-btn">Reject</button>
                                </div>
                            </div>
                            <div class="btn-row">
                                <span class="error-msg"><?php echo $data['reasonID_err'] ?? ''; ?></span>
                            </div>
                        </form>
                    <?php else: ?>
                        <?php if ($data['actionDetail']): ?>
                            <?php if ($data['actionDetail']->CurrentStatus == 'Resolved'): ?>
                                <div class="status-act" style="width: 100%;">
                                    <?php if (!empty($data['actionDetail']->Reason)): ?>
                                        <span>Reason: <?php echo $data['actionDetail']->Reason ?></span><br>
                                    <?php endif; ?>
                                    <?php if (!empty($data['actionDetail']->ActionTimestamp)): ?>
                                        <span>Resolved On: <?php echo substr($data['actionDetail']->ActionTimestamp, 0, 10); ?></span><br>
                                    <?php endif; ?>
                                    <?php if (!empty($data['actionDetail']->AdminNote)): ?>
                                        <span>Note: <?php echo $data['actionDetail']->AdminNote ?></span><br>
                                    <?php endif; ?>
                                </div>
                            <?php elseif ($data['actionDetail']->CurrentStatus == 'Rejected'): ?>
                                <div class="status-deact" style="width: 100%;">
                                    <?php if (!empty($data['actionDetail']->Reason)): ?>
                                        <span>Reason: <?php echo $data['actionDetail']->Reason ?></span><br>
                                    <?php endif; ?>
                                    <?php if (!empty($data['actionDetail']->ActionTimestamp)): ?>
                                        <span>Rejected On: <?php echo substr($data['actionDetail']->ActionTimestamp, 0, 10); ?></span><br>
                                    <?php endif; ?>
                                    <?php if (!empty($data['actionDetail']->AdminNote)): ?>
                                        <span>Note: <?php echo $data['actionDetail']->AdminNote ?></span><br>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Side: File Previews -->
            <div class="file-previews">
                <h2>Proof Previews</h2>
                <?php if (empty($data['complaint']->Proof)) : ?>
                    <span class="no-file">Not available</span>
                <?php elseif (pathinfo($data['complaint']->Proof, PATHINFO_EXTENSION) == 'pdf') : ?>
                    <iframe class="file-preview" src="<?php echo UPLOADROOT . '/proofs/' . $data['complaint']->Proof; ?>" frameborder="0"></iframe>
                <?php elseif (in_array(pathinfo($data['complaint']->Proof, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) : ?>
                    <img class="file-preview" src="<?php echo UPLOADROOT . '/proofs/' . $data['complaint']->Proof; ?>" alt="Proof Image">
                <?php else : ?>
                    <span class="no-file">Unsupported file type</span>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>