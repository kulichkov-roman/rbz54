<div class="gallery-section">
    <div class="service-caption"><?=GetMessage("SRVICE_CAPTION_GALLERY");?></div>
    <div class="owl-carousel owl-theme owl-carusel-gallery light-gallery">
        <?foreach ($arData['GALLERY']['VALUE'] as $arElement):?>
            <?$gall_picture = CFile::GetPath($arElement);?>
            <div class="item" data-src="<?=$gall_picture?>">
                <a class="picturelist-slider-image" href="<?=$gall_picture?>" style="background-image:url(<?=$gall_picture?>)">
                    <img src="<?=$gall_picture?>" style="display:none"/>
                </a>
            </div>
        <?endforeach;?>
    </div>
    <script>
        $(document).ready(function() {
            $(".light-gallery").lightGallery({
                selector: '.item'
            });
            var owl = $('.owl-carusel-gallery');
            owl.owlCarousel({
                loop: false,
                margin: 0,
                navRewind: false,
                nav:true,
                navText: ["",""],
                responsive: {
                    0: {
                        items: 2
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                },
            })
        })
    </script>
</div>