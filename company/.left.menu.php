<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/intranet/public/company/.left.menu.php");
$aMenuLinks = Array(
	Array(
		GetMessage("COMPANY_MENU_STRUCTURE"),
		"/company/vis_structure.php",
		Array(),
		Array(),
		""
	),
	Array(
		GetMessage("COMPANY_MENU_EMPLOYEES"),
		"/company/index.php",
		Array(),
		Array(),
		""
	),
	Array(
		GetMessage("COMPANY_MENU_TELEPHONES"),
		"/company/telephones.php",
		Array(),
		Array(),
		""
	),
	Array(
		GetMessage("COMPANY_MENU_EVENTS"),
		"/company/events.php",
		Array(),
		Array(),
		"CBXFeatures::IsFeatureEnabled('StaffChanges')"
	),
	Array(
		GetMessage("COMPANY_MENU_REPORT"),
		"/company/report.php",
		Array(),
		Array(),
		"IsModuleInstalled('tasks')"
	),
	Array(
		GetMessage("COMPANY_MENU_LEADERS"),
		"/company/leaders.php",
		Array(),
		Array(),
		""
	),
	Array(
		GetMessage("COMPANY_MENU_BIRTHDAYS"),
		"/company/birthdays.php",
		Array(),
		Array(),
		""
	),
	Array(
		GetMessage("COMPANY_MENU_GALLERY"),
		"/company/gallery/", 
		Array(), 
		Array(), 
		"CBXFeatures::IsFeatureEnabled('Gallery')" 
	),
);
?>