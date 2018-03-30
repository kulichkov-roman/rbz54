<?$properties = $arResult['DISPLAY_PROPERTIES'];?>
<div class="service-properties">
    <?if (count($properties) > 0 && is_array($properties)):?>
        <div class="service-caption"><?=GetMessage("PROPS");?></div>
        <div class="service-properties">
            <table>
                <?foreach ($properties as $property):?>
                    <tr>
                        <td>
                            <?=$property['NAME']?>
                        </td>
                        <td>
                            <?if (!is_array($property['VALUE'])) {?>
                                <div class="value">
                                    <?=$property['DISPLAY_VALUE']?>
                                </div>
                            <?} else {?>
                                <div class="value">
                                    <?=implode(', ', $property['VALUE'])?>
                                </div>
                            <?}?>
                        </td>
                    </tr>
                <?endforeach;?>
            </table>
        </div>
    <?endif;?>
</div>