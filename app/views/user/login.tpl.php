<div class="container">
    <div id="login-row" class="row justify-content-center align-items-center">
    <?php
    // On inclut des sous-vues => "partials"
    include __DIR__.'/../partials/form_errors.tpl.php';
    ?>
        <div id="login-column" class="col-md-6">
            <div class="box">
                <div class="float">
                    <form class="form" action="<?= $router->generate('user-login-post'); ?>" method="post">
                        <div class="form-group">
                            <label for="username">E-mail:</label><br>
                            <input type="text" name="email" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe :</label><br>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-info btn-md" value="Connexion">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>