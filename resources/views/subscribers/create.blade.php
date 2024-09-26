@extends('laravel-mail::layouts.app')

@section('title', __('New Subscriber'))

@section('heading')
    {{ __('Subscribers') }}
@stop

@section('content')

    @component('laravel-mail::layouts.partials.card')
        @slot('cardHeader', __('Create Subscriber'))

        @slot('cardBody')
            <form action="{{ route('laravel-mail.subscribers.store') }}" class="form-horizontal" method="POST">
                @csrf
                @include('laravel-mail::subscribers.partials.form')

                <x-laravel-mail.submit-button :label="__('Save')" />
            </form>
        @endSlot
    @endcomponent

@stop
