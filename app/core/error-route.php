<?php

class ErrorRoute extends ErrorRouteBase
{
    static function page404()
    {
        $path = '404.php';

        try {
            parent::prepareData(StatusCodes::HTTP_NOT_FOUND, $path);
            parent::sendDefaultHeaders();
        } catch (Exception $e) {
//            todo: throw and handle 500 error
            echo "<script>alert('500');</script>";
            throw $e;
        }

        exit;
    }
}

class ErrorRouteBase
{
    protected const HTTP_HEADER_KEY = 'http_header';
    protected const STATUS_HEADER_KEY = 'status_header';
    protected const LOCATION_HEADER_KEY = 'location_header';
    protected const STATUS_CODE_KEY = 'status_code';
    protected const HOST_KEY = 'host';

    private static  $config;


    /**
     * Prepare header data to send back to client
     * @param int $status_code - HTTP Response status code
     * @param string $path - Where redirect client to (default = [status_code])
     * @return Config - Configurations
     * @throws Exception - If required configuration missing
     */
    protected static function prepareData(int $status_code, string $path = '')
    {
//        Create new instance
        self::$config = new Config();

//        if no path given then set it as status_code
        $path = $path ? $path : $status_code;
        self::$config->setConfig(self::STATUS_CODE_KEY, $status_code);

        self::appendHost();
        self::appendHeaders($path);

        return self::$config;
    }


    /**
     * Append headers to configuration
     * @param string $path - where redirect client to
     * @throws Exception - if missing required configuration
     */
    private static function appendHeaders(string $path)
    {
        $code = self::$config->getConfig(self::STATUS_CODE_KEY);
        $host = self::$config->getConfig(self::HOST_KEY);

        self::$config->setConfig(self::HTTP_HEADER_KEY, StatusCodes::httpHeaderFor($code));
        self::$config->setConfig(self::STATUS_HEADER_KEY, 'Status: ' . StatusCodes::getMessageForCode($code));
        self::$config->setConfig(self::LOCATION_HEADER_KEY, 'Location: ' . $host . '/' . $path);
    }


    /**
     * Appends host to configuration
     */
    private static function appendHost()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']) ? "https://" : "http://");

        self::$config->setConfig(self::HOST_KEY, $protocol . $_SERVER['HTTP_HOST']);
    }

    /**
     * Sends headers to client
     * @throws Exception - If required configuration missing
     */
    protected static function sendDefaultHeaders()
    {
        header(self::$config->getConfig(self::HTTP_HEADER_KEY));
        header(self::$config->getConfig(self::STATUS_HEADER_KEY));
        header(self::$config->getConfig(self::HOST_KEY));
    }
}

class Config
{
    private  $config;

    public function __construct()
    {
        $this->config = [];
    }

    /**
     * Get Configuration value
     * @param $key
     * @return mixed
     * @throws Exception - If key not exists
     */
    public function getConfig($key)
    {
        if (!empty($this->config[$key])) {
            return $this->config[$key];
        } else {
            throw new Exception('Missing configuration: ' . $key);
        }
    }

    public function setConfig($key, $val): void
    {
        $this->config[$key] = $val;
    }
}