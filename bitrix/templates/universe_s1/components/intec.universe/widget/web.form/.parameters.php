<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var array $arCurrentValues
 */

if (!Loader::includeModule('form'))
    return;

$arTemplateParameters = array();

$arForms = array();
$rsForms = CForm::GetList($by = 'sort', $order = 'asc', array(), $filtered = false);

while ($arForm = $rsForms->Fetch())
    $arForms[$arForm['ID']] = '['. $arForm['ID'] .'] '. $arForm['NAME'];

$arTemplateParameters['WEB_FORM_ID'] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => GetMessage('W_WEB_FORM_PARAMETERS_WEB_FORM_ID'),
    'TYPE' => 'LIST',
    'VALUES' => $arForms,
    'ADDITIONAL_VALUES' => 'Y'
);

$rsTemplates = CComponentUtil::GetTemplatesList('bitrix:form.result.new');
$arTemplates = array();

foreach ($rsTemplates as $arTemplate) {
    $arTemplates[$arTemplate['NAME']] = $arTemplate['NAME'].(!empty($arTemplate['TEMPLATE']) ? ' ('.$arTemplate['TEMPLATE'].')' : null);
}

$arTemplateParameters['WEB_FORM_TEMPLATE'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('W_WEB_FORM_PARAMETERS_WEB_FORM_TEMPLATE'),
    'TYPE' => 'LIST',
    'VALUES' => $arTemplates,
    'ADDITIONAL_VALUES' => 'Y'
);