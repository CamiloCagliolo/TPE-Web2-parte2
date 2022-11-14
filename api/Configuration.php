<?php

define('SECRET', "Sos Jorge el Curioso?");

define('EXOPLANETS_COLUMNS', array(
    'name' => 'e.name ',
    'mass' => 'e.mass ',
    'radius' => 'e.radius ',
    'method' => 'm.name_acronym ',
    'star' => 's.name '
));

define('STARS_COLUMNS',array(
    'name' => 'name ',
    'mass' => 'mass ',
    'radius' => 'radius ',
    'distance' => 'distance ',
    'type' => 'type '
));

define('VALID_REQUESTS', ["resource", "sort", "order", "contains", "page", "limit"]);
define('ROLE', "editor");
define('EXPIRATION_TIME', 180);
