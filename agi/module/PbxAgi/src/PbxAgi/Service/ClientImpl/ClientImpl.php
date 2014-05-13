<?php
namespace PbxAgi\Service\ClientImpl;

use PAGI\Client\AbstractClient;
use PAGI\Exception\PAGIException;
use Zend\Console\Console;
use PbxAgi\Service\ClientImpl\ClientImplInterface;
use PbxAgi\Service\ClientImpl\Peer;
use PbxAgi\Service\ChannelVarManager\ChannelVarManagerInterface;

class ClientImpl extends AbstractClient implements ClientImplInterface
{

 
    /**
     * Current instance.
     * 
     * @var ClientImpl
     */
    private static $_instance = false;

    /**
     * AGI input
     * 
     * @var stream
     */
    private $_input;

    /**
     * AGI output
     * 
     * @var stream
     */
    private $_output;

    /**
     * Sends a command to asterisk.
     * Returns an array with:
     * [0] => AGI Result (3 digits)
     * [1] => Command result
     * [2] => Result data.
     *
     * @param string $text
     *            Command
     *            
     * @throws ChannelDownException
     * @throws InvalidCommandException
     *
     * @return Result
     */
    protected function send($text)
    {
        // $text .= "\n";
        $len = strlen($text);
        $console = $this->getConsole();
        $console->writeLine($text);
        do {
            $res = $console->readLine();
        } while (strlen($res) == 0);
        // var_dump($res);
        // $res=substr($res, 0, -2);
        return $this->getResultFromResultString($res);
    }

    /**
     * Opens connection to agi.
     * Will also read initial channel variables given
     * by asterisk when launching the agi.
     *
     * @return void
     */
    protected function open()
    {
        $console = $this->getConsole();
        
        while (true) {
          $line = $console->readLine();
            if ($line="\n") {
                break;
            }
            $this->readEnvironmentVariable($line);
        }
    }

    /**
     * Closes the connection to agi.
     *
     * @return void
     */
    protected function close()
    {}

    /**
     * Reads input from asterisk.
     *
     * @throws PAGIException
     *
     * @return string
     */
    protected function read()
    {
        $console = $this->getConsole();
        $line = $console->readLine();
        // if ($line === false) {
        // throw new PAGIException('Could not read from AGI');
        // }
        $line = substr($line, 0, - 1);
        return $line;
    }

    /**
     * Returns a client instance for this call.
     *
     * @param array $options
     *            Optional properties.
     *            
     * @return ClientImpl
     */
    public static function getInstance(array $options = array())
    {
        if (self::$_instance === false) {
            $ret = new ClientImpl($options);
            self::$_instance = $ret;
        } else {
            $ret = self::$_instance;
        }
        return $ret;
    }

    /**
     * Constructor.
     *
     * Note: The client accepts an array with options. The available options are
     *
     * log4php.properties => Optional. If set, should contain the absolute
     * path to the log4php.properties file.
     *
     * stdin => Optional. If set, should contain an already open stream from
     * where the client will read data (useful to make it interact with fastagi
     * servers or even text files to mock stuff when testing). If not set, stdin
     * will be used by the client.
     *
     * stdout => Optional. Same as stdin but for the output of the client.
     *
     * @param array $options
     *            Optional properties.
     *            
     * @return void
     */
    private function getConsole()
    {
        return Console::getInstance();
    }
    // public function errorHandler($type, $message, $file, $line) {};
    
    /**
     * Your signal handler.
     * Be careful when implementing this one.
     *
     * @param integer $signal
     *            Signal catched.
     *            
     * @return void
     */
    // public function signalHandler($signal) {};
    
    /**
     * Returns AGI Client.
     *
     * @return IClient
     */
    /*
     * public function set_hangup_handler($callable) { pcntl_signal(SIGHUP, $callable); }
     */
    public function fatal_handler()
    {
        $error = error_get_last();
        if ($error !== NULL) {
            $loggerFacade = $this->getAsteriskLogger();
            $loggerFacade->error('PHP Unhandled Exception ');
            $this->consoleLog(implode("\n", $error));
            foreach ($error as $err) {
                $loggerFacade->error($err);
            }
            $this->hangup();
            exit();
        }
    }

    public function exception_handler($e)
    {
        $this->log($e->getMessage());
        $this->hangup();
    }

    public function __construct()
    {
        /*
         * $signalHandler = array($this, 'signalHandler'); pcntl_signal(SIGINT, $signalHandler); pcntl_signal(SIGQUIT, $signalHandler); pcntl_signal(SIGTERM, $signalHandler); pcntl_signal(SIGHUP, $signalHandler); pcntl_signal(SIGUSR1, $signalHandler); pcntl_signal(SIGUSR2, $signalHandler); pcntl_signal(SIGCHLD, $signalHandler); pcntl_signal(SIGALRM, $signalHandler);
         */
        // set_error_handler(array($this, 'errorHandler'));
        set_exception_handler(array(
            $this,
            'exception_handler'
        ));
        $this->open();
        register_shutdown_function(array(
            $this,
            "fatal_handler"
        ));
        error_reporting('stderr');
        @ini_set('display_errors', 0); // nothing should disturb stdout interaction
                                           // set_error_handler(array($this, 'errorHandler'));
                                           // set_exception_handler(array($this, 'exception_handler'));

        $language = ChannelVarManagerInterface::CH_LANGUAGE_TYPE_RU;
        $this->exec('Set',array("CHANNEL(language)=\"{$language}\""));
        
        // throw new \Exception('yo', 3, null);
    }

  
    public function StreamMultiple($files, $escapeDigits, $postSilenceSeconds = null)
    {
        foreach ($files as $file) {
            $result = $this->streamFile($file, $escapeDigits);
            if (! $result->isTimeout())
                break;
        }
        if (! $result->isTimeout()) {
            $result = $this->StreamSilence($postSilenceSeconds, $escapeDigits);
        }
        return $result;
    }

    public function StreamSilence($seconds, $escapeDigits)
    {
        return $this->StreamMultiple('silence', $this->prepareSilence($seconds), $escapeDigits);
    }

    protected function prepareSilence($seconds)
    {
        $silenceFile = $this->getSilenceFile();
        $silence = array();
        $quotient = $seconds / 9;
        $modulus = $seconds % 9;
        $silenceadd[]=(0 == $modulus) ? '' : "{$silenceFile}/{$modulus}";
        array_merge($silence, array_fill(0, $quotient, "{$silenceFile}/9"));
        return $silence;
    }
}
