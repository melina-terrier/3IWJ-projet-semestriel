<section class="user-profile">
        <img src="<?= !empty($userData['img_path']) ? htmlspecialchars($userData['img_path']) : '/Views/styles/dist/images/profil.png' ?>" alt="Image de profil">
        <div class="user-info">
            <p class="subtitle"><?= htmlspecialchars($userData['firstname']) . ' ' . htmlspecialchars($userData['lastname']) ?></p>
            <p class="text"><strong>Email :</strong> <?= htmlspecialchars($userData['email']) ?></p>
            <p class="text"><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($userData['username']) ?></p>
            <p class="text"><strong>Status :</strong> <?= $userData['status'] === 0 ? 'Inactif' : 'Actif' ?></p>
            <p class="text"><strong>Rôle :</strong> <?= htmlspecialchars($userData['roles'] ?? 'Utilisateur') ?></p>
            <p class="text"><strong>Créé le :</strong> <?= date('d/m/Y à H:i', strtotime($userData['createdat'])) ?></p>
            <p class="text"><strong>Dernière mise à jour :</strong> <?= $userData['updatedat'] ? date('d/m/Y à H:i', strtotime($userData['updatedat'])) : 'N/A' ?></p>
            <p class="text"><strong>Actif :</strong> <?= $userData['is_active'] ? 'Oui' : 'Non' ?></p>
            <a href="/bo/user/edit-user?id=<?php echo $userData['id']; ?>"><button class="button button-primary">Modifier</button></a>
        </div>
</section>

