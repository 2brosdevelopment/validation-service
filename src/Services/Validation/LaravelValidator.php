<?php
    namespace TwoBros\ValidationService\Services\Validation;

    use Illuminate\Config\Repository;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Factory;

    class LaravelValidator extends AbstractValidator
    {

        /**
         * validator
         *
         * @var \Illuminate\Validation\Factory
         */
        protected $validator;

        /**
         * uniqueIds
         *
         * @var array
         */
        protected $uniqueIds = [ ];
        /**
         * repository
         *
         * @var Repository
         */
        protected $repository;

        /**
         * @param Factory $validator
         */
        public function __construct( Factory $validator )
        {

            $this->validator = $validator;

        }

        /**
         * loadCustomValidation
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         * @return boolean
         */
        private function loadCustomValidation()
        {

            $customValidations = Config::get( 'validation_service' );

            if (( sizeof( $customValidations ) === 0 ) || ( !is_array( $customValidations ) )) {
                return true;
            }

            // Loop through our custom validations, and add them to the extender
            foreach ($customValidations as $validationName => $validationClassMethod) {
                Validator::extend( $validationName, $validationClassMethod );
            }

            return true;
        }

        /**
         * passes
         *
         * @return bool
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function passes()
        {

            // Load the custom validation rules
            $this->loadCustomValidation();

            $validator = $this->validator->make( $this->data, $this->rules, $this->messages );

            if ($validator->fails()) {
                $this->errors = $validator->messages();

                return false;
            }

            return true;
        }

        /**
         * setUniqueId
         *
         * @param $fieldName
         * @param $primaryKey
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         * @return $this
         */
        public function setUniqueId( $fieldName, $primaryKey )
        {

            $this->uniqueIds[ $fieldName ] = $primaryKey;

            return $this;
        }

    }
