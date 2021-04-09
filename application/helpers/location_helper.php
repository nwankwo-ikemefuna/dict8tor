<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function countries() {
    $countries = array (
        'Afghanistan',
        'Albania',
        'Algeria',
        'Andorra',
        'Angola',
        'Antigua and Barbuda',
        'Argentina',
        'Armenia',
        'Aruba',
        'Australia',
        'Austria',
        'Azerbaijan',
        'Bahamas', 
        'The Bahrain',
        'Bangladesh',
        'Barbados',
        'Belarus',
        'Belgium',
        'Belize',
        'Benin',
        'Bhutan',
        'Bolivia',
        'Bosnia and Herzegovina',
        'Botswana',
        'Brazil',
        'Brunei',
        'Bulgaria',
        'Burkina Faso',
        'Burma',
        'Burundi',
        'Cambodia',
        'Cameroon',
        'Canada',
        'Cabo Verde',
        'Central African Republic',
        'Chad',
        'Chile',
        'China',
        'Colombia',
        'Comoros',
        'Congo', 
        'Democratic Republic of the Congo', 
        'Costa Rica',
        'Cote d Ivoire',
        'Croatia',
        'Cuba',
        'Curacao',
        'Cyprus',
        'Czechia',
        'Denmark',
        'Djibouti',
        'Dominica',
        'Dominican Republic',
        'East Timor (see Timor-Leste)',
        'Ecuador',
        'Egypt',
        'El Salvador',
        'Equatorial Guinea',
        'Eritrea',
        'Estonia',
        'Ethiopia',
        'Fiji',
        'Finland',
        'France',
        'Gabon',
        'Gambia', 
        'Georgia',
        'Germany',
        'Ghana',
        'Greece',
        'Grenada',
        'Guatemala',
        'Guinea',
        'Guinea-Bissau',
        'Guyana',
        'Haiti',
        'Holy See',
        'Honduras',
        'Hong Kong',
        'Hungary',
        'Iceland',
        'India',
        'Indonesia',
        'Iran',
        'Iraq',
        'Ireland',
        'Israel',
        'Italy',
        'Jamaica',
        'Japan',
        'Jordan',
        'Kazakhstan',
        'Kenya',
        'Kiribati',
        'Korea, North',
        'Korea, South',
        'Kosovo',
        'Kuwait',
        'Kyrgyzstan',
        'Laos',
        'Latvia',
        'Lebanon',
        'Lesotho',
        'Liberia',
        'Libya',
        'Liechtenstein',
        'Lithuania',
        'Luxembourg',
        'Macau',
        'Macedonia',
        'Madagascar',
        'Malawi',
        'Malaysia',
        'Maldives',
        'Mali',
        'Malta',
        'Marshall Islands',
        'Mauritania',
        'Mauritius',
        'Mexico',
        'Micronesia',
        'Moldova',
        'Monaco',
        'Mongolia',
        'Montenegro',
        'Morocco',
        'Mozambique',
        'Namibia',
        'Nauru',
        'Nepal',
        'Netherlands',
        'New Zealand',
        'Nicaragua',
        'Niger',
        'Nigeria',
        'North Korea',
        'Norway',
        'Oman',
        'Pakistan',
        'Palau',
        'Palestinian Territories',
        'Panama',
        'Papua New Guinea',
        'Paraguay',
        'Peru',
        'Philippines',
        'Poland',
        'Portugal',
        'Qatar',
        'Romania',
        'Russia',
        'Rwanda',
        'Saint Kitts and Nevis',
        'Saint Lucia',
        'Saint Vincent and the Grenadines',
        'Samoa',
        'San Marino',
        'Sao Tome and Principe',
        'Saudi Arabia',
        'Senegal',
        'Serbia',
        'Seychelles',
        'Sierra Leone',
        'Singapore',
        'Sint Maarten',
        'Slovakia',
        'Slovenia',
        'Solomon Islands',
        'Somalia',
        'South Africa',
        'South Korea',
        'South Sudan',
        'Spain',
        'Sri Lanka',
        'Sudan',
        'Suriname',
        'Swaziland',
        'Sweden',
        'Switzerland',
        'Syria',
        'Taiwan',
        'Tajikistan',
        'Tanzania',
        'Thailand',
        'Timor-Leste',
        'Togo',
        'Tonga',
        'Trinidad and Tobago',
        'Tunisia',
        'Turkey',
        'Turkmenistan',
        'Tuvalu',
        'Uganda',
        'Ukraine',
        'United Arab Emirates',
        'United Kingdom (UK)',
        'United States of America (USA)',
        'Uruguay',
        'Uzbekistan',
        'Vanuatu',
        'Venezuela',
        'Vietnam',
        'Yemen',
        'Zambia',
        'Zimbabwe',
    );
    return $countries; 
}


function currency_codes() {
    $currencies = array (
        'Albania Lek' => '76',
        'Afghanistan Afghani' => '1547',
        'Argentina Peso' => '36',
        'Aruba Guilder' => '402',
        'Australia Dollar' => '36',
        'Azerbaijan New Manat' => '1084',
        'Bahamas Dollar' => '36',
        'Barbados Dollar' => '36',
        'Belarus Ruble' => '66',
        'Belize Dollar' =>  '66',
        'Bermuda Dollar' => '36',
        'Bolivia Bolíviano' => '36',
        'Bosnia & Herzegovina Convertible Marka' => '75',
        'Botswana Pula' => '80',
        'Bulgaria Lev' => '1083',
        'Brazil Real' => '82',
        'Brunei Darussalam Dollar' => '36',
        'Cambodia Riel' =>  '6107',
        'Canada Dollar' =>  '36',
        'Cayman Islands Dollar' =>  '36',
        'Chile Peso'    =>  '36',
        'China Yuan Renminbi'   =>  '165',
        'Colombia Peso' =>  '36',
        'Costa Rica Colon'  =>  '8353',
        'Croatia Kuna'  =>  '107',
        'Cuba Peso' =>  '8369',
        'Czech Republic Koruna' =>  '75',
        'Denmark Krone' =>  '107',
        'Dominican Republic Peso'   =>  '82',
        'East Caribbean Dollar' =>  '36',
        'Egypt Pound'   =>  '163',
        'El Salvador Colon' =>  '36',
        'Euro Member Countries' =>  '8364',
        'Falkland Islands (Malvinas) Pound' =>  '163',
        'Fiji Dollar'   =>  '36',
        'Ghana Cedi'    =>  '162',
        'Gibraltar Pound'   =>  '163',
        'Guatemala Quetzal' =>  '81',
        'Guernsey Pound'    =>  '163',
        'Guyana Dollar' =>  '36',
        'Honduras Lempira'  =>  '76',
        'Hong Kong Dollar'  =>  '36',
        'Hungary Forint'    =>  '70',
        'Iceland Krona' =>  '107',
        'India Rupee'   =>  '8377',
        'Indonesia Rupiah'  =>  '82',
        'Iran Rial' =>  '65020',
        'Isle of Man Pound' =>  '163',
        'Israel Shekel' =>  '8362',
        'Jamaica Dollar'    =>  '74',
        'Japan Yen' =>  '165',
        'Jersey Pound'  =>  '163',
        'Kazakhstan Tenge'  =>  '1083',
        'Korea (North) Won' =>  '8361',
        'Korea (South) Won' =>  '8361',
        'Kyrgyzstan Som'    =>  '1083',
        'Laos Kip'  =>  '8365',
        'Lebanon Pound' =>  '163',
        'Liberia Dollar'    =>  '36',
        'Macedonia Denar'   =>  '1076',
        'Malaysia Ringgit'  =>  '82',
        'Mauritius Rupee'   =>  '8360',
        'Mexico Peso'   =>  '36',
        'Mongolia Tughrik'  =>  '8366',
        'Mozambique Metical'    =>  '77',
        'Namibia Dollar'    =>  '36',
        'Nepal Rupee'   =>  '8360',
        'Netherlands Antilles Guilder'  =>  '402',
        'New Zealand Dollar'    =>  '36',
        'Nicaragua Cordoba' =>  '67',
        'Nigeria Naira' =>  '8358',
        'Korea (North) Won' =>  '8361',
        'Norway Krone'  =>  '107',
        'Oman Rial' =>  '65020',
        'Pakistan Rupee'    =>  '8360',
        'Panama Balboa' =>  '66',
        'Paraguay Guarani'  =>  '71',
        'Peru Sol'  =>  '83',
        'Philippines Peso'  =>  '8369',
        'Poland Zloty'  =>  '122',
        'Qatar Riyal'   =>  '65020',
        'Romania New Leu'   =>  '108',
        'Russia Ruble'  =>  '1088',
        'Saint Helena Pound'    =>  '163',
        'Saudi Arabia Riyal'    =>  '65020',
        'Serbia Dinar'  =>  '1044',
        'Seychelles Rupee'  =>  '8360',
        'Singapore Dollar'  =>  '36',
        'Solomon Islands Dollar'    =>  '36',
        'Somalia Shilling'  =>  '83',
        'South Africa Rand' =>  '82',
        'Korea (South) Won' =>  '8361',
        'Sri Lanka Rupee'   =>  '8360',
        'Sweden Krona'  =>  '107',
        'Switzerland Franc' =>  '67',
        'Suriname Dollar'   =>  '36',
        'Syria Pound'   =>  '163',
        'Taiwan New Dollar' =>  '78',
        'Thailand Baht' =>  '3647',
        'Trinidad and Tobago Dollar'    =>  '84',
        'Turkey Lira'   =>  '8378',
        'Tuvalu Dollar' =>  '36',
        'Ukraine Hryvnia'   =>  '8372',
        'United Kingdom Pound'  =>  '163',
        'United States Dollar'  =>  '36',
        'Uruguay Peso'  =>  '36',
        'Uzbekistan Som'    =>  '1083',
        'Venezuela Bolivar' =>  '66',
        'Viet Nam Dong' =>  '8363',
        'Yemen Rial'    =>  '65020',
        'Zimbabwe Dollar'   =>  '90',
    );
    return $currencies;
}


function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => $ipdat->geoplugin_city,
                        "state"          => $ipdat->geoplugin_regionName,
                        "country"        => $ipdat->geoplugin_countryName,
                        "country_code"   => $ipdat->geoplugin_countryCode,
                        "continent"      => $continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => $ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = $ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = $ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = $ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = $ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = $ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}


function ip_info_safe($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        // $ip = "129.205.124.65";//remove when done;
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}