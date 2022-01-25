<?php /* Template Name: kontact */
get_header(); ?>

<main class="main contact">
    <section class="contact__container">
        <div class="flex jc-space al-stretch">
            <div class="clm-4 flex1">
                <?= the_field('contact_company') ?>
            </div>
            <div class="clm-4 flex1"><?= the_field('data_company') ?></div>
            <div class="clm-4 flex1"><?= the_field('contact_company_2') ?></div>
            <div class="clm-4 flex1"><?= the_field('contact_last_block') ?></div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
