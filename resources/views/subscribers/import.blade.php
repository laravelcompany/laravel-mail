@extends('laravel-mail::layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/css/bootstrap-select.min.css">
@endpush

@section('heading')
    {{ __('Import Subscribers') }}
@stop

@section('content')
    <div class="container-fluid">
        @if (isset($errors) and count($errors->getBags()))
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->getBags() as $key => $bag)
                                @foreach($bag->all() as $error)
                                    <li>{{ $key }} - {{ $error }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @component('laravel-mail::layouts.partials.card')

            @slot('cardHeader', __('Import via CSV file'))

            @slot('cardBody')
                <p class="text-white"><b>{{ __('CSV format') }}:</b> {{ __('Format your CSV the same way as the example below (with the first title row). Use the ID or email columns if you want to update a Subscriber instead of creating it.') }}</p>

                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped table-dark">
                        <thead>
                        <tr>
                            <th>{{ __('id') }}</th>
                            <th>{{ __('email') }}</th>
                            <th>{{ __('first_name') }}</th>
                            <th>{{ __('last_name') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td>me@laravelmail.com</td>
                            <td>Myself</td>
                            <td>Included</td>
                        </tr>
                        </tbody>
                    </table>
                </div>


                <form action="{{ route('laravel-mail.subscribers.import.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf

                    <x-laravel-mail.file-field name="file" :label="__('File')" required="required" />

                    <x-laravel-mail.select-field name="tags[]" :label="__('Tags')" :options="$tags" multiple />

                    <div class="form-group row">
                        <div class="offset-sm-3 col-sm-9">
                            <a href="{{ route('laravel-mail.subscribers.index') }}" class="btn btn-light">{{ __('Back') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
                        </div>
                    </div>
                </form>

            @endSlot
        @endcomponent

    </div>
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/js/bootstrap-select.min.js"></script>
@endpush
