document.addEventListener('DOMContentLoaded', function () {
    const themes = ['day', 'midnight', 'night'];
    const themeIcons = {
        day: 'day.svg',
        midnight: 'midnight.svg',
        night: 'night.svg'
    };

    let currentThemeIndex = 0;

    const body = document.body;
    const slider = document.getElementById('slider');
    const switcherContainer = document.getElementById('switcherContainer');
    const themeSwitcherIcon = document.getElementById('themeSwitcherIcon');
    const themeSwitcherToggle = document.getElementById('themeSwitcherToggle');
    const themeIcon = document.getElementById('themeIcon');

    function updateTheme() {
        const theme = themes[currentThemeIndex];
        body.setAttribute('data-theme', theme);
        updateSliderIcon(theme);
        updateSliderPosition(currentThemeIndex);
    }

    function updateSliderIcon(theme) {
        const icon = slider.querySelector('.theme-icon');
        icon.src = themeIcons[theme];
        icon.alt = theme;
        themeIcon.src = themeIcons[theme];
    }

    function updateSliderPosition(index) {
        const toggleHeight = themeSwitcherToggle.offsetHeight;
        const sectionHeight = toggleHeight / themes.length;
        slider.style.top = `${index * sectionHeight}px`;
    }

    
    themeSwitcherToggle.addEventListener('click', function () {
        slider.classList.add('slider-jump');

        currentThemeIndex = (currentThemeIndex + 1) % themes.length;

        setTimeout(() => {
            updateTheme();
        }, 200);

        setTimeout(() => {
            slider.classList.remove('slider-jump');
        }, 600);
    });

    
    themeSwitcherIcon.addEventListener('click', function () {
        switcherContainer.classList.toggle('expanded');
        switcherContainer.classList.toggle('collapsed');
    });

    updateTheme();
 
});
