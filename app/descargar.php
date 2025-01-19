<?php
require_once "../assets/php/connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dia = isset($_POST["dia"]) ? intval($_POST["dia"]) : null;
    $mes = isset($_POST["mes"]) ? strtolower($_POST["mes"]) : null;

    if (!empty($mes)) {
        $tabla_mes = "datos_2025_" . $mes;

        $query_check_table = "SHOW TABLES LIKE '$tabla_mes'";
        $result_check_table = $conn->query($query_check_table);

        if ($result_check_table->num_rows > 0) {
            if (!empty($dia)) {
                $sql = "SELECT * FROM $tabla_mes WHERE dia = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $dia);
            } else {
                $sql = "SELECT * FROM $tabla_mes";
                $stmt = $conn->prepare($sql);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                header("Content-Type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=datos_$mes.xls");

                echo "ID\tCedula\tNombre\tDia\tMes\tNinos\tOfrenda\tProtemplo\tObra Social\tAyuda Pastoral\n";

                while ($row = $result->fetch_assoc()) {
                    echo $row["id"] . "\t" .
                         $row["cedula"] . "\t" .
                         $row["nombre"] . "\t" .
                         $row["dia"] . "\t" .
                         $row["mes"] . "\t" .
                         $row["ninos"] . "\t" .
                         $row["ofrenda"] . "\t" .
                         $row["protemplo"] . "\t" .
                         $row["obra_social"] . "\t" .
                         $row["ayuda_pastoral"] . "\n";
                }
                exit();
            } else {
                echo "no se encontraron datos";
            }
        } else {
        }
    } else {
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/descargar.css">
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-btn">
                <a href="app.php">Agregar</a>
                <a href="descargar.php">Descargar</a>
                <a href="consultar.html">Consultar</a>
            </div>
        </div>
    </footer>
    <main>
        <header>
            <div class="header-container">
                <h1>Casa de la Verdad</h1>
                <div class="header-btn">
                    <a href="app.php">Agregar</a>
                    <a href="descargar.php">Descargar</a>
                    <a href="consultar.html">Consultar</a>
                </div>
                <a onclick="abrir_pop()" class="salir-btn" href="#">CERRAR</a>
            </div>
        </header>

        <div class="consultar-sec">
            <div class="consultar-sec-container">
                <h1>Descargar</h1>
            <form method="POST" action="descargar.php">
                <label for="dia">Día:</label>
                <input type="number" id="dia" name="dia" min="1" max="31"><br><br>
        
                <label for="mes">Mes:</label>
                <select id="mes" name="mes" required>
                    <option value="">Seleccione un mes</option>
                    <option value="Enero">Enero</option>
                    <option value="Febrero">Febrero</option>
                    <option value="Marzo">Marzo</option>
                    <option value="Abril">Abril</option>
                    <option value="Mayo">Mayo</option>
                    <option value="Junio">Junio</option>
                    <option value="Julio">Julio</option>
                    <option value="Agosto">Agosto</option>
                    <option value="Septiembre">Septiembre</option>
                    <option value="Octubre">Octubre</option>
                    <option value="Noviembre">Noviembre</option>
                    <option value="Diciembre">Diciembre</option>
                </select>
        
                <div class="btn-consultar">
                    <button type="submit">Descargar</button>
                </div>
            </form>
            </div>
        </div>
    </main>
</body>
</html>