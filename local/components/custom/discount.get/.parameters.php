<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"TIME_LIMIT" => Array(
			"NAME" => GetMessage("PARAMS_TIME_LIMIT"),
			"TYPE" => "STRING",
			"DEFAULT" => 180,
			"PARENT" => "BASE",
		),
	),
);
?>