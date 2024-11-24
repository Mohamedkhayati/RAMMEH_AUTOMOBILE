document.addEventListener('DOMContentLoaded', (event) => {
    const carList = document.querySelectorAll('.car');

    carList.forEach(car => {
        car.style.opacity = 0;
        car.style.transition = 'opacity 0.5s ease-in-out, transform 0.5s ease-in-out';

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                } else {
                    entry.target.style.opacity = 0;
                    entry.target.style.transform = 'translateY(50px)';
                }
            });
        });

        observer.observe(car);
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const carCards = document.querySelectorAll('.car-card');
    carCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.3}s`;
        card.classList.add('fade-in');
    });
});


let isAdmin = true; 

window.onload = function() {
    if (isAdmin) {
        document.getElementById('addCarLink').style.display = 'inline';
    }
}
document.addEventListener('DOMContentLoaded', () => {
    const carCards = document.querySelectorAll('.car-card');
    carCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
        }, index * 200); 
    });
});
