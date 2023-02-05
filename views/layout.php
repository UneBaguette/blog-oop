<?php

$currentPage = $_SERVER['REQUEST_URI'];

$navbarAdminLink = [
    HREF_ROOT . "admin/posts" => "Posts",
    HREF_ROOT . "admin/tags" => "Tags"
];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="<?= SCRIPTS . 'css/app.css' ?>">
    <link rel="stylesheet" href="<?= SCRIPTS . 'css/home.css' ?>">
</head>
<body>
    <noscript>
        <p style="position: fixed; width: 100%; height: 100%; top: 0; left: 0; background: #F2F2F2; z-index: 100; font-size: 1.6rem; text-align: center; display: flex; justify-content:center; align-items: center;" >Ce site a besoin de JavaScript pour fonctionner!</p>
    </noscript>
    <nav class="navbar navbar-expand-lg navbar-light bg-light nav-big">
        <a class="navbar-brand" href=<?= HREF_ROOT ?>>Blog</a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= HREF_ROOT ?>">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= HREF_ROOT ?>posts">Les derniers articles</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['auth'])){ ?>
                    <?php if ($_SESSION['auth'] === 1 && (!str_contains($_SERVER['REQUEST_URI'], "admin") || (isset($_GET['onpage']) && $_GET['onpage']))): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= HREF_ROOT ?>admin/posts">Panneau Administrateur</a>
                        </li>
                    <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= HREF_ROOT ?>logout">Se déconnecter</a>
                </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= HREF_ROOT ?>login">Se connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= HREF_ROOT ?>register">S'enregistrer</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <?php if(str_contains($_SERVER['REQUEST_URI'], "admin") && !(bool)(filter_var(($_GET['onpage'] ?? false), FILTER_VALIDATE_BOOLEAN))): ?>
        <nav class="navbar-admin">
            <ul>
                <?php foreach($navbarAdminLink as $link => $title): ?>
                    <li>
                        <a 
                            <?php 
                                if (explode("/", $link)[2] === (explode("/", strtok($_SERVER["REQUEST_URI"], '?'))[2])) {echo "class='current'";};
                            ?> 
                            href=<?= $link ?>><?= $title ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php endif; ?>
    <div class="container">
        <?= $content ?>
    </div>
    <script src="<?= SCRIPTS . 'js/app.js' ?>" ></script>
</body>
</html>
