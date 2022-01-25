const singleProduct = () => {
  const path = window.location.pathname,
        elements = document.querySelectorAll('.product__more-element');

  if (!elements) return;

  elements.forEach(item => {
    const link = item.getAttribute('href').replace('http://hedo.puzzlestudio.eu', '');

    if (path === link) {
      item.classList.add('_active');
    }
  });
};

export default singleProduct;