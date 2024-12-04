<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Pembelajaran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f0f4f8;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: white;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            font-size: 1.1rem;
            color: #1a365d;
        }

        .share-button {
            background: none;
            border: none;
            cursor: pointer;
            color: #1a365d;
        }

        .main-content {
            position: relative;
            background-color: white;
            aspect-ratio: 16/9;
            overflow: hidden;
        }

        .main-content img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
            background-color: white;
            border-radius: 0 0 8px 8px;
        }

        .nav-button {
            padding: 8px 20px;
            background-color: #1a365d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .nav-button:hover {
            background-color: #2c5282;
        }

        .thumbnail-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .thumbnail {
            position: relative;
            aspect-ratio: 16/9;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thumbnail-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .thumbnail-container {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 10px;
            }

            .header h1 {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">

            
            <h1>01 - Video Pembelajaran</h1>
            <button class="share-button">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                    <polyline points="16 6 12 2 8 6"></polyline>
                    <line x1="12" y1="2" x2="12" y2="15"></line>
                </svg>
            </button>
        </header>

        <main class="main-content">
            @if($detailMateri->description == NULL )
            <img src="/placeholder.svg?height=720&width=1280" alt="Video content">
            @elseif($detailMateri->file_material == NULL)
            <div>{{$detailMateri->description}}</div>
            @endif
        </main>

        <nav class="navigation">
            <button class="nav-button">Previous</button>
            <button class="nav-button">Continue</button>
        </nav>

        <div class="thumbnail-container">
            <div class="thumbnail">
                <img src="/placeholder.svg?height=180&width=320" alt="Video 03">
                <div class="thumbnail-title">03 - Video</div>
            </div>
            <div class="thumbnail">
                <img src="/placeholder.svg?height=180&width=320" alt="Video 04">
                <div class="thumbnail-title">04 - Video</div>
            </div>
            <div class="thumbnail">
                <img src="/placeholder.svg?height=180&width=320" alt="Video 05">
                <div class="thumbnail-title">05 - Video</div>
            </div>
            <div class="thumbnail">
                <img src="/placeholder.svg?height=180&width=320" alt="Video 06">
                <div class="thumbnail-title">06 - Video</div>
            </div>
            <div class="thumbnail">
                <img src="/placeholder.svg?height=180&width=320" alt="Video 07">
                <div class="thumbnail-title">07 - Video</div>
            </div>
        </div>
    </div>
</body>
</html>