import WOW from 'wow.js';
import HoverSlide from "./hoverSlide";


const initAll = () => {

  window.addEventListener('resize', () => {
    // We execute the same script as before
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
  });

  const mainScreenSwiper = new Swiper('.main-screen .swiper-container', {
    slidesPerView: 1,
    spaceBetween: 0,
    speed: 800,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
    },
  });

    const categoryScreenSwiper = new Swiper('.category__row .swiper-container', {
        slidesPerView: 3,
        spaceBetween: 31,
        speed: 800,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
          el: '.swiper-pagination',
          type: 'bullets',
        },

        breakpoints: {
          320: {
            slidesPerView: 1,
            spaceBetween: 10,

          },
          769: {
            slidesPerView: 2,
            spaceBetween: 30
          },
          1025: {
            slidesPerView: 3,
            spaceBetween: 40
          }
        }
    });

    // categoryScreenSwiper.on('slideChange', function () {
    //     const swiperSlideHover = document.querySelector('.slider-category-wrap'),
    //         hoverNext = swiperSlideHover.querySelector('.swiper-slide-next + div'),
    //         swiperNext = swiperSlideHover.parentNode.querySelector('.swiper-button-next');
    //
    //     if (!swiperSlideHover) return;
    //     console.log();
    //
    //
    //     console.log(swiperSlideHover);
    //
    //     hoverNext.addEventListener('mouseenter', () => {
    //         swiperNext.classList.add('_active');
    //         hoverNext.style.border = '1px solid red';
    //     });
    //     swiperSlideHover.querySelector('.swiper-slide-next + div').addEventListener('mouseleave', () => {
    //         swiperNext.classList.remove('_active');
    //     });
    // });

  const productSlideSwiper = new Swiper(
    '.bestsellery__right .swiper-container',
    {
      slidesPerView: 1,
      spaceBetween: 0,
      speed: 800,
      allowTouchMove: false,
      autoplay: {
        delay: 5000,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    }
  );

  const mobileNews = new Swiper(
    '.mobile-news__container .swiper-container',
    {
      slidesPerView: 1,
      spaceBetween: 0,
      speed: 800,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    }
  );



  const productSlideSwiper2 = new Swiper(
    '.slide_new .swiper-container',
    {
      slidesPerView: 1,
      spaceBetween: 0,
      speed: 800,
      allowTouchMove: false,
      autoplay: {
        delay: 5000,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    }
  );
  const blogScreenSwiper = new Swiper('.blog__slider .swiper-container', {
    slidesPerView: 3,
    spaceBetween: 31,
    speed: 800,
    loop: true,
    navigation: {
      nextEl: '.blog__slider .swiper-button-next',
      prevEl: '.blog__slider .swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 10,

      },
      769: {
        slidesPerView: 2,
        spaceBetween: 30
      },
      1025: {
        slidesPerView: 3,
        spaceBetween: 40
      }
    }
  });

  const related = new Swiper('.related__slider .swiper-container', {
    slidesPerView: 3,
    spaceBetween: 31,
    speed: 800,
    autoplay: {
      delay: 5000,
    },
    loop: false,
    navigation: {
      nextEl: '.related__slider .swiper-button-next',
      prevEl: '.related__slider .swiper-button-prev',
    },
    pagination: {
      el: '.related__slider .swiper-pagination',
      type: 'bullets',
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: false,
      },
      769: {
        slidesPerView: 2,
        spaceBetween: 30
      },
      1025: {
        slidesPerView: 3,
        spaceBetween: 40
      }
    }
  });

  const related2 = new Swiper('.related__slider_2 .swiper-container', {
    slidesPerView: 3,
    spaceBetween: 31,
    speed: 800,
    autoplay: {
      delay: 5000,
    },
    loop: false,
    navigation: {
      nextEl: '.related__slider_2 .swiper-button-next',
      prevEl: '.related__slider_2 .swiper-button-prev',
    },
    pagination: {
      el: '.related__slider_2 .swiper-pagination',
      type: 'bullets',
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 10,
        navigation: false,
      },
      769: {
        slidesPerView: 2,
        spaceBetween: 30
      },
      1025: {
        slidesPerView: 3,
        spaceBetween: 40
      }
    }
  });

  var galleryThumbs = new Swiper('.product__gallery .gallery-thumbs', {
    direction: 'vertical',
    spaceBetween: 10,
    slidesPerView: 3,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });
  var galleryTop = new Swiper('.product__gallery .gallery-top', {
    slidesPerView: 1,
    spaceBetween: 10,
    dynamicBullets: true,
    navigation: {
      nextEl: '.product__gallery .swiper-button-next',
      prevEl: '.product__gallery .swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
    },
    thumbs: {
      swiper: galleryThumbs,
    },
  });

  var wow = new WOW(
    {
      boxClass:     'wow',      // animated element css class (default is wow)
      animateClass: 'animated', // animation css class (default is animated)
      offset:       0,          // distance to the element when triggering the animation (default is 0)
      mobile:       false,       // trigger animations on mobile devices (default is true)
      live:         true,       // act on asynchronously loaded content (default is true)
      callback:     function(box) {
        // the callback is fired every time an animation is started
        // the argument that is passed in is the DOM node being animated
      },
      scrollContainer: null,    // optional scroll container selector, otherwise use window,
      resetAnimation: true,     // reset animation on end (default is true)
    }
  );
  wow.init();
};

export default initAll;
