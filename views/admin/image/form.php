<a href="<?= HREF_ROOT . "admin/images"?>">⬅ Back to panel</a>

<h1><?= $params['image']->name ?? 'Créer un nouvelle image' ?></h1>

<form method="POST" name="postlink" action="<?= isset($params['image']) ? HREF_ROOT."admin/images/edit/{$params['image']->id}"  :  "../../admin/images/create" ?>" >
    <div class="form-element">
        <label for="name">Nom de l'image</label>
        <input type="text" class="form-input" name="name" id="name" value="<?= $params['image']->name ?? '' ?>">
    </div>
    <div class="form-element">
        <label for="name">Texte alternatif de l'image</label>
        <input type="text" class="form-input" name="alt" id="alt" value="<?= $params['image']->alt ?? '' ?>">
    </div>
    <div class="form-element">
        <label for="name">Nom du fichier de l'image</label>
        <input type="text" class="form-input" name="filename" id="filename" value="<?= $params['image']->filename ?? '' ?>">
    </div>
    <button type="submit" class="btn-form"><?= isset($params['image']) ? "Enregistrer les modifications" : "Enregistrer mon tag" ?></button>
</form>
<script>
function submitPostLink()
{    
    document.postlink.submit();
}
</script>