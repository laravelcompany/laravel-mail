<div class="row">
    @foreach($templates as $template)
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="text-white">
                        {{ $template->name }}
                    </div>

                    @include('laravel-mail::templates.partials.griditem')

                        @if ( ! $template->is_in_use)
                            <form action="{{ route('laravel-mail.templates.destroy', $template->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('laravel-mail.templates.edit', $template->id) }}"
                                   class="btn btn-xs btn-light">{{ __('Edit') }}</a>
                                <button type="submit" class="btn btn-xs btn-light">{{ __('Delete') }}</button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @endforeach
</div>

{{ $templates->links() }}
