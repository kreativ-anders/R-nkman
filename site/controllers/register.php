<?php

return function ($kirby) {

  // don't show the login screen to already logged in users
  if ($kirby->user()) {
    go('/');
  }

  $error = false;

  // handle the form submission
  if ($kirby->request()->is('POST') && get('register')) {

    // Check Captcha
    if (get('captcha') === get('captcha_solution')) {
      try {

        // impersonate
        $kirby->impersonate('kirby');
  
        // create user
        $user = $kirby->users()->create([
          'email'     => esc(get('email')),
          'role'      => 'visitor',
          'language'  => 'en',
          'password'  => esc(get('password'))
        ]);
  
        // deimpersonate
        $kirby->impersonate();

        $id = Db::insert('user', [
          'NAME'          => esc(get('email')),
          'Identifier'    => $user
        ]);
  
        // login user
        if($user and $user->login(get('password'))) {
          go('dashboard');
        }   
  
      } catch(Exception $e) {
      
        $error = $e->getMessage();    
      }
    }
    else {
      $error = "Wrong Calculation ... So you´re a BOT!?";
    }
  }

  return [
    'error' => $error
  ];

};