<?php
/** @var array $photoList */
?>
<div class="slider-container">
    <div class="slider">
        <ul class="owl-carousel">
            <?php foreach ($photoList as $image) { ?>
                <li class="slider-item">
                    <span class="slider-image"
                          data-src="<?= $image ?>"
                          style="background-image: url('<?= $image ?>');"></span>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="slide-left"></div>
    <div class="slide-right"></div>
</div>