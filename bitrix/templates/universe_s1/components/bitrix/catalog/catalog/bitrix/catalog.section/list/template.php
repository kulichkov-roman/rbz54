<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
\Bitrix\Main\Loader::includeModule("intec.core");
use intec\core\helpers\ArrayHelper;

$this->setFrameMode(true);

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
<?if (!empty($arResult['ITEMS'])) {?>
    <? if ($arParams["DISPLAY_TOP_PAGER"]) { ?>
        <?= $arResult["NAV_STRING"] ?>
    <? } ?>
    <!-- items-container -->
    <div class="intec-catalog-section intec-catalog-section-list" data-entity="<?=$containerName?>">
        <?
        $strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
        $strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
        $arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
        foreach ($arResult["ITEMS"] as $cell => $arElement) {

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
            $flg_offers = 0;
            $flg_offers_can_buy = false;
            if( !empty($arElement["OFFERS"]) ) {
                $flg_offers = 1;
                foreach ($arElement["OFFERS"] as $arOffer) {
                    if ($arOffer['CAN_BUY']) {
                        $flg_offers_can_buy = true;
                    }
                }
            }?>

            <div id="<?=$this->GetEditAreaId($arElement['ID']);?>" class="catalog-section-element" data-entity="items-row">
                <div class="image-block">
                    <div class="intec-marks">
                        <?if( $arElement["PROPERTIES"][$arParams['PROPERTY_IS_RECOMMENDATION']]["VALUE"] ){?>
                            <span class="intec-mark recommend"><?=GetMessage('MARK_RECOMMEND')?></span>
                        <?}?>
                        <?if( $arElement["PROPERTIES"][$arParams['PROPERTY_IS_NEW']]["VALUE"] ){?>
                            <span class="intec-mark new"><?=GetMessage('MARK_NEW')?></span>
                        <?}?>
                        <?if($arElement["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"]){?>
                            <span class="intec-mark action">- <?=$arElement["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"];?> %</span>
                        <?}?>
                        <?if( $arElement["PROPERTIES"][$arParams['PROPERTY_IS_POPULAR']]["VALUE"] ){?>
                            <span class="intec-mark hit"><?=GetMessage('MARK_HIT')?></span>
                        <?}?>
                    </div>
                    <div class="valign"></div>
                    <a class="image-link" href="<?=$arElement['DETAIL_PAGE_URL']?>">
                        <img src="<?=$arElement['PICTURE']['src']?>" title="<?=$arElement['PICTURE']['imgTitle']?>" alt="<?=$arElement['PICTURE']['imgAlt']?>"/>
                    </a>
                </div>
                <div class="element-catalog">

                    <div class="price-block">
                        <?
                        $newprice = $arElement["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"];
                        $oldprice = $arElement["MIN_PRICE"]["PRINT_VALUE"];
                        $useDiscount = false;
                        if ($arElement["MIN_PRICE"]['DISCOUNT_DIFF']>0) {
                            $useDiscount = true;
                        }
                        ?>
                        <div class="newprice">
                            <?=($flg_offers)? GetMessage('PRICE_FROM'):''?> <?=$newprice?>
                        </div>
                        <?if ($useDiscount) {?>
                        <div class="oldprice">
                            <?=$oldprice?>
                        </div>
                        <?}?>
                    </div>
                    <?if ($arElement['CAN_BUY'] && !$flg_offers) {?>
                        <div class="buys">
                            <div class="intec-button intec-button-w-icon intec-button-cl-common intec-button-transparent intec-button-lg intec-button-fs-16 add"
                                 data-basket-add="<?= $arElement['ID'] ?>"
                                 data-basket-in="false">
                                <span class="intec-button-icon intec-basket glyph-icon-cart"></span>
                                <span class="intec-button-text intec-basket-text"><?=GetMessage('ADD_TO_CART');?></span>
                            </div>
                            <a href="<?= $arParams['BASKET_URL'] ?>"
                               class="intec-button intec-button-w-icon intec-button-cl-common intec-button-lg intec-button-fs-16 added"
                               data-basket-added="<?= $arElement['ID'] ?>"
                               data-basket-in="false">
                                <span class="intec-button-icon intec-basket glyph-icon-cart"></span>
                                <span class="intec-button-text intec-basket-text"><?=GetMessage('ADDED_TO_CART');?></span>
                            </a>
                        </div>
                        <div class="min-button-block">
                            <?if ($arParams['DISPLAY_COMPARE'] == 'Y' ) {?>
                                <div class="intec-min-button intec-min-button-compare add"
                                     data-compare-add="<?=$arElement['ID']?>"
                                     data-compare-in="false"
                                     data-compare-list="<?= $compareList ?>">
                                    <i class="glyph-icon-compare" aria-hidden="true"></i>
                                </div>
                                <div class="intec-min-button intec-min-button-compare added"
                                     data-compare-added="<?=$arElement['ID']?>"
                                     data-compare-in="false"
                                     data-compare-list="<?= $compareList ?>">
                                    <i class="glyph-icon-compare" aria-hidden="true"></i>
                                </div>
                            <?}?>
                            <div class="intec-min-button intec-min-button-like add"
                                 data-basket-delay="<?=$arElement['ID']?>"
                                 data-basket-in="false">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </div>
                            <div class="intec-min-button intec-min-button-like added"
                                 data-basket-delayed="<?=$arElement['ID']?>"
                                 data-basket-in="false">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                            </div>
                        </div>
                    <?}else if($flg_offers && $flg_offers_can_buy) {?>
                        <div class="buys">
                            <a href="<?=$arElement['DETAIL_PAGE_URL']?>" class="intec-button intec-button-w-icon intec-button-cl-common intec-button-transparent intec-button-lg intec-button-fs-16" data-product-id="<?=$arElement['ID']?>" data-quantity="1">
                                <span class="intec-button-icon intec-basket glyph-icon-cart"></span>
                                <span class="intec-button-text intec-basket-text"><?=GetMessage('MORE');?></span>
                            </a>
                        </div>
                    <?} else {?>
                        <div class="buys">
                            <?=GetMessage('PRODUCT_NOT_HAVE');?>
                        </div>
                    <?}?>
                </div>
                <div class="element-description">
                    <div class="element-name">
                        <a href="<?=$arElement['DETAIL_PAGE_URL']?>">
                            <?=$arElement['NAME']?>
                        </a>
                    </div>
                    <?if ($arParams['DISPLAY_PREVIEW']=='Y' && !empty($arElement['PREVIEW_TEXT'])){?>
                        <div class="element-preview-text">
                            <?=TruncateText($arElement['PREVIEW_TEXT'], 200);?>
                        </div>
                    <?}?>
                    <?if ($arParams['DISPLAY_PROPERTIES']=='Y' && !empty($arElement['DISPLAY_PROPERTIES']) ) {?>
                        <div class="element-properties">
                            <ul class="element-properties-ul">
                                <?foreach ($arElement['DISPLAY_PROPERTIES'] as $property) {?>
                                <li>
                                    <span>
                                        <?=$property['NAME'].' &mdash; ';?>
                                        <?=(is_array($property['VALUE']))? implode(', ', $property['VALUE']):$property['DISPLAY_VALUE']?>
                                    </span>
                                </li>
                                <?}?>
                            </ul>
                        </div>
                    <?}?>
                </div>
                <div class="clearfix"></div>
            </div>
        <? } ?>
    </div>
    <!-- items-container -->
    <div class="clear"></div>
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
<? } ?>
<?//include('scriptBasket.php');?>
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
