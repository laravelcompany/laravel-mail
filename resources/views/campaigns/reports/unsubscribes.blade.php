@extends('laravel-mail::layouts.app')

@section('title', $campaign->name)

@section('heading', $campaign->name)

@section('content')

    @include('laravel-mail::campaigns.reports.partials.nav')

    <div class="card">
        <div class="card-table table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('Subscriber') }}</th>
                    <th>{{ __('Subject') }}</th>
                    <th>{{ __('Unsubscribed') }}</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td><a href="{{ route('laravel-mail.subscribers.show', $message->subscriber_id) }}">{{ $message->recipient_email }}</a></td>
                            <td>{{ $message->subject }}</td>
                            <td>{{ ($message->unsubscribed_at) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">
                                <p class="empty-table-text">{{ __('There are no unsubscribes') }}</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('laravel-mail::layouts.partials.pagination', ['records' => $messages])

@endsection
