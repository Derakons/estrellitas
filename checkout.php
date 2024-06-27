<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 700px;
            margin: 50px auto;
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
        .text-muted {
            color: #6c757d;
        }
        .form-group label {
            font-weight: bold;
        }
        .table {
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #ced4da;
        }
        .table th,
        .table td {
            border: 1px solid #ced4da;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
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
    $usuario = obtenerUsuario($_SESSION['usuario_id']);

    // Obtener información del carrito
    $carrito = $_SESSION['carrito'];
    $total = calcularTotalCarrito($carrito);

    // Procesar el envío del formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener datos del formulario
        $nombre = limpiarInput($_POST['nombre']);
        $apellidos = limpiarInput($_POST['apellidos']);
        $email = limpiarInput($_POST['email']);
        $telefono = limpiarInput($_POST['telefono']);
        $direccion = limpiarInput($_POST['direccion']);
        $ciudad = limpiarInput($_POST['ciudad']);
        $codigo_postal = limpiarInput($_POST['codigo_postal']);
        $metodo_pago = limpiarInput($_POST['metodo_pago']);

        // Validaciones
        if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) || empty($direccion) || empty($ciudad) || empty($codigo_postal) || empty($metodo_pago)) {
            $error = "Por favor, llena todos los campos.";
        } else {
            // Crear el pedido
            $pedido_id = generarPedido($usuario['id'], $total, $carrito, $nombre, $apellidos, $email, $telefono, $direccion, $ciudad, $codigo_postal, $metodo_pago);

            if ($pedido_id) {
                // Redireccionar a la página de confirmación
                header("Location: confirmar.php?id=$pedido_id");
                exit;
            } else {
                $error = "Hubo un error al realizar el pedido. Inténtalo de nuevo.";
            }
        }
    }

    // Función para generar un nuevo pedido
    function generarPedido($usuario_id, $total, $carrito, $nombre, $apellidos, $email, $telefono, $direccion, $ciudad, $codigo_postal, $metodo_pago) {
        global $conn;
    
        // Insertar el pedido
        $sql_pedido = "INSERT INTO pedidos (usuario_id, total, estado, nombre, apellidos, email, telefono, direccion, ciudad, codigo_postal, metodo_pago) VALUES (?, ?, 'Pendiente', ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_pedido = $conn->prepare($sql_pedido);
        $stmt_pedido->bind_param("idssssssss", $usuario_id, $total, $nombre, $apellidos, $email, $telefono, $direccion, $ciudad, $codigo_postal, $metodo_pago);
        $stmt_pedido->execute();
    
        // Obtener el ID del nuevo pedido
        $pedido_id = $conn->insert_id;
    
        // Insertar los productos del pedido
        foreach ($carrito as $item) {
            $producto_id = $item['id'];
            $cantidad = $item['cantidad'];
    
            $sql_detalle_pedido = "INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)";
            $stmt_detalle_pedido = $conn->prepare($sql_detalle_pedido);
            $stmt_detalle_pedido->bind_param("iii", $pedido_id, $producto_id, $cantidad);
            $stmt_detalle_pedido->execute();
        }
    
        return $pedido_id;
    }
    ?>

    <?php include 'navbar.php'; ?>

    <main class="container">
        <h2 class="text-center mb-4">Pago</h2>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="checkout.php">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="telefono">Teléfono:</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="ciudad">Ciudad:</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="codigo_postal">Código Postal:</label>
                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="metodo_pago">Método de Pago:</label>
                        <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                            <option value="Tarjeta">Tarjeta de Crédito/Débito</option>
                            <option value="Paypal">Paypal</option>
                            <option value="Transferencia">Transferencia Bancaria</option>
                        </select>
                    </div>
                </div>
            </div>

            <h3 class="mb-3">Resumen del Pedido</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $item) : ?>
                        <?php $producto = obtenerDetallesProducto($item['id']); ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo number_format($producto['precio'], 2); ?>€</td>
                            <td><?php echo $item['cantidad']; ?></td>
                            <td><?php echo number_format($producto['precio'] * $item['cantidad'], 2); ?>€</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td><strong><?php echo number_format($total, 2); ?>€</strong></td>
                    </tr>
                </tfoot>
            </table>

            <button type="submit" class="btn btn-primary btn-block">Confirmar Pedido</button>
        </form>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>