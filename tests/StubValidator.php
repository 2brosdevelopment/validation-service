<?php
    namespace TwoBros\ValidationService\Tests;

    use TwoBros\ValidationService\Contracts\Services\Validation\ValidableInterface;
    use TwoBros\ValidationService\Services\Validation\LaravelValidator;

    class StubValidator extends LaravelValidator implements ValidableInterface
    {

        protected $rules = [
            'email' => 'required|email',
            'name'  => 'required'
        ];

        /**
         * testExtendedValidation
         *
         * custom validation for password strength
         *
         * @param $attribute
         * @param $value
         * @param $params
         *
         * @return bool
         */
        public function testExtendedValidation( $attribute, $value, $params )
        {

            return ( $attribute == 'email' && $value == 'vincenzo@example.com' ) ? false : true;
        }

        /**
         * addRuntimeValidationRules
         *
         * Need to add email rule to allow for unique values with current record
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function addRuntimeValidationRules()
        {

            $this->rules[ 'email' ] = 'required|testExtendedValidation';

            return $this;
        }

        /**
         * getUniqueIds
         *
         * Added merely for the purpose of testing rules
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function getUniqueIds()
        {

            return $this->uniqueIds;
        }

    }