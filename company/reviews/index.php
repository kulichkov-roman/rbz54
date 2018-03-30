<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отзывы");?>
<?$APPLICATION->IncludeComponent(
	"intec.universe:widget", 
	"reviews", 
	array(
		"IBLOCK_TYPE" => "reviews",
		"IBLOCK_ID" => "15",
		"ITEMS_LIMIT" => "20",
		"PROPERTY_DISPLAY" => "",
		"DISPLAY_TITLE" => "N",
		"DISPLAY_BUTTON_ALL" => "N",
		"VIEW_DESKTOP" => "default.all",
		"VIEW_MOBILE" => "default.all",
		"PAGE_URL" => "/company/reviews/#ELEMENT_ID#/",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "0"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>