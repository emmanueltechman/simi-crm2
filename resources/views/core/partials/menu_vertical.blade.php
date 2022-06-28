<!-- BEGIN: Header-->
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item mr-auto logo_margin"><a class="navbar-brand" href="{{route('biller.dashboard')}}"><img
                            class="brand-logo"
                            alt="Brand Logo"
                            src="{{ Storage::disk('public')->url('app/public/img/company/theme/' . config('core.theme_logo')) }}">

                    </a></li>

                <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">


                    @include('core.partials.mega')
                    @permission('pos')
                    <li class="nav-item ">
                        <a href="{{route('biller.invoices.pos')}}" class="btn  btn-success round mt_6">
                            <i class="ficon ft-shopping-cart"></i>{{trans('pos.pos')}} </a></li>
                    @endauth
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#" title="Press F11 or Fn+F11 to Get Full Screen" alt="Press F11 or Fn+F11 to Get Full Screen"><i
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


                    </li>


                </ul>
                <ul class="nav navbar-nav float-right">
                    @if (config('locale.status') && count(config('locale.languages')) > 1)
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ trans('menus.language-picker.language') }}
                                <span class="caret"></span>
                            </a>


                            @include('includes.partials.lang_focus')
                        </li>
                    @endif

                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"
                                                                           onclick="loadNotifications()"><i
                                class="ficon ft-bell"></i><span
                                class="badge badge-pill badge-danger badge-up"
                                id="n_count">{{ auth()->user()->unreadNotifications->count() }}</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right" id="user_notifications">

                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown">@if(session('clock', false))
                                <i
                                    class="ficon ft-clock spinner"></i>
                                <span
                                    class="badge badge-pill badge-info badge-up">{{trans('general.on') }}</span>
                            @else
                                <i
                                    class="ficon ft-clock"></i>
                                <span
                                    class="badge badge-pill badge-danger badge-up"> {{trans('general.off') }}</span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

                            <li class="scrollable-container media-list">
                                <div class="media">

                                    <div class="media-body text-center">
                                        @if(!session('clock', false)) <a href="{{route('biller.clock')}}"
                                                                         class="btn btn-success"><i
                                                class="ficon ft-clock spinner"></i> {{trans('hrms.clock_in') }}</a>
                                        @else
                                            <a href="{{route('biller.clock')}}" class="btn btn-secondary"><i
                                                    class="ficon ft-clock"></i> {{trans('hrms.clock_out') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label"
                                                                           href="{{route('biller.messages')}}"><i
                                class="ficon ft-mail"></i><span
                                class="badge badge-pill badge-warning badge-up">{{Auth::user()->newThreadsCount()}}</span></a>

                    </li>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown"><span
                                class="avatar avatar-online"><img
                                    src="{{ Storage::disk('public')->url('app/public/img/users/' . @$logged_in_user->picture) }}"
                                    alt=""><i></i></span><span class="user-name">{{ $logged_in_user->name }}</span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                          href="{{ route('biller.profile') }}"><i
                                    class="ft-user"></i> {{ trans('navs.frontend.user.account')}}</a><a
                                class="dropdown-item" href="{{route('biller.messages')}}"><i class="ft-mail"></i> My
                                Inbox</a><a
                                class="dropdown-item" href="{{route('biller.todo')}}"><i
                                    class="ft-check-square"></i>
                                {{ trans('general.tasks')}}</a><a
                                class="dropdown-item" href="{{route('biller.attendance')}}"><i
                                    class="ft-activity"></i>
                                {{ trans('hrms.attendance')}}</a>


                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('biller.logout') }}"><i
                                    class="ft-power"></i> {{  trans('navs.general.logout') }}</a>


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
            <li class="nav-item m-4"></li>
            <li class="nav-item"><a
                    class="nav-link {{ Request::segment(1) == 'dashboard' ? 'active' : null }}"
                    href="{{route('biller.dashboard')}}"><i
                        class="ft-home"></i><span>{{  trans('navs.frontend.dashboard') }}</span></a>
            </li>
            @if(access()->allow('invoice-manage') || access()->allow('quote-quote'))
                <li class="nav-item {{ $active_path == 'invoices' || $active_path == 'quotes' || $active_path == 'orders'? 'open' : null }}"><a href="#"
                    ><i
                            class="icon-basket"></i><span>{{trans('features.sales')}}</span></a>
                    <ul class="menu-content">
                        @permission('invoice-manage')
                        <li><a
                                class="menu-item" href="#"><i
                                    class="ft-layout"></i> {{ trans('invoices.management') }}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{route( 'biller.invoices.index' ) }}"
                                    ><i
                                            class="ft-file-text"></i> {{ trans('labels.backend.invoices.management') }}
                                    </a>
                                </li>
                                @permission('invoice-create')
                                <li><a class="menu-item" href="{{ route( 'biller.invoices.create' ) }}"
                                    ><i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.invoices.create') }}
                                    </a>
                                </li> @endauth
                                <li><a class="menu-item" href="{{route( 'biller.invoices.index' ) }}?md=pos"
                                    ><i
                                            class="ft-zap"></i> {{ trans('labels.backend.invoices.pos_management') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endauth
                        @permission('quote-manage')
                        <li ><a
                                class="menu-item dropdown-toggle" href="#" ><i
                                    class="ft-phone-outgoing"></i> {{ trans('quotes.management') }}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{ route( 'biller.quotes.index' ) }}"
                                    ><i
                                            class="ft-file-text"></i> {{ trans('quotes.management') }}
                                    </a>
                                </li>
                                <li><a class="menu-item" href="{{ route( 'biller.quotes.create' ) }}"
                                    ><i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.quotes.create') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endauth
                        @permission('invoice-manage')
                        <li ><a
                                class="menu-item " href="#" ><i
                                    class="icon-umbrella"></i> {{ trans('invoices.subscriptions') }}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{route( 'biller.invoices.index')}}?md=sub"
                                    ><i
                                            class="ft-file-text"></i> {{ trans('invoices.subscriptions')}}
                                    </a>
                                </li>
                                <li><a class="menu-item" href="{{ route( 'biller.invoices.create' ) }}?sub=true"
                                    ><i
                                            class="fa fa-plus-circle"></i> {{ trans('invoices.create_subscription') }}
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endauth
                        @permission('creditnote-manage')
                        <li ><a
                                class="menu-item" href="#" ><i
                                    class="ft-phone-outgoing"></i> {{ trans('orders.credit_notes') }}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item"
                                       href="{{route( 'biller.orders.index' )}}?section=creditnote"
                                    ><i
                                            class="ft-file-text"></i> {{ trans('orders.credit_notes_manage')}}
                                    </a>
                                </li>
                                @permission('data-creditnote')
                                <li><a class="menu-item"
                                       href="{{ route( 'biller.orders.create' )}}?section=creditnote"
                                    ><i
                                            class="fa fa-plus-circle"></i> {{ trans('orders.credit_notes_create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth

                    </ul>
                </li>
            @endif
            @if(access()->allow('manage-customer') || access()->allow('manage-customergroup'))
                <li class="nav-item {{ $active_path == 'customers' || $active_path == 'customergroups'? 'open' : null }}"><a class="menu-item" href="#"
                    ><i
                            class="icon-diamond"></i><span>{{trans('features.crm')}}</span></a>
                    <ul class="menu-content">
                        @permission('manage-customer')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="ft-users"></i></i> {{ trans('labels.backend.customers.management') }}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{ route( 'biller.customers.index' ) }}"
                                    ><i
                                            class="ft-list"></i> {{ trans('labels.backend.customers.management') }}
                                    </a>
                                </li>
                                @permission('customer-create')
                                <li><a class="menu-item" href="{{ route( 'biller.customers.create' ) }}"
                                    ><i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.customers.create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth
                        @permission('manage-customergroup')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="ft-grid"></i></i> {{ trans('labels.backend.customergroups.management') }}
                            </a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{ route( 'biller.customergroups.index' ) }}"
                                    ><i
                                            class="ft-list"></i> {{ trans('labels.backend.customergroups.management') }}
                                    </a>
                                </li>
                                @permission('create-customergroup')
                                <li><a class="menu-item" href="{{ route( 'biller.customergroups.create' ) }}"
                                    ><i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.customergroups.create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth

                    </ul>
                </li>
            @endif
            @if(access()->allow('product-manage') || access()->allow('purchaseorder-manage') || access()->allow('manage-warehouse') || access()->allow('supplier-manage'))
                <li class="nav-item {{ $active_path == 'products' || $active_path == 'purchaseorders' || $active_path == 'suppliers'? 'open' : null }}" ><a class="menu-item" href="#"
                    ><i
                            class="ft-layers"></i><span>{{trans('features.stock')}}</span></a>
                    <ul class="menu-content">

                        @permission('product-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-cube"></i> {{ trans('labels.backend.products.management') }}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{ route( 'biller.products.index' ) }}"
                                    > <i
                                            class="ft-list"></i> {{ trans('labels.backend.products.management') }}
                                    </a>
                                </li>

                                @permission('product-create')
                                <li><a class="menu-item" href="{{ route( 'biller.products.create' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.products.create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth

                        @permission('purchaseorder-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-clipboard"></i> {{ trans('purchaseorders.management') }}
                            </a>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{ route( 'biller.purchaseorders.index' ) }}"
                                    > <i
                                            class="ft-list"></i> {{ trans('purchaseorders.management') }}
                                    </a>
                                </li>
                                @permission('purchaseorder-data')
                                <li><a class="menu-item" href="{{ route( 'biller.purchaseorders.create' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.purchaseorders.create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth


                        @permission('productcategory-manage')

                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-object-ungroup"></i> {{ trans('labels.backend.productcategories.management') }}
                            </a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{ route( 'biller.productcategories.index' ) }}"
                                    > <i
                                            class="ft-list"></i> {{ trans('labels.backend.productcategories.management') }}
                                    </a>
                                </li>
                                @permission('productcategory-data')
                                <li><a class="menu-item" href="{{ route( 'biller.productcategories.create' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.productcategories.create') }}
                                    </a>
                                </li> @endauth

                            </ul>
                        </li>
                        @endauth
                        @permission('manage-warehouse')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-building-o"></i> {{ trans('labels.backend.warehouses.management') }}
                            </a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{ route( 'biller.warehouses.index' ) }}"
                                    > <i
                                            class="ft-list"></i> {{ trans('labels.backend.warehouses.management') }}
                                    </a>
                                </li>
                                @permission('warehouse-data')
                                <li><a class="menu-item" href="{{ route( 'biller.warehouses.create' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.warehouses.create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth
                        @permission('supplier-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="ft-target"></i> {{ trans('suppliers.management') }}
                            </a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{ route( 'biller.suppliers.index' ) }}"
                                    > <i
                                            class="ft-list"></i> {{ trans('suppliers.management') }}
                                    </a>
                                </li>
                                @permission('supplier-data')
                                <li><a class="menu-item" href="{{ route( 'biller.suppliers.create' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.suppliers.create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth
                        @permission('stockreturn-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-puzzle-piece"></i> {{ trans('orders.stock_returns') }}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item"
                                       href="{{route( 'biller.orders.index' )}}?section=stockreturn"
                                    ><i
                                            class="ft-file-text"></i> {{ trans('orders.stock_return_manage')}}
                                    </a>
                                </li>
                                @permission('stockreturn-data')
                                <li><a class="menu-item"
                                       href="{{ route( 'biller.orders.create' )}}?section=stockreturn"
                                    ><i
                                            class="fa fa-plus-circle"></i> {{ trans('orders.stock_return_create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth
                        @permission('creditnote-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="ft-phone-outgoing"></i> {{ trans('orders.stock_return_customer') }}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item"
                                       href="{{route( 'biller.orders.index' )}}?section=creditnote"
                                    ><i
                                            class="ft-file-text"></i> {{ trans('orders.credit_notes_manage')}}
                                    </a>
                                </li>
                                @permission('data-creditnote')
                                <li><a class="menu-item"
                                       href="{{ route( 'biller.orders.create' )}}?section=creditnote"
                                    ><i
                                            class="fa fa-plus-circle"></i> {{ trans('orders.credit_notes_create') }}
                                    </a>
                                </li> @endauth
                            </ul>
                        </li>
                        @endauth
                        @permission('product-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-barcode"></i> {{ trans('products.product_label_print') }}
                            </a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{route( 'biller.products.product_label' )}}"
                                    > <i
                                            class="ft-list"></i> {{ trans('products.product_label_print') }}
                                    </a>
                                </li>
                                <li><a class="menu-item" href="{{route( 'biller.products.standard' )}}"
                                    > <i
                                            class="ft-list"></i> {{ trans('products.standard_sheet') }}
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @endauth
                        @permission('stocktransfer')
                        <li><a
                                class="dropdown-item " href="{{route( 'biller.products.stock_transfer' )}}"><i
                                    class="ft-wind"></i> {{ trans('products.stock_transfer') }}</a>

                        </li> @endauth

                    </ul>
                </li>

            @endif

            @if(access()->allow('transaction-manage') || access()->allow('account-manage'))
                <li class="nav-item {{ $active_path == 'accounts' || $active_path == 'transactions' ? 'open' : null }}" ><a class="menu-item" href="#"
                    ><i
                            class="icon-calculator"></i><span>{{trans('general.finance')}}</span></a>
                    <ul class="menu-content">
                        @permission('account-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-book"></i> {{ trans('labels.backend.accounts.management') }}
                            </a>
                            <ul class="menu-content">

                                <li><a class="menu-item" href="{{ route( 'biller.accounts.index' ) }}"
                                    > <i
                                            class="ft-list"></i> {{ trans('labels.backend.accounts.management') }}
                                    </a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{ route( 'biller.accounts.balance_sheet',['v']) }}"
                                    > <i
                                            class="fa fa-columns"></i> {{ trans('accounts.balance_sheet') }}</a>
                                </li>
                                @permission('account-data')
                                <li><a class="menu-item" href="{{ route( 'biller.accounts.create' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.accounts.create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth
                        @permission('transaction-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-hdd-o"></i> {{ trans('labels.backend.transactions.management') }}
                            </a>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{ route( 'biller.transactions.index' ) }}"
                                    > <i
                                            class="ft-list"></i> {{ trans('labels.backend.transactions.management') }}
                                    </a>
                                </li>
                                @permission('transaction-data')
                                <li><a class="menu-item" href="{{ route( 'biller.transactions.create' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('labels.backend.transactions.create') }}
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </li>
                        @endauth
                    </ul>
                </li>  @endif
            @if(access()->allow('project-manage') || access()->allow('task-manage'))
                <li class="nav-item {{ $active_path == 'projects' || $active_path == 'tasks' ? 'open' : null }}" ><a class="menu-item" href="#"
                    ><i
                            class="icon-briefcase"></i><span>{{trans('features.project_tasks')}}</span></a>
                    <ul class="menu-content">
                        @permission('project-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="ft-calendar"></i> {{ trans('labels.backend.projects.management') }}</a>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{ route( 'biller.projects.index' ) }}"
                                    > <i class="ft-list"></i> {{ trans('projects.projects')}}
                                        <span class="badge badge-sm badge-primary">Beta</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        @endauth
                        @permission('task-manage')
                        <li  ><a
                                class="menu-item" href="{{ route( 'biller.tasks.index' ) }}"><i
                                    class="icon-directions"></i> {{ trans('labels.backend.tasks.management') }}</a>
                        </li>
                        @endauth
                        @permission('misc-manage')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="icon-tag"></i> {{ trans('tags.tag_status') }}</a>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{ route( 'biller.miscs.index')}}?module=task"
                                    > <i
                                            class="fa fa-compass"></i> {{ trans('tasks.status_management') }}
                                    </a>
                                </li>
                                <li><a class="menu-item" href="{{ route( 'biller.miscs.create' ) }}?module=task"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('tags.new_status') }}
                                    </a>
                                </li>
                                <li><a class="menu-item" href="{{ route( 'biller.miscs.index' ) }}"
                                    > <i class="fa fa-tags"></i> {{ trans('tags.tags') }}</a>
                                </li>
                                <li><a class="menu-item" href="{{ route( 'biller.miscs.create' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('tags.new') }}
                                    </a>
                                </li>


                            </ul>
                        </li>
                        @endauth

                    </ul>
                </li>
            @endif
            @if(access()->allow('manage-hrm') || access()->allow('department-manage'))
                <li class="nav-item {{ $active_path == 'hrms' || $active_path == 'attendance' || $active_path == 'departments'? 'open' : null }}" ><a class="menu-item" href="#"
                    ><i
                            class="icon-badge"></i><span>{{trans('features.hrm')}}</span></a>
                    <ul class="menu-content">
                        @permission('manage-hrm')
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-users"></i> {{ trans('hrms.management') }}</a>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{ route( 'biller.hrms.index' ) }}"
                                    > <i class="ft-list"></i> {{ trans('hrms.employees') }}</a>
                                </li>

                                <li><a class="menu-item" href="{{ route( 'biller.hrms.create' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('hrms.create') }}
                                    </a>
                                </li>
                                <li><a class="menu-item" href="{{ route( 'biller.role.index' ) }}"
                                    > <i class="ft-pocket"></i> {{ trans('hrms.roles') }}</a>
                                </li>
                            </ul>
                        </li>
                        @endauth
                        @permission('department-manage')
                        <li><a class="menu-item" href="{{ route( 'biller.departments.index' ) }}"
                            > <i
                                    class="ft-list"></i> {{ trans('departments.departments') }}</a>
                        </li>

                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa fa-money"></i> {{ trans('hrms.payroll') }}</a>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{ route( 'biller.hrms.index' ) }}?rel_type=3"
                                    > <i class="ft-list"></i> {{ trans('hrms.payroll') }}
                                    </a>
                                </li>
                                <li><a class="menu-item" href="{{ route( 'biller.hrms.payroll' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('hrms.payroll_entry') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li  ><a
                                class="menu-item" href="#" ><i
                                    class="fa ft-activity"></i> {{ trans('hrms.attendance') }}</a>
                            <ul class="menu-content">
                                <li><a class="menu-item" href="{{ route( 'biller.hrms.attendance_list' ) }}"
                                    > <i class="ft-list"></i> {{ trans('hrms.attendance') }}
                                    </a>
                                </li>
                                <li><a class="menu-item" href="{{ route( 'biller.hrms.attendance' ) }}"
                                    > <i
                                            class="fa fa-plus-circle"></i> {{ trans('hrms.attendance_add') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endauth
                    </ul>
                </li>
            @endif
            @if(access()->allow('note-manage') || access()->allow('manage-event'))
                <li class="nav-item {{ $active_path == 'notes' || $active_path == 'events'? 'open' : null }}" ><a class="menu-item" href="#"
                    ><i
                            class="icon-star"></i><span>{{trans('features.misc')}}</span></a>
                    <ul class="menu-content">
                        @permission('note-manage')
                        <li><a class="menu-item"
                               href="{{route('biller.notes.index')}}"
                            ><i
                                    class="icon-note"></i> {{trans('general.notes')}}</a>
                        </li>
                        @endauth
                        @permission('manage-event')
                        <li><a class="menu-item"
                               href="{{route('biller.events.index')}}"
                            ><i
                                    class="icon-calendar"></i> {{trans('features.calendar')}}</a>
                        </li>
                        @endauth

                    </ul>
                </li>
            @endif




            @permission('reports-statements')
                <li class="nav-item {{ $active_path == 'reports' ? 'open' : null }}" ><a class="menu-item" href="#"
                    ><i
                            class="icon-pie-chart"></i><span>{{trans('features.reports')}}</span></a>
                    <ul class="menu-content">

                        <li><a class="nav-item" href="#"><i
                                    class="fa fa-book"></i>{{trans('meta.finance_account_statement')}}
                            </a>
                            <ul class="menu-content">

                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['account'])}}"
                                    ><i class="icon-doc"></i> {{trans('meta.finance_account_statement')}}
                                    </a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['income'])}}"
                                    ><i class="icon-doc"></i> {{trans('meta.income_statement')}}</a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['expense'])}}"
                                    ><i class="icon-doc"></i> {{trans('meta.expense_statement')}}</a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['pos_statement'])}}"
                                    ><i class="icon-doc"></i> {{trans('meta.pos_statement')}}</a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['market_statement'])}}"
                                    ><i class="icon-doc"></i> {{trans('sales_channel.sales_channel_statement')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li><a
                                class="menu-item" href="#"><i
                                    class="fa fa-smile-o"></i>{{trans('customers.customer')}}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['customer'])}}"
                                       data-toggle="dropdown">{{trans('meta.customer_statements')}}</a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['product_customer_statement'])}}"
                                       data-toggle="dropdown">{{trans('meta.product_customer_statement')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li><a
                                class="menu-item" href="#"><i
                                    class="fa fa-truck"></i>{{trans('suppliers.supplier')}}</a>
                            <ul class="menu-content">


                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['supplier'])}}"
                                       data-toggle="dropdown">{{trans('meta.supplier_statements')}}</a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['product_supplier_statement'])}}"
                                       data-toggle="dropdown">{{trans('meta.product_supplier_statement')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li><a
                                class="menu-item" href="#"><i
                                    class="icon-doc"></i>{{trans('meta.tax_statements')}}</a>
                            <ul class="menu-content">

                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['tax'])}}"
                                       data-toggle="dropdown">{{trans('meta.tax_statements')}} {{trans('meta.sales')}}</a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['tax'])}}?s=purchase"
                                       data-toggle="dropdown">{{trans('meta.tax_statements')}}  {{trans('meta.purchase')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li><a
                                class="menu-item" href="#"><i
                                    class="fa fa-th"></i>{{trans('meta.product_statement')}}</a>
                            <ul class="menu-content">
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['product_statement'])}}"
                                       data-toggle="dropdown">{{trans('meta.product_statement')}}</a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['product_category_statement'])}}"
                                       data-toggle="dropdown">{{trans('meta.product_category_statement')}}</a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['product_warehouse_statement'])}}"
                                       data-toggle="dropdown">{{trans('meta.product_warehouse_statement')}}</a>
                                </li>
                            </ul>
                        </li>

                        <li><a
                                class="menu-item" href="#"><i
                                    class="fa fa-road"></i>{{trans('products.stock_transfer')}}</a>
                            <ul class="menu-content">


                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['stock_transfer'])}}"
                                       data-toggle="dropdown">{{trans('meta.stock_transfer_statement_warehouse')}}</a>
                                </li>
                                <li><a class="menu-item"
                                       href="{{route('biller.reports.statements',['stock_transfer_product'])}}"
                                       data-toggle="dropdown">{{trans('meta.stock_transfer_statement_product')}}</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="menu-item"
                               href="{{route('biller.reports.statements',['pos_statement'])}}"
                            ><i class="icon-doc"></i> {{trans('meta.pos_statement')}}</a>
                        </li>




                    </ul>
                </li>
            <li class="nav-item {{ $active_path == 'reports' ? 'open' : null }}" ><a class="menu-item" href="#"
                ><i
                        class="icon-bar-chart"></i><span>{{trans('meta.graphical_reports')}}</span></a>

                <ul class="menu-content">

                    <li><a class="menu-item"
                                        href="{{route('biller.reports.charts',['customer'])}}"><i
                                class="fa fa-bar-chart"></i> {{trans('meta.customer_graphical_overview')}}
                        </a>
                    </li>
                    <li ><a class="menu-item"
                                        href="{{route('biller.reports.charts',['supplier'])}}"><i
                                class="fa fa-sun-o"></i> {{trans('meta.supplier_graphical_overview')}}
                        </a>
                    </li>
                    <li ><a class="menu-item"
                                        href="{{route('biller.reports.charts',['product'])}}"><i
                                class="ft-trending-up"></i> {{trans('meta.product_graphical_overview')}}
                        </a>
                    </li>
                    <li><a class="menu-item"
                                        href="{{route('biller.reports.charts',['income_vs_expenses'])}}"
                        ><i
                                class="icon-pie-chart"></i> {{trans('meta.income_vs_expenses_overview')}}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ $active_path == 'reports' ? 'open' : null }}" ><a class="menu-item" href="#"
                ><i
                        class="icon-eyeglasses"></i><span>{{trans('meta.summary_reports')}}</span></a>

                <ul class="menu-content">

                    <li><a class="menu-item"
                           href="{{route('biller.reports.summary',['income'])}}"
                        ><i
                                class="ft-check-circle"></i> {{trans('meta.income_summary')}}</a>
                    </li>
                    <li><a class="menu-item"
                           href="{{route('biller.reports.summary',['expense'])}}"
                        ><i
                                class="fa fa fa-bullhorn"></i> {{trans('meta.expense_summary')}}</a>
                    </li>
                    <li><a class="menu-item"
                           href="{{route('biller.reports.summary',['sale'])}}"
                        ><i
                                class="ft-aperture"></i> {{trans('meta.sale_summary')}}</a>
                    </li>
                    <li><a class="menu-item"
                           href="{{route('biller.reports.summary',['purchase'])}}"
                        ><i
                                class="ft-disc"></i> {{trans('meta.purchase_summary')}}</a>
                    </li>
                    <li><a class="menu-item"
                           href="{{route('biller.reports.summary',['products'])}}"
                        ><i
                                class="ft-layers"></i> {{trans('meta.products_summary')}}</a>
                    </li>
                </ul>
            </li> <li class="nav-item" ><a class="menu-item" href="#"
                ><i
                        class="icon-size-actual"></i><span>{{trans('import.import')}}</span></a>

                <ul class="menu-content">

                    <li><a class="menu-item"
                           href="{{route('biller.import.general',['customer'])}}"
                        ><i
                                class="fa fa-file-excel-o"></i> {{trans('import.import_customers')}}
                        </a>
                    </li>
                    <li><a class="menu-item"
                           href="{{route('biller.import.general',['products'])}}"
                        ><i
                                class="fa fa-file-excel-o"></i> {{trans('import.import_products')}}
                        </a>
                    </li>
                    <li><a class="menu-item"
                           href="{{route('biller.import.general',['accounts'])}}"
                        ><i
                                class="fa fa-file-excel-o"></i> {{trans('import.import_accounts')}}
                        </a>
                    </li>
                    <li><a class="menu-item"
                           href="{{route('biller.import.general',['transactions'])}}"
                        ><i
                                class="fa fa-file-excel-o"></i> {{trans('import.import_transactions')}}
                        </a>
                    </li>
                </ul>
            </li>
            @endif

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
