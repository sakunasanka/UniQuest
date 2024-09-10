<?php require APPROOT . '/views/components/header.php'; ?>

<header class="header">

</header>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php require APPROOT . '/views/components/admin/topPanelUser.php'; ?>
        <div class="table-block">
            <div class="content-header">
                <span class="total-count">Total: 10</span>
                <button class="add-btn">
                    <span class="material-symbols-outlined">person_add</span>
                    <span class="add-btn-text">Add Student</span>
                </button>
            </div>
            <table>
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
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view" data-tooltip="View Profile">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit" data-tooltip="Edit Profile">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate" data-tooltip="Deactivate User">
                                person_remove
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status inactive">Deactive</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn activate">
                                person_add
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Sakith</td>
                        <td>sakiththewmika@gmail.com</td>
                        <td>076 4834398</td>
                        <td>2024/05/16</td>
                        <td><span class="status active">Active</span></td>
                        <td class="action">
                            <span class="material-symbols-outlined action-btn view">
                                account_box
                            </span>
                            <span class="material-symbols-outlined action-btn edit">
                                edit_square
                            </span>
                            <span class="material-symbols-outlined action-btn deactivate">
                                person_remove
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="pagination">
                <button class="page-btn prev">&laquo;</button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn next">&raquo;</button>
            </div>
        </div>
    </main>
</div>

<!-- Footer -->
<footer class="footer">

</footer>

<?php require APPROOT . '/views/components/footer.php'; ?>