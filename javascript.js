/* DOM ELEMENTS */
const hamburger = document.getElementById("hamburger");
const sideMenu = document.getElementById("sideMenu");
const overlay = document.getElementById("overlay");
const cartItems = document.getElementById("cartItems");
const cartPanel = document.getElementById("cartPanel");
const closeCart = document.getElementById("closeCart");
const notification = document.getElementById("cartNotification");
const menuCartCount = document.getElementById("menuCartCount");
const menuCartBtn = document.getElementById("menuCartBtn");
const header = document.getElementById("Navigation");

/* ANIMATION OBSERVER */
const observer = new IntersectionObserver((entries)=>{
    entries.forEach((entry)=>{
        if(entry.isIntersecting){
            entry.target.classList.add("show");
        }else{
            entry.target.classList.remove("show");
        }
    });
}, { threshold:0.2 });

document.querySelectorAll(".produktbild, .product-button, .one, .two, .buttonOne, .buttonTwo, .texting, .texting2")
    .forEach(el => observer.observe(el));


/* CART SYSTEM */
let cart = [];
const buttons = document.querySelectorAll(".product-button");

buttons.forEach(button => {
    button.addEventListener("click", () => {
        let name = button.dataset.name;
        let existing = cart.find(item => item.name === name);

        if(existing){
            existing.quantity += 1;
        }else{
            cart.push({ name, quantity: 1 });
        }

        updateCart();
        showNotification(name);
    });
});

function updateCart(){
    cartItems.innerHTML = "";

    cart.forEach((item, i)=>{
        const li = document.createElement("li");

        li.innerHTML = `
        ${item.name} (${item.quantity}x)
        <button onclick="removeItem(${i})">X</button>
        `;

        cartItems.appendChild(li);
    });

    let total = 0;
    cart.forEach(item => total += item.quantity);

    if(menuCartCount){
        menuCartCount.innerText = total;
    }
}

function removeItem(index){
    cart.splice(index, 1);
    updateCart();
}

function showNotification(name){
    notification.innerText = `✅ ${name} added to cart`;
    notification.classList.add("show");

    setTimeout(()=>{
        notification.classList.remove("show");
    }, 2000);
}


/* UNIFIED MENU & CART SYSTEM */

// 1. Click Hamburger
hamburger.addEventListener("click", () => {
    // If cart is open, close everything
    if (cartPanel.classList.contains("open")) {
        cartPanel.classList.remove("open");
        overlay.classList.remove("active");
        hamburger.textContent = "☰";
        return;
    }

    // Otherwise toggle menu
    const isOpen = sideMenu.classList.toggle("open");
    overlay.classList.toggle("active");
    hamburger.textContent = isOpen ? "✖" : "☰";
});

// 2. Open Cart from Side Menu
menuCartBtn.addEventListener("click", () => {
    cartPanel.classList.add("open");
    sideMenu.classList.remove("open");
    hamburger.textContent = "✖"; 
});

// 3. Click "Close" inside the Cart (Goes back to Menu)
closeCart.addEventListener("click", () => {
    cartPanel.classList.remove("open");
    sideMenu.classList.add("open"); 
    hamburger.textContent = "✖";
});

// 4. Click the blurred background (Closes Everything)
overlay.addEventListener("click", () => {
    sideMenu.classList.remove("open");
    cartPanel.classList.remove("open");
    overlay.classList.remove("active");
    hamburger.textContent = "☰";
});


/* HIDE NAVBAR ON SCROLL */
let lastScroll = 0;

window.addEventListener("scroll", () => {
    let currentScroll = window.pageYOffset;

    if (currentScroll > lastScroll && currentScroll > 100) {
        header.style.transform = "translateY(-100%)";
    } else {
        header.style.transform = "translateY(0)";
    }

    lastScroll = currentScroll;
});