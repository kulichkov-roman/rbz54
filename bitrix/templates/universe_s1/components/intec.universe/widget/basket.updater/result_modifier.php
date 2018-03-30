<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\Core;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\BasketItem;
use Bitrix\Sale\Fuser;

if (!Loader::includeModule('intec.core') || !Loader::includeModule('sale'))
    return;

/**
 * @var array $arParams
 * @var array $arResult
 */

$basket = Basket::loadItemsForFUser(
    Fuser::getId(),
    Context::getCurrent()->getSite()
);

$sCompare = $arParams['COMPARE_NAME'];

$arResult['BASKET'] = array();
$arResult['COMPARE'] = array();

if ($arParams['BASKET_UPDATE'] == 'Y') {
    /** @var BasketItem $item */
    foreach ($basket as $item) {
        $arResult['BASKET'][] = array(
            'id' => $item->getField('PRODUCT_ID'),
            'delay' => $item->isDelay()
        );
    }
}

if (!empty($sCompare) && $arParams['COMPARE_UPDATE'] == 'Y') {
    $arCompare = Core::$app->session->get($sCompare);

    if (Type::isArray($arCompare))
        foreach ($arCompare as $arIBlock) {
            $arItems = ArrayHelper::getValue($arIBlock, 'ITEMS');

            if (Type::isArray($arItems))
                foreach ($arItems as $arItem) {
                    $iId = ArrayHelper::getValue($arItem, 'ID');

                    if (!empty($iId))
                        $arResult['COMPARE'][] = $iId;
                }
        }
}