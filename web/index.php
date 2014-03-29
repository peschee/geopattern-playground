<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Klein\Klein;
use Lex\Parser;
use RedeyeVentures\GeoPattern\GeoPattern;

$klein = new Klein();
$parser = new Parser();

$klein->respond('GET', '/', function ($request) use ($parser) {
    return nl2br("Feed me something.\n\n[GET] /[:string]");
});

$klein->respond('GET', '/[:string]', function ($request) use ($parser) {
    $geopattern = new GeoPattern();
    $geopattern->setString($request->string);
    $base64 = $geopattern->toBase64();

    return $parser->parse(file_get_contents(__DIR__ . '/../view/string.html.lex'), array('base64' => $base64));
});

$klein->dispatch();
