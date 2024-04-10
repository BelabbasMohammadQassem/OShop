<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= $router->generate('main-home') ?>">oShop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === "main/home") ? "active" : "" ?>" href="<?= $router->generate('main-home') ?>">Accueil <?= ($currentPage === "main/home") ? "<span class=\"sr-only\">(current)</span>" : "" ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === "category/list") ? "active" : "" ?>" href="<?= $router->generate('category-list') ?>">Catégories  <?= ($currentPage === "category/list") ? "<span class=\"sr-only\">(current)</span>" : "" ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === "product/list") ? "active" : "" ?>" href="<?= $router->generate('product-list') ?>">Produits  <?= ($currentPage === "product/list") ? "<span class=\"sr-only\">(current)</span>" : "" ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Types</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Marques</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tags</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sélection Accueil</a>
                </li>
            </ul>
        </div>
    </div>
</nav>