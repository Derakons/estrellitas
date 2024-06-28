<!-- Modal para agregar un producto -->
<div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="agregarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarProductoModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="admin.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio (€):</label>
                        <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen">
                    </div>
                    <div class="mb-3">
                        <label for="categoria_id" class="form-label">Categoría:</label>
                        <select class="form-select" id="categoria_id" name="categoria_id" required>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?= $categoria['id']; ?>"><?= $categoria['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="signos_compatibles" class="form-label">Signos Compatibles:</label>
                        <select class="form-select" id="signos_compatibles" name="signos_compatibles[]" multiple>
                            <option value="Aries">Aries</option>
                            <option value="Tauro">Tauro</option>
                            <option value="Géminis">Géminis</option>
                            <option value="Cáncer">Cáncer</option>
                            <option value="Leo">Leo</option>
                            <option value="Virgo">Virgo</option>
                            <option value="Libra">Libra</option>
                            <option value="Escorpio">Escorpio</option>
                            <option value="Sagitario">Sagitario</option>
                            <option value="Capricornio">Capricornio</option>
                            <option value="Acuario">Acuario</option>
                            <option value="Piscis">Piscis</option>
                        </select>
                    </div>
                    <button type="submit" name="agregar_producto" class="btn btn-primary">Agregar Producto</button>
                </form>
            </div>
        </div>
    </div>
</div>