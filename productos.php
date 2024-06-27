<?php
session_start(); // Inicia la sesión al inicio de login.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroShop - Productos</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
                .product-card {
            height: 100%; /* Asegura que todas las tarjetas tengan la misma altura */
            border: 1px solid #dee2e6; /* Borde ligero para separación visual */
            border-radius: 8px; /* Bordes redondeados */
            transition: transform 0.3s ease; /* Transición suave al pasar el mouse */
        }

        .product-card:hover {
            transform: translateY(-5px); /* Efecto de elevación al pasar el mouse */
        }

        .product-image {
            height: 200px; /* Altura fija para las imágenes */
            object-fit: cover; /* Ajuste de la imagen para cubrir el espacio */
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .product-details {
            padding: 1.25rem; /* Espaciado interno */
        }

        .product-title {
            font-size: 1.25rem; /* Tamaño de fuente del título */
            margin-bottom: 0.75rem; /* Espacio inferior del título */
        }

        .product-price {
            font-size: 1.1rem; /* Tamaño de fuente del precio */
            color: #007bff; /* Color azul para el precio */
        }
        /* Estilos para la página de productos */
        body {
            background-color: #f8f9fa; /* Color de fondo suave */
        }

        .product-card {
            border-radius: 10px; /* Bordes redondeados para las tarjetas */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra sutil */
            overflow: hidden; /* Ocultar el contenido que sobresalga */
            transition: transform 0.2s ease-in-out; /* Transición de transformación */
        }

        .product-card:hover {
            transform: translateY(-5px); /* Elevar ligeramente la tarjeta al pasar el mouse */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Aumentar la sombra al pasar el mouse */
        }

        .product-image {
            width: 100%;
            height: 200px; /* Ajustar la altura según tus necesidades */
            object-fit: cover; /* Ajustar la imagen para cubrir el área */
        }

        .product-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .product-price {
            color: #343a40; /* Color del precio */
            font-weight: bold;
            font-size: 1.2rem;
        }

        .product-details {
            padding: 15px;
        }

        .filter-options {
            margin-bottom: 20px;
        }

        .filter-options select {
            width: 350px;
        }

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
        .jumbotron {
            background-color: transparent; /* Fondo transparente */
            color: #ffffff; /* Texto inicial en blanco */
            padding: 4rem 2rem; /* Ajuste de espaciado interno */
        }
        .transparent-bg {
            background-color: rgba(255, 255, 255, 0.7); /* Fondo blanco con transparencia */
            padding: 2rem; /* Espaciado interno */
            border-radius: 30px; /* Bordes redondeados */
        }
        .filter-options {
            background-color: #f8f9fa; /* Fondo gris claro */
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
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

    <div class="container my-5 transparent-bg">
        <h1 class="text-center mb-4">Nuestros Productos</h1>

        <!-- Opciones de filtro -->
        <div class="container py-5">
            <div class="filter-options">
                <form method="GET" action="productos.php">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <select class="form-select" name="category" id="categoryFilter">
                                <option value="0" <?= !isset($_GET['category']) || $_GET['category'] == 0 ? 'selected' : '' ?>>Todas las Categorías</option>
                                <option value="1" <?= isset($_GET['category']) && $_GET['category'] == 1 ? 'selected' : '' ?>>Ropa</option>
                                <option value="2" <?= isset($_GET['category']) && $_GET['category'] == 2 ? 'selected' : '' ?>>Adornos</option>
                                <option value="3" <?= isset($_GET['category']) && $_GET['category'] == 3 ? 'selected' : '' ?>>Lectura de Cartas</option>
                                <option value="4" <?= isset($_GET['category']) && $_GET['category'] == 4 ? 'selected' : '' ?>>Otros Productos</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <input class="form-control" type="search" name="search" placeholder="Buscar productos..." aria-label="Buscar">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-block bg-gradient-success">Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contenedor de productos -->
        <div class="container py-5">
        <div class="row" id="productContainer">
            <?php
            // Conexion a la base de datos
            include 'includes/database.php';
            // Incluir el archivo de funciones
            require_once 'includes/funciones.php';
            $category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;
            $search = isset($_GET['search']) ? $_GET['search'] : '';

            $sql = "SELECT * FROM productos WHERE nombre LIKE ?";

            if ($category_id != 0) {
                $sql .= " AND categoria_id = ?";
            }

            $stmt = $conn->prepare($sql);
            $search_param = '%' . $search . '%';
            
            if ($category_id != 0) {
                $stmt->bind_param("si", $search_param, $category_id);
            } else {
                $stmt->bind_param("s", $search_param);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card product-card">
                            <img src="<?php echo htmlspecialchars($row['imagen']); ?>" class="card-img-top product-image" alt="<?php echo htmlspecialchars($row['nombre']); ?>">
                            <div class="card-body product-details">
                                <h5 class="card-title product-title"><?php echo htmlspecialchars($row['nombre']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['descripcion']); ?></p>
                                <p class="card-text product-price"><strong>$<?php echo number_format($row['precio'], 2); ?></strong></p>
                                <a href="producto.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Ver Producto</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-12"><p class="text-center">No se encontraron productos.</p></div>';
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
    
</div>
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>