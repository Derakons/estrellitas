<?php
/**
 * Funciones para AstroShop
 * 
 * Este archivo contiene funciones útiles para el funcionamiento de la tienda online.
 */

// Limpieza y Seguridad

/**
 * Limpia la entrada de datos para evitar XSS e inyecciones.
 * 
 * @param string $data Datos de entrada
 * @return string Datos limpiados
 */
function limpiarInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Funciones de Carrito de Compras

/**
 * Calcula el total del carrito de compras.
 * 
 * @param array $carrito Carrito de compras
 * @return float Total del carrito
 */
function calcularTotalCarrito($carrito) {
    $total = 0;
    if (is_array($carrito) && !empty($carrito)) {
        foreach ($carrito as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
    }
    return $total;
}

/**
 * Agrega un producto al carrito de compras.
 * 
 * @param int $producto_id ID del producto
 * @param int $cantidad Cantidad del producto
 */
function agregarAlCarrito($producto_id, $cantidad) {
    global $conn;
    $producto = obtenerDetallesProducto($producto_id);
    $_SESSION['carrito'][$producto_id] = array(
        'id' => $producto['id'],
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'imagen' => $producto['imagen'],
        'cantidad' => $cantidad
    );
}

/**
 * Elimina un producto del carrito de compras.
 * 
 * @param int $producto_id ID del producto
 */
function eliminarDelCarrito($producto_id) {
    if (isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
    }
}

/**
 * Actualiza la cantidad de un producto en el carrito de compras.
 * 
 * @param int $producto_id ID del producto
 * @param int $cantidad Nueva cantidad
 */
function actualizarCantidadCarrito($producto_id, $cantidad) {
    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id]['cantidad'] = $cantidad;
    }
}

/**
 * Obtiene el número de artículos en el carrito de compras.
 * 
 * @return int Cantidad de artículos en el carrito
 */
function obtenerCantidadCarrito() {
    return isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
}

// Funciones de Administración de Usuarios

/**
 * Verifica si el usuario actual es administrador.
 * 
 * @return bool Verdadero si es administrador, falso si no lo es
 */
function esAdministrador() {
    if (isset($_SESSION['usuario_id'])) {
        return verificarEsAdministrador($_SESSION['usuario_id']);
    }
    return false;
}

/**
 * Verifica si un usuario específico es administrador.
 * 
 * @param int $usuarioId ID del usuario
 * @return bool Verdadero si es administrador, falso si no lo es
 */
function verificarEsAdministrador($usuarioId) {
    global $conn;
    $sql = "SELECT es_administrador FROM usuarios WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $usuarioId);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['es_administrador'] == 1;
    }
    return false;
}

/**
 * Registra un nuevo usuario.
 * 
 * @param string $nombre Nombre del usuario
 * @param string $email Correo electrónico del usuario
 * @param string $contrasena Contraseña del usuario
 * @param string $signo_zodiacal Signo zodiacal del usuario
 * @return bool Verdadero si se registra exitosamente, falso en caso contrario
 */
function registrarUsuario($nombre, $email, $contrasena, $signo_zodiacal) {
    global $conn;
    $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, contrasena, signo_zodiacal) VALUES (?, ?, ?, ?)";
    return ejecutarConsulta($sql, "ssss", $nombre, $email, $contrasena_cifrada, $signo_zodiacal);
}

/**
 * Verifica la contraseña de un usuario.
 * 
 * @param string $contrasena Contraseña ingresada
 * @param string $contrasena_cifrada Contraseña cifrada almacenada
 * @return bool Verdadero si coincide, falso si no
 */
function verificarContrasena($contrasena, $contrasena_cifrada) {
    return password_verify($contrasena, $contrasena_cifrada);
}

/**
 * Obtiene la información de un usuario por su ID.
 * 
 * @param int $usuario_id ID del usuario
 * @return array|null Datos del usuario o null si no existe
 */
function obtenerUsuario($usuario_id) {
    global $conn;
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $usuario_id);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    }
    return null;
}

/**
 * Actualiza la información de un usuario.
 * 
 * @param int $usuario_id ID del usuario
 * @param string $nombre Nombre del usuario
 * @param string $email Correo electrónico del usuario
 * @param string|null $contrasena Nueva contraseña (opcional)
 * @return bool Verdadero si se actualiza exitosamente, falso en caso contrario
 */
function actualizarUsuario($usuario_id, $nombre, $email, $contrasena = null) {
    global $conn;
    $sql = "UPDATE usuarios SET nombre = ?, email = ?";
    $params = [$nombre, $email];
    $tipos = "ss";

    if (!is_null($contrasena)) {
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql .= ", contrasena = ?";
        $params[] = $contrasena_cifrada;
        $tipos .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $usuario_id;
    $tipos .= "i";

    return ejecutarConsulta($sql, $tipos, ...$params);
}

/**
 * Elimina un usuario por su ID.
 * 
 * @param int $usuario_id ID del usuario
 * @return bool Verdadero si se elimina exitosamente, falso en caso contrario
 */
function eliminarUsuario($usuario_id) {
    global $conn;
    $sql = "DELETE FROM usuarios WHERE id = ?";
    return ejecutarConsulta($sql, "i", $usuario_id);
}

/**
 * Verifica si un correo electrónico ya está registrado.
 * 
 * @param string $email Correo electrónico
 * @return bool Verdadero si ya existe, falso si no
 */
function correoExiste($email) {
    global $conn;
    $sql = "SELECT COUNT(*) AS existe FROM usuarios WHERE email = ?";
    $resultado = ejecutarConsulta($sql, "s", $email);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['existe'] > 0;
    }
    return false;
}

/**
 * Obtiene el correo electrónico de un usuario por su ID.
 * 
 * @param int $usuario_id ID del usuario
 * @return string Correo electrónico del usuario
 */
function obtenerEmailUsuario($usuario_id) {
    global $conn;
    $sql = "SELECT email FROM usuarios WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $usuario_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['email'];
    }
    return "";
}

// Funciones de Productos

/**
 * Obtiene la lista de todos los productos.
 * 
 * @return array Lista de productos
 */
function obtenerProductos() {
    global $conn;
    $sql = "SELECT * FROM productos";
    $resultado = ejecutarConsulta($sql);

    $productos = [];
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $productos[] = $row;
        }
    }
    return $productos;
}

/**
 * Obtiene el nombre de un producto por su ID.
 * 
 * @param int $producto_id ID del producto
 * @return string Nombre del producto
 */
function obtenerNombreProducto($producto_id) {
    global $conn;
    $sql = "SELECT nombre FROM productos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $producto_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['nombre'];
    }
    return "Producto no encontrado";
}

/**
 * Obtiene los detalles de un producto por su ID.
 * 
 * @param int $producto_id ID del producto
 * @return array|null Detalles del producto o null si no existe
 */
function obtenerDetallesProducto($producto_id) {
    global $conn;
    $sql = "SELECT * FROM productos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $producto_id);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    }
    return null;
}

/**
 * Obtiene las imágenes de un producto por su ID.
 * 
 * @param int $producto_id ID del producto
 * @return array Lista de rutas de imágenes
 */
function obtenerImagenesProducto($producto_id) {
    global $conn;
    $sql = "SELECT ruta FROM imagenes_productos WHERE producto_id = ?";
    $resultado = ejecutarConsulta($sql, "i", $producto_id);

    $imagenes = [];
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $imagenes[] = $row['ruta'];
        }
    }
    return $imagenes;
}

/**
 * Obtiene los signos compatibles con un producto.
 * 
 * @param int $producto_id ID del producto
 * @return array Lista de signos compatibles
 */
function obtenerSignosCompatibles($producto_id) {
    global $conn;
    $sql = "SELECT signos_compatibles FROM productos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $producto_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return explode(",", $row['signos_compatibles']);
    }
    return [];
}

// Funciones de Categorías

/**
 * Obtiene la lista de todas las categorías.
 * 
 * @return array Lista de categorías
 */
function obtenerCategorias() {
    global $conn;
    $sql = "SELECT * FROM categorias";
    $resultado = ejecutarConsulta($sql);

    return $resultado->fetch_all(MYSQLI_ASSOC);
}

/**
 * Obtiene la información de una categoría por su ID.
 * 
 * @param int $categoria_id ID de la categoría
 * @return array|null Información de la categoría o null si no existe
 */
function obtenerInformacionCategoria($categoria_id) {
    global $conn;
    $sql = "SELECT * FROM categorias WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $categoria_id);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    }
    return null;
}

// Funciones de Pedidos

/**
 * Obtiene la lista de todos los pedidos.
 * 
 * @return array Lista de pedidos
 */
function obtenerPedidos() {
    global $conn;
    $sql = "SELECT p.*, u.nombre
            FROM pedidos p 
            LEFT JOIN usuarios u ON p.usuario_id = u.id";
    $resultado = ejecutarConsulta($sql);

    if (!$resultado) {
        echo "Error en la consulta: " . $conn->error;
        exit;
    }

    return $resultado->fetch_all(MYSQLI_ASSOC);
}

/**
 * Obtiene los pedidos de un usuario por su ID.
 * 
 * @param int $usuario_id ID del usuario
 * @return array Lista de pedidos del usuario
 */
function obtenerPedidosUsuario($usuario_id) {
    global $conn;
    $sql = "SELECT * FROM pedidos WHERE usuario_id = ? ORDER BY fecha_pedido_utc DESC";
    $resultado = ejecutarConsulta($sql, "i", $usuario_id);

    $pedidos = [];
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $pedidos[] = $row;
        }
    }
    return $pedidos;
}

/**
 * Obtiene los detalles de un pedido por su ID.
 * 
 * @param int $pedido_id ID del pedido
 * @return array|null Detalles del pedido o null si no existe
 */
function obtenerDetallesPedido($pedido_id) {
    global $conn;
    $sql = "SELECT * FROM pedidos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $pedido_id);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    }
    return null;
}

/**
 * Obtiene los productos de un pedido por su ID.
 * 
 * @param int $pedido_id ID del pedido
 * @return array Lista de productos en el pedido
 */
function obtenerProductosPedido($pedido_id) {
    global $conn;
    $sql = "SELECT p.*, dp.cantidad, dp.precio_unitario 
            FROM detalle_pedidos dp
            JOIN productos p ON dp.producto_id = p.id
            WHERE dp.pedido_id = ?";
    $resultado = ejecutarConsulta($sql, "i", $pedido_id);

    $productos = [];
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $productos[] = $row;
        }
    }
    return $productos;
}

/**
 * Obtiene el total de un pedido por su ID.
 * 
 * @param int $pedido_id ID del pedido
 * @return float Total del pedido
 */
function obtenerTotalPedido($pedido_id) {
    global $conn;
    $sql = "SELECT total FROM pedidos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $pedido_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['total'];
    }
    return 0;
}

/**
 * Obtiene el estado de un pedido por su ID.
 * 
 * @param int $pedido_id ID del pedido
 * @return string Estado del pedido
 */
function obtenerEstadoPedido($pedido_id) {
    global $conn;
    $sql = "SELECT estado FROM pedidos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $pedido_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['estado'];
    }
    return "Desconocido";
}

// Funciones de Correo Electrónico

/**
 * Envía un correo electrónico.
 * 
 * @param string $to Destinatario
 * @param string $subject Asunto
 * @param string $message Mensaje
 * @return bool Verdadero si se envía exitosamente, falso en caso contrario
 */
function enviarCorreo($to, $subject, $message) {
    return mail($to, $subject, $message);
}
function agregarProducto($datos) {
    global $conn; // Asegúrate de que $conn esté disponible

    // Inicia el manejo de mensajes
    $mensaje = '';

    // Validar datos del formulario
    $nombre = limpiarInput($datos['nombre']);
    $descripcion = limpiarInput($datos['descripcion']);
    $precio = floatval($datos['precio']);
    $categoriaId = intval($datos['categoria_id']);
    $signosCompatibles = isset($datos['signos_compatibles']) ? implode(',', $datos['signos_compatibles']) : '';

    // Manejo de imágenes
    $imagen = '';
    $errorSubida = '';

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $carpetaDestino = '../img/productos/'; // Ajusta la ruta si es necesario

        if (!is_dir($carpetaDestino)) {
            if (!mkdir($carpetaDestino, 0755, true)) {
                $errorSubida = "Error al crear la carpeta de imágenes: " . error_get_last()['message'];
            }
        }

        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaImagen = $carpetaDestino . basename($nombreArchivo);

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            $imagen = $rutaImagen;
        } else {
            $errorSubida = "Error al subir la imagen. Código: " . $_FILES['imagen']['error'];
        }
    }

    // Consulta SQL para agregar el producto
    $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen, categoria_id, signos_compatibles) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepara la consulta
    $stmt = $conn->prepare($sql);

    // Maneja errores en la preparación de la consulta
    if ($stmt) { 
        // Vincula los parámetros
        $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $imagen, $categoriaId, $signosCompatibles);

        // Ejecuta la consulta
        if ($stmt->execute()) {
            // Manejo de éxito
            $mensaje = "Producto agregado correctamente.";
        } else {
            $mensaje = "Error al agregar el producto: " . $stmt->error;
        }

        // Cierra la consulta
        $stmt->close(); 
    } else {
        $mensaje = "Error en la preparación de la consulta: " . $conn->error;
    }

    // Guardar el mensaje en la sesión y redireccionar
    $_SESSION['mensaje'] = $mensaje;
    header("Location: admin.php"); 
    exit;
}

?>
