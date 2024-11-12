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


use phpseclib3\Net\SSH2;
use phpseclib3\Net\SFTP;
use EasyLog\Logger;

/**
 * Mikrotik
 * @method void __construct(string $name, string $ip, string $username, string $password, int $port, $logPath = '.' . DIRECTORY_SEPARATOR, $printLog = false)
 * @method bool backup(string $backupName,string $localPath)
 */
class Mikrotik
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
    var string $ip;




    /**
     * username
     *
     * @var string
     */
    var string $username;




    /**
     * password
     *
     * @var string
     */
    var string $password;



    /**
     * port
     *
     * @var int
     */
    var int $port;

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
     * @param  bool $printLog
     * @return void
     */
    public function __construct(string $name, string $ip, string $username, string $password, int $port, $logPath = '.' . DIRECTORY_SEPARATOR, $printLog = false)
    {
        $this->logger = new Logger($logPath . 'mikrotik.log', $printLog);
        $this->name = $name;
        $this->ip = $ip;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
    }

    /**
     * backup
     *
     * @param  string $backupName
     * @param  string $localPath
     * @return bool
     */
    public function backup(string $backupName, string $localPath)
    {

        try {
            $ssh = new SSH2($this->ip, $this->port);
            if (!$ssh->login($this->username, $this->password)) {
                $this->logger->error('server ' . $this->name . 'failed authentication ssh2.');
                return false;
            }
            if (!$ssh->exec("/system/backup/save dont-encrypt=yes name=$backupName")) {
                $this->logger->error('server ' . $this->name . 'failed run backup command.');
                return false;
            }
            $ssh->disconnect();
            $sftp = new SFTP($this->ip, $this->port);
            if (!$sftp->login($this->username, $this->password)) {
                $this->logger->error('server ' . $this->name . 'failed authentication sftp.');
                return false;
            }
            if (!$sftp->get($backupName . '.backup', $localPath)) {
                $this->logger->error('server ' . $this->name . 'failed download backup.');
                return false;
            }
            if (!$sftp->delete($backupName . '.backup')) {
                $this->logger->error('server ' . $this->name . 'failed remove backup.');
                return false;
            }
        } catch (\Exception $e) {
            $this->logger->error('server ' . $this->name . 'connect error ' . $e->getMessage());
            return false;
        }
        return true;
    }
}
