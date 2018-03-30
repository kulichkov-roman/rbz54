<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!CModule::IncludeModule('intec.core'))
    return;

$sIBlockType = $arParams['IBLOCK_TYPE'];
$iIBlockId = $arParams['IBLOCK_ID'];
$sFilterName = $arParams['FILTER_NAME'];
$sPropertyDisplay = $arParams['PROPERTY_DISPLAY'];

if (empty($sFilterName))
    $sFilterName = 'arFilter';

$arParams['FILTER_NAME'] = $sFilterName;
$arFilter = ArrayHelper::getValue($GLOBALS, $sFilterName);

if (!Type::isArray($arFilter))
    $arFilter = array();

if (!empty($sPropertyDisplay))
    $arFilter['!PROPERTY_'.$sPropertyDisplay] = false;

$GLOBALS[$sFilterName] = $arFilter;

$sView = ArrayHelper::getValue($arParams, 'VIEW_DESKTOP');
$sView = ArrayHelper::fromRange(['default.all', 'tile.all', 'minimal.all', 'blocks.all', 'blocks.small.all'], $sView);
$arParams['VIEW_DESKTOP'] = $sView;

$sView = ArrayHelper::getValue($arParams, 'VIEW_MOBILE');
$sView = ArrayHelper::fromRange(['default.all', 'tile.all', 'tile.slider.mobile', 'minimal.all', 'blocks.all', 'blocks.small.all'], $sView);
$arParams['VIEW_MOBILE'] = $sView;

$arParams['ITEMS_LIMIT'] = Type::toInteger($arParams['ITEMS_LIMIT']);

$sPageUrl = ArrayHelper::getValue($arParams, 'PAGE_URL');
$sPageUrl = StringHelper::replaceMacros($sPageUrl, [
    'SITE_DIR' => SITE_DIR
]);
$arParams['PAGE_URL'] = $sPageUrl;