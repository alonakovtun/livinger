<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package egofilm
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" viewport-fit="cover" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
  <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"> -->

</head>

<?
$page_class = '';

if( is_page_template('page-contact.php') ){
	$page_class = 'p-contact';
} elseif( is_page_template('page-o-nas.php') ){
	$page_class = 'p-onas';
} elseif( is_page_template('page-career.php') ){
	$page_class = 'p-career';
} elseif( is_page_template('page-oferta.php') ){
	$page_class = 'p-oferta';
} elseif( is_singular() ){
	$page_class = 'p-project';
}

?>

<body data-barba="wrapper" <?php body_class(); ?>>
  <ul class="transition">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
  </ul>

<div class="site <?= $page_class; ?>" id="page">
  <? if( is_front_page() ): ?>
  <div class="video-start-page video-start">
    <div class="video-start-page__header header__controller">
      <a id="close-video" href="#" class="video-start-page__close video-close">skip showreel</a>
      <a id="muted" href="#" class="video-start-page__close video-start-page__mute">unmute</a>
    </div>
    <div class="video-start-page__video header__video">
    <video class="video-banner__video header__video-bunner" autoplay loop muted playisinline preload="metadata">
    <?php
    $file = get_field('video_start', 8);
    if( $file ): ?>
        <source src="<?php echo $file; ?>" type="video/mp4">
    <?php endif; ?>
    </video>
    <video class="video-banner__mobile" autoplay loop muted playisinline preload="metadata">
    <?php
    $file = get_field('video_start_mobile', 8);
    if( $file ): ?>
        <source src="<?php echo $file; ?>" type="video/mp4">
    <?php endif; ?>
    </video>
    </div>
  </div>
  <? endif; ?>

  <div class="header__fake">
    <header id="masthead" class="header l-header container-fluid">
      <aside class="u-aside">
        <div class="header__container container u-aside_content">
          <div class="header__home">
            <a href="/" class="circle"></a>
            <a href="/" class="circle"></a>
            <a class="menu__link menu__link_before-disabled" href="/">
              <? if (qtranxf_getLanguage() == 'pl'):  ?>
                Home
              <? else: ?>
                Home
              <? endif; ?>
            </a>
          </div>
          <div class="header__burger">
            <i class="burger-line"></i>
          </div>
          <div class="header__menu">
            <div class="header__menu-flex">
              <div class="header__menu-head">
                <ul class="menu b-cat-nav">
                    <li class="menu__item cat-nav_unit mobile">
                    <a class="menu__link" href="/">
              <? if (qtranxf_getLanguage() == 'pl'):  ?>
                Home
              <? else: ?>
                Home
              <? endif; ?>
            </a>
                    </li>
                    <li class="menu__item cat-nav_unit">
                      <a class="menu__link" href="/index">
                        <? if (qtranxf_getLanguage() == 'pl'):  ?>
                          Index
                        <? else: ?>
                          Index
                        <? endif; ?>
                      </a>
                    </li>
                    <li class="menu__item cat-nav_unit">
                      <a class="menu__link" href="/studio">
                        <? if (qtranxf_getLanguage() == 'pl'):  ?>
                          studio
                        <? else: ?>
                          Studio
                        <? endif; ?>
                      </a>
                    </li>
                    <li class="menu__item cat-nav_unit">
                      <a class="menu__link" href="<?= get_page_link(231); ?>">
                        <? if (qtranxf_getLanguage() == 'pl'):  ?>
                          Praca
                        <? else: ?>
                          Careers
                        <? endif; ?>
                      </a>
                    </li>
                </ul>
                <ul class="studio__social b-nav a--flx-row-btv">
                  <? wp_nav_menu( array(
                    'theme_location'  => 'footer_social',
                    'menu'            => 'Social',
                    'container'       => false,
                    'menu_class'      => 'menu',
                    'menu_id'         => '',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu',
                    'before'          => '',
                    'after'           => '',
                    'link_before'     => '',
                    'link_after'      => '',
                    'items_wrap'      => '%3$s',
                    'depth'           => 0,
                    'walker'          => '',
                  ) );
                  ?>
                </ul>
              </div>
              <div class="header__menu-bottom">
                <?
                  $pl_active_class = '';
                  $en_active_class = '';
                  if (qtranxf_getLanguage() == 'pl') { ?>
                    <a class="mail a--btn <?= $en_active_class; ?>" href="?lang=en">switch to english</a>
                  <? }
                  else { ?>
                    <a class="mail a--btn <?= $pl_active_class; ?>" href="?lang=pl">switch to polish</a>
                <? } ?>
                <a href="mailto:studio@egofilm.pl" class="mail">studio@egofilm.pl</a>

              </div>
              <div class="header__menu-footer">
                <p class="txt-copy">EGoFILm &copy;2021 Animation studio</p>
              </div>
            </div>
          </div>
          <div class="header__switch-lang">
              <?
              $pl_active_class = '';
              $en_active_class = '';
              if (qtranxf_getLanguage() == 'pl') { ?>
                <a class="lang_en a--btn <?= $en_active_class; ?>" href="?lang=en">switch to english</a>
                <a href="?lang=en" class="circle circle-lang">
                  <img src="//localhost:3000/wp-content/themes/egofilm/custom/img/en.jpeg" alt="english" />
                </a>
              <? }
              else { ?>
                <a class="lang_pl a--btn <?= $pl_active_class; ?>" href="?lang=pl">switch to polish</a>
                <a href="?lang=pl" class="circle circle-lang">
                  <img src="//localhost:3000/wp-content/themes/egofilm/custom/img/pl.png" alt="polish" />
                </a>
              <? } ?>
          </div>
          </div>
        </div>
    </header>
  </div>
	<div data-barba="container" data-barba-namespace="home" class="l-content site-content container-fluid" id="content">
