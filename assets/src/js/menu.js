
const menu = document.querySelectorAll('.menu__item--has-dropdown')
if(menu.length > 0) {
    menu.forEach( (element) => {
        
        element.addEventListener("click", (event) => {
            console.log(event.target)
            if(window.innerWidth > 1024) return;
            if(!event.target.classList.contains("mobile__arrow")) return;
            event.stopPropagation();
            event.preventDefault();

            let open = event.currentTarget.classList.contains("menu__item--open");
            document.querySelectorAll('.menu__item--has-dropdown').forEach((element) => {
                element.classList.remove("menu__item--open");
            });
            if(open) { 
                event.currentTarget.classList.remove("menu__item--open"); 
                return;
            }
            event.currentTarget.classList.add("menu__item--open"); 
             
        })
        
    })
} 

const hamburger = document.getElementById('hamburger')

if(hamburger) {
    hamburger.addEventListener('click', (event) => {
        hamburger.firstElementChild.classList.toggle('is-active')
        var menu = document.getElementById('hamburger-menu')
            menu.classList.toggle("menu--open");
    });
} 

