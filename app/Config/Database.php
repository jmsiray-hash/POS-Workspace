<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Database connection group to use if none specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     *
     * @var array<string, mixed>
     */
    public array $default = [
        'DSN'          => '',
        'hostname'     => 'roundhouse.proxy.rlwy.net',
        'username'     => 'root',
        'password'     => 'RdwuRLBsmcyPnyqikfvYvPkcfyPPPxiR',
        'database'     => 'railway',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => true,
        'charset'      => 'utf8mb4',
        'DBCollat'     => 'utf8mb4_general_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 14238,
        'numberNative' => false,
        'foundRows'    => false,
        'dateFormat'   => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    /**
     * This database connection is used when running PHPUnit database tests.
     *
     * @var array<string, mixed>
     */
    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8mb4',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
        'dateFormat'  => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        $this->default['hostname'] = getenv('database.default.hostname')
            ?: getenv('DB_HOST')
            ?: getenv('MYSQLHOST')
            ?: 'roundhouse.proxy.rlwy.net';
        $this->default['username'] = getenv('database.default.username')
            ?: getenv('DB_USER')
            ?: getenv('MYSQLUSER')
            ?: 'root';
        $this->default['password'] = getenv('database.default.password')
            ?: getenv('DB_PASS')
            ?: getenv('MYSQLPASSWORD')
            ?: 'RdwuRLBsmcyPnyqikfvYvPkcfyPPPxiR';
        $this->default['database'] = getenv('database.default.database')
            ?: getenv('DB_NAME')
            ?: getenv('MYSQLDATABASE')
            ?: 'railway';
        $this->default['port']     = (int) (
            getenv('database.default.port')
            ?: getenv('DB_PORT')
            ?: getenv('MYSQLPORT')
            ?: 14238
        );

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}