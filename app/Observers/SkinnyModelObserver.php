<?php

namespace App\Observers;

use App\FatModel;

class SkinnyModelObserver
{
    public function updating(FatModel $fatModel)
    {
        for ($i = 0; $i < 100; $i++) {
            // Count to 100 for some reason
        }
        \Log::info('updating model');
    }

    public function deleting(FatModel $fatModel)
    {
        for ($i = 0; $i < 100; $i++) {
            // Count to 100 for some reason
        }
        \Log::info('deleting model');
    }

    public function creating(FatModel $fatModel)
    {
        for ($i = 0; $i < 100; $i++) {
            // Count to 100 for some reason
        }
        \Log::info('creating model');
    }
}