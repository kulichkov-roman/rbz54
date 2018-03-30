<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

?>
<?php if ($products): ?>
    <div class="share-header-block">
        <?= GetMessage('GOODS_OF_SHARE') ?>
    </div>

    <?php $GLOBALS['arrFilter'] = array(
        'ID' => $products
    );

    $APPLICATION->IncludeComponent(
        'bitrix:catalog.section',
        'small-share',
        array(
            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE_FOR_SALE'],
            'IBLOCK_ID' => $arParams['IBLOCK_TYPE_ID_SALE'],
            'SECTION_USER_FIELDS' => array(),
            'SHOW_ALL_WO_SECTION' => 'Y',
            'PRICE_CODE' => $arParams['PROPERTY_PRICE_CODE_SALE'],
            'SHOW_PRICE_COUNT' => '1',
            'FILTER_NAME' => 'arrFilter',
            'TITLE' => GetMessage('RECOMENDATIONS'),
            'PROPERTY_BASKET_URL' => $arParams['PROPERTY_BASKET_URL']
        ),
        $component
    ); ?>
<?php endif; ?>
