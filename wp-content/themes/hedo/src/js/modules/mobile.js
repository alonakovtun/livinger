import $ from 'jquery';

export const burgerMobile = () => {
  const burgerTrigger = document.querySelector('.header__mobile-burger'),
        menuBurger = document.querySelector('.header__menu-mobile');

  if (!burgerTrigger) return;

  burgerTrigger.addEventListener('click', (e) => {
    e.preventDefault();

    burgerTrigger.classList.toggle('_active');
    $('.header__menu-mobile').slideToggle();
    if (burgerTrigger.classList.contains('_active')) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = 'visible';
    }
  });

}


export const bagMobile = () => {
  const mobileBag = document.querySelector('.header__mobile-basket'),
        miniCart = document.querySelector('.mini-cart');

  if (!mobileBag) return;

  mobileBag.addEventListener('click', (e) => {
    e.preventDefault();

    miniCart.classList.toggle('_active');
  });

}

export const menuMobile = () => {
  const items = document.querySelectorAll('header #mobile .menu-item'),
        sklep = document.querySelector('.menu-item_sklep');

  let backElem,
      subMenu,
      stop_mobile_scroll = true;

  if (!items) return;


  const createBackButton = () => {
    const element = document.createElement('li');
    element.classList.add('menu-item', 'menu-item__back');
    element.innerHTML = `<a class="menu-item__back-link"><span></span></a>`;

    return element;
  }

  items.forEach((item, i) => {
    if (i == 0 || i == 1) {
    } else {
      item.addEventListener('click', (e) => {
        if (stop_mobile_scroll) {
          e.preventDefault();
        }

        if (item.nextElementSibling.classList.contains('submenu')) {
          subMenu = item.nextElementSibling;
          stop_mobile_scroll = false;
          subMenu.style.display = 'block';
          subMenu.prepend(createBackButton());
          backElem = subMenu.querySelector('.menu-item__back');
          e.stopPropagation();
        }

        if (backElem !== undefined) {
          backElem.addEventListener('click', (e) => {
            e.preventDefault();
            stop_mobile_scroll = true;

            backElem.remove();
            subMenu.style.display = 'none';
          });
        }
      });
    }



  });

  sklep.addEventListener('click', (e) => {
    e.preventDefault();
    const subMenuSklep = document.querySelector('.menu-mobile-container');
    subMenuSklep.style.display = 'block';
    subMenuSklep.prepend(createBackButton());

    const backElemSklep = subMenuSklep.querySelector('.menu-item__back');

    if (backElemSklep !== undefined) {
      backElemSklep.addEventListener('click', (e) => {
        e.preventDefault();
        // stop_mobile_scroll = true;

        backElemSklep.remove();
        subMenuSklep.style.display = 'none';
      });
    }

  });


  $('.menu-item_search').on('click', (e) => {
    e.preventDefault();

    $('.menu-item_search .woocommerce-product-search').slideToggle();
  })
}

export const toggleMiniCart = () => {
  $('.header__mobile-basket').on('click', (e) => {
    e.preventDefault();

    $('.mini-cart').toggleClass('show');
    $('.mini-cart').slideToggle().css({'display': 'flex'});
    if ($('.mini-cart').hasClass('show')) {
      $('body').css({'overflow': 'hidden', 'height': '100vh'});
    } else {
      $('body').css({'overflow': 'visible', 'height': 'auto'});
    }
  });

  $('.mini-cart__close').on('click', (e) => {
    e.preventDefault();

    $('.mini-cart').toggleClass('show');
    $('.mini-cart').slideToggle();
    $('body').css({'overflow': 'visible', 'height': 'auto'});
  });
}


export const toggleMenuFooter = () => {
  $('.sklep').on('click', () => {
    $('.menu-footer-sklep-container').slideToggle();
    $('.menu-footer-sklep-2-container').slideToggle();
  });

  $('#home').on('click', () => {
    $('.menu-footer-hedo-container').slideToggle();
  })

  $('#information').on('click', () => {
    $('.menu-footer-info-container').slideToggle();
  })

}


export const mobileFilters = () => {
  $('.filters__mobile').on('click', () => {
    $('.filters__mobile').toggleClass('_active');
    $('.filters__element').slideToggle();
  })

  $('#wcapf-price-filter-2').on('click', () => {
    $('#wcapf-price-filter-2').children('.wcapf-price-filter-wrapper').slideToggle();
  })
  $('#wcapf-attribute-filter-2').on('click', () => {
    $('#wcapf-attribute-filter-2').children('.wcapf-layered-nav').slideToggle();
  })
  $('#wcapf-attribute-filter-3').on('click', () => {
    $('#wcapf-attribute-filter-3').children('.wcapf-layered-nav').slideToggle();
  })
}