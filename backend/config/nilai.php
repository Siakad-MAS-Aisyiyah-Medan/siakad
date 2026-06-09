<?php

return [
    'weights' => [
        'default' => [
            'tugas' => 0.30,
            'uts' => 0.30,
            'uas' => 0.40,
        ],
        'with_praktik' => [
            'tugas' => 0.25,
            'uts' => 0.25,
            'uas' => 0.30,
            'praktik' => 0.20,
        ],
    ],

    'predikat' => [
        ['min' => 90, 'grade' => 'A'],
        ['min' => 80, 'grade' => 'B'],
        ['min' => 70, 'grade' => 'C'],
        ['min' => 60, 'grade' => 'D'],
        ['min' => 0, 'grade' => 'E'],
    ],
];
