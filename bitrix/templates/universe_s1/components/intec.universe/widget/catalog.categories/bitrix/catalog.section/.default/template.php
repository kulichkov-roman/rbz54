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

$bShowTitle = ArrayHelper::getValue($arParams, 'DISPLAY_TITLE') == 'Y' && !empty($arParams['TITLE']);
$bTitleCenter = ArrayHelper::getValue($arParams, 'TITLE_ALIGN') == 'Y';

$bShowDescription = ArrayHelper::getValue($arParams, 'DISPLAY_DESCRIPTION') == 'Y' && !empty($arParams['DESCRIPTION']);
$bDescriptionCenter = ArrayHelper::getValue($arParams, 'DESCRIPTION_ALIGN') == 'Y';

$oFrame = $this->createFrame() ?>
<div class="intec-content widget-catalog-categories">
    <div class="intec-content-wrapper">
        <?php $oFrame->begin() ?>
            <?php switch($arParams["COUNT_ELEMENT_IN_ROW"]) {
                case "three":
                    $count_elements = 3;
                    break;
                case "four" :
                    $count_elements = 4;
                    break;
                case "five" :
                    $count_elements = 5;
                    break;
                default:
                    $count_elements = 4;
                    break;
            } ?>
            <?php if ($bShowTitle) { ?>
                <div class="title <?= $bTitleCenter ? 'text-center' : null ?>">
                    <?=$arParams["TITLE"]?>
                </div>
            <?php } ?>
            <?php if ($bShowDescription) { ?>
                <div class="description <?= $bDescriptionCenter ? 'text-center' : null ?>">
                    <?= $arParams["DESCRIPTION"] ?>
                </div>
            <?php } ?>
            <div class="widget-catalog-categories" id="<?= $sTemplateId ?>">
                <div class="widget-catalog-categories-desktop">
                    <?php require('views/'.$arParams['VIEW_DESKTOP'].'.php'); ?>
                </div>
                <?php if (!defined('EDITOR')) { ?>
                    <div class="widget-catalog-categories-mobile">
                        <?php require('views/'.$arParams['VIEW_MOBILE'].'.php'); ?>
                    </div>
                <?php } ?>
            </div>
        <?php $oFrame->end() ?>
    </div>
</div>
