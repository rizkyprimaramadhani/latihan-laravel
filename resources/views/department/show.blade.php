<x-app>

    <x-slot:title>{{ $title }}</x-slot>

    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <a class="btn btn-primary mb-3" href="{{ route('department.index') }}" 
    role="button">Back</a>

    <ul class="list-group">
        @foreach ( $department->lecturers as $lecturer)
            <li class="list-group-item">
                {{ $loop->iteration }}. {{ $lecturer->name }}</li>
        @endforeach
</ul>

</x-app>