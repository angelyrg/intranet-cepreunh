<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ciclos\StoreCicloRequest;
use App\Http\Requests\Ciclos\UpdateCicloRequest;
use App\Http\Requests\Matricula\MatriculaEstudianteRequest;
use App\Http\Requests\Matricula\MatriculaRequest;
use App\Models\Intranet\Area;
use App\Models\Intranet\Ciclo;
use App\Models\Intranet\Discapacidad;
use App\Models\Intranet\Docente;
use App\Models\Intranet\EstadoCivil;
use App\Models\Intranet\Estudiante;
use App\Models\Intranet\Genero;
use App\Models\Intranet\IdentidadEtnica;
use App\Models\Intranet\Matricula;
use App\Models\Intranet\Precio;
use App\Models\Intranet\Sede;
use App\Models\Intranet\TipoDocumento;
use App\Models\Intranet\TiposCiclos;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MatriculaController extends Controller
{

    public function buscar_dni(Request $request)
    {
        $ciclo_id = $request->query('ciclo');

        $request->validate([
            'estudiante_dni' => 'required|numeric|min:8',
        ]);

        $dni = $request->estudiante_dni;
        $estudiante = Estudiante::where('nro_documento', $dni)->first();


        if ($estudiante && $estudiante->discapacidades) {
            $estudiante->discapacidades = explode(',', $estudiante->discapacidades);
        }

        $tipos_documentos = TipoDocumento::all();
        $generos = Genero::all();
        $estados_civiles = EstadoCivil::all();
        $identidades_etnicas = IdentidadEtnica::all();
        $discapacidades = Discapacidad::all();

        $paises = [
            [
                "name" => "Peru",
                "es_name" => "Perú",
                "code" => "PE",
                "nationality" => "Peruano"
            ],
            [
                "name" => "Afghanistan",
                "es_name" => "Afganistán",
                "code" => "AF",
                "nationality" => "Afgano"
            ],
            [
                "name" => "Albania",
                "es_name" => "Albania",
                "code" => "AL",
                "nationality" => "Albanés"
            ],
            [
                "name" => "Algeria",
                "es_name" => "Argelia",
                "code" => "DZ",
                "nationality" => "Argelino"
            ],
            [
                "name" => "American Samoa",
                "es_name" => "Samoa Americana",
                "code" => "AS",
                "nationality" => "Samoano"
            ],
            [
                "name" => "Andorra",
                "es_name" => "Andorra",
                "code" => "AD",
                "nationality" => "Andorrano"
            ],
            [
                "name" => "Angola",
                "es_name" => "Angola",
                "code" => "AO",
                "nationality" => "Angoleño"
            ],
            [
                "name" => "Anguilla",
                "es_name" => "Anguila",
                "code" => "AI",
                "nationality" => "Anguilense"
            ],
            [
                "name" => "Antarctica",
                "es_name" => "Antártida",
                "code" => "AQ",
                "nationality" => "Antártico"
            ],
            [
                "name" => "Antigua and Barbuda",
                "es_name" => "Antigua y Barbuda",
                "code" => "AG",
                "nationality" => "Antiguano"
            ],
            [
                "name" => "Argentina",
                "es_name" => "Argentina",
                "code" => "AR",
                "nationality" => "Argentino"
            ],
            [
                "name" => "Armenia",
                "es_name" => "Armenia",
                "code" => "AM",
                "nationality" => "Armenio"
            ],
            [
                "name" => "Aruba",
                "es_name" => "Aruba",
                "code" => "AW",
                "nationality" => "Arubano"
            ],
            [
                "name" => "Australia",
                "es_name" => "Australia",
                "code" => "AU",
                "nationality" => "Australiano"
            ],
            [
                "name" => "Austria",
                "es_name" => "Austria",
                "code" => "AT",
                "nationality" => "Austriaco"
            ],
            [
                "name" => "Azerbaijan",
                "es_name" => "Azerbaiyán",
                "code" => "AZ",
                "nationality" => "Azerí"
            ],
            [
                "name" => "Bahamas",
                "es_name" => "Bahamas",
                "code" => "BS",
                "nationality" => "Bahamés"
            ],
            [
                "name" => "Bahrain",
                "es_name" => "Baréin",
                "code" => "BH",
                "nationality" => "Bareiní"
            ],
            [
                "name" => "Bangladesh",
                "es_name" => "Bangladesh",
                "code" => "BD",
                "nationality" => "Bangladesí"
            ],
            [
                "name" => "Barbados",
                "es_name" => "Barbados",
                "code" => "BB",
                "nationality" => "Barbadense"
            ],
            [
                "name" => "Belarus",
                "es_name" => "Bielorrusia",
                "code" => "BY",
                "nationality" => "Bielorruso"
            ],
            [
                "name" => "Belgium",
                "es_name" => "Bélgica",
                "code" => "BE",
                "nationality" => "Belga"
            ],
            [
                "name" => "Belize",
                "es_name" => "Belice",
                "code" => "BZ",
                "nationality" => "Beliceño"
            ],
            [
                "name" => "Benin",
                "es_name" => "Benín",
                "code" => "BJ",
                "nationality" => "Beninés"
            ],
            [
                "name" => "Bermuda",
                "es_name" => "Bermuda",
                "code" => "BM",
                "nationality" => "Bermudeño"
            ],
            [
                "name" => "Bhutan",
                "es_name" => "Bután",
                "code" => "BT",
                "nationality" => "Butanés"
            ],
            [
                "name" => "Bolivia",
                "es_name" => "Bolivia",
                "code" => "BO",
                "nationality" => "Boliviano"
            ],
            [
                "name" => "Bosnia and Herzegovina",
                "es_name" => "Bosnia-Herzegovina",
                "code" => "BA",
                "nationality" => "Bosnio"
            ],
            [
                "name" => "Botswana",
                "es_name" => "Botswana",
                "code" => "BW",
                "nationality" => "Botswanés"
            ],
            [
                "name" => "Brazil",
                "es_name" => "Brasil",
                "code" => "BR",
                "nationality" => "Brasileño"
            ],
            [
                "name" => "Brunei Darussalam",
                "es_name" => "Brunéi",
                "code" => "BN",
                "nationality" => "Bruneano"
            ],
            [
                "name" => "Bulgaria",
                "es_name" => "Bulgaria",
                "code" => "BG",
                "nationality" => "Búlgaro"
            ],
            [
                "name" => "Burkina Faso",
                "es_name" => "Burkina Faso",
                "code" => "BF",
                "nationality" => "Burkinés"
            ],
            [
                "name" => "Burundi",
                "es_name" => "Burundi",
                "code" => "BI",
                "nationality" => "Burundés"
            ],
            [
                "name" => "Cambodia",
                "es_name" => "Camboya",
                "code" => "KH",
                "nationality" => "Camboyano"
            ],
            [
                "name" => "Cameroon",
                "es_name" => "Camerún",
                "code" => "CM",
                "nationality" => "Camerunés"
            ],
            [
                "name" => "Canada",
                "es_name" => "Canadá",
                "code" => "CA",
                "nationality" => "Canadiense"
            ],
            [
                "name" => "Cape Verde",
                "es_name" => "Cabo Verde",
                "code" => "CV",
                "nationality" => "Caboverdiano"
            ],
            [
                "name" => "Cayman Islands",
                "es_name" => "Islas Caimán",
                "code" => "KY",
                "nationality" => "Caimanes"
            ],
            [
                "name" => "Central African Republic",
                "es_name" => "República Centroafricana",
                "code" => "CF",
                "nationality" => "Centroafricano"
            ],
            [
                "name" => "Chad",
                "es_name" => "Chad",
                "code" => "TD",
                "nationality" => "Chadiano"
            ],
            [
                "name" => "Chile",
                "es_name" => "Chile",
                "code" => "CL",
                "nationality" => "Chileno"
            ],
            [
                "name" => "China",
                "es_name" => "China",
                "code" => "CN",
                "nationality" => "Chino"
            ],
            [
                "name" => "Christmas Island",
                "es_name" => "Isla de Navidad",
                "code" => "CX",
                "nationality" => "Navideño"
            ],
            [
                "name" => "Cocos (Keeling) Islands",
                "es_name" => "Islas Cocos",
                "code" => "CC",
                "nationality" => "Cocoseño"
            ],
            [
                "name" => "Colombia",
                "es_name" => "Colombia",
                "code" => "CO",
                "nationality" => "Colombiano"
            ],
            [
                "name" => "Comoros",
                "es_name" => "Comoras",
                "code" => "KM",
                "nationality" => "Comorense"
            ],
            [
                "name" => "Congo",
                "es_name" => "República del Congo",
                "code" => "CG",
                "nationality" => "Congoleño"
            ],
            [
                "name" => "Congo, The Democratic Republic of the",
                "es_name" => "República Democrática del Congo",
                "code" => "CD",
                "nationality" => "Congoleño"
            ],
            [
                "name" => "Cook Islands",
                "es_name" => "Islas Cook",
                "code" => "CK",
                "nationality" => "Cookense"
            ],
            [
                "name" => "Costa Rica",
                "es_name" => "Costa Rica",
                "code" => "CR",
                "nationality" => "Costarricense"
            ],
            [
                "name" => "Cote D'Ivoire",
                "es_name" => "Costa de Marfil",
                "code" => "CI",
                "nationality" => "Marfileño"
            ],
            [
                "name" => "Croatia",
                "es_name" => "Croacia",
                "code" => "HR",
                "nationality" => "Croata"
            ],
            [
                "name" => "Cuba",
                "es_name" => "Cuba",
                "code" => "CU",
                "nationality" => "Cubano"
            ],
            [
                "name" => "Cyprus",
                "es_name" => "Chipre",
                "code" => "CY",
                "nationality" => "Chipriota"
            ],
            [
                "name" => "Czech Republic",
                "es_name" => "República Checa",
                "code" => "CZ",
                "nationality" => "Checo"
            ],
            [
                "name" => "Denmark",
                "es_name" => "Dinamarca",
                "code" => "DK",
                "nationality" => "Danés"
            ],
            [
                "name" => "Djibouti",
                "es_name" => "Yibuti",
                "code" => "DJ",
                "nationality" => "Yibutiano"
            ],
            [
                "name" => "Dominica",
                "es_name" => "Dominica",
                "code" => "DM",
                "nationality" => "Dominiqueño"
            ],
            [
                "name" => "Dominican Republic",
                "es_name" => "República Dominicana",
                "code" => "DO",
                "nationality" => "Dominicano"
            ],
            [
                "name" => "Ecuador",
                "es_name" => "Ecuador",
                "code" => "EC",
                "nationality" => "Ecuatoriano"
            ],
            [
                "name" => "Egypt",
                "es_name" => "Egipto",
                "code" => "EG",
                "nationality" => "Egipcio"
            ],
            [
                "name" => "El Salvador",
                "es_name" => "El Salvador",
                "code" => "SV",
                "nationality" => "Salvadoreño"
            ],
            [
                "name" => "Equatorial Guinea",
                "es_name" => "Guinea Ecuatorial",
                "code" => "GQ",
                "nationality" => "Ecuatoguineano"
            ],
            [
                "name" => "Eritrea",
                "es_name" => "Eritrea",
                "code" => "ER",
                "nationality" => "Eritreo"
            ],
            [
                "name" => "Estonia",
                "es_name" => "Estonia",
                "code" => "EE",
                "nationality" => "Estonio"
            ],
            [
                "name" => "Eswatini",
                "es_name" => "Esuatini",
                "code" => "SZ",
                "nationality" => "Eswatini"
            ],
            [
                "name" => "Ethiopia",
                "es_name" => "Etiopía",
                "code" => "ET",
                "nationality" => "Ecuatoriano"
            ],
            [
                "name" => "Falkland Islands",
                "es_name" => "Islas Malvinas",
                "code" => "FK",
                "nationality" => "Malvinense"
            ],
            [
                "name" => "Faroe Islands",
                "es_name" => "Islas Faroe",
                "code" => "FO",
                "nationality" => "Faroeño"
            ],
            [
                "name" => "Fiji",
                "es_name" => "Fiyi",
                "code" => "FJ",
                "nationality" => "Fiyiano"
            ],
            [
                "name" => "Finland",
                "es_name" => "Finlandia",
                "code" => "FI",
                "nationality" => "Finlandés"
            ],
            [
                "name" => "France",
                "es_name" => "Francia",
                "code" => "FR",
                "nationality" => "Francés"
            ],
            [
                "name" => "French Guiana",
                "es_name" => "Guayana Francesa",
                "code" => "GF",
                "nationality" => "Guayanés"
            ],
            [
                "name" => "French Polynesia",
                "es_name" => "Polinesia Francesa",
                "code" => "PF",
                "nationality" => "Polinesio"
            ],
            [
                "name" => "French Southern Territories",
                "es_name" => "Territorios Australes Franceses",
                "code" => "TF",
                "nationality" => "Franceses"
            ],
            [
                "name" => "Gabon",
                "es_name" => "Gabón",
                "code" => "GA",
                "nationality" => "Gabonés"
            ],
            [
                "name" => "Gambia",
                "es_name" => "Gambia",
                "code" => "GM",
                "nationality" => "Gambiano"
            ],
            [
                "name" => "Georgia",
                "es_name" => "Georgia",
                "code" => "GE",
                "nationality" => "Georgiano"
            ],
            [
                "name" => "Germany",
                "es_name" => "Alemania",
                "code" => "DE",
                "nationality" => "Alemán"
            ],
            [
                "name" => "Ghana",
                "es_name" => "Ghana",
                "code" => "GH",
                "nationality" => "Ghanés"
            ],
            [
                "name" => "Gibraltar",
                "es_name" => "Gibraltar",
                "code" => "GI",
                "nationality" => "Gibraltareño"
            ],
            [
                "name" => "Greece",
                "es_name" => "Grecia",
                "code" => "GR",
                "nationality" => "Griego"
            ],
            [
                "name" => "Greenland",
                "es_name" => "Groenlandia",
                "code" => "GL",
                "nationality" => "Groenlandés"
            ],
            [
                "name" => "Grenada",
                "es_name" => "Granada",
                "code" => "GD",
                "nationality" => "Granadino"
            ],
            [
                "name" => "Guadeloupe",
                "es_name" => "Guadalupe",
                "code" => "GP",
                "nationality" => "Guadalupeño"
            ],
            [
                "name" => "Guam",
                "es_name" => "Guam",
                "code" => "GU",
                "nationality" => "Guameño"
            ],
            [
                "name" => "Guatemala",
                "es_name" => "Guatemala",
                "code" => "GT",
                "nationality" => "Guatemalteco"
            ],
            [
                "name" => "Guernsey",
                "es_name" => "Guernsey",
                "code" => "GG",
                "nationality" => "Guernsey"
            ],
            [
                "name" => "Guinea",
                "es_name" => "Guinea",
                "code" => "GN",
                "nationality" => "Guineano"
            ],
            [
                "name" => "Guinea-Bissau",
                "es_name" => "Guinea-Bisáu",
                "code" => "GW",
                "nationality" => "Guineano"
            ],
            [
                "name" => "Guyana",
                "es_name" => "Guyana",
                "code" => "GY",
                "nationality" => "Guyanés"
            ],
            [
                "name" => "Haiti",
                "es_name" => "Haití",
                "code" => "HT",
                "nationality" => "Haitiano"
            ],
            [
                "name" => "Honduras",
                "es_name" => "Honduras",
                "code" => "HN",
                "nationality" => "Hondureño"
            ],
            [
                "name" => "Hong Kong",
                "es_name" => "Hong Kong",
                "code" => "HK",
                "nationality" => "Hongkonés"
            ],
            [
                "name" => "Hungary",
                "es_name" => "Hungría",
                "code" => "HU",
                "nationality" => "Húngaro"
            ],
            [
                "name" => "Iceland",
                "es_name" => "Islandia",
                "code" => "IS",
                "nationality" => "Islandés"
            ],
            [
                "name" => "India",
                "es_name" => "India",
                "code" => "IN",
                "nationality" => "Indio"
            ],
            [
                "name" => "Indonesia",
                "es_name" => "Indonesia",
                "code" => "ID",
                "nationality" => "Indonesio"
            ],
            [
                "name" => "Iran",
                "es_name" => "Irán",
                "code" => "IR",
                "nationality" => "Iraní"
            ],
            [
                "name" => "Iraq",
                "es_name" => "Irak",
                "code" => "IQ",
                "nationality" => "Irakí"
            ],
            [
                "name" => "Ireland",
                "es_name" => "Irlanda",
                "code" => "IE",
                "nationality" => "Irlandés"
            ],
            [
                "name" => "Isle of Man",
                "es_name" => "Isla de Man",
                "code" => "IM",
                "nationality" => "Manés"
            ],
            [
                "name" => "Israel",
                "es_name" => "Israel",
                "code" => "IL",
                "nationality" => "Israelí"
            ],
            [
                "name" => "Italy",
                "es_name" => "Italia",
                "code" => "IT",
                "nationality" => "Italiano"
            ],
            [
                "name" => "Jamaica",
                "es_name" => "Jamaica",
                "code" => "JM",
                "nationality" => "Jamaicano"
            ],
            [
                "name" => "Japan",
                "es_name" => "Japón",
                "code" => "JP",
                "nationality" => "Japonés"
            ],
            [
                "name" => "Jersey",
                "es_name" => "Jersey",
                "code" => "JE",
                "nationality" => "Jerseyan"
            ],
            [
                "name" => "Jordan",
                "es_name" => "Jordania",
                "code" => "JO",
                "nationality" => "Jordano"
            ],
            [
                "name" => "Kazakhstan",
                "es_name" => "Kazajistán",
                "code" => "KZ",
                "nationality" => "Kazajo"
            ],
            [
                "name" => "Kenya",
                "es_name" => "Kenia",
                "code" => "KE",
                "nationality" => "Keniano"
            ],
            [
                "name" => "Kiribati",
                "es_name" => "Kiribati",
                "code" => "KI",
                "nationality" => "Kiribatiano"
            ],
            [
                "name" => "Korea, Democratic People's Republic of",
                "es_name" => "Corea del Norte",
                "code" => "KP",
                "nationality" => "Norcoreano"
            ],
            [
                "name" => "Korea, Republic of",
                "es_name" => "Corea del Sur",
                "code" => "KR",
                "nationality" => "Surcoreano"
            ],
            [
                "name" => "Kuwait",
                "es_name" => "Kuwait",
                "code" => "KW",
                "nationality" => "Kuwaití"
            ],
            [
                "name" => "Kyrgyzstan",
                "es_name" => "Kirguistán",
                "code" => "KG",
                "nationality" => "Kirguís"
            ],
            [
                "name" => "Lao People's Democratic Republic",
                "es_name" => "Laos",
                "code" => "LA",
                "nationality" => "Laosiano"
            ],
            [
                "name" => "Latvia",
                "es_name" => "Letonia",
                "code" => "LV",
                "nationality" => "Letón"
            ],
            [
                "name" => "Lebanon",
                "es_name" => "Líbano",
                "code" => "LB",
                "nationality" => "Libanés"
            ],
            [
                "name" => "Lesotho",
                "es_name" => "Lesoto",
                "code" => "LS",
                "nationality" => "Lesoteño"
            ],
            [
                "name" => "Liberia",
                "es_name" => "Liberia",
                "code" => "LR",
                "nationality" => "Liberiano"
            ],
            [
                "name" => "Libya",
                "es_name" => "Libia",
                "code" => "LY",
                "nationality" => "Libio"
            ],
            [
                "name" => "Liechtenstein",
                "es_name" => "Liechtenstein",
                "code" => "LI",
                "nationality" => "Liechtensteiniano"
            ],
            [
                "name" => "Lithuania",
                "es_name" => "Lituania",
                "code" => "LT",
                "nationality" => "Lituano"
            ],
            [
                "name" => "Luxembourg",
                "es_name" => "Luxemburgo",
                "code" => "LU",
                "nationality" => "Luxemburgués"
            ],
            [
                "name" => "Madagascar",
                "es_name" => "Madagascar",
                "code" => "MG",
                "nationality" => "Malgache"
            ],
            [
                "name" => "Malawi",
                "es_name" => "Malawi",
                "code" => "MW",
                "nationality" => "Malauí"
            ],
            [
                "name" => "Malaysia",
                "es_name" => "Malasia",
                "code" => "MY",
                "nationality" => "Malasio"
            ],
            [
                "name" => "Maldives",
                "es_name" => "Maldivas",
                "code" => "MV",
                "nationality" => "Maldivo"
            ],
            [
                "name" => "Mali",
                "es_name" => "Malí",
                "code" => "ML",
                "nationality" => "Maliense"
            ],
            [
                "name" => "Malta",
                "es_name" => "Malta",
                "code" => "MT",
                "nationality" => "Maltés"
            ],
            [
                "name" => "Marshall Islands",
                "es_name" => "Islas Marshall",
                "code" => "MH",
                "nationality" => "Marshallés"
            ],
            [
                "name" => "Mauritania",
                "es_name" => "Mauritania",
                "code" => "MR",
                "nationality" => "Mauritano"
            ],
            [
                "name" => "Mauritius",
                "es_name" => "Mauricio",
                "code" => "MU",
                "nationality" => "Mauriciano"
            ],
            [
                "name" => "Mayotte",
                "es_name" => "Mayotte",
                "code" => "YT",
                "nationality" => "Mayotense"
            ],
            [
                "name" => "Mexico",
                "es_name" => "México",
                "code" => "MX",
                "nationality" => "Mexicano"
            ],
            [
                "name" => "Micronesia",
                "es_name" => "Micronesia",
                "code" => "FM",
                "nationality" => "Micronesio"
            ],
            [
                "name" => "Moldova",
                "es_name" => "Moldavia",
                "code" => "MD",
                "nationality" => "Moldavo"
            ],
            [
                "name" => "Monaco",
                "es_name" => "Mónaco",
                "code" => "MC",
                "nationality" => "Monegasco"
            ],
            [
                "name" => "Mongolia",
                "es_name" => "Mongolia",
                "code" => "MN",
                "nationality" => "Mongol"
            ],
            [
                "name" => "Montenegro",
                "es_name" => "Montenegro",
                "code" => "ME",
                "nationality" => "Montenegrino"
            ],
            [
                "name" => "Montserrat",
                "es_name" => "Montserrat",
                "code" => "MS",
                "nationality" => "Montserratiano"
            ],
            [
                "name" => "Morocco",
                "es_name" => "Marruecos",
                "code" => "MA",
                "nationality" => "Marroquí"
            ],
            [
                "name" => "Mozambique",
                "es_name" => "Mozambique",
                "code" => "MZ",
                "nationality" => "Mozambiqueño"
            ],
            [
                "name" => "Myanmar",
                "es_name" => "Birmania",
                "code" => "MM",
                "nationality" => "Birmano"
            ],
            [
                "name" => "Namibia",
                "es_name" => "Namibia",
                "code" => "NA",
                "nationality" => "Namibio"
            ],
            [
                "name" => "Nauru",
                "es_name" => "Nauru",
                "code" => "NR",
                "nationality" => "Nauruano"
            ],
            [
                "name" => "Nepal",
                "es_name" => "Nepal",
                "code" => "NP",
                "nationality" => "Nepalí"
            ],
            [
                "name" => "Netherlands",
                "es_name" => "Países Bajos",
                "code" => "NL",
                "nationality" => "Neerlandés"
            ],
            [
                "name" => "New Caledonia",
                "es_name" => "Nueva Caledonia",
                "code" => "NC",
                "nationality" => "Neocaledonio"
            ],
            [
                "name" => "New Zealand",
                "es_name" => "Nueva Zelanda",
                "code" => "NZ",
                "nationality" => "Neozelandés"
            ],
            [
                "name" => "Nicaragua",
                "es_name" => "Nicaragua",
                "code" => "NI",
                "nationality" => "Nicaragüense"
            ],
            [
                "name" => "Niger",
                "es_name" => "Níger",
                "code" => "NE",
                "nationality" => "Nigerino"
            ],
            [
                "name" => "Nigeria",
                "es_name" => "Nigeria",
                "code" => "NG",
                "nationality" => "Nigeriano"
            ],
            [
                "name" => "Niue",
                "es_name" => "Niue",
                "code" => "NU",
                "nationality" => "Niueano"
            ],
            [
                "name" => "Norfolk Island",
                "es_name" => "Isla Norfolk",
                "code" => "NF",
                "nationality" => "Norfolkeño"
            ],
            [
                "name" => "North Macedonia",
                "es_name" => "Macedonia del Norte",
                "code" => "MK",
                "nationality" => "Macedonio"
            ],
            [
                "name" => "Northern Mariana Islands",
                "es_name" => "Islas Marianas del Norte",
                "code" => "MP",
                "nationality" => "Marianense"
            ],
            [
                "name" => "Norway",
                "es_name" => "Noruega",
                "code" => "NO",
                "nationality" => "Noruego"
            ],
            [
                "name" => "Oman",
                "es_name" => "Omán",
                "code" => "OM",
                "nationality" => "Omaní"
            ],
            [
                "name" => "Pakistan",
                "es_name" => "Pakistán",
                "code" => "PK",
                "nationality" => "Paquistaní"
            ],
            [
                "name" => "Palau",
                "es_name" => "Palaú",
                "code" => "PW",
                "nationality" => "Palauano"
            ],
            [
                "name" => "Palestine",
                "es_name" => "Palestina",
                "code" => "PS",
                "nationality" => "Palestino"
            ],
            [
                "name" => "Panama",
                "es_name" => "Panamá",
                "code" => "PA",
                "nationality" => "Panameño"
            ],
            [
                "name" => "Papua New Guinea",
                "es_name" => "Papúa Nueva Guinea",
                "code" => "PG",
                "nationality" => "Papú"
            ],
            [
                "name" => "Paraguay",
                "es_name" => "Paraguay",
                "code" => "PY",
                "nationality" => "Paraguayo"
            ],
            [
                "name" => "Philippines",
                "es_name" => "Filipinas",
                "code" => "PH",
                "nationality" => "Filipino"
            ],
            [
                "name" => "Pitcairn Islands",
                "es_name" => "Islas Pitcairn",
                "code" => "PN",
                "nationality" => "Pitcairnés"
            ],
            [
                "name" => "Poland",
                "es_name" => "Polonia",
                "code" => "PL",
                "nationality" => "Polaco"
            ],
            [
                "name" => "Portugal",
                "es_name" => "Portugal",
                "code" => "PT",
                "nationality" => "Portugués"
            ],
            [
                "name" => "Puerto Rico",
                "es_name" => "Puerto Rico",
                "code" => "PR",
                "nationality" => "Puertorriqueño"
            ],
            [
                "name" => "Qatar",
                "es_name" => "Catar",
                "code" => "QA",
                "nationality" => "Qatarí"
            ],
            [
                "name" => "Réunion",
                "es_name" => "Reunión",
                "code" => "RE",
                "nationality" => "Reunionés"
            ],
            [
                "name" => "Romania",
                "es_name" => "Rumanía",
                "code" => "RO",
                "nationality" => "Rumano"
            ],
            [
                "name" => "Russia",
                "es_name" => "Rusia",
                "code" => "RU",
                "nationality" => "Ruso"
            ],
            [
                "name" => "Rwanda",
                "es_name" => "Ruanda",
                "code" => "RW",
                "nationality" => "Ruandés"
            ],
            [
                "name" => "Saint Barthélemy",
                "es_name" => "San Bartolomé",
                "code" => "BL",
                "nationality" => "Barthélemois"
            ],
            [
                "name" => "Saint Helena",
                "es_name" => "Santa Elena",
                "code" => "SH",
                "nationality" => "Helenense"
            ],
            [
                "name" => "Saint Kitts and Nevis",
                "es_name" => "San Cristóbal y Nieves",
                "code" => "KN",
                "nationality" => "Kittitian"
            ],
            [
                "name" => "Saint Lucia",
                "es_name" => "Santa Lucía",
                "code" => "LC",
                "nationality" => "Luciano"
            ],
            [
                "name" => "Saint Martin",
                "es_name" => "San Martín",
                "code" => "MF",
                "nationality" => "Marteen"
            ],
            [
                "name" => "Saint Pierre and Miquelon",
                "es_name" => "San Pedro y Miquelón",
                "code" => "PM",
                "nationality" => "Saint-Pierrais"
            ],
            [
                "name" => "Saint Vincent and the Grenadines",
                "es_name" => "San Vicente y las Granadinas",
                "code" => "VC",
                "nationality" => "Vincentino"
            ],
            [
                "name" => "Samoa",
                "es_name" => "Samoa",
                "code" => "WS",
                "nationality" => "Samoano"
            ],
            [
                "name" => "San Marino",
                "es_name" => "San Marino",
                "code" => "SM",
                "nationality" => "Sammarinese"
            ],
            [
                "name" => "Sao Tome and Principe",
                "es_name" => "Santo Tomé y Príncipe",
                "code" => "ST",
                "nationality" => "Santo Tomense"
            ],
            [
                "name" => "Saudi Arabia",
                "es_name" => "Arabia Saudita",
                "code" => "SA",
                "nationality" => "Saudi"
            ],
            [
                "name" => "Senegal",
                "es_name" => "Senegal",
                "code" => "SN",
                "nationality" => "Senegalés"
            ],
            [
                "name" => "Serbia",
                "es_name" => "Serbia",
                "code" => "RS",
                "nationality" => "Serbio"
            ],
            [
                "name" => "Seychelles",
                "es_name" => "Seychelles",
                "code" => "SC",
                "nationality" => "Seychelense"
            ],
            [
                "name" => "Sierra Leone",
                "es_name" => "Sierra Leona",
                "code" => "SL",
                "nationality" => "Sierra Leonés"
            ],
            [
                "name" => "Singapore",
                "es_name" => "Singapur",
                "code" => "SG",
                "nationality" => "Singapurense"
            ],
            [
                "name" => "Sint Maarten",
                "es_name" => "Sint Maarten",
                "code" => "SX",
                "nationality" => "Sint Maartener"
            ],
            [
                "name" => "Slovakia",
                "es_name" => "Eslovaquia",
                "code" => "SK",
                "nationality" => "Eslovaco"
            ],
            [
                "name" => "Slovenia",
                "es_name" => "Eslovenia",
                "code" => "SI",
                "nationality" => "Esloveno"
            ],
            [
                "name" => "Solomon Islands",
                "es_name" => "Islas Salomón",
                "code" => "SB",
                "nationality" => "Salomonense"
            ],
            [
                "name" => "Somalia",
                "es_name" => "Somalia",
                "code" => "SO",
                "nationality" => "Somalí"
            ],
            [
                "name" => "South Africa",
                "es_name" => "Sudáfrica",
                "code" => "ZA",
                "nationality" => "Sudafricano"
            ],
            [
                "name" => "South Georgia and the South Sandwich Islands",
                "es_name" => "Islas Georgias del Sur y Sandwich del Sur",
                "code" => "GS",
                "nationality" => "Georgiano del Sur"
            ],
            [
                "name" => "South Sudan",
                "es_name" => "Sudán del Sur",
                "code" => "SS",
                "nationality" => "SurSudanés"
            ],
            [
                "name" => "Spain",
                "es_name" => "España",
                "code" => "ES",
                "nationality" => "Español"
            ],
            [
                "name" => "Sri Lanka",
                "es_name" => "Sri Lanka",
                "code" => "LK",
                "nationality" => "Ceilanés"
            ],
            [
                "name" => "Sudan",
                "es_name" => "Sudán",
                "code" => "SD",
                "nationality" => "Sudanés"
            ],
            [
                "name" => "Suriname",
                "es_name" => "Surinam",
                "code" => "SR",
                "nationality" => "Surinamés"
            ],
            [
                "name" => "Svalbard and Jan Mayen",
                "es_name" => "Svalbard y Jan Mayen",
                "code" => "SJ",
                "nationality" => "Svalbardense"
            ],
            [
                "name" => "Sweden",
                "es_name" => "Suecia",
                "code" => "SE",
                "nationality" => "Sueco"
            ],
            [
                "name" => "Switzerland",
                "es_name" => "Suiza",
                "code" => "CH",
                "nationality" => "Suizo"
            ],
            [
                "name" => "Syria",
                "es_name" => "Siria",
                "code" => "SY",
                "nationality" => "Sirio"
            ],
            [
                "name" => "Taiwan",
                "es_name" => "Taiwán",
                "code" => "TW",
                "nationality" => "Taiwanés"
            ],
            [
                "name" => "Tajikistan",
                "es_name" => "Tayikistán",
                "code" => "TJ",
                "nationality" => "Tayiko"
            ],
            [
                "name" => "Tanzania",
                "es_name" => "Tanzania",
                "code" => "TZ",
                "nationality" => "Tanzano"
            ],
            [
                "name" => "Thailand",
                "es_name" => "Tailandia",
                "code" => "TH",
                "nationality" => "Tailandés"
            ],
            [
                "name" => "Timor-Leste",
                "es_name" => "Timor Oriental",
                "code" => "TL",
                "nationality" => "Timorense"
            ],
            [
                "name" => "Togo",
                "es_name" => "Togo",
                "code" => "TG",
                "nationality" => "Togolés"
            ],
            [
                "name" => "Tokelau",
                "es_name" => "Tokelau",
                "code" => "TK",
                "nationality" => "Tokelauano"
            ],
            [
                "name" => "Tonga",
                "es_name" => "Tonga",
                "code" => "TO",
                "nationality" => "Tonga"
            ],
            [
                "name" => "Trinidad and Tobago",
                "es_name" => "Trinidad y Tobago",
                "code" => "TT",
                "nationality" => "Trinitense"
            ],
            [
                "name" => "Tunisia",
                "es_name" => "Túnez",
                "code" => "TN",
                "nationality" => "Tunecino"
            ],
            [
                "name" => "Turkey",
                "es_name" => "Turquía",
                "code" => "TR",
                "nationality" => "Turco"
            ],
            [
                "name" => "Turkmenistan",
                "es_name" => "Turkmenistán",
                "code" => "TM",
                "nationality" => "Turcomano"
            ],
            [
                "name" => "Tuvalu",
                "es_name" => "Tuvalu",
                "code" => "TV",
                "nationality" => "Tuvaluano"
            ],
            [
                "name" => "Uganda",
                "es_name" => "Uganda",
                "code" => "UG",
                "nationality" => "Ugandés"
            ],
            [
                "name" => "Ukraine",
                "es_name" => "Ucrania",
                "code" => "UA",
                "nationality" => "Ucraniano"
            ],
            [
                "name" => "United Arab Emirates",
                "es_name" => "Emiratos Árabes Unidos",
                "code" => "AE",
                "nationality" => "Emiratí"
            ],
            [
                "name" => "United Kingdom",
                "es_name" => "Reino Unido",
                "code" => "GB",
                "nationality" => "Británico"
            ],
            [
                "name" => "United States of America",
                "es_name" => "Estados Unidos",
                "code" => "US",
                "nationality" => "Estadounidense"
            ],
            [
                "name" => "Uruguay",
                "es_name" => "Uruguay",
                "code" => "UY",
                "nationality" => "Uruguayo"
            ],
            [
                "name" => "Uzbekistan",
                "es_name" => "Uzbekistán",
                "code" => "UZ",
                "nationality" => "Uzbeco"
            ],
            [
                "name" => "Vanuatu",
                "es_name" => "Vanuatu",
                "code" => "VU",
                "nationality" => "Vanuatense"
            ],
            [
                "name" => "Venezuela",
                "es_name" => "Venezuela",
                "code" => "VE",
                "nationality" => "Venezolano"
            ],
            [
                "name" => "Viet Nam",
                "es_name" => "Vietnam",
                "code" => "VN",
                "nationality" => "Vietnamita"
            ],
            [
                "name" => "Western Sahara",
                "es_name" => "Sáhara Occidental",
                "code" => "EH",
                "nationality" => "Saharaui"
            ],
            [
                "name" => "Yemen",
                "es_name" => "Yemen",
                "code" => "YE",
                "nationality" => "Yemení"
            ],
            [
                "name" => "Zambia",
                "es_name" => "Zambia",
                "code" => "ZM",
                "nationality" => "Zambiano"
            ],
            [
                "name" => "Zimbabwe",
                "es_name" => "Zimbabue",
                "code" => "ZW",
                "nationality" => "Zimbabuense"
            ]
        ];

        return view('intranet.matricula.datos-personales', compact(
            'estudiante',
            'tipos_documentos',
            'generos',
            'estados_civiles',
            'paises',
            'identidades_etnicas',
            'discapacidades',
            'ciclo_id'
        ));
    }

   


    public function store_estudiante(MatriculaEstudianteRequest $request)
    {
        $tieneDiscapacidad = $request->has('tiene_discapacidad');
        $ciclo_id = $request->validated()['ciclo_id'];

        $estudiante = Estudiante::updateOrCreate(
            ['id' => $request->id],
            array_merge(
                $request->validated(),
                ['tiene_discapacidad' => $tieneDiscapacidad]
            )
        );

        $estudiante_id = $estudiante->id;

        // session()->flash('ciclo_id', $ciclo_id);
        // session()->flash('estudiante_id', $estudiante_id);
        session()->put('ciclo_id', $ciclo_id);
        session()->put('estudiante_id', $estudiante_id);


        return redirect()->route('matricula.create');
    }


    public function create(Request $request)
    {
        $ciclo_id = session('ciclo_id');
        $estudiante_id = session('estudiante_id');

        $areas = Area::all();
        $sedes = Sede::all();
        $ciclo = Ciclo::findOrFail($ciclo_id);

        return view('intranet.matricula.create', compact(
            'ciclo_id',
            'ciclo',
            'estudiante_id',
            'areas',
            'sedes'
        ));
    }


    public function store( MatriculaRequest $request )
    {
        $validatedData = $request->validated();

        $matricula = Matricula::create([
            'ciclo_id' => $validatedData['ciclo_id'],
            'estudiante_id' => $validatedData['estudiante_id'],
            'area_id' => $validatedData['area_id'],
            'carrera_id' => $validatedData['carrera_id'],
            'sede_id' => $validatedData['sede_id'],
        ]);

        return redirect()->route('matricula.show', [$matricula]);
    }


    public function show($id)
    {
        $matricula = Matricula::findOrFail($id);
        return view('intranet.matricula.show', compact('matricula'));
    }


    // private function getData()
    // {
    //     $ciclos = Ciclo::all();

    //     $html = "";
    //     foreach ($ciclos as $item) {
    //         $id = $item->id;
    //         $descripcion = $item->descripcion;
    //         $fecha_inicio = (new DateTime($item->fecha_inicio))->format('d/m/Y');
    //         $fecha_fin = (new DateTime($item->fecha_fin))->format('d/m/Y');
    //         $duracion = $item->duracion . " semanas";
    //         $tipo_ciclo = $item->tipo_ciclo->descripcion;
    //         $estado = $item->estado;
    //         $fecha_creacion = (new DateTime($item->created_at))->format('d/m/Y');

    //         $acciones = "
    //         <div class='btnActionCarrera'>
    //             <a class='btn btn-sm btn-outline-primary btnEdit' data-id='$id' role='button'>
    //                 <i class='ti ti-edit'></i>                                        
    //             </a>
    //             <a class='btn btn-sm btn-outline-danger btnDelete' data-id='$id' role='button'>
    //                 <i class='ti ti-trash'></i>                                        
    //             </a>
    //             <a class='btn btn-sm btn-outline-primary' href=" . route('ciclos.show', $id) . ">
    //                 <i class='ti ti-eye'></i>                                        
    //             </a>
    //         </div>
    //         ";

    //         $estado = ($estado > 0) ? 'ACTIVO' : 'INACTIVO';

    //         $html .= "<tr>
    //             <td>$acciones</td>
    //             <td><span class='badge fw-semibold bg-primary-subtle text-primary'>$estado</span></td>
    //             <td>
    //                 <a href=" . route('ciclos.show', $id) . ">
    //                     $descripcion
    //                 </a>
    //             </td>
    //             <td>$fecha_inicio</td>
    //             <td>$fecha_fin</td>
    //             <td>$duracion</td>
    //             <td>$tipo_ciclo</td>
    //             <td>$fecha_creacion</td>
    //         </tr>";
    //     }

    //     return $html;
    // }

    // public function eliminar(Ciclo $ciclo)
    // {
    //     try {
    //         $ciclo->delete(); //softdelete            
    //         $ciclo->save();
    //         $datatable = $this->getData();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Ciclo eliminada con éxito',
    //             'datatable' => $datatable
    //         ], 200);
    //     } catch (ModelNotFoundException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Ciclo no encontrada'
    //         ], 404);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error al eliminar el ciclo',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
}