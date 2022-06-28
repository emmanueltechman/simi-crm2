@extends ('core.layouts.app')
@section ('title','Application Activation Panel')
@section('content')
    <div class="">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h4 class="content-header-title mb-0">Application Activation Panel</h4>

                </div>

            </div>
            <div class="content-body">

                {{ Form::open(['route' => 'biller.activate_post', 'class' => 'card form-horizontal', 'role' => 'form', 'method' => 'post','files' => true]) }}

                <input type="hidden" id="core"
                       value="settings/activate">
                <div class="card-body">

                    <h5>Activate Rose Billing</h5>
                    <hr>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="email">Email</label>

                        <div class="col-sm-6">
                            <input type="email"
                                   class="form-control margin-bottom  required" name="email"
                                   placeholder="Your Email Address">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="code">Envato Purchase Code</label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="Envato Activation Code"
                                   class="form-control margin-bottom  required" name="code"
                            >
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="currency">License</label>

                        <div class="col-sm-6">
                            <p>Single Use Standard License. Read The Full License Here <a
                                        href="https://codecanyon.net/licenses/standard">https://codecanyon.net/licenses/standard</a>.
                                You can not activate the application on multiple domains with single key.
                            </p>
                            <p> Standard License license has two types : </p>
                            <p> i. Regular <br> - Suitable for one company and <strong>one installation.</strong></p>
                            <p> ii. Extended<br> - Suitable for multi companies and <strong>one installation.</strong>
                            </p>
                            <p>
                                <a
                                        href="https://codecanyon.net/licenses/standard">https://codecanyon.net/licenses/standard</a>
                            </p>
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" class="btn btn-success margin-bottom"
                                   value="Confirm" data-loading-text="Updating...">
                        </div>
                    </div>

                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
