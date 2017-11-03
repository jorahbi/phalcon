<?php

namespace Admin\Models;

use Phalcon\Validation;
use ArrayObject;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\StringLength;

class Admin extends \Admin\Entity\Admin
{
	/**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();
        $message = $this->getDI()->get('languageConfig')->validation;
        $validator->add('email', new PresenceOf([
                'model'   => $this,
                'message' => $message->notNull,
            ])
        );
        $validator->add('email', new EmailValidator([
                'model'   => $this,
                'message' => $message->email,
            ])
        );

        $validator->add('password', new PresenceOf([
                'model'   => $this,
                'message' => $message->notNull,
            ])
        );
        $validator->add('password', new StringLength ([
                'model'   => $this,
                //'message' => $message->validation->notNull,
                'max'           => 15,
	            'min'           => 6,
	            'messageMaximum' => $message->maximum,
	            'messageMinimum'=> $message->minimum,
            ])
        );
        $validator->setFilters('password', 'trim');
		$validator->setFilters('email', 'trim');

        return $this->validate($validator);
    }

    public function &getMessages()
    {
    	$messages = parent::getMessages() ?: [];
    	$result = ['error' => []];
    	foreach ($messages as $message) 
    	{
    		$result['error'][$message->getField()] = $message->getMessage();
    	}
    	return $result;
    }
}