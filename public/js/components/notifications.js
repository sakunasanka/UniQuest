document.addEventListener('DOMContentLoaded', function() {
    const notificationBtn = document.getElementById('notificationDropdown');
    const dropdownContent = document.getElementById('notificationDropdownContent');
    let isDropdownOpen = false;
    let isLoading = false;
    
    // Toggle dropdown
    notificationBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isVisible = dropdownContent.style.display === 'block';
        
        // Toggle display
        dropdownContent.style.display = isVisible ? 'none' : 'block';
        isDropdownOpen = !isVisible;
        
        // Reset to normal view when opening
        if (!isVisible) {
            dropdownContent.classList.remove('expanded');
            document.getElementById('viewAllNotificationsBtn').textContent = 'View all notifications';
            if (!isLoading) {
                loadNotifications();
            }
            document.body.classList.add('dropdown-open');
        } else {
            document.body.classList.remove('dropdown-open');
        }
    });

    // Close when clicking outside
    document.addEventListener('click', function() {
        dropdownContent.style.display = 'none';
        isDropdownOpen = false;
        document.body.classList.remove('dropdown-open');
    });
    
    // Prevent dropdown from closing when clicking inside
    dropdownContent.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Load notifications
    function loadNotifications() {
        isLoading = true;
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
            isLoading = false;
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            isLoading = false;
        });
    }
    
    // Render notifications (only once)
    function renderNotifications(notifications, unreadCount) {
        const container = document.querySelector('.notification-items');
        // Only update if there are actual changes
        if (container.dataset.lastCount === unreadCount && container.innerHTML !== '') {
            return;
        }
        
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
        container.dataset.lastCount = unreadCount;
        updateBadge(unreadCount);
    }
    
    // Mark as read handler
    document.addEventListener('click', function(e) {
        if (!isDropdownOpen) return;
        
        // Handle explicit "Mark as Read" button clicks
        if (e.target.closest('.mark-read')) {
            const button = e.target.closest('.mark-read');
            const id = button.dataset.id;
            const role = button.dataset.role;
            markAsRead(id, role);
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
            'info': 'fa-info-circle text-info'
        };
        return icons[type] || 'fa-bell';
    }
    
    // Poll for new notifications only when dropdown is closed
    setInterval(function() {
        if (!isDropdownOpen) {
            loadNotifications();
        }
    }, 30000);

    // Handle "View all notifications" click
    document.getElementById('viewAllNotificationsBtn').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        if (isLoading) return;
        
        const dropdown = document.getElementById('notificationDropdownContent');
        
        if (dropdown.classList.contains('expanded')) {
            dropdown.classList.remove('expanded');
            this.textContent = 'View all notifications';
            loadNotifications();
        } else {
            dropdown.classList.add('expanded');
            this.textContent = 'Show less';
            loadAllNotifications();
        }
    });

    // Function to load all notifications
    function loadAllNotifications() {
        isLoading = true;
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
            isLoading = false;
        })
        .catch(error => {
            console.error('Error loading all notifications:', error);
            isLoading = false;
        });
    }
});

function handleNotificationClick(event, notificationId, role) {
    fetch(`/UniQuest/${role}/markAsRead/${notificationId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then(response => {
        if (response.ok) {
            window.location.href = event.currentTarget.href;
        }
    }).catch(error => {
        console.error('Error:', error);
        window.location.href = event.currentTarget.href;
    });
    
    event.preventDefault();
}