<?php

return [
    /*
     * public_path depends on your folder structure, if your app source and public_html under same directory it won't work, you should configure it according to your structure
     */

	'public_path'=>'/public_html',

    /*
     * Whether or not to show the language picker, or just default to the default
     * locale specified in the app config file
     *
     * @var bool
     */
    'status' => true,

    /*
     * Available languages
     *
     * Add your language code to this array.
     * The code must have the same name as the language folder.
     * Be sure to add the new language in an alphabetical order.
     *
     * The language picker will not be available if there is only one language option
     * Commenting out languages will make them unavailable to the user
     *
     * @var array
     */
    'languages' => [
        /*
         * Key is the Laravel locale code
         * Index 0 of sub-array is the Carbon locale code
         * Index 1 of sub-array is the PHP locale code for setlocale()
         * Index 2 of sub-array is whether or not to use RTL (right-to-left) css for this language
         */
        "en" => ['en', 'en_US', false, 'us'],
        "ar" => ['ar', 'ar_AE', true, 'sa'],
        "bn" => ['bn', 'bn_BD', false, 'bd'],
              "zh" => ['zh', 'zh_CN', false, 'cn'],
        "cs" => ['cs', 'cs_CZ', false, 'cz'],

            "nl" => ['nl', 'nl_NL', false, 'nl'],
                "fl" => ['fi', 'fi_FI', false, 'ph'],
           "fr" => ['en', 'en_US', false, 'fr'],
        "de" => ['de', 'de_DE', false, 'de'],
        "el" => ['el', 'el_GR', false, 'gr'],
        "he" => ['he', 'he_IL', true, 'il'],
        "hi" => ['hi', 'hi_IN', false, 'in'],
        "id" => ['id', 'id_ID', false, 'id'],
        "it" => ['it', 'it_IT', false, 'it'],
        "ja" => ['ja', 'ja_JP ', false, 'jp'],
        "jv" => ['jv', 'jv_ID ', false, 'id'],
        "km" => ['km', 'km_TH ', false, 'kh'],
        "ko" => ['ko', 'ko_KO ', false, 'kr'],
        "pt_BR" => ['pt', 'pt_BR', false, 'pt'],
        "pl" => ['pl', 'pl_PL ', false, 'pl'],
        "ro" => ['ro', 'ro_RO ', false, 'ro'],
        "ru" => ['ru', 'ru-RU', false, 'ru'],
         "es" => ['es', 'es_ES', false, 'es'],
        "sv" => ['sv', 'sv_SE', false, 'sv',],
        "th" => ['th', 'th_TH', false, 'th'],
        "tr" => ['tr', 'tr_TR', false, 'tr'],
        "vi" => ['vi', 'vi_VN', false, 'vi'],
           "ur" => ['ur', 'ur_PK', true, 'pk'],
    ],
];
