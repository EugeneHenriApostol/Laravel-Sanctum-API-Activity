<!DOCTYPE html>
<html>
<head>
    <title>Feed</title>
</head>
<body>
    <h1>Welcome, {{ Auth::user()->name }}</h1>
    <form method="POST" action="{{ url('posts') }}">
        @csrf
        <div>
            <label>Title</label>
            <input type="text" name="title">
        </div>
        <div>
            <label>Body</label>
            <textarea name="body"></textarea>
        </div>
        <button type="submit">Create Post</button>
    </form>

    @foreach($posts as $post)
        <div>
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->body }}</p>
            <p>Posted by: {{ $post->user->name }}</p>

            @can('update', $post)
                <form method="POST" action="{{ url('posts/' . $post->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="text" name="title" value="{{ $post->title }}">
                    <textarea name="body">{{ $post->body }}</textarea>
                    <button type="submit">Update Post</button>
                </form>
            @endcan

            @can('delete', $post)
                <form method="POST" action="{{ url('posts/' . $post->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete Post</button>
                </form>
            @endcan

            <form method="POST" action="{{ url('comments') }}">
                @csrf
                <div>
                    <textarea name="body"></textarea>
                </div>
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <button type="submit">Add Comment</button>
            </form>

            @foreach($post->comments as $comment)
                <div>
                    <p>{{ $comment->body }}</p>
                    <p>Commented by: {{ $comment->user->name }}</p>

                    @can('update', $comment)
                        <form method="POST" action="{{ url('comments/' . $comment->id) }}">
                            @csrf
                            @method('PUT')
                            <textarea name="body">{{ $comment->body }}</textarea>
                            <button type="submit">Update Comment</button>
                        </form>
                    @endcan

                    @can('delete', $comment)
                        <form method="POST" action="{{ url('comments/' . $comment->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete Comment</button>
                        </form>
                    @endcan
                </div>
            @endforeach
        </div>
    @endforeach
</body>
</html>
