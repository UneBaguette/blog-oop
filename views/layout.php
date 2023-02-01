
<!DOCTYPE html>
<html lang="fr">
<?php $currentPage = $_SERVER['REQUEST_URI']; ?>

<?php

$navbarAdminLink = [
    HREF_ROOT . "admin/posts" => "Posts",
    HREF_ROOT . "admin/tags" => "Tags"
];

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="<?= SCRIPTS . 'css/app.css' ?>">
    <link rel="stylesheet" href="<?= SCRIPTS . 'css/home.css' ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
    <?php if(str_contains($_SERVER['REQUEST_URI'], "admin")): ?>
        <nav class="navbar-admin">
            <ul>
                <?php foreach($navbarAdminLink as $link => $title): ?>
                    <li>
                        <a 
                            <?php 
                                if ($link === $_SERVER['REQUEST_URI']) {echo "class='current'";};
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
</body>

</html>
