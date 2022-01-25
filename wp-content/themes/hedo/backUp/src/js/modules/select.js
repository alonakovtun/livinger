import $ from 'jquery';
import select2 from 'select2';

const select = () => {
  $('.js-example-basic-single').select2({
    placeholder: 'Select an option',
    dropdownCssClass: 'product__select-open',
    selectionCssClass: 'product__select'
  });

  $('.shipping_country').select2({
    placeholder: 'Select an option',
    dropdownCssClass: 'product__select-open',
    selectionCssClass: 'product__select'
  });

  $('.single-product_select').select2({
    placeholder: 'Select an option',
    dropdownCssClass: 'product__select-open',
    selectionCssClass: 'product__select'
  });
}

export default select;