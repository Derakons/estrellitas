<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Estilos para la página de contacto */
        body {
            background-color: #f8f9fa; /* Color de fondo suave */
        }

        .contact-form {
            border-radius: 10px; /* Bordes redondeados para el formulario */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra sutil */
            padding: 30px;
        }

        .contact-form h2 {
            color: #343a40; /* Color del título */
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            box-shadow: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .contact-info {
            margin-top: 30px;
            text-align: center;
        }

        .contact-info h4 {
            color: #343a40; /* Color del título de información de contacto */
            margin-bottom: 10px;
        }

        .contact-info ul {
            list-style: none;
            padding: 0;
        }

        .contact-info li {
            margin-bottom: 10px;
        }

        /* Estilos para el carrusel de categorías */
        #carouselCategorias .card-img-top {
            width: 300px;       /* Ancho fijo */
            height: 300px;      /* Alto fijo */
           object-fit: cover;   /* Ajusta la imagen para cubrir el área, manteniendo la relación de aspecto */
           margin: 0 auto;     /* Centra la imagen horizontalmente */
            }

        /* Estilos internos para el video de fondo */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        .video-background video {
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }
        .content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding: 50px;
        }
        /* Estilo para el encabezado con color blanco neon */
        .jumbotron {
            background-color: transparent; /* Fondo transparente */
            color: #ffffff; /* Texto inicial en blanco */
            padding: 4rem 2rem; /* Ajuste de espaciado interno */
        }
        .transparent-bg {
            background-color: rgba(255, 255, 255, 0.7); /* Fondo blanco con transparencia */
            padding: 2rem; /* Espaciado interno */
            border-radius: 30px; /* Bordes redondeados */
        }
    </style>
</head>
<body>
<div class="video-background">
        <video autoplay muted loop>
            <source src="img/ra.mp4" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
    </div>
    <?php include 'navbar.php'; ?>

    <div class="container my-5 transparent-bg">
        <h1 class="text-center mb-4">Contáctanos</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="contact-form">
                    <h2>Envíanos un Mensaje</h2>
                    <form method="post" action="enviar_contacto.php">
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="asunto">Asunto:</label>
                            <input type="text" class="form-control" id="asunto" name="asunto" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="mensaje">Mensaje:</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Enviar Mensaje</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-info">
                    <h4>Información de Contacto</h4>
                    <ul>
                        <li><strong>Dirección:</strong> AstroShop, Calle Astral 123, Ciudad Estelar</li>
                        <li><strong>Teléfono:</strong> +55 123 456 7890</li>
                        <li><strong>Email:</strong> info@astroshop.com</li>
                        <li><strong>Redes Sociales:</strong>
                            <a href="#" class="text-muted"><i class="fab fa-facebook-f"></i> Facebook</a>
                            <a href="#" class="text-muted"><i class="fab fa-twitter"></i> Twitter</a>
                            <a href="#" class="text-muted"><i class="fab fa-instagram"></i> Instagram</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>