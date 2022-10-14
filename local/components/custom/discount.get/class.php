<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Application;

CBitrixComponent::includeComponentClass("custom:discount.add");
class CheckDiscountManager extends TestDiscountManager
{
    public function onPrepareComponentParams($arParams): array {
        if (!$arParams['TIME_LIMIT'])
			$arParams['TIME_LIMIT'] = 180;
		return $arParams;
    }

    public function executeComponent(): void {
        parent::checkModules();
        $request = Application::getInstance()->getContext()->getRequest();
        $this->arResult['FORM_CHECK'] = $request->get("check");
        $this->arResult['FORM_COUPON'] = trim($request->get("coupon"));        
        if ($request->get("check") && $this->arResult['FORM_COUPON'] && check_bitrix_sessid() && parent::checkUserAuthorize()) {
            $this->arResult['COUPON'] = parent::getActiveCoupon($this->arResult['FORM_COUPON']);
        }
        $this->includeComponentTemplate();
    }
};

?>