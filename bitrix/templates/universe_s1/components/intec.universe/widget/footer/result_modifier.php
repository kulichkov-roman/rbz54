<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\constructor\models\Build;

/**
 * @var array $arParams
 * @var array $arResult
 * CBitrixComponentTemplate $this
 */


if (!Loader::includeModule('intec.core'))
    return;

$arHandleParameters = array(
    'FOOTER_SHOW_SEARCH_PATH'
);

foreach ($arHandleParameters as $sParameter) {
    $sValue = ArrayHelper::getValue($arParams, $sParameter, '');
    $sValue = StringHelper::replaceMacros($sValue, array(
        'SITE_DIR' => SITE_DIR
    ));

    $arResult[$sParameter] = $sValue;
}


$oBuild = Build::getCurrent();
$oProperties = null;

if (!empty($oBuild)) {
    $oPage = $oBuild->getPage();
    $oProperties = $oPage->getProperties();
}

if (!empty($oProperties) && $arParams['USE_GLOBAL_SETTINGS'] == 'Y') {
    $template = $oProperties->get('template_footer');
    if (in_array($template, array(1,2,3,4,5))) {
        $arParams['FOOTER_DESIGN'] = 'TYPE_'. $template;
    }

    $theme = $oProperties->get('footer_theme');
    switch ($theme) {
        case 'dark':
            $arParams['FOOTER_BLACK'] = 'Y';
            break;
        default:
            $arParams['FOOTER_BLACK'] = 'N';
            break;
    }
}