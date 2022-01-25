const acceptModal = () => {
  const trigger = document.querySelectorAll('.checkout__remove'),
        modal = document.querySelector('.accept'),
        buttonAccept = modal.querySelector('.btn-accept'),
        buttonCancel = modal.querySelector('.btn-cancel');

  if (!trigger) return;

  let href = '';

  trigger.forEach(item => {
    item.addEventListener('click', (e) => {
      e.preventDefault();
      modal.classList.add('_active');
      href = item;

      buttonAccept.setAttribute('href', item.getAttribute('href'))
    });
  });

  buttonCancel.addEventListener('click', (e) => {
    e.preventDefault();
    modal.classList.remove('_active');
  });


  document.documentElement.addEventListener('click', (e) => {
    if (!e.target.closest('.accept__container') && !e.target.closest('.checkout__remove')) {
      modal.classList.remove('_active');
    }
  })

};

export default acceptModal;