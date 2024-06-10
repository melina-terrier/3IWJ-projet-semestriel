<h3>Modifier utilisateur</h3>
<section>
    <h4>Informations de l'utilisateur</h4>
    <?php $this->includeComponent("form", $configForm, $errorsForm, $successForm, "button button-primary");?>
</section>

<footer>
    <?php if (isset($userInfo)): ?>
        <p class="text"> Si vous voulez modifier le mot de passe de l'utilisateur, <a href="edit-password?id=<?= htmlspecialchars($userInfo['id']) ?>" >cliquez ici. </a></p>
    <?php endif; ?>
</footer>