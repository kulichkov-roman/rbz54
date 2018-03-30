<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Context;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\core\bitrix\Component;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!CModule::IncludeModule('intec.core') || !CModule::IncludeModule('sale'))
    return;

$iIBlockId = ArrayHelper::getValue($arParams, 'IBLOCK_ID');
$sPropertySection = ArrayHelper::getValue($arParams, 'PROPERTY_SECTION');
$arSections = array();
$oBasket = Basket::loadItemsForFUser(
    Fuser::getId(),
    Context::getCurrent()->getSite()
);

$arUrlParameters = array(
    'BASKET_URL'
);

foreach ($arUrlParameters as $sParameter) {
    $sValue = ArrayHelper::getValue($arParams, $sParameter, '');
    $sValue = StringHelper::replaceMacros($sValue, array(
        'SITE_DIR' => SITE_DIR
    ));

    $arResult[$sParameter] = $sValue;
}

if (!empty($iIBlockId) && !empty($sPropertySection)) {
    $arResult['ITEMS'] = Component::SetElementsProperties(
        $arResult['ITEMS'],
        ArrayHelper::replaceKeys(
            array(
                'PROPERTY_LABEL_NEW' => 'LABEL_NEW',
                'PROPERTY_LABEL_RECOMMEND' => 'LABEL_RECOMMEND',
                'PROPERTY_LABEL_HIT' => 'LABEL_HIT',
            ),
            $arParams
        )
    );
    
    $arProperty = CIBlockProperty::GetList(array('SORT' => 'ASC'), array(
        'IBLOCK_ID' => $iIBlockId,
        'CODE' => $sPropertySection
    ));
    $arProperty = $arProperty->Fetch();

    if (!empty($arProperty)) {
        $arPropertyEnums = array();
        $rsPropertyEnums = CIBlockPropertyEnum::GetList(array('SORT' => 'ASC'), array(
            'IBLOCK_ID' => $iIBlockId,
            'PROPERTY_ID' => $arProperty['ID']
        ));

        while ($arPropertyEnum = $rsPropertyEnums->Fetch())
            $arPropertyEnums[$arPropertyEnum['XML_ID']] = $arPropertyEnum;

        $arOrder = ArrayHelper::getKeys($arPropertyEnums);
        $arOrder = ArrayHelper::flip($arOrder);
        $arIBlockSectionsId = array();

        foreach ($arResult['ITEMS'] as $arItem) {
            $iIBlockSectionId = ArrayHelper::getValue($arItem, 'IBLOCK_SECTION_ID');

            if (!empty($iIBlockSectionId) && !ArrayHelper::isIn($iIBlockSectionId, $arIBlockSectionsId))
                $arIBlockSectionsId[] = $iIBlockSectionId;
        }

        $arIBlockSections = array();
        $rsIBlockSections = CIBlockSection::GetList(array('SORT' => 'ASC'), array(
            'ID' => $arIBlockSectionsId
        ));

        $rsIBlockSections->SetUrlTemplates(
            $arParams['DETAIL_URL'],
            $arParams['SECTION_URL']
        );

        while ($arIBlockSection = $rsIBlockSections->GetNext())
            $arIBlockSections[$arIBlockSection['ID']] = $arIBlockSection;

        foreach ($arResult['ITEMS'] as &$arItem) {
            $iIBlockSectionId = ArrayHelper::getValue($arItem, 'IBLOCK_SECTION_ID');
            $arItem['IBLOCK_SECTION'] = null;
            $oBasketItem = $oBasket->getExistsItem('catalog', $arItem['ID']);
            $arItem['BASKET'] = array(
                'IN' => !empty($oBasketItem) && !$oBasketItem->isDelay(),
                'DELAY' => !empty($oBasketItem) && $oBasketItem->isDelay(),
            );

            if (!empty($iIBlockSectionId) && ArrayHelper::keyExists($iIBlockSectionId, $arIBlockSections))
                $arItem['IBLOCK_SECTION'] = ArrayHelper::getValue($arIBlockSections, $iIBlockSectionId);

            $arPrice = $arItem['MIN_PRICE'];

            foreach ($arItem['OFFERS'] as $arOffer) {
                $arOfferPrice = $arOffer['MIN_PRICE'];

                //var_dump($arOfferPrice);

                if (empty($arOfferPrice))
                    continue;

                if (empty($arPrice) || $arPrice['VALUE'] > $arOfferPrice['VALUE'])
                    $arPrice = $arOfferPrice;
            }

            $arItem['PRICE'] = $arPrice;

            $sId = ArrayHelper::getValue($arItem, ['PROPERTIES', $sPropertySection, 'VALUE_XML_ID']);
            $sValue = ArrayHelper::getValue($arItem, ['PROPERTIES', $sPropertySection, 'VALUE']);

            if (!empty($sId) && !empty($sValue)) {
                if (!ArrayHelper::keyExists($sId, $arSections))
                    $arSections[$sId] = array(
                        'NAME' => $sValue,
                        'CODE' => $sId,
                        'ITEMS' => array()
                    );

                $arSections[$sId]['ITEMS'][] = $arItem;
            }
        }

        usort($arSections, function ($arSection1, $arSection2) use (&$arOrder) {
            $iOrder1 = ArrayHelper::getValue($arOrder, $arSection1['CODE']);
            $iOrder2 = ArrayHelper::getValue($arOrder, $arSection2['CODE']);

            if ($iOrder1 > $iOrder2) return 1;
            if ($iOrder1 < $iOrder2) return -1;
            return 0;
        });
    }
}

$arResult['SECTIONS'] = $arSections;