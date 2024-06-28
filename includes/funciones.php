<?php

/**
 * Funciones para AstroShop
 * 
 * Este archivo contiene funciones útiles para el funcionamiento de la tienda online.
 */

// Función para limpiar datos de entrada
function limpiarInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Función para calcular el total del carrito de compras
function calcularTotalCarrito($carrito) {
    $total = 0;
    if (is_array($carrito) && !empty($carrito)) {
        foreach ($carrito as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
    }
    return $total;
}
// Función para verificar si un usuario es administrador
function esAdministrador($usuario_id) {
    global $conn;

    $sql = "SELECT es_administrador FROM usuarios WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $usuario_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['es_administrador'];
    } else {
        return false;
    }
}

// Función para obtener todos los productos
function obtenerProductos() {
    global $conn;

    $sql = "SELECT * FROM productos";
    $resultado = ejecutarConsulta($sql); // No necesita parámetros en este caso

    $productos = [];
    if ($resultado && $resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $productos[] = $row;
        }
    }
    return $productos;
}
// Función para obtener el nombre de un producto por su ID
function obtenerNombreProducto($producto_id) {
    global $conn;

    $sql = "SELECT nombre FROM productos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $producto_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['nombre'];
    } else {
        return "Producto no encontrado";
    }
}

// Función para obtener los detalles de un producto por su ID
function obtenerDetallesProducto($producto_id) {
    global $conn;

    $sql = "SELECT * FROM productos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $producto_id);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    } else {
        return null;
    }
}

// Función para obtener la información de una categoría por su ID
function obtenerInformacionCategoria($categoria_id) {
    global $conn;

    $sql = "SELECT * FROM categorias WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $categoria_id);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    } else {
        return null;
    }
}

// Función para obtener la lista de imágenes de un producto
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

// Función para obtener la lista de signos compatibles con un producto
function obtenerSignosCompatibles($producto_id) {
    global $conn;

    $sql = "SELECT signos_compatibles FROM productos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $producto_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return explode(",", $row['signos_compatibles']); // Divide la cadena en un array
    } else {
        return []; // Devuelve un array vacío si no se encuentran signos
    }
}

// Función para agregar un producto al carrito de compras
function agregarAlCarrito($producto_id, $cantidad) {
    global $conn;

    // Obtener detalles del producto
    $producto = obtenerDetallesProducto($producto_id);

    // Agregar producto al carrito de compras (en la sesión)
    $_SESSION['carrito'][$producto_id] = array(
        'id' => $producto['id'],
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'imagen' => $producto['imagen'],
        'cantidad' => $cantidad
    );
}

// Función para eliminar un producto del carrito de compras
function eliminarDelCarrito($producto_id) {
    if (isset($_SESSION['carrito'][$producto_id])) {
        unset($_SESSION['carrito'][$producto_id]);
    }
}

// Función para actualizar la cantidad de un producto en el carrito
function actualizarCantidadCarrito($producto_id, $cantidad) {
    if (isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id]['cantidad'] = $cantidad;
    }
}

// Función para obtener el número de artículos en el carrito de compras
function obtenerCantidadCarrito() {
    return isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
}

// Función para obtener el total de un pedido
function obtenerTotalPedido($pedido_id) {
    global $conn;

    $sql = "SELECT total FROM pedidos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $pedido_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

// Función para obtener el estado de un pedido
function obtenerEstadoPedido($pedido_id) {
    global $conn;

    $sql = "SELECT estado FROM pedidos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $pedido_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['estado'];
    } else {
        return "Desconocido";
    }
}
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

// Función para obtener los detalles de un pedido por ID
function obtenerDetallesPedido($pedido_id) {
    global $conn;

    $sql = "SELECT * FROM pedidos WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $pedido_id);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    } else {
        return null;
    }
}

// Función para obtener los productos de un pedido por ID
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

// Función para enviar un correo electrónico (puedes usar una librería como PHPMailer)
function enviarCorreo($to, $subject, $message) {
    // Implementa aquí la lógica para enviar correos electrónicos
    // Puedes usar una librería como PHPMailer o la función mail() de PHP
    // Ejemplo usando mail():
    if (mail($to, $subject, $message)) {
        return true;
    } else {
        return false;
    }
}

// Función para obtener la dirección de correo electrónico del usuario por ID
function obtenerEmailUsuario($usuario_id) {
    global $conn;

    $sql = "SELECT email FROM usuarios WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $usuario_id);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['email'];
    } else {
        return "";
    }
}

// Función para verificar si un correo electrónico ya está registrado
function correoExiste($email) {
    global $conn;

    $sql = "SELECT COUNT(*) AS existe FROM usuarios WHERE email = ?";
    $resultado = ejecutarConsulta($sql, "s", $email);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['existe'] > 0;
    } else {
        return false;
    }
}

// Función para registrar un nuevo usuario
function registrarUsuario($nombre, $email, $contrasena, $signo_zodiacal) {
    global $conn;

    // Cifrar la contraseña antes de guardarla
    $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, contrasena, signo_zodiacal) VALUES (?, ?, ?, ?)";
    $resultado = ejecutarConsulta($sql, "ssss", $nombre, $email, $contrasena_cifrada, $signo_zodiacal);

    return $resultado;
}

// Función para verificar la contraseña de un usuario
function verificarContrasena($contrasena, $contrasena_cifrada) {
    return password_verify($contrasena, $contrasena_cifrada);
}

// Función para obtener los datos de un usuario por su ID
function obtenerUsuario($usuario_id) {
    global $conn;

    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $usuario_id);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    } else {
        return null;
    }
}

// Función para actualizar la información de un usuario
function actualizarUsuario($usuario_id, $nombre, $email, $contrasena = null) {
    global $conn;

    $sql = "UPDATE usuarios SET nombre = ?, email = ?";
    $params = [$nombre, $email];
    $tipos = "ss";

    if (!is_null($contrasena)) {
        // Cifrar la contraseña antes de actualizarla
        $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql .= ", contrasena = ?";
        $params[] = $contrasena_cifrada;
        $tipos .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $usuario_id;
    $tipos .= "i";

    $resultado = ejecutarConsulta($sql, $tipos, ...$params);

    return $resultado;
}

// Función para eliminar un usuario
function eliminarUsuario($usuario_id) {
    global $conn;

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $resultado = ejecutarConsulta($sql, "i", $usuario_id);

    return $resultado;
}

?>