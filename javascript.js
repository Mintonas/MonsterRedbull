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

const buttons = document.querySelectorAll(".product-button")

buttons.forEach((button,index)=>{
    button.addEventListener("click",()=>{

        const product = button.closest(".product")
        const name = product.querySelector("p").innerText.slice(0,25)

        cart.push(name)

        updateCart()
    })
})

function updateCart(){

    cartItems.innerHTML=""

    cart.forEach((item,i)=>{
        const li=document.createElement("li")

        li.innerHTML=`
        ${item}
        <button onclick="removeItem(${i})">X</button>
        `

        cartItems.appendChild(li)
    })

    cartCount.innerText=cart.length
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