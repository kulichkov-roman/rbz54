<?php
/**
 * @var array $arResult
 * @var array $arParams
 */

use \intec\core\helpers\Html;
use intec\constructor\models\Build;
?>
<?
$oBuild = Build::getCurrent();
if (!empty($oBuild)) {
    $oPage = $oBuild->getPage();
    $oProperties = $oPage->getProperties();
    $personal_data = $oProperties->get('inform_about_processing_personal_data');
}
?>
<div class="intec-web-form">
    <?php if ($arResult['isFormNote'] == 'Y') { ?>
        <div class="contacts-form-note">
            <?= $arResult["FORM_NOTE"] ?>
        </div>
    <?php } else { ?>
        <?= $arResult['FORM_HEADER'] ?>

        <?php if ($arResult["isFormErrors"] == 'Y') { ?>
            <div class="contacts-form-error">
                <?= $arResult["FORM_ERRORS_TEXT"] ?>
            </div>
        <?php } ?>

        <div class="intec-form-description"><?= $arResult['arForm']['DESCRIPTION'] ?></div>

        <?php foreach ($arResult['QUESTIONS'] as $question) { ?>
            <div class="intec-form-field">
                <div class="intec-form-caption">
                    <?= $question['CAPTION'] . ($question['REQUIRED'] == 'Y' ? $arResult['REQUIRED_SIGN'] : '') ?>
                    <?= $question['IS_INPUT_CAPTION_IMAGE'] == 'Y' ? '<br />'. $question['IMAGE']['HTML_CODE'] : '' ?>
                </div>
                <div class="intec-form-value">
                    <?= $question['HTML_CODE'] ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($arResult['isUseCaptcha'] == 'Y') { ?>
            <div class="contacts-form-field contacts-form-field-captcha">
                <div class="contacts-form-field-title">
                    <?= GetMessage('F_R_N_POPUP_FIELD_CAPTCHA') ?> *
                </div>
                <div class="contacts-form-field-content intec-form-value">
                    <input type="hidden" name="captcha_sid" value="<?= Html::encode($arResult["CAPTCHACode"]) ?>" />
                    <div class="contacts-form-captcha-image">
                        <img src="/bitrix/tools/captcha.php?captcha_sid=<?= Html::encode($arResult["CAPTCHACode"]) ?>" width="180" height="40" />
                    </div>
                    <input type="text" name="captcha_word" size="30" maxlength="50" value="" />
                </div>
            </div>
        <?php } ?>

        <?if($personal_data) {?>
            <div class="consent">
                <div class="intec-contest-checkbox checked" style="margin-right: 5px; float: left;"></div>
                <?=GetMessage("CONTEST_TEXT");?>

            </div>
        <?}?>

        <div class="intec-form-buttons-wrap">
            <input <?= intval($arResult['F_RIGHT']) < 10 ? "disabled=\"disabled\"" : '' ?>
                   class="intec-button intec-button-cl-common intec-button-s-6"
                   type="submit"
                   name="web_form_submit"
                   value="<?= htmlspecialcharsbx(strlen(trim($arResult['arForm']['BUTTON'])) <= 0 ? GetMessage('FORM_ADD') : $arResult['arForm']['BUTTON']) ?>" />
            &nbsp;<input class="intec-button intec-button-cl-common intec-button-s-6" type="reset" value="<?= GetMessage('FORM_RESET') ?>" />
        </div>
    <?php } ?>

    <?= $arResult['FORM_FOOTER'] ?>
</div>
