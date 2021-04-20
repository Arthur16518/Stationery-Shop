let carousel = document.querySelector('.carousel');
let dots = document.getElementsByClassName('dot');
let activeItem = 0;
let timeout = setTimeout(switchCarousel, 4000);

function switchCarousel(target = activeItem + 1) {
    clearInterval(timeout);
    if (target == -1){
        if (activeItem > 0)
            target = activeItem - 1;
        else
            target = carousel.children.length - 1;
    }
    dots[activeItem].id = '';
    if (target < carousel.children.length){
        carousel.style.transform = "translateX("+(-100*target)+"vw)";
    }
    else{
        target = 0;
        carousel.style.transform = "translateX(0vw)";
    }
    dots[target].id = 'active-dot';
    activeItem = target;
    timeout = setTimeout(switchCarousel, 4000);
}