<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>

<div>
    <?if ($arResult['USERS']) {?>
        <div class="result">
            <?foreach($arResult['USERS'] as $i=>$arUser) {?>
                <p><?=++$i?>. <?=GetMessage('COMP_TEMPLATE_LOGIN')?>: <?=$arUser['LOGIN']?><br><?=GetMessage('COMP_TEMPLATE_PASSWORD')?>: <?=$arUser['PASSWORD']?></p>
            <?}?>
        </div>
    <?}?>
    <form action="<?=POST_FORM_ACTION_URI?>" method="POST">
        <?=bitrix_sessid_post()?>
        <p><input class="btn btn-primary btn-md" type="submit" name="create" value="<?=GetMessage('COMP_TEMPLATE_SUBMIT_VALUE', ['#USER_COUNT#'=>$arParams['USER_COUNT']])?>"></p>
    </form>
</div>