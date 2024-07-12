<!DOCTYPE html>
<html>
<head>
    <title>Feed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box; /* Ensures padding and border are included in width */
            resize: vertical; /* Allows vertical resizing of textareas */
        }

        button[type="submit"], button[type="button"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        button[type="submit"]:hover, button[type="button"]:hover {
            background-color: #0056b3;
        }

        .post, .comment {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .post h2 {
            margin-top: 0;
        }

        .post p {
            margin-bottom: 10px;
            word-wrap: break-word; /* Allows long words to wrap */
        }

        .comment p {
            margin-bottom: 5px;
            word-wrap: break-word;
        }

        .comment form {
            margin-top: 10px;
        }

        .error {
            color: red;
            font-size: 0.8em;
        }

        .logout-form {
            display: inline;
        }

        .logout-button {
            background-color: #dc3545;
            padding: 5px 10px;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
            border: none;
            margin-left: 10px;
        }

        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, {{ Auth::user()->name }}</h1>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-button">Logout</button>
            </form>
        </div>

        <form method="POST" action="{{ url('posts') }}">
            @csrf
            <div>
                <label>Title</label>
                <input type="text" name="title" style="width: calc(100% - 0px);"> <!-- Adjusting width to account for padding -->
            </div>
            <div>
                <label>Body</label>
                <textarea name="body" style="width: calc(100% - 0px); height: 100px;"></textarea> <!-- Adjusting width and height -->
            </div>
            <button type="submit">Create Post</button>
        </form>

        @foreach($posts as $post)
            <div class="post">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->body }}</p>
                <p>Posted by: {{ $post->user->name }}</p>

                @can('update', $post)
                    <form method="POST" action="{{ url('posts/' . $post->id) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <label>Title</label>
                            <input type="text" name="title" value="{{ $post->title }}" style="width: calc(100% - 22px);"> <!-- Adjusting width -->
                        </div>
                        <div>
                            <label>Body</label>
                            <textarea name="body" style="width: calc(100% - 22px); height: 100px;">{{ $post->body }}</textarea> <!-- Adjusting width and height -->
                        </div>
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
                        <textarea name="body" style="width: calc(100% - 22px);"></textarea> <!-- Adjusting width -->
                    </div>
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <button type="submit">Add Comment</button>
                </form>

                @foreach($post->comments as $comment)
                    <div class="comment">
                        <p>{{ $comment->body }}</p>
                        <p>Commented by: {{ $comment->user->name }}</p>

                        @can('update', $comment)
                            <form method="POST" action="{{ url('comments/' . $comment->id) }}">
                                @csrf
                                @method('PUT')
                                <div>
                                    <textarea name="body" style="width: calc(100% - 22px);">{{ $comment->body }}</textarea> <!-- Adjusting width -->
                                </div>
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
    </div>
</body>
</html>
