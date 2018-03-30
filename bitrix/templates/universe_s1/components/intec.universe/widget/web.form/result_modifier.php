<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 */

if (!CModule::IncludeModule('intec.core') || !CModule::IncludeModule('form')) {
    return false;
}

$arResult['WEB_FORM'] = CForm::GetByID($arParams['WEB_FORM_ID']);
$arResult['WEB_FORM'] = $arResult['WEB_FORM']->GetNext();