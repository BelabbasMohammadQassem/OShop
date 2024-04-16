<div class="container my-4">
    <a href="categories.html" class="btn btn-success float-right">Retour</a>
    <h2>Ajouter un utilisateur</h2>
    
    <form action="<?= $router->generate('user-add') ?>" method="POST" class="mt-5">
        <div class="form-group">
            <label for="email">email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Votre email">
        </div>
        <div class="form-group">
            <label for="pass">Password</label>
            <input type="password" class="form-control" id="pass" name="password" placeholder="Votre mot de passe" aria-describedby="subtitleHelpBlock">
        </div>
        <div class="form-group">
            <label for="pass-confirm">Password confirm</label>
            <input type="password" class="form-control" id="pass-confirm" name="password-confirm" placeholder="Confirmez le mot de passe" aria-describedby="subtitleHelpBlock">
        </div>
        <div class="form-group">
            <label for="firstName">FirstName</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Prénom" aria-describedby="pictureHelpBlock">
        </div>

        <div class="form-group">
            <label for="lirstName">LastName</label>
            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Nom de famille" aria-describedby="pictureHelpBlock">
        </div>
        <input type="hidden" name="token" value="<?= $csrfToken ?>">
        <div class="form-group">
            <label for="role-select">Choisissez un role:</label>
            <select name="role" id="role-select">
                <option value="">--Votre role--</option>
                <option value="admin">Admin</option>
                <option value="catalog-manager">Catalog manager</option>
            </select>
        </div>

        <div class="form-group">
            <label for="role-select">Choisissez votre status:</label>
            <select name="status" id="status-select">
                <option value="">--Votre status--</option>
                <option value="1">Actif</option>
                <option value="2">Désactivé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary btn-block mt-5">Valider</button>
    </form>
</div>