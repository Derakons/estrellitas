<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar {
            background-color: transparent !important; /* Fondo transparente */
            box-shadow: none; /* Sin sombra */
        }
        .navbar-brand {
            font-family: 'UnifrakturMaguntia', cursive;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transform: scale(1.4);
        }
        .btn-app {
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
        .navbar-brand .fa-star {
            margin-right: 4px; /* Espacio entre el icono y el texto */
            color: #ffd700; /* Color dorado para la estrella */
        }

        /* Estilos adicionales para navbar */
        .navbar-nav .nav-item {
            padding: 0 10px;
            transition: background-color 0.3s;
        }
        .navbar-nav .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .navbar-nav .nav-link {
            color: #fff;
            transition: color 0.3s;
        }
        .navbar-nav .nav-link:hover {
            color: #39ff14; /* Cambia el color al verde */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
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
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['usuario_id'])) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            <?php echo $_SESSION['usuario_nombre']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="pedidos.php"><i class="fas fa-clipboard-list"></i> Mis Pedidos</a></li>
                            <li><a class="dropdown-item" href="perfil.php"><i class="fas fa-user-edit"></i> Mi Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
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
<script>
    // Script para cambiar el color del texto al hacer hover
    var navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(function(navLink) {
        navLink.addEventListener('mouseover', function() {
            this.style.color = '#39ff14'; // Color verde al hacer hover
        });
        navLink.addEventListener('mouseout', function() {
            this.style.color = '#fff'; // Restaura el color original al salir
        });
    });

    // Script para animación al desplegar menú dropdown
    var dropdownToggles = document.querySelectorAll('.navbar-nav .dropdown-toggle');
    dropdownToggles.forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            var dropdownMenu = this.nextElementSibling;
            dropdownMenu.classList.toggle('show'); // Añade clase 'show' para animación de despliegue
        });
    });
</script>

</body>
</html>
