import "./bootstrap";
import "./action.js";
import "./swiper.init.js";
import "./datatable.js";
import "./AOS.js";
import "./waypoints.js";
import "flowbite";

// Lazy Loading
const images = document.querySelectorAll(".lazyload");

const lazyLoad = (entries, observer) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.getAttribute("data-src");

            img.classList.remove("lazyload");
            img.classList.add("loaded");

            img.onload = () => {
                img.classList.remove("skeleton");
                img.classList.add("loaded");
            };

            observer.unobserve(img);
        }
    });
};

const observer = new IntersectionObserver(lazyLoad, { threshold: 0.1 });

images.forEach((image) => {
    observer.observe(image);
});
// End Lazy Loading

// Sidebar Menu
document.addEventListener("DOMContentLoaded", () => {
    const navbarMenu = document.getElementById("navbarMenu");
    const sidebarMenu = document.getElementById("sidebarMenu");
    const panelSidebar = document.getElementById("panelSidebar");

    if (navbarMenu && sidebarMenu) {
        sidebarMenu.innerHTML = panelSidebar
            ? navbarMenu.innerHTML + panelSidebar.innerHTML
            : navbarMenu.innerHTML;
    }

    const sidebarUl = sidebarMenu?.querySelector("ul");
    if (sidebarUl) {
        sidebarUl.classList.add("flex-col", "space-y-2");
    }

    sidebarMenu?.querySelectorAll("li").forEach((item) => {
        const text = item.textContent?.trim().toLowerCase();
        if (text === 'settings' || text.includes('settings')) {
            item.remove();
        }

        if (!item.classList.contains("uppercase")) {
            item.classList.add("flex-col");
        }
    });

    sidebarMenu?.querySelectorAll("a").forEach((item) => {
        const text = item.textContent?.trim().toLowerCase();

        if (text === 'logout' || text.includes('logout')) {
            item.remove();
        } 
    });

    sidebarMenu?.querySelectorAll("a, button").forEach((el) => {
        el.className = "";
        el.classList.add(
            "flex",
            "items-center",
            "font-semibold",
            "text-sm",
            "px-4",
            "py-2.5",
            "rounded-lg",
            "border-s-4",
            "border-transparent",
            "hover:border-primary",
            "hover:bg-dark/10",
            "focus:!text-primary",
            "focus:border-primary",
            "focus:bg-dark/10",
            "hover:!text-primary",
            "gap-2"
        );

        const href = el.getAttribute("href");
        if (href && window.location.pathname === new URL(href, window.location.origin).pathname) {
            el.classList.add("!border-primary", "bg-primary/10", "!text-primary");
        }
    });

    const sidebarMultiMenu = sidebarMenu?.querySelector("button");
    if (sidebarMultiMenu) {
        sidebarMultiMenu.removeAttribute("data-dropdown-placement");
        sidebarMultiMenu.removeAttribute("data-dropdown-toggle");
        sidebarMultiMenu.setAttribute("aria-controls", "dropdown-example");
        sidebarMultiMenu.setAttribute(
            "data-collapse-toggle",
            "dropdown-example"
        );
        sidebarMultiMenu.classList.add("w-full");
    }

    const dropdown = sidebarMenu?.querySelector("#dropdown");
    if (dropdown) {
        dropdown.id = "dropdown-example";
        dropdown.classList.remove(
            "z-10",
            "bg-white",
            "divide-y",
            "divide-gray-100",
            "rounded-lg",
            "shadow-sm",
            "w-44",
            "dark:bg-gray-700"
        );
        dropdown.querySelectorAll("a").forEach((item) => {
            item.classList.remove(
                "block",
                "px-4",
                "py-2",
                "hover:bg-gray-100",
                "dark:hover:bg-gray-600",
                "dark:hover:text-white"
            );
            item.classList.add(
                "flex",
                "items-center",
                "p-2",
                "text-dark",
                "w-full",
                "transition",
                "duration-75",
                "rounded-lg",
                "pl-8.5",
                "group",
                "hover:text-primary",
                "dark:text-white",
                "hover:bg-primary/10",
                "font-medium"
            );
        });
    }
});
// End Sidebar Menu

// Password Toggle
const togglePasswordButtons = document.querySelectorAll(".toggle-password");

if (togglePasswordButtons.length > 0) {
    togglePasswordButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const passwordField =
                this.closest("div").querySelector(".password-field");
            const eyeIcon = this.querySelector(".eye-icon");

            const isPasswordVisible = passwordField.type === "password";
            console.log(isPasswordVisible);

            passwordField.type = isPasswordVisible ? "text" : "password";

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
document.addEventListener("click", function (event) {
    const modalTargetEl = event.target.closest("[data-modal-target]");
    const modalHideEl = event.target.closest("[data-modal-hide]");

    if (modalTargetEl) {
        const modalId = modalTargetEl.getAttribute("data-modal-target");
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            new Modal(modalElement).show();
        }
    }

    if (modalHideEl) {
        const modalId = modalHideEl.getAttribute("data-modal-hide");
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            new Modal(modalElement).hide();
        }
    }
});

// Search Modal
document.addEventListener("keydown", function (event) {
    if (event.ctrlKey && event.key === "k") {
        event.preventDefault();

        const searchModal = document.getElementById("searchModal");
        const modal = new Modal(searchModal);

        // Check if the modal is currently visible
        if (searchModal.classList.contains("hidden")) {
            modal.show();
            const searchInput = document.getElementById("simple-search");
            searchInput.focus();
        } else {
            modal.hide();
        }
    }
});
