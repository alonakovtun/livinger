<?php /* Template Name: FAQ page */
get_header(); ?>

    <main class="main information">
        <?php get_template_part('template-parts/info-menu'); ?>
        <div class="information__container">
            <section class="wysylka faq">
                <?php if (have_rows('faq')) : ?>
                    <div class="accordion mw-mini db-auto">
                        <?php while (have_rows('faq')) : the_row();
                            $head = get_sub_field('faq_head');
                            $body = get_sub_field('faq_body');
                            ?>
                            <div class="accordion__element">
                                <div class="accordion__head">
                                    <p class="txt-18 lh-27 c-black-mini txt-light">
                                        <?= $head ?>
                                    </p>
                                </div>
                                <div class="accordion__body">
                                    <p class="txt-18 lh-27 c-gold txt-light">
                                        <?= $body ?>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

<?php get_footer(); ?>