<?php

    namespace TwoBros\ValidationService\Providers;

    use Illuminate\Support\ServiceProvider;

    class ValidationServiceProvider extends ServiceProvider
    {

        /**
         * Bootstrap the application services.
         *
         * @return void
         */
        public function boot()
        {

            // Need to publish our configuration
            $this->publishes( [
                __DIR__ . '/../Config/validation_service.php' => config_path( 'validation_service.php' )
            ] );
        }

        /**
         * Register the application services.
         *
         * @return void
         */
        public function register()
        {
            //
        }
    }
