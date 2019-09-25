<?php
namespace OaiPmhHarvester\Form;

use Zend\Form\Element;
use Omeka\Form\Element\ResourceTemplateSelect;
use Zend\Form\Form;

class HarvestForm extends Form
{
    public function init()
    {
        $this->setAttribute('action', 'oaipmhharvester/sets');

        $this->add([
            'name' => 'base_url',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Base URL', // @translate
                'info' => 'The base URL of the OAI-PMH data provider.', // @translate
            ],
            'attributes' => [
                'id' => 'base_url',
                'required' => 'true',
                'value' => 'http://localhost/bacasable/oai-pmh-repository/request',
                'size' => 60,
            ],
        ]);


        $this->add([
            'name' => 'resource_template',
            'type' => ResourceTemplateSelect::class,
            'options' => [
                'label' => 'Resource template', // @translate
                'empty_option' => '',
            ],
            'attributes' => [
                'class' => 'chosen-select',
                'data-placeholder' => 'Resource template',
                'id' => 'resource_template',
            ],
        ]);

        $inputFilter = $this->getInputFilter();
        $inputFilter->add([
            'name' => 'base_url',
            'required' => true,
        ]);
    }
}
