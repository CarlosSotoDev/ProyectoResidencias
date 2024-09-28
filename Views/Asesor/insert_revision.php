<?php
include('../../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comentario = $_POST['comentario'];
    $fecha_proxima_revision = $_POST['fecha_proxima_revision'];
    $fecha_revision_actual = date('Y-m-d');
    $id_proyecto = $_POST['id_proyecto'];

    // Obtener el id_conexion relacionado al proyecto
    $queryConexion = "SELECT ID_Conexion FROM conproyectorevisiones WHERE ID_Proyecto = ?";
    $stmtConexion = $connection->prepare($queryConexion);
    $stmtConexion->bind_param("i", $id_proyecto);
    $stmtConexion->execute();
    $resultConexion = $stmtConexion->get_result();

    // Definir la fecha actual antes de usarla
    $fecha_actual = date('Y-m-d');

    if ($resultConexion->num_rows > 0) {
        $conexion = $resultConexion->fetch_assoc();
        $id_conexion = $conexion['ID_Conexion'];

        // Insertar la nueva revisión
        $insertQuery = "INSERT INTO revisiones (ID_Conexion, Comentario, Fecha_Revision, Fecha_Proxima_Revision) 
                        VALUES (?, ?, ?, ?)";
        $stmtInsert = $connection->prepare($insertQuery);
        $stmtInsert->bind_param("isss", $id_conexion, $comentario, $fecha_revision_actual, $fecha_proxima_revision);
        if ($stmtInsert->execute()) {
            // Obtener todas las revisiones actualizadas para este ID_Conexion
            $queryRevisiones = "SELECT ROW_NUMBER() OVER (ORDER BY Fecha_Revision ASC) AS Revision_Numero, Comentario, Fecha_Revision, Fecha_Proxima_Revision 
                                FROM revisiones WHERE ID_Conexion = ?";
            $stmtRevisiones = $connection->prepare($queryRevisiones);
            $stmtRevisiones->bind_param("i", $id_conexion);
            $stmtRevisiones->execute();
            $resultRevisiones = $stmtRevisiones->get_result();

            // Generar y devolver las filas de la tabla con los botones "Ver Comentario" y aplicar las clases de colores a las fechas
            while ($revision = $resultRevisiones->fetch_assoc()) {
                $fecha_proxima_revision = $revision['Fecha_Proxima_Revision'];
                $clase_fecha = '';

                if ($fecha_proxima_revision < $fecha_actual) {
                    $clase_fecha = 'text-danger'; // Fecha pasada: rojo
                } elseif ($fecha_proxima_revision == $fecha_actual) {
                    $clase_fecha = 'text-success'; // Fecha actual: verde
                } else {
                    $clase_fecha = 'text-warning'; // Fecha futura: amarillo
                }

                echo "<tr>";
                echo "<td>" . htmlspecialchars($revision['Revision_Numero']) . "</td>";
                echo "<td><button class='btn btn-info ver-comentario' data-comentario='" . htmlspecialchars($revision['Comentario']) . "'>Ver Comentario</button></td>";
                echo "<td>" . htmlspecialchars($revision['Fecha_Revision']) . "</td>";
                echo "<td class='" . $clase_fecha . "'>" . htmlspecialchars($revision['Fecha_Proxima_Revision']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "Error al insertar la revisión.";
        }
    } else {
        // Si no se encuentra la conexión, agregamos una conexión para el proyecto en conproyectorevisiones
        $queryInsertConexion = "INSERT INTO conproyectorevisiones (ID_Proyecto) VALUES (?)";
        $stmtInsertConexion = $connection->prepare($queryInsertConexion);
        $stmtInsertConexion->bind_param("i", $id_proyecto);
        if ($stmtInsertConexion->execute()) {
            $id_conexion = $connection->insert_id; // Obtener el ID de conexión recién creado

            // Ahora que tenemos la nueva conexión, repetir la inserción de la revisión
            $insertQuery = "INSERT INTO revisiones (ID_Conexion, Comentario, Fecha_Revision, Fecha_Proxima_Revision) 
                            VALUES (?, ?, ?, ?)";
            $stmtInsert = $connection->prepare($insertQuery);
            $stmtInsert->bind_param("isss", $id_conexion, $comentario, $fecha_revision_actual, $fecha_proxima_revision);
            if ($stmtInsert->execute()) {
                // Obtener todas las revisiones actualizadas para este ID_Conexion
                $queryRevisiones = "SELECT ROW_NUMBER() OVER (ORDER BY Fecha_Revision ASC) AS Revision_Numero, Comentario, Fecha_Revision, Fecha_Proxima_Revision 
                                    FROM revisiones WHERE ID_Conexion = ?";
                $stmtRevisiones = $connection->prepare($queryRevisiones);
                $stmtRevisiones->bind_param("i", $id_conexion);
                $stmtRevisiones->execute();
                $resultRevisiones = $stmtRevisiones->get_result();

                // Generar y devolver las filas de la tabla
                while ($revision = $resultRevisiones->fetch_assoc()) {
                    $fecha_proxima_revision = $revision['Fecha_Proxima_Revision'];
                    $clase_fecha = '';

                    if ($fecha_proxima_revision < $fecha_actual) {
                        $clase_fecha = 'text-danger'; 
                    } elseif ($fecha_proxima_revision == $fecha_actual) {
                        $clase_fecha = 'text-success';
                    } else {
                        $clase_fecha = 'text-warning';
                    }

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($revision['Revision_Numero']) . "</td>";
                    echo "<td><button class='btn btn-info ver-comentario' data-comentario='" . htmlspecialchars($revision['Comentario']) . "'>Ver Comentario</button></td>";
                    echo "<td>" . htmlspecialchars($revision['Fecha_Revision']) . "</td>";
                    echo "<td class='" . $clase_fecha . "'>" . htmlspecialchars($revision['Fecha_Proxima_Revision']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "Error al insertar la revisión en la nueva conexión.";
            }
        } else {
            echo "Error al crear la nueva conexión para el proyecto.";
        }
    }
}
