<?php
    namespace TwoBros\ValidationService\Tests;

    use Illuminate\Support\Facades\Config;
    use Mockery;
    use Orchestra\Testbench\TestCase;

    class StubValidatorTest extends TestCase
    {

        protected $stubValidator;

        /**
         * configMock
         *
         * @var \Illuminate\Config\Repository
         *
         */
        protected $configMock;

        /**
         * validationMock
         *
         * @var \Illuminate\Validation\Factory
         */
        protected $validationMock;

        public function setUp()
        {

            parent::setUp();
            $this->stubValidator = new StubValidator( $this->app[ 'validator' ] );
        }

        /**
         * tearDown
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function tearDown()
        {

            parent::tearDown();
            Mockery::close();
        }

        /**
         * testValidationWithGoodDataAndNoAddedRules
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function testValidationWithGoodDataAndNoAddedRules()
        {

            $goodData = [
                'email' => 'vincent@example.com',
                'name'  => 'Vincent Sposato'
            ];

            Config::shouldReceive( 'get' )
                  ->once()
                  ->with( 'validation_service' )
                  ->andReturn( [ ] );
            $validatedDataResults = $this->stubValidator->with( $goodData )
                                                        ->passes();

            $validationErrors = $this->stubValidator->errors();
            $this->assertTrue( $validatedDataResults, 'Good data failed validation!' );
            $this->assertEmpty( $validationErrors, 'Good data returned errors from validation!' );
        }

        /**
         * testValidationWithGoodDataAndAddedRules
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function testValidationWithGoodDataAndAddedRules()
        {

            $goodData = [
                'email' => 'vincent@example.com',
                'name'  => 'Vincent Sposato'
            ];

            Config::shouldReceive( 'get' )
                  ->once()
                  ->with( 'validation_service' )
                  ->andReturn( [ 'testExtendedValidation' => 'TwoBros\ValidationService\Tests\StubValidator@testExtendedValidation' ] );
            $validatedDataResults = $this->stubValidator->with( $goodData )
                                                        ->addRuntimeValidationRules()
                                                        ->passes();

            $validationErrors = $this->stubValidator->errors();
            $this->assertTrue( $validatedDataResults, 'Good data failed validation!' );
            $this->assertEmpty( $validationErrors, 'Good data returned errors from validation!' );
        }

        /**
         * testValidationWithBadDataAndNoAddedRules
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function testValidationWithBadDataAndNoAddedRules()
        {

            $badData = [
                'email' => 'vincent@example.com'
            ];

            Config::shouldReceive( 'get' )
                  ->once()
                  ->with( 'validation_service' )
                  ->andReturn( [ ] );
            $validatedDataResults = $this->stubValidator->with( $badData )
                                                        ->passes();

            $validationErrors = $this->stubValidator->errors();
            $this->assertFalse( $validatedDataResults, 'Bad data passed validation!' );
            $this->assertNotEmpty( $validationErrors->toArray(), 'Bad data did not return errors from validation!' );
        }

        /**
         * testValidationWithBadDataAndAddedRules
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function testValidationWithBadDataAndAddedRules()
        {

            $badData = [
                'email' => 'vincenzo@example.com',
                'name'  => 'Vincent Sposato'
            ];

            Config::shouldReceive( 'get' )
                  ->once()
                  ->with( 'validation_service' )
                  ->andReturn( [ 'testExtendedValidation' => 'TwoBros\ValidationService\Tests\StubValidator@testExtendedValidation' ] );
            $validatedDataResults = $this->stubValidator->with( $badData )
                                                        ->addRuntimeValidationRules()
                                                        ->passes();

            $validationErrors = $this->stubValidator->errors();
            $this->assertFalse( $validatedDataResults, 'Bad data passed validation!' );
            $this->assertNotEmpty( $validationErrors->toArray(), 'Bad data did not return errors from validation!' );
        }

        /**
         * testValidationWithBadDataAndAddedRulesAndMessages
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function testValidationWithBadDataAndAddedRulesAndMessages()
        {

            $badData = [
                'email' => 'vsposato@example.com'
            ];

            $customMessages = [
                'name.required' => 'This is a test message make sure it comes through'
            ];

            Config::shouldReceive( 'get' )
                  ->once()
                  ->with( 'validation_service' )
                  ->andReturn( [ 'testExtendedValidation' => 'TwoBros\ValidationService\Tests\StubValidator@testExtendedValidation' ] );
            $validatedDataResults = $this->stubValidator->with( $badData, $customMessages )
                                                        ->addRuntimeValidationRules()
                                                        ->passes();

            $validationErrors = $this->stubValidator->errors();
            $this->assertFalse( $validatedDataResults, 'Bad data passed validation!' );
            $this->assertNotEmpty( $validationErrors->toArray(), 'Bad data did not return errors from validation!' );
            $this->assertEquals( $validationErrors->first( 'name' ),
                'This is a test message make sure it comes through', 'Message not returned correctly' );
        }

        /**
         * testValidationWithBadDataAndAddedRulesAndWithMessages
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function testValidationWithBadDataAndAddedRulesAndWithMessages()
        {

            $badData = [
                'email' => 'vsposato@example.com'
            ];

            $customMessages = [
                'name.required' => 'This is a test message make sure it comes through'
            ];

            Config::shouldReceive( 'get' )
                  ->once()
                  ->with( 'validation_service' )
                  ->andReturn( [ 'testExtendedValidation' => 'TwoBros\ValidationService\Tests\StubValidator@testExtendedValidation' ] );
            $validatedDataResults = $this->stubValidator->with( $badData )
                                                        ->withMessages( $customMessages )
                                                        ->addRuntimeValidationRules()
                                                        ->passes();

            $validationErrors = $this->stubValidator->errors();
            $this->assertFalse( $validatedDataResults, 'Bad data passed validation!' );
            $this->assertNotEmpty( $validationErrors->toArray(), 'Bad data did not return errors from validation!' );
            $this->assertEquals( $validationErrors->first( 'name' ),
                'This is a test message make sure it comes through', 'Message not returned correctly' );
        }

        /**
         * testSetUniqueIdActuallySetsId
         *
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function testSetUniqueIdActuallySetsId()
        {

            $badData = [
                'email' => 'vsposato@example.com'
            ];

            $customMessages = [
                'name.required' => 'This is a test message make sure it comes through'
            ];

            $this->stubValidator->with( $badData )
                                ->setUniqueId( 'email', 1 )
                                ->addRuntimeValidationRules();

            $uniqueIds = $this->stubValidator->getUniqueIds();
            $this->assertEquals( $uniqueIds[ 'email' ], 1 );
        }

    }
