<a href="<?= HREF_ROOT . "admin/images"?>">⬅ Back to panel</a>

<h1><?= $params['image']->name ?? 'Créer une nouvelle image' ?></h1>

<form method="POST" name="postlink" enctype="multipart/form-data" action="<?= isset($params['image']) ? HREF_ROOT."admin/images/edit/{$params['image']->id}"  :  HREF_ROOT."admin/images/create" ?>" >
    <div class="form-element">
        <label for="name">Nom de l'image</label>
        <input required="required" type="text" class="form-input" name="name" id="name" value="<?= $params['image']->name ?? '' ?>">
    </div>
    <div class="form-element">
        <label for="name">Texte alternatif de l'image</label>
        <input required="required" type="text" class="form-input" name="alt" id="alt" value="<?= $params['image']->alt ?? '' ?>">
    </div>
    <div class="form-element">
        <label for="name">Image</label>
        <div class="form-input" id="img-container">
            <div class="img-content">
                <div class="img-infos">
                    <?php if (isset($params['image'])) { ?>
                            <img src="<?= ($params['path'] ?? SCRIPTS . "images/") . $params['image']->filename  ?>">
                            <p class="uploaded-filename" style="width: 100%; text-align:center;"><?= $params['image']->filename ?></p>
                            <button class="img-trash trash">
                                Delete
                            </button>
                    <?php } else { ?>
                        <p>No image uploaded</p>
                    <?php }; ?>
                </div>
                <input style="display: none;" type="text" name="filename" id="filename" value="<?= $params['image']->filename ?? '' ?>">
            </div>
        </div>
        <div>
            <label for="rename">Auto-rename file</label>
            <input type="checkbox" name="rename" id="rename" value="true">
        </div>
        <div>
            <label for="overwrite">Overwrite exisiting file</label>
            <input type="checkbox" name="overwrite" id="overwrite" value="true">
        </div>
        <span class="btn btn-file">
            <img src="<?= SCRIPTS . "content/icons8-plus-96.svg" ?>">
            <input name="file" id="file" type="file" class="img-add" accept="image/*">
        </span>
    </div>
    <button type="submit" class="btn-form"><?= isset($params['image']) ? "Enregistrer les modifications" : "Enregistrer mon image" ?></button>
</form>
<script>
function submitPostLink()
{    
    document.postlink.submit();
}
</script>
<?php if (!isset($params['image'])): ?>
    <script src="<?= SCRIPTS ?>js/load.js"></script>
<?php endif; ?>