<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\UploadLog;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AttendanceImport;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // CHANGE: Added latest() and take(5) to show only the 5 most recent uploads
        $logs = UploadLog::latest()->take(5)->get();

        return view('attendance', compact('logs'));
    }

    public function report(Request $request)
    {
        // 1. Get distinct employees for the dropdown
        $employees = Attendance::select('employee_name')->distinct()->orderBy('employee_name')->get();

        // Initialize variables
        $results = collect();
        $hasSearched = false;
        $summary = ['present' => 0, 'incomplete' => 0, 'absent' => 0, 'total_minutes' => 0, 'onleave' => 0];

        // Check if any filter input is present in the URL
        if ($request->filled('employee_name') && $request->filled('start_date') && $request->filled('end_date')) {
            $hasSearched = true;

            // Fix: Use Carbon to create definitive start and end points
            $startDate = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $endDate = \Carbon\Carbon::parse($request->end_date)->endOfDay();

            $results = Attendance::where('employee_name', $request->employee_name)
                ->whereBetween('attendance_date', [$startDate, $endDate]) // This now captures the full end day
                ->orderBy('attendance_date', 'asc')
                ->get();

            // Map through the results to calculate everything upfront
            $results->transform(function ($row) use (&$summary) {
                $hasIn = !empty($row->clock_in);
                $hasOut = !empty($row->clock_out);

                // Default values
                $row->display_status = 'Absent';
                $row->work_duration = '';
                $row->overtime = '';
                $row->undertime = '';
                $row->total_color = 'text-red-600';
                $row->color = 'bg-red-50/70';
                $row->status_color = 'text-red-700'; // Default red for absent
                $row->background_color = 'bg-red-50'; // Default light red for absent
                $row->circle_color = 'bg-red-600'; // Default light red for absent

                if ($hasIn && $hasOut) {
                    $in = \Carbon\Carbon::parse($row->clock_in);
                    $out = \Carbon\Carbon::parse($row->clock_out);
                    if ($out->lt($in)) { $out->addDay(); }

                    $grossMins = $in->diffInMinutes($out);
                    $netMins = max(0, $grossMins - 60); // Subtract 1hr break

                    // Update Summary
                    $summary['present']++;
                    $summary['total_minutes'] += $grossMins;

                    // Format Duration
                    $row->work_duration = floor($netMins / 60) . 'h ' . ($netMins % 60) . 'm';

                    // Status & Overtime/Undertime Logic
                    $threshold = 7 * 60; // 7 hours
                    if ($netMins >= $threshold) {
                        $row->display_status = 'Present';
                        $row->color = '';
                        $row->total_color = 'text-gray-700';
                        $row->status_color = 'text-green-700';
                        $row->background_color = 'bg-green-50'; // Default light green for present
                        $row->circle_color = 'bg-green-600'; // Default light green for present
                        $otMins = $netMins - $threshold;
                        if ($otMins > 0) $row->overtime = floor($otMins / 60) . 'h ' . ($otMins % 60) . 'm';
                    } else {
                        $row->display_status = 'Under';
                        $row->color = '';
                        $row->total_color = 'text-amber-600';
                        $row->status_color = 'text-amber-600';
                        $row->background_color = 'bg-amber-50'; // Default light amber for less than 7 hours
                        $row->circle_color = 'bg-amber-600'; // Default light amber for less than 7 hours
                        $utMins = $threshold - $netMins;
                        $row->undertime = floor($utMins / 60) . 'h ' . ($utMins % 60) . 'm';
                    }
                } elseif ($hasIn || $hasOut) {
                    $summary['incomplete']++;
                    $row->display_status = 'Incomplete';
                    $row->color = '';
                    $row->total_color = 'text-amber-600';
                    $row->status_color = 'text-amber-600';
                    $row->background_color = 'bg-amber-50'; // Default light incomplete
                    $row->circle_color = 'bg-amber-600'; // Default light incomplete
                } else {
                    $summary['absent']++;
                    // If they are absent but have a note, let's show that!
                    // if (!empty($row->note)) {
                    //     $summary['onleave']++;
                    //     $row->display_status = 'On Leave';
                    //     $row->status_color = 'text-blue-600'; // Blue for excused absence
                    // }
                }

                return $row;
            });
        }

        return view('report', compact('employees', 'results', 'hasSearched', 'summary'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'attendance_file' => 'required|mimes:xlsx,xls|max:10240', // Max 10MB
        ]);

        try {
            Excel::import(new AttendanceImport, $request->file('attendance_file'));

            UploadLog::create([
                'file_name' => $request->file('attendance_file')->getClientOriginalName()
            ]);

            // Return with a success message
            return redirect()->back()->with('success', 'File uploaded and records synced successfully!');

        } catch (\Exception $e) {
            // Return with an error message if something goes wrong (e.g., bad date format)
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }
}
