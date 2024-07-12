<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>
    <h1>Create Post</h1>
    <form method="POST" action="{{ route('posts.store') }}">
        @csrf
        <div class="div">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}">
        </div>
        <div class="div">
            <label for="body">Body</label>
            <textarea id="body" name="body">{{ old('body') }}</textarea>
        </div>
        <div class="div">
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>