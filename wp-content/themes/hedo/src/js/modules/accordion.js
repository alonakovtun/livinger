const accordion = (head, body, activeClass) => {
  const elementHead = document.querySelectorAll(head),
        elementBody = document.querySelectorAll(body);

  if (!elementHead) return;

  elementHead.forEach(head => {
    head.addEventListener('click', (e) => {
      e.preventDefault();
      head.nextElementSibling.classList.toggle(activeClass);
    });
  })
};

export default accordion;