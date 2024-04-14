<div class="container my-4">
    <a href="<?= $this->router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
    <h2><?= is_null($product->getId()) ? "Ajouter un produit" : "Modifier le produit N°{$product->getId()}" ?></h2>
    
    <form action="" method="POST" class="mt-5">

        <?php
        // On inclut la sous-vue/partial form_errors.tpl.php
        include __DIR__ . '/../partials/form_errors.tpl.php';
        ?>

        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nom du produit" value="<?= $product->getName() ?>">
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea type="text" name="description" class="form-control" id="description"><?= $product->getDescription() ?></textarea>
        </div>

        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock"  value="<?= $product->getPicture() ?>">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="number" min="0" step=".01" name="price" class="form-control" id="price" placeholder="Prix" value="<?= $product->getPrice() ?>">
        </div>

        <div class="mb-3">
            <legend style="font-size: 1em">Note :</legend>

            <div>
                <input class="form-check-input" type="radio" name="rate" id="rate1" value="1" <?= ($product->getRate() == 1) ? "checked" : "" ?>/>
                <label class="form-check-label" for="rate1">1/5</label>
            </div>

            <div>
                <input class="form-check-input" type="radio" name="rate" id="rate2" value="2" <?= ($product->getRate() == 2) ? "checked" : "" ?>/>
                <label class="form-check-label" for="rate2">2/5</label>
            </div>

            <div>
                <input class="form-check-input" type="radio" name="rate" id="rate3" value="3" <?= ($product->getRate() == 3) ? "checked" : "" ?>/>
                <label class="form-check-label" for="rate3">3/5</label>
            </div>

            <div>
                <input class="form-check-input" type="radio" name="rate" id="rate4" value="4" <?= ($product->getRate() == 4) ? "checked" : "" ?>/>
                <label class="form-check-label" for="rate4">4/5</label>
            </div>

            <div>
                <input class="form-check-input" type="radio" name="rate" id="rate5" value="5" <?= ($product->getRate() == 5) ? "checked" : "" ?>/>
                <label class="form-check-label" for="rate5">5/5</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" name="status" id="status">
                <option value="0" <?= ($product->getStatus() == 0) ? "selected" : "" ?>>Non renseigné</option>
                <option value="1" <?= ($product->getStatus() == 1) ? "selected" : "" ?>>Disponible</option>
                <option value="2" <?= ($product->getStatus() == 2) ? "selected" : "" ?>>Indisponible</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="brand_id" class="form-label">Marque</label>
            <select class="form-select" name="brand_id" id="brand_id">
                <?php foreach($brands as $brand) : ?>
                    <option value="<?= $brand->getId() ?>" <?= ($product->getBrandId() == $brand->getId()) ? "selected" : "" ?>><?= $brand->getName() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Catégorie</label>
            <select class="form-select" name="category_id" id="category_id">
                <!-- <option value="1">Détente</option>
                <option value="2">Au travail</option> -->

                <!-- pas génial en dur, donc on boucle ! -->
                <?php foreach($categories as $category) : ?>
                    <option value="<?= $category->getId() ?>" <?= ($product->getCategoryId() == $category->getId()) ? "selected" : "" ?>><?= $category->getName() ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="type_id" class="form-label">Type de produit</label>
            <select class="form-select" name="type_id" id="type_id">
                <?php foreach($types as $type) : ?>
                    <option value="<?= $type->getId() ?>" <?= ($product->getTypeId() == $type->getId()) ? "selected" : "" ?>><?= $type->getName() ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>