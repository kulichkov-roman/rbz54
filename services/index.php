<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Услуги");

?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog", 
	"services", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BASKET_URL" => "/personal/basket.php",
		"BIG_DATA_RCM_TYPE" => "bestsell",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMMON_ADD_TO_BASKET_ACTION" => "ADD",
		"COMMON_SHOW_CLOSE_POPUP" => "N",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
		"DETAIL_ADD_TO_BASKET_ACTION" => "",
		"DETAIL_BACKGROUND_IMAGE" => "-",
		"DETAIL_BRAND_USE" => "N",
		"DETAIL_BROWSER_TITLE" => "-",
		"DETAIL_CHECK_SECTION_ID_VARIABLE" => "N",
		"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "H",
		"DETAIL_IMAGE_RESOLUTION" => "16by9",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
		"DETAIL_PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "TRAVEL_DIAGNOSIS",
			1 => "CONSUMABLES",
			2 => "CAPITAL_REPAIR",
			3 => "COMPUTER_DIAGNOSTICS",
			4 => "IMAGE",
			5 => "ETHICS",
			6 => "MANUAL_DIAGNOSTICS",
			7 => "CONFIDENCE",
			8 => "SELF_MANAGEMENT",
			9 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_SET_VIEWED_IN_COMPONENT" => "N",
		"DETAIL_SHOW_POPULAR" => "Y",
		"DETAIL_SHOW_SLIDER" => "N",
		"DETAIL_SHOW_VIEWED" => "Y",
		"DETAIL_STRICT_SECTION_CHECK" => "N",
		"DETAIL_USE_COMMENTS" => "N",
		"DETAIL_USE_VOTE_RATING" => "N",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "shows",
		"ELEMENT_SORT_FIELD2" => "shows",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "asc",
		"FILTER_HIDE_ON_MOBILE" => "N",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"GIFTS_DETAIL_BLOCK_TITLE" => "",
		"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "",
		"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "",
		"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_MESS_BTN_BUY" => "",
		"GIFTS_SECTION_LIST_BLOCK_TITLE" => "",
		"GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE" => "N",
		"GIFTS_SECTION_LIST_PAGE_ELEMENT_COUNT" => "4",
		"GIFTS_SECTION_LIST_TEXT_LABEL_GIFT" => "",
		"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
		"GIFTS_SHOW_IMAGE" => "Y",
		"GIFTS_SHOW_NAME" => "Y",
		"GIFTS_SHOW_OLD_PRICE" => "Y",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"IBLOCK_ID" => "17",
		"IBLOCK_TYPE" => "catalogs",
		"INCLUDE_SUBSECTIONS" => "Y",
		"INSTANT_RELOAD" => "N",
		"LAZY_LOAD" => "Y",
		"LINE_ELEMENT_COUNT" => "3",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"LINK_IBLOCK_ID" => "",
		"LINK_IBLOCK_TYPE" => "",
		"LINK_PROPERTY_SID" => "",
		"LIST_BROWSER_TITLE" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_META_KEYWORDS" => "-",
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "Р’ РєРѕСЂР·РёРЅСѓ",
		"MESS_BTN_BUY" => "РљСѓРїРёС‚СЊ",
		"MESS_BTN_COMPARE" => "РЎСЂР°РІРЅРµРЅРёРµ",
		"MESS_BTN_DETAIL" => "РџРѕРґСЂРѕР±РЅРµРµ",
		"MESS_BTN_SUBSCRIBE" => "РџРѕРґРїРёСЃР°С‚СЊСЃСЏ",
		"MESS_COMMENTS_TAB" => "РљРѕРјРјРµРЅС‚Р°СЂРёРё",
		"MESS_DESCRIPTION_TAB" => "РћРїРёСЃР°РЅРёРµ",
		"MESS_NOT_AVAILABLE" => "РќРµС‚ РІ РЅР°Р»РёС‡РёРё",
		"MESS_PRICE_RANGES_TITLE" => "Р¦РµРЅС‹",
		"MESS_PROPERTIES_TAB" => "РҐР°СЂР°РєС‚РµСЂРёСЃС‚РёРєРё",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "",
		"PAGE_ELEMENT_COUNT" => "2",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"SEARCH_CHECK_DATES" => "Y",
		"SEARCH_NO_WORD_LOGIC" => "Y",
		"SEARCH_PAGE_RESULT_COUNT" => "50",
		"SEARCH_RESTART" => "N",
		"SEARCH_USE_LANGUAGE_GUESS" => "Y",
		"SECTIONS_SHOW_PARENT_NAME" => "Y",
		"SECTIONS_VIEW_MODE" => "list",
		"SECTION_ADD_TO_BASKET_ACTION" => "BUY",
		"SECTION_BACKGROUND_IMAGE" => "-",
		"SECTION_COUNT_ELEMENTS" => "Y",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_TOP_DEPTH" => "2",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_DEACTIVATED" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_TOP_ELEMENTS" => "Y",
		"SIDEBAR_DETAIL_SHOW" => "N",
		"SIDEBAR_PATH" => "",
		"SIDEBAR_SECTION_SHOW" => "Y",
		"TEMPLATE_THEME" => "site",
		"TOP_ADD_TO_BASKET_ACTION" => "BUY",
		"TOP_ELEMENT_COUNT" => "9",
		"TOP_ELEMENT_SORT_FIELD" => "shows",
		"TOP_ELEMENT_SORT_FIELD2" => "shows",
		"TOP_ELEMENT_SORT_ORDER" => "asc",
		"TOP_ELEMENT_SORT_ORDER2" => "asc",
		"TOP_LINE_ELEMENT_COUNT" => "3",
		"TOP_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"USE_BIG_DATA" => "Y",
		"USE_COMMON_SETTINGS_BASKET_POPUP" => "N",
		"USE_COMPARE" => "N",
		"USE_ELEMENT_COUNTER" => "Y",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_FILTER" => "N",
		"USE_GIFTS_DETAIL" => "N",
		"USE_GIFTS_MAIN_PR_SECTION_LIST" => "Y",
		"USE_GIFTS_SECTION" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"USE_REVIEW" => "N",
		"USE_SALE_BESTSELLERS" => "Y",
		"USE_STORE" => "N",
		"COMPONENT_TEMPLATE" => "services",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"DETAIL_ADD_TO_BASKET_ACTION_PRIMARY" => array(
			0 => "BUY",
		),
		"TOP_PROPERTY_CODE_MOBILE" => "",
		"TOP_VIEW_MODE" => "BANNER",
		"TOP_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"TOP_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"TOP_ENLARGE_PRODUCT" => "STRICT",
		"TOP_SHOW_SLIDER" => "Y",
		"TOP_SLIDER_INTERVAL" => "3000",
		"TOP_SLIDER_PROGRESS" => "N",
		"LIST_PROPERTY_CODE_MOBILE" => "",
		"LIST_PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"LIST_PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"LIST_ENLARGE_PRODUCT" => "STRICT",
		"LIST_SHOW_SLIDER" => "Y",
		"LIST_SLIDER_INTERVAL" => "3000",
		"LIST_SLIDER_PROGRESS" => "N",
		"DETAIL_MAIN_BLOCK_PROPERTY_CODE" => "",
		"DETAIL_SHOW_MAX_QUANTITY" => "N",
		"SEF_FOLDER" => "/services/",
		"USE_SIMILAR_SERVICES" => "N",
		"REVIEWS_IBLOCK_TYPE" => "reviews",
		"REVIEWS_IBLOCK_ID" => "16",
		"REVIEWS_COUNT" => "20",
		"LINE_SECTION_COUNT" => "2",
		"USE_ALSO_BUY" => "N",
		"PRODUCT_DISPLAY_MODE" => "N",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => "",
		"OFFERS_CART_PROPERTIES" => "",
		"TOP_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"TOP_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"TOP_OFFERS_LIMIT" => "5",
		"LIST_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_OFFERS_LIMIT" => "5",
		"DETAIL_OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"TMP_SECTION_SHOW" => "tile",
		"TMP_BLOCK_SECTION_SHOW" => "N",
		"TMP_CIRCLE_SECTION_SHOW" => "Y",
		"TMP_EXTEND_SECTION_SHOW" => "BLOCK",
		"TMP_TILE_SECTION_SHOW" => "TWO",
		"TMP_LIST_SHOW" => "tile",
		"TMP_BLOCK_LIST_SHOW" => "N",
		"TMP_TILE_LIST_SHOW" => "TWO",
		"TMP_CIRCLE_LIST_SHOW" => "Y",
		"TOP_ROTATE_TIMER" => "30",
		"SHOW_SQUARE_IMAGE" => "SQUARE",
		"SHOW_SQUARE_AND_CIRCLE_IMAGE" => "CIRCLE",
		"SHOW_SECTION_SQUARE_AND_CIRCLE_IMAGE" => "CIRCLE",
		"TMP_EXTEND_LIST_SHOW" => "BLOCK",
		"NAME_PROP_PROJECTS" => "SYSTEM_PROJECTS",
		"NAME_PROP_VIDEO" => "SYSTEM_VIDEO",
		"NAME_PROP_GALLERY" => "SYSTEM_GALLERY",
		"NAME_PROP_REVIEWS" => "SYSTEM_REVIEWS",
		"NAME_PROP_SERVICES" => "SYSTEM_SERVICES",
		"SECTIONS_LIST_VIEW" => "settings",
		"ELEMENTS_LIST_VIEW" => "settings",
		"TYPE_BANNER" => "settings",
		"FEEDBACK" => "Y",
		"SERVICES" => "Y",
		"SECTIONS_LIST_VIEW_LINE_COUNT" => "3",
		"SECTIONS_LIST_VIEW_IMAGES" => "CIRCLE",
		"SECTIONS_LIST_VIEW_DISPLAY_DESCRIPTION" => "N",
		"ELEMENTS_LIST_VIEW_LINE_COUNT" => "2",
		"ELEMENTS_LIST_VIEW_IMAGES" => $viewImages,
		"ELEMENTS_LIST_VIEW_DISPLAY_DESCRIPTION" => "N",
		"NAME_PROP_URL_VIDEO" => "LINK",
		"NAME_PROP_PRICE" => "SYSTEM_PRICE",
		"NAME_PROP_AUTOR_REVIEW" => "SYSTEM_AUTOR",
		"NAME_PROP_COMPANY_REVIEW" => "SYSTEM_COMPANY",
		"FEEDBACK_FORM_ID" => "3",
		"SERVICES_FORM_ID" => "2",
		"PROPERTY_FORM_ORDER_SERVICE" => "form_text_3",
		"PROPERTY_IMAGE" => "",
		"PROPERTY_ARTICLE" => "",
		"PROPERTY_BRAND" => "",
		"PROPERTY_IS_NEW" => "",
		"PROPERTY_IS_POPULAR" => "",
		"PROPERTY_VIDEO" => "",
		"PROPERTY_DOCUMENTS" => "",
		"PROPERTY_BUYING" => "",
		"PROPERTY_RECOMENDATIONS" => "",
		"PROPERTY_MORE_PHOTO" => "",
		"DETAIL_VIEW" => "tabless",
		"OFFERS_PROPERTIES_MODE" => "COLOR",
		"DISPLAY_IBLOCK_DESCRIPTION" => "Y",
		"GRID_CATALOG_ROOT_SECTIONS_COUNT" => "5",
		"GRID_CATALOG_SECTIONS_COUNT" => "4",
		"USE_SUBSECTIONS_SECTIONS" => "N",
		"SECTIONS_DISPLAY_DESCRIPTION" => "Y",
		"SECTION_SORT_PRICE_CODE" => "1",
		"USE_COUNT_PRODUCT" => "N",
		"LIST_DISPLAY_PREVIEW" => "Y",
		"LIST_DISPLAY_PROPERTIES" => "Y",
		"DETAIL_PICTURE_POPUP" => "Y",
		"DETAIL_PICTURE_LOOP" => "Y",
		"TYPE_BANNER_WIDE" => "Y",
		"MESS_BTN_LAZY_LOAD" => "Показать еще",
		"SHOW_HEADER_SUBMENU" => "N",
		"USER_CONSENT" => "N",
		"USER_CONSENT_ID" => "0",
		"USER_CONSENT_IS_CHECKED" => "Y",
		"USER_CONSENT_IS_LOADED" => "N",
		"MENU_ROOT_TYPE" => "left",
		"MENU_MAX_LEVEL" => "1",
		"MENU_CHILD_TYPE" => "left",
		"MENU_DISPLAY_IN_ROOT" => "settings",
		"MENU_DISPLAY_IN_SECTION" => "settings",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE#/",
			"element" => "#SECTION_CODE#/#ELEMENT_ID#/",
			"compare" => "compare.php?action=#ACTION_CODE#",
			"smart_filter" => "#SECTION_ID#/filter/#SMART_FILTER_PATH#/apply/",
		),
		"VARIABLE_ALIASES" => array(
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
