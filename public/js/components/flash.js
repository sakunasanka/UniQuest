class FlashMessage {
    static show(message, type = 'success', duration = 3000) {
        const flashContainer = document.getElementById('flash-container') || this.createContainer();
        const messageEl = document.createElement('div');
        
        messageEl.className = `flash-message ${type}`;
        messageEl.innerHTML = `
            <i class="fas fa-${this.getIcon(type)}"></i>
            <span>${message}</span>
            <button class="flash-close">&times;</button>
        `;
        
        flashContainer.appendChild(messageEl);
        setTimeout(() => messageEl.classList.add('show'), 10);
        
        // Auto-remove
        if (duration > 0) {
            setTimeout(() => this.remove(messageEl), duration);
        }
        
        // Close button
        messageEl.querySelector('.flash-close').addEventListener('click', () => {
            this.remove(messageEl);
        });
        
        return messageEl;
    }
    
    static remove(element) {
        element.classList.remove('show');
        setTimeout(() => element.remove(), 300);
    }
    
    static getIcon(type) {
        const icons = {
            'success': 'check-circle',
            'error': 'exclamation-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        return icons[type] || 'info-circle';
    }
    
    static createContainer() {
        const container = document.createElement('div');
        container.id = 'flash-container';
        container.className = 'flash-container';
        document.body.appendChild(container);
        return container;
    }
}

// Make it available globally
window.Flash = FlashMessage;