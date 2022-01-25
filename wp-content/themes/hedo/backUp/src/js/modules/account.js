const account = () => {
  const buttonTrigger = document.querySelector('.button__trigger-register'),
        visibileBox = document.querySelector('.login-box'),
        hiddenBox = document.querySelector('.register-box');

  if (!buttonTrigger) return;
  if (!visibileBox) return;

  buttonTrigger.addEventListener('click', (e) => {
    e.preventDefault();
    visibileBox.classList.add('animated', 'fadeOutLeft');
    setTimeout(() => {
      visibileBox.style.display = 'none';
      hiddenBox.style.display = 'block';
      hiddenBox.classList.add('animated', 'fadeInUp')
    }, 1000)
  });
};

export default account;