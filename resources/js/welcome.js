import { Carousel } from 'flowbite';

document.addEventListener('DOMContentLoaded', () => {
    const carouselElement = document.getElementById('animation-carousel');

    if (!carouselElement) return;

    const options = {
        defaultPosition: 0,
        interval: 10000,
    };

    const carousel = new Carousel(carouselElement, options);
    console.log('Carousel initialized:', carousel);
});
