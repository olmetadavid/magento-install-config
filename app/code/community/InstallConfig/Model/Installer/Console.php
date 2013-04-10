<?php

class Clever_InstallConfig_Model_Installer_Console extends Mage_Install_Model_Installer_Console
{

    protected $argName = 'config';

    /**
     * Get the arg name.
     *
     * @return string
     *   The arg name of custome configuration.
     */
    public function getArgName()
    {
        return $this->argName;
    }

    /**
     * Set and validate arguments
     *
     * @param array $args
     * @return boolean
     */
    public function setArgs($args = null)
    {
        parent::setArgs($args);

        if (empty($args)) {
            // take server args
            $args = $_SERVER['argv'];
        }

        // Parse arguments and store all relative to additional config data.
        $currentArg = false;
        $match = false;
        $arguments = array();
        foreach ($args as $arg) {
            if (preg_match('/^--config(.*)$/', $arg, $match)) {
                // argument name
                //$currentArg = $match[1];
                $currentArg = count($arguments);
                // in case if argument doesn't need a value
                $arguments[$currentArg] = true;
            }
            else {
                // argument value
                if ($currentArg !== false) {

                    // Get the path and the value.
                    $parts = explode('::', $arg);
                    if (count($parts) != 2) {
                        unset($arguments[$currentArg]);
                    }
                    else {
                        $arguments[$currentArg] = array(
                            'path' => $parts[0],
                            'value' => $parts[1],
                        );
                    }
                }
                $currentArg = false;
            }
        }

        $this->_args[$this->argName] = $arguments;

        return true;
    }

    /**
     * Prepare data ans save it in data model
     *
     * @return Mage_Install_Model_Installer_Console
     */
    protected function _prepareData()
    {
        parent::_prepareData();

        $this->_getDataModel()->setCustomData(array(
            $this->argName => $this->_args[$this->argName],
        ));

        return $this;
    }

}