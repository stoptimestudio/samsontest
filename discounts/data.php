<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тестовые данные");
?>

<?$APPLICATION->IncludeComponent(
	"custom:discount.test.data",
	"",
	Array(
		"USER_COUNT" => 5,
		"AJAX_MODE" => "Y",
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>