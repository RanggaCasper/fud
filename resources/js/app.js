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