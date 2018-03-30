<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<?$frame = $this->createFrame()->begin()?>
	<?if (!empty($arResult)):?>
        <div class="owl-carousel carusel-products owl-theme">
            <?foreach($arResult['ITEMS'] as $arItem):?>
                <div class="view-item clearfix">
                    <div class="clearfix" style="padding:18px 13px">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"
                           class="left_block"
                           style="background-image:url('<?=$arItem['PREVIEW_PICTURE']["SRC"]?>')">
                        </a>
                        <div class="right_block">
                            <a class="name"
                               href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                                <?=TruncateText($arItem["NAME"],30)?>
                            </a>
                            <div class="price">
                                <?=number_format($arItem["PROPERTIES"][$arParams["NAME_PROP_PRICE"]]["VALUE"], 0, '', ' ');?> <?=GetMessage("RUB");?>
                            </div>
                        </div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
        <script>
            $(document).ready(function() {
                var owl = $('.carusel-products');
                owl.owlCarousel({
                    margin: 10,
                    navRewind: false,
                    nav:false,
                    dots:true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 3
                        },
                        1000: {
                            items: 4
                        }
                    }
                })
            })
        </script>
	<?endif;?>
<?$frame->end();?>