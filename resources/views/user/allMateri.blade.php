@extends('user.layouts.headers')

@section('mainContent')
        <div class="container-fluid text-center mt-4">
          <div class="row mx-auto">

            @foreach($material as $materi)

            <div class="main-materi col-md-4 mt-4">
              <div class="card-materi mx-auto">
                <div class="image-section">
                  <img src="{{asset('assets/img/'.$materi['material_image'])}}" alt="" />
                </div>
                <div class="nama-materi"><a href="{{route('join.class',$materi['id'])}}">{{$materi['material_title']}}</a></div>
                <div class="section-pemateri">
                  <hr />
                  <div class="pemateri">
                    <div class="nama-pemateri">
                      <div class="nama">{{$materi->userTeacher->name}}</div>
                      <div>Pemateri</div>
                    </div>
                    <div class="image-pemateri">
                      <img src="{{asset('assets/img/5e877d32564341611e7ef184f9009800.png')}}" alt="" />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            @endforeach

          </div>
        </div>
@endsection