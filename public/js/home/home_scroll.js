document.querySelector('.cta-button').addEventListener('click', function (event) {
    event.preventDefault();
    document.querySelector('#services').scrollIntoView({
        behavior: 'smooth'
    });
});