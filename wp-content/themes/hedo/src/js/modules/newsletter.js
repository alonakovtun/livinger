const newsletter = () => {
  const newsletterbox = document.querySelector('.modal-newsletter');

  if(!newsletterbox) return;

  if (localStorage.getItem('newsletter')) {
    newsletterbox.classList.remove('_active');

    const alert = newsletterbox.querySelector('.mc4wp-alert');

    if (alert) {
      localStorage.setItem('newsletter', true);
    } else {
      newsletterbox.classList.remove('_active');
      localStorage.setItem('newsletter', true);
    }


  } else {
    newsletterbox.classList.add('_active');
    const alert = newsletterbox.querySelector('.mc4wp-alert');

    if (alert) {
      localStorage.setItem('newsletter', true);
    }
  }

  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-newsletter')) {
      newsletterbox.classList.remove('_active');
      const alert = newsletterbox.querySelector('.mc4wp-alert');
      if (alert) {
        alert.remove();
      }
    }
  });

  document.querySelector('.modal-newsletter__close').addEventListener('click', () => {
    newsletterbox.classList.remove('_active');
    const alert = newsletterbox.querySelector('.mc4wp-alert');
    if (alert) {
      alert.remove();
    }
  });
};

export default newsletter;