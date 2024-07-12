<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->body }}</p>

    <h2>Comments</h2>
    <form method="POST" action="{{ route('comments.store', $post) }}">
        @csrf
        <div class="div">
            <label for="body">Comment</label>
            <textarea name="body" id="body">{{ old('body') }}</textarea>
        </div>
        <div class="div">
            <button type="submit">Add Comment</button>
        </div>
    </form>
    <ul>
        @foreach ($post->comments as comment)
            <li>
                {{ $comment->body }}
                
            </li>
        @endforeach
    </ul>
</body>
</html>