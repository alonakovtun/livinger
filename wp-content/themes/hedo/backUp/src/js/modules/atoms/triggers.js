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

    console.log(elClick);

    elClick.addEventListener('click', (e) => {
        e.preventDefault();
        elShow.classList.add(activeClass);
    })
};

export default triggers;
