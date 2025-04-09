// falling-ingredients.js

document.addEventListener("DOMContentLoaded", () => {
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

    const backgroundLayer = document.createElement('div');
    backgroundLayer.className = 'background-ingredients';
    document.body.appendChild(backgroundLayer);

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
        setInterval(() => {
            const ingredient = ingredients[Math.floor(Math.random() * ingredients.length)];
            backgroundLayer.appendChild(createIngredientElement(ingredient));
        }, 100);
    }

    // Start the animation with all ingredients
    manageFallingIngredients(Object.keys(ingredientMap));
});