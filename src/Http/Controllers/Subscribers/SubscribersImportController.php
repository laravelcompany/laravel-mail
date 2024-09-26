<?php
declare(strict_types=1);
namespace LaravelCompany\Mail\Http\Controllers\Subscribers;


use Exception;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use LaravelCompany\Mail\Facades\LaravelMail;
use Rap2hpoutre\FastExcel\FastExcel;

use LaravelCompany\Mail\Http\Controllers\Controller;
use LaravelCompany\Mail\Http\Requests\SubscribersImportRequest;
use LaravelCompany\Mail\Repositories\TagTenantRepository;
use LaravelCompany\Mail\Services\Subscribers\ImportSubscriberService;

class SubscribersImportController extends Controller
{
    /** @var ImportSubscriberService */
    protected ImportSubscriberService $subscriberService;

    private int $workspaceId;

    public function __construct(ImportSubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;

        $this->workspaceId = LaravelMail::currentWorkspaceId();
    }

    /**
     * @throws Exception
     */
    public function show(TagTenantRepository $tagRepo): ViewContract
    {
        $tags = $tagRepo->pluck($this->workspaceId, 'name', 'id');

        return view('laravel-mail::subscribers.import', compact('tags'));
    }

    /**
     * @throws Exception
     */
    public function showNew(TagTenantRepository $tagRepo): ViewContract
    {
        $tags = $tagRepo->pluck($this->workspaceId, 'name', 'id');

        return view('laravel-mail::subscribers.import-new', compact('tags'));
    }


    /**
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     */
    public function store(SubscribersImportRequest $request): RedirectResponse
    {
        if ($request->file('file')->isValid()) {
            $filename = Str::random(16) . '.csv';

            $path = $request->file('file')->storeAs('imports', $filename, 'local');

            $errors = $this->validateCsvContents(Storage::disk('local')->path($path));

            if (count($errors->getBags())) {
                Storage::disk('local')->delete($path);

                return redirect()->back()
                    ->withInput()
                    ->with('error', __('The provided file contains errors'))
                    ->with('errors', $errors);
            }

            $counter = [
                'created' => 0,
                'updated' => 0
            ];

            (new FastExcel())->import(Storage::disk('local')->path($path), function (array $line) use ($request, &$counter) {
                $data = Arr::only($line, ['id', 'email', 'first_name', 'last_name']);

                $data['tags'] = $request->get('tags') ?? [];
                $subscriber = $this->subscriberService->import($this->workspaceId, $data);

                if ($subscriber->wasRecentlyCreated) {
                    $counter['created']++;
                } else {
                    $counter['updated']++;
                }
            });

            Storage::disk('local')->delete($path);

            return redirect()->route('laravel-mail.subscribers.index')
                ->with('success', __('Imported :created subscriber(s) and updated :updated subscriber(s) out of :total', [
                    'created' => $counter['created'],
                    'updated' => $counter['updated'],
                    'total' => $counter['created'] + $counter['updated']
                ]));
        }

        return redirect()->route('laravel-mail.subscribers.index')
            ->with('errors', __('The uploaded file is not valid'));
    }

    /**
     * @param string $path
     * @return ViewErrorBag
     * @throws IOException
     * @throws ReaderNotOpenedException
     * @throws UnsupportedTypeException
     */
    protected function validateCsvContents(string $path): ViewErrorBag
    {
        $errors = new ViewErrorBag();

        $row = 1;

        (new FastExcel())->import($path, function (array $line) use ($errors, &$row) {
            $data = Arr::only($line, ['id', 'email', 'first_name', 'last_name']);

            try {
                $this->validateData($data);
            } catch (ValidationException $e) {
                $errors->put('Row ' . $row, $e->validator->errors());
            }

            $row++;
        });

        return $errors;
    }

    /**
     * @param array $data
     * @throws ValidationException
     */
    protected function validateData(array $data): void
    {
        $validator = Validator::make($data, [
            'id' => 'integer',
            'email' => 'required|email:filter',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }


    public function storeNew(Request $request): RedirectResponse
    {
        $rows = collect($request->get('rows'));

        $rows->each
        (/**
         * @throws Exception
         */
        function ($row) use ($request) {

            if(count($row['values']) > 0){

                $row['values']['tags'] = $request->get('tags') ?? [];

                //todo dispatch workflow to check for subscribers
                $this->subscriberService->import($this->workspaceId, $row['values']);


            }
        });


        return redirect()->route('laravel-mail.subscribers.index')->with('flash', 'Subscriber imported successfully.');

    }
}
