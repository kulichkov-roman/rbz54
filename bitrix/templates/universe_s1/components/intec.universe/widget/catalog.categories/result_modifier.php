<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!CModule::IncludeModule('intec.core'))
    return;

$sFilterName = $arParams['FILTER_NAME'];
$sPropertySection = $arParams['PROPERTY_SECTION'];

if (empty($sFilterName))
    $sFilterName = 'arFilter';

$arParams['FILTER_NAME'] = $sFilterName;
$arFilter = ArrayHelper::getValue($GLOBALS, $sFilterName);

if (!Type::isArray($arFilter))
    $arFilter = array();

if (!empty($sPropertySection))
    $arFilter['!PROPERTY_'.$sPropertySection] = false;

$GLOBALS[$sFilterName] = $arFilter;

$sView = ArrayHelper::getValue($arParams, 'VIEW_DESKTOP');
$sView = ArrayHelper::fromRange(['default.desktop'], $sView);
$arParams['VIEW_DESKTOP'] = $sView;

$sView = ArrayHelper::getValue($arParams, 'VIEW_MOBILE');
$sView = ArrayHelper::fromRange(['default.mobile', 'deployed.mobile'], $sView);
$arParams['VIEW_MOBILE'] = $sView;

$arParams['ITEMS_LIMIT'] = Type::toInteger($arParams['ITEMS_LIMIT']);

$sIBlockType = $arParams['IBLOCK_TYPE'];
$iIBlockId = $arParams['IBLOCK_ID'];