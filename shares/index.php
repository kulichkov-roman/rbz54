<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Акции"); ?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"shares", 
	array(
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "23",
		"NEWS_COUNT" => "20",
		"USE_SEARCH" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "Y",
		"USE_REVIEW" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"SEF_MODE" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_TITLE" => "Y",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "Y",
		"USE_PERMISSIONS" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"USE_SHARE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_ACTIVE_DATE_FORMAT" => "j F Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "PERIOD",
			1 => "SYSTEM_SHOW_ON_MAIN",
			2 => "SALE",
			3 => "CONDITION",
			4 => "LINK",
			5 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_ACTIVE_DATE_FORMAT" => "j F Y",
		"DETAIL_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "PREVIEW_PICTURE",
			4 => "DETAIL_TEXT",
			5 => "DETAIL_PICTURE",
			6 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "PERIOD",
			1 => "SYSTEM_SHOW_ON_MAIN",
			2 => "SALE",
			3 => "CONDITION",
			4 => "ICONS",
			5 => "PROMO",
			6 => "TAESER",
			7 => "TAESER_HEADER",
			8 => "OVERVIEWS_VIDEO",
			9 => "PHOTO",
			10 => "SECTIONS_HEADER",
			11 => "SERVICES",
			12 => "LINK",
			13 => "",
		),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"SHARE_HIDE" => "N",
		"SHARE_TEMPLATE" => "",
		"SHARE_HANDLERS" => array(
			0 => "facebook",
			1 => "mailru",
			2 => "delicious",
			3 => "vk",
			4 => "twitter",
			5 => "lj",
		),
		"SHARE_SHORTEN_URL_LOGIN" => "",
		"SHARE_SHORTEN_URL_KEY" => "",
		"SEF_FOLDER" => "/shares/",
		"CATEGORY_IBLOCK" => array(
			0 => "16",
		),
		"CATEGORY_CODE" => "CATEGORY",
		"CATEGORY_ITEMS_COUNT" => "4",
		"CATEGORY_THEME_16" => "photo",
		"PROPERTY_RECOMENDATIONS" => "LINK",
		"IBLOCK_TYPE_FOR_SALE" => "catalogs",
		"IBLOCK_TYPE_ID_SALE" => "13",
		"HEAD_PICTURE_TYPE" => "SETTINGS",
		"USE_LIST_DATE_FILTER" => "N",
		"DISPLAY_LIST_PICTURE" => "N",
		"DISPLAY_LIST_PREVIEW_TEXT" => "N",
		"VIEW_LIST" => "news.tile",
		"DISPLAY_DETAIL_PICTURE" => "N",
		"DISPLAY_DETAIL_PREVIEW_TEXT" => "N",
		"DISPLAY_DETAIL_DATE" => "Y",
		"DISPLAY_DETAIL_READ_ALSO" => "N",
		"TYPE_OF_BLOCK_FOR_CONDITIONS" => "content",
		"ID_OF_BLOCK_FOR_CONDITIONS" => "19",
		"PROPERTY_OF_BLOCK_FOR_CONDITIONS" => "CONDITION",
		"PROPERTY_PRICE_CODE_SALE" => array(
			0 => "BASE",
		),
		"PROPERTY_LIST_TEMPLATE" => "settings",
		"PROPERTY_DETAIL_TEMPLATE" => "extended",
		"PROPERTY_SHOW_FORM" => "Y",
		"PROPERTY_FORM_ID" => "3",
		"PROPERTY_IBLOCK_TYPE_ICONS" => "content",
		"PROPERTY_IBLOCK_ID_ICONS" => "20",
		"PROPERTY_FOR_ICONS" => "ICONS",
		"PROPERTY_IBLOCK_TYPE_PROMO" => "content",
		"PROPERTY_IBLOCK_ID_PROMO" => "22",
		"PROPERTY_FOR_PROMO" => "PROMO",
		"PROPERTY_IBLOCK_TYPE_TEASER" => "content",
		"PROPERTY_IBLOCK_ID_TEASER" => "21",
		"PROPERTY_FOR_TEASER" => "TAESER",
		"PROPERTY_TEASER_HEADER" => "TAESER_HEADER",
		"PROPERTY_IBLOCK_TYPE_OVERVIEWS" => "content",
		"PROPERTY_IBLOCK_ID_OVERVIEWS" => "25",
		"PROPERTY_FOR_OVERVIEWS" => "OVERVIEWS_VIDEO",
		"PROPERTY_OVERVIEWS_LINK" => "LINK",
		"PROPERTY_IBLOCK_TYPE_PHOTO" => "content",
		"PROPERTY_IBLOCK_ID_PHOTO" => "11",
		"PROPERTY_FOR_PHOTO" => "PHOTO",
		"PROPERTY_PHOTO_PROPERTIES" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_IBLOCK_TYPE_SECTION" => "catalogs",
		"PROPERTY_IBLOCK_ID_SECTION" => "13",
		"PROPERTY_FOR_SECTION" => "SECTIONS",
		"PROPERTY_SECTION_HEADER" => "SECTIONS_HEADER",
		"PROPERTY_IBLOCK_TYPE_SERVICES" => "catalogs",
		"PROPERTY_IBLOCK_ID_SERVICES" => "17",
		"PROPERTY_FOR_SERVICES" => "SERVICES",
		"PROPERTY_FOR_PERIOD" => "PERIOD",
		"PROPERTY_FOR_SALE_PERCENT" => "SALE",
		"PROPERTY_BASKET_URL" => "/personal/basket/",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "",
			"detail" => "#ELEMENT_ID#/",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>