export const cookies = () => {
    const closeCookies = document.querySelector('.cookies__close');

    if (!closeCookies) return;

    if (localStorage.getItem('cookies')) {
      closeCookies.parentNode.parentNode.style.display = 'none';
    } else {
      closeCookies.parentNode.parentNode.style.display = 'block';
      localStorage.setItem('cookies', true);
    }

    closeCookies.addEventListener('click', (e) => {
        e.preventDefault();
        closeCookies.parentNode.parentNode.classList.add('_hide');
        localStorage.setItem('cookies', true);
    })
};
