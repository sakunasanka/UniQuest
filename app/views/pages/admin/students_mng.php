<?php require APPROOT . '/views/components/header.php'; ?>

<header class="header">
    <div class="logo-block"></div>
    <div class="nav-block"></div>
</header>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>
    
    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab active" style="border-radius: 10px 0px 0px 10px;">Students</button>
            <button class="tab">Companies</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;">Verification Team</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <span class="total-count">Total: 3</span>
                <button class="add-student-btn">Add Student</button>
            </div>
            <table class="students-table">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Registered Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td>
                            <button class="action-btn view"></button>
                            <button class="action-btn deactivate"></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td>
                            <button class="action-btn view"></button>
                            <button class="action-btn activate"></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td>
                            <button class="action-btn view"></button>
                            <button class="action-btn deactivate"></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Footer -->
<footer class="footer">
    © 2024 UniQuest. All rights reserved. | <a href="#">Terms of Services</a> | <a href="#">Privacy policy</a>
</footer>

<?php require APPROOT . '/views/components/footer.php'; ?>