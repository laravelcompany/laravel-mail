@extends('laravel-mail::layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ __('Create workflow') }}</h1>
            </div>
        </div>

        <div class="row table-dark ">
            <div class="col-md-12 p-4">
               <form action="{{ route('laravel-mail.workflows.store') }}" method="POST">
                   @csrf
                   <div class="col-md-12">
                   <div class="form-group">
                       <label for="name">{{  __('Name') }}</label>
                       <input type="text" class="form-control" id="name" name="name" aria-describedby="Name" placeholder="Name">
                   </div>
                   </div>
                   <div class="col-md-12 text-right">
                   <a href="{{ route('laravel-mail.workflows.index') }}" class="btn btn-warning float-start">{{ __('Cancel')}}</a>
                   <button type="submit" class="ml-4 btn btn-success float-start">{{ __('Save')}}</button>
                   </div>
               </form>
            </div>
        </div>
    </div>
@endsection
