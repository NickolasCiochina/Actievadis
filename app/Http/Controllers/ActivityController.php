<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Registration;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::all();

        // Check if activities are being retrieved
        if ($activities->isEmpty()) {
            return view('activity_cards', ['activities' => $activities, 'noActivitiesMessage' => 'Er zijn momenteel geen activiteiten beschikbaar.']);
        }

        return view('activity_cards', compact('activities'));
    }

    public function covadisActivities()
    {
        // Fetch only activities that are for Covadis members
        $activities = Activity::where('is_for_covadis_members', 1)->get();

        // Check if there are activities
        if ($activities->isEmpty()) {
            return view('activity_cards_covadis', ['activities' => $activities, 'noActivitiesMessage' => 'Er zijn momenteel geen activiteiten beschikbaar voor Covadis-leden.']);
        }

        return view('activity_cards_covadis', compact('activities'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'food_and_drinks_available' => 'required|boolean',
            'description' => 'nullable|string',
            'start_date' => 'required|date|after:now', // Start date cannot be in the past
            'end_date' => 'required|date|after:start_date', // End date should be after start date
            'cost' => 'required|numeric|min:0',
            'min_participants' => 'required|integer|min:2|max:1000',
            'max_participants' => 'required|integer|min:2|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_for_covadis_members' => 'boolean',
        ]);

        // Additional data array to store other fields
        $additionalData = [];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Store the image in the 'public/images' directory and get the path
            $imagePath = $request->file('image')->store('images', 'public');
            $additionalData['image'] = $imagePath;
        }

        // Add 'date' to the additional data array, copying the value from 'start_date'
        $additionalData['date'] = $validated['start_date'];

        // Merge $validated and $additionalData into one array
        $finalData = array_merge($validated, $additionalData);

        // Create a new activity using the merged data
        Activity::create($finalData);

        // Redirect back to the activity list page
        return redirect()->route('activity_cards')->with('success', 'Activiteit succesvol toegevoegd');
    }



    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {

        // Fetch all registrations for the activity
        $registrations = $activity->registrations()->get();

        return view('activity_single', compact('activity', 'registrations'));
    }

    /**
     * Handle the registration form submission.
     */
    public function register(Request $request, Activity $activity)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
        ]);

        // Create a new registration
        Registration::create([
            'activity_id' => $activity->id,
            'name' => $validated['name'],
            'surname' => $validated['surname'],
        ]);

        // Redirect back to the activity page with a success message
        return redirect()->route('activity.show', $activity)->with('success', 'Je bent succesvol ingeschreven voor deze activiteit.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        // Delete the activity
        $activity->delete();

        // Redirect to the homepage with a success message
        return redirect('/')->with('success', 'Activiteit succesvol verwijderd.');
    }
}
