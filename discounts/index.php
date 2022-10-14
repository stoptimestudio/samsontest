<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Функционал скидок");
?>
<h2>Добавление скидки</h2>
<?$APPLICATION->IncludeComponent(
	"custom:discount.add",
	"",
	Array(
		"TIME_LIMIT" => "60",
		"DISCOUNT_MIN" => 1,
		"DISCOUNT_MAX" => 50,
		"AJAX_MODE" => "Y",
	)
);?>

<br><br>
<h2>Проверка скидки</h2>
<?$APPLICATION->IncludeComponent(
	"custom:discount.get",
	"",
	Array(
		"TIME_LIMIT" => "180",
		"AJAX_MODE" => "Y",
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>