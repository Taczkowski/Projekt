// script.js
const button = document.getElementById('startButton');
const boxes = document.querySelectorAll('.box');

button.addEventListener('click', () => {
    boxes.forEach((box) => {
        // Etap 1: Wpadają na środek (lekko obniżone o 300px)
        box.style.transform = 'translate(calc(48.5vw - 900px), calc(50vh - 900px + 300px))';

        // Etap 2: Po 1 sekundzie wracają poza ekran
        setTimeout(() => {
            const className = box.className.split(' ')[1];
            switch (className) {
                case 'lefttop':
                    box.style.transform = 'translate(-150vw, -150vh)';
                    break;
                case 'left':
                    box.style.transform = 'translate(-150vw, 50%)';
                    break;
                case 'leftbottom':
                    box.style.transform = 'translate(-150vw, 150vh)';
                    break;
                case 'righttop':
                    box.style.transform = 'translate(150vw, -150vh)';
                    break;
                case 'right':
                    box.style.transform = 'translate(150vw, 50%)';
                    break;
                case 'rightbottom':
                    box.style.transform = 'translate(150vw, 150vh)';
                    break;
            }
        }, 1000); // Po 1 sekundzie
    });
});
