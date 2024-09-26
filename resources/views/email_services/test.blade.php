@extends('laravel-mail::layouts.app')

@section('heading')
    {{ __('Test Email Service') }}
@stop

@section('content')

    @component('laravel-mail::layouts.partials.card')
        @slot('cardHeader', __('Test Email Service') . ' : ' . $emailService->name)

        @slot('cardBody')
            <form action="{{ route('laravel-mail.email_services.test.store', $emailService->id) }}" method="POST" class="form-horizontal">
                @csrf

                <x-laravel-mail.text-field name="to" :label="__('To Email')" placeholder="Email To" required="required" />

                <x-laravel-mail.text-field name="from" :label="__('From Email')" placeholder="Email From" required="required" />

                <x-laravel-mail.text-field name="subject" :label="__('Subject')" placeholder="Email Subject" required="required" />

                <x-laravel-mail.textarea-field name="body" :label="__('Email Body')" required="required" rows="5">This is a test for the email service {{ $emailService->name }}</x-laravel-mail.textarea-field>

                <x-laravel-mail.submit-button :label="__('Test')" />
            </form>
        @endSlot
    @endcomponent

@stop


