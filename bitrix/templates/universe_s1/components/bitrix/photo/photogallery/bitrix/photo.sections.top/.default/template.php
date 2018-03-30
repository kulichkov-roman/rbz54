<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
?>
<div class="photo-sections-top">
    <?foreach($arResult["SECTIONS"] as $arSection):?>
        <?
        $this->AddEditAction('section_'.$arSection['ID'], $arSection['ADD_ELEMENT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "ELEMENT_ADD"), array('ICON' => 'bx-context-toolbar-create-icon'));
        $this->AddEditAction('section_'.$arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
        $this->AddDeleteAction('section_'.$arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_SECTION_DELETE_CONFIRM')));
        ?>
        <?$path_picture = CFile::GetPath($arSection["PICTURE"]);?>
        <div class="photo-sections-top-item">
            <div class="photo-sections-top-item-wrapper" id="<?=$this->GetEditAreaId('section_'.$arSection['ID']);?>">
                 <div class="photo-sections-top-item-wrapper-content" style="background-image: url('<?=$path_picture?>');">
                    <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="photo-sections-top-item-blackout"></a>
                    <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="intec-button intec-button-cl-default  photo-sections-top-item-button-default intec-button intec-button-fs-16"><?=$arSection['NAME'];?></a>
                    <a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="intec-button intec-button-cl-common photo-sections-top-item-button-hover intec-button intec-button-fs-16"><?=$arSection['NAME'];?></a>
                    <?if(is_array($arSection['ITEMS'])):?>
                        <div class="photo-sections-top-item-wrapper-count-information"><i class="glyph-icon-landscape"></i><span><?= count($arSection['ITEMS'])?></span></div>
                    <?endif;?>
                 </div>
            </div>
        </div>
    <?endforeach?>
    <div style="clear:both"></div>
</div>
