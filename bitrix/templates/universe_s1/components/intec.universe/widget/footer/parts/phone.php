<?
$configuration = \Bitrix\Main\Config\Configuration::getInstance();
$arParams["FOOTER_PHONE"] = $configuration->get('phoneNumber');

if($arParams["FOOTER_PHONE"]){
    ?>
    <div class="phone">
        <i class="glyph-icon-phone"></i>
        <a href="tel:<?=$arParams["FOOTER_PHONE"];?>"><?=$arParams["FOOTER_PHONE"];?></a>
    </div>
<?}?>