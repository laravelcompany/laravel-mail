@extends('laravel-mail::layouts.app')

@section('title', __("Edit Tag"))

@section('heading')
    {{ __('Tags') }}
@stop

@section('content')

    @component('laravel-mail::layouts.partials.card')
        @slot('cardHeader', __('Edit Tag'))

        @slot('cardBody')
            <form action="{{ route('laravel-mail.tags.update', $tag->id) }}" method="POST" class="form-horizontal">
                @csrf
                @method('PUT')

                @include('laravel-mail::tags.partials.form')

                <x-laravel-mail.submit-button :label="__('Save')" />
            </form>
        @endSlot
    @endcomponent

@stop
