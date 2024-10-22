<?php
    // Asumiendo que $categorias es un array asociativo con la información de la base de datos
    $categorias = [
        1 => ['id' => 1, 'nombre' => 'Ropa'],
        2 => ['id' => 2, 'nombre' => 'Adornos'],
        3 => ['id' => 3, 'nombre' => 'Libros'],
        4 => ['id' => 4, 'nombre' => 'Cristales'],
        5 => ['id' => 5, 'nombre' => 'Inciensos'],
        6 => ['id' => 6, 'nombre' => 'Cartas del Tarot'],
        7 => ['id' => 7, 'nombre' => 'Runas'],
        8 => ['id' => 8, 'nombre' => 'Aceites Esenciales'],
        9 => ['id' => 9, 'nombre' => 'Joyería'],
        10 => ['id' => 10, 'nombre' => 'Decoración']
    ];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Mejorado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Modal para agregar un producto -->
<div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="agregarProductoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarProductoModalLabel">Agregar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="admin.php" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label for="precio" class="form-label">Precio (S/.):</label>
                        <div class="input-group">
                            <span class="input-group-text">S/.</span>
                            <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)">
                        <img id="preview" src="#" alt="Vista previa de la imagen" class="mt-2 img-thumbnail" style="max-width: 100%; max-height: 200px; display: none;">
                    </div>
                    <script>
                        function previewImage(event) {
                            var input = event.target;
                            var preview = document.getElementById('preview');
                            preview.style.display = 'block';

                            var reader = new FileReader();
                            reader.onload = function() {
                                preview.src = reader.result;
                            };

                            reader.readAsDataURL(input.files[0]);
                        }
                    </script>
                    <div class="col-md-6">
                        <label for="categoria_id" class="form-label">Categoría:</label>
                        <select class="form-select" id="categoria_id" name="categoria_id" required>
                            <option value="">Selecciona una categoría</option>
                            <?php foreach ($categorias as $categoria) { ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php include 'signos_compatibles.php'; ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="agregar_producto" class="btn btn-primary">Agregar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
