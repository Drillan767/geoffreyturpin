export default function () {
    let observer = new IntersectionObserver((observables) => {
        observables.forEach((observable) => {
            if (observable.intersectionRatio > 0.25) {
                observable.target.classList.add('in-view');
                observer.unobserve(observable.target);
            }
        })
    }, {
        threshold: [0.25]
    })

    let items = document.querySelectorAll('.timeline li');
    items.forEach((item) => {
        observer.observe(item);
    })

}
