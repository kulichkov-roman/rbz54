<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подписки");?>
<?$APPLICATION->IncludeComponent(
    "bitrix:subscribe.edit",
    "subscribe-edit",
    Array(
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "ALLOW_ANONYMOUS" => "Y",
        "CACHE_TIME" => "3600",
        "CACHE_TYPE" => "A",
        "SET_TITLE" => "Y",
        "SHOW_AUTH_LINKS" => "Y",
        "SHOW_HIDDEN" => "N"
    )
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
