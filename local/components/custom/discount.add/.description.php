<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("COMPONENT_NAME"),
	"DESCRIPTION" => GetMessage("COMPONENT_DESCRIPTION"),
	"ICON" => "/images/icon.gif",
	"SORT" => 10,
	"PATH" => array(
		"ID" => "custom",
		"NAME" => GetMessage("COMPONENT_SECTION_NAME"),
	),
	"COMPLEX" => "N",
);

?>