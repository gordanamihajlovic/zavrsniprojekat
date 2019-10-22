<?php
/**
 * Forma za unos novog ili izmenu postojeceg recepta
 *
 * @var array  $recipe
 * @var array  $categoryOptions
 * @var string $formAction
 * @var array  $invalidFields
 * @var string $buttonLabel
 */
?>

<form id="recipeForm" method="post" enctype="multipart/form-data" action="<?php echo $formAction; ?>">
    <!-- input za naziv recepta -->
    <div class="form-group required">
        <label for="name">Naziv</label>
        <input
            type="text"
            class="form-control <?php if (in_array('name', $invalidFields)): ?>is-invalid<?php endif; ?>"
            id="name"
            name="name"
            placeholder="Unesite naziv recepta"
            value="<?php echo $recipe['name']; ?>"
        >
        <?php if (in_array('name', $invalidFields)): ?>
            <div class="invalid-feedback">
                Naziv recepta je obavezan.
            </div>
        <?php endif; ?>
    </div>

    <!-- select za kategoriju recepta -->
    <div class="form-group required">
        <label for="categories">Kategorija</label>
        <select class="form-control <?php if (in_array('category_id', $invalidFields)): ?>is-invalid<?php endif; ?>" id="category_id" name="category_id">
            <?php foreach ($categoryOptions as $option): ?>
            <option value="<?php echo $option['id']; ?>"<?php if ($recipe['category_id'] == $option['id']): ?> selected<?php endif; ?>><?php echo $option['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (in_array('category_id', $invalidFields)): ?>
            <div class="invalid-feedback">
                Izbor kategorije je obavezan.
            </div>
        <?php endif; ?>
    </div>

    <!-- file input za sliku recepta -->
    <div class="form-group">
        <div class="custom-file">
            <label class="custom-file-label" for="image">Slika recepta</label>
            <input type="file" class="custom-file-input" id="image" name="image">
        </div>
    </div>

    <div class="form-group required">
        <label for="description">Tekst recepta</label>
        <textarea
            class="form-control  <?php if (in_array('description', $invalidFields)): ?>is-invalid<?php endif; ?>"
            id="description"
            name="description"
            rows="10"
            placeholder="Unesite tekst recepta"
        ><?php echo $recipe['description']; ?></textarea>
        <?php if (in_array('description', $invalidFields)): ?>
            <div class="invalid-feedback">
                Opis recepta je obavezan.
            </div>
        <?php endif; ?>
    </div>

    <input type="hidden" name="id" id="id" value="<?php echo $recipe['id']; ?>" />

    <button type="submit" class="btn btn-danger"><?php echo $buttonLabel; ?></button>
</form>
