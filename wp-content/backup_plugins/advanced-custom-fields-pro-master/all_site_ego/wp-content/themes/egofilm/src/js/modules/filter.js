// import openAbout from '../modules/open-about';

const filter = () => {
  const items = document.querySelectorAll('.index-page__menu-item a');

  items.forEach((item) => {
    item.addEventListener('click', () => {
      items.forEach((link) => link.classList.remove('active'));
      item.classList.add('active');

      // setTimeout(() => {
      //   openAbout();
      // }, 2000);
    });
  });
};

export default filter;
