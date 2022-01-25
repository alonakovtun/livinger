const form = () => {
  const trigger = document.querySelectorAll('.praca__header'),
    triggerClose = document.querySelectorAll('.praca__container .txt-default');

  if (!trigger) return;

  trigger.forEach((item) => {
    item.addEventListener('click', () => {
      document.body.style.overflow = 'hidden';
      item.nextElementSibling.classList.add('active');
    });
  });

  triggerClose.forEach((button) => {
    button.addEventListener('click', () => {
      document.body.style.overflow = 'auto';
      button.parentNode.parentNode.parentNode.classList.remove('active');
    });
  });
};

export default form;
