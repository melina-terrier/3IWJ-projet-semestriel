document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn = document.getElementById('openMediaModal');
    const modal = document.getElementById('mediaModal');
    const closeBtn = document.querySelector('.close');
    const saveMediaBtn = document.getElementById('saveMedia');

    if (openModalBtn && saveMediaBtn && closeBtn && modal){
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

        const mediaUploadForm = modal.querySelector('form#media-form'); 
        console.log(mediaUploadForm);
        mediaUploadForm.addEventListener('submit', handleMediaUpload);

        function handleMediaUpload(event) {
            console.log('test');
            event.preventDefault();
            var formData = new FormData(this);

            // Envoi des données via AJAX
            $.ajax({
                url: '/Controllers/Media.php', // Utilisation d'un chemin relatif, ajustez selon votre structure de fichiers
                type: 'POST',
                data: formData,
                processData: false,  // Ne pas traiter les données
                contentType: false,  // Ne pas définir le type de contenu
                success: function(response) {
                    // Gérer la réponse du serveur si nécessaire
                    console.log('Réponse du serveur :', response);
                    // Par exemple, afficher un message de succès à l'utilisateur
                    alert('Données envoyées avec succès !');
                },
                error: function(xhr, status, error) {
                    // Gérer les erreurs d'envoi si nécessaire
                    console.error('Erreur lors de l\'envoi des données :', error);
                    // Afficher un message d'erreur à l'utilisateur
                    alert('Erreur lors de l\'envoi des données. Veuillez réessayer.');
                }
            });
        }
    }

});