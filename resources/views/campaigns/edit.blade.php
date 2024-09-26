@extends('laravel-mail::layouts.app')

@section('title', __('Edit Campaign'))

@section('heading')
    {{ __('Edit Campaign') }}
@stop

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header text-white">
                        {{ __('Edit Campaign') }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('laravel-mail.campaigns.update', $campaign->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            @include('laravel-mail::campaigns.partials.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
