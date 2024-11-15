<!-- resources/views/background_jobs/index.blade.php -->

@extends('layouts.app')

@section('title', 'Background Job Listings')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-8 text-center text-blue-800">Background Job Listings</h1>

    @if(session('status'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('status') }}
        </div>
    @endif

    @if($jobs->isEmpty())
        <p class="text-gray-500 text-center">No background jobs available at the moment.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="py-3 px-6 text-left">Job ID</th>
                        <th class="py-3 px-6 text-left">Class</th>
                        <th class="py-3 px-6 text-left">Method</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Retries</th>
                        <th class="py-3 px-6 text-left">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                        <tr class="hover:bg-gray-100">
                            <td class="py-4 px-6 border-b border-gray-200">{{ $job->id }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">{{ $job->class }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">{{ $job->method }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">
                                @if($job->status === 'completed')
                                    <span class="text-green-600 font-semibold">Completed</span>
                                @elseif($job->status === 'running')
                                    <span class="text-blue-500 font-semibold">Running</span>
                                @elseif($job->status === 'failed')
                                    <span class="text-red-600 font-semibold">Failed</span>
                                @else
                                    <span class="text-gray-500 font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 border-b border-gray-200">{{ $job->retry_count }}</td>
                            <td class="py-4 px-6 border-b border-gray-200">{{ $job->created_at->format('M d, Y H:i') }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
@endsection
