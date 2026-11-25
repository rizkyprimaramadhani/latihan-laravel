<x-app>

    <x-slot:title>{{ $title }}</x-slot>

    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <a class="btn btn-warning mb-3" href="{{ route('lecturer.index') }}" 
    role="button">Back</a>

    <div class="card" style="width: 18rem;">
        <img src="{{ $lecturer->avatar ? asset('storage/' . $lecturer->avatar) : asset('image/no-images.jpeg') }}" 
            class="card-img-top" alt="{{ $lecturer->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $lecturer->name }}</h5>
                    <p class="card-text">Department {{ $lecturer->department->name }}</p>
                    <p class="card-text">Last Update {{ $lecturer->updated_at-> diffForHumans() }}</p>
                </div>
    </div>

</x-app>