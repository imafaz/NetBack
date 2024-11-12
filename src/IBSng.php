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
use phpseclib3\Net\SSH2;
use phpseclib3\Net\SFTP;


/**
 * IBSng
 * @method __construct(string $name, string $ip, string $username, string $password, int $port, $logPath = '.' . DIRECTORY_SEPARATOR, $printLog = false)
 * @method backup(string $localPath, string $pgPath = '/var/lib/pgsql')
 */
class IBSng
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
     * @var mixed
     */
    public string $port;


    /**
     * loggger object
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
    public function __construct(string $name, string $ip, string $username, string $password, int $port,string $logPath = '.' . DIRECTORY_SEPARATOR, $printLog = false)
    {
        $this->logger = new Logger($logPath . 'ibsng.log', $printLog);
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
     * @param  string $pgPath
     * @return void
     */
    public function backup(string $localPath, string $pgPath = '/var/lib/pgsql')
    {

        try {
            $ssh = new SSH2($this->ip, $this->port);
            if (!$ssh->login($this->username, $this->password)) {
                $this->logger->error('server ' . $this->name . 'failed authentication ssh2.');
                return false;
            }
            if (!$ssh->exec("su postgres -c \"pg_dump IBSng > $pgPath/IBSng.sql\"")) {
                $this->logger->error('server ' . $this->name . 'failed run backup command.');
                return false;
            }
            $ssh->disconnect();
            $sftp = new SFTP($this->ip, $this->port);
            if (!$sftp->login($this->username, $this->password)) {
                $this->logger->error('server ' . $this->name . 'failed authentication sftp.');
                return false;
            }
            if (!$sftp->get("$pgPath/IBSng.sql", $localPath)) {
                $this->logger->error('server ' . $this->name . 'failed download backup.');
                return false;
            }
            if (!$sftp->delete("$pgPath/IBSng.sql")) {
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
