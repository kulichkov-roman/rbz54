<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use intec\constructor\models\build\File;

Loc::loadMessages(__FILE__);

return [
    'files' => [
        ['path' => 'css/common.css', 'type' => File::TYPE_CSS],
        ['path' => 'css/content.css', 'type' => File::TYPE_CSS],
        ['path' => 'css/buttons.css', 'type' => File::TYPE_CSS],
        ['path' => 'css/scheme.scss', 'type' => File::TYPE_SCSS],
        ['path' => 'css/elements.scss', 'type' => File::TYPE_SCSS],

        ['path' => 'js/plugins/owl_carousel/css/owl.carousel.min.css', 'type' => File::TYPE_CSS],
        ['path' => 'js/plugins/owl_carousel/css/owl.theme.default.min.css', 'type' => File::TYPE_CSS],
        ['path' => 'js/plugins/owl_carousel/owl.carousel.min.js', 'type' => File::TYPE_JAVASCRIPT],
        ['path' => '/js/plugins/light_gallery/js/lightgallery-all.min.js', 'type' => File::TYPE_JAVASCRIPT],
        ['path' => '/js/plugins/light_gallery/css/lightgallery.min.css', 'type' => File::TYPE_CSS]
    ],
    'settings' => [
        /*'banners_position' => [
            'name' => GetMessage('universe.meta.settings.banners_position'),
            'type' => 'list',
            'default' => 'above_header',
            'values' => [
                'above_header' => GetMessage('universe.meta.settings.banners_position.above_header'),
                'under_header' => GetMessage('universe.meta.settings.banners_position.under_header'),
                'above_content' => GetMessage('universe.meta.settings.banners_position.above_content'),
                'under_content' => GetMessage('universe.meta.settings.banners_position.under_content'),
                'side' => GetMessage('universe.meta.settings.banners_position.side'),
                'page_bottom' => GetMessage('universe.meta.settings.banners_position.page_bottom')
            ]
        ],*/
        'bg_color' => [
            'name' => GetMessage('universe.meta.settings.bg_color'),
            'type' => 'color',
            'default' => '#000'
        ],
        /*'catalog_detail' => [
            'name' =>  GetMessage('universe.meta.settings.catalog_detail'),
            'type' => 'list',
            'default' => 'with_tabs',
            'values' => [
                'with_tabs' => GetMessage('universe.meta.settings.catalog_detail.with_tabs'),
                'without_tabs' => GetMessage('universe.meta.settings.catalog_detail.without_tabs')
            ]
        ],*/
        'catalog_detail_image' => [
            'name' => GetMessage('universe.meta.settings.catalog_detail_image'),
            'type' => 'custom',
            'values' => [
                'loop' => GetMessage('universe.meta.settings.catalog_detail_image.loop'),
                'popup' => GetMessage('universe.meta.settings.catalog_detail_image.popup')
            ]
        ],
        'color' => [
            'name' => GetMessage('universe.meta.settings.color'),
            'type' => 'color',
            'default' => '#13181f'
        ],
        'default_products_view' => [
            'name' => GetMessage('universe.meta.settings.default_products_view'),
            'type' => 'list',
            'default' => 'tile',
            'values' => [
                'text' => GetMessage('universe.meta.settings.default_products_view.text'),
                'list' => GetMessage('universe.meta.settings.default_products_view.list'),
                'tile' => GetMessage('universe.meta.settings.default_products_view.tile')
            ]
        ],
        'fio_in_one_field' => [
            'name' => GetMessage('universe.meta.settings.fio_in_one_field'),
            'type' => 'boolean',
            'default' => false
        ],
        'font_size' => [
            'name' => GetMessage('universe.meta.settings.font_size'),
            'type' => 'list',
            'default' => 14,
            'values' => [
                13 => GetMessage('universe.meta.settings.font_size.13'),
                14 => GetMessage('universe.meta.settings.font_size.14'),
                15 => GetMessage('universe.meta.settings.font_size.15'),
                16 => GetMessage('universe.meta.settings.font_size.16')
            ]
        ],
        'font_size_titles' => [
            'name' => GetMessage('universe.meta.settings.font_size_titles'),
            'type' => 'list',
            'default' => 24,
            'values' => [
                20 => GetMessage('universe.meta.settings.font_size_titles.20'),
                24 => GetMessage('universe.meta.settings.font_size_titles.24'),
                30 => GetMessage('universe.meta.settings.font_size_titles.30')
            ]
        ],
        'inform_about_processing_personal_data' => [
            'name' => GetMessage('universe.meta.settings.inform_about_processing_personal_data'),
            'type' => 'boolean',
            'default' => true,
        ],
        'login_equal_email' => [
            'name' => GetMessage('universe.meta.settings.login_equal_email'),
            'type' => 'boolean',
            'default' => true,
        ],
        /*'mobile_menu_type' => [
            'name' => GetMessage('universe.meta.settings.mobile_menu_type'),
            'type' => 'list',
            'default' => 'detail',
            'values' => [
                'detail' => GetMessage('universe.meta.settings.mobile_menu_type.detail'),
                'brief' => GetMessage('universe.meta.settings.mobile_menu_type.brief')
            ]
        ],*/
        'show_bg' => [
            'name' => GetMessage('universe.meta.settings.show_bg'),
            'type' => 'boolean',
            'default' => true
        ],
        'use_basket' => [
            'name' => GetMessage('universe.meta.settings.use_basket'),
            'type' => 'boolean',
            'default' => true
        ],
        'show_flying_basket_when_add_product' => [
            'name' => GetMessage('universe.meta.settings.show_flying_basket_when_add_product'),
            'type' => 'boolean',
            'default' => true
        ],
        /*'show_print_button_on_create_order_page' => [
            'name' => GetMessage('universe.meta.settings.show_print_button_on_create_order_page'),
            'type' => 'boolean',
            'default' => true
        ],*/
        /*'show_products_in_catalog_section' => [
            'name' => GetMessage('universe.meta.settings.show_products_in_catalog_section'),
            'type' => 'boolean',
            'default' => true
        ],*/
        'show_sections_icons_in_menu' => [
            'name' => GetMessage('universe.meta.settings.show_sections_icons_in_menu'),
            'type' => 'boolean',
            'default' => true
        ],
        /*'show_side_menu_on_product_page' => [
            'name' => GetMessage('universe.meta.settings.show_side_menu_on_product_page'),
            'type' => 'boolean',
            'default' => true
        ],*/
        /*'side_menu' => [
            'name' => GetMessage('universe.meta.settings.side_menu'),
            'type' => 'custom',
            'values' => [
                'filter' => GetMessage('universe.meta.settings.side_menu.filter'),
                'catalog' => GetMessage('universe.meta.settings.side_menu.catalog'),
                'banner' => GetMessage('universe.meta.settings.side_menu.banner'),
                'subscribe' => GetMessage('universe.meta.settings.side_menu.subscribe'),
                'news' => GetMessage('universe.meta.settings.side_menu.news'),
                'articles' => GetMessage('universe.meta.settings.side_menu.articles')
            ],
        ],*/
        'site_width' => [
            'name' => GetMessage('universe.meta.settings.site_width'),
            'type' => 'list',
            'default' => 1200,
            'values' => [
                1200 => GetMessage('universe.meta.settings.site_width.1200'),
                1344 => GetMessage('universe.meta.settings.site_width.1344'),
                1500 => GetMessage('universe.meta.settings.site_width.1500'),
                1700 => GetMessage('universe.meta.settings.site_width.1700')
            ]
        ],
        /*'smart_filter' => [
            'name' => GetMessage('universe.meta.settings.smart_filter'),
            'type' => 'list',
            'default' => 'horizontal',
            'values' => [
                'horizontal' => GetMessage('universe.meta.settings.smart_filter.horizontal'),
                'vertical' => GetMessage('universe.meta.settings.smart_filter.vertical')
            ]
        ],*/
        /*'template_about' => [
            'name' => GetMessage('universe.meta.settings.template_about'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'with_icons' => GetMessage('universe.meta.settings.template_about.with_icons'),
                'without_icons' => GetMessage('universe.meta.settings.template_about.without_icons')
            ]
        ],*/
        'template_shares_section' => [
            'name' => GetMessage('universe.meta.settings.template_shares_section'),
            'type' => 'list',
            'default' => 'list',
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_shares_section.default'),
                'blocks' => GetMessage('universe.meta.settings.template_shares_section.blocks'),
                'list' => GetMessage('universe.meta.settings.template_shares_section.list'),
            ]
        ],
        'template_shares_widget' => [
            'name' => GetMessage('universe.meta.settings.template_shares_widget'),
            'type' => 'list',
            'default' => 'list',
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_shares_widget.default'),
                'blocks' => GetMessage('universe.meta.settings.template_shares_widget.blocks'),
                'tile' => GetMessage('universe.meta.settings.template_shares_widget.tile'),
            ]
        ],
        'template_mobile_shares_widget' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_shares_widget'),
            'type' => 'list',
            'default' => 'list',
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_mobile_shares_widget.default'),
                'compact' => GetMessage('universe.meta.settings.template_mobile_shares_widget.compact'),
            ]
        ],
        'template_actions_page' => [
            'name' => GetMessage('universe.meta.settings.template_actions_page'),
            'type' => 'list',
            'default' => 1,
            'values' => [
                1 => GetMessage('universe.meta.settings.template_actions_page.1'),
                2 => GetMessage('universe.meta.settings.template_actions_page.2')
            ]
        ],
        /*'template_basket_icon' => [
            'name' => GetMessage('universe.meta.settings.template_basket_icon'),
            'type' => 'list',
            'default' => 'fillet',
            'values' => [
                'fillet' => GetMessage('universe.meta.settings.template_basket_icon.fillet'),
                'squere' => GetMessage('universe.meta.settings.template_basket_icon.squere'),
                'round' => GetMessage('universe.meta.settings.template_basket_icon.round')
            ]
        ],*/
        /*'template_blog' => [
            'name' => GetMessage('universe.meta.settings.template_blog'),
            'type' => 'list',
            'default' => 'with_filters',
            'values' => [
                'with_filters' => GetMessage('universe.meta.settings.template_blog.with_filters'),
                'without_filters' => GetMessage('universe.meta.settings.template_blog.without_filters')
            ]
        ],*/
        'template_catalog_root' => [
            'name' => GetMessage('universe.meta.settings.template_catalog_root'),
            'type' => 'list',
            'default' => 'tile',
            'values' => [
                'tile' => GetMessage('universe.meta.settings.template_catalog_root.tile'),
                'tile_2' => GetMessage('universe.meta.settings.template_catalog_root.tile_2'),
                'list' => GetMessage('universe.meta.settings.template_catalog_root.list'),
                'list_2' => GetMessage('universe.meta.settings.template_catalog_root.list_2')
            ]
        ],
        'template_catalog_section' => [
            'name' => GetMessage('universe.meta.settings.template_catalog_section'),
            'type' => 'list',
            'default' => 'tile',
            'values' => [
                'tile' => GetMessage('universe.meta.settings.template_catalog_section.tile'),
                'tile_2' => GetMessage('universe.meta.settings.template_catalog_section.tile_2'),
                'list' => GetMessage('universe.meta.settings.template_catalog_section.list'),
                'list_2' => GetMessage('universe.meta.settings.template_catalog_section.list_2')
            ]
        ],
        'template_catalog_product' => [
            'name' => GetMessage('universe.meta.settings.template_catalog_product'),
            'type' => 'list',
            'default' => 'tabless',
            'values' => [
                'tabless' => GetMessage('universe.meta.settings.template_catalog_product.tabless'),
                'tabs' => GetMessage('universe.meta.settings.template_catalog_product.tabs'),
                'tabs_bottom' => GetMessage('universe.meta.settings.template_catalog_product.tabs_bottom'),
                'tabs_right' => GetMessage('universe.meta.settings.template_catalog_product.tabs_right')
            ]
        ],
        'template_certificates' => [
            'name' => GetMessage('universe.meta.settings.template_certificates'),
            'type' => 'list',
            'default' => 'blocks',
            'values' => [
                'tiles' => GetMessage('universe.meta.settings.template_certificates.tiles'),
                'list' => GetMessage('universe.meta.settings.template_certificates.list')
            ]
        ],
        'template_contacts' => [
            'name' => GetMessage('universe.meta.settings.template_contacts'),
            'type' => 'list',
            'default' => 'without_representation_and_magazines',
            'values' => [
                'none' => GetMessage('universe.meta.settings.template_contacts.none'),
                'shops' => GetMessage('universe.meta.settings.template_contacts.shops'),
                'offices' => GetMessage('universe.meta.settings.template_contacts.offices')
            ]
        ],
        'template_footer' => [
            'name' => GetMessage('universe.meta.settings.template_footer'),
            'type' => 'list',
            'default' => 1,
            'values' => [
                1 => GetMessage('universe.meta.settings.template_footer.1'),
                2 => GetMessage('universe.meta.settings.template_footer.2'),
                3 => GetMessage('universe.meta.settings.template_footer.3'),
                4 => GetMessage('universe.meta.settings.template_footer.4'),
                5 => GetMessage('universe.meta.settings.template_footer.5')
            ]
        ],
        'footer_show_feedback' => [
            'name' => GetMessage('universe.meta.settings.footer_show_feedback'),
            'type' => 'boolean',
            'default' => false
        ],
        'footer_theme' => [
            'name' => GetMessage('universe.meta.settings.footer_theme'),
            'type' => 'list',
            'default' => 'light',
            'values' => [
                'light' => GetMessage('universe.meta.settings.footer_theme.light'),
                'dark' => GetMessage('universe.meta.settings.footer_theme.dark')
            ]
        ],
        'template_header' => [
            'name' => GetMessage('universe.meta.settings.template_header'),
            'type' => 'list',
            'default' => 1,
            'values' => [
                2 => GetMessage('universe.meta.settings.template_header.2'),
                1 => GetMessage('universe.meta.settings.template_header.1')
            ]
        ],
        'template_main_page' => [
            'name' => GetMessage('universe.meta.settings.template_main_page'),
            'type' => 'list',
            'default' => 'wide',
            'values' => [
                'wide' => GetMessage('universe.meta.settings.template_main_page.wide'),
                'two_columns' => GetMessage('universe.meta.settings.template_main_page.two_columns')
            ]
        ],
        'template_menu' => [
            'name' => GetMessage('universe.meta.settings.template_menu'),
            'type' => 'list',
            'default' => 1,
            'values' => [
                1 => GetMessage('universe.meta.settings.template_menu.1'),
                2 => GetMessage('universe.meta.settings.template_menu.2'),
                3 => GetMessage('universe.meta.settings.template_menu.3'),
                4 => GetMessage('universe.meta.settings.template_menu.4'),
                5 => GetMessage('universe.meta.settings.template_menu.5'),
                6 => GetMessage('universe.meta.settings.template_menu.6'),
                7 => GetMessage('universe.meta.settings.template_menu.7'),
                8 => GetMessage('universe.meta.settings.template_menu.8'),
                9 => GetMessage('universe.meta.settings.template_menu.9'),
                10 => GetMessage('universe.meta.settings.template_menu.10'),
                11 => GetMessage('universe.meta.settings.template_menu.11'),
                12 => GetMessage('universe.meta.settings.template_menu.12')
            ]
        ],
        'use_fixed_mobile_header' => [
            'name' => GetMessage('universe.meta.settings.use_fixed_mobile_header'),
            'type' => 'boolean',
            'default' => true
        ],
        'use_fixed_header' => [
            'name' => GetMessage('universe.meta.settings.use_fixed_header'),
            'type' => 'boolean',
            'default' => true
        ],
        /*'template_menu_inner' => [
            'name' => GetMessage('universe.meta.settings.template_menu_inner'),
            'type' => 'list',
            'default' => 'left',
            'values' => [
                'left' => GetMessage('universe.meta.settings.template_menu_inner.left'),
                'right' => GetMessage('universe.meta.settings.template_menu_inner.right')
            ]
        ],*/
        'template_mobile_blog' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_blog'),
            'type' => 'list',
            'default' => 'tiles',
            'values' => [
                'tiles' => GetMessage('universe.meta.settings.template_mobile_blog.tiles'),
                'under_other' => GetMessage('universe.meta.settings.template_mobile_blog.under_other')
            ]
        ],
        'template_mobile_catalog' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_catalog'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'tiles' => GetMessage('universe.meta.settings.template_mobile_catalog.tiles'),
                'list' => GetMessage('universe.meta.settings.template_mobile_catalog.list')
            ]
        ],
        'template_mobile_catalog_sections' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_catalog_sections'),
            'type' => 'list',
            'default' => 'tiles',
            'values' => [
                'tiles' => GetMessage('universe.meta.settings.template_mobile_catalog_sections.tiles'),
                'under_other' => GetMessage('universe.meta.settings.template_mobile_catalog_sections.under_other')
            ]
        ],
        'template_mobile_collections' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_collections'),
            'type' => 'list',
            'default' => 'tiles',
            'values' => [
                'tiles' => GetMessage('universe.meta.settings.template_mobile_collections.tiles'),
                'slider' => GetMessage('universe.meta.settings.template_mobile_collections.slider')
            ]
        ],
        'template_mobile_header' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_header'),
            'type' => 'list',
            'default' => 'white',
            'values' => [
                'white' => GetMessage('universe.meta.settings.template_mobile_header.white'),
                'colored' => GetMessage('universe.meta.settings.template_mobile_header.colored'),
                'white_with_icons' => GetMessage('universe.meta.settings.template_mobile_header.white_with_icons'),
                'colored_with_icons' => GetMessage('universe.meta.settings.template_mobile_header.colored_with_icons')
            ]
        ],
        'template_fixed_header' => [
            'name' => GetMessage('universe.meta.settings.template_fixed_menu'),
            'type' => 'list',
            'default' => 1,
            'values' => [
                1 => GetMessage('universe.meta.settings.template_fixed_header.1'),
                2 => GetMessage('universe.meta.settings.template_fixed_header.2'),
                3 => GetMessage('universe.meta.settings.template_fixed_header.3')
            ]
        ],
        /*'template_mobile_menu_show' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_menu_show'),
            'type' => 'list',
            'default' => 'from_left',
            'values' => [
                'from_top' => GetMessage('universe.meta.settings.template_mobile_menu_show.from_top'),
                'from_left' => GetMessage('universe.meta.settings.template_mobile_menu_show.from_left')
            ]
        ],*/
        'template_mobile_products' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_products'),
            'type' => 'list',
            'default' => 'tiles',
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_mobile_products.default'),
                'deployed' => GetMessage('universe.meta.settings.template_mobile_products.deployed'),
                #'list' => GetMessage('universe.meta.settings.template_mobile_products.list')
            ]
        ],
        'template_mobile_services' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_services'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_mobile_services.default'),
                'tile' => GetMessage('universe.meta.settings.template_mobile_services.tile'),
                'tile_slider' => GetMessage('universe.meta.settings.template_mobile_services.tile_slider'),
                'minimal' => GetMessage('universe.meta.settings.template_mobile_services.minimal'),
                'blocks' => GetMessage('universe.meta.settings.template_mobile_services.blocks'),
                'small_blocks' => GetMessage('universe.meta.settings.template_mobile_services.small_blocks')
                /*'under_other' => GetMessage('universe.meta.settings.template_mobile_services.under_other'),
                'slider' => GetMessage('universe.meta.settings.template_mobile_services.slider')*/
            ]
        ],
        'template_news_section' => [
            'name' => GetMessage('universe.meta.settings.template_news_section'),
            'type' => 'list',
            'default' => 'list',
            'values' => [
                'blocks' => GetMessage('universe.meta.settings.template_news_section.blocks'),
                'list' => GetMessage('universe.meta.settings.template_news_section.list'),
                'tiles' => GetMessage('universe.meta.settings.template_news_section.tiles')
            ]
        ],
        'template_news' => [
            'name' => GetMessage('universe.meta.settings.template_news'),
            'type' => 'list',
            'default' => 'default',
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_news.default'),
                'extend' => GetMessage('universe.meta.settings.template_news.extend'),
                'tiles' => GetMessage('universe.meta.settings.template_news.tiles')
            ]
        ],
        'template_mobile_news' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_news'),
            'type' => 'list',
            'default' => 'default',
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_mobile_news.default'),
                'extend' => GetMessage('universe.meta.settings.template_mobile_news.extend')
            ]
        ],
        'template_product_catalog' => [
            'name' => GetMessage('universe.meta.settings.template_product_catalog'),
            'type' => 'list',
            'default' => 1,
            'values' => [
                1 => GetMessage('universe.meta.settings.template_product_catalog.1'),
                2 => GetMessage('universe.meta.settings.template_product_catalog.2'),
                3 => GetMessage('universe.meta.settings.template_product_catalog.3'),
                4 => GetMessage('universe.meta.settings.template_product_catalog.4'),
                5 => GetMessage('universe.meta.settings.template_product_catalog.5'),
                6 => GetMessage('universe.meta.settings.template_product_catalog.6'),
                7 => GetMessage('universe.meta.settings.template_product_catalog.7')
            ]
        ],
        'template_search' => [
            'name' => GetMessage('universe.meta.settings.template_search'),
            'type' => 'list',
            'default' => null,
            'values' => [
                3 => GetMessage('universe.meta.settings.template_search.3'),
                1 => GetMessage('universe.meta.settings.template_search.1'),
                2 => GetMessage('universe.meta.settings.template_search.2')
            ]
        ],
        'template_services_catalog' => [
            'name' => GetMessage('universe.meta.settings.template_services_catalog'),
            'type' => 'list',
            'default' => 'default',
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_services_catalog.default'),
                'blocks' => GetMessage('universe.meta.settings.template_services_catalog.blocks'),
                'tile' => GetMessage('universe.meta.settings.template_services_catalog.tile'),
                'minimal' => GetMessage('universe.meta.settings.template_services_catalog.minimal'),
                'small_blocks' => GetMessage('universe.meta.settings.template_services_catalog.small_blocks')
            ]
        ],
        'template_services_root' => [
            'name' => GetMessage('universe.meta.settings.template_services_root'),
            'type' => 'list',
            'default' => 'default',
            'values' => [
                1 => GetMessage('universe.meta.settings.template_services_root.1'),
                2 => GetMessage('universe.meta.settings.template_services_root.2'),
                3 => GetMessage('universe.meta.settings.template_services_root.3'),
                4 => GetMessage('universe.meta.settings.template_services_root.4'),
                5 => GetMessage('universe.meta.settings.template_services_root.5'),
                6 => GetMessage('universe.meta.settings.template_services_root.6'),
                7 => GetMessage('universe.meta.settings.template_services_root.7'),
                8 => GetMessage('universe.meta.settings.template_services_root.8'),
                9 => GetMessage('universe.meta.settings.template_services_root.9'),
                10 => GetMessage('universe.meta.settings.template_services_root.10')
            ]
        ],
        'template_services_section' => [
            'name' => GetMessage('universe.meta.settings.template_services_section'),
            'type' => 'list',
            'default' => 'default',
            'values' => [
                1 => GetMessage('universe.meta.settings.template_services_section.1'),
                2 => GetMessage('universe.meta.settings.template_services_section.2'),
                3 => GetMessage('universe.meta.settings.template_services_section.3'),
                4 => GetMessage('universe.meta.settings.template_services_section.4'),
                5 => GetMessage('universe.meta.settings.template_services_section.5'),
                6 => GetMessage('universe.meta.settings.template_services_section.6'),
                7 => GetMessage('universe.meta.settings.template_services_section.7'),
                8 => GetMessage('universe.meta.settings.template_services_section.8'),
                9 => GetMessage('universe.meta.settings.template_services_section.9'),
                10 => GetMessage('universe.meta.settings.template_services_section.10')
            ]
        ],
        'template_service_page' => [
            'name' => GetMessage('universe.meta.settings.template_service_page'),
            'type' => 'list',
            'default' => 'big_images',
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_service_page.default'),
                'big_image' => GetMessage('universe.meta.settings.template_service_page.big_image'),
                'small_image' => GetMessage('universe.meta.settings.template_service_page.small_image'),
                'without_text' => GetMessage('universe.meta.settings.template_service_page.without_text'),
                'without_price_and_button' => GetMessage('universe.meta.settings.template_service_page.without_price_and_button'),
            ]
        ],
        'template_title_and_breadcrumbs' => [
            'name' => GetMessage('universe.meta.settings.template_title_and_breadcrumbs'),
            'type' => 'list',
            'default' => null,
            'values' => [
                1 => GetMessage('universe.meta.settings.template_title_and_breadcrumbs.1'),
                2 => GetMessage('universe.meta.settings.template_title_and_breadcrumbs.2')
            ]
        ],
        'template_reviews' => [
            'name' => GetMessage('universe.meta.settings.template_reviews'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_reviews_default'),
                'slider' => GetMessage('universe.meta.settings.template_reviews_slider'),
                'blocks_1' => GetMessage('universe.meta.settings.template_reviews_blocks_1'),
                'blocks_2' => GetMessage('universe.meta.settings.template_reviews_blocks_2')
            ]
        ],
        'template_mobile_reviews' => [
            'name' => GetMessage('universe.meta.settings.template_mobile_reviews'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_mobile_reviews_default'),
                'slider' => GetMessage('universe.meta.settings.template_mobile_reviews_slider'),
                'blocks_1' => GetMessage('universe.meta.settings.template_mobile_reviews_blocks_1'),
                'blocks_2' => GetMessage('universe.meta.settings.template_mobile_reviews_blocks_2')
            ]
        ],
        'template_rubrics' => [
            'name' => GetMessage('universe.meta.settings.template_rubrics'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'chess' => GetMessage('universe.meta.settings.template_rubrics_chess'),
                'puzzle' => GetMessage('universe.meta.settings.template_rubrics_puzzle'),
                'tiles' => GetMessage('universe.meta.settings.template_rubrics_tiles')
            ]
        ],
        'template_categories' => [
            'name' => GetMessage('universe.meta.settings.template_categories'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'list' => GetMessage('universe.meta.settings.template_categories_list'),
                'tiles' => GetMessage('universe.meta.settings.template_categories_tiles')
            ]
        ],
        'template_banner' => [
            'name' => GetMessage('universe.meta.settings.template_banner'),
            'type' => 'list',
            'default' => null,
            'values' => [
                1 => GetMessage('universe.meta.settings.template_banner.1'),
                2 => GetMessage('universe.meta.settings.template_banner.2'),
                3 => GetMessage('universe.meta.settings.template_banner.3'),
                4 => GetMessage('universe.meta.settings.template_banner.4'),
                5 => GetMessage('universe.meta.settings.template_banner.5')
            ]
        ],
        /*'use_offer_title' => [
            'name' => GetMessage('universe.meta.settings.use_offer_title'),
            'type' => 'boolean',
            'default' => true
        ],
        'use_product_sum' => [
            'name' => GetMessage('universe.meta.settings.use_product_sum'),
            'type' => 'boolean',
            'default' => true
        ],
        'use_quick_view_in_basket' => [
            'name' => GetMessage('universe.meta.settings.use_quick_view_in_basket'),
            'type' => 'boolean',
            'default' => true
        ],
        'use_quick_view_in_catalog' => [
            'name' => GetMessage('universe.meta.settings.use_quick_view_in_catalog'),
            'type' => 'boolean',
            'default' => true
        ],*/
        'menu_display_in' => [
            'name' => GetMessage('universe.meta.settings.menu_display_in'),
            'type' => 'custom'
        ],
        'main_blocks' => [
            'type' => 'custom',
        ],
        'fixed_header' => [
            'type' => 'c'
        ],
        /*'use_regionality' => [
            'name' => GetMessage('universe.meta.settings.use_regionality'),
            'type' => 'boolean'
        ],
        'use_regionality_on' => [
            'name' => GetMessage('universe.meta.settings.use_regionality_on'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'one_domain' => GetMessage('universe.meta.settings.use_regionality_on.one_domain'),
                'sub_domains' => GetMessage('universe.meta.settings.use_regionality_on.sub_domains')
            ]
        ],
        'view_regions' => [
            'name' => GetMessage('universe.meta.settings.view_regions'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'drop_list' => GetMessage('universe.meta.settings.view_regions.drop_list'),
                'modal_with_regions' => GetMessage('universe.meta.settings.view_regions.modal_with_regions'),
                'modal_with_cities' => GetMessage('universe.meta.settings.view_regions.modal_with_cities')
            ]
        ],
        'basket_type' => [
            'name' => GetMessage('universe.meta.settings.basket_type'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'header' => GetMessage('universe.meta.settings.basket_type.header'),
                'flying' => GetMessage('universe.meta.settings.basket_type.flying'),
                'footer' => GetMessage('universe.meta.settings.basket_type.footer'),
            ]
        ],
        'basket_color' => [
            'name' => GetMessage('universe.meta.settings.basket_color'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'dark' => GetMessage('universe.meta.settings.basket_color.dark'),
                'site_color' => GetMessage('universe.meta.settings.basket_color.site_color'),
                'white' => GetMessage('universe.meta.settings.basket_color.white'),
            ]
        ],*/
        'font_family' => [
            'name' => GetMessage('universe.meta.settings.font_family'),
            'type' => 'list',
            'default' => 'P22 underground',
            'values' => [
                'P22 underground' => 'P22 Underground',
                'Open Sans' => 'Open Sans',
                'Roboto' => 'Roboto',
                'PT Sans' => 'PT Sans'
            ]
        ],
        'template_articles' => [
            'name' => GetMessage('universe.meta.settings.template_articles'),
            'type' => 'list',
            'default' => null,
            'values' => [
                'default' => GetMessage('universe.meta.settings.template_articles.default'),
                'with_big_block' => GetMessage('universe.meta.settings.template_articles.with_big_block'),
            ]
        ],
        'use_global_settings' => [
            'name' => GetMessage('universe.meta.settings.use_global_settings'),
            'type' => 'boolean',
            'default' => true
        ]
    ]
];