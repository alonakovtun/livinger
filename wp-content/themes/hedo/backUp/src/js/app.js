import initAll from './modules/initAll';
import account from './modules/account';
import accordion from './modules/accordion';
import subMenu, {subMenuHover} from './modules/header/sub-menu';
import filters from './modules/shop/filters'
import tabs from './modules/tabs';
import animation from './modules/animation';
import miniCart from './modules/mini-cart';
import triggers from "./modules/atoms/triggers";
import singleProduct from './modules/single-product/single-product';
import checkout, { swapLoginForm } from './modules/checkout';
import HoverSlide from './modules/hoverSlide';
import checkoutValidation from "./modules/checkout-validation";
import { cookies } from './modules/modals';
import {
  bagMobile,
  burgerMobile,
  menuMobile,
  toggleMiniCart,
  toggleMenuFooter,
  mobileFilters } from './modules/mobile';


window.addEventListener('DOMContentLoaded', () => {
  'use strict';

  // variantSwatch();
  initAll();
  subMenu();
  subMenuHover()

  account();
  filters();
  tabs('.tabs__element-head');
  animation();
  miniCart();
  (/checkout/i).test(window.location.pathname) ? checkout() : null;
  accordion('.faq .accordion__head', '.faq .accordion__body', '_active');
  triggers('.search-trigger', '.search-pop', 'search_active');
  singleProduct();
  swapLoginForm();
  HoverSlide();
  checkoutValidation();
  cookies();
  //
  // cart();
  // selectFix();


  // --------MOBILE --------
  if ((window.innerWidth || document.documentElement.clientWidth) < 720) {
    burgerMobile();
    bagMobile();
    menuMobile();
    toggleMiniCart();
    mobileFilters();
    toggleMenuFooter();
  }
});
