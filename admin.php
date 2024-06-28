<?php
session_start();

require_once 'includes/database.php';
require_once 'includes/funciones.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['usuario_id']) || !esAdministrador($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Manejar acciones del administrador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_producto'])) {
        // Procesar el formulario para agregar un nuevo producto
        // ...
    } elseif (isset($_POST['editar_producto'])) {
        // Procesar el formulario para editar un producto existente
        // ...
    } elseif (isset($_POST['eliminar_producto'])) {
        // Eliminar un producto
        // ...
    } elseif (isset($_POST['agregar_categoria'])) {
        // Procesar el formulario para agregar una nueva categoría
        // ...
    } elseif (isset($_POST['editar_categoria'])) {
        // Procesar el formulario para editar una categoría existente
        // ...
    } elseif (isset($_POST['eliminar_categoria'])) {
        // Eliminar una categoría
        // ...
    } elseif (isset($_POST['cambiar_estado_pedido'])) {
        // Cambiar el estado de un pedido
        // ...
    }
}
// ... (código existente)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_producto'])) {
        // Obtener datos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $categoriaId = $_POST['categoria_id'];
        // Validar datos
        // ...
        // Insertar producto en la base de datos
        $sql = "INSERT INTO productos (nombre, descripcion, precio, categoria_id) VALUES ('$nombre', '$descripcion', $precio, $categoriaId)";
        if ($conn->query($sql) === TRUE) {
            // Redirigir a la página de administración
            header("Location: admin.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['editar_producto'])) {
        // Obtener datos del formulario y ID del producto
        $productoId = $_POST['producto_id'];
        // ... (resto del código para editar producto)
    } elseif (isset($_POST['eliminar_producto'])) {
        // Obtener ID del producto
        $productoId = $_POST['producto_id'];
        // Eliminar producto de la base de datos
        $sql = "DELETE FROM productos WHERE id = $productoId";
        if ($conn->query($sql) === TRUE) {
            // Redirigir a la página de administración
            header("Location: admin.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    // ... (resto de las acciones de los formularios)
}

// ... (resto del código)
// Obtener datos para la página
$productos = obtenerProductos();
$categorias = obtenerCategorias();
$pedidos = obtenerPedidos();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Estilos para el panel de administración */
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 960px;
        }
        .card {
            margin-bottom: 20px;
        }
        .table th, .table td {
            text-align: center;
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
        <h1 class="text-center mb-4">Panel de Administración</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Productos</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $producto) : ?>
                                    <tr>
                                        <td><?php echo $producto['id']; ?></td>
                                        <td><?php echo $producto['nombre']; ?></td>
                                        <td><?php echo number_format($producto['precio'], 2); ?>€</td>
                                        <td>
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarProductoModal" data-producto-id="<?php echo $producto['id']; ?>">Editar</a>
                                            <form method="post" action="admin.php" style="display: inline;">
                                                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                                <button type="submit" name="eliminar_producto" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarProductoModal">Agregar Producto</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Categorías</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categorias as $categoria) : ?>
                                    <tr>
                                        <td><?php echo $categoria['id']; ?></td>
                                        <td><?php echo $categoria['nombre']; ?></td>
                                        <td>
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal" data-categoria-id="<?php echo $categoria['id']; ?>">Editar</a>
                                            <form method="post" action="admin.php" style="display: inline;">
                                                <input type="hidden" name="categoria_id" value="<?php echo $categoria['id']; ?>">
                                                <button type="submit" name="eliminar_categoria" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCategoriaModal">Agregar Categoría</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Pedidos</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $pedido) : ?>
                                    <tr>
                                        <td><?php echo $pedido['id']; ?></td>
                                        <td><?php echo $pedido['nombre'] . ' ' . $pedido['apellidos']; ?></td>
                                        <td><?php echo number_format($pedido['total'], 2); ?>€</td>
                                        <td><?php echo $pedido['estado']; ?></td>
                                        <td>
                                            <form method="post" action="admin.php">
                                                <input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">
                                                <select name="estado" class="form-select">
                                                    <option value="pendiente" <?php echo ($pedido['estado'] === 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                                    <option value="procesando" <?php echo ($pedido['estado'] === 'procesando') ? 'selected' : ''; ?>>Procesando</option>
                                                    <option value="enviado" <?php echo ($pedido['estado'] === 'enviado') ? 'selected' : ''; ?>>Enviado</option>
                                                    <option value="completado" <?php echo ($pedido['estado'] === 'completado') ? 'selected' : ''; ?>>Completado</option>
                                                    <option value="cancelado" <?php echo ($pedido['estado'] === 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                                                </select>
                                                <button type="submit" name="cambiar_estado_pedido" class="btn btn-primary">Actualizar Estado</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include 'footer.php'; ?>

    <!-- Modals -->
    <!-- Modal para agregar un producto -->
    <div class="modal fade" id="agregarProductoModal" tabindex="-1" aria-labelledby="agregarProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarProductoModalLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="admin.php">
                        <!-- Formulario para agregar producto -->
                        <button type="submit" name="agregar_producto" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar un producto -->
    <div class="modal fade" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarProductoModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="admin.php">
                        <!-- Formulario para editar producto -->
                        <input type="hidden" name="producto_id" id="productoId">
                        <button type="submit" name="editar_producto" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar una categoría -->
    <div class="modal fade" id="agregarCategoriaModal" tabindex="-1" aria-labelledby="agregarCategoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarCategoriaModalLabel">Agregar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="admin.php">
                        <!-- Formulario para agregar categoría -->
                        <button type="submit" name="agregar_categoria" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar una categoría -->
    <div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="admin.php">
                        <!-- Formulario para editar categoría -->
                        <input type="hidden" name="categoria_id" id="categoriaId">
                        <button type="submit" name="editar_categoria" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Eventos para los modales de edición
        const editarProductoModal = document.getElementById('editarProductoModal');
        editarProductoModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const productoId = button.getAttribute('data-producto-id');
            const modalTitle = editarProductoModal.querySelector('.modal-title');
            const productoIdInput = editarProductoModal.querySelector('#productoId');
            // Obtener información del producto (usando AJAX) y rellenar el formulario
            // ...
            productoIdInput.value = productoId;
        });

        const editarCategoriaModal = document.getElementById('editarCategoriaModal');
        editarCategoriaModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;
            const categoriaId = button.getAttribute('data-categoria-id');
            const modalTitle = editarCategoriaModal.querySelector('.modal-title');
            const categoriaIdInput = editarCategoriaModal.querySelector('#categoriaId');
            // Obtener información de la categoría (usando AJAX) y rellenar el formulario
            // ...
            categoriaIdInput.value = categoriaId;
        });
    </script>
</body>
</html>