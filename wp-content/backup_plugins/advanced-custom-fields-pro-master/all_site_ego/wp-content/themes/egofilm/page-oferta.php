<?
/* Template Name: Oferta */

get_header(); ?>


<main class="oferta_content">
	<? $acf_top = get_field('oferta_top'); ?>
	<h1 class="content_ttl a--hd-1"><?= $acf_top['title']; ?></h1>
	<p class="content_tgl a--ex-tgl"><?= $acf_top['tagline']; ?></p>

	<?
	if( have_rows('oferta_content') ):
		while ( have_rows('oferta_content') ) : the_row(); ?>



		<section class="oferta_text a--txt-ctr">
			<?= the_sub_field('oferta_text-1'); ?>
		</section>

		<ul class="b-gallery row">
			<? if( have_rows('oferta_gallery') ):
				while ( have_rows('oferta_gallery') ) : the_row(); ?>

					<li class="gallery_unit col-sm-12 col-md-6" data-groups='["one"]'>
						<div class="unit_img-wrap">
							<a href="<? the_sub_field('entry'); ?>" data-fancybox="gallery">
								<div class="unit_img a--all-ctr" style="
									background: url(<? the_sub_field('entry'); ?>) no-repeat center center/cover;
								"> </div>
							</a>
						</div>
					</li>

				<? endwhile;
			endif; ?>
		</ul>

		<section class="oferta_text a--txt-ctr">
			<?= the_sub_field('oferta_text-2'); ?>
		</section>

		<div class="b-slider" id="offer_slider">
			<?
			if( have_rows('oferta_img-block') ):
				while ( have_rows('oferta_img-block') ) : the_row(); ?>

					<img src="<? the_sub_field('entry'); ?>" alt="">

				<? endwhile;
			endif;
			?>
		</div>

		<section class="oferta_text a--txt-ctr">
			<?= the_sub_field('oferta_text-3'); ?>
		</section>




		<? endwhile;
	endif;
	?>


</main>


<? get_footer();