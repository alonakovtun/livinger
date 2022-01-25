import $ from 'jquery';

const filters = () => {
  const elems = document.querySelectorAll('.filters__element');
  const prices = document.querySelectorAll('.wcapf-price-filter-wrapper .slider-values p');
  let elemClick;

  if (!elems) return;

  elems.forEach(elem => {
    elem.querySelector('.filters__head').addEventListener('click', (e) => {
      if (e.target.parentNode !== elemClick) {
        elems.forEach(item => item.classList.remove('_active'))
      }

      if (e.target.parentNode.parentNode.classList.contains('_active')) {
        elem.classList.remove('_active')
      } else {
        elem.classList.add('_active')
        elemClick  = e.target.parentNode;
      }
    });
  });

  prices.forEach((item, i) => {
    if (i == 0) {
      const txt = item.innerHTML;
      const replace = txt.replace(/Min Price:/g, '');
      item.innerHTML = replace;
    } else {
      const txt2 = item.innerHTML;
      const replace2 = txt2.replace(/Max Price:/g, '');
      item.innerHTML = replace2;
    }
  });
};


export default filters;