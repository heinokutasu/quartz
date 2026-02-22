<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Upload Attendance - Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
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
                    <a class="relative text-primary text-sm font-bold py-1 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-primary after:rounded-full" href="{{ route('home') }}">Upload</a>
                    <a class="text-slate-600 dark:text-gray-400 text-sm font-medium hover:text-primary transition-colors" href="{{ route('report') }}">Report</a>
                </nav>
            </div>
        </header>

        <main class="flex flex-1 justify-center py-10 px-4 md:px-20">
            <div class="layout-content-container flex flex-col max-w-[800px] flex-1 gap-8">
                @if(session('success'))
                <div class="mb-0 @container">
                    <div class="flex flex-1 flex-col items-start justify-between gap-4 rounded-xl border border-emerald-100 bg-emerald-50 dark:bg-emerald-950/20 dark:border-emerald-900/50 p-5 @[480px]:flex-row @[480px]:items-center">
                        <div class="flex items-center gap-4">
                            <div class="bg-emerald-500 text-white rounded-full p-1 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
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
                <div class="mb-0 @container">
                    <div class="flex flex-1 flex-col items-start justify-between gap-4 rounded-xl border border-rose-100 bg-rose-50 dark:bg-rose-950/20 dark:border-rose-900/50 p-5 @[480px]:flex-row @[480px]:items-center">
                        <div class="flex items-center gap-4">
                            <div class="bg-rose-500 text-white rounded-full p-1 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor"><path d="M480-280q17 0 28.5-11.5T520-320q0-17-11.5-28.5T480-360q-17 0-28.5 11.5T440-320q0 17 11.5 28.5T480-280Zm-40-160h80v-240h-80v240Zm40 360q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                            </div>
                            <div class="flex flex-col">
                                <p class="text-rose-900 dark:text-rose-100 text-base font-bold leading-tight">Failed!</p>
                                <p class="text-rose-700 dark:text-rose-400 text-sm font-normal leading-normal">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="flex flex-col gap-2">
                    <h1 class="text-slate-900 dark:text-white text-4xl font-black leading-tight tracking-tight">Upload Attendance</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-base font-normal">Select your attendance data files to get started.</p>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-xl border border-primary/10 shadow-sm overflow-hidden">
                    <div class="p-8">
                        <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" id="attendanceForm">
                            @csrf
                            <label for="attendance-upload" id="drop-zone" class="flex flex-col items-center gap-6 rounded-xl border-2 border-dashed border-primary/20 bg-primary/5 px-6 py-16 hover:border-primary/40 transition-all cursor-pointer group">
                                <input accept=".csv, .xlsx" class="hidden" id="attendance-upload" name="attendance_file" type="file" />
                                <div class="flex flex-col items-center gap-4">
                                    <div class="size-16 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-primary shadow-sm group-hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32" fill="currentColor">
                                            <path d="M440-200v-326L330-416l-56-58 194-194 194 194-56 58-110-110v326h-80ZM160-640v-120q0-33 23.5-56.5T240-840h480q33 0 56.5 23.5T800-760v120h-80v-120H240v120h-80Z"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col items-center gap-1 text-center">
                                        <p id="file-name-text" class="text-slate-900 dark:text-white text-lg font-bold">Drag and drop attendance files</p>
                                        <p class="text-slate-500 dark:text-slate-400 text-sm">Supported formats: .xls, .xlsx (Max 10MB)</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <span class="flex min-w-[120px] items-center justify-center rounded-lg h-11 px-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">Browse files</span>
                                </div>
                            </label>

                            <div class="mt-8 flex justify-end">
                                <button type="submit" class="flex items-center justify-center gap-2 rounded-lg h-12 px-10 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor"><path d="m424-312 282-282-56-56-226 226-114-114-56 56 170 170ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                                    Submit Records
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <h2 class="text-slate-900 dark:text-white text-xl font-bold">Recent Uploads</h2>
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
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <svg class="text-primary/60" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor"><path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/></svg>
                                                <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $log->file_name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-right text-slate-500 dark:text-slate-400">{{ $log->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">No files uploaded yet.</td>
                                        <td></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="p-4 rounded-xl bg-primary/5 border border-primary/10 flex gap-4">
                        <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Template Help</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Make sure your file follows our standard format. Download the template here.</p>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-primary/5 border border-primary/10 flex gap-4">
                        <svg class="text-primary" xmlns="http://www.w3.org/2000/svg" height="20" viewBox="0 -960 960 960" width="20" fill="currentColor"><path d="M480-80q-139-35-229.5-159.5T160-516v-244l320-120 320 120v244q0 152-90.5 276.5T480-80Zm0-84q104-33 172-132t68-220v-189l-240-90-240 90v189q0 121 68 220t172 132Zm0-316Z"/></svg>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Secure Upload</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">All data is encrypted end-to-end and stored securely according to policy.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="mt-auto py-8 px-6 md:px-20 border-t border-primary/10 bg-white dark:bg-slate-900">
            <div class="max-w-[800px] mx-auto flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 text-sm">
                <p>© 2026 AttendancePortal. All rights reserved.</p>
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

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                updateFileName(this.files[0].name);
            }
        });

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-primary', 'bg-primary/10');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-primary', 'bg-primary/10');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-primary', 'bg-primary/10');

            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                updateFileName(e.dataTransfer.files[0].name);
            }
        });

        function updateFileName(name) {
            fileNameText.innerText = "Selected: " + name;
            fileNameText.classList.add('text-primary');
        }
    </script>
</body>
</html>
