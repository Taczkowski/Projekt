document.addEventListener("DOMContentLoaded", () => {
    const loginButton = document.getElementById("login");
    const mainDiv = document.querySelector("main > div");
    const snowflakeContainer = document.querySelector(".snowflakes");
    const boxes = document.querySelectorAll(".box");

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

    function animateBoxes() {
        return new Promise((resolve) => {
            boxes.forEach((box) => {
                box.style.transition = "transform 1s ease-in-out";
                box.style.transform = "translate(0, 0) rotate(0deg) scale(1)";
            });
            setTimeout(() => resolve(), 1000); // Czas trwania animacji
        });
    }

    function resetBoxes() {
        return new Promise((resolve) => {
            setTimeout(() => {
                boxes.forEach((box) => {
                    if (box.classList.contains("lefttop")) box.style.transform = "translate(-150vw, -150vh) rotate(-45deg) scale(0.5)";
                    if (box.classList.contains("left")) box.style.transform = "translate(-225vw, 0) rotate(-30deg) scale(0.5)";
                    if (box.classList.contains("leftbottom")) box.style.transform = "translate(-150vw, 150vh) rotate(-15deg) scale(0.5)";
                    if (box.classList.contains("righttop")) box.style.transform = "translate(150vw, -150vh) rotate(45deg) scale(0.5)";
                    if (box.classList.contains("right")) box.style.transform = "translate(225vw, 0) rotate(30deg) scale(0.5)";
                    if (box.classList.contains("rightbottom")) box.style.transform = "translate(150vw, 150vh) rotate(15deg) scale(0.5)";
                });
                resolve();
            }, 300); // Czas powrotu elementów
        });
    }

    function addButtonAnimation(button, animationClass) {
        button.classList.add(animationClass);
        setTimeout(() => {
            button.classList.remove(animationClass);
        }, 1000);
    }

    function displayLoginForm() {
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
                <button id="register" type="button"></button>
                <button id="previousOne" type="button"></button>
            </div>
        `;

        loginFormContainer.innerHTML = loginForm;
        mainDiv.innerHTML = '';
        mainDiv.appendChild(loginFormContainer);

        const registerButton = document.getElementById("register");
        registerButton.addEventListener("click", handleRegisterClick);
    }

    function displayRegistrationForm() {
        const registrationFormContainer = document.createElement("div");
        registrationFormContainer.style.margin = "10px auto";
        registrationFormContainer.style.padding = "40px";
        registrationFormContainer.style.textAlign = "center";
        registrationFormContainer.style.backgroundColor = "#bd8d8d";
        registrationFormContainer.style.borderRadius = "30px";
        registrationFormContainer.style.width = "70%";

        const registrationForm = `
            <div class="login-form">
                <label for="firstName"></label>
                <input type="text" id="firstName" placeholder="Imię">
            </div>
            <div class="login-form">
                <label for="lastName"></label>
                <input type="text" id="lastName" placeholder="Nazwisko">
            </div>
            <div class="login-form">
                <label for="email"></label>
                <input type="email" id="email" placeholder="Email">
            </div>
            <div class="login-form">
                <label for="password"></label>
                <input type="password" id="password" placeholder="Hasło">
            </div>
            <div>
                <button id="createAccount" type="button"></button>
                <button id="previousTwo" type="button"></button>
            </div>
        `;

        registrationFormContainer.innerHTML = registrationForm;
        mainDiv.innerHTML = '';
        mainDiv.appendChild(registrationFormContainer);

    }

    async function handleRegisterClick() {
        const registerButton = document.getElementById("register");
        addButtonAnimation(registerButton, "animate__rubberBand");
        snowflakeContainer.style.display = "block";

        await animateBoxes();
        await resetBoxes();

        displayRegistrationForm(); // Wyświetla formularz rejestracji
    }

    loginButton.addEventListener("click", async () => {
        addButtonAnimation(loginButton, "animate__rubberBand");
        snowflakeContainer.style.display = "block";

        await animateBoxes();
        await resetBoxes();

        displayLoginForm();
    });
});
