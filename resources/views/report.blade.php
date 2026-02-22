<!DOCTYPE html>

<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Attendance Report - Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background-light dark:bg-background-dark text-[#111418] dark:text-white min-h-screen">
    <!-- Main Layout Container -->
    <div class="relative flex flex-col min-h-screen w-full">
        <!-- Navigation Bar -->
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-primary/10 bg-white dark:bg-background-dark px-6 md:px-10 py-3 sticky top-0 z-50">
            <div class="flex items-center gap-4 text-primary">
                <div class="size-9 flex items-center justify-center bg-primary text-white rounded-xl shadow-sm shadow-primary/20">
                    <span class="material-symbols-outlined text-[20px]">analytics</span>
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

        <!-- Main Content -->
        <main class="max-w-[1200px] mx-auto w-full px-6 py-8 flex flex-col gap-8">
            <!-- Header -->
            <div class="print:hidden flex flex-col gap-2">
                <div class="flex flex-wrap justify-between items-end gap-4 mt-2">
                    <div>
                        <h1 class="text-3xl font-black tracking-tight text-[#111418] dark:text-white">Attendance Report</h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">Select employee and date to view the records.</p>
                    </div>
                </div>
            </div>
            <!-- Search Form Section -->
            <div class="gap 2 print:hidden">
                <form class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end" action="{{ route('report') }}" method="GET">

                    <div class="flex flex-col gap-2 md:col-span-2">
                        <label class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest" for="employee-name">
                            Employee Name
                        </label>
                        <select name="employee_name" id="employee-name" class="w-full" placeholder="Search by name..." required>
                            <option value="">-- Select Employee --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->employee_name }}" {{ request('employee_name') == $emp->employee_name ? 'selected' : '' }}>
                                    {{ $emp->employee_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest" for="date-from">
                            From
                        </label>
                        <input name="start_date"
                            class="w-full px-4 py-2.5 rounded-xl border-none bg-white dark:bg-gray-900 shadow-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all text-sm text-gray-700 dark:text-gray-200"
                            id="date-from" type="date" value="{{ request('start_date') }}" required />
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest" for="date-until">
                            Until
                        </label>
                        <input name="end_date"
                            class="w-full px-4 py-2.5 rounded-xl border-none bg-white dark:bg-gray-900 shadow-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all text-sm text-gray-700 dark:text-gray-200"
                            id="date-until" type="date" value="{{ request('end_date') }}" required />
                    </div>

                    <div class="flex gap-2">
                        <button class="flex-1 flex items-center justify-center gap-2 h-[42px] px-6 bg-primary text-white rounded-xl text-sm font-bold hover:bg-primary/90 transition-all shadow-md shadow-primary/20" type="submit">
                            Show Records
                        </button>
                        <a href="{{ route('report') }}"
                        class="flex items-center justify-center w-[42px] h-[42px] bg-white dark:bg-gray-900 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl shadow-sm transition-all border-none">
                            <span class="material-symbols-outlined text-[22px]">restart_alt</span>
                        </a>
                    </div>
                </form>
            </div>

            @if($hasSearched)
            <div class="hidden print:flex items-baseline justify-between">
                <p class="text-s text-black font-bold">
                    Employee: {{ request('employee_name') }}
                </p>

                <p class="text-xs text-black text-right">
                    <span class="font-bold">{{ \Carbon\Carbon::parse(request('start_date'))->format('M d') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}</span>
                    <span class="ml-4">
                        P: <span class="font-bold">{{ $summary['present'] }}</span> |
                        A: <span class="font-bold">{{ $summary['absent'] }}</span> |
                        I: <span class="font-bold">{{ $summary['incomplete'] }}</span>
                    </span>
                </p>
            </div>

            <div class="flex flex-col gap-2 mt-4 print:hidden">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-3">
                            <h2 class="text-xl font-mono text-slate-900 dark:text-white tracking-tight">
                                Employee: {{ request('employee_name') }}
                            </h2>
                            <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase rounded-md">
                                {{ $results->count() }} Records
                            </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Attendance report from <span class="font-medium text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse(request('start_date'))->format('M d') }}</span>
                            to <span class="font-medium text-slate-700 dark:text-slate-300">{{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}</span>
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button onclick="window.print()" class="flex items-center gap-2 h-10 px-4 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-sm font-bold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">print</span>
                            Print
                        </button>
                    </div>
                </div>
            </div>
            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 print:hidden">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 block">event_available</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Present</p>
                        <p class="text-2xl font-bold text-[#111418] dark:text-white">{{ $summary['present'] }} <span class="text-xs font-normal text-gray-400">Days</span></p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                        <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 block">schedule</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Incomplete</p>
                        <p class="text-2xl font-bold text-[#111418] dark:text-white">{{ $summary['incomplete'] }} <span class="text-xs font-normal text-gray-400">Days</span></p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 block">event_busy</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Absent</p>
                        <p class="text-2xl font-bold text-[#111418] dark:text-white">{{ $summary['absent'] }} <span class="text-xs font-normal text-gray-400">Days</span></p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex items-center gap-4">
                    <div class="p-3 bg-cyan-50 dark:bg-cyan-900/20 rounded-lg">
                        <span class="material-symbols-outlined text-cyan-600 dark:text-cyan-400 block">overview</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Work Time</p>
                        @php
                            $netTotalMins = max(0, $summary['total_minutes'] - ($summary['present'] * 60));
                            $h = floor($netTotalMins / 60);
                            $m = $netTotalMins % 60;
                        @endphp
                        <p class="text-2xl font-bold text-[#111418] dark:text-white">{{ $h }}h {{ $m }}m</p>
                    </div>
                </div>
            </div>
            <!-- Detailed Log Table Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-wider">
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">In</th>
                                <th class="px-6 py-4">Out</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($results as $row)
                            <tr class="hover:bg-primary/5 dark:hover:bg-primary/10 transition-colors {{ $row->color }}">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-[#111418] dark:text-white">{{ $row->attendance_date->format('M d, Y') }}</span>
                                        <span class="text-xs text-gray-500">{{ $row->attendance_date->format('l') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $row->clock_in ?? '--:--' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $row->clock_out ?? '--:--' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold {{ $row->total_color }} dark:text-gray-300">{{ $row->work_duration ?? '--:--' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $row->background_color }} {{ $row->status_color }}">
                                        <span class="size-1.5 rounded-full {{ $row->circle_color }}"></span> {{ $row->display_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-700 dark:text-gray-400">
                                    {{ $row->note ?? '' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-300"colspan="6" align="center">No records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </main>

        <!-- Footer -->
        <footer class="mt-auto py-8 border-t border-gray-100 dark:border-gray-700 text-center print:hidden">
            <p class="text-xs text-gray-400">© 2023 Corporate HR Solutions. All attendance data is automatically synced from biometric devices.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        if (typeof TomSelect !== 'undefined') {
            new TomSelect("#employee-name", {
                create: false,
                controlInput: '<input>',
                render: {
                    option: function(data, escape) {
                        return '<div class="py-2 px-3"><span>' + escape(data.text) + '</span></div>';
                    },
                    item: function(data, escape) {
                        return '<div class="py-0"><span>' + escape(data.text) + '</span></div>';
                    }
                }
            });
        }
    </script>
</body>

</html>
