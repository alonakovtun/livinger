const checkoutValidation = () => {
    const form = document.querySelector('.checkout-swap');

    if (!form) return;

    const inputName = form.querySelector('input[name="billing_first_name"]'),
    inputFirstName = form.querySelector('input[name="billing_last_name"]'),
    inputPostCode= form.querySelector('input[name="billing_postcode"]'),
    inputCity= form.querySelector('input[name="billing_city"]'),
    inputPhone= form.querySelector('input[name="billing_phone"]'),
    inputEmail= form.querySelector('input[name="billing_email"]'),
    allInput = form.querySelectorAll('.validate-required input');


    allInput.forEach(item => {
        console.log(item);
    })

    const validationInputs = (elem, len) => {
        if (elem.value.length >= len) {
            elem.style.borderBottomColor = '#009f88'; //d1b86c
            // elem.style.boxShadow = '0 0 0 0.25rem rgba(25, 253, 13, 0.25)';
            return true;
        } else {
            elem.style.borderBottomColor = '#9f0000';
            // elem.style.boxShadow = '0 0 0 0.25rem rgba(253, 13, 13, 0.25)';
            return false;
        }
    }


    inputName.addEventListener('input', () => {
        validationInputs(inputName, 4);
    })

    console.log(inputName);


    console.log(form);

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        console.log('click');
    })
};

export default checkoutValidation;