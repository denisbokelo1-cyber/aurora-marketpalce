<?php

namespace App\Livewire\Pages;
use App\Services\SettingService;
use Livewire\Component;

class ReturnPolicy extends Component
{
    public function render()
    {
        $return_policy_setting = app(SettingService::class)->getSettings('return_policy',true);
        $return_policy = $return_policy_setting ? json_decode($return_policy_setting, true) : [];
        $data = $return_policy['return_policy'] ?? '';

        return view('livewire.'.config('constants.theme').'.pages.return-policy',[
            'return_policy' => $data
        ])->title("Return Policy |");
    }
}
