@extends('laravel-mail::layouts.app')

@section('heading')
    {{ __('Email Services') }}
@stop

@section('content')

    @component('laravel-mail::layouts.partials.card')

        @slot('cardHeader', __('Edit Email Service'))

        @slot('cardBody')
            <form action="{{ route('laravel-mail.email_services.update', $emailService->id) }}" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')

                <x-laravel-mail.text-field name="name" :label="__('Name')" :value="$emailService->name" />

                @include('laravel-mail::email_services.options.' . strtolower($emailServiceType->name), ['settings' => $emailService->settings])

                <x-laravel-mail.submit-button :label="__('Update')" />
            </form>
        @endSlot
    @endcomponent

@stop
