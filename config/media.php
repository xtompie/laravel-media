<?php

return [

    'image' => [
        'extension' => ['jpg', 'png', 'jpeg'],
        'uri' => '/image/',
        'variant' =>  [
            's' => ['type' => 'crop', 'w' => 400, 'h' => 225],
            'm' => ['type' => 'crop', 'w' => 800, 'h' => 450],
            'l' => ['type' => 'resize', 'w' => 1920, 'h' => 1080],        
        ],
    ]

];