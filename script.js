// Fonction pour passer à l'image suivante
function nextImage(button) {
    const carousel = button.closest('.vehicle-carousel');
    const images = carousel.querySelectorAll('.vehicle-image');
    let activeIndex = Array.from(images).findIndex(image => image.classList.contains('active'));

    images[activeIndex].classList.remove('active');

    // Si l'image active est la dernière, revenir à la première
    activeIndex = (activeIndex + 1) % images.length;

    images[activeIndex].classList.add('active');
}

// Fonction pour passer à l'image précédente
function previousImage(button) {
    const carousel = button.closest('.vehicle-carousel');
    const images = carousel.querySelectorAll('.vehicle-image');
    let activeIndex = Array.from(images).findIndex(image => image.classList.contains('active'));

    images[activeIndex].classList.remove('active');

    // Si l'image active est la première, revenir à la dernière
    activeIndex = (activeIndex - 1 + images.length) % images.length;

    images[activeIndex].classList.add('active');
}

// Fonction pour démarrer le carrousel automatique
function startCarousel() {
    const carousels = document.querySelectorAll('.vehicle-carousel');

    carousels.forEach(carousel => {
        setInterval(() => {
            nextImage(carousel.querySelector('.next'));
        }, 3000); // Change l'image toutes les 3 secondes
    });
}

// Démarre le carrousel quand la page est prête
document.addEventListener('DOMContentLoaded', startCarousel);

