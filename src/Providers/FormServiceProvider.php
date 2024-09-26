<?php

namespace LaravelCompany\Mail\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use LaravelCompany\Mail\View\Components\CheckboxField;
use LaravelCompany\Mail\View\Components\FieldWrapper;
use LaravelCompany\Mail\View\Components\FileField;
use LaravelCompany\Mail\View\Components\Label;
use LaravelCompany\Mail\View\Components\SelectField;
use LaravelCompany\Mail\View\Components\SubmitButton;
use LaravelCompany\Mail\View\Components\TextareaField;
use LaravelCompany\Mail\View\Components\TextField;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component(TextField::class, 'laravel-mail.text-field');
        Blade::component(TextareaField::class, 'laravel-mail.textarea-field');
        Blade::component(FileField::class, 'laravel-mail.file-field');
        Blade::component(SelectField::class, 'laravel-mail.select-field');
        Blade::component(CheckboxField::class, 'laravel-mail.checkbox-field');
        Blade::component(Label::class, 'laravel-mail.label');
        Blade::component(SubmitButton::class, 'laravel-mail.submit-button');
        Blade::component(FieldWrapper::class, 'laravel-mail.field-wrapper');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
