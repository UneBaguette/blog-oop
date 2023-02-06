<h1>S'enregistrer</h1>

<?php $registered_permitted = false; if (isset($_SESSION['errors'])):?>

<?php foreach($_SESSION['errors'] as $errorsArray): ?>
    <?php foreach($errorsArray as $errors): ?>
        <div class="alert">
            <?php foreach($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach ?>
        </div>
    <?php endforeach ?>
<?php endforeach ?>

<?php endif ?>

<?php if ($registered_permitted){ ?>

<form action="" method="POST">
    <div class="form-element">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" class="form-input" name="username" id="username">
    </div>
    <div class="form-element">
        <label for="password">Mot de passe</label>
        <input type="password" class="form-input" name="password" id="password">
    </div>
    <div class="form-element">
        <label for="passwordverify">Confirmez le mot de passe</label>
        <input type="password" class="form-input" name="passwordverify" id="passwordverify">
    </div>
    <button type="submit" class="btn-form">S'enregistrer</button>
</form>

<?php } else { ?>

<p style="user-select: none;text-align: center; display: flex; justify-content: center; align-items: center; padding: 40vh 0; font-weight: bold; font-size: 20px;"><span style="display: flex; align-items: center; justify-content:center;text-align: center;width: 40px; height: 40px; margin: 0 10px;animation: beat normal 1300ms infinite cubic-bezier(.6,-0.05,0,.97);">😥</span>L'inscription au site a été désactivé<span style="display: flex; align-items: center; justify-content:center;text-align: center;width: 40px; height: 40px; margin: 0 10px;animation: beat normal 1300ms infinite cubic-bezier(.6,-0.05,0,.97);">😥</span></p>

<?php } ?>
