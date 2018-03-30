<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\constructor\models\Build;

/**
 * @var array $arParams
 * @var array $arResult
 * CBitrixComponentTemplate $this
 */

if (!CModule::IncludeModule('intec.core'))
    return;

$sDisplayIn = ArrayHelper::getValue($arParams, 'MENU_MAIN_DISPLAY_IN');
$sDisplayIn = ArrayHelper::fromRange(array('default', 'header', 'popup'), $sDisplayIn);
$arParams['MENU_MAIN_DISPLAY_IN'] = $sDisplayIn;

$sDisplayIn = ArrayHelper::getValue($arParams, 'PHONE_DISPLAY_IN');
$sDisplayIn = ArrayHelper::fromRange(array('default', 'header'), $sDisplayIn);
$arParams['PHONE_DISPLAY_IN'] = $sDisplayIn;

$arHandleParameters = array(
    'LOGOTYPE_PATH',
    'LOGOTYPE_MOBILE_PATH',
    'LOGIN_URL',
    'PROFILE_URL',
    'FORGOT_PASSWORD_URL',
    'REGISTER_URL',
    'BASKET_URL',
    'COMPARE_URL',
    'AUTH_URL',
    'SEARCH_PAGE',
    'MENU_CATALOG_LINK'
);

foreach ($arHandleParameters as $sParameter) {
    $sValue = ArrayHelper::getValue($arParams, $sParameter, '');
    $sValue = StringHelper::replaceMacros($sValue, array(
        'SITE_DIR' => SITE_DIR
    ));

    $arResult[$sParameter] = $sValue;
    $arParams[$sParameter] = $sValue;
}


$build = Build::getCurrent();
$properties = null;

if (!empty($build)) {
    $page = $build->getPage();
    $properties = $page->getProperties();
}

$sView = ArrayHelper::getValue($arParams, 'MOBILE_VIEW');
if ($sView == 'settings') {
    switch ($properties->get('template_mobile_header')) {
        case 'white':
            $arParams['MOBILE_VIEW'] = 'default';
            $arParams['W_HEADER_PARAMETERS_AUTH_MOBILE_DISPLAY'] = 'N';
            break;
        case 'colored':
            $arParams['MOBILE_VIEW'] = 'colored';
            $arParams['W_HEADER_PARAMETERS_AUTH_MOBILE_DISPLAY'] = 'N';
            break;
        case 'white_with_icons':
            $arParams['MOBILE_VIEW'] = 'default';
            $arParams['W_HEADER_PARAMETERS_AUTH_MOBILE_DISPLAY'] = 'Y';
            break;
        case 'colored_with_icons':
            $arParams['MOBILE_VIEW'] = 'colored';
            $arParams['W_HEADER_PARAMETERS_AUTH_MOBILE_DISPLAY'] = 'Y';
            break;
    }
}

$sView = ArrayHelper::getValue($arParams, 'FIXED_HEADER');
if ($sView == 'settings') {
    switch ($properties->get('use_fixed_header')) {
        case 1:
            $arParams['FIXED_HEADER'] = 'Y';
            break;
        default:
            $arParams['FIXED_HEADER'] = 'N';
            break;
    }
}

$sView = ArrayHelper::getValue($arParams, 'FIXED_HEADER_MOBILE');
if ($sView == 'settings') {
    switch ($properties->get('use_fixed_mobile_header')) {
        case 1:
            $arParams['FIXED_HEADER_MOBILE'] = 'Y';
            break;
        default:
            $arParams['FIXED_HEADER_MOBILE'] = 'N';
            break;
    }
}