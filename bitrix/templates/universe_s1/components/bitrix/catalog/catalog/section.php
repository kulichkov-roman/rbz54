<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use intec\Core;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\RegExp;
use intec\core\helpers\Type;
use intec\core\helpers\StringHelper;
use intec\constructor\models\Build;

global $options;

/**
 * @var array $arParams
 */

if (!CModule::IncludeModule('iblock'))
    return;

if (!isset($arResult['VARIABLES']['SECTION_ID'])) {
    $rsSections = CIBlockSection::GetList(
        array(),
        array(
            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
            '=CODE' => $arResult['VARIABLES']['SECTION_CODE']
        )
    );
    if ($arSection = $rsSections->Fetch()){
        $arResult['VARIABLES']['SECTION_ID'] = $arSection['ID'];
    }
}

$oBuild = Build::getCurrent();
$oProperties = null;

if (!empty($oBuild)) {
    $oPage = $oBuild->getPage();
    $oProperties = $oPage->getProperties();
}

$bMenuDisplay = $arParams['MENU_DISPLAY_IN_SECTION'] == 'Y';

if (!empty($oProperties)) {
    if ($arParams['MENU_DISPLAY_IN_SECTION'] == 'settings') {
        $arMenuDisplayIn = $oProperties->get('menu_display_in');
        $sPath = '/' . Core::$app->request->getPathInfo();
        $sPath = RegExp::replaceBy('/^' . RegExp::escape(SITE_DIR) . '/', null, $sPath);
        $sPath = StringHelper::replace($sPath, [
            '/' => '.'
        ]);

        $sSection = null;

        if (Type::isArray($arMenuDisplayIn))
            foreach ($arMenuDisplayIn as $sKey => $arValue)
                if (RegExp::isMatchBy('/^' . RegExp::escape($sKey) . '/', $sPath))
                    $sSection = $sKey;

        if (!empty($sSection)) {
            $sSection .= '.section';
            $bMenuDisplay = ArrayHelper::getValue($arMenuDisplayIn, [$sSection, 'display']) == 1;
        }

        unset($sSection);
    }
    if ($arParams['TYPE_SUBMENU'] == 'settings') {
        switch ($oProperties->get('show_sections_icons_in_menu')) {
            case 1:
                $arParams['TYPE_SUBMENU'] = 'picture';
                break;
            default:
                $arParams['TYPE_SUBMENU'] = 'default';
                break;
        }
    }
}
$this->setFrameMode(true);

?>
<div class="intec-content intec-content-visible">
    <div class="intec-content-wrapper">
        <div class="intec-content-left">
            <?php
            $getListFilter = array(
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"]
            );
            if ($arParams['INCLUDE_SUBSECTIONS']!='N') {
                $getListFilter['INCLUDE_SUBSECTIONS'] = 'Y';
            }
            if ($arParams['INCLUDE_SUBSECTIONS']=='A') {
                $getListFilter['SECTION_GLOBAL_ACTIVE'] = 'Y';
            }

            $db_res = CIBlockElement::GetList(
                array(),
                array($getListFilter),
                false,
                array()
            );

            $elements = $db_res->Fetch();
            if ($arParams["USE_FILTER"]=="Y") {
                $arFilter = array(
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "ACTIVE" => "Y",
                    "GLOBAL_ACTIVE" => "Y",
                );
                if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
                {
                    $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
                }
                elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
                {
                    $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
                }

                $obCache = new CPHPCache();
                if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
                    $arCurSection = $obCache->GetVars();
                } elseif ($obCache->StartDataCache()) {
                    $arCurSection = array();
                    if (\Bitrix\Main\Loader::includeModule("iblock")) {
                        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

                        if (defined("BX_COMP_MANAGED_CACHE")) {
                            global $CACHE_MANAGER;
                            $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                            if ($arCurSection = $dbRes->Fetch())
                            {
                                $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
                            }
                            $CACHE_MANAGER->EndTagCache();
                        } else {
                            if(!$arCurSection = $dbRes->Fetch())
                                $arCurSection = array();
                        }
                    }
                    $obCache->EndDataCache($arCurSection);
                }
                if (!isset($arCurSection)) {
                    $arCurSection = array();
                }

                if ($elements) { ?>
                    <div class="intec-section-filter-left">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:catalog.smart.filter",
                            '',
                            Array(
                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                "SECTION_ID" => $arCurSection['ID'],
                                "FILTER_NAME" => $arParams["FILTER_NAME"],
                                "PRICE_CODE" => $arParams["PRICE_CODE"],
                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                "SAVE_IN_SESSION" => "N",
                                "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                                "XML_EXPORT" => "Y",
                                "SECTION_TITLE" => "NAME",
                                "SECTION_DESCRIPTION" => "DESCRIPTION",
                                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                "SEF_MODE" => $arParams["SEF_MODE"],
                                "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                                "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                                "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                            ),
                            $component,
                            array('HIDE_ICONS' => 'Y')
                        );?>
                    </div>
                <?php } ?>
            <?php } ?>

            <?php if ($bMenuDisplay) { ?>
                <div class="intec-section-menu">
                    <?php $APPLICATION->IncludeComponent("bitrix:menu", "vertical", array(
                            'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                            'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                            'PROPERTY_IMAGE' => $arParams['PROPERTY_IMAGE'],
                            'PROPERTY_SHOW_HEADER_SUBMENU' => $arParams['SHOW_HEADER_SUBMENU'],
                            'ROOT_MENU_TYPE' => $arParams['ROOT_MENU_TYPE'],
                            'MENU_CACHE_TYPE' => 'N',
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array(
                            ),
                            "MAX_LEVEL" => $arParams['MAX_LEVEL_MENU'],
                            "CHILD_MENU_TYPE" => $arParams['CHILD_MENU_TYPE'],
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "HIDE_CATALOG" => "Y",
                            "COUNT_ITEMS_CATALOG" => "8",
                            'TYPE_SUBMENU' => $arParams['TYPE_SUBMENU']
                        ),
                        $component
                    ); ?>
                </div>
            <?php } ?>
        </div><!--left_col_index-->

        <div class="intec-content-right">
            <div class="intec-content-right-wrapper">
                <?php
                $arViews = array('tile', 'tile2', 'text', 'list');
                $sView = ArrayHelper::getValue($arParams, 'SUBSECTIONS_VIEW_MODE');

                if ($sView == 'settings' && !empty($oProperties)) {
                    switch ($oProperties->get('template_catalog_section')) {
                        case 'list':
                            $sView = 'text';
                            $arParams['USE_SUBSECTIONS_SECTIONS'] = 'Y';
                            $arParams['SECTIONS_DISPLAY_DESCRIPTION'] = 'Y';
                            break;
                        case 'list_2':
                            $sView = 'list';
                            $arParams['USE_SUBSECTIONS_SECTIONS'] = 'Y';
                            $arParams['SECTIONS_DISPLAY_DESCRIPTION'] = 'Y';
                            break;
                        case 'tile':
                            $sView = 'tile';
                            $arParams['USE_SUBSECTIONS_SECTIONS'] = 'Y';
                            break;
                        case 'tile_2':
                            $sView = 'tile2';
                            $arParams['USE_SUBSECTIONS_SECTIONS'] = 'N';
                            break;
                    }
                }
                $sView = ArrayHelper::fromRange($arViews, $sView);

                if (ArrayHelper::isIn($sView, array('list', 'text'))) {
                    $arParams['GRID_CATALOG_SECTIONS_COUNT'] = 2;
                }
                ?>
                <div class="intec-section-list">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list",
                        $sView,
                        Array(
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                            "COUNT_ELEMENTS" => 3,
                            "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                            "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                            "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
                            "GRID_CATALOG_SECTIONS_COUNT" => $arParams['GRID_CATALOG_SECTIONS_COUNT'],
                            'USE_SUBSECTIONS' => $arParams['USE_SUBSECTIONS_SECTIONS'],
                            'COUNT_SUBSECTIONS' => $arParams['COUNT_SUBSECTIONS_SECTIONS'],
                            'SECTIONS_DISPLAY_DESCRIPTION' => $arParams['SECTIONS_DISPLAY_DESCRIPTION']
                        ),
                        $component
                    );?>
                </div>

            <?if ($elements):?>
                <?if (!empty($arParams['SECTION_SORT_PRICE_CODE']) && (int)$arParams['SECTION_SORT_PRICE_CODE'] > 0) {
                    $sortPriceCode = $arParams['SECTION_SORT_PRICE_CODE'];
                } else {
                    $sortPriceCode = 1;
                }

                $sort=$_GET['sort'];

                if(empty($sort)){
                    $sort=null;
                    $sort_p=null;
                }

                if ($_GET['sort']=="name") {
                    $sort='name';
                    $sort_p='name';
                }
                if ($_GET['sort']=="price") {
                    $sort='catalog_PRICE_'.$sortPriceCode;
                    $sort_p='price';
                }
                if ($_GET['sort']=="pop") {
                    $sort='show_counter';
                    $sort_p='pop';
                }

                $pView = ArrayHelper::getValue($arParams, 'PRODUCTS_VIEW_MODE');
                if ($pView == 'settings' && !empty($oProperties)) {
                    $view = $oProperties->get('default_products_view');
                }

                $viewValues = array('text', 'list', 'tile');
                if (isset($_COOKIE['view'])) {
                    $view = $_COOKIE['view'];
                }

                if (isset($_GET['view']) && in_array($_GET['view'], $viewValues)) {
                    $view = $_GET['view'];
                    setcookie("view", $view, time()+60*60*24*7, '/');
                }

                if (empty($view) || !in_array($view, $viewValues)) {
                    $view = 'tile';
                }

                $order = "desc";
                if (isset($_GET['order'])) {
                    if ($_GET['order']=='asc') {
                        $order = "asc";
                    }
                    if ($_GET['order']=='desc') {
                        $order = "desc";
                    }
                }

                if ($order=="desc") {
                    $classAngle = 'up';
                    $order_p = "asc";
                } else {
                    $classAngle = 'down';
                    $order_p = "desc";
                }
                ?>
                <div class="intec-panel-sort">
                    <div class="intec-section-filter-mobile-wrap">
                        <span class="intec-section-filter-mobile-button intec-button intec-button-w-icon intec-button-cl-common intec-button-r-3 intec-button-s-2">
                            <i class="glyph-icon-filter" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="intec-sort">
                        <div class="sort-values">
                            <div class="sort-value<?= $sort_p=='pop' ? ' sort-state-active' : '' ?>">
                                <a rel="nofollow" href="<?= $APPLICATION->GetCurPageParam('sort=pop&order='.$order_p, array('sort','order'), false) ?>">
                                    <span class="sort-value-desktop"><?=GetMessage("SECTION_SORT_POPUL")?></span>
                                    <span class="sort-value-mobile"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                    <span class="sort-value-arrow"><i class="fa fa-angle-<?=$classAngle?>" aria-hidden="true"></i></span>
                                </a>
                            </div>
                            <div class="sort-value<?= $sort_p=='name' ? ' sort-state-active' : '' ?>">
                                <a rel="nofollow" href="<?= $APPLICATION->GetCurPageParam('sort=name&order='.$order_p, array('sort','order'), false) ?>">
                                    <span class="sort-value-desktop"><?=GetMessage("SECTION_SORT_NAME")?></span>
                                    <span><i class="glyph-icon-filter" aria-hidden="true"></i></span>
                                    <span class="sort-value-mobile">A</span>
                                    <span class="sort-value-arrow"><i class="fa fa-angle-<?=$classAngle?>" aria-hidden="true"></i></span>
                                </a>
                            </div>
                            <div class="sort-value<?= $sort_p=='price' ? ' sort-state-active' : '' ?>">
                                <a rel="nofollow" href="<?= $APPLICATION->GetCurPageParam('sort=price&order='.$order_p, array('sort','order'), false) ?>">
                                    <span class="sort-value-desktop"><?=GetMessage("SECTION_SORT_PRICE")?></span>
                                    <span class="sort-value-mobile"><i class="fa fa-rub" aria-hidden="true"></i></span>
                                    <span class="sort-value-arrow"><i class="fa fa-angle-<?=$classAngle?>" aria-hidden="true"></i></span>
                                </a>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="intec-panel-view">
                        <div class="intec-aligner"></div>
                        <div class="intec-views">
                            <?php foreach ($viewValues as $v) { ?>
                                <a rel="nofollow"
                                   href="<?=$APPLICATION->GetCurPageParam('view='.$v, array('view'), false)?>"
                                   class="text <?= $view==$v ? 'view-active' : '' ?>">
                                    <i class="glyph-icon-view_<?= $v ?>" aria-hidden="true"></i>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="intec-section-filter-mobile">
                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:catalog.smart.filter",
                            'mobile',
                            Array(
                                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                                "SECTION_ID" => $arCurSection['ID'],
                                "FILTER_NAME" => $arParams["FILTER_NAME"],
                                "PRICE_CODE" => $arParams["PRICE_CODE"],
                                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                "CACHE_TIME" => $arParams["CACHE_TIME"],
                                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                "SAVE_IN_SESSION" => "N",
                                "FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
                                "XML_EXPORT" => "Y",
                                "SECTION_TITLE" => "NAME",
                                "SECTION_DESCRIPTION" => "DESCRIPTION",
                                'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                                "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
                                'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                                "SEF_MODE" => $arParams["SEF_MODE"],
                                "SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
                                "SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
                                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                                "INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
                            ),
                            $component,
                            array('HIDE_ICONS' => 'Y')
                        ); ?>
                    </div>
                </div>
            <?endif;?>

            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                $view,
                Array(
                    "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                    "ELEMENT_SORT_FIELD" => !empty($sort)?$sort:$arParams['ELEMENT_SORT_FIELD'],
                    "ELEMENT_SORT_ORDER" => !empty($sort)?$order:$arParams['ELEMENT_SORT_ORDER'],
                    "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                    "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                    "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                    "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                    "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                    "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                    "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                    "BASKET_URL" => $arParams["BASKET_URL"],
                    "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                    "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                    "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                    "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                    "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                    "FILTER_NAME" => $arParams["FILTER_NAME"],
                    "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                    "CACHE_TIME" => $arParams["CACHE_TIME"],
                    "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                    "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                    "SET_TITLE" => $arParams["SET_TITLE"],
                    "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                    "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                    "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                    "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                    'DISPLAY_PREVIEW' => $arParams['LIST_DISPLAY_PREVIEW'],
                    'DISPLAY_PROPERTIES' => $arParams['LIST_DISPLAY_PROPERTIES'],
                    "PRICE_CODE" => $arParams["PRICE_CODE"],
                    "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                    "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                    "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                    "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                    "QUANTITY_FLOAT" => $arParams["QUANTITY_FLOAT"],
                    "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                    "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                    "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                    "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                    "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                    "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                    "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                    "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                    "OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
                    "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
                    "OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
                    "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
                    "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
                    "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
                    "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
                    "OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
                    "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                    "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                    "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                    "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                    'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                    'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                    'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
                    "COMPARE_NAME" => $arParams["COMPARE_NAME"],
                    'USE_COUNT_PRODUCT' => $arParams['USE_COUNT_PRODUCT'],
                    'USE_COUNT_PRODUCT' => $arParams['USE_COUNT_PRODUCT'],
                    "LAZY_LOAD" => $arParams["LAZY_LOAD"],
                    "MESS_BTN_LAZY_LOAD" => $arParams["MESS_BTN_LAZY_LOAD"],
                    'PROPERTY_IS_NEW' => $arParams['PROPERTY_IS_NEW'],
                    'PROPERTY_RECOMENDATIONS' => $arParams['PROPERTY_RECOMENDATIONS'],
                    'PROPERTY_IS_POPULAR' => $arParams['PROPERTY_IS_POPULAR'],
                    'PROPERTY_IS_RECOMMENDATION' => $arParams['PROPERTY_IS_RECOMMENDATION'],
                ),
                $component
            );
            ?>
            <?php
            $resSection = CIBlockSection::GetByID($arResult["VARIABLES"]["SECTION_ID"]);
            if ($arrSection = $resSection->GetNext())
                $sectionDescription = $arrSection['DESCRIPTION'];
            if (!empty($sectionDescription)) { ?>
                <div class="intec-section-desription"><?= $sectionDescription ?></div>
            <?php } ?>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script>

    var filterSelecterDesktop;
    var filterSelecterMobile;
    var filterDesktopCode;
    var filterMobileCode;

    function windowSizeFilter(){
        if ($(window).width() <= '720'){
            if ($.trim(filterSelecterMobile.html()) == '') {
                filterSelecterMobile.html(filterMobileCode);
            }
            filterSelecterDesktop.empty();
        } else {
            if ($.trim(filterSelecterDesktop.html()) == '') {
                filterSelecterDesktop.html(filterDesktopCode);
            }
            filterSelecterMobile.empty();
        }
    }

    $(window).load(function() {
        filterSelecterDesktop = $('.intec-section-filter-left');
        filterSelecterMobile = $('.intec-section-filter-mobile');
        filterDesktopCode = filterSelecterDesktop.html();
        filterMobileCode = filterSelecterMobile.html();
        $(document).on('click', '.intec-section-filter-mobile-wrap', function() {
            $('.intec-section-filter-mobile').toggle();
        });
        windowSizeFilter();
        $(window).on('resize',windowSizeFilter);
    });
</script>