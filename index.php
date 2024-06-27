<?php
session_start(); // Inicia la sesión al inicio de login.php


require_once 'includes/database.php'; // Archivo de conexión a la base de datos
require_once 'includes/funciones.php';

// Inicializar carrito de compras si no existe
if (!isset($_SESSION['carrito'])) {
  $_SESSION['carrito'] = array();
}

// Agregar producto al carrito
if (isset($_POST['agregar_al_carrito'])) {
  $producto_id = limpiarInput($_POST['producto_id']);
  $cantidad = limpiarInput($_POST['cantidad']);

  // Verificar si el producto ya está en el carrito
  if (isset($_SESSION['carrito'][$producto_id])) {
    $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad; 
  } else {
    // Obtener detalles del producto de la base de datos
    $sql_producto = "SELECT * FROM productos WHERE id = ?";
    $resultado_producto = ejecutarConsulta($sql_producto, "i", $producto_id);
    $producto = $resultado_producto->fetch_assoc();

    // Agregar al carrito
    $_SESSION['carrito'][$producto_id] = array(
      'id' => $producto['id'],
      'nombre' => $producto['nombre'],
      'precio' => $producto['precio'],
      'imagen' => $producto['imagen'],
      'cantidad' => $cantidad
    );
  }
}

// Paginación (Ejemplo básico, puedes ajustarlo)
$productosPorPagina = 8;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual - 1) * $productosPorPagina;


// Obtener el total de productos
$sql_total_productos = "SELECT COUNT(*) AS total FROM productos";
$resultado_total_productos = $conn->query($sql_total_productos);
$totalProductos = $resultado_total_productos->fetch_assoc()['total'];
$totalPaginas = ceil($totalProductos / $productosPorPagina);

// Obtener productos para la página actual
$sql_productos = "SELECT * FROM productos LIMIT ?, ?";
$resultado_productos = ejecutarConsulta($sql_productos, "ii", $inicio, $productosPorPagina);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Tu Tienda Online de Astrología</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
<div class="video-background">
        <video autoplay muted loop>
            <source src="img/ra.mp4" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
    </div>

<?php include 'navbar.php'; ?> 

<header class="jumbotronS text-center" id="header">
        <div class="container">
            <h1 class="display-4 neon-text" id="headerText">¡Bienvenido a AstroShop!</h1>
            <p class="lead">Encuentra todo lo que necesitas para tu viaje astral.</p>
        </div>
    </header>

<?php 
  // En index.php, después de incluir el navbar y antes de la sección de productos destacados

  // Obtener categorías desde la base de datos
  $sql_categorias = "SELECT * FROM categorias";
  $resultado_categorias = $conn->query($sql_categorias);
?>


<?php
// Procesar nuevo comentario (si se envía el formulario)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_comentario'])) {
  $nombre = limpiarInput($_POST['nombre']);
  $email = limpiarInput($_POST['email']);
  $comentario = limpiarInput($_POST['comentario']);

  // Validación básica (puedes agregar más validaciones)
  if (empty($nombre) || empty($email) || empty($comentario)) {
    $error_comentario = "Por favor, completa todos los campos.";
  } else {
    // Guardar comentario en la base de datos
    $sql_comentario = "INSERT INTO comentarios (nombre, email, comentario) VALUES (?, ?, ?)";
    $guardar_comentario = ejecutarConsulta($sql_comentario, "sss", $nombre, $email, $comentario); 

    if ($guardar_comentario) {
      $mensaje_exito = "Tu comentario se ha enviado correctamente.";
      $nombre = "";
      $email = "";
      $comentario = "";
    } else {
      $error_comentario = "Hubo un error al enviar tu comentario. Inténtalo de nuevo.";
    }
  }
}

// Obtener comentarios de la base de datos
$sql_obtener_comentarios = "SELECT * FROM comentarios ORDER BY fecha_comentario DESC";
$resultado_comentarios = ejecutarConsulta($sql_obtener_comentarios);
?>

<!-- ... (resto del contenido de index.php) ... -->

<section class="container py-5" >
  <h2 class="text-center mb-4 transparent-bg">Comentarios</h2>

  <?php if (isset($mensaje_exito)): ?>
    <div class="alert alert-success"><?php echo $mensaje_exito; ?></div>
  <?php endif; ?>

  <?php if (isset($error_comentario)): ?>
    <div class="alert alert-danger"><?php echo $error_comentario; ?></div>
  <?php endif; ?>

  <!-- Formulario para enviar comentarios -->
  <div class="mb-4 transparent-bg"  >
    <form method="post" action="">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
      </div>
      <div class="mb-3">
        <label for="comentario" class="form-label">Comentario:</label>
        <textarea class="form-control" id="comentario" name="comentario" rows="4"><?php echo isset($comentario) ? $comentario : ''; ?></textarea>
      </div>
      <button type="submit" name="enviar_comentario" class="btn btn-primary">Enviar comentario</button>
    </form>
  </div>

  <!-- Mostrar comentarios existentes -->
  <div class="comentarios transparent-bg">
    <?php 
    if ($resultado_comentarios->num_rows > 0) {
      while ($comentario = $resultado_comentarios->fetch_assoc()) { ?>
        <div class="comentario mb-3">
          <div class="comentario-encabezado">
            <strong><?php echo $comentario['nombre']; ?></strong> 
            <small class="text-muted"> - <?php echo date("d/m/Y", strtotime($comentario['fecha_comentario'])); ?></small>
          </div>
          <p><?php echo nl2br($comentario['comentario']); ?></p>
        </div>
    <?php 
      } 
    } else { ?>
      <p>Aún no hay comentarios. ¡Sé el primero en compartir tu opinión!</p>
    <?php } ?>
  </div>
</section>

<!-- ... (resto del código de index.php) ... -->
    <!--  Footer --> 
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script> 
    <script>
        // Función para cambiar el color del texto con efecto de neón
        function cambiarColorTexto() {
            var headerText = document.getElementById('headerText');
            var colores = ['#39ff14', '#ff00ff', '#00ffff', '#ffff00']; // Lista de colores a utilizar
            var indiceColor = 0;

            setInterval(function() {
                var colorActual = colores[indiceColor];
                headerText.style.color = colorActual;
                headerText.style.textShadow = 
                    `0 0 5px rgba(255, 255, 255, 0.5),
                    0 0 10px rgba(255, 255, 255, 0.5),
                    0 0 20px rgba(255, 255, 255, 0.5),
                    0 0 40px ${colorActual},
                    0 0 80px ${colorActual},
                    0 0 90px ${colorActual},
                    0 0 100px ${colorActual},
                    0 0 150px ${colorActual}`;

                indiceColor = (indiceColor + 1) % colores.length; // Avanza al siguiente color
            }, 2000); // Cambia cada 2 segundos (2000 milisegundos)
        }

        // Llama a la función al cargar la página
        window.onload = cambiarColorTexto;
    </script>
</body>
</html>