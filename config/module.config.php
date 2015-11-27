<?php
// NOTE: you can check to see if a user is logged in as follows:
//       From a controller: if ($this->isLoggedIn()) { // OK }
//       From inside a view template: if ($this->isLoggedIn()) { // OK }
return [
	'controller_plugins' => [
		'invokables' => [
        	'isLoggedIn' => 'UnsrcSimpleAuth\Plugin\IsLoggedInControllerPlugin',
		],
    ],
	'view_helpers' => [
        'invokables' => [
			'isLoggedIn'  => 'UnsrcSimpleAuth\Plugin\IsLoggedInViewHelper',
			'getIdentity' => 'UnsrcSimpleAuth\Plugin\GetIdentityViewHelper',
		],
    ],
	'service_manager' => [
		'invokables' => [
			'unsrc-simple-auth-login-filter' => 'UnsrcSimpleAuth\Form\LoginFilter',
            'unsrc-simple-auth-service' => 'Zend\Authentication\AuthenticationService',
		],
	],
	'router' => [
        'routes' => [
            'unsrc-simple-auth-login' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/login',
                    'defaults' => [
                        'controller'    => 'unsrc-simple-auth-controller-login',
                        'action'        => 'login',
                    ],
                ],
            ],
            'unsrc-simple-auth-logout' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/logout',
                    'defaults' => [
                        'controller'    => 'unsrc-simple-auth-controller-login',
                        'action'        => 'logout',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_map' => include __DIR__ . '/../template_map.php',
    ],
];
