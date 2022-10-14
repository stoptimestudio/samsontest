<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div>
    <?if ($arResult['COUPON']) {?>
        <div class="discount_result_info">
            <p><?=GetMessage('COMP_TEMPLATE_GET_COUPON')?>: <?=$arResult['COUPON']['COUPON']?></p>
            <p><?=$arResult['COUPON']['DESCRIPTION']?></p>
        </div>
    <?} elseif($arResult['FORM_CHECK']) {?>
        <div class="discount_result_info">
            <p><?=GetMessage('COMP_TEMPLATE_GET_NOT_AVAILABLE')?></p>
        </div>
    <?}?>
    <div class="discount_description"><?=GetMessage('COMP_TEMPLATE_GET_DESCRIPTION')?></div>
    <form action="<?=POST_FORM_ACTION_URI?>" method="POST">
        <?=bitrix_sessid_post()?>
        <p><input type="text" name="coupon" placeholder="<?=GetMessage('COMP_TEMPLATE_GET_PLACEHOLDER')?>" value="<?=$arResult['FORM_COUPON']?>"></p>
        <p><input class="btn btn-primary btn-md" type="submit" name="check" value="<?=GetMessage('COMP_TEMPLATE_GET_SUBMIT_VALUE')?>"></p>
    </form>
</div>