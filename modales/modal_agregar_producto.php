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
                    <form method="post" action="admin.php" enctype="multipart/form-data" class="custom-form-horizontal">
                        <div class="row mb-3">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="descripcion" class="col-sm-2 col-form-label">Descripción:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="precio" class="col-sm-2 col-form-label">Precio (€):</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                            </div>
                            <label for="imagen" class="col-sm-2 col-form-label">Imagen:</label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="categoria_id" class="col-sm-2 col-form-label">Categoría:</label>
                            <div class="col-md-9">
                                <select class="form-select" id="categoria_id" name="categoria_id" required>
                                    <option value="">Selecciona una categoría</option>
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

                                    foreach ($categorias as $categoria) : ?>
                                        <option value="<?= $categoria['id']; ?>"><?= $categoria['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>>
                            <label for="signos_compatibles" class="col-sm-2 col-form-label">Signos Compatibles:</label>
                            <div class="col-sm-4">
    <select class="form-select" id="signos_compatibles" name="signos_compatibles[]" multiple size="3">
        <?php 
        $signos = ["Aries", "Tauro", "Géminis", "Cáncer", "Leo", "Virgo", "Libra", "Escorpio", "Sagitario", "Capricornio", "Acuario", "Piscis"];
        foreach ($signos as $signo) : 
        ?>
        <option value="<?= $signo; ?>"><?= $signo; ?></option>
        <?php endforeach; ?>
    </select>
</div>

                        </div>
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
