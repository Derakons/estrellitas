<!-- Modal para agregar una categoría -->
<div class="modal fade" id="agregarCategoriaModal" tabindex="-1" aria-labelledby="agregarCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarCategoriaModalLabel">Agregar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="admin.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombreCategoria" class="form-label">Nombre de la Categoría:</label>
                        <input type="text" class="form-control" id="nombreCategoria" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagenCategoria" class="form-label">Imagen:</label>
                        <input type="file" class="form-control" id="imagenCategoria" name="imagen">
                    </div>
                    <button type="submit" name="agregar_categoria" class="btn btn-primary">Agregar Categoría</button>
                </form>
            </div>
        </div>
    </div>
</div>