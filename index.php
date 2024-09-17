<?php
error_reporting(0);
session_start();
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica_opti";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}



// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    
    $email = $_POST["email"];
    $cedula = $_POST["cedula"];
    $telefono = $_POST["telefono"];
    session_start();
    // Realizar la consulta a la base de datos para verificar si existe un registro con los datos proporcionados
    $sql = "SELECT * FROM empleados WHERE Email = '$email' AND Cedula = '$cedula' AND Phone = '$telefono'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Redirigir al usuario a la página de actualización de contraseña
        header("Location: ActualizarContrasena.php?email=$email&cedula=$cedula&telefono=$telefono");
        exit();

    } else {
// Si no se encuentra un registro, almacenar el mensaje en una variable de sesión
session_start();
$_SESSION["error_message"] = "Los datos proporcionados no coinciden con ningún registro.";
header("Location: #forgotPasswordModal"); // Redirigir al modal
exit();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <link rel="stylesheet" href="http://localhost:8080/Clinica_Optica/assets/css/style_login.css"> <!-- Sin el puerto no funciona -->
    
     <style>
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 10px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 50px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <title>Login-Opticlin</title> 
                     
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            
                <form action="confirmarRegistro.php" method="post" onsubmit="return validateForm()">
                <h1 style="margin-top: 15px;">Crear Cuenta</h1>

                <span>Ingresa los siguientes datos...</span>
                <!-- <input type="text" placeholder="ID" name="ID"> -->
                <input style="font-weight: bold;" type="text" placeholder="Nombres" name="nombres" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')">
                <input style="font-weight: bold;" type="text" placeholder="APellidos" name="apellidos" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')">
                <input style="font-weight: bold;" type="text" placeholder="Cedula" name="cedula" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')">                
                <input style="font-weight: bold;" id="usuario" type="email" placeholder="Email" name="usuario" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')">

                <select style="font-weight: bold;" name="departamento" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')">
                <option value="">Departamento/Cargo</option>
                <option value="Encargado">Encargado</option>
                <option value="Secretaria">Secretaria</option>
                <option value="Doctor">Doctor</option>
                <!-- Agrega más opciones según sea necesario -->
                </select>

                <input style="font-weight: bold;" type="text" placeholder="Direccion de Residencia" name="direccion" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')"> 
                <input style="font-weight: bold;" type="text" placeholder="Telefono" name="telefono" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')">
                <input style="font-weight: bold;" id="password" type="password" placeholder="Contraseña" name="password" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')">
                <input style="font-weight: bold;" id="codigo" type="password" placeholder="Codigo de Acceso Proporciodado" required oninvalid="this.setCustomValidity('¡Código incorrecto!')" oninput="this.setCustomValidity('')" oninput="validateCode(this)" >

                <script>
                function validateCode(input) {
                var validCodes = ["codigo1", "codigo2", "codigo3"]; // Aquí puedes agregar los códigos válidos
                var inputValue = input.value.trim();
                if (!validCodes.includes(inputValue)) {
                input.setCustomValidity('¡Código incorrecto!');
                } else {
                input.setCustomValidity('');
                }
                }
                function validateForm() {
                var passwordInput = document.getElementById("codigo");
                validateCode(passwordInput); // Ejecutar la validación del código antes de enviar el formulario
                return passwordInput.checkValidity(); // Devolver si el formulario es válido o no
                }
                </script>
                
                <button type=submit>Registrarme</button>

                </form method="post" action="">
                </div>
                
                <div class="form-container sign-in">

                <form  action="confirmar.php" method="post">
                <h1>Iniciar sesión</h1>
                <a style="font-weight: bold;">Ingresa tus Credenciales...</a>

               <input style="font-weight: bold;" id="usuario" type="email" placeholder="Email" name="usuario" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')">  <!-- el name es como nombre de variables -->
                <input style="font-weight: bold;" id="password" type="password" placeholder="Contraseña" name="password" required oninvalid="this.setCustomValidity('¡Este Campo es Requerido!')" oninput="this.setCustomValidity('')">
                <a href="" style="font-weight: bold;" onclick="showModal('forgotPasswordModal'); return false;">¿Olvidades tu contraseña?</a>

                <button name="btnEntrar">Entrar</button>
                <!-- onclick="redireccion()" -->
            </form>


            
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>¡Bienvenido otra vez!</h1>
                    <p>Regístrese con sus datos personales para utilizar el sitio</p>
                    <button class="hidden" id="login">Iniciar sesión</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>¡Bienvenido otra vez!</h1>
                    <p>Regístrese con sus datos personales para utilizar el sitio</p>
                    <button class="hidden" id="register">Registrarse</button>
                </div>
            </div>
        </div>

<!-- <div id="updatePasswordModal" class="modal">
            <div class="modal-content">
                <span class="close" style="font-size: 35px;">&times;</span>
                <h1>Actualizar Contraseña</h1>
                <p style="font-weight: bold;">Ingresa tu nueva contraseña.</p>
                <form action="#" method="post">
                    <input type="password" placeholder="Nueva Contraseña" required>
                    <input type="password" placeholder="Confirmar Contraseña" required>
                    <button type="submit">Actualizar Contraseña</button>
                </form>
            </div>
        </div> -->


        <div id="forgotPasswordModal" class="modal">
            <div class="modal-content">
            <span class="close" style="font-size: 35px;" >&times;</span>
            <h1>¿Olvidaste tu contraseña?</h1>
            <p style="font-weight: bold;">Ingresa tu Correo electrónico, Cédula y Número de Telefono para restablecer tu contraseña.</p>
            <?php
            session_start();
             if (isset($_SESSION["error_message"])) {
            echo "<p style=\"color: red; font-weight: bold;\">".$_SESSION["error_message"]."</p>";
            unset($_SESSION["error_message"]); // Limpiar la variable de sesión
            }
            ?>
            <form action="#" method="post">
                <input style="font-weight: bold;" type="email" name="email" placeholder="Correo Electrónico" required>
                <input style="font-weight: bold;" type="text"  name="cedula" placeholder="Cédula de Identidad (Sin Guiones)" required>
                <input style="font-weight: bold;" type="text"  name="telefono" placeholder="Número de Telefono" required>

                <button type="submit">Enviar</button>
            </form>
            </div>
            </div>

    <script src="script-login.js"></script>
    <script>
        // Función para mostrar el modal
        function showModal(modalId) {
            var modal = document.getElementById(modalId);
            
            modal.style.display = "block";

            // Cuando el usuario hace clic en (x), cierra el modal
            var closeButton = modal.getElementsByClassName("close")[0];
            closeButton.onclick = function() {
                modal.style.display = "none";
            };

            // Cierra el modal cuando el usuario hace clic fuera de él
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
        }

        // Función para mostrar el modal cuando se hace clic en "Olvidaste tu contraseña"
        document.querySelector("a.forgot-password").addEventListener("click", function(event) {
            event.preventDefault();
            showModal("forgotPasswordModal");
        });
    </script>
</body>
</html>