<?
/* Template Name: Career */

get_header(); ?>


<main class="praca career_content">
	<? $acf_top = get_field('career_top'); ?>

	<section class="praca__description s-txt-1 a--txt-ctr">
    <div class="praca__container container">
      <?
      the_field('career_top-text');

      $acf_email = get_field('career_email-block');
      ?>
    </div>
	</section>


	<section class="s-form">
		<ul>
		<? $formCounter = 1; ?>
		<? $formId      = array(
			"1" => 1403,
			"2" => 1404,
			"3" => 1405,
			"4" => 1406
		); ?>


		<? if( have_rows('career_form-block') ):
      $i = 1;
			while ( have_rows('career_form-block') ) : the_row(); ?>

			<li class="praca__trigger form_unit">
				<div class="praca__header unit_title a--txt-ctr container">
          <p class="praca__offer-txt praca__offer-number">no. o<?= $i++ ?></p>
          <div class="praca__name">
					  <? the_sub_field('nav_item_name'); ?>
          </div>
          <div class="praca__offer-description txt-1">
							<? the_sub_field('text_block_1'); ?>
						</div>
				</div>

				<div class="praca__details unit_drop">
          <div class="praca__details-header">
            <div class="praca__container container flex al-center jc-start">
              <p class="txt-default">close offer</p>
            </div>
          </div>
          <div class="praca__details-subheader">
            <div class="praca__header unit_title a--txt-ctr container">
              <p class="praca__offer-txt praca__offer-number">no. o2</p>
              <div class="praca__name">
                <? the_sub_field('nav_item_name'); ?>
              </div>
              <div class="praca__offer-description txt-1">
                  <? the_sub_field('text_block_1'); ?>
              </div>
            </div>
          </div>
          <div class="praca__details-list drop_txt a--txt-ctr">
            <div class="praca__details-list-container container flex jc-space">
              <div class="praca__details-list-box praca__details-txt txt-2">
                <? the_sub_field('text_block_2'); ?>
              </div>
              <div class="praca__details-list-box praca__details-txt txt-3">
                <? the_sub_field('text_block_3'); ?>
              </div>
            </div>
					</div>

					<div class="drop_form a--txt-ctr">
						<?= do_shortcode('[contact-form-7 id="'. $formId[$formCounter] .'" title="'. $formCounter .'" html_class="drop_form"]'); ?>

						<div class="form_submitted">
							<div class="submitted_txt">
								<p>Dziękujemy!</p>
								<p>Twoje zgłoszeni zostało wysłane.</p>
							</div>
						</div>
					</div>

					<div class="b-terms-accept">
						Zapoznałam/em się i akceptuję <a href="#">regulamin</a> i  <a href="#">politykę prywatności</a>
					</div>
				</div>
			</li>
			<? $formCounter = $formCounter+1; ?>

			<? endwhile;
		endif; ?>
		</ul>
	</section>


</main>


<? get_footer();