const renderDOM = (element, renderBlock) => {
  const el = document.querySelector(element),
        block = document.querySelector(renderBlock);

  const html = el.innerHTML;
  el.remove();
  block.appendChild(el);
};

export default renderDOM;