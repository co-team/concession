function nextImage(button) {
    const carousel = button.closest('.vehicle-carousel');
    const images = carousel.querySelectorAll('.vehicle-image');
    let activeIndex = Array.from(images).findIndex(img => img.classList.contains('active'));

    images[activeIndex].classList.remove('active');
    activeIndex = (activeIndex + 1) % images.length;
    images[activeIndex].classList.add('active');
}

function previousImage(button) {
    const carousel = button.closest('.vehicle-carousel');
    const images = carousel.querySelectorAll('.vehicle-image');
    let activeIndex = Array.from(images).findIndex(img => img.classList.contains('active'));

    images[activeIndex].classList.remove('active');
    activeIndex = (activeIndex - 1 + images.length) % images.length;
    images[activeIndex].classList.add('active');
}

// Simulation de la recherche client (à personnaliser selon votre base de données)
function searchClient() {
    const query = document.getElementById('search-client').value;
    alert("Rechercher les informations du client pour: " + query);
}
