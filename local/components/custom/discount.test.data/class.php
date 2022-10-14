<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Application;

class CheckDiscountManager extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams): array {
        if (!$arParams['USER_COUNT'])
			$arParams['USER_COUNT'] = 5;
		return $arParams;
    }

    public function executeComponent(): void {
        $request = Application::getInstance()->getContext()->getRequest();
        $this->arResult['FORM_CREATE'] = $request->get("create");       
        if ($request->get("create") && check_bitrix_sessid()) {
            $this->arResult['USERS'] = $this->createUsers();
        }
        $this->includeComponentTemplate();
    }

	private function createUsers(): array {
		$arUsers = [];
		if ($this->arParams['USER_COUNT']) {
			for ($i=0; $i<$this->arParams['USER_COUNT']; $i++) {
				$arUsers[] = $this->createUser();
			}
		}
		return $arUsers;
	}

	private function createUser(): array {
		global $USER;
		$email = $this->generateEmail();
		$password = $this->generatePassword();
		$def_group = COption::GetOptionString("main", "new_user_registration_def_group", "");
		if ($def_group) {
			$arGroups = explode(",", $def_group);
		}
		$arFileds = [
			"LOGIN" => $email,
			"EMAIL" => $email,
			"ACTIVE" => "Y",
			"LID" => SITE_ID,
			"GROUP_ID" => $arGroups,
			"PASSWORD" => $password,
			"CONFIRM_PASSWORD" => $password,
		];
		$user = new CUser;
		if ($user_id = $user->add($arFileds)) 
			return ['ID' => $user_id, 'LOGIN' => $email, 'PASSWORD' => $password];
		else 
			throw new \Exception($user->LAST_ERROR);
	}

	private function generateEmail(): string {
		return randString(5, "abcdefghijklnmopqrstuvwxyz").randString(2, "0123456789").'@site.com';
	}

	private function generatePassword(): string {
		return randString(10, ["abcdefghijklnmopqrstuvwxyz", "ABCDEFGHIJKLNMOPQRSTUVWXYZ", "0123456789", "!@#\$%^&*()"]);
	}	
};

?>