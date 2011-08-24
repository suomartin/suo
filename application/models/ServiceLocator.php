<?php

class ServiceLocator
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected static $em;

    /**
     * @var Doctrine\DBAL\Connection
     */
    protected static $db;

    /**
     * @var Doctrine\Common\Cache\AbstractCache
     */
    protected static $cache;

    /**
     * @var Zend_Config
     */
    protected static $config;

    /**
     *
     * @var Services\TicketService
     */
    protected static $o_ticket_service;

    /**
     * @var Doctrine\Orm\EntityRepository
     */
    protected static $o_room_repository;

    /**
     * @return Doctrine\DBAL\Connection
     */
    public static function getDb()
    {
        if (self::$db === null) {
            $dbConfig = self::getConfig()->get('doctrine')->get('db');
            self::$db = Doctrine\DBAL\DriverManager::getConnection($dbConfig->toArray());
        }

        return self::$db;
    }

    /**
     * @return Zend_Config
     */
    public static function getDomainConfig()
    {
        return self::getConfig()->get('domain');
    }

    /**
     * @return Doctrine\Common\Cache\AbstractCache
     */
    public static function getCache()
    {
        if (self::$cache === null) {
            $doctrineConfig = self::getConfig()->get('doctrine');
            $cacheClass = $doctrineConfig->get('cacheClass');
            self::$cache = new $cacheClass;
        }

        return self::$cache;
    }

    /**
     * @return Zend_Config
     */
    public static function getConfig()
    {
        if (self::$config === null) {
            self::$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV, true);
            if (is_readable(APPLICATION_PATH . '/configs/application.local.ini')) {
                self::$config->merge(new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.local.ini',
                                                         APPLICATION_ENV));
            }
            self::$config->setReadOnly();
        }

        return self::$config;
    }

    /**
     *
     * @param Zend_Config $config
     */
    public static function setConfig(Zend_Config $config)
    {
        self::$config = $config;
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    public static function getEm()
    {
        if (self::$em === null) {
            $cache = self::getCache();
            $db = self::getDb();
            $config = new \Doctrine\ORM\Configuration();
            $config->setMetadataCacheImpl($cache);
            $config->setQueryCacheImpl($cache);
            $config->setMetadataDriverImpl(
                $config->newDefaultAnnotationDriver(APPLICATION_PATH . '/models'));
            $config->setProxyDir(APPLICATION_PATH . '/models/Infrastructure/Proxies');
            $config->setProxyNamespace('Infrastructure\Proxies');
            $config->setAutoGenerateProxyClasses(false);
            self::$em = \Doctrine\ORM\EntityManager::create($db, $config);
        }

        return self::$em;
    }

    /**
     *
     * @param Doctrine\Orm\EntityManager $em
     */
    public static function setEm(Doctrine\Orm\EntityManager $em)
    {
        self::$em = $em;
    }

    /**
     * Set Room repository
     *
     * @param Doctrine\Orm\EntityRepository $o_repository repository
     */
    public static function setRoomRepository(Doctrine\Orm\EntityRepository $o_repository)
    {
        self::$o_room_repository = $o_repository;
    }

    /**
     * Get Room repository
     *
     * @return Doctrine\Orm\EntityRepository
     */
    public static function getRoomRepository()
    {
        if (null === self::$o_room_repository) {
            self::$o_room_repository = self::getEm()->getRepository('\Domain\Room');
        }

        return self::$o_room_repository;
    }

    /**
     * @return Services\TicketService
     */
    public static function getTicketService()
    {
        if (null == self::$o_ticket_service) {
            self::$o_ticket_service = new \Services\TicketService();
        }

        return self::$o_ticket_service;
    }
}