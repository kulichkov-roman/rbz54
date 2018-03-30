<?php

use intec\core\helpers\JavaScript;
use intec\core\helpers\ArrayHelper;

/**
 * @var $APPLICATION
 * @var array $arResult
 * @var array $arParams
 * @var array $component
 * @var array $arItemIDs
 * @var array $minPrice
 * @var boolean $canBuy
 * @var array $currentOffer
 * @var boolean $showBuyBtn
 * @var boolean $showAddBtn
 * @var boolean $showSubscribeBtn
 */

$buyBtnMessage = $arParams['MESS_BTN_BUY'] != '' ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCE_CATALOG_BUY');
$addToBasketBtnMessage = $arParams['MESS_BTN_ADD_TO_BASKET'] != '' ? $arParams['MESS_BTN_ADD_TO_BASKET'] : GetMessage('CT_BCE_CATALOG_ADD');
$notAvailableMessage = $arParams['MESS_NOT_AVAILABLE'] != '' ? $arParams['MESS_NOT_AVAILABLE'] : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE');
$compareBtnMessage = $arParams['MESS_BTN_COMPARE'] != '' ? $arParams['MESS_BTN_COMPARE'] : GetMessage('CT_BCE_CATALOG_COMPARE');

$iIBlockId = $arResult['IBLOCK_ID'];
$bInBasket = ArrayHelper::getValue($arResult, ['BASKET', 'IN']);
$bInDelay = ArrayHelper::getValue($arResult, ['BASKET', 'DELAY']);
$bInCompare = !empty(ArrayHelper::getValue($_SESSION, [$arParams['COMPARE_NAME'], $arParams['IBLOCK_ID'], 'ITEMS', $arResult['ID']]));
$compareList = $arParams['COMPARE_NAME'];
?>

<div class="row">
    <div class="col-xs-5 column-price-value">
        <?php if ($canBuy) { ?>
            <div class="item-price">
                <div class="item-current-price-wrap">
                    <div class="item-current-price"><?= $minPrice['PRINT_DISCOUNT_VALUE'] ?></div>
                    <?php if ('Y' == $arParams['SHOW_MAX_QUANTITY']) {
                        if (!empty($arResult['OFFERS'])) {
                            ?>
                            <div class="item-quantity text-muted" id="<?= $arItemIDs['QUANTITY_LIMIT'] ?>">
                                <?= GetMessage('OSTATOK') ?> <span><?= $currentOffer['CATALOG_QUANTITY'] .' '. $currentOffer['CATALOG_MEASURE_NAME'] ?></span>
                            </div>
                            <?php
                        } else if ('Y' == $arResult['CATALOG_QUANTITY_TRACE'] && 'N' == $arResult['CATALOG_CAN_BUY_ZERO']) {
                            ?>
                            <div class="item-quantity text-muted" id="<? $arItemIDs['QUANTITY_LIMIT'] ?>">
                                <?= GetMessage('OSTATOK') ?> <span><?= $arResult['CATALOG_QUANTITY'] .' '. $arResult['CATALOG_MEASURE_NAME'] ?></span>
                            </div>
                            <?php
                        }
                    } ?>
                </div>
                <div class="item-old-price-wrap">
                    <?php if ($arParams['SHOW_OLD_PRICE'] == 'Y') {
                        $boolDiscountShow = $minPrice['DISCOUNT_DIFF'] > 0;
                        ?>
                        <div class="item-old-price" style="<?= $boolDiscountShow ? '' : 'display: none' ?>">
                            <?= $boolDiscountShow ? $minPrice['PRINT_VALUE'] : '' ?>
                        </div>
                    <?php } ?>

                    <?php if ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y') {
                        if (empty($arResult['OFFERS'])) {
                            if ($arResult['MIN_PRICE']['DISCOUNT_DIFF'] > 0) { ?>
                                <div class="item-discount-percents" id="<?= $arItemIDs['DISCOUNT_PICT_ID'] ?>">
                                    <?= -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ?>%
                                </div>
                            <?php }
                        } elseif ($currentOffer) {
                            if ($currentOffer['MIN_PRICE']['DISCOUNT_DIFF'] > 0) { ?>
                            <div class="item-discount-percents" id="<?= $arItemIDs['DISCOUNT_PICT_ID'] ?>">
                                <?= -$currentOffer['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] ?>%
                            </div>
                        <?php }
                        }
                    } ?>
                </div>
            </div>
        <?php } else { ?>
            <span id="<?= $arItemIDs['NOT_AVAILABLE_MESS'] ?>" class="product-not-available"><?= $notAvailableMessage ?></span>
        <?php }
        unset($minPrice); ?>
    </div>
    <div class="col-xs-7 column-buy-button" style="<?= !$currentOffer['CAN_BUY'] ? 'display: none;' : '' ?>">
        <div class="item-info-section clearfix">
            <?php if ($arParams['USE_PRODUCT_QUANTITY'] == 'Y') { ?>
                <?php if (!empty($arResult['OFFERS'])) { ?>
                    <?php foreach($arResult['OFFERS'] as $key => $arOffer) {
                        $bInBasket = ArrayHelper::getValue($arOffer, ['BASKET', 'IN']);
                        $bInDelay = ArrayHelper::getValue($arOffer, ['BASKET', 'DELAY']);
                        $bInCompare = !empty(ArrayHelper::getValue($_SESSION, [$arParams['COMPARE_NAME'], 'ITEMS', $arResult['ID']]));

                        if ($canBuy) {

                        ?>
                        <div class="item-buttons-block block-<?= $arOffer['ID'] ?>" style="display: none;">
                            <div class="item-buttons vam">
                                <?php if ($showBuyBtn || $showAddBtn) { ?>
                                    <span class="item-quantity-wrap" data-max-quantity="<?= $arOffer['CATALOG_QUANTITY'] ?>">
                                        <a href="javascript:void(0)"
                                           class="intec-bt-button-type-2 button-small item-quantity-down"
                                           id="<?= $arItemIDs['QUANTITY_DOWN'] ?>">-</a>
                                        <input id="<?= $arItemIDs['QUANTITY'] ?>"
                                               type="text"
                                               class="item-quantity-input"
                                               value="<?= $arOffer['CATALOG_MEASURE_RATIO'] ?>" />
                                        <a href="javascript:void(0)"
                                           class="intec-bt-button-type-2 button-small item-quantity-up"
                                           id="<?= $arItemIDs['QUANTITY_UP'] ?>">+</a>
                                        <span class="item-quantity-measure" id="<?= $arItemIDs['QUANTITY_MEASURE'] ?>">
                                            <?= isset($arOffer['CATALOG_MEASURE_NAME']) ? $arOffer['CATALOG_MEASURE_NAME'] : '' ?>
                                        </span>
                                    </span>
                                <?php } ?>
                                <span class="item-buttons-counter-block">
                                    <a class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button add"
                                       data-basket-add="<?= $arOffer['ID'] ?>"
                                       data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                       data-basket-quantity="1">
                                        <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                        <span class="intec-basket-text"><?= $buyBtnMessage ?></span>
                                    </a>
                                    <a href="<?= $arParams['BASKET_URL'] ?>"
                                       class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button added"
                                       data-basket-added="<?= $arOffer['ID'] ?>"
                                       data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                       data-basket-quantity="1">
                                        <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                        <span class="intec-basket-text">
                                            <?= GetMessage('CT_BCE_CATALOG_ADDED') ?>
                                        </span>
                                    </a>
                                    <?php if ($arParams['USE_FAST_ORDER'] == 'Y') { ?>
                                        <span class="intec-button intec-button-link jsFastOrder">
                                            <i class="intec-button-w-icon glyph-icon-one_click"></i>
                                            <?= GetMessage('CE_FAST_ORDER') ?>
                                        </span>
                                    <?php } ?>
                                </span>
                            </div>
                            <span class="intec-small-buttons-wrapper">
                                <?php if ($arParams['DISPLAY_COMPARE']) { ?>
                                    <span class="intec-compare glyph-icon-compare add"
                                          data-compare-add="<?= $arOffer['ID'] ?>"
                                          data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                          data-compare-list="<?= $compareList ?>"
                                          data-compare-iblock="<?= $iIBlockId ?>">
                                    </span>
                                    <span class="intec-compare glyph-icon-compare active added"
                                          data-compare-added="<?= $arOffer['ID'] ?>"
                                          data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                          data-compare-list="<?= $compareList ?>"
                                          data-compare-iblock="<?= $iIBlockId ?>">
                                    </span>
                                <?php } ?>
                                <span class="intec-like fa fa-heart add"
                                      data-basket-delay="<?= $arOffer['ID'] ?>"
                                      data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>">
                                </span>
                                <span class="intec-like fa fa-heart added active"
                                      data-basket-delayed="<?= $arOffer['ID'] ?>"
                                      data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>">
                                </span>
                            </span>
                        </div>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                    <div class="item-buttons vam">
                        <?php if ($canBuy) {
                            if ($showBuyBtn || $showAddBtn) { ?>
                                <span class="item-quantity-wrap" data-max-quantity="<?= $arResult['CATALOG_QUANTITY'] ?>">
                                    <a href="javascript:void(0)"
                                       class="intec-bt-button-type-2 button-small item-quantity-down"
                                       id="<?= $arItemIDs['QUANTITY_DOWN'] ?>">-</a>
                                    <input id="<?= $arItemIDs['QUANTITY'] ?>"
                                           type="text"
                                           class="item-quantity-input"
                                           value="<?= !empty($arResult['OFFERS']) ? 1 : $arResult['CATALOG_MEASURE_RATIO'] ?>" />
                                    <a href="javascript:void(0)"
                                       class="intec-bt-button-type-2 button-small item-quantity-up"
                                       id="<?= $arItemIDs['QUANTITY_UP'] ?>">+</a>
                                    <span class="item-quantity-measure" id="<?= $arItemIDs['QUANTITY_MEASURE'] ?>">
                                        <?= isset($arResult['CATALOG_MEASURE_NAME']) ? $arResult['CATALOG_MEASURE_NAME'] : '' ?>
                                    </span>
                                </span>
                            <?php } ?>
                            <span class="item-buttons-counter-block" id="<?= $arItemIDs['BASKET_ACTIONS'] ?>">
                                <?php if ($showBuyBtn) { ?>
                                    <a class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button add"
                                       data-basket-add="<?= $arResult['ID'] ?>"
                                       data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                       data-basket-quantity="1">
                                        <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                        <span class="intec-basket-text"><?= $buyBtnMessage ?></span>
                                    </a>
                                <?php } else if ($showAddBtn) { ?>
                                    <a class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button add"
                                       id="<?= $arItemIDs['ADD_BASKET_LINK'] ?>"
                                       data-basket-add="<?= $arResult['ID'] ?>"
                                       data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                       data-basket-quantity="1">
                                        <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                        <span class="intec-basket-text"><?= $addToBasketBtnMessage ?></span>
                                    </a>
                                <?php } ?>
                                <a href="<?= $arParams['BASKET_URL'] ?>"
                                   class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button added"
                                   data-basket-added="<?= $arResult['ID'] ?>"
                                   data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                   data-basket-quantity="1">
                                    <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                    <span class="intec-basket-text"><?= GetMessage('CT_BCE_CATALOG_ADDED') ?></span>
                                </a>

                                <?php if ($arParams['USE_FAST_ORDER'] == 'Y') { ?>
                                    <span class="intec-button intec-button-link jsFastOrder">
                                        <i class="intec-button-w-icon glyph-icon-one_click"></i>
                                        <?= GetMessage('CE_FAST_ORDER') ?>
                                    </span>
                                <?php } ?>
                            </span>
                        <?php } ?>

                        <?php if ($showSubscribeBtn) {
                            $APPLICATION->includeComponent('bitrix:catalog.product.subscribe', '',
                                array(
                                    'PRODUCT_ID' => $arResult['ID'],
                                    'BUTTON_ID' => $arItemIDs['SUBSCRIBE_LINK'],
                                    'BUTTON_CLASS' => 'bx_big bx_bt_button',
                                    'DEFAULT_DISPLAY' => !$canBuy,
                                ),
                                $component, array('HIDE_ICONS' => 'Y')
                            );
                        } ?>
                    </div>
                    <span class="intec-small-buttons-wrapper">
                        <?php if ($arParams['DISPLAY_COMPARE']) { ?>
                            <span class="intec-compare glyph-icon-compare add"
                                  data-compare-add="<?= $arResult['ID'] ?>"
                                  data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                  data-compare-list="<?= $compareList ?>"></span>
                            <span class="intec-compare glyph-icon-compare active added"
                                  data-compare-added="<?= $arResult['ID'] ?>"
                                  data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                  data-compare-list="<?= $compareList ?>"></span>
                        <?php } ?>
                        <span class="intec-like fa fa-heart add <?= $arResult['IN_DELAY'] ? 'active' : '' ?>"
                              data-basket-delay="<?= $arResult['ID'] ?>"
                              data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>"></span>
                        <span class="intec-like fa fa-heart added active <?= $arResult['IN_DELAY'] ? 'active' : '' ?>"
                              data-basket-delayed="<?= $arResult['ID'] ?>"
                              data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>"></span>
                    </span>
                <?php } ?>
            <?php } else { ?>
                <?php if (!empty($arResult['OFFERS'])) { ?>
                    <?php foreach($arResult['OFFERS'] as $key => $arOffer) {
                        $bInBasket = ArrayHelper::getValue($arOffer, ['BASKET', 'IN']);
                        $bInDelay = ArrayHelper::getValue($arOffer, ['BASKET', 'DELAY']);
                        $bInCompare = !empty(ArrayHelper::getValue($_SESSION, [$arParams['COMPARE_NAME'], 'ITEMS', $arResult['ID']]));
                        ?>
                        <div class="item-buttons-block block-<?= $arOffer['ID'] ?>" style="display: none;">
                            <div class="item-buttons vam">
                                <span class="item-buttons-counter-block">
                                    <a class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button add"
                                       data-basket-add="<?= $arOffer['ID'] ?>"
                                       data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                       data-basket-quantity="1">
                                        <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                        <span class="intec-basket-text"><?= $buyBtnMessage ?></span>
                                    </a>

                                    <a href="<?= $arParams['BASKET_URL'] ?>"
                                       class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button added"
                                       data-basket-added="<?= $arOffer['ID'] ?>"
                                       data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                       data-basket-quantity="1">
                                        <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                        <span class="intec-basket-text">
                                            <?= GetMessage('CT_BCE_CATALOG_ADDED') ?>
                                        </span>
                                    </a>
                                </span>
                            </div>
                            <span class="intec-small-buttons-wrapper">
                                <?php if ($arParams['DISPLAY_COMPARE']) { ?>
                                    <span class="intec-compare glyph-icon-compare add"
                                          data-compare-add="<?= $arOffer['ID'] ?>"
                                          data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                          data-compare-list="<?= $compareList ?>"
                                          data-compare-iblock="<?= $iIBlockId ?>">
                                    </span>
                                    <span class="intec-compare glyph-icon-compare active added"
                                          data-compare-added="<?= $arOffer['ID'] ?>"
                                          data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                          data-compare-list="<?= $compareList ?>"
                                          data-compare-iblock="<?= $iIBlockId ?>">
                                    </span>
                                <?php } ?>
                                <span class="intec-like fa fa-heart add"
                                      data-basket-delay="<?= $arOffer['ID'] ?>"
                                      data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>">
                                </span>
                                <span class="intec-like fa fa-heart added active"
                                      data-basket-delayed="<?= $arOffer['ID'] ?>"
                                      data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>">
                                </span>
                            </span>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="item-buttons vam">
                        <span class="item-buttons-counter-block"
                              id="<?= $arItemIDs['BASKET_ACTIONS'] ?>"
                              style="<?= $canBuy ? '' : 'display: none;' ?>">
                            <?php if ($showBuyBtn) { ?>
                                <a class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button add"
                                   data-basket-add="<?= $arResult['ID'] ?>"
                                   data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                   data-basket-quantity="1">
                                    <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                    <span class="intec-basket-text"><?= $buyBtnMessage ?></span>
                                </a>
                            <?php } else if ($showAddBtn) { ?>
                                <a class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button add"
                                   data-basket-add="<?= $arResult['ID'] ?>"
                                   data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                                   data-basket-quantity="1">
                                    <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                    <span class="intec-basket-text"><?= $addToBasketBtnMessage ?></span>
                                </a>
                            <?php } ?>
                            <a href="<?= $arParams['BASKET_URL'] ?>"
                               class="intec-button intec-button-cl-common intec-button-md intec-button-s-7 intec-button-fs-16 intec-button-block intec-basket-button added"
                               data-basket-added="<?= $arResult['ID'] ?>"
                               data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>"
                               data-basket-quantity="1">
                                <span class="intec-button-w-icon intec-basket glyph-icon-cart"></span>
                                <span class="intec-basket-text"><?= GetMessage('CT_BCE_CATALOG_ADDED') ?></span>
                            </a>
                            <?php if ($arParams['USE_FAST_ORDER'] == 'Y') { ?>
                                <span class="intec-button intec-button-link jsFastOrder">
                                    <i class="intec-button-w-icon glyph-icon-one_click"></i>
                                    <?= GetMessage('CE_FAST_ORDER') ?>
                                </span>
                            <?php } ?>
                        </span>
                        <?php /*if ($showSubscribeBtn) {
                            $APPLICATION->IncludeComponent('bitrix:catalog.product.subscribe', '',
                                array(
                                    'PRODUCT_ID' => $arResult['ID'],
                                    'BUTTON_ID' => $arItemIDs['SUBSCRIBE_LINK'],
                                    'BUTTON_CLASS' => 'bx_big bx_bt_button',
                                    'DEFAULT_DISPLAY' => !$canBuy,
                                ),
                                $component, array('HIDE_ICONS' => 'Y')
                            );
                        }*/ ?>
                    </div>
                    <?php
                    unset($showAddBtn, $showBuyBtn); ?>

                    <span class="intec-small-buttons-wrapper">
                        <?php if ($arParams['DISPLAY_COMPARE']) { ?>
                            <span class="intec-compare glyph-icon-compare add"
                                  data-compare-add="<?= $arResult['ID'] ?>"
                                  data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                  data-compare-list="<?= $compareList ?>">
                            </span>
                            <span class="intec-compare glyph-icon-compare active added"
                                  data-compare-added="<?= $arResult['ID'] ?>"
                                  data-compare-in="<?= $bInCompare ? 'true' : 'false' ?>"
                                  data-compare-list="<?= $compareList ?>">
                            </span>
                        <?php } ?>
                        <span class="intec-like fa fa-heart add <?= $arResult['IN_DELAY'] ? 'active' : '' ?>"
                              data-basket-delay="<?= $arResult['ID'] ?>"
                              data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>">
                        </span>
                        <span class="intec-like fa fa-heart added active <?= $arResult['IN_DELAY'] ? 'active' : '' ?>"
                              data-basket-delayed="<?= $arResult['ID'] ?>"
                              data-basket-in="<?= $bInDelay ? 'true' : 'false' ?>">
                        </span>
                    </span>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<?php //print_r($arResult['OFFERS'])?>

<script type="text/javascript">
    <?php if (!empty($arResult['OFFERS'])) { ?>
        window.offers = new universe.catalog.offers(<?= JavaScript::toObject($arJSParams) ?>);
        offers.setCurrentOfferByID(<?= $currentOffer['ID'] ?>);
        $('.intec-item-detail .item-buttons-block.block-'+<?= $currentOffer['ID'] ?>).show();
        offers.on('offerChange', function(event, parameters) {
            var $container = $('#item-offer-' + parameters.offer['ID']),
                $buyButtonText = $('.intec-item-detail .intec-basket-button .intec-basket-text');

            if ($container) {
                var $containerSiblings = $container.siblings('.item-offer-images');
                $container.fadeIn(500);
                $containerSiblings.fadeOut(500);
                $containerSiblings.find('.slider-item').removeClass('active');
            } else {
                $('.item-offers-images > .item-offer-images').fadeOut(500);
                $('.item-offers-images > .item-default-images').animate({opacity: 1}, 500);
            }

            var propertyValueSelector = function (properties, codeKey, valueKey) {
                var result = [];

                codeKey = codeKey || 'key';
                valueKey = valueKey || 'value';

                intec.each(properties, function(i, property){
                    if (property[codeKey] && property[valueKey])
                        result.push('[data-property-code="'+ property[codeKey] +'"] [data-property-value="'+ property[valueKey] +'"]');
                });

                return result.join(', ');
            };

            // Properties values
            $(propertyValueSelector(parameters.properties.disabled)).addClass('disabled');
            $(propertyValueSelector(parameters.properties.enabled)).removeClass('disabled');
            $('[data-property-value]').removeClass('active');
            $(propertyValueSelector(parameters.properties.selected)).addClass('active');

            // Show offer content
            var $itemDetail = $('.intec-item-detail');
            $itemDetail.data('offer-id', parameters.offer['ID']);

            if (parameters.offer['CAN_BUY']) {
                $('.column-buy-button', $itemDetail).show();
            } else {
                $('.column-buy-button', $itemDetail).hide();
            }

            $('.item-current-price', $itemDetail).html(parameters.offer['PRICE']['PRINT_DISCOUNT_VALUE']);
            $('.item-old-price', $itemDetail).html(parameters.offer['PRICE']['PRINT_VALUE']);
            $('.item-discount-percents', $itemDetail).html('-' + parameters.offer['PRICE']['DISCOUNT_DIFF_PERCENT'] + '%');
            $('[data-max-quantity]', $itemDetail).data('max-quantity', parameters.offer['MAX_QUANTITY']);
            $('.item-quantity-input', $itemDetail).trigger('change');
            $('.item-quantity > span', $itemDetail).html(parameters.offer['MAX_QUANTITY'] + ' ' + parameters.offer['MEASURE']);
            $('.item-bigimage', $itemDetail).attr('src', parameters.offer['DETAIL_PICTURE']['SRC']).trigger('changeImage');
            $('.item-buttons-block', $itemDetail).hide();
            $('.item-buttons-block.block-'+parameters.offer['ID'], $itemDetail).show();
        });
    <?php } ?>

    // Fast order
    $(document).on('click', '.intec-item-detail .jsFastOrder', function(){
        var parameters;

        parameters = <?= JavaScript::toObject(array(
            'TITLE' => $arParams['FAST_ORDER_TITLE'],
            'SEND' => $arParams['FAST_ORDER_SEND_BUTTON'],
            'SHOW_COMMENT' => $arParams['FAST_ORDER_SHOW_COMMENT'],
            'PRICE_TYPE_ID' => $arParams['FAST_ORDER_PRICE_TYPE'],
            'DELIVERY_ID' => $arParams['FAST_ORDER_DELIVERY_TYPE'],
            'PAYMENT_ID' => $arParams['FAST_ORDER_PAYMET_TYPE'],
            'PERSON_TYPE_ID' => $arParams['FAST_ORDER_PAYER_TYPE'],
            'SHOW_ORDER_PROPERTIES' => $arParams['FAST_ORDER_SHOW_PROPERTIES'],
            'PROPERTY_PHONE' => $arParams['FAST_ORDER_PROPERTY_PHONE'],
            'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'_FAST_ORDER'
        )) ?>;
        parameters.PRODUCT_ID = $('.intec-item-detail').data('offer-id');

        universe.components.show({
            component: 'intec.universe:sale.order.fast',
            template: '<?= $arParams['FAST_ORDER_TEMPLATE'] ?>',
            parameters: parameters,
            settings: {
                width: 800
            }
        });
    });
</script>
