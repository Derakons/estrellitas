<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css"> 
    <title>AstroShop - Pie de página</title>
</head>
<body>

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-3">AstroShop</h5>
                <p class="text-muted">Descubre el universo de la astrología con AstroShop, tu tienda online de productos y servicios relacionados con los signos zodiacales. ¡Explora nuestra colección y encuentra el regalo perfecto para ti o para alguien especial!</p>
                <a href="#" class="btn btn-outline-light btn-sm">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="#" class="btn btn-outline-light btn-sm">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
                <a href="#" class="btn btn-outline-light btn-sm">
                    <i class="fab fa-instagram"></i> Instagram
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-3">Información</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted">Quiénes somos</a></li>
                    <li><a href="#" class="text-muted">Política de privacidad</a></li>
                    <li><a href="#" class="text-muted">Términos y condiciones</a></li>
                    <li><a href="#" class="text-muted">Ayuda</a></li>
                    <li><a href="#" class="text-muted">Contacto</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase mb-3">Suscríbete a nuestro boletín</h5>
                <p class="text-muted">Recibe ofertas especiales, noticias y consejos astrológicos directamente en tu bandeja de entrada.</p>
                <form class="form-inline" action="suscribir.php" method="POST">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Tu correo electrónico" name="email" required>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-light">Suscribirme</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="text-center py-3">
        <p class="text-muted mb-0">© <?php echo date("Y"); ?> AstroShop. Todos los derechos reservados.</p>
        <p class="text-muted mb-0">Diseñado y desarrollado por [Tu nombre o empresa].</p>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>