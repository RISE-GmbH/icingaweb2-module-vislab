<?php

namespace Icinga\Module\Vislab\ProvidedHook\Icingadb;

use Icinga\Module\Icingadb\Hook\HostDetailExtensionHook;
use Icinga\Module\Icingadb\Model\Host;

use Icinga\Module\Vislab\Helpers\GrapherHelper;

use ipl\Html\Html;
use ipl\Html\ValidHtml;
use ipl\Web\Compat\StyleWithNonce;

class HostDetailExtension extends HostDetailExtensionHook
{
    protected $asDashboard = false;
    public function getHtmlForObject(Host $host): ValidHtml
    {
        $hostname = $host->name;
        $servicename = null;
        $perfdata = $host->state->performance_data;
        $command_name = $host->checkcommand_name;


        $grapher = new GrapherHelper($hostname,$command_name,true,$perfdata,$servicename);
        $div =  Html::tag('div',['name'=>'vislab-icingadb', 'class'=>'vislab-wrapper'],$grapher->getHtmlForObject());

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