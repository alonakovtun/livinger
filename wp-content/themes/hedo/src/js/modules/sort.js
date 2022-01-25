const sort = () => {
  if (/shop/.test(window.location.pathname) || /product-category/.test(window.location.pathname)) {
    const options = document.querySelectorAll('.orderby option'),
        fakeSort = document.querySelector('.filter-body-sort ul');
    if (!options) return;
    console.log('da');


    options.forEach(item => {
      const li = document.createElement('li');
      li.innerHTML = `
        <a href="javascript:void(0)" class="sort-item">
          ${item.textContent}
        </a>
      `
       fakeSort.appendChild(li);
    })

    const items = document.querySelectorAll('.sort-item');

    items.forEach(item => {
      item.addEventListener('click', (e) => {
        e.preventDefault();
        items.forEach(a => a.parentNode.classList.remove('chosen'));
        item.parentNode.classList.add('chosen');

        const txt = item.textContent.replace(/\s/g, '');
        options.forEach(option => {
          if (option.textContent.replace(/\s/g, '') == txt) {
            jQuery('.orderby').val(option.value).trigger('change');
          }
        })
      });
    });



  }
};

export default sort;