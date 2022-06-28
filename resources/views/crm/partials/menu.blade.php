@php
    use Illuminate\Support\Facades\Route;
@endphp
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header border-bottom">
            <ul class="nav navbar-nav flex-row ">
                <li class="nav-item mobile-menu d-lg-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('crm.invoices.index')}}"><img
                                src="{{ Storage::disk('public')->url('app/public/img/company/' . business(auth('crm')->user()->ins)['logo']) }}"
                               class="avatar-50" style="max-height:70px">
                        <h6 class="brand-text">{{business(auth('crm')->user()->ins)['name']}}</h6>
                    </a></li>

                <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                                                  data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">

                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i
                                    class="ficon ft-maximize"></i></a></li>
                    <li class="dropdown">
                        <a href="#" class="nav-link " data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            <i class="ficon ft-toggle-left"></i> </a>
                        <ul class="dropdown-menu lang-menu" role="menu">
                            <li class="dropdown-item"><a href="{{route('direction',['ltr'])}}"><i
                                            class="ficon ft-layout"></i> {{trans('meta.ltr')}}</a></li>
                            <li class="dropdown-item"><a href="{{route('direction',['rtl'])}}"><i
                                            class="ficon ft-layout"></i> {{trans('meta.rtl')}}</a></li>
                        </ul>


                    </li> @if (config('locale.status') && count(config('locale.languages')) > 1)
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ trans('menus.language-picker.language') }}
                                <span class="caret"></span>
                            </a>


                            @include('includes.partials.lang_focus')
                        </li>
                    @endif
                </ul>
                <ul class="nav navbar-nav float-right">


                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown"><span
                                    class="avatar avatar-online"><img
                                        src="{{ Storage::disk('public')->url('app/public/img/customer/' .auth('crm')->user()->picture) }}"><i></i></span><span
                                    class="user-name">{{auth('crm')->user()->name}}</span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                          href="{{route('crm.user.update')}}"><i
                                        class="ft-user"></i> {{ trans('labels.backend.access.users.edit-profile') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{route('crm.logout')}}"><i
                                        class="ft-power"></i> {{ trans('navs.general.logout') }}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


    </div>
</nav>
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="navigation-header  text-center mb-2"><span class="white">{{trans('customers.panel')}}</span>
                <div class="mt-2"></div>
                <img src="{{ Storage::disk('public')->url('app/public/img/customer/' .auth('crm')->user()->picture) }}"
                     class="avatar-100"></li>


            <li class=" nav-item"><a href="{{route('crm.invoices.index')}}"
                                     class="menu-item  {{ (Route::currentRouteName()=='crm.invoices.index') ? 'active' : '' }}"><i
                            class="ft-file-text"></i><span class="menu-title">{{trans('invoices.invoices')}}</span></a>

            </li>


            <li class=" nav-item"><a href="{{route('crm.quotes.index')}}"
                                     class="menu-item {{ (Route::currentRouteName()=='crm.quotes.index') ? 'active' : '' }}"><i
                            class="ft-phone-outgoing"></i><span class="menu-title">{{trans('quotes.quote')}}</span></a>

            </li>

            <li class=" nav-item"><a href="{{route('crm.projects.index')}}"
                                     class="menu-item {{ (Route::currentRouteName()=='crm.projects.index') ? 'active' : '' }}"><i
                            class="ft-calendar"></i><span class="menu-title">{{trans('projects.projects')}}</span></a>

            </li>

            <li class=" nav-item"><a href="{{route('crm.user.wallet')}}"
                                     class="menu-item {{ (Route::currentRouteName()=='crm.user.wallet') ? 'active' : '' }}"><i
                            class="fa fa-credit-card"></i><span class="menu-title">{{trans('customers.wallet')}}</span></a>

            </li>


        </ul>
    </div>
</div>
