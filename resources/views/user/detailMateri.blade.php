@extends('user.layouts.headers')

@section('mainContent')

<div class="containerVideo mx-auto">
<div class="section-detail-materi">
    <div class="title-subMateri">
        <i class="bi bi-play-btn"></i> - 
        {{$detailMateri->title}}
    </div>
    <section>
        <div class="section-video-materi">
            <div class="video_player">
                <video preload="metadata" class="main-video" tabindex="0">
                <!-- <source src="How to add twak.to chat app in website-480p.mp4" size="480" type="video/mp4"> -->
                <source src="{{asset('assets/video/'.$detailMateri->file_material)}}" size="720" type="video/mp4">
                <!-- <source src="How to add twak.to chat app in website-1080p.mp4" size="1080" type="video/mp4"> -->
                </video>
            </div>
        </div>
    </section>
    <div class="btn-complete d-flex justify-content-center my-4">
        <a href="{{route('sub.materi', $detailMateri->id_material)}}" class="btn button-compelete">Selesai</a>
    </div>
    </div>

    {{-- Comments --}}
    <div class="comments">
    <div id="disqus_thread"></div>
<script>
    /**
    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
    
    var disqus_config = function () {
    this.page.url = "{{route('show.materi', $detailMateri->id)}}";  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = "PID_"+"{{$detailMateri->id}}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };

    (function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = 'https://webelearning.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
</div>
</div>

@endsection

@section('script')
<script src="{{asset('assets/js/scriptVideo.js')}}"></script>
@endsection