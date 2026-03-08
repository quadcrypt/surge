// Mobile Navbar Logic
const menuIcon = document.querySelector('#menu-icon');
const navbar = document.querySelector('.navbar');

menuIcon.onclick = () => {
    menuIcon.classList.toggle('bx-x');
    navbar.classList.toggle('active');
};

// Intersection Observer for Straight Reveal
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        }
    });
}, { threshold: 0.15 });

document.querySelectorAll('.reveal-left, .reveal-right, .reveal-bottom').forEach((el) => revealObserver.observe(el));

// Sticky Header & Active Link Tracking
window.onscroll = () => {
    const header = document.querySelector('.header');
    header.classList.toggle('sticky', window.scrollY > 100);

    menuIcon.classList.remove('bx-x');
    navbar.classList.remove('active');

    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('header nav a');
    
    sections.forEach(sec => {
        let top = window.scrollY;
        let offset = sec.offsetTop - 150;
        let height = sec.offsetHeight;
        let id = sec.getAttribute('id');

        if(top >= offset && top < offset + height) {
            navLinks.forEach(links => {
                links.classList.remove('active');
                document.querySelector('header nav a[href*=' + id + ']').classList.add('active');
            });
        }
    });
};

// INTENSIFIED Parallax Scroll Effect
// This tracks the mouse movement and applies a stronger shift to images
document.addEventListener("mousemove", (e) => {
    const parallaxItems = document.querySelectorAll('.parallax-item');
    
    parallaxItems.forEach(item => {
        // Reduced divisor (from 100 to 40) increases the movement intensity
        const moving_value = item.getAttribute("data-value") || 40;
        const x = (window.innerWidth - e.pageX * 2) / moving_value;
        const y = (window.innerHeight - e.pageY * 2) / moving_value;

        item.style.transform = `translateX(${x}px) translateY(${y}px)`;
    });
});