document.addEventListener("DOMContentLoaded", () => {
    const loginButton = document.getElementById("login");
    const mainDiv = document.querySelector("main > div");
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

    let maxSnowflakes = 10;
    let snowflakeCount = 0;

    function createSnowflake() {
        if (snowflakeCount < maxSnowflakes) {
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

            snowflakeCount++;

            snowflake.addEventListener("animationend", () => {
                snowflake.remove();
                snowflakeCount--;
            });
        }
    }

    setInterval(createSnowflake, 2000);

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
            loginFormContainer.style.width = "70%";

            const loginForm = `
                <div class="login-form">
                    <label for="username"></label>
                    <input type="text" id="username" placeholder="Wpisz login">
                </div>
                <div class="login-form">
                    <label for="password"></label>
                    <input type="password" id="password" placeholder="Wpisz hasło">
                </div>
                <div>
                    <button id="submit" type="button"></button>
                </div>
            `;

            loginFormContainer.innerHTML = loginForm;

            const secondDiv = document.createElement("div");
            secondDiv.style.marginTop = "20px";

            const registerButtonDiv = document.createElement("button");
            registerButtonDiv.style.backgroundSize = "contain";
            registerButtonDiv.style.backgroundPosition = "center";
            registerButtonDiv.style.backgroundRepeat = "no-repeat";
            registerButtonDiv.style.width = "200px";
            registerButtonDiv.style.height = "60px";
            registerButtonDiv.style.padding = "10px 20px";
            registerButtonDiv.style.cursor = "pointer";
            registerButtonDiv.style.backgroundColor = "#f2b97b";
            registerButtonDiv.style.border = "none";
            registerButtonDiv.style.borderRadius = "10px";

            registerButtonDiv.style.background = "url('./assets/newAccountUC.png') no-repeat center center";
            registerButtonDiv.style.backgroundSize = "cover";

            registerButtonDiv.style.transition = "background-color 0.3s ease-in-out"; 
            registerButtonDiv.style.borderRadius = "10px";

            registerButtonDiv.addEventListener("mouseover", () => {
                registerButtonDiv.style.background = "url('./assets/newAccountCC.png') no-repeat center center";
                registerButtonDiv.style.backgroundSize = "cover";
            });

            registerButtonDiv.addEventListener("mouseout", () => {
                registerButtonDiv.style.background = "url('./assets/newAccountUC.png') no-repeat center center";
                registerButtonDiv.style.backgroundSize = "cover";
            });

            registerButtonDiv.addEventListener("click", () => {
                const registrationFormContainer = document.createElement("div");
                registrationFormContainer.style.margin = "10px auto";
                registrationFormContainer.style.padding = "40px";
                registrationFormContainer.style.textAlign = "center";
                registrationFormContainer.style.backgroundColor = "#bd8d8d"; 
                registrationFormContainer.style.borderRadius = "30px";
                registrationFormContainer.style.width = "70%";

                const registrationForm = `
                    <div class="register-form">
                        <label for="firstName"></label>
                        <input type="text" id="firstName" placeholder="Imię">
                    </div>
                    <div class="register-form">
                        <label for="lastName"></label>
                        <input type="text" id="lastName" placeholder="Nazwisko">
                    </div>
                    <div class="register-form">
                        <label for="email"></label>
                        <input type="email" id="email" placeholder="Email">
                    </div>
                    <div class="register-form">
                    <div>
                        <button id="registerSubmit" type="button"></button>
                    </div>
                `;

                registrationFormContainer.innerHTML = registrationForm;

                mainDiv.innerHTML = '';
                mainDiv.appendChild(registrationFormContainer);

                const registerInputs = document.querySelectorAll('.register-form input');
                registerInputs.forEach(input => {
                    input.style.marginBottom = "15px";
                    input.style.padding = "10px";
                    input.style.width = "100%";
                    input.style.border = "1px solid #ccc";
                    input.style.borderRadius = "5px";
                    input.style.fontSize = "16px";
                    input.style.marginTop = "10px";
                });

                const registerSubmitButton = document.getElementById("registerSubmit");
                registerSubmitButton.style.border = "none";
                registerSubmitButton.style.width = "150px";
                registerSubmitButton.style.height = "50px";
                registerSubmitButton.style.cursor = "pointer";
                registerSubmitButton.style.background = "url('./assets/rejestrUC.png') no-repeat center center";
                registerSubmitButton.style.backgroundSize = "cover";
                registerSubmitButton.style.transition = "background-color 0.3s ease-in-out"; 
                registerSubmitButton.style.borderRadius = "10px";

                registerSubmitButton.addEventListener("mouseover", () => {
                    registerSubmitButton.style.background = "url('./assets/rejestrCC.png') no-repeat center center";
                    registerSubmitButton.style.backgroundSize = "cover";
                });

                registerSubmitButton.addEventListener("mouseout", () => {
                    registerSubmitButton.style.background = "url('./assets/rejestrUC.png') no-repeat center center";
                    registerSubmitButton.style.backgroundSize = "cover";
                });
            });

            secondDiv.appendChild(registerButtonDiv);
            loginFormContainer.appendChild(secondDiv);

            mainDiv.innerHTML = ''; 
            mainDiv.appendChild(loginFormContainer);

            const submitButton = document.getElementById("submit");
            submitButton.style.border = "none";
            submitButton.style.width = "150px";
            submitButton.style.height = "50px";
            submitButton.style.cursor = "pointer";
            submitButton.style.background = "url('./assets/loginUC.png') no-repeat center center";
            submitButton.style.backgroundSize = "cover";
            submitButton.style.transition = "background-color 0.3s ease-in-out"; 
            submitButton.style.borderRadius = "10px";

            submitButton.addEventListener("mouseover", () => {
                submitButton.style.background = "url('./assets/loginCC.png') no-repeat center center";
                submitButton.style.backgroundSize = "cover";
            });

            submitButton.addEventListener("mouseout", () => {
                submitButton.style.background = "url('./assets/loginUC.png') no-repeat center center";
                submitButton.style.backgroundSize = "cover";
            });
        }, 2000);
    });
});
