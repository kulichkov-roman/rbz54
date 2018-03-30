<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

if (!Loader::includeModule('iblock') || !Loader::includeModule('sale'))
	return;

$boolCatalog = Loader::includeModule('catalog');

$arSKU = false;
$boolSKU = false;
if ($boolCatalog && (isset($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID']) > 0)
{
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	$boolSKU = !empty($arSKU) && is_array($arSKU);

    $dbPriceType = CCatalogGroup::GetList();
    $arPrice = array();
    while ($arPriceType = $dbPriceType->Fetch())
    {
        $arPrice[$arPriceType["ID"]] = '['.$arPriceType["ID"].']'.'['.$arPriceType['NAME'].'] '.$arPriceType['NAME_LANG'];

    }
}

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arMenu = GetMenuTypes($site);

$arTemplateParameters = array(
    "ROOT_MENU_TYPE" => array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => GetMessage('ROOT_MENU_TYPE'),
        "TYPE" => "LIST",
        "DEFAULT"=>'left',
        "VALUES" => $arMenu,
        "ADDITIONAL_VALUES"	=> "Y",
        "COLS" => 45
    ),
    "MAX_LEVEL_MENU" => array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => GetMessage('MAX_LEVEL'),
        "TYPE" => "LIST",
        "DEFAULT"=>'1',
        "VALUES" => Array(
            1 => "1",
            2 => "2",
            3 => "3",
            4 => "4",
        ),
        "ADDITIONAL_VALUES"	=> "N",
    ),
    "CHILD_MENU_TYPE" => array(
        "PARENT" => "DATA_SOURCE",
        "NAME" => GetMessage('CHILD_MENU_TYPE'),
        "TYPE" => "LIST",
        "DEFAULT"=>'left',
        "VALUES" => $arMenu,
        "ADDITIONAL_VALUES"	=> "Y",
        "COLS" => 45
    ),
    "SHOW_HEADER_SUBMENU" => array(
        "PARENT" => 'VISUAL',
        "NAME" => GetMessage('SHOW_HEADER_SUBMENU'),
        "TYPE" => 'CHECKBOX',
        "DEFAULT" => 'N'
    ),
    "SECTIONS_VIEW_MODE" => array(
        "PARENT" => "SECTIONS_SETTINGS",
        "NAME" => GetMessage('SECTIONS_VIEW_MODE'),
        'TYPE' => 'LIST',
        'REFRESH' => 'Y',
        "VALUES" => array(
            'settings' => GetMessage('SECTIONS_VIEW_MODE_SETTINGS'),
            'list' => GetMessage('SECTIONS_VIEW_MODE_LINE'),
            'tile' => GetMessage('SECTIONS_VIEW_MODE_TILE'),
            'tile2' => GetMessage('SECTIONS_VIEW_MODE_TILE2'),
            'text' => GetMessage('SECTIONS_VIEW_MODE_TEXT')
        ),
        "DEFAULT" => "tile"
    ),
    "SUBSECTIONS_VIEW_MODE" => array(
        "PARENT" => "SECTIONS_SETTINGS",
        "NAME" => GetMessage('SUBSECTIONS_VIEW_MODE'),
        'TYPE' => 'LIST',
        'REFRESH' => 'Y',
        "VALUES" => array(
            'settings' => GetMessage('SECTIONS_VIEW_MODE_SETTINGS'),
            'list' => GetMessage('SECTIONS_VIEW_MODE_LINE'),
            'tile' => GetMessage('SECTIONS_VIEW_MODE_TILE'),
            'tile2' => GetMessage('SECTIONS_VIEW_MODE_TILE2'),
            'text' => GetMessage('SECTIONS_VIEW_MODE_TEXT')
        ),
        "DEFAULT" => "tile"
    ),
    "DISPLAY_IBLOCK_DESCRIPTION" => array(
        "PARENT" => "SECTIONS_SETTINGS",
        "NAME" => GetMessage('DISPLAY_IBLOCK_DESCRIPTION'),
        'TYPE' => 'CHECKBOX',
        "DEFAULT" => 'Y'
    ),
    "GRID_CATALOG_ROOT_SECTIONS_COUNT" => array(
        "PARENT" => "SECTIONS_SETTINGS",
        "NAME" => GetMessage('GRID_CATALOG_ROOT_SECTIONS_COUNT'),
        "TYPE" => "STRING",
        "ADDITIONAL_VALUES" => "Y",
        "DEFAULT" => "5"
    ),
    "GRID_CATALOG_SECTIONS_COUNT" => array(
        "PARENT" => "SECTIONS_SETTINGS",
        "NAME" => GetMessage('GRID_CATALOG_SECTIONS_COUNT'),
        "TYPE" => "STRING",
        "ADDITIONAL_VALUES" => "Y",
        "DEFAULT" => "4"
    ),
    "USE_SUBSECTIONS_SECTIONS" => array(
        "PARENT" => "SECTIONS_SETTINGS",
        "NAME" => GetMessage('USE_SUBSECTIONS_SECTIONS'),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N",
        'REFRESH' => 'Y'
    ),
    "SECTION_SORT_PRICE_CODE" => array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("SECTION_SORT_PRICE_CODE"),
        "TYPE" => "LIST",
        "VALUES" => $arPrice,
    ),
	"PRODUCTS_VIEW_MODE" => array(
		"PARENT" => "LIST_SETTINGS",
		"NAME" => GetMessage('PRODUCTS_VIEW_MODE'),
		'TYPE' => 'LIST',
		'REFRESH' => 'Y',
		"VALUES" => array(
			'settings' => GetMessage('SECTIONS_VIEW_MODE_SETTINGS'),
			'list' => GetMessage('SECTIONS_VIEW_MODE_LINE'),
			'tile' => GetMessage('SECTIONS_VIEW_MODE_TILE'),
			'text' => GetMessage('SECTIONS_VIEW_MODE_TEXT')
		),
		"DEFAULT" => "tile"
	),
    "USE_COUNT_PRODUCT" => array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => GetMessage("USE_COUNT_PRODUCT"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => 'N',
    ),

);

if (isset($arCurrentValues['SECTIONS_VIEW_MODE']) && (in_array($arCurrentValues['SECTIONS_VIEW_MODE'], array('list', 'tile'))) ) {
    $arTemplateParameters['SECTIONS_DISPLAY_DESCRIPTION'] = array(
        "PARENT" => "SECTIONS_SETTINGS",
        "NAME" => GetMessage('SECTIONS_DISPLAY_DESCRIPTION'),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
    );
}

if (isset($arCurrentValues['USE_SUBSECTIONS_SECTIONS']) && $arCurrentValues['USE_SUBSECTIONS_SECTIONS'] == 'Y') {
    $arTemplateParameters['COUNT_SUBSECTIONS_SECTIONS'] = array(
            "PARENT" => "SECTIONS_SETTINGS",
            "NAME" => GetMessage('COUNT_SUBSECTIONS_SECTIONS'),
            "TYPE" => "STRING",
            "DEFAULT" => "4"
    );
}

$arTemplateParameters["FILTER_VIEW_MODE"] = array(
	"PARENT" => "FILTER_SETTINGS",
	"NAME" => GetMessage('CPT_BC_FILTER_VIEW_MODE'),
	"TYPE" => "LIST",
	"VALUES" => array(
		"VERTICAL" => GetMessage("CPT_BC_FILTER_VIEW_MODE_VERTICAL"),
		"HORIZONTAL" => GetMessage("CPT_BC_FILTER_VIEW_MODE_HORIZONTAL")
	),
	"DEFAULT" => "VERTICAL",
	"HIDDEN" => (!isset($arCurrentValues['USE_FILTER']) || 'N' == $arCurrentValues['USE_FILTER'])
);

$arTemplateParameters["INSTANT_RELOAD"] = array(
	"PARENT" => "FILTER_SETTINGS",
	"NAME" => GetMessage("CPT_BC_INSTANT_RELOAD"),
	"TYPE" => "CHECKBOX",
	"DEFAULT" => "N",
);

if (isset($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0)
{
	$arAllPropList = array();
	$arFilePropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$arListPropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$arHighloadPropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$rsProps = CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'ID' => 'ASC'),
		array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
		if ('' == $arProp['CODE'])
			$arProp['CODE'] = $arProp['ID'];
		$arAllPropList[$arProp['CODE']] = $strPropName;
		switch ($arProp['PROPERTY_TYPE']) {
			case 'F':
				$arFilePropList[$arProp['CODE']] = $strPropName;
				break;
			case 'L':
				$arListPropList[$arProp['CODE']] = $strPropName;
				break;
			case 'S':
				if ($arProp['USER_TYPE'] == 'directory' && CIBlockPriceTools::checkPropDirectory($arProp))
					$arHighloadPropList[$arProp['CODE']] = $strPropName;
				break;
		}
	}

	$arTemplateParameters['ADD_PICT_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_ADD_PICT_PROP'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'ADDITIONAL_VALUES' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '-',
		'VALUES' => $arFilePropList
	);
	$arTemplateParameters['LABEL_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_LABEL_PROP'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'ADDITIONAL_VALUES' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '-',
		'VALUES' => $arListPropList
	);

	if ($boolSKU)
	{
		$arTemplateParameters['PRODUCT_DISPLAY_MODE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_PRODUCT_DISPLAY_MODE'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'Y',
			'DEFAULT' => 'N',
			'VALUES' => array(
				'N' => GetMessage('CP_BC_TPL_DML_SIMPLE'),
				'Y' => GetMessage('CP_BC_TPL_DML_EXT')
			)
		);
		$arAllOfferPropList = array();
		$arFileOfferPropList = array(
			'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
		);
		$arTreeOfferPropList = array(
			'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
		);
		$rsProps = CIBlockProperty::GetList(
			array('SORT' => 'ASC', 'ID' => 'ASC'),
			array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
		);
		while ($arProp = $rsProps->Fetch())
		{
			if ($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
				continue;
			$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
			$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
			if ('' == $arProp['CODE'])
				$arProp['CODE'] = $arProp['ID'];
			$arAllOfferPropList[$arProp['CODE']] = $strPropName;
			if ('F' == $arProp['PROPERTY_TYPE'])
				$arFileOfferPropList[$arProp['CODE']] = $strPropName;
			if ('N' != $arProp['MULTIPLE'])
				continue;
			if (
				'L' == $arProp['PROPERTY_TYPE']
				|| 'E' == $arProp['PROPERTY_TYPE']
				|| ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
			)
				$arTreeOfferPropList[$arProp['CODE']] = $strPropName;
		}
		$arTemplateParameters['OFFER_ADD_PICT_PROP'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_OFFER_ADD_PICT_PROP'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arFileOfferPropList
		);
		$arTemplateParameters['OFFER_TREE_PROPS'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_OFFER_TREE_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arTreeOfferPropList
		);
	}

    $arFields = array();
    $rsFields = CUserTypeEntity::GetList(array('SORT' => 'ASC'), array(
        'ENTITY_ID' => 'IBLOCK_'.$arCurrentValues['IBLOCK_ID'].'_SECTION',
        'USER_TYPE_ID' => 'file'
    ));

    while ($arField = $rsFields->Fetch())
        $arFields[$arField['FIELD_NAME']] = $arField['FIELD_NAME'];

    $arTemplateParameters['PROPERTY_IMAGE'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IMAGE'),
        'TYPE' => 'LIST',
        'VALUES' => $arFields,
        'REFRESH' => 'Y',
        'ADDITIONAL_VALUES' => 'Y'
    );
    $arTemplateParameters['TYPE_SUBMENU'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => GetMessage('TYPE_SUBMENU'),
        'TYPE' => 'LIST',
        'VALUES' => array(
            'settings' => GetMessage('TYPE_SUBMENU_SETTINGS'),
            'default' => GetMessage('TYPE_SUBMENU_DEFAULT'),
            'picture' => GetMessage('TYPE_SUBMENU_PICTURE'),
            'picture_with_submenu' => GetMessage('TYPE_SUBMENU_PICTURE_WITH_SUBMENU')
        ),
        'DEFAULT' => 'default'
    );
}

$arTemplateParameters['LIST_DISPLAY_PREVIEW'] = array(
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => GetMessage('LIST_DISPLAY_PREVIEW'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y'
);

$arTemplateParameters['LIST_DISPLAY_PROPERTIES'] = array(
    'PARENT' => 'LIST_SETTINGS',
    'NAME' => GetMessage('LIST_DISPLAY_PROPERTIES'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'Y'
);

$arTemplateParameters['DETAIL_DISPLAY_NAME'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_NAME'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y'
);

// Popup for main image
$arTemplateParameters['DETAIL_PICTURE_POPUP'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('DETAIL_PICTURE_POPUP'),
	'TYPE' => 'LIST',
	'VALUES' => array(
		'SETTINGS' => GetMessage('DETAIL_PICTURE_POPUP_SETTINGS'),
		'Y' => GetMessage('DETAIL_PICTURE_POPUP_Y'),
		'N' => GetMessage('DETAIL_PICTURE_POPUP_N')
	)
);

// Loop for main image
$arTemplateParameters['DETAIL_PICTURE_LOOP'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('DETAIL_PICTURE_LOOP'),
	'TYPE' => 'LIST',
	'VALUES' => array(
		'SETTINGS' => GetMessage('DETAIL_PICTURE_LOOP_SETTINGS'),
		'Y' => GetMessage('DETAIL_PICTURE_LOOP_Y'),
		'N' => GetMessage('DETAIL_PICTURE_LOOP_N')
	)
);

$arTemplateParameters['DETAIL_ADD_DETAIL_TO_SLIDER'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_ADD_DETAIL_TO_SLIDER'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N'
);

$arTemplateParameters['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE'),
	'TYPE' => 'LIST',
	'VALUES' => array(
		'H' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE_HIDE'),
		'E' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE_EMPTY_DETAIL'),
		'S' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE_SHOW')
	),
	'DEFAULT' => 'E'
);

if ($boolCatalog)
{
	$arTemplateParameters['USE_COMMON_SETTINGS_BASKET_POPUP'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_USE_COMMON_SETTINGS_BASKET_POPUP'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);
	$useCommonSettingsBasketPopup = (
		isset($arCurrentValues['USE_COMMON_SETTINGS_BASKET_POPUP'])
		&& $arCurrentValues['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y'
	);
	$addToBasketActions = array(
		'BUY' => GetMessage('ADD_TO_BASKET_ACTION_BUY'),
		'ADD' => GetMessage('ADD_TO_BASKET_ACTION_ADD')
	);
	$arTemplateParameters['COMMON_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_COMMON_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N',
		'HIDDEN' => ($useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	$arTemplateParameters['COMMON_SHOW_CLOSE_POPUP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_COMMON_SHOW_CLOSE_POPUP'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	$arTemplateParameters['TOP_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_TOP_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N',
		'HIDDEN' => (!$useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	$arTemplateParameters['SECTION_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_SECTION_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'ADD',
		'REFRESH' => 'N',
		'HIDDEN' => (!$useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	$arTemplateParameters['DETAIL_ADD_TO_BASKET_ACTION'] = array(
		'PARENT' => 'BASKET',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_ADD_TO_BASKET_ACTION'),
		'TYPE' => 'LIST',
		'VALUES' => $addToBasketActions,
		'DEFAULT' => 'BUY',
		'REFRESH' => 'N',
		'MULTIPLE' => 'Y',
		'HIDDEN' => (!$useCommonSettingsBasketPopup ? 'N' : 'Y')
	);
	/*	$arTemplateParameters['PRODUCT_SUBSCRIPTION'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_PRODUCT_SUBSCRIPTION'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
		); */
	$arTemplateParameters['SHOW_DISCOUNT_PERCENT'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_SHOW_DISCOUNT_PERCENT'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y',
	);
	$arTemplateParameters['SHOW_OLD_PRICE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_SHOW_OLD_PRICE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	$arTemplateParameters['DETAIL_SHOW_MAX_QUANTITY'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_SHOW_MAX_QUANTITY'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	if (isset($arCurrentValues['USE_PRODUCT_QUANTITY']) && $arCurrentValues['USE_PRODUCT_QUANTITY'] === 'Y')
	{
		$arTemplateParameters['DETAIL_SHOW_BASIS_PRICE'] = array(
			"PARENT" => "BASKET",
			"NAME" => GetMessage("CP_BC_TPL_DETAIL_SHOW_BASIS_PRICE"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"REFRESH" => "N",
		);
	}
}

$arTemplateParameters['MESS_BTN_BUY'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_BUY'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_BUY_DEFAULT')
);
$arTemplateParameters['MESS_BTN_ADD_TO_BASKET'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_ADD_TO_BASKET'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_ADD_TO_BASKET_DEFAULT')
);
$arTemplateParameters['MESS_BTN_COMPARE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_COMPARE'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_COMPARE_DEFAULT')
);
$arTemplateParameters['MESS_BTN_DETAIL'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_DETAIL'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_DETAIL_DEFAULT')
);
$arTemplateParameters['MESS_NOT_AVAILABLE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_MESS_NOT_AVAILABLE'),
	'TYPE' => 'STRING',
	'DEFAULT' => GetMessage('CP_BC_TPL_MESS_NOT_AVAILABLE_DEFAULT')
);
$arTemplateParameters['DETAIL_USE_VOTE_RATING'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_USE_VOTE_RATING'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y'
);
if (isset($arCurrentValues['DETAIL_USE_VOTE_RATING']) && 'Y' == $arCurrentValues['DETAIL_USE_VOTE_RATING'])
{
	$arTemplateParameters['DETAIL_VOTE_DISPLAY_AS_RATING'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_VOTE_DISPLAY_AS_RATING'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'rating' => GetMessage('CP_BC_TPL_DVDAR_RATING'),
			'vote_avg' => GetMessage('CP_BC_TPL_DVDAR_AVERAGE'),
		),
		'DEFAULT' => 'rating'
	);
}

$arTemplateParameters['DETAIL_USE_COMMENTS'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_USE_COMMENTS'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y'
);
if (isset($arCurrentValues['DETAIL_USE_COMMENTS']) && 'Y' == $arCurrentValues['DETAIL_USE_COMMENTS'])
{
	if (ModuleManager::isModuleInstalled("blog"))
	{
		$arTemplateParameters['DETAIL_BLOG_USE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_DETAIL_BLOG_USE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
			'REFRESH' => 'Y'
		);
		if (isset($arCurrentValues['DETAIL_BLOG_USE']) && $arCurrentValues['DETAIL_BLOG_USE'] == 'Y')
		{
			$arTemplateParameters['DETAIL_BLOG_URL'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCE_DETAIL_TPL_BLOG_URL'),
				'TYPE' => 'STRING',
				'DEFAULT' => 'catalog_comments'
			);
			$arTemplateParameters['DETAIL_BLOG_EMAIL_NOTIFY'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BCE_TPL_DETAIL_BLOG_EMAIL_NOTIFY'),
				'TYPE' => 'CHECKBOX',
				'DEFAULT' => 'N'
			);
		}
	}

	$boolRus = false;
	$langBy = "id";
	$langOrder = "asc";
	$rsLangs = CLanguage::GetList($langBy, $langOrder, array('ID' => 'ru',"ACTIVE" => "Y"));
	if ($arLang = $rsLangs->Fetch())
	{
		$boolRus = true;
	}

	if ($boolRus)
	{
		$arTemplateParameters['DETAIL_VK_USE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_DETAIL_VK_USE'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'N',
			'REFRESH' => 'Y'
		);

		if (isset($arCurrentValues['DETAIL_VK_USE']) && 'Y' == $arCurrentValues['DETAIL_VK_USE'])
		{
			$arTemplateParameters['DETAIL_VK_API_ID'] = array(
				'PARENT' => 'VISUAL',
				'NAME' => GetMessage('CP_BC_TPL_DETAIL_VK_API_ID'),
				'TYPE' => 'STRING',
				'DEFAULT' => 'API_ID'
			);
		}
	}

	$arTemplateParameters['DETAIL_FB_USE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_FB_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);

	if (isset($arCurrentValues['DETAIL_FB_USE']) && 'Y' == $arCurrentValues['DETAIL_FB_USE'])
	{
		$arTemplateParameters['DETAIL_FB_APP_ID'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_DETAIL_FB_APP_ID'),
			'TYPE' => 'STRING',
			'DEFAULT' => ''
		);
	}
}

if (ModuleManager::isModuleInstalled("highloadblock"))
{
	$arTemplateParameters['DETAIL_BRAND_USE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_BRAND_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);

	if (isset($arCurrentValues['DETAIL_BRAND_USE']) && 'Y' == $arCurrentValues['DETAIL_BRAND_USE'])
	{
		$arTemplateParameters['DETAIL_BRAND_PROP_CODE'] = array(
			'PARENT' => 'VISUAL',
			"NAME" => GetMessage("CP_BC_TPL_DETAIL_PROP_CODE"),
			"TYPE" => "LIST",
			"VALUES" => $arHighloadPropList,
			"MULTIPLE" => "Y",
			"ADDITIONAL_VALUES" => "Y"
		);
	}
}

if (ModuleManager::isModuleInstalled("sale"))
{
	$arTemplateParameters['USE_SALE_BESTSELLERS'] = array(
		'NAME' => GetMessage('CP_BC_TPL_USE_SALE_BESTSELLERS'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y'
	);

	$arTemplateParameters['USE_BIG_DATA'] = array(
		'PARENT' => 'BIG_DATA_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_USE_BIG_DATA'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);
	if (!isset($arCurrentValues['USE_BIG_DATA']) || $arCurrentValues['USE_BIG_DATA'] == 'Y')
	{
		$rcmTypeList = array(
			'bestsell' => GetMessage('CP_BC_TPL_RCM_BESTSELLERS'),
			'personal' => GetMessage('CP_BC_TPL_RCM_PERSONAL'),
			'similar_sell' => GetMessage('CP_BC_TPL_RCM_SOLD_WITH'),
			'similar_view' => GetMessage('CP_BC_TPL_RCM_VIEWED_WITH'),
			'similar' => GetMessage('CP_BC_TPL_RCM_SIMILAR'),
			'any_similar' => GetMessage('CP_BC_TPL_RCM_SIMILAR_ANY'),
			'any_personal' => GetMessage('CP_BC_TPL_RCM_PERSONAL_WBEST'),
			'any' => GetMessage('CP_BC_TPL_RCM_RAND')
		);
		$arTemplateParameters['BIG_DATA_RCM_TYPE'] = array(
			'PARENT' => 'BIG_DATA_SETTINGS',
			'NAME' => GetMessage('CP_BC_TPL_BIG_DATA_RCM_TYPE'),
			'TYPE' => 'LIST',
			'VALUES' => $rcmTypeList
		);
		unset($rcmTypeList);
	}
}

if (isset($arCurrentValues['SHOW_TOP_ELEMENTS']) && 'Y' == $arCurrentValues['SHOW_TOP_ELEMENTS'])
{
	$arTopViewModeList = array(
		'BANNER' => GetMessage('CPT_BC_TPL_VIEW_MODE_BANNER'),
		'SLIDER' => GetMessage('CPT_BC_TPL_VIEW_MODE_SLIDER'),
		'SECTION' => GetMessage('CPT_BC_TPL_VIEW_MODE_SECTION')
	);
	$arTemplateParameters['TOP_VIEW_MODE'] = array(
		'PARENT' => 'TOP_SETTINGS',
		'NAME' => GetMessage('CPT_BC_TPL_TOP_VIEW_MODE'),
		'TYPE' => 'LIST',
		'VALUES' => $arTopViewModeList,
		'MULTIPLE' => 'N',
		'DEFAULT' => 'SECTION',
		'REFRESH' => 'Y'
	);
	if (isset($arCurrentValues['TOP_VIEW_MODE']) && ('SLIDER' == $arCurrentValues['TOP_VIEW_MODE'] || 'BANNER' == $arCurrentValues['TOP_VIEW_MODE']))
	{
		$arTemplateParameters['TOP_ROTATE_TIMER'] = array(
			'PARENT' => 'TOP_SETTINGS',
			'NAME' => GetMessage('CPT_BC_TPL_TOP_ROTATE_TIMER'),
			'TYPE' => 'STRING',
			'DEFAULT' => '30'
		);
	}
}

if (isset($arCurrentValues['USE_COMPARE']) && $arCurrentValues['USE_COMPARE'] == 'Y')
{
	$arTemplateParameters['COMPARE_POSITION_FIXED'] = array(
		'PARENT' => 'COMPARE_SETTINGS',
		'NAME' => GetMessage('CPT_BC_TPL_COMPARE_POSITION_FIXED'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
		'REFRESH' => 'Y'
	);
	if (!isset($arCurrentValues['COMPARE_POSITION_FIXED']) || $arCurrentValues['COMPARE_POSITION_FIXED'] == 'Y')
	{
		$positionList = array(
			'top left' => GetMessage('CPT_BC_TPL_PARAM_COMPARE_POSITION_TOP_LEFT'),
			'top right' => GetMessage('CPT_BC_TPL_PARAM_COMPARE_POSITION_TOP_RIGHT'),
			'bottom left' => GetMessage('CPT_BC_TPL_PARAM_COMPARE_POSITION_BOTTOM_LEFT'),
			'bottom right' => GetMessage('CPT_BC_TPL_PARAM_COMPARE_POSITION_BOTTOM_RIGHT')
		);
		$arTemplateParameters['COMPARE_POSITION'] = array(
			'PARENT' => 'COMPARE_SETTINGS',
			'NAME' => GetMessage('CPT_BC_TPL_COMPARE_POSITION'),
			'TYPE' => 'LIST',
			'VALUES' => $positionList,
			'DEFAULT' => 'top left'
		);
		unset($positionList);
	}
}

$arTemplateParameters['SIDEBAR_SECTION_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_SIDEBAR_SECTION_SHOW'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'SORT' => 800
);
$arTemplateParameters['SIDEBAR_DETAIL_SHOW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_SIDEBAR_DETAIL_SHOW'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y',
	'SORT' => 800
);
$arTemplateParameters['SIDEBAR_PATH'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CPT_SIDEBAR_PATH'),
	'TYPE' => 'STRING',
	'SORT' => 800
);

$arTemplateParameters['DETAIL_VIEW'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('DETAIL_VIEW'),
	'TYPE' => 'LIST',
	'VALUES' => [
	    'settings' => GetMessage('DETAIL_VIEW_SETTINGS'),
		'tabless' => GetMessage('DETAIL_VIEW_TABLESS'),
		'tabs' => GetMessage('DETAIL_VIEW_TABS'),
		'tabs_bottom' => GetMessage('DETAIL_VIEW_TABS_BOTTOM'),
		'tabs_right' => GetMessage('DETAIL_VIEW_TABS_RIGHT')
	]
);

$arTemplateParameters['OFFERS_PROPERTIES_MODE'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('OFFERS_PROPERTIES_MODE'),
	'TYPE' => 'LIST',
	'VALUES' => array(
		'COLOR' => GetMessage('OFFERS_PROPERTIES_MODE_COLOR'),
		'TEXT' => GetMessage('OFFERS_PROPERTIES_MODE_TEXT'),
		'COLOR_TEXT' => GetMessage('OFFERS_PROPERTIES_MODE_COLOR_TEXT')
	),
	'DEFAULT' => 'E'
);

if (!empty($arCurrentValues['IBLOCK_ID'])) {

	$catalog = CCatalog::GetByID($arCurrentValues['IBLOCK_ID']);

	$iBlockPropertiesList = CIBlockProperty::GetList(array(), array(
		'IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'],
		'ACTIVE' => 'Y'
	));
	// Infoblock properties arrays [type => data_array]
	$iBlockProperties = array(
		'list' => array(),
		'element' => array(),
		'string' => array(),
		'file' => array(),
		'checkbox' => array()
	);
	while ($row = $iBlockPropertiesList->Fetch()) {
		$propertyName = '['. $row['CODE'] .'] '. $row['NAME'];
		switch ($row['PROPERTY_TYPE']) {
			case 'L':
				if ($row['LIST_TYPE'] == 'C') {
					$iBlockProperties['checkbox'][$row['CODE']] = $propertyName;
				} else {
					$iBlockProperties['list'][$row['CODE']] = $propertyName;
				}
				break;
			case 'E':
				$iBlockProperties['element'][$row['CODE']] = $propertyName;
				break;
			case 'F':
				$iBlockProperties['file'][$row['CODE']] = $propertyName;
				break;
			case 'S':
				$iBlockProperties['string'][$row['CODE']] = $propertyName;
				break;
		}
	}
	unset($iBlockPropertiesList);

	// Property Article
	$arTemplateParameters['PROPERTY_ARTICLE'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('PROPERTY_ARTICLE'),
		'TYPE' => 'LIST',
		'VALUES' => $iBlockProperties['string'],
		'ADDITIONAL_VALUES' => 'Y'
	);

	// Property Brand
	$arTemplateParameters['PROPERTY_BRAND'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('PROPERTY_BRAND'),
		'TYPE' => 'LIST',
		'VALUES' => $iBlockProperties['element'],
		'ADDITIONAL_VALUES' => 'Y'
	);

	// Property is new
	$arTemplateParameters['PROPERTY_IS_NEW'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('PROPERTY_IS_NEW'),
		'TYPE' => 'LIST',
		'VALUES' => $iBlockProperties['checkbox'],
		'ADDITIONAL_VALUES' => 'Y'
	);

	// Property is popular
	$arTemplateParameters['PROPERTY_IS_POPULAR'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('PROPERTY_IS_POPULAR'),
		'TYPE' => 'LIST',
		'VALUES' => $iBlockProperties['checkbox'],
		'ADDITIONAL_VALUES' => 'Y'
	);

    // Property is recommendation
    $arTemplateParameters['PROPERTY_IS_RECOMMENDATION'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_IS_RECOMMENDATION'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockProperties['checkbox'],
        'ADDITIONAL_VALUES' => 'Y'
    );

	$arTemplateParameters['VIDEO_IBLOCK_TYPE'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('VIDEO_IBLOCK_TYPE'),
		'TYPE' => 'LIST',
		'VALUES' => CIBlockParameters::GetIBlockTypes(),
		'ADDITIONAL_VALUES' => 'Y',
		'REFRESH' => 'Y'
	);

	$videoIBlocksList = array();
	$videoIBlocks = CIBlock::GetList(
		array(),
		!empty($arCurrentValues['VIDEO_IBLOCK_TYPE'])
			? array('ACTIVE' => 'Y', 'TYPE' => $arCurrentValues['VIDEO_IBLOCK_TYPE'])
			: array('ACTIVE' => 'Y')
	);
	while ($row = $videoIBlocks->Fetch()) {
		$videoIBlocksList[$row['ID']] = '['. $row['ID'] .'] '. $row['NAME'];
	}
	$arTemplateParameters['VIDEO_IBLOCK_ID'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('VIDEO_IBLOCK_ID'),
		'TYPE' => 'LIST',
		'VALUES' => $videoIBlocksList,
		'ADDITIONAL_VALUES' => 'Y',
		'REFRESH' => 'Y'
	);
	unset($videoIBlocks, $videoIBlocksList);

	$videoIBlockPropertiesList = array();
	$videoIBlockProperties = CIBlockProperty::GetList(array(), array(
		'IBLOCK_ID' => $arCurrentValues['VIDEO_IBLOCK_ID'],
		'ACTIVE' => 'Y',
		'PROPERTY_TYPE' => 'S'
	));
	while ($row = $videoIBlockProperties->GetNext()) {
		$videoIBlockPropertiesList[$row['CODE']] = '['. $row['CODE'] .'] '. $row['NAME'];
	}
	$arTemplateParameters['VIDEO_IBLOCK_PROPERTY'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('VIDEO_IBLOCK_PROPERTY'),
		'TYPE' => 'LIST',
		'VALUES' => $videoIBlockPropertiesList,
		'ADDITIONAL_VALUES' => 'Y'
	);
	unset($videoIBlockProperties, $videoIBlockPropertiesList);

	// Property Video
	$arTemplateParameters['PROPERTY_VIDEO'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('PROPERTY_VIDEO'),
		'TYPE' => 'LIST',
		'VALUES' => $iBlockProperties['element'],
		'ADDITIONAL_VALUES' => 'Y'
	);

	// Property Documents
	$arTemplateParameters['PROPERTY_DOCUMENTS'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('PROPERTY_DOCUMENTS'),
		'TYPE' => 'LIST',
		'VALUES' => $iBlockProperties['file'],
		'ADDITIONAL_VALUES' => 'Y'
	);

	// Property buying
    $arTemplateParameters['PROPERTY_BUYING'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_BUYING'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockProperties['element'],
		'ADDITIONAL_VALUES' => 'Y'
    );

    // Property recomendations
    $arTemplateParameters['PROPERTY_RECOMENDATIONS'] = array(
        'PARENT' => 'DATA_SOURCE',
        'NAME' => GetMessage('PROPERTY_RECOMENDATIONS'),
        'TYPE' => 'LIST',
        'VALUES' => $iBlockProperties['element'],
		'ADDITIONAL_VALUES' => 'Y'
    );


	// Property more photo
	$arTemplateParameters['PROPERTY_MORE_PHOTO'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('PROPERTY_MORE_PHOTO'),
		'TYPE' => 'LIST',
		'VALUES' => $iBlockProperties['file'],
		'ADDITIONAL_VALUES' => 'Y'
	);

	$offersIBlockPropertiesList = array();
	$offersIBlockProperties = CIBlockProperty::GetList(array(), array(
		'IBLOCK_ID' => $catalog['OFFERS_IBLOCK_ID'],
		'ACTIVE' => 'Y',
		'PROPERTY_TYPE' => 'F'
	));
	while ($row = $offersIBlockProperties->GetNext()) {
		$offersIBlockPropertiesList[$row['CODE']] = '['. $row['CODE'] .'] '. $row['NAME'];
	}
	$arTemplateParameters['OFFERS_PROPERTY_MORE_PHOTO'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('OFFERS_PROPERTY_MORE_PHOTO'),
		'TYPE' => 'LIST',
		'VALUES' => $offersIBlockPropertiesList,
		'ADDITIONAL_VALUES' => 'Y'
	);
	unset($offersIBlockProperties, $offersIBlockPropertiesList);

	// Reviews infoblock type
	$arTemplateParameters['REVIEWS_IBLOCK_TYPE'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('REVIEWS_IBLOCK_TYPE'),
		'TYPE' => 'LIST',
		'VALUES' => CIBlockParameters::GetIBlockTypes(),
		'ADDITIONAL_VALUES' => 'Y',
		'REFRESH' => 'Y'
	);

	// Reviews infoblock
	$infoblocksList = array();
	$infoblocks = CIBlock::GetList(
		array(),
		!empty($arCurrentValues['REVIEWS_IBLOCK_TYPE'])
			? array('TYPE' => $arCurrentValues['REVIEWS_IBLOCK_TYPE'], 'ACTIVE' => 'Y')
			: array('ACTIVE' => 'Y')
	);
	while ($row = $infoblocks->Fetch()) {
		$infoblocksList[$row['ID']] = '['. $row['ID'] .'] '. $row['NAME'];
	}
	$arTemplateParameters['REVIEWS_IBLOCK'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('REVIEWS_IBLOCK'),
		'TYPE' => 'LIST',
		'VALUES' => $infoblocksList,
		'ADDITIONAL_VALUES' => 'Y',
		'REFRESH' => 'Y'
	);
	unset($infoblocks, $infoblocksList);

	// Reviews settings
	if (!empty($arCurrentValues['REVIEWS_IBLOCK'])) {

		// Element binding property
		$reviewProperties = array();
		$reviewPropertiesList = CIBlockProperty::GetList(array(), array(
			'IBLOCK_ID' => $arCurrentValues['REVIEWS_IBLOCK'],
			'PROPERTY_TYPE' => 'E',
			'ACTIVE' => 'Y'
		));
		while ($row = $reviewPropertiesList->Fetch()) {
			$reviewProperties[$row['CODE']] = '['. $row['CODE'] .'] '. $row['NAME'];
		}
		unset($reviewPropertiesList);

		$arTemplateParameters['REVIEWS_PROPERTY_ELEMENT_ID'] = array(
			'PARENT' => 'DATA_SOURCE',
			'NAME' => GetMessage('REVIEWS_PROPERTY_ELEMENT_ID'),
			'TYPE' => 'LIST',
			'VALUES' => $reviewProperties,
			'ADDITIONAL_VALUES' => 'Y'
		);

		// Reviews mail event
		$reviewsMailEventsList = array();
		$reviewsMailEvents = CEventType::GetList(
			array(
				'TYPE_ID' => 'WF_NEW_IBLOCK_ELEMENT'
			)
		);
		while ($row = $reviewsMailEvents->Fetch()) {
			$reviewsMailEventsList[$row['CODE']] = $row['NAME'];
		}
		$arTemplateParameters['REVIEWS_MAIL_EVENT'] = array(
			'PARENT' => 'DATA_SOURCE',
			'NAME' => GetMessage('REVIEWS_MAIL_EVENT'),
			'TYPE' => 'LIST',
			'VALUES' => $reviewsMailEventsList,
			'ADDITIONAL_VALUES' => 'Y'
		);
		unset($reviewsMailEvents, $reviewsMailEventsList);

		$arTemplateParameters['REVIEWS_USE_CAPTCHA'] = array(
			'PARENT' => 'DATA_SOURCE',
			'NAME' => GetMessage('REVIEWS_USE_CAPTCHA'),
			'TYPE' => 'CHECKBOX',
			'DEFAULT' => 'Y',
		);
	}
}

// Web Form
if (CModule::IncludeModule('form')) {
	$webFormsList = array();
	$webForms = CForm::GetList($by = 'sort', $order = 'asc', array(), $filtered = false);
	while ($row = $webForms->Fetch()) {
		$webFormsList[$row['ID']] = '['. $row['ID'] .'] '. $row['NAME'];
	}
	$arTemplateParameters['WEB_FORM'] = array(
		'PARENT' => 'DATA_SOURCE',
		'NAME' => GetMessage('WEB_FORM'),
		'TYPE' => 'LIST',
		'VALUES' => $webFormsList,
		'REFRESH' => 'Y'
	);
}

$arTemplateParameters['USE_FAST_ORDER'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CE_USE_FAST_ORDER'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y'
);
if ($arCurrentValues['USE_FAST_ORDER'] == 'Y') {

	$fastOrderTemplatesList = array();
	$fastOrderTemplates = CComponentUtil::GetTemplatesList('intec.universe:sale.order.fast', 'universe');
	foreach ($fastOrderTemplates as $template) {
		$templateName = $template['TEMPLATE'] ? $template['TEMPLATE'] : GetMessage('CE_DEFAULT_TEMPLATE');
		$fastOrderTemplatesList[$template['NAME']] = $template['NAME'] .' ('. $templateName .')';
	}
	$arTemplateParameters['FAST_ORDER_TEMPLATE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_TEMPLATE'),
		'TYPE' => 'LIST',
		'VALUES' => $fastOrderTemplatesList
	);
	unset($fastOrderTemplates);

	$arTemplateParameters['FAST_ORDER_TITLE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_TITLE'),
		'TYPE' => 'STRING'
	);
	$arTemplateParameters['FAST_ORDER_SEND_BUTTON'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_SEND_BUTTON'),
		'TYPE' => 'STRING'
	);
	$arTemplateParameters['FAST_ORDER_SHOW_COMMENT'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_SHOW_COMMENT'),
		'TYPE' => 'CHECKBOX'
	);

	$priceTypesList = array();
	$priceTypes = CCatalogGroup::GetList(array(), array());
	while ($row = $priceTypes->GetNext()) {
		$priceTypesList[$row['ID']] = '['. $row['ID'] .'] '. $row['NAME'];
	}
	$arTemplateParameters['FAST_ORDER_PRICE_TYPE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_PRICE_TYPE'),
		'TYPE' => 'LIST',
		'VALUES' => $priceTypesList
	);
	unset($priceTypes, $priceTypesList);

	$deliveryTypeList = array();
	$deliveryType = CSaleDelivery::GetList(
		array(),
		array('ACTIVE' => 'Y', 'SID'=>SITE_ID),
		false,
		false,
		array('ID', 'NAME')
	);
	while ($row = $deliveryType->Fetch()) {
		$deliveryTypeList[$row['ID']] = '['. $row['ID'] .'] '. $row['NAME'];
	}
	$arTemplateParameters['FAST_ORDER_DELIVERY_TYPE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_DELIVERY_TYPE'),
		'TYPE' => 'LIST',
		'VALUES' => $deliveryTypeList
	);
	unset($deliveryType, $deliveryTypeList);

	$paySystemList = array();
	$paySystem = CSalePaySystem::GetList(
		array(),
		array('ACTIVE' => 'Y'),
		false,
		false,
		array('ID', 'NAME')
	);
	while ($row = $paySystem->Fetch()) {
		$paySystemList[$row['ID']] = '['. $row['ID'] .'] '. $row['NAME'];
	}
	$arTemplateParameters['FAST_ORDER_PAYMET_TYPE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_PAYMENT_TYPE'),
		'TYPE' => 'LIST',
		'VALUES' => $paySystemList
	);
	unset($paySystem, $paySystemList);

	$personTypeList = array();
	$personType = CSalePersonType::GetList(
		array(),
		array('ACTIVE' => 'Y', 'SID'=>SITE_ID),
		false,
		false,
		array('ID', 'NAME')
	);
	while ($row = $personType->Fetch()) {
		$personTypeList[$row['ID']] = '['. $row['ID'] .'] '. $row['NAME'];
	}
	$arTemplateParameters['FAST_ORDER_PAYER_TYPE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_PAYER_TYPE'),
		'TYPE' => 'LIST',
		'VALUES' => $personTypeList,
		'REFRESH' => 'Y'
	);
	unset($personType, $personTypeList);

	$saleOrderPropsList = array();
	$saleOrderPropsNoRrequiedList = array();
	$saleOrderProps = CSaleOrderProps::GetList(array(), array(
		'PERSON_TYPE_ID' => $arCurrentValues['FAST_ORDER_PAYER_TYPE']
	));
	while ($row = $saleOrderProps->Fetch()) {
		$name = '['. $row['ID'] .'] '. $row['NAME'];
		if ($row['REQUIED'] == 'N') {
			$saleOrderPropsNoRrequiedList[$row['ID']] = $name;
		}
		$saleOrderPropsList[$row['ID']] = $name;
	}
	$arTemplateParameters['FAST_ORDER_SHOW_PROPERTIES'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_SHOW_PROPERTIES'),
		'TYPE' => 'LIST',
		'VALUES' => $saleOrderPropsNoRrequiedList,
		'MULTIPLE' => 'Y'
	);
	unset($saleOrderProps, $saleOrderPropsNoRrequiedList);

	$arTemplateParameters['FAST_ORDER_PROPERTY_PHONE'] = array(
		'PARENT' => 'DETAIL_SETTINGS',
		'NAME' => GetMessage('CE_FAST_ORDER_PROPERTY_PHONE'),
		'TYPE' => 'LIST',
		'VALUES' => $saleOrderPropsList,
		'ADDITIONAL_VALUES' => 'Y'
	);
}


//LAZY_LOAD
$arTemplateParameters['LAZY_LOAD'] = array(
	'PARENT' => 'PAGER_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_LAZY_LOAD'),
	'TYPE' => 'CHECKBOX',
	'REFRESH' => 'Y',
	'DEFAULT' => 'N'
);

if (isset($arCurrentValues['LAZY_LOAD']) && $arCurrentValues['LAZY_LOAD'] === 'Y')
{
	$arTemplateParameters['MESS_BTN_LAZY_LOAD'] = array(
		'PARENT' => 'PAGER_SETTINGS',
		'NAME' => GetMessage('CP_BC_TPL_MESS_BTN_LAZY_LOAD'),
		'TYPE' => 'TEXT',
		'DEFAULT' => GetMessage('CP_BC_TPL_MESS_BTN_LAZY_LOAD_DEFAULT')
	);
}

$arTemplateParameters['MENU_DISPLAY_IN_ROOT'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_ROOT'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        'settings' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_FROM_SETTINGS'),
        'Y' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_YES'),
        'N' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_NO'),
    ),
    'DEFAULT' => 'N'
);

$arTemplateParameters['MENU_DISPLAY_IN_SECTION'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_SECTION'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        'settings' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_FROM_SETTINGS'),
        'Y' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_YES'),
        'N' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_NO'),
    ),
    'DEFAULT' => 'Y'
);

$arTemplateParameters['MENU_DISPLAY_IN_ELEMENT'] = array(
    'PARENT' => 'VISUAL',
    'NAME' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_ELEMENT'),
    'TYPE' => 'LIST',
    'VALUES' => array(
        'settings' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_FROM_SETTINGS'),
        'Y' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_YES'),
        'N' => GetMessage('C_CATALOG_MENU_DISPLAY_IN_NO'),
    ),
    'DEFAULT' => 'N'
);