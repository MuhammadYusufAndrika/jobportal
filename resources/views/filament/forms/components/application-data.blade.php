<div class="space-y-4">
    @if(isset($application_data) && count($application_data) > 0)
        @foreach($application_data as $data)
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900 mb-2">{{ $data['field'] }}</h4>
                        
                        @if($data['is_file'])
                            <div class="flex items-center space-x-3">
                                @php
                                    $extension = strtolower($data['file_extension']);
                                    $isPdf = $extension === 'pdf';
                                    $isDoc = in_array($extension, ['doc', 'docx']);
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png']);
                                @endphp
                                
                                <div class="flex items-center space-x-2">
                                    @if($isPdf)
                                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 18h12V6l-4-4H4v16zm8-14v3h3l-3-3z"/>
                                        </svg>
                                        <span class="text-red-600 font-medium">PDF</span>
                                    @elseif($isDoc)
                                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 18h12V6l-4-4H4v16zm8-14v3h3l-3-3z"/>
                                        </svg>
                                        <span class="text-blue-600 font-medium">DOC</span>
                                    @elseif($isImage)
                                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/>
                                        </svg>
                                        <span class="text-green-600 font-medium">IMAGE</span>
                                    @else
                                        <svg class="w-8 h-8 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 18h12V6l-4-4H4v16zm8-14v3h3l-3-3z"/>
                                        </svg>
                                        <span class="text-gray-600 font-medium">FILE</span>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $data['file_name'] }}</p>
                                    <p class="text-xs text-gray-500">Click the buttons to view or download</p>
                                </div>
                                
                                <div class="flex space-x-2">
                                    @if($isPdf)
                                        <a href="{{ $data['file_url'] }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View PDF
                                        </a>
                                        <a href="{{ $data['file_url'] }}" 
                                           download
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download
                                        </a>
                                    @elseif($isImage)
                                        <a href="{{ $data['file_url'] }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Image
                                        </a>
                                        <a href="{{ $data['file_url'] }}" 
                                           download
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download
                                        </a>
                                    @else
                                        <a href="{{ $data['file_url'] }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Open File
                                        </a>
                                        <a href="{{ $data['file_url'] }}" 
                                           download
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="text-gray-900">
                                @if(is_array($data['value']))
                                    {{ implode(', ', $data['value']) }}
                                @else
                                    {{ $data['value'] }}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="text-center py-6 text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="mt-2">No application data available</p>
        </div>
    @endif
</div>