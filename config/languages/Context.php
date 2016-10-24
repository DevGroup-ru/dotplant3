<?php
$siteConfig = __DIR__ . '/../../modules/site/config/languages/Context.php';
if (file_exists($siteConfig)) {
    return include($siteConfig);
}
return [
    1 => [
        'id' => '1',
        'name' => 'Web',
        'domain' => 'dotplant3.dev',
        'tree_root_id' => '1',
    ],
];