document.addEventListener('DOMContentLoaded', () => {
    const addToMenuLink = document.getElementById('add-to-menu');
    const addExternalLinkButton = document.getElementById('add-external-link');
    const dropFrame = document.querySelector('.menu-list');
    const saveMenuButton = document.querySelector('[type="submit"]');

    addToMenuLink.addEventListener('click', (e) => {
        e.preventDefault();
        const checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        checkedCheckboxes.forEach(checkbox => {
            const label = document.querySelector(`label[for='${checkbox.id}']`);
            if (label) {
                const listItem = createMenuItem(label.textContent, checkbox.id, 'page');
                dropFrame.appendChild(listItem);
            }
        });
    });

    addExternalLinkButton.addEventListener('click', (e) => {
        e.preventDefault();
        const title = document.getElementById('external-link-title').value;
        const url = document.getElementById('external-link-url').value;
        if (title && url) {
            const listItem = createMenuItem(title, url, 'external_link');
            dropFrame.appendChild(listItem);
        }
    });

    saveMenuButton.addEventListener('click', (e) => {
        e.preventDefault(); // Empêche la soumission du formulaire par défaut
        const menuItems = Array.from(dropFrame.children).map(item => ({
            id: item.dataset.checkboxId,
            type: item.dataset.type,
            title: item.textContent.replace('Supprimer', '').trim(),
            url: item.dataset.type === 'external_link' ? item.dataset.url : null
        }));
        sendSaveMenuRequest(menuItems);
    });

    function createMenuItem(text, id, type) {
        const listItem = document.createElement('div');
        listItem.className = 'menu-item';
        listItem.textContent = text;
        listItem.dataset.checkboxId = id;
        listItem.dataset.type = type;
        if (type === 'external_link') {
            listItem.dataset.url = id;
        }
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Supprimer';
        deleteButton.addEventListener('click', () => {
            dropFrame.removeChild(listItem);
        });
        listItem.appendChild(deleteButton);
        listItem.draggable = true;
        listItem.addEventListener('dragstart', handleDragStart);
        listItem.addEventListener('dragover', handleDragOver);
        listItem.addEventListener('drop', handleDrop);
        return listItem;
    }

    function handleDragStart(e) {
        e.dataTransfer.setData('text/plain', e.target.dataset.checkboxId);
        e.dataTransfer.effectAllowed = 'move';
        this.style.opacity = '0.4';
    }

    function handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    }

    function handleDrop(e) {
        e.preventDefault();
        e.stopPropagation();
        const draggedId = e.dataTransfer.getData('text/plain');
        const draggedItem = [...dropFrame.children].find(item => item.dataset.checkboxId === draggedId);
        if (draggedItem && draggedItem !== this) {
            dropFrame.insertBefore(draggedItem, this);
        }
        draggedItem.style.opacity = '1.0';
    }

    function sendSaveMenuRequest(menuItems) {
        fetch('/dashboard/menu', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: 'setMenu',
                menuItems: menuItems
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Menu sauvegardé avec succès!");
            } else {
                alert("Une erreur est survenue: " + data.errors.join(', '));
            }
        })
        .catch(error => {
            console.error('Error saving menu:', error);
            alert("Une erreur est survenue lors de la sauvegarde du menu.");
        });
    }
});
