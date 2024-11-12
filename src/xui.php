<?php

/**
 * @version 1.0.0
 * @author MrAfaz abolfazlmajidi100@gmail.com
 * @package NetBack
 * @license https://opensource.org/licenses/MIT
 * @link https://github.com/imafaz/NetBack
 * 
 */

namespace NetBack;

use EasyLog\Logger;
use phpseclib3\Net\SFTP;

/**
 * xui
 * @method __construct(string $name, string $ip, string $username, string $password, int $port, $logPath = '.' . DIRECTORY_SEPARATOR, $printLog = false)
 * @method backup(string $localPath ,string $databasePath = '/etc/x-ui/x-ui.db')
 */
class xui
{    
    /**
     * name
     *
     * @var string
     */
    public string $name;  
    
    
    /**
     * ip
     *
     * @var string
     */
    public string $ip;  
    
    
    /**
     * username
     *
     * @var string
     */
    public string $username;  
    
    
    /**
     * password
     *
     * @var string
     */
    public string $password;  
    
    
    /**
     * port
     *
     * @var int
     */
    public int $port;


    
    /**
     * logger
     *
     * @var object
     */
    private object $logger;


    
    /**
     * __construct
     *
     * @param  string $name
     * @param  string $ip
     * @param  string $username
     * @param  string $password
     * @param  int $port
     * @param  string $logPath
     * @param  string $printLog
     * @return void
     */
    public function __construct(string $name, string $ip, string $username, string $password, int $port, $logPath = '.' . DIRECTORY_SEPARATOR, $printLog = false)
    {
        $this->logger = new Logger($logPath . 'xui.log', $printLog);
        $this->name = $name;
        $this->ip = $ip;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
    }
    

    
    /**
     * backup
     *
     * @param  string $localPath
     * @param  string $databasePath
     * @return bool
     */
    public function backup(string $localPath ,string $databasePath = '/etc/x-ui/x-ui.db')
    {

        try {
            $sftp = new SFTP($this->ip, $this->port);
            if (!$sftp->login($this->username, $this->password)) {
                $this->logger->error('server ' . $this->name . 'failed authentication sftp.');
                return false;
            }
            if (!$sftp->get($databasePath, $localPath)){
                $this->logger->error('server ' . $this->name . 'failed download backup.');
                return false;
            }

        } catch (\Exception $e) {
            $this->logger->error('server ' . $this->name . 'connect error ' . $e->getMessage());
            return false;
        }
        return true;
    }
}
