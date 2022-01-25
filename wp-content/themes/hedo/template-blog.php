<?php /* Template Name: Blog */
get_header(); ?>

<section class="blog">
    <h1 class="blog__title txt-center title-28 ff-ed wow fadeInUp" data-wow-delay="0.1s">Zainspruj się.</h1>
    <p class="blog__desc txt-16 txt-light c-black txt-center wow fadeInUp" data-wow-delay="0.3s">Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
        sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna </p>
    <div class="blog__list flex jc-space al-stretch">
        <?php
        $i = 1;
        $posts = get_posts(array(
            'numberposts' => -1,
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
            <div class="bestsellery__left wow fadeInUp news_block order-1 ml-15 mb-35" data-wow-delay="0.<?= $i > 10 ? $i = 1 : $i ?>s">
                <img class="bestsellery__shadow" src="<?php bloginfo('template_directory') ?>/assets/img/bestsellery-shadow.png" alt="shadow" />
                <a href="<?php the_permalink() ?>" class="bestsellery__image">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="images" />
                </a>

                <div class="bestsellery__bottom">
                    <p class="bestsellery__title title-80 wow fadeInUp" data-wow-delay="0.5s">
                        <?php the_title(); ?>
                    </p>
                    <a href="<?php the_permalink() ?>" class="button-link-24 mt-38 wow fadeInUp" data-wow-delay="0.5s">Czytaj dalej</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php get_footer(); ?>