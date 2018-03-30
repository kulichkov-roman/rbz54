<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use intec\core\helpers\ArrayHelper;

/**
 * @var CBitrixComponentTemplate $this
 * @var array $arParams
 * @var array $arResult
 */

foreach ($arResult['ITEMS'] as &$item) {
    $arPrice = $item['MIN_PRICE'];

    foreach ($item['OFFERS'] as $arOffer) {
        $arOfferPrice = $arOffer['MIN_PRICE'];

        if (empty($arOfferPrice))
            continue;

        if (empty($arPrice) || $arPrice['VALUE'] > $arOfferPrice['VALUE'])
            $arPrice = $arOfferPrice;
    }

    $item['PRICE'] = $arPrice;
}