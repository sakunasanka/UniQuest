<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/notification.css">


<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
    
    
    <div class="content-area">
    <div class="notification-item">
      <div class="badge joined">Joined New User</div>
      <div class="content">
        <h4>New Registration: Finibus Bonorum et Malorum</h4>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
        <span class="author">Allen Deu</span>
      </div>
      <div class="time">24 Nov 2018 at 9:30 AM</div>
    </div>

    <div class="notification-item">
      <div class="badge message">Message</div>
      <div class="content">
        <h4>Darren Smith sent new message</h4>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
        <span class="author">Darren</span>
      </div>
      <div class="time">24 Nov 2018 at 9:30 AM</div>
    </div>

    <div class="notification-item">
      <div class="badge comment">Comment</div>
      <div class="content">
        <h4>Arin Ganshiram Commented on post</h4>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
        <span class="author">Arin Ganshiram</span>
      </div>
      <div class="time">24 Nov 2018 at 9:30 AM</div>
    </div>

    <div class="notification-item">
      <div class="badge connect">Connect</div>
      <div class="content">
        <h4>Jullet Den Connect Allen Depk</h4>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium</p>
        <span class="author">Jullet Den</span>
      </div>
      <div class="time">24 Nov 2018 at 9:30 AM</div>
    </div>
  </div>









<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>
