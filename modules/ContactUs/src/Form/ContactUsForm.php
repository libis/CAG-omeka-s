<?php
namespace ContactUs\Form;

use Zend\Filter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Validator;

class ContactUsForm extends Form
{
    public function init()
    {
        $question = $this->getOption('question');
        $checkAnswer = $this->getOption('checkAnswer');

        // "To" is used instead of "email" to avoid some basic spammers.
        $this->add([
            'name' => 'from',
            'type' => Element\Email::class,
            'options' => [
                'label' => 'E-mail: (verplicht)', // @translate
            ],
            'attributes' => [
                'id' => 'from',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'name',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Naam: (verplicht)', // @translate
            ],
            'attributes' => [
                'id' => 'name',
                'required' => false,
            ],
        ]);

        $this->add([
            'name' => 'message',
            'type' => Element\Textarea::class,
            'options' => [
                'label' => 'Bericht', // @translate
            ],
            'attributes' => [
                'id' => 'message',
                'required' => true,
            ],
        ]);

        $this->add([
            'name' => 'newsletter',
            'type' => Element\Checkbox::class,
            'options' => [
                'label' => 'Ik wil graag de nieuwsbrief en/of andere activiteiten van CAG en ICAG ontvangen via mail', // @translate
            ],
            'attributes' => [
                'id' => 'newsletter',
                'required' => false,
            ],
        ]);

        $this->add([
            'name' => 'privacy',
            'type' => Element\Checkbox::class,
            'options' => [
                'label' => 'Ik ga akkoord met de privacy statement', // @translate
            ],
            'attributes' => [
                'id' => 'privacy',
                'required' => false,
            ],
        ]);


        if ($question) {
            $this->add([
                'name' => 'answer',
                'type' => Element\Text::class,
                'options' => [
                    'label' => $question,
                ],
                'attributes' => [
                    'id' => 'answer',
                    'required' => true,
                ],
            ]);

            $this->add([
                'name' => 'check',
                'type' => Element\Hidden::class,
                'attributes' => [
                    'value' => substr(md5($question), 0, 16),
                ],
            ]);
        }

        $this->add([
            'name' => 'submit',
            'type' => Element\Submit::class,
            'attributes' => [
                'id' => 'submit',
                'class' => 'btn',
                'value' => 'Verzenden', // @translate
            ],
        ]);

        $inputFilter = $this->getInputFilter();
        $inputFilter->add([
            'name' => 'message',
            'required' => true,
            'filters' => [
                ['name' => Filter\StringTrim::class],
            ],
        ]);
        if ($question) {
            $inputFilter->add([
                'name' => 'answer',
                'required' => true,
                'filters' => [
                    ['name' => Filter\StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => Validator\Callback::class,
                        'options' => [
                            'callback' => function ($answer) use ($checkAnswer) {
                                return $answer === $checkAnswer;
                            },
                            'callbackOptions' => [
                                'checkAnswer' => $checkAnswer,
                            ],
                        ],
                    ],
                ],
            ]);
        }
    }
}
