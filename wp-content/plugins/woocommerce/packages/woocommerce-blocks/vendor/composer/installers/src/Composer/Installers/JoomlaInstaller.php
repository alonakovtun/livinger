<?php
namespace Composer\Installers;

class JoomlaInstaller extends BaseInstaller
{
    protected $locations = array(
        'component'    => 'components/{$name}/',
        'module'       => 'modules/{$name}/',
        'template'     => 'woocommerce/{$name}/',
        'plugin'       => 'plugins/{$name}/',
        'library'      => 'libraries/{$name}/',
    );

    // TODO: Add inflector for mod_ and com_ names
}
