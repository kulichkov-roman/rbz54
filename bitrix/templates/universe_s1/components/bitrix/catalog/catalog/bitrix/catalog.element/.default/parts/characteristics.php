<?php
/**
 * @var $APPLICATION
 * @var array $arResult
 * @var array $arParams
 * @var array $characteristics
 * @var array $hasTab
 * @var array $activeTab
 * @var array $component
 */

if ($hasTab['characteristics']) {
    $tempCharacteristics = $characteristics;
    $firstCharacteristics = array_splice($tempCharacteristics, 0, 6);
    ?>
    <div class="properties-list-wrapper">
        <ul class="properties-list">
            <?php foreach ($firstCharacteristics as $key => $property) { ?>
                <li class="col-xs-12 col-md-6">
                    <span><?= $property['NAME'] ?> - <?= $property['VALUE'] ?>;</span>
                </li>
            <?php } ?>
        </ul>
        <div class="show-all-characteristics"
             onclick="
                 $(document).scrollTo('#anchor-characteristics', 500);
                 $('[href=\'#tab-characteristics\']').tab('show');">
            <?= GetMessage('ALL_CHARACTERISTICS') ?>
        </div>
    </div>
    <?php
    unset($tempCharacteristics, $firstCharacteristics);
}
?>