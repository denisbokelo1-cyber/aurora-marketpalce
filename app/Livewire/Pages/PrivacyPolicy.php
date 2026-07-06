<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Services\SettingService;
class PrivacyPolicy extends Component
{
    public function render()
    {
        $privacy_policy_setting = app(SettingService::class)->getSettings('privacy_policy',true);
        $privacy_policy = $privacy_policy_setting ? json_decode($privacy_policy_setting, true) : [];
        $data = $privacy_policy['privacy_policy'] ?? '';

        return view('livewire.'.config('constants.theme').'.pages.privacy-policy',[
            'privacy_policy' => $data
        ])->title("Privacy Policy |");
    }
}
