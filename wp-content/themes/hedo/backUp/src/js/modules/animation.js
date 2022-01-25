const animation = () => {
    const tl = gsap.timeline();

    gsap.to('.animation-image', {
        duration: 0.8,
        delay: 1.3,
        clipPath: "polygon(0 0, 100% 0, 100% 100%, 0% 100%",
    });

    // gsap.to('.preloader-in', {
    //     duration: 1.7,
    //     width: '0%',
    //     left: '0%',
    //     ease: 'Expo.easeInOut'
    // });
    //
    // const triggers = (triggerElement) => {
    //     const buttonTrigger = document.querySelectorAll(triggerElement);
    //
    //     buttonTrigger.forEach(trigger => {
    //         trigger.addEventListener('click', (e) => {
    //             gsap.to('.preloader-out', {
    //                 duration: 0.8,
    //                 width: '100%',
    //                 right: '0%',
    //                 ease: 'Expo.easeIn'
    //             });
    //         })
    //     });
    // }
    // triggers('.menu-item a');
    // triggers('.trigger-change');

};

export default animation;