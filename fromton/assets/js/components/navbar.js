let burgerMenuState = false;
const menuSidebar = $('.burgerMenu__links');
const main = $('main');
const linkToBurgerMenu = $('.burgerMenu');

$('.burgerMenu').on('click', '.fa-bars, .menuClose', () => {
    burgerMenuState = !burgerMenuState;
    if (burgerMenuState) {
        menuSidebar.css('left', '0');
        main.css('margin-left', '300px');
        linkToBurgerMenu.css('left', '-300px');
    } else {
        menuSidebar.css('left', '-300px');
        main.css('margin-left', '0');
        linkToBurgerMenu.css('left', '0');
    }
});

$('.notification__number--overninethousand').click(() => {
    alert('OMAE WA MOU SHINDERU');
    console.log('%c NANIIII', 'color: red; font-size: 50px')
    console.log('%c https://www.youtube.com/watch?v=SiMHTK15Pik', 'color: transparent')
    const naniiii = new Audio("https://www.myinstants.com/media/sounds/nani_Pmxf5n3.mp3")
    naniiii.play();
});