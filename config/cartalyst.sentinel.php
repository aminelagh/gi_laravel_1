<?php

return [

  'session' => 'cartalyst_sentinel',
  'cookie' => 'cartalyst_sentinel',
  'users' => [
    'model' => 'Cartalyst\Sentinel\Users\EloquentUser',
  ],

  'roles' => [
    'model' => 'Cartalyst\Sentinel\Roles\EloquentRole',
  ],
  'permissions' => [
    'class' => 'Cartalyst\Sentinel\Permissions\StandardPermissions',
  ],
  'persistences' => [
    'model' => 'Cartalyst\Sentinel\Persistences\EloquentPersistence',
    'single' => false,
  ],
  
  'checkpoints' => [
    'throttle',
    'activation',
  ],

  'activations' => [
    'model' => 'Cartalyst\Sentinel\Activations\EloquentActivation',
    'expires' => 259200,
    'lottery' => [2, 100],
  ],
  'reminders' => [
    'model' => 'Cartalyst\Sentinel\Reminders\EloquentReminder',
    'expires' => 14400,
    'lottery' => [2, 100],
  ],
  'throttling' => [
    'model' => 'Cartalyst\Sentinel\Throttling\EloquentThrottle',
    'global' => [
      'interval' => 900,
      'thresholds' => [
        10 => 1,
        20 => 2,
        30 => 4,
        40 => 8,
        50 => 16,
        60 => 12
      ],
    ],
    'ip' => [
      'interval' => 900,
      'thresholds' => 5,
    ],
    'user' => [
      'interval' => 900,
      'thresholds' => 5,
    ],
  ],
];
