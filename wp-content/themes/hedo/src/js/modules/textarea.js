const textarea = (inputWrapper, activeClass) => {
  const inputsWrapper = document.querySelectorAll(inputWrapper);

  if (!inputWrapper) return;

  inputsWrapper.forEach(wrapper => {
    const input = wrapper.querySelector('input'),
          label = wrapper.querySelector('label');



    if (input !== null) {
      if (input.value.length >= 1) {
        label.classList.add(activeClass)
      }

      if (input.placeholder) {
        label.classList.add(activeClass)
      }

      input.addEventListener('focus', () => {
        label.classList.add(activeClass)
      });
      input.addEventListener('blur', () => {
        if (input.value.length >= 1) {
          label.classList.add(activeClass)
        } else {
          label.classList.remove(activeClass);

          if (input.placeholder) {
            label.classList.add(activeClass)
          }
        }
      });
    }
  })
};

export default textarea;