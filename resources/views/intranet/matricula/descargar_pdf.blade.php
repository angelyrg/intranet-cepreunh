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
            width: 1.2cm;
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
            width: 3.5cm;
            height: 4.5cm;
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
            margin-top: 10px;
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
            width: 3cm ;
            height: 3.5cm;
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
            <h5>CENTRO PRE UNIVERSITARIO DE LA UNH</h5>
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
                <td class="text-end">TIPO DE CICLO:</td>
                <td>
                    <strong class="text-uppercase">{{ $matricula->ciclo->tipo_ciclo->descripcion; }}</strong>
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
                                Toda la información a registrar en el formulario de inscripción es verdadera y de mi entera responsabilidad.
                            </li>
                            <li>
                                Conozco y acepto todas las disposiciones del reglamento específico de admisión, al cual me someto.
                            </li>
                            <li>
                                No soy condenado por el delito de terrorismo apología al terrorismo en cualquiera de sus modalidades.
                            </li>
                            <li>
                                No tengo sanción de impedimento de postular u otras medidas disciplinarias en la UNH u otra universidad del
                                pais.
                            </li>
                            <li>
                                Autorizo a la Universidad Nacional de Huancavelica,el uso de mis datos personales y la información
                                proporcionada, para los fines que estime conveniente.
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
        </div>
    </div>
        
    </div>

</body>
</html>