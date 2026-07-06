<?php

namespace App\Livewire\Pages;
use App\Services\SettingService;
use Livewire\Component;

class TermAndConditions extends Component
{
    public function render()
    {
        $terms_setting = app(SettingService::class)->getSettings('terms_and_conditions', true);
        $terms_and_conditions = $terms_setting ? json_decode($terms_setting, true) : [];
        $data = $terms_and_conditions['terms_and_conditions'] ?? '';

        return view('livewire.' . config('constants.theme') . '.pages.term-and-conditions', [
            'terms_and_conditions' => $data
        ])->title("Terms & Conditions |");
    }
}
