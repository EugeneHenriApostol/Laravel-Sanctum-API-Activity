<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    <form method="POST" action="{{ route('posts.update', $post) }}"></form>
        @csrf
        @method('PUT')
        <div class="div">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="{{ $post->title }}">
        </div>
        <div class="div">
            <label for="body">Body</label>
            <input type="text" id="body" name="body" value="{{ $post->body }}">
        </div>
        <div class="div">
            <button type="submit">Submit</button>
        </div>
</body>
</html>