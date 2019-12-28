<?php

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

global $APPLICATION;

$APPLICATION->IncludeComponent(
    "custom:all.components",
    "",
    []
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");