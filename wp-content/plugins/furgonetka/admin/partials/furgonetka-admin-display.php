<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://furgonetka.pl
 * @since      1.0.0
 *
 * @package    Furgonetka
 * @subpackage Furgonetka/admin/partials
 */

/**
 * /wp-content/plugins/furgonetka/admin/class-furgonetka-admin.php:168
 * available variables
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}
$tab = isset($_GET['tab'])?sanitize_text_field($_GET['tab']):'furgonetka';
$tab_api_account = 'furgonetka';
$tab_sender_info = 'sender_info';
$tab_attach_map = 'attach_map';

?>
<div class="wrap">

    <nav class="nav-tab-wrapper woo-nav-tab-wrapper">
      <a href="<?php echo get_admin_url('','/admin.php?page=furgonetka&tab='.$tab_api_account)?>" class="nav-tab <?php echo ($tab == $tab_api_account || !isset($tab)) ? "nav-tab-active" :"" ; ?>"><?php _e('API account', 'furgonetka'); ?></a>
        <?php if(Furgonetka_Admin::isAccountActive()):?>
            <a href="<?php echo get_admin_url('','/admin.php?page=furgonetka&tab='.$tab_sender_info)?>" class="nav-tab <?php echo ($tab == $tab_sender_info) ? "nav-tab-active" :"" ; ?>"><?php _e('Sender info', 'furgonetka'); ?></a>
            <a href="<?php echo get_admin_url('','/admin.php?page=furgonetka&tab='.$tab_attach_map)?>" class="nav-tab <?php echo ($tab == $tab_attach_map) ? "nav-tab-active" :"" ; ?>"><?php _e('Attach map', 'furgonetka'); ?></a>
        <?php endif;?>
         </nav>

    <?php Furgonetka_Admin::printMessages($furgonetka_errors,'error');?>
    <?php Furgonetka_Admin::printMessages($furgonetka_messages,'message');?>

    <?php if($tab == $tab_api_account || !isset($tab)): ?>
        <h1 class="screen-reader-text"><?php _e('Main settings', 'furgonetka'); ?></h1>
        <h2><?php _e('Furgonetka', 'furgonetka'); ?></h2>
        <p>
            <?php _e('The Furgonetka.pl website enables the use of a wide range of courier services at very attractive prices without restrictions and the need to sign contracts.','furgonetka');?>
            <br/>
            <?php _e('We offer convenient tools that allow both companies and individuals to order quickly and conveniently courier.','furgonetka');?>
            <br/>
            <?php _e('This module will significantly improve the creation of shipments and ordering courier at Furgonetka.pl.','furgonetka');?>
        </p>
        <?php if(Furgonetka_Admin::isAccountActive()):?>
            <table class="form-table">

                <tbody>

                <tr>
                    <th scope="row"><label for="balance"><?php _e('Balance', 'furgonetka'); ?></label></th>
                    <td>
                        <input name="" type="text" id="balance" value="<?php echo Furgonetka_Admin::getClientBalance();?>" class="regular-text" required disabled>

                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="clientID"><?php _e('Client ID', 'furgonetka'); ?></label></th>
                    <td>
                        <input name="" type="text" id="clientID" value="<?php echo Furgonetka_Admin::getClientID();?>" class="regular-text" required disabled>

                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="clientSecret"><?php _e('Client Secret', 'furgonetka'); ?></label></th>
                    <td>
                        <input name="" type="text" id="clientSecret" value="<?php echo Furgonetka_Admin::getClientSecret();?>" class="regular-text" required disabled>

                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="isTestMode"><?php _e('Test mode', 'furgonetka'); ?></label></th>
                    <td>
                        <input name="" type="checkbox" id="isTestMode" value="1" <?php echo Furgonetka_Admin::getTestMode()?'checked':'';?> disabled>
                        <input name="isTestMode" type="hidden"  value="<?php echo Furgonetka_Admin::getTestMode()?'1':'';?>">

                        <p class="description" id="home-description"><?php _e('Requires an account on', 'furgonetka'); ?>
                            http://test.furgonetka.pl/</p>
                </tr>
                </tbody>
            </table>
        <form method="post" action="<?php echo $furgonetka_form_url.'&tab='.$tab_api_account;?>">
        <input type="hidden" name="furgonetkaAction" value="resetCredentials"/>
            <p>
                <?php _e('You can reset current account by clicking Reset button', 'furgonetka'); ?>
            </p>
             <table class="form-table">

                 <p class="submit"><input type="submit" name="submit" id="submit" class="button button-secondary" value="<?php _e('Reset', 'furgonetka'); ?>"></p>
             </table>
        </form>
            <?php else:?>
            <h2><?php _e('Account', 'furgonetka'); ?></h2>
            <p>
                <?php _e('Please add new WOOCOMMERCE REST API read key and copy Consumer key and Consumer secret below.', 'furgonetka'); ?>
                <a href="<?php echo get_admin_url('','/admin.php?page=wc-settings&tab=advanced&section=keys&create-key=1')?>" target="_blank"> <?php _e('Create new key', 'furgonetka'); ?></a><br>
                <a href="https://docs.woocommerce.com/document/woocommerce-rest-api/" target="_blank">More info - https://docs.woocommerce.com/document/woocommerce-rest-api/</a>
            </p>
            <form method="post" action="<?php echo $furgonetka_form_url.'&tab='.$tab_api_account;?>">
                <input type="hidden" name="furgonetkaAction" value="createIntegration"/>
                <table class="form-table">

                    <tbody>
                    <tr>
                        <th scope="row"><label for="key_consumer_key"><?php _e('Consumer key', 'furgonetka'); ?></label></th>
                        <td><input name="key_consumer_key" type="text" id="key_consumer_key" value="<?php echo isset($_POST['key_consumer_key'])?esc_html($_POST['key_consumer_key']):'';?>" class="regular-text" required></td>
                    </tr>
                 <tr>
                        <th scope="row"><label for="key_consumer_secret"><?php _e('Consumer secret', 'furgonetka'); ?></label></th>
                        <td><input name="key_consumer_secret" type="text" id="key_consumer_secret" value="<?php echo isset($_POST['key_consumer_secret'])?esc_html($_POST['key_consumer_secret']):'';?>" class="regular-text" required></td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="isTestMode"><?php _e('Test mode', 'furgonetka'); ?></label></th>
                        <td><input name="isTestMode" type="checkbox" id="isTestMode" value="1" <?php echo Furgonetka_Admin::getTestMode()?'checked':'';?>>
                            <p class="description" id="home-description"><?php _e('Requires an account on', 'furgonetka'); ?>
                                http://test.furgonetka.pl/</p>
                    </tr>
                    </tbody>
                </table>
                <p class="submit"><input type="submit" name="submit"  class="button button-primary" value="<?php _e('Save', 'furgonetka'); ?>"></p>
            </form>

        <?php endif; ?>
    <?php endif; ?>

    <?php if($tab == $tab_sender_info && Furgonetka_Admin::isAccountActive()): ?>
        <h1 class="screen-reader-text"><?php _e('Sender info', 'furgonetka'); ?></h1>
        <h2><?php _e('Sender info', 'furgonetka'); ?></h2>
        <p><?php _e('Complete the senders address details.', 'furgonetka'); ?></p>
        <form method="post" action="<?php echo $furgonetka_form_url.'&tab='.$tab_sender_info; ?>">
            <input type="hidden" name="furgonetkaAction" value="saveSenderData"/>
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row"><label for="name"><?php _e('Name', 'furgonetka'); ?></label></th>
                    <td><input name="name" type="text" id="name" value="<?php echo Furgonetka_Admin::getName();?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="companyName"><?php _e('Company name', 'furgonetka'); ?></label></th>
                    <td><input name="companyName" type="text" id="companyName" value="<?php echo Furgonetka_Admin::getCompanyName();?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="postCode"><?php _e('Post code', 'furgonetka'); ?></label></th>
                    <td><input name="postCode" type="text" id="postCode" value="<?php echo Furgonetka_Admin::getPostCode();?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="city"><?php _e('City', 'furgonetka'); ?></label></th>
                    <td><input name="city" type="text" id="city" value="<?php echo Furgonetka_Admin::getCity();?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="street"><?php _e('Address', 'furgonetka'); ?></label></th>
                    <td><input name="street" type="text" id="street" value="<?php echo Furgonetka_Admin::getStreet();?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="email"><?php _e('E-mail', 'furgonetka'); ?></label></th>
                    <td><input name="email" type="text" id="email" value="<?php echo Furgonetka_Admin::getSenderEmail();?>" class="regular-text" ></td>
                </tr>
                <tr>
                    <th scope="row"><label for="telephone"><?php _e('Phone', 'furgonetka'); ?></label></th>
                    <td><input name="telephone" type="text" id="telephone" value="<?php echo Furgonetka_Admin::getTelephone();?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="iban"><?php _e('Bank account number', 'furgonetka'); ?></label></th>
                    <td><input name="iban" type="text" id="iban" value="<?php echo Furgonetka_Admin::getIban();?>" class="regular-text" required></td>
                </tr>
                <tr>
                    <th scope="row"><label for="accountOwner"><?php _e('Bank account owner name', 'furgonetka'); ?></label></th>
                    <td><input name="accountOwner" type="text" id="accountOwner" value="<?php echo Furgonetka_Admin::getAccountOwner();?>" class="regular-text" required></td>
                </tr>
                </tbody>
            </table>
            <p class="submit"><input type="submit" name="submit"  class="button button-primary" value="<?php _e('Save', 'furgonetka'); ?>"></p>
        </form>
    <?php endif; ?>

    <?php if($tab == $tab_attach_map && Furgonetka_Admin::isAccountActive()): ?>
        <h1 class="screen-reader-text"><?php _e('Attach map to delivery option', 'furgonetka'); ?></h1>
        <h2><?php _e('Attach map to delivery option', 'furgonetka'); ?></h2>
        <p>
            <?php _e('Please remember! You can only attach map to flat rates delivery option. Every delivery option can have one map attached', 'furgonetka'); ?>
        </p>
        <form method="post" action="<?php echo $furgonetka_form_url.'&tab='.$tab_attach_map;?>">
            <?php
            $deliveryToType = get_option(FURGONETKA_PLUGIN_NAME . '_deliveryToType');
            ?>
            <input type="hidden" name="furgonetkaAction" value="saveDelivery"/>
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row"><label for="inpost"><?php _e('Add inpost map to:', 'furgonetka'); ?></label></th>
                    <td>
                        <?php Furgonetka_Admin::mapAttachTo('inpost',$deliveryToType);?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="poczta"><?php _e('Add Poczta Polska map to:', 'furgonetka'); ?></label></th>
                    <td>
                        <?php Furgonetka_Admin::mapAttachTo('poczta',$deliveryToType);?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="kiosk"><?php _e('Add Paczka w RUCHu map to:', 'furgonetka'); ?></label></th>
                    <td>
                        <?php Furgonetka_Admin::mapAttachTo('kiosk',$deliveryToType);?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="uap"><?php _e('Add UPS Access Point map to:', 'furgonetka'); ?></label></th>
                    <td>
                        <?php Furgonetka_Admin::mapAttachTo('uap',$deliveryToType);?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="dpd"><?php _e('Add DPD Pickup map to:', 'furgonetka'); ?></label></th>
                    <td>
                        <?php Furgonetka_Admin::mapAttachTo('dpd',$deliveryToType);?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="dhl"><?php _e('Add DHL Parcel map to:', 'furgonetka'); ?></label></th>
                    <td>
                        <?php Furgonetka_Admin::mapAttachTo('dhl',$deliveryToType);?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="fedex"><?php _e('Add FedEx Point map to:', 'furgonetka'); ?></label></th>
                    <td>
                        <?php Furgonetka_Admin::mapAttachTo('fedex',$deliveryToType);?>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="submit"><input type="submit" name="submit"  class="button button-primary" value="<?php _e('Save', 'furgonetka'); ?>"></p>
        </form>
    <?php endif; ?>
</div>
