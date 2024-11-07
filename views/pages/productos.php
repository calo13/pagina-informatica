<div class="container">
    <h1 class="text-center">Productos disponibles</h1>
    <?php if (isset($_SESSION['auth'])): ?>
        <div class="row justify-content-end mb-3">
            <div class="col-lg-3 d-flex align-items-center">
                <a href="/admin/productos" class="btn btn-outline-success w-100">Ir a ingreso de productos</a>
            </div>
        </div>
    <?php endif ?>
    <div class="row" style="min-height: 75vh;">
        <div class="border col-lg-3 px-0">
            <div class="list-group list-group-flush">
                <?php foreach ($categorias as $key => $categoria): ?>
                    <button type="button" data-categoria="<?= $categoria->cat_id ?>"
                        class="list-group-item list-group-item-action <?= $key == 0 ? 'active' : '' ?>" aria-current="true">
                        <?= $categoria->cat_nombre ?><span class="ms-3 spinner-border spinner-border-sm"
                            id="spinner<?= $categoria->cat_id ?>" style="display: none;"></span>
                    </button>
                <?php endforeach ?>

            </div>
        </div>
        <div class="border col-lg-9">
            <div class="row" id="divProductos">
            </div>
        </div>
    </div>

</div>
<script src="build/js/pages/productos.js"></script>