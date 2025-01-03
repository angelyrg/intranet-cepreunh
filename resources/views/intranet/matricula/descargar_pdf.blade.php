<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Descargar ficha</title>
    <style>
        * {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
        }

        body {
            margin-top: -7mm;
        }
    
        .document-header-img{
            width: 55%;
            margin-bottom: 2mm;
        }
        .page-title{
            font-size: 14px;
        }
        .page-subtitle{
            font-size: 13px;
        }
        .pdf-header h5{
            margin: 0;
            font-weight: bolder;
        }
        .text-center{
            text-align: center;
        }
        .text-end{
            text-align: right;
        }
        .text-uppercase{
            text-transform: uppercase;
        }
        .text-bold{
            font-weight: bold
        }
        .text_small{
            font-size: 10px;
            font-weight: 400;
            text-transform: capitalize;
            position: relative;
            top: 4px;
        }

        .mb-0{
            margin-bottom: 0;
        }
        .mt-0{
            margin-top: 0;
        }

        .vertical-align-center{
            vertical-align: center;
        }

        .photo_box{
            width: 2.5cm;
            height: 3.5cm;
            border: 1px solid #000;
            margin: 0 auto;
            margin-top: 3mm;
            line-height: 4cm;
            border-radius: 3px;
        }
        .photo_box span {
            font-size: 1.5rem;
            font-weight: 700;
            vertical-align: middle;
            opacity: 0.3;
        }
        .flex{
            display: flex;
            gap: 10px;
        }
        table{
            width: 100%;
            margin-top: 2mm;
        }
        .matricula-table {
            border: 2px solid gray;
            border-radius: 8px;
            background-color: rgba(235, 235, 235, 0.1);
        }
       
        .matricula-table *{
            margin-top: 0;
            vertical-align: top;
            /* border: 1px solid black; */
        }
        .matricula-table tr td:first-child{
            width: 45%;
        }
        td{
            width: auto;
            padding: 0 5px;
            /* border: 1px solid black; */
        }
        .firmas-section > table{
            width: 100%;

        }
        .firmas-section table tr td{
            width: 33%;
        }

        .firma-item {
            height: auto;
            vertical-align: bottom;
        }
        
        .firma-item p {
            margin-top: auto;
        }
        .firma-item .firma_linea{
            width: 90%;
            border-bottom: 1px solid #000;
            margin: 0 auto;
        }


        .firma_postulante_box{
            width: 2.5cm ;
            height: 2.9cm;
            border: 1px solid #000;
            margin: 0 auto;
            border-radius: 3px;
        }
        .legal-section{
            border: 1px solid gray;
            padding: 5px 8px;
            border-radius: 3px;
        }
        .legal-section table tr td{
            border: 1px solid black;
            vertical-align: top;
        }
        .legal-section *{
            font-size: 8px;
        }

        .sello_vb{
            width: 2.7cm;
            height: 2.7cm;
            margin: auto 23%;
        }
    </style>
</head>
<body>
    <div>
        <div class="pdf-header text-center">
            <img class="document-header-img" src="{{ $document_header }}" alt="" srcset="">
            <h5 class="page-title">FICHA DE INSCRIPCIÓN</h5>
            <h5 class="page-subtitle text-uppercase">{{ $matricula->ciclo?->descripcion; }}</h5>
            <div class="photo_box">
                <span>FOTO</span>
            </div>
        </div>
        <table class="matricula-table">
            <tr>
                <td>
                    <div>
                        <table>
                            <tr>
                                <td class="text-end">NOMBRES:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->estudiante->nombres; }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">APELLIDOS:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->estudiante->apellido_paterno; }} {{ $matricula->estudiante->apellido_materno; }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">DNI:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->estudiante->nro_documento; }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">ÁREA:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->area?->descripcion ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">CARRERA:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->carrera?->descripcion ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">SEDE:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->sede?->descripcion ?? '' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <div>
                        <table>
                            <tr>
                                <td class="text-end">AULA:</td>
                                <td class="text-uppercase text-bold vertical-align-center">
                                    {{ $matricula->aulas->first()?->aula->descripcion ?? '' }}
                                    <small class="text_small">(Hasta examen de ubicación)</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">CONCEPTO DE PAGO:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->pagos->first()?->descripcion_pago ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">MONTO NETO:</td>
                                <td class="text-uppercase text-bold">
                                    S/{{ $matricula->pagos->first()?->monto_neto ?? '' }}
                                </td>
                            </tr>
                            @if ($matricula->pagos->first()?->condicion_pago)  
                            <tr>
                                <td class="text-end">CONDICIÓN DE PAGO:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->pagos->first()?->condicion_pago ?? '' }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-end">MODALIDAD DE MATRÍCULA:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->modalidad_matricula }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end">MODALIDAD DE ESTUDIO:</td>
                                <td class="text-uppercase text-bold">
                                    {{ $matricula->modalidad_estudio }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <div class="firmas-section">
            <table>
                <tr>
                    <td class="firma-item">
                        <div class="firma_postulante_box"></div>
                        <p class="text-center"><small>Huella digital</small></p>
                    </td>
                    <td class="firma-item">
                        <div class="firma_linea"></div>
                        <p class="text-center">FIRMA DEL POSTULANTE</p>
                    </td>
                    <td class="firma-item ">
                        <div class="firma_linea">
                            @if (strtoupper($matricula->modalidad_matricula) === 'VIRTUAL')
                            <img class="sello_vb" src="{{ $sello_VB }}" alt="">
                            @endif
                        </div>
                        <p class="text-center">CEPRE UNH</p>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="legal-section">
            <div>
                <strong>DECLARO BAJO JURAMENTO QUE:</strong>
                <ul class="mt-0">
                    <li>
                        Toda la información a registrar en el formulario de inscripción es verdadera y de mi entera
                        responsabilidad
                    </li>
                    <li>
                        Conozco y acepto todas las disposiciones del reglamento específico de CEPRE-UNH, al cual me
                        someto.
                    </li>
                    <li>
                        No soy condenado por el delito de terrorismo apología al terrorismo en cualquiera de sus
                        modalidades.
                    </li>
                    <li>
                        No tengo sanción de impedimento de postular u otras medidas disciplinarias en la UNH u otra
                        universidad del
                        país.
                    </li>
                    <li>
                        Autorizo a la Universidad Nacional de Huancavelica, el uso de mis datos personales y la
                        información
                        proporcionada, para
                        los fines que estime conveniente.
                    </li>
                </ul>
            </div>

            <div>
                <strong>DERECHOS Y DEBERES DEL ESTUDIANTE:</strong>
                <br>
                <strong>Todo estudiante de la Institución tiene derecho a:</strong>
                <ol type="a" class="mt-0 mb-0">
                    <li>
                        Recibir una educación científica, humanística y con valores.
                    </li>
                    <li>
                        Exigir el cumplimiento de los contenidos del compendio académico.
                    </li>
                    <li>
                        Participar responsable y objetivamente en la evaluación académica de la plana docente.
                    </li>
                    <li>
                        Recibir los compendios académicos, de acuerdo a la modalidad de
                        inscripción en cada ciclo académico, siempre que no adeude por ningún
                        servicio a la institución.
                    </li>
                    <li>
                        Hacer uso de los ambientes y servicios que brinda la Institución dentro de
                        los horarios establecidos.
                    </li>
                </ol>
                <strong>Todo estudiante del CEPRE – UNH, tiene las siguientes obligaciones:</strong>
                <ol type="a" class="mt-0">
                    <li>
                        Asistir puntualmente a clases de acuerdo al horario, turno y aula
                        correspondiente, aseado y vestido adecuadamente.
                    </li>
                    <li>
                        Por ningún motivo este permitido cambio de aulas una vez designados
                        mediante el examen de ubicación.
                    </li>
                    <li>
                        Rendir examen de ubicación, examen semanal académico (ESA) y
                        simulacro programadas en forma obligatoria.
                    </li>
                    <li>
                        Estudiar e investigar los temas de acuerdo al avance del curso.
                    </li>
                    <li>
                        Participar activamente en las sesiones de aprendizaje (clases, exámenes
                        y/o seminarios).
                    </li>
                    <li>
                        Respetar a los integrantes de la Institución: Miembros del directorio,
                        docentes, administrativos, vigilantes y estudiantes.
                    </li>
                    <li>
                        Practicar la solidaridad y armonía entre los estudiantes.
                    </li>
                    <li>
                        Mantener buen comportamiento dentro del aula, sala de lectura y demás
                        ambientes de la Institución.
                    </li>
                    <li>
                        Hacer uso adecuado y responsable de la biblioteca central de la UNH.
                    </li>
                    <li>
                        Pagar oportunamente por derecho de inscripción, matricula y enseñanza
                        en el CEPRE-UNH, pudiendo ser el pago al 100% o en dos cuotas con
                        recargo.
                    </li>
                    <li>
                        Cancelar la segunda cuota de pago al 100% antes del primer examen de
                        selección.
                    </li>
                    <li>
                        Cuidar los ambientes, mobiliarios y material bibliográfico de la Institución.
                    </li>
                    <li>
                        Presentar justificaciones (Por los padres o un documento escrito) por falta
                        y tardanzas.
                    </li>
                    <li>
                        No fomentar, desorden, escándalos u otro acto que atente contra los
                        derechos de la Institución.
                    </li>
                    <li>
                        Asistir más de 70% de las clases programadas para tener derecho a
                        exámenes de vacantes programados.
                    </li>
                    <li>
                        No está permitido la devolución de pago una vez realizado la inscripción.
                    </li>
                    <li>
                        Conocer y cumplir el presente reglamento y guía del estudiante con el
                        objeto de favorecer su formación académica y personal.
                    </li>
                </ol>
            </div>

        </div>
        @if ($matricula->pagos->first()?->condicion_pago != 'Cancelado')
        <div>
            <small>
                <strong>NOTA.</strong> Los estudiantes que tienen pendiente la segunda cuota, la fecha límite de pago es 15/01/2024.
            </small>
        </div>
        @endif
        <p>
            Fecha de impresión: {{ now()->format('d/m/Y h:i:sA') }}
        </p>

    </div>

</body>
</html>