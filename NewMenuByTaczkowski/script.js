document.addEventListener("DOMContentLoaded", () => {
    const ingredientConfig = {
        pepperoni: { x: 35, y: 40, rotation: -15 },
        papryka: { x: 55, y: 30, rotation: 20 },
        cebula: { x: 65, y: 60, rotation: -30 },
        kurczak: { x: 45, y: 50, rotation: 10 },
        boczek: { x: 60, y: 45, rotation: -25 },
        ananas: { x: 40, y: 35, rotation: 15 },
        kukurydza: { x: 50, y: 55, rotation: -10 }
    };

    const pizzas = [
        {
            name: "Eminem Classic",
            price: 32,
            ingredients: ["pepperoni", "papryka", "cebula"]
        },
        {
            name: "Snoop Dogg BBQ",
            price: 35,
            ingredients: ["kurczak", "boczek", "cebula"]
        },
        {
            name: "Kanye West Veggie",
            price: 34,
            ingredients: ["papryka", "cebula", "kukurydza"]
        },
        {
            name: "Drake Tropical",
            price: 33,
            ingredients: ["ananas", "kukurydza", "kurczak"]
        }
    ];

    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Generowanie menu
    pizzas.forEach(pizza => {
        const pizzaItem = document.createElement("div");
        pizzaItem.className = "pizza-item";
        pizzaItem.innerHTML = `
            <h3>${pizza.name} <span class="price">${pizza.price}zł</span></h3>
            <p class="ingredients">${pizza.ingredients.join(", ")}</p>
            <button onclick="addToCart('${pizza.name}')">Dodaj do koszyka</button>
        `;

        pizzaItem.addEventListener('mouseenter', () => {
            const container = document.querySelector('.dynamic-ingredients');
            container.innerHTML = '';
            
            pizza.ingredients.forEach(ingredient => {
                const img = document.createElement('img');
                img.className = 'ingredient';
                img.src = `./assets/ingredients/${ingredient}.png`;
                img.style.cssText = `
                    left: ${ingredientConfig[ingredient].x}%;
                    top: ${ingredientConfig[ingredient].y}%;
                    transform: rotate(${ingredientConfig[ingredient].rotation}deg);
                `;
                container.appendChild(img);
            });

            document.querySelector('.pizza-base').style.animation = 'pizzaSpin 20s linear infinite';
        });

        pizzaItem.addEventListener('mouseleave', () => {
            document.querySelector('.dynamic-ingredients').innerHTML = '';
            document.querySelector('.pizza-base').style.animation = '';
        });

        document.getElementById('pizza-menu').appendChild(pizzaItem);
    });

    // Funkcje koszyka
    window.toggleCart = () => document.getElementById('cart-popup').classList.toggle('visible');
    window.closeCart = () => document.getElementById('cart-popup').classList.remove('visible');

    window.addToCart = (pizzaName) => {
        const existingItem = cart.find(item => item.name === pizzaName);
        existingItem ? existingItem.count++ : cart.push({ name: pizzaName, count: 1 });
        updateCart();
    };

    window.removeFromCart = (pizzaName) => {
        const index = cart.findIndex(item => item.name === pizzaName);
        if (index !== -1) {
            cart[index].count--;
            if (cart[index].count === 0) cart.splice(index, 1);
            updateCart();
        }
    };

    window.checkout = () => {
        if (cart.length === 0) return alert("Koszyk jest pusty!");
        if (confirm("Potwierdź zamówienie")) {
            cart = [];
            localStorage.removeItem('cart');
            updateCart();
            closeCart();
            alert("Dziękujemy! Twoja pizza jest w drodze 🍕");
        }
    };

    function updateCart() {
        localStorage.setItem('cart', JSON.stringify(cart));
        
        const cartItems = document.getElementById('cart-items');
        const total = cart.reduce((sum, item) => sum + (pizzas.find(p => p.name === item.name).price * item.count), 0);
        
        cartItems.innerHTML = cart.map(item => `
            <li>
                ${item.name} x${item.count}
                <button onclick="removeFromCart('${item.name}')">Usuń</button>
            </li>
        `).join('');
        
        document.getElementById('cart-total').textContent = `${total}zł`;
        document.getElementById('cart-count').textContent = cart.reduce((sum, item) => sum + item.count, 0);
    }

    updateCart();
});