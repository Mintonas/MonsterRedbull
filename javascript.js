const observer = new IntersectionObserver((entries)=>{
    entries.forEach((entry)=>{
        if(entry.isIntersecting){
            entry.target.classList.add("show")
        }else{
            entry.target.classList.remove("show")
        }
    })
}, {
    threshold: 0.2
})

const elementsToObserve = document.querySelectorAll(".produktbild, .product-button, .one, .two, .buttonOne, .buttonTwo, .texting, .texting2")

elementsToObserve.forEach(el => observer.observe(el))