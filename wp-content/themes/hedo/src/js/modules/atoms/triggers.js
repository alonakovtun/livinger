const triggers = (elementClick, elementShow, activeClass) => {
    const elClick = document.querySelector(elementClick),
          elShow = document.querySelector(elementShow);

    document.addEventListener('click', function(e) {
        if (!e.target.closest(elementClick)) {
            if (elShow.classList.contains(activeClass)) {
                if (e.target.closest(elementShow) == null) {
                    elShow.classList.remove(activeClass);
                }
            }
        }
    });

    elClick.addEventListener('click', (e) => {
        e.preventDefault();

        if (elementClick === '.search-trigger') {
          setTimeout(() => {
            elShow.querySelector('.textarea__search').focus();
          }, 300)
        }
        elShow.classList.add(activeClass);

    })
};

export default triggers;
