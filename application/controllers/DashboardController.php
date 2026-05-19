<?php

namespace Icinga\Module\Vislab\Controllers;

use Icinga\Application\Modules\Module;
use Icinga\Module\Alerthub\Model\Service;
use Icinga\Module\Icingadb\Common\Auth;
use Icinga\Module\Icingadb\Common\Database;
use Icinga\Module\Icingadb\Model\Host;
use Icinga\Module\Vislab\ProvidedHook\Icingadb\HostDetailExtension;
use Icinga\Module\Vislab\ProvidedHook\Icingadb\ServiceDetailExtension;
use ipl\Html\Html;
use ipl\Stdlib\Filter;
use ipl\Web\Compat\CompatController;


class DashboardController extends CompatController
{


    public function indexAction()
    {
        $this->addTitleTab("No backend available");
        $this->addContent(Html::tag('p', [], t("Please enable icingadb and/or the monitoring module to use the vislab")));
    }

}
