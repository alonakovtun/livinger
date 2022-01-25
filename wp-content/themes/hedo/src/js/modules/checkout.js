const checkout = () => {
    const accHed = document.querySelectorAll('.checkout__invoice');

    if (!accHed) return;

    accHed.forEach(acc => {
      acc.addEventListener('click', () => {
        acc.classList.toggle('active');
        acc.nextElementSibling.classList.toggle('active');
      })
    })
};


export default checkout;

export const swapLoginForm = () => {
    const buttonTrigger = document.querySelector('.button__trigger-checkout'),
          formHide = document.querySelector('.log-in'),
          titleCheckout = document.querySelector('.checkout__txt-title'),
          page = document.querySelector('.checkout-swap');

    if (!buttonTrigger) return;

    buttonTrigger.addEventListener('click', (e) => {
        e.preventDefault();

        formHide.classList.add('animated', 'fadeOutLeft');
        setTimeout(() => {
            formHide.style.display = 'none';
            page.classList.remove('checkout__hidden')
            titleCheckout.textContent = 'Podsumowanie';
            page.classList.add('animated', 'fadeInUp');
        }, 1000)
    })
}