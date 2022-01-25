<?

show_admin_bar(false);

register_nav_menus( array(
	'footer_social' => 'Footer Social'
));


/*
 * Hide Default Editor on Homepage
 */

add_action( 'admin_init', 'hide_editor' );
function hide_editor() {
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	if( !isset( $post_id ) ) return;

	$homepgname = get_the_title($post_id);
	if($homepgname == 'Home'){
		remove_post_type_support('page', 'editor');
	}
}


/* ===============================
 * AJAX
** =============================== */

function eg_post_loop($the_query){
  $i = 1;
	while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

		<?
		$project_cats = get_the_category();
		?>

    <li class="gallery_unit project_unit col-sm-12 col-md-6" data-link="<? the_permalink(); ?>" data-groups='["<?= $project_cats[0]->name; ?>"]'>
      <div class="about-project-item">
        <div class="video-start-page">
          <div class="video-start-page__header">
            <a href="#" class="video-start-page__close close-project close-li">close project</a>
            <div class="video-start-page__controller">
              <a href="#" class="video-start-page__close video-start-page__mute pause-li">
                pause
              </a>
              <a href="#" class="video-start-page__close video-start-page__mute muted-li">unmute</a>
              <a href="#" class="video-start-page__close video-start-page__mute fullscreen-li">fullscreen</a>
            </div>
          </div>
          <div class="video-start-page__video">
          <img class="video-start-page__stub" src="<?= get_the_post_thumbnail_url() ?>" alt="<? the_sub_field('entry'); ?>" />
          <video class="video-banner__video" loop muted playisinline preload="metadata">
            <?php
            $file = get_field('video_project');
            if( $file ): ?>
              <source class="source" src="<?php echo $file; ?>" type="video/mp4">
            <?php endif; ?>
          </video>
          </div>
        </div>

        <div class="about-project-item__info">
          <div class="about-project-item__header">
            <div class="about-project-item__container container flex al-center jc-space">
              <div class="flex jc-start al-center">
                <p class="about-project-item__name"><? the_title(); ?></p>
                <p class="txt-defualt about-project-item_margin"><?php echo ($project_cats[0]->name === 'Home') ? $project_cats[1]->name : $project_cats[0]->name; ?></p>
                <p class="txt-defualt about-project-item_margin"><? the_field('year'); ?></p>
              </div>
              <p class="about-project-item__close-info txt-defualt info">info</p>
            </div>
          </div>
          <div class="about-project-item__description flex nowrap jc-space">
            <div class="about-project-item__description-txt flex-50 txt-28">
            <? the_field('project_txt-1'); ?>
            </div>
            <div class="about-project-item__description-info flex-50">
              <? the_field('project_txt-2'); ?>
            </div>
          </div>
          <div class="about-project-item__gallery flex jc-space">
            <? if( have_rows('project_gallery') ):
              while ( have_rows('project_gallery') ) : the_row(); ?>
                <div class="gallery_unit col-sm-12 col-md-6" data-groups='["one"]'>
                  <div class="unit_img-wrap">
                    <a href="<? the_sub_field('entry'); ?>" data-fancybox="gallery">
                      <div class="unit_img a--all-ctr" style="
                        background: url(<? the_sub_field('entry'); ?>) no-repeat center center/cover;
                      ">
                      </div>
                    </a>
                  </div>
                </div>
                <? endwhile;
            endif; ?>
          </div>
        </div>
      </div>
      <div class="gallery__container">
        <div class="unit_img-wrap a--flx-row-ctr">
          <div class="project__link">
            <div class="unit_img a--all-ctr" style="
              background: url(<?= get_the_post_thumbnail_url() ?>) no-repeat center center/cover;
            ">
              <video class="video-hover" loop muted playisinline preload="metadata">
                <?php
                $file = get_field('video_project');
                if( $file ): ?>
                  <source src="<?php echo $file; ?>" type="video/mp4">
                <?php endif; ?>
              </video>
            </div>
            <div class="mobile mobile__photo">
            <?php
              $image = get_field('photo_mobile');
              if( !empty( $image ) ): ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_url($image['url']); ?>" />
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="unit-info container">
          <p class="txt-def unit-info__number">NO. <?php the_ID(); ?></p>
          <p class="unit_title a--hd-3 disable"><? the_title(); ?></p>
          <div class="unit_cat">
            <div class="a--txt" href="<?= get_home_url() . '?category=' . $project_cats[0]->term_id; ?>"><?php echo ($project_cats[0]->name === 'Home') ? $project_cats[1]->name : $project_cats[0]->name; ?></div>
          </div>
          <p class="txt-def unit-info__year"><? the_field('year'); ?></p>
        </div>
      </div>
		</li>

	<? endwhile; wp_reset_query();
}

add_action( 'wp_ajax_nopriv_infinite_loop', 'infinite_loop' );
add_action( 'wp_ajax_infinite_loop', 'infinite_loop' );

/*
 * Infinete Loop
 */

function infinite_loop() {
	$post_cat = $_POST['cat'];

	$query_args = array(
		'post_type' => 'projects',
		'posts_per_page' => 2,
		// 'offset' => $_POST['page'],
		'paged' => $_POST['page']
	);

	if( strlen($post_cat) > 0 && $post_cat != 0 ) {
		$query_args['tax_query'] = array( array(
			'taxonomy' => 'category',
			'terms' => $post_cat
		));
	}

	$the_query = new WP_Query( $query_args );

	eg_post_loop($the_query);

	die();
}


/*
 * Load Posts Cat
 */

add_action( 'wp_ajax_nopriv_load_posts_cat', 'load_posts_cat' );
add_action( 'wp_ajax_load_posts_cat', 'load_posts_cat' );

function load_posts_cat()
{
	$post_cat = $_POST['cat'];

	$query_args = array(
		'post_type' => 'projects',
		'posts_per_page' => 4,
		// 'offset' => $_POST['page'],
		'paged' => $_POST['page']
	);

	if( strlen($post_cat) > 0 && $post_cat != 0 ) {
		$query_args['tax_query'] = array( array(
			'taxonomy' => 'category',
			'terms' => $post_cat
		));
	}

	$the_query = new WP_Query( $query_args );

	eg_post_loop($the_query);

	die();
}


/*
 * Add "Project" cpt.
 */

add_action( 'init', 'eg_add_cpt_project' );
function eg_add_cpt_project() {
	register_post_type( 'projects',
	array(
		'labels' => array(
			'name'               => 'Projects',
			'singular_name'      => 'Project',
			'add_new'            => 'Add Project',
			'add_new_item'       => 'Adding new Project',
			'edit_item'          => 'Edit Project',
			'new_item'           => 'New Project',
			'view_item'          => 'View Project',
			'search_items'       => 'Search for Project',
			'menu_name'          => 'Projects',
	),
		'taxonomies'          => array( 'category' ),
		'supports'            => array( 'title', 'thumbnail', 'editor' ),
		'public'              => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-gallery',
	)
	);
	// add_image_size( 'happy_people-size', 600, 600, array( 'center', 'center' ) );
};


/**
 * Load Custom scripts/styles.
 */

add_action('wp_enqueue_scripts', 'pr_add_scripts');
function pr_add_scripts()
{
	$theme = get_template_directory_uri();
	$css = $theme.'/custom/css/';
	$lib = $theme.'/custom/lib/';

	wp_register_script(
		'js-main',
		$theme.'/custom/js/main.js',
		array( 'jquery', 'js-validation' ),
		'',
		true
	);
	wp_register_script(
		'js-validation',
		$lib.'jquery.validate.min.js',
		'',
		true
	);
	// wp_register_script(
	// 	'js-scroll-to',
	// 	$lib.'scrollto.js',
	// 	array( 'jquery' ),
	// 	'',
	// 	true
	// );
	wp_register_script(
		'js-owl',
		$lib.'owl/owl.carousel.min.js',
		array( 'jquery' ),
		'',
		true
	);
	wp_localize_script( 'jquery', 'pzl', array(
		'url' => array(
			'theme'  => get_template_directory_uri(),
			'ajax'   => admin_url('admin-ajax.php'),
		),
		'nounce' => wp_create_nonce('ajax'),
	) );
	// wp_register_script(
	// 	'js-shuffle',
	// 	$lib.'shuffle/shuffle.min.js',
	// 	array( 'jquery' ),
	// 	'',
	// 	true
	// );
	// wp_register_script(
	// 	'js-selectric',
	// 	$lib.'selectric/jquery.selectric.js',
	// 	array( 'jquery' ),
	// 	true
	// );
	// wp_register_script(
	// 	'js-transit',
	// 	$lib.'transit/jquery.transit.js',
	// 	array( 'jquery' ),
	// 	'',
	// 	true
	// );
	// wp_register_script(
	// 	'js-fancybox',
	// 	$lib.'fancybox/jquery.fancybox.min.js',
	// 	array( 'jquery' ),
	// 	'',
	// 	true
	// );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'js-owl' );
	wp_enqueue_script( 'js-main' );
	wp_enqueue_script( 'js-validation' );
	// wp_enqueue_script( 'js-scroll-to' );
	// wp_enqueue_script( 'js-selectric' );
	// wp_enqueue_script( 'js-shuffle' );
	// wp_enqueue_script( 'js-transit' );
	// wp_enqueue_script( 'js-fancybox' );
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'start_post_rel_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'adjacent_posts_rel_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'start_post_rel_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'adjacent_posts_rel_link');


	wp_register_style(
		'css-base',
		$css.'base.css',
		array( 'egofilm-style' ),
		filemtime(get_stylesheet_directory().'/custom/css/base.css')
	);

	wp_enqueue_style( 'css-base' );
}

// FORM PORTFOLIO
// ----------
add_action( 'post_edit_form_tag', 'update_edit_form' );
function update_edit_form() {
	echo ' enctype="multipart/form-data"';
}

add_action( 'admin_post_nopriv_form_portfolio', 'ajax_form_portfolio' );
add_action( 'admin_post_form_portfolio', 'ajax_form_portfolio' );
function ajax_form_portfolio(){
	// print_r($_FILES);
	var_dump($_FILES);

	$recipient_email = 'viburnumbox@gmail.com';
	$reply_to_email  = 'illustrator@gmail.com';
	$from_email      = 'illustrator@gmail.com';
	$subject         = 'Portfolio';
	$boundary        = md5("random");

	// FORM DATA
	// -----
	$firstName = $_POST['firstName'];
	$lastName  = $_POST['lastName'];
	$sity      = $_POST['sity'];
	$tel       = $_POST['tel'];
	$email     = $_POST['email'];
	$link      = $_POST['link'];

	$formData = array(
		'firstName' => $firstName,
		'lastName'  => $lastName,
		'sity'      => $sity,
		'tel'       => $tel,
		'email'     => $email,
		'link'      => $link
	);


	$message = $firstName. "\n" .$lastName. "\n" .$sity. "\n" .$tel. "\n" .$email. "\n" .$link;


	// FILE META
	$tmp_name    = $_FILES['file1']['tmp_name']; // get the temporary file name of the file on the server
	$name        = $_FILES['file1']['name'];  // get the name of the file
	$size        = $_FILES['file1']['size'];  // get size of the file for size validation
	$type        = $_FILES['file1']['type'];  // get type of the file
	$error       = $_FILES['file1']['error']; // get the error (if any)

	//read from the uploaded file & base64_encode content
	$handle  = fopen($tmp_name, "r"); // set the file handle only for reading the file
	$content = fread($handle, $size); // reading the file
	fclose($handle);                  // close upon completion

		$encoded_content = chunk_split(base64_encode($content));
		$boundary = md5("random"); // define boundary with a md5 hashed value

	// HEADERS
	// -----
	$headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version
	$headers .= "From:".$from_email."\r\n"; // Sender Email
	$headers .= "Reply-To: ".$reply_to_email."\r\n"; // Email addrress to reach back
	$headers .= "Content-Type: multipart/mixed;\r\n"; // Defining Content-Type
	$headers .= "boundary = $boundary\r\n"; //Defining the Boundary


	// PLAIN TEXT
	// -----
	$body = "--$boundary\r\n";
	$body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
	$body .= "Content-Transfer-Encoding: base64\r\n\r\n";
	$body .= chunk_split(base64_encode($message));


	// SEND EMAIL
	// -----
	$sentMailResult = mail($recipient_email, $subject, $body, $headers);


	// wp_send_json( print_r($_FILES) );
	// print_r(ini_get('file_uploads'));
	// print_r($_FILES['file1']['error']);

	$fileError = $_FILES["file1"]["error"]; // where FILE_NAME is the name attribute of the file input in your form
	switch($fileError) {
    case UPLOAD_ERR_INI_SIZE:
        print 'Exceeds max size in php.ini';
        break;
    case UPLOAD_ERR_PARTIAL:
        print 'Exceeds max size in html form';
        break;
    case UPLOAD_ERR_NO_FILE:
        print 'No file was uploaded';
        break;
    case UPLOAD_ERR_NO_TMP_DIR:
        print 'No /tmp dir to write to';
        break;
    case UPLOAD_ERR_CANT_WRITE:
        print 'Error writing to disk';
        break;
    default:
        print 'No error was faced! Phew!';
        break;
}

	die();
}