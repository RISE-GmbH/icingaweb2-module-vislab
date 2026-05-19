<?php

namespace Icinga\Module\Vislab\ProvidedHook\Icingadb;

use Icinga\Module\Icingadb\Hook\ServiceDetailExtensionHook;
use Icinga\Module\Icingadb\Model\Service;

use Icinga\Module\Vislab\Helpers\GrapherHelper;

use ipl\Html\Html;
use ipl\Html\ValidHtml;
use ipl\Web\Compat\StyleWithNonce;

class ServiceDetailExtension extends ServiceDetailExtensionHook
{
    protected $asDashboard = false;

    public function getHtmlForObject(Service $service): ValidHtml
    {
        $hostname = $service->host->name;
        $servicename = $service->name;
        $perfdata = $service->state->performance_data;
        $command_name = $service->checkcommand_name;


        $grapher = new GrapherHelper($hostname,$command_name,true,$perfdata,$servicename);
        $div = Html::tag('div',['name'=>'vislab-icingadb', 'class'=>'vislab-wrapper'],$grapher->getHtmlForObject());

        if(!$this->asDashboard){
            $graphStyle = (new StyleWithNonce());
            $graphStyle->addFor($div, $grapher->getStyleDefaults());
            $div->add($graphStyle);
        }

        return $div;
    }
    public function setAsDashboard(bool $asDashboard)
    {
        $this->asDashboard = $asDashboard;
    }
}