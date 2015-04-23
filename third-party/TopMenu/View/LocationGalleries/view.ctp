
<div id="myCarousel" class="carousel slide">
    <?php if(!empty($gallery)){   ?>
      <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>    
    <?php $i = 0; ?>
    <?php foreach ($gallery as $g) { ?>

        <div class="carousel-inner">
            <?php if ($i == 0) { ?>
                <div class="item active">
                <?php } else { ?>
                 <div class="item">
                <?php } ?>
                    <?php $i++; ?>
                    <?php echo $this->Image->out($g['LocationGallery']['image'], '128x128'); ?>
                        <div class="carousel-caption">
                            <p class="lead">
                                <?php echo $g['LocationGallery']['caption']; ?>                  
                            </p>
                        </div>
                    </div>
            </div>
    <?php } ?>
        

<!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>
    <?php }else{ ?>
        <?php echo __('No gallery for this restaurant'); ?>
    <?php } ?>

</div>