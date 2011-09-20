<?php

class ServiceLocator
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected static $o_em;

    /**
     * @var Doctrine\DBAL\Connection
     */
    protected static $o_db;

    /**
     * @var Doctrine\Common\Cache\AbstractCache
     */
    protected static $o_cache;

    /**
     * @var Zend_Config
     */
    protected static $o_config;

    /**
     * @var Services\TicketService
     */
    protected static $o_ticket_service;

    /**
     * @var array
     */
    protected static $a_o_repositories = array();

    /**
     * @return Doctrine\DBAL\Connection
     */
    public static function getDb()
    {
        if (self::$o_db === null) {
            $dbConfig = self::getConfig()->get('doctrine')->get('db');
            self::$o_db = Doctrine\DBAL\DriverManager::getConnection($dbConfig->toArray());
        }

        return self::$o_db;
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
        if (self::$o_cache === null) {
            $doctrineConfig = self::getConfig()->get('doctrine');
            $cacheClass = $doctrineConfig->get('cacheClass');
            self::$o_cache = new $cacheClass;
        }

        return self::$o_cache;
    }

    /**
     * @return Zend_Config
     */
    public static function getConfig()
    {
        if (self::$o_config === null) {
            self::$o_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV, true);
            if (is_readable(APPLICATION_PATH . '/configs/application.local.ini')) {
                self::$o_config->merge(new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.local.ini',
                                                         APPLICATION_ENV));
            }
            self::$o_config->setReadOnly();
        }

        return self::$o_config;
    }

    /**
     *
     * @param Zend_Config $config
     */
    public static function setConfig(Zend_Config $config)
    {
        self::$o_config = $config;
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    public static function getEm()
    {
        if (null == self::$o_em) {
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
            self::$o_em = \Doctrine\ORM\EntityManager::create($db, $config);
        }

        return self::$o_em;
    }

    /**
     *
     * @param Doctrine\Orm\EntityManager $em
     */
    public static function setEm(Doctrine\Orm\EntityManager $em)
    {
        self::$o_em = $em;
    }

    /**
     * Set repository
     *
     * @param string $s_repo_name
     * @param Doctrine\Orm\EntityRepository $o_repository repository
     */
    public static function setRepository($s_repo_name, Doctrine\Orm\EntityRepository $o_repository)
    {
        self::$a_o_repositories[$s_repo_name] = $o_repository;
    }

    /**
     * Get repository
     *
     * @param  string $s_repo_name
     * @return Doctrine\Orm\EntityRepository
     */
    public static function getRepository($s_repo_name)
    {
        if (!isset(self::$a_o_repositories[$s_repo_name])) {
            self::$a_o_repositories[$s_repo_name] = self::getEm()->getRepository('\Domain\\' . $s_repo_name);
        }

        return self::$a_o_repositories[$s_repo_name];
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

    /**
     * @return Services\AtmService
     */
    public static function getAtmService()
    {
        if (null == self::$o_atm_service) {
            self::$o_atm_service = new \Services\AtmService();
        }

        return self::$o_atm_service;
    }

}