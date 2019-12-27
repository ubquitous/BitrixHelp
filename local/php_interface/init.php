<?php
\Bitrix\Main\Loader::registerAutoloadClasses(
    null,
    array(
        "Custom\\Highload" => "/local/classes/Highload.php"
    )
);
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"] . "/log.txt");

