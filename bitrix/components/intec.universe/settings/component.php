<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use intec\Core;
use intec\core\base\InvalidParamException;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\FileHelper;
use intec\core\helpers\Json;
use intec\core\helpers\Type;
use intec\universe\classes\GlobalSettings;

/**
 * @var array $arParams
 * @var array $arResult
 * @global CUser $USER
 */

if (defined('EDITOR'))
    return;

$request = Core::$app->request;
$session = Core::$app->session;
$arResult['IS_POST'] = false;
$bHandle = $arParams['HANDLE'] == 'Y';
$bIsAdmin = $USER->IsAdmin();
$sSessionKey = ArrayHelper::getValue($arParams, 'SESSION_PROPERTY', 'settings');
$properties = GlobalSettings::getSettingsData();
$defaultSettings = GlobalSettings::getDefaultSettings();

if (class_exists('intec\constructor\models\Build')) {
    $arResult['BUILD'] = $build = intec\constructor\models\Build::getCurrent();

    if (empty($build))
        return;

    $arResult['TEMPLATE'] = $build->getTemplate();
    $arResult['TEMPLATES'] = $build->getTemplates(true);
    $properties = $build->getMetaValue('settings');
}


/**
 * @param array $property
 * @param mixed $value
 * @return mixed
 */
$bring = function ($property, $value) {
    if ($property['type'] === 'list') {
        if (!ArrayHelper::keyExists($value, $property['values']))
            return $property['default'];
    } else if ($property['type'] == 'boolean') {
        if ($value === null)
            return $property['default'];

        return Type::toBoolean($value);
    }

    return $value;
};

$file = Core::getAlias('@root').SITE_DIR.'.settings.json';
$values = $session->get($sSessionKey);

if ($bIsAdmin || empty($values)) {
    $values = FileHelper::getFileData($file);

    try {
        $values = Json::decode($values);
    } catch (InvalidParamException $exception) {}
}

if (!Type::isArray($values))
    $values = [];

foreach ($properties as $code => $property) {
    $properties[$code]['value'] = $bring(
        $property,
        ArrayHelper::getValue($values, $code)
    );
}

$arResult['ACTIVE_TAB'] = 'global';
if ($request->post('universeSettingsAjax') == 'Y') {
    $arResult['IS_POST'] = true;
    $arResult['ACTIVE_TAB'] = $request->post('active_tab', $arResult['ACTIVE_TAB']);
}

if ($bHandle)
    if ($arResult['IS_POST']) {
        $post = $request->post();

        foreach ($properties as $code => $property) {
            $value = ArrayHelper::getValue($post, $code);
            $value = $bring($property, $value);
            $properties[$code]['value'] = $value;
        }
    }

$values = [];

foreach ($properties as $code => $property) {
    if ($request->post('default_settings') == 'Y' && $code != 'use_global_settings' && ArrayHelper::keyExists($code, $defaultSettings)) {
        $values[$code] = ArrayHelper::getValue($defaultSettings, $code);
    } else {
        $values[$code] = $property['value'];
    }
}

if ($bHandle)
    if ($arResult['IS_POST'])
        if ($bIsAdmin) {
            FileHelper::setFileData($file, Json::encode($values));
        } else {
            $session->set($sSessionKey, $values);
        }

$arResult['PROPERTIES'] = $properties;
$arResult['VALUES'] = [];
$arResult['HANDLE'] = $bHandle;

$this->IncludeComponentTemplate();
$templateValues = ArrayHelper::getValue($arResult, 'VALUES');

if (Type::isArray($templateValues))
    $values = ArrayHelper::merge($values, $templateValues);

return $values;