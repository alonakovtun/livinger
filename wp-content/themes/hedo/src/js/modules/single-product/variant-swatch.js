const variantSwatch = () => {
  const variant = document.querySelector('.single-product .variations_form .variations');

  if (!variant) return;
  setTimeout(() => {
    const variantHtml = variant.innerHTML,
    variantElem = document.createElement('table');

    variantElem.classList.add('variations');
    variantElem.setAttribute('cellspacing', '0');

    variantElem.innerHTML = variantHtml;

    const appendElem = variant.nextElementSibling.querySelector('.product__variant');
    appendElem.appendChild(variantElem);
    variant.remove();
  }, 1000)
};

export default variantSwatch;