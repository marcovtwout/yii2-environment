<?php

namespace marcovtwout\YiiEnvironment;

use Exception;

/**
 * @name Environment
 * @author Marco van 't Wout | Tremani
 *
 * Simple class used to set configuration and debugging depending on environment.
 * Using this you can predefine configurations for use in different environments,
 * like _development, testing, staging and production_.
 *
 * @see README.md
 */
class Environment
{
    /**
     * Inherit key that can be used in configConsole
     */
    const INHERIT_KEY = 'inherit';
    
    /**
     * @var string name of env var to check
     */
    public $envVar = 'YII_ENVIRONMENT';
    
    /**
     * @var array list of valid modes
     */
    public $validModes = [
        100 => 'DEVELOPMENT',
        200 => 'TEST',
        300 => 'STAGING',
        400 => 'PRODUCTION'
    ];
        
    /**
     * @var array @see https://www.yiiframework.com/doc/guide/2.0/en/concept-configurations#environment-constants
     */
    public $modeToYiiEnvMap = [
        'DEVELOPMENT' => 'dev',
        'TEST' => 'test',
        'STAGING' => 'prod',
        'PRODUCTION' => 'prod'
    ];
    
    /**
     * @var bool debug on/off
     */
    public $yiiDebug;
    
    /**
     * @var array web config array
     */
    public $configWeb;
    
    /**
     * @var array console config array
     */
    public $configConsole;
        
    /**
     * @var string selected environment mode
     */
    protected $mode;

    /**
     * @var string config dir
     */
    protected $configDir;
    
    /**
     * Initilizes the Environment class with the given mode
     * @param string $mode used to override automatically setting mode
     * @param string $configDir override default configDir
     * @throws Exception
     */
    public function __construct($mode = null, $configDir = null)
    {
        $this->setConfigDir($configDir);
        $this->setMode($mode);
        $this->setEnvironment();
    }
    
    /**     
     * @return string Yii2 environment.
     */
    public function getYiiEnv()
    {
        return $this->modeToYiiEnvMap[$this->mode];
    }

    /**
     * Set config dir.
     * @param string|null $configDir
     */
    protected function setConfigDir($configDir)
    {
        if ($configDir !== null) {
            $this->configDir = rtrim($configDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        } else {
            $this->configDir = __DIR__ . '/../../../config/';
        }
    }

    /**
     * Set environment mode, if valid mode can be determined.
     * @param string $mode if left empty, determine automatically
     */
    protected function setMode($mode = null)
    {
        // If not overridden, determine automatically
        if ($mode === null) {
            $mode = $this->determineMode();
        }

        // Check if mode is valid
        $mode = strtoupper($mode);
        if (!in_array($mode, $this->validModes, true)) {
            throw new Exception('Invalid environment mode supplied or selected.');
        }

        $this->mode = $mode;
    }

    /**
     * Determine current environment mode depending on environment variable.
     * Also checks if there is a mode file that might override this environment.
     * Override this function if you want to implement your own method.
     * @return string mode
     */
    protected function determineMode()
    {
        if (file_exists($this->getModeFilePath())) {
            // Is there a mode file?
            $mode = trim(file_get_contents($this->getModeFilePath()));
        } else {
            // Else, return mode based on environment var
            $mode = getenv($this->envVar);
            if ($mode === false) {
                throw new Exception('"Environment mode cannot be determined, see class for instructions.');
            }
        }
        return $mode;
    }

    /**
     * @return string mode file path
     */
    protected function getModeFilePath()
    {
        return $this->configDir . 'mode.php';
    }

    /**
     * Load and merge config files into one array.
     * @return array $config array to be processed by setEnvironment.
     */
    protected function getConfig()
    {
        // Load main config
        $fileMainConfig = $this->configDir . 'main.php';
        if (!file_exists($fileMainConfig)) {
            throw new Exception('Cannot find main config file "' . $fileMainConfig . '".');
        }
        $configMain = require($fileMainConfig);

        // Load specific config
        $fileSpecificConfig = $this->configDir . 'mode_' . strtolower($this->mode) . '.php';
        if (!file_exists($fileSpecificConfig)) {
            throw new Exception('Cannot find mode specific config file "' . $fileSpecificConfig . '".');
        }
        $configSpecific = require($fileSpecificConfig);

        // Merge specific config into main config
        $config = self::mergeArray($configMain, $configSpecific);

        // If one exists, load and merge local config
        $fileLocalConfig = $this->configDir . 'local.php';
        if (file_exists($fileLocalConfig)) {
            $configLocal = require($fileLocalConfig);
            $config = self::mergeArray($config, $configLocal);
        }

        // Return
        return $config;
    }

    /**
     * Sets the environment and configuration for the selected mode.
     */
    protected function setEnvironment()
    {
        $config = $this->getConfig();

        // Set attributes
        $this->yiiDebug = $config['yiiDebug'];
        $this->configWeb = $config['configWeb'];
        $this->configWeb['params']['environment'] = strtolower($this->mode);

        // Set console attributes and related actions
        if (isset($config['configConsole']) && !empty($config['configConsole'])) {
            $this->configConsole = $config['configConsole'];
            $this->processInherits($this->configConsole); // Process configConsole for inherits
            $this->configConsole['params']['environment'] = strtolower($this->mode);
        }
    }

    /**
     * Merges two arrays into one recursively.
     * @param array $a array to be merged to
     * @param array $b array to be merged from
     * @return array the merged array (the original arrays are not changed.)
     *
     * Taken from Yii's CMap::mergeArray, since php does not supply a native
     * function that produces the required result.
     * @see http://www.yiiframework.com/doc/api/1.1/CMap#mergeArray-detail
     */
    protected static function mergeArray($a, $b)
    {
        foreach ($b as $k => $v) {
            if (is_integer($k)) {
                $a[] = $v;
            } elseif (is_array($v) && isset($a[$k]) && is_array($a[$k])) {
                $a[$k] = self::mergeArray($a[$k], $v);
            } else {
                $a[$k] = $v;
            }
        }
        return $a;
    }

    /**
     * Loop through console config array, replacing values called 'inherit' by values from $this->configWeb
     * @param array $array target array
     * @param array $path array that keeps track of current path
     */
    private function processInherits(&$array, $path = [])
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $this->processInherits($value, array_merge($path, [$key]));
            }

            if ($value === self::INHERIT_KEY) {
                $value = $this->getValueFromArray($this->configWeb, array_reverse(array_merge($path, [$key])));
            }
        }
    }

    /**
     * Walk $array through $path until the end, and return value
     * @param array $array target
     * @param array $path path array, from deep key to shallow key
     * @return mixed
     */
    private function getValueFromArray(&$array, $path)
    {
        if (count($path) > 1) {
            $key = end($path);
            return $this->getValueFromArray($array[array_pop($path)], $path);
        } else {
            return $array[reset($path)];
        }
    }
}
