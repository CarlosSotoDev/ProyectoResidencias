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
    <title>APA 7</title>
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
                        <a class="nav-link text-white text-center" href="#pagina">Formato de pagina</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#titulo">Titulos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#subtitulo">Subtitulos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#parrafos">Parrafos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#viñetas">Viñetas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#tablas">Tablas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#imgFig">Imagenes y Figuras</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white text-center" href="#referencias">Referencias</a>
                    </li>
                </ul>
            </div>

            <!-- Contenido principal -->
            <div class="col-sm-10 content bg-white p-5 my-5 text-justify">
                <h1 id="anteproyecto">CITADO APA 7° EDICION</h1>
                <p>El anteproyecto es el primer documento que se te solicitará cuando ya estes registrado en Residencias
                    profesionales aqui te eneseñamos como se debe de construir los apartados principales de este
                    documento

                </p>

                <div class="container mt-5">
                    <!-- Formato de Hoja -->
                    <div class="card mb-4" id="pagina">
                        <div class="card-header bg-success text-white ">
                            <h2 class="card-title">Formato APA - Página</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Características de la página según APA 7.ª edición:</h5>
                            <ul>
                                <li><strong>Tamaño de la hoja:</strong> Carta (8.5 x 11 pulgadas).</li>
                                <li><strong>Márgenes:</strong> 1 pulgada (2.54 cm) en todos los lados (superior,
                                    inferior, izquierdo y derecho).</li>
                                <li><strong>Fuente:</strong> Arial, Times New Roman, (Consulte con su asesor asignado
                                    para la fuente requerida, aunque "Arial" es la más común).</li>
                                <li><strong>Interlineado:</strong> Doble espacio en todo el documento.</li>
                                <li><strong>Sangría:</strong> Primera línea de cada párrafo con sangría de 0.5 pulgadas
                                    (1.27 cm).</li>
                                <li><strong>Alineación del texto:</strong> Alineado a la izquierda (no justificar el
                                    texto).</li>
                                <li><strong>Número de página:</strong> En la esquina superior derecha de cada página,
                                    comenzando desde la página del título.</li>
                            </ul>
                        </div>
                    </div>


                    <!-- Título -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="titulo">Formato APA - Título</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Características del título según APA 7.ª edición:</h5>
                            <ul>
                                <li><strong>Formato:</strong> Centrado, en negritas, con mayúscula en cada palabra
                                    importante.</li>
                                <li><strong>Tamaño de letra:</strong> 12 puntos.</li>
                                <li><strong>Fuente:</strong> Arial, Times New Roman, (Esta la pueden consultar con su
                                    asesor asignado para que los oriente con la fuente requerida, puede variar segun el
                                    asesor, pero es mas usada la fuente "Arial")</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Subtitulos -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="subtitulos">Formato APA - Subtítulos</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Características de los subtítulos según APA 7.ª edición:</h5>
                            <p>Usualmente son mas usados los primeros 3 niveles, de igual manera buscar asesoria para
                                saber cuando usarlos segun las preferencias de la institucion</p>
                            <ul>
                                <li><strong>Formato del Nivel 1:</strong> Centrado, en negritas, con mayúscula en cada
                                    palabra importante.</li>
                                <li><strong>Formato del Nivel 2:</strong> Alineado a la izquierda, en negritas, con
                                    mayúscula en cada palabra importante.</li>
                                <li><strong>Formato del Nivel 3:</strong> Alineado a la izquierda, en negritas y
                                    cursiva, con mayúscula en cada palabra importante.</li>
                                <li><strong>Formato del Nivel 4:</strong> Sangría (0.5 pulgadas), en negritas, punto
                                    final, solo la primera palabra en mayúscula.</li>
                                <li><strong>Formato del Nivel 5:</strong> Sangría (0.5 pulgadas), en negritas y cursiva,
                                    punto final, solo la primera palabra en mayúscula.</li>
                                <li><strong>Tamaño de letra:</strong> 12 puntos.</li>
                                <li><strong>Fuente:</strong> Arial, Times New Roman (Consulte con su asesor para la
                                    fuente requerida, aunque "Arial" es la más común).</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Parrafo -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="parrafos">Formato APA - Párrafos</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Características de los párrafos según APA 7.ª edición:</h5>
                            <ul>
                                <li><strong>Formato:</strong> Alineado a la izquierda (TESCO pide los formatos
                                    justificados).</li>
                                <li><strong>Interlineado:</strong> Doble espacio (1.5 líneas en Word).</li>
                                <li><strong>Sangría:</strong> Primera línea de cada párrafo con una sangría de 0.5
                                    pulgadas (1.27 cm).</li>
                                <li><strong>Espaciado:</strong> Sin espacio adicional antes o después de cada párrafo.(0
                                    puntos al Inicio y 0 puntos al final)
                                </li>
                                <li><strong>Tamaño de letra:</strong> 12 puntos.</li>
                                <li><strong>Fuente:</strong> Arial, Times New Roman (Consulte con su asesor para la
                                    fuente requerida, aunque "Arial" es la más común).</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Viñetas -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="viñetas">Formato APA - Viñetas</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Características de las viñetas según APA 7.ª edición:</h5>
                            <ul>
                                <li><strong>Formato de viñetas:</strong> Usar viñetas simples (●) o guiones (-) para
                                    listas no secuenciales.</li>
                                <li><strong>Interlineado:</strong> Doble espacio entre líneas de las viñetas.</li>
                                <li><strong>Sangría:</strong> La primera línea de cada viñeta debe estar alineada con el
                                    margen izquierdo. El texto adicional después de la primera línea debe estar sangrado
                                    0.5 pulgadas (1.27 cm).</li>
                                <li><strong>Tamaño de letra:</strong> 12 puntos.</li>
                                <li><strong>Fuente:</strong> Arial, Times New Roman (Consulte con su asesor para la
                                    fuente requerida, aunque "Arial" es la más común).</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Tablas -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="tablas">Formato APA - Tablas</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Características de las tablas según APA 7.ª edición:</h5>
                            <ul>
                                <li><strong>Numeración de Tablas:</strong> Las tablas deben estar numeradas en orden
                                    consecutivo (Tabla 1, Tabla 2, etc.).</li>
                                <li><strong>Titulo de la Tabla:</strong> El título de la tabla debe colocarse en la
                                    parte superior izquierda y sin punto final</li>
                                <li><strong>Estructura del Titulo:</strong> El titulo debe de Tener el Numero de tabla,
                                    El contenido de la tabla, fuente , lugar de donde se saco la misma, y autor entre
                                    parentesis(Si la tabla es de auditoria propia, se coloca el mensaje de "Elaboración
                                    propia")</li>
                                <li><strong>Alineación:</strong> Todo el contenido de la tabla de estar centrado</li>
                                <li><strong>Estilos:</strong> Evita el uso de bordes y líneas interiores; sólo se usan
                                    en la parte superior e inferior de la tabla y debajo de los encabezados.</li>
                                <li><strong>Tamaño de letra:</strong> 12 puntos.</li>
                                <li><strong>Fuente:</strong> Arial, Times New Roman (Consulte con su asesor para la
                                    fuente requerida, aunque "Arial" es la más común).</li>
                            </ul>
                            <h5 class="font-weight-bold">Ejemplo:</h5>
                            <div class="text-center">
                                <img src="../../Assets/IMG/TablaApa.webp" alt="Cronograma" class="text-center">
                            </div>
                        </div>
                    </div>

                    <!-- Imagenes y Figuras -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="imgFig">Formato APA - Imagenes y Figuras</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Características de las Imagenes y Figuras según APA 7.ª
                                edición:</h5>
                            <ul>
                                <li><strong>Numeración de Images/Figuras:</strong> Las Imagenes o Figuras deben estar
                                    numeradas en orden
                                    consecutivo (Imagen 1, Imagen 2, etc.).</li>
                                <li><strong>Titulo de la Imagen/Figura:</strong> El título de las Imagenes o Figuras
                                    debe colocarse en la
                                    parte inferior izquierda y sin punto final</li>
                                <li><strong>Estructura del Titulo:</strong> El titulo debe de Tener el Numero de Imagen
                                    o Figura,
                                    El contenido de la misma, fuente , lugar de donde se saco, y autor entre
                                    parentesis(Si la Imagen o Figura es de auditoria propia, se coloca el mensaje de
                                    "Elaboración
                                    propia")</li>
                                <li><strong>Alineación:</strong> Las imagenes o figuras en formatos mas formales deben
                                    de ser de un tamaño no molesto para los lectores y deben de ser centradas</li>
                                <li><strong>Tamaño de letra:</strong> 12 puntos.</li>
                                <li><strong>Fuente:</strong> Arial, Times New Roman (Consulte con su asesor para la
                                    fuente requerida, aunque "Arial" es la más común).</li>
                            </ul>
                            <h5 class="font-weight-bold">Ejemplo:</h5>
                            <div class="text-center">
                                <img src="../../Assets/IMG/ImgApa.webp" alt="Cronograma" class="text-center">
                            </div>
                        </div>
                    </div>

                    <!-- REFERENCIAS -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h2 class="card-title" id="referencias">Formato APA - Referencias</h2>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-bold">Características de las referencias según APA 7.ª edición:</h5>
                            <ul>
                                <li><strong>Formato de la lista de referencias:</strong> Alineado a la izquierda con
                                    sangría francesa de 0.5 pulgadas (1.27 cm).</li>
                                <li><strong>Orden:</strong> Las referencias deben estar ordenadas alfabéticamente por el
                                    apellido del primer autor.</li>
                                <li><strong>Interlineado:</strong> Doble espacio entre las referencias, sin espacio
                                    adicional entre ellas.</li>
                                <li><strong>Tamaño de letra:</strong> 12 puntos.</li>
                                <li><strong>Fuente:</strong> Arial, Times New Roman (Consulte con su asesor para la
                                    fuente requerida, aunque "Arial" es la más común).</li>
                                <li><strong>Estructura:</strong> Autor o Autores, Año de publicacion de la Investigacion
                                    Publicada, Titulo de la Investigacion, Editorial o Institucion de publicacion, y
                                    opcionalmente las paginas de donde se consulto la informacion</li>
                            </ul>


                            <h5 class="font-weight-bold">Ejemplo:</h5>
                            <div class="text-center">
                                <p><strong>Tejera-Martínez, F., Aguilera, D., & Vílchez-González, J. M. (2020).
                                        Lenguajes de programación y desarrollo de competencias clave. Revisión
                                        sistemática. Revista Electrónica de Investigación Educativa, 22(e27),
                                        1-16.</strong></p>
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