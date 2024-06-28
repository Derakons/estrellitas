<?php 
$signos = ["Aries", "Tauro", "Géminis", "Cáncer", "Leo", "Virgo", "Libra", "Escorpio", "Sagitario", "Capricornio", "Acuario", "Piscis"];
?>
<div class="col-md-6">
    <label class="form-label">Signos Compatibles:</label>
    <div class="form-check">
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