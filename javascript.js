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

const btnSignUp = document.getElementById("btnSignUp");
const btnLogIn = document.getElementById("btnLogIn");
const btnDiscount = document.getElementById("btnDiscount");

const popupOverlay = document.getElementById("popupOverlay");
const closePopup = document.getElementById("closePopup");
const popupTitle = document.getElementById("popupTitle");
const popupInput1 = document.getElementById("popupInput1");
const popupInput2 = document.getElementById("popupInput2");
const popupSubmit = document.getElementById("popupSubmit");

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

/* CART SYSTEM */
const cartTotalPrice = document.getElementById("cartTotalPrice");
const buyBtn = document.getElementById("buyBtn");

let cart = [];
const buttons = document.querySelectorAll(".product-button");

buttons.forEach(button => {
    button.addEventListener("click", () => {
        let name = button.dataset.name;
        let price = parseFloat(button.dataset.price); 
        let existing = cart.find(item => item.name === name);

        if(existing){
            existing.quantity += 1;
        }else{
            cart.push({ name, price, quantity: 1 }); 
        }

        updateCart();
        showNotification(`✅ ${name} added to cart`);
    });
});

function updateCart(){
    cartItems.innerHTML = "";
    let totalQty = 0;
    let totalPrice = 0; 

    cart.forEach((item, i)=>{
        const li = document.createElement("li");
        
        let itemTotal = (item.price * item.quantity).toFixed(2);

        li.innerHTML = `
        <div class="cart-item-info">
            <span>${item.name} (${item.quantity}x)</span>
            <span class="cart-item-price">$${itemTotal}</span>
        </div>
        <button onclick="removeItem(${i})">X</button>
        `;

        cartItems.appendChild(li);

        totalQty += item.quantity;
        totalPrice += (item.price * item.quantity);
    });


    if(menuCartCount){
        menuCartCount.innerText = totalQty;
    }

    if(cartTotalPrice){
        cartTotalPrice.innerText = totalPrice.toFixed(2);
    }
}

function removeItem(index){
    cart.splice(index, 1);
    updateCart();
}

// Buy Button
if (buyBtn) {
    buyBtn.addEventListener("click", () => {
        if (cart.length === 0) {
            showNotification("⚠️ Your cart is empty!");
            return;
        }
        

        let finalTotal = cartTotalPrice.innerText;
        

        cart = [];
        updateCart(); 
        
     
        cartPanel.classList.remove("open");
        overlay.classList.remove("active");
        
     
        showNotification(`🎉 Order placed! Total: $${finalTotal}`);
    });
}

/* NOTIFICATION SYSTEM */
function showNotification(message){
    notification.innerText = message;
    notification.classList.add("show");

    setTimeout(()=>{
        notification.classList.remove("show");
    }, 2000);
}


/* UNIFIED MENU AND CART SYSTEM */
hamburger.addEventListener("click", () => {
    if (cartPanel.classList.contains("open")) {
        cartPanel.classList.remove("open");
        overlay.classList.remove("active");
        hamburger.textContent = "☰";
        return;
    }

    const isOpen = sideMenu.classList.toggle("open");
    overlay.classList.toggle("active");
    hamburger.textContent = isOpen ? "✖" : "☰";
});

menuCartBtn.addEventListener("click", () => {
    cartPanel.classList.add("open");
    sideMenu.classList.remove("open");
    hamburger.textContent = "✖"; 
});

closeCart.addEventListener("click", () => {
    cartPanel.classList.remove("open");
    sideMenu.classList.add("open"); 
    hamburger.textContent = "✖";
});

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


/* NAVBAR POP-UP LOGIC */
let currentPopupAction = "";

// Click Sign Up
if (btnSignUp) {
    btnSignUp.addEventListener("click", () => {
        popupTitle.innerText = "Sign Up";
        popupInput1.placeholder = "Email Address";
        popupInput1.type = "email";
        popupInput1.value = "";
        popupInput2.style.display = "block"; 
        popupInput2.value = "";
        currentPopupAction = "signup";
        popupOverlay.classList.add("show");
    });
}

// Click Log In
if (btnLogIn) {
    btnLogIn.addEventListener("click", () => {
        popupTitle.innerText = "Log In";
        popupInput1.placeholder = "Email Address";
        popupInput1.type = "email";
        popupInput1.value = "";
        popupInput2.style.display = "block"; 
        popupInput2.value = "";
        currentPopupAction = "login";
        popupOverlay.classList.add("show");
    });
}

// Click Discount Codes
if (btnDiscount) {
    btnDiscount.addEventListener("click", () => {
        popupTitle.innerText = "Redeem Code";
        popupInput1.placeholder = "Enter Discount Code";
        popupInput1.type = "text";
        popupInput1.value = "";
        popupInput2.style.display = "none";
        currentPopupAction = "discount";
        popupOverlay.classList.add("show");
    });
}

// Close Pop-up
if (closePopup) {
    closePopup.addEventListener("click", () => {
        popupOverlay.classList.remove("show");
    });
}

// Close if clicking the dark background outside the box
if (popupOverlay) {
    popupOverlay.addEventListener("click", (e) => {
        if (e.target === popupOverlay) {
            popupOverlay.classList.remove("show");
        }
    });
}

// Submit Button Logic
if (popupSubmit) {
    popupSubmit.addEventListener("click", () => {
        if (popupInput1.value.trim() === "") {
            showNotification("⚠️ Please fill out the field");
            return;
        }

        if (currentPopupAction === "signup") {
            showNotification("✅ Account Created!");
        } else if (currentPopupAction === "login") {
            showNotification("✅ Logged In Successfully!");
        } else if (currentPopupAction === "discount") {
            showNotification(`✅ Code '${popupInput1.value.toUpperCase()}' Redeemed!`);
        }

        // Close the popup after submitting
        popupOverlay.classList.remove("show");
    });
}