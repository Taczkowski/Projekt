document.addEventListener("DOMContentLoaded", () => {
    // Konfiguracja obrazków
    const initialImages = {
        left: { target: { left: "0%", top: "50%", transform: "translate(-100%, -50%) scale(0.8)", opacity: 0 } },
        right: { target: { left: "100%", top: "50%", transform: "translate(0%, -50%) scale(0.8)", opacity: 0 } },
        leftbottom: { target: { left: "0%", top: "100%", transform: "translate(-100%, 0%) scale(0.6)", opacity: 0 } },
        lefttop: { target: { left: "0%", top: "0%", transform: "translate(-100%, -100%) scale(0.6)", opacity: 0 } },
        rightbottom: { target: { left: "100%", top: "100%", transform: "translate(0%, 0%) scale(0.6)", opacity: 0 } },
        righttop: { target: { left: "100%", top: "0%", transform: "translate(0%, -100%) scale(0.6)", opacity: 0 } }
    };

    // Inicjalizacja animacji
    function initAnimation() {
        const container = document.querySelector('.initial-animation-container');
        if (!container) return;

        // Losowe nakładanie obrazków
        container.querySelectorAll('img').forEach(img => {
            img.style.zIndex = Math.floor(Math.random() * 100);
        });

        // Rozpocznij animację po krótkim opóźnieniu
        setTimeout(() => {
            container.classList.add('animate-out');
            
            // Usuń kontener po zakończeniu animacji
            setTimeout(() => {
                container.remove();
            }, 1500); // Dopasuj do czasu trwania animacji
        }, 100);
    }

    // Uruchom animację
    initAnimation();
});