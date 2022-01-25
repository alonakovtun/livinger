<?php
namespace Composer\Installers;

class TheliaInstaller extends BaseInstaller
{
    protected $locations = array(
        'module'                => 'local/modules/{$name}/',
        'frontoffice-template'  => 'woocommerce/frontOffice/{$name}/',
        'backoffice-template'   => 'woocommerce/backOffice/{$name}/',
        'email-template'        => 'woocommerce/email/{$name}/',
    );
}
