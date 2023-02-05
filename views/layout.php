<?php

$currentPage = $_SERVER['REQUEST_URI'];

$navbarLink = [
    "left" => array(
        HREF_ROOT => "Accueil", 
        HREF_ROOT . "posts" => "Les derniers articles"
    ),
    "right" => array(
        HREF_ROOT . "login" => "Se connecter",
        HREF_ROOT . "register" => "S'enregistrer",
    )
];

if (isset($_SESSION['auth'])) {
    $authlink = array();
    if ($_SESSION['auth'] === 1 && (!str_contains($_SERVER['REQUEST_URI'], "admin") || (isset($_GET['onpage']) && $_GET['onpage']))) {
        $authlink = array(HREF_ROOT . "admin/posts" => "Panneau Administrateur") + $authlink;
    }
    $authlink += array(HREF_ROOT . "logout" => "Se déconnecter");
    $navbarLink['right'] = $authlink;
}

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
    <link rel="shortcut icon" type="image/png" href="<?= SCRIPTS . 'favicons/chat-message-office-16.png' ?>" sizes="16x16"/>
    <link rel="shortcut icon" type="image/png" href="<?= SCRIPTS . 'favicons/chat-message-office-32.png' ?>" sizes="32x32"/>
    <link rel="shortcut icon" type="image/png" href="<?= SCRIPTS . 'favicons/chat-message-office-96.png' ?>" sizes="96x96"/>
    <title>Blog</title>
    <link rel="stylesheet" href="<?= SCRIPTS . 'css/app.css' ?>">
    <link rel="stylesheet" href="<?= SCRIPTS . 'css/home.css' ?>">
</head>
<body>
    <noscript>
        <p style="position: fixed; width: 100%; height: 100%; top: 0; left: 0; background: #F2F2F2; z-index: 100; font-size: 1.6rem; text-align: center; display: flex; justify-content:center; align-items: center;" >Ce site a besoin de JavaScript pour fonctionner!</p>
    </noscript>
    <header>
        <nav class="navbar">
            <a class="navbar-title" href="<?= HREF_ROOT ?>">Blog</a>
            <div class="navbar-links">
                <ul class="navbar-list">
                    <?php foreach($navbarLink["left"] as $link => $title): ?>
                        <li class="navbar-item">
                            <a 
                            class="navbar-link <?php if (explode("/", $link)[1] === (explode("/", strtok($_SERVER["REQUEST_URI"], '?'))[1])) {echo "active";}; ?>" href="<?= $link ?>">
                                <?= $title ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="navbar-list">
                    <?php foreach($navbarLink["right"] as $link => $title): ?>
                        <li class="navbar-item">
                            <a 
                            class="navbar-link <?php if (explode("/", $link)[1] === (explode("/", strtok($_SERVER["REQUEST_URI"], '?'))[1])) {echo "active";}; ?>" href="<?= $link ?>">
                                <?= $title ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
    </header>
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
    <footer>
        <span>Copyright 2023</span>
        <div class="theme">
            <button><img src="<?= SCRIPTS . "content/sun-60.png" ?>" ></button>
        </div>
    </footer>
    <script src="<?= SCRIPTS . 'js/app.js' ?>" ></script>
</body>
</html>
