<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to make logo clickable
    function makeLogoClickable() {
        // Find the brand logo/name element
        const brandElements = document.querySelectorAll('a[href*="/admin"], a[href*="/company"], a[href*="/user"]');
        
        // Also try to find by common Filament brand selectors
        const logoSelectors = [
            '.fi-logo',
            '.fi-sidebar-header a',
            '.fi-topbar-brand a',
            'a[class*="brand"]',
            'header a img',
            'nav a img'
        ];
        
        logoSelectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                element.style.cursor = 'pointer';
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = '/';
                });
            });
        });
        
        // Try to find the brand text/logo in sidebar
        const sidebarBrand = document.querySelector('.fi-sidebar-header');
        if (sidebarBrand) {
            const brandLink = sidebarBrand.querySelector('a');
            if (brandLink) {
                brandLink.href = '/';
                brandLink.style.cursor = 'pointer';
            }
        }
        
        // Try to find brand logo image
        const brandImages = document.querySelectorAll('img[src*="logo"]');
        brandImages.forEach(img => {
            const parentLink = img.closest('a');
            if (parentLink) {
                parentLink.href = '/';
                parentLink.style.cursor = 'pointer';
            } else {
                img.style.cursor = 'pointer';
                img.addEventListener('click', function() {
                    window.location.href = '/';
                });
            }
        });
        
        // Find brand text and make clickable
        const brandTexts = document.querySelectorAll('*');
        brandTexts.forEach(element => {
            if (element.textContent && element.textContent.includes('Loker Oku Timur')) {
                const parentLink = element.closest('a');
                if (parentLink) {
                    parentLink.href = '/';
                    parentLink.style.cursor = 'pointer';
                } else if (element.tagName !== 'TITLE' && element.tagName !== 'SCRIPT') {
                    element.style.cursor = 'pointer';
                    element.addEventListener('click', function() {
                        window.location.href = '/';
                    });
                }
            }
        });
    }
    
    // Run the function
    makeLogoClickable();
    
    // Re-run after Livewire updates (for Filament's dynamic content)
    document.addEventListener('livewire:navigated', makeLogoClickable);
    document.addEventListener('livewire:load', makeLogoClickable);
    
    // Re-run after a short delay to catch dynamically loaded content
    setTimeout(makeLogoClickable, 1000);
});
</script>

<style>
/* Additional CSS to ensure logo is clickable */
.fi-sidebar-header a,
.fi-topbar-brand a,
a[class*="brand"],
img[src*="logo"] {
    cursor: pointer !important;
    transition: opacity 0.2s ease;
}

.fi-sidebar-header a:hover,
.fi-topbar-brand a:hover,
a[class*="brand"]:hover,
img[src*="logo"]:hover {
    opacity: 0.8;
}
</style>