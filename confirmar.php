<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Confirmación de Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
    /* Estilos para el carrusel de categorías */
    #carouselCategorias .card-img-top {
      width: 300px;       /* Ancho fijo */
      height: 300px;      /* Alto fijo */
     object-fit: cover;   /* Ajusta la imagen para cubrir el área, manteniendo la relación de aspecto */
     margin: 0 auto;     /* Centra la imagen horizontalmente */
      }

        /* Estilos internos para el video de fondo */
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
        .content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding: 50px;
        }
        /* Estilo para el encabezado con color blanco neon */
        .jumbotronS {
            background-color: transparent; /* Fondo transparente */
            color: #ffffff; /* Texto inicial en blanco */
            padding: 4rem 2rem; /* Ajuste de espaciado interno */
        }
        .transparent-bg {
            background-color: rgba(255, 255, 255, 0.7); /* Fondo blanco con transparencia */
            padding: 2rem; /* Espaciado interno */
            border-radius: 30px; /* Bordes redondeados */
        }
                /* Estilo para el efecto neón */
                .neon-text {
            text-shadow:
                0 0 5px rgba(255, 255, 255, 0.5),
                0 0 10px rgba(255, 255, 255, 0.5),
                0 0 20px rgba(255, 255, 255, 0.5),
                0 0 40px #39ff14,
                0 0 80px #39ff14,
                0 0 90px #39ff14,
                0 0 100px #39ff14,
                0 0 150px #39ff14;
            transition: color 2s ease, text-shadow 2s ease;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    require_once 'includes/database.php';
    require_once 'includes/funciones.php';

    

    // Obtener ID del pedido de la URL
    $pedido_id = isset($_GET['id']) ? (int)limpiarInput($_GET['id']) : null;

    // Validar que el pedido existe
    if (!$pedido_id) {
        header("Location: index.php");
        exit;
    }

    // Obtener detalles del pedido
    $pedido = obtenerDetallesPedido($pedido_id);
    $productos = obtenerProductosPedido($pedido_id);

    // Verificar si el pedido existe
    if (!$pedido) {
        header("Location: index.php");
        exit;
    }

    // Reiniciar el carrito de compras
    $_SESSION['carrito'] = []; // Limpia el carrito
    ?>

    <?php include 'navbar.php'; ?>

    <main class="container">
        <h2 class="text-center mb-4">Confirmación de Pedido</h2>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">¡Tu pedido ha sido realizado con éxito!</h5>
                <p class="card-text">Gracias por tu compra. Tu pedido se está procesando y recibirás una confirmación por correo electrónico pronto.</p>
                <p class="card-text"><strong>Número de Pedido:</strong> <?php echo $pedido_id; ?></p>

                <h6 class="card-title mt-4">Detalles de tu pedido:</h6>
                <table class="table mt-2">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) : ?>
                            <tr>
                                <td>
                                    <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>" class="product-image">
                                    <?php echo $producto['nombre']; ?>
                                </td>
                                <td><?php echo number_format($producto['precio'], 2); ?>€</td>
                                <td><?php echo $producto['cantidad']; ?></td>
                                <td><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?>€</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong><?php echo number_format($pedido['total'], 2); ?>€</strong></td>
                        </tr>
                    </tfoot>
                </table>

                <h6 class="card-title mt-4">Información de envío:</h6>
                <ul class="list-group mt-2">
                    <li class="list-group-item"><strong>Nombre:</strong> <?php echo $pedido['nombre']; ?></li>
                    <li class="list-group-item"><strong>Apellidos:</strong> <?php echo $pedido['apellidos']; ?></li>
                    <li class="list-group-item"><strong>Email:</strong> <?php echo $pedido['email']; ?></li>
                    <li class="list-group-item"><strong>Teléfono:</strong> <?php echo $pedido['telefono']; ?></li>
                    <li class="list-group-item"><strong>Dirección:</strong> <?php echo $pedido['direccion']; ?></li>
                    <li class="list-group-item"><strong>Ciudad:</strong> <?php echo $pedido['ciudad']; ?></li>
                    <li class="list-group-item"><strong>Código Postal:</strong> <?php echo $pedido['codigo_postal']; ?></li>
                    <li class="list-group-item"><strong>Método de Pago:</strong> <?php echo $pedido['metodo_pago']; ?></li>
                </ul>

                <p class="card-text mt-4">Puedes ver el estado de tu pedido en tu <a href="pedidos.php">historial de pedidos</a>.</p>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>