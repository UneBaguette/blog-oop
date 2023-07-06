<h1>Se connecter</h1>

<?php if (isset($_SESSION['errors'])): ?>

<?php foreach($_SESSION['errors'] as $errorsArray): ?>
    <?php foreach($errorsArray as $errors): ?>
        <div class="alert">
            <?php foreach($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
<?php endforeach; $_SESSION['errors'] = [] ?>

<?php endif; ?>

<?php if (isset($_GET['error'])): ?>

    <p class="wrong">Wrong username or password</p>

<?php endif; ?>

<form action="<?= HREF_ROOT ?>login" method="POST">
    <div class="form-element">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" required="required" class="form-input" name="username" id="username">
    </div>
    <div class="form-element">
        <label for="password">Mot de passe</label>
        <input type="password" required="required" class="form-input" name="password" id="password">
    </div>
    <button type="submit" class="btn-form">Se connecter</button>
</form>