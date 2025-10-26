<!DOCTYPE html>
<html>
<head>
    <title>File Upload - My App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<div class="container">
    <h2 class="mb-4">Upload a File</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input type="file" name="file" class="form-control" required>
        </div>
        <button class="btn btn-primary">Upload</button>
    </form>

    <hr>

<h3>Uploaded Files</h3>
<ul class="list-group mt-3">
    @foreach($files as $file)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                {{-- ✅ If file is an image, show preview --}}
                @php
                    $extension = pathinfo($file->filename, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                @endphp

                @if($isImage)
                    <img src="{{ asset($file->path) }}" alt="{{ $file->filename }}" 
                         alt="{{ $file->filename }}" 
                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                @else
                    <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" 
                         alt="File icon" 
                         style="width: 40px; height: 40px; margin-right: 15px;">
                @endif

                {{-- File name link --}}
                <a href="{{ asset($file->path) }}" target="_blank">{{ $file->filename }}</a>
            </div>

            {{-- Delete button --}}
            <form action="{{ route('file.delete', $file->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>
        </li>
    @endforeach
</ul>


    <a href="{{ route('search.page') }}" class="btn btn-link mt-3">Go to Search Page</a>
</div>

</body>
</html>
