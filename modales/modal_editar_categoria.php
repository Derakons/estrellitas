<!-- Modal para editar una categoría -->
<div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="admin.php" enctype="multipart/form-data">
                    <input type="hidden" name="categoria_id" id="editarCategoriaId">
                    <div class="mb-3">
                        <label for="editarNombreCategoria" class="form-label">Nombre de la Categoría:</label>
                        <input type="text" class="form-control" id="editarNombreCategoria" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editarImagenCategoria" class="form-label">Imagen Actual:</label>
                        <img src="" id="imagenActualCategoria" alt="Imagen actual de la categoría" style="max-width: 200px;"> 
                        <br><br>
                        <label for="editarImagenCategoria" class="form-label">Nueva Imagen:</label>
                        <input type="file" class="form-control" id="editarImagenCategoria" name="imagen">
                    </div>
                    <button type="submit" name="editar_categoria" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // JavaScript para cargar los datos de la categoría en el modal
    $('#editarCategoriaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var categoriaId = button.data('categoria-id');
        var nombre = button.data('categoria-nombre');
        var imagen = button.data('categoria-imagen'); 

        var modal = $(this);
        modal.find('#editarCategoriaId').val(categoriaId);
        modal.find('#editarNombreCategoria').val(nombre);
        modal.find('#imagenActualCategoria').attr('src', imagen); // Mostrar la imagen actual
    });
</script>