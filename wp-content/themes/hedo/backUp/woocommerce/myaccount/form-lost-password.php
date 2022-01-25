<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>
<div class="log-in">
    <div class="log-in__left reset-password">
        <h2 class="log-in__title"><?php esc_html_e( 'Reset password', 'hedo' ); ?></h2>
        <form method="post" class="woocommerce-ResetPassword lost_reset_password">
            <div class="log-in__input-data">
                <p class="log-in__right-mess mb-30"><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

                <div class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
    <!--                <label for="user_login"></label>-->
                    <input class="woocommerce-Input woocommerce-Input--text input-text textarea__input textarea__input_login" type="text" name="user_login" id="user_login" autocomplete="username" placeholder="<?php esc_html_e( 'Username or email', 'woocommerce' ); ?>" />
                </div>

                <div class="clear"></div>

                <?php do_action( 'woocommerce_lostpassword_form' ); ?>
            </div>

            <p class="woocommerce-form-row form-row">
                <input type="hidden" name="wc_reset_password" value="true" />
                <button type="submit" class="woocommerce-Button button button__full button__flex button__green button__register button__reset mt-33 " value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?></button>
            </p>

            <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>

        </form>
    </div>
</div>
<?php
do_action( 'woocommerce_after_lost_password_form' );
