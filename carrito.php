<?php
session_start();
require_once 'includes/database.php';



// Manejar actualización de cantidades y eliminación de productos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actualizar'])) {
        // Actualizar cantidad
        $producto_id = (int)$_POST['producto_id'];
        $cantidad = max(1, (int)$_POST['cantidad']);
        
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id'] == $producto_id) {
                $item['cantidad'] = $cantidad;
                break;
            }
        }
    } elseif (isset($_POST['eliminar'])) {
        // Eliminar producto del carrito
        $producto_id = (int)$_POST['producto_id'];
        
        $_SESSION['carrito'] = array_filter($_SESSION['carrito'], function($item) use ($producto_id) {
            return $item['id'] !== $producto_id;
        });
    } elseif (isset($_POST['vaciar'])) {
        // Vaciar carrito
        $_SESSION['carrito'] = [];
    }
}

// Obtener detalles de productos para mostrar en el carrito
$productos = [];
if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) {
    $ids = array_map(function($item) { return $item['id']; }, $_SESSION['carrito']);
    $ids_placeholder = implode(',', array_fill(0, count($ids), '?'));
    
    $sql = "SELECT * FROM productos WHERE id IN ($ids_placeholder)";
    $tipos = str_repeat('i', count($ids));
    $resultado_productos = ejecutarConsulta($sql, $tipos, ...$ids);
    
    while ($row = $resultado_productos->fetch_assoc()) {
        $productos[$row['id']] = $row;
    }
}

// Calcular total del carrito
$total_carrito = 0;
foreach ($_SESSION['carrito'] as $item) {
    if (isset($productos[$item['id']])) {
        $total_carrito += $productos[$item['id']]['precio'] * $item['cantidad'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .product-image {
            width: 100px;
            height: auto;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <main class="container my-5">
        <h1 class="display-4 text-center mb-4">Carrito de Compras</h1>

        <?php if (empty($_SESSION['carrito'])) : ?>
            <div class="alert alert-warning text-center" role="alert">
                Tu carrito está vacío. <a href="productos.php" class="alert-link">Continúa comprando</a>.
            </div>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['carrito'] as $item) : ?>
                            <?php if (isset($productos[$item['id']])) : ?>
                                <?php $producto = $productos[$item['id']]; ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="product-image" width="200" height="200">
                                        <?php echo htmlspecialchars($producto['nombre']); ?>
                                    </td>
                                    <td><?php echo number_format($producto['precio'], 2); ?>€</td>
                                    <td>
                                        <form method="post" class="d-flex">
                                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                            <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" class="form-control" style="width: 80px;">
                                            <button type="submit" name="actualizar" class="btn btn-primary ms-2"><i class="fa fa-refresh"></i></button>
                                        </form>
                                    </td>
                                    <td><?php echo number_format($producto['precio'] * $item['cantidad'], 2); ?>€</td>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                            <button type="submit" name="eliminar" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td colspan="2"><?php echo number_format($total_carrito, 2); ?>€</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-between">
                <form method="post">
                    <button type="submit" name="vaciar" class="btn btn-danger"><i class="fa fa-trash"></i> Vaciar Carrito</button>
                </form>
                <a href="checkout.php" class="btn btn-success"><i class="fa fa-credit-card"></i> Proceder al Pago</a>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
