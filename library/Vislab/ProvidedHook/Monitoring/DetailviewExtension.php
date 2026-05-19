<?php

namespace Icinga\Module\Vislab\ProvidedHook\Monitoring;


use Icinga\Application\Logger;
use Icinga\Module\Monitoring\Hook\DetailviewExtensionHook;
use Icinga\Module\Monitoring\Object\MonitoredObject;
use Icinga\Module\Monitoring\Object\Host;
use Icinga\Module\Monitoring\Object\Service;
use Icinga\Module\Vislab\Helpers\GrapherHelper;
use ipl\Html\Html;
use ipl\Web\Compat\StyleWithNonce;
use Throwable;


class DetailviewExtension extends DetailviewExtensionHook
{

    protected $hasPreviews = true;
    protected $asDashboard = false;


    public function init()
    {

        parent::init();
    }

    public function has(MonitoredObject $object)
    {
        if (($object instanceof Host) || ($object instanceof Service)) {
            return true;
        } else {
            return false;
        }
    }


    public function getHtmlForObject(MonitoredObject $object)
    {

        $service = null;

        if($object instanceof Host){
            $host = $object->getName();
        }else{
            $service = $object->getName();
            $host=$object->host_name;
        }
        $check_command = $object->check_command;
        try {
            $grapher = new GrapherHelper($host,$check_command,false,$object->perfdata,$service);
            $div =  Html::tag('div',['name'=>'vislab-monitoring', 'class'=>'vislab-wrapper'],$grapher->getHtmlForObject());
            if(!$this->asDashboard){
                $graphStyle = (new StyleWithNonce());
                $graphStyle->addFor($div, $grapher->getStyleDefaults());
                $div->add($graphStyle);
            }
            return $div->render();

        }catch (Throwable $exception){
            Logger::error($exception->getMessage());
            Logger::error($exception->getTraceAsString());
        }
        return '';
    }
    public function setAsDashboard(bool $asDashboard)
    {
        $this->asDashboard = $asDashboard;
    }
}