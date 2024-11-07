<div class="row border-bottom border-top py-3 mb-3 numbered-row">
    <div class="row-number">1</div>
    <div class="col-lg-2">
        <label for="explosivo_detalle_1">Descripción</label>
        <select name="explosivo[]" id="explosivo_detalle_1" class="form-select form-select-sm">
            <option value="">Seleccione...</option>
            <?php foreach ($materiales as $material) :  ?>
                <option value="<?= $material->mat_id ?>"><?= $material->mat_desc_lg ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="col-lg-2">
        <label for="peso_detalle_1">Peso</label>
        <div class="input-group input-group-sm d-flex">
            <input type="number" name="peso[]" id="peso_detalle_1" class="form-control form-control-sm">
            <select name="unidad[]" id="unidad_detalle_1" class="form-select">
                <option value="">--</option>
                <?php foreach ($unidades as $unidad) :  ?>
                    <option value="<?= $unidad->uni_id ?>"><?= $unidad->uni_descripcion . ' (' . $unidad->uni_abreviatura . ')' ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="col-lg-1">
        <label for="cantidad_detalle_1">Cantidad</label>
        <input type="number" name="cantidad[]" id="cantidad_detalle_1" class="form-control form-control-sm">
    </div>
    <div class="col-lg-2">
        <label for="pais_detalle_1">País de procedencia</label>
        <select name="pais[]" id="pais_detalle_1" class="form-select form-select-sm">
            <option value="">Seleccione...</option>
            <?php foreach ($paises as $pais) :  ?>
                <option value="<?= $pais->pai_id ?>"><?= $pais->pai_desc_lg ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="col-lg-2">
        <label for="empresa_detalle_1">Empresa</label>
        <input type="text" name="empresa[]" id="empresa_detalle_1" class="form-control form-control-sm"></input>
    </div>
    <div class="col-lg-2">
        <label for="lugar_detalle_1">Lugar de Alm.</label>
        <input type="text" name="lugar[]" id="lugar_detalle_1" class="form-control form-control-sm"></input>
    </div>
    <div class="col-lg-1">
        <label for="aduana_detalle_1">Aduana</label>
        <select name="aduana[]" id="aduana_detalle_1" class="form-select form-select-sm">
            <option value="">Seleccione...</option>
            <?php foreach ($puertos as $puerto) :  ?>
                <option value="<?= $puerto->pue_id ?>"><?= $puerto->pue_desc_lg ?></option>
            <?php endforeach ?>
        </select>
    </div>
</div>