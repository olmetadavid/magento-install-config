<?php

class Clever_InstallConfig_Model_Installer extends Mage_Install_Model_Installer
{

    /**
     * Database installation
     *
     * @return Mage_Install_Model_Installer
     */
    public function installDb()
    {
        // Call the standard installation.
        parent::installDb();

        // Get custom data.
        $data = $this->getDataModel()->getCustomData();

        // Get the setup to add all config.
        $setupModel = Mage::getResourceModel('core/setup', 'core_setup');

        // Get console to retrieve arg name.
        $console = Mage::getModel('install/installer_console');

        // Install each config.
        foreach ($data[$console->getArgName()] as $config) {
            $setupModel->setConfigData($config['path'], $config['value']);
        }

        return $this;
    }

}