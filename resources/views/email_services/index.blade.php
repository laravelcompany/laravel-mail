@extends('laravel-mail::layouts.app')

@section('title', __('Email Services'))

@section('heading')
    {{ __('Email Services') }}
@endsection

@section('content')

    @component('laravel-mail::layouts.partials.actions')
        @slot('right')
            <a class="btn btn-primary btn-md btn-flat" href="{{ route('laravel-mail.email_services.create') }}">
                <i class="fa fa-plus mr-1"></i> {{ __('Add Email Service') }}
            </a>
        @endslot
    @endcomponent

    <div class="card">
        <div class="card-table">
            <table class="table table-dark">
                <thead>
                <tr>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Service') }}</th>
                    <th class="text-right">{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($emailServices as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->type->name }}</td>
                        <td class="text-right">
                            <a href="{{ route('laravel-mail.email_services.test.create', $service->id) }}" class="btn btn-sm btn-light">
                                {{ __('Test') }}
                            </a>
                            <a class="btn btn-sm btn-light"
                               href="{{ route('laravel-mail.email_services.edit', $service->id) }}">{{ __('Edit') }}</a>
                            <form action="{{ route('laravel-mail.email_services.delete', $service->id) }}" method="POST"
                                  style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-light">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%">
                            <p class="empty-table-text">{{ __('You have not configured any email service.') }}</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
