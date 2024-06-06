<section>
        <img src="<?= !empty($userData['photo']) ? htmlspecialchars($userData['photo']) : '' ?>" alt="Image de profil">
        
        <div>
            <p class="subtitle"><?= htmlspecialchars($userData['firstname']) . ' ' . htmlspecialchars($userData['lastname']) ?></p>
            <p class="text"><strong>Email :</strong> <?= htmlspecialchars($userData['email']) ?></p>
            <p class="text"><strong>Status :</strong> <?php
                    $status = $userData['status'];

                    $statusText = "";
                    switch ($status) {
                        case -1:
                            $statusText = "Supprimé";
                            break;
                        case 0:
                            $statusText = "En attente";
                            break;
                        case 1:
                            $statusText = "Verifié";
                            break;
                        default:
                            $statusText = "Inconnu";
                    }
                    echo $statusText
            ?></p>
            <p class="text"><strong>Rôle :</strong> <?= htmlspecialchars($userData['role'] ?? 'Utilisateur') ?></p>
            <p class="text"><strong>Créé le :</strong> <?= date('d/m/Y à H:i', strtotime($userData['creation_date'])) ?></p>
            <p class="text"><strong>Dernière mise à jour :</strong> <?= $userData['modification_date'] ? date('d/m/Y à H:i', strtotime($userData['modification_date'])) : 'N/A' ?></p>
            <a href="/dashboard/edit-user?id=<?php echo $userData['id']; ?>">Modifier</a>
        </div>
</section>

