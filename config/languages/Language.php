<?php
$siteConfig = __DIR__ . '/../../modules/site/config/languages/Language.php';
if (file_exists($siteConfig)) {
    return include($siteConfig);
}
return [
    1 => [
        'id' => 1,
        'name' => 'English',
        'name_native' => 'English',
        'iso_639_1' => 'en',
        'iso_639_2t' => 'eng',
        'hreflang' => 'en',
        'context_rules' => [
            1 => [
                'domain' => 'dotplant3.dev',
                'folder' => 'en',
            ]
        ],
        'yii_language' => 'en-US',
        'sort_order' => 1,
    ],
    2 => [
        'id' => 2,
        'name' => 'Russian',
        'name_native' => 'Русский',
        'iso_639_1' => 'ru',
        'iso_639_2t' => 'rus',
        'hreflang' => 'ru',
        'context_rules' => [
            1 => [
                'domain' => 'dotplant3.dev',
                'folder' => 'ru',
            ]
        ],
        'yii_language' => 'ru',
        'sort_order' => 2,
    ],
];