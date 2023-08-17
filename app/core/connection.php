<?php

class DatabaseConfig
{
    private $config = [
        'localhost' => [
            'DBUSER' => 'root',
            'DBPASS' => 'password',
            'DBNAME' => 'MyBlogPHP',
            'DBHOST' => 'localhost'
        ],
        // Add other environment configurations here
    ];

    public function getDatabaseConfig()
    {
        $serverName = $_SERVER['SERVER_NAME'];

        if (array_key_exists($serverName, $this->config)) {
            return $this->config[$serverName];
        }

        // Default configuration if environment is not recognized
        return [
            'DBUSER' => 'root',
            'DBPASS' => 'password',
            'DBNAME' => 'MyBlogPHP',
            'DBHOST' => 'localhost'
        ];
    }
}

$databaseConfig = new DatabaseConfig();
$config = $databaseConfig->getDatabaseConfig();

define('DBUSER', $config['DBUSER']);
define('DBPASS', $config['DBPASS']);
define('DBNAME', $config['DBNAME']);
define('DBHOST', $config['DBHOST']);