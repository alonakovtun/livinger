const fancyBox = () => {
  const images = document.querySelectorAll('.woocommerce-product-gallery__wrapper .swiper-slide');

  if (!images) return;

  images.forEach(element => {
    element.setAttribute('data-fancybox', '');
  });
};

export default fancyBox;