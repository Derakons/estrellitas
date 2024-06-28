<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Horizontal Mejorado</title>
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
                    <form method="post" action="admin.php" enctype="multipart/form-data" class="custom-form-horizontal">
                        <div class="row g-3">
                            <div class="col-md-3 text-md-end">
                                <label for="nombre" class="form-label">Nombre:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-3 text-md-end">
                                <label for="descripcion" class="form-label">Descripción:</label>
                            </div>
                            <div class="col-md-9">
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="1"></textarea>
                            </div>
                            <div class="col-md-3 text-md-end">
                                <label for="precio" class="form-label">Precio (€):</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                            </div>
                            <div class="col-md-3 text-md-end">
                                <label for="imagen" class="form-label">Imagen:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                            <div class="col-md-3 text-md-end">
                                <label for="categoria_id" class="form-label">Categoría:</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-select" id="categoria_id" name="categoria_id" required>
                                    <option value="">Selecciona una categoría</option>
                                    <?php foreach ($categorias as $categoria) : ?>
                                        <option value="<?= $categoria['id']; ?>"><?= $categoria['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 text-md-end">
                                <label for="signos_compatibles" class="form-label">Signos Compatibles:</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-select" id="signos_compatibles" name="signos_compatibles[]" multiple size="3">
                                    <?php $signos = ["Aries", "Tauro", "Géminis", "Cáncer", "Leo", "Virgo", "Libra", "Escorpio", "Sagitario", "Capricornio", "Acuario", "Piscis"];
                                    foreach ($signos as $signo) : ?>
                                        <option value="<?= $signo; ?>"><?= $signo; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer mt-4">
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
