<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Horizontal Mejorado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .modal-dialog {
            max-width: 2000px; /* Ajusta según el tamaño necesario */
        }

        .modal-content {
            padding: 20px;
        }

        .form-horizontal {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 15px 20px;
            align-items: center;
        }

        .form-horizontal .form-label {
            justify-self: end;
            font-weight: 600;
        }

        .form-horizontal .form-control, 
        .form-horizontal .form-select, 
        .form-horizontal .form-control-file {
            width: 80%; /* Ajusta el ancho según sea necesario */
        }

        .modal-footer {
            text-align: right;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .modal-footer button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <!-- Modal para agregar un producto -->
    <div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="agregarProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarProductoModalLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="admin.php" enctype="multipart/form-data" class="form-horizontal">
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
                            <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoría:</label>
                            <select class="form-select" id="categoria_id" name="categoria_id" required>
                                <option value="">Selecciona una categoría</option> 
                                <?php foreach ($categorias as $categoria) : ?>
                                    <option value="<?= $categoria['id']; ?>"><?= $categoria['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="signos_compatibles" class="form-label">Signos Compatibles:</label>
                            <select class="form-select" id="signos_compatibles" name="signos_compatibles[]" multiple size="4">
                                <?php $signos = ["Aries", "Tauro", "Géminis", "Cáncer", "Leo", "Virgo", "Libra", "Escorpio", "Sagitario", "Capricornio", "Acuario", "Piscis"];
                                foreach ($signos as $signo) : ?>
                                    <option value="<?= $signo; ?>"><?= $signo; ?></option>
                                <?php endforeach; ?>
                            </select>
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
