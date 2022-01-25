/*
 * if Category Page
 */

if (window.location.href.indexOf('?category=') != -1) {
  jQuery('body').append(
    '<style> .header_bottom + .b-bunner.m--autoplay {display: none;}</style>'
  );
}

/*
 * if Safari browser
 */

if (
  navigator.userAgent.search('Safari') >= 0 &&
  navigator.userAgent.search('Chrome') < 0
) {
  jQuery('body').append(
    '<style> .a--txt-ctr, .p-project .a--txt-nrrw p {text-align: center} </style>'
  );
}

/* ==============================
 * Preloader
 * ============================== */

jQuery(window).on('load', function () {
  jQuery('#preloader').fadeOut(100);
});

/* ==============================
 * Logo
 * ============================== */

jQuery(document).ready(function () {
  scrollSwitch = false;

  jQuery(document).on('scroll', function () {
    var scrollPos = jQuery(document).scrollTop(),
      bHeaderBottom = jQuery('.header_bottom');

    if (scrollPos > 63 && !scrollSwitch) {
      if (jQuery(window).width() < 720) {
        jQuery('.header_top').addClass('m--fixed');
        scrollSwitch = true;

        return;
      }
      bHeaderBottom.removeClass('m--fluid');
      bHeaderBottom.addClass('m--fixed');
      scrollSwitch = true;

      jQuery('.header_top').css('padding-bottom', 76);
      console.log(jQuery('.header_top').css('padding-bottom'));
    } else if (scrollPos < 63 && scrollSwitch) {
      if (jQuery(window).width() < 720) {
        jQuery('.header_top').removeClass('m--fixed');
        scrollSwitch = false;

        return;
      }
      bHeaderBottom.removeClass('m--fixed');
      bHeaderBottom.addClass('m--fluid');
      scrollSwitch = false;

      jQuery('.header_top').css('padding-bottom', 25);
      // console.log( 'done!' );
    }
    // console.log('scroll!');
  });
});

/* ==============================
 * Logo
 * ============================== */

/*
 * Tagline Animation
 */

jQuery(document).ready(function () {
  var cntr1 = 0,
    cntr2 = 0;

  animLogo(jQuery('#aside-logo-tagline'), cntr1);
  animLogo(jQuery('#header-logo-tagline'), cntr2);

  function animLogo(bTaglineContainer, i) {
    var esTaglineUnits = jQuery('.tagline_unit', bTaglineContainer),
      esTaglineUnitsLength = esTaglineUnits.length;
    i = esTaglineUnitsLength + 1;

    setInterval(function () {
      var prvsTaglineUnit = jQuery('.tagline_unit.active', bTaglineContainer);

      prvsTaglineUnit.removeClass('active');
      prvsTaglineUnit.addClass('disable');

      prvsTaglineUnit.height(16);
      prvsTaglineUnit.transition(
        {
          opacity: '0',
        },
        1500
      );

      setTimeout(function () {
        prvsTaglineUnit.height(0);
      }, 1450);

      // eGalleryImg.transition({
      // transform: 'translate(-50%, -50%) scale(1.1,1.1)',
      // }, 1500
      // );

      setTimeout(function () {
        var crntTaglineUnit = jQuery(
          esTaglineUnits.get(i % esTaglineUnitsLength)
        );
        crntTaglineUnit.removeClass('disable');
        crntTaglineUnit.addClass('active');

        crntTaglineUnit.transition(
          {
            opacity: '1',
          },
          1500
        );

        setTimeout(function () {
          crntTaglineUnit.height(0);
        }, 1450);

        i++;
      }, 1500);
    }, 6000);
  }
});

/* ===============================
 * SLIDE MENU
 * =============================== */

jQuery(document).ready(function () {
  var btnOpen = jQuery('#aside-open'),
    btnClose = jQuery('#aside-close'),
    eAside = jQuery('.u-aside'),
    eShadow = jQuery('.u-shadow-aside'),
    btns = btnOpen.add(btnClose).add(eShadow),
    counter = 0;

  btnOpen.on('click', function () {
    if (jQuery(this).hasClass('active')) {
      jQuery(this).removeClass('active');
      jQuery(this).addClass('disable');

      eAside.removeClass('m-aside-show');
      eAside.addClass('m-aside-hide');
      return;
    }

    jQuery(this).removeClass('disable');
    jQuery(this).addClass('active');

    eAside.removeClass('m-aside-hide');
    eAside.addClass('m-aside-show');
  });
});

/* ==============================
 * Gallery
 * ============================== */

jQuery(document).ready(galleryInit);

function galleryInit() {
  /*
   * Hover
   */

  var esGalleryFilterBtn = jQuery('#header-bottom .nav_unit'),
    esGalleryUnitTitle = jQuery('#gallery .gallery_unit');

  esGalleryFilterBtn.unbind('mouseleave');
  esGalleryFilterBtn.unbind('mouseenter');
  esGalleryUnitTitle.unbind('mouseleave');
  esGalleryUnitTitle.unbind('mouseenter');

  hoverNavUnit(esGalleryFilterBtn, 'mouseleave');
  hoverNavUnit(esGalleryFilterBtn, 'mouseenter');

  hoverGalUnit(esGalleryUnitTitle, 'mouseleave');
  hoverGalUnit(esGalleryUnitTitle, 'mouseenter');

  function hoverNavUnit(elms, evnt) {
    elms.on(evnt, function () {
      elms.not(this).removeClass('active');
      jQuery(this).toggleClass('active');
      jQuery(this).toggleClass('disable');
    });
  }

  function hoverGalUnit(elms, evnt) {
    elms.on(evnt, function () {
      var galUnitTitle = jQuery('.unit_title', this);

      galUnitTitle.toggleClass('active');
      galUnitTitle.toggleClass('disable');
    });
  }

  /*
   * Filtration
   */

  esGalleryFilterBtn.unbind('click');
  esGalleryFilterBtn.click(function () {
    if (!jQuery(this).hasClass('clicked')) {
      loadPostsCategory(this);
    }
    navUnitHover(this);
  });

  function navUnitHover(el) {
    var filterArg = jQuery(el).attr('data-groups');

    jQuery('.b-bunner').slideUp();
    // if( jQuery(el).hasClass('clicked') ) {
    // } else {
    // 	jQuery('.b-bunner').slideUp();
    // }

    esGalleryFilterBtn.removeClass('clicked');
    jQuery(el).addClass('clicked');
  }

  /*
   * Resize
   */

  esGalleryImgWrap = jQuery('.b-gallery .unit_img-wrap');

  jQuery(window).resize(function () {
    esGalleryImgWrap.each(function (i) {
      galleryUnitResize(jQuery(esGalleryImgWrap.get(i)));
    });
  });

  setTimeout(function () {
    esGalleryImgWrap.each(function (i) {
      galleryUnitResize(jQuery(esGalleryImgWrap.get(i)));
    });
  }, 100);

  function galleryUnitResize(eGalleryUnit) {
    var eUnitImg = jQuery('img', eGalleryUnit);

    // console.log( eGalleryUnit, eGalleryUnit.width() );

    eGalleryUnit.height(eGalleryUnit.width() / 1.7);
  }
}

/* ==============================
 * Video Player
 * ============================== */

jQuery(document).ready(function () {
  /*
   * Resize
   */

  var esVideoBunner = jQuery('.b-bunner:has(video)');

  jQuery(window).on('resize', function () {
    esVideoBunner.each(function (i) {
      videoResize(jQuery(esVideoBunner.get(i)));
    });
  });

  esVideoBunner.each(function (i) {
    videoResize(jQuery(esVideoBunner.get(i)));
  });

  function videoResize(bVideoContainer) {
    var eVideo = jQuery('.wp-video', bVideoContainer);

    wVideo = eVideo.width();
    bVideoContainer.height(wVideo / 2);
  }

  /*
   * Resize Youtube video
   */

  var esVideoYoutubeBunner = jQuery('.b-bunner:has(iframe)'),
    nYoutubeVideoRatio =
      jQuery('.b-bunner:has(iframe) iframe').width() /
      jQuery('.b-bunner:has(iframe) iframe').height();

  jQuery(window).on('resize', function () {
    esVideoYoutubeBunner.each(function (i) {
      videoYoutubeResize(jQuery(esVideoYoutubeBunner.get(i)));
    });
  });

  esVideoYoutubeBunner.each(function (i) {
    videoYoutubeResize(jQuery(esVideoYoutubeBunner.get(i)));
  });

  function videoYoutubeResize(bVideoContainer) {
    var eVideo = jQuery('iframe', bVideoContainer);

    eVideo.width(bVideoContainer.width());
    eVideo.height(eVideo.width() / nYoutubeVideoRatio);
  }

  /*
   * Autoplay
   */

  videoAutoplay('.b-bunner.m--autoplay');

  function videoAutoplay(eVideo) {
    jQuery('.wp-video-shortcode', eVideo).prop('volume', 0);
    jQuery('video', eVideo).attr('autoplay', 'true');
    jQuery('video', eVideo).prop('muted', true);
    jQuery('video', eVideo).attr('muted', '');
    jQuery('.mejs-overlay-button', eVideo).trigger('click');
    jQuery('.mejs-button.mejs-volume-button.mejs-mute button', eVideo).trigger(
      'click'
    );
  }

  /*
   * Sound Btn
   */

  var esVideoShortcode = jQuery('div.wp-video-shortcode');

  btnVideoSound = jQuery('.bunner_sound');
  btnVideoSound.click(videoOnOffSound);

  function videoOnOffSound() {
    var eVideo = jQuery('.wp-video-shortcode', jQuery(this).prev()),
      eVideoTag = jQuery('video', eVideo);

    if (eVideoTag.prop('muted') == true || eVideo.prop('volume') == 0) {
      eVideo.prop('volume', 1);
      eVideoTag.prop('muted', false);
      console.log('on');
    } else {
      eVideo.prop('volume', 0);
      eVideoTag.prop('muted', true);
      console.log('off');
    }
  }
});

/* ==============================
 * Fancy Box.
 * ============================== */

jQuery(document).ready(function () {
  jQuery('[data-fancybox="gallery"]').fancybox({
    keyboard: true,
    infobar: false,
    arrows: false,
    buttons: [],
  });
});

/* ===============================
 * AJAX
 ** =============================== */

var pageCatOne = 1,
  pageCatTwo = 1,
  pageCatThree = 1,
  pageCatFour = 1,
  pageCatFife = 1,
  postCategory = 0,
  bPreloader = jQuery('.box:has(.loader10)');

(ajaxurl = 'http://localhost:8888/wp-admin/admin-ajax.php'),
  (page = 3),
  (resLength = 1);

/*
 * Infinite Loop
 */

jQuery(document).ready(function () {
  var eGallery = jQuery('#gallery'),
    shownPreloader = false,
    onRequest = false;
  ajaxCheck = jQuery('.ajax-check');

  if (ajaxCheck.length == 0) {
    return;
  }

  jQuery(window).on('scroll', function () {
    var scrollHeight = jQuery(document).height();

    var scrollPosition = jQuery(window).height() + jQuery(window).scrollTop();
    if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
      if (!shownPreloader) {
        // eGallery.append('<img id="preloader" src="http://sonia-a.co.uk/wp-content/themes/View/inc/img/preloader.gif" alt="">');
        shownPreloader = true;
      }

      if (!onRequest) {
        /* ---------- */

        // if( window.location.href.indexOf("?group=") >= 0 ) {
        // 	var group = window.location.href.slice(
        // 		window.location.href.indexOf("?group=")+7
        // 		);
        // 	console.log(group);
        // }

        /* ---------- */

        /* Projects Preloader */

        bPreloader.addClass('box_active');

        onRequest = true;

        jQuery.ajax({
          url: ajaxurl,
          type: 'post',
          data: {
            page: page,
            cat: postCategory,
            action: 'infinite_loop',
          },
          error: function (response) {
            setTimeout(function () {
              bPreloader.removeClass('box_active');
            }, 600);
          },
          success: function (response) {
            console.log('success');
            if (resLength == 0) {
              setTimeout(function () {
                bPreloader.removeClass('box_active');
                return;
              }, 600);

              return;
            }

            setTimeout(function () {
              var nProjects = jQuery(response);
              console.log(nProjects.length);

              eGallery.append(response);
              galleryInit();
              if (nProjects.length == 3) {
                var newProjects = eGallery
                  .find('.gallery_unit:last-child')
                  .prev('.gallery_unit')
                  .andSelf()
                  .hide()
                  .fadeIn(500);
                // console.log('yes!');
              } else if (nProjects.length == 1) {
                var newProjects = eGallery
                  .find('.gallery_unit:last-child')
                  .hide()
                  .fadeIn(500);
              }

              // jQuery('#preloader').remove();
              console.log(page);
              page += 1;

              shownPreloader = false;
              onRequest = false;
              resLength = response.length;

              console.log(resLength);

              bPreloader.removeClass('box_active');
            }, 600);
          },
        });
      }
    }
  });
});

/*
 * Change Category
 */

function loadPostsCategory(el) {
  jQuery('.b-gallery').slideUp();

  var pageCat = 1,
    eGallery = jQuery('#gallery'),
    reqPostCat = jQuery(el).attr('data-cat'),
    shownPreloader = false,
    onRequest = false,
    resLengthCat = 1;

  onRequest = true;

  jQuery.ajax({
    url: ajaxurl,
    type: 'post',
    data: {
      page: pageCat,
      cat: reqPostCat,
      action: 'load_posts_cat',
    },

    error: function (response) {},

    success: function (response) {
      if (resLengthCat == 0) {
        return;
      }

      eGallery.html(response);
      galleryInit();
      jQuery('.b-gallery').slideDown();
      pageCat += 1;

      shownPreloader = false;
      onRequest = false;
      resLength = response.length;
      postCategory = reqPostCat;

      (page = 3), (resLengthCat = 1);

      console.log('Response length: ' + resLengthCat);
      console.log(postCategory);
    },
  });
}

/* ==============================
 * page Project
 * ============================== */

jQuery(document).ready(function () {
  var esGalleryImgWrap = jQuery('.project_related-prod .unit_img-wrap');
  console.log(esGalleryImgWrap);

  jQuery(window).resize(function () {
    esGalleryImgWrap.each(function (i) {
      galleryRelatedUnitResize(jQuery(esGalleryImgWrap.get(i)));
    });
  });

  setTimeout(function () {
    esGalleryImgWrap.each(function (i) {
      galleryRelatedUnitResize(jQuery(esGalleryImgWrap.get(i)));
    });
  }, 100);

  function galleryRelatedUnitResize(eGalleryUnit) {
    var eUnitImg = jQuery('img', eGalleryUnit);

    eGalleryUnit.height(eGalleryUnit.width() / 1.7);
  }

  jQuery('.gallery__container')
    .mouseenter(function () {
      var video = jQuery(this)[0].querySelector('video');
      var location = window.location.pathname;
      var reg = /index/i;
      if (!reg.test(location)) {
        if (video.paused) {
          video.play();
        }
        video.muted = true;
      }
    })
    .mouseleave(function () {
      var video = jQuery(this)[0].querySelector('video');
      var location = window.location.pathname;
      var reg = /index/i;
      if (!reg.test(location)) {
        if (!video.paused) {
          video.pause();
        }
      }
    });

  function openProject() {
    jQuery('.gallery__container').on('click', function (e) {
      e.preventDefault();
      jQuery('body')[0].style.overflow = 'hidden';
      var video = jQuery(this)[0].previousElementSibling.querySelector('video');
      video.setAttribute('controls', '');
      video.muted = true;
      if (!jQuery(this).parent().hasClass('is-active')) {
        jQuery(this).parent().addClass('is-active');
        if (video) {
          video.play();
        }
      }
      if (!jQuery(this).prev().hasClass('is-active')) {
        jQuery(this).prev().addClass('is-active');
      }
    });
    jQuery('.close-project').on('click', function (e) {
      e.preventDefault();
      jQuery('body')[0].style.overflow = 'auto';
      jQuery(this).parent().parent().parent().removeClass('is-active');
      jQuery(this).parent().parent().parent().parent().removeClass('is-active');

      e.preventDefault();

      var video = jQuery(
        this
      )[0].parentNode.parentNode.parentNode.querySelector('video');
      if (video) {
        video.pause();
      }
    });
    jQuery('.about-project-item__close-info').on('click', function () {
      if (jQuery(this).text() == 'info') {
        jQuery(this).text('close info');
        jQuery(this).parent().parent().parent().addClass('is-active');
      } else {
        jQuery(this).text('info');
        jQuery(this).parent().parent().parent().removeClass('is-active');
      }
    });
    jQuery('.muted-li').on('click', function (e) {
      e.preventDefault();
      var video = jQuery(
        this
      )[0].parentNode.parentNode.parentNode.querySelector('video');
      if (!video.muted) {
        video.muted = true;
        jQuery(this).text('unmute');
      } else {
        video.muted = false;
        jQuery(this).text('mute');
      }
    });
    jQuery('.pause-li').on('click', function (e) {
      e.preventDefault();
      var video = jQuery(
        this
      )[0].parentNode.parentNode.parentNode.querySelector('video');
      if (video.paused) {
        jQuery(this).text('pause');
        video.play();
      } else {
        jQuery(this).text('play');
        video.pause();
      }
    });
    jQuery('.fullscreen-li').on('click', function (e) {
      e.preventDefault();
      var video = jQuery(
        this
      )[0].parentNode.parentNode.parentNode.querySelector('video');
      if (!document.fullscreenElement) {
        jQuery(this).text('exit fullscreen');
        video.requestFullscreen().catch((err) => {
          alert(
            `Error attempting to enable full-screen mode: ${err.message} (${err.name})`
          );
        });
      } else {
        jQuery(this).text('fullscreen');
        document.exitFullscreen();
      }
    });
  }

  openProject();

  jQuery(document).ajaxSuccess(function () {
    setTimeout(function () {
      jQuery('.gallery__container')
        .mouseenter(function () {
          var video = jQuery(this)[0].querySelector('video');
          var location = window.location.pathname;
          var reg = /index/i;

          var isPlaying = true;

          // On video playing toggle values
          video.onplaying = function () {
            isPlaying = true;
          };

          // On video pause toggle values
          video.onpause = function () {
            isPlaying = false;
          };

          // Play video function
          function playVid() {
            video.play();
          }
          var JSONvideo = jQuery(this)[0].querySelector('.wp-playlist-script');
          var obj = JSON.parse(JSONvideo.text).tracks[0];
          var src = obj.src;
          video.setAttribute('src', src);
          video.setAttribute('autoplay', 'autoplay');
          video.removeAttribute('controls');
          video.setAttribute('muted', 'muted');
          video.muted = true;

          if (!reg.test(location)) {
            if (video.paused && !isPlaying) {
              playvid();
            }
          }
        })
        .mouseleave(function () {
          var video = jQuery(this)[0].querySelector('video');
          var location = window.location.pathname;
          var reg = /index/i;
          if (!reg.test(location)) {
            if (!video.paused) {
              video.pause();
            }
          }
        });
      jQuery('.gallery__container').on('click', function (e) {
        e.preventDefault();
        jQuery('body')[0].style.overflow = 'hidden';
        if (!jQuery(this).parent().hasClass('is-active')) {
          jQuery(this).parent().addClass('is-active');
        }
        if (!jQuery(this).prev().hasClass('is-active')) {
          jQuery(this).prev().addClass('is-active');
        }

        var videoJSON = jQuery(this)[0].previousElementSibling.querySelector(
          '.wp-playlist-script'
        );
        var obj = JSON.parse(videoJSON.text).tracks[0];
        var src = obj.src;
        console.log(
          videoJSON.previousElementSibling.previousElementSibling
            .previousElementSibling
        );
        videoJSON.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.setAttribute(
          'src',
          src
        );
        videoJSON.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.setAttribute(
          'autoplay',
          'autoplay'
        );
        videoJSON.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.setAttribute(
          'muted',
          'muted'
        );
        videoJSON.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.muted = true;
      });
      jQuery('.close-project').on('click', function (e) {
        e.preventDefault();
        jQuery(this).parent().parent().parent().removeClass('is-active');
        jQuery(this)
          .parent()
          .parent()
          .parent()
          .parent()
          .removeClass('is-active');
      });
      jQuery('.about-project-item__close-info').on('click', function () {
        if (jQuery(this).text() == 'info') {
          jQuery(this).text('close info');
          jQuery(this).parent().parent().parent().addClass('is-active');
        } else {
          jQuery(this).text('info');
          jQuery(this).parent().parent().parent().removeClass('is-active');
        }
      });
      jQuery('.muted-li').on('click', function (e) {
        e.preventDefault();
        var video = jQuery(
          this
        )[0].parentNode.parentNode.parentNode.querySelector('video');
        if (!video.muted) {
          video.muted = true;
          jQuery(this).text('unmute');
        } else {
          video.muted = false;
          jQuery(this).text('mute');
        }
      });
      jQuery('.pause-li').on('click', function (e) {
        e.preventDefault();
        var video = jQuery(
          this
        )[0].parentNode.parentNode.parentNode.querySelector('video');
        if (video.paused) {
          jQuery(this).text('pause');
          video.play();
        } else {
          jQuery(this).text('play');
          video.pause();
        }
      });
      jQuery('.close-li').on('click', function (e) {
        e.preventDefault();
        jQuery('body')[0].style.overflow = 'auto';
        var video = jQuery(
          this
        )[0].parentNode.parentNode.parentNode.querySelector('video');
        if (video) {
          video.pause();
        }
      });
      jQuery('.fullscreen-li').on('click', function (e) {
        e.preventDefault();
        console.log('fullscreen');
        var video = jQuery(
          this
        )[0].parentNode.parentNode.parentNode.querySelector('video');
        video.requestFullscreen();
      });
    }, 1500);
  });
});

/* ==============================
 * page O Nas
 * ============================== */

/*
 * Top Bunner
 */

jQuery(document).ready(function () {
  jQuery('#onas-slider').owlCarousel({
    items: 1,
    loop: true,
    autoplay: 6500,
    autoplaySpeed: 1500,
  });

  var esSlider = jQuery('.b-slider .slider_unit');

  jQuery(window).on('resize', function () {
    esSlider.each(function (i) {
      sliderResize(jQuery(esSlider.get(i)));
    });
  });

  esSlider.each(function (i) {
    sliderResize(jQuery(esSlider.get(i)));
  });

  function sliderResize(bSlider) {
    wSlider = bSlider.width();
    bSlider.height(wSlider / 2);
  }
});

/*
 * Peple Gallery
 */

jQuery(document).ready(function () {
  var esPeapleGalleryUnits = jQuery(
      '.peaple-gallery_unit',
      '.s-peaple-gallery'
    ),
    intervalId = 0;

  esPeapleGalleryUnits.each(function (i) {
    var unit = esPeapleGalleryUnits.get(i),
      unitImgsCnt = jQuery('.unit_imgs', unit),
      unitImgs = jQuery('.unit_imgs img', unit);

    unitImgsCnt.attr('data-img-amount', unitImgs.length);
    unitImgsCnt.attr('data-img-current', 1);
  });

  esPeapleGalleryUnits.on('mouseenter', function () {
    var esImages = jQuery('.unit_imgs img', this),
      imgCnt = jQuery('.unit_imgs', this),
      imgAmount = imgCnt.attr('data-img-amount'),
      imgCurrent = imgCnt.attr('data-img-current');

    nextImage(esImages);

    timer = setInterval(function () {
      nextImage(esImages);
    }, 1000);

    intervalId = timer;
    function nextImage(esImages) {
      esImages.removeClass('active');
      jQuery(esImages.get(imgCurrent % imgAmount)).toggleClass('active');

      imgCnt.attr('data-img-current', ++imgCurrent % imgAmount);
    }
  });

  esPeapleGalleryUnits.on('mouseleave', function () {
    clearInterval(intervalId);
  });
});

/*
 * Social Sharing
 */

jQuery(document).ready(function () {
  var bSocialSharing = jQuery('.p-project .b-social-sharing'),
    eFacebook = jQuery('#sharing-facebook', bSocialSharing),
    eTwitter = jQuery('#sharing-twitter', bSocialSharing),
    ePinterest = jQuery('#sharing-pinterest', bSocialSharing);

  eFacebook.click(function () {});

  eTwitter.click(function () {});

  ePinterest.click(function () {});
});

/* ==============================
 * page Career
 * ============================== */

jQuery(document).ready(function () {
  /*
   * Form Tabs
   */

  var esFormNav = jQuery('.s-form .unit_title');
  esFormCnt = jQuery('.s-form .unit_drop');
  // esFormCnt = jQuery('.s-form .s-form .cnt_unit');

  /*
   * Fake File Inputs
   */

  var btnFileFake1 = jQuery('.file-fake-inp-1'),
    btnFileFake2 = jQuery('.file-fake-inp-2'),
    inpFile1 = jQuery('.file-inp-1'),
    inpFile2 = jQuery('.file-inp-2'),
    btnFileDel1 = jQuery('.btn-remove-file-inp', btnFileFake1),
    btnFileDel2 = jQuery('.btn-remove-file-inp', btnFileFake2),
    btnFileOpen1 = jQuery('.btn-file-inp', btnFileFake1),
    btnFileOpen2 = jQuery('.btn-file-inp', btnFileFake2);

  btnFileFake1.on('click', function () {
    jQuery(this).parent().find('.file-inp-1').trigger('click');
  });
  btnFileFake2.on('click', function () {
    jQuery(this).parent().find('.file-inp-2').trigger('click');
  });

  inpFile1.change(function () {
    var txt = jQuery(this).val();

    // Slice file path
    var sliceStart = txt.lastIndexOf('\\') + 1;
    var txt = txt.slice(sliceStart);

    jQuery('span', btnFileFake1).text(txt);
    jQuery('span', btnFileFake1).css('color', '#2bd222');

    console.log(jQuery('span', inpFile1));

    btnFileOpen1.fadeOut(100);
    btnFileDel1.fadeIn(300);
  });
  inpFile2.change(function () {
    var txt = jQuery(this).val();

    // Slice file path
    var sliceStart = txt.lastIndexOf('\\') + 1;
    var txt = txt.slice(sliceStart);

    jQuery('span', btnFileFake1).text(txt);
    jQuery('span', btnFileFake2).css('color', '#2bd222');

    console.log(jQuery('span', inpFile2));

    btnFileOpen2.fadeOut(100);
    btnFileDel2.fadeIn(300);
  });

  btnFileDel1.click(function (e) {
    jQuery('span', btnFileFake1).css('color', '#636363');
    jQuery('span', btnFileFake1).text('Załącz plik #1');

    inpFile1.val('');

    btnFileOpen1.fadeIn(300);
    jQuery(this).fadeOut(100);
    e.stopPropagation();
  });

  btnFileDel2.click(function (e) {
    jQuery('span', btnFileFake2).css('color', '#636363');
    jQuery('span', btnFileFake2).text('Załącz plik #2');

    inpFile2.val('');

    btnFileOpen2.fadeIn(300);
    jQuery(this).fadeOut(100);
    e.stopPropagation();
  });

  /*
   * Submit Form
   */
  (($) => {
    var $btnSubmit = $('.drop_form_btn-submit');

    console.log($btnSubmit);

    $btnSubmit.attr('disabled', 'disabled');
  })(jQuery);

  /*
   * Submit Form
   */
  esFormCnt.each(function (i) {
    var btnSubmit = jQuery('input[type=submit]', esFormCnt.get(i)),
      inpFields = jQuery('input[type=text]', esFormCnt.get(i))
        .add(jQuery('input[type=email]', esFormCnt.get(i)))
        .add(jQuery('input[type=tel]', esFormCnt.get(i)))
        .add(jQuery('input[type=url]', esFormCnt.get(i)));

    btnSubmit.on('click', function (e) {
      // e.preventDefault();
      return;

      check = false;

      inpFields.each(function (i) {
        var _check = jQuery(inpFields.get(i)).hasClass('m--valid');

        check = true;

        if (!_check) {
          check = false;
        }
      });

      if (check) {
        jQuery('.form_submitted', esFormCnt.get(i)).fadeIn(500);
        console.log('success');
      } else {
        console.log('error');
      }

      // console.log('click!');
    });
  });

  /*
   * Terms Checkbox
   */

  var btnTermsCheck = jQuery('.b-terms-accept'),
    esFormSubmitBtn = jQuery('.drop_form input[type=submit]');

  btnTermsCheck.on('click', function () {
    if (jQuery(this).hasClass('active')) {
      jQuery(this).removeClass('active');
      esFormSubmitBtn.attr('disabled', 'disabled');
    } else {
      jQuery(this).addClass('active');
      esFormSubmitBtn.removeAttr('disabled');
    }
  });

  var lnkRegulars = jQuery('.b-terms-accept > a');

  lnkRegulars.on('mouseenter', function () {
    var drop = jQuery('.terms-accept_drop');

    drop.fadeIn(500);
  });

  jQuery('.terms-accept_drop').on('mouseleave', function () {
    var drop = jQuery('.terms-accept_drop');

    drop.fadeOut(500);
  });

  /*
   * Form Validation
   */
  var bCareerForm = jQuery('.drop_form form');

  bCareerForm.each(function (i) {
    jQuery(bCareerForm.get(i)).validate({
      errorClass: 'm--error',
      validClass: 'm--valid',
      onfocusout: function (element, event) {
        console.log(element, event);

        if (jQuery(element).val().length == 0) {
          jQuery(element).removeClass('m--valid').removeClass('m--error');
          return;
        }

        jQuery(element).valid();
        // return true;
      },

      highlight: function (element, errorClass, validClass) {
        jQuery(element).addClass(errorClass).removeClass(validClass);
      },

      unhighlight: function (element, errorClass, validClass) {
        jQuery(element).removeClass(errorClass).addClass(validClass);
      },

      showErrors: function (errorMap, errorList) {
        jQuery('#summary').html(
          'Your form contains ' +
            this.numberOfInvalids() +
            ' errors, see details below.'
        );
        this.defaultShowErrors();
      },
    });
  });
});

/* ==============================
 * page Offer
 * ============================== */

jQuery(document).ready(function () {
  jQuery('#offer_slider').owlCarousel({
    items: 1,
  });
});

/* ==============================
 * TRANSIT
 * ============================== */

/*!
 * jQuery Transit - CSS3 transitions and transformations
 * (c) 2011-2014 Rico Sta. Cruz
 * MIT Licensed.
 *
 * http://ricostacruz.com/jquery.transit
 * http://github.com/rstacruz/jquery.transit
 */

/* jshint expr: true */

(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    module.exports = factory(require('jquery'));
  } else {
    factory(root.jQuery);
  }
})(this, function ($) {
  $.transit = {
    version: '0.9.12',

    // Map of $.css() keys to values for 'transitionProperty'.
    // See https://developer.mozilla.org/en/CSS/CSS_transitions#Properties_that_can_be_animated
    propertyMap: {
      marginLeft: 'margin',
      marginRight: 'margin',
      marginBottom: 'margin',
      marginTop: 'margin',
      paddingLeft: 'padding',
      paddingRight: 'padding',
      paddingBottom: 'padding',
      paddingTop: 'padding',
    },

    // Will simply transition "instantly" if false
    enabled: true,

    // Set this to false if you don't want to use the transition end property.
    useTransitionEnd: false,
  };

  var div = document.createElement('div');
  var support = {};

  // Helper function to get the proper vendor property name.
  // (`transition` => `WebkitTransition`)
  function getVendorPropertyName(prop) {
    // Handle unprefixed versions (FF16+, for example)
    if (prop in div.style) return prop;

    var prefixes = ['Moz', 'Webkit', 'O', 'ms'];
    var prop_ = prop.charAt(0).toUpperCase() + prop.substr(1);

    for (var i = 0; i < prefixes.length; ++i) {
      var vendorProp = prefixes[i] + prop_;
      if (vendorProp in div.style) {
        return vendorProp;
      }
    }
  }

  // Helper function to check if transform3D is supported.
  // Should return true for Webkits and Firefox 10+.
  function checkTransform3dSupport() {
    div.style[support.transform] = '';
    div.style[support.transform] = 'rotateY(90deg)';
    return div.style[support.transform] !== '';
  }

  var isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;

  // Check for the browser's transitions support.
  support.transition = getVendorPropertyName('transition');
  support.transitionDelay = getVendorPropertyName('transitionDelay');
  support.transform = getVendorPropertyName('transform');
  support.transformOrigin = getVendorPropertyName('transformOrigin');
  support.filter = getVendorPropertyName('Filter');
  support.transform3d = checkTransform3dSupport();

  var eventNames = {
    transition: 'transitionend',
    MozTransition: 'transitionend',
    OTransition: 'oTransitionEnd',
    WebkitTransition: 'webkitTransitionEnd',
    msTransition: 'MSTransitionEnd',
  };

  // Detect the 'transitionend' event needed.
  var transitionEnd = (support.transitionEnd =
    eventNames[support.transition] || null);

  // Populate jQuery's `$.support` with the vendor prefixes we know.
  // As per [jQuery's cssHooks documentation](http://api.jquery.com/jQuery.cssHooks/),
  // we set $.support.transition to a string of the actual property name used.
  for (var key in support) {
    if (support.hasOwnProperty(key) && typeof $.support[key] === 'undefined') {
      $.support[key] = support[key];
    }
  }

  // Avoid memory leak in IE.
  div = null;

  // ## $.cssEase
  // List of easing aliases that you can use with `$.fn.transition`.
  $.cssEase = {
    _default: 'ease',
    in: 'ease-in',
    out: 'ease-out',
    'in-out': 'ease-in-out',
    snap: 'cubic-bezier(0,1,.5,1)',
    // Penner equations
    easeInCubic: 'cubic-bezier(.550,.055,.675,.190)',
    easeOutCubic: 'cubic-bezier(.215,.61,.355,1)',
    easeInOutCubic: 'cubic-bezier(.645,.045,.355,1)',
    easeInCirc: 'cubic-bezier(.6,.04,.98,.335)',
    easeOutCirc: 'cubic-bezier(.075,.82,.165,1)',
    easeInOutCirc: 'cubic-bezier(.785,.135,.15,.86)',
    easeInExpo: 'cubic-bezier(.95,.05,.795,.035)',
    easeOutExpo: 'cubic-bezier(.19,1,.22,1)',
    easeInOutExpo: 'cubic-bezier(1,0,0,1)',
    easeInQuad: 'cubic-bezier(.55,.085,.68,.53)',
    easeOutQuad: 'cubic-bezier(.25,.46,.45,.94)',
    easeInOutQuad: 'cubic-bezier(.455,.03,.515,.955)',
    easeInQuart: 'cubic-bezier(.895,.03,.685,.22)',
    easeOutQuart: 'cubic-bezier(.165,.84,.44,1)',
    easeInOutQuart: 'cubic-bezier(.77,0,.175,1)',
    easeInQuint: 'cubic-bezier(.755,.05,.855,.06)',
    easeOutQuint: 'cubic-bezier(.23,1,.32,1)',
    easeInOutQuint: 'cubic-bezier(.86,0,.07,1)',
    easeInSine: 'cubic-bezier(.47,0,.745,.715)',
    easeOutSine: 'cubic-bezier(.39,.575,.565,1)',
    easeInOutSine: 'cubic-bezier(.445,.05,.55,.95)',
    easeInBack: 'cubic-bezier(.6,-.28,.735,.045)',
    easeOutBack: 'cubic-bezier(.175, .885,.32,1.275)',
    easeInOutBack: 'cubic-bezier(.68,-.55,.265,1.55)',
  };

  // ## 'transform' CSS hook
  // Allows you to use the `transform` property in CSS.
  //
  //     $("#hello").css({ transform: "rotate(90deg)" });
  //
  //     $("#hello").css('transform');
  //     //=> { rotate: '90deg' }
  //
  $.cssHooks['transit:transform'] = {
    // The getter returns a `Transform` object.
    get: function (elem) {
      return $(elem).data('transform') || new Transform();
    },

    // The setter accepts a `Transform` object or a string.
    set: function (elem, v) {
      var value = v;

      if (!(value instanceof Transform)) {
        value = new Transform(value);
      }

      // We've seen the 3D version of Scale() not work in Chrome when the
      // element being scaled extends outside of the viewport.  Thus, we're
      // forcing Chrome to not use the 3d transforms as well.  Not sure if
      // translate is affectede, but not risking it.  Detection code from
      // http://davidwalsh.name/detecting-google-chrome-javascript
      if (support.transform === 'WebkitTransform' && !isChrome) {
        elem.style[support.transform] = value.toString(true);
      } else {
        elem.style[support.transform] = value.toString();
      }

      $(elem).data('transform', value);
    },
  };

  // Add a CSS hook for `.css({ transform: '...' })`.
  // In jQuery 1.8+, this will intentionally override the default `transform`
  // CSS hook so it'll play well with Transit. (see issue #62)
  $.cssHooks.transform = {
    set: $.cssHooks['transit:transform'].set,
  };

  // ## 'filter' CSS hook
  // Allows you to use the `filter` property in CSS.
  //
  //     $("#hello").css({ filter: 'blur(10px)' });
  //
  $.cssHooks.filter = {
    get: function (elem) {
      return elem.style[support.filter];
    },
    set: function (elem, value) {
      elem.style[support.filter] = value;
    },
  };

  // jQuery 1.8+ supports prefix-free transitions, so these polyfills will not
  // be necessary.
  if ($.fn.jquery < '1.8') {
    // ## 'transformOrigin' CSS hook
    // Allows the use for `transformOrigin` to define where scaling and rotation
    // is pivoted.
    //
    //     $("#hello").css({ transformOrigin: '0 0' });
    //
    $.cssHooks.transformOrigin = {
      get: function (elem) {
        return elem.style[support.transformOrigin];
      },
      set: function (elem, value) {
        elem.style[support.transformOrigin] = value;
      },
    };

    // ## 'transition' CSS hook
    // Allows you to use the `transition` property in CSS.
    //
    //     $("#hello").css({ transition: 'all 0 ease 0' });
    //
    $.cssHooks.transition = {
      get: function (elem) {
        return elem.style[support.transition];
      },
      set: function (elem, value) {
        elem.style[support.transition] = value;
      },
    };
  }

  // ## Other CSS hooks
  // Allows you to rotate, scale and translate.
  registerCssHook('scale');
  registerCssHook('scaleX');
  registerCssHook('scaleY');
  registerCssHook('translate');
  registerCssHook('rotate');
  registerCssHook('rotateX');
  registerCssHook('rotateY');
  registerCssHook('rotate3d');
  registerCssHook('perspective');
  registerCssHook('skewX');
  registerCssHook('skewY');
  registerCssHook('x', true);
  registerCssHook('y', true);

  // ## Transform class
  // This is the main class of a transformation property that powers
  // `$.fn.css({ transform: '...' })`.
  //
  // This is, in essence, a dictionary object with key/values as `-transform`
  // properties.
  //
  //     var t = new Transform("rotate(90) scale(4)");
  //
  //     t.rotate             //=> "90deg"
  //     t.scale              //=> "4,4"
  //
  // Setters are accounted for.
  //
  //     t.set('rotate', 4)
  //     t.rotate             //=> "4deg"
  //
  // Convert it to a CSS string using the `toString()` and `toString(true)` (for WebKit)
  // functions.
  //
  //     t.toString()         //=> "rotate(90deg) scale(4,4)"
  //     t.toString(true)     //=> "rotate(90deg) scale3d(4,4,0)" (WebKit version)
  //
  function Transform(str) {
    if (typeof str === 'string') {
      this.parse(str);
    }
    return this;
  }

  Transform.prototype = {
    // ### setFromString()
    // Sets a property from a string.
    //
    //     t.setFromString('scale', '2,4');
    //     // Same as set('scale', '2', '4');
    //
    setFromString: function (prop, val) {
      var args =
        typeof val === 'string'
          ? val.split(',')
          : val.constructor === Array
          ? val
          : [val];

      args.unshift(prop);

      Transform.prototype.set.apply(this, args);
    },

    // ### set()
    // Sets a property.
    //
    //     t.set('scale', 2, 4);
    //
    set: function (prop) {
      var args = Array.prototype.slice.apply(arguments, [1]);
      if (this.setter[prop]) {
        this.setter[prop].apply(this, args);
      } else {
        this[prop] = args.join(',');
      }
    },

    get: function (prop) {
      if (this.getter[prop]) {
        return this.getter[prop].apply(this);
      } else {
        return this[prop] || 0;
      }
    },

    setter: {
      // ### rotate
      //
      //     .css({ rotate: 30 })
      //     .css({ rotate: "30" })
      //     .css({ rotate: "30deg" })
      //     .css({ rotate: "30deg" })
      //
      rotate: function (theta) {
        this.rotate = unit(theta, 'deg');
      },

      rotateX: function (theta) {
        this.rotateX = unit(theta, 'deg');
      },

      rotateY: function (theta) {
        this.rotateY = unit(theta, 'deg');
      },

      // ### scale
      //
      //     .css({ scale: 9 })      //=> "scale(9,9)"
      //     .css({ scale: '3,2' })  //=> "scale(3,2)"
      //
      scale: function (x, y) {
        if (y === undefined) {
          y = x;
        }
        this.scale = x + ',' + y;
      },

      // ### skewX + skewY
      skewX: function (x) {
        this.skewX = unit(x, 'deg');
      },

      skewY: function (y) {
        this.skewY = unit(y, 'deg');
      },

      // ### perspectvie
      perspective: function (dist) {
        this.perspective = unit(dist, 'px');
      },

      // ### x / y
      // Translations. Notice how this keeps the other value.
      //
      //     .css({ x: 4 })       //=> "translate(4px, 0)"
      //     .css({ y: 10 })      //=> "translate(4px, 10px)"
      //
      x: function (x) {
        this.set('translate', x, null);
      },

      y: function (y) {
        this.set('translate', null, y);
      },

      // ### translate
      // Notice how this keeps the other value.
      //
      //     .css({ translate: '2, 5' })    //=> "translate(2px, 5px)"
      //
      translate: function (x, y) {
        if (this._translateX === undefined) {
          this._translateX = 0;
        }
        if (this._translateY === undefined) {
          this._translateY = 0;
        }

        if (x !== null && x !== undefined) {
          this._translateX = unit(x, 'px');
        }
        if (y !== null && y !== undefined) {
          this._translateY = unit(y, 'px');
        }

        this.translate = this._translateX + ',' + this._translateY;
      },
    },

    getter: {
      x: function () {
        return this._translateX || 0;
      },

      y: function () {
        return this._translateY || 0;
      },

      scale: function () {
        var s = (this.scale || '1,1').split(',');
        if (s[0]) {
          s[0] = parseFloat(s[0]);
        }
        if (s[1]) {
          s[1] = parseFloat(s[1]);
        }

        // "2.5,2.5" => 2.5
        // "2.5,1" => [2.5,1]
        return s[0] === s[1] ? s[0] : s;
      },

      rotate3d: function () {
        var s = (this.rotate3d || '0,0,0,0deg').split(',');
        for (var i = 0; i <= 3; ++i) {
          if (s[i]) {
            s[i] = parseFloat(s[i]);
          }
        }
        if (s[3]) {
          s[3] = unit(s[3], 'deg');
        }

        return s;
      },
    },

    // ### parse()
    // Parses from a string. Called on constructor.
    parse: function (str) {
      var self = this;
      str.replace(/([a-zA-Z0-9]+)\((.*?)\)/g, function (x, prop, val) {
        self.setFromString(prop, val);
      });
    },

    // ### toString()
    // Converts to a `transition` CSS property string. If `use3d` is given,
    // it converts to a `-webkit-transition` CSS property string instead.
    toString: function (use3d) {
      var re = [];

      for (var i in this) {
        if (this.hasOwnProperty(i)) {
          // Don't use 3D transformations if the browser can't support it.
          if (
            !support.transform3d &&
            (i === 'rotateX' ||
              i === 'rotateY' ||
              i === 'perspective' ||
              i === 'transformOrigin')
          ) {
            continue;
          }

          if (i[0] !== '_') {
            if (use3d && i === 'scale') {
              re.push(i + '3d(' + this[i] + ',1)');
            } else if (use3d && i === 'translate') {
              re.push(i + '3d(' + this[i] + ',0)');
            } else {
              re.push(i + '(' + this[i] + ')');
            }
          }
        }
      }

      return re.join(' ');
    },
  };

  function callOrQueue(self, queue, fn) {
    if (queue === true) {
      self.queue(fn);
    } else if (queue) {
      self.queue(queue, fn);
    } else {
      self.each(function () {
        fn.call(this);
      });
    }
  }

  // ### getProperties(dict)
  // Returns properties (for `transition-property`) for dictionary `props`. The
  // value of `props` is what you would expect in `$.css(...)`.
  function getProperties(props) {
    var re = [];

    $.each(props, function (key) {
      key = $.camelCase(key); // Convert "text-align" => "textAlign"
      key = $.transit.propertyMap[key] || $.cssProps[key] || key;
      key = uncamel(key); // Convert back to dasherized

      // Get vendor specify propertie
      if (support[key]) key = uncamel(support[key]);

      if ($.inArray(key, re) === -1) {
        re.push(key);
      }
    });

    return re;
  }

  // ### getTransition()
  // Returns the transition string to be used for the `transition` CSS property.
  //
  // Example:
  //
  //     getTransition({ opacity: 1, rotate: 30 }, 500, 'ease');
  //     //=> 'opacity 500ms ease, -webkit-transform 500ms ease'
  //
  function getTransition(properties, duration, easing, delay) {
    // Get the CSS properties needed.
    var props = getProperties(properties);

    // Account for aliases (`in` => `ease-in`).
    if ($.cssEase[easing]) {
      easing = $.cssEase[easing];
    }

    // Build the duration/easing/delay attributes for it.
    var attribs = '' + toMS(duration) + ' ' + easing;
    if (parseInt(delay, 10) > 0) {
      attribs += ' ' + toMS(delay);
    }

    // For more properties, add them this way:
    // "margin 200ms ease, padding 200ms ease, ..."
    var transitions = [];
    $.each(props, function (i, name) {
      transitions.push(name + ' ' + attribs);
    });

    return transitions.join(', ');
  }

  // ## $.fn.transition
  // Works like $.fn.animate(), but uses CSS transitions.
  //
  //     $("...").transition({ opacity: 0.1, scale: 0.3 });
  //
  //     // Specific duration
  //     $("...").transition({ opacity: 0.1, scale: 0.3 }, 500);
  //
  //     // With duration and easing
  //     $("...").transition({ opacity: 0.1, scale: 0.3 }, 500, 'in');
  //
  //     // With callback
  //     $("...").transition({ opacity: 0.1, scale: 0.3 }, function() { ... });
  //
  //     // With everything
  //     $("...").transition({ opacity: 0.1, scale: 0.3 }, 500, 'in', function() { ... });
  //
  //     // Alternate syntax
  //     $("...").transition({
  //       opacity: 0.1,
  //       duration: 200,
  //       delay: 40,
  //       easing: 'in',
  //       complete: function() { /* ... */ }
  //      });
  //
  $.fn.transition = $.fn.transit = function (
    properties,
    duration,
    easing,
    callback
  ) {
    var self = this;
    var delay = 0;
    var queue = true;

    var theseProperties = $.extend(true, {}, properties);

    // Account for `.transition(properties, callback)`.
    if (typeof duration === 'function') {
      callback = duration;
      duration = undefined;
    }

    // Account for `.transition(properties, options)`.
    if (typeof duration === 'object') {
      easing = duration.easing;
      delay = duration.delay || 0;
      queue = typeof duration.queue === 'undefined' ? true : duration.queue;
      callback = duration.complete;
      duration = duration.duration;
    }

    // Account for `.transition(properties, duration, callback)`.
    if (typeof easing === 'function') {
      callback = easing;
      easing = undefined;
    }

    // Alternate syntax.
    if (typeof theseProperties.easing !== 'undefined') {
      easing = theseProperties.easing;
      delete theseProperties.easing;
    }

    if (typeof theseProperties.duration !== 'undefined') {
      duration = theseProperties.duration;
      delete theseProperties.duration;
    }

    if (typeof theseProperties.complete !== 'undefined') {
      callback = theseProperties.complete;
      delete theseProperties.complete;
    }

    if (typeof theseProperties.queue !== 'undefined') {
      queue = theseProperties.queue;
      delete theseProperties.queue;
    }

    if (typeof theseProperties.delay !== 'undefined') {
      delay = theseProperties.delay;
      delete theseProperties.delay;
    }

    // Set defaults. (`400` duration, `ease` easing)
    if (typeof duration === 'undefined') {
      duration = $.fx.speeds._default;
    }
    if (typeof easing === 'undefined') {
      easing = $.cssEase._default;
    }

    duration = toMS(duration);

    // Build the `transition` property.
    var transitionValue = getTransition(
      theseProperties,
      duration,
      easing,
      delay
    );

    // Compute delay until callback.
    // If this becomes 0, don't bother setting the transition property.
    var work = $.transit.enabled && support.transition;
    var i = work ? parseInt(duration, 10) + parseInt(delay, 10) : 0;

    // If there's nothing to do...
    if (i === 0) {
      var fn = function (next) {
        self.css(theseProperties);
        if (callback) {
          callback.apply(self);
        }
        if (next) {
          next();
        }
      };

      callOrQueue(self, queue, fn);
      return self;
    }

    // Save the old transitions of each element so we can restore it later.
    var oldTransitions = {};

    var run = function (nextCall) {
      var bound = false;

      // Prepare the callback.
      var cb = function () {
        if (bound) {
          self.unbind(transitionEnd, cb);
        }

        if (i > 0) {
          self.each(function () {
            this.style[support.transition] = oldTransitions[this] || null;
          });
        }

        if (typeof callback === 'function') {
          callback.apply(self);
        }
        if (typeof nextCall === 'function') {
          nextCall();
        }
      };

      if (i > 0 && transitionEnd && $.transit.useTransitionEnd) {
        // Use the 'transitionend' event if it's available.
        bound = true;
        self.bind(transitionEnd, cb);
      } else {
        // Fallback to timers if the 'transitionend' event isn't supported.
        window.setTimeout(cb, i);
      }

      // Apply transitions.
      self.each(function () {
        if (i > 0) {
          this.style[support.transition] = transitionValue;
        }
        $(this).css(theseProperties);
      });
    };

    // Defer running. This allows the browser to paint any pending CSS it hasn't
    // painted yet before doing the transitions.
    var deferredRun = function (next) {
      this.offsetWidth = this.offsetWidth; // force a repaint
      run(next);
    };

    // Use jQuery's fx queue.
    callOrQueue(self, queue, deferredRun);

    // Chainability.
    return this;
  };

  function registerCssHook(prop, isPixels) {
    // For certain properties, the 'px' should not be implied.
    if (!isPixels) {
      $.cssNumber[prop] = true;
    }

    $.transit.propertyMap[prop] = support.transform;

    $.cssHooks[prop] = {
      get: function (elem) {
        var t = $(elem).css('transit:transform');
        return t.get(prop);
      },

      set: function (elem, value) {
        var t = $(elem).css('transit:transform');
        t.setFromString(prop, value);

        $(elem).css({ 'transit:transform': t });
      },
    };
  }

  // ### uncamel(str)
  // Converts a camelcase string to a dasherized string.
  // (`marginLeft` => `margin-left`)
  function uncamel(str) {
    return str.replace(/([A-Z])/g, function (letter) {
      return '-' + letter.toLowerCase();
    });
  }

  // ### unit(number, unit)
  // Ensures that number `number` has a unit. If no unit is found, assume the
  // default is `unit`.
  //
  //     unit(2, 'px')          //=> "2px"
  //     unit("30deg", 'rad')   //=> "30deg"
  //
  function unit(i, units) {
    if (typeof i === 'string' && !i.match(/^[\-0-9\.]+$/)) {
      return i;
    } else {
      return '' + i + units;
    }
  }

  // ### toMS(duration)
  // Converts given `duration` to a millisecond string.
  //
  // toMS('fast') => $.fx.speeds[i] => "200ms"
  // toMS('normal') //=> $.fx.speeds._default => "400ms"
  // toMS(10) //=> '10ms'
  // toMS('100ms') //=> '100ms'
  //
  function toMS(duration) {
    var i = duration;

    // Allow string durations like 'fast' and 'slow', without overriding numeric values.
    if (typeof i === 'string' && !i.match(/^[\-0-9\.]+/)) {
      i = $.fx.speeds[i] || $.fx.speeds._default;
    }

    return unit(i, 'ms');
  }

  // Export some functions for testable-ness.
  $.transit.getTransitionValue = getTransition;

  return $;
});

/* ==============================
 * PORTFOLIO EMAIL
 * ============================== */
(function ($) {
  var $form = $('form.drop_form'),
    $btnSub = $('input.form_btn-submit'),
    $inpFirstName = $('input.drop_form_inp-first-name'),
    $inpLastName = $('input.drop_form_inp-last-name'),
    $inpSity = $('input.drop_form_inp-sity'),
    $inpTel = $('input.drop_form_inp-tel'),
    $inpEmail = $('input.drop_form_inp-email'),
    $inpLink = $('input.drop_form_inp-link'),
    $inpFile1 = $('input.drop_form_inp-file1');

  $btnSub.on('click', (e) => {
    console.log('-- submit form');

    // e.preventDefault();
    return;

    var formData = new FormData($form[0]);
    console.log(formData);

    // Collect Data
    var data = {};

    data.firstName = $inpFirstName.val();
    data.lastName = $inpLastName.val();
    data.sity = $inpSity.val();
    data.tel = $inpTel.val();
    data.email = $inpEmail.val();
    data.link = $inpLink.val();
    data.file1 = $inpFile1.val();

    // Log
    console.log(data);

    $form.trigger('submit');

    // $.ajax({
    // 	url: pzl.url.ajax,
    // 	type: 'post',
    // 	// async: false,
    // 	// cache: false,
    // 	// contentType: false,
    // 	// processData: false,
    // 	// contentType: "multipart/form-data",
    // 	data: {
    // 		action: 'form_portfolio',
    // 		data:   data,
    // 	},
    // 	success: function(res){
    // 		console.log('-- response');
    // 		console.log(res);
    // 	},
    // 	error: function(res){
    // 		console.log('-- error');
    // 		console.log(res);
    // 	}
    // });
  });
})(jQuery);

/* ==============================
 * FANCYBOX
 * ============================== */

// ==================================================
// fancyBox v3.3.5
//
// Licensed GPLv3 for open source use
// or fancyBox Commercial License for commercial use
//
// http://fancyapps.com/fancybox/
// Copyright 2018 fancyApps
//
// ==================================================
!(function (t, e, n, o) {
  'use strict';
  function i(t, e) {
    var o,
      i,
      a = [],
      s = 0;
    (t && t.isDefaultPrevented()) ||
      (t.preventDefault(),
      (e = t && t.data ? t.data.options : e || {}),
      (o = e.$target || n(t.currentTarget)),
      (i = o.attr('data-fancybox') || ''),
      i
        ? ((a = e.selector ? n(e.selector) : t.data ? t.data.items : []),
          (a = a.length
            ? a.filter('[data-fancybox="' + i + '"]')
            : n('[data-fancybox="' + i + '"]')),
          (s = a.index(o)),
          s < 0 && (s = 0))
        : (a = [o]),
      n.fancybox.open(a, e, s));
  }
  if (((t.console = t.console || { info: function (t) {} }), n)) {
    if (n.fn.fancybox) return void console.info('fancyBox already initialized');
    var a = {
        loop: !1,
        gutter: 50,
        keyboard: !0,
        arrows: !0,
        infobar: !0,
        smallBtn: 'auto',
        toolbar: 'auto',
        buttons: ['zoom', 'thumbs', 'close'],
        idleTime: 3,
        protect: !1,
        modal: !1,
        image: { preload: !1 },
        ajax: { settings: { data: { fancybox: !0 } } },
        iframe: {
          tpl:
            '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen allowtransparency="true" src=""></iframe>',
          preload: !0,
          css: {},
          attr: { scrolling: 'auto' },
        },
        defaultType: 'image',
        animationEffect: 'zoom',
        animationDuration: 366,
        zoomOpacity: 'auto',
        transitionEffect: 'fade',
        transitionDuration: 366,
        slideClass: '',
        baseClass: '',
        baseTpl:
          '<div class="fancybox-container" role="dialog" tabindex="-1"><div class="fancybox-bg"></div><div class="fancybox-inner"><div class="fancybox-infobar"><span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span></div><div class="fancybox-toolbar">{{buttons}}</div><div class="fancybox-navigation">{{arrows}}</div><div class="fancybox-stage"></div><div class="fancybox-caption"></div></div></div>',
        spinnerTpl: '<div class="fancybox-loading"></div>',
        errorTpl: '<div class="fancybox-error"><p>{{ERROR}}</p></div>',
        btnTpl: {
          download:
            '<a download data-fancybox-download class="fancybox-button fancybox-button--download" title="{{DOWNLOAD}}" href="javascript:;"><svg viewBox="0 0 40 40"><path d="M13,16 L20,23 L27,16 M20,7 L20,23 M10,24 L10,28 L30,28 L30,24" /></svg></a>',
          zoom:
            '<button data-fancybox-zoom class="fancybox-button fancybox-button--zoom" title="{{ZOOM}}"><svg viewBox="0 0 40 40"><path d="M18,17 m-8,0 a8,8 0 1,0 16,0 a8,8 0 1,0 -16,0 M24,22 L31,29" /></svg></button>',
          close:
            '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="{{CLOSE}}"><svg viewBox="0 0 40 40"><path d="M10,10 L30,30 M30,10 L10,30" /></svg></button>',
          smallBtn:
            '<button data-fancybox-close class="fancybox-close-small" title="{{CLOSE}}"><svg viewBox="0 0 32 32"><path d="M10,10 L22,22 M22,10 L10,22"></path></svg></button>',
          arrowLeft:
            '<a data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}" href="javascript:;"><svg viewBox="0 0 40 40"><path d="M18,12 L10,20 L18,28 M10,20 L30,20"></path></svg></a>',
          arrowRight:
            '<a data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}" href="javascript:;"><svg viewBox="0 0 40 40"><path d="M10,20 L30,20 M22,12 L30,20 L22,28"></path></svg></a>',
        },
        parentEl: 'body',
        autoFocus: !1,
        backFocus: !0,
        trapFocus: !0,
        fullScreen: { autoStart: !1 },
        touch: { vertical: !0, momentum: !0 },
        hash: null,
        media: {},
        slideShow: { autoStart: !1, speed: 4e3 },
        thumbs: {
          autoStart: !1,
          hideOnClose: !0,
          parentEl: '.fancybox-container',
          axis: 'y',
        },
        wheel: 'auto',
        onInit: n.noop,
        beforeLoad: n.noop,
        afterLoad: n.noop,
        beforeShow: n.noop,
        afterShow: n.noop,
        beforeClose: n.noop,
        afterClose: n.noop,
        onActivate: n.noop,
        onDeactivate: n.noop,
        clickContent: function (t, e) {
          return 'image' === t.type && 'zoom';
        },
        clickSlide: 'close',
        clickOutside: 'close',
        dblclickContent: !1,
        dblclickSlide: !1,
        dblclickOutside: !1,
        mobile: {
          idleTime: !1,
          clickContent: function (t, e) {
            return 'image' === t.type && 'toggleControls';
          },
          clickSlide: function (t, e) {
            return 'image' === t.type ? 'toggleControls' : 'close';
          },
          dblclickContent: function (t, e) {
            return 'image' === t.type && 'zoom';
          },
          dblclickSlide: function (t, e) {
            return 'image' === t.type && 'zoom';
          },
        },
        lang: 'en',
        i18n: {
          en: {
            CLOSE: 'Close',
            NEXT: 'Next',
            PREV: 'Previous',
            ERROR:
              'The requested content cannot be loaded. <br/> Please try again later.',
            PLAY_START: 'Start slideshow',
            PLAY_STOP: 'Pause slideshow',
            FULL_SCREEN: 'Full screen',
            THUMBS: 'Thumbnails',
            DOWNLOAD: 'Download',
            SHARE: 'Share',
            ZOOM: 'Zoom',
          },
          de: {
            CLOSE: 'Schliessen',
            NEXT: 'Weiter',
            PREV: 'Zurück',
            ERROR:
              'Die angeforderten Daten konnten nicht geladen werden. <br/> Bitte versuchen Sie es später nochmal.',
            PLAY_START: 'Diaschau starten',
            PLAY_STOP: 'Diaschau beenden',
            FULL_SCREEN: 'Vollbild',
            THUMBS: 'Vorschaubilder',
            DOWNLOAD: 'Herunterladen',
            SHARE: 'Teilen',
            ZOOM: 'Maßstab',
          },
        },
      },
      s = n(t),
      r = n(e),
      c = 0,
      l = function (t) {
        return t && t.hasOwnProperty && t instanceof n;
      },
      d = (function () {
        return (
          t.requestAnimationFrame ||
          t.webkitRequestAnimationFrame ||
          t.mozRequestAnimationFrame ||
          t.oRequestAnimationFrame ||
          function (e) {
            return t.setTimeout(e, 1e3 / 60);
          }
        );
      })(),
      u = (function () {
        var t,
          n = e.createElement('fakeelement'),
          i = {
            transition: 'transitionend',
            OTransition: 'oTransitionEnd',
            MozTransition: 'transitionend',
            WebkitTransition: 'webkitTransitionEnd',
          };
        for (t in i) if (n.style[t] !== o) return i[t];
        return 'transitionend';
      })(),
      f = function (t) {
        return t && t.length && t[0].offsetHeight;
      },
      p = function (t, e) {
        var o = n.extend(!0, {}, t, e);
        return (
          n.each(e, function (t, e) {
            n.isArray(e) && (o[t] = e);
          }),
          o
        );
      },
      h = function (t, o, i) {
        var a = this;
        (a.opts = p({ index: i }, n.fancybox.defaults)),
          n.isPlainObject(o) && (a.opts = p(a.opts, o)),
          n.fancybox.isMobile && (a.opts = p(a.opts, a.opts.mobile)),
          (a.id = a.opts.id || ++c),
          (a.currIndex = parseInt(a.opts.index, 10) || 0),
          (a.prevIndex = null),
          (a.prevPos = null),
          (a.currPos = 0),
          (a.firstRun = !0),
          (a.group = []),
          (a.slides = {}),
          a.addContent(t),
          a.group.length &&
            ((a.$lastFocus = n(e.activeElement).trigger('blur')), a.init());
      };
    n.extend(h.prototype, {
      init: function () {
        var i,
          a,
          s,
          r = this,
          c = r.group[r.currIndex],
          l = c.opts,
          d = n.fancybox.scrollbarWidth;
        n.fancybox.getInstance() ||
          l.hideScrollbar === !1 ||
          (n('body').addClass('fancybox-active'),
          !n.fancybox.isMobile &&
            e.body.scrollHeight > t.innerHeight &&
            (d === o &&
              ((i = n(
                '<div style="width:100px;height:100px;overflow:scroll;" />'
              ).appendTo('body')),
              (d = n.fancybox.scrollbarWidth =
                i[0].offsetWidth - i[0].clientWidth),
              i.remove()),
            n('head').append(
              '<style id="fancybox-style-noscroll" type="text/css">.compensate-for-scrollbar { margin-right: ' +
                d +
                'px; }</style>'
            ),
            n('body').addClass('compensate-for-scrollbar'))),
          (s = ''),
          n.each(l.buttons, function (t, e) {
            s += l.btnTpl[e] || '';
          }),
          (a = n(
            r.translate(
              r,
              l.baseTpl
                .replace('{{buttons}}', s)
                .replace('{{arrows}}', l.btnTpl.arrowLeft + l.btnTpl.arrowRight)
            )
          )
            .attr('id', 'fancybox-container-' + r.id)
            .addClass('fancybox-is-hidden')
            .addClass(l.baseClass)
            .data('FancyBox', r)
            .appendTo(l.parentEl)),
          (r.$refs = { container: a }),
          [
            'bg',
            'inner',
            'infobar',
            'toolbar',
            'stage',
            'caption',
            'navigation',
          ].forEach(function (t) {
            r.$refs[t] = a.find('.fancybox-' + t);
          }),
          r.trigger('onInit'),
          r.activate(),
          r.jumpTo(r.currIndex);
      },
      translate: function (t, e) {
        var n = t.opts.i18n[t.opts.lang];
        return e.replace(/\{\{(\w+)\}\}/g, function (t, e) {
          var i = n[e];
          return i === o ? t : i;
        });
      },
      addContent: function (t) {
        var e,
          i = this,
          a = n.makeArray(t);
        n.each(a, function (t, e) {
          var a,
            s,
            r,
            c,
            l,
            d = {},
            u = {};
          n.isPlainObject(e)
            ? ((d = e), (u = e.opts || e))
            : 'object' === n.type(e) && n(e).length
            ? ((a = n(e)),
              (u = a.data() || {}),
              (u = n.extend(!0, {}, u, u.options)),
              (u.$orig = a),
              (d.src = i.opts.src || u.src || a.attr('href')),
              d.type || d.src || ((d.type = 'inline'), (d.src = e)))
            : (d = { type: 'html', src: e + '' }),
            (d.opts = n.extend(!0, {}, i.opts, u)),
            n.isArray(u.buttons) && (d.opts.buttons = u.buttons),
            (s = d.type || d.opts.type),
            (c = d.src || ''),
            !s &&
              c &&
              ((r = c.match(/\.(mp4|mov|ogv)((\?|#).*)?$/i))
                ? ((s = 'video'),
                  d.opts.videoFormat ||
                    (d.opts.videoFormat =
                      'video/' + ('ogv' === r[1] ? 'ogg' : r[1])))
                : c.match(
                    /(^data:image\/[a-z0-9+\/=]*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg|ico)((\?|#).*)?$)/i
                  )
                ? (s = 'image')
                : c.match(/\.(pdf)((\?|#).*)?$/i)
                ? (s = 'iframe')
                : '#' === c.charAt(0) && (s = 'inline')),
            s ? (d.type = s) : i.trigger('objectNeedsType', d),
            d.contentType ||
              (d.contentType =
                n.inArray(d.type, ['html', 'inline', 'ajax']) > -1
                  ? 'html'
                  : d.type),
            (d.index = i.group.length),
            'auto' == d.opts.smallBtn &&
              (d.opts.smallBtn =
                n.inArray(d.type, ['html', 'inline', 'ajax']) > -1),
            'auto' === d.opts.toolbar && (d.opts.toolbar = !d.opts.smallBtn),
            d.opts.$trigger &&
              d.index === i.opts.index &&
              (d.opts.$thumb = d.opts.$trigger.find('img:first')),
            (d.opts.$thumb && d.opts.$thumb.length) ||
              !d.opts.$orig ||
              (d.opts.$thumb = d.opts.$orig.find('img:first')),
            'function' === n.type(d.opts.caption) &&
              (d.opts.caption = d.opts.caption.apply(e, [i, d])),
            'function' === n.type(i.opts.caption) &&
              (d.opts.caption = i.opts.caption.apply(e, [i, d])),
            d.opts.caption instanceof n ||
              (d.opts.caption =
                d.opts.caption === o ? '' : d.opts.caption + ''),
            'ajax' === d.type &&
              ((l = c.split(/\s+/, 2)),
              l.length > 1 &&
                ((d.src = l.shift()), (d.opts.filter = l.shift()))),
            d.opts.modal &&
              (d.opts = n.extend(!0, d.opts, {
                infobar: 0,
                toolbar: 0,
                smallBtn: 0,
                keyboard: 0,
                slideShow: 0,
                fullScreen: 0,
                thumbs: 0,
                touch: 0,
                clickContent: !1,
                clickSlide: !1,
                clickOutside: !1,
                dblclickContent: !1,
                dblclickSlide: !1,
                dblclickOutside: !1,
              })),
            i.group.push(d);
        }),
          Object.keys(i.slides).length &&
            (i.updateControls(),
            (e = i.Thumbs),
            e && e.isActive && (e.create(), e.focus()));
      },
      addEvents: function () {
        var o = this;
        o.removeEvents(),
          o.$refs.container
            .on('click.fb-close', '[data-fancybox-close]', function (t) {
              t.stopPropagation(), t.preventDefault(), o.close(t);
            })
            .on(
              'touchstart.fb-prev click.fb-prev',
              '[data-fancybox-prev]',
              function (t) {
                t.stopPropagation(), t.preventDefault(), o.previous();
              }
            )
            .on(
              'touchstart.fb-next click.fb-next',
              '[data-fancybox-next]',
              function (t) {
                t.stopPropagation(), t.preventDefault(), o.next();
              }
            )
            .on('click.fb', '[data-fancybox-zoom]', function (t) {
              o[o.isScaledDown() ? 'scaleToActual' : 'scaleToFit']();
            }),
          s.on('orientationchange.fb resize.fb', function (t) {
            t && t.originalEvent && 'resize' === t.originalEvent.type
              ? d(function () {
                  o.update();
                })
              : (o.$refs.stage.hide(),
                setTimeout(
                  function () {
                    o.$refs.stage.show(), o.update();
                  },
                  n.fancybox.isMobile ? 600 : 250
                ));
          }),
          r.on('focusin.fb', function (t) {
            var o = n.fancybox ? n.fancybox.getInstance() : null;
            o.isClosing ||
              !o.current ||
              !o.current.opts.trapFocus ||
              n(t.target).hasClass('fancybox-container') ||
              n(t.target).is(e) ||
              (o &&
                'fixed' !== n(t.target).css('position') &&
                !o.$refs.container.has(t.target).length &&
                (t.stopPropagation(), o.focus()));
          }),
          r.on('keydown.fb', function (t) {
            var e = o.current,
              i = t.keyCode || t.which;
            if (
              e &&
              e.opts.keyboard &&
              !(
                t.ctrlKey ||
                t.altKey ||
                t.shiftKey ||
                n(t.target).is('input') ||
                n(t.target).is('textarea')
              )
            )
              return 8 === i || 27 === i
                ? (t.preventDefault(), void o.close(t))
                : 37 === i || 38 === i
                ? (t.preventDefault(), void o.previous())
                : 39 === i || 40 === i
                ? (t.preventDefault(), void o.next())
                : void o.trigger('afterKeydown', t, i);
          }),
          o.group[o.currIndex].opts.idleTime &&
            ((o.idleSecondsCounter = 0),
            r.on(
              'mousemove.fb-idle mouseleave.fb-idle mousedown.fb-idle touchstart.fb-idle touchmove.fb-idle scroll.fb-idle keydown.fb-idle',
              function (t) {
                (o.idleSecondsCounter = 0),
                  o.isIdle && o.showControls(),
                  (o.isIdle = !1);
              }
            ),
            (o.idleInterval = t.setInterval(function () {
              o.idleSecondsCounter++,
                o.idleSecondsCounter >= o.group[o.currIndex].opts.idleTime &&
                  !o.isDragging &&
                  ((o.isIdle = !0),
                  (o.idleSecondsCounter = 0),
                  o.hideControls());
            }, 1e3)));
      },
      removeEvents: function () {
        var e = this;
        s.off('orientationchange.fb resize.fb'),
          r.off('focusin.fb keydown.fb .fb-idle'),
          this.$refs.container.off('.fb-close .fb-prev .fb-next'),
          e.idleInterval &&
            (t.clearInterval(e.idleInterval), (e.idleInterval = null));
      },
      previous: function (t) {
        return this.jumpTo(this.currPos - 1, t);
      },
      next: function (t) {
        return this.jumpTo(this.currPos + 1, t);
      },
      jumpTo: function (t, e) {
        var i,
          a,
          s,
          r,
          c,
          l,
          d,
          u = this,
          p = u.group.length;
        if (!(u.isDragging || u.isClosing || (u.isAnimating && u.firstRun))) {
          if (
            ((t = parseInt(t, 10)),
            (a = u.current ? u.current.opts.loop : u.opts.loop),
            !a && (t < 0 || t >= p))
          )
            return !1;
          if (
            ((i = u.firstRun = !Object.keys(u.slides).length),
            !(p < 2 && !i && u.isDragging))
          ) {
            if (
              ((r = u.current),
              (u.prevIndex = u.currIndex),
              (u.prevPos = u.currPos),
              (s = u.createSlide(t)),
              p > 1 &&
                ((a || s.index > 0) && u.createSlide(t - 1),
                (a || s.index < p - 1) && u.createSlide(t + 1)),
              (u.current = s),
              (u.currIndex = s.index),
              (u.currPos = s.pos),
              u.trigger('beforeShow', i),
              u.updateControls(),
              (l = n.fancybox.getTranslate(s.$slide)),
              (s.isMoved =
                (0 !== l.left || 0 !== l.top) &&
                !s.$slide.hasClass('fancybox-animated')),
              (s.forcedDuration = o),
              n.isNumeric(e)
                ? (s.forcedDuration = e)
                : (e = s.opts[i ? 'animationDuration' : 'transitionDuration']),
              (e = parseInt(e, 10)),
              i)
            )
              return (
                s.opts.animationEffect &&
                  e &&
                  u.$refs.container.css('transition-duration', e + 'ms'),
                u.$refs.container.removeClass('fancybox-is-hidden'),
                f(u.$refs.container),
                u.$refs.container.addClass('fancybox-is-open'),
                f(u.$refs.container),
                s.$slide.addClass('fancybox-slide--previous'),
                u.loadSlide(s),
                s.$slide
                  .removeClass('fancybox-slide--previous')
                  .addClass('fancybox-slide--current'),
                void u.preload('image')
              );
            n.each(u.slides, function (t, e) {
              n.fancybox.stop(e.$slide);
            }),
              s.$slide
                .removeClass('fancybox-slide--next fancybox-slide--previous')
                .addClass('fancybox-slide--current'),
              s.isMoved
                ? ((c = Math.round(s.$slide.width())),
                  n.each(u.slides, function (t, o) {
                    var i = o.pos - s.pos;
                    n.fancybox.animate(
                      o.$slide,
                      { top: 0, left: i * c + i * o.opts.gutter },
                      e,
                      function () {
                        o.$slide
                          .removeAttr('style')
                          .removeClass(
                            'fancybox-slide--next fancybox-slide--previous'
                          ),
                          o.pos === u.currPos &&
                            ((s.isMoved = !1), u.complete());
                      }
                    );
                  }))
                : u.$refs.stage.children().removeAttr('style'),
              s.isLoaded ? u.revealContent(s) : u.loadSlide(s),
              u.preload('image'),
              r.pos !== s.pos &&
                ((d =
                  'fancybox-slide--' + (r.pos > s.pos ? 'next' : 'previous')),
                r.$slide.removeClass(
                  'fancybox-slide--complete fancybox-slide--current fancybox-slide--next fancybox-slide--previous'
                ),
                (r.isComplete = !1),
                e &&
                  (s.isMoved || s.opts.transitionEffect) &&
                  (s.isMoved
                    ? r.$slide.addClass(d)
                    : ((d =
                        'fancybox-animated ' +
                        d +
                        ' fancybox-fx-' +
                        s.opts.transitionEffect),
                      n.fancybox.animate(r.$slide, d, e, function () {
                        r.$slide.removeClass(d).removeAttr('style');
                      }))));
          }
        }
      },
      createSlide: function (t) {
        var e,
          o,
          i = this;
        return (
          (o = t % i.group.length),
          (o = o < 0 ? i.group.length + o : o),
          !i.slides[t] &&
            i.group[o] &&
            ((e = n('<div class="fancybox-slide"></div>').appendTo(
              i.$refs.stage
            )),
            (i.slides[t] = n.extend(!0, {}, i.group[o], {
              pos: t,
              $slide: e,
              isLoaded: !1,
            })),
            i.updateSlide(i.slides[t])),
          i.slides[t]
        );
      },
      scaleToActual: function (t, e, i) {
        var a,
          s,
          r,
          c,
          l,
          d = this,
          u = d.current,
          f = u.$content,
          p = n.fancybox.getTranslate(u.$slide).width,
          h = n.fancybox.getTranslate(u.$slide).height,
          g = u.width,
          b = u.height;
        !d.isAnimating &&
          f &&
          'image' == u.type &&
          u.isLoaded &&
          !u.hasError &&
          (n.fancybox.stop(f),
          (d.isAnimating = !0),
          (t = t === o ? 0.5 * p : t),
          (e = e === o ? 0.5 * h : e),
          (a = n.fancybox.getTranslate(f)),
          (a.top -= n.fancybox.getTranslate(u.$slide).top),
          (a.left -= n.fancybox.getTranslate(u.$slide).left),
          (c = g / a.width),
          (l = b / a.height),
          (s = 0.5 * p - 0.5 * g),
          (r = 0.5 * h - 0.5 * b),
          g > p &&
            ((s = a.left * c - (t * c - t)),
            s > 0 && (s = 0),
            s < p - g && (s = p - g)),
          b > h &&
            ((r = a.top * l - (e * l - e)),
            r > 0 && (r = 0),
            r < h - b && (r = h - b)),
          d.updateCursor(g, b),
          n.fancybox.animate(
            f,
            { top: r, left: s, scaleX: c, scaleY: l },
            i || 330,
            function () {
              d.isAnimating = !1;
            }
          ),
          d.SlideShow && d.SlideShow.isActive && d.SlideShow.stop());
      },
      scaleToFit: function (t) {
        var e,
          o = this,
          i = o.current,
          a = i.$content;
        !o.isAnimating &&
          a &&
          'image' == i.type &&
          i.isLoaded &&
          !i.hasError &&
          (n.fancybox.stop(a),
          (o.isAnimating = !0),
          (e = o.getFitPos(i)),
          o.updateCursor(e.width, e.height),
          n.fancybox.animate(
            a,
            {
              top: e.top,
              left: e.left,
              scaleX: e.width / a.width(),
              scaleY: e.height / a.height(),
            },
            t || 330,
            function () {
              o.isAnimating = !1;
            }
          ));
      },
      getFitPos: function (t) {
        var e,
          n,
          o,
          i,
          a,
          s = this,
          r = t.$content,
          c = t.width || t.opts.width,
          l = t.height || t.opts.height,
          d = {};
        return (
          !!(t.isLoaded && r && r.length) &&
          ((i = {
            top: parseInt(t.$slide.css('paddingTop'), 10),
            right: parseInt(t.$slide.css('paddingRight'), 10),
            bottom: parseInt(t.$slide.css('paddingBottom'), 10),
            left: parseInt(t.$slide.css('paddingLeft'), 10),
          }),
          (e = parseInt(s.$refs.stage.width(), 10) - (i.left + i.right)),
          (n = parseInt(s.$refs.stage.height(), 10) - (i.top + i.bottom)),
          (c && l) || ((c = e), (l = n)),
          (o = Math.min(1, e / c, n / l)),
          (c = Math.floor(o * c)),
          (l = Math.floor(o * l)),
          'image' === t.type
            ? ((d.top = Math.floor(0.5 * (n - l)) + i.top),
              (d.left = Math.floor(0.5 * (e - c)) + i.left))
            : 'video' === t.contentType &&
              ((a =
                t.opts.width && t.opts.height ? c / l : t.opts.ratio || 16 / 9),
              l > c / a ? (l = c / a) : c > l * a && (c = l * a)),
          (d.width = c),
          (d.height = l),
          d)
        );
      },
      update: function () {
        var t = this;
        n.each(t.slides, function (e, n) {
          t.updateSlide(n);
        });
      },
      updateSlide: function (t, e) {
        var o = this,
          i = t && t.$content,
          a = t.width || t.opts.width,
          s = t.height || t.opts.height;
        i &&
          (a || s || 'video' === t.contentType) &&
          !t.hasError &&
          (n.fancybox.stop(i),
          n.fancybox.setTranslate(i, o.getFitPos(t)),
          t.pos === o.currPos && ((o.isAnimating = !1), o.updateCursor())),
          t.$slide.trigger('refresh'),
          o.$refs.toolbar.toggleClass(
            'compensate-for-scrollbar',
            t.$slide.get(0).scrollHeight > t.$slide.get(0).clientHeight
          ),
          o.trigger('onUpdate', t);
      },
      centerSlide: function (t, e) {
        var i,
          a,
          s = this;
        s.current &&
          ((i = Math.round(t.$slide.width())),
          (a = t.pos - s.current.pos),
          n.fancybox.animate(
            t.$slide,
            { top: 0, left: a * i + a * t.opts.gutter, opacity: 1 },
            e === o ? 0 : e,
            null,
            !1
          ));
      },
      updateCursor: function (t, e) {
        var o,
          i = this,
          a = i.current,
          s = i.$refs.container.removeClass(
            'fancybox-is-zoomable fancybox-can-zoomIn fancybox-can-drag fancybox-can-zoomOut'
          );
        a &&
          !i.isClosing &&
          ((o = i.isZoomable()),
          s.toggleClass('fancybox-is-zoomable', o),
          n('[data-fancybox-zoom]').prop('disabled', !o),
          o &&
          ('zoom' === a.opts.clickContent ||
            (n.isFunction(a.opts.clickContent) &&
              'zoom' === a.opts.clickContent(a)))
            ? i.isScaledDown(t, e)
              ? s.addClass('fancybox-can-zoomIn')
              : a.opts.touch
              ? s.addClass('fancybox-can-drag')
              : s.addClass('fancybox-can-zoomOut')
            : a.opts.touch &&
              'video' !== a.contentType &&
              s.addClass('fancybox-can-drag'));
      },
      isZoomable: function () {
        var t,
          e = this,
          n = e.current;
        if (n && !e.isClosing && 'image' === n.type && !n.hasError) {
          if (!n.isLoaded) return !0;
          if (((t = e.getFitPos(n)), n.width > t.width || n.height > t.height))
            return !0;
        }
        return !1;
      },
      isScaledDown: function (t, e) {
        var i = this,
          a = !1,
          s = i.current,
          r = s.$content;
        return (
          t !== o && e !== o
            ? (a = t < s.width && e < s.height)
            : r &&
              ((a = n.fancybox.getTranslate(r)),
              (a = a.width < s.width && a.height < s.height)),
          a
        );
      },
      canPan: function () {
        var t,
          e = this,
          n = !1,
          o = e.current;
        return (
          'image' === o.type &&
            (t = o.$content) &&
            !o.hasError &&
            ((n = e.getFitPos(o)),
            (n =
              Math.abs(t.width() - n.width) > 1 ||
              Math.abs(t.height() - n.height) > 1)),
          n
        );
      },
      loadSlide: function (t) {
        var e,
          o,
          i,
          a = this;
        if (!t.isLoading && !t.isLoaded) {
          switch (
            ((t.isLoading = !0),
            a.trigger('beforeLoad', t),
            (e = t.type),
            (o = t.$slide),
            o.off('refresh').trigger('onReset').addClass(t.opts.slideClass),
            e)
          ) {
            case 'image':
              a.setImage(t);
              break;
            case 'iframe':
              a.setIframe(t);
              break;
            case 'html':
              a.setContent(t, t.src || t.content);
              break;
            case 'video':
              a.setContent(
                t,
                '<video class="fancybox-video" controls controlsList="nodownload"><source src="' +
                  t.src +
                  '" type="' +
                  t.opts.videoFormat +
                  '">Your browser doesn\'t support HTML5 video</video'
              );
              break;
            case 'inline':
              n(t.src).length ? a.setContent(t, n(t.src)) : a.setError(t);
              break;
            case 'ajax':
              a.showLoading(t),
                (i = n.ajax(
                  n.extend({}, t.opts.ajax.settings, {
                    url: t.src,
                    success: function (e, n) {
                      'success' === n && a.setContent(t, e);
                    },
                    error: function (e, n) {
                      e && 'abort' !== n && a.setError(t);
                    },
                  })
                )),
                o.one('onReset', function () {
                  i.abort();
                });
              break;
            default:
              a.setError(t);
          }
          return !0;
        }
      },
      setImage: function (e) {
        var o,
          i,
          a,
          s,
          r,
          c = this,
          l = e.opts.srcset || e.opts.image.srcset;
        if (
          ((e.timouts = setTimeout(function () {
            var t = e.$image;
            !e.isLoading ||
              (t && t[0].complete) ||
              e.hasError ||
              c.showLoading(e);
          }, 350)),
          l)
        ) {
          (s = t.devicePixelRatio || 1),
            (r = t.innerWidth * s),
            (a = l.split(',').map(function (t) {
              var e = {};
              return (
                t
                  .trim()
                  .split(/\s+/)
                  .forEach(function (t, n) {
                    var o = parseInt(t.substring(0, t.length - 1), 10);
                    return 0 === n
                      ? (e.url = t)
                      : void (
                          o && ((e.value = o), (e.postfix = t[t.length - 1]))
                        );
                  }),
                e
              );
            })),
            a.sort(function (t, e) {
              return t.value - e.value;
            });
          for (var d = 0; d < a.length; d++) {
            var u = a[d];
            if (
              ('w' === u.postfix && u.value >= r) ||
              ('x' === u.postfix && u.value >= s)
            ) {
              i = u;
              break;
            }
          }
          !i && a.length && (i = a[a.length - 1]),
            i &&
              ((e.src = i.url),
              e.width &&
                e.height &&
                'w' == i.postfix &&
                ((e.height = (e.width / e.height) * i.value),
                (e.width = i.value)),
              (e.opts.srcset = l));
        }
        (e.$content = n('<div class="fancybox-content"></div>')
          .addClass('fancybox-is-hidden')
          .appendTo(e.$slide.addClass('fancybox-slide--image'))),
          (o =
            e.opts.thumb ||
            (!(!e.opts.$thumb || !e.opts.$thumb.length) &&
              e.opts.$thumb.attr('src'))),
          e.opts.preload !== !1 &&
            e.opts.width &&
            e.opts.height &&
            o &&
            ((e.width = e.opts.width),
            (e.height = e.opts.height),
            (e.$ghost = n('<img />')
              .one('error', function () {
                n(this).remove(), (e.$ghost = null);
              })
              .one('load', function () {
                c.afterLoad(e);
              })
              .addClass('fancybox-image')
              .appendTo(e.$content)
              .attr('src', o))),
          c.setBigImage(e);
      },
      setBigImage: function (t) {
        var e = this,
          o = n('<img />');
        (t.$image = o
          .one('error', function () {
            e.setError(t);
          })
          .one('load', function () {
            var n;
            t.$ghost ||
              (e.resolveImageSlideSize(
                t,
                this.naturalWidth,
                this.naturalHeight
              ),
              e.afterLoad(t)),
              t.timouts && (clearTimeout(t.timouts), (t.timouts = null)),
              e.isClosing ||
                (t.opts.srcset &&
                  ((n = t.opts.sizes),
                  (n && 'auto' !== n) ||
                    (n =
                      (t.width / t.height > 1 && s.width() / s.height() > 1
                        ? '100'
                        : Math.round((t.width / t.height) * 100)) + 'vw'),
                  o.attr('sizes', n).attr('srcset', t.opts.srcset)),
                t.$ghost &&
                  setTimeout(function () {
                    t.$ghost && !e.isClosing && t.$ghost.hide();
                  }, Math.min(300, Math.max(1e3, t.height / 1600))),
                e.hideLoading(t));
          })
          .addClass('fancybox-image')
          .attr('src', t.src)
          .appendTo(t.$content)),
          (o[0].complete || 'complete' == o[0].readyState) &&
          o[0].naturalWidth &&
          o[0].naturalHeight
            ? o.trigger('load')
            : o[0].error && o.trigger('error');
      },
      resolveImageSlideSize: function (t, e, n) {
        var o = parseInt(t.opts.width, 10),
          i = parseInt(t.opts.height, 10);
        (t.width = e),
          (t.height = n),
          o > 0 && ((t.width = o), (t.height = Math.floor((o * n) / e))),
          i > 0 && ((t.width = Math.floor((i * e) / n)), (t.height = i));
      },
      setIframe: function (t) {
        var e,
          i = this,
          a = t.opts.iframe,
          s = t.$slide;
        (t.$content = n(
          '<div class="fancybox-content' +
            (a.preload ? ' fancybox-is-hidden' : '') +
            '"></div>'
        )
          .css(a.css)
          .appendTo(s)),
          s.addClass('fancybox-slide--' + t.contentType),
          (t.$iframe = e = n(a.tpl.replace(/\{rnd\}/g, new Date().getTime()))
            .attr(a.attr)
            .appendTo(t.$content)),
          a.preload
            ? (i.showLoading(t),
              e.on('load.fb error.fb', function (e) {
                (this.isReady = 1), t.$slide.trigger('refresh'), i.afterLoad(t);
              }),
              s.on('refresh.fb', function () {
                var n,
                  i,
                  s = t.$content,
                  r = a.css.width,
                  c = a.css.height;
                if (1 === e[0].isReady) {
                  try {
                    (n = e.contents()), (i = n.find('body'));
                  } catch (t) {}
                  i &&
                    i.length &&
                    i.children().length &&
                    (s.css({ width: '', height: '' }),
                    r === o &&
                      (r = Math.ceil(
                        Math.max(i[0].clientWidth, i.outerWidth(!0))
                      )),
                    r && s.width(r),
                    c === o &&
                      (c = Math.ceil(
                        Math.max(i[0].clientHeight, i.outerHeight(!0))
                      )),
                    c && s.height(c)),
                    s.removeClass('fancybox-is-hidden');
                }
              }))
            : this.afterLoad(t),
          e.attr('src', t.src),
          s.one('onReset', function () {
            try {
              n(this)
                .find('iframe')
                .hide()
                .unbind()
                .attr('src', '//about:blank');
            } catch (t) {}
            n(this).off('refresh.fb').empty(), (t.isLoaded = !1);
          });
      },
      setContent: function (t, e) {
        var o = this;
        o.isClosing ||
          (o.hideLoading(t),
          t.$content && n.fancybox.stop(t.$content),
          t.$slide.empty(),
          l(e) && e.parent().length
            ? (e.parent().parent('.fancybox-slide--inline').trigger('onReset'),
              (t.$placeholder = n('<div>').hide().insertAfter(e)),
              e.css('display', 'inline-block'))
            : t.hasError ||
              ('string' === n.type(e) &&
                ((e = n('<div>').append(n.trim(e)).contents()),
                3 === e[0].nodeType && (e = n('<div>').html(e))),
              t.opts.filter && (e = n('<div>').html(e).find(t.opts.filter))),
          t.$slide.one('onReset', function () {
            n(this).find('video,audio').trigger('pause'),
              t.$placeholder &&
                (t.$placeholder.after(e.hide()).remove(),
                (t.$placeholder = null)),
              t.$smallBtn && (t.$smallBtn.remove(), (t.$smallBtn = null)),
              t.hasError || (n(this).empty(), (t.isLoaded = !1));
          }),
          n(e).appendTo(t.$slide),
          n(e).is('video,audio') &&
            (n(e).addClass('fancybox-video'),
            n(e).wrap('<div></div>'),
            (t.contentType = 'video'),
            (t.opts.width = t.opts.width || n(e).attr('width')),
            (t.opts.height = t.opts.height || n(e).attr('height'))),
          (t.$content = t.$slide
            .children()
            .filter('div,form,main,video,audio')
            .first()
            .addClass('fancybox-content')),
          t.$slide.addClass('fancybox-slide--' + t.contentType),
          this.afterLoad(t));
      },
      setError: function (t) {
        (t.hasError = !0),
          t.$slide
            .trigger('onReset')
            .removeClass('fancybox-slide--' + t.contentType)
            .addClass('fancybox-slide--error'),
          (t.contentType = 'html'),
          this.setContent(t, this.translate(t, t.opts.errorTpl)),
          t.pos === this.currPos && (this.isAnimating = !1);
      },
      showLoading: function (t) {
        var e = this;
        (t = t || e.current),
          t &&
            !t.$spinner &&
            (t.$spinner = n(e.translate(e, e.opts.spinnerTpl)).appendTo(
              t.$slide
            ));
      },
      hideLoading: function (t) {
        var e = this;
        (t = t || e.current),
          t && t.$spinner && (t.$spinner.remove(), delete t.$spinner);
      },
      afterLoad: function (t) {
        var e = this;
        e.isClosing ||
          ((t.isLoading = !1),
          (t.isLoaded = !0),
          e.trigger('afterLoad', t),
          e.hideLoading(t),
          t.pos === e.currPos && e.updateCursor(),
          !t.opts.smallBtn ||
            (t.$smallBtn && t.$smallBtn.length) ||
            (t.$smallBtn = n(e.translate(t, t.opts.btnTpl.smallBtn)).prependTo(
              t.$content
            )),
          t.opts.protect &&
            t.$content &&
            !t.hasError &&
            (t.$content.on('contextmenu.fb', function (t) {
              return 2 == t.button && t.preventDefault(), !0;
            }),
            'image' === t.type &&
              n('<div class="fancybox-spaceball"></div>').appendTo(t.$content)),
          e.revealContent(t));
      },
      revealContent: function (t) {
        var e,
          i,
          a,
          s,
          r = this,
          c = t.$slide,
          l = !1,
          d = !1;
        return (
          (e = t.opts[r.firstRun ? 'animationEffect' : 'transitionEffect']),
          (a = t.opts[r.firstRun ? 'animationDuration' : 'transitionDuration']),
          (a = parseInt(t.forcedDuration === o ? a : t.forcedDuration, 10)),
          t.pos === r.currPos &&
            (t.isComplete ? (e = !1) : (r.isAnimating = !0)),
          (!t.isMoved && t.pos === r.currPos && a) || (e = !1),
          'zoom' === e &&
            (t.pos === r.currPos &&
            a &&
            'image' === t.type &&
            !t.hasError &&
            (d = r.getThumbPos(t))
              ? (l = r.getFitPos(t))
              : (e = 'fade')),
          'zoom' === e
            ? ((l.scaleX = l.width / d.width),
              (l.scaleY = l.height / d.height),
              (s = t.opts.zoomOpacity),
              'auto' == s &&
                (s = Math.abs(t.width / t.height - d.width / d.height) > 0.1),
              s && ((d.opacity = 0.1), (l.opacity = 1)),
              n.fancybox.setTranslate(
                t.$content.removeClass('fancybox-is-hidden'),
                d
              ),
              f(t.$content),
              void n.fancybox.animate(t.$content, l, a, function () {
                (r.isAnimating = !1), r.complete();
              }))
            : (r.updateSlide(t),
              e
                ? (n.fancybox.stop(c),
                  (i =
                    'fancybox-animated fancybox-slide--' +
                    (t.pos >= r.prevPos ? 'next' : 'previous') +
                    ' fancybox-fx-' +
                    e),
                  c
                    .removeAttr('style')
                    .removeClass(
                      'fancybox-slide--current fancybox-slide--next fancybox-slide--previous'
                    )
                    .addClass(i),
                  t.$content.removeClass('fancybox-is-hidden'),
                  f(c),
                  void n.fancybox.animate(
                    c,
                    'fancybox-slide--current',
                    a,
                    function (e) {
                      c.removeClass(i).removeAttr('style'),
                        t.pos === r.currPos && r.complete();
                    },
                    !0
                  ))
                : (f(c),
                  t.$content.removeClass('fancybox-is-hidden'),
                  void (t.pos === r.currPos && r.complete())))
        );
      },
      getThumbPos: function (o) {
        var i,
          a = this,
          s = !1,
          r = o.opts.$thumb,
          c = r && r.length && r[0].ownerDocument === e ? r.offset() : 0,
          l = function (e) {
            for (
              var o, i = e[0], a = i.getBoundingClientRect(), s = [];
              null !== i.parentElement;

            )
              ('hidden' !== n(i.parentElement).css('overflow') &&
                'auto' !== n(i.parentElement).css('overflow')) ||
                s.push(i.parentElement.getBoundingClientRect()),
                (i = i.parentElement);
            return (
              (o = s.every(function (t) {
                var e = Math.min(a.right, t.right) - Math.max(a.left, t.left),
                  n = Math.min(a.bottom, t.bottom) - Math.max(a.top, t.top);
                return e > 0 && n > 0;
              })),
              o &&
                a.bottom > 0 &&
                a.right > 0 &&
                a.left < n(t).width() &&
                a.top < n(t).height()
            );
          };
        return (
          c &&
            l(r) &&
            ((i = a.$refs.stage.offset()),
            (s = {
              top: c.top - i.top + parseFloat(r.css('border-top-width') || 0),
              left:
                c.left - i.left + parseFloat(r.css('border-left-width') || 0),
              width: r.width(),
              height: r.height(),
              scaleX: 1,
              scaleY: 1,
            })),
          s
        );
      },
      complete: function () {
        var t = this,
          o = t.current,
          i = {};
        !o.isMoved &&
          o.isLoaded &&
          (o.isComplete ||
            ((o.isComplete = !0),
            o.$slide.siblings().trigger('onReset'),
            t.preload('inline'),
            f(o.$slide),
            o.$slide.addClass('fancybox-slide--complete'),
            n.each(t.slides, function (e, o) {
              o.pos >= t.currPos - 1 && o.pos <= t.currPos + 1
                ? (i[o.pos] = o)
                : o && (n.fancybox.stop(o.$slide), o.$slide.off().remove());
            }),
            (t.slides = i)),
          (t.isAnimating = !1),
          t.updateCursor(),
          t.trigger('afterShow'),
          o.$slide.find('video,audio').filter(':visible:first').trigger('play'),
          (n(e.activeElement).is('[disabled]') ||
            (o.opts.autoFocus && 'image' != o.type && 'iframe' !== o.type)) &&
            t.focus());
      },
      preload: function (t) {
        var e = this,
          n = e.slides[e.currPos + 1],
          o = e.slides[e.currPos - 1];
        n && n.type === t && e.loadSlide(n),
          o && o.type === t && e.loadSlide(o);
      },
      focus: function () {
        var t,
          e = this.current;
        this.isClosing ||
          (e &&
            e.isComplete &&
            e.$content &&
            ((t = e.$content.find('input[autofocus]:enabled:visible:first')),
            t.length ||
              (t = e.$content
                .find('button,:input,[tabindex],a')
                .filter(':enabled:visible:first')),
            (t = t && t.length ? t : e.$content),
            t.trigger('focus')));
      },
      activate: function () {
        var t = this;
        n('.fancybox-container').each(function () {
          var e = n(this).data('FancyBox');
          e &&
            e.id !== t.id &&
            !e.isClosing &&
            (e.trigger('onDeactivate'), e.removeEvents(), (e.isVisible = !1));
        }),
          (t.isVisible = !0),
          (t.current || t.isIdle) && (t.update(), t.updateControls()),
          t.trigger('onActivate'),
          t.addEvents();
      },
      close: function (t, e) {
        var o,
          i,
          a,
          s,
          r,
          c,
          l,
          p = this,
          h = p.current,
          g = function () {
            p.cleanUp(t);
          };
        return (
          !p.isClosing &&
          ((p.isClosing = !0),
          p.trigger('beforeClose', t) === !1
            ? ((p.isClosing = !1),
              d(function () {
                p.update();
              }),
              !1)
            : (p.removeEvents(),
              h.timouts && clearTimeout(h.timouts),
              (a = h.$content),
              (o = h.opts.animationEffect),
              (i = n.isNumeric(e) ? e : o ? h.opts.animationDuration : 0),
              h.$slide
                .off(u)
                .removeClass(
                  'fancybox-slide--complete fancybox-slide--next fancybox-slide--previous fancybox-animated'
                ),
              h.$slide.siblings().trigger('onReset').remove(),
              i &&
                p.$refs.container
                  .removeClass('fancybox-is-open')
                  .addClass('fancybox-is-closing'),
              p.hideLoading(h),
              p.hideControls(),
              p.updateCursor(),
              'zoom' !== o ||
                (t !== !0 &&
                  a &&
                  i &&
                  'image' === h.type &&
                  !h.hasError &&
                  (l = p.getThumbPos(h))) ||
                (o = 'fade'),
              'zoom' === o
                ? (n.fancybox.stop(a),
                  (s = n.fancybox.getTranslate(a)),
                  (c = {
                    top: s.top,
                    left: s.left,
                    scaleX: s.width / l.width,
                    scaleY: s.height / l.height,
                    width: l.width,
                    height: l.height,
                  }),
                  (r = h.opts.zoomOpacity),
                  'auto' == r &&
                    (r =
                      Math.abs(h.width / h.height - l.width / l.height) > 0.1),
                  r && (l.opacity = 0),
                  n.fancybox.setTranslate(a, c),
                  f(a),
                  n.fancybox.animate(a, l, i, g),
                  !0)
                : (o && i
                    ? t === !0
                      ? setTimeout(g, i)
                      : n.fancybox.animate(
                          h.$slide.removeClass('fancybox-slide--current'),
                          'fancybox-animated fancybox-slide--previous fancybox-fx-' +
                            o,
                          i,
                          g
                        )
                    : g(),
                  !0)))
        );
      },
      cleanUp: function (t) {
        var e,
          o = this,
          i = n('body');
        o.current.$slide.trigger('onReset'),
          o.$refs.container.empty().remove(),
          o.trigger('afterClose', t),
          o.$lastFocus &&
            o.current.opts.backFocus &&
            o.$lastFocus.trigger('focus'),
          (o.current = null),
          (e = n.fancybox.getInstance()),
          e
            ? e.activate()
            : (i.removeClass('fancybox-active compensate-for-scrollbar'),
              n('#fancybox-style-noscroll').remove());
      },
      trigger: function (t, e) {
        var o,
          i = Array.prototype.slice.call(arguments, 1),
          a = this,
          s = e && e.opts ? e : a.current;
        return (
          s ? i.unshift(s) : (s = a),
          i.unshift(a),
          n.isFunction(s.opts[t]) && (o = s.opts[t].apply(s, i)),
          o === !1
            ? o
            : void ('afterClose' !== t && a.$refs
                ? a.$refs.container.trigger(t + '.fb', i)
                : r.trigger(t + '.fb', i))
        );
      },
      updateControls: function (t) {
        var e = this,
          n = e.current,
          o = n.index,
          i = n.opts.caption,
          a = e.$refs.container,
          s = e.$refs.caption;
        n.$slide.trigger('refresh'),
          (e.$caption = i && i.length ? s.html(i) : null),
          e.isHiddenControls || e.isIdle || e.showControls(),
          a.find('[data-fancybox-count]').html(e.group.length),
          a.find('[data-fancybox-index]').html(o + 1),
          a
            .find('[data-fancybox-prev]')
            .toggleClass('disabled', !n.opts.loop && o <= 0),
          a
            .find('[data-fancybox-next]')
            .toggleClass('disabled', !n.opts.loop && o >= e.group.length - 1),
          'image' === n.type
            ? a
                .find('[data-fancybox-zoom]')
                .show()
                .end()
                .find('[data-fancybox-download]')
                .attr('href', n.opts.image.src || n.src)
                .show()
            : n.opts.toolbar &&
              a.find('[data-fancybox-download],[data-fancybox-zoom]').hide();
      },
      hideControls: function () {
        (this.isHiddenControls = !0),
          this.$refs.container.removeClass(
            'fancybox-show-infobar fancybox-show-toolbar fancybox-show-caption fancybox-show-nav'
          );
      },
      showControls: function () {
        var t = this,
          e = t.current ? t.current.opts : t.opts,
          n = t.$refs.container;
        (t.isHiddenControls = !1),
          (t.idleSecondsCounter = 0),
          n
            .toggleClass('fancybox-show-toolbar', !(!e.toolbar || !e.buttons))
            .toggleClass(
              'fancybox-show-infobar',
              !!(e.infobar && t.group.length > 1)
            )
            .toggleClass(
              'fancybox-show-nav',
              !!(e.arrows && t.group.length > 1)
            )
            .toggleClass('fancybox-is-modal', !!e.modal),
          t.$caption
            ? n.addClass('fancybox-show-caption ')
            : n.removeClass('fancybox-show-caption');
      },
      toggleControls: function () {
        this.isHiddenControls ? this.showControls() : this.hideControls();
      },
    }),
      (n.fancybox = {
        version: '3.3.5',
        defaults: a,
        getInstance: function (t) {
          var e = n(
              '.fancybox-container:not(".fancybox-is-closing"):last'
            ).data('FancyBox'),
            o = Array.prototype.slice.call(arguments, 1);
          return (
            e instanceof h &&
            ('string' === n.type(t)
              ? e[t].apply(e, o)
              : 'function' === n.type(t) && t.apply(e, o),
            e)
          );
        },
        open: function (t, e, n) {
          return new h(t, e, n);
        },
        close: function (t) {
          var e = this.getInstance();
          e && (e.close(), t === !0 && this.close());
        },
        destroy: function () {
          this.close(!0), r.add('body').off('click.fb-start', '**');
        },
        isMobile:
          e.createTouch !== o &&
          /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
            navigator.userAgent
          ),
        use3d: (function () {
          var n = e.createElement('div');
          return (
            t.getComputedStyle &&
            t.getComputedStyle(n) &&
            t.getComputedStyle(n).getPropertyValue('transform') &&
            !(e.documentMode && e.documentMode < 11)
          );
        })(),
        getTranslate: function (t) {
          var e;
          return (
            !(!t || !t.length) &&
            ((e = t[0].getBoundingClientRect()),
            {
              top: e.top || 0,
              left: e.left || 0,
              width: e.width,
              height: e.height,
              opacity: parseFloat(t.css('opacity')),
            })
          );
        },
        setTranslate: function (t, e) {
          var n = '',
            i = {};
          if (t && e)
            return (
              (e.left === o && e.top === o) ||
                ((n =
                  (e.left === o ? t.position().left : e.left) +
                  'px, ' +
                  (e.top === o ? t.position().top : e.top) +
                  'px'),
                (n = this.use3d
                  ? 'translate3d(' + n + ', 0px)'
                  : 'translate(' + n + ')')),
              e.scaleX !== o &&
                e.scaleY !== o &&
                (n =
                  (n.length ? n + ' ' : '') +
                  'scale(' +
                  e.scaleX +
                  ', ' +
                  e.scaleY +
                  ')'),
              n.length && (i.transform = n),
              e.opacity !== o && (i.opacity = e.opacity),
              e.width !== o && (i.width = e.width),
              e.height !== o && (i.height = e.height),
              t.css(i)
            );
        },
        animate: function (t, e, i, a, s) {
          var r = !1;
          n.isFunction(i) && ((a = i), (i = null)),
            n.isPlainObject(e) || t.removeAttr('style'),
            n.fancybox.stop(t),
            t.on(u, function (o) {
              (!o ||
                !o.originalEvent ||
                (t.is(o.originalEvent.target) &&
                  'z-index' != o.originalEvent.propertyName)) &&
                (n.fancybox.stop(t),
                r && n.fancybox.setTranslate(t, r),
                n.isPlainObject(e)
                  ? s === !1 && t.removeAttr('style')
                  : s !== !0 && t.removeClass(e),
                n.isFunction(a) && a(o));
            }),
            n.isNumeric(i) && t.css('transition-duration', i + 'ms'),
            n.isPlainObject(e)
              ? (e.scaleX !== o &&
                  e.scaleY !== o &&
                  ((r = n.extend({}, e, {
                    width: t.width() * e.scaleX,
                    height: t.height() * e.scaleY,
                    scaleX: 1,
                    scaleY: 1,
                  })),
                  delete e.width,
                  delete e.height,
                  t.parent().hasClass('fancybox-slide--image') &&
                    t.parent().addClass('fancybox-is-scaling')),
                n.fancybox.setTranslate(t, e))
              : t.addClass(e),
            t.data(
              'timer',
              setTimeout(function () {
                t.trigger('transitionend');
              }, i + 16)
            );
        },
        stop: function (t) {
          t &&
            t.length &&
            (clearTimeout(t.data('timer')),
            t.off('transitionend').css('transition-duration', ''),
            t.parent().removeClass('fancybox-is-scaling'));
        },
      }),
      (n.fn.fancybox = function (t) {
        var e;
        return (
          (t = t || {}),
          (e = t.selector || !1),
          e
            ? n('body')
                .off('click.fb-start', e)
                .on('click.fb-start', e, { options: t }, i)
            : this.off('click.fb-start').on(
                'click.fb-start',
                { items: this, options: t },
                i
              ),
          this
        );
      }),
      r.on('click.fb-start', '[data-fancybox]', i),
      r.on('click.fb-start', '[data-trigger]', function (t) {
        i(t, {
          $target: n(
            '[data-fancybox="' + n(t.currentTarget).attr('data-trigger') + '"]'
          ).eq(n(t.currentTarget).attr('data-index') || 0),
          $trigger: n(this),
        });
      });
  }
})(window, document, window.jQuery || jQuery),
  (function (t) {
    'use strict';
    var e = function (e, n, o) {
        if (e)
          return (
            (o = o || ''),
            'object' === t.type(o) && (o = t.param(o, !0)),
            t.each(n, function (t, n) {
              e = e.replace('$' + t, n || '');
            }),
            o.length && (e += (e.indexOf('?') > 0 ? '&' : '?') + o),
            e
          );
      },
      n = {
        youtube: {
          matcher: /(youtube\.com|youtu\.be|youtube\-nocookie\.com)\/(watch\?(.*&)?v=|v\/|u\/|embed\/?)?(videoseries\?list=(.*)|[\w-]{11}|\?listType=(.*)&list=(.*))(.*)/i,
          params: {
            autoplay: 1,
            autohide: 1,
            fs: 1,
            rel: 0,
            hd: 1,
            wmode: 'transparent',
            enablejsapi: 1,
            html5: 1,
          },
          paramPlace: 8,
          type: 'iframe',
          url: '//www.youtube.com/embed/$4',
          thumb: '//img.youtube.com/vi/$4/hqdefault.jpg',
        },
        vimeo: {
          matcher: /^.+vimeo.com\/(.*\/)?([\d]+)(.*)?/,
          params: {
            autoplay: 1,
            hd: 1,
            show_title: 1,
            show_byline: 1,
            show_portrait: 0,
            fullscreen: 1,
            api: 1,
          },
          paramPlace: 3,
          type: 'iframe',
          url: '//player.vimeo.com/video/$2',
        },
        instagram: {
          matcher: /(instagr\.am|instagram\.com)\/p\/([a-zA-Z0-9_\-]+)\/?/i,
          type: 'image',
          url: '//$1/p/$2/media/?size=l',
        },
        gmap_place: {
          matcher: /(maps\.)?google\.([a-z]{2,3}(\.[a-z]{2})?)\/(((maps\/(place\/(.*)\/)?\@(.*),(\d+.?\d+?)z))|(\?ll=))(.*)?/i,
          type: 'iframe',
          url: function (t) {
            return (
              '//maps.google.' +
              t[2] +
              '/?ll=' +
              (t[9]
                ? t[9] +
                  '&z=' +
                  Math.floor(t[10]) +
                  (t[12] ? t[12].replace(/^\//, '&') : '')
                : t[12] + ''
              ).replace(/\?/, '&') +
              '&output=' +
              (t[12] && t[12].indexOf('layer=c') > 0 ? 'svembed' : 'embed')
            );
          },
        },
        gmap_search: {
          matcher: /(maps\.)?google\.([a-z]{2,3}(\.[a-z]{2})?)\/(maps\/search\/)(.*)/i,
          type: 'iframe',
          url: function (t) {
            return (
              '//maps.google.' +
              t[2] +
              '/maps?q=' +
              t[5].replace('query=', 'q=').replace('api=1', '') +
              '&output=embed'
            );
          },
        },
      };
    t(document).on('objectNeedsType.fb', function (o, i, a) {
      var s,
        r,
        c,
        l,
        d,
        u,
        f,
        p = a.src || '',
        h = !1;
      (s = t.extend(!0, {}, n, a.opts.media)),
        t.each(s, function (n, o) {
          if ((c = p.match(o.matcher))) {
            if (
              ((h = o.type), (f = n), (u = {}), o.paramPlace && c[o.paramPlace])
            ) {
              (d = c[o.paramPlace]),
                '?' == d[0] && (d = d.substring(1)),
                (d = d.split('&'));
              for (var i = 0; i < d.length; ++i) {
                var s = d[i].split('=', 2);
                2 == s.length &&
                  (u[s[0]] = decodeURIComponent(s[1].replace(/\+/g, ' ')));
              }
            }
            return (
              (l = t.extend(!0, {}, o.params, a.opts[n], u)),
              (p =
                'function' === t.type(o.url)
                  ? o.url.call(this, c, l, a)
                  : e(o.url, c, l)),
              (r =
                'function' === t.type(o.thumb)
                  ? o.thumb.call(this, c, l, a)
                  : e(o.thumb, c)),
              'youtube' === n
                ? (p = p.replace(/&t=((\d+)m)?(\d+)s/, function (t, e, n, o) {
                    return (
                      '&start=' +
                      ((n ? 60 * parseInt(n, 10) : 0) + parseInt(o, 10))
                    );
                  }))
                : 'vimeo' === n && (p = p.replace('&%23', '#')),
              !1
            );
          }
        }),
        h
          ? (a.opts.thumb ||
              (a.opts.$thumb && a.opts.$thumb.length) ||
              (a.opts.thumb = r),
            'iframe' === h &&
              (a.opts = t.extend(!0, a.opts, {
                iframe: { preload: !1, attr: { scrolling: 'no' } },
              })),
            t.extend(a, {
              type: h,
              src: p,
              origSrc: a.src,
              contentSource: f,
              contentType:
                'image' === h
                  ? 'image'
                  : 'gmap_place' == f || 'gmap_search' == f
                  ? 'map'
                  : 'video',
            }))
          : p && (a.type = a.opts.defaultType);
    });
  })(window.jQuery || jQuery),
  (function (t, e, n) {
    'use strict';
    var o = (function () {
        return (
          t.requestAnimationFrame ||
          t.webkitRequestAnimationFrame ||
          t.mozRequestAnimationFrame ||
          t.oRequestAnimationFrame ||
          function (e) {
            return t.setTimeout(e, 1e3 / 60);
          }
        );
      })(),
      i = (function () {
        return (
          t.cancelAnimationFrame ||
          t.webkitCancelAnimationFrame ||
          t.mozCancelAnimationFrame ||
          t.oCancelAnimationFrame ||
          function (e) {
            t.clearTimeout(e);
          }
        );
      })(),
      a = function (e) {
        var n = [];
        (e = e.originalEvent || e || t.e),
          (e =
            e.touches && e.touches.length
              ? e.touches
              : e.changedTouches && e.changedTouches.length
              ? e.changedTouches
              : [e]);
        for (var o in e)
          e[o].pageX
            ? n.push({ x: e[o].pageX, y: e[o].pageY })
            : e[o].clientX && n.push({ x: e[o].clientX, y: e[o].clientY });
        return n;
      },
      s = function (t, e, n) {
        return e && t
          ? 'x' === n
            ? t.x - e.x
            : 'y' === n
            ? t.y - e.y
            : Math.sqrt(Math.pow(t.x - e.x, 2) + Math.pow(t.y - e.y, 2))
          : 0;
      },
      r = function (t) {
        if (
          t.is(
            'a,area,button,[role="button"],input,label,select,summary,textarea,video,audio'
          ) ||
          n.isFunction(t.get(0).onclick) ||
          t.data('selectable')
        )
          return !0;
        for (var e = 0, o = t[0].attributes, i = o.length; e < i; e++)
          if ('data-fancybox-' === o[e].nodeName.substr(0, 14)) return !0;
        return !1;
      },
      c = function (e) {
        var n = t.getComputedStyle(e)['overflow-y'],
          o = t.getComputedStyle(e)['overflow-x'],
          i =
            ('scroll' === n || 'auto' === n) && e.scrollHeight > e.clientHeight,
          a = ('scroll' === o || 'auto' === o) && e.scrollWidth > e.clientWidth;
        return i || a;
      },
      l = function (t) {
        for (var e = !1; ; ) {
          if ((e = c(t.get(0)))) break;
          if (
            ((t = t.parent()),
            !t.length || t.hasClass('fancybox-stage') || t.is('body'))
          )
            break;
        }
        return e;
      },
      d = function (t) {
        var e = this;
        (e.instance = t),
          (e.$bg = t.$refs.bg),
          (e.$stage = t.$refs.stage),
          (e.$container = t.$refs.container),
          e.destroy(),
          e.$container.on(
            'touchstart.fb.touch mousedown.fb.touch',
            n.proxy(e, 'ontouchstart')
          );
      };
    (d.prototype.destroy = function () {
      this.$container.off('.fb.touch');
    }),
      (d.prototype.ontouchstart = function (o) {
        var i = this,
          c = n(o.target),
          d = i.instance,
          u = d.current,
          f = u.$content,
          p = 'touchstart' == o.type;
        if (
          (p && i.$container.off('mousedown.fb.touch'),
          (!o.originalEvent || 2 != o.originalEvent.button) &&
            c.length &&
            !r(c) &&
            !r(c.parent()) &&
            (c.is('img') ||
              !(o.originalEvent.clientX > c[0].clientWidth + c.offset().left)))
        ) {
          if (!u || d.isAnimating || d.isClosing)
            return o.stopPropagation(), void o.preventDefault();
          if (((i.realPoints = i.startPoints = a(o)), i.startPoints.length)) {
            if (
              (o.stopPropagation(),
              (i.startEvent = o),
              (i.canTap = !0),
              (i.$target = c),
              (i.$content = f),
              (i.opts = u.opts.touch),
              (i.isPanning = !1),
              (i.isSwiping = !1),
              (i.isZooming = !1),
              (i.isScrolling = !1),
              (i.startTime = new Date().getTime()),
              (i.distanceX = i.distanceY = i.distance = 0),
              (i.canvasWidth = Math.round(u.$slide[0].clientWidth)),
              (i.canvasHeight = Math.round(u.$slide[0].clientHeight)),
              (i.contentLastPos = null),
              (i.contentStartPos = n.fancybox.getTranslate(i.$content) || {
                top: 0,
                left: 0,
              }),
              (i.sliderStartPos =
                i.sliderLastPos || n.fancybox.getTranslate(u.$slide)),
              (i.stagePos = n.fancybox.getTranslate(d.$refs.stage)),
              (i.sliderStartPos.top -= i.stagePos.top),
              (i.sliderStartPos.left -= i.stagePos.left),
              (i.contentStartPos.top -= i.stagePos.top),
              (i.contentStartPos.left -= i.stagePos.left),
              n(e)
                .off('.fb.touch')
                .on(
                  p
                    ? 'touchend.fb.touch touchcancel.fb.touch'
                    : 'mouseup.fb.touch mouseleave.fb.touch',
                  n.proxy(i, 'ontouchend')
                )
                .on(
                  p ? 'touchmove.fb.touch' : 'mousemove.fb.touch',
                  n.proxy(i, 'ontouchmove')
                ),
              n.fancybox.isMobile &&
                e.addEventListener('scroll', i.onscroll, !0),
              (!i.opts && !d.canPan()) ||
                (!c.is(i.$stage) && !i.$stage.find(c).length))
            )
              return void (c.is('.fancybox-image') && o.preventDefault());
            (n.fancybox.isMobile && (l(c) || l(c.parent()))) ||
              o.preventDefault(),
              (1 === i.startPoints.length || u.hasError) &&
                (i.instance.canPan()
                  ? (n.fancybox.stop(i.$content),
                    i.$content.css('transition-duration', ''),
                    (i.isPanning = !0))
                  : (i.isSwiping = !0),
                i.$container.addClass('fancybox-controls--isGrabbing')),
              2 === i.startPoints.length &&
                'image' === u.type &&
                (u.isLoaded || u.$ghost) &&
                ((i.canTap = !1),
                (i.isSwiping = !1),
                (i.isPanning = !1),
                (i.isZooming = !0),
                n.fancybox.stop(i.$content),
                i.$content.css('transition-duration', ''),
                (i.centerPointStartX =
                  0.5 * (i.startPoints[0].x + i.startPoints[1].x) -
                  n(t).scrollLeft()),
                (i.centerPointStartY =
                  0.5 * (i.startPoints[0].y + i.startPoints[1].y) -
                  n(t).scrollTop()),
                (i.percentageOfImageAtPinchPointX =
                  (i.centerPointStartX - i.contentStartPos.left) /
                  i.contentStartPos.width),
                (i.percentageOfImageAtPinchPointY =
                  (i.centerPointStartY - i.contentStartPos.top) /
                  i.contentStartPos.height),
                (i.startDistanceBetweenFingers = s(
                  i.startPoints[0],
                  i.startPoints[1]
                )));
          }
        }
      }),
      (d.prototype.onscroll = function (t) {
        var n = this;
        (n.isScrolling = !0), e.removeEventListener('scroll', n.onscroll, !0);
      }),
      (d.prototype.ontouchmove = function (t) {
        var e = this,
          o = n(t.target);
        return void 0 !== t.originalEvent.buttons &&
          0 === t.originalEvent.buttons
          ? void e.ontouchend(t)
          : e.isScrolling || (!o.is(e.$stage) && !e.$stage.find(o).length)
          ? void (e.canTap = !1)
          : ((e.newPoints = a(t)),
            void (
              (e.opts || e.instance.canPan()) &&
              e.newPoints.length &&
              e.newPoints.length &&
              ((e.isSwiping && e.isSwiping === !0) || t.preventDefault(),
              (e.distanceX = s(e.newPoints[0], e.startPoints[0], 'x')),
              (e.distanceY = s(e.newPoints[0], e.startPoints[0], 'y')),
              (e.distance = s(e.newPoints[0], e.startPoints[0])),
              e.distance > 0 &&
                (e.isSwiping
                  ? e.onSwipe(t)
                  : e.isPanning
                  ? e.onPan()
                  : e.isZooming && e.onZoom()))
            ));
      }),
      (d.prototype.onSwipe = function (e) {
        var a,
          s = this,
          r = s.isSwiping,
          c = s.sliderStartPos.left || 0;
        if (r !== !0)
          'x' == r &&
            (s.distanceX > 0 &&
            (s.instance.group.length < 2 ||
              (0 === s.instance.current.index && !s.instance.current.opts.loop))
              ? (c += Math.pow(s.distanceX, 0.8))
              : s.distanceX < 0 &&
                (s.instance.group.length < 2 ||
                  (s.instance.current.index === s.instance.group.length - 1 &&
                    !s.instance.current.opts.loop))
              ? (c -= Math.pow(-s.distanceX, 0.8))
              : (c += s.distanceX)),
            (s.sliderLastPos = {
              top: 'x' == r ? 0 : s.sliderStartPos.top + s.distanceY,
              left: c,
            }),
            s.requestId && (i(s.requestId), (s.requestId = null)),
            (s.requestId = o(function () {
              s.sliderLastPos &&
                (n.each(s.instance.slides, function (t, e) {
                  var o = e.pos - s.instance.currPos;
                  n.fancybox.setTranslate(e.$slide, {
                    top: s.sliderLastPos.top,
                    left:
                      s.sliderLastPos.left +
                      o * s.canvasWidth +
                      o * e.opts.gutter,
                  });
                }),
                s.$container.addClass('fancybox-is-sliding'));
            }));
        else if (Math.abs(s.distance) > 10) {
          if (
            ((s.canTap = !1),
            s.instance.group.length < 2 && s.opts.vertical
              ? (s.isSwiping = 'y')
              : s.instance.isDragging ||
                s.opts.vertical === !1 ||
                ('auto' === s.opts.vertical && n(t).width() > 800)
              ? (s.isSwiping = 'x')
              : ((a = Math.abs(
                  (180 * Math.atan2(s.distanceY, s.distanceX)) / Math.PI
                )),
                (s.isSwiping = a > 45 && a < 135 ? 'y' : 'x')),
            (s.canTap = !1),
            'y' === s.isSwiping &&
              n.fancybox.isMobile &&
              (l(s.$target) || l(s.$target.parent())))
          )
            return void (s.isScrolling = !0);
          (s.instance.isDragging = s.isSwiping),
            (s.startPoints = s.newPoints),
            n.each(s.instance.slides, function (t, e) {
              n.fancybox.stop(e.$slide),
                e.$slide.css('transition-duration', ''),
                (e.inTransition = !1),
                e.pos === s.instance.current.pos &&
                  (s.sliderStartPos.left =
                    n.fancybox.getTranslate(e.$slide).left -
                    n.fancybox.getTranslate(s.instance.$refs.stage).left);
            }),
            s.instance.SlideShow &&
              s.instance.SlideShow.isActive &&
              s.instance.SlideShow.stop();
        }
      }),
      (d.prototype.onPan = function () {
        var t = this;
        return s(t.newPoints[0], t.realPoints[0]) <
          (n.fancybox.isMobile ? 10 : 5)
          ? void (t.startPoints = t.newPoints)
          : ((t.canTap = !1),
            (t.contentLastPos = t.limitMovement()),
            t.requestId && (i(t.requestId), (t.requestId = null)),
            void (t.requestId = o(function () {
              n.fancybox.setTranslate(t.$content, t.contentLastPos);
            })));
      }),
      (d.prototype.limitMovement = function () {
        var t,
          e,
          n,
          o,
          i,
          a,
          s = this,
          r = s.canvasWidth,
          c = s.canvasHeight,
          l = s.distanceX,
          d = s.distanceY,
          u = s.contentStartPos,
          f = u.left,
          p = u.top,
          h = u.width,
          g = u.height;
        return (
          (i = h > r ? f + l : f),
          (a = p + d),
          (t = Math.max(0, 0.5 * r - 0.5 * h)),
          (e = Math.max(0, 0.5 * c - 0.5 * g)),
          (n = Math.min(r - h, 0.5 * r - 0.5 * h)),
          (o = Math.min(c - g, 0.5 * c - 0.5 * g)),
          l > 0 && i > t && (i = t - 1 + Math.pow(-t + f + l, 0.8) || 0),
          l < 0 && i < n && (i = n + 1 - Math.pow(n - f - l, 0.8) || 0),
          d > 0 && a > e && (a = e - 1 + Math.pow(-e + p + d, 0.8) || 0),
          d < 0 && a < o && (a = o + 1 - Math.pow(o - p - d, 0.8) || 0),
          { top: a, left: i }
        );
      }),
      (d.prototype.limitPosition = function (t, e, n, o) {
        var i = this,
          a = i.canvasWidth,
          s = i.canvasHeight;
        return (
          n > a
            ? ((t = t > 0 ? 0 : t), (t = t < a - n ? a - n : t))
            : (t = Math.max(0, a / 2 - n / 2)),
          o > s
            ? ((e = e > 0 ? 0 : e), (e = e < s - o ? s - o : e))
            : (e = Math.max(0, s / 2 - o / 2)),
          { top: e, left: t }
        );
      }),
      (d.prototype.onZoom = function () {
        var e = this,
          a = e.contentStartPos,
          r = a.width,
          c = a.height,
          l = a.left,
          d = a.top,
          u = s(e.newPoints[0], e.newPoints[1]),
          f = u / e.startDistanceBetweenFingers,
          p = Math.floor(r * f),
          h = Math.floor(c * f),
          g = (r - p) * e.percentageOfImageAtPinchPointX,
          b = (c - h) * e.percentageOfImageAtPinchPointY,
          m = (e.newPoints[0].x + e.newPoints[1].x) / 2 - n(t).scrollLeft(),
          y = (e.newPoints[0].y + e.newPoints[1].y) / 2 - n(t).scrollTop(),
          v = m - e.centerPointStartX,
          x = y - e.centerPointStartY,
          w = l + (g + v),
          $ = d + (b + x),
          S = { top: $, left: w, scaleX: f, scaleY: f };
        (e.canTap = !1),
          (e.newWidth = p),
          (e.newHeight = h),
          (e.contentLastPos = S),
          e.requestId && (i(e.requestId), (e.requestId = null)),
          (e.requestId = o(function () {
            n.fancybox.setTranslate(e.$content, e.contentLastPos);
          }));
      }),
      (d.prototype.ontouchend = function (t) {
        var o = this,
          s = Math.max(new Date().getTime() - o.startTime, 1),
          r = o.isSwiping,
          c = o.isPanning,
          l = o.isZooming,
          d = o.isScrolling;
        return (
          (o.endPoints = a(t)),
          o.$container.removeClass('fancybox-controls--isGrabbing'),
          n(e).off('.fb.touch'),
          e.removeEventListener('scroll', o.onscroll, !0),
          o.requestId && (i(o.requestId), (o.requestId = null)),
          (o.isSwiping = !1),
          (o.isPanning = !1),
          (o.isZooming = !1),
          (o.isScrolling = !1),
          (o.instance.isDragging = !1),
          o.canTap
            ? o.onTap(t)
            : ((o.speed = 366),
              (o.velocityX = (o.distanceX / s) * 0.5),
              (o.velocityY = (o.distanceY / s) * 0.5),
              (o.speedX = Math.max(
                0.5 * o.speed,
                Math.min(1.5 * o.speed, (1 / Math.abs(o.velocityX)) * o.speed)
              )),
              void (c
                ? o.endPanning()
                : l
                ? o.endZooming()
                : o.endSwiping(r, d)))
        );
      }),
      (d.prototype.endSwiping = function (t, e) {
        var o = this,
          i = !1,
          a = o.instance.group.length;
        (o.sliderLastPos = null),
          'y' == t && !e && Math.abs(o.distanceY) > 50
            ? (n.fancybox.animate(
                o.instance.current.$slide,
                {
                  top: o.sliderStartPos.top + o.distanceY + 150 * o.velocityY,
                  opacity: 0,
                },
                200
              ),
              (i = o.instance.close(!0, 200)))
            : 'x' == t && o.distanceX > 50 && a > 1
            ? (i = o.instance.previous(o.speedX))
            : 'x' == t &&
              o.distanceX < -50 &&
              a > 1 &&
              (i = o.instance.next(o.speedX)),
          i !== !1 ||
            ('x' != t && 'y' != t) ||
            (e || a < 2
              ? o.instance.centerSlide(o.instance.current, 150)
              : o.instance.jumpTo(o.instance.current.index)),
          o.$container.removeClass('fancybox-is-sliding');
      }),
      (d.prototype.endPanning = function () {
        var t,
          e,
          o,
          i = this;
        i.contentLastPos &&
          (i.opts.momentum === !1
            ? ((t = i.contentLastPos.left), (e = i.contentLastPos.top))
            : ((t = i.contentLastPos.left + i.velocityX * i.speed),
              (e = i.contentLastPos.top + i.velocityY * i.speed)),
          (o = i.limitPosition(
            t,
            e,
            i.contentStartPos.width,
            i.contentStartPos.height
          )),
          (o.width = i.contentStartPos.width),
          (o.height = i.contentStartPos.height),
          n.fancybox.animate(i.$content, o, 330));
      }),
      (d.prototype.endZooming = function () {
        var t,
          e,
          o,
          i,
          a = this,
          s = a.instance.current,
          r = a.newWidth,
          c = a.newHeight;
        a.contentLastPos &&
          ((t = a.contentLastPos.left),
          (e = a.contentLastPos.top),
          (i = { top: e, left: t, width: r, height: c, scaleX: 1, scaleY: 1 }),
          n.fancybox.setTranslate(a.$content, i),
          r < a.canvasWidth && c < a.canvasHeight
            ? a.instance.scaleToFit(150)
            : r > s.width || c > s.height
            ? a.instance.scaleToActual(
                a.centerPointStartX,
                a.centerPointStartY,
                150
              )
            : ((o = a.limitPosition(t, e, r, c)),
              n.fancybox.setTranslate(
                a.$content,
                n.fancybox.getTranslate(a.$content)
              ),
              n.fancybox.animate(a.$content, o, 150)));
      }),
      (d.prototype.onTap = function (e) {
        var o,
          i = this,
          s = n(e.target),
          r = i.instance,
          c = r.current,
          l = (e && a(e)) || i.startPoints,
          d = l[0] ? l[0].x - n(t).scrollLeft() - i.stagePos.left : 0,
          u = l[0] ? l[0].y - n(t).scrollTop() - i.stagePos.top : 0,
          f = function (t) {
            var o = c.opts[t];
            if ((n.isFunction(o) && (o = o.apply(r, [c, e])), o))
              switch (o) {
                case 'close':
                  r.close(i.startEvent);
                  break;
                case 'toggleControls':
                  r.toggleControls(!0);
                  break;
                case 'next':
                  r.next();
                  break;
                case 'nextOrClose':
                  r.group.length > 1 ? r.next() : r.close(i.startEvent);
                  break;
                case 'zoom':
                  'image' == c.type &&
                    (c.isLoaded || c.$ghost) &&
                    (r.canPan()
                      ? r.scaleToFit()
                      : r.isScaledDown()
                      ? r.scaleToActual(d, u)
                      : r.group.length < 2 && r.close(i.startEvent));
              }
          };
        if (
          (!e.originalEvent || 2 != e.originalEvent.button) &&
          (s.is('img') || !(d > s[0].clientWidth + s.offset().left))
        ) {
          if (
            s.is(
              '.fancybox-bg,.fancybox-inner,.fancybox-outer,.fancybox-container'
            )
          )
            o = 'Outside';
          else if (s.is('.fancybox-slide')) o = 'Slide';
          else {
            if (
              !r.current.$content ||
              !r.current.$content.find(s).addBack().filter(s).length
            )
              return;
            o = 'Content';
          }
          if (i.tapped) {
            if (
              (clearTimeout(i.tapped),
              (i.tapped = null),
              Math.abs(d - i.tapX) > 50 || Math.abs(u - i.tapY) > 50)
            )
              return this;
            f('dblclick' + o);
          } else
            (i.tapX = d),
              (i.tapY = u),
              c.opts['dblclick' + o] &&
              c.opts['dblclick' + o] !== c.opts['click' + o]
                ? (i.tapped = setTimeout(function () {
                    (i.tapped = null), f('click' + o);
                  }, 500))
                : f('click' + o);
          return this;
        }
      }),
      n(e).on('onActivate.fb', function (t, e) {
        e && !e.Guestures && (e.Guestures = new d(e));
      });
  })(window, document, window.jQuery || jQuery),
  (function (t, e) {
    'use strict';
    e.extend(!0, e.fancybox.defaults, {
      btnTpl: {
        slideShow:
          '<button data-fancybox-play class="fancybox-button fancybox-button--play" title="{{PLAY_START}}"><svg viewBox="0 0 40 40"><path d="M13,12 L27,20 L13,27 Z" /><path d="M15,10 v19 M23,10 v19" /></svg></button>',
      },
      slideShow: { autoStart: !1, speed: 3e3 },
    });
    var n = function (t) {
      (this.instance = t), this.init();
    };
    e.extend(n.prototype, {
      timer: null,
      isActive: !1,
      $button: null,
      init: function () {
        var t = this;
        (t.$button = t.instance.$refs.toolbar
          .find('[data-fancybox-play]')
          .on('click', function () {
            t.toggle();
          })),
          (t.instance.group.length < 2 ||
            !t.instance.group[t.instance.currIndex].opts.slideShow) &&
            t.$button.hide();
      },
      set: function (t) {
        var e = this;
        e.instance &&
        e.instance.current &&
        (t === !0 ||
          e.instance.current.opts.loop ||
          e.instance.currIndex < e.instance.group.length - 1)
          ? (e.timer = setTimeout(function () {
              e.isActive &&
                e.instance.jumpTo(
                  (e.instance.currIndex + 1) % e.instance.group.length
                );
            }, e.instance.current.opts.slideShow.speed))
          : (e.stop(),
            (e.instance.idleSecondsCounter = 0),
            e.instance.showControls());
      },
      clear: function () {
        var t = this;
        clearTimeout(t.timer), (t.timer = null);
      },
      start: function () {
        var t = this,
          e = t.instance.current;
        e &&
          ((t.isActive = !0),
          t.$button
            .attr('title', e.opts.i18n[e.opts.lang].PLAY_STOP)
            .removeClass('fancybox-button--play')
            .addClass('fancybox-button--pause'),
          t.set(!0));
      },
      stop: function () {
        var t = this,
          e = t.instance.current;
        t.clear(),
          t.$button
            .attr('title', e.opts.i18n[e.opts.lang].PLAY_START)
            .removeClass('fancybox-button--pause')
            .addClass('fancybox-button--play'),
          (t.isActive = !1);
      },
      toggle: function () {
        var t = this;
        t.isActive ? t.stop() : t.start();
      },
    }),
      e(t).on({
        'onInit.fb': function (t, e) {
          e && !e.SlideShow && (e.SlideShow = new n(e));
        },
        'beforeShow.fb': function (t, e, n, o) {
          var i = e && e.SlideShow;
          o
            ? i && n.opts.slideShow.autoStart && i.start()
            : i && i.isActive && i.clear();
        },
        'afterShow.fb': function (t, e, n) {
          var o = e && e.SlideShow;
          o && o.isActive && o.set();
        },
        'afterKeydown.fb': function (n, o, i, a, s) {
          var r = o && o.SlideShow;
          !r ||
            !i.opts.slideShow ||
            (80 !== s && 32 !== s) ||
            e(t.activeElement).is('button,a,input') ||
            (a.preventDefault(), r.toggle());
        },
        'beforeClose.fb onDeactivate.fb': function (t, e) {
          var n = e && e.SlideShow;
          n && n.stop();
        },
      }),
      e(t).on('visibilitychange', function () {
        var n = e.fancybox.getInstance(),
          o = n && n.SlideShow;
        o && o.isActive && (t.hidden ? o.clear() : o.set());
      });
  })(document, window.jQuery || jQuery),
  (function (t, e) {
    'use strict';
    var n = (function () {
      for (
        var e = [
            [
              'requestFullscreen',
              'exitFullscreen',
              'fullscreenElement',
              'fullscreenEnabled',
              'fullscreenchange',
              'fullscreenerror',
            ],
            [
              'webkitRequestFullscreen',
              'webkitExitFullscreen',
              'webkitFullscreenElement',
              'webkitFullscreenEnabled',
              'webkitfullscreenchange',
              'webkitfullscreenerror',
            ],
            [
              'webkitRequestFullScreen',
              'webkitCancelFullScreen',
              'webkitCurrentFullScreenElement',
              'webkitCancelFullScreen',
              'webkitfullscreenchange',
              'webkitfullscreenerror',
            ],
            [
              'mozRequestFullScreen',
              'mozCancelFullScreen',
              'mozFullScreenElement',
              'mozFullScreenEnabled',
              'mozfullscreenchange',
              'mozfullscreenerror',
            ],
            [
              'msRequestFullscreen',
              'msExitFullscreen',
              'msFullscreenElement',
              'msFullscreenEnabled',
              'MSFullscreenChange',
              'MSFullscreenError',
            ],
          ],
          n = {},
          o = 0;
        o < e.length;
        o++
      ) {
        var i = e[o];
        if (i && i[1] in t) {
          for (var a = 0; a < i.length; a++) n[e[0][a]] = i[a];
          return n;
        }
      }
      return !1;
    })();
    if (!n)
      return void (
        e &&
        e.fancybox &&
        (e.fancybox.defaults.btnTpl.fullScreen = !1)
      );
    var o = {
      request: function (e) {
        (e = e || t.documentElement),
          e[n.requestFullscreen](e.ALLOW_KEYBOARD_INPUT);
      },
      exit: function () {
        t[n.exitFullscreen]();
      },
      toggle: function (e) {
        (e = e || t.documentElement),
          this.isFullscreen() ? this.exit() : this.request(e);
      },
      isFullscreen: function () {
        return Boolean(t[n.fullscreenElement]);
      },
      enabled: function () {
        return Boolean(t[n.fullscreenEnabled]);
      },
    };
    e.extend(!0, e.fancybox.defaults, {
      btnTpl: {
        fullScreen:
          '<button data-fancybox-fullscreen class="fancybox-button fancybox-button--fullscreen" title="{{FULL_SCREEN}}"><svg viewBox="0 0 40 40"><path d="M9,12 v16 h22 v-16 h-22 v8" /></svg></button>',
      },
      fullScreen: { autoStart: !1 },
    }),
      e(t).on({
        'onInit.fb': function (t, e) {
          var n;
          e && e.group[e.currIndex].opts.fullScreen
            ? ((n = e.$refs.container),
              n.on(
                'click.fb-fullscreen',
                '[data-fancybox-fullscreen]',
                function (t) {
                  t.stopPropagation(), t.preventDefault(), o.toggle();
                }
              ),
              e.opts.fullScreen &&
                e.opts.fullScreen.autoStart === !0 &&
                o.request(),
              (e.FullScreen = o))
            : e && e.$refs.toolbar.find('[data-fancybox-fullscreen]').hide();
        },
        'afterKeydown.fb': function (t, e, n, o, i) {
          e &&
            e.FullScreen &&
            70 === i &&
            (o.preventDefault(), e.FullScreen.toggle());
        },
        'beforeClose.fb': function (t, e) {
          e &&
            e.FullScreen &&
            e.$refs.container.hasClass('fancybox-is-fullscreen') &&
            o.exit();
        },
      }),
      e(t).on(n.fullscreenchange, function () {
        var t = o.isFullscreen(),
          n = e.fancybox.getInstance();
        n &&
          (n.current &&
            'image' === n.current.type &&
            n.isAnimating &&
            (n.current.$content.css('transition', 'none'),
            (n.isAnimating = !1),
            n.update(!0, !0, 0)),
          n.trigger('onFullscreenChange', t),
          n.$refs.container.toggleClass('fancybox-is-fullscreen', t));
      });
  })(document, window.jQuery || jQuery),
  (function (t, e) {
    'use strict';
    var n = 'fancybox-thumbs',
      o = n + '-active',
      i = n + '-loading';
    e.fancybox.defaults = e.extend(
      !0,
      {
        btnTpl: {
          thumbs:
            '<button data-fancybox-thumbs class="fancybox-button fancybox-button--thumbs" title="{{THUMBS}}"><svg viewBox="0 0 120 120"><path d="M30,30 h14 v14 h-14 Z M50,30 h14 v14 h-14 Z M70,30 h14 v14 h-14 Z M30,50 h14 v14 h-14 Z M50,50 h14 v14 h-14 Z M70,50 h14 v14 h-14 Z M30,70 h14 v14 h-14 Z M50,70 h14 v14 h-14 Z M70,70 h14 v14 h-14 Z" /></svg></button>',
        },
        thumbs: {
          autoStart: !1,
          hideOnClose: !0,
          parentEl: '.fancybox-container',
          axis: 'y',
        },
      },
      e.fancybox.defaults
    );
    var a = function (t) {
      this.init(t);
    };
    e.extend(a.prototype, {
      $button: null,
      $grid: null,
      $list: null,
      isVisible: !1,
      isActive: !1,
      init: function (t) {
        var e,
          n,
          o = this;
        (o.instance = t),
          (t.Thumbs = o),
          (o.opts = t.group[t.currIndex].opts.thumbs),
          (e = t.group[0]),
          (e =
            e.opts.thumb ||
            (!(!e.opts.$thumb || !e.opts.$thumb.length) &&
              e.opts.$thumb.attr('src'))),
          t.group.length > 1 &&
            ((n = t.group[1]),
            (n =
              n.opts.thumb ||
              (!(!n.opts.$thumb || !n.opts.$thumb.length) &&
                n.opts.$thumb.attr('src')))),
          (o.$button = t.$refs.toolbar.find('[data-fancybox-thumbs]')),
          o.opts && e && n && e && n
            ? (o.$button.show().on('click', function () {
                o.toggle();
              }),
              (o.isActive = !0))
            : o.$button.hide();
      },
      create: function () {
        var t,
          o = this,
          a = o.instance,
          s = o.opts.parentEl,
          r = [];
        o.$grid ||
          ((o.$grid = e(
            '<div class="' + n + ' ' + n + '-' + o.opts.axis + '"></div>'
          ).appendTo(a.$refs.container.find(s).addBack().filter(s))),
          o.$grid.on('click', 'li', function () {
            a.jumpTo(e(this).attr('data-index'));
          })),
          o.$list || (o.$list = e('<ul>').appendTo(o.$grid)),
          e.each(a.group, function (e, n) {
            (t =
              n.opts.thumb ||
              (n.opts.$thumb ? n.opts.$thumb.attr('src') : null)),
              t || 'image' !== n.type || (t = n.src),
              r.push(
                '<li data-index="' +
                  e +
                  '" tabindex="0" class="' +
                  i +
                  '"' +
                  (t && t.length
                    ? ' style="background-image:url(' + t + ')" />'
                    : '') +
                  '></li>'
              );
          }),
          (o.$list[0].innerHTML = r.join('')),
          'x' === o.opts.axis &&
            o.$list.width(
              parseInt(o.$grid.css('padding-right'), 10) +
                a.group.length * o.$list.children().eq(0).outerWidth(!0)
            );
      },
      focus: function (t) {
        var e,
          n,
          i = this,
          a = i.$list,
          s = i.$grid;
        i.instance.current &&
          ((e = a
            .children()
            .removeClass(o)
            .filter('[data-index="' + i.instance.current.index + '"]')
            .addClass(o)),
          (n = e.position()),
          'y' === i.opts.axis &&
          (n.top < 0 || n.top > a.height() - e.outerHeight())
            ? a.stop().animate({ scrollTop: a.scrollTop() + n.top }, t)
            : 'x' === i.opts.axis &&
              (n.left < s.scrollLeft() ||
                n.left > s.scrollLeft() + (s.width() - e.outerWidth())) &&
              a.parent().stop().animate({ scrollLeft: n.left }, t));
      },
      update: function () {
        var t = this;
        t.instance.$refs.container.toggleClass(
          'fancybox-show-thumbs',
          this.isVisible
        ),
          t.isVisible
            ? (t.$grid || t.create(),
              t.instance.trigger('onThumbsShow'),
              t.focus(0))
            : t.$grid && t.instance.trigger('onThumbsHide'),
          t.instance.update();
      },
      hide: function () {
        (this.isVisible = !1), this.update();
      },
      show: function () {
        (this.isVisible = !0), this.update();
      },
      toggle: function () {
        (this.isVisible = !this.isVisible), this.update();
      },
    }),
      e(t).on({
        'onInit.fb': function (t, e) {
          var n;
          e &&
            !e.Thumbs &&
            ((n = new a(e)), n.isActive && n.opts.autoStart === !0 && n.show());
        },
        'beforeShow.fb': function (t, e, n, o) {
          var i = e && e.Thumbs;
          i && i.isVisible && i.focus(o ? 0 : 250);
        },
        'afterKeydown.fb': function (t, e, n, o, i) {
          var a = e && e.Thumbs;
          a && a.isActive && 71 === i && (o.preventDefault(), a.toggle());
        },
        'beforeClose.fb': function (t, e) {
          var n = e && e.Thumbs;
          n && n.isVisible && n.opts.hideOnClose !== !1 && n.$grid.hide();
        },
      });
  })(document, window.jQuery || jQuery),
  (function (t, e) {
    'use strict';
    function n(t) {
      var e = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
        '/': '&#x2F;',
        '`': '&#x60;',
        '=': '&#x3D;',
      };
      return String(t).replace(/[&<>"'`=\/]/g, function (t) {
        return e[t];
      });
    }
    e.extend(!0, e.fancybox.defaults, {
      btnTpl: {
        share:
          '<button data-fancybox-share class="fancybox-button fancybox-button--share" title="{{SHARE}}"><svg viewBox="0 0 40 40"><path d="M6,30 C8,18 19,16 23,16 L23,16 L23,10 L33,20 L23,29 L23,24 C19,24 8,27 6,30 Z"></svg></button>',
      },
      share: {
        url: function (t, e) {
          return (
            (!t.currentHash &&
              'inline' !== e.type &&
              'html' !== e.type &&
              (e.origSrc || e.src)) ||
            window.location
          );
        },
        tpl:
          '<div class="fancybox-share"><h1>{{SHARE}}</h1><p><a class="fancybox-share__button fancybox-share__button--fb" href="https://www.facebook.com/sharer/sharer.php?u={{url}}"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m287 456v-299c0-21 6-35 35-35h38v-63c-7-1-29-3-55-3-54 0-91 33-91 94v306m143-254h-205v72h196" /></svg><span>Facebook</span></a><a class="fancybox-share__button fancybox-share__button--tw" href="https://twitter.com/intent/tweet?url={{url}}&text={{descr}}"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m456 133c-14 7-31 11-47 13 17-10 30-27 37-46-15 10-34 16-52 20-61-62-157-7-141 75-68-3-129-35-169-85-22 37-11 86 26 109-13 0-26-4-37-9 0 39 28 72 65 80-12 3-25 4-37 2 10 33 41 57 77 57-42 30-77 38-122 34 170 111 378-32 359-208 16-11 30-25 41-42z" /></svg><span>Twitter</span></a><a class="fancybox-share__button fancybox-share__button--pt" href="https://www.pinterest.com/pin/create/button/?url={{url}}&description={{descr}}&media={{media}}"><svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m265 56c-109 0-164 78-164 144 0 39 15 74 47 87 5 2 10 0 12-5l4-19c2-6 1-8-3-13-9-11-15-25-15-45 0-58 43-110 113-110 62 0 96 38 96 88 0 67-30 122-73 122-24 0-42-19-36-44 6-29 20-60 20-81 0-19-10-35-31-35-25 0-44 26-44 60 0 21 7 36 7 36l-30 125c-8 37-1 83 0 87 0 3 4 4 5 2 2-3 32-39 42-75l16-64c8 16 31 29 56 29 74 0 124-67 124-157 0-69-58-132-146-132z" fill="#fff"/></svg><span>Pinterest</span></a></p><p><input class="fancybox-share__input" type="text" value="{{url_raw}}" /></p></div>',
      },
    }),
      e(t).on('click', '[data-fancybox-share]', function () {
        var t,
          o,
          i = e.fancybox.getInstance(),
          a = i.current || null;
        a &&
          ('function' === e.type(a.opts.share.url) &&
            (t = a.opts.share.url.apply(a, [i, a])),
          (o = a.opts.share.tpl
            .replace(
              /\{\{media\}\}/g,
              'image' === a.type ? encodeURIComponent(a.src) : ''
            )
            .replace(/\{\{url\}\}/g, encodeURIComponent(t))
            .replace(/\{\{url_raw\}\}/g, n(t))
            .replace(
              /\{\{descr\}\}/g,
              i.$caption ? encodeURIComponent(i.$caption.text()) : ''
            )),
          e.fancybox.open({
            src: i.translate(i, o),
            type: 'html',
            opts: {
              animationEffect: !1,
              afterLoad: function (t, e) {
                i.$refs.container.one('beforeClose.fb', function () {
                  t.close(null, 0);
                }),
                  e.$content
                    .find('.fancybox-share__links a')
                    .click(function () {
                      return (
                        window.open(
                          this.href,
                          'Share',
                          'width=550, height=450'
                        ),
                        !1
                      );
                    });
              },
            },
          }));
      });
  })(document, window.jQuery || jQuery),
  (function (t, e, n) {
    'use strict';
    function o() {
      var t = e.location.hash.substr(1),
        n = t.split('-'),
        o =
          n.length > 1 && /^\+?\d+$/.test(n[n.length - 1])
            ? parseInt(n.pop(-1), 10) || 1
            : 1,
        i = n.join('-');
      return { hash: t, index: o < 1 ? 1 : o, gallery: i };
    }
    function i(t) {
      var e;
      '' !== t.gallery &&
        (e = n("[data-fancybox='" + n.escapeSelector(t.gallery) + "']")
          .eq(t.index - 1)
          .trigger('click.fb-start'));
    }
    function a(t) {
      var e, n;
      return (
        !!t &&
        ((e = t.current ? t.current.opts : t.opts),
        (n = e.hash || (e.$orig ? e.$orig.data('fancybox') : '')),
        '' !== n && n)
      );
    }
    n.escapeSelector ||
      (n.escapeSelector = function (t) {
        var e = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g,
          n = function (t, e) {
            return e
              ? '\0' === t
                ? '�'
                : t.slice(0, -1) +
                  '\\' +
                  t.charCodeAt(t.length - 1).toString(16) +
                  ' '
              : '\\' + t;
          };
        return (t + '').replace(e, n);
      }),
      n(function () {
        n.fancybox.defaults.hash !== !1 &&
          (n(t).on({
            'onInit.fb': function (t, e) {
              var n, i;
              e.group[e.currIndex].opts.hash !== !1 &&
                ((n = o()),
                (i = a(e)),
                i &&
                  n.gallery &&
                  i == n.gallery &&
                  (e.currIndex = n.index - 1));
            },
            'beforeShow.fb': function (n, o, i, s) {
              var r;
              i &&
                i.opts.hash !== !1 &&
                ((r = a(o)),
                r &&
                  ((o.currentHash =
                    r + (o.group.length > 1 ? '-' + (i.index + 1) : '')),
                  e.location.hash !== '#' + o.currentHash &&
                    (o.origHash || (o.origHash = e.location.hash),
                    o.hashTimer && clearTimeout(o.hashTimer),
                    (o.hashTimer = setTimeout(function () {
                      'replaceState' in e.history
                        ? (e.history[s ? 'pushState' : 'replaceState'](
                            {},
                            t.title,
                            e.location.pathname +
                              e.location.search +
                              '#' +
                              o.currentHash
                          ),
                          s && (o.hasCreatedHistory = !0))
                        : (e.location.hash = o.currentHash),
                        (o.hashTimer = null);
                    }, 300)))));
            },
            'beforeClose.fb': function (n, o, i) {
              var s;
              i.opts.hash !== !1 &&
                ((s = a(o)),
                o.currentHash && o.hasCreatedHistory
                  ? e.history.back()
                  : o.currentHash &&
                    ('replaceState' in e.history
                      ? e.history.replaceState(
                          {},
                          t.title,
                          e.location.pathname +
                            e.location.search +
                            (o.origHash || '')
                        )
                      : (e.location.hash = o.origHash)),
                (o.currentHash = null),
                clearTimeout(o.hashTimer));
            },
          }),
          n(e).on('hashchange.fb', function () {
            var t,
              e = o();
            n.each(n('.fancybox-container').get().reverse(), function (e, o) {
              var i = n(o).data('FancyBox');
              if (i.currentHash) return (t = i), !1;
            }),
              t
                ? !t.currentHash ||
                  t.currentHash === e.gallery + '-' + e.index ||
                  (1 === e.index && t.currentHash == e.gallery) ||
                  ((t.currentHash = null), t.close())
                : '' !== e.gallery && i(e);
          }),
          setTimeout(function () {
            n.fancybox.getInstance() || i(o());
          }, 50));
      });
  })(document, window, window.jQuery || jQuery),
  (function (t, e) {
    'use strict';
    var n = new Date().getTime();
    e(t).on({
      'onInit.fb': function (t, e, o) {
        e.$refs.stage.on(
          'mousewheel DOMMouseScroll wheel MozMousePixelScroll',
          function (t) {
            var o = e.current,
              i = new Date().getTime();
            e.group.length < 2 ||
              o.opts.wheel === !1 ||
              ('auto' === o.opts.wheel && 'image' !== o.type) ||
              (t.preventDefault(),
              t.stopPropagation(),
              o.$slide.hasClass('fancybox-animated') ||
                ((t = t.originalEvent || t),
                i - n < 250 ||
                  ((n = i),
                  e[
                    (-t.deltaY || -t.deltaX || t.wheelDelta || -t.detail) < 0
                      ? 'next'
                      : 'previous'
                  ]())));
          }
        );
      },
    });
  })(document, window.jQuery || jQuery);
