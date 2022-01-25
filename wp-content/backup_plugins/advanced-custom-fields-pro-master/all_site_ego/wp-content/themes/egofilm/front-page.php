<? get_header(); ?>
<div class="egofilm-box">
  <div class="egofilm-box__container">
    <img class="egofilm-logo egofilm-box__logo container" src="//egofilm.puzzlestudio.eu/wp-content/themes/egofilm/custom/img/logotype.svg" alt="logo" />
  </div>
  <!-- <h1 class="egofilm-logo">EG<span class="egofilm-logo_lowercase">o</span>FILM</h1> -->
</div>
<ul class="product b-gallery row" id="gallery">
<?

  $wp_query = new WP_Query( array(
    'post_type' => 'projects',
    'posts_per_page' => -1,
    'cat' => 8,
    'orderby'=> 'title'
  ));
  ?>
  <?php if ( have_posts() ) : ?>
    <?php $i = 00.1; ?>
    <?php while ( have_posts() ) : the_post(); ?>

      <?
        $project_cats = get_the_category();
      ?>

      <li class="gallery_unit project_unit col-sm-12 col-md-6">
        <div class="about-project-item">
          <div class="video-start-page">
            <div class="video-start-page__header">
              <a href="#" class="video-start-page__close close-project close-li">close project</a>
              <div class="video-start-page__controller">
                <a href="#" class="video-start-page__close video-start-page__mute pause-li">
                  pause
                </a>
                <a href="#" class="video-start-page__close video-start-page__mute muted-li">unmute</a>
                <a href="#" class="video-start-page__close video-start-page__mute fullscreen-li">fullscreen</a>
              </div>
            </div>
            <div class="video-start-page__video">
            <img class="video-start-page__stub" src="<?= get_the_post_thumbnail_url() ?>" alt="<? the_sub_field('entry'); ?>" />
            <video class="video-banner__video" loop muted playisinline preload="metadata">
              <?php
              $file = get_field('video_project');
              if( $file ): ?>
                <source class="source" src="<?php echo $file; ?>" type="video/mp4">
              <?php endif; ?>
            </video>
            </div>
          </div>

          <div class="about-project-item__info">
            <div class="about-project-item__header">
              <div class="about-project-item__container container flex al-center jc-space">
                <div class="flex jc-start al-center">
                  <p class="about-project-item__name"><? the_title(); ?></p>
                  <p class="txt-defualt about-project-item_margin"><?= $project_cats[1]->name ?></p>
                  <p class="txt-defualt about-project-item_margin"><? the_field('year'); ?></p>
                </div>
                <p class="about-project-item__close-info txt-defualt info">info</p>
              </div>
            </div>
            <div class="about-project-item__description flex nowrap jc-space">
              <div class="about-project-item__description-txt flex-50 txt-28">
              <? the_field('project_txt-1'); ?>
              </div>
              <div class="about-project-item__description-info flex-50">
                <? the_field('project_txt-2'); ?>
              </div>
            </div>
            <div class="about-project-item__gallery flex jc-space">
              <? if( have_rows('project_gallery') ):
                while ( have_rows('project_gallery') ) : the_row(); ?>
                  <div class="gallery_unit col-sm-12 col-md-6" data-groups='["one"]'>
                    <div class="unit_img-wrap">
                      <a href="<? the_sub_field('entry'); ?>" data-fancybox="gallery">
                        <div class="unit_img a--all-ctr" style="
                          background: url(<? the_sub_field('entry'); ?>) no-repeat center center/cover;
                        ">
                        </div>
                      </a>
                    </div>
                  </div>
                  <? endwhile;
              endif; ?>
            </div>
          </div>
        </div>
        <div class="gallery__container">
          <div class="unit_img-wrap a--flx-row-ctr">
            <div class="project__link">
              <div class="unit_img a--all-ctr" style="
                background: url(<?= get_the_post_thumbnail_url() ?>) no-repeat center center/cover;
              ">
                <video class="video-hover" loop muted playisinline preload="metadata">
                  <?php
                  $file = get_field('video_project');
                  if( $file ): ?>
                    <source src="<?php echo $file; ?>" type="video/mp4">
                  <?php endif; ?>
                </video>
              </div>
              <div class="mobile mobile__photo">
              <?php
                $image = get_field('photo_mobile');
                if( !empty( $image ) ): ?>
                  <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_url($image['url']); ?>" />
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="unit-info container">
            <p class="txt-def unit-info__number">NO. <?php the_ID(); ?></p>
            <p class="unit_title a--hd-3 disable"><? the_title(); ?></p>
            <div class="unit_cat">
              <div class="a--txt" href="<?= get_home_url() . '?category=' . $project_cats[0]->term_id; ?>"><?= $project_cats[1]->name; ?></div>
            </div>
            <p class="txt-def unit-info__year"><? the_field('year'); ?></p>
          </div>
        </div>
      </li>
    <?php endwhile; ?>
  <?php endif; ?>

  <?php wp_reset_query(); // очищаем запрос?>

</ul>
  <? get_footer();