<?php
session_start();

require_once 'includes/database.php';
require_once 'includes/funciones.php';
include 'modales/modal_agregar_producto.php'; 
include 'modales/modal_editar_producto.php';
include 'modales/modal_agregar_categoria.php';
include 'modales/modal_editar_categoria.php';


// Manejar acciones del administradoress
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch (true) {
        case isset($_POST['agregar_producto']):
            agregarProducto($_POST);
            break;
        case isset($_POST['editar_producto']):
            editarProducto($_POST);
            break;
        case isset($_POST['eliminar_producto']):
            eliminarProducto($_POST['producto_id']);
            break;
        case isset($_POST['agregar_categoria']):
            agregarCategoria($_POST);
            break;
        case isset($_POST['editar_categoria']):
            editarCategoria($_POST);
            break;
        case isset($_POST['eliminar_categoria']):
            eliminarCategoria($_POST['categoria_id']);
            break;
        case isset($_POST['cambiar_estado_pedido']):
            cambiarEstadoPedido($_POST);
            break;
    }
}

// Obtener datos para la página
$productos = obtenerProductos();
$categorias = obtenerCategorias();
$pedidos = obtenerPedidos();

// Funciones del administrador (en includes/funciones.php)


    // ...

    if (isset($_SESSION['mensaje_error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['mensaje_error'] . '</div>';
        unset($_SESSION['mensaje_error']); // Elimina el mensaje de la sesión
    }

    if (isset($_SESSION['mensaje_exito'])) {
        echo '<div class="alert alert-success">' . $_SESSION['mensaje_exito'] . '</div>';
        unset($_SESSION['mensaje_exito']); // Elimina el mensaje de la sesión
    }

    // ... 


function editarProducto($datos) {
    global $conn;

    // Validar datos del formulario
    $productoId = intval($datos['producto_id']);
    $nombre = limpiarInput($datos['nombre']);
    $descripcion = limpiarInput($datos['descripcion']);
    $precio = floatval($datos['precio']);
    $categoriaId = intval($datos['categoria_id']);
    $signosCompatibles = isset($datos['signos_compatibles']) ? implode(',', $datos['signos_compatibles']) : '';

    // Manejo de imágenes
    $imagen = obtenerDetallesProducto($productoId)['imagen']; // Valor actual de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // ... Tu lógica para validar, procesar y guardar la nueva imagen
        $carpetaDestino = 'img/productos/';
        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaImagen = $carpetaDestino . basename($nombreArchivo);

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            $imagen = $rutaImagen; // Actualiza la ruta de la imagen si la subida fue exitosa
        } else {
            echo "Error al subir la imagen.";
        }
    } 

    $sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, imagen=?, categoria_id=?, signos_compatibles=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsisi", $nombre, $descripcion, $precio, $imagen, $categoriaId, $signosCompatibles, $productoId);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Error al editar el producto: " . $stmt->error;
    }
    $stmt->close();

}

function eliminarProducto($productoId) {
    global $conn;
    $productoId = intval($productoId);
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productoId);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }
    $stmt->close();
}

function agregarCategoria($datos) {
    global $conn;

    // Validar datos del formulario
    $nombre = limpiarInput($datos['nombre']);
    
    // Manejo de la imagen
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $carpetaDestino = 'img/categorias/'; // Carpeta para las imágenes de categorías
        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaImagen = $carpetaDestino . basename($nombreArchivo);

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            $imagen = $rutaImagen;
        } else {
            echo "Error al subir la imagen.";
        }
    }

    $sql = "INSERT INTO categorias (nombre, imagen) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre, $imagen);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Error al agregar la categoría: " . $stmt->error;
    }
    $stmt->close();
}

function editarCategoria($datos) {
    global $conn;

    // Validar datos del formulario
    $categoriaId = intval($datos['categoria_id']);
    $nombre = limpiarInput($datos['nombre']);

    // Manejo de la imagen (similar a agregarCategoria)
    $imagen = obtenerInformacionCategoria($categoriaId)['imagen']; // Valor actual de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $carpetaDestino = 'img/categorias/'; 
        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaImagen = $carpetaDestino . basename($nombreArchivo);

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            $imagen = $rutaImagen; 
        } else {
            echo "Error al subir la imagen.";
        }
    } 

    $sql = "UPDATE categorias SET nombre=?, imagen=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $imagen, $categoriaId);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Error al editar la categoría: " . $stmt->error;
    }
    $stmt->close();
}

function eliminarCategoria($categoriaId) {
    global $conn;
    $categoriaId = intval($categoriaId);
    $sql = "DELETE FROM categorias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoriaId);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Error al eliminar la categoría: " . $stmt->error;
    }
    $stmt->close();
}

function cambiarEstadoPedido($datos) {
    global $conn;

    // Validar datos
    $pedidoId = intval($datos['pedido_id']);
    $nuevoEstado = limpiarInput($datos['estado']);

    // Verificar si el nuevo estado es válido
    $estadosValidos = ['pendiente', 'procesando', 'enviado', 'completado', 'cancelado'];
    if (!in_array($nuevoEstado, $estadosValidos)) {
        echo "Estado de pedido inválido.";
        return;
    }

    $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nuevoEstado, $pedidoId);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Error al actualizar el estado del pedido: " . $stmt->error;
    }
    $stmt->close();
}
if (isset($_SESSION['mensaje'])) {
    echo "<div class='mensaje'>" . $_SESSION['mensaje'] . "</div>";
    unset($_SESSION['mensaje']);
}

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
        /* ... Estilos CSS ... */ 
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

    <main class="container my-5">
        <h1 class="text-center mb-4" style="background-color: rgba(245, 245, 245, 0.8);">Panel de Administración</h1>
        
 <!-- Tabla de productos -->
 <div class="cards mb-4" style="background-color: rgba(245, 245, 245, 0.8);">
        <div class="card-header">
            <h5 class="card-title">
                Productos 
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#agregarProductoModal">
                    Agregar Producto
                </button>
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
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
                            <td><?= htmlspecialchars($producto['id']); ?></td>
                            <td><?= htmlspecialchars($producto['nombre']); ?></td>
                            <td><?= number_format($producto['precio'], 2); ?>€</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                                    data-bs-target="#editarProductoModal" 
                                    data-producto-id="<?= htmlspecialchars($producto['id']); ?>"
                                    data-producto-nombre="<?= htmlspecialchars($producto['nombre']); ?>"
                                    data-producto-descripcion="<?= htmlspecialchars($producto['descripcion']); ?>"
                                    data-producto-precio="<?= htmlspecialchars($producto['precio']); ?>"
                                    data-producto-imagen="<?= htmlspecialchars($producto['imagen']); ?>"
                                    data-producto-categoria-id="<?= htmlspecialchars($producto['categoria_id']); ?>"
                                    data-producto-signos-compatibles="<?= htmlspecialchars($producto['signos_compatibles']); ?>">
                                    Editar
                                </button>

                                <form method="post" action="admin.php" style="display: inline;">
                                    <input type="hidden" name="producto_id" value="<?= htmlspecialchars($producto['id']); ?>">
                                    <button type="submit" name="eliminar_producto" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


        <!-- Categorías -->
        <div class="cards mb-4" style="background-color: rgba(245, 245, 245, 0.8);">
            <div class="card-header">
                <h5 class="card-title">
                    Categorías
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#agregarCategoriaModal">
                        Agregar Categoría
                    </button>
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
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
                                <td><?= $categoria['id']; ?></td>
                                <td><?= $categoria['nombre']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                                        data-bs-target="#editarCategoriaModal" 
                                        data-categoria-id="<?= $categoria['id']; ?>"
                                        data-categoria-nombre="<?= $categoria['nombre']; ?>"
                                        data-categoria-imagen="<?= $categoria['imagen']; ?>">
                                        Editar
                                    </button>
                                    <form method="post" action="admin.php" style="display: inline;">
                                        <input type="hidden" name="categoria_id" value="<?= $categoria['id']; ?>">
                                        <button type="submit" name="eliminar_categoria" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar esta categoría?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pedidos -->
        <div class="cards" style="background-color: rgba(245, 245, 245, 0.8);">
            <div class="card-header">
                <h5 class="card-title">Pedidos</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
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
                                <td><?= $pedido['id']; ?></td>
                                <td><?= $pedido['nombre']; ?></td> 
                                <td><?= number_format($pedido['total'], 2); ?>€</td>
                                <td><?= $pedido['estado']; ?></td>
                                <td>
                                    <form method="post" action="admin.php">
                                        <input type="hidden" name="pedido_id" value="<?= $pedido['id']; ?>">
                                        <select name="estado" class="form-select form-select-sm">
                                            <option value="pendiente" <?= ($pedido['estado'] === 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                            <option value="procesando" <?= ($pedido['estado'] === 'procesando') ? 'selected' : ''; ?>>Procesando</option>
                                            <option value="enviado"    <?= ($pedido['estado'] === 'enviado') ? 'selected' : ''; ?>>Enviado</option>
                                            <option value="completado"  <?= ($pedido['estado'] === 'completado') ? 'selected' : ''; ?>>Completado</option>
                                            <option value="cancelado"  <?= ($pedido['estado'] === 'cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                                        </select>
                                        <button type="submit" name="cambiar_estado_pedido" class="btn btn-primary btn-sm mt-2">
                                            Actualizar Estado
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <?php include 'footer.php'; ?>

    <!-- Modales para Agregar/Editar Productos y Categorías -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // ... (JavaScript para manejar los Modals) ...
        // Ejemplo para el Modal de Edición de Productos:
        const editarProductoModal = document.getElementById('editarProductoModal');
        editarProductoModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget; 
            const productoId = button.getAttribute('data-producto-id');
            // ... obtener el resto de los datos del producto del botón ...

            // Actualizar los campos del formulario en el Modal
            const modal = $(this);
            modal.find('#editarProductoId').val(productoId);
            // ... actualizar el resto de los campos del formulario ...
        });

    </script>

</body>
</html>