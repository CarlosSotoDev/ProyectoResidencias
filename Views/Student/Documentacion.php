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

// Mensajes de éxito o error al cambiar la contraseña
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
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
    <!-- Modal Cambio Contraseña -->
    <?php require('../../includes/modalCambioContrasena.php'); ?>

    <!-- Página de contenido -->
    <div class="container-fluid page-dashboard bg-white">
        <div class="row">
            <!-- Barra lateral -->
            <div class="col-2 sidebar bg-success d-flex flex-column align-items-center p-3">
                <!-- Aquí va el contenido de la barra lateral -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#portada">Portada</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#indice-general">Indice General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#indice-figuras">Indice de Figuras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#indice-tablas">Indice de Tablas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#introduccion">Introduccion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#planteamiento-problema">Planteamiento del
                            problema</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#justificacion">Justificacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#objetivos">Objetivos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#cronograma">Cronograma de Actividades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#marTeo">Marco Teorico</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#desarrollo">Desarrollo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#conclusiones">Conclusiones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#glosario">Glosario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#bibliografia">Bibliografía</a>
                    </li>
                </ul>
            </div>

            <!-- Contenido principal -->
            <div class="col-sm-10 content bg-white p-5 my-5 text-justify">
                <h1 id="anteproyecto">Documentacion</h1>
                <p>En este documento tendras registro de todos los detalles de tu proyecto y todas las partes que le
                    conforman, desde la portada hasta la referencias, este es el documento más largo en la entrega de tu
                    proyecto, aqui te explicamos como hacer cada uno de los puntos mas importantes
                    recuerda que para elaborar este documento necesitaras del formato <a href="APA7.php">APA 7
                        edicion</a> que dando click en en link te redirigira a los formatos y reglas especificas que tu
                    documento deberá de tener

                </p>

                <div class="container mt-5">
                    <!-- Portada -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="portada">Portada</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>La portada del proyecto debe presentar toda la información esencial que identifique el
                                trabajo de manera clara y profesional. Debe incluir el encabezado institucional y todos
                                los detalles de identificación necesarios.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Una portada es la primera página del proyecto, diseñada
                                    para proporcionar información básica e identificar el trabajo ante la institución.
                                </li>
                                <li><strong>Características de la portada:</strong></li>
                                <ul>
                                    <li><strong>Encabezado escolar:</strong> Tecnológico de Estudios Superiores de
                                        Coacalco.</li>
                                    <li><strong>Logo oficial de la institución:</strong> Incluir el logo en un lugar
                                        visible.</li>
                                    <li><strong>Carrera:</strong> Indicar el nombre de la carrera para la cual se
                                        presenta el proyecto.</li>
                                    <li><strong>Nombre del proyecto:</strong> Título claro y conciso que refleje el
                                        propósito del proyecto.</li>
                                    <li><strong>Quienes presentan el proyecto:</strong> Nombres de los autores o
                                        estudiantes responsables del proyecto.</li>
                                    <li><strong>Fecha:</strong> Fecha en que se presenta o se entrega el proyecto.</li>
                                </ul>
                                <li><strong>Por qué:</strong> La portada ofrece una identificación formal del proyecto y
                                    sus autores, cumpliendo con los requisitos institucionales.</li>
                                <li><strong>Cómo:</strong> Se organiza de forma limpia y estructurada, siguiendo un
                                    orden que facilite la lectura y ubicación de cada elemento.</li>
                            </ul>
                            <h5 class="font-weight-bold">Ejemplo:</h5>
                            <div class="text-center">
                                <img src="../../Assets/IMG/Documentacion/Portada.webp" alt="Cronograma"
                                    class="text-center">
                            </div>
                        </div>
                    </div>


                    <!-- Índice General -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="indice-general">Índice General</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>El índice general muestra una lista de todos los capítulos y secciones del proyecto,
                                facilitando la navegación y organización del documento. Este indice se debe de
                                actualizar al final de la elaboracion de este documento con todos los subtemas y temas
                                dentro del mismo</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Un listado estructurado de todas las partes principales del
                                    proyecto.</li>
                                <li><strong>Por qué:</strong> Permite al lector ubicar rápidamente el contenido y
                                    estructura del proyecto.</li>
                                <li><strong>Cómo:</strong> Se organiza jerárquicamente, indicando el título de cada
                                    sección junto con la página.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Índice de Figuras -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="indice-figuras">Índice de Figuras</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>Este índice enumera todas las figuras utilizadas en el documento, incluyendo
                                ilustraciones, gráficos, o diagramas, proporcionando al lector fácil acceso visual al
                                contenido gráfico. Este indice se debe de actualizar al final de la elaboracion de este
                                documento con todas las imagenes, ilustraciones o figuras dentro del mismo</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Un listado de las figuras con sus títulos y la página en
                                    que se encuentran.</li>
                                <li><strong>Por qué:</strong> Facilita la localización rápida de figuras relevantes para
                                    la interpretación de datos o explicaciones visuales.</li>
                                <li><strong>Cómo:</strong> Se presenta en formato de lista, especificando el número de
                                    figura, título y página.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Índice de Tablas -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="indice-tablas">Índice de Tablas</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>Este índice contiene todas las tablas del documento, detallando su ubicación y contenido
                                de cada una para facilitar el análisis de datos y comparaciones. Este indice se debe de
                                actualizar al final de la elaboracion de este
                                documento con todas tablas presentes dentro del mismo</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Un listado de todas las tablas, incluyendo títulos y número
                                    de página.</li>
                                <li><strong>Por qué:</strong> Permite a los lectores acceder rápidamente a datos
                                    importantes organizados en forma de tabla.</li>
                                <li><strong>Cómo:</strong> Presentado en formato de lista, mostrando el número de tabla,
                                    título y ubicación por página.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Introducción -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="introduccion">Introducción</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>La introducción debe ofrecer una vista general del proyecto, explicando el contexto,
                                propósito y relevancia del tema, sin profundizar en detalles específicos.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Un resumen inicial que contextualiza el proyecto y presenta
                                    los temas principales de forma general.</li>
                                <li><strong>Por qué:</strong> Permite que el lector entienda la importancia y relevancia
                                    del proyecto desde el inicio.</li>
                                <li><strong>Cómo:</strong> La introducción debe ser concisa y no debe exceder una
                                    cuartilla de extensión.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Planteamiento del Problema -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="planteamiento-problema">Planteamiento del Problema</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>El planteamiento del problema describe de manera detallada el problema que el proyecto
                                busca resolver, enfocándose en su origen, impacto y relevancia.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Una descripción precisa del problema que se abordará en el
                                    proyecto, enfatizando por qué es importante resolverlo.</li>
                                <li><strong>Por qué:</strong> Define claramente el problema que motiva la creación del
                                    proyecto, ayudando a justificar la necesidad de una solución.</li>
                                <li><strong>Cómo:</strong> Debe ser un análisis estructurado y no debe exceder una
                                    extensión de cuartilla y media.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Justificación -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="justificacion">Justificación</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>La justificación argumenta la importancia de desarrollar el proyecto, describiendo para
                                quién se realiza y los beneficios que generará.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Una explicación de la importancia y los beneficios del
                                    proyecto, detallando a quién va dirigido.</li>
                                <li><strong>Por qué:</strong> Muestra la relevancia del proyecto, destacando los
                                    beneficios esperados y su impacto positivo.</li>
                                <li><strong>Cómo:</strong> Se presenta de manera detallada y argumentativa, con una
                                    extensión máxima de cuartilla y media.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Objetivos -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="objetivos">Objetivos</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>Los objetivos son metas específicas que se desean alcanzar con el proyecto. Incluyen un
                                objetivo general y tres objetivos específicos que guiarán el desarrollo del proyecto.
                            </p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Objetivo General:</strong> Debe ser una declaración concisa, con un máximo
                                    de tres líneas, que resuma el propósito principal del proyecto.</li>
                                <li><strong>Objetivos Específicos:</strong> Tres objetivos específicos, cada uno con un
                                    máximo de tres líneas, que detallan pasos o metas concretas para alcanzar el
                                    objetivo general.</li>
                                <li><strong>Por qué:</strong> Los objetivos proporcionan una guía clara y específica
                                    para el desarrollo y evaluación del proyecto.</li>
                                <li><strong>Cómo:</strong> Cada objetivo debe ser breve, concreto y alinearse con el
                                    propósito y alcance del proyecto.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Cronograma -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="cronograma">Cronograma de actividades</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>El cronograma define el tiempo estimado para cada fase del proyecto, incluyendo las
                                fechas clave y los plazos de entrega de las distintas tareas y actividades. Ayuda a
                                planificar el trabajo, controlar el progreso y asegurar que el proyecto se complete
                                dentro del plazo estipulado.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Debe especificar las actividades principales del proyecto y
                                    su orden cronológico.</li>
                                <li><strong>Por qué:</strong> Justifica la importancia de seguir un cronograma para
                                    asegurar que el proyecto avance de manera ordenada.</li>
                                <li><strong>Cómo:</strong> Indica cómo se definirán los tiempos y fechas para cada
                                    tarea, estableciendo hitos o entregas parciales.</li>
                                <li><strong>En qué herramientas:</strong> Este se puede realizar en herramientas como
                                    Excel o GantProject.</li>
                            </ul>
                            <h5 class="font-weight-bold">Ejemplo realizado en Excel:</h5>
                            <div class="text-center">
                                <img src="../../Assets/IMG/Cronograma.webp" alt="Cronograma" class="text-center">
                            </div>
                        </div>
                    </div>


                    <!-- Marco Teórico -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="marco-teorico">Marco Teórico</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>El marco teórico es la parte más extensa y fundamental del documento. En esta sección se
                                desarrollan las bases teóricas, conceptos y temas clave que se utilizarán en el
                                proyecto. Proporciona el contexto necesario y detalla los fundamentos que sustentan la
                                investigación.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Es una recopilación y análisis de las teorías,
                                    investigaciones previas, y conceptos relevantes para el desarrollo del proyecto.
                                    Establece el contexto académico y científico necesario para fundamentar el trabajo.
                                </li>
                                <li><strong>Extensión:</strong> Debido a su importancia y complejidad, el marco teórico
                                    debe tener una extensión mínima de 50 cuartillas. La extensión máxima dependerá de
                                    la magnitud de la investigación y la profundidad requerida para abordar los temas.
                                </li>
                                <li><strong>Por qué:</strong> Brinda el sustento teórico necesario para comprender el
                                    problema y las soluciones planteadas en el proyecto. Sin una base teórica sólida, el
                                    proyecto carecería de rigor académico.</li>
                                <li><strong>Cómo:</strong> Toda la información incluida en el marco teórico debe estar
                                    citada correctamente. Las citas y referencias precisas son esenciales, ya que
                                    cualquier omisión de la fuente original puede considerarse plagio, lo cual puede
                                    llevar a la anulación total del trabajo.</li>
                            </ul>
                        </div>
                    </div>


                    <!-- Desarrollo -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="desarrollo">Desarrollo</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>En el apartado de desarrollo se aplican todas las metodologías, temas y conocimientos
                                investigados en el marco teórico, llevando a cabo el proyecto de manera práctica. Es la
                                implementación de cada esquema, metodología y fundamento teórico que se mencionó
                                anteriormente.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Es la sección donde se desarrolla y ejecuta el proyecto en
                                    base a los conceptos, metodologías y teorías planteadas en el marco teórico.</li>
                                <li><strong>Elementos a incluir:</strong> Esta sección debe contener esquemas,
                                    metodologías, capturas de pantalla, imágenes del proyecto en desarrollo, tablas de
                                    datos, y todos los elementos visuales necesarios para ilustrar el avance y
                                    funcionamiento del proyecto.</li>
                                <li><strong>Por qué:</strong> Facilita la comprensión práctica de cómo se implementa la
                                    teoría en el desarrollo real del proyecto, mostrando los resultados visuales y los
                                    pasos fundamentales.</li>
                                <li><strong>Cómo:</strong> Deben evitarse explicaciones excesivamente técnicas como
                                    códigos de programación detallados. Solo se incluirán fragmentos esenciales o de
                                    funciones principales para evitar que el contenido se torne tedioso o complicado.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Conclusiones -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="conclusiones">Conclusiones</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>La sección de conclusiones presenta un resumen de los resultados y aprendizajes obtenidos
                                durante el desarrollo del proyecto. Incluye las observaciones finales, el análisis de
                                los logros alcanzados, así como cualquier limitación o desafío encontrado.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Un análisis reflexivo sobre el proyecto, en el que se
                                    exponen los resultados más relevantes y el impacto de las soluciones implementadas.
                                </li>
                                <li><strong>Por qué:</strong> Permite cerrar el documento evaluando si se lograron los
                                    objetivos planteados y destacando el valor del trabajo realizado.</li>
                                <li><strong>Cómo:</strong> Las conclusiones deben ser claras y objetivas, reflejando de
                                    manera precisa los resultados y aportes del proyecto, sin extenderse demasiado.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Glosario -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="glosario">Glosario</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>El glosario es una sección destinada a explicar palabras o términos técnicos utilizados
                                en el documento, especialmente aquellos que pueden ser difíciles de entender para
                                lectores no especializados en la disciplina.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Una lista de términos acompañados de su definición, con el
                                    objetivo de facilitar la comprensión del contenido técnico del proyecto.</li>
                                <li><strong>Por qué:</strong> Ayuda a los lectores a entender términos especializados,
                                    permitiendo una lectura más fluida y accesible.</li>
                                <li><strong>Cómo:</strong> Los términos deben listarse en orden alfabético, con
                                    definiciones claras y concisas.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bibliografía -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="bibliografia">Bibliografía</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Explicación:</h5>
                            <p>La bibliografía incluye todas las fuentes de información consultadas para la elaboración
                                del proyecto, tales como libros, artículos, documentos académicos y páginas web. Cada
                                fuente debe citarse correctamente para respaldar la información presentada y evitar el
                                plagio.</p>

                            <h5 class="font-weight-bold">Estructura:</h5>
                            <ul>
                                <li><strong>Qué es:</strong> Una lista de referencias utilizadas para construir el marco
                                    teórico y fundamentar el proyecto.</li>
                                <li><strong>Por qué:</strong> Proporciona el debido crédito a los autores y garantiza la
                                    veracidad de la información presentada.</li>
                                <li><strong>Cómo:</strong> Cada referencia debe seguir un formato de citación estándar
                                    (como APA), con los detalles necesarios para que el lector pueda localizar la
                                    fuente.</li>
                            </ul>
                        </div>
                    </div>






                </div>

                <!-- Scripts de Bootstrap -->
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>