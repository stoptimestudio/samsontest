<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"TIME_LIMIT" => Array(
			"NAME" => GetMessage("PARAMS_TIME_LIMIT"),
			"TYPE" => "STRING",
			"DEFAULT" => 60,
			"PARENT" => "BASE",
		),
		"DISCOUNT_MIN" => Array(
			"NAME" => GetMessage("PARAMS_DISCOUNT_MIN"),
			"TYPE" => "STRING",
			"DEFAULT" => 1,
			"PARENT" => "BASE",
		),
		"DISCOUNT_MAX" => Array(
			"NAME" => GetMessage("PARAMS_DISCOUNT_MAX"),
			"TYPE" => "STRING",
			"DEFAULT" => 50,
			"PARENT" => "BASE",
		),				
	),
);
?>