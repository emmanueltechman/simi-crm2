const mix = require('laravel-mix');
mix.copyDirectory('public/core/app-assets/fonts', 'public/focus/fonts')
    .styles([
        'resources/assets/core/app-assets/vendors/css/vendors-ltr.min.css',
        'resources/assets/core/app-assets/css-ltr/bootstrap.css',
        'resources/assets/core/app-assets/css-ltr/bootstrap-extended.css',
        'resources/assets/core/app-assets/css-ltr/components.css',
        'resources/assets/core/app-assets/css-ltr/core/colors/palette-gradient.css',
        'resources/assets/core/app-assets/css-ltr/pages/login-register.css',
        'resources/assets/core/app-assets/vendors/css/tables/datatable/datatables.min.css',
        'resources/assets/core/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css',
        'resources/assets/core/app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css',
        'resources/assets/core/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css',
        'resources/assets/core/app-assets/css-ltr/core/colors/palette-gradient.css',
        'resources/assets/core/app-assets/css-ltr/colors.css',
        'resources/assets/core/app-assets/vendors/css/extensions/sweetalert.css',
        'resources/assets/core/app-assets/fonts/simple-line-icons/style.min.css',
        'resources/assets/core/assets/css/summernote.css',
        'resources/assets/core/assets/css/datepicker.min.css',
        'resources/assets/core/assets/css/select2.min.css',
        'resources/assets/core/app-assets/vendors/css/hold.css'
    ], 'public/focus/app_end-ltr.css')
    //general
     .styles([
        'resources/assets/general/css/bootstrap.css',
        'resources/assets/general/css/fontawesome-all.css',
        'resources/assets/general/css/swiper.css',
         'resources/assets/general/css/magnific-popup.css',
         'resources/assets/general/css/styles.css',
    ], 'public/general/app.css')
    .styles([
        'resources/assets/core/app-assets/vendors/css/vendors-rtl.min.css',
        'resources/assets/core/app-assets/css-rtl/bootstrap.css',
        'resources/assets/core/app-assets/css-rtl/bootstrap-extended.css',
        'resources/assets/core/app-assets/css-rtl/components.css',
        'resources/assets/core/app-assets/css-rtl/core/colors/palette-gradient.css',
        'resources/assets/core/app-assets/css-rtl/pages/login-register.css',
        'resources/assets/core/app-assets/vendors/css/tables/datatable/datatables.min.css',
        'resources/assets/core/app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css',
        'resources/assets/core/app-assets/vendors/css/tables/extensions/responsive.dataTables.min.css',
        'resources/assets/core/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css',
        'resources/assets/core/app-assets/css-rtl/core/colors/palette-gradient.css',
        'resources/assets/core/app-assets/css-rtl/colors.css',
        'resources/assets/core/app-assets/vendors/css/extensions/sweetalert.css',
        'resources/assets/core/app-assets/fonts/simple-line-icons/style.min.css',
        'resources/assets/core/assets/css/summernote.css',
        'resources/assets/core/assets/css/datepicker.min.css',
        'resources/assets/core/assets/css/select2.min.css',
        'resources/assets/core/app-assets/vendors/css/hold.css'
    ], 'public/focus/app_end-rtl.css')

    .scripts([
        "resources/assets/core/app-assets/vendors/js/vendors.min.js",
        "resources/assets/focus/js/jquery-ui.js",
        "resources/assets/core/app-assets/vendors/js/ui/jquery.sticky.js",
        "resources/assets/core/app-assets/vendors/js/charts/jquery.sparkline.min.js",
        "resources/assets/core/app-assets/vendors/js/forms/icheck/icheck.min.js",
        "resources/assets/core/app-assets/js/core/app-menu.js",
        "resources/assets/core/app-assets/js/core/app.js",
        "resources/assets/focus/js/datepicker.min.js",
        "resources/assets/focus/js/accounting.min.js",
        "resources/assets/focus/js/summernote.min.js",
        "resources/assets/focus/js/printThis.js",
        "resources/assets/core/app-assets/js/scripts/hold.js",
    ], 'public/js/app_end.js')


        .scripts([
        "resources/assets/general/js/jquery.min.js",
        "resources/assets/general/js/popper.min.js",
        "resources/assets/general/js/bootstrap.min.js",
        "resources/assets/general/js/jquery.easing.min.js",
        "resources/assets/general/js/swiper.min.js",
        "resources/assets/general/js/jquery.magnific-popup.js",
        "resources/assets/general/js/validator.min.js",
        "resources/assets/general/js/scripts.js"
    ], 'public/js/app.js')


    .scripts([

       "resources/assets/js/admin/admin.js"
    ], 'public/js/backend-custom.js')
    //Datatable js
    .scripts([
        'node_modules/datatables.net/js/jquery.dataTables.js',
        'resources/assets/js/plugin/datatables/dataTables.bootstrap.min.js',
        'node_modules/datatables.net-buttons/js/dataTables.buttons.js',
        'node_modules/datatables.net-buttons/js/buttons.flash.js',
        'resources/assets/js/plugin/datatables/jszip.min.js',
        'resources/assets/js/plugin/datatables/pdfmake.min.js',
        'resources/assets/js/plugin/datatables/vfs_fonts.js',
        'node_modules/datatables.net-buttons/js/buttons.html5.js',
        'node_modules/datatables.net-buttons/js/buttons.print.js',
        'node_modules/datatables.net-responsive/js/dataTables.responsive.js',
        "resources/assets/core/app-assets/js/core/sweetalert.min.js",
        'resources/assets/core/app-assets/js/core/plugins.js',
    ], 'public/js/dataTable.js')

    .webpackConfig({

    })
    .version();
