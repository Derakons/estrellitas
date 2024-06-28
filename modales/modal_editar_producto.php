<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Horizontal Mejorado</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        /* Estilos del modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease-in-out, visibility 0.5s ease-in-out;
        }

        .modal {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            padding: 20px;
            position: relative;
            transform: translateX(-100%);
            transition: transform 0.5s ease-in-out;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5em;
        }

        .modal-close {
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1.5em;
        }

        .modal-body {
            padding: 20px 0;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }

        .modal-footer button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-left: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-footer button:hover {
            background-color: #0056b3;
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal.active .modal-content {
            transform: translateX(0);
        }
    </style>
</head>
<body>
    <!-- Modal Trigger Button -->
    <button id="open-modal" style="padding: 10px 20px; border-radius: 5px; border: none; background: #007bff; color: white; cursor: pointer;">Abrir Modal</button>

    <!-- Modal -->
    <div id="modal" class="modal-overlay">
        <div class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Título del Modal</h2>
                    <button class="modal-close">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Contenido del modal. Aquí puedes poner cualquier texto o elementos HTML que desees.</p>
                </div>
                <div class="modal-footer">
                    <button class="modal-close">Cerrar</button>
                    <button>Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Funcionalidad del modal
        document.getElementById('open-modal').addEventListener('click', function() {
            document.getElementById('modal').classList.add('active');
        });

        document.querySelectorAll('.modal-close').forEach(function(closeButton) {
            closeButton.addEventListener('click', function() {
                document.getElementById('modal').classList.remove('active');
            });
        });
    </script>
</body>
</html>
