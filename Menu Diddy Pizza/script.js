function selectPizza(name, image) {
    const pizzaDisplay = document.getElementById('pizza-display');
    const orderList = document.getElementById('order-list');

    // Zmień obrazek pizzy
    pizzaDisplay.src = image;

    // Dodaj pizzę do zamówienia
    const listItem = document.createElement('li');
    listItem.textContent = name;
    orderList.appendChild(listItem);
    
    
}

function toggleVolume() {
    const audio = document.getElementById('background-music');
    const volumeIcon = document.getElementById('volume-icon');

    if (audio.muted) {
        audio.muted = false; // Jeśli muzyka jest wyciszona, włącz ją
        volumeIcon.src = 'volume-icon.png'; // Zmień ikonę na głośnik
    } else {
        audio.muted = true; // Jeśli muzyka gra, wycisz ją
        volumeIcon.src = 'volume-none.png'; // Zmień ikonę na ikonę wyciszenia
    }
}