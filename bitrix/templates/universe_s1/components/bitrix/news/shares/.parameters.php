<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

if (!Loader::includeModule('iblock'))
    return;
$boolCatalog = Loader::includeModule('catalog');

$relationProperties = array();
$sectionProperties = array();

$iBlockProp = array();
$properties = CIBlockProperty::GetList(
    Array("sort" => "asc"),
    Array(
        "ACTIVE" => "Y",
        'IBLOCK_TYPE' => $arCurrentValues['IBLOCK_TYPE'],
        "IBLOCK_ID" => $arCurrentValues['IBLOCK_ID'],
    )
);
while ($propFields = $properties->Fetch()) {
    $iBlockProp[$propFields["CODE"]] = '[' . $propFields["CODE"] . ']' . $propFields["NAME"];
    if ($propFields['PROPERTY_TYPE'] == 'E') {
        $relationProperties[$propFields['CODE']] = '[' . $propFields["CODE"] . ']' . $propFields["NAME"];
    } else if ($propFields['PROPERTY_TYPE'] == 'G') {
        $sectionProperties[$propFields['CODE']] = '[' . $propFields["CODE"] . ']' . $propFields["NAME"];
    }
}
unset($propFields, $properties);

$arTemplateParameters['LIST_VIEW'] = array(
    'PARENT' => 'VISUAL',
    'TYPE' => 'LIST',
    'NAME' => GetMessage('T_IBLOCK_LIST_VIEW'),
    'VALUES' => array(
        'TILE' => GetMessage('C_SHARES_PARAMETERS_LIST_VIEW_TILE'),
        'LIST' => GetMessage('C_SHARES_PARAMETERS_LIST_VIEW_LIST'),
    )
);

$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"USE_SHARE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_USE_SHARE"),
		"TYPE" => "CHECKBOX",
		"MULTIPLE" => "N",
		"VALUE" => "Y",
		"DEFAULT" =>"N",
		"REFRESH"=> "Y",
	),
);

if ($arCurrentValues["USE_SHARE"] == "Y")
{
	$arTemplateParameters["SHARE_HIDE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_HIDE"),
		"TYPE" => "CHECKBOX",
		"VALUE" => "Y",
		"DEFAULT" => "N",
	);

	$arTemplateParameters["SHARE_TEMPLATE"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_TEMPLATE"),
		"DEFAULT" => "",
		"TYPE" => "STRING",
		"MULTIPLE" => "N",
		"COLS" => 25,
		"REFRESH"=> "Y",
	);

	if (strlen(trim($arCurrentValues["SHARE_TEMPLATE"])) <= 0)
		$shareComponentTemlate = false;
	else
		$shareComponentTemlate = trim($arCurrentValues["SHARE_TEMPLATE"]);

	include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/components/bitrix/main.share/util.php");

	$arHandlers = __bx_share_get_handlers($shareComponentTemlate);

        $arTemplateParameters["SHARE_HANDLERS"] = array(
            "NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SYSTEM"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => $arHandlers["HANDLERS"],
            "DEFAULT" => $arHandlers["HANDLERS_DEFAULT"],
        );

	$arTemplateParameters["SHARE_SHORTEN_URL_LOGIN"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_LOGIN"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);

	$arTemplateParameters["SHARE_SHORTEN_URL_KEY"] = array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SHARE_SHORTEN_URL_KEY"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	);
}

$arTemplateParameters["HEAD_PICTURE_TYPE"] = array(
    'PARENT' => 'DATA_SOURCE',
    "NAME" => GetMessage("HEAD_PICTURE_TYPE_TMP"),
    "TYPE" => "LIST",
    'VALUES' => array(
        'SETTINGS' => GetMessage('HEAD_PICTURE_TYPE_TMP_SETTINGS'),
        'FULL_PICTURE' => GetMessage('HEAD_PICTURE_TYPE_TMP_FULL'),
        'NOT_FULL_PICTURE' => GetMessage('HEAD_PICTURE_TYPE_TMP_NOT_FULL')
    ),
    'DEFAULT' => 'NOT_FULL_PICTURE'
);

$arTemplateParameters["PROPERTY_FOR_PERIOD"] = array(
    'PARENT' => 'DATA_SOURCE',
    "NAME" => GetMessage("PROPERTY_FOR_PERIOD"),
    "TYPE" => "LIST",
    'VALUES' => $iBlockProp,
    'ADDITIONAL_VALUES' => 'Y'
);

$arTemplateParameters["PROPERTY_FOR_SALE_PERCENT"] = array(
    'PARENT' => 'DATA_SOURCE',
    "NAME" => GetMessage("PROPERTY_FOR_SALE_PERCENT"),
    "TYPE" => "LIST",
    'VALUES' => $iBlockProp,
    'ADDITIONAL_VALUES' => 'Y'
);

$iBlockListSale = CIBlockParameters::GetIBlockTypes();
$arTemplateParameters["IBLOCK_TYPE_FOR_SALE"] = array(
    'PARENT' => 'DATA_SOURCE',
    "NAME" => GetMessage("NAME_TYPE_OF_BLOCK"),
    "TYPE" => "LIST",
    'VALUES' => $iBlockListSale,
    "REFRESH"=> "Y",
);


    $arIBlock = array();
    $rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), array('TYPE' => $arCurrentValues['IBLOCK_TYPE_FOR_SALE']));
    while ($arr = $rsIBlock->Fetch())
        $arIBlock[$arr['ID']] = $arr['NAME'];
    unset($arr, $rsIBlock, $iblockFilter);
    $arTemplateParameters["IBLOCK_TYPE_ID_SALE"] = array(
        'PARENT' => 'DATA_SOURCE',
        "NAME" => GetMessage("NAME_ID_OF_BLOCK"),
        "TYPE" => "LIST",
        'VALUES' => $arIBlock,
    );

    $arTemplateParameters['PROPERTY_BASKET_URL'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_BASKET_URL'),
        'TYPE' => 'STRING'
    );


// Property recomendations
$recomendationsList = array();
$recomendations = CIBlockProperty::GetList(array(), array(
    'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'],
    'PROPERTY_TYPE' => 'E',
    'ACTIVE' => 'Y'
));
while ($row = $recomendations->Fetch()) {
    $recomendationsList[$row['CODE']] = $row['NAME'];
}
$arTemplateParameters['PROPERTY_RECOMENDATIONS'] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => GetMessage('PROPERTY_RECOMENDATIONS'),
    'TYPE' => 'LIST',
    'VALUES' => $recomendationsList
);
unset($recomendations, $recomendationsList);


$iBlockListSale = CIBlockParameters::GetIBlockTypes();
$arTemplateParameters["TYPE_OF_BLOCK_FOR_CONDITIONS"] = array(
    'PARENT' => 'DATA_SOURCE',
    "NAME" => GetMessage("TYPE_OF_BLOCK_FOR_CONDITIONS"),
    "TYPE" => "LIST",
    'VALUES' => $iBlockListSale,
    "REFRESH"=> "Y",
);

$arIBlock = array();
$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), array('TYPE' => $arCurrentValues['TYPE_OF_BLOCK_FOR_CONDITIONS']));
while ($arr = $rsIBlock->Fetch())
    $arIBlock[$arr['ID']] = '[' . $arr["CODE"] . ']' . $arr['NAME'];
unset($arr, $rsIBlock, $iblockFilter);
$arTemplateParameters["ID_OF_BLOCK_FOR_CONDITIONS"] = array(
    'PARENT' => 'DATA_SOURCE',
    "NAME" => GetMessage("ID_OF_BLOCK_FOR_CONDITIONS"),
    "TYPE" => "LIST",
    'VALUES' => $arIBlock,
    "REFRESH" => "Y",
);

$iBlockProperty = array();
$properties = CIBlockProperty::GetList(Array("sort" => "asc"), Array("ACTIVE" => "Y", "IBLOCK_ID" => $arCurrentValues['IBLOCK_ID']));
while ($propFields = $properties->GetNext()) {
    $iBlockProperty[$propFields["CODE"]] = '[' . $propFields["CODE"] . ']' . $propFields["NAME"];
}
$arTemplateParameters["PROPERTY_OF_BLOCK_FOR_CONDITIONS"] = array(
    'PARENT' => 'DATA_SOURCE',
    "NAME" => GetMessage("PROPERTY_OF_BLOCK_FOR_CONDITIONS"),
    "TYPE" => "LIST",
    'VALUES' => $iBlockProperty,
);

$arPrices = CCatalogIBlockParameters::getPriceTypesList();
$arTemplateParameters["PROPERTY_PRICE_CODE_SALE"] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => GetMessage('PROPERTY_PRICE_CODE_SALE'),
    'TYPE' => 'LIST',
    'MULTIPLE' => 'Y',
    'VALUES' => $arPrices
);

$arTemplateParameters["PROPERTY_LIST_TEMPLATE"] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => GetMessage('PROPERTY_LIST_TEMPLATE'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        'settings' => GetMessage('PROPERTY_LIST_TEMPLATE_SETTINGS'),
        '.default' => GetMessage('PROPERTY_LIST_TEMPLATE_DEFAULT'),
        'blocks' => GetMessage('PROPERTY_LIST_TEMPLATE_BLOCKS'),
        'news.list' => GetMessage('PROPERTY_LIST_TEMPLATE_LIST')
    )
);

$arTemplateParameters["PROPERTY_DETAIL_TEMPLATE"] = array(
    'PARENT' => 'DATA_SOURCE',
    'NAME' => GetMessage('PROPERTY_DETAIL_TEMPLATE'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        '.default' => '1',
        'extended' => '2'
    ),
    'REFRESH' => 'Y'
);

if ($arCurrentValues['PROPERTY_DETAIL_TEMPLATE'] == 'extended') {

    $arTemplateParameters['PROPERTY_SHOW_FORM'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_SHOW_FORM'),
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'Y'
    );

    if ($arCurrentValues['PROPERTY_SHOW_FORM'] == 'Y') {

        if (CModule::IncludeModule('form')) {

            $webFormsList = array();
            $webForms = CForm::GetList($by = 'sort', $order = 'asc', array(), $filtered = false);
            while ($row = $webForms->Fetch()) {
                $webFormsList[$row['ID']] = '[' . $row['ID'] . '] ' . $row['NAME'];
            }

            $arTemplateParameters["PROPERTY_FORM_ID"] = array(
                'PARENT' => 'DATA_SOURCE',
                'NAME' => GetMessage('PROPERTY_FORM_ID'),
                'TYPE' => 'LIST',
                'VALUES' => $webFormsList,
                'REFRESH' => 'Y',
                'ADDITIONAL_VALUES' => 'Y'
            );
        }
    }

    $iBlockTypes = CIBlockParameters::GetIBlockTypes();

    /*ICONS SETTINGS*/
    $arTemplateParameters["PROPERTY_IBLOCK_TYPE_ICONS"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_TYPE_ICONS'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockTypes,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arIcons = array();
    $iBlockIdIcons = CIBlock::GetList(
        array('SORT' => 'ASC'),
        array('TYPE' => $arCurrentValues['PROPERTY_IBLOCK_TYPE_ICONS'])
    );
    while ($arr = $iBlockIdIcons->Fetch())
        $arIcons[$arr['ID']] = '[' . $arr["CODE"] . ']' . $arr['NAME'];
    unset($arr, $iBlockIdIcons);

    $arTemplateParameters["PROPERTY_IBLOCK_ID_ICONS"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_ID_ICONS'),
        'TYPE' => 'LIST',
        'VALUES' => $arIcons,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters['PROPERTY_FOR_ICONS'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_FOR_ICONS'),
        'TYPE' => 'LIST',
        'VALUES' => $relationProperties,
        'ADDITIONAL_VALUES' => 'Y'
    );

    /*PROMO SETTINGS*/
    $arTemplateParameters["PROPERTY_IBLOCK_TYPE_PROMO"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_TYPE_PROMO'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockTypes,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arPromo = array();
    $iBlockIdPromo = CIBlock::GetList(
        array('SORT' => 'ASC'),
        array('TYPE' => $arCurrentValues['PROPERTY_IBLOCK_TYPE_PROMO'])
    );
    while ($arr = $iBlockIdPromo->Fetch())
        $arPromo[$arr['ID']] = '[' . $arr["CODE"] . ']' . $arr['NAME'];
    unset($arr, $iBlockIdPromo);

    $arTemplateParameters["PROPERTY_IBLOCK_ID_PROMO"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_ID_PROMO'),
        'TYPE' => 'LIST',
        'VALUES' => $arPromo,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters['PROPERTY_FOR_PROMO'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_FOR_PROMO'),
        'TYPE' => 'LIST',
        'VALUES' => $relationProperties,
        'ADDITIONAL_VALUES' => 'Y'
    );

    /*TEASERS SETTINGS*/
    $arTemplateParameters["PROPERTY_IBLOCK_TYPE_TEASER"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_TYPE_TEASER'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockTypes,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTeaser = array();
    $iBlockIdTeaser = CIBlock::GetList(
        array('SORT' => 'ASC'),
        array('TYPE' => $arCurrentValues['PROPERTY_IBLOCK_TYPE_TEASER'])
    );
    while ($arr = $iBlockIdTeaser->Fetch())
        $arTeaser[$arr['ID']] = '[' . $arr["CODE"] . ']' . $arr['NAME'];
    unset($arr, $iBlockIdTeaser);

    $arTemplateParameters["PROPERTY_IBLOCK_ID_TEASER"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_ID_TEASER'),
        'TYPE' => 'LIST',
        'VALUES' => $arTeaser,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters['PROPERTY_FOR_TEASER'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_FOR_TEASER'),
        'TYPE' => 'LIST',
        'VALUES' => $relationProperties,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters['PROPERTY_TEASER_HEADER'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_TEASER_HEADER'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockProp,
        'ADDITIONAL_VALUES' => 'Y'
    );

    /*VIDEO SETTINGS*/
    $arTemplateParameters["PROPERTY_IBLOCK_TYPE_OVERVIEWS"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_TYPE_OVERVIEWS'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockTypes,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arOverviews = array();
    $iBlockIdOverviews = CIBlock::GetList(
        array('SORT' => 'ASC'),
        array('TYPE' => $arCurrentValues['PROPERTY_IBLOCK_TYPE_OVERVIEWS'])
    );
    while ($arr = $iBlockIdOverviews->Fetch())
        $arOverviews[$arr['ID']] = '[' . $arr["CODE"] . ']' . $arr['NAME'];
    unset($arr, $iBlockIdOverviews);

    $arTemplateParameters["PROPERTY_IBLOCK_ID_OVERVIEWS"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_ID_OVERVIEWS'),
        'TYPE' => 'LIST',
        'VALUES' => $arOverviews,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters['PROPERTY_FOR_OVERVIEWS'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_FOR_OVERVIEWS'),
        'TYPE' => 'LIST',
        'VALUES' => $relationProperties,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $videoProperty = array();
    $properties = CIBlockProperty::GetList(
        Array("sort" => "asc"),
        Array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $arCurrentValues['PROPERTY_IBLOCK_ID_OVERVIEWS']
        )
    );
    while ($propFields = $properties->GetNext()) {
        $videoProperty[$propFields["CODE"]] = '[' . $propFields["CODE"] . ']' . $propFields["NAME"];
    }
    unset($propFields, $properties);

    $arTemplateParameters['PROPERTY_OVERVIEWS_LINK'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_OVERVIEWS_LINK'),
        'TYPE' => 'LIST',
        'VALUES' => $videoProperty,
        'ADDITIONAL_VALUES' => 'Y'
    );

    /*PHOTO SETTINGS*/
    $arTemplateParameters["PROPERTY_IBLOCK_TYPE_PHOTO"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_TYPE_PHOTO'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockTypes,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arPhoto = array();
    $iBlockIdPhoto = CIBlock::GetList(
        array('SORT' => 'ASC'),
        array('TYPE' => $arCurrentValues['PROPERTY_IBLOCK_TYPE_PHOTO'])
    );
    while ($arr = $iBlockIdPhoto->Fetch())
        $arPhoto[$arr['ID']] = '[' . $arr["CODE"] . ']' . $arr['NAME'];
    unset($arr, $iBlockIdPhoto);

    $arTemplateParameters["PROPERTY_IBLOCK_ID_PHOTO"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_ID_PHOTO'),
        'TYPE' => 'LIST',
        'VALUES' => $arPhoto,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters['PROPERTY_FOR_PHOTO'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_FOR_PHOTO'),
        'TYPE' => 'LIST',
        'VALUES' => $relationProperties,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $photoProperty = array();
    $properties = CIBlockProperty::GetList(
        Array("sort" => "asc"),
        Array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $arCurrentValues['PROPERTY_IBLOCK_ID_PHOTO']
        )
    );
    while ($propFields = $properties->GetNext()) {
        $photoProperty[$propFields["CODE"]] = '[' . $propFields["CODE"] . ']' . $propFields["NAME"];
    }
    unset($propFields, $properties);

    $arTemplateParameters['PROPERTY_PHOTO_PROPERTIES'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_PHOTO_PROPERTIES'),
        'TYPE' => 'LIST',
        'MULTIPLE' => 'Y',
        'VALUES' => $photoProperty,
        'ADDITIONAL_VALUES' => 'Y'
    );

    /*SECTIONS PROPERTIES*/
    $arTemplateParameters["PROPERTY_IBLOCK_TYPE_SECTION"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_TYPE_SECTION'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockTypes,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arSection = array();
    $iBlockIdSection = CIBlock::GetList(
        array('SORT' => 'ASC'),
        array('TYPE' => $arCurrentValues['PROPERTY_IBLOCK_TYPE_SECTION'])
    );
    while ($arr = $iBlockIdSection->Fetch())
        $arSection[$arr['ID']] = '[' . $arr["CODE"] . ']' . $arr['NAME'];
    unset($arr, $iBlockIdSection);

    $arTemplateParameters["PROPERTY_IBLOCK_ID_SECTION"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_ID_SECTION'),
        'TYPE' => 'LIST',
        'VALUES' => $arSection,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters["PROPERTY_FOR_SECTION"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_FOR_SECTION'),
        'TYPE' => 'LIST',
        'VALUES' => $sectionProperties,
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters["PROPERTY_SECTION_HEADER"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_SECTION_HEADER'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockProp,
        'ADDITIONAL_VALUES' => 'Y'
    );

    /*SERVICES SETTINGS*/
    $arTemplateParameters["PROPERTY_IBLOCK_TYPE_SERVICES"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_TYPE_SERVICES'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockTypes,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arServices = array();
    $iBlockIdServices = CIBlock::GetList(
        array('SORT' => 'ASC'),
        array('TYPE' => $arCurrentValues['PROPERTY_IBLOCK_TYPE_SERVICES'])
    );
    while ($arr = $iBlockIdServices->Fetch())
        $arServices[$arr['ID']] = '[' . $arr["CODE"] . ']' . $arr['NAME'];
    unset($arr, $iBlockIdServices);

    $arTemplateParameters["PROPERTY_IBLOCK_ID_SERVICES"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IBLOCK_ID_SERVICES'),
        'TYPE' => 'LIST',
        'VALUES' => $arServices,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );

    $arTemplateParameters["PROPERTY_FOR_SERVICES"] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_FOR_SERVICES'),
        'TYPE' => 'LIST',
        'VALUES' => $relationProperties,
        'ADDITIONAL_VALUES' => 'Y'
    );
}