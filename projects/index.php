<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"projects", 
	array(
		"COMPONENT_TEMPLATE" => "projects",
		"IBLOCK_TYPE" => "content",
		"IBLOCK_ID" => "14",
		"NEWS_COUNT" => "50",
		"USE_SEARCH" => "N",
		"IBLOCK_TYPE_SERVICES" => "catalogs",
		"IBLOCK_ID_SERVICES" => "17",
		"ALLOW_LINK_SERVICES" => "Y",
		"IBLOCK_TYPE_REVIEWS" => "",
		"IBLOCK_ID_REVIEWS" => "",
		"ALLOW_LINK_REVIEWS" => "N",
		"USE_RSS" => "N",
		"USE_RATING" => "N",
		"USE_CATEGORIES" => "N",
		"USE_REVIEW" => "N",
		"USE_FILTER" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"CHECK_DATES" => "Y",
		"FORM_ORDER" => "4",
		"PROPERTY_FORM_ORDER_PROJECT" => "form_text_11",
		"FORM_ASK" => "3",
		"PROPERTY_GALLERY" => "SYSTEM_GALLERY",
		"PROPERTY_OBJECTIVE" => "SYSTEM_OBJECTIVE",
		"PROPERTY_SERVICES" => "SYSTEM_SERVICES",
		"PROPERTY_IMAGES" => "SYSTEM_IMAGES",
		"PROPERTY_SOLUTION_BEGIN" => "SYSTEM_SOLUTION_BEGIN",
		"PROPERTY_SOLUTION_IMAGE" => "SYSTEM_SOLUTION_IMAGE",
		"PROPERTY_SOLUTION_END" => "SYSTEM_SOLUTION_END",
		"DISPLAY_FORM_ORDER" => "Y",
		"DISPLAY_FORM_ASK" => "Y",
		"DETAIL_URL_SERVICES" => "",
		"PAGE_URL_REVIEWS" => "",
		"DETAIL_URL_REVIEWS" => "",
		"SEF_MODE" => "N",
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
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "SYSTEM_OBJECTIVE",
			1 => "SYSTEM_SOLUTION_END",
			2 => "SYSTEM_SOLUTION_BEGIN",
			3 => "SYSTEM_SERVICES",
			4 => "",
		),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_LIST_TAB_ALL" => "Y",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_ACTIVE_DATE_FORMAT" => "j F Y",
		"DETAIL_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"DETAIL_PROPERTY_CODE" => array(
			0 => "SYSTEM_OBJECTIVE",
			1 => "SYSTEM_SOLUTION_END",
			2 => "SYSTEM_SOLUTION_BEGIN",
			3 => "SYSTEM_SERVICES",
			4 => "",
		),
		"DESCRIPTION_DETAIL_PROPERTIES" => array(
			0 => "SPHERE",
			1 => "DATE",
			2 => "AUTHOR",
			3 => "SITE",
		),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"VARIABLE_ALIASES" => array(
			"SECTION_ID" => "SECTION_ID",
			"ELEMENT_ID" => "ELEMENT_ID",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
