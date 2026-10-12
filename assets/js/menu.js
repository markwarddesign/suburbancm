document.addEventListener('DOMContentLoaded', function () {
    // --- Mega Menu Logic ---
    const menuConfigs = [
        {
            buttonId: 'projects-menu-button',
            menuId: 'projects-mega-menu',
            iconId: 'projects-menu-icon',
        },
        {
            buttonId: 'services-menu-button',
            menuId: 'services-mega-menu',
            iconId: 'services-menu-icon',
        },
    ];

    const allMenus = menuConfigs.map(config => document.getElementById(config.menuId));
    const allButtons = menuConfigs.map(config => document.querySelector(`[data-target="#${config.menuId}"]`));
    const allIcons = menuConfigs.map(config => document.querySelector(`#${config.iconId}`));

    // Ensure all menus are hidden on page load
    allMenus.forEach(menu => {
        if (menu) {
            menu.classList.add('hidden');
        }
    });

    // Function to close all mega menus
    const closeAllMegaMenus = () => {
        allMenus.forEach((menu, index) => {
            if (menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                const icon = allIcons[index];
                if (icon) icon.classList.remove('rotate-180');
            }
        });
    };

    // Function to open a specific mega menu
    const openMegaMenu = (menu, icon) => {
        closeAllMegaMenus();
        if (menu) {
            menu.classList.remove('hidden');
        }
        if (icon) {
            icon.classList.add('rotate-180');
        }
    };

    // Add hover listeners for mega menus
    menuConfigs.forEach((config, index) => {
        const button = document.querySelector(`[data-target="#${config.menuId}"]`);
        const menu = document.getElementById(config.menuId);
        const icon = document.querySelector(`#${config.iconId}`);

        if (button && menu) {
            // Show menu on hover
            button.addEventListener('mouseenter', () => openMegaMenu(menu, icon));
            menu.addEventListener('mouseenter', () => openMegaMenu(menu, icon));

            // Hide menu when mouse leaves both the button and the menu
            button.addEventListener('mouseleave', (event) => {
                if (!menu.contains(event.relatedTarget)) {
                    closeAllMegaMenus();
                }
            });
            menu.addEventListener('mouseleave', (event) => {
                if (!button.contains(event.relatedTarget)) {
                    closeAllMegaMenus();
                }
            });
        }
    });

    // Global listener to close menus when clicking outside
    document.addEventListener('click', (event) => {
        const isOutside = allButtons.every(button => !button.contains(event.target));
        if (isOutside) {
            closeAllMegaMenus();
        }
    });

    // Close menus on Escape key press
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeAllMegaMenus();
        }
    });

    // --- Mobile Menu Toggle Logic ---
    const mobileMenuButton = document.getElementById('mobile-menu-open-button');
    const mobileMenuCloseButton = document.getElementById('mobile-menu-close-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        // Open mobile menu
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });

        // Close mobile menu
        if (mobileMenuCloseButton) {
            mobileMenuCloseButton.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = ''; // Restore background scrolling
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', (event) => {
            if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = ''; // Restore background scrolling
            }
        });

        // Close menu on Escape key press
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = ''; // Restore background scrolling
            }
        });
    }
});

// Regular Dropdown 
document.addEventListener('DOMContentLoaded', function () {
    // Mobile menu open/close
    const openBtn = document.getElementById('mobile-menu-open-button');
    const closeBtn = document.getElementById('mobile-menu-close-button');
    const mobileMenu = document.getElementById('mobile-menu');
    if (openBtn && closeBtn && mobileMenu) {
        openBtn.addEventListener('click', () => mobileMenu.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    }

    // Dropdown toggles for mobile
    document.querySelectorAll('#mobile-menu .menu-item-has-children > a').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            if (submenu && submenu.classList.contains('sub-menu')) {
                submenu.classList.toggle('hidden');
            }
        });
    });
});