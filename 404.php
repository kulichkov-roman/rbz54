<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");


?>
    <div class="intec-content">
        <div class="intec-content-wrapper intec-404">
            <div class="row">
                <div class="col-md-6 xs-12">
                    <div class="image-404">
                        <img src="<?=SITE_DIR?>images/404.png">
                    </div>
                </div>
                <div class="col-md-6 xs-12">
                    <div class="text-404">
                        <div class="header-text">
                            Ошибка 404
                        </div>
                        <div class="header2-text">
                            Страница не найдена
                        </div>
                        <div class="text">
                            Неправильно набран адрес или такой страницы не существует
                        </div>
                        <div>
                            <a href="<?=SITE_DIR?>" class="intec-button intec-button-cl-common intec-button-md ">
                                Перейти на главную
                            </a>
                            <a href="<?=SITE_DIR?>catalog/" class="intec-button intec-button-transparent intec-button-cl-default intec-button-md ">
                                Вернуться в каталог
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            <div>
                <?$APPLICATION->IncludeComponent(
                    "intec.universe:widget",
                    "search_block",
                    array(
                        "COMPONENT_TEMPLATE" => "search_block",
                        "IBLOCK_TYPE" => "content_new",
                        "IBLOCK_ID" => "33",
                        "ITEMS_LIMIT" => "3",
                        "PROPERTY_DISPLAY" => "",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "DESC",
                        "SORT_BY2" => "ASC",
                        "SORT_ORDER2" => "ASC",
                        "DATE_FORMAT" => "d.m.Y",
                        "DISPLAY_TITLE" => "Y",
                        "DISPLAY_DESCRIPTION" => "Y",
                        "VIEW_DESKTOP" => "tile.desktop",
                        "COUNT_IN_ROW" => "three",
                        "VIEW_MOBILE" => "default.all",
                        "DETAIL_URL" => "",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "0",
                        "TITLE" => "Наши акции",
                        "ALIGN_TITLE" => "left",
                        "DESCRIPTION" => "Наши акции самые крутые",
                        "TITLE_SEARCH" => "Попробуйте найти нужные Вам страницы с помощью поиска",
                        "PAGE_SEARCH" => "/s2/search/"
                    ),
                    false
                );?>
                <br><br>
                <?$APPLICATION->IncludeComponent(
                    "intec.universe:widget",
                    "shares",
                    array(
                        "COMPONENT_TEMPLATE" => "shares",
                        "IBLOCK_TYPE" => "content_new",
                        "IBLOCK_ID" => "33",
                        "ITEMS_LIMIT" => "3",
                        "PROPERTY_DISPLAY" => "",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "DESC",
                        "SORT_BY2" => "ASC",
                        "SORT_ORDER2" => "ASC",
                        "DATE_FORMAT" => "d.m.Y",
                        "DISPLAY_TITLE" => "Y",
                        "DISPLAY_DESCRIPTION" => "Y",
                        "VIEW_DESKTOP" => "tile.desktop",
                        "COUNT_IN_ROW" => "three",
                        "VIEW_MOBILE" => "default.all",
                        "DETAIL_URL" => "",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "0",
                        "TITLE" => "Наши акции",
                        "ALIGN_TITLE" => "left",
                        "DESCRIPTION" => "Наши акции самые крутые"
                    ),
                    false
                );?>
            </div>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>