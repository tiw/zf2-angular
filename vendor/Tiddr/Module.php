<?php

namespace Tiddr;

use ZfcBase\Module\AbstractModule;

/**
 * Description of Module
 *
 * @author wangting
 */
class Module extends AbstractModule
{

    public function getDir()
    {
        return __DIR__;
    }

    public function getNamespace()
    {
        return __NAMESPACE__;
    }

}

?>
