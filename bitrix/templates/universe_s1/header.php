<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule('intec.core') || !CModule::IncludeModule('intec.constructor') || !CModule::IncludeModule('intec.universe'))
    return;

use intec\Core;
use intec\core\helpers\FileHelper;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Json;
use intec\constructor\models\Build;
use intec\constructor\models\build\File;
use intec\constructor\models\build\Template;

global $APPLICATION, $USER, $template, $data;

$request = Core::$app->request;
$build = Build::getCurrent();

if (empty($build))
    return;

require('helper/functions.php');

IntecUniverse::Initialize();
$settingsDisplay = IntecUniverse::SettingsDisplay(null, SITE_ID);
$settings = $APPLICATION->IncludeComponent(
    'intec.universe:settings',
    '.default',
    array(
        'SESSION_PROPERTY' => 'settings',
        'HANDLE' => 'Y'
    ),
    false,
    array('HIDE_ICONS' => 'Y')
);

$page = $build->getPage();
$page->getProperties()->setRange($settings);
$page->execute(['state' => 'loading']);

/** @var Template $template */
$template = $build->getTemplate();

if (empty($template))
    return;

$template->populateRelation('build', $build);
$files = $build->getFiles();
$directory = $build->getDirectory();
$directoryRelative = $build->getDirectory(false, true, '/');

Core::$app->web->js->loadExtensions(['jquery', 'intec_core', 'ajax', 'popup']);
Core::$app->web->css->addFile($directory.'/js/plugins/bootstrap/css/bootstrap.css');
Core::$app->web->css->addFile($directory.'/js/plugins/bootstrap/css/bootstrap-theme.css');
Core::$app->web->css->addFile($directory.'/js/plugins/jquery_ui/jquery-ui.all.min.css');
Core::$app->web->css->addFile($directory.'/js/plugins/light_gallery/css/lightgallery.min.css');
Core::$app->web->css->addFile($directory.'/js/plugins/colorpicker/colorpicker.css');
Core::$app->web->css->addFile($directory.'/js/plugins/nanoscroller/nanoscroller.css');
Core::$app->web->css->addFile($directory.'/fonts/font-awesome/css/font-awesome.css');
Core::$app->web->css->addFile($directory.'/fonts/p22underground/style.css');
Core::$app->web->css->addFile($directory.'/fonts/glyphter/style.css');
Core::$app->web->css->addFile($directory.'/fonts/typicons/style.css');
Core::$app->web->css->addFile($directory.'/css/public.css');
Core::$app->web->js->addFile($directory.'/js/plugins/jquery.2.2.4.min.js');
Core::$app->web->js->addFile($directory.'/js/plugins/jquery_ui/jquery-ui.min.js');
Core::$app->web->js->addFile($directory.'/js/plugins/bootstrap/js/bootstrap.min.js');
Core::$app->web->js->addFile($directory.'/js/plugins/jquery.mousewheel.min.js');
Core::$app->web->js->addFile($directory.'/js/plugins/picturefill.min.js');
Core::$app->web->js->addFile($directory.'/js/plugins/jquery.zoom.min.js');
Core::$app->web->js->addFile($directory.'/js/plugins/jquery.scrollTo.min.js');
Core::$app->web->js->addFile($directory.'/js/plugins/light_gallery/js/lightgallery-all.min.js');
Core::$app->web->js->addFile($directory.'/js/plugins/colorpicker/colorpicker.js');
Core::$app->web->js->addFile($directory.'/js/plugins/nanoscroller/nanoscroller.js');
Core::$app->web->js->addFile($directory.'/js/plugins/sly.min.js');

$page->execute(['state' => 'loaded']);

if ($request->getIsAjax() && $request->getIsPost() && $request->post('ajax-mode') == 'Y') {
    $response = null;
    include('ajax.php');
    echo StringHelper::convert(Json::encode($response));
    die();
}

if ($request->get('page-mode') == 'Y') {
    $response = null;
    include('pages.php');

    if ($response !== null)
        echo StringHelper::convert($response);

    die();
}

$properties = $template->getPropertiesValues();

foreach ($settings as $key => $value)
    if (!$properties->exists($key))
        $properties->set($key, $value);

?><!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
    <head>
        <title><? $APPLICATION->ShowTitle() ?></title>
        <? $APPLICATION->ShowHead() ?>
        <meta name="viewport" content="initial-scale=1.0, width=device-width">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" href="/favicon.png">
        <? include($directory.'/js/universe.php') ?>
        <?php foreach ($files as $file) { ?>
            <?php if ($file->getType() == File::TYPE_JAVASCRIPT) { ?>
                <script type="text/javascript" src="<?= $file->getPath(true, '/') ?>"></script>
            <?php } else if ($file->getType() == File::TYPE_CSS) { ?>
                <link rel="stylesheet" href="<?= $file->getPath(true, '/') ?>" />
            <?php } else if ($file->getType() == File::TYPE_SCSS) { ?>
                <style type="text/css"><?= Core::$app->web->scss->compileFile($file->getPath(), null, $properties->asArray()) ?></style>
            <?php } ?>
        <?php } ?>
        <style type="text/css"><?= $template->getCss() ?></style>
        <style type="text/css"><?= $template->getLess() ?></style>
        <script type="text/javascript" src="<?= $directoryRelative.'/js/basket.js' ?>"></script>
        <script type="text/javascript" src="<?= $directoryRelative.'/js/compare.js' ?>"></script>
        <script type="text/javascript" src="<?= $directoryRelative.'/js/catalog.js' ?>"></script>
        <script type="text/javascript" src="<?= $directoryRelative.'/js/common.js' ?>"></script>
        <script type="text/javascript" src="<?= $directoryRelative.'/js/forms.js' ?>"></script>
        <script type="text/javascript" src="<?= $directoryRelative.'/js/components.js' ?>"></script>
        <script type="text/javascript"><?= $template->getJs() ?></script>
    </head>
    <body class="public intec-adaptive">
        <? $APPLICATION->IncludeComponent(
            'intec.universe:widget',
            'basket.updater',
            array(
                'BASKET_UPDATE' => 'Y',
                'COMPARE_UPDATE' => 'Y',
                'COMPARE_NAME' => 'compare',
                'CACHE_TYPE' => 'N'
            ),
            false,
            array('HIDE_ICONS' => 'Y')
        ); ?>
        <? if ($settingsDisplay == 'all' || $settingsDisplay == 'admin' && $USER->IsAdmin()) { ?>
            <? $APPLICATION->IncludeComponent(
                'intec.universe:settings',
                '.default',
                array(
                    'SESSION_PROPERTY' => 'settings',
                    'SIDE_MENU_ROOT_TYPE' => 'top',
                    'SIDE_MENU_CHILD_TYPE' => 'left'
                ),
                false,
                array(
                    'HIDE_ICONS' => 'N'
                )
            ); ?>
        <? } ?>
        <? $data = $APPLICATION->IncludeComponent(
            'intec.constructor:template',
            '',
            array(
                'TEMPLATE_ID' => $template->id,
                'DISPLAY' => 'HEADER',
                'DATA' => [
                    'template' => $template
                ]
            ),
            false,
            array('HIDE_ICONS' => 'Y')
        ); ?>
