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
<label for="imagen" class="col-sm-2 col-form-label">Imagen:</label>
<div class="col-sm-4">
    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)">
    <br>
    <img id="preview" src="#" alt="Vista previa de la imagen" style="max-width: 100%; max-height: 200px;">
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

<div class="row mb-3">
    <label for="categoria_id" class="col-sm-2 col-form-label">Categoría:</label>
    <div class="col-md-9">
        <select class="form-select" id="categoria_id" name="categoria_id" required>
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categorias as $categoria) : ?>
                <option value="<?= $categoria['id']; ?>"><?= $categoria['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <label for="categoria_id" class="col-sm-2 col-form-label">Signos Compatibles:</label>
    <div class="col-md-9">
        <?php foreach ($signos as $signo) : ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="signo_<?= $signo; ?>" name="signos_compatibles[]" value="<?= $signo; ?>">
                <label class="form-check-label" for="signo_<?= $signo; ?>">
                    <?= $signo; ?>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
