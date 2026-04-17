<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignSlogan extends Model
{
    //
    protected $guarded = [];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
