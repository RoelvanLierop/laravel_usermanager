<?php
/**
 * User Manager Configuration File
 *
 * This configuration file lays out all the configuration we need to get the User Manager up and running
 *
 * @used-by Roelvanlierop\Usermanager\UserManagerServiceProvider::boot()
 * @author Roel van Lierop - <roel.van.lierop@gmail.com>
 * @category Laravel Configuration File
 * @link ../vendor/roelvanlierop/usermanager/src/config/usermanager.php
 */

return [
    'routes' => [
        'index' => 'users',
        'shadowlogin_return_uri' => '/dashboard'
    ],
];
