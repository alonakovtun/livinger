<?
/* Template Name: Index */

get_header(); ?>
<main class="index-page">
  <div class="header_bottom a--flx-row-btv" id="header-bottom">
			<?
			$acf_filter_units = get_field('header_filter_titles', 8);
			?>

			<ul class="index-page__menu container b-nav a--btn-bld-in a--flx-row-btv" id="navigation">
				<li class="index-page__menu-item nav_unit disable" data-cat='4'>
					<a href="#"><?= $acf_filter_units['first'] ?></a>
				</li>
				<li class="index-page__menu-item nav_unit disable" data-cat='3'>
					<a href="#"><?= $acf_filter_units['second'] ?></a>
				</li>
				<li class="index-page__menu-item nav_unit disable" data-cat='5'>
					<a href="#"><?= $acf_filter_units['third'] ?></a>
				</li>
				<li class="index-page__menu-item nav_unit disable" data-cat='6'>
					<a href="#"><?= $acf_filter_units['fourth'] ?></a>
				</li>
				<li class="index-page__menu-item nav_unit disable" data-cat='0'>
					<a href="#" class="active"><?= $acf_filter_units['sixth'] ?></a>
				</li>
			</ul>
		</div>
  </div>

  <ul class="product b-gallery row" id="gallery">

    <?
    $post_cat = $_GET['category'];

    $query_args = array(
      'post_type' => 'projects',
      'posts_per_page' => 4,
    );

    if( strlen($post_cat) > 0 && $post_cat != 0 ) {
      $query_args['tax_query'] = array( array(
        'taxonomy' => 'category',
        'terms' => $post_cat
      )); ?>

      <script>
        jQuery(document).ready(function(){
          postCategory = <?= $post_cat ?>;
        });
      </script>

    <? }

    $the_query = new WP_Query( $query_args );

    eg_post_loop($the_query);
    ?>

  </ul>
  <div class="box">
    <div class="loader10"></div>
    <!-- <div class="loader" id="loader-4">
      <span></span>
      <span></span>
      <span></span>
    </div> -->
  </div>
    <div class="ajax-check" style="display: none;"></div>
</main>
<? get_footer();