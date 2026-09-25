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
        'hostname'     => 'mysql-3af8d409-gsiray49-3918.k.aivencloud.com',
        'username'     => 'avnadmin',
        'password'     => 'AVNS_6oduRy3fzhjOW0yOzkn',
        'database'     => 'defaultdb',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => true,
        'charset'      => 'utf8mb4',
        'DBCollat'     => 'utf8mb4_general_ci',
        'swapPre'      => '',
        'encrypt'      => [
            'ssl_verify' => false,
        ],
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 14702,
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

        // PIPILITIN NITO ANG TAMANG CREDENTIALS AT SSL OVERRIDE PAGKATAPOS BASAHIN ANG ENV
        $this->default['hostname'] = 'mysql-3af8d409-gsiray49-3918.k.aivencloud.com';
        $this->default['username'] = 'avnadmin';
        $this->default['password'] = 'AVNS_6oduRy3fzhjOW0yOzkn';
        $this->default['database'] = 'defaultdb';
        $this->default['port']     = 14702;
        $this->default['encrypt']  = [
            'ssl_verify' => false,
        ];

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}