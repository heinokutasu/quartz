<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Upload Attendance - Portal</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1162d4",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101822",
                    },
                    fontFamily: {
                        "display": ["Geist", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Geist', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
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
                    <a class="relative text-primary text-sm font-bold py-1 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-primary after:rounded-full" href="{{ route('home') }}">Upload</a>
                    <a class="text-slate-600 dark:text-gray-400 text-sm font-medium hover:text-primary transition-colors" href="{{ route('report') }}">Report</a>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex flex-1 justify-center py-10 px-4 md:px-20">
            <div class="layout-content-container flex flex-col max-w-[800px] flex-1 gap-8">
                @if(session('success'))
                <!-- Success Alert -->
                <div class="mb-0 @container">
                    <div class="flex flex-1 flex-col items-start justify-between gap-4 rounded-xl border border-emerald-100 bg-emerald-50 dark:bg-emerald-950/20 dark:border-emerald-900/50 p-5 @[480px]:flex-row @[480px]:items-center">
                        <div class="flex items-center gap-4">
                            <div class="bg-emerald-500 text-white rounded-full p-1 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">check</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-emerald-900 dark:text-emerald-100 text-base font-bold leading-tight">Success!</p>
                                <p class="text-emerald-700 dark:text-emerald-400 text-sm font-normal leading-normal">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('error'))
                    <!-- Error Alert -->
                <div class="mb-0 @container">
                    <div class="flex flex-1 flex-col items-start justify-between gap-4 rounded-xl border border-rose-100 bg-rose-50 dark:bg-rose-950/20 dark:border-rose-900/50 p-5 @[480px]:flex-row @[480px]:items-center">
                        <div class="flex items-center gap-4">
                            <div class="bg-rose-500 text-white rounded-full p-1 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">error</span>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-rose-900 dark:text-rose-100 text-base font-bold leading-tight">Failed!</p>
                                <p class="text-rose-700 dark:text-rose-400 text-sm font-normal leading-normal">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Header Section -->
                <div class="flex flex-col gap-2">
                    <h1 class="text-slate-900 dark:text-white text-4xl font-black leading-tight tracking-tight">Upload Attendance</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-base font-normal">
                        Select your attendance data files to get started.
                    </p>
                </div>

                <!-- Upload Section Card -->
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-primary/10 shadow-sm overflow-hidden">
                    <div class="p-8">
                        <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" id="attendanceForm">
                            @csrf

                            <label for="attendance-upload"
                                id="drop-zone"
                                class="flex flex-col items-center gap-6 rounded-xl border-2 border-dashed border-primary/20 bg-primary/5 px-6 py-16 hover:border-primary/40 transition-all cursor-pointer group">

                                <input accept=".csv, .xlsx"
                                    class="hidden"
                                    id="attendance-upload"
                                    name="attendance_file"
                                    type="file" />

                                <div class="flex flex-col items-center gap-4">
                                    <div class="size-16 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-primary shadow-sm group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-4xl">upload_file</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1 text-center">
                                        <p id="file-name-text" class="text-slate-900 dark:text-white text-lg font-bold">
                                            Drag and drop attendance files
                                        </p>
                                        <p class="text-slate-500 dark:text-slate-400 text-sm">
                                            Supported formats: .xls, .xlsx (Max 10MB)
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <span class="flex min-w-[120px] items-center justify-center rounded-lg h-11 px-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                        Browse files
                                    </span>
                                </div>
                            </label>

                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="flex items-center justify-center gap-2 rounded-lg h-12 px-10 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                                    <span class="material-symbols-outlined text-xl">check_circle</span> Submit Records
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-slate-900 dark:text-white text-xl font-bold">Recent Uploads</h2>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-primary/10 bg-white dark:bg-slate-900 shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-primary/5">
                                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">File Name</th>
                                        <th class="px-6 py-4 text-xs text-right font-semibold text-slate-500 uppercase tracking-wider">Upload Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-primary/5">

                                    @forelse($logs as $log)
                                    <!-- Row 1 -->
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <span class="material-symbols-outlined text-primary/60">description</span>
                                                <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $log->file_name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right text-slate-500 dark:text-slate-400">{{ $log->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm font-medium text-slate-900 dark:text-white">No files uploaded yet.</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tips Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="p-4 rounded-xl bg-primary/5 border border-primary/10 flex gap-4">
                        <span class="material-symbols-outlined text-primary">info</span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Template Help</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Make sure your file follows our standard format. Download the template here.</p>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-primary/5 border border-primary/10 flex gap-4">
                        <span class="material-symbols-outlined text-primary">security</span>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Secure Upload</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">All data is encrypted end-to-end and stored securely according to policy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-auto py-8 px-6 md:px-20 border-t border-primary/10 bg-white dark:bg-slate-900">
            <div class="max-w-[800px] mx-auto flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 text-sm">
                <p>© 2023 AttendancePortal. All rights reserved.</p>
                <div class="flex gap-6">
                    <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                    <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
                    <a class="hover:text-primary transition-colors" href="#">Help Center</a>
                </div>
            </div>
        </footer>
    </div>
    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('attendance-upload');
        const fileNameText = document.getElementById('file-name-text');

        // 1. Show file name when selected via "Browse"
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                updateFileName(this.files[0].name);
            }
        });

        // 2. Handle Drag and Drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = 'var(--primary)'; // Optional visual cue
            dropZone.style.backgroundColor = 'rgba(var(--primary-rgb), 0.1)';
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.style.borderColor = '';
            dropZone.style.backgroundColor = '';
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '';
            dropZone.style.backgroundColor = '';

            if (e.dataTransfer.files.length > 0) {
                // Assign the dropped file to the hidden input
                fileInput.files = e.dataTransfer.files;
                updateFileName(e.dataTransfer.files[0].name);
            }
        });

        function updateFileName(name) {
            fileNameText.innerText = "Selected: " + name;
            fileNameText.style.color = "#3b82f6"; // Changes color to blue to show success
        }
    </script>
</body>
</html>
