@extends('layouts.app')

@section('title', 'Upload Playlist')

@section('content')

@include('includes.nav')


<body class=" min-h-screen flex items-center justify-center">

    <!-- Playlist Upload Form -->
    <div class="container m-auto p-4 sm:p-8 max-w-full">
        <h1 class="text-2xl md:text-3xl font-bold text-left">Upload Playlist Videos</h1>
        <p class="text-gray-600 text-left mb-4">Easily upload your videos and organize them into a playlist for better viewing experience.</p>


       
        <!-- Update Playlist Link -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('admin.update-playlist') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-sm text-gray-800 rounded-md transition">
                <svg class="h-5 w-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Update Existing Playlist
            </a>
        </div>

        <!-- Form to upload playlist -->
        <form action="{{ route('playlists.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Title Input -->
            <div class="mb-4">
                <label for="title" class="block text-sm font-semibold text-gray-700">Title</label>
                <input type="text" name="title" required
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-800">
            </div>

            <!-- Video Link Input -->
            <div class="mb-4">
                <label for="video_link" class="block text-sm font-semibold text-gray-700">Video Link (YouTube or
                    MP4)</label>
                <input type="url" name="video_link" required
                    class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-800">
            </div>

            <!-- Thumbnail Image Upload -->
            <div class="mb-4">
                <label for="thumbnail" class="block text-sm font-semibold text-gray-700">Thumbnail Image </label>
                <input type="file" name="thumbnail" accept="image/*"
                    class="mt-1 block w-full p-[10px] border bg-white border-gray-300 rounded-lg text-gray-800 cursor-pointer hover:bg-gray-100">
            </div>


            <!-- Submit Button -->
            <button type="submit"
                class="cursor-pointer bg-blue-700 w-full text-white py-3 rounded-lg font-bold text-lg transition-all duration-300 hover:bg-blue-800 flex items-center justify-center space-x-2">
                <svg class="h-6 w-6 text-white" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M7 18a4.6 4.4 0 0 1 0 -9h0a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" />
                    <polyline points="9 15 12 12 15 15" />
                    <line x1="12" y1="12" x2="12" y2="21" />
                </svg>
                <span>Upload Playlist</span>
            </button>


        </form>

        

        @endsection