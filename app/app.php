<?php
require_once "../assets/php/connect.php";
$mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula = $_POST["cedula"];
    $nombre = $_POST["nombre"];
    $dia = $_POST["dia"];
    $mes = $_POST["mes"];
    $anio = $_POST["anio"];
    $ninos = $_POST["ninos"];
    $ofrenda = $_POST["ofrenda"];
    $protemplo = $_POST["protemplo"];
    $obra_social = $_POST["obra_social"];
    $ayuda_pastoral = $_POST["ayuda_pastoral"];
    $sql_check_usuario = "SELECT cedula FROM usuarios WHERE cedula = '$cedula'";
    $result = $conn->query($sql_check_usuario);

    if ($result->num_rows > 0) {
    } else {
        $sql_usuario = "INSERT INTO usuarios (cedula, nombre) VALUES ('$cedula', '$nombre')";
        if ($conn->query($sql_usuario) !== TRUE) {
            $mensaje = "<script>errorEnviar();</script>";
            exit();
        }
    }
    $tabla_mes = "datos_2025_" . strtolower($mes);

    $sql_insert_data = "INSERT INTO $tabla_mes (cedula, nombre, dia, mes, ninos, ofrenda, protemplo, obra_social, ayuda_pastoral) 
                        VALUES ('$cedula', '$nombre', '$dia', '$mes', '$ninos', '$ofrenda', '$protemplo', '$obra_social', '$ayuda_pastoral')";

    if ($conn->query($sql_insert_data) === TRUE) {
        $mensaje = "<script>enviado();</script>";
    } else {
        $mensaje = "<script>errorEnviar();</script>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa de la Verdad</title>
    <link rel="stylesheet" href="../assets/css/app.css">
    <script src="https://kit.fontawesome.com/6378b72010.js" crossorigin="anonymous"></script>
    <script>
        function enviado() {
            var enviado = document.getElementById('info-ok');
            enviado.style.top = "10vh";
        }   
        function errorEnviar() {
            var errorEnviar = document.getElementById('info-error');
            errorEnviar.style.top = "10vh";
        }    
        function closemsg_ok() {
            var closemsg_ok = document.getElementById('info-ok');
            closemsg_ok.style.top = "-100vh";
        }  
        function closemsg_error() {
            var closemsg_error = document.getElementById('info-error');
            closemsg_error.style.top = "-100vh";
        }   
    </script>
</head>
<body>
    <div id="info-ok" class="info">
        <div class="info-container">
            <div class="info-icon">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div class="info-msg">
                <p>Datos enviados correctamente</p>
            </div>
            <div class="title-close">
                <a onclick="closemsg_ok()" href="#">x</a>
            </div>
        </div>
    </div>
    <div id="info-error" class="info">
        <div class="info-container">
            <div class="info-title">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div class="info-msg">
                <p>Error al enviar los datos</p>
            </div>
            <div class="title-close">
                <a onclick="closemsg_error()" href="#">x</a>
            </div>
        </div>
    </div>

    <main>
        <header>
            <div class="header-container">
                <h1>Casa de la Verdad</h1>
                <div class="header-btn">
                    <a href="app.php">Agregar</a>
                    <a href="descargar.php">Descargar</a>
                    <a href="consultar.html">Consultar</a>
                </div>
                <a class="salir-btn" href="#">CERRAR</a>
            </div>
        </header>

        <?php if (!empty($mensaje)) echo $mensaje; ?>

        <div class="form-sec" id="agregar">
            <div class="form-sec-container">
                <form action="app.php" method="post">
                    <div class="form-sec-groups">
                        <div class="form-group-1 group">
                            <label for="cedula">Cédula:</label>
                            <input type="number" id="cedula" name="cedula" required>

                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" maxlength="255" required>
                        </div>
                
                        <div class="form-group-2 group">
                            <label for="dia">Día:</label>
                            <select id="dia" name="dia" required>
                                <option value="">Seleccione un día</option>
                                <?php for ($i = 1; $i <= 31; $i++) echo "<option value='$i'>$i</option>"; ?>
                            </select>

                            <label for="mes">Mes:</label>
                            <select id="mes" name="mes" required>
                                <option value="">Seleccione un mes</option>
                                <option value="enero">Enero</option>
                                <option value="febrero">Febrero</option>
                                <option value="marzo">Marzo</option>
                                <option value="abril">Abril</option>
                                <option value="mayo">Mayo</option>
                                <option value="junio">Junio</option>
                                <option value="julio">Julio</option>
                                <option value="agosto">Agosto</option>
                                <option value="septiembre">Septiembre</option>
                                <option value="octubre">Octubre</option>
                                <option value="noviembre">Noviembre</option>
                                <option value="diciembre">Diciembre</option>
                            </select>

                        </div>
                
                        <div class="form-group-3 group">
                            <label for="anio">Año:</label>
                            <input type="text" id="anio" name="anio" readonly value="2025">

                            <label for="ayuda_pastoral">Ayuda Pastoral:</label>
                            <input type="number" id="ayuda_pastoral" name="ayuda_pastoral" >
                        </div>

                        <div class="form-group-4 group">
                            <label for="ninos">Niños:</label>
                            <input type="number" id="ninos" name="ninos" >

                            <label for="ofrenda">Ofrenda:</label>
                            <input type="number" id="ofrenda" name="ofrenda" >
                        </div>

                        <div class="form-group-5 group">
                            <label for="obra_social">Obra Social:</label>
                            <input type="number" id="obra_social" name="obra_social" >

                            <label for="protemplo">Protemplo:</label>
                            <input type="number" id="protemplo" name="protemplo" >
                        </div>
                    </div>
                    <div class="btn-enviar">
                        <button type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
<script src="../assets/js/functions.js"></script>
</html>
