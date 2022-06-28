<ul class="dropdown-menu lang-menu" role="menu" style="width: 400px;">
    @foreach (config('locale.languages') as $key => $lang)

        @if ($key != App::getLocale())       <span
                class="mt-1 pb-1 display-inline-block width-30-per border-bottom-blue-grey border-bottom-lighten-3 ">&nbsp;<i
                    class="flag-icon flag-icon-{{$lang[3]}}"></i>{{ link_to('lang/'.$key, trans('menus.language-picker.langs.'.$key)) }}</span> @endif



    @endforeach
</ul>