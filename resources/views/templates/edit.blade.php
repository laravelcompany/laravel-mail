@extends('laravel-mail::layouts.app')

@section('title', __("Templates"))

@section('heading')
    Templates
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <p class="text-bg-dark text-2xl font-bold ">
                            The following tags are available in your template:
                        </p>
                        <p class="text-bg-dark text-2xl font-bold ">
                            'email',
                            'first_name',
                            'last_name',
                            'unsubscribe_url',
                            'webview_url'
                        </p>
                        <form action="{{ route('laravel-mail.templates.update', $template->id) }}" method="POST" class="form-horizontal">
                            <div class="form-group row mt-3 mb-3">
                                <div class="col-12">
                                    <input type="text" class="form-control" id="title" name="name" value="{{ $template->name }}" placeholder="Template Name">
                                </div>
                            </div>
                            @csrf
                            @method('PUT')

                            <link href="https://cdn.jsdelivr.net/npm/grapesjs@0.14.52/dist/css/grapes.min.css" rel="stylesheet"/>
                            <script src="https://cdn.jsdelivr.net/combine/npm/grapesjs@0.14.52,npm/grapesjs-mjml@0.0.31/dist/grapesjs-mjml.min.js"></script>

                            <textarea style="display:none" class="form-control" id="content" name="content" rows="10" placeholder="Template Content">
                             <?php echo $template->content; ?>
                            </textarea>

                            <div id="gjs" style="height:200px; width:100%;">
                                <?php echo $template->content; ?>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-md" type="submit">{{ __('Save Template') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        // -- SETUP
        var editor = grapesjs.init({
            container : '#gjs',
            fromElement: true,
            plugins: [
                'grapesjs-mjml'
            ],
            pluginsOpts: {
                'grapesjs-mjml': {
                    resetDevices: false // so we can use the device buttons
                }
            }

        });

        // ---- Save Button
        editor.Panels.addButton('options', {
            id: 'save-db',
            className: 'fa fa-floppy-o',
            command: (editor,sender) => {
                sender && sender.set('active'); // turn off the button
                document.getElementById('content').value = editor.getHtml()

                editor.store()
            },
            attributes: {
                title: 'Save'
            }
        });
        // save additional data to grapesjs storage
    </script>
@stop

