const body = document.body;
const theme = localStorage.getItem('theme') || 'light'; // Default ke light

document.documentElement.setAttribute('data-bs-theme', 'light');
localStorage.setItem('theme', 'light');