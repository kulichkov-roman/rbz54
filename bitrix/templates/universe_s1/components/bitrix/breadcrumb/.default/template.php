<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php
use Bitrix\Main\Loader;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $templateFile
 * @var string $templateFolder
 * @var string $componentPath
 * @var CBitrixComponent $component
 */

if (!Loader::includeModule('intec.core'))
    return;

global $APPLICATION;

//delayed function must return a string
if (empty($arResult))
    return '';


$result = array();

// Add link to main page
$arResult = array_merge(
    array(
        array(
            'TITLE' => GetMessage('BREADCRUMB_MAIN_PAGE_TITLE'),
            'LINK' => SITE_DIR
        )
    ),
    $arResult
);

$itemsCount = count($arResult);
$i = 0;
foreach ($arResult as $item) {
    $title = Html::encode($item['TITLE']);

    if ($item['LINK'] != '' && $i != $itemsCount-1) {
        $result[] = '
            <div class="breadcrumbs-item">
                <a href="'.$item['LINK'].'" title="'.$title.'">
                    <span>'.$title.'</span>
                </a>
            </div>';
    } else {
        $result[] = '
            <div class="breadcrumbs-item intec-cl-text">
                <span>'.$title.'</span>
            </div>';
    }

    $i++;
}

return
    '<div id="'.spl_object_hash($this).'" class="breadcrumbs">'.
        '<div class="intec-content">'.
            '<div class="intec-content-wrapper">'.
                implode('<span class="breadcrumbs-separator">/</span>', $result)
            .'</div>'.
        '</div>'
    .'</div>';