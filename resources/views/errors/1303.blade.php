@extends ('core.layouts.public_app')
@section('content')
    <div class="content-wrapper ">

        <div class="content-body">
            <section class="flexbox-container mt-5">
                <div class="col-12 d-flex align-items-center justify-content-center card">
                    <div class="col-lg-4 col-md-8 col-10">
                        <div class="card-header bg-transparent border-5">
                            <h1 class="error-code text-center mt-5 mb-5 danger">Unexpected Error!</h1>
                            <p class="text-center">{!! $code !!}</p>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
