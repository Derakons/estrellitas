<?php
session_start();
require_once 'includes/database.php';
// Incluir el archivo de funciones
require_once 'includes/funciones.php';


// Obtener ID del producto desde la URL
$producto_id = isset($_GET['id']) ? (int)limpiarInput($_GET['id']) : null;

// Validar que el producto existe
if (!$producto_id) {
    header("Location: productos.php"); // Redireccionar a la página de productos si no hay ID de producto
    exit;
}

// Consulta para obtener el producto
$sql_producto = "SELECT p.*, c.nombre AS categoria_nombre 
                 FROM productos p 
                 JOIN categorias c ON p.categoria_id = c.id 
                 WHERE p.id = ?";
$resultado_producto = ejecutarConsulta($sql_producto, "i", $producto_id);
$producto = $resultado_producto->fetch_assoc();

if (!$producto) {
    header("Location: productos.php"); // Redireccionar si el producto no existe
    exit;
}

// Procesar el formulario para añadir al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_al_carrito'])) {
        $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

        // Preparar el item para añadir al carrito
        $item = [
            'id' => $producto_id,
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => $cantidad
        ];

        // Inicializar o actualizar el carrito en la sesión
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Verificar si el producto ya está en el carrito y actualizar la cantidad si es así
        $producto_en_carrito = false;
        foreach ($_SESSION['carrito'] as &$carrito_item) {
            if ($carrito_item['id'] === $producto_id) {
                $carrito_item['cantidad'] += $cantidad;
                $producto_en_carrito = true;
                break;
            }
        }

        // Si el producto no estaba en el carrito, añadirlo
        if (!$producto_en_carrito) {
            $_SESSION['carrito'][] = $item;
        }

        // Redireccionar a carrito.php después de añadir el producto
        header("Location: carrito.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - <?php echo htmlspecialchars($producto['nombre']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .breadcrumb-item.active {
            color: #6c757d;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="video-background">
        <video autoplay muted loop>
            <source src="img/ra.mp4" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
    </div>
    <main class="container my-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="productos.php">Productos</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($producto['nombre']); ?></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" class="product-image" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            </div>
            <div class="col-md-6" style="background-color: rgba(245, 245, 245, 0.8);">
                <h1 class="display-4"><?php echo htmlspecialchars($producto['nombre']); ?></h1>
                <p class="text-muted">Categoría: <?php echo htmlspecialchars($producto['categoria_nombre']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></p>
                <h3 class="text-primary">$<?php echo number_format($producto['precio'], 2); ?></h3>

                <form method="post">
                    <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" value="1" min="1" class="form-control" required>
                    </div>
                    <button type="submit" name="agregar_al_carrito" class="btn btn-primary btn-lg"><i class="fa fa-cart-plus"></i> Añadir al Carrito</button>
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
