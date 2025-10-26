<!DOCTYPE html>
<html>
<head>
    <title>Search Files - My App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h2 class="mb-4">Search Files</h2>

    <form action="{{ route('search.files') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="q" class="form-control" placeholder="Enter filename..." value="{{ $query ?? '' }}">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>

    @isset($files)
        <h4>Search Results:</h4>
        <ul class="list-group mt-3">
            @forelse($files as $file)
                <li class="list-group-item">
                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank">{{ $file->filename }}</a>
                </li>
            @empty
                <li class="list-group-item text-muted">No files found.</li>
            @endforelse
        </ul>
    @endisset

    <a href="{{ route('home') }}" class="btn btn-link mt-3">Back to Home</a>
</div>

</body>
</html>
