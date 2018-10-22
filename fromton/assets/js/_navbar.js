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