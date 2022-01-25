<?
/* Template Name: O nas */

get_header(); ?>

<main class="onas_content">

	<ul class="b-slider" id="onas-slider">
		<?
		if( have_rows('onas_bunner', 145) ):
			while ( have_rows('onas_bunner', 145) ) : the_row(); ?>
				<li class="slider_unit">
					<img src="<? the_sub_field('entry'); ?>" alt="">
				</li>
		<? endwhile;
		endif; ?>
	</ul>

	<!-- <section class="b-bunner a--mb-lg"> -->
		<? // the_field('onas_bunner'); ?>
		<!-- <div class="bunner_sound"> -->
			<!-- <img class="sound_img" src="<? // get_template_directory_uri(); ?>/custom/img/icon-sound.svg" alt=""> -->
		<!-- </div> -->
	<!-- </section> -->

	<section class="a--txt-ctr s-txt-1">
		<?
		$acf_txt_1 = get_field('onas_block_1');
		?>
		<h3 class="txt_ttl a--hd-1 a--ex-ttl">
			<?= $acf_txt_1['title']; ?>
		</h3>
		<p class="txt_tgl a--ex-tgl">
			<?= $acf_txt_1['tagline']; ?>
		</p>
		<div class="txt_content a--ex-cnt">
			<?= $acf_txt_1['content']; ?>
		</div>
	</section>

	<section class="a--txt-ctr s-txt-2">
		<?
		$acf_txt_2 = get_field('onas_block_2');
		?>
		<h3 class="txt_ttl a--hd-1 a--ex-ttl">
			<?= $acf_txt_2['title']; ?>
		</h3>
		<p class="txt_tgl a--ex-tgl">
			<?= $acf_txt_2['tagline']; ?>
		</p>
		<div class="txt_content a--ex-cnt">
			<?= $acf_txt_2['content']; ?>
		</div>
	</section>

	<section class="s-peaple-gallery">
		<ul>
			<?
			if( have_rows('onas_people-gallery') ):
				while ( have_rows('onas_people-gallery') ) : the_row(); ?>

					<li class="peaple-gallery_unit">
						<div class="unit_imgs">
							<?
							$cnt = 0;
							$entry_class = 'active';

							if( have_rows('images') ):
								while ( have_rows('images') ) : the_row();
									if( $cnt > 0 ) {
										$entry_class = 'disable';
									} ?>

									<img class="a--all-ctr <?= $entry_class; ?>" src="<?= the_sub_field('entry'); ?>" alt="">

									<? $cnt++;
								endwhile;
							endif;
							?>
						</div>
						<p class="unit_name"><? the_sub_field('name'); ?></p>
						<p class="unit_position"><? the_sub_field('position'); ?></p>
					</li>

				<? endwhile;
			endif;
			?>
		</ul>
	</section>



	<section class="a--txt-ctr s-txt-2">
		<?
		$acf_txt_2 = get_field('onas_block_3-1_directors');
		?>
		<h3 class="txt_ttl a--hd-1 a--ex-ttl">
			<?= $acf_txt_2['title']; ?>
		</h3>
		<p class="txt_tgl a--ex-tgl">
			<?= $acf_txt_2['tagline']; ?>
		</p>
		<div class="txt_content a--ex-cnt">
			<?= $acf_txt_2['content']; ?>
		</div>
	</section>

	<section class="s-peaple-gallery">
		<ul>
			<?
			if( have_rows('onas_people-gallery_directors') ):
				while ( have_rows('onas_people-gallery_directors') ) : the_row(); ?>

					<li class="peaple-gallery_unit">
						<div class="unit_imgs">
							<?
							$cnt = 0;
							$entry_class = 'active';

							if( have_rows('images') ):
								while ( have_rows('images') ) : the_row();
									if( $cnt > 0 ) {
										$entry_class = 'disable';
									} ?>

									<img class="a--all-ctr <?= $entry_class; ?>" src="<?= the_sub_field('entry'); ?>" alt="">

									<? $cnt++;
								endwhile;
							endif;
							?>
						</div>
						<p class="unit_name"><? the_sub_field('name'); ?></p>
						<p class="unit_position"><? the_sub_field('position'); ?></p>
					</li>

				<? endwhile;
			endif;
			?>
		</ul>
	</section>



	<section class="a--txt-ctr s-txt-3">
		<?
		$acf_txt_3 = get_field('onas_block_3');
		?>
		<h3 class="txt_ttl a--hd-1 a--ex-ttl">
			<?= $acf_txt_3['title']; ?>
		</h3>
		<p class="txt_tgl a--ex-tgl">
			<?= $acf_txt_3['tagline']; ?>
		</p>
		<div class="txt_content a--ex-cnt">
			<?= $acf_txt_3['content']; ?>
		</div>
	</section>

	<section class="a--txt-ctr s-txt-4">
		<?
		$acf_txt_4 = get_field('onas_block_4');
		?>
		<h3 class="txt_ttl a--ex-ttl">
			<?= $acf_txt_4['title']; ?>
		</h3>
		<div class="txt_content a--ex-cnt">
			<?= $acf_txt_4['content']; ?>
		</div>
	</section>

	<section class="s-footer-imgs">
		<ul>
			<?
			if ( have_rows('onas_footer-images') ):
				while ( have_rows('onas_footer-images') ) : the_row(); ?>

			        <li>
			        	<img src="<? the_sub_field('image'); ?>" alt="">
			        </li>

				<? endwhile;
			endif;
			?>
		</ul>
	</section>

</main>


<? get_footer();