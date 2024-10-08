document.addEventListener('DOMContentLoaded', function () {
    const textareas = document.querySelectorAll('textarea');

    textareas.forEach(function (textarea) {
        // Funkcja do dostosowania wysokości
        function adjustHeight() {
            const MAX_HEIGHT = 700; // Set the maximum height in pixels
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, MAX_HEIGHT) + 'px';
        }

        // Dostosuj wysokość po załadowaniu strony
        adjustHeight();

        // Dostosuj wysokość podczas wpisywania
        textarea.addEventListener('input', adjustHeight);

        // Opcjonalnie: dostosuj wysokość przy zmianie rozmiaru okna
        window.addEventListener('resize', adjustHeight);
    });
});
