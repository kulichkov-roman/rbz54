<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
\Bitrix\Main\Loader::includeModule("intec.core");
use intec\core\helpers\ArrayHelper;


if (!empty($arResult['NAV_RESULT'])) {
    $navParams =  array(
        'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
        'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
        'NavNum' => $arResult['NAV_RESULT']->NavNum
    );
} else {
    $navParams = array(
        'NavPageCount' => 1,
        'NavPageNomer' => 1,
        'NavNum' => $this->randString()
    );
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;
$obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-'.$navParams['NavNum'];
$compareList = $arParams['COMPARE_NAME'];

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1) {
    $showTopPager = $arParams['DISPLAY_TOP_PAGER'];
    $showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
    $showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}
?>

<?
$this->setFrameMode(true);
switch ($arParams['LINE_ELEMENT_COUNT']) {
    case '2': $gridStyle = "col-lg-6 col-md-6 col-sm-6 col-xs-12"; break;
    case '3': $gridStyle = "col-lg-4 col-md-4 col-sm-4 col-xs-12"; break;
    default : $gridStyle = "col-lg-4 col-md-4 col-sm-4 col-xs-12"; break;
}
?>
<?if (!empty($arResult['ITEMS'])) {?>
    <div class="intec-catalog-section intec-catalog-section-tile">
        <!-- items-container -->
        <div data-entity="<?=$containerName?>">
            <?
            $frame = $this->createFrame()->begin();
            $strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
            $strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
            $arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));?>
            <? foreach ($arResult['ITEMS'] as $cell => $arElement) {?>
                <?
                $this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], $strElementEdit);
                $this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
                $strMainID = $this->GetEditAreaId($arElement['ID']);

                $arItemIDs = array(
                    'ID' => $strMainID,
                    'PICT' => $strMainID.'_pict',
                    'SECOND_PICT' => $strMainID.'_secondpict',

                    'QUANTITY' => $strMainID.'_quantity',
                    'QUANTITY_DOWN' => $strMainID.'_quant_down',
                    'QUANTITY_UP' => $strMainID.'_quant_up',
                    'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
                    'BUY_LINK' => $strMainID.'_buy_link',
                    'SUBSCRIBE_LINK' => $strMainID.'_subscribe',

                    'PRICE' => $strMainID.'_price',
                    'DSC_PERC' => $strMainID.'_dsc_perc',
                    'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',

                    'PROP_DIV' => $strMainID.'_sku_tree',
                    'PROP' => $strMainID.'_prop_',
                    'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
                    'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
                );


                $bInBasket = ArrayHelper::getValue($arElement, ['BASKET', 'IN']);
                $bInDelay = ArrayHelper::getValue($arElement, ['BASKET', 'DELAY']);
                $bInCompare = !empty(ArrayHelper::getValue($_SESSION, [$arParams['COMPARE_NAME'], $arParams['IBLOCK_ID'], 'ITEMS', $arElement['ID']]));

                $flg_offers = 0;
                $flg_offers_can_buy = false;
                if( !empty($arElement["OFFERS"]) ) {
                    $flg_offers = 1;
                    foreach ($arElement["OFFERS"] as $arOffer) {
                        if ($arOffer['CAN_BUY']) {
                            $flg_offers_can_buy = true;
                        }
                    }
                }
                ?>
                <div id="<?=$this->GetEditAreaId($arElement['ID']);?>" class="catalog-section-element <?=$gridStyle?>" data-entity="items-row">
                    <div class="element-wrap">
                        <div class="element-img-wrap">
                            <div class="intec-marks">
                                <?if( $arElement["PROPERTIES"]["RECOMMEND"]["VALUE"] ){?>
                                    <span class="intec-mark recommend"><?=GetMessage('MARK_RECOMEND')?></span>
                                <?}?>
                                <?if( $arElement["PROPERTIES"]["NEWPRODUCT"]["VALUE"] ){?>
                                    <span class="intec-mark new"><?=GetMessage('MARK_NEW')?></span>
                                <?}?>
                                <?if($arElement["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"]){?>
                                    <span class="intec-mark action">- <?=$arElement["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"];?> %</span>
                                <?}?>
                                <?if( $arElement["PROPERTIES"]["SALELEADER"]["VALUE"] ){?>
                                    <span class="intec-mark hit"><?=GetMessage('MARK_HIT')?></span>
                                <?}?>
                            </div>
                            <a href="<?= $arElement['DETAIL_PAGE_URL']?>" class="element-img">
                                <div class="intec-aligner"></div>
                                <img src="<?=$arElement["PICTURE"]["src"]?>" alt="<?=$arElement["PICTURE"]["imgAlt"]?>" title="<?=$arElement["PICTURE"]["imgTitle"]?>"/>
                            </a>
                            <?if ($arElement['CAN_BUY'] && !$flg_offers) {?>
                                <div class="min-button-block">
                                    <?if ($arParams['DISPLAY_COMPARE'] == 'Y' ) {?>
                                        <div class="intec-min-button intec-min-button-compare add"
                                             data-compare-add="<?=$arElement['ID']?>"
                                             data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                             data-compare-list="<?= $compareList ?>">
                                            <i class="glyph-icon-compare" aria-hidden="true"></i>
                                        </div>
                                        <div class="intec-min-button intec-min-button-compare added"
                                             data-compare-added="<?=$arElement['ID']?>"
                                             data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                             data-compare-list="<?= $compareList ?>">
                                            <i class="glyph-icon-compare" aria-hidden="true"></i>
                                        </div>
                                    <?}?>
                                    <div class="intec-min-button intec-min-button-like add"
                                         data-basket-delay="<?= $arElement['ID'] ?>"
                                         data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </div>
                                    <div class="intec-min-button intec-min-button-like added"
                                         data-basket-delayed="<?= $arElement['ID'] ?>"
                                         data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                        <div class="element-description">
                            <a href="<?= $arElement['DETAIL_PAGE_URL'] ?>" class="element-name">
                                <?= $arElement['NAME'] ?>
                            </a>
                            <div class="price-block">
                                <?
                                $newprice = $arElement["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"];
                                $oldprice = $arElement["MIN_PRICE"]["PRINT_VALUE"];
                                $useDiscount = false;
                                if ($newprice < $oldprice) {
                                    $useDiscount = true;
                                }
                                ?>
                                <div class="price-value">
                                    <div class="newprice">
                                        <?=($flg_offers)? GetMessage('PRICE_FROM'):''?> <?=$newprice?>
                                    </div>
                                    <?if ($useDiscount) {?>
                                        <div class="oldprice">
                                            <?=$oldprice?>
                                        </div>
                                    <?}?>
                                </div>
                                <?
                                if ($arParams['USE_COUNT_PRODUCT']!='Y') {
                                    if ($arElement['CAN_BUY'] && !$flg_offers) {?>
                                        <a class="element-buys add"
                                           data-basket-add="<?= $arElement['ID'] ?>"
                                           data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>">
                                            <div class="intec-aligner"></div>
                                            <span class="intec-basket glyph-icon-cart"></span>
                                        </a>
                                        <a class="element-buys added"
                                           href="<?= $arParams['BASKET_URL'] ?>"
                                           data-basket-added="<?= $arElement['ID'] ?>"
                                           data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                           href="<?= $arResult['BASKET_URL'] ?>">
                                            <div class="intec-aligner"></div>
                                            <span class="intec-basket glyph-icon-cart"></span>
                                        </a>
                                    <?}else if($flg_offers && $flg_offers_can_buy) {?>
                                        <a href="<?= $arElement['DETAIL_PAGE_URL'] ?>" class="element-buys">
                                            <div class="intec-aligner"></div>
                                            <span class="intec-basket glyph-icon-cart"></span>
                                        </a>
                                    <?}?>
                                <?}
                                ?>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                        <?if ($arParams['USE_COUNT_PRODUCT']=='Y'){?>
                            <div class="element-buys-block">
                                <?if ($arElement['CAN_BUY'] && !$flg_offers) {?>
                                    <div class="buys">
												<span class="quantity-wrap" data-max-quantity="<?= $arElement['CATALOG_QUANTITY'] ?>" data-measure-ratio="<?=$arElement['CATALOG_MEASURE_RATIO'] ?>">
													<a href="javascript:void(0)"
                                                       class="intec-bt-button-type-2 button-small quantity-down">-</a>
													<input
                                                            type="text"
                                                            class="quantity-input"
                                                            value="<?=$arElement['CATALOG_MEASURE_RATIO']?>" />
													<a href="javascript:void(0)"
                                                       class="intec-bt-button-type-2 button-small quantity-up">+</a>
												</span>
                                        <div class="to-cart">
                                            <a href="javascript:void(0);" class="intec-button intec-button-transparent intec-button-cl-common add" data-product-id="<?=$arElement['ID']?>" data-quantity="1">
                                                <span class="intec-basket glyph-icon-cart"></span>
                                                <span class="intec-basket-text"><?=GetMessage('ADD_TO_CART');?></span>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                <?}else if($flg_offers && $flg_offers_can_buy) {?>
                                    <div class="buys_more">
                                        <a href="<?=$arElement['DETAIL_PAGE_URL']?>" class="intec-button intec-button-transparent intec-button-cl-common" data-product-id="<?=$arElement['ID']?>" data-quantity="1">
                                            <span class="intec-basket glyph-icon-cart"></span>
                                            <span class="intec-basket-text"><?=GetMessage('MORE');?></span>
                                        </a>
                                    </div>
                                <?} else {?>
                                    <div class="buys_not_have">
                                        <?=GetMessage('PRODUCT_NOT_HAVE');?>
                                    </div>
                                <?}?>
                            </div>
                        <?}?>
                    </div>
                </div>
            <?}?>
        </div>
        <!-- items-container -->
        <div class="clearfix"></div>
    </div>
<?}?>
<?if ($showLazyLoad){ ?>
    <div class="row bx-<?=$arParams['TEMPLATE_THEME']?>">
        <div class="show-more show-more-btn intec-cl-text"
             data-use="show-more-<?=$navParams['NavNum']?>">
            <i class="glyph-icon-show-more intec-cl-background"></i>
            <?=$arParams['MESS_BTN_LAZY_LOAD']?>
        </div>
    </div>
<? }
if ($showBottomPager) {?>
    <div data-pagination-num="<?=$navParams['NavNum']?>">
        <!-- pagination-container -->
        <?=$arResult['NAV_STRING']?>
        <!-- pagination-container -->
    </div>
    <?
}?>
<?
$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'catalog.section');
$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
?>
<script>
    BX.message({
        BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
        BASKET_URL: '<?=$arParams['BASKET_URL']?>',
        ADD_TO_BASKET_OK: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
        TITLE_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR')?>',
        TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS')?>',
        TITLE_SUCCESSFUL: '<?=GetMessageJS('ADD_TO_BASKET_OK')?>',
        BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR')?>',
        BTN_MESSAGE_SEND_PROPS: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS')?>',
        BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE')?>',
        BTN_MESSAGE_CLOSE_POPUP: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
        COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_OK')?>',
        COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
        COMPARE_TITLE: '<?=GetMessageJS('CT_BCS_CATALOG_MESS_COMPARE_TITLE')?>',
        PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCS_CATALOG_PRICE_TOTAL_PREFIX')?>',
        RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
        RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
        BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
        BTN_MESSAGE_LAZY_LOAD: '<?=$arParams['MESS_BTN_LAZY_LOAD']?>',
        BTN_MESSAGE_LAZY_LOAD_WAITER: '<?=GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_LAZY_LOAD_WAITER')?>',
        SITE_ID: '<?=SITE_ID?>'
    });
    var <?=$obName?> = new JCCatalogSectionComponent({
        siteId: '<?=CUtil::JSEscape(SITE_ID)?>',
        componentPath: '<?=CUtil::JSEscape($componentPath)?>',
        navParams: <?=CUtil::PhpToJSObject($navParams)?>,
        deferredLoad: false, // enable it for deferred load
        initiallyShowHeader: '<?=!empty($arResult['ITEM_ROWS'])?>',
        bigData: <?=CUtil::PhpToJSObject($arResult['BIG_DATA'])?>,
        lazyLoad: !!'<?=$showLazyLoad?>',
        loadOnScroll: !!'<?=($arParams['LOAD_ON_SCROLL'] === 'Y')?>',
        template: '<?=CUtil::JSEscape($signedTemplate)?>',
        ajaxId: '<?=CUtil::JSEscape($arParams['AJAX_ID'])?>',
        parameters: '<?=CUtil::JSEscape($signedParams)?>',
        container: '<?=$containerName?>'
    });
</script>

