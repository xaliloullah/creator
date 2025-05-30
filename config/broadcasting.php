<?php

return [
  'default' => env('BROADCAST_DRIVER', 'pusher'),
  'options' => [
    'cluster' => 'eu',
    'useTLS' => true
  ],
];
