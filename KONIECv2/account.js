document.addEventListener("DOMContentLoaded", () => {
    const avatar = document.getElementById('avatar');
    const avatarPopup = document.getElementById('avatar-popup');
    const avatarOptions = document.querySelectorAll('.avatar-option');

    // Otwórz okienko z wyborem awatara
    avatar.addEventListener('click', () => {
        avatarPopup.classList.toggle('hidden');
    });

    // Wybierz awatar
    avatarOptions.forEach(option => {
        option.addEventListener('click', () => {
            const selectedAvatar = option.getAttribute('data-avatar');

            // Zapisz wybrany awatar w sesji (przez AJAX)
            fetch('update_avatar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ avatar: selectedAvatar })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Zaktualizuj wyświetlany awatar
                    avatar.querySelector('img').src = selectedAvatar;
                    avatarPopup.classList.add('hidden');
                } else {
                    alert('Wystąpił błąd podczas zapisywania awatara.');
                }
            })
            .catch(error => {
                console.error('Błąd:', error);
            });
        });
    });
});