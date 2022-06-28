@extends ('crm.layouts.app')
@section ('title', trans('labels.backend.access.users.no_permissions'))
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">{{trans('labels.backend.access.users.no_permissions')}}</h4>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block"><h4>{{trans('labels.backend.access.users.no_permissions')}}</h4>


                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
