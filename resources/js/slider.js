export default function () {
    const carousel = document.querySelector('.carousel');
    const image = document.querySelector('.compoimage');
    const music = document.querySelector('.puremusic');

    image.addEventListener('click', () => {
        if (! image.classList.contains('selected')) {
            carousel.style.transform = "translateX(0)"
            image.classList.add('selected');
            music.classList.remove('selected');
        }
    });


    music.addEventListener('click', () => {
        if (! music.classList.contains('selected')) {
            carousel.style.transform = "translateX(-100%)";
            music.classList.add('selected');
            image.classList.remove('selected');
        }
    });
}
