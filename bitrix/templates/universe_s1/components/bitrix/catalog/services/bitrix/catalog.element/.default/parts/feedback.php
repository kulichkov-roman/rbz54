<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $sTemplateId
 */

?>
<div class="service-feedback clearfix">
    <div class="service-feedback-body">
        <div class="title-form pull-left">
            <?= GetMessage('SRVICE_FEEDBACK_TITLE');?>
        </div>
        <div class="separate intec-cl-background pull-left">
        </div>
        <div class="text pull-left">
            <?=GetMessage("SRVICE_FEEDBACK_TEXT");?>
        </div>
        <div class="pull-right button-feedback">
            <a class="intec-button-md intec-button intec-button-cl-common" onclick="universe.forms.show(<?= JavaScript::toObject([
                'id' => $arParams['FEEDBACK_FORM_ID'],
                'template' => 'popup',
                'parameters' => [
                    'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'_FORM_FEEDBACK'
                ],
                'settings' => [
                    'title' => GetMessage("SRVICE_FEEDBACK_BUTTON")
                ]
            ]) ?>)">
                <?= GetMessage("SRVICE_FEEDBACK_BUTTON") ?>
            </a>

        </div>
    </div>
</div>