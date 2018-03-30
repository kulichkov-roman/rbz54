<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use \intec\core\net\Url;

if (!Loader::includeModule('sale') || !Loader::includeModule('iblock') || !Loader::includeModule('catalog'))
    return;

/**
 * @global $APPLICATION
 * @global $USER
 * @var array $arParams
 * @var array $arResult
 */

$arResult['COMPONENT_HASH'] = 'flying_basket_'. spl_object_hash($this);

$arParams['URL_CATALOG'] = str_replace('/', SITE_DIR, $arParams['URL_CATALOG']);
$arParams['URL_BASKET'] = str_replace('/', SITE_DIR, $arParams['URL_BASKET']);
$arParams['URL_ORDER'] = str_replace('/', SITE_DIR, $arParams['URL_ORDER']);
$arParams['URL_COMPARE'] = str_replace('/', SITE_DIR, $arParams['URL_COMPARE']);
$arParams['URL_CABINET'] = str_replace('/', SITE_DIR, $arParams['URL_CABINET']);

$arParams['IS_OPENED'] = !(empty($arParams['IS_OPENED']) || $arParams['IS_OPENED'] == 'N');
$arParams['ACTIVE_TAB'] = !empty($arParams['ACTIVE_TAB']) ? $arParams['ACTIVE_TAB'] : '';

$delayedUrl = new Url($arParams['URL_BASKET']);
$delayedUrl->getQuery()->setRange(['delay' => 'y']);
$arResult['URL_DELAYED'] = $delayedUrl->build();
unset($delayedUrl);

$arResult['SHOW_BLOCK'] = array(
    'BASKET' => $arParams['SHOW_BASKET'] == 'Y',
    'DELAYED' => $arParams['SHOW_DELAYED'] == 'Y',
    'COMPARE' => $arParams['SHOW_COMPARE'] == 'Y',
    'FORM' => $arParams['SHOW_FORM'] == 'Y',
    'AUTH' => $arParams['SHOW_AUTH'] == 'Y'
);

// Get delayed and basket items
$arResult['BASKET_ITEMS'] = array();
$arResult['BASKET_SUM'] = 0;
$arResult['DELAYED_ITEMS'] = array();

$saleBasket = CSaleBasket::GetList(array(), array(
    'FUSER_ID' => CSaleBasket::GetBasketUserID(),
    'LID' => SITE_ID,
    'ORDER_ID' => 'NULL'
));
$basketItems = array();
while ($row = $saleBasket->GetNext()) {
    $basketItems[$row['PRODUCT_ID']] = $row;
}
unset($saleBasket);

// Get elements info
$elements = array();
$products = array();

if (!empty($basketItems)) {
    $iBlockElements = CIBlockElement::GetList(array(), array(
        'ID' => array_keys($basketItems)
    ));
    while ($row = $iBlockElements->GetNext()) {
        $elements[$row['ID']] = $row;
    }
    unset($iBlockElements);

    $catalogProducts = CCatalogProduct::GetList(array(), array(
        'ID' => array_keys($basketItems)
    ));
    while ($row = $catalogProducts->GetNext()) {
        $products[$row['ID']] = $row;
    }
    unset($catalogProducts);
}

// Set delatey and basket items
foreach ($basketItems as $id => $item) {
    $item['ELEMENT'] = !empty($elements[$id]) ? $elements[$id] : array();

    if (!empty($item['ELEMENT']['PREVIEW_PICTURE'])) {
        $item['ELEMENT']['PREVIEW_PICTURE'] = CFile::GetFileArray($item['ELEMENT']['PREVIEW_PICTURE']);
    }
    if (!empty($item['ELEMENT']['DETAIL_PICTURE'])) {
        $item['ELEMENT']['DETAIL_PICTURE'] = CFile::GetFileArray($item['ELEMENT']['DETAIL_PICTURE']);
    }

    $item['PRODUCT'] = !empty($products[$id]) ? $products[$id] : array();

    $item['TOTAL_PRICE'] = $item['PRICE'] * $item['QUANTITY'];

    if (!empty($item['ELEMENT']['DETAIL_PAGE_URL'])) {
        $item['DETAIL_PAGE_URL'] = $item['ELEMENT']['DETAIL_PAGE_URL'];
    }

    if ($item['DELAY'] == 'Y') {
        $arResult['DELAYED_ITEMS'][$id] = $item;
    } else {
        $arResult['BASKET_SUM'] += $item['TOTAL_PRICE'];
        $arResult['BASKET_ITEMS'][$id] = $item;
    }
}
unset($basketItems);

$arResult['BASKET_COUNT'] = count($arResult['BASKET_ITEMS']);
$arResult['DELAYED_COUNT'] = count($arResult['DELAYED_ITEMS']);

$arResult['WEB_FORM'] = array();
if (CModule::IncludeModule('form')) {
    $form = CForm::GetByID($arParams['WEB_FORM_ID']);
    if ($form) {
        $form = $form->GetNext();
        $arResult['WEB_FORM'] = $form;
    }
}

$arResult['COMPARE_ITEMS'] = $_SESSION[$arParams['COMPARE_CODE']][$arParams['COMPARE_IBLOCK_ID']]['ITEMS'];
$arResult['COMPARE_ITEMS_COUNT'] = 0;
if (!empty($arResult['COMPARE_ITEMS'])) {
    $arResult['COMPARE_ITEMS_COUNT'] = count($arResult['COMPARE_ITEMS']);
}