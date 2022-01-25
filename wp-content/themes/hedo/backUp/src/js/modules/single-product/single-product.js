const singleProduct = () => {
  const path = window.location.pathname,
        elements = document.querySelectorAll('.product__more-element');

  if (!elements) return;

  elements.forEach(item => {
    const link = item.getAttribute('href').replace('http://hedo.puzzlestudio.eu', '');
    console.log('link', link);
    console.log('path', path);

    if (path === link) {
      item.classList.add('_active');
    }
  });
};

export default singleProduct;