@extends('laravel-mail::layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/css/bootstrap-select.min.css">
@endpush

@section('heading')
    {{ __('Import New') }}
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="app" style="max-height: 75vh"></div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/js/bootstrap-select.min.js"></script>
    <script src="https://unpkg.com/csv-import-js@latest/index.js"></script>
    <script>
        const data = {
            rows: [],
        };

        const importer = CSVImporter.createCSVImporter({
            domElement: document.getElementById("app"),
            modalOnCloseTriggered: () => importer?.closeModal(),

            onComplete: (importedData) => {

                // Append CSRF token to the data
                importedData._token = "{{ csrf_token() }}";

                // jQuery post data with CSRF token
                $.post('{{ route('laravel-mail.subscribers.import.storeNew') }}', importedData)
                    .done(function(response) {
                        console.log('Data imported successfully:', response);
                    })
                    .fail(function(error) {
                        console.log('Error during data import:', error);
                    });
            },
            darkMode: true,
            isModal: false,
            template: {
                columns: [
                    {
                        name: "First Name",
                        key: "first_name",
                        description: "Subscriber's first name",
                        suggested_mappings: ["first_name", "First Name"],
                    },
                    {
                        name: "Email",
                        key: "email",
                        description: "Subscriber's email address",
                        suggested_mappings: ["email"],
                    },

                ],
            },
        });
    </script>
@endpush
