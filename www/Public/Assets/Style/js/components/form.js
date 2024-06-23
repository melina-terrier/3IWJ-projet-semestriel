document.addEventListener('DOMContentLoaded', () => {
    const boutonAjouter = document.getElementById('add-link');
    const inputName = boutonAjouter.getAttribute('data-link');
    const container = document.getElementById(inputName);

    let nombreChamps = 1;

    boutonAjouter.addEventListener('click', (event) => {
        event.preventDefault();
        
        const input = document.createElement('input');
        input.type = 'text';
        input.id = inputName+nombreChamps;
        input.name = inputName;
        console.log(input);
        
        container.appendChild(input);
        console.log(container);
        
        nombreChamps++;
    });
});
