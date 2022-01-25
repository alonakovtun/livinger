const selectFix = () => {
    const optionCustom = document.querySelectorAll('.select2-results__option');

    if (!optionCustom) return;

    optionCustom.forEach(option => {
      console.log(option);
    })
};

export default selectFix;