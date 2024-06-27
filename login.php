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

        .transparent-bg {
            background-color: rgba(0, 0, 0, 0.5); /* Color negro semi-transparente */
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .custom-image {
            max-width: 100%;
            width: 400px;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            color: #ffffff;
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid #ffffff;
        }

        .btn-custom {
            background-color: #ff6f61;
            border-color: #ff6f61;
            color: #ffffff;
        }

        .btn-custom:hover {
            background-color: #ff8a74;
            border-color: #ff8a74;
        }

        .text-white {
            color: #ffffff !important;
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
    session_start();

    if (isset($_SESSION['usuario_id'])) {
        echo '<div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">¡Bienvenido, ' . htmlspecialchars($_SESSION['usuario_nombre']) . '!</h2>
                                <p class="card-text">Ya has iniciado sesión. <a href="logout.php">Cerrar sesión</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        exit;
    }

    require_once 'includes/database.php';
    require_once 'includes/funciones.php';

    $error = ""; 

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = limpiarInput($_POST['email']);
        $contrasena = limpiarInput($_POST['contrasena']);

        if (empty($email) || empty($contrasena)) {
            $error = "Por favor, completa todos los campos.";
        } else {
            $sql = "SELECT * FROM usuarios WHERE email = ?";
            $resultado = ejecutarConsulta($sql, "s", $email);

            if ($resultado && $resultado->num_rows > 0) {
                $usuario = $resultado->fetch_assoc();

                if (verificarContrasena($contrasena, $usuario['contrasena'])) {
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Contraseña incorrecta.";
                }
            } else {
                $error = "El correo electrónico no está registrado.";
            }
        }
    }
    ?>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <img src="img/1.jpg" class="img-fluid custom-image" alt="Imagen de fondo">
            </div>
            <div class="col-md-6">
                <div class="transparent-bg">
                    <h2 class="text-center text-white mb-4">Iniciar Sesión</h2>

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
                        <button type="submit" class="btn btn-custom btn-block">Iniciar Sesión</button>
                    </form>

                    <div class="forgot-password mt-3 text-center">
                        <a href="#" class="text-white">¿Olvidaste tu contraseña?</a>
                    </div>

                    <div class="text-white mt-3">
                        <p>¿Aún no tienes una cuenta? <a href="registro.php" class="text-warning">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script> 
</body>

</html>
