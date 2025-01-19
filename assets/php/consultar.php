<?php
require '../vendor/autoload.php';
require_once "../assets/php/connect.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    if (isset($_POST["mes"]) && !empty($_POST["mes"])) {
        $mes = strtolower($_POST["mes"]);
        $tabla_mes = "datos_2025_" . $mes;

        $result = $conn->query("SHOW TABLES LIKE '$tabla_mes'");
        if ($result->num_rows === 1) {
            $sql = "SELECT * FROM $tabla_mes";
            $result_data = $conn->query($sql);

            if ($result_data->num_rows > 0) {
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                $sheet->setCellValue('A1', 'Cédula');
                $sheet->setCellValue('B1', 'Nombre');
                $sheet->setCellValue('C1', 'Día');
                $sheet->setCellValue('D1', 'Mes');
                $sheet->setCellValue('E1', 'Monto');

                $row = 2;
                while ($data = $result_data->fetch_assoc()) {
                    $sheet->setCellValue("A$row", $data['cedula']);
                    $sheet->setCellValue("B$row", $data['nombre']);
                    $sheet->setCellValue("C$row", $data['dia']);
                    $sheet->setCellValue("D$row", $mes);
                    $sheet->setCellValue("E$row", $data['monto']);
                    $row++;
                }
                $writer = new Xlsx($spreadsheet);
                $filename = "datos_$mes.xlsx";

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header("Content-Disposition: attachment; filename=\"$filename\"");
                $writer->save("php://output");
            } else {
                echo "No hay datos disponibles para el mes seleccionado.";
            }
        } else {
            echo "La tabla de datos para el mes seleccionado no existe.";
        }
    } elseif (isset($_POST["cedula"]) && !empty($_POST["cedula"])) {
        $cedula = $_POST["cedula"];

        $meses = [
            "enero", "febrero", "marzo", "abril", "mayo", "junio",
            "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Cédula');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Día');
        $sheet->setCellValue('D1', 'Mes');
        $sheet->setCellValue('E1', 'Monto');

        $row = 2;

        foreach ($meses as $mes) {
            $tabla_mes = "datos_2025_" . $mes;

            $result = $conn->query("SHOW TABLES LIKE '$tabla_mes'");
            if ($result->num_rows === 1) {
                $sql = "SELECT * FROM $tabla_mes WHERE cedula = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $cedula);
                $stmt->execute();
                $result_data = $stmt->get_result();

                if ($result_data->num_rows > 0) {
                    while ($data = $result_data->fetch_assoc()) {
                        $sheet->setCellValue("A$row", $data['cedula']);
                        $sheet->setCellValue("B$row", $data['nombre']);
                        $sheet->setCellValue("C$row", $data['dia']);
                        $sheet->setCellValue("D$row", $mes);
                        $sheet->setCellValue("E$row", $data['monto']);
                        $row++;
                    }
                }
                $stmt->close();
            }
        }

        if ($row > 2) {
            $writer = new Xlsx($spreadsheet);
            $filename = "datos_cedula_$cedula.xlsx";

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            $writer->save("php://output");
        } else {
            echo "No hay datos disponibles para la cédula ingresada.";
        }
    } else {
        echo "Por favor, complete los campos necesarios para la descarga.";
    }

    $conn->close();
    exit();
}
?>
