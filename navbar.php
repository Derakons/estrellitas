<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .navbar-custom {
            background-color: transparent !important;
            box-shadow: none;
        }
        .navbar-custom .navbar-brand {
            font-family: 'UnifrakturMaguntia', cursive;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transform: scale(1.4);
        }
        .navbar-custom .btn-app {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            font-size: 15px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transform: scale(0.8);
        }
        .navbar-custom .navbar-brand .fa-star {
            margin-right: 4px;
            color: #ffd700;
        }

        .navbar-custom .dropdown-menu {
            border: none;
            background-color: #333;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            display: none; /* Ocultar inicialmente */
        }
        .navbar-custom .dropdown-item {
            color: #fff;
            transition: background-color 0.3s;
        }
        .navbar-custom .dropdown-item:hover {
            background-color: #555;
        }
        .navbar-custom .dropdown-menu.show {
            display: block; /* Mostrar el menú cuando la clase 'show' está presente */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-star"></i>Estrellitas
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="productos.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacto.php">Contacto</a>
                </li>
            </ul>
            <form class="d-flex" action="productos.php" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Buscar productos..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['usuario_id'])) : ?>
                    <?php if (isset($_SESSION['es_administrador']) && $_SESSION['es_administrador'] = 1) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Admin</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <?php echo $_SESSION['usuario_nombre']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="pedidos.php"><i class="fas fa-clipboard-list"></i> Mis Pedidos</a></li>
                            <li><a class="dropdown-item" href="perfil.php"><i class="fas fa-user-edit"></i> Mi Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if (isset($_SESSION['es_administrador']) && $_SESSION['es_administrador'] == 1) : ?>
                                <li><a class="dropdown-item" href="admin.php"><i class="fas fa-cogs"></i> Panel de Administrador</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php"><i class="fas fa-user-plus"></i> Registrarse</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="btn btn-app bg-success" href="carrito.php">
                        <i class="fas fa-shopping-cart"></i>
                        Carrito
                        <?php if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) > 0) : ?>
                            <span class="badge bg-teal"><?php echo count($_SESSION['carrito']); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script> 
</body>
</html>
