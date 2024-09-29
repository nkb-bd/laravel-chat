<x-app-layout>
    <div class=" w-full min-h-screen" id="app" >

        <chat-app
            :current-user='{{$currentUser}}'
            :conversations='{{$conversations}}'
            :active-conversations='@json($activeConversation)'
        />
    </div>
</x-app-layout>

{{--@push('styles')--}}
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">--}}
{{--@endpush--}}

{{--@push('scripts')--}}
{{--    <script src="https://cdn.tailwindcss.com"></script>--}}
{{--@endpush--}}
