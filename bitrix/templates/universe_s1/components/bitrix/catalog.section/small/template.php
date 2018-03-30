<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/**
 * @var $arResult
 */

$this->setFrameMode(true);

$componentHash = spl_object_hash($this);

if (!empty($arResult['ITEMS'])) { ?>
    <div class="item-bind-items" id="<?= $componentHash ?>">
        <? if (!empty($arParams['TITLE'])) { ?>
            <div class="item-sub-title"><?= $arParams['TITLE'] ?></div>
        <? } ?>
        <div class="item-bind-items-list owl-carousel">
            <? foreach ($arResult['ITEMS'] as $item) { ?>
                <div class="item-bind-item clearfix">
                    <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="item-bind-image"
                       style="background-image: url('<?= $item['PREVIEW_PICTURE']['SRC'] ?>')"></a>
                    <div class="item-bind-info">
                        <a href="<?= $item['DETAIL_PAGE_URL'] ?>" class="item-bind-name"><?= $item['NAME'] ?></a>
                        <? if ($item['PRICE']) { ?>
                            <div class="item-bind-price"><?= $item['PRICE']['PRINT_DISCOUNT_VALUE'] ?></div>
                        <? } ?>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
    <?
    include('javascript.php');
}