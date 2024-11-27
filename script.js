document.addEventListener("DOMContentLoaded", () => {
    const snowflakeContainer = document.querySelector(".snowflakes");
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
        './assets/Ingredients_Basil.png'
    ];


    function createSnowflake() {
        const snowflake = document.createElement("div");
        snowflake.classList.add("snowflake");

        const randomIngredient = ingredients[Math.floor(Math.random() * ingredients.length)];
        const img = document.createElement("img");
        img.src = randomIngredient;
        img.width = 50;
        img.height = 50;


        snowflake.style.left = Math.random() * 100 + "vw";
        snowflake.style.animationDuration = Math.random() * 3 + 5 + "s";
        snowflake.style.opacity = Math.random() + 0.3;

        snowflake.appendChild(img);
        snowflakeContainer.appendChild(snowflake);


        snowflake.addEventListener("animationend", () => {
            snowflake.remove();
        });
    }


    setInterval(createSnowflake, 800);
});
