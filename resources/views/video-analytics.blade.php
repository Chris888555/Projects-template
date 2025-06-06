@extends('layouts.app')

@section('title', 'Video Analytics')

@section('content')

@include('includes.nav')

<div class="container m-auto p-4 sm:p-8 max-w-full">
   
     <h1 class="text-2xl md:text-3xl font-bold text-left">Video Watch Analytics</h1>
       <p class="text-gray-600 text-left mb-4">Track and analyze how viewers interact with your videos.</p>


    <p id="note" class="bg-yellow-100 border-l-4 mb-6 border-yellow-500 text-gray-800 p-4 mb-4 text-sm flex items-center justify-between">
    <span>Track user watch progress and engagement throughout your sales funnel videos. Use these metrics to identify user behavior and optimize your funnel.</span>
    <button onclick="document.getElementById('note').classList.add('hidden')" class="text-gray-600 hover:text-gray-800 ml-4 text-xl">
        &times;
    </button>
</p>



    <!-- Add a form for deletion -->
    <form id="delete-form" method="POST" action="{{ route('video-analytics.delete') }}">
        @csrf
        @method('DELETE')


        <div class="mb-4 flex items-center justify-between flex-wrap ">
          

                <!-- Total Page Views Display -->
    <div class="flex items-center gap-4 bg-white shadow-[0px_2px_3px_-1px_rgba(0,0,0,0.1),0px_1px_0px_0px_rgba(25,28,33,0.02),0px_0px_0px_1px_rgba(25,28,33,0.08)] rounded-lg p-5 w-full  mx-auto mb-8 border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <!-- Icon -->
        <div class="w-14 h-14 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
            <svg class="w-7 h-7 text-gray-500 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
            </svg>
        </div>

        <!-- Count and Label -->
        <div class="flex flex-col">
            <span class="text-4xl font-extrabold text-gray-900 dark:text-white">{{ $videoAnalytics->total() }}</span>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Video Views</p>
        </div>
    </div>

            <button type="submit"
                class="bg-red-50 border border-red-200 text-red-500 px-4 py-2 rounded-md hover:bg-red-100 flex items-center gap-2">
                <svg class="h-5 w-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    <line x1="10" y1="11" x2="10" y2="17" />
                    <line x1="14" y1="11" x2="14" y2="17" />
                </svg>
                Delete Selected
            </button>


        </div>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 align-middle text-left whitespace-nowrap">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3  ">
                            <input type="checkbox" id="select-all" class="form-checkbox">
                        </th>
                        <th class="px-6 py-3 ">Client</th>
                        <th class="px-6 py-3">Progress (%)</th>
                        <th class="px-6 py-3">Max Watched (%)</th>
                        <th class="px-6 py-3">Started At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($videoAnalytics as $data)
                    <tr>
                        <td class="px-6 py-3">
                            <input type="checkbox" name="selected[]" value="{{ $data->id }}"
                                class="form-checkbox user-checkbox">
                        </td>
                        <td class="px-6 py-4">{{ $data->user_cookie }}</td>
                        <td class="px-6 py-4">{{ number_format($data->progress, 2) }}</td>
                        <td class="px-6 py-4 text-green-500">{{ number_format($data->max_watch_percentage, 2) }}</td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $data->created_at->format('M-j-Y') }}
                            @if ($data->created_at->isToday())
                            <span
                                class="ml-4 inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                New
                            </span>
                            @endif
                        </td>
                    </tr>
                   @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            <div
                                class="w-full flex items-center flex-wrap justify-center gap-10  p-4">
                                <div class="grid gap-4 w-60">
                                    <svg class="mx-auto" xmlns="http://www.w3.org/2000/svg" width="128" height="124"
                                        viewBox="0 0 128 124" fill="none">
                                        <g filter="url(#filter0_d_14133_718)">
                                            <path
                                                d="M4 61.0062C4 27.7823 30.9309 1 64.0062 1C97.0319 1 124 27.7699 124 61.0062C124 75.1034 119.144 88.0734 110.993 98.3057C99.7572 112.49 82.5878 121 64.0062 121C45.3007 121 28.2304 112.428 17.0071 98.3057C8.85599 88.0734 4 75.1034 4 61.0062Z"
                                                fill="#F9FAFB" />
                                        </g>
                                        <path
                                            d="M110.158 58.4715H110.658V57.9715V36.9888C110.658 32.749 107.226 29.317 102.986 29.317H51.9419C49.6719 29.317 47.5643 28.165 46.3435 26.2531L46.342 26.2509L43.7409 22.2253L43.7404 22.2246C42.3233 20.0394 39.8991 18.7142 37.2887 18.7142H20.8147C16.5749 18.7142 13.1429 22.1462 13.1429 26.386V57.9715V58.4715H13.6429H110.158Z"
                                            fill="#EEF2FF" stroke="#A5B4FC" />
                                        <path
                                            d="M49 20.2142C49 19.6619 49.4477 19.2142 50 19.2142H106.071C108.281 19.2142 110.071 21.0051 110.071 23.2142V25.6428H53C50.7909 25.6428 49 23.8519 49 21.6428V20.2142Z"
                                            fill="#A5B4FC" />
                                        <circle cx="1.07143" cy="1.07143" r="1.07143"
                                            transform="matrix(-1 0 0 1 36.1429 23.5)" fill="#4F46E5" />
                                        <circle cx="1.07143" cy="1.07143" r="1.07143"
                                            transform="matrix(-1 0 0 1 29.7144 23.5)" fill="#4F46E5" />
                                        <circle cx="1.07143" cy="1.07143" r="1.07143"
                                            transform="matrix(-1 0 0 1 23.2858 23.5)" fill="#4F46E5" />
                                        <path
                                            d="M112.363 95.459L112.362 95.4601C111.119 100.551 106.571 104.14 101.323 104.14H21.8766C16.6416 104.14 12.0808 100.551 10.8498 95.4592C10.8497 95.4591 10.8497 95.459 10.8497 95.459L1.65901 57.507C0.0470794 50.8383 5.09094 44.4286 11.9426 44.4286H111.257C118.108 44.4286 123.166 50.8371 121.541 57.5069L112.363 95.459Z"
                                            fill="white" stroke="#E5E7EB" />
                                        <path
                                            d="M65.7893 82.4286C64.9041 82.4286 64.17 81.6945 64.17 80.7877C64.17 77.1605 58.686 77.1605 58.686 80.7877C58.686 81.6945 57.9519 82.4286 57.0451 82.4286C56.1599 82.4286 55.4258 81.6945 55.4258 80.7877C55.4258 72.8424 67.4302 72.8639 67.4302 80.7877C67.4302 81.6945 66.6961 82.4286 65.7893 82.4286Z"
                                            fill="#4F46E5" />
                                        <path
                                            d="M79.7153 68.5462H72.9358C72.029 68.5462 71.2949 67.8121 71.2949 66.9053C71.2949 66.0201 72.029 65.286 72.9358 65.286H79.7153C80.6221 65.286 81.3562 66.0201 81.3562 66.9053C81.3562 67.8121 80.6221 68.5462 79.7153 68.5462Z"
                                            fill="#4F46E5" />
                                        <path
                                            d="M49.9204 68.546H43.1409C42.2341 68.546 41.5 67.8119 41.5 66.9051C41.5 66.0198 42.2341 65.2858 43.1409 65.2858H49.9204C50.8056 65.2858 51.5396 66.0198 51.5396 66.9051C51.5396 67.8119 50.8056 68.546 49.9204 68.546Z"
                                            fill="#4F46E5" />
                                        <circle cx="107.929" cy="91.0001" r="18.7143" fill="#EEF2FF" stroke="#E5E7EB" />
                                        <path
                                            d="M115.161 98.2322L113.152 96.2233M113.554 90.1965C113.554 86.6461 110.676 83.7679 107.125 83.7679C103.575 83.7679 100.697 86.6461 100.697 90.1965C100.697 93.7469 103.575 96.6251 107.125 96.6251C108.893 96.6251 110.495 95.9111 111.657 94.7557C112.829 93.5913 113.554 91.9786 113.554 90.1965Z"
                                            stroke="#4F46E5" stroke-width="1.6" stroke-linecap="round" />
                                        <defs>
                                            <filter id="filter0_d_14133_718" x="2" y="0" width="124" height="124"
                                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                                <feColorMatrix in="SourceAlpha" type="matrix"
                                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                    result="hardAlpha" />
                                                <feOffset dy="1" />
                                                <feGaussianBlur stdDeviation="1" />
                                                <feComposite in2="hardAlpha" operator="out" />
                                                <feColorMatrix type="matrix"
                                                    values="0 0 0 0 0.0627451 0 0 0 0 0.0941176 0 0 0 0 0.156863 0 0 0 0.05 0" />
                                                <feBlend mode="normal" in2="BackgroundImageFix"
                                                    result="effect1_dropShadow_14133_718" />
                                                <feBlend mode="normal" in="SourceGraphic"
                                                    in2="effect1_dropShadow_14133_718" result="shape" />
                                            </filter>
                                        </defs>
                                    </svg>
                                    <div>
                                        <h2 class="text-center text-black text-base font-semibold leading-relaxed pb-1">
                                            No records found</h2>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </form>

    <!-- Pagination links -->
    <div class="mt-4 flex justify-center items-center">
        {{ $videoAnalytics->links() }}
    </div>

</div>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
// Handle "Select All" functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Validate before submitting the form using SweetAlert
document.getElementById('delete-form').addEventListener('submit', function(e) {
    const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');

    if (selectedCheckboxes.length === 0) {
        e.preventDefault(); // Stop form from submitting

        // SweetAlert2 warning
        Swal.fire({
            icon: 'warning',
            title: 'No record selected',
            text: 'Please select at least one record to delete.',
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    }
});
</script>


@endsection