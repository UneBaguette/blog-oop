<?php

$adminPage = str_contains($_SERVER['REQUEST_URI'], "admin") && ($_SESSION['auth'] ?? "") === 1;

$navbarLink = [
    "left" => array(
        HREF_ROOT => "Accueil", 
        HREF_ROOT . "posts" => "Les derniers articles"
    ),
    "right" => array(
        HREF_ROOT . "login" => array("class" => "", "title" => "Se connecter"),
        HREF_ROOT . "register" => array("class" => "", "title" => "S'enregistrer"),
    )
];

if (isset($_SESSION['auth'])) {
    $authlink = array();
    if ($_SESSION['auth'] === 1 && (!$adminPage || (isset($_GET['onpage']) && $_GET['onpage']))) {
        $authlink = array(HREF_ROOT . "admin/posts" => array("class" => "", "title" => "Panneau Administrateur")) + $authlink;
    }
    $authlink += array(HREF_ROOT . "logout" => array("class" => "disconnect", "title" => "Se déconnecter"));
    $navbarLink['right'] = $authlink;
}

$navbarAdminLink = [
    HREF_ROOT . "admin/posts" => "Posts",
    HREF_ROOT . "admin/tags" => "Tags",
    HREF_ROOT . "admin/images" => "Images"
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
    <?php if ($adminPage): ?>
        <link rel="stylesheet" href="<?= SCRIPTS ?>css/panel.css">
        <script>

            const toggleOverlay = (title = "") => {
                const overlay = document.querySelector(".overlay-container");
                const popup = document.querySelector(".popup");

                if (!overlay.classList.contains("show")) {
                    //TODO: fix for admin
                    //document.querySelector(".popup-title").textContent = title.textContent;
                    overlay.classList.toggle("show");
                    setTimeout(() => {
                        overlay.classList.toggle("transition");
                        setTimeout(() => {
                            return popup.classList.toggle("show");
                        }, 50)
                    }, 100);
                }
                else {
                    popup.classList.toggle("show");
                    setTimeout(() => {
                        overlay.classList.toggle("transition");
                        setTimeout(() => {
                            return overlay.classList.toggle("show");
                        }, 100)
                    }, 100);
                }
            }

        </script>
    <?php endif; ?>
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
                    <?php foreach($navbarLink["right"] as $link => $el): ?>
                        <li class="navbar-item">
                            <a 
                            class="navbar-link <?= $el['class'] ?> <?php if (explode("/", $link)[1] === (explode("/", strtok($_SERVER["REQUEST_URI"], '?'))[1])) {echo "active";};?>" href="<?= $link ?>">
                                <?= $el['title'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
        <?php if($adminPage && !(bool)(filter_var(($_GET['onpage'] ?? false), FILTER_VALIDATE_BOOLEAN))): ?>
        <nav class="navbar-admin">
            <ul>
                <?php foreach($navbarAdminLink as $link => $title): ?>
                    <li>
                        <a 
                            <?php 
                                if (explode("/", $link)[2] === (explode("/", strtok($_SERVER["REQUEST_URI"], "?"))[2])) {echo "class='current'";};
                            ?> 
                            href=<?= $link ?>><?= $title ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php endif; ?>
    </header>
    <div class="container">
        <?= $content ?>
    </div>
    <?php if ($adminPage): ?>
        <div class="overlay-container">
            <div class="popup">
                <span></span>
                <h3>Supprimer "<span class="popup-title">...</span>" ?</h3>
                <p class="popup-text">Vous ne pourrez pas revenir en arrière.</p>
                <div class="actions-overlay">
                    <button class="btn" id="cancel">Annuler</button>
                    <button class="btn danger" id="confirm">Confirmer</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <footer>
        <span>Copyright &#169;	&#174;	&#8482; 2023</span>
        <!-- WIP -->
        <!-- <div class="theme">
            <button class="change-theme"></button>
        </div> -->
        <!-- WIP -->
    </footer>
    <script src="<?= SCRIPTS . 'js/app.js' ?>" ></script>
    <?php if ($adminPage): echo '<script src="'.SCRIPTS.'js/panel.js"></script>'; ?>
        <?php foreach($navbarAdminLink as $link => $title): ?>
            <?php if($_SERVER["REQUEST_URI"] === $link): ?>
                <script>

                    const edit = (e) => {
                        e.preventDefault();
                        window.location.href =  window.location.pathname + "/edit/" + e.target.dataset.id;
                    };

                    const del = (e) => {
                        e.preventDefault();
                        document.querySelector(".actions-overlay #confirm").setAttribute("data-id", e.target.dataset.id);
                        toggleOverlay(e.target.parentNode.parentNode.children[1]);
                    };

                </script>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>