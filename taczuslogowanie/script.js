document.addEventListener("DOMContentLoaded", () => {
    const loginButton = document.getElementById("login");
    const mainDiv = document.querySelector("main > div");
    const snowflakeContainer = document.querySelector(".snowflakes");
    const boxes = document.querySelectorAll(".box");

    const originalMainContent = mainDiv.innerHTML;

    let currentView = "main";

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
            setTimeout(() => resolve(), 1000);
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
            }, 10);
        });
    }

    function addButtonAnimation(button, animationClass) {
        button.classList.add(animationClass);
        setTimeout(() => {
            button.classList.remove(animationClass);
        }, 1000);
    }

    function displayMainPage() {
        mainDiv.innerHTML = originalMainContent;
        currentView = "main";
        attachMainListeners();
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
                <div class="form-row">
                    <h1>Login</h1>
                    <input type="text" id="username" placeholder="Wpisz login">
                </div>
                <div class="form-row">
                    <h1>Hasło</h1>
                    <input type="password" id="password" placeholder="Wpisz hasło">
                </div>
                <div class="form-buttons">
                    <button id="submit" type="button">Zaloguj się</button>
                    <button id="register" type="button">Rejestracja</button>
                    <button id="previousOne" type="button">Powrót</button>
                </div>
            </div>
        `;

        loginFormContainer.innerHTML = loginForm;
        mainDiv.innerHTML = '';
        mainDiv.appendChild(loginFormContainer);
        currentView = "login";

        const registerButton = document.getElementById("register");
        registerButton.addEventListener("click", handleRegisterClick);

        const previousOneButton = document.getElementById("previousOne");
        previousOneButton.addEventListener("click", async () => {
            addButtonAnimation(previousOneButton, "animate__rubberBand");
            snowflakeContainer.style.display = "block";
            await animateBoxes();
            await resetBoxes();
            displayMainPage();
        });

        const submitButton = document.getElementById("submit");
        submitButton.addEventListener("click", async () => {
            addButtonAnimation(submitButton, "animate__rubberBand");
            await loginUser();
        });
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
                    <h1>Login</h1>
                <label for="Name"></label>
                <input type="text" id="Name" placeholder="Login">
            </div>
            <div class="login-form">
                    <h1>Email</h1>
                <label for="email"></label>
                <input type="email" id="email" placeholder="Email">
            </div>
            <div class="login-form">
                    <h1>Hasło</h1>
                <label for="password"></label>
                <input type="password" id="password" placeholder="Hasło">
            </div>
            <div>
                <button id="createAccount" type="button">Utwórz konto</button>
                <button id="previousTwo" type="button">Powrót</button>
            </div>
        `;

        registrationFormContainer.innerHTML = registrationForm;
        mainDiv.innerHTML = '';
        mainDiv.appendChild(registrationFormContainer);
        currentView = "register";

        const previousTwoButton = document.getElementById("previousTwo");
        previousTwoButton.addEventListener("click", async () => {
            addButtonAnimation(previousTwoButton, "animate__rubberBand");
            snowflakeContainer.style.display = "block";
            await animateBoxes();
            await resetBoxes();
            displayLoginForm();
        });

        const createAccountButton = document.getElementById("createAccount");
        createAccountButton.addEventListener("click", async () => {
            addButtonAnimation(createAccountButton, "animate__rubberBand");
            await registerUser();
        });
    }

    async function handleRegisterClick() {
        const registerButton = document.getElementById("register");
        addButtonAnimation(registerButton, "animate__rubberBand");
        snowflakeContainer.style.display = "block";

        await animateBoxes();
        await resetBoxes();

        displayRegistrationForm();
    }

    async function loginUser() {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        const response = await fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `username=${username}&password=${password}`
        });

        const data = await response.json();
        if (data.status === "success") {
            alert("Zalogowano pomyślnie!");
            // Możesz dodać logikę po udanym logowaniu, np. przekierowanie
        } else {
            alert(data.message);
        }
    }

    async function registerUser() {
        const username = document.getElementById("Name").value;
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        const response = await fetch('register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `username=${username}&email=${email}&password=${password}`
        });

        const data = await response.json();
        if (data.status === "success") {
            alert("Rejestracja zakończona sukcesem!");
            // Możesz dodać logikę po udanej rejestracji, np. przekierowanie
        } else {
            alert(data.message);
        }
    }

    displayMainPage();
});
