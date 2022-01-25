const miniCart = () => {
  const triggerButton = document.querySelector('.mini-cart-trigger'),
        cart = document.querySelector('.mini-cart'),
        closeButton = document.querySelector('.mini-cart__close');

  document.documentElement.addEventListener('click', (e) => {
    if (!e.target.closest('.mini-cart-trigger')) {
      if (e.target.closest('.accept') == null && !e.target.closest('.mini-cart')) {
        cart.classList.remove('_active');
        document.body.classList.remove('mini-cart_active');
      }
    }
  })


  triggerButton.addEventListener('click', (e) => {
    e.preventDefault();

    cart.classList.add('_active');
    document.body.classList.add('mini-cart_active');
  });

  closeButton.addEventListener('click', (e) => {
    e.preventDefault();

    cart.classList.remove('_active');
    document.body.classList.remove('mini-cart_active');
  })


};

export default miniCart;