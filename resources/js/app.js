import './bootstrap';
import Alpine from 'alpinejs';

// Make Alpine available globally
window.Alpine = Alpine;

// Alpine.js Components
Alpine.data('sidebar', () => ({
    isOpen: false,
    toggle() {
        this.isOpen = !this.isOpen;
    }
}));

Alpine.data('notification', () => ({
    show: false,
    message: '',
    type: 'success',
    showNotification(message, type = 'success') {
        this.message = message;
        this.type = type;
        this.show = true;
        setTimeout(() => {
            this.show = false;
        }, 5000);
    }
}));

Alpine.data('modal', () => ({
    isOpen: false,
    open() {
        this.isOpen = true;
        document.body.style.overflow = 'hidden';
    },
    close() {
        this.isOpen = false;
        document.body.style.overflow = 'auto';
    }
}));

Alpine.data('table', () => ({
    sortBy: null,
    sortDirection: 'asc',
    search: '',
    sort(column) {
        if (this.sortBy === column) {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortBy = column;
            this.sortDirection = 'asc';
        }
    }
}));

Alpine.data('form', () => ({
    loading: false,
    async submit() {
        this.loading = true;
        // Form submission logic will be handled by Laravel
        setTimeout(() => {
            this.loading = false;
        }, 2000);
    }
}));

// Utility Functions
window.utils = {
    // Format currency
    formatCurrency(amount) {
        return new Intl.NumberFormat('fr-FR', {
            style: 'currency',
            currency: 'XOF'
        }).format(amount);
    },
    
    // Format date
    formatDate(date) {
        return new Intl.DateTimeFormat('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    },
    
    // Show loading spinner
    showLoading() {
        const spinner = document.createElement('div');
        spinner.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';
        spinner.innerHTML = '<div class="loading-spinner"></div>';
        document.body.appendChild(spinner);
        return spinner;
    },
    
    // Hide loading spinner
    hideLoading(spinner) {
        if (spinner) {
            spinner.remove();
        }
    },
    
    // Copy to clipboard
    async copyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            this.showNotification('Copié dans le presse-papiers', 'success');
        } catch (err) {
            this.showNotification('Erreur lors de la copie', 'error');
        }
    },
    
    // Show notification
    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${type === 'success' ? '✅' : type === 'error' ? '❌' : '⚠️'}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
};

// Initialize Alpine
Alpine.start();

// Global event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Confirm delete actions
    document.querySelectorAll('[data-confirm]').forEach(element => {
        element.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm') || 'Êtes-vous sûr de vouloir continuer ?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
});

// Export for use in other modules
export default Alpine;
