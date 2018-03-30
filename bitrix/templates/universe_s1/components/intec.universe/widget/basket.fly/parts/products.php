<?php

/**
 * @var $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var array $products
 */

?>
<table class="flying-basket_table_products" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th class="column-image"></th>
            <th class="column-name"><?= GetMessage('WBF_COLUMN_NAME') ?></th>
            <th class="column-price"><?= GetMessage('WBF_COLUMN_PRICE') ?></th>
            <th class="column-quantity"><?= GetMessage('WBF_COLUMN_QUANTITY') ?></th>
            <th class="column-sum"><?= GetMessage('WBF_COLUMN_SUM') ?></th>
            <th class="column-control"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product_id => $item) { ?>
        <tr data-product-id="<?= $product_id ?>"
            data-max-quantity="<?= $item['PRODUCT']['QUANTITY'] ?>">
            <td class="column-image">
                <?php if (!empty($item['ELEMENT']['PREVIEW_PICTURE']) && is_array($item['ELEMENT']['PREVIEW_PICTURE'])) { ?>
                    <a href="<?= $item['DETAIL_PAGE_URL'] ?>">
                        <span class="product-image"
                              style="background-image: url(<?= $item['ELEMENT']['PREVIEW_PICTURE']['SRC'] ?>);"></span>
                    </a>
                <?php } ?>
            </td>
            <td class="column-name">
                <a class="intec-cl-text" href="<?= $item['DETAIL_PAGE_URL'] ?>"><?= $item['NAME'] ?></a>
            </td>
            <td class="column-price">
                <?= CurrencyFormat($item['PRICE'], $item['CURRENCY']) ?>
            </td>
            <td class="column-quantity">
                <?php if ($item['DELAY'] == 'Y') {
                    echo $item['QUANTITY'];
                } else { ?>
                    <div class="quantity-wrapper intec-no-select">
                        <span class="quantity-down">-</span>
                        <input type="text"
                               class="intec-input quantity-value"
                               value="<?= $item['QUANTITY'] ?>" />
                        <span class="quantity-up">+</span>
                    </div>
                <?php } ?>
            </td>
            <td class="column-sum">
                <?= CurrencyFormat($item['TOTAL_PRICE'], $item['CURRENCY']) ?>
            </td>
            <td class="column-control">
                <?php if ($item['DELAY'] == 'Y') { ?>
                    <span class="add-item glyph-icon-cart intec-cl-text-hover" title="<?= GetMessage('WBF_BUTTON_TO_BASKET') ?>"></span>
                <?php } else { ?>
                    <span class="delay-item fa fa-heart intec-cl-text-hover" title="<?= GetMessage('WBF_BUTTON_DELAY') ?>"></span>
                <?php } ?>
                <span class="delete-item glyph-icon-cancel" title="<?= GetMessage('WBF_BUTTON_DELETE') ?>"></span>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
