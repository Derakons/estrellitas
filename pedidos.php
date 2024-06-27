<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Mis Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .orders-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 50px auto;
        }
        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .orders-header h2 {
            margin: 0;
            color: #343a40;
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
            text-transform: capitalize; 
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
        .empty-message {
            text-align: center;
            margin-top: 50px;
            font-style: italic;
            color: #6c757d;
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

    // Obtener el ID del usuario
    $usuario_id = $_SESSION['usuario_id'];

    // Obtener los pedidos del usuario
    $pedidos = obtenerPedidosUsuario($usuario_id);
    ?>

    <?php include 'navbar.php'; ?>

    <div class="orders-container">
        <div class="orders-header">
            <h2>Mis Pedidos</h2>
        </div>

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
            <p class="empty-message">Aún no has realizado ningún pedido.</p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>