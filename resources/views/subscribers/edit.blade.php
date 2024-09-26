@extends('laravel-mail::layouts.app')

@section('title', __("Edit Subscriber") . " : {$subscriber->full_name}")

@section('heading')
    {{ __('Subscribers') }}
@stop

@section('content')

    @component('laravel-mail::layouts.partials.card')
        @slot('cardHeader', __('Edit Subscriber'))

        @slot('cardBody')
            <form action="{{ route('laravel-mail.subscribers.update', $subscriber->id) }}" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')

                @include('laravel-mail::subscribers.partials.form')

                <x-laravel-mail.submit-button :label="__('Save')" />
            </form>
        @endSlot
    @endcomponent

@stop
