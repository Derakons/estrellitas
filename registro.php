<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Registro</title>
    
    <!-- Enlaces a archivos CSS -->
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
        .transparent-bg {
            background-color: rgba(255, 255, 255, 0.7); /* Fondo blanco con transparencia */
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
    </style>
</head>
<body>
<div class="video-background">
        <video autoplay muted loop>
            <source src="img/ra.mp4" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
    </div>
    <!-- Incluye la barra de navegación -->
    <?php include 'navbar.php'; ?> 
<br>
    <!-- Contenedor principal del contenido -->
    <main class="container transparent-bg"> 
        <div class="row"> 
            <!-- Columna izquierda: Imagen de fondo -->
            <div class="col-md-6">
    <center>
        <br>
        <svg width="500" height="500" viewBox="0 0 100 100">
            <defs>
                <clipPath id="rounded-corner">
                    <rect width="100" height="100" rx="15" ry="15"/>
                </clipPath>
            </defs>
            <image href="img/2.jpg" width="100" height="100" clip-path="url(#rounded-corner)" />
        </svg>
    </center>
</div>


            <!-- Columna derecha: Formulario de registro -->
            <div class="col-md-6">
                <h2 class="text-center mb-4">Registro</h2>

                <?php
                // Incluir archivos de conexión y funciones
                require_once 'includes/database.php';
                require_once 'includes/funciones.php';

                // Variables para almacenar mensajes de error y valores del formulario
                $error = ""; 
                $nombre = ""; 
                $email = ""; 

                // Procesar el formulario si se ha enviado
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Obtener los datos del formulario y limpiarlos
                    $nombre = limpiarInput($_POST['nombre']);
                    $email = limpiarInput($_POST['email']);
                    $contrasena = limpiarInput($_POST['contrasena']);
                    $confirmar_contrasena = limpiarInput($_POST['confirmar_contrasena']);
                    $signo_zodiacal = limpiarInput($_POST['signo_zodiacal']);

                    // Validaciones del formulario
                    if (empty($nombre) || empty($email) || empty($contrasena) || empty($confirmar_contrasena) || empty($signo_zodiacal)) {
                        $error = "Por favor, llena todos los campos.";
                    } elseif ($contrasena !== $confirmar_contrasena) {
                        $error = "Las contraseñas no coinciden.";
                    } elseif (correoExiste($email)) {
                        $error = "El correo electrónico ya está registrado.";
                    } else {
                        // Registrar el usuario en la base de datos
                        if (registrarUsuario($nombre, $email, $contrasena, $signo_zodiacal)) {
                            // Mensaje de éxito si el registro fue exitoso
                            $mensaje_exito = "¡Te has registrado correctamente! Ahora puedes iniciar sesión.";
                            // Resetear los valores del formulario
                            $nombre = "";
                            $email = "";
                            $contrasena = "";
                            $confirmar_contrasena = "";
                            $signo_zodiacal = "";
                        } else {
                            // Mensaje de error si el registro falló
                            $error = "Hubo un error al registrarte. Inténtalo de nuevo.";
                        }
                    }
                }
                ?>

                <!-- Mostrar mensajes de error o éxito -->
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($mensaje_exito)) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $mensaje_exito; ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario de registro -->
                <form method="post" action="registro.php">
                    <div class="form-group mb-3">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                        <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="signo_zodiacal">Signo Zodiacal:</label>
                        <select class="form-control" id="signo_zodiacal" name="signo_zodiacal" required>
                            <option value="">Selecciona tu signo</option>
                            <option value="Aries">Aries</option>
                            <option value="Tauro">Tauro</option>
                            <option value="Géminis">Géminis</option>
                            <option value="Cáncer">Cáncer</option>
                            <option value="Leo">Leo</option>
                            <option value="Virgo">Virgo</option>
                            <option value="Libra">Libra</option>
                            <option value="Escorpio">Escorpio</option>
                            <option value="Sagitario">Sagitario</option>
                            <option value="Capricornio">Capricornio</option>
                            <option value="Acuario">Acuario</option>
                            <option value="Piscis">Piscis</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                </form>

                <p class="text-muted text-center mt-3">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
            </div>
        </div>
    </main>

    <!-- Incluye el pie de página -->
    <?php include 'footer.php'; ?>

    <!-- Enlaces a archivos JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>