<?php get_header(); ?>
    <section class="custom-blog">
        <div class="custom-blog__container">
            <div class="custom-blog__header">
                <h1 class="custom-blog__title title-40 txt-light txt-center wow fadeInUp" data-wow-delay="0.1s"><?php the_field('title') ?></h1>
                <p class="txt-36 txt-center txt-light c-gold-black txt-center wow fadeInUp" data-wow-delay="0.3s"><?php the_field('date') ?></p>
            </div>
            <div class="custom-blog__images flex jc-space al-stretch">
                <?php
                $trueOne = the_field('one__two_images');
                if ($trueOne) : ?>
                    <?php
                    $hero = get_field('image_left');
                    if ($hero) : ?>
                        <div class="custom-blog__item">
                            <div class="custom-blog__image wow fadeInRight" data-wow-delay="0.5s">
                                <img src="<?php echo esc_url($hero['image']['url']); ?>" alt="<?php echo esc_attr($hero['image']['alt']); ?>" />
                            </div>
                            <p class="custom-blog__name txt-20 txt-light c-gold-black txt-center wow fadeInUp" data-wow-delay="0.1s">
                                <?php echo $hero['name']; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    <?php
                    $hero = get_field('image_right');
                    if ($hero) : ?>
                        <div class="custom-blog__item">
                            <div class="custom-blog__image wow fadeInLeft">
                                <img src="<?php echo esc_url($hero['image']['url']); ?>" alt="<?php echo esc_attr($hero['image']['alt']); ?>" />
                            </div>
                            <p class="custom-blog__name txt-20 txt-light c-gold-black txt-center wow fadeInUp" data-wow-delay="0.5s">
                                <?php echo $hero['name']; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <?php
                    $fullImage = get_field('image');
                    if ($fullImage) : ?>
                        <div class="custom-blog__item custom-blog__item_full wow fadeInUp">
                            <div class="custom-blog__image">
                                <img src="<?php echo esc_url($fullImage['image']['url']); ?>" alt="<?php echo esc_attr($fullImage['image']['alt']); ?>" />
                            </div>
                            <p class="custom-blog__name txt-20 txt-light c-gold-black txt-center wow fadeInUp" data-wow-delay="0.3s">
                                <?php echo $fullImage['name']; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="custom-blog__description wow fadeInUp" data-wow-delay="0.2s">
                <?php the_field('textarea') ?>
            </div>
            <div class="custom-blog__images flex jc-space al-stretch">
                <?php
                $trueOne2 = get_field('two-images');
                if ($trueOne2) : ?>
                    <?php
                    $left = get_field('image_left_2');
                    if ($left) : ?>
                        <div class="custom-blog__item wow fadeInLeft">
                            <div class="custom-blog__image">
                                <img src="<?php echo esc_url($left['img']['url']); ?>" alt="<?php echo esc_attr($left['image']['alt']); ?>" />
                            </div>
                            <p class="custom-blog__name txt-20 txt-light c-gold-black txt-center wow fadeInUp" data-wow-delay="0.4s">
                                <?php echo $left['name']; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    <?php
                    $right = get_field('image_right_2');
                    if ($right) : ?>
                        <div class="custom-blog__item wow fadeInRight">
                            <div class="custom-blog__image">
                                <img src="<?php echo esc_url($right['img']['url']); ?>" alt="<?php echo esc_attr($right['image']['alt']); ?>" />
                            </div>
                            <p class="custom-blog__name txt-20 txt-light c-gold-black txt-center wow fadeInUp" data-wow-delay="0.4s">
                                <?php echo $right['name']; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <?php
                    $fullImage2 = get_field('images_2');
                    if ($fullImage2) : ?>
                        <div class="custom-blog__item custom-blog__item_full wow fadeInUp">
                            <div class="custom-blog__image custom-blog__image_full">
                                <img src="<?php echo esc_url($fullImage2['image']['url']); ?>" alt="<?php echo esc_attr($fullImage2['image']['alt']); ?>" />
                            </div>
                            <p class="custom-blog__name txt-20 txt-light c-gold-black txt-center wow fadeInUp" data-wow-delay="0.5s">
                                <?php echo $fullImage2['name']; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="custom-blog__footer wow fadeInUp" data-wow-delay="0.5s">
                <?php the_field('textarea_footer') ?>
            </div>
        </div>
    </section>
    <section class="blogs">
        <p class="catgory__title title-block txt-center txt-upper mtb-80 wow fadeInUp">polecane na blogu</p>
        <div class="flex js-space al-stretch">
            <?php
            $i = 1;
            $posts = get_posts(array(
                'numberposts' => 3,
                'category'    => 0,
                'orderby'     => 'date',
                'order'       => 'DESC',
                'include'     => array(),
                'exclude'     => array(),
                'post_type'   => 'blog',
                'suppress_filters' => true,
            ));
            foreach ($posts as $post) :
                setup_postdata($post);
                $i += 2;
                ?>
                <div class="bestsellery__left bestsellery__33 news_block order-1 ml-15 wow fadeInLeft" data-wow-delay="0.<?= $i > 10 ? $i = 1 : $i ?>s">
                    <img class="bestsellery__shadow" src="<?php bloginfo('template_directory') ?>/assets/img/mini-shadow.png" alt="shadow" />
                    <a href="<?php the_permalink() ?>" class="bestsellery__image">
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="images" />
                    </a>

                    <div class="bestsellery__bottom">
                        <p class="bestsellery__title title-30 c-white wow fadeInUp" data-wow-delay="0.4s">
                            <?php the_title(); ?>
                        </p>
                        <a href="<?php the_permalink() ?>" class="button-link-24 txt-light button-link-20 mt-38 wow fadeInUp" data-wow-delay="0.4s">Czytaj dalej</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php get_footer();
