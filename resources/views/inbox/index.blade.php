@extends('laravel-mail::layouts.app')

@section('title', __('Inbox'))

@section('heading')
    {{ __('Inbox') }}
@endsection

@section('content')
    <div class="row">
        <!-- Sidebar with Inbox Folders -->
        <div class="col-md-3">
            <div class="list-group">
                 <a href="#" class="list-group-item list-group-item-action bg-dark">
                    {{ __('Inbox') }}
                 </a>
                <a href="#" class="list-group-item list-group-item-action bg-dark">
                    {{ __('Deleted') }}
                </a>
            </div>
        </div>

        <!-- Messages for Each Folder -->
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Emails') }}</h5>
                </div>
                <div class="card-table table-responsive">
                    <table class="table table-dark table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Created') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($messages->sortByDesc('date') as $message)
                            <tr>
                                <td>{{ ($message['subject']) }}</td>
                                <td>email@email.com</td>
                                <td>{{ ($message['date']) }} </td>
                                <td>Status</td>
                                <td>
                                    <a href="{{ route('laravel-mail.inbox.show', $message['uid']) }}" class="btn btn-primary">{{ __('View') }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">{{ __('No messages in this folder.') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
