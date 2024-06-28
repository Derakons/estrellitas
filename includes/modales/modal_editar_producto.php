<!-- Modal para editar un producto -->
<div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarProductoModalLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="admin.php" enctype="multipart/form-data">
                    <input type="hidden" name="producto_id" id="editarProductoId">
                    <div class="mb-3">
                        <label for="editarNombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="editarNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarDescripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="editarDescripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editarPrecio" class="form-label">Precio (€):</label>
                        <input type="number" class="form-control" id="editarPrecio" name="precio" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarImagen" class="form-label">Imagen Actual:</label>
                        <img src="" id="imagenActual" alt="Imagen actual del producto" style="max-width: 200px;"> 
                        <br><br>
                        <label for="editarImagen" class="form-label">Nueva Imagen:</label>
                        <input type="file" class="form-control" id="editarImagen" name="imagen">
                    </div>
                    <div class="mb-3">
                        <label for="editarCategoriaId" class="form-label">Categoría:</label>
                        <select class="form-select" id="editarCategoriaId" name="categoria_id" required>
                            <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?= $categoria['id']; ?>"><?= $categoria['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editarSignosCompatibles" class="form-label">Signos Compatibles:</label>
                        <select class="form-select" id="editarSignosCompatibles" name="signos_compatibles[]" multiple>
                            <option value="Aries">Aries</option>
                            <option value="Tauro">Tauro</option>
                            <!-- Agrega el resto de los signos -->
                        </select>
                    </div>
                    <button type="submit" name="editar_producto" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // JavaScript para cargar los datos del producto en el modal
    $('#editarProductoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var productoId = button.data('producto-id');
        var nombre = button.data('producto-nombre');
        var descripcion = button.data('producto-descripcion');
        var precio = button.data('producto-precio');
        var imagen = button.data('producto-imagen'); 
        var categoriaId = button.data('producto-categoria-id');
        var signosCompatibles = button.data('producto-signos-compatibles').split(","); // Convertir a array

        var modal = $(this);
        modal.find('#editarProductoId').val(productoId);
        modal.find('#editarNombre').val(nombre);
        modal.find('#editarDescripcion').val(descripcion);
        modal.find('#editarPrecio').val(precio);
        modal.find('#imagenActual').attr('src', imagen); // Mostrar la imagen actual
        modal.find('#editarCategoriaId').val(categoriaId);

        // Seleccionar los signos compatibles en el select multiple
        $.each(signosCompatibles, function(index, signo) {
            modal.find('#editarSignosCompatibles option[value="' + signo.trim() + '"]').prop('selected', true);
        });
    });
</script>