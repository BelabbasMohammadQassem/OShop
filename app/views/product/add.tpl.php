<div class="container my-4">
    <a href="<?= $this->router->generate('product-list') ?>" class="btn btn-success float-end">Retour</a>
    <h2>Ajouter un produit</h2>
    
    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nom de la catégorie">
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea type="text" name="description" class="form-control" id="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="picture" class="form-label">Image</label>
            <input type="text" class="form-control" id="picture" name="picture" placeholder="image jpg, gif, svg, png" aria-describedby="pictureHelpBlock">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Prix</label>
            <input type="text" name="price" class="form-control" id="price" placeholder="Prix">
        </div>

        <div class="mb-3">
            <label for="rate" class="form-label">Rate</label>
            <input type="text" name="rate" class="form-control" id="rate" placeholder="Note du produit">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" name="status" class="form-control" id="status" aria-describedby="priceHelpBlock">
            <small id="priceHelpBlock" class="form-text text-muted">
                1 ou 2
            </small>
        </div>

        <div class="mb-3">
            <label for="brand_id" class="form-label">brand_id</label>
            <input type="number" name="brand_id" class="form-control" id="brand_id">
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">category_id</label>
            <input type="number" name="category_id" class="form-control" id="category_id">
        </div>
        <div class="mb-3">
            <label for="type_id" class="form-label">type_id</label>
            <input type="number" name="type_id" class="form-control" id="type_id">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>