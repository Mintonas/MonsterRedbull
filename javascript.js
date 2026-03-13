const observer = new IntersectionObserver((entries)=>{
    entries.forEach((entry)=>{
        if(entry.isIntersecting){
            entry.target.classList.add("show")
        }else{
            entry.target.classList.remove("show")
        }
    })
},{
    threshold:0.2
})

const elementsToObserve = document.querySelectorAll(".produktbild, .product-button, .one, .two, .buttonOne, .buttonTwo, .texting, .texting2")

elementsToObserve.forEach(el => observer.observe(el))

/* CART SYSTEM */

let cart = []

const cartItems = document.getElementById("cartItems")
const cartCount = document.getElementById("cartCount")
const cartPanel = document.getElementById("cartPanel")
const cartButton = document.getElementById("cartButton")
const closeCart = document.getElementById("closeCart")
const notification = document.getElementById("cartNotification")

const buttons = document.querySelectorAll(".product-button")

buttons.forEach(button => {

    button.addEventListener("click", () => {

        let name = button.dataset.name

        let existing = cart.find(item => item.name === name)

        if(existing){
            existing.quantity += 1
        }else{
            cart.push({
                name: name,
                quantity: 1
            })
        }

        updateCart()
        showNotification(name)

    })

})

function updateCart(){

    cartItems.innerHTML=""

    cart.forEach((item,i)=>{

        const li = document.createElement("li")

        li.innerHTML = `
        ${item.name} (${item.quantity}x)
        <button onclick="removeItem(${i})">X</button>
        `

        cartItems.appendChild(li)

    })

    let total = 0
    cart.forEach(item => total += item.quantity)

    cartCount.innerText = total
}

function removeItem(index){
    cart.splice(index,1)
    updateCart()
}

cartButton.addEventListener("click",()=>{
    cartPanel.classList.add("open")
})

closeCart.addEventListener("click",()=>{
    cartPanel.classList.remove("open")
})

function showNotification(name){

    notification.innerText = `✅ ${name} added to cart`
    notification.classList.add("show")

    setTimeout(()=>{
        notification.classList.remove("show")
    },2000)

}