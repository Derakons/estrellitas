<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">

    <style>
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
        .jumbotronS {
            background-color: transparent; /* Fondo transparente */
            color: #ffffff; /* Texto inicial en blanco */
            padding: 4rem 2rem; /* Ajuste de espaciado interno */
        }
        .transparent-bgs {
            background-color: rgba(52, 58, 64, 0.7); /* Color oscuro semi-transparente */
            padding: 2rem; /* Espaciado interno */
            border-radius: 30px; /* Bordes redondeados */
        }
        /* Estilo para el efecto neón */
        .neon-text {
            text-shadow:
                0 0 5px rgba(255, 255, 255, 0.5),
                0 0 10px rgba(255, 255, 255, 0.5),
                0 0 20px rgba(255, 255, 255, 0.5),
                0 0 40px #39ff14,
                0 0 80px #39ff14,
                0 0 90px #39ff14,
                0 0 100px #39ff14,
                0 0 150px #39ff14;
            transition: color 2s ease, text-shadow 2s ease;
        }
        .custom-image {
            max-width: 100%;
            height: auto;
            width: 400px;
            height: 400px;
            object-fit: cover;
        }
        h2.text-center.mb-4 {
            color: #ffffff; /* Color blanco */
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }
        label.form-label {
            color: #ffffff; /* Color blanco */
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
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
    <?php 
    session_start(); // Inicia la sesión al inicio de login.php

    // Redirecciona al usuario si ya ha iniciado sesión
    if (isset($_SESSION['usuario_id'])) {
        header("Location: index.php");
        exit; 
    }

    require_once 'includes/database.php';
    require_once 'includes/funciones.php';

    $error = ""; 

    // Procesar el formulario de inicio de sesión
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = limpiarInput($_POST['email']);
        $contrasena = limpiarInput($_POST['contrasena']);

        // Validación básica del formulario (puedes agregar más validaciones)
        if (empty($email) || empty($contrasena)) {
            $error = "Por favor, completa todos los campos.";
        } else {
            // Consulta para obtener el usuario por correo electrónico
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $resultado = ejecutarConsulta($sql, "s", $email);

            if ($resultado && $resultado->num_rows > 0) {
                $usuario = $resultado->fetch_assoc();

                // Verificar la contraseña
                if (verificarContrasena($contrasena, $usuario['contrasena'])) {
                    // Contraseña correcta, iniciar sesión
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    header("Location: index.php"); // Redireccionar a la página principal
                    exit;
                } else {
                    // Contraseña incorrecta
                    $error = "Contraseña incorrecta.";
                }
            } else {
                // El usuario no existe
                $error = "El correo electrónico no está registrado.";
            }
        }
    }
    ?>
<?php include 'navbar.php'; ?>
<div class="container mt-5 transparent-bgs" >
        <div class="row">
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <img src="img/1.jpg" class="img-fluid custom-image" alt="Imagen de fondo" >
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div class="login-container">
                    <h2 class="text-center mb-4">Iniciar Sesión</h2>

                    <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                        </div>
                        <button type="submit" class="btn btn-block bg-gradient-secondary">Iniciar Sesión</button>
                    </form>

                    <div class="forgot-password mt-3 text-center">
                        <a href="#">¿Olvidaste tu contraseña?</a>
                    </div>

                    <div class="text-warning">
                        <p>¿Aún no tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script> 
</body>

</html>