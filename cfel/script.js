document.addEventListener("DOMContentLoaded", () => {
    const loginButton = document.getElementById("login");
    const mainDiv = document.querySelector("main > div");
    const boxes = document.querySelectorAll(".box");
    const originalMainContent = mainDiv.innerHTML;
    let currentView = "main";

    const animateBoxes = () => new Promise(resolve => {
        boxes.forEach(box => {
            box.style.transition = "transform 1s ease-in-out";
            box.style.transform = "translate(0, 0) rotate(0deg) scale(1)";
        });
        setTimeout(resolve, 1000);
    });

    const resetBoxes = () => new Promise(resolve => {
        setTimeout(() => {
            boxes.forEach(box => {
                const classList = box.classList;
                if(classList.contains("lefttop")) box.style.transform = "translate(-150vw, -150vh) rotate(-45deg) scale(0.5)";
                if(classList.contains("left")) box.style.transform = "translate(-225vw, 0) rotate(-30deg) scale(0.5)";
                if(classList.contains("leftbottom")) box.style.transform = "translate(-150vw, 150vh) rotate(-15deg) scale(0.5)";
                if(classList.contains("righttop")) box.style.transform = "translate(150vw, -150vh) rotate(45deg) scale(0.5)";
                if(classList.contains("right")) box.style.transform = "translate(225vw, 0) rotate(30deg) scale(0.5)";
                if(classList.contains("rightbottom")) box.style.transform = "translate(150vw, 150vh) rotate(15deg) scale(0.5)";
            });
            resolve();
        }, 10);
    });

    const displaySection = (html, className) => {
        const container = document.createElement("div");
        container.className = className;
        container.innerHTML = html;
        mainDiv.innerHTML = '';
        mainDiv.appendChild(container);
    };

    const displayLoginForm = () => {
        displaySection(`
            <div class="form-container">
                <h2>Logowanie</h2>
                <div class="form-group">
                    <label>Login:</label>
                    <input type="text" id="loginUsername" required>
                </div>
                <div class="form-group">
                    <label>Hasło:</label>
                    <input type="password" id="loginPassword" required>
                </div>
                <div class="form-buttons">
                    <button id="loginSubmit" class="btn-primary">Zaloguj</button>
                    <button id="showRegister" class="btn-secondary">Rejestracja</button>
                </div>
                <div>
                    <button id="backToMain" class="btn-back">Powrót</button>
                    </div>
            </div>
        `, 'login-form');
    };

    const displayRegistrationForm = () => {
        displaySection(`
            <div class="form-container">
                <h2>Rejestracja</h2>
                <div class="form-group">
                    <label>Login:</label>
                    <input type="text" id="regUsername" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" id="regEmail" required>
                </div>
                <div class="form-group">
                    <label>Hasło:</label>
                    <input type="password" id="regPassword" required>
                </div>
                <div class="form-buttons">
                    <button id="regSubmit" class="btn-primary">Zarejestruj</button>
                    <button id="backToLogin" class="btn-back">Powrót</button>
                </div>
            </div>
        `, 'registration-form');
    };

    document.addEventListener('click', async e => {
        if(e.target.matches('#login')) {
            e.target.classList.add('animate__rubberBand');
            await animateBoxes();
            await resetBoxes();
            displayLoginForm();
        }
        
        if(e.target.matches('#backToMain, #backToLogin')) {
            e.target.classList.add('animate__rubberBand');
            await animateBoxes();
            await resetBoxes();
            mainDiv.innerHTML = originalMainContent;
            attachMainListeners();
        }

        if(e.target.matches('#showRegister')) {
            e.target.classList.add('animate__rubberBand');
            await animateBoxes();
            await resetBoxes();
            displayRegistrationForm();
        }

        if(e.target.matches('#loginSubmit')) handleLogin(e);
        if(e.target.matches('#regSubmit')) handleRegistration(e);
    });

    const handleLogin = async e => {
        e.preventDefault();
        const username = document.getElementById('loginUsername')?.value;
        const password = document.getElementById('loginPassword')?.value;

        if(!username || !password) {
            alert('Wypełnij wszystkie pola!');
            return;
        }

        try {
            const response = await fetch('login.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({username, password})
            });

            const data = await response.json();
            
            if(data.status === "success") {
                window.location.href = "main.php";
            } else {
                alert(`Błąd: ${data.message}`);
            }
        } catch(error) {
            console.error('Błąd:', error);
            alert('Błąd połączenia z serwerem');
        }
    };

    const handleRegistration = async e => {
        e.preventDefault();
        const username = document.getElementById('regUsername')?.value;
        const email = document.getElementById('regEmail')?.value;
        const password = document.getElementById('regPassword')?.value;

        if(!username || !email || !password) {
            alert('Wypełnij wszystkie pola!');
            return;
        }

        try {
            const response = await fetch('register.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({username, email, password})
            });

            const data = await response.json();
            
            if(data.status === "success") {
                alert('Rejestracja udana! Możesz się zalogować');
                displayLoginForm();
            } else {
                alert(`Błąd: ${data.message}`);
            }
        } catch(error) {
            console.error('Błąd:', error);
            alert('Błąd połączenia z serwerem');
        }
    };

    const attachMainListeners = () => {
        document.getElementById('login')?.addEventListener('click', () => {
            // Możesz dodać inne działania po kliknięciu przycisku logowania
        });
    };

    attachMainListeners();
});