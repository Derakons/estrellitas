<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 50px auto;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-header h2 {
            margin-top: 15px;
            color: #343a40;
        }
        .profile-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .profile-detail {
            width: 48%;
            margin-bottom: 20px;
        }
        .profile-detail label {
            font-weight: bold;
        }
        .profile-detail p {
            margin-bottom: 0;
        }
        .btn-edit {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        .btn-edit:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        /* Estilos para la sección de pedidos */
        .orders-section {
            margin-top: 50px;
        }
        .order-table th {
            background-color: #f2f2f2;
        }
        .order-table td {
            vertical-align: middle;
        }
        .order-status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .order-status.pendiente {
            background-color: #ffc107;
            color: #fff;
        }
        .order-status.procesando {
            background-color: #17a2b8;
            color: #fff;
        }
        .order-status.enviado {
            background-color: #28a745;
            color: #fff;
        }
        .order-status.completado {
            background-color: #007bff;
            color: #fff;
        }
        .order-status.cancelado {
            background-color: #dc3545;
            color: #fff;
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
    require_once 'includes/database.php';
    require_once 'includes/funciones.php';

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: login.php");
        exit;
    }

    // Obtener información del usuario
    $usuario_id = $_SESSION['usuario_id'];
    $usuario = obtenerUsuario($usuario_id);

    // Manejar la actualización de la información del perfil
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar_perfil'])) {
        $nombre = limpiarInput($_POST['nombre']);
        $email = limpiarInput($_POST['email']);
        $contrasena = limpiarInput($_POST['contrasena']);
        $confirmar_contrasena = limpiarInput($_POST['confirmar_contrasena']);
        $signo_zodiacal = limpiarInput($_POST['signo_zodiacal']);
        $direccion_envio = limpiarInput($_POST['direccion_envio']);

        // Validaciones
        if (empty($nombre) || empty($email) || empty($signo_zodiacal) || empty($direccion_envio)) {
            $error = "Por favor, llena todos los campos obligatorios.";
        } elseif (!empty($contrasena) && $contrasena !== $confirmar_contrasena) {
            $error = "Las contraseñas no coinciden.";
        } elseif (!empty($email) && correoExiste($email) && $email !== $usuario['email']) {
            $error = "El correo electrónico ya está registrado.";
        } else {
            // Actualizar la información del usuario
            if (actualizarUsuario($usuario_id, $nombre, $email, !empty($contrasena) ? $contrasena : null, $signo_zodiacal, $direccion_envio)) {
                $mensaje_exito = "Tu perfil se ha actualizado correctamente.";
                // Actualizar la información del usuario en la sesión
                $_SESSION['usuario_nombre'] = $nombre;
                $usuario = obtenerUsuario($usuario_id); // Obtener la información actualizada
            } else {
                $error = "Hubo un error al actualizar tu perfil. Inténtalo de nuevo.";
            }
        }
    }

    // Obtener pedidos del usuario
    $pedidos = obtenerPedidosUsuario($usuario_id);
    ?>

    <?php include 'navbar.php'; ?>

    <div class="profile-container transparent-bg">
        <div class="profile-header">
            <img src="https://via.placeholder.com/150" alt="Imagen de perfil">
            <h2><?php echo $usuario['nombre']; ?></h2>
        </div>

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

        <form method="post" action="perfil.php">
            <div class="profile-details">
                <div class="profile-detail">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
                </div>
                <div class="profile-detail">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>
                </div>
                <div class="profile-detail">
                    <label for="contrasena">Nueva Contraseña:</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena">
                </div>
                <div class="profile-detail">
                    <label for="confirmar_contrasena">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena">
                </div>
                <div class="profile-detail">
                    <label for="signo_zodiacal">Signo Zodiacal:</label>
                    <select class="form-control" id="signo_zodiacal" name="signo_zodiacal" required>
                        <option value="">Selecciona tu signo</option>
                        <option value="Aries" <?php if ($usuario['signo_zodiacal'] === 'Aries') echo 'selected'; ?>>Aries</option>
                        <option value="Tauro" <?php if ($usuario['signo_zodiacal'] === 'Tauro') echo 'selected'; ?>>Tauro</option>
                        <option value="Géminis" <?php if ($usuario['signo_zodiacal'] === 'Géminis') echo 'selected'; ?>>Géminis</option>
                        <option value="Cáncer" <?php if ($usuario['signo_zodiacal'] === 'Cáncer') echo 'selected'; ?>>Cáncer</option>
                        <option value="Leo" <?php if ($usuario['signo_zodiacal'] === 'Leo') echo 'selected'; ?>>Leo</option>
                        <option value="Virgo" <?php if ($usuario['signo_zodiacal'] === 'Virgo') echo 'selected'; ?>>Virgo</option>
                        <option value="Libra" <?php if ($usuario['signo_zodiacal'] === 'Libra') echo 'selected'; ?>>Libra</option>
                        <option value="Escorpio" <?php if ($usuario['signo_zodiacal'] === 'Escorpio') echo 'selected'; ?>>Escorpio</option>
                        <option value="Sagitario" <?php if ($usuario['signo_zodiacal'] === 'Sagitario') echo 'selected'; ?>>Sagitario</option>
                        <option value="Capricornio" <?php if ($usuario['signo_zodiacal'] === 'Capricornio') echo 'selected'; ?>>Capricornio</option>
                        <option value="Acuario" <?php if ($usuario['signo_zodiacal'] === 'Acuario') echo 'selected'; ?>>Acuario</option>
                        <option value="Piscis" <?php if ($usuario['signo_zodiacal'] === 'Piscis') echo 'selected'; ?>>Piscis</option>
                    </select>
                </div>
                <div class="profile-detail">
                    <label for="direccion_envio">Dirección de Envío:</label>
                    <input type="text" class="form-control" id="direccion_envio" name="direccion_envio" value="<?php echo $usuario['direccion_envio']; ?>" required>
                </div>
            </div>

            <button type="submit" name="actualizar_perfil" class="btn-success btn-edit btn-block ">Actualizar Perfil</button>
        </form>

        <!-- Sección de pedidos -->
        <div class="orders-section">
            <h3>Mis Pedidos</h3>
            <?php if (count($pedidos) > 0) : ?>
                <table class="table order-table">
                    <thead>
                        <tr>
                            <th>Número de Pedido</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido) : ?>
                            <tr>
                                <td><?php echo $pedido['id']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($pedido['fecha_pedido_utc'])); ?></td>
                                <td><?php echo number_format($pedido['total'], 2); ?>€</td>
                                <td>
                                    <span class="order-status <?php echo strtolower($pedido['estado']); ?>">
                                        <?php echo $pedido['estado']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detalles_pedido.php?id=<?php echo $pedido['id']; ?>" class="btn btn-primary btn-sm">Ver Detalles</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>Aún no has realizado ningún pedido.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>