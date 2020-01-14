<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/' => [[['_route' => 'GET_', '_controller' => 'kernel::viewHome'], null, ['GET' => 0], null, false, false, null]],
        '/import' => [[['_route' => 'GET_import_', '_controller' => 'kernel::import'], null, ['GET' => 0], null, true, false, null]],
        '/getdata' => [[['_route' => 'POST_getdata_', '_controller' => 'kernel::searchData'], null, ['POST' => 0], null, true, false, null]],
    ],
    [ // $regexpList
    ],
    [ // $dynamicRoutes
    ],
    null, // $checkCondition
];
