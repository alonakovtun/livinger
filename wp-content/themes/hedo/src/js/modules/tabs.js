const tabs = (trigger) => {
  const triggers = document.querySelectorAll(trigger);

  if (!triggers) return;

  triggers.forEach(item => {
    item.addEventListener('click', (e) => {
      e.preventDefault();

      item.classList.toggle('_active');
      item.nextElementSibling.classList.toggle('_active');
    })
  });
};

export default tabs;