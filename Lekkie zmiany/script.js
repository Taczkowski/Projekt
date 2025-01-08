document.addEventListener("DOMContentLoaded", () => {
    const snowflakeContainer = document.querySelector(".snowflakes");
    const cartPopup = document.querySelector(".cart-popup");
    const cartItems = document.getElementById("cart-items");
    const cartCount = document.getElementById("cart-count");
    let cart = [];

    function createSnowflake() {
        // Code for creating snowflake animations
    }

    function changeImage(imagePath) {
        const imageBox = document.getElementById("pizza-image");
        imageBox.classList.remove("pizza-spin");
        setTimeout(() => {
            imageBox.classList.add("pizza-spin");
            setTimeout(() => {
                imageBox.src = imagePath;
            }, 450);
        }, 50);
    }

    function addToCart(pizzaName) {
        const index = cart.findIndex(item => item.name === pizzaName);
        if (index > -1) {
            cart[index].count++;
        } else {
            cart.push({ name: pizzaName, count: 1 });
        }
        updateCartDisplay();
    }

    function removeFromCart(pizzaName) {
        const index = cart.findIndex(item => item.name === pizzaName);
        if (index > -1) {
            cart[index].count--;
            if (cart[index].count === 0) cart.splice(index, 1);
        }
        updateCartDisplay();
    }

    function updateCartDisplay() {
        cartItems.innerHTML = "";
        cartCount.textContent = cart.reduce((acc, item) => acc + item.count, 0);

        if (cart.length === 0) {
            cartItems.innerHTML = "<p>Twój koszyk jest pusty.</p>";
        } else {
            cart.forEach(item => {
                const li = document.createElement("li");
                li.innerHTML = `
                    ${item.name} x ${item.count}
                    <button onclick="removeFromCart('${item.name}')">Usuń</button>
                `;
                cartItems.appendChild(li);
            });
        }
    }

    window.changeImage = changeImage;
    window.addToCart = addToCart;
    window.removeFromCart = removeFromCart;

    document.querySelector(".cart").addEventListener("click", () => {
        cartPopup.classList.toggle("visible");
    });

    document.getElementById("close-cart").addEventListener("click", () => {
        cartPopup.classList.remove("visible");
    });
});
