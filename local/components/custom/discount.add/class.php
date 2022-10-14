<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Application;
use Bitrix\Main\Loader;

class TestDiscountManager extends CBitrixComponent
{
    protected $discountNumb;
    protected $userGroups;
    protected $discountId;
    protected $couponCode;
    protected $globUser;

    protected function checkModules(): void {
        global $USER;
        $this->globUser = $USER;
        if (!Loader::includeModule('sale')) {
            throw new \Exception(GetMessage('COMP_CLASS_DONT_MODULES'));
        }
    }

    public function onPrepareComponentParams($arParams): array {
        if (!$arParams['TIME_LIMIT'])
			$arParams['TIME_LIMIT'] = 60;
        if (!$arParams['DISCOUNT_MIN'])
			$arParams['DISCOUNT_MIN'] = 1;
        if (!$arParams['DISCOUNT_MAX'])
			$arParams['DISCOUNT_MAX'] = 50;            
		return $arParams;
    }

    public function executeComponent(): void {
        $this->checkModules();
        $request = Application::getInstance()->getContext()->getRequest();
        if (
            $request->get("send") && 
            $this->checkUserAuthorize() && 
            check_bitrix_sessid()            
        ) {
            $this->arResult['COUPON'] = $this->getActiveCoupon();
            if (!$this->arResult['COUPON']) {
                $this->discount_numb = $this->getRandomDiscountNumb();
                $this->$discountId = $this->getExistsDiscount();
                if (!$this->$discountId)
                    $this->$discountId = $this->discountAdd();
                if ($this->$discountId) {
                    $this->arResult['COUPON'] = $this->couponAdd();
                }
            }
        }
        $this->includeComponentTemplate();
    }

    protected function getActiveCoupon(string $coupon = ''): ?array {
        $dateLimit = new \Bitrix\Main\Type\DateTime();
        $dateLimit = $dateLimit->add(($this->arParams['TIME_LIMIT']*-1)." minutes");
        $arFilter = [
            'USER_ID' => $this->getUserId(),
            ">=ACTIVE_FROM" => $dateLimit,
        ];
        if ($coupon) {
            $arFilter['COUPON'] = $coupon;
        }
        $dbCoupons = \Bitrix\Sale\Internals\DiscountCouponTable::getList([
            'order' => ['ID' => 'DESC'],
            'filter' => $arFilter,
        ]);
        if($arCoupon = $dbCoupons->fetch()) {
            return $arCoupon;
        } else {
            return null;
        }
    }

    private function getExistsDiscount(): ?int {
        if ($this->discount_numb) {
            $arDiscount = CSaleDiscount::GetList(['ID' => 'DESC'], ['XML_ID'=>'DISCOUNT_'.$this->discount_numb.'%'])->fetch();
            if ($arDiscount['ID'])
                return $arDiscount['ID'];                
        }
        return null;
    }

    protected function checkUserAuthorize(): bool {
        return $this->globUser->IsAuthorized();
    }

    private function getUserId(): int {
        return $this->globUser->GetId();
    }      

    private function getUserGroups(): array {
        return $this->globUser->GetUserGroupArray();
    }       

    private function getRandomDiscountNumb(): int {
        return rand($this->arParams['DISCOUNT_MIN'], $this->arParams['DISCOUNT_MAX']);
    }

    private function discountAdd(): ?int {     
        $this->userGroups = $this->getUserGroups();        
        $arFields = array(
            "LID" => Application::getInstance()->getContext()->getSite(),
            "NAME" => $this->discount_numb."% ".GetMessage('COMP_CLASS_DISCOUNTS')." ".date("d.m.y"),               
            "CURRENCY" => "RUB",
            "ACTIVE" => "Y",
            "USER_GROUPS" => $this->userGroups,        
            'ACTIONS' => $this->getDiscountActionsArray(),
            "CONDITIONS" => $this->getDiscountConditionsArray(),
            "XML_ID" => "DISCOUNT_".$this->discount_numb."%",
        );
        if ($discountID = CSaleDiscount::Add($arFields)) {
            return $discountID;
        } else {
            return null;
        }
    }

    private function getDiscountActionsArray(): array {
        $arActions = [
            "CLASS_ID" => "CondGroup",
            "DATA" => [
                "All" => "AND"
            ],
            "CHILDREN" => [
                [
                    "CLASS_ID" => "ActSaleBsktGrp",
                    "DATA" => [
                        "Type" => "Discount",
                        "Value" => $this->discount_numb,
                        "Unit" => "Perc",
                        "Max" => 0,
                        "All" => "OR",
                        "True" => "True",                    
                    ],
                ],
            ],
        ];
        return $arActions;
    }

    private function getDiscountConditionsArray(): array {
        $arConditions = [
            "CLASS_ID" => "CondGroup",
            "DATA" => [
                "All" => "AND",
                "True" => "True",
            ],
            "CHILDREN" => [],
        ];
        return $arConditions;
    }

    private function couponAdd(): ?array {
        if ($this->$discountId > 0) {
            $this->couponCode = CatalogGenerateCoupon();
            $activeFrom = new \Bitrix\Main\Type\DateTime();
			$activeTo = new \Bitrix\Main\Type\DateTime();
			$activeTo = $activeTo->add($this->arParams['TIME_LIMIT']." minutes");            
            $couponFields = [
                "DISCOUNT_ID" => $this->$discountId,
                "COUPON" => $this->couponCode,
                "ACTIVE" => "Y",
                "TYPE" => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_MULTI_ORDER,
                "USER_ID" => $this->getUserId(),
                "ACTIVE_FROM" => $activeFrom,
                "ACTIVE_TO" => $activeTo,
                "MAX_USE" => 0,
                "DESCRIPTION" => GetMessage('COMP_CLASS_PROCENT_DISCOUNT')." ".$this->discount_numb."%",
            ];
            $addCouponRes = \Bitrix\Sale\Internals\DiscountCouponTable::add($couponFields);
            if (!$addCouponRes->isSuccess()){
                $this->arResult['ERROR'] = $addCouponRes->getErrorMessages();
                return null;
            } else {
                return $couponFields;
            }
        }
    }
    
};
?>