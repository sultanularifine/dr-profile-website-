<?php

namespace App\Http\Controllers;

use App\Models\ConsentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ConsentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'analytics' => ['required', 'boolean'],
            'marketing' => ['required', 'boolean'],
        ]);

        $analytics = (bool) $data['analytics'];
        $marketing = (bool) $data['marketing'];
        $previousAnalytics = (bool) $request->session()->get('site_consent_analytics', false);
        $previousMarketing = (bool) $request->session()->get('site_consent_marketing', false);

        $request->session()->put([
            'site_consent_choice' => true,
            'site_consent_analytics' => $analytics,
            'site_consent_marketing' => $marketing,
        ]);

        if (Schema::hasTable('consent_records')) {
            ConsentRecord::updateOrCreate(
                ['visitor_hash' => hash('sha256', $request->session()->getId())],
                [
                    'analytics' => $analytics,
                    'marketing' => $marketing,
                    'consent_version' => '1.0',
                    'consented_at' => now(),
                    'withdrawn_at' => ((!$analytics && !$marketing) && ($previousAnalytics || $previousMarketing)) ? now() : null,
                ]
            );
        }

        return response()->json(['saved' => true]);
    }
}
