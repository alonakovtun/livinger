import filter from './modules/filter';
import form from './modules/form';

window.addEventListener('DOMContentLoaded', () => {
  'use strict';

  if (/career/.test(window.location.pathname)) {
    form();
  }
  if (/index/.test(window.location.pathname)) {
    filter();
  }
});
