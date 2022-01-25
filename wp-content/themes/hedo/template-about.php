<?php /* Template Name: About */
get_header(); ?>

<section class="about">
    <div class="about__container">
        <h1 class="about__title txt-center title-28 ff-ed"><?= get_field('title'); ?></h1>
        <div class="about__content">
            <?= get_field('text_area') ?>
        </div>
        <?php
        $file = get_field('video');
        if ($file) : ?>
            <div class="about__video">
                <span class="about__video-play"></span>
                <?php
                $image = get_field('zagluzhka');
                if (!empty($image)) : ?>
                    <img class="about__video-image" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                <?php endif; ?>
                <video class="video" autoplay loop muted playisinline preload="metadata">
                    <source src="<?php echo $file; ?>" type="video/mp4">
                </video>
            </div>

        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>