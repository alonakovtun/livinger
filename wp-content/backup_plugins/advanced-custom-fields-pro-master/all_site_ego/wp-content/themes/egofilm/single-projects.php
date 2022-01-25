<? get_header(); ?>

<div class="p-project">

	<div class="b-bunner">
		<? the_field('project_bunner-1'); ?>
		<div class="bunner_sound">
			<!-- <img class="sound_img" src="<? // get_template_directory_uri(); ?>/custom/img/icon-sound.svg" alt=""> -->
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 15h-3v-6h3v6zm6 3l-5-3v-6l5-3v12z"/></svg>
		</div>
	</div>

	<div class="project_main-txt-block a--txt-nrrw col-sm-12 col-md-6 offset-md-3">
		<?
		$project_cats = get_the_category();
		?>
		<h1 class="project_title a--hd-1 a--mb-lg"><? the_field('project_title'); ?></h1>
		<p class="project_tagline a--txt-md a--mb-lg">
			<a href="<?= get_home_url() . '?category=' . $project_cats[0]->term_id; ?>"><?= $project_cats[0]->name; ?></a>
		</p>

		<? the_field('project_txt-1'); ?>
	</div>

	<div class="b-bunner">
		<? the_field('project_bunner-2'); ?>
		<div class="bunner_sound">
			<!-- <img class="sound_img" src="<? // get_template_directory_uri(); ?>/custom/img/icon-sound.svg" alt=""> -->
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 15h-3v-6h3v6zm6 3l-5-3v-6l5-3v12z"/></svg>
		</div>
	</div>

	<div class="a--txt-nrrw a--txt-jstf col-sm-12 col-md-6 offset-md-3">
		<? the_field('project_txt-2'); ?>
	</div>

	<ul class="b-gallery row">
		<? if( have_rows('project_gallery') ):
			while ( have_rows('project_gallery') ) : the_row(); ?>

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

	<div class="a--txt-nrrw a--txt-jstf a--txt-upc-in col-sm-12 col-md-6 offset-md-3 project_authors">
		<? the_field('project_txt-3'); ?>
	</div>
	<?
	$acf_bottom_link = get_field('project_bottom-link');
	?>
	<a href="<?= $acf_bottom_link['link_address']; ?>" class="project_link a--btn-bld"><?= $acf_bottom_link['title']; ?></a>

	<section class="s-pagination a--mb-lg a--txt-lite-in">
		<div class="btn-pag-left">
		<? if (strlen(get_previous_post()->post_title) == 0) { ?>

			<?
			$last_project_custom_taxterms = wp_get_object_terms( $post->ID, 'category', array('fields' => 'ids') );

			// arguments
			$last_project_args = array(
				'post_type' => 'projects',
				'post_status' => 'publish',
				'posts_per_page' => 1,
				'order' => 'DESC',
				// 'orderby' => 'rand',
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field' => 'id',
						'terms' => $last_project_custom_taxterms
					)
				),
				'post__not_in' => array ($post->ID),
			);

			$last_project = new WP_Query( $last_project_args );
			?>

			<? while ( $last_project->have_posts() ) : $last_project->the_post(); ?>

				<?
				$last_project_cats = get_the_category();
				?>

				<a href="<? the_permalink(); ?>">Poprzedni projekt</a>

			<? endwhile; wp_reset_query(); ?>

		<? } else { ?>
			<? previous_post_link( '%link', 'Poprzedni projekt' ); ?>
		<? } ?>
		</div>

		<ul class="b-social-sharing a--txt-ctr">
			<li class="social-sharing_unit" id="sharing-custom">
				Udostępnij ten projekt
			</li>
			<li class="social-sharing_unit" id="sharing-facebook">
				Facebook
				<?= do_shortcode('[addtoany buttons="facebook"]'); ?>
			</li>
			<li class="social-sharing_unit" id="sharing-twitter">
				Twitter
				<?= do_shortcode('[addtoany buttons="twitter"]'); ?>
			</li>
			<li class="social-sharing_unit" id="sharing-pinterest">
				Pinterest
				<?= do_shortcode('[addtoany buttons="pinterest"]'); ?>
			</li>
		</ul>
		
		<div class="b-social-sharing-hidden" style="">
			<? // do_shortcode('[addtoany]'); ?>
		</div>

		<div class="btn-pag-right">
			<? if (strlen(get_next_post()->post_title) == 0) { ?>

				<?
				$last_project_custom_taxterms = wp_get_object_terms( $post->ID, 'category', array('fields' => 'ids') );

				// arguments
				$last_project_args = array(
					'post_type' => 'projects',
					'post_status' => 'publish',
					'posts_per_page' => 1,
					// 'orderby' => 'rand',
					'tax_query' => array(
						array(
							'taxonomy' => 'category',
							'field' => 'id',
							'terms' => $last_project_custom_taxterms
						)
					),
					'post__not_in' => array ($post->ID),
				);

				$last_project = new WP_Query( $last_project_args );
				?>

				<? while ( $last_project->have_posts() ) : $last_project->the_post(); ?>

					<?
					$last_project_cats = get_the_category();
					?>

					<a href="<? the_permalink(); ?>">Następny projekt</a>

				<? endwhile; wp_reset_query(); ?>



			<? } else { ?>

				<? next_post_link( '%link', 'Następny projekt' ); ?>

			<? } ?>
		</div>
	</section>


	<section class="project_related-prod">
		<h2 class="a--hd-1 a--mb-sm"><?= __('Podobne projekty', 'egofilm'); ?></h2>
		<ul class="b-gallery row" id="gallery-related">

			<?
			$custom_taxterms = wp_get_object_terms( $post->ID, 'category', array('fields' => 'ids') );

			// arguments
			$args = array(
				'post_type' => 'projects',
				'post_status' => 'publish',
				'posts_per_page' => 4,
				'orderby' => 'rand',
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field' => 'id',
						'terms' => $custom_taxterms
					)
				),
				'post__not_in' => array ($post->ID),
			);

			$related_items = new WP_Query( $args );
			?>

			<? while ( $related_items->have_posts() ) : $related_items->the_post(); ?>

				<?
				$project_cats = get_the_category();
				?>

				<li class="gallery_unit col-sm-12 col-md-3" data-groups='["<?= $project_cats[0]->name; ?>"]'>
					<div class="unit_img-wrap a--flx-row-ctr">
						<a href="<? the_permalink(); ?>">
							<div class="unit_img a--all-ctr" style="
								background: url(<?= get_the_post_thumbnail_url() ?>) no-repeat center center/cover;
							"> </div>
						</a>
					</div>
					<h3 class="unit_title a--hd-3 disable"><a href="<? the_permalink(); ?>"><? the_title(); ?></a></h3>
					<p class="unit_cat">
						<a class="a--txt" href="<?= get_home_url() . '?category=' . $project_cats[0]->term_id; ?>"><?= $project_cats[0]->name; ?></a>
					</p>
				</li>

			<? endwhile; wp_reset_query(); ?>
		</ul>

	</section>

	<?
	$acf_project_link = get_field('project_bottom-link');
	?>


</div>

<? get_footer();