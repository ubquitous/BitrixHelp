<?php
\Bitrix\Main\Loader::registerAutoloadClasses(
    null,
    array(
        "Custom\\Highload" => "/local/classes/Highload.php"
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