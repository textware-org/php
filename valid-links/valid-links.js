(function() {
    const PHP_VALIDATOR_URL = 'valid-links/index.php'; // Zmień na właściwy URL

    function validateLinks() {
        const links = document.getElementsByTagName('a');

        Array.from(links).forEach(link => {
            const url = encodeURIComponent(link.href);
            fetch(`${PHP_VALIDATOR_URL}?q=${url}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'valid') {
                        link.style.fontWeight = 'bold';
                    } else {
                        link.style.textDecoration = 'line-through';
                        link.style.opacity = '0.5';
                    }
                })
                .catch(() => {
                    link.style.textDecoration = 'line-through';
                    link.style.opacity = '0.5';
                });
        });
    }

    // Dodaj style CSS
    const style = document.createElement('style');
    style.textContent = `
        a { transition: all 0.3s ease; }
    `;
    document.head.appendChild(style);

    // Uruchom walidację po załadowaniu strony
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', validateLinks);
    } else {
        validateLinks();
    }

    // Eksportuj funkcję do globalnego obiektu window
    window.validateLinks = validateLinks;
})();
