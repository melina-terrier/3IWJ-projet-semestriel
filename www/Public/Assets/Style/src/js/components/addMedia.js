document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn = document.getElementById('openMediaModal');
    const modal = document.getElementById('mediaModal');
    const closeBtn = document.querySelector('.close');
    const saveMediaBtn = document.getElementById('saveMedia');

    openModalBtn.addEventListener('click', (event) => {
        event.preventDefault();
        modal.style.display = 'block';
    });

    closeBtn.addEventListener('click', (event) => {
        event.preventDefault;
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        event.preventDefault;
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    saveMediaBtn.addEventListener('click', (event) => {
        event.preventDefault;
    });

});