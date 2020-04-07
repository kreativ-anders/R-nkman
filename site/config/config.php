<?php

/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen. 
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */
return [
    'debug' => true,
    'routes' => [
        [
          'pattern' => 'logout',
          'action'  => function() {
    
            if ($user = kirby()->user()) {
              $user->logout();
            }
    
            go('login');
          }
        ],
        [
          'pattern' => 'survey/(:alphanum)/(:alphanum)',
          'action'  => function ($user, $voter) {

            Cookie::set('u', $user, ['lifetime' => time() +2592000]);
            Cookie::set('v', $voter, ['lifetime' => time() +2592000]);

            return go('survey');
           }
        ],
        [
          'pattern' => 'survey/(:alphanum)/all',
          'action'  => function ($user) {
            Cookie::set('u', $user, ['lifetime' => time() +2592000]);

            return go('survey');
           }
        ]
    ],
    'db' => [
      'host'     => '127.0.0.1',
      'database' => 'u204246837_rankman_db',
      'user'     => 'u204246837_rankman_user',
      'password' => '123456',
    ]
];
