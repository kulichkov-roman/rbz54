<?php
/**
 * @var $APPLICATION
 * @var array $arResult
 * @var array $arParams
 * @var array $component
 * @var array $currentOffer
 */

if (!empty($arResult['SKU_PROPS']))
{
?>
<div class="sku-container">
    <?php foreach ($arResult['SKU_PROPS'] as $key => $property) {
        $currentValue = null; // for selecting currently active values

        if ($property['SHOW_MODE'] != 'PICT') {
            $propertyStyle = 'text';
        } else {
            $propertyStyle = strtolower($arParams['OFFERS_PROPERTIES_MODE']);
        }

        if ($property['VALUES_COUNT'] <= 0)
            continue;

        if (!empty($currentOffer['PROPERTIES'][$key]))
            $currentValue = $currentOffer['PROPERTIES'][$key];
        ?>
        <div class="sku-property sku-type-<?= $propertyStyle ?>"
             data-property-code="<?= $key ?>">
            <div class="sku-property-name"><?= $property['NAME'] ?></div>
            <ul class="sku-property-values">
                <?php foreach ($property['VALUES'] as $value) {
                    if ($value['NAME'] == '-') // TODO fix this shit
                        continue;

                    $active = false;
                    switch ($currentValue['PROPERTY_TYPE']) { // burn in hell bitrix developers
                        case 'L':
                            if ($value['ID'] == $currentValue['VALUE_ENUM_ID'])
                                $active = true;
                            break;
                        case 'S':
                            if ($value['XML_ID'] == $currentValue['VALUE'])
                                $active = true;
                            break;
                    }
                    ?>
                    <li class="sku-property-value intec-no-select <?= $active ? 'active' : '' ?>"
                        <?= $propertyStyle == 'color' ? 'title="'. $value['NAME'] .'"' : '' ?>
                        data-property-value="<?= !empty($value['XML_ID']) ? $value['XML_ID'] : $value['ID'] ?>">
                        <span class="sku-property-value-name"><?= $value['NAME'] ?></span>
                        <span class="sku-property-value-image"
                              style="<? if (!empty($value['PICT']['SRC'])) { ?>
                                  background-image: url('<?= $value['PICT']['SRC'] ?>');
                              <? } ?>"></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
</div>
<?
}