<?php
return [
    //'aff/<id:\d+>/<lp:\d+>' => 'affiliate/index',
    //'aff/<id:\d+>' => 'affiliate/index',

    'aff/<username>/<lp:\d+>' => 'affiliate/index',
    'aff/<username>' => 'affiliate/index',
    'affiliate/profile/<username>' => 'affiliate/profile',

    'landing/<id:\d+>' => 'landing/index',
    'lp/<id:\d+>/<username>' => 'landing/index',
    'lp/<id:\d+>' => 'landing/index',
];
