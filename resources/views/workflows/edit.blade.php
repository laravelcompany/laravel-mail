@section('title', __('Workflows'))

@section('heading')
    {{ __('Edit Workflow') }} {{ $workflow->name }}
@endsection

@section(config('workflows.section'))
    <div class="container">
        <div class="row">
            <div class="col-md-12">
               <form action="{{ route('laravel-mail.workflows.update', ['workflow' => $workflow]) }}" method="POST">
                   @csrf
                   <div class="col-md-12">
                   <div class="form-group">
                       <input type="text" class="form-control" id="name" name="name" value="{{ $workflow->name }}" aria-describedby="Name" placeholder="Name">
                   </div>
                   </div>
                   <div class="col-md-12 text-right">
                   <a href="{{ route('laravel-mail.workflows.index') }}" class="btn btn-warning">{{ __('workflows.Cancel')}}</a>
                   <button type="submit" class="btn btn-success">{{ __('workflows.Save')}}</button>
                   </div>
               </form>
            </div>
        </div>
    </div>
@endsection
