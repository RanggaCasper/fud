import './bootstrap';
import './action.js';
import './swiper.init.js';
import './datatable.js';
import './AOS.js';
import './waypoints.js';
import 'flowbite';


// Lazy Loading
const images = document.querySelectorAll('.lazyload');

const lazyLoad = (entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.getAttribute('data-src');

            img.classList.remove('lazyload');
            img.classList.add('loaded');

            img.onload = () => {
                img.classList.remove('skeleton');
                img.classList.add('loaded');
            };

            observer.unobserve(img);
        }
    });
};

const observer = new IntersectionObserver(lazyLoad, { threshold: 0.1 });

images.forEach(image => {
    observer.observe(image);
}); 
// End Lazy Loading

// Sidebar Menu
document.addEventListener('DOMContentLoaded', () => {
    const navbarMenu = document.getElementById('navbarMenu');
    const sidebarMenu = document.getElementById('sidebarMenu');
    sidebarMenu.innerHTML = navbarMenu.innerHTML;

    const sidebarUl = sidebarMenu.querySelector('ul');
    if (sidebarUl) {
        sidebarUl.classList.add('flex-col', 'space-y-2');
    }

    const sidebarLi = sidebarMenu.querySelector('li');
    if (sidebarLi) {
        sidebarMenu.querySelectorAll('li').forEach(item => {
            item.classList.add('flex-col');
        });
    }

    const sidebarMultiMenu = sidebarMenu.querySelector('button');
    if (sidebarMultiMenu) {
        sidebarMultiMenu.removeAttribute('data-dropdown-placement');
        sidebarMultiMenu.removeAttribute('data-dropdown-toggle');

        sidebarMultiMenu.setAttribute('aria-controls', 'dropdown-example');
        sidebarMultiMenu.setAttribute('data-collapse-toggle', 'dropdown-example');
        sidebarMultiMenu.classList.add('w-full')
    }

    const dropdown = sidebarMenu.querySelector('#dropdown');
    if (dropdown) {
        dropdown.id = 'dropdown-example'; 
        dropdown.classList.remove('z-10', 'bg-white', 'divide-y', 'divide-gray-100', 'rounded-lg', 'shadow-sm', 'w-44', 'dark:bg-gray-700');
        
        dropdown.querySelectorAll('a').forEach(item => {
            item.classList.remove('block', 'px-4', 'py-2', 'hover:bg-gray-100', 'dark:hover:bg-gray-600', 'dark:hover:text-white');
            item.classList.add('flex', 'items-center', 'p-2', 'text-dark', 'w-full', 'transition', 'duration-75', 'rounded-lg', 'pl-8.5', 'group', 'hover:text-primary', 'dark:text-white', 'hover:bg-primary/10', 'font-medium');
        });
    }
});
// End Sidebar Menu

// Password Toggle
const togglePasswordButtons = document.querySelectorAll('.toggle-password');

if (togglePasswordButtons.length > 0) {
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const passwordField = this.closest('div').querySelector('.password-field');
            const eyeIcon = this.querySelector('.eye-icon');
            
            const isPasswordVisible = passwordField.type === 'password';
            console.log(isPasswordVisible)

            passwordField.type = isPasswordVisible ? 'text' : 'password';

            if (isPasswordVisible) {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                `;
            }
        });
    });
}
// End Password Toggle

// Modal
document.addEventListener('click', function(event) {
    if (event.target.hasAttribute('data-modal-target')) {
        const modalId = event.target.getAttribute('data-modal-target');
        const modalElement = document.getElementById(modalId);

        if (modalElement) {
            new Modal(modalElement).show();
        }
    }
});

document.addEventListener('click', function(event) {
    if (event.target.hasAttribute('data-modal-hide')) {
        const modalId = event.target.getAttribute('data-modal-hide');
        const modalElement = document.getElementById(modalId);

        if (modalElement) {
            new Modal(modalElement).hide();
        }
    }
});

// Search
document.getElementById('showSearch').addEventListener('click', function() {
    var searchContainer = document.getElementById('searchContainer');
    searchContainer.classList.remove('hidden');
    
    setTimeout(function() {
        searchContainer.style.width = '100%';
        searchContainer.style.opacity = '1';
    }, 10);
});

document.getElementById('closeSearch').addEventListener('click', function() {
    var searchContainer = document.getElementById('searchContainer');
    
    searchContainer.style.width = '0';
    searchContainer.style.opacity = '0';

    setTimeout(function() {
        searchContainer.classList.add('hidden');
    }, 500);
});

function showSearchResults(query, containerId) {
    const resultsContainer = document.getElementById(containerId);

    if (!query.trim()) {
        resultsContainer.classList.add('hidden');
        return;
    }

    const results = [
        'Restoran A',
        'Restoran B',
        'Restoran C',
        'Restoran D',
    ].filter(result => result.toLowerCase().includes(query.toLowerCase()));

    if (results.length > 0) {
        resultsContainer.innerHTML = results.map(result => `<div class="p-2 hover:bg-gray-100 cursor-pointer">${result}</div>`).join('');
        resultsContainer.classList.remove('hidden');
    } else {
        resultsContainer.classList.add('hidden');
    }
}

document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value;
    showSearchResults(query, 'searchResults');
});

document.getElementById('searchInputMobile').addEventListener('input', function() {
    const query = this.value;
    showSearchResults(query, 'searchResultsMobile');
});
