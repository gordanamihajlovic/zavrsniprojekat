<?php
/**
 * Templejt za desni sidebar
 *
 * @var array $categories
 */
?>

<!-- box za pretragu recepata -->
<form class="form-inline bd-search" id="formSearch" action="/recipe/search" method="POST">
    <div class="card w-100">
        <div class="card-body p-3">
            <h5 class="card-title">Pretraga</h5>
            <input class="form-control ds-input w-100" type="search" id="search" name="search" placeholder="Unesite pojam" aria-label="Unesite pojam">
            <button class="btn btn-danger mt-3" type="submit">Traži</button>
        </div>
    </div>
</form>
