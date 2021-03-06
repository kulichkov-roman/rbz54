<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */

$this->setFrameMode(true);
$sTemplateId = spl_object_hash($this);

$sTitle = ArrayHelper::getValue($arParams, 'TITLE');
$bDisplayTitle = ArrayHelper::getValue($arParams, 'DISPLAY_TITLE') == 'Y' && !empty($sTitle);
$bTitleCenter = ArrayHelper::getValue($arParams, 'ALIGN_TITLE') == 'Y';

$sDescription = ArrayHelper::getValue($arParams, 'DESCRIPTION');
$bDisplayDescription = ArrayHelper::getValue($arParams, 'DISPLAY_DESCRIPTION') == 'Y' && !empty($sDescription);
$bDescriptionCenter = ArrayHelper::getValue($arParams, 'ALIGN_DESCRIPTION') == 'Y';

?>
<div class="intec-content">
    <div class="intec-content-wrapper">
        <div class="widget-news" id="<?= $sTemplateId ?>">
            <?php if ($bDisplayTitle) { ?>
                <div class="widget-news-title <?= $bTitleCenter ? 'text-center' : null; ?>">
                    <?= $sTitle ?>
                </div>
            <?php } ?>
            <?php if ($bDisplayDescription) { ?>
                <div class="description <?= $bDescriptionCenter ? 'text-center' : null ?>">
                    <?= $sDescription ?>
                </div>
            <?php } ?>
            <div class="widget-news-desktop">
                <?php $sType = 'desktop';
                require('views/'.$arParams['VIEW_DESKTOP'].'.php') ?>
            </div>
            <?php if (!defined('EDITOR')) { ?>
                <div class="widget-news-mobile">
                    <?php $sType = 'mobile' ?>
                    <?php require('views/'.$arParams['VIEW_MOBILE'].'.php') ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
