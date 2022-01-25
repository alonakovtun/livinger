<?php /* Template Name: Odstąpienie od umowy page */
get_header(); ?>

<main class="main information">
  <!-- menu -->
  <?php get_template_part('template-parts/menu-for-information-pages'); ?>
  <div class="information__container">
    <section class="wysylka">
      <div class="wysylka__container">
        <h1 class="information__title txt-24 txt-upper txt-ligth c-black lh-22 txt-center"><?php the_field('title') ?></h1>
        <div class="wysylka__content">
          <?php the_field('content'); ?>
        </div>
      </div>
    </section>
  </div>
</main>

<?php get_footer(); ?>