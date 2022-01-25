const subMenu = () => {
    const parentMenu = document.querySelectorAll('.menu-item-has-children');

    if (!parentMenu) return;

    parentMenu.forEach(item => {
        const subMenu = item.querySelector('.sub-menu');
        const element = document.createElement('ul');
        (window.innerWidth || document.documentElement.clientWidth) > 720
        ? element.classList.add('sub-menu')
        : element.classList.add('submenu');

        element.innerHTML = subMenu.innerHTML;
        subMenu.remove();
        item.parentNode.insertBefore(element, item.nextElementSibling);
    })
};

export const subMenuHover = () => {
    const parentMenu = document.querySelectorAll('.menu-item-has-children');

    if (!parentMenu) return;

    parentMenu.forEach(item => {
       item.addEventListener('mouseenter', () => {
           item.nextElementSibling.classList.add('_active');
           item.classList.add('_active');
       });

       item.addEventListener('mouseleave', () => {
           item.nextElementSibling.addEventListener('mouseenter', () => {
               item.nextElementSibling.classList.add('_active');
               item.classList.add('_active');
           })
           item.nextElementSibling.addEventListener('mouseleave', () => {
               item.nextElementSibling.classList.remove('_active');
                  item.classList.remove('_active');
           })
           item.nextElementSibling.classList.remove('_active');
              item.classList.remove('_active');
       })
    });



};

export default subMenu;
