<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die() ?>
<?php

/**
 * @var array $arCurrentValues
 */

if (!CModule::IncludeModule('iblock'))
    return;

if (!CModule::IncludeModule('catalog'))
    return;

$arTemplateParameters = array();

$arIBlocksTypes = CIBlockParameters::GetIBlockTypes();
$sIBlockType = $arCurrentValues['IBLOCK_TYPE'];

$arIBlocks = array();
$arIBlocksFilter = array();
$arIBlocksFilter['ACTIVE'] = 'Y';

if (!empty($sIBlockType))
    $arIBlocksFilter['TYPE'] = $sIBlockType;

$rsIBlocks = CIBlock::GetList(array('SORT' => 'ASC'), $arIBlocksFilter);

while ($arIBlock = $rsIBlocks->Fetch())
    $arIBlocks[$arIBlock['ID']] = '['.$arIBlock['ID'].'] '.$arIBlock['NAME'];

$iIBlockId = (int)$arCurrentValues['IBLOCK_ID'];

$arTemplateParameters['IBLOCK_TYPE'] = array(
    'PARENT' => 'BASE',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_IBLOCK_TYPE'),
    'VALUES' => $arIBlocksTypes,
    'ADDITIONAL_VALUES' => 'Y',
    'REFRESH' => 'Y'
);
$arTemplateParameters['IBLOCK_ID'] = array(
    'PARENT' => 'BASE',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_IBLOCK_ID'),
    'VALUES' => $arIBlocks,
    'ADDITIONAL_VALUES' => 'Y',
    'REFRESH' => 'Y'
);

$arPrices = CCatalogIBlockParameters::getPriceTypesList();

if (!empty($iIBlockId)) {
    $arProperties = array();
    $arPropertiesList = array();
    $arPropertiesBoolean = array();
    $rsProperties = CIBlockProperty::GetList(array('SORT' => 'ASC'), array(
        'IBLOCK_ID' => $iIBlockId
    ));

    while ($arProperty = $rsProperties->Fetch()) {
        if (!empty($arProperty['CODE'])) {
            $sName = '[' . $arProperty['CODE'] . '] ' . $arProperty['NAME'];

            if ($arProperty['PROPERTY_TYPE'] == 'L')
                $arPropertiesList[$arProperty['CODE']] = $sName;

            if ($arProperty['PROPERTY_TYPE'] == 'L' && $arProperty['LIST_TYPE'] == 'C' && $arProperty['MULTIPLE'] == 'N')
                $arPropertiesBoolean[$arProperty['CODE']] = $sName;
        }

        $arProperties[$arProperty['CODE']] = $arProperty;
    }

    $arTemplateParameters['PROPERTY_LABEL_NEW'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_PROPERTY_LABEL_NEW'),
        'VALUES' => $arPropertiesBoolean,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters['PROPERTY_LABEL_RECOMMEND'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_PROPERTY_LABEL_RECOMMEND'),
        'VALUES' => $arPropertiesBoolean,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters['PROPERTY_LABEL_HIT'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_PROPERTY_LABEL_HIT'),
        'VALUES' => $arPropertiesBoolean,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters['DISPLAY_DISCOUNT'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'CHECKBOX',
        'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_DISPLAY_DISCOUNT')
    );

    $arTemplateParameters['PROPERTY_SECTION'] = array(
        'PARENT' => 'DATA_SOURCE',
        'TYPE' => 'LIST',
        'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_PROPERTY_SECTION'),
        'VALUES' => $arPropertiesList,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arOffers = CCatalogSku::GetInfoByProductIBlock($iIBlockId);
    $arOffersProperties = array();

    if (!empty($arOffers)) {
        $rsOffersProperties = Bitrix\Iblock\PropertyTable::getList(array(
            'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'),
            'filter' => array('=IBLOCK_ID' => $arOffers['IBLOCK_ID'], '=ACTIVE' => 'Y', '!=ID' => $arOffers['SKU_PROPERTY_ID']),
            'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
        ));

        while ($arOfferProperty = $rsOffersProperties->Fetch()) {
            $sCode = $arOfferProperty['CODE'];

            if (empty($sCode))
                $sCode = $arOfferProperty['ID'];

            $sName = '['.$sCode.'] '.$arOfferProperty['NAME'];
            $arOffersProperties[$sCode] = $sName;
        }
    }

    $arTemplateParameters['OFFERS_PROPERTY_CODE'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_OFFERS_PROPERTY_CODE'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'VALUES' => $arOffersProperties,
        'ADDITIONAL_VALUES' => 'Y',
    );
}

$arTemplateParameters['ITEMS_LIMIT'] = array(
    'PARENT' => 'BASE',
    'TYPE' => 'STRING',
    'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_ITEMS_LIMIT'),
    'DEFAULT' => 20
);

$arTemplateParameters['PRICE_CODE'] = array(
    "PARENT" => "BASE",
    "NAME" => GetMessage("C_W_CATALOG_CATEGORIES_PARAMETERS_PRICE_CODE"),
    "TYPE" => "LIST",
    "MULTIPLE" => "Y",
    "VALUES" => $arPrices,
);

$arTemplateParameters['SECTION_URL'] = CIBlockParameters::GetPathTemplateParam(
    'SECTION',
    'SECTION_URL',
    GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_SECTION_URL'),
    '',
    'URL_TEMPLATES'
);

$arTemplateParameters['DETAIL_URL'] = CIBlockParameters::GetPathTemplateParam(
    'DETAIL',
    'DETAIL_URL',
    GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_DETAIL_URL'),
    '',
    'URL_TEMPLATES'
);

$arTemplateParameters['BASKET_URL'] = array(
    "PARENT" => 'URL_TEMPLATES',
    "NAME" => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_BASKET_URL'),
    "TYPE" => 'STRING',
    "DEFAULT" => '/personal/basket.php',
);

$arTemplateParameters['VIEW_DESKTOP'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_VIEW_DESKTOP'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        'default.desktop' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_VIEW_DESKTOP_DEFAULT')
    )
);

$arTemplateParameters['VIEW_MOBILE'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_VIEW_MOBILE'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        'default.mobile' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_VIEW_MOBILE_DEFAULT'),
        'deployed.mobile' => GetMessage('C_W_CATALOG_CATEGORIES_PARAMETERS_VIEW_MOBILE_DEPLOYED')
    )
);

$arTemplateParameters["DISPLAY_TITLE"] = array(
    "PARENT" => "VISUAL",
    "NAME" => GetMessage("C_W_CATALOG_CATEGORIES_PARAMETERS_SHOW_TITLE"),
    "TYPE" => "CHECKBOX",
    "REFRESH" => "Y"
);
if($arCurrentValues["DISPLAY_TITLE"] == "Y") {
    $arTemplateParameters["TITLE_ALIGN"] = array(
        "PARENT" => "VISUAL",
        "NAME" => GetMessage("C_W_CATALOG_CATEGORIES_PARAMETERS_TITLE_ALIGN"),
        "TYPE" => "CHECKBOX",
        'DEFAULT' => 'N'
    );
    $arTemplateParameters["TITLE"] = array(
        "PARENT" => "VISUAL",
        "NAME" => GetMessage("C_W_CATALOG_CATEGORIES_PARAMETERS_TITLE"),
        "TYPE" => "TEXT"
    );
}
$arTemplateParameters["SHOW_DESCRIPTION"] = array(
    "PARENT" => "VISUAL",
    "NAME" => GetMessage("C_W_CATALOG_CATEGORIES_PARAMETERS_SHOW_DESCRIPTION"),
    "TYPE" => "CHECKBOX",
    "REFRESH" => "Y"
);
if($arCurrentValues["SHOW_DESCRIPTION"] == "Y") {
    $arTemplateParameters["DESCRIPTION_ALIGN"] = array(
        "PARENT" => "VISUAL",
        "NAME" => GetMessage("C_W_CATALOG_CATEGORIES_PARAMETERS_DESCRIPTION_ALIGN"),
        "TYPE" => "CHECKBOX",
        'DEFAULT' => 'N'
    );
    $arTemplateParameters["DESCRIPTION"] = array(
        "PARENT" => "VISUAL",
        "NAME" => GetMessage("C_W_CATALOG_CATEGORIES_PARAMETERS_DESCRIPTION"),
        "TYPE" => "STRING"
    );
}
$arTemplateParameters["COUNT_ELEMENT_IN_ROW"] = array(
    "PARENT" => "VISUAL",
    "NAME"=>GetMessage("C_W_CATALOG_CATEGORIES_COUNT_IN_ROW"),
    "TYPE" => "LIST",
    "VALUES" => array(
        "three" => 3,
        "four" => 4,
        "five" => 5
    )
);
