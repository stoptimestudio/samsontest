<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>

<div>
    <?if ($arResult['COUPON']) {?>
        <div class="discount_result_info">
            <p><?=GetMessage('COMP_TEMPLATE_COUPON')?>: <?=$arResult['COUPON']['COUPON']?></p>
            <p><?=$arResult['COUPON']['DESCRIPTION']?></p>
        </div>
    <?}?>
    <div class="discount_description"><?=GetMessage('COMP_TEMPLATE_DESCRIPTION')?></div>
    <form action="<?=POST_FORM_ACTION_URI?>" method="POST">
        <?=bitrix_sessid_post()?>
        <p><input class="btn btn-primary btn-md" type="submit" name="send" value="<?=GetMessage('COMP_TEMPLATE_SUBMIT_VALUE')?>"></p>
    </form>
</div>