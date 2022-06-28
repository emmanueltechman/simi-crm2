@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.welcome.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer_messages.welcome.title') }}
@endsection

@section('container')
    <p class="text-center">
        {{ trans('installer_messages.welcome.message') }}
    </p>
    <h6 class="text-center  m-0">
        Envato (Codecanyon) License Summary
    </h6>
    <div>
        <p>The License grants you, the purchaser, an ongoing, non-exclusive, worldwide
            license to make
            use
            of the digital work (Item) you have selected.</p>

        <p>You are licensed to use the Item to create one single End Product for yourself or for one
            client (a
            "single application"), and the End Product can be distributed for Free.</p>

        <p>
            You can create one End Product for a client, and you can transfer that single End
            Product to your
            client
            for any fee. This license is then transferred to your client.</p>

        <p><strong>You can't Sell the End Product, except to one client. </strong></p>


        <p><strong>You can't re-distribute the Item as stock, in a tool or template, or with source
                files. You
                can't do this with an Item either on its own or bundled with other items, and even
                if you modify
                the
                Item. You can't re-distribute or make available the Item as-is or with superficial
                modifications.
                These things are not allowed even if the re-distribution is for Free.</strong></p>


        <p><strong>Although you can modify the Item and therefore delete unwanted components before
                creating
                your
                single End Product, you can't extract and use a single component of an Item on a
                stand-alone
                basis.</strong></p>


        <p>This license can be terminated if you breach it. If that happens, you must stop making
            copies of or
            distributing the End Product until you remove the Item from it.</p>


        <p>The author of the Item retains ownership of the Item but grants you the license on these
            terms. This
            license is between the author of the Item and you. Envato Pty Ltd is not a party to this
            license or
            the
            one giving you the license.</p>

        <p>Read The Full License Here- <a href="https://codecanyon.net/licenses/standard">https://codecanyon.net/licenses/standard</a>
        </p>

    </div>
    <div class="section">
        <div class="text-center">
            <h6>About</h6>
            <hr class="star-primary">
            <p>Application Name: <strong>Rose Billing</strong></p>
            <p>Version: <strong><?php echo $version['version'] ?></strong> Build <?php echo $version['build'] ?></p>

            <p>Release Date: <strong><?php echo $version['date'] ?></strong></p>

            <p>By: <strong>UltimateKode</strong> [ <a href="https://www.ultimatekode.com"
                                                      target="_blank">www.ultimatekode.com</a>
                ]</p>
        </div>
    </div>
    <div class="section">
        <div class="text-center">
            <h6>Support</h6>
            <hr class="star-primary">
            <p><strong><strong class="text-danger">Note</strong>: Please read the troubleshoot_guide before
                    sending any support request.</strong></p>
            <p>If you find any bugs or you have any idea for improvement, Please don't hesitate to
                contact with us using
                Our support page here<br>
                <a href="http://helpdesk.ultimatekode.com/"
                   target="_blank">--Support Section--</a></p>
        </div>
    </div>
    <p class="text-center">
        <a href="{{ route('LaravelInstaller::requirements') }}" class="button">
            {{ trans('installer_messages.welcome.next') }}
            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
        </a>
    </p>
@endsection
