document.addEventListener("DOMContentLoaded", () => {
    // Konfiguracja
    const ingredientMap = {
        bazylia: "Ingredients_Basil.png",
        kukurydza: "Ingredients_Corn.png",
        jalapeno: "Ingredients_Jalapeno.png",
        cebula: "Ingredients_Onion.png",
        kurczak: "Ingredients_Sliced_Chicken.png",
        boczek: "Ingredients_Beacon.png",
        czosnek: "Ingredients_Garlic.png",
        pieczarki: "Ingredients_Mushroom.png",
        pepperoni: "Ingredients_Pepperoni.png",
        ananas: "Ingredients_Sliced_SHIT.png",
        sardela: "Ingredients_Anchovy.png",
        papryka: "Ingredients_Bell-Pepper.png",
        szynka: "Ingredients_Ham.png",
        oliwki: "Ingredients_Olive.png",
        krewetki: "Ingredients_Shrimp.png",
        pomidor: "Ingredients_Sliced_Tomato.png"
    };

    const BASE_PRICE = 35;
    const INGREDIENT_PRICE = 2;

    const pizzas = [
        {
            name: "🍳 Pizza Własna",
            price: BASE_PRICE,
            ingredients: [],
            custom: true
        },
        {
            name: "Travis Scott Special",
            price: 38,
            ingredients: ["pepperoni", "boczek", "jalapeno"],
        },
        {
            name: "Eminem Classic",
            price: 32,
            ingredients: ["pepperoni", "papryka", "cebula"],
        },
        {
            name: "Snoop Dogg BBQ",
            price: 35,
            ingredients: ["kurczak", "boczek", "cebula"],
        },
        {
            name: "Drake Tropical",
            price: 33,
            ingredients: ["ananas", "szynka", "kukurydza"],
        },
        {
            name: "Kanye West Supreme",
            price: 40,
            ingredients: ["pepperoni", "cebula", "czosnek"],
            animation: "flip-in"
        },
        {
            name: "Jay-Z Deluxe",
            price: 42,
            ingredients: ["kurczak", "papryka", "bazylia"],
            animation: "fade-in"
        },
        {
            name: "50 Cent Spicy",
            price: 38,
            ingredients: ["jalapeno", "boczek", "oliwki"],
            animation: "slide-in"
        },
        {
            name: "Lil Wayne Hot",
            price: 37,
            ingredients: ["krewetki", "czosnek", "bazylia"],
            animation: "bounce-in"
        },
        {
            name: "Post Malone Cheesy",
            price: 36,
            ingredients: ["szynka", "pieczarki", "cebula"],
            animation: "zoom-in"
        },
        {
            name: "Travis Barker Vegan",
            price: 34,
            ingredients: ["papryka", "pomidor", "bazylia"],
            animation: "fade-up"
        },
        {
            name: "Rick Ross Big Boss",
            price: 45,
            ingredients: ["boczek", "kurczak", "czosnek"],
            animation: "grow-in"
        },
        {
            name: "The Rock Power",
            price: 50,
            ingredients: ["kurczak", "boczek", "jalapeno"],
            animation: "drop-in"
        },
        {
            name: "Cardi B Queen",
            price: 39,
            ingredients: ["ananas", "szynka", "cebula"],
            animation: "wave"
        },
        {
            name: "Dr. Dre Classic",
            price: 41,
            ingredients: ["pepperoni", "czosnek", "pieczarki"],
            animation: "rotate-in"
        },
        {
            name: "Ice Cube Cool",
            price: 35,
            ingredients: ["oliwki", "papryka", "bazylia"],
            animation: "floating"
        },
        {
            name: "Nicki Minaj Pink",
            price: 37,
            ingredients: ["pomidor", "kurczak", "papryka"],
            animation: "slide-down"
        },
        {
            name: "Eminem Fire",
            price: 43,
            ingredients: ["jalapeno", "boczek", "czosnek"],
            animation: "pop-in"
        },
        {
            name: "DJ Khaled Major Key",
            price: 44,
            ingredients: ["kurczak", "oliwki", "cebula"],
            animation: "pulse"
        },
        {
            name: "Lil Uzi Vert Neon",
            price: 38,
            ingredients: ["szynka", "pieczarki", "bazylia"],
            animation: "flash-in"
        }
    ];

    // Stan aplikacji
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let currentPizza = null;
    let fallingInterval = null;
    let customIngredients = [];
    let isCustomMode = false;

    const audioCache = {
        add: new Audio('./assets/add-sound.mp3'),
        remove: new Audio('./assets/remove-sound.mp3'),
        pizza: new Audio('./assets/pizza-sound.mp3')
    };

    // Elementy DOM
    const backgroundLayer = document.createElement('div');
    backgroundLayer.className = 'background-ingredients';
    document.body.appendChild(backgroundLayer);

    // Animacja początkowa - 6 obrazków
    const initialImages = {
        left: { target: { left: "0%", top: "50%", transform: "translate(-100%, -50%) scale(0.8)", opacity: 0 } },
        right: { target: { left: "100%", top: "50%", transform: "translate(0%, -50%) scale(0.8)", opacity: 0 } },
        leftbottom: { target: { left: "0%", top: "100%", transform: "translate(-100%, 0%) scale(0.6)", opacity: 0 } },
        lefttop: { target: { left: "0%", top: "0%", transform: "translate(-100%, -100%) scale(0.6)", opacity: 0 } },
        rightbottom: { target: { left: "100%", top: "100%", transform: "translate(0%, 0%) scale(0.6)", opacity: 0 } },
        righttop: { target: { left: "100%", top: "0%", transform: "translate(0%, -100%) scale(0.6)", opacity: 0 } }
    };

    // Tworzenie obrazków
    const container = document.createElement('div');
    container.className = 'initial-animation-container';
    document.body.appendChild(container);

    Object.keys(initialImages).forEach(id => {
        const img = document.createElement('img');
        img.id = id;
        img.src = `./assets/${id}.png`;
        img.style.cssText = `
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 1;
            z-index: ${Math.random() * 100}; /* Losowe nakładanie */
        `;
        container.appendChild(img);
    });

    // Animacja
    setTimeout(() => {
        Object.entries(initialImages).forEach(([id, config]) => {
            const element = document.getElementById(id);
            if (element) {
                Object.assign(element.style, {
                    left: config.target.left,
                    top: config.target.top,
                    transform: config.target.transform,
                    opacity: config.target.opacity,
                    filter: 'blur(8px)'
                });
            }
        });
    }, 100);

    // Animacja składników
    function createIngredientElement(ingredient) {
        const img = document.createElement('img');
        img.className = 'falling-ingredient';
        img.src = `./assets/${ingredientMap[ingredient]}`;
        img.style.left = `${Math.random() * 100}%`;
        img.style.top = `-10%`;
        img.style.animation = `fall ${Math.random() * 3 + 2}s linear forwards`;

        requestAnimationFrame(() => {
            img.classList.add('visible');
        });

        img.addEventListener('animationend', () => img.remove());
        return img;
    }

    function manageFallingIngredients(ingredients) {
        if (fallingInterval) clearInterval(fallingInterval);
        fallingInterval = setInterval(() => {
            const ingredient = ingredients[Math.floor(Math.random() * ingredients.length)];
            backgroundLayer.appendChild(createIngredientElement(ingredient));
        }, 100);
    }

    function initFallingIngredients() {
        Object.keys(ingredientMap).forEach(ingredient => {
            const img = createIngredientElement(ingredient);
            img.style.position = 'absolute';
            img.style.animation = 'none';
            img.style.top = `${Math.random() * 30}%`;
            backgroundLayer.appendChild(img);
        });

        setTimeout(() => {
            document.querySelectorAll('.falling-ingredient').forEach(img => {
                img.style.animation = `fall ${Math.random() * 3 + 2}s linear forwards`;
            });
            manageFallingIngredients(Object.keys(ingredientMap));
        }, 100);
    }

    // Custom Pizza Functions
    function enterCustomPizzaMode() {
        isCustomMode = true;
        document.getElementById('pizza-menu').style.display = 'none';
        document.getElementById('custom-pizza-ui').style.display = 'block';
        document.querySelector('.text-box h2').textContent = 'Wybierz składniki';
        initIngredientSelector();
        manageFallingIngredients([]);
    }

// Zmiana w script.js w funkcji exitCustomPizzaMode
function exitCustomPizzaMode() {
    isCustomMode = false;
    document.getElementById('pizza-menu').style.display = 'block';
    document.getElementById('custom-pizza-ui').style.display = 'none';
}

function addCustomPizzaToCart() {
    console.log("Dodawanie własnej pizzy");
}


    function initIngredientSelector() {
        const container = document.querySelector('.ingredient-selector');
        container.innerHTML = '';

        Object.keys(ingredientMap).forEach(ingredient => {
            const btn = document.createElement('button');
            btn.className = `ingredient-btn ${customIngredients.includes(ingredient) ? 'active' : ''}`;
            btn.innerHTML = `
                <img src="./assets/${ingredientMap[ingredient]}" alt="${ingredient}">
                <span>${translateIngredients([ingredient])[0]}</span>
            `;

            btn.onclick = () => {
                audioCache.pizza.play();
                const index = customIngredients.indexOf(ingredient);
                if (index > -1) {
                    customIngredients.splice(index, 1);
                } else {
                    customIngredients.push(ingredient);
                }
                btn.classList.toggle('active');
                showIngredients({ ingredients: customIngredients });
                manageFallingIngredients(customIngredients);
            };
            container.appendChild(btn);
        });
    }

// Zmiana w funkcji addCustomPizzaToCart
function addCustomPizzaToCart() {
    if (customIngredients.length === 0) {
        alert('Proszę dodać przynajmniej 1 składnik!');
        return;
    }

    const customPizza = {
        name: `Custom Pizza (${customIngredients.join(', ')})`,
        price: BASE_PRICE + (customIngredients.length * INGREDIENT_PRICE),
        ingredients: [...customIngredients]
    };

    console.log("Dodawana pizza:", customPizza); // Sprawdzenie w konsoli
    cart.push(customPizza);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartIcon();
    renderCartItems();
    exitCustomPizzaMode();
}


    // Menu pizz
    function initMenu() {
        const menuContainer = document.getElementById('pizza-menu');
        menuContainer.innerHTML = '';

        pizzas.forEach(pizza => {
            const pizzaItem = document.createElement('div');
            pizzaItem.className = 'pizza-item';
            pizzaItem.dataset.pizza = pizza.name.toLowerCase().replace(/ /g, '-');
            pizzaItem.innerHTML = `
                <h3>${pizza.name} <span class="price">${pizza.price}zł</span></h3>
                ${pizza.custom ? '' : `<p class="ingredients">${translateIngredients(pizza.ingredients).join(', ')}</p>`}
                <button>${pizza.custom ? 'Stwórz' : 'Dodaj do koszyka'}</button>
            `;

            pizzaItem.querySelector('button').addEventListener('click', () => {
                if (pizza.custom) {
                    enterCustomPizzaMode();
                } else {
                    addToCart(pizza);
                }
            });
            pizzaItem.addEventListener('click', handlePizzaClick(pizza, pizzaItem));
            menuContainer.appendChild(pizzaItem);
        });
    }

    function handlePizzaClick(pizza, pizzaItem) {
        return (e) => {
            if (e.target.tagName === 'BUTTON') return;

            if (pizza.custom) {
                enterCustomPizzaMode();
                return;
            }

            audioCache.pizza.play();
            const wasActive = pizzaItem.classList.contains('active');
            document.querySelectorAll('.pizza-item').forEach(item => item.classList.remove('active'));

            if (!wasActive) {
                pizzaItem.classList.add('active');
                currentPizza = pizza;
                showIngredients(pizza);
                manageFallingIngredients(pizza.ingredients);
            } else {
                currentPizza = null;
                hideIngredients();
                manageFallingIngredients(Object.keys(ingredientMap));
            }
        };
    }

    // Wyświetlanie składników
    function showIngredients(pizza) {
        const ingredientsLayer = document.querySelector('.dynamic-ingredients');
        ingredientsLayer.innerHTML = '';

        const SLICES = 6;
        const INGREDIENTS_PER_TYPE = isCustomMode ? 6 : 3;

        for (let slice = 0; slice < SLICES; slice++) {
            const sliceIngredients = [...pizza.ingredients]
                .sort(() => Math.random() - 0.5)
                .flatMap(ing => Array(INGREDIENTS_PER_TYPE).fill(ing))
                .sort(() => Math.random() - 0.5);

            const sliceBaseAngle = (slice / SLICES) * 2 * Math.PI;

            sliceIngredients.forEach((ingredient) => {
                const img = document.createElement('img');
                img.className = 'ingredient';
                img.src = `./assets/${ingredientMap[ingredient]}`;

                const angle = sliceBaseAngle + (Math.random() * 0.5 - 0.25);
                const radius = 8 + (Math.random() * 8) + (Math.random() * 15);

                img.style.cssText = `
                    left: ${50 + (Math.cos(angle) * radius)}%;
                    top: ${50 + (Math.sin(angle) * radius)}%;
                    transform: 
                        translate(-50%, -50%) 
                        rotate(${Math.random() * 360}deg)
                        scale(${0.8 + Math.random() * 0.4});
                    animation: 
                        ingredientAppear 0.6s ease-out ${Math.random() * 0.4}s forwards,
                        ingredientFloat 3s ease-in-out infinite;
                    width: ${6 + Math.random() * 4}%;
                    z-index: ${Math.floor(Math.random() * 20)};
                    opacity: ${0.9 + Math.random() * 0.1};
                `;

                ingredientsLayer.appendChild(img);
            });
        }
        ingredientsLayer.style.opacity = '1';
    }

    function hideIngredients() {
        const ingredientsLayer = document.querySelector('.dynamic-ingredients');
        ingredientsLayer.style.opacity = '0';
        setTimeout(() => ingredientsLayer.innerHTML = '', 300);
    }

    // Obsługa koszyka
    
    function proceedToCheckout() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        window.location.href = `summary.php?cart=${encodeURIComponent(JSON.stringify(cart))}`;
    }

    function addToCart(pizza) {
        audioCache.add.play();
        cart.push(pizza);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartIcon();
        renderCartItems();
    }

    function updateCartIcon() {
        document.getElementById('cart-count').textContent = cart.length;
    }

    function toggleCart() {
        document.getElementById('cart-popup').classList.toggle('visible');
        renderCartItems();
    }

    function closeCart() {
        document.getElementById('cart-popup').classList.remove('visible');
    }

    function renderCartItems() {
        const cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = '';
        let total = 0;

        cart.forEach((item, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                ${item.name} - ${item.price} zł
                <button class="remove-btn">🗑️</button>
            `;
            li.querySelector('button').addEventListener('click', () => removeFromCart(index));
            cartItemsContainer.appendChild(li);
            total += item.price;
        });

        document.getElementById('cart-total').textContent = `${total} zł`;
    }

    function removeFromCart(index) {
        audioCache.remove.play();
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartIcon();
        renderCartItems();
    }

    function checkout() {
        if (cart.length > 0) {
            alert('Dziękujemy za zamówienie! 🍕');
            cart = [];
            localStorage.removeItem('cart');
            updateCartIcon();
            renderCartItems();
        } else {
            alert('Koszyk jest pusty!');
        }
    }

    // Pomocnicze
    function translateIngredients(ingredients) {
        const translations = {
            pepperoni: "Pepperoni",
            boczek: "Boczek",
            jalapeno: "Jalapeño",
            papryka: "Papryka",
            cebula: "Cebula",
            kurczak: "Kurczak",
            ananas: "Ananas",
            szynka: "Szynka",
            kukurydza: "Kukurydza",
            bazylia: "Bazylia",
            czosnek: "Czosnek",
            pieczarki: "Pieczarki",
            sardela: "Sardela",
            oliwki: "Oliwki",
            krewetki: "Krewetki",
            pomidor: "Pomidor"
        };
        return ingredients.map(ing => translations[ing] || ing);
    }

    // Inicjalizacja
    document.querySelector('.cart').addEventListener('click', toggleCart);
    document.getElementById('close-cart').addEventListener('click', closeCart);
    document.getElementById('checkout-btn').addEventListener('click', proceedToCheckout);

    initFallingIngredients();
    initMenu();
    updateCartIcon();
});
