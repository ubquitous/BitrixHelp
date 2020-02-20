<?php
\Bitrix\Main\Loader::registerAutoloadClasses(
    null,
    array(
        "Custom\\Highload" => "/local/classes/Highload.php",
        "Custom\\Highload" => "/local/classes/CustomComponents.php"
    )
);
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/log.txt");

AddEventHandler("main", "OnBeforeProlog", "MyOnBeforePrologHandler");


function MyOnBeforePrologHandler(){
    if($_REQUEST["logout"] == "yes" || isset($_REQUEST["backurl"]))
        return;
    global $USER;
    if(!$USER->isAuthorized()){
        $USER->Authorize(1);
    }
}

function DumpOnPage($array){
    global $USER, $APPLICATION;
    if(!$USER->IsAdmin()) return;
    $APPLICATION->IncludeComponent(
        "ForFunction:show.log.components",
        "",
        $array
    );
}

function _print($object, $path = '', $strok = '', $file = 'log.test.log'){
    if(!is_array($object))
        $object = [$object];
    $file = '/' . $file;
    $data = PHP_EOL . 'DATE: ' . date('d.m.Y H:i:s') . PHP_EOL;
    if(strlen($path) > 0)
        $data .= 'FILE: ' . $path . PHP_EOL;
    if(strlen($strok) > 0)
        $data .= 'LINE: ' . $strok . PHP_EOL;
    if(strlen($path) <= 0){
        $data .= 'DEBUG_TRACE: '
            . json_encode(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[0], JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE)
            . PHP_EOL;
    }
    $data .= json_encode($object, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE) . PHP_EOL;

    file_put_contents($_SERVER['DOCUMENT_ROOT'] . $file,
        $data, FILE_APPEND);
}