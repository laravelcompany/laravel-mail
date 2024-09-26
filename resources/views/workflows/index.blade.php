@extends('laravel-mail::layouts.app')
@section('title', __('Workflows'))

@section('heading')
    {{ __('Email Workflows') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('laravel-mail.workflows.create') }}" class="btn btn-secondary  mb-2">{{__('Create workflow')}}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-dark">
                    <tr>
                        <th>{{ __('Name')}}</th>
                        <th>{{ __('Tasks')}}</th>
                        <th>{{ __('Created at')}}</th>
                        <th></th>
                    </tr>
                    @foreach($workflows as $workflow)
                        <tr>
                            <td>{{ $workflow->name }}</td>
                            <td>{{ $workflow->tasks->count() }}</td>
                            <td>{{ $workflow->created_at->format('d.m.Y') }}</td>
                            <td>
                                <a href="{{ route('laravel-mail.workflows.show', ['workflow' => $workflow]) }}"><i class="fas fa-eye"></i></a> -
                                <a href="{{ route('laravel-mail.workflows.edit', ['workflow' => $workflow]) }}"><i class="fas fa-edit"></i></a> -
                                <a href="{{ route('laravel-mail.workflows.delete', ['workflow' => $workflow]) }}"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $workflows->links() }}
            </div>
        </div>
    </div>
@endsection
