<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true)?>
<?
$arData = $arResult['DATA'];
$sCurrentElement = null;
$sTemplateId = spl_object_hash($this);
?>
<div class="service landing">
	<?include("parts/banner.php");?>
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<?if ($arData['DETAIL_TEXT']['SHOW']&&$arParams["TYPE_BANNER"]<4):?>
				<?if (!$arData['IMAGE']['SHOW']):?>
					<div class="detail_description_adaptiv">
				<?endif;?>
				<div class="detail_description">
					<div class="service-header-description">
						<div class="service-header-description-caption">
							<?=$arParams['ELEMENT_CAPTION_DESCRIPTION']?>
						</div>
						<div class="service-header-description-text">
							<?=$arData['DETAIL_TEXT']['VALUE']?>
						</div>
					</div>
				</div>
				<?if (!$arData['IMAGE']['SHOW']):?>
					</div>
				<?endif;?>
			<?endif;?>
			<?if($arParams["FEEDBACK"] == "Y"){?>
				<?include("parts/feedback.php");?>
			<?}?>
			<?if ($arData['GALLERY']['SHOW']):?>
				<?include('parts/gallery.php');?>
			<?endif;?>
			<?include('parts/properties.php');?>
			<?if ($arData['VIDEO']['SHOW'] && $arData['VIDEO']['VALUE']):?>
				<div class="section-video">
					<div class="service-caption" id="video"><?=$arParams['ELEMENT_CAPTION_VIDEO']?></div>
					<div class="service-section">
						<?$APPLICATION->IncludeComponent("intec.universe:iblock.elements", "video.slider.1", Array(
							   "ELEMENTS_ID" => $arData['VIDEO']['VALUE'],
							   "USE_DETAIL_PICTURE" => "N",
							   "USE_PREVIEW_PICTURE" => "N",
							   "SLIDER_ID" => "services-video-slider-".$arResult['ID'],
							   "NAME_PROP_URL_VIDEO" => $arParams["NAME_PROP_URL_VIDEO"]
							),
							$component
						);?>
					</div>
				</div>
			<?endif;?>
			<?if ($arData['PROJECTS']['SHOW'] && $arData["PROJECTS"]["VALUE"]):?>
				<div class="section-projects">
					<div class="service-caption" id="projects"><?=$arParams['ELEMENT_CAPTION_PROJECTS']?></div>
					<div class="service-section">
						<?$APPLICATION->IncludeComponent("intec.universe:iblock.elements", "tiles.projects", Array(
								"ELEMENTS_ID" => $arData["PROJECTS"]["VALUE"],
								"LINK_TO_ELEMENTS" => $arParams["PROJECTS_SECTION_URL"],
							),
							$component
						);?>
					</div>
				</div>
			<?endif;?>
			<?if ($arData['REVIEWS']['SHOW'] && $arData['REVIEWS']['VALUE']):?>
				<div class="block-review">
					<div class="service-caption" id="reviews"><?=$arParams['ELEMENT_CAPTION_REVIEWS']?></div>
					<div class="service-section">
						<?$APPLICATION->IncludeComponent("intec.universe:iblock.elements", "reviews.landing.1", Array(
								"ELEMENTS_ID" => $arData['REVIEWS']['VALUE'],
								"USE_LINK_TO_ELEMENTS" => "Y",
								"LINK_TO_ELEMENTS" => $arParams['REVIEWS_SECTION_URL'],
								"NAME_PROP_AUTOR_REVIEW" => $arParams["NAME_PROP_AUTOR_REVIEW"],
								"NAME_PROP_COMPANY_REVIEW" => $arParams["NAME_PROP_COMPANY_REVIEW"],

							),
							$component
						);?>
					</div>
				</div>
			<?endif;?>
			<?$sCurrentElement = $arData['REVIEWS']['ELEMENT'];?>
			<?if ($arData['SERVICES']['SHOW'] && $arData['SERVICES']['VALUE']):?>
				<div class="service-caption" id="services"><?=$arParams['ELEMENT_CAPTION_SERVICES']?></div>
				<div class="service-section">
					<?$APPLICATION->IncludeComponent("intec.universe:iblock.elements", "tiles.landing.3", Array(
							"ELEMENTS_ID" => $arData['SERVICES']['VALUE'],
							"LINK_TO_ELEMENTS" => "",
							"NAME_PROP_PRICE" => $arParams["NAME_PROP_PRICE"]
						),
						$component
					);?>
				</div>
			<?endif;?>
		</div>
	</div>
</div>