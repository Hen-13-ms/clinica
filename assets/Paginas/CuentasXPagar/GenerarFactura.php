<?php
error_reporting(0); //Quita las alvertencias de la ppagina


// Verificar si se recibió el ID del paciente a eliminar
if(isset($_POST['IdCuentaXPagar'])) {
    // Obtener el ID del paciente a eliminar
    $IdFacturaPorPagar= $_POST['IdCuentaXPagar'];
    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "clinica_opti";
                    
                    // Crear conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

    // Consulta SQL para eliminar el paciente
    $sql = "DELETE FROM cuentaxpagar WHERE IdCuentaXPagar = $IdFacturaPorPagar";
    $result = $conn->query($sql);
}

$nombre = $_POST['nombre']; //Esto es proveedor
$NFactura = $_POST['Nfactura'];

$Monto = $_POST['monto'];
$Impuesto = $_POST['impuestos'];

$fechaCreacion = $_POST['fecha'];
$FechaHastaPagar = $_POST['fechaHastaPagar'];
$metodoPago = $_POST['metodoPago'];

$TotalAPagar   = $_POST['TotalAPagar'];
$PagoRealizado = $_POST['PagoRealizado'];
$PagoADevolver = $_POST['PagoADevolver']; //Monto Faltante a pagar (RestanteAPagar)
// $notasdeldoctor = $_POST['notasAdicionalesForm'];

if ($PagoADevolver > 0){
    // Obtener el ID del paciente a eliminar
    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "clinica_opti";
                    
                    // Crear conexión
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    $insertar = "INSERT INTO cuentaxpagar (
                        NDeFactura, Proveedor, Fecha, FechaHastaPagar, Monto, MetodoDePago, Impuestos, Estado, TotalApagar,  PagoRealizado, RestanteAPagar
                    ) VALUES (
                        '$NFactura', '$nombre','$fechaCreacion', '$FechaHastaPagar', '$Monto', '$metodoPago', '$Impuesto','', '$PagoADevolver', '$PagoRealizado', '$PagoADevolver'
                    )";
            
                    if ($conn->query($insertar) === TRUE) {
                        echo "Registro insertado correctamente";
                    } else {
                        echo "Error: " . $insertar . "<br>" . $conn->error;
                    }
}

// Verificar si se recibieron datos POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Iterar sobre los datos recibidos
    foreach ($_POST as $key => $value) {
        
        // Verificar si la clave comienza con "fila" (que indica que es una fila enviada desde el formulario)
        if (strpos($key, 'fila') === 0) {
            // Verificar si la fila ya ha sido recibida anteriormente
            if (!in_array($value, $filasUnicas)) {
                // Si la fila es única, procesarla y mostrarla
                echo "<!--Fila recibida: $value <br>-->";
                // Agregar la fila al array de filas únicas
                $filasUnicas[] = $value;
            }
        }
    }
} else {
    // Si no se recibieron datos POST, mostrar un mensaje de error
    echo "No se recibieron datos POST.";
}

file_put_contents('log.txt', print_r($_POST, true) . PHP_EOL, FILE_APPEND);


// Suponiendo que hay una conexión a la base de datos establecida previamente
// y que $conexion es el objeto de conexión a la base de datos.

$servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "clinica_opti";
                        
                        // Crear conexión
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        
                        // Verificar la conexión
                        if ($conn->connect_error) {
                            die("Conexión fallida: " . $conn->connect_error);
                        } 
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Punto de Venta</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');
        body {
            font-family: 'Ubuntu', sans-serif;
            margin: 0;
            padding: 0;
        }
                /* Ajuste de tamaño de página para impresión */
                @page {
            size: 140mm 199mm; /* 5.51" x 7.83" */
            margin: 0;
        }

        .factura {
            width: 140mm;
            height: 350mm;
            margin: 0 auto;
            padding: 10mm;
            border: 1px solid #ccc;
            /* border-radius: 5px; */
            box-sizing: border-box;
        }

        .encabezado {
            text-align: left;
            margin-bottom: 10mm;
        }

        h1{
            text-align: center;
        }

        .cliente, .productos, .total {
            margin-bottom: 10mm;
        }

        .doctor, .productos, .total {
            margin-bottom: 10mm;
        }

        table {
            width: 50px;
            border-collapse: collapse;
        }

        table, th, td {

            /* border: 1px solid #ccc; */
            margin-left: -10px;
            width: 50mm;
        }

        th, td {
            padding: 5px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .total {
            text-align: right;
        }

        .total p {
            font-weight: bold;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            width: 300px;
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            font-size: 14px;
            border: 0px solid #5c6bc0;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #5c6bc0;
            color: white;
            border-radius: 10px;
        }
        td {
            /* border-radius: 5px; */
        }
</style>
</head>

<body>
    <div class="factura">
        <div class="encabezado">
            <h1 class="h1">(NOMBRE DE LA CLINICA)</h1>
            <h1 class="h1">Factura de Venta</h1>
            <p>Sucursal.:</p>
            <p>Fecha.: <?php echo date("d/m/Y"); ?></p>
            <!-- <p>Fecha de Expiración.: <?php echo $fechaExpiracion; ?></p> -->
            <p>RNC.: </p>
            <p>Número de Factura.: <?php echo $NFactura; ?></p>
            <p style="text-align: center;"><strong>.:Factura para uso interno:.</strong></p>

        </div>

        <div class="cliente">
            <h2>Información del Proveedor</h2>
            <p><strong>Proveedor:</strong> <?php echo $nombre; ?></p>
            <p><strong>Emision de Factura:</strong> <?php echo $fechaCreacion; ?></p>
            <p><strong>Método de Pago:</strong> <?php echo $metodoPago; ?></p>
            <!-- <p><strong>RNC:</strong> <?php echo $dni; ?></p> -->
        </div>
<p></p>
<p></p>
<p></p>

<!-- Tabla de productos/servicios facturados -->
<h1 style="font-size:17px ; margin-left: 40px; margin-top: 70px; ">Productos/Servicios:</h1>

<?php
$totalDescuento = 0;
// Verificar si hay filas para mostrar
if (!empty($filasUnicas)) {
    // Mostrar la tabla
    echo '<div style="margin-left: -25px; margin-right: 0; margin-top: 25px; font-size:10px;">';
    echo "<table style= max-width: 25%; width:25%; font-size:12px;>";
    echo "<thead><tr><th>Tipo</th><th>Descripción</th><th>Categoría</th><th>Precio</th><th>Cantidad</th><th>Descuento</th><th>Total</th></tr></thead>";
    echo "<tbody>";
    // Iterar sobre las filas únicas y mostrarlas en la tabla
    foreach ($filasUnicas as $fila) {
        // Separar los datos de la fila por las etiquetas </td>
        $datosFila = explode("</td>", $fila);
        // Eliminar el último elemento (columna "Acciones")
        array_pop($datosFila);
        $datosFila = array_map(function($dato) {
            return str_replace('Eliminar', '', $dato);
        }, $datosFila);

        // Extraer el valor del descuento de la fila
        $descuentoUnitario = str_replace('<td>', '', $datosFila[5]); // Ajusta el índice según la posición real de la columna de descuento
        // Extraer el valor de la cantidad de la fila
        $cantidad = str_replace('<td>', '', $datosFila[4]); // Ajusta el índice según la posición real de la columna de cantidad
        
        // Calcular el descuento total multiplicando el descuento unitario por la cantidad
        $descuentoTotal = floatval($descuentoUnitario) * intval($cantidad);
        
        // Sumar el descuento total al total de descuentos
        $totalDescuento += $descuentoTotal;
        // Sumar el descuento al total de descuentos
        // $totalDescuento += floatval($descuento);

        // Reunir los datos nuevamente y mostrar la fila en la tabla
        echo "<tr>" . implode("</td>", $datosFila) . "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo '</div>';
} else {
    // Si no hay filas para mostrar, mostrar un mensaje
    echo "Hasta ahora no hay filas para mostrar.";
}
?>

        <div class="total" style="margin-top: 60px;">
            <h2>Total</h2>
            <p><strong>Monto de Cuenta.:</strong> <?php echo $Monto; ?></p>
            <p><strong>Total a Pagar.:</strong> <?php echo $TotalAPagar; ?></p>
            <p><strong>Pago Realizado.:</strong> <?php echo $PagoRealizado; ?></p>
            <p><strong>Monto Pendiente.:</strong> <?php echo $PagoADevolver; ?></p>
        </div>

    </div>

    <script>
            window.onload = function() {
                window.print();
                window.print();
            };
        </script>

<?php
$filasUnicas = array();

// Verificar si se recibieron datos POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Iterar sobre los datos recibidos
    foreach ($_POST as $key => $value) {
        
        // Verificar si la clave comienza con "fila" (que indica que es una fila enviada desde el formulario)
        if (strpos($key, 'fila') === 0) {
            // Verificar si la fila ya ha sido recibida anteriormente
            if (!in_array($value, $filasUnicas)) {
                // Si la fila es única, procesarla y mostrarla
                echo "<!--Fila recibida: $value <br>-->";
                // Agregar la fila al array de filas únicas
                $filasUnicas[] = $value;
            }
        }
    }
} else {
    // Si no se recibieron datos POST, mostrar un mensaje de error
    echo "No se recibieron datos POST.";
}

file_put_contents('log.txt', print_r($_POST, true) . PHP_EOL, FILE_APPEND);

// Establecer la conexión a la base de datos (reemplaza los valores con los de tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica_opti";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Array para almacenar las claves de las filas procesadas
$filasProcesadas = array(); // Inicializamos un array para almacenar las filas procesadas

foreach ($_POST as $clave => $valor) {
    // Verificar si la fila contiene información de productos/servicios
    if (preg_match('/<td>.*?<\/td>/', $valor)) {
        // Verificar si la fila ya ha sido procesada
        if (in_array($valor, $filasProcesadas)) {
            echo "<!--La fila ya ha sido procesada anteriormente: $valor-->";
            continue; // Saltar a la siguiente iteración del bucle
        }
        
        // Agregar la fila al array de filas procesadas
        $filasProcesadas[] = $valor;

        // Extraer los elementos relevantes de la fila
        preg_match_all('/<td>(.*?)<\/td>/', $valor, $matches);
        
        // Verificar si se encontraron coincidencias y si hay suficientes coincidencias para extraer datos
        if ($matches && count($matches[1]) >= 6) {
            // Capturar los valores extraídos
            $productoServicio = $matches[1][0];
            $descripcion = $matches[1][1];
            $categoria = $matches[1][2];
            $precio = $matches[1][3];
            $cantidad = $matches[1][4];
            $total = $matches[1][5];
            
            // Insertar datos en la base de datos
            $insertar = "INSERT INTO consultasfacturadas (CedulaPaciente,
            NombrePaciente,
            EdadPaciente, 
            FechaConsullta,
            OjoDerechoES, 
            OjoDerechoCIL, 
            OjoDerechoEJE, 
            OjoDerechoADD, 
            OjoDerechoAVv, 
            OjoDerechoDP, 
            OjoIzquierdoES, 
            OjoIzquierdoCIL, 
            OjoIzquierdoEJE, 
            OjoIzquierdoADD, 
            OjoIzquierdoAVv,
            OjoIzquierdoDP,
            TipoProductoServicio, 
            Descripcion, Categoria, 
            Precio, Cantidad, Descuento, 
            DescuentoTota, TotalAPagar,
            PagoDePaciente, MontoADevolver) VALUES ('$cedula',
            '$nombre','$edad',$fechaConsulta,
            '$OjoDerechoES', '$OjoDerechoCIL', 
            '$OjoDerechoEJE', '$OjoDerechoADD','$OjoDerechoAVv', 
            '$OjoDerechoDP', '$OjoIzquierdoES', '$OjoIzquierdoCIL',
            '$OjoIzquierdoEJE', '$OjoIzquierdoADD', '$OjoIzquierdoAVv',
            '$OjoIzquierdoDP','$productoServicio', '$descripcion', 
            '$categoria', '$precio', '$cantidad', '$total',  
            '$totalDescuento','$TotalAPagar', '$PagoRealizado','$PagoADevolver')";

// total es Descuento
            
            if ($conn->query($insertar) === TRUE) {
                echo "Datos insertados correctamente.";
            } else {
                echo "Error al insertar datos: " . $conn->error; 
            }
        } else {
            echo "No se pudieron extraer datos relevantes de la fila: $valor";
        }
    }
}
file_put_contents('log.txt', ''); //Borrar contenido del archivo, para evitar atercados futuros. en almacenamiento y consultas.

// Cerrar la conexión a la base de datos

$conn->close();
?>
</body>
</html>