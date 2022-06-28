@permission('business_settings')
<li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link" href="#"
                                               data-toggle="dropdown">{{trans('business.business_admin')}}</a>
    <ul class="mega-dropdown-menu dropdown-menu row">
        <li class="col-md-3 col-sm-6">
            <h6 class="dropdown-menu-header text-uppercase mb-1"><i
                    class="fa fa-building-o"></i> {{trans('business.general_preference')}}</h6>
            <ul>
                <li class="menu-list">
                    <ul>
                        <li><a class="dropdown-item" href="{{route('biller.business.settings')}}"><i
                                    class="ft-feather"></i>{{trans('business.company_settings')}}
                            </a></li>
                        <li><a class="dropdown-item"
                               href="{{route('biller.settings.localization')}}"><i
                                    class="fa fa-globe"></i> {{trans('business.business_localization')}}
                            </a></li>

                        <li><a class="dropdown-item"
                               href="{{route('biller.transactioncategories.index')}}"><i
                                    class="ft-align-center"></i> {{trans('transactioncategories.transactioncategories')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.settings.status')}}"><i
                                    class="fa fa-flag-o"></i> {{trans('meta.default_status')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.markets.index')}}"><i
                                    class="fa fa-vcard"></i> {{trans('sales_channel.sales_channels')}}
                            </a></li>

                    </ul>
                </li>
            </ul>
        </li>
        <li class="col-md-3 col-sm-6">
            <h6 class="dropdown-menu-header text-uppercase"><i
                    class="fa fa-random"></i> {{trans('business.billing_settings')}}</h6>
            <ul>
                <li class="menu-list">
                    <ul>
                        <li><a class="dropdown-item"
                               href="{{route('biller.settings.billing_preference')}}"><i
                                    class="fa fa-files-o"></i> {{trans('business.billing_settings_preference')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.additionals.index')}}"><i
                                    class="fa fa-floppy-o"></i> {{trans('business.tax_discount_management')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.prefixes.index')}}"><i
                                    class="fa fa-bookmark-o"></i> {{trans('business.prefix_management')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.terms.index')}}"><i
                                    class="fa fa-gavel"></i> {{trans('business.terms_management')}}
                            </a></li>
                        <li><a class="dropdown-item"
                               href="{{route('biller.settings.pos_preference')}}"><i
                                    class="fa fa-shopping-cart"></i> {{trans('pos.preference')}}
                            </a></li>

                    </ul>
                </li>
            </ul>
        </li>

        <li class="col-md-3 col-sm-6">
            <h6 class="dropdown-menu-header text-uppercase"><i
                    class="fa fa-money"></i> {{trans('business.payment_account_settings')}}
            </h6>
            <ul>
                <li class="menu-list">
                    <ul>
                        <li><a class="dropdown-item"
                               href="{{route('biller.settings.payment_preference')}}"><i
                                    class="fa fa-credit-card"></i> {{trans('business.payment_preferences')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.currencies.index')}}"><i
                                    class="fa fa-money"></i> {{trans('business.currency_management')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.banks.index')}}"><i
                                    class="ft-server"></i> {{trans('business.bank_accounts')}}
                            </a>
                        </li>
                        <li><a class="dropdown-item"
                               href="{{route('biller.usergatewayentries.index')}}"><i
                                    class="fa fa-server"></i> {{trans('usergatewayentries.usergatewayentries')}}
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{route('biller.settings.accounts')}}"><i
                                    class="ft-compass"></i> {{trans('business.accounts_settings')}}
                            </a>
                        </li>

                        <li>&nbsp;</li>

                    </ul>
                </li>
            </ul>
        </li>
        <li class="col-md-3 col-sm-6">
            <h6 class="dropdown-menu-header text-uppercase"><i
                    class="ft-at-sign"></i> {{trans('business.communication_settings')}}</h6>
            <ul>
                <li class="menu-list">
                    <ul>
                        <li><a class="dropdown-item"
                               href="{{route('biller.business.email_sms_settings')}}"><i
                                    class="ft-minimize-2"></i> {{trans('meta.email_sms_settings')}}
                            </a></li>

                        <li><a class="dropdown-item"
                               href="{{route('biller.settings.notification_email')}}"><i
                                    class="ft-activity"></i> {{trans('meta.notification_email')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.templates.index')}}"><i
                                    class="fa fa-comments"></i> {{trans('templates.manage')}}
                            </a></li>
                        <li><a class="dropdown-item"
                               href="{{route('biller.settings.currency_exchange')}}"><i
                                    class="fa fa-retweet"></i> {{trans('currencies.currency_exchange')}}
                            </a></li>


                    </ul>
                </li>
            </ul>
        </li>
        <li class="col-md-3 col-sm-6  mb-1">
            <h6 class="dropdown-menu-header text-uppercase"><i
                    class="fa fa-random"></i> {{trans('business.miscellaneous_settings')}}</h6>
            <ul>
                <li class="menu-list">
                    <ul>
                        <li><a class="dropdown-item"
                               href="{{route('biller.customfields.index')}}"><i
                                    class="ft-anchor"></i> {{trans('customfields.customfields')}}
                            </a>
                        </li>
                        <li><a class="dropdown-item"
                               href="{{route('biller.productvariables.index')}}"><i
                                    class="ft-package"></i> {{trans('business.product_units')}}
                            </a></li>


                    </ul>
                </li>
            </ul>
        </li>
        <li class="col-md-3 col-sm-6">
            <h6 class="dropdown-menu-header text-uppercase"><i
                    class="fa fa-cogs"></i> {{trans('business.advanced_settings')}}</h6>
            <ul>
                <li class="menu-list">
                    <ul>

                        <li><a class="dropdown-item" href="{{route('biller.cron')}}"><i
                                    class="fa fa-terminal"></i> {{trans('meta.cron')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.web_update_wizard')}}"><i
                                    class="fa fa-magic"></i> {{trans('update.web_updater')}}
                            </a></li>

                    </ul>
                </li>
            </ul>
        </li>
        <li class="col-md-3 col-sm-6">
            <h6 class="dropdown-menu-header text-uppercase"><i
                    class="fa fa-asterisk"></i> {{trans('business.crm_hrm_settings')}}</h6>
            <ul>
                <li class="menu-list">
                    <ul>

                        <li><a class="dropdown-item"
                               href="{{route('biller.settings.crm_hrm_section')}}"><i
                                    class="fa fa-indent"></i> {{trans('meta.self_attendance')}}
                            </a></li>
                        <li><a class="dropdown-item"
                               href="{{route('biller.settings.crm_hrm_section')}}"><i
                                    class="fa fa-key"></i> {{trans('meta.customer_login')}}
                            </a>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="col-md-3 col-sm-6">
            <h6 class="dropdown-menu-header text-uppercase"><i
                    class="fa fa-camera-retro"></i> {{trans('business.visual_settings')}}</h6>
            <ul>
                <li class="menu-list">
                    <ul>


                        <li><a class="dropdown-item" href="{{route('biller.settings.theme')}}"><i
                                    class="fa fa-columns"></i> {{trans('meta.employee_panel_theme')}}
                            </a></li>
                        <li><a class="dropdown-item" href="{{route('biller.about')}}"><i
                                    class="fa fa-info-circle"></i> {{trans('update.about_system')}}
                            </a></li>
                    </ul>
                </li>
            </ul>
        </li><li class="col-md-3 col-sm-6">
            <h6 class="dropdown-menu-header text-uppercase"><i
                    class="fa fa-plug"></i> Plugins</h6>
            <ul>
                <li class="menu-list">
                    <ul>

{{rose_plugins_checker()}}

                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</li>
@endauth
