<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$isAjax = ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["ajax_action"]) && $_POST["ajax_action"] == "Y");?>
<div class="compare-result-empty"><?=GetMessage('COMPARE_RESULT_EMPTY');?></div>
<div class="bx_compare" id="bx_catalog_compare_block">
    <?//print_r($arResult);?>
    <?if ($isAjax){
        $APPLICATION->RestartBuffer();
    }?>
    <div class="bx_sort_container">
        <div class="bx_sort_container">
            <a class="compare-result-clear"><i class="fa fa-times" aria-hidden="true"></i><?=GetMessage('CATALOG_COMPARE_CLEAR')?></a>
            <div>
                <a class="sortbutton<? echo (!$arResult["DIFFERENT"] ? ' current' : ''); ?>" href="<? echo $arResult['COMPARE_URL_TEMPLATE'].'DIFFERENT=N'; ?>" rel="nofollow"><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?></a>
                <a class="sortbutton<? echo ($arResult["DIFFERENT"] ? ' current' : ''); ?>" href="<? echo $arResult['COMPARE_URL_TEMPLATE'].'DIFFERENT=Y'; ?>" rel="nofollow"><?=GetMessage("CATALOG_ONLY_DIFFERENT")?></a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="table_compare wrap_sliders tabs-body">
        <?if (!empty($arResult["SHOW_FIELDS"])){?>
            <div class="frame top">
                <div class="wraps">
                    <table class="compare_view top">
                        <tr>
                            <?foreach($arResult["ITEMS"] as $arElement){?>
                                <?
                                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM')));

                                $newprice = $arElement["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"];
                                $oldprice = $arElement["MIN_PRICE"]["PRINT_VALUE"];
                                $useDiscount = false;
                                if ($newprice < $oldprice) {
                                    $useDiscount = true;
                                }
                                ?>
                                <td class="compare-item-td">
                                    <div class="compare-item" data-product-id="<?=$arElement['ID']?>" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
                                        <i class="remove_compare fa fa-times" aria-hidden="true"></i>
                                        <a href="<?=$arElement['DETAIL_PAGE_URL']?>" class="intec-image compare-item-img">
                                            <span class="intec-aligner"></span>
                                            <img src="<?=$arElement['PICTURE']['src']?>" alt="<?=$arElement['PICTURE']['imgAlt']?>" title="<?=$arElement['PICTURE']['imgAlt']?>">
                                        </a>
                                        <a href="<?=$arElement['DETAIL_PAGE_URL']?>" class="compare-item-name"><?=$arElement['NAME']?></a>
                                        <a href="<?=$arElement['SECTION']['SECTION_PAGE_URL']?>" class="compare-item-section"><?=$arElement['SECTION']['NAME']?></a>
                                        <div class="compare-item-price">
                                            <div class="price newprice">
                                                <?=$newprice?>
                                            </div>
                                            <?if ($useDiscount) {?>
                                                <div class="price oldprice">
                                                    <?=$oldprice?>
                                                </div>
                                            <?}?>
                                        </div>
                                    </div>
                                </td>
                            <?}?>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="wrapp_scrollbar">
                <div class="wr_scrollbar">
                    <div class="scrollbar">
                        <div class="handle intec-cl-background">
                            <div class="mousearea"></div>
                        </div>
                    </div>
                </div>
                <ul class="slider_navigation compare">
                    <ul class="slider-direction-nav">
                        <li class="slider-nav-prev backward"><span class="slider-prev fa fa-angle-left"></span></li>
                        <li class="slider-nav-next forward"><span class="slider-next fa fa-angle-right"></span></li>
                    </ul>
                </ul>
            </div>
        <?}?>

            <div class="bx_filtren_container">
                <ul>
                    <?foreach( $arResult["SHOW_PROPERTIES"] as $key => $arProp ):?>
                        <li class="intec-button intec-button-s-6 intec-button-r-3 intec-button-cl-common intec-button-transparent property" data-id-prop="<?=$arProp['ID']?>">
                            + <?=$arProp['NAME']?>
                        </li>
                    <?endforeach;?>
                    <?foreach( $arResult["SHOW_OFFER_PROPERTIES"] as $key => $arProp ):?>
                        <li class="intec-button intec-button-s-6 intec-button-r-3 intec-button-cl-common intec-button-transparent property" data-id-prop="<?=$arProp['ID']?>">
                            + <?=$arProp['NAME']?>
                        </li>
                    <?endforeach;?>
                </ul>
            </div>

        <?$arUnvisible=array("NAME", "PREVIEW_PICTURE", "DETAIL_PICTURE");?>
        <div class="prop_title_table"></div>

        <div class="frame props">
            <div class="wraps">
                <table class="data_table_props compare_view">
                    <?if (!empty($arResult["SHOW_FIELDS"])){
                        foreach ($arResult["SHOW_FIELDS"] as $code => $arProp){
                            if(!in_array($code, $arUnvisible)){
                                $showRow = true;
                                if (!isset($arResult['FIELDS_REQUIRED'][$code]) || $arResult['DIFFERENT']){
                                    $arCompare = array();
                                    foreach($arResult["ITEMS"] as &$arElement){
                                        $arPropertyValue = $arElement["FIELDS"][$code];
                                        if (is_array($arPropertyValue)){
                                            sort($arPropertyValue);
                                            $arPropertyValue = implode(" / ", $arPropertyValue);
                                        }
                                        $arCompare[] = $arPropertyValue;
                                    }
                                    unset($arElement);
                                    $showRow = (count(array_unique($arCompare)) > 1);
                                }
                                if ($showRow){?>
                                    <tr>
                                        <td>
                                            <?=GetMessage("IBLOCK_FIELD_".$code);?>
                                            <i class="fa fa-times" aria-hidden="true" data-id-prop="<?=$arProperty['ID']?>"></i>
                                        </td>
                                        <?foreach($arResult["ITEMS"] as $arElement){?>
                                            <td valign="top">
                                                <?=$arElement["FIELDS"][$code];?>

                                            </td>
                                        <?}
                                        unset($arElement);?>
                                    </tr>
                                <?}?>
                            <?}?>
                        <?}
                    }
                    if (!empty($arResult["SHOW_OFFER_FIELDS"])){
                        foreach ($arResult["SHOW_OFFER_FIELDS"] as $code => $arProp){
                            $showRow = true;
                            if ($arResult['DIFFERENT']){
                                $arCompare = array();
                                foreach($arResult["ITEMS"] as &$arElement){
                                    $Value = $arElement["OFFER_FIELDS"][$code];
                                    if(is_array($Value)){
                                        sort($Value);
                                        $Value = implode(" / ", $Value);
                                    }
                                    $arCompare[] = $Value;
                                }
                                unset($arElement);
                                $showRow = (count(array_unique($arCompare)) > 1);
                            }
                            if ($showRow){?>
                                <tr>
                                    <td>
                                        <?=GetMessage("IBLOCK_OFFER_FIELD_".$code)?>
                                        <i class="fa fa-times" aria-hidden="true" data-id-prop="<?=$arProperty['ID']?>"></i>
                                    </td>
                                    <?foreach($arResult["ITEMS"] as &$arElement){?>
                                        <td>
                                            <?=(is_array($arElement["OFFER_FIELDS"][$code])? implode("/ ", $arElement["OFFER_FIELDS"][$code]): $arElement["OFFER_FIELDS"][$code])?>
                                        </td>
                                    <?}
                                    unset($arElement);
                                    ?>
                                </tr>
                            <?}
                        }
                    }?>
                    <?
                    if (!empty($arResult["SHOW_PROPERTIES"])){
                        foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty){
                            $showRow = true;
                            if ($arResult['DIFFERENT']){
                                $arCompare = array();
                                foreach($arResult["ITEMS"] as &$arElement){
                                    $arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
                                    if (is_array($arPropertyValue)){
                                        sort($arPropertyValue);
                                        $arPropertyValue = implode(" / ", $arPropertyValue);
                                    }
                                    $arCompare[] = $arPropertyValue;
                                }
                                unset($arElement);
                                $showRow = (count(array_unique($arCompare)) > 1);
                            }
                            if ($showRow){?>
                                <tr>
                                    <td>
                                        <?=$arProperty["NAME"]?>
                                        <i class="fa fa-times" aria-hidden="true" data-id-prop="<?=$arProperty['ID']?>"></i>
                                    </td>
                                    <?foreach($arResult["ITEMS"] as &$arElement){?>
                                        <td>
                                            <?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
                                        </td>
                                    <?}
                                    unset($arElement);
                                    ?>
                                </tr>
                            <?}
                        }
                    }
                    if (!empty($arResult["SHOW_OFFER_PROPERTIES"])){
                        foreach($arResult["SHOW_OFFER_PROPERTIES"] as $code=>$arProperty){
                            $showRow = true;
                            if ($arResult['DIFFERENT']){
                                $arCompare = array();
                                foreach($arResult["ITEMS"] as &$arElement){
                                    $arPropertyValue = $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["VALUE"];
                                    if(is_array($arPropertyValue)){
                                        sort($arPropertyValue);
                                        $arPropertyValue = implode(" / ", $arPropertyValue);
                                    }
                                    $arCompare[] = $arPropertyValue;
                                }
                                unset($arElement);
                                $showRow = (count(array_unique($arCompare)) > 1);
                            }
                            if ($showRow){?>
                                <tr>
                                    <td>
                                        <?=$arProperty["NAME"]?>
                                        <i class="fa fa-times" aria-hidden="true" data-id-prop="<?=$arProperty['ID']?>"></i>
                                    </td>
                                    <?foreach($arResult["ITEMS"] as &$arElement){?>
                                        <td>
                                            <?=(is_array($arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["OFFER_DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
                                        </td>
                                    <?}
                                    unset($arElement);
                                    ?>
                                </tr>
                            <?}
                        }
                    }?>
                </table>
            </div>
        </div>
        <?//}?>
    </div>

    <?if ($isAjax){
        die();
    }?>
</div>
<?include('script.php');