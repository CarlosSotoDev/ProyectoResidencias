<?php
include('../../includes/config.php');
checkLogin();

$usuario_id = $_SESSION['user_id'];

// Consulta para obtener el proyecto del alumno
$query = "SELECT p.ID_Proyecto, p.Nombre_Proyecto
          FROM proyecto p
          WHERE p.Integrante_1 = ? OR p.Integrante_2 = ? OR p.Integrante_3 = ? LIMIT 1";
$stmt = $connection->prepare($query);
$stmt->bind_param("iii", $usuario_id, $usuario_id, $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificamos si hay un proyecto asignado
if ($result && $result->num_rows > 0) {
    $proyecto = $result->fetch_assoc();
    $_SESSION['id_proyecto'] = $proyecto['ID_Proyecto']; // Guardamos el ID del proyecto en la sesión
    $nombre_proyecto = $proyecto['Nombre_Proyecto'];
} else {
    $_SESSION['id_proyecto'] = null; // No hay proyecto asignado
    $nombre_proyecto = "No hay proyecto asignado";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentacion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>docs.css">
</head>

<body>
    <!-- Navbar -->
    <?php require('../../includes/navbarAlumno.php'); ?>

    <!-- Página de contenido -->
    <div class="container-fluid page-dashboard bg-white">
        <div class="row">
            <!-- Barra lateral -->
            <div class="col-2 sidebar bg-success d-flex flex-column align-items-center p-3">
                <!-- Aquí va el contenido de la barra lateral -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#anteproyecto">Portada</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#titulo">Indice General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#objGen">Indice de Figuras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#objEsp">Indice de Tablas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#acts">Introduccion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#cronograma">Planteamiento del problema</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#cronograma">Justificacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#cronograma">Objetivos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#cronograma">Cronograma de Actividades</a>
                    </li>
                </ul>
            </div>

            <!-- Contenido principal -->
            <div class="col-sm-10 content bg-white p-5 my-5 text-justify">
                <h1 id="anteproyecto">Documentacion</h1>
                <p>En este documento tendras registro de todos los detalles de tu proyecto y todas las partes que le conforman, desde la portada hasta la referencias, este es el documento más largo en la entrega de tu proyecto, aqui te explicamos como hacer cada uno de los puntos mas importantes
                    recuerda que para elaborar este documento necesitaras del formato <a href="APA7.php">APA 7 edicion</a>  que dando click en en link te redirigira a los formatos y reglas especificas que tu documento deberá de tener

                </p>

                <div class="container mt-5">
                    <!-- Título -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="titulo">Título del Proyecto</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>El título del proyecto debe ser claro y conciso, indicando de manera resumida el
                                propósito principal del proyecto. Se deben mencionar las tecnologías principales que se
                                van a utilizar y describir brevemente qué solución o sistema se va a implementar.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Se debe identificar qué es lo que se va a hacer en el
                                    proyecto, por ejemplo, un sistema, un programa, una aplicación, un invento, etc.
                                </li>
                                <li><strong>Por qué:</strong> Se debe justificar por qué es necesario desarrollar este
                                    proyecto, destacando la necesidad o problema que se quiere solucionar.</li>
                                <li><strong>Cómo:</strong> Se debe describir brevemente cómo se llevará a cabo el
                                    proyecto, es decir, las principales tecnologías o métodos que se utilizarán.</li>
                            </ul>

                            <h5 class="font-weight-bold">Ejemplo:</h5>
                            <p><em>Sistema de información web con PHP y MySQL para la gestión de proyectos de
                                    residencias profesionales del Tecnológico de Estudios Superiores de Coacalco.</em>
                            </p>
                        </div>
                    </div>

                    <!-- Objetivo General -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="objGen">Objetivo General</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>El objetivo general describe el propósito principal del proyecto. Es una meta amplia que
                                busca el resultado final del proyecto. Debe centrarse en el "para qué" se está
                                realizando, qué se espera lograr a un nivel global.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Se debe definir de manera general qué se espera lograr con
                                    el proyecto.</li>
                                <li><strong>Por qué:</strong> Se debe explicar la razón o necesidad que motiva la
                                    realización del proyecto.</li>
                                <li><strong>Cómo:</strong> De manera general, describir qué métodos, herramientas o
                                    tecnologías se usarán para alcanzar el objetivo.</li>
                                <li><strong>Inicio</strong> Los objetivos especificos y generales deben de comenzar con
                                    un verbo</li>
                            </ul>

                            <h5 class="font-weight-bold">Ejemplo:</h5>
                            <p><em>Crear e implementar un sistema web que permita gestionar eficientemente los proyectos
                                    de residencias profesionales, facilitando la administración de documentos, el
                                    seguimiento de avances, y la asignación de asesorías mediante el uso de tecnologías
                                    modernas.</em></p>
                        </div>
                    </div>

                    <!-- Objetivos Específicos -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="objEsp">Objetivos Específicos</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>Los objetivos específicos detallan de manera más precisa las metas que se deben alcanzar
                                para cumplir con el objetivo general. Cada objetivo específico corresponde a una tarea o
                                funcionalidad concreta del proyecto. Se dividen en pequeños pasos que, en conjunto,
                                logran el propósito del proyecto.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Define claramente cada funcionalidad o tarea que se va a
                                    desarrollar como parte del proyecto.</li>
                                <li><strong>Por qué:</strong> Justifica la necesidad de cada tarea o funcionalidad,
                                    explicando su importancia dentro del proyecto.</li>
                                <li><strong>Cómo:</strong> Describe brevemente las tecnologías o métodos que se usarán
                                    para realizar esa tarea específica.</li>
                                <li><strong>Inicio</strong> Los objetivos especificos y generales deben de comenzar con
                                    un verbo</li>
                                <li><strong>Cuantos</strong> Aqui tu puedes colocar lo objetivos especificos que
                                    requieras, recuerda que estos tambien se definiran en tu Cronograma(Tambien se
                                    explica como se debe de hacer en el siguiente punto de la pagina)</li>
                            </ul>

                            <h5 class="font-weight-bold">Ejemplos:</h5>
                            <ul>
                                <li> Implementar el backend con PHP y MySQL
                                    para gestionar la lógica de negocio relacionada con los proyectos, usuarios y la
                                    gestión de entregas.</li>
                                <li> Desarrollar el
                                    frontend utilizando HTML, CSS, Bootstrap y JavaScript para crear una interfaz de
                                    usuario intuitiva y responsive.</li>
                                <li>Establecer un sistema de roles y
                                    autenticación que permita a los usuarios acceder a las funcionalidades según su rol
                                    (administrador, asesor, alumno).</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Descripcion detallada de actividades -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="acts">Descripción detallada de las actividades a realizar</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Breve Explicación:</h5>
                            <p>La descripción detallada de las actividades establece los pasos específicos que se deben
                                llevar a cabo para completar el proyecto. Cada actividad debe estar claramente definida,
                                con objetivos y responsabilidades bien establecidos para asegurar que el proyecto avance
                                de manera ordenada y eficiente.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Se debe detallar cada una de las actividades que se
                                    realizarán a lo largo del proyecto, asegurando que todas las fases del desarrollo
                                    estén cubiertas.</li>
                                <li><strong>Por qué:</strong> Explicar por qué es necesario definir claramente las
                                    actividades a realizar, como una forma de asegurar que no se omita ningún paso
                                    importante y de facilitar el seguimiento del progreso.</li>
                                <li><strong>Cómo:</strong> Describir cómo se organizarán las actividades, estableciendo
                                    un orden lógico, identificando dependencias entre tareas y asignando responsables y
                                    fechas para cada una.</li>
                            </ul>

                            <h5 class="font-weight-bold">Ejemplos:</h5>
                            <ul>
                                <li><strong>Análisis de requerimientos:</strong> Recolectar las necesidades de los
                                    usuarios (alumnos, asesores y administradores) y establecer el diseño del sistema.
                                </li>
                                <li><strong>Diseño del sistema:</strong> Definir la arquitectura del sistema, diseñando
                                    tanto el frontend como el backend.</li>
                                <li><strong>Desarrollo del backend:</strong> Implementar las funcionalidades para la
                                    gestión de usuarios y proyectos utilizando PHP y MySQL.</li>
                                <li><strong>Desarrollo del frontend:</strong> Crear una interfaz de usuario responsive y
                                    fácil de usar con HTML, CSS, Bootstrap y JavaScript.</li>
                                <li><strong>Integración del sistema de roles:</strong> Implementar un sistema de
                                    autenticación con roles diferenciados para alumnos, asesores y administradores.</li>
                                <li><strong>Pruebas del sistema:</strong> Realizar pruebas de funcionalidad y carga para
                                    asegurar que el sistema responde correctamente bajo diferentes condiciones.</li>
                                <li><strong>Documentación:</strong> Generar la documentación técnica del sistema para
                                    facilitar futuras modificaciones y mantenimientos.</li>
                            </ul>

                            <h5 class="font-weight-bold">Deben de estar ligadas al Cronograma al igual que los objetivos
                                especificos</h5>
                        </div>
                    </div>

                    <!-- Cronograma -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="cronograma">Cronograma de actividades</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Breve Explicación:</h5>
                            <p>El cronograma define el tiempo estimado para cada fase del proyecto, incluyendo las
                                fechas clave y los plazos de entrega de las distintas tareas y actividades. Ayuda a
                                planificar el trabajo, controlar el progreso y asegurar que el proyecto se complete
                                dentro del plazo estipulado.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Debe especificar las actividades principales del proyecto y
                                    su orden cronológico (Esta vinculado a los objetivos especificos).</li>
                                <li><strong>Por qué:</strong> Justifica la importancia de seguir un cronograma para
                                    asegurar que el proyecto avance de manera ordenada y se cumplan los plazos
                                    establecidos.</li>
                                <li><strong>Cómo:</strong> Indica cómo se definirán los tiempos y fechas para cada
                                    tarea (Pueden ser días, semanas o el periodo te tiempo de preferencia),
                                    estableciendo hitos o entregas parciales, y los métodos que se utilizarán
                                    para monitorear el cumplimiento.</li>
                                <li><strong>En donde se puede realizar:</strong> Este se puede realizar en diferentes
                                    herramientas o plataformas, alguna de ella puede ser Excel o GantProject. Tambien se
                                    puede preguntar al asesor y al departamento de residencias para pedir alguna
                                    sugerencia y si este diagrama es aceptado con dicha tecnologia</li>
                            </ul>
                            <h5 class="font-weight-bold">Ejemplo realizado en Excel:</h5>
                            <div class="text-center">
                                <img src="../../Assets/IMG/Cronograma.webp" alt="" class="text-center">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Scripts de Bootstrap -->
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>