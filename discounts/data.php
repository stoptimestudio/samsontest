<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");

CModule::IncludeModule('sale');
echo '<pre>';
print_r(CSaleDiscount::GetByID(9));
print_r(unserialize(CSaleDiscount::GetByID(9)['ACTIONS']));
print_r(unserialize(CSaleDiscount::GetByID(9)['CONDITIONS']));
echo '</pre>';
?>

<?/*$APPLICATION->IncludeComponent(
	"custom:discount.test.data",
	"",
	Array()
);*/?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>