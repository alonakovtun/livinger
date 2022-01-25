<script src="https://unpkg.com/@barba/core"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>
<script>
function pageTransition() {
    var tl = gsap.timeline();

    tl.to('ul.transition li', {
      duration: 0.5,
      scaleY: 1,
      transformOrigin: 'bottom left',
      stagger: 0.2,
    });
    tl.to('ul.transition li', {
      duration: 0.5,
      scaleY: 0,
      transformOrigin: 'bottom left',
      stagger: 0.1,
      delay: 0.1,
    });
  }

  function delay(n) {
    n = n || 2000;
    return new Promise((done) => {
      setTimeout(() => {
        done();
      }, n);
    });
  }

  barba.init({
    sync: true,

    transitions: [
      {
        async leave(data) {
          const done = this.async();

          pageTransition();
          await delay(1500);
          done();
        },
        // async enter(data) {
        //   contentAnimaiton();
        // },

        // async once(data) {
        //   contentAnimaiton();
        // },
      },
    ],
  });
</script>