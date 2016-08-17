<?php

namespace app;

class Installer
{
    public static function createLocalConfigs()
    {
        $configs = [
            'cache-local.php' => [],
            'common-local.php' => [],
            'console-local.php' => [],
            'db-local.php' => [
                'dsn' => 'mysql:host=127.0.0.1;dbname=dotplant3',
                'username' => 'root',
                'password' => '',
            ],
            'dev-ips-local.php' => [],
            'log-local.php' => [],
            'mailer-local.php' => [],
            'params-local.php' => [],
            'web-local.php' => [
                'components' => [
                    'request' => [
                        'cookieValidationKey' => '',
                    ],
                ],
            ],
        ];
        foreach ($configs as $name => $config) {
            $filename = __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $name;
            if (file_exists($filename) === false) {
                echo "File 'config/" . $name . "' is created: ";
                echo file_put_contents($filename, "<?php\n\nreturn " . \yii\helpers\VarDumper::export($config) . ";\n") !== false
                    ? "yes\n"
                    : "no\n";
            }
        }
    }
}
