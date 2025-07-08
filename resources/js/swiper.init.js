import Swiper from 'swiper';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

// init Swiper:
new Swiper('.bannerSwiper', {
    modules: [Pagination, Autoplay],
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    autoplay: {
        delay: 2000,
        disableOnInteraction: true,
        pauseOnMouseEnter: true,
    },
    loop: true,
    slidesPerView: 1,
    spaceBetween: 30,
});

new Swiper('.reviewSwiper', {
    modules: [Navigation, Pagination, Autoplay],
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    loop: true,
    slidesPerView: 1,
    spaceBetween: 30,
    breakpoints: {
        768: {
            slidesPerView: 3,
        },
    }
});


new Swiper('.mockupSwiper', {
    modules: [Navigation, Pagination, Autoplay],
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
    loop: true,
    slidesPerView: 1,
    spaceBetween: 30,
});

