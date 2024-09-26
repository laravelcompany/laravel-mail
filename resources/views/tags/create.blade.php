@extends('laravel-mail::layouts.app')

@section('title', __('New Tag'))

@section('heading')
    {{ __('Tags') }}
@stop

@section('content')

    @component('laravel-mail::layouts.partials.card')

        @slot('cardHeader', __('Create Tag'))

        @slot('cardBody')
            <form action="{{ route('laravel-mail.tags.store') }}" method="POST" class="form-horizontal">
                @csrf

                @include('laravel-mail::tags.partials.form')

                <x-laravel-mail.submit-button :label="__('Save')" />
            </form>
        @endSlot
    @endcomponent

@stop
