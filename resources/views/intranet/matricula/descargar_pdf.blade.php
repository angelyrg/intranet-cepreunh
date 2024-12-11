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
        .img-unh{
            width: 4cm;
            height: auto;
            margin-bottom: 10px;
        }
        .page-title{
            font-size: 14px;
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

        .photo_box{
            width: 3cm;
            height: 4cm;
            border: 1px solid #000;
            margin: 0 auto;
            margin-top: 20px;
        }
        .flex{
            display: flex;
            gap: 10px;
        }
        table{
            width: 100%;
            margin-top: 20px;
        }
        .matricula-table tr td:first-child{
            width: 40%;
        }
        td{
            width: auto;
            padding: 0 5px;
            /* border: 1px solid black; */
        }

        .firmas-section{
            /* margin-top: 0.3cm; */
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


        .firma_postulante_box{
            width: 2.5cm ;
            height: 3cm;
            border: 1px solid #000;
            margin: 0 auto;
        }


        .legal-section table tr td{
            border: 1px solid black;
            vertical-align: top;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <div>
        <div class="pdf-header text-center">
            <img class="img-unh" src="{{ $unh_logo }}" alt="" srcset="">
            <h5 class="page-title">FICHA DE INSCRIPCIÓN</h5>
            <h5 class="text-uppercase">{{ $matricula->ciclo->tipo_ciclo->descripcion; }}</h5>
            <div class="photo_box"></div>
        </div>
        <table class="matricula-table">
            <tr>
                <td class="text-end">NOMBRES:</td>
                <td>
                    <strong class="text-uppercase">{{ $matricula->estudiante->nombres; }}</strong>
                </td>
            </tr>
            <tr>
                <td class="text-end">APELLIDOS:</td>
                <td>
                    <strong class="text-uppercase">{{ $matricula->estudiante->apellido_paterno; }} {{ $matricula->estudiante->apellido_materno; }}</strong>
                </td>
            </tr>
            <tr>
                <td class="text-end">N° DE DOCUMENTO:</td>
                <td>
                    <strong class="text-uppercase">{{ $matricula->estudiante->nro_documento; }}</strong>
                </td>
            </tr>
            <tr>
                <td class="text-end">CICLO:</td>
                <td>
                    <strong class="text-uppercase">{{ $matricula->ciclo->descripcion; }}</strong>
                </td>
            </tr>
            <tr>
                <td class="text-end">ÁREA:</td>
                <td>
                    <strong class="text-uppercase">{{ $matricula->area->descripcion; }}</strong>
                </td>
            </tr>
            <tr>
                <td class="text-end">CARRERA:</td>
                <td>
                    <strong class="text-uppercase">{{ $matricula->carrera->descripcion; }}</strong>
                </td>
            </tr>
            <tr>
                <td class="text-end">SEDE:</td>
                <td>
                    <strong class="text-uppercase">{{ $matricula->sede->descripcion; }}</strong>
                </td>
            </tr>
            <tr>
                <td class="text-end">Aula <small>(Hasta examen de ubicación)</small>:</td>
                <td>
                    <strong class="text-uppercase">{{ $matricula->aulas[0]->aula->descripcion }}</strong>
                </td>
            </tr>
            <tr>
                <td class="text-end">CONCEPTO DE PAGO:</td>
                <td>
                    {{-- TODO: AVOID USE [0] --}}
                    <strong class="text-uppercase">{{ $matricula->pagos[0]->descripcion_pago }}</strong>
                </td>
            </tr>
            <tr>
                <td class="text-end">MONTO:</td>
                <td>
                    {{-- TODO: AVOID USE [0] --}}
                    <strong class="text-uppercase">S/{{ $matricula->pagos[0]->monto_neto }}</strong>
                </td>
            </tr>

        </table>

        <hr>

        <div class="firmas-section">
            <table>
                <tr>
                    <td class="firma-item">
                        <div class="firma_postulante_box"></div>
                        <p class="text-center"><small>Huella digital</small></p>
                    </td>
                    <td class="firma-item">
                        <hr style="width: 90%">
                        <p class="text-center">FIRMA DEL POSTULANTE</p>
                    </td>
                    <td class="firma-item">
                        <hr style="width: 90%">
                        <p class="text-center">CEPRE UNH</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="legal-section">
            <table>
                <tr>
                    <td>
                        <strong>DECLARO BAJO JURAMENTO QUE:</strong>
                        <ul>
                            <li>
                                Toda la información a registrar en el formulario de inscripción es verdadera y de mi entera responsabilidad
                            </li>
                            <li>
                                Conozco y acepto todas las disposiciones del reglamento específico de CEPRE-UNH, al cual me someto. 
                            </li>
                            <li>
                                No soy condenado por el delito de terrorismo apología al terrorismo en cualquiera de sus modalidades.
                            </li>
                            <li>
                                No tengo sanción de impedimento de postular u otras medidas disciplinarias en la UNH u otra universidad del país.
                            </li>
                            <li>
                                Autorizo a la Universidad Nacional de Huancavelica, el uso de mis datos personales y la información proporcionada, para
                                los fines que estime conveniente.
                            </li>
                        </ul>
                    </td>
                    <td>
                        <strong>RECOMENDACIONES:</strong>
                        <ul>
                            <li>
                                Verificar que sus datos de inscripción sean los correctos. En caso exista errores apersonarse o comunicarse con la
                                Cepre-UNH, bajo responsabilidad.
                            </li>
                        </ul>
                    </td>
                </tr>
            </table>
            <div>
                <small>
                    <strong>NOTA.</strong> Los estudiantes que tienen pendiente la segunda cuota, la fecha límite de pago es 15/01/2024.
                </small>
            </div>
        </div>
    </div>
        
    </div>

</body>
</html>