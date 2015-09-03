<?php
    namespace TwoBros\ValidationService\Contracts\Services\Validation;

    interface ValidableInterface
    {

        /**
         * with
         *
         * @param array $data
         * @param array $messages
         *
         * @return mixed
         * @internal param array $input
         *
         * @author   Vincent Sposato <vincent.sposato@gmail.com>
         * @version  v1.0
         */
        public function with( array $data, array $messages );

        /**
         * passes
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function passes();

        /**
         * errors
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function errors();

        /**
         * withMessages
         *
         * @param array $messages
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function withMessages( array $messages );
    }