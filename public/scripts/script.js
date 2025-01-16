const closeFlash = document.querySelectorAll('.flashContainer .close');
closeFlash.forEach(close => {
    close.addEventListener('click', () => {
        close.parentElement.remove();
    })
})