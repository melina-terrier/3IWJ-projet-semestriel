
document.addEventListener('DOMContentLoaded', () => {
    const addToMenuLink = document.getElementById('add-to-menu');
    const dropFrame = document.querySelector('.menu-list');
    const menuContentInput = document.getElementById('menu');

    if (addToMenuLink &&  dropFrame && menuContentInput) {
        const menuDataString = menuContentInput.value;
        const menuData = JSON.parse(menuDataString);

        menuData.forEach(menuItem => {
            const listItem = document.createElement('li');
            listItem.className = 'menu-item';
            listItem.dataset.id = menuItem.id;
            listItem.dataset.url = menuItem.url;

            const titleInput = document.createElement('input');
            titleInput.type = 'text';
            titleInput.value = menuItem.title;
            titleInput.addEventListener('input', updateMenuContentInput);

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Supprimer';
            deleteButton.addEventListener('click', () => {
                listItem.parentElement.removeChild(listItem);
                updateMenuContentInput();
            });

            listItem.appendChild(titleInput);
            listItem.appendChild(deleteButton);

            listItem.draggable = true;
            listItem.addEventListener('dragstart', handleDragStart);
            listItem.addEventListener('dragover', handleDragOver);
            listItem.addEventListener('drop', handleDrop);

            dropFrame.appendChild(listItem);
        });


        // Ajout d'un élément au menu à partir des checkboxes sélectionnées
        if (addToMenuLink) {
            addToMenuLink.addEventListener('click', (e) => {
                e.preventDefault();
                const checkedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
                checkedCheckboxes.forEach(checkbox => {
                    const label = document.querySelector(`label[for='${checkbox.id}']`);
                    if (label) {
                        const listItem = createMenuItem({
                            id: checkbox.id,
                            title: label.textContent,
                            url: checkbox.getAttribute('url'),
                            isCategory: false,
                        });
                        dropFrame.appendChild(listItem);
                        checkbox.checked = false;
                    }
                });
                updateMenuContentInput();
            });
        }


        // Fonction pour construire l'arbre du menu à partir de la liste HTML
        function buildMenuTree(list) {
            return Array.from(list.children).map((item, index) => {

                return {
                    id: item.dataset.id,
                    title: item.querySelector('input').value.trim(),
                    url: item.dataset.url,
                    position: index + 1, // Position dans le menu (index + 1)
                };
            });
        }

        // Fonction pour créer un élément de menu
        function createMenuItem(itemData) {
            const listItem = document.createElement('li');
            listItem.className = 'menu-item';
            listItem.dataset.id = itemData.id;
            listItem.dataset.url = itemData.url;

            const titleInput = document.createElement('input');
            titleInput.type = 'text';
            titleInput.value = itemData.title;
            titleInput.addEventListener('input', updateMenuContentInput);

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Supprimer';
            deleteButton.addEventListener('click', () => {
                listItem.parentElement.removeChild(listItem);
                updateMenuContentInput();
            });

            listItem.appendChild(titleInput);
            listItem.appendChild(deleteButton);

            listItem.draggable = true;
            listItem.addEventListener('dragstart', handleDragStart);
            listItem.addEventListener('dragover', handleDragOver);
            listItem.addEventListener('drop', handleDrop);

            return listItem;
        }

        // Fonction pour gérer le drag and drop
        function handleDragStart(e) {
            e.dataTransfer.setData('text/plain', e.target.dataset.id);
            e.dataTransfer.effectAllowed = 'move';
            this.classList.add('dragging');
        }

        function handleDragOver(e) {
            e.preventDefault();
            const draggedItem = document.querySelector('.dragging');
            if (draggedItem && this !== draggedItem) {
                const rect = this.getBoundingClientRect();
                const offset = e.clientY - rect.top;
                if (offset > rect.height / 2) {
                    this.classList.add('drag-over');
                } else {
                    this.classList.remove('drag-over');
                }
            }
        }

        function handleDrop(e) {
            e.preventDefault();

            const draggedId = e.dataTransfer.getData('text/plain');
            const draggedItem = document.querySelector(`[data-id='${draggedId}']`);

            if (draggedItem && draggedItem !== this) {
                const rect = this.getBoundingClientRect();
                const offset = e.clientY - rect.top;
                const newIndex = offset > rect.height / 2 ? 1 : 0;

                // Retirer la classe 'dragging' de l'élément
                draggedItem.classList.remove('dragging');

                // Insérer l'élément au bon endroit
                if (newIndex === 1) {
                    this.parentNode.insertBefore(draggedItem, this.nextSibling);
                } else {
                    this.parentNode.insertBefore(draggedItem, this);
                }

                // Mettre à jour le contenu du menu
                updateMenuContentInput();
            }

            // Retirer la classe 'drag-over' de l'élément courant
            this.classList.remove('drag-over');
        }


        // Fonction pour mettre à jour le contenu de l'input caché avec la structure du menu
        function updateMenuContentInput() {
            const menuItems = buildMenuTree(dropFrame);
            menuContentInput.value = JSON.stringify(menuItems);
        }
    }

    const controllingField = document.querySelector('[name="position"]');
    if (controllingField){

        controllingField.addEventListener('change', () => {
        const selectedValue = controllingField.value.toLowerCase(); 
            console.log(selectedValue);
            if (selectedValue === 'horizontal') {
                const horizontalAlignmentField = document.querySelector('[name="horizontal-alignement"]');
                if (horizontalAlignmentField) {
                horizontalAlignmentField.style.display = 'block';
                console.log(horizontalAlignmentField);
                }
            } else if (selectedValue === 'vertical' || selectedValue === 'burger') {
                const verticalAlignmentField = document.querySelector('[name="vertical-alignement"]');
                if (verticalAlignmentField) {
                verticalAlignmentField.style.display = 'block';
                console.log(verticalAlignmentField);
                }
            }

        });
    }
});
