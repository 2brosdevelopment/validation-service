# Installation & Setup [![Build Status](https://travis-ci.org/2brosdevelopment/validation-service.svg?branch=develop)](https://travis-ci.org/2brosdevelopment/validation-service)

## Composer
You can install this package via <a href="http://getcomposer.org">Composer</a> by running the command: `composer require "two_bros/ValidationService:~1.0"`.

Or by adding the package to your `composer.json`
```json
    {
        "require": {
            "two_bros/ValidationService": "~1.0"
        }
    }
```
Then install it via `composer install` or `composer update`

## Configuration
Once you have installed the package, you will need to register the Service Provider in your `config/app.php` under the `providers` array:
```php
    'providers' => [
        ...
        TwoBros\ValidationService\Providers\ValidationServiceProvider::class,
    ];
```
After adding the Service Provider to your `config/app.php`, you should publish the configuration from the package using: `php artisan vendor:publish`

This will create a file named `validation_service.php` in the configuration directory. This file will be utilized to add any custom validation rules you may create.

The format for this configuration file is:
```php
    return [
        'passwordStrength' => 'User@passwordStrength'
    ];
```
# Basic Usage

## Simple Validation

For each model that you need to validate, you can simply create a validation class and extend the `TwoBros\ValidationService\Services\Validation\LaravelValidator`.

```php
    use TwoBros\ValidationService\Services\Validation\LaravelValidator;
    
    class ModelCreateValidator extends LaravelValidator
    {
        protected $rules = [
            'name' => 'required|min:8'
        ];
        
    }
```

Now when you want to validate data, you can pass the data into the validator and determine if it passed or not.

```php
    $modelValidator = new ModelCreateValidator($this->app['validator']);
    
    if ($modelValidator->with($inputArray)
                       ->passes()) {
        // Do some stuff for passing
    } else {
        // Get the errors
        $validationErrors = $modelValidator->errors();
        
        // Do some stuff for failing
    }
```

## Custom Messages

If you want customize your validation messages, you can do this by passing the message array to the `with` method.

```php
    $messages = [
        'required' => 'The field :attribute is required'
    ];
    
    $modelValidator = new ModelCreateValidator($this->app['validator']);
    
    if ($modelValidator->with($inputArray, $messages)
                       ->passes()) {
        // Do some stuff for passing
    } else {
        // Get the errors
        $validationErrors = $modelValidator->errors();
        
        // Do some stuff for failing
    }            
```

Or by using the `withMessages` method of the validator.

```php
    $messages = [
        'required' => 'The field :attribute is required'
    ];
    
    $modelValidator = new ModelCreateValidator($this->app['validator']);
    
    if ($modelValidator->with($inputArray)
                       ->withMessages($messages)
                       ->passes()) {
        // Do some stuff for passing
    } else {
        // Get the errors
        $validationErrors = $modelValidator->errors();
        
        // Do some stuff for failing
    }
```

## Adding Uniqueness Requirements to Validation
There are times when you may want to use uniqueness, but when you are doing an update you need to use the id of current record to exclude the current record from the uniqueness check.

For this, you need to add a method to your validator class `addRuntimeValidationRules` that updates the rules with the ids needed.

```php
    use TwoBros\ValidationService\Services\Validation\LaravelValidator;
    
    class ModelCreateValidator extends LaravelValidator
    {
        protected $rules = [
            'name' => 'required|min:8',
            'email' => 'required|max:100|unique:users,email'
        ];
        
        public function addRuntimeValidationRules()
        {

            $this->rules[ 'email' ] = 'required|max:100|unique:users,email,' . $this->uniqueIds[ 'email' ];

            return $this;
        }
    }
```

You can then add the function to the call string, so you can customize this with the id needed upon validation.

```php
    $modelValidator = new ModelCreateValidator($this->app['validator']);
    
    if ($modelValidator->with($inputArray)
                       ->setUniqueId('email', $modelToUpdate->id)
                       ->addRuntimeValidationRules()
                       ->passes()) {
        // Do some stuff for passing
    } else {
        // Get the errors
        $validationErrors = $modelValidator->errors();
        
        // Do some stuff for failing
    }
```

You will note that you must use the `setUniqueId` method call to set the id of the current record. Also, instead of instantiating the validator class, you can use Laravel's IoC to bring it into the method.

```php

    public function update(ModelValidator $modelValidator) {

        if ($modelValidator->with($inputArray)
                           ->setUniqueId('email', $modelToUpdate->id)
                           ->addRuntimeValidationRules()
                           ->passes()) {
            // Do some stuff for passing
        } else {
            // Get the errors
            $validationErrors = $modelValidator->errors();
            
            // Do some stuff for failing
        }

    }
```

# License

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.