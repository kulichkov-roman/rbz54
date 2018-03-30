<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use intec\core\helpers\ArrayHelper;

/** @var array $arParams */

$this->setFrameMode(true);
$componentHash = spl_object_hash($this);
$sectionName = null;
$sectionUrl = null;
$canBuy = false;
$bInBasket = null;
$basketUrl = ArrayHelper::getValue($arParams, 'PROPERTY_BASKET_URL');
?>
<?php if (!empty($arResult['ITEMS'])): ?>
    <div class="share-products-block clearfix">
        <?php foreach ($arResult['ITEMS'] as $arItem): ?>
            <?php
                $res = CIBlockSection::GetByID($arItem["IBLOCK_SECTION_ID"]);

                if ($arSection = $res->GetNext()) {
                    $sectionName = $arSection['NAME'];
                    $sectionUrl = $arSection['SECTION_PAGE_URL'];
                }

                $price = null;
                $discountPrice = null;
                $oldPrice = null;
                $offersFLG = false;

                if (!empty($arItem['OFFERS'])) {
                    $minPrice = null;
                    $printPrice = null;
                    $price = null;
                    foreach ($arItem['OFFERS'] as $arOffer) {
                        $newPrice = $arOffer['MIN_PRICE']['DISCOUNT_VALUE'];
                        if ($minPrice === null || $newPrice < $minPrice) {
                            $minPrice = $newPrice;
                            $printPrice = $arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
                            if ($minPrice < $arOffer['MIN_PRICE']['VALUE']) {
                                $oldPrice = $arOffer['MIN_PRICE']['PRINT_VALUE'];
                            }
                        }
                        if ($arOffer['MIN_PRICE']['CAN_BUY'] == 'Y') {
                            $canBuy = true;
                        } else {
                            $canBuy = false;
                        }
                    }
                    $price = $printPrice;
                    $offersFLG = true;
                } else {
                    $price = $arItem['MIN_PRICE']['VALUE'];
                    $discountPrice = $arItem['MIN_PRICE']['DISCOUNT_VALUE'];
                    if ($price > $discountPrice) {
                        $oldPrice = $arItem['MIN_PRICE']['PRINT_VALUE'];
                        $price = $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
                    } else {
                        $price = $arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
                    }

                    if ($arItem['MIN_PRICE']['CAN_BUY'] == 'Y') {
                        $canBuy = true;
                        $bInBasket = ArrayHelper::getValue($arItem, ['BASKET', 'IN']);
                    } else {
                        $canBuy = false;
                    }
                }
            ?>
            <div class="products-element">
                <div class="element-wrapper">
                    <div class="element-img" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                        <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                            <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>">
                            <div class="intec-aligner"></div>
                        </a>
                    </div>
                    <div class="element-text">
                        <span class="text-name">
                            <a class="intec-cl-text-hover" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                                <?= $arItem['NAME'] ?>
                            </a>
                        </span>
                        <span class="text-section">
                            <a class="intec-cl-text-hover" href="<?= $sectionUrl ?>">
                                <?= $sectionName ?>
                            </a>
                        </span>
                    </div>
                    <div class="price-block">
                        <div class="price">
                            <span class="new-price">
                                <?php if ($offersFLG && !empty($price)): ?>
                                    <?= GetMessage('FROM') ?>
                                <?php endif; ?>
                                <?= $price ?>
                            </span>
                            <?php if ($oldPrice): ?>
                                <span class="old-price">
                                    <?= $oldPrice ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($canBuy) { ?>
                                <?php if ($offersFLG) { ?>
                                    <a class="element-buy add intec-cl-text intec-cl-text-light-hover"
                                       href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                                        <span class="glyph-icon-cart"></span>
                                    </a>
                                <?php } else { ?>
                                    <a class="element-buy add intec-cl-text intec-cl-text-light-hover"
                                       data-basket-add="<?= $arItem['ID'] ?>"
                                       data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>">
                                        <span class="glyph-icon-cart"></span>
                                    </a>
                                    <a class="element-buy added intec-cl-background intec-cl-background-light-hover"
                                       href="<?= $basketUrl ?>"
                                       data-basket-add="<?= $arItem['ID'] ?>"
                                       data-basket-in="<?= $bInBasket ? 'true' : 'false' ?>">
                                        <span class="glyph-icon-cart"></span>
                                    </a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?//print_r($arResult['ITEMS'])?>