<?php


// Chargement manuel de Faker
require_once __DIR__ . '/faker/autoload.php';
use Faker\Factory;

// Initialiser Faker
$faker = Factory::create('en_US');

// Pays avec probabilité modifiée
$countries = array_merge(
    array_fill(0, 24, 'France'),
    array_fill(0, 15, 'United States'),
    ['Germany','Spain','Italy','Netherlands','Belgium','Canada','Australia','Japan','Brazil','India','Mexico',
     'Sweden','Norway','Denmark','Finland','Poland','Switzerland','Ireland','Austria','Portugal','Russia',
     'South Korea','Argentina','Turkey','China','New Zealand','South Africa','Indonesia','Greece','Ukraine',
     'Hungary','Czech Republic','Romania','Thailand','Vietnam','Philippines','Malaysia','Singapore','Colombia','Chile','Peru']
);

$antivirus = ["Windows Defender","Kaspersky","Norton","Bitdefender","McAfee","Avast","AVG","ESET NOD32",
"Trend Micro","F-Secure","Sophos","Webroot","Panda","Malwarebytes","Comodo","ZoneAlarm","G Data","Avira",
"BullGuard","Immunet","Dr.Web","ClamAV","Vipre","Tencent","Fortinet","360 Total Security","Adaware","AhnLab",
"PC Matic","Zemana","Spybot","Bkav","SecureAge","Cylance","CrowdStrike Falcon","NRVEye","Carbon Black",
"SentinelOne","Check Point","Bitglass","Cybereason"];

$brands = ["Dell","HP","Asus","Acer","Lenovo","MSI","Gigabyte","Alienware","Samsung","Toshiba","Fujitsu","Sony","Razer","Microsoft","Intel","AMD"];
$types  = ["Laptop","Desktop","Notebook","Server","Workstation","MiniPC","Tower","GamingRig","HomePC","ProStation"];

function randomTimestamps() {
    $now = time();
    $offsets = [rand(60,7200), rand(5*86400,6*86400), rand(180*86400,365*86400)];
    $last = $now - $offsets[array_rand($offsets)];
    $infected = $last - rand(0,3*365*86400);
    return [$last, $infected];
}

function generateUsername($faker) {
    $base = $faker->userName;
    $prefix = rand(0,1)?rand(1,99):'';
    if (rand(0,1)) {
        $extra = ["",".","_","-",rand(10,9999)][rand(0,4)];
        return $prefix . $base . $extra . $faker->word;
    }
    return $prefix . $base;
}

function generatePCName($faker, $brands, $types) {
    $p = [];
    $r = rand(0,4);
    if ($r===0) $p[]=$faker->firstName;
    elseif ($r===1) $p[]=$faker->userName;
    else $p[]=$brands[array_rand($brands)];
    if (rand(0,1)) $p[]=$types[array_rand($types)];
    if (rand(0,1)) $p[] = strtoupper($faker->bothify('??##'));
    shuffle($p);
    return implode(rand(0,1)?'-':'',$p);
}

function generateBotData($faker,$countries,$brands,$types,$antivirus) {
    list($last,$infected)=randomTimestamps();
    return [
        "request"=>"request",
        "API_KEY"=>"TESTAPIKEY",
        "HWID"=>substr($faker->sha1,0,20),
        "USER_TOKEN"=>"USER_".substr($faker->sha1,0,20),
        "GROUP_TOKEN"=>"GROUP_".substr($faker->sha1,0,20),
        "PCNAME"=>generatePCName($faker,$brands,$types),
        "USERNAME"=>generateUsername($faker),
        "BUSY"=>rand(0,1),
        "ANTI_VIRUS"=>$antivirus[array_rand($antivirus)],
        "IP"=>$faker->ipv4,
        "COUNTRY"=>$countries[array_rand($countries)],
        "LASTREQUEST"=>$last,
        "ONLINE"=>$last,
        "INFECTEDDATE"=>$infected,
        "REQUEST"=>rand(0,250000)
    ];
}

// Générer un bot
$botData = generateBotData($faker,$countries,$brands,$types,$antivirus);

// Affichage JSON local
header('Content-Type: application/json');
echo json_encode($botData, JSON_PRETTY_PRINT);

// Envoi de la requête Alive vers l’API PHP
$url = "http://localhost/RevBot/?p=api";

$opts = [
    "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/x-www-form-urlencoded",
        "content" => http_build_query($botData)
    ]
];

$context  = stream_context_create($opts);
$response = file_get_contents($url, false, $context);

// Log réponse API
file_put_contents("last_alive_response.txt", $response);
