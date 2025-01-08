document.addEventListener("DOMContentLoaded", () => {
    const navButtons = document.querySelectorAll(".nav-btn");
    const centralDiv = document.getElementById("central-div");
    const snowflakeContainer = document.querySelector(".snowflakes");
    const avatar = document.getElementById("avatar");
    const avatarPopup = document.getElementById("avatar-popup");
  
    const ingredients = [
      "./assets/Ingredients_Pepperoni.png",
      "./assets/Ingredients_Bell-Pepper.png",
      "./assets/Ingredients_Corn.png",
      "./assets/Ingredients_Garlic.png",
      "./assets/Ingredients_Jalapeno.png",
      "./assets/Ingredients_Mushroom.png",
      "./assets/Ingredients_Olive.png",
      "./assets/Ingredients_Onion.png",
      "./assets/Ingredients_Sliced_Tomato.png",
      "./assets/Ingredients_Basil.png",
    ];
  
    const content = {
      promocje: `
        <h2>Kody Promocyjne</h2>
        <p>Wprowadź kod promocyjny:</p>
        <input type="text" placeholder="Kod promocyjny">
        <button>Aktywuj</button>
      `,
      konto: `
        <h2>Dane Konta</h2>
        <form>
          <label>Imię: <input type="text" name="imie"></label><br>
          <label>Nazwisko: <input type="text" name="nazwisko"></label><br>
          <label>Miejscowość: <input type="text" name="miasto"></label><br>
          <label>Ulica: <input type="text" name="ulica"></label><br>
          <label>Numer telefonu: <input type="text" name="telefon"></label><br>
          <label>Email: <input type="email" name="email"></label>
          <button>Submit</button>
        </form>
      `,
      zamowienia: `
        <h2>Ostatnie Zamówienia</h2>
        <p>Twoje zamówienia:</p>
        <ul>
          <li>Pizza Pepperoni - 22.12.2024</li>
          <li>Pizza Margherita - 18.12.2024</li>
        </ul>
      `,
    };
  
    // Obsługa zmiany zawartości centralnego diva
    navButtons.forEach((button) => {
      button.addEventListener("click", () => {
        const section = button.dataset.section;
        centralDiv.innerHTML = content[section] || `<h2>Witamy na stronie konta</h2>`;
      });
    });
  
    // Obsługa kliknięcia avatara
    avatar.addEventListener("click", () => {
      avatarPopup.classList.toggle("hidden");
    });
  
    // Animacja opadania składników
    let maxSnowflakes = 10;
  
    function createSnowflake() {
      const snowflake = document.createElement("div");
      snowflake.classList.add("snowflake");
  
      const randomIngredient = ingredients[Math.floor(Math.random() * ingredients.length)];
      const img = document.createElement("img");
      img.src = randomIngredient;
  
      snowflake.style.left = Math.random() * 100 + "vw";
      snowflake.style.animationDuration = Math.random() * 3 + 5 + "s";
      snowflake.style.opacity = Math.random() + 0.3;
  
      snowflake.appendChild(img);
      snowflakeContainer.appendChild(snowflake);
  
      snowflake.addEventListener("animationend", () => {
        snowflake.remove();
      });
    }
  
    setInterval(() => {
      const snowflakes = document.querySelectorAll(".snowflake");
      if (snowflakes.length < maxSnowflakes) {
        createSnowflake();
      }
    }, 1000);
  });