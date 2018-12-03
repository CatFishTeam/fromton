let burgerMenuState = false;
const menuSidebar = $('.burgerMenu__links');
const main = $('main');
const linkToBurgerMenu = $('.burgerMenu');
const searchbarContainer = $('.searchbar-container');
const searchbar = $('#searchbar');

$('.burgerMenu').on('click', '.fa-bars, .menuClose', () => {
    burgerMenuState = !burgerMenuState;
    // Menu s'ouvre
    if (burgerMenuState) {
        menuSidebar.css('left', '0');
        menuSidebar.removeClass('closed');
        if (window.innerWidth <= 375) {
            searchbarContainer.animate({width: '100%'}, 250);
            searchbar.css('padding', '0 10px');
        } else {
            main.css('margin-left', '300px');
            linkToBurgerMenu.css('left', '-300px');
        }
    }
    // Menu se ferme
    else {
        menuSidebar.css('left', '-300px');
        menuSidebar.addClass('closed');
        if (window.innerWidth <= 375) {
            searchbarContainer.animate({width: 0}, 100, () => searchbar.css('padding', '0'));
        } else {
            main.css('margin-left', '0');
            linkToBurgerMenu.css('left', '0');
        }
    }
});

$('.notification__number--overninethousand').click(() => {
    alert('OMAE WA MOU SHINDERU');
    console.log('%c NANIIII', 'color: red; font-size: 50px')
    console.log('%c https://www.youtube.com/watch?v=SiMHTK15Pik', 'color: transparent')
    const naniiii = new Audio("https://www.myinstants.com/media/sounds/nani_Pmxf5n3.mp3")
    naniiii.play();
});