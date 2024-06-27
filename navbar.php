<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css"> 
    <title>AstroShop - Barra de Navegación</title>
    <style>
/* Estilo de texto de neón */
#headerText {
    font-size: 2.5em; /* Tamaño del texto */
    color: #fff; /* Color inicial */
    text-align: center; /* Centrado del texto */
    
    text-shadow:
        0 0 5px rgba(255, 255, 255, 0.5),
        0 0 10px rgba(255, 255, 255, 0.7),
        0 0 15px rgba(255, 255, 255, 0.9),
        0 0 20px #39ff14,
        0 0 40px #39ff14,
        0 0 60px #39ff14,
        0 0 80px #39ff14,
        0 0 100px #39ff14;
    transition: color 1s ease, text-shadow 1s ease; /* Transición suave */
    display: inline-block; /* Inline block para centrar */
    position: relative; /* Posición relativa para la animación */
}

/* Animación de neón */
@keyframes neonGlow {
    0%, 100% {
        text-shadow:
            0 0 5px rgba(255, 255, 255, 0.5),
            0 0 10px rgba(255, 255, 255, 0.7),
            0 0 15px rgba(255, 255, 255, 0.9),
            0 0 20px #39ff14,
            0 0 40px #39ff14,
            0 0 60px #39ff14,
            0 0 80px #39ff14,
            0 0 100px #39ff14;
    }
    50% {
        text-shadow:
            0 0 5px rgba(255, 255, 255, 0.5),
            0 0 10px rgba(255, 255, 255, 0.7),
            0 0 15px rgba(255, 255, 255, 0.9),
            0 0 20px #ff00ff,
            0 0 40px #ff00ff,
            0 0 60px #ff00ff,
            0 0 80px #ff00ff,
            0 0 100px #ff00ff;
    }
}

/* Aplicación de la animación */
#headerText.neon {
    animation: neonGlow 1s ease-in-out infinite alternate;
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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">

        <a id="headerText" class="neon" href="index.php" >    <i class="fas fa-star" ></i>Estrellitas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">

                <li class="nav-item ">
                    <a class="nav-link" href="productos.php">Productos</a>
                </li>

                    <a class="nav-link" href="contacto.php">Contacto</a> </li>
            </ul>
            <form class="d-flex" action="productos.php" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Buscar productos..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <ul class="navbar-nav me-auto" id="mainNav">

                <?php if (isset($_SESSION['usuario_id'])) : ?>
                    <li class="nav-item dropdown">
                        <br>
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
                        <br>
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
                        <br>
                    </li>
                    <li class="nav-item">
                        <br>
                        <a class="nav-link" href="registro.php"><i class="fas fa-user-plus"></i> Registrarse</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <br>
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
<script>
    // Función para cambiar el color del texto con efecto de neón
    function cambiarColorTexto() {
        var headerText = document.getElementById('neon');
        var colores = ['#39ff14', '#ff00ff', '#00ffff', '#ffff00', '#ff4500', '#0000ff', '#ff1493']; // Lista de colores a utilizar
        var indiceColor = 0;

        setInterval(function() {
            var colorActual = colores[indiceColor];
            var sombra = '';

            switch(colorActual) {
                case '#39ff14': // Verde neón
                    sombra = `
                        0 0 5px rgba(255, 255, 255, 0.5),
                        0 0 10px rgba(255, 255, 255, 0.7),
                        0 0 15px rgba(255, 255, 255, 0.9),
                        0 0 20px #39ff14,
                        0 0 40px #39ff14,
                        0 0 60px #39ff14,
                        0 0 80px #39ff14,
                        0 0 100px #39ff14;`;
                    break;
                case '#ff00ff': // Magenta
                    sombra = `
                        0 0 5px rgba(255, 255, 255, 0.5),
                        0 0 10px rgba(255, 255, 255, 0.7),
                        0 0 15px rgba(255, 255, 255, 0.9),
                        0 0 20px #ff00ff,
                        0 0 40px #ff00ff,
                        0 0 60px #ff00ff,
                        0 0 80px #ff00ff,
                        0 0 100px #ff00ff;`;
                    break;
                case '#00ffff': // Cyan
                    sombra = `
                        0 0 5px rgba(255, 255, 255, 0.5),
                        0 0 10px rgba(255, 255, 255, 0.7),
                        0 0 15px rgba(255, 255, 255, 0.9),
                        0 0 20px #00ffff,
                        0 0 40px #00ffff,
                        0 0 60px #00ffff,
                        0 0 80px #00ffff,
                        0 0 100px #00ffff;`;
                    break;
                case '#ffff00': // Amarillo
                    sombra = `
                        0 0 5px rgba(255, 255, 255, 0.5),
                        0 0 10px rgba(255, 255, 255, 0.7),
                        0 0 15px rgba(255, 255, 255, 0.9),
                        0 0 20px #ffff00,
                        0 0 40px #ffff00,
                        0 0 60px #ffff00,
                        0 0 80px #ffff00,
                        0 0 100px #ffff00;`;
                    break;
                case '#ff4500': // Naranja
                    sombra = `
                        0 0 5px rgba(255, 255, 255, 0.5),
                        0 0 10px rgba(255, 255, 255, 0.7),
                        0 0 15px rgba(255, 255, 255, 0.9),
                        0 0 20px #ff4500,
                        0 0 40px #ff4500,
                        0 0 60px #ff4500,
                        0 0 80px #ff4500,
                        0 0 100px #ff4500;`;
                    break;
                case '#0000ff': // Azul
                    sombra = `
                        0 0 5px rgba(255, 255, 255, 0.5),
                        0 0 10px rgba(255, 255, 255, 0.7),
                        0 0 15px rgba(255, 255, 255, 0.9),
                        0 0 20px #0000ff,
                        0 0 40px #0000ff,
                        0 0 60px #0000ff,
                        0 0 80px #0000ff,
                        0 0 100px #0000ff;`;
                    break;
                case '#ff1493': // Rosa neón
                    sombra = `
                        0 0 5px rgba(255, 255, 255, 0.5),
                        0 0 10px rgba(255, 255, 255, 0.7),
                        0 0 15px rgba(255, 255, 255, 0.9),
                        0 0 20px #ff1493,
                        0 0 40px #ff1493,
                        0 0 60px #ff1493,
                        0 0 80px #ff1493,
                        0 0 100px #ff1493;`;
                    break;
            }

            headerText.style.color = colorActual;
            headerText.style.textShadow = sombra;

            indiceColor = (indiceColor + 1) % colores.length; // Avanza al siguiente color
        }, 1000); // Cambia cada 1 segundo (1000 milisegundos)
    }

    // Llama a la función al cargar la página
    window.onload = cambiarColorTexto;
</script>

</body>
</html>