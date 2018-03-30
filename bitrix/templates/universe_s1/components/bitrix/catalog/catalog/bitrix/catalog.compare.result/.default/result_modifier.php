<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arElementID = array();
foreach ($arResult["ITEMS"] as $elementKey => $arElement) {
    $arElementID[] = ($arElement['ID']==$arElement['~ID'])?$arElement['ID']:$arElement['~ID'];
    $picture = array();

    if (!empty($arElement['PREVIEW_PICTURE'])) {
        $picture = CFile::ResizeImageGet($arElement['PREVIEW_PICTURE']['ID'], array('width' => 195, 'height' => 195, BX_RESIZE_IMAGE_PROPORTIONAL_ALT));
        $strTitle = (!empty($arElement["IPROPERTY_VALUES"]['ELEMENT_PREVIEW_PICTURE_FILE_TITLE'])
            ? $arElement["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
            : $arElement['NAME']
        );
        $strAlt = (!empty($arElement["IPROPERTY_VALUES"]['ELEMENT_PREVIEW_PICTURE_FILE_ALT'])
            ? $arElement["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_ALT"]
            : $arElement['NAME']
        );
    } elseif (!empty($arElement['DETAIL_PICTURE']))  {
        $picture = CFile::ResizeImageGet($arElement['DETAIL_PICTURE']['ID'], array('width' => 195, 'height' => 195, BX_RESIZE_IMAGE_PROPORTIONAL_ALT));
        $strTitle = (!empty($arElement["IPROPERTY_VALUES"]['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
            ? $arElement["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
            : $arElement['NAME']
        );
        $strAlt = (!empty($arElement["IPROPERTY_VALUES"]['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
            ? $arElement["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
            : $arElement['NAME']
        );
    } else {
        $picture['src'] = SITE_TEMPLATE_PATH.'/images/noimg/no-img.png';
        $strTitle = $arElement['NAME'];
        $strAlt = $arElement['NAME'];
    }

    $picture['imgTitle'] = $strTitle;
    $picture['imgAlt'] = $strAlt;

    $arResult["ITEMS"][$elementKey]['PICTURE'] = $picture;
}

if (!empty($arElementID)) {
    CModule::IncludeModule('iblock');
    $db_groups = CIBlockElement::GetElementGroups($arElementID, true, array('NAME', 'SECTION_PAGE_URL'));
    $arSection = array();
    while($ar_group = $db_groups->GetNext()) {
        $arSection[$ar_group['ID']] = $ar_group;
    }

    foreach ($arResult["ITEMS"] as $elementKey => $arElement) {
        /*if ($arElement[]) {

        }*/
        $arResult["ITEMS"][$elementKey]['SECTION'] = $arSection[$arElement['IBLOCK_SECTION_ID']];
    }
}
?>