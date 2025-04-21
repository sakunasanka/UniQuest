document.addEventListener('DOMContentLoaded', function() {
    const notificationBtn = document.getElementById('notificationDropdown');
    const dropdownContent = document.getElementById('notificationDropdownContent');
    
    // Toggle dropdown
    notificationBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isVisible = dropdownContent.style.display === 'block';
        
        // Toggle display
        dropdownContent.style.display = isVisible ? 'none' : 'block';
        
        // Reset to normal view when opening
        if (!isVisible) {
            dropdownContent.classList.remove('expanded');
            document.getElementById('viewAllNotificationsBtn').textContent = 'View all notifications';
            loadNotifications();
            document.body.classList.add('dropdown-open');
        } else {
            document.body.classList.remove('dropdown-open');
        }
    });

    // Also update the document click handler
    document.addEventListener('click', function() {
        dropdownContent.style.display = 'none';
        document.body.classList.remove('dropdown-open');
    });
    
    // Close when clicking outside
    document.addEventListener('click', function() {
        dropdownContent.style.display = 'none';
    });
    
    // Load notifications
    function loadNotifications() {
        fetch(`/UniQuest/${userRole}/getRecentNotifications`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                renderNotifications(data.notifications, data.unreadCount);
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
        });
    }
    
    // Render notifications
    function renderNotifications(notifications, unreadCount) {
        const container = document.querySelector('.notification-items');
        let html = '';
        
        if (notifications.length > 0) {
            notifications.forEach(notification => {
                const timeAgo = formatTime(notification.created_at);
                html += `
                <div class="notification-item ${notification.is_read ? 'read' : 'unread'} ${notification.type}" 
                     data-id="${notification.id}">
                    <div class="notification-icon">
                        <i class="fas ${getIcon(notification.type)}"></i>
                    </div>
                    <div class="notification-content">
                        ${notification.related_url ? `
                            <a href="/UniQuest${notification.related_url}" class="notification-link mark-read" data-id="${notification.id}" data-role="${userRole}">
                                ${notification.message}
                            </a>` 
                            : 
                            `<span class="notification-link mark-read" data-id="${notification.id}" data-role="${userRole}">
                                ${notification.message}
                            </span>`}
                        <small>${timeAgo}</small>
                    </div>
                    ${notification.is_read ? '' : `
                    <span class="mark-read" data-id="${notification.id}" data-role="${userRole}">
                        <span class="mark-all-read">Mark As Read</span>
                    </span>`}
                </div>`;
            });
        } else {
            html = '<div class="empty-notification"><p>No notifications</p></div>';
        }
        
        container.innerHTML = html;
        updateBadge(unreadCount);
    }
    
    // Mark as read handler
    document.addEventListener('click', function(e) {
        // Handle explicit "Mark as Read" button clicks
        if (e.target.closest('.mark-read')) {
            const button = e.target.closest('.mark-read');
            const id = button.dataset.id;
            const role = button.dataset.role;
            markAsRead(id, role);
        }
        
        // Handle notification content clicks
        const notificationContent = e.target.closest('.notification-content');
        if (notificationContent) {
            const notificationItem = notificationContent.closest('.notification-link');
            if (notificationItem && notificationItem.classList.contains('unread')) {
                const id = notificationItem.dataset.id;
                
                // Mark as read but don't immediately apply visual changes
                fetch(`/UniQuest/${userRole}/markAsRead/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateBadge(data.unreadCount);
                        // Don't change appearance here
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
            }
        }
    });
    
    // Mark as read function
    function markAsRead(id, role) {
        fetch(`/UniQuest/${role}/markAsRead/${id}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const item = document.querySelector(`.notification-item[data-id="${id}"]`);
                if (item) {
                    item.classList.remove('unread');
                    item.classList.add('read');
                    item.querySelector('.mark-read')?.remove();
                }
                updateBadge(data.unreadCount);
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }
    
    // Helper functions
    function updateBadge(count) {
        const badge = document.querySelector('.notification-badge');
        if (count > 0) {
            if (badge) {
                badge.textContent = count;
            } else {
                const newBadge = document.createElement('span');
                newBadge.className = 'notification-badge';
                newBadge.textContent = count;
                notificationBtn.appendChild(newBadge);
            }
        } else if (badge) {
            badge.remove();
        }
    }
    
    function formatTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) + 
               ' · ' + date.toLocaleDateString([], { month: 'short', day: 'numeric' });
    }
    
    function getIcon(type) {
        const icons = {
            'success': 'fa-check-circle text-success',
            'warning': 'fa-exclamation-triangle text-warning',
            'danger': 'fa-times-circle text-danger',
            'info': 'fa-info-circle text-info',
            'message': 'fa-envelope text-primary'
        };
        return icons[type] || 'fa-bell';
    }
    
    // Poll for new notifications every 30 seconds
    setInterval(loadNotifications, 30000);

    // Handle "View all notifications" click
    document.getElementById('viewAllNotificationsBtn').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Get the dropdown
        const dropdown = document.getElementById('notificationDropdownContent');
        
        // Toggle between expanded and normal view
        if (dropdown.classList.contains('expanded')) {
            dropdown.classList.remove('expanded');
            this.textContent = 'View all notifications';
            loadNotifications(); // Load only the recent notifications
        } else {
            dropdown.classList.add('expanded');
            this.textContent = 'Show less';
            loadAllNotifications(); // Load all notifications
        }
    });

    // Function to load all notifications
    function loadAllNotifications() {
        fetch(`/UniQuest/${userRole}/getAllNotifications`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                renderNotifications(data.notifications, data.unreadCount);
            }
        })
        .catch(error => {
            console.error('Error loading all notifications:', error);
        });
    }
});

function handleNotificationClick(event, notificationId, role) {
    // First mark as read
    fetch(`/UniQuest/${role}/markAsRead/${notificationId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then(response => {
        if (response.ok) {
            // After marking as read, proceed with navigation
            window.location.href = event.currentTarget.href;
        }
    }).catch(error => {
        console.error('Error:', error);
        // Still proceed with navigation even if marking read fails
        window.location.href = event.currentTarget.href;
    });
    
    // Prevent default to wait for mark-as-read to complete
    event.preventDefault();
}