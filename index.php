<?php
// Incluye la configuración global usando una ruta relativa directamente
include('includes/config.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Trámites</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>styles.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Main Content -->
    <div class="container mt-1 flex-grow-1 container-content">
        <h1 class="text-center">TRÁMITES</h1>

        <!-- Tramites Section -->
        <div class="accordion mt-3" id="tramitesAccordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Inscripciónes
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#tramitesAccordion">
                    <div class="card-body">
                        <h1>Proceso de Inscripción en el Tecnológico de Estudios Superiores de Coacalco (TESCo)</h1>

                        <p class="parrafo"><strong>1. Consulta de Convocatoria:</strong> La convocatoria para el proceso de inscripción
                            se publica en el portal oficial
                            <a href="https://tescoacalco.edomex.gob.mx" target="_blank">TESCo</a> en las fechas
                            establecidas. Es fundamental estar pendiente de la página para cualquier
                            actualización. Dentro de la convocatoria, se detallan todas las instrucciones necesarias
                            para continuar con el proceso.
                        </p>

                        <p class="parrafo"><strong>2. Registro en línea:</strong> Una vez publicada la convocatoria, se debe completar
                            el formulario de preinscripción en línea en el portal de TESCo,
                            proporcionando los datos personales y académicos requeridos.</p>

                        <p class="parrafo"><strong>3. Pago de la ficha:</strong> Posterior al registro, realiza el pago correspondiente
                            para obtener la ficha de examen de admisión, siguiendo las
                            instrucciones especificadas en la convocatoria.</p>

                        <p class="parrafo"><strong>4. Examen de admisión:</strong> Presenta el examen en la fecha y lugar indicados en
                            la convocatoria. Los resultados del examen determinarán si puedes
                            avanzar en el proceso de inscripción.</p>

                        <p class="parrafo"><strong>5. Entrega de documentos:</strong> Si eres aceptado, deberás entregar en la oficina
                            de control escolar los documentos solicitados, tales como acta de
                            nacimiento, certificado de bachillerato, CURP, y el comprobante de pago de la inscripción.
                        </p>

                        <p class="parrafo"><strong>6. Pago de inscripción:</strong> Realiza el pago de la inscripción y las cuotas
                            correspondientes, siguiendo las indicaciones que se proporcionan en
                            la convocatoria.</p>

                        <p class="parrafo"><strong>7. Asignación de horario:</strong> Una vez completado el proceso de inscripción, se
                            te asignará un horario para el semestre que está por iniciar.</p>

                        <p class="parrafo"><strong>8. Inicio de clases:</strong> Finalmente, comenzarás tus clases en la fecha
                            establecida en el calendario académico de TESCo.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Reinscripción
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#tramitesAccordion">
                    <div class="card-body">
                        <h1>Proceso de Reinscripción en el Tecnológico de Estudios Superiores de Coacalco (TESCo)</h1>

                        <p class="parrafo"><strong>1. Consulta de Convocatoria:</strong> La convocatoria para el proceso de
                            reinscripción se publica en el portal oficial
                            <a href="https://tescoacalco.edomex.gob.mx" target="_blank">TESCo</a> en las fechas
                            establecidas. Es fundamental revisar la página para cualquier
                            actualización. La convocatoria incluye todas las instrucciones necesarias para llevar a cabo
                            la reinscripción.
                        </p>

                        <p class="parrafo"><strong>2. Revisión de Requisitos:</strong> Revisa que cumplas con los requisitos
                            establecidos en la convocatoria, tales como haber aprobado las materias
                            del semestre anterior y estar al corriente en los pagos.</p>

                        <p class="parrafo"><strong>3. Pago de Reinscripción:</strong> Realiza el pago correspondiente a la reinscripción
                            en las fechas indicadas, siguiendo las instrucciones
                            especificadas en la convocatoria. Asegúrate de conservar el comprobante de pago.</p>

                        <p class="parrafo"><strong>4. Actualización de Datos:</strong> En caso de ser necesario, actualiza tus datos
                            personales y académicos en el sistema de gestión escolar a través
                            del portal de TESCo.</p>

                        <p class="parrafo"><strong>5. Asignación de Horario:</strong> Después de realizar el pago, se te asignará un
                            horario para el semestre que está por iniciar, según la disponibilidad
                            de los grupos y las materias.</p>

                        <p class="parrafo"><strong>6. Inicio de Clases:</strong> Una vez completado el proceso de reinscripción,
                            comenzarás tus clases en la fecha establecida en el calendario académico
                            de TESCo.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Constancias
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                    data-parent="#tramitesAccordion">
                    <div class="card-body">
                        <h1>Trámite para Obtener Constancias Escolares en TESCo</h1>

                        <p class="parrafo"><strong>1. Consulta de Requisitos:</strong> Visita el portal oficial de TESCo o acude a la
                            oficina de control escolar para conocer los requisitos y documentos necesarios para
                            solicitar una constancia escolar. Asegúrate de cumplir con todos los requisitos antes de
                            proceder con la solicitud.</p>

                        <p class="parrafo"><strong>2. Generación de la Línea de Captura:</strong> Después de consultar los requisitos,
                            debes generar la línea de captura para el pago de derechos. Para ello, accede al portal de
                            Servicios al Contribuyente del Estado de México <a
                                href="https://sfpya.edomexico.gob.mx/recaudacion/" target="_blank">aquí</a> y sigue las
                            instrucciones para generar el concepto de pago correspondiente a la constancia escolar.</p>

                        <p class="parrafo"><strong>3. Pago de la Línea de Captura:</strong> Realiza el pago de la línea de captura en
                            cualquiera de las opciones habilitadas, como bancos o tiendas de conveniencia. Asegúrate de
                            conservar el comprobante de pago.</p>

                        <p class="parrafo"><strong>4. Validación del Pago en el Departamento de Contabilidad:</strong> Lleva el
                            comprobante de pago al departamento de contabilidad de TESCo para que validen el pago. El
                            departamento de contabilidad sellará y firmará el comprobante una vez que la validación sea
                            exitosa.</p>

                        <p class="parrafo"><strong>5. Solicitud de la Constancia:</strong> Con el comprobante de pago validado y sellado
                            por el departamento de contabilidad, dirígete a la oficina de control escolar para realizar
                            la solicitud formal de la constancia. Presenta el comprobante junto con el formulario de
                            solicitud.</p>

                        <p class="parrafo"><strong>6. Tiempo de Entrega:</strong> La constancia escolar suele entregarse en un plazo de
                            3 a 5 días hábiles, dependiendo de la carga de trabajo de la oficina. Te notificarán cuando
                            esté lista para recogerla.</p>

                        <p class="parrafo"><strong>7. Recogida de la Constancia:</strong> Una vez que tu constancia esté lista, podrás
                            recogerla en la oficina de control escolar. Asegúrate de llevar una identificación oficial
                            para la entrega del documento.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingFour">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Servicio Social
                        </button>
                    </h2>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#tramitesAccordion">
                    <div class="card-body">
                        <h1>Proceso para Realizar el Servicio Social en TESCo</h1>

                        <p class="parrafo"><strong>1. Consulta de Requisitos:</strong> Visita la oficina de servicio social o consulta
                            el portal oficial de TESCo para conocer los requisitos necesarios para iniciar el servicio
                            social. Generalmente, debes haber cubierto un porcentaje específico de tus créditos
                            académicos (por lo general, entre el 70% y 80%).</p>

                        <p class="parrafo"><strong>2. Selección de Programa:</strong> Revisa los programas y proyectos de servicio
                            social disponibles que estén vinculados con tu carrera. Elige el programa que más se ajuste
                            a tus intereses y al perfil de tu carrera.</p>

                        <p class="parrafo"><strong>3. Solicitud de Carta de Presentación:</strong> Una vez seleccionado el programa,
                            debes solicitar en la oficina de servicio social una carta de presentación dirigida a la
                            institución, empresa u organización donde realizarás tu servicio social.</p>

                        <p class="parrafo"><strong>4. Entrega de Documentos en la Institución Receptora:</strong> Lleva la carta de
                            presentación junto con otros documentos requeridos (como copias de tu identificación y
                            historial académico) a la institución, empresa u organización donde realizarás el servicio
                            social.</p>

                        <p class="parrafo"><strong>5. Inicio del Servicio Social:</strong> Una vez aceptado, comenzarás tu servicio
                            social en la institución receptora. Es importante llevar un registro de tus actividades y
                            cumplir con las horas requeridas (por lo general, 480 horas).</p>

                        <p class="parrafo"><strong>6. Entrega de Reportes Periódicos:</strong> Durante el periodo de servicio social,
                            debes entregar reportes periódicos a la oficina de servicio social de TESCo, donde
                            documentes tus actividades y el progreso del servicio.</p>

                        <p class="parrafo"><strong>7. Solicitud de Carta de Liberación:</strong> Al finalizar el servicio social,
                            solicita a la institución receptora una carta de terminación o constancia de cumplimiento.
                            Con este documento, acude a la oficina de servicio social de TESCo para solicitar la carta
                            de liberación del servicio social.</p>

                        <p class="parrafo"><strong>8. Entrega de la Carta de Liberación:</strong> Finalmente, entrega la carta de
                            liberación junto con otros documentos requeridos a la oficina de servicio social para
                            concluir oficialmente el proceso.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingFive">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Residencias
                        </button>
                    </h2>
                </div>
                <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#tramitesAccordion">
                    <div class="card-body">
                        <h1>Requisitos para Residencias Profesionales en TESCo</h1>

                        <p class="parrafo"><strong>Ser estudiante regular:</strong> Estar inscrito en el TESCo y tener un buen historial
                            académico, sin adeudos de materias ni sanciones disciplinarias.</p>

                        <p class="parrafo"><strong>Haber cubierto al menos el 80% de los créditos:</strong> Debes haber completado al
                            menos el 80% de los créditos de tu plan de estudios. Este porcentaje puede variar
                            dependiendo de la carrera, por lo que es importante verificarlo con tu coordinación
                            académica.</p>

                        <p class="parrafo"><strong>Constancia de no adeudo:</strong> Debes presentar una constancia que acredite que no
                            tienes adeudos financieros ni de materiales con el instituto.</p>

                        <p class="parrafo"><strong>Formato de solicitud de residencias profesionales:</strong> Completar y presentar el
                            formato oficial de solicitud de residencias profesionales, disponible en la oficina de
                            servicio social y residencias o en el portal del TESCo.</p>

                        <p class="parrafo"><strong>Carta de postulación:</strong> Solicitar una carta de postulación, que es emitida por
                            la coordinación académica, dirigida a la empresa o institución donde realizarás las
                            residencias.</p>

                        <p class="parrafo"><strong>Carta de aceptación de la empresa o institución:</strong> Obtener una carta de
                            aceptación por parte de la empresa o institución donde se llevarán a cabo las residencias.
                            Esta carta debe estar firmada por el representante legal o el responsable del área.</p>

                        <p class="parrafo"><strong>Programa de trabajo:</strong> Presentar un programa de trabajo que especifique las
                            actividades a realizar durante las residencias, así como los objetivos, cronograma y
                            metodología.</p>

                        <p class="parrafo"><strong>Seguro de estudiante:</strong> Contar con un seguro médico vigente durante el periodo
                            de las residencias. Generalmente, el seguro facultativo del IMSS o un seguro particular es
                            aceptable.</p>

                        <p class="parrafo"><strong>Currículum vitae:</strong> Presentar un currículum vitae actualizado, que incluya tus
                            datos personales, formación académica, habilidades, y cualquier experiencia laboral o
                            práctica profesional relevante.</p>

                        <p class="parrafo"><strong>Reporte mensual:</strong> Estar dispuesto a entregar reportes mensuales de las
                            actividades realizadas, según las indicaciones de la coordinación de residencias
                            profesionales.</p>

                        <p class="parrafo"><strong>Informe final de residencias:</strong> Al concluir las residencias, deberás entregar
                            un informe final que describa las actividades realizadas, los logros obtenidos, y una
                            evaluación personal de la experiencia.</p>

                        <h2>Anexos:</h2>
                        <ul>
                            <li class="elemento_Listas_Parrafo"><a href="https://tescoacalco.edomex.gob.mx/sites/tescoacalco.edomex.gob.mx/files/files/residencias%20profesionales/PO-VI-TESCO-03_Acreditacion%20de%20Residencia%20Profesional%20%20V5a.docx"
                                    target="_blank">Subproceso de Acreditación de Residencia Profesional
                                    PO-VI-TESCO-03</a></li>
                            <li class="elemento_Listas_Parrafo"><a href="https://tescoacalco.edomex.gob.mx/sites/tescoacalco.edomex.gob.mx/files/files/residencias%20profesionales/FO-TESCo-36%20Control%20Mensual%20de%20Asistencias%20a%20la%20Empresa%20de%20Residencias%20Profesionales%20V4.docx"
                                    target="_blank">FO-TESCo-36: Control Mensual de Asistencias a la Empresa de
                                    Residencias Profesionales</a></li>
                            <li class="elemento_Listas_Parrafo"><a href="https://tescoacalco.edomex.gob.mx/sites/tescoacalco.edomex.gob.mx/files/files/residencias%20profesionales/FO-TESCo-41%20Reporte%20Mensual%20de%20Asesorias%20de%20Residencia%20Profesional%20V4.docx"
                                    target="_blank">FO-TESCo-41: Reporte Mensual de Asesorías de Residencias
                                    Profesionales</a></li>
                            <li class="elemento_Listas_Parrafo"><a href="https://tescoacalco.edomex.gob.mx/sites/tescoacalco.edomex.gob.mx/files/files/residencias%20profesionales/FO-TESCo-71%20Anteproyecto%20de%20Residencia%20Profesional%20V3.docx"
                                    target="_blank">FO-TESCo-71: Anteproyecto de Residencias Profesionales</a></li>
                            <li class="elemento_Listas_Parrafo"><a href="https://tescoacalco.edomex.gob.mx/sites/tescoacalco.edomex.gob.mx/files/files/residencias%20profesionales/FO-TESCo-72%20Formato%20de%20Solicitud%20de%20Residencias%20Profesionales%20V3.docx"
                                    target="_blank">FO-TESCo-72: Solicitud de Residencias Profesionales</a></li>
                            <li class="elemento_Listas_Parrafo"><a href="https://tescoacalco.edomex.gob.mx/sites/tescoacalco.edomex.gob.mx/files/files/residencias%20profesionales/MANUAL%20DE%20LINEAMIENTOS%20TecNM.pdf"
                                    target="_blank">Lineamiento para la Operación y Acreditación de la Residencia
                                    Profesional</a></li>
                            <li class="elemento_Listas_Parrafo"><a href="https://tescoacalco.edomex.gob.mx/sites/tescoacalco.edomex.gob.mx/files/files/residencias%20profesionales/ANEXO%20XXIX_%20FORMATO%20DE%20EVALUACI%C3%93N%20Y%20SEGUIMIENTO%20DE%20RESIDENCIA%20PROFESIONAL.docx"
                                    target="_blank">Anexo XXIX: Formato de evaluación y seguimiento de Residencia
                                    Profesional</a></li>
                            <li class="elemento_Listas_Parrafo"><a href="https://tescoacalco.edomex.gob.mx/sites/tescoacalco.edomex.gob.mx/files/files/residencias%20profesionales/ANEXO%20XXX_%20FORMATO%20DE%20EVALUACI%C3%93N%20DE%20REPORTE%20DE%20RESIDENCIA%20PROFESIONAL.docx"
                                    target="_blank">Anexo XXX: Formato de evaluación de reporte de Residencia
                                    Profesional</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingSix">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Titulación
                        </button>
                    </h2>
                </div>
                <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#tramitesAccordion">
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut
<<<<<<< HEAD
                        labore et dolore magna aliua.
=======
                        labore et dolore magna alqua.
>>>>>>> features/Carlos
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
