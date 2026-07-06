/**
 * Initialize intl-tel-input for login page
 */
let loginIti = null;

function initLoginPhone() {
    const input = document.querySelector("#mobile");
    if (!input) return;

    // Destroy previous instance properly
    if (loginIti) {
        try {
            loginIti.destroy();
        } catch (e) {
            console.warn('Error destroying intl-tel-input:', e);
        }
        loginIti = null;
    }

    // Also check if intlTelInput has a getInstance method (newer versions)
    if (typeof window.intlTelInput.getInstance === 'function') {
        const existingInstance = window.intlTelInput.getInstance(input);
        if (existingInstance) {
            try {
                existingInstance.destroy();
            } catch (e) {
                console.warn('Error destroying existing instance:', e);
            }
        }
    }

    // Remove old wrapper if exists
    const parentWrapper = input.parentElement;
    if (parentWrapper && parentWrapper.classList.contains("iti")) {
        const inputParent = input.closest(".form-group");
        if (inputParent && parentWrapper.parentElement === inputParent) {
            parentWrapper.replaceWith(input);
        }
    }

    // Get default country from data attribute or default to 'in'
    const defaultCountry = input.dataset.defaultCountry || 'in';

    // Initialize intl-tel-input
    loginIti = window.intlTelInput(input, {
        initialCountry: defaultCountry,
        separateDialCode: true,
        preferredCountries: [defaultCountry, "in", "us", "gb", "eg"],
        utilsScript: "/vendor/intl-tel-input/js/utils.js"
    });

    // Ensure the container is full width
    const container = input.closest(".iti");
    if (container) {
        container.style.width = "100%";
        input.style.width = "100%";
    }
}

// Ensure intl-tel-input library is loaded before initializing
function ensureLibraryLoaded() {
    if (typeof window.intlTelInput === 'function') {
        initLoginPhone();
    } else {
        // Retry if library not yet loaded
        setTimeout(ensureLibraryLoaded, 100);
    }
}

// Initialize on various events
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', ensureLibraryLoaded);
} else {
    // DOM is already loaded
    ensureLibraryLoaded();
}

document.addEventListener('livewire:navigated', ensureLibraryLoaded);
document.addEventListener('livewire:initialized', ensureLibraryLoaded);
