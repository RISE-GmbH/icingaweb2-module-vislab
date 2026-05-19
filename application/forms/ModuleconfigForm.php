<?php
// Icinga Reporting | (c) 2019 Icinga GmbH | GPLv2

namespace Icinga\Module\Vislab\Forms;

use Icinga\Application\Config;
use Icinga\Forms\ConfigForm;

class ModuleconfigForm extends ConfigForm
{
    protected static $dummyPassword = '_web_form_m0r34m4z1n6n1ck';

    public function init()
    {

        $this->setName('vislab_settings');
        $this->setSubmitLabel($this->translate('Save Changes'));
    }

    public function createElements(array $formData)
    {
        $backends = [];
        $query  = Config::module('vislab', 'resources', true)->getConfigObject()
            ->setKeyColumn('name')
            ->select()
            ->order('name');
        foreach($query as $name => $value){
            $backends[$name]=$name;
        }
        $this->addElement('select', 'settings_backend', [
            'label' => $this->translate('Backend'),
            'required' => true,
            'multiOptions' => $backends
        ]);

        $this->addElement('select', 'settings_dashboardbackend', [
            'label' => $this->translate('Dasboard Backend'),
            'required' => true,
            'multiOptions' => ['icingadb'=>'icingadb', 'monitoring'=>'monitoring (ido)']
        ]);

        $this->addElement('checkbox','settings_showthresholds',
            [
                'label' => $this->translate('Show Thresholds in Graph'),
                'required' => false,
                'description' => $this->translate(
                    'Whether we should enable or disable The lines for the thresholds'
                ),
                'value' => 0
            ]
        );

        $this->addElement('checkbox','settings_nojs',
            [
                'label' => $this->translate('No JavaScript'),
                'required' => false,
                'description' => $this->translate(
                    'Whether to use the javascript less gnuplot implementation'
                ),
                'value' => 0
            ]
        );

        $this->addElement('number', 'settings_hook_max_width_value', [
            'label' => $this->translate('Hook max width (value)'),
            'description' => $this->translate(
                'Maximum width of the graph container on host/service detail view (hook only, not dashlets). Value is in percent or pixels depending on unit.'
            ),
            'required' => true,
            'value' => 100,

        ]);

        $this->addElement('select', 'settings_hook_max_width_unit', [
            'label' => $this->translate('Hook max width (unit)'),
            'description' => $this->translate('Unit for the hook max width value.'),
            'required' => true,
            'multiOptions' => ['percent' => $this->translate('Percent'), 'pixel' => $this->translate('Pixel')],
            'value' => 'percent'
        ]);

    }
}