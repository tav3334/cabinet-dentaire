<!-- Toast Notification System -->
<div x-data="toastNotification()"
     @notify.window="show($event.detail)"
     class="fixed top-4 right-4 z-50 space-y-3"
     style="max-width: 400px;">

    <template x-for="(toast, index) in toasts" :key="toast.id">
        <div x-show="toast.visible"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transform transition ease-in duration-200"
             x-transition:leave-start="translate-x-0 opacity-100"
             x-transition:leave-end="translate-x-full opacity-0"
             :class="{
                 'bg-gradient-to-r from-green-500 to-emerald-600': toast.type === 'success',
                 'bg-gradient-to-r from-red-500 to-rose-600': toast.type === 'error',
                 'bg-gradient-to-r from-blue-500 to-cyan-600': toast.type === 'info',
                 'bg-gradient-to-r from-amber-500 to-orange-600': toast.type === 'warning'
             }"
             class="flex items-center p-4 rounded-xl shadow-2xl text-white backdrop-blur-sm">

            <div class="flex-shrink-0 mr-3">
                <template x-if="toast.type === 'success'">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="bi bi-check-circle-fill text-2xl"></i>
                    </div>
                </template>
                <template x-if="toast.type === 'error'">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="bi bi-exclamation-circle-fill text-2xl"></i>
                    </div>
                </template>
                <template x-if="toast.type === 'info'">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="bi bi-info-circle-fill text-2xl"></i>
                    </div>
                </template>
                <template x-if="toast.type === 'warning'">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle-fill text-2xl"></i>
                    </div>
                </template>
            </div>

            <div class="flex-1">
                <p class="font-semibold" x-text="toast.title"></p>
                <p class="text-sm text-white text-opacity-90" x-text="toast.message"></p>
            </div>

            <button @click="remove(toast.id)"
                    class="flex-shrink-0 ml-3 p-1 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </template>
</div>

<script>
function toastNotification() {
    return {
        toasts: [],
        nextId: 1,

        show(config) {
            const toast = {
                id: this.nextId++,
                type: config.type || 'info',
                title: config.title || this.getDefaultTitle(config.type),
                message: config.message,
                visible: true
            };

            this.toasts.push(toast);

            setTimeout(() => {
                this.remove(toast.id);
            }, config.duration || 5000);
        },

        remove(id) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index > -1) {
                this.toasts[index].visible = false;
                setTimeout(() => {
                    this.toasts.splice(index, 1);
                }, 300);
            }
        },

        getDefaultTitle(type) {
            const titles = {
                'success': 'Succès',
                'error': 'Erreur',
                'info': 'Information',
                'warning': 'Attention'
            };
            return titles[type] || 'Notification';
        }
    }
}

// Helper function to trigger notifications
window.notify = function(message, type = 'info', title = null) {
    window.dispatchEvent(new CustomEvent('notify', {
        detail: { message, type, title }
    }));
};
</script>
