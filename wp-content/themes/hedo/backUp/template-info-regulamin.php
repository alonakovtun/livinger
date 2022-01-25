<?php /* Template Name: Regulaminy page */
get_header(); ?>

    <main class="main information">
        <!-- menu -->
        <?php get_template_part('template-parts/menu-for-information-pages'); ?>
        <div class="information__container">
            <section class="wysylka">
                <div class="wysylka__container">
                    <div class="wysylka__content">
                        <?= get_field('regulaminy') ?>
                    </div>
                </div>
            </section>
        </div>
    </main>

<?php get_footer(); ?>