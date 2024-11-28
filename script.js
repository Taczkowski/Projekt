document.addEventListener("DOMContentLoaded", () => {
    const loginButton = document.getElementById("login");
    const pizza = document.querySelector(".pizza");
    const mainDiv = document.querySelector("main > div");

    loginButton.addEventListener("click", () => {

        const newPizza = document.createElement("img");
        newPizza.src = "./assets/HSPIZZA.png";
        newPizza.alt = "Pizza Animation";
        newPizza.classList.add("pizza-animation");
        document.body.appendChild(newPizza);


        setTimeout(() => {

            const loginFormContainer = document.createElement("div");
            loginFormContainer.style.margin = "10px auto";
            loginFormContainer.style.padding = "40px";
            loginFormContainer.style.textAlign = "center";
            loginFormContainer.style.backgroundColor = "#bd8d8d"; 
            loginFormContainer.style.borderRadius = "30px";
            loginFormContainer.style.border = "solid #924d4d"; 
            loginFormContainer.style.width = "70%";


            const loginForm = `
                <div class="login-form">
                    <label for="username">Login</label>
                    <input type="text" id="username" placeholder="Wpisz login">
                </div>
                <div class="login-form">
                    <label for="password">Hasło</label>
                    <input type="password" id="password" placeholder="Wpisz hasło">
                </div>
                <div>
                    <button id="submit" type="button">Zaloguj</button>
                </div>
            `;


            loginFormContainer.innerHTML = loginForm;

            mainDiv.innerHTML = ''; 
            mainDiv.appendChild(loginFormContainer);
        }, 2000); 
    });


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
