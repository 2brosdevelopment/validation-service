<?php
    namespace TwoBros\ValidationService\Services\Validation;

    use TwoBros\ValidationService\Contracts\Services\Validation\ValidableInterface;

    abstract class AbstractValidator implements ValidableInterface
    {

        /**
         * validator
         *
         * @var ValidableInterface
         */
        protected $validator;

        /**
         * data
         *
         * @var array
         */
        protected $data = [ ];

        /**
         * rules
         *
         * @var array
         */
        protected $rules = [ ];

        /**
         * errors
         *
         * @var array
         */
        protected $errors = [ ];

        /**
         * messages
         *
         * @var array
         */
        protected $messages = [ ];

        /**
         * with
         *
         * @param array $data
         * @param array $messages
         *
         * @return $this
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function with( array $data, array $messages = [ ] )
        {

            $this->data = $data;

            if (!empty( $messages )) {
                $this->messages = array_merge( $this->messages, $messages );
            }

            return $this;
        }

        /**
         * withMessages
         *
         * @param array $messages
         *
         * @return $this
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function withMessages( array $messages )
        {

            $this->messages = array_merge( $this->messages, $messages );

            return $this;
        }

        /**
         * errors
         *
         * @return array
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function errors()
        {

            return $this->errors;
        }

        /**
         * passes
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        abstract public function passes();
    }
