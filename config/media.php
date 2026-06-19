<?php

return [

  'disk' => env('MEDIA_DISK', 'public'),

  'base_path' => 'media',

  'variants' => [
    'original' => null,
    'optimized' => ['max_width' => 1920, 'quality' => 85],
    'thumbnail' => ['max_width' => 400, 'max_height' => 400, 'quality' => 80],
    'webp' => ['quality' => 82],
  ],

  'lazy_loading' => [
    'enabled' => true,
    'placeholder' => 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 1"%3E%3C/svg%3E',
  ],

  'generate_webp' => env('MEDIA_GENERATE_WEBP', true),

  'collections' => [
    'default',
    'hero',
    'gallery',
    'article',
    'portfolio',
    'teacher',
  ],

];
