<?php
/**
 * Prodiz Memoria User Manager Configuration File
 *
 * This configuration file lays out all the configuration we need to get the User Manager up and running
 *
 * @used-by Prodizmemoria\Usermanager\UserManagerServiceProvider::boot()
 * @author Roel van Lierop | Prodiz Memoria Lead Developer - <roel@aandachttrekkers.nl>
 * @category Laravel Configuration File
 * @link ../vendor/prodizmemoria/usermanager/src/config/usermanager.php
 */

return [
    'routes' => [
        'index' => 'users',
        'shadowlogin_return_uri' => '/dashboard'
    ],
];
