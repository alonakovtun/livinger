function checkProduct(newProductLength) {
  var allProductArray = document.querySelectorAll('.project_unit');
  var inArray = Array.from(allProductArray);
  startProductLength = allProductArray.length;
  var newElements = inArray.slice(startProductLength - newProductLength);

  newElements.forEach((element) => {
    var containerElement = element.querySelector('.gallery__container');
    var videoElement = containerElement.querySelector('.video-hover');

    var closeProduct = containerElement.previousElementSibling.querySelector(
      '.close-li'
    );
    var playPauseButton = containerElement.previousElementSibling.querySelector(
      '.pause-li'
    );

    var muteUnmuteButton = containerElement.previousElementSibling.querySelector(
      '.muted-li'
    );

    var fullscreenButton = containerElement.previousElementSibling.querySelector(
      '.fullscreen-li'
    );

    var infoCloseInfoButton = containerElement.previousElementSibling.querySelector(
      '.info'
    );

    if (!videoElement.muted) {
      videoElement.muted = true;
    }

    containerElement.addEventListener('mouseenter', function () {
      playVideo(videoElement);
    });
    containerElement.addEventListener('mouseleave', function () {
      pauseVideo(videoElement);
    });

    containerElement.addEventListener('click', function (e) {
      jQuery('body')[0].style.overflow = 'hidden';
      jQuery('body').css({ marginRight: `${scroll}px` });

      var boxAboutInfo = containerElement.previousElementSibling;
      var videoElem = boxAboutInfo.querySelector('.video-banner__video');
      var source = videoElem.querySelector('source');

      checkSource(source, playPauseButton, muteUnmuteButton, fullscreenButton);

      if (!videoElem.muted) {
        videoElem.muted = true;
      }

      playVideo(videoElem);

      boxAboutInfo.classList.add('is-active');

      if ((window.innerWidth || document.documentElement.clientWidth) > 850) {
        jQuery('.header').addClass('is-hidden');
      }
    });

    closeProduct.addEventListener('click', function (e) {
      e.preventDefault();
      closeProject(closeProduct, 'is-active');
      jQuery('body')[0].style.overflow = 'auto';
      if ((window.innerWidth || document.documentElement.clientWidth) > 850) {
        jQuery('.header').removeClass('is-hidden');
      }
    });

    playPauseButton.addEventListener('click', function (e) {
      e.preventDefault();
      var video = playPauseButton.parentNode.parentNode.nextElementSibling.querySelector(
        '.video-banner__video'
      );

      playPauseVideoHandler(playPauseButton, video);
    });

    fullscreenButton.addEventListener('click', function (e) {
      e.preventDefault();
      const videoElem = fullscreenButton.parentNode.parentNode.nextElementSibling.querySelector(
        'video'
      );

      fullScreenVideo(videoElem, fullscreenButton);
    });

    muteUnmuteButton.addEventListener('click', function (e) {
      e.preventDefault();
      var video = muteUnmuteButton.parentNode.parentNode.nextElementSibling.querySelector(
        'video'
      );
      muteUnmuteVideoHandler(muteUnmuteButton, video);
    });

    infoCloseInfoButton.addEventListener('click', function (e) {
      e.preventDefault();
      var boxAboutInfo = infoCloseInfoButton.parentNode.parentNode.parentNode;
      infoCloseInfoHandler(infoCloseInfoButton, boxAboutInfo, 'is-active');
    });

    element.addEventListener('click', function (e) {
      e.preventDefault();
    });
  });
  /* ==============================
   * Fancy Box.
   * ============================== */

  jQuery(document).ready(function () {
    jQuery('[data-fancybox="gallery"]').fancybox({
      keyboard: true,
      infobar: false,
      arrows: true,
      buttons: [
        'zoom',
        //"share",
        'slideShow',
        //"fullScreen",
        //"download",
        'thumbs',
        'close',
      ],
      touch: {
        vertical: true, // Allow to drag content vertically
        momentum: true, // Continuous movement when panning
      },
    });
  });
}
