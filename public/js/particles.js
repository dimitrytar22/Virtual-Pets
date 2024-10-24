document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('particleCanvas');
    const ctx = canvas.getContext('2d');
    const header = document.querySelector('header'); // Получаем элемент header

    // Установка размеров canvas
    function resizeCanvas() {
        canvas.width = header.offsetWidth;
        canvas.height = header.offsetHeight;
    }
    resizeCanvas(); // Вызов для начальной установки
    window.addEventListener('resize', resizeCanvas); // Корректировка размера при изменении окна

    let particlesArray = [];

    // Класс частицы
    class Particle {
        constructor(x, y, size, speedX, speedY) {
            this.x = x;
            this.y = y;
            this.size = size;
            this.speedX = speedX;
            this.speedY = speedY;
            this.alpha = 1; // Прозрачность частицы
        }
        update() {
            this.x += this.speedX;
            this.y += this.speedY;
            this.alpha -= 0.02; // Частицы постепенно исчезают
        }
        draw() {
            ctx.fillStyle = `rgba(255, 255, 255, ${this.alpha})`; // Цвет частицы с учётом прозрачности
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.closePath();
            ctx.fill();
        }
    }

    // Функция добавления частиц
    function addParticle(x, y) {
        const size = Math.random() * 3 + 1; // Размер частицы
        const speedX = (Math.random() - 0.5) * 2; // Скорость по оси X
        const speedY = (Math.random() - 0.5) * 2; // Скорость по оси Y
        particlesArray.push(new Particle(x, y, size, speedX, speedY));
    }

    // Функция обновления и отрисовки частиц
    function animateParticles() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        particlesArray = particlesArray.filter(particle => particle.alpha > 0); // Удаляем частицы, которые исчезли
        particlesArray.forEach(particle => {
            particle.update();
            particle.draw();
        });
        requestAnimationFrame(animateParticles);
    }

    // Обработка движения мыши
    header.addEventListener('mousemove', function (event) {
        const rect = header.getBoundingClientRect(); // Позиция header относительно окна
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        for (let i = 0; i < 5; i++) { // Добавляем несколько частиц при каждом движении мыши
            addParticle(x, y);
        }
    });

    animateParticles(); // Запуск анимации
});
