<script>
// Add product to basket
$(document).on('click', '.element-buys.add', function(){
    var self = this;
    $(this).removeClass('add').addClass('added').attr('href', '<?=$arParams['BASKET_URL']?>');

    universe.basket.add({
        product_id: $(self).data('product-id'),
        quantity: 1,
        iblock_id: '<?=$arParams['IBLOCK_ID']?>'
        }, function(response){

        }
    );
    return false;
});

// Delete product from basket
$(document).on('click', '.buys .intec-basket-button.added', function(){
    var self = this;
    $(this).removeClass('added').addClass('add').attr('href', '<?=$arParams['BASKET_URL']?>');
    $('.intec-basket-text', self).html('<?=GetMessage('ADDED_TO_CART')?>');

    universe.basket.add({
            product_id: $(self).data('product-id'),
            quantity: 1
        }, function(response){

        }
    );
    return false;
});

// Add product to basket delay
$(document).on('click', '.min-button-block .intec-min-button-like.add', function(){
    var self = this;
    $(this).removeClass('add').addClass('added');

    universe.basket.addDelay({
            product_id: $(self).data('product-id'),
            quantity: 1
        }, function(response){

        }
    );
    return false;
});

// Delete product from basket delay
$(document).on('click', '.min-button-block .intec-min-button-like.added', function(){
    var self = this;
    $(this).removeClass('added').addClass('add');

    universe.basket.removeDelay({
            product_id: $(self).data('product-id'),
            quantity: 1
        }, function(response){

        }
    );
    return false;
});

<?if ($arParams['DISPLAY_COMPARE'] == 'Y' && !empty($arParams['COMPARE_NAME']) && !empty($arParams['IBLOCK_ID'])) {?>
    // Add product to compare
    $(document).on('click', '.min-button-block .intec-min-button-compare.add', function(){
        var self = this;
        $(this).removeClass('add').addClass('added');

        universe.basket.addCompare({
                product_id: $(self).data('product-id'),
                compare_name: '<?=$arParams['COMPARE_NAME']?>',
                iblock_id: '<?=$arParams['IBLOCK_ID']?>'
            }, function(response){

            }
        );
        return false;
    });

    // Delete product from compare
    $(document).on('click', '.min-button-block .intec-min-button-compare.added', function(){
        var self = this;
        $(this).removeClass('added').addClass('add');

        universe.basket.removeCompare({
                product_id: $(self).data('product-id'),
                compare_name: '<?=$arParams['COMPARE_NAME']?>',
                iblock_id: '<?=$arParams['IBLOCK_ID']?>'
            }, function(response){

            }
        );
        return false;
    });
<?}?>
</script>

