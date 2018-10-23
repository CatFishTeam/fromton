let burgerMenuState = false;
let menuSidebar = $('.burgerMenu__links')

$('.burgerMenu').on('click', '.fa-bars, .menuClose', function (e) {
  burgerMenuState = !burgerMenuState
  if (burgerMenuState) {
    menuSidebar.css('left', '0')
  } else {
    menuSidebar.css('left', '-300px')
  }
})

$('.notification__number--overninethousand').click(() => {
    alert('OMAE WA MOU SHINDERU');
    console.log('%c NANIIII', 'color: red; font-size: 50px')
    console.log('%c https://www.youtube.com/watch?v=SiMHTK15Pik', 'color: transparent')
    const naniiii = new Audio("https://www.myinstants.com/media/sounds/nani_Pmxf5n3.mp3")
    naniiii.play();
})