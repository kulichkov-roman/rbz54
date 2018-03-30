<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\JavaScript;
use intec\core\helpers\ArrayHelper;
use intec\constructor\models\Build;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $currentOffer
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var boolean $showPreviewDescription
 * @var CBitrixComponent $component
 */

$oBuild = Build::getCurrent();
if (!empty($oBuild)) {
    $oPage = $oBuild->getPage();
    $oProperties = $oPage->getProperties();

    $detailImage = $oProperties->get('catalog_detail_image');
    if ($arParams['DETAIL_PICTURE_POPUP'] == 'SETTINGS') {
        $arParams['DETAIL_PICTURE_POPUP'] = 'N';
        if (ArrayHelper::getValue($detailImage, 'popup', 0) == 1) {
            $arParams['DETAIL_PICTURE_POPUP'] = 'Y';
        }
    }
    if ($arParams['DETAIL_PICTURE_LOOP'] == 'SETTINGS') {
        $arParams['DETAIL_PICTURE_LOOP'] = 'N';
        if (ArrayHelper::getValue($detailImage, 'loop', 0) == 1) {
            $arParams['DETAIL_PICTURE_LOOP'] = 'Y';
        }
    }
    unset($detailImage);
}

$this->setFrameMode(true);
$templateLibrary = array('popup');
$sTemplateId = spl_object_hash($this);
$currencyList = '';
if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
    'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$strMainID = $this->GetEditAreaId($arResult['ID']);

include('parts/result_modifier.php');
?>

<div class="intec-item-detail <?= $templateData['TEMPLATE_CLASS'] ?>"
     id="<?= $strMainID ?>"
     data-offer-id="<?= ArrayHelper::getValue($currentOffer, 'ID', $arResult['ID'])  ?>">

    <div class="intec-item-container">

        <div class="row intec-item-top">
            <div class="col-xs-12 col-md-5">
                <?php include('parts/main_image.php') ?>
            </div>
            <div class="col-xs-12 col-md-7 item-info-column">
                <?php if ($brand && is_numeric($brand['PREVIEW_PICTURE'])) {
                    $brandImage = CFile::GetPath($brand['PREVIEW_PICTURE']);
                    ?>
                    <span class="item-brand">
                        <a href="<?= $brand['DETAIL_PAGE_URL'] ?>">
                            <img class="intec-icon-brand"
                                 src="<?= $brandImage ?>"
                                 alt="<?= $brand['NAME'] ?>"
                                 title="<?= $brand['NAME'] ?>" />
                        </a>
                    </span>
                <?php } ?>

                <?php if (!empty($arParams['PROPERTY_ARTICLE']) && !empty($arResult['PROPERTIES'][$arParams['PROPERTY_ARTICLE']])) { ?>
                    <div class="item-article text-muted">
                        <?= GetMessage('ARTICLE') ?>: <?= $arResult['PROPERTIES'][$arParams['PROPERTY_ARTICLE']]['VALUE'] ?>
                    </div>
                <?php } ?>
                <div class="clearfix"></div>

                <?php include('parts/price_block.php') ?>

                <?php include('parts/sku.php') ?>

                <?php if ($showPreviewDescription) { ?>
                    <div class="item-preview-description"><?= $arResult['PREVIEW_TEXT'] ?></div>
                <?php } ?>

                <?php include('parts/characteristics.php') ?>

                <?php if (empty($arParams['DETAIL_VIEW']) || $arParams['DETAIL_VIEW'] == 'tabs_right') {
                    include('parts/info_tabs.php');
                } ?>
            </div>
        </div>

        <?php
        if (!empty($arParams['DETAIL_VIEW'])) {
            switch ($arParams['DETAIL_VIEW']) {
                case 'tabs':
                    include('parts/info_tabs.php');
                    break;
                case 'tabless':
                    include('parts/info_full.php');
                    break;
            }
        }

        // Ask questions web form
        if (!empty($arParams['WEB_FORM'])) {
            $APPLICATION->IncludeComponent(
                'intec.universe:widget',
                'web.form',
                array(
                    'WEB_FORM_ID' => $arParams['WEB_FORM'],
                    'WEB_FORM_SETTINGS' => array(
                        'COMPONENT_TEMPLATE' => 'popup'
                    )
                ),
                $component
            );
        }

        // Often by with
        if (!empty($arResult['PROPERTIES'][$arParams['PROPERTY_BUYING']]['VALUE'])) {
            $GLOBALS['arrFilter'] = array(
                'ID' => $arResult['PROPERTIES'][$arParams['PROPERTY_BUYING']]['VALUE']
            );
            $APPLICATION->IncludeComponent(
                'bitrix:catalog.section',
                'small',
                array(
                    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                    'SECTION_USER_FIELDS' => array(),
                    'SHOW_ALL_WO_SECTION' => 'Y',
                    'FILTER_NAME' => 'arrFilter',
                    'TITLE' => GetMessage('BUYING_WITH'),
                    'PRICE_CODE' => $arParams['PRICE_CODE'],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID']
                ),
                $component
            );
        }

        // Recomended products
        if (!empty($arResult['PROPERTIES'][$arParams['PROPERTY_RECOMENDATIONS']]['VALUE'])) {
            $GLOBALS['arrFilter'] = array(
                'ID' => $arResult['PROPERTIES'][$arParams['PROPERTY_RECOMENDATIONS']]['VALUE']
            );
            $APPLICATION->IncludeComponent(
                'bitrix:catalog.section',
                'small',
                array(
                    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                    'SECTION_USER_FIELDS' => array(),
                    'SHOW_ALL_WO_SECTION' => 'Y',
                    'FILTER_NAME' => 'arrFilter',
                    'TITLE' => GetMessage('RECOMENDATIONS'),
                    'PRICE_CODE' => $arParams['PRICE_CODE'],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID']
                ),
                $component
            );
        }

        if (!empty($arParams['DETAIL_VIEW']) && $arParams['DETAIL_VIEW'] == 'tabs_bottom') {
            include('parts/info_tabs.php');
        }
        ?>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        <?php if ($hasTab['reviews']) { ?>
            universe.components.get(<?= JavaScript::toObject([
                'component' => 'intec.universe:reviews',
                'template' => '.default',
                'parameters' => [
                    'COMPONENT_TEMPLATE' => '.default',
                    'IBLOCK_TYPE' => $arParams['REVIEWS_IBLOCK_TYPE'],
                    'IBLOCK_ID' => $arParams['REVIEWS_IBLOCK'],
                    'ELEMENT_ID' => $arParams['ELEMENT_ID'],
                    'DISPLAY_REVIEWS_COUNT' => 5,
                    'PROPERTY_ELEMENT_ID' => $arParams['REVIEWS_PROPERTY_ELEMENT_ID'],
                    'MAIL_EVENT' => $arParams['REVIEWS_MAIL_EVENT'],
                    'USE_CAPTCHA' => $arParams['REVIEWS_USE_CAPTCHA'],
                    'AJAX_MODE' => 'Y',
                    'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'_REVIEWS',
                    'AJAX_OPTION_SHADOW' => 'N',
                    'AJAX_OPTION_JUMP' => 'Y',
                    'AJAX_OPTION_STYLE' => 'Y'
                ]
            ]) ?>, function(popup){
                $('#<?= $strMainID ?> .reviews-container').html(popup);
            });
        <?php } ?>
    });
</script>