<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Attendance Report - Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white min-h-screen">
    <div class="relative flex flex-col min-h-screen w-full">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-primary/10 bg-white dark:bg-background-dark px-6 md:px-10 py-3 sticky top-0 z-50">
            <div class="flex items-center gap-4 text-primary">
                <div class="size-9 flex items-center justify-center bg-primary text-white rounded-xl shadow-sm shadow-primary/20">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor"><path d="M280-280h80v-280h-80v280Zm160 0h80v-400h-80v400Zm160 0h80v-160h-80v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T800-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
                </div>
                <h2 class="text-slate-900 dark:text-white text-lg font-bold leading-tight tracking-tight">Portal</h2>
            </div>

            <div class="flex items-center gap-8">
                <nav class="hidden md:flex items-center gap-6">
                    <a class="text-slate-600 dark:text-gray-400 text-sm font-medium hover:text-primary transition-colors" href="{{ route('home') }}">Upload</a>
                    <a class="relative text-primary text-sm font-bold py-1 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-primary after:rounded-full" href="{{ route('report') }}">Report</a>
                </nav>
            </div>
        </header>

        <main class="max-w-[1200px] mx-auto w-full px-6 py-8 flex flex-col gap-8">
            <div class="print:hidden flex flex-col gap-2">
                <div class="flex flex-wrap justify-between items-end gap-4 mt-2">
                    <div>
                        <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">Attendance Report</h1>
                        <p class="text-slate-500 dark:text-slate-400 mt-1">Select employee and date to view the records.</p>
                    </div>
                </div>
            </div>

            <div class="print:hidden">
                <form class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end" action="{{ route('report') }}" method="GET">
                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="employee-name">
                            Employee Name
                        </label>
                        <select name="employee_name" id="employee-name" class="w-full" required>
                            <option value="">-- Select Employee --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->employee_name }}" {{ request('employee_name') == $emp->employee_name ? 'selected' : '' }}>
                                    {{ strtoupper($emp->employee_name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="date-from">From</label>
                        <input name="start_date" class="w-full px-4 py-2.5 rounded-xl border-none bg-white dark:bg-slate-900 shadow-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all text-sm text-slate-700 dark:text-slate-200" id="date-from" type="date" value="{{ request('start_date') }}" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest" for="date-until">Until</label>
                        <input name="end_date" class="w-full px-4 py-2.5 rounded-xl border-none bg-white dark:bg-slate-900 shadow-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all text-sm text-slate-700 dark:text-slate-200" id="date-until" type="date" value="{{ request('end_date') }}" required />
                    </div>

                    <div class="flex gap-2">
                        <button class="flex-1 flex items-center justify-center gap-2 h-[42px] px-6 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition-all shadow-md shadow-primary/20" type="submit">
                            Show Records
                        </button>
                        <a href="{{ route('report') }}" class="flex items-center justify-center w-[42px] h-[42px] bg-white dark:bg-slate-900 text-slate-400 hover:text-primary rounded-xl shadow-sm transition-all border border-slate-100 dark:border-slate-800">
                            <svg xmlns="http://www.w3.org/2000/svg" height="22" viewBox="0 -960 960 960" width="22" fill="currentColor"><path d="M480-160q-134 0-227-93t-93-227q0-134 93-227t227-93q69 0 132 28.5T720-690v-110h80v280H520v-80h168q-32-56-87.5-88T480-720q-100 0-170 70t-70 170q0 100 70 170t170 70q77 0 139-44t87-116h84q-28 106-114 173t-196 67Z"/></svg>
                        </a>
                    </div>
                </form>
            </div>

            @if($hasSearched)
            <div class="hidden print:flex items-baseline justify-between">
                <p class="text-sm text-black font-bold">Employee: {{ strtoupper(request('employee_name')) }}</p>
                <p class="text-xs text-black text-right">
                    <span class="font-bold">{{ \Carbon\Carbon::parse(request('start_date'))->format('M d') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}</span>
                    <span class="ml-4">P: {{ $summary['present'] }} | A: {{ $summary['absent'] }} | I: {{ $summary['incomplete'] }}</span>
                </p>
            </div>

            <div class="flex flex-col gap-2 mt-4 print:hidden">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Employee: {{ strtoupper(request('employee_name')) }}</h2>
                            <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase rounded-md">{{ $results->count() }} Records</span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Attendance from <span class="font-medium text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse(request('start_date'))->format('M d') }}</span> to <span class="font-medium text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}</span>
                        </p>
                    </div>
                    <button onclick="window.print()" class="flex items-center gap-2 h-10 px-4 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-50 transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 -960 960 960" width="18" fill="currentColor"><path d="M640-640v-120H320v120h-80v-200h480v200h-80Zm-480 80h640-640Zm560 100q17 0 28.5-11.5T760-500q0-17-11.5-28.5T720-540q-17 0-28.5 11.5T680-500q0 17 11.5 28.5T720-460Zm-80 260v-160H320v160h320Zm80 80H240v-160H80v-240q0-51 35-85.5t85-34.5h560q51 0 85.5 34.5T880-520v240H720v160Zm80-240v-160q0-17-11.5-28.5T760-560H200q-17 0-28.5 11.5T160-520v160h80v-80h480v80h80Z"/></svg>
                        Print
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 print:hidden">
                <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T800-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm214-114 226-226-56-56-170 170-100-100-56 56 156 156Zm-214 114v-560 560Z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Present</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $summary['present'] }} <span class="text-xs font-normal text-slate-400">Days</span></p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor"><path d="m612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Incomplete</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $summary['incomplete'] }} <span class="text-xs font-normal text-slate-400">Days</span></p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-rose-50 dark:bg-rose-900/20 rounded-lg text-rose-600">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T800-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm112-112 168-168 168 168 56-56-168-168 168-168-56-56-168 168-168-168-56 56 168 168-168 168 56 56Zm-112 112v-560 560Z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Absent</p>
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $summary['absent'] }} <span class="text-xs font-normal text-slate-400">Days</span></p>
                    </div>
                </div>
                <div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-sky-50 dark:bg-sky-900/20 rounded-lg text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" fill="currentColor"><path d="M480-120q-75 0-140.5-28.5t-114-77q-48.5-48.5-77-114T120-480q0-75 28.5-140.5t77-114q48.5-48.5 114-77T480-840q82 0 155.5 35T760-706v-94h80v240H600v-80h110q-41-56-103-88t-127-32q-109 0-184.5 75.5T220-480q0 109 75.5 184.5T480-220q83 0 152-46.5T721-390h84q-25 105-108 172.5T480-120Zm120-168-152-152v-180h80v148l128 128-56 56Z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Work Time</p>
                        @php
                            $netTotalMins = max(0, $summary['total_minutes'] - ($summary['present'] * 60));
                            $h = floor($netTotalMins / 60);
                            $m = $netTotalMins % 60;
                        @endphp
                        <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $h }}h {{ $m }}m</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">In</th>
                                <th class="px-6 py-4">Out</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($results as $row)
                            <tr class="hover:bg-primary/5 transition-colors {{ $row->color }}">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $row->attendance_date->format('M d, Y') }}</span>
                                        <span class="text-xs text-slate-500">{{ $row->attendance_date->format('l') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">{{ $row->clock_in ?? '--:--' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-slate-700 dark:text-slate-300">{{ $row->clock_out ?? '--:--' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold {{ $row->total_color }} dark:text-slate-300">{{ $row->work_duration ?? '--:--' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $row->background_color }} {{ $row->status_color }}">
                                        <span class="size-1.5 rounded-full {{ $row->circle_color }}"></span> {{ $row->display_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-400">{{ $row->note ?? '' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-slate-500 text-center" colspan="6">No records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </main>

        <footer class="mt-auto py-8 border-t border-slate-100 dark:border-slate-800 text-center print:hidden">
            <p class="text-xs text-slate-400">© 2026 AttendancePortal. All attendance data is automatically synced from biometric devices.</p>
        </footer>
    </div>

    <script>
        // This ensures the script waits for your Vite bundle to load TomSelect
        document.addEventListener("DOMContentLoaded", function() {
            if (window.TomSelect) {
                new TomSelect("#employee-name", {
                    create: false,
                    controlInput: '<input>',
                    render: {
                        option: function(data, escape) {
                            return '<div class="py-2 px-3 text-sm"><span>' + escape(data.text) + '</span></div>';
                        },
                        item: function(data, escape) {
                            return '<div class="py-0 text-sm"><span>' + escape(data.text) + '</span></div>';
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
