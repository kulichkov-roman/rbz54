<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;

if (!Loader::includeModule('intec.core') || !Loader::includeModule('sale') || !Loader::includeModule('iblock') || !Loader::includeModule('catalog'))
    return;

/**
 * @var array $arParams
 * @var array $arResult
 */

$arResult['SHOW_COMPARE'] = $arParams['SHOW_COMPARE'] == 'Y';
$arResult['SHOW_BASKET'] = $arParams['SHOW_BASKET'] == 'Y';
$arResult['SHOW_DELAY'] = $arParams['SHOW_DELAY'] == 'Y';

$arResult['URL_COMPARE'] = StringHelper::replaceMacros(
    ArrayHelper::getValue($arParams, 'URL_COMPARE'),
    array('SITE_DIR' => SITE_DIR)
);
$arResult['URL_BASKET'] = StringHelper::replaceMacros(
    ArrayHelper::getValue($arParams, 'URL_BASKET'),
    array('SITE_DIR' => SITE_DIR)
);

$arResult['COMPARE_COUNT'] = 0;
$arResult['BASKET_COUNT'] = 0;
$arResult['DELAYED_COUNT'] = 0;


$compareItems = $_SESSION[$arParams['COMPARE_CODE']][$arParams['COMPARE_IBLOCK_ID']]['ITEMS'];
if (!empty($compareItems)) {
    $arResult['COMPARE_COUNT'] = count($compareItems);
}

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


// Set delatey and basket items
foreach ($basketItems as $id => $item) {
    if ($item['DELAY'] == 'Y') {
        $arResult['DELAYED_COUNT']++;
    } else {
        $arResult['BASKET_COUNT']++;
    }
}
unset($basketItems);

