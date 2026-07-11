<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            // Check if a file was uploaded for this key
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('settings', 'public');
                CompanySetting::set($key, $path);
            } elseif (!$request->hasFile($key) && array_key_exists($key, $request->all())) {
                // Set the value (even if null, allowing them to clear a setting)
                // Note: files aren't in $value usually, but this ensures we don't accidentally save an UploadedFile object as text
                CompanySetting::set($key, $value);
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated.');
    }
}
