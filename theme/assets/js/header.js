document.addEventListener('DOMContentLoaded', function() {
    let lastScrollTop = 0;
    const header = document.querySelector('.site-header');
    const scrollThreshold = 100; // Минимальное расстояние прокрутки для срабатывания

    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
        
        // Показываем шапку в самом верху страницы
        if (currentScroll <= 0) {
            header.classList.remove('is-hidden');
            return;
        }
        
        // Если прокрутили больше порога
        if (Math.abs(lastScrollTop - currentScroll) <= scrollThreshold) return;

        // Скрываем при прокрутке вниз, показываем при прокрутке вверх
        if (currentScroll > lastScrollTop) {
            // Прокрутка вниз
            header.classList.add('is-hidden');
        } else {
            // Прокрутка вверх
            header.classList.remove('is-hidden');
        }

        lastScrollTop = currentScroll;
    }, { passive: true });
}); 