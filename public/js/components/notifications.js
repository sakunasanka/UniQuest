document.addEventListener('DOMContentLoaded', function() {
    const notificationBtn = document.getElementById('notificationDropdown');
    const dropdownContent = document.getElementById('notificationDropdownContent');
    
    // Toggle dropdown
    notificationBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isVisible = dropdownContent.style.display === 'block';
        dropdownContent.style.display = isVisible ? 'none' : 'block';
        
        if (!isVisible) {
            loadNotifications();
        }
    });
    
    // Close when clicking outside
    document.addEventListener('click', function() {
        dropdownContent.style.display = 'none';
    });
    
    // Load notifications
    function loadNotifications() {
        fetch(`/UniQuest/${role}/getRecentNotifications`, {
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
                        <p>${notification.message}</p>
                        <small>${timeAgo}</small>
                    </div>
                    ${notification.is_read ? '' : `
                    <button class="mark-read" data-id="${notification.id}" data-role="${role}">
                        <span class="material-symbols-outlined">check_circle</span>
                    </button>`}
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
    
    // Poll for new notifications every 30 seconds
    setInterval(loadNotifications, 30000);
});