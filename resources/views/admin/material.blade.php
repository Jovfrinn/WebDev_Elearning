@extends('admin.layouts.headers')

@section('teacherContent')
<div class="container">
    <div class="header-main">
      <span>Halaman Admin</span>
      <span class="vortex">Semua Materi</span>
      <hr />
    </div>
    <div class="section-materi-admin mx-auto">
        <div class="row">
            @foreach ($materials as $material)
                <div class="col-md-4 my-3">
                    <div class="card-materi mx-auto">
                        <div class="image-section">
                        <img src="{{asset('/assets/img/'.$material->material_image)}}" alt="" />
                        </div>
                        <div class="nama-materi">
                            <a href="">
                                {{$material->material_title}}
                            </a>
                        </div>
                        <div class="section-pemateri">
                        <hr />
                        <div class="pemateri">
                            <div class="nama-pemateri">
                            <div class="nama">{{$material->userTeacher->name}}</div>
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

</div>
</div>
@endsection