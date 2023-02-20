<a href="<?= HREF_ROOT . "admin/tags"?>">⬅ Back to panel</a>

<h1><?= $params['tag']->name ?? 'Créer un nouveau tag' ?></h1>

<form method="POST" name="postlink" action="<?= isset($params['tag']) ? HREF_ROOT."admin/tags/edit/{$params['tag']->id}"  :  HREF_ROOT."admin/tags/create" ?>" >
    <div class="form-element">
        <label for="name">Nom du tag</label>
        <input type="text" required="required" class="form-input" name="name" id="name" value="<?= $params['tag']->name ?? '' ?>">
    </div>
    <button type="submit" class="btn-form"><?= isset($params['tag']) ? "Enregistrer les modifications" : "Enregistrer mon tag" ?></button>
</form>


<script language=javascript>
function submitPostLink()
{    
    document.postlink.submit();
}
</script>