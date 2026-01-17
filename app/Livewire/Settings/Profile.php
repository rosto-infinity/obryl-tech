<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $bio = '';

    public string $company = '';

    public string $country = '';

    public string $github_url = '';

    public string $linkedin_url = '';

    public $avatar;

    public $currentAvatar;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $profile = $user->profile;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->currentAvatar = $user->avatar;

        if ($profile) {
            $this->bio = $profile->bio ?? '';
            $this->company = $profile->company ?? '';
            $this->country = $profile->country ?? '';
            $this->github_url = $profile->github_url ?? '';
            $this->linkedin_url = $profile->linkedin_url ?? '';
        }
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'company' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:1024'], // 1MB Max
        ]);

        $user->fill([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update or Create Profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'bio' => $this->bio,
                'company' => $this->company,
                'country' => $this->country,
                'github_url' => $this->github_url,
                'linkedin_url' => $this->linkedin_url,
            ]
        );

        $this->dispatch('profile-updated', name: $user->name);

        // Refresh current avatar if changed
        if ($this->avatar) {
            $this->currentAvatar = $user->avatar;
            $this->avatar = null;
        }
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
