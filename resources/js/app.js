import './bootstrap';
import 'flowbite';

// Theme Toggle
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark')
}

let themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
let themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

if (themeToggleDarkIcon && themeToggleLightIcon) {
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }
}

let themeToggleBtn = document.getElementById('theme-toggle');

if(themeToggleBtn) {
    themeToggleBtn.addEventListener('click', function() {
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');
    
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
        
    });
}
// End Theme Toggle

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
    const navLinks = document.querySelectorAll('#main-nav a');
    const sidebarMenu = document.getElementById('sidebar-menu');

    navLinks.forEach(link => {
      const li = document.createElement('li');
      const a = document.createElement('a');

      a.href = link.href;
      a.textContent = link.textContent;
      a.className = 'block py-2 px-4 rounded hover:bg-primary/10 text-dark hover:text-primary transition';

      li.appendChild(a);
      sidebarMenu.appendChild(li);
    });
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