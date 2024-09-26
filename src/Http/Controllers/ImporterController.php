<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Http\Controllers;

use Illuminate\View\View;
use LaravelCompany\Mail\Facades\LaravelMail;


class ImporterController extends Controller
{
    public function show()
    {
        return view('laravel-mail::csv-importer.index');
    }


    public function store()
    {
        $file = request()->file('file');

        if (! $file) {
            return redirect()->back()->withErrors(['file' => 'File is required']);
        }

        $fileName = $file->getClientOriginalName();

        $filePath = $file->store('csv-imports');

        $import = LaravelMail::importCsv($filePath);

        return redirect()->back()->with('success', 'Imported ' . $import->imported . ' records');
    }
}
