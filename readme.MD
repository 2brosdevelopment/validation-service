# Installation & Setup

## Composer
You can install this package via <a href="getcomposer.org">Composer</a> by running the command: `composer require "two_bros/ValidationService:~1.0"`.

Or by adding the package to your `composer.json`
<pre>
    <code>
    {
        "require": {
            "two_bros/ValidationService": "~1.0"
        }
    }
    </code>
</pre>

Then install it via `composer install` or `composer update`

## Configuration
Once you have installed the package, you will need to register the Service Provider in your `config/app.php` under the `providers` array:
<pre>
    <code>
        'providers' => [
            ...
            TwoBros\ValidationService\Providers\ValidationServiceProvider::class,
        ];
    </code>
</pre>

After adding the Service Provider to your `config/app.php`, you should publish the configuration from the package using: `php artisan vendor:publish`

This will create a file named `validation_service.php` in the configuration directory. This file will be utilized to add any custom validation rules you may create.

The format for this configuration file is:
<pre>
    <code>
        return [
            'passwordStrength' => 'User@passwordStrength'
        ];
    </code>
</pre>

# Basic Usage

For each model that you need to validate, you can simply create a validation class and extend the `TwoBros\ValidationService\Services\Validation\LaravelValidator`.

<pre>
    <code>
        ```php
            use TwoBros\ValidationService\Services\Validation\LaravelValidator;
            
            class ModelCreateValidator extends LaravelValidator
            {
                protected $rules = [
                    'name' => 'required|min:8'
                ];
                
                
            }
        ```
    </code>
</pre>

Now when you want to validate data, you can pass the data into the validator and determine if it passed or not.

<pre>
    <code>
        <?php
            $modelValidator = new ModelCreateValidator($this->app['validator']);
            
            if ($modelValidator->with($inputArray)->passes()) {
                // Do some stuff for passing
            } else {
                // Get the errors
                $validationErrors = $modelValidator->errors();
                
                // Do some stuff for failing
            }
        ?>
    </code>
</pre>

If you want customize your validation messages, you can do this by passing the message array to the `with` method.

<pre>
    <code>
        <?php
            $messages = [
                'required' => 'The field :attribute is required'
            ];
            
            $modelValidator = new ModelCreateValidator($this->app['validator']);
            
            if ($modelValidator->with($inputArray, $messages)->passes()) {
                // Do some stuff for passing
            } else {
                // Get the errors
                $validationErrors = $modelValidator->errors();
                
                // Do some stuff for failing
            }
            
        ?>
    </code>
</pre>

Or by using the `withMessages` method of the validator.

<pre>
    <code>
        <?php
            $messages = [
                'required' => 'The field :attribute is required'
            ];
            
            $modelValidator = new ModelCreateValidator($this->app['validator']);
            
            if ($modelValidator->with($inputArray)->withMessages($messages)->passes()) {
                // Do some stuff for passing
            } else {
                // Get the errors
                $validationErrors = $modelValidator->errors();
                
                // Do some stuff for failing
            }
            
        ?>
    </code>
</pre>
