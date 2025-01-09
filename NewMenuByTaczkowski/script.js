document.addEventListener("DOMContentLoaded", () => {
    const cartPopup = document.getElementById("cart-popup");
    const cartItems = document.getElementById("cart-items");
    const cartCount = document.getElementById("cart-count");
    const ingredientButtons = document.getElementById("ingredient-buttons");
    let cart = [];

    // Funkcja otwierania koszyka
    window.toggleCart = () => {
        cartPopup.classList.add("visible");
    };

    // Funkcja zamykania koszyka
    window.closeCart = () => {
        cartPopup.classList.remove("visible");
    };

    // Funkcja dodawania pizzy do koszyka
    function addToCart(pizzaName) {
        const index = cart.findIndex(item => item.name === pizzaName);
        if (index > -1) {
            cart[index].count++;
        } else {
            cart.push({ name: pizzaName, count: 1 });
        }
        updateCartDisplay();
    }

    // Funkcja aktualizacji koszyka
    function updateCartDisplay() {
        cartItems.innerHTML = "";
        cartCount.textContent = cart.reduce((acc, item) => acc + item.count, 0);

        if (cart.length === 0) {
            cartItems.innerHTML = "<p>Twój koszyk jest pusty.</p>";
        } else {
            cart.forEach(item => {
                const li = document.createElement("li");
                li.innerHTML = `
                    ${item.name} x ${item.count}
                    <button onclick="removeFromCart('${item.name}')">Usuń</button>
                `;
                cartItems.appendChild(li);
            });
        }
    }

    // Funkcja usuwania pizzy z koszyka
    window.removeFromCart = pizzaName => {
        const index = cart.findIndex(item => item.name === pizzaName);
        if (index > -1) {
            cart[index].count--;
            if (cart[index].count === 0) cart.splice(index, 1);
        }
        updateCartDisplay();
    };

    // Generowanie przycisków dla pizzy
    const pizzaNames = ["Margharitta", "Capriciossa", "Szefowska", "WloskiKurczak", "Ostra", "Hawajska", "Meska"];
    pizzaNames.forEach(name => {
        for (let i = 1; i <= 5; i++) {
            const ingredientItem = document.createElement("div");
            ingredientItem.className = "ingredient-item";

            const nameButton = document.createElement("button");
            nameButton.textContent = `${name} ${i}`;
            nameButton.onclick = () => changeImage(`./assets/${name}.png`);

            const addButton = document.createElement("button");
            addButton.textContent = "Dodaj do koszyka";
            addButton.className = "add-button";
            addButton.onclick = () => addToCart(`${name} ${i}`);

            ingredientItem.appendChild(nameButton);
            ingredientItem.appendChild(addButton);
            ingredientButtons.appendChild(ingredientItem);
        }
    });

    // Funkcja zmiany obrazka pizzy
    function changeImage(imagePath) {
        const imageBox = document.getElementById("pizza-image");
        imageBox.classList.remove("pizza-spin");
        setTimeout(() => {
            imageBox.classList.add("pizza-spin");
            setTimeout(() => {
                imageBox.src = imagePath;
            }, 450);
        }, 50);
    }
});
