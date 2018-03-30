<?php

use Bitrix\Main\Context;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;

/**
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

$oBasket = Basket::loadItemsForFUser(
    Fuser::getId(),
    Context::getCurrent()->getSite()
);

foreach ($arResult['ITEMS'] as $itemKey => $arItem) {
    $oBasketItem = $oBasket->getExistsItem('catalog', $arResult['ID']);
    $arItem['BASKET'] = array(
        'IN' => !empty($oBasketItem) && !$oBasketItem->isDelay(),
        'DELAY' => !empty($oBasketItem) && $oBasketItem->isDelay(),
    );
    $arResult['ITEMS'][$itemKey] = $arItem;
}