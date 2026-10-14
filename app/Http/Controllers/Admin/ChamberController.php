<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamber;
use App\Models\ChamberSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChamberController extends Controller
{
    private function authorizeMedicalStaff(): void
    {
        abort_unless(auth()->user()?->hasAnyRole(['Super Admin', 'Doctor']), 403);
    }

    public function index()
    {
        $this->authorizeMedicalStaff();
        $chambers = Chamber::with('schedules')->orderBy('display_order')->orderBy('name')->get();
        return view('backend.medical.chambers.index', compact('chambers'));
    }

    public function store(Request $request)
    {
        $this->authorizeMedicalStaff();
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'hospital_name' => ['nullable','string','max:255'],
            'department' => ['nullable','string','max:255'],
            'address' => ['required','string','max:2000'],
            'phone' => ['nullable','string','max:50'],
            'maps_url' => ['nullable','url','max:1000'],
            'consultation_type' => ['required', Rule::in(['offline','online','both'])],
            'consultation_fee' => ['required','numeric','min:0','max:99999999'],
            'display_order' => ['nullable','integer','min:0','max:99999'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_default'] = $request->boolean('is_default');
        if ($data['is_default']) Chamber::query()->update(['is_default' => false]);
        Chamber::create($data);
        return back()->with('success', 'Chamber created.');
    }

    public function update(Request $request, Chamber $chamber)
    {
        $this->authorizeMedicalStaff();
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'hospital_name' => ['nullable','string','max:255'],
            'department' => ['nullable','string','max:255'],
            'address' => ['required','string','max:2000'],
            'phone' => ['nullable','string','max:50'],
            'maps_url' => ['nullable','url','max:1000'],
            'consultation_type' => ['required', Rule::in(['offline','online','both'])],
            'consultation_fee' => ['required','numeric','min:0','max:99999999'],
            'display_order' => ['nullable','integer','min:0','max:99999'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_default'] = $request->boolean('is_default');
        if ($data['is_default']) Chamber::where('id', '!=', $chamber->id)->update(['is_default' => false]);
        $chamber->update($data);
        return back()->with('success', 'Chamber updated.');
    }

    public function storeSchedule(Request $request, Chamber $chamber)
    {
        $this->authorizeMedicalStaff();
        $data = $request->validate([
            'weekday' => ['required','integer','between:0,6'],
            'starts_at' => ['required','date_format:H:i'],
            'ends_at' => ['required','date_format:H:i','after:starts_at'],
            'slot_minutes' => ['required','integer','between:5,180'],
            'max_patients' => ['required','integer','between:1,500'],
        ]);
        // The add form has an enabled-by-default checkbox. An unchecked box intentionally creates an inactive shift.
        $data['is_active'] = $request->boolean('is_active');
        if ($data['is_active']) {
            $overlapsExistingShift = ChamberSchedule::query()
                ->where('chamber_id', $chamber->id)
                ->where('weekday', $data['weekday'])
                ->where('is_active', true)
                ->where('starts_at', '<', $data['ends_at'])
                ->where('ends_at', '>', $data['starts_at'])
                ->exists();

            if ($overlapsExistingShift) {
                return back()->withInput()->withErrors([
                    'starts_at' => 'This shift overlaps an existing active schedule for the same day.',
                ]);
            }
        }

        $chamber->schedules()->create($data);
        return back()->with('success', 'Chamber schedule added.');
    }

    public function updateSchedule(Request $request, Chamber $chamber, ChamberSchedule $schedule)
    {
        $this->authorizeMedicalStaff();
        abort_unless((int) $schedule->chamber_id === (int) $chamber->id, 404);

        $data = $request->validate([
            'weekday' => ['required', 'integer', 'between:0,6'],
            'starts_at' => ['required', 'date_format:H:i'],
            'ends_at' => ['required', 'date_format:H:i', 'after:starts_at'],
            'slot_minutes' => ['required', 'integer', 'between:5,180'],
            'max_patients' => ['required', 'integer', 'between:1,500'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        if ($data['is_active']) {
            $overlap = ChamberSchedule::query()
                ->where('chamber_id', $chamber->id)
                ->where('weekday', $data['weekday'])
                ->where('is_active', true)
                ->where('id', '!=', $schedule->id)
                ->where('starts_at', '<', $data['ends_at'])
                ->where('ends_at', '>', $data['starts_at'])
                ->exists();

            if ($overlap) {
                return back()->withInput()->withErrors([
                    'starts_at' => 'This shift overlaps another active schedule for the same day.',
                ]);
            }
        }

        $schedule->update($data);
        return back()->with('success', 'Chamber schedule updated.');
    }

    public function destroySchedule(Chamber $chamber, ChamberSchedule $schedule)
    {
        $this->authorizeMedicalStaff();
        abort_unless($schedule->chamber_id === $chamber->id, 404);
        $schedule->delete();
        return back()->with('success', 'Schedule removed.');
    }
}
