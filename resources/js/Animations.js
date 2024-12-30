import gsap from "gsap";


const Animations = {

    cardBeforeEnter: (el) => {
        el.style.transform = "translateY(60px)";
        el.style.opacity = 0;
    },

    cardEnter: (el, done) => {
        gsap.to(el, {
            duration: 0.8,
            y: 0,
            opacity: 1,
            onComplete: done,
            delay: el.dataset.index * 0.1,
            ease: "power3.out",
        });
    }

}

export default  Animations;