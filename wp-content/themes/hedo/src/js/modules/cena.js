const filterCena = () => {
  if (/shop/.test(window.location.pathname) || /product-category/.test(window.location.pathname)) {
    const filterOd = document.querySelector('.filter-od'),
          filterDo = document.querySelector('.filter-do'),
          buttonAdd = document.querySelector('.button-ok'),
          buttonReset = document.querySelector('.button-reset');

    if (!filterOd) return;

    const validOd = (input, min, max) => {
      let validLength = input.value.length !== 0;
      let validMin = parseInt(input.value) < min;
      let validMax = parseInt(input.value) > max;

      return (validLength === validMin === validMax)
    }

    setTimeout(() => {
      const inputMin = document.querySelector(".noUi-target").getAttribute('data-min'),
      inputMax = document.querySelector('.noUi-target').getAttribute('data-max');

      filterOd.setAttribute('placeholder', inputMin.replace(/[^+\d]/g, ''));
      filterDo.setAttribute('placeholder', inputMax.replace(/[^+\d]/g, ''));


      filterOd.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/[^0-9\.]/g, '');
        validOd(e.target, inputMin.replace(/[^+\d]/g, ''), inputMax.replace(/[^+\d]/g, ''))
          ? filterOd.style.borderColor = 'green'
          : filterOd.style.borderColor = 'red';
      })

      filterDo.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/[^0-9\.]/g, '');


        validOd(e.target, inputMin.replace(/[^+\d]/g, ''), inputMax.replace(/[^+\d]/g, ''))
          ? filterDo.style.borderColor = 'green'
          : filterDo.style.borderColor = 'red';
      })

      buttonReset.addEventListener('click', () => {
        window.location.href = window.location.href + `&min-price=${filterOd.getAttribute('placeholder')}&max-price=${filterDo.getAttribute('placeholder')}`;
      })

      buttonAdd.addEventListener('click', (e) => {
        e.preventDefault();

        if (validOd(filterOd, inputMin.replace(/[^+\d]/g, ''), inputMax.replace(/[^+\d]/g, ''))
          && validOd(filterDo, inputMin.replace(/[^+\d]/g, ''), inputMax.replace(/[^+\d]/g, ''))) {
            /&min-price/.test(window.location.pathname)
              ? window.location.href = window.location.href.replace(/\*([^*]+)\*/g , '<i>$1</i>')
              : window.location.href = window.location.href + `&min-price=${filterOd.value}&max-price=${filterDo.value}`
        } else {
          alert('Validation Error');
        }
      });
    })
  }
};

export default filterCena;