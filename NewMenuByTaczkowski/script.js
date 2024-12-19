document.addEventListener("DOMContentLoaded", () => {
    const snowflakeContainer = document.querySelector(".snowflakes");
    const cartContainer = document.querySelector(".cart");
    const cartPopup = document.querySelector(".cart-popup");
    const cartCount = document.getElementById("cart-count");

    // Lista składników pizzy
    const ingredients = [
        './assets/Ingredients_Pepperoni.png',
        './assets/Ingredients_Bell-Pepper.png',
        './assets/Ingredients_Corn.png',
        './assets/Ingredients_Garlic.png',
        './assets/Ingredients_Jalapeno.png',
        './assets/Ingredients_Mushroom.png',
        './assets/Ingredients_Olive.png',
        './assets/Ingredients_Onion.png',
        './assets/Ingredients_Sliced_Tomato.png',
        './assets/Ingredients_Basil.png',
        './assets/Ingredients_Sliced_SHIT.png',
        './assets/Ingredients_Sliced_Chicken.png',
        './assets/Ingredients_Shrimp.png',
        './assets/Ingredients_Ham.png',
        './assets/Ingredients_Beacon.png',
        './assets/Ingredients_Anchovy.png'
    ];

    const pizzas = [
        { name: "Margharitta", image: './assets/Pizza.png' },
        { name: "Capriciossa", image: './assets/PizzaCapriciossa.png' },
        { name: "Szefowska", image: './assets/PizzaChefMan.png' },
        { name: "WłoskiKurczak", image: './assets/PizzaChicken.png' },
        { name: "Ostra", image: './assets/PizzaHot.png' },
        { name: "Zamówienie grozi kastracją", image: './assets/PizzaSHIT.png' },
        { name: "Męska", image: './assets/PizzaTrueMan.png' }
    ];

    let cart = []; // Koszyk na pizze
    let snowflakeCount = 0;
    const maxSnowflakes = 10; // Maksymalna liczba składników na ekranie

    // Funkcja tworząca spadający składnik
    function createSnowflake() {
        if (snowflakeCount < maxSnowflakes) {
            const snowflake = document.createElement("div");
            snowflake.classList.add("snowflake");

            // Wybieranie losowego składnika pizzy
            const randomIngredient = ingredients[Math.floor(Math.random() * ingredients.length)];
            const img = document.createElement("img");
            img.src = randomIngredient;

            // Ustawienia dla każdego składnika
            snowflake.style.left = Math.random() * 100 + "vw";
            snowflake.style.animationDuration = Math.random() * 3 + 5 + "s"; // Losowa prędkość
            snowflake.style.opacity = Math.random() + 0.3; // Losowa przezroczystość

            // Dodanie do DOM
            snowflake.appendChild(img);
            snowflakeContainer.appendChild(snowflake);

            snowflakeCount++;

            // Usunięcie elementu po zakończeniu animacji
            snowflake.addEventListener("animationend", () => {
                snowflake.remove();
                snowflakeCount--;
            });
        }
    }

    // Generowanie składników co 2 sekundy
    setInterval(createSnowflake, 2000);

    // Funkcja zmieniająca obrazek w lewym divie
    function changeImage(imagePath) {
        const imageBox = document.getElementById('pizza-image');

        // Usuń poprzednią animację, jeśli istnieje
        imageBox.classList.remove('pizza-spin');

        // Małe opóźnienie, aby ponowne uruchomienie animacji działało
        setTimeout(() => {
            imageBox.classList.add('pizza-spin');

            // Zmiana obrazu trochę przed pojawianiem się nowego (około 45% animacji)
            setTimeout(() => {
                imageBox.src = imagePath;
            }, 450); // Czas zmiany obrazu
        }, 50);
    }

    // Funkcja obsługująca dodawanie pizzy do koszyka
    function addToCart(pizzaName) {
        // Sprawdzamy, czy pizza już istnieje w koszyku
        const pizzaIndex = cart.findIndex(pizza => pizza.name === pizzaName);

        if (pizzaIndex === -1) {
            // Dodajemy pizzę, jeśli jej nie ma
            cart.push({ name: pizzaName, count: 1 });
        } else {
            // Zwiększamy liczbę, jeśli pizza już jest
            cart[pizzaIndex].count++;
        }

        updateCartDisplay();
    }

    // Funkcja aktualizująca wyświetlanie koszyka
    function updateCartDisplay() {
        const cartCount = document.getElementById('cart-count');
        const cartList = document.createElement("ul");  // Tworzymy nową listę za każdym razem
        cartPopup.innerHTML = ''; // Wyczyść poprzednią zawartość koszyka

        // Dodaj tekst "Twój koszyk" na początku
        const cartTitle = document.createElement("h3");
        cartTitle.textContent = "Twój koszyk:";
        cartPopup.appendChild(cartTitle);  // Dodajemy tytuł koszyka

        // Zaktualizowanie liczby pizzy w koszyku
        cartCount.textContent = cart.reduce((acc, pizza) => acc + pizza.count, 0);

        if (cart.length === 0) {
            cartPopup.innerHTML = "<p>Twój koszyk jest pusty.</p>";
        } else {
            cart.forEach(pizza => {
                const pizzaItem = document.createElement("li");
                pizzaItem.textContent = `${pizza.name} x ${pizza.count}`;
                cartList.appendChild(pizzaItem);
            });
            cartPopup.appendChild(cartList);  // Dodajemy tylko jedną listę
        }

        // Dodaj przycisk "Zamknij" zawsze na końcu
        const closeCartButton = document.createElement("button");
        closeCartButton.id = "close-cart";
        closeCartButton.textContent = "Zamknij";
        closeCartButton.style.backgroundColor = "#d77f00";
        closeCartButton.style.color = "white";
        closeCartButton.style.padding = "10px";
        closeCartButton.style.border = "none";
        closeCartButton.style.cursor = "pointer";
        closeCartButton.style.borderRadius = "5px";
        closeCartButton.style.marginBottom = "10px";
        closeCartButton.addEventListener("click", closeCart);
        cartPopup.appendChild(closeCartButton);
    }

    // Funkcja rozwijająca koszyk
    function toggleCart() {
        cartPopup.classList.toggle("visible");
    }

    // Funkcja zamykająca koszyk
    function closeCart() {
        cartPopup.classList.remove("visible");
    }

    // Dodanie obsługi kliknięcia w koszyk, aby pokazać popup
    cartContainer.addEventListener("click", toggleCart);

    // Udostępnienie funkcji dla przycisków
    window.changeImage = changeImage;
    window.addToCart = addToCart;
});
