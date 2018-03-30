<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
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
$sView = ArrayHelper::fromRange(['default.all', 'extend.all', 'list.all', 'tiles.all'], $sView);
$arParams['VIEW_DESKTOP'] = $sView;

if ($sView == 'default.all') {
    $iLineCount = ArrayHelper::getValue($arParams, 'LINE_COUNT_DESKTOP');
    $iLineCount = Type::toInteger($iLineCount);

    if ($iLineCount < 1)
        $iLineCount = 1;

    if ($iLineCount > 4)
        $iLineCount = 4;

    $arParams['LINE_COUNT_DESKTOP'] = $iLineCount;
}

$sView = ArrayHelper::getValue($arParams, 'VIEW_MOBILE');
$sView = ArrayHelper::fromRange(['default.all', 'extend.all', 'list.all', 'tiles.all'], $sView);
$arParams['VIEW_MOBILE'] = $sView;

if ($sView == 'default.all') {
    $iLineCount = ArrayHelper::getValue($arParams, 'LINE_COUNT_MOBILE');
    $iLineCount = Type::toInteger($iLineCount);

    if ($iLineCount < 1)
        $iLineCount = 1;

    if ($iLineCount > 4)
        $iLineCount = 4;

    $arParams['LINE_COUNT_MOBILE'] = $iLineCount;
}