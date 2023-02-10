<a href="<?= HREF_ROOT . "admin/images"?>">⬅ Back to panel</a>

<h1><?= $params['image']->name ?? 'Créer un nouvelle image' ?></h1>

<form method="POST" name="postlink" action="<?= isset($params['image']) ? HREF_ROOT."admin/images/edit/{$params['image']->id}"  :  HREF_ROOT."admin/images/create" ?>" >
    <div class="form-element">
        <label for="name">Nom de l'image</label>
        <input type="text" class="form-input" name="name" id="name" value="<?= $params['image']->name ?? '' ?>">
    </div>
    <div class="form-element">
        <label for="name">Texte alternatif de l'image</label>
        <input type="text" class="form-input" name="alt" id="alt" value="<?= $params['image']->alt ?? '' ?>">
    </div>
    <div class="form-element">
        <label for="name">Image</label>
        <div class="form-input">
            <?php if (isset($params['image'])) { ?>
                <div class="img-content">
                    <img src="<?= SCRIPTS . "images/" . $params['image']->filename  ?>">
                    <p class="uploaded-filename"><?= $params['image']->filename ?></p>
                    <span class="trash">
                        Delete
                    </span>
                </div>
            <?php } else { ?>
                <p>No image uploaded</p>
            <?php }; ?>
            <input style="display: none;" type="text" name="filename" id="filename" value="">
        </div>
        <?php if (!isset($params['image']->filename)): ?>
            <span class="btn btn-file">
                <img src="<?= SCRIPTS . "content/icons8-plus-96.svg" ?>">
                <input type="file" class="img-add">
            </span>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn-form"><?= isset($params['image']) ? "Enregistrer les modifications" : "Enregistrer mon image" ?></button>
</form>
<script>
function submitPostLink()
{    
    document.postlink.submit();
}
</script>