document.addEventListener('DOMContentLoaded', function() {
    // Создаем кнопку
    const backToTop = document.createElement('button');
    backToTop.className = 'back-to-top';
    backToTop.setAttribute('aria-label', 'Прокрутить вверх');
    document.body.appendChild(backToTop);

    // Функция прокрутки вверх
    const scrollToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };

    // Обработчик клика
    backToTop.addEventListener('click', scrollToTop);

    // Показываем/скрываем кнопку при прокрутке
    const toggleBackToTop = () => {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    };

    // Слушаем событие прокрутки
    window.addEventListener('scroll', toggleBackToTop, { passive: true });
}); 