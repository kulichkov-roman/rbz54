<?
$arData = $arResult['DATA'];
$sCurrentElement = null;
use intec\core\helpers\JavaScript;

$arFormParameters = [
    'id' => $arParams['SERVICES_FORM_ID'],
    'template' => 'popup',
    'parameters' => [
        'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'_FORM_ORDER'
    ],
    'settings' => [
        'title' => GetMessage("SERVICE_HEADER_ORDER_BUTTON")
    ],
    'fields' => []
];

if (!empty($arParams['PROPERTY_FORM_ORDER_SERVICE']))
    $arFormParameters['fields'][$arParams['PROPERTY_FORM_ORDER_SERVICE']] = $arResult['NAME'];

?>
<?if($arParams["TYPE_BANNER_WIDE"] != "Y"){?>
    <div class="intec-content">
    <div class="intec-content-wrapper">
<?}?>
    <div class="service-header">
        <?if((int)$arParams["TYPE_BANNER"] == 1){?>
            <table width="100%" border="0" cellspadding="0" cellsspacing="0" style="width: 100%;">
                <tr>
                    <td style="width: 100%; vertical-align: top; text-align: left; font-size: 0;" class="service-header-image-wrapper">
                        <div class="service-header-image">
                            <div class="uni-image" style="height: 100%;">
                                <div class="uni-aligner-vertical"></div>
                                <div class="big-image" style = "background-image:url(<?=$arData['IMAGE']['PATH']?>)">
                                </div>
                            </div>
                        </div>
                        <div class="intec-content">
                            <div class="intec-content-wrapper">
                                <h1 class="service-header-title">
                                    <?=$arResult["NAME"]?>
                                </h1>
                                <div class="service-header-information <?=!$arData['IMAGE']['SHOW'] ? 'service-header-information-no-img':''?>">
                                    <?if ($arData['PRICE']['SHOW']):?>
                                        <div class="service-header-information-price">
												<span class="caption">
													<?=GetMessage('SERVICE_HEADER_PRICE_CAPTION')?>:
												</span>
												<span class="price">
													<?=$arData['PRICE']['FORMATTED']?>
												</span>
                                            <?if($arParams["SERVICES"] == "Y") {?>
                                                <div class="service-header-information-order">
                                                    <a class="intec-button intec-button-cl-common intec-button-md " onclick="universe.forms.show(<?= JavaScript::toObject($arFormParameters) ?>)">
                                                        <?= GetMessage("SERVICE_HEADER_ORDER_BUTTON") ?>
                                                    </a>
                                                </div>
                                            <?}?>
                                        </div>
                                    <?endif;?>

                                    <?if ($arData['PREVIEW_TEXT']['SHOW']):?>
                                        <div class="service-header-information-text">
                                            <?=$arData['PREVIEW_TEXT']['VALUE']?>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="service-header-information-adaptiv">
                            <?if ($arData['PRICE']['SHOW']):?>
                                <div class="service-header-information-price">
                                    <div class="service-header-information-price-caption">
                                        <?=GetMessage('SERVICE_HEADER_PRICE_CAPTION')?>:
                                    </div>
                                    <div class="service-header-information-price-value">
                                        <?=$arData['PRICE']['FORMATTED']?>
                                    </div>
                                </div>

                            <?endif;?>
                            <div class="service-header-information-order">
                                <a class="intec-button-md intec-button intec-button-cl-common" onclick="openOrderServicePopup('<?=SITE_DIR?>', '<?=$arResult['NAME']?>')"><?=GetMessage('SERVICE_HEADER_ORDER_BUTTON')?></a>
                            </div>
                            <?if ($arData['PREVIEW_TEXT']['SHOW']):?>
                                <div class="service-header-information-text">
                                    <?=$arData['PREVIEW_TEXT']['VALUE']?>
                                </div>
                            <?endif;?>
                        </div>
                    </td>
                </tr>
            </table>
        <?}?>
        <?if((int)$arParams["TYPE_BANNER"] > 1){?>
            <table border="0" cellspadding="0" cellsspacing="0" style="width: 100%;">
                <tr>
                    <td style="width: 100%; vertical-align: top; text-align: left; font-size: 0;" class="service-header-image-wrapper">
                        <div class="background-block <?=$arParams["TYPE_BANNER"]>2?"white":""?> <?=$arParams["TYPE_BANNER"]>3?"static":""?>">
                            <div class="intec-content">
                                <div class="intec-content-wrapper" style="position:relative;">
                                    <div class="text-block">
                                        <h1 class="service-header-title">
                                            <?=$arResult["NAME"]?>
                                        </h1>
                                        <div style="clear:both"></div>
                                        <?if($arParams["TYPE_BANNER"] < 4){?>
                                            <div class="service-header-information <?=!$arData['IMAGE']['SHOW'] ? 'service-header-information-no-img':''?>">
                                                <?if ($arData['PRICE']['SHOW']):?>
                                                    <div class="service-header-information-price">
															<span class="caption">
																<?=GetMessage('SERVICE_HEADER_PRICE_CAPTION')?>:
															</span>
															<span class="price">
																<?=$arData['PRICE']['FORMATTED']?>
															</span>
                                                        <?if($arParams["SERVICES"] == "Y") {?>
                                                            <div class="service-header-information-order">
                                                                <a class="intec-button intec-button-cl-common intec-button-md " onclick="universe.forms.show(<?= JavaScript::toObject($arFormParameters) ?>)">
                                                                    <?= GetMessage("SERVICE_HEADER_ORDER_BUTTON") ?>
                                                                </a>
                                                            </div>
                                                        <?}?>
                                                    </div>
                                                <?endif;?>
                                                <?if($arParams["TYPE_BANNER"] < 3){?>
                                                    <?if ($arData['PREVIEW_TEXT']['SHOW']):?>
                                                        <div class="service-header-information-text">
                                                            <?=$arData['PREVIEW_TEXT']['VALUE']?>
                                                        </div>
                                                    <?endif;?>
                                                <?}?>
                                            </div>
                                        <?}?>
                                    </div>
                                    <div class="service-header-image">
                                        <div class="uni-image" style="height: 100%;background-image:url(<?=$arData['IMAGE']['PATH']?>);">
                                        </div>
                                    </div>
                                    <?if ($arData['DETAIL_TEXT']['SHOW'] && $arParams["TYPE_BANNER"]>2):?>
                                        <div class="detail_description">
                                            <div class="service-header-description">
                                                <div class="service-header-description-caption">
                                                    <?=$arParams['ELEMENT_CAPTION_DESCRIPTION']?>
                                                </div>
                                                <div class="service-header-description-text">
                                                    <?=$arData['DETAIL_TEXT']['VALUE']?>
                                                </div>
                                            </div>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="service-header-information-adaptiv">
                            <?if ($arData['PRICE']['SHOW']):?>
                                <div class="service-header-information-price">
                                    <div class="service-header-information-price-caption">
                                        <?=GetMessage('SERVICE_HEADER_PRICE_CAPTION')?>:
                                    </div>
                                    <div class="service-header-information-price-value">
                                        <?=$arData['PRICE']['FORMATTED']?>
                                    </div>
                                </div>

                            <?endif;?>
                            <?if($arParams["SERVICES"] == "Y") {?>
                                <div class="service-header-information-order">
                                    <a class="intec-button intec-button-cl-common intec-button-md " onclick="universe.forms.show(<?= JavaScript::toObject($arFormParameters) ?>)">
                                        <?= GetMessage("SERVICE_HEADER_ORDER_BUTTON") ?>
                                    </a>
                                </div>
                            <?}?>
                            <?if ($arData['PREVIEW_TEXT']['SHOW']):?>
                                <div class="service-header-information-text">
                                    <?=$arData['PREVIEW_TEXT']['VALUE']?>
                                </div>
                            <?endif;?>
                        </div>
                    </td>
                </tr>
            </table>
        <?}?>
        <?
        $sCurrentElement = $arData['GALLERY']['ELEMENT'];
        $sCurrentElement = null;
        ?>
    </div>
<?if($arParams["TYPE_BANNER_WIDE"] != "Y"){?>
    </div>
    </div>
<?}?>