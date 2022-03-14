<?php
header("Content-Type: application/json;charset=utf-8");

$dom = new DOMDocument();
$dom->load("http://www.ign.es/ign/RssTools/sismologia.xml");

$result = array();

$items = $dom->getElementsByTagName("item");

foreach ($items as $item) {
    $arr = array();
    $title = $item->getElementsByTagName("title")[0]->nodeValue;
    $title = str_replace("-Info.terremoto: ", "", $title);

    $arr["date"] = substr($title, 0, 10);
    $arr["time"] = substr($title, 11);
    $arr["link"] = $item->getElementsByTagName("link")[0]->nodeValue;
    $description = $item->getElementsByTagName("description")[0]->nodeValue;
    $arr["description"] = $description;

    $arr["magnitude"] = substr($description, strpos($description, "magnitud") + 9, 3);
    $location = substr($description, strpos($description, "en") + 3);
    $location = substr($location, 0, strpos($location, "en") - 1);
    $arr["location"] = $location;

    $arr["lat"] = $item->getElementsByTagName("lat")[0]->nodeValue;
    $arr["long"] = $item->getElementsByTagName("long")[0]->nodeValue;
    $result[] = $arr;
}
/*
echo "<pre>";
print_r($result);
echo "</pre>";
*/
echo json_encode($result);