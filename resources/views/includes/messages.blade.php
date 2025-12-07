{{-- partials/messages.blade.php --}}
@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4 shadow-md text-center">
        {{ session('success') }}
    </div>
@endif

@if(session('danger'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 shadow-md text-center">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 shadow-md">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
