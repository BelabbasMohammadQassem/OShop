<div class="container my-4">
    <a href="<?= $this->router->generate('user-update') ?>" class="btn btn-success float-end">Retour</a>
    <h2>Modifier la catégorie N°<?= $updateUsers->getId() ?></h2>
    
    <form action="" method="POST" class="mt-5">
        <div class="mb-3">
            <label for="name" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Nom de la catégorie" value="<?= $updateUsers->getEmail() ?>">
        </div>
        <div class="mb-3">
            <label for="subtitle" class="form-label">Mot de Passe</label>
            <input type="text" class="form-control" id="password" name="password" placeholder="Mot de Passe" aria-describedby="subtitleHelpBlock"  value="<?= $updateUsers->getPassword() ?>">
            <small id="subtitleHelpBlock" class="form-text text-muted">
                Sera affiché sur la page d'accueil comme bouton devant l'image
            </small>
        </div>
        <div class="mb-3">
            <label for="picture" class="form-label">firstname</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="firstname" aria-describedby="pictureHelpBlock" value="<?= $updateUsers->getFirstname() ?>">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>

        <div class="mb-3">
            <label for="picture" class="form-label">lastname</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="lastname" aria-describedby="pictureHelpBlock" value="<?= $updateUsers->getLastname() ?>">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>

        <div class="mb-3">
            <label for="picture" class="form-label">role</label>
            <input type="text" class="form-control" id="role" name="role" placeholder="role" aria-describedby="pictureHelpBlock" value="<?= $updateUsers->getRole() ?>">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>

        <div class="mb-3">
            <label for="picture" class="form-label">status</label>
            <input type="text" class="form-control" id="status" name="status" placeholder="status" aria-describedby="pictureHelpBlock" value="<?= $updateUsers->getStatus() ?>">
            <small id="pictureHelpBlock" class="form-text text-muted">
                URL relative d'une image (jpg, gif, svg ou png) fournie sur <a href="https://benoclock.github.io/S06-images/" target="_blank">cette page</a>
            </small>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>
    </form>
</div>