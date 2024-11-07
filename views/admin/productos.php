<div class="row">
    <div class="col-lg-10">
        <h1>Ingreso de productos</h1>
    </div>
    <div class="col-lg-1 d-flex align-items-center">
        <a href="/productos" class="btn btn-outline-success w-100"><i class="bi bi-eye"></i></a>
    </div>
    <div class="col-lg-1 d-flex align-items-center">
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalProducto"><i
                class="bi bi-plus-circle"></i></button>
    </div>
</div>

<div class="row">
    <div class="col table-responsive">
        <table id="datatableProductos" class="table table-hover table-stripped table-bordered">
        </table>

    </div>
</div>
<div class="modal fade" id="modalProducto" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleIdProducto">
                    Crear producto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formProducto" class="modal-body needs-validation" novalidate>
                <!-- Nombre del producto -->
                <input type="hidden" name="pro_id" id="pro_id">
                <div class="mb-3">
                    <label for="pro_nombre" class="form-label">Nombre del producto</label>
                    <input type="text" class="form-control" id="pro_nombre" name="pro_nombre" required>
                    <div class="invalid-feedback">
                        Por favor, ingresa el nombre del producto.
                    </div>
                </div>

                <!-- Descripción del producto -->
                <div class="mb-3">
                    <label for="pro_descripcion" class="form-label">Descripción del producto</label>
                    <textarea class="form-control" id="pro_descripcion" name="pro_descripcion" rows="3"
                        required></textarea>
                    <div class="invalid-feedback">
                        Por favor, ingresa una descripción del producto.
                    </div>
                </div>

                <!-- Precio -->
                <div class="mb-3">
                    <label for="pro_precio" class="form-label">Precio</label>
                    <input type="number" class="form-control" id="pro_precio" name="pro_precio" min="0" step="0.01"
                        required>
                    <div class="invalid-feedback">
                        Por favor, ingresa un precio válido.
                    </div>
                </div>

                <!-- Categoría -->
                <div class="mb-3">
                    <label for="pro_cat_id" class="form-label">Categoría</label>
                    <select class="form-select" id="pro_cat_id" name="pro_cat_id" required>
                        <option value="" selected disabled>Selecciona una categoría</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria->cat_id ?>"><?= $categoria->cat_nombre ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Por favor, selecciona una categoría.
                    </div>
                </div>

                <!-- Tallas -->
                <div class="mb-3">
                    <label for="prod_tallas" class="form-label">Tallas disponibles</label>
                    <select multiple class="form-select" id="prod_tallas" name="prod_tallas[]">
                        <?php foreach ($tallas as $talla): ?>
                            <option value="<?= $talla->tal_id ?>"><?= $talla->tal_nombre ?></option>
                        <?php endforeach ?>
                    </select>
                    <div class="invalid-feedback">
                        Por favor, selecciona al menos una talla.
                    </div>
                </div>

                <!-- Imagen del producto -->
                <div class="mb-3">
                    <label for="prod_imagen" class="form-label">Imagen del producto</label>
                    <input multiple type="file" class="form-control" id="prod_imagen" name="prod_imagen[]"
                        accept="image/*" required>
                    <div class="invalid-feedback">
                        Por favor, sube una imagen del producto.
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">
                    Cerrar
                </button>
                <button class="btn btn-primary" type="submit" form="formProducto" id="btnGuardar">Guardar<span
                        id="spanLoader" class="spinner-border spinner-border-sm ms-2"
                        aria-hidden="true"></span></button>
                <button class="btn btn-warning" type="button" id="btnModificar">Modificar<span id="spanLoaderModificar"
                        class="spinner-border spinner-border-sm ms-2" aria-hidden="true"></span></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImagenes" tabindex="-1" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImagenId">
                    Fotografias cargadas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="datatableImagenes" class="table table-hover text-center table-stripped table-bordered">
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('./build/js/admin/productos.js') ?>"></script>