<div x-data="auroraToast()">
    <template x-for="(toast, index) in toasts" :key="toast.id">
        <div x-show="toast.show"
             x-transition:enter="aurora-toast-enter"
             x-transition:enter-start="aurora-toast-enter-start"
             x-transition:enter-end="aurora-toast-enter-end"
             x-transition:leave="aurora-toast-leave"
             x-transition:leave-start="aurora-toast-leave-start"
             x-transition:leave-end="aurora-toast-leave-end"
             class="aurora-toast"
             :class="'aurora-toast-' + toast.type"
             role="alert">
            <div class="aurora-toast-content">
                <div class="aurora-toast-icon-wrap">
                    <svg x-show="toast.type === 'success'" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <svg x-show="toast.type === 'error'" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    <svg x-show="toast.type === 'warning'" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <svg x-show="toast.type === 'info'" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                </div>
                <div class="aurora-toast-text">
                    <p class="aurora-toast-message" x-text="toast.message"></p>
                </div>
                <button class="aurora-toast-close" @click="dismiss(toast.id)" aria-label="Fermer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="aurora-toast-progress" :style="{ animationDuration: toast.duration + 'ms' }"></div>
        </div>
    </template>
</div>

@once
<script>
    function auroraToast() {
        return {
            toasts: [],
            init() {
                @if(session()->has('message'))
                this.addToast('success', '{{ session('message') }}');
                @endif
                const types = [
                    { key: 'success', type: 'success' },
                    { key: 'error', type: 'error' },
                    { key: 'warning', type: 'warning' },
                    { key: 'status', type: 'info' },
                ];
                types.forEach(t => {
                    @if(session()->has(t.key))
                    this.addToast(t.type, '{{ session(t.key) }}');
                    @endif
                });
            },
            addToast(type, message) {
                if (this.toasts.some(t => t.message === message && t.type === type)) return;
                const id = Date.now() + Math.random();
                const duration = 5000;
                this.toasts.push({ id, type, message, show: true, duration });
                setTimeout(() => this.dismiss(id), duration);
            },
            dismiss(id) {
                const toast = this.toasts.find(t => t.id === id);
                if (toast) toast.show = false;
                setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 400);
            }
        }
    }
</script>
@endonce
