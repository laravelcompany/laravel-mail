<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\Http\Controllers\Auth;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use LaravelCompany\Mail\Http\Controllers\Controller;
use LaravelCompany\Mail\Models\User;
use LaravelCompany\Mail\Models\Workspace;
use LaravelCompany\Mail\Rules\ValidInvitation;
use LaravelCompany\Mail\Services\Workspaces\AcceptInvitation;
use LaravelCompany\Mail\Services\Workspaces\CreateWorkspace;
use LaravelCompany\Mail\Traits\ChecksInvitations;

class RegisterController extends Controller
{
    use RegistersUsers;
    use ChecksInvitations;

    /** @var AcceptInvitation */
    private $acceptInvitation;

    /** @var CreateWorkspace */
    private $createWorkspace;

    public function __construct(AcceptInvitation $acceptInvitation, CreateWorkspace $createWorkspace)
    {
        $this->middleware('guest');

        $this->acceptInvitation = $acceptInvitation;
        $this->createWorkspace = $createWorkspace;
    }

    /**
     * @return mixed
     */
    public function showRegistrationForm(Request $request)
    {
        $invitation = $request->get('invitation');

        if ($invitation && $this->isInvalidInvitation($invitation)) {
            return redirect('register')
                ->with('error', __('The invitation is no longer valid.'));
        }

        return view('sendportal::auth.register');
    }

    protected function validator(array $data): ValidatorContract
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'/*, 'confirmed'*/],
            'invitation' => [new ValidInvitation()]
        ]);
    }

    protected function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'api_token' => Str::random(80),
            ]);

            if ($token = request('invitation')) {
                // Attach user to invited workspace.
                $this->acceptInvitation->handle($user, $this->getInvitationFromToken($token));
            } else {
                // Create a new workspace and attach as owner.
                $this->createWorkspace->handle($user, $data['company_name'], Workspace::ROLE_OWNER);
            }

            return $user;
        });
    }

    protected function redirectTo(): string
    {
        return route('sendportal.dashboard');
    }
}
