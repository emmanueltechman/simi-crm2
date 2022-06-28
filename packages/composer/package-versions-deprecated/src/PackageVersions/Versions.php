<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'laravel/laravel';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'anhskohbo/no-captcha' => '3.3.0@f654a4093bd2e9ddbdfad3297bb7aa142a55e611',
  'asm89/stack-cors' => 'v2.0.2@8d8f88b3b3830916be94292c1fbce84433efb1aa',
  'authorizenet/authorizenet' => '2.0.0@7fa78e6397d363296e462c3b348573c17175b7a8',
  'bacon/bacon-qr-code' => '2.0.3@3e9d791b67d0a2912922b7b7c7312f4b37af41e4',
  'brick/math' => '0.9.1@283a40c901101e66de7061bd359252c013dcc43c',
  'cmgmyr/messenger' => '2.21@fc9e943684ec3549d5bc0792249b906efe080fd6',
  'dasprid/enum' => '1.0.3@5abf82f213618696dda8e3bf6f64dd042d8542b2',
  'defuse/php-encryption' => 'v2.2.1@0f407c43b953d571421e0020ba92082ed5fb7620',
  'dnoegel/php-xdg-base-dir' => 'v0.1.1@8f8a6e48c5ecb0f991c2fdcf5f154a47d85f9ffd',
  'doctrine/inflector' => '2.0.3@9cf661f4eb38f7c881cac67c75ea9b00bf97b210',
  'doctrine/lexer' => '1.2.1@e864bbf5904cb8f5bb334f99209b48018522f042',
  'dragonmantank/cron-expression' => 'v3.1.0@7a8c6e56ab3ffcc538d05e8155bb42269abf1a0c',
  'egulias/email-validator' => '2.1.25@0dbf5d78455d4d6a41d186da50adc1122ec066f4',
  'endroid/qr-code' => '3.9.6@9cdd4f5d609bfc8811ca4a62b4d23eb16976242f',
  'ezyang/htmlpurifier' => 'v4.13.0@08e27c97e4c6ed02f37c5b2b20488046c8d90d75',
  'fideloper/proxy' => '4.4.1@c073b2bd04d1c90e04dc1b787662b558dd65ade0',
  'firebase/php-jwt' => 'v5.2.0@feb0e820b8436873675fd3aca04f3728eb2185cb',
  'fruitcake/laravel-cors' => 'v2.0.3@01de0fe5f71c70d1930ee9a80385f9cc28e0f63a',
  'graham-campbell/result-type' => 'v1.0.1@7e279d2cd5d7fbb156ce46daada972355cea27bb',
  'guzzlehttp/guzzle' => '7.2.0@0aa74dfb41ae110835923ef10a9d803a22d50e79',
  'guzzlehttp/promises' => '1.4.0@60d379c243457e073cff02bc323a2a86cb355631',
  'guzzlehttp/psr7' => '1.7.0@53330f47520498c0ae1f61f7e2c90f55690c06a3',
  'khanamiryan/qrcode-detector-decoder' => '1.0.4@07fceefb79d895e858e52921afb9c1433d2f3d5e',
  'laravel/framework' => 'v8.20.1@b5d8573ab16027867eaa1ac148893833434f9b02',
  'laravel/passport' => 'v10.1.0@c2b93a7d8d93cf303bb1eefbfa5610f084f9bdd4',
  'laravel/tinker' => 'v2.5.0@45884b526e10a88a1b179fa1a1a24d5468c668c2',
  'laravel/ui' => 'v3.1.0@444072cb2f8baaa15172c5cde2bd30d188c3b7e7',
  'laravelcollective/html' => 'v6.2.1@ae15b9c4bf918ec3a78f092b8555551dd693fde3',
  'lcobucci/clock' => '2.0.0@353d83fe2e6ae95745b16b3d911813df6a05bfb3',
  'lcobucci/jwt' => '4.0.0@6d8665ccd924dc076a9b65d1ea8abe21d68f6958',
  'league/commonmark' => '1.5.7@11df9b36fd4f1d2b727a73bf14931d81373b9a54',
  'league/event' => '2.2.0@d2cc124cf9a3fab2bb4ff963307f60361ce4d119',
  'league/flysystem' => '1.1.3@9be3b16c877d477357c015cec057548cf9b2a14a',
  'league/mime-type-detection' => '1.5.1@353f66d7555d8a90781f6f5e7091932f9a4250aa',
  'league/oauth2-server' => '8.2.4@622eaa1f28eb4a2dea0cfc7e4f5280fac794e83c',
  'maatwebsite/excel' => '3.1.26@66f7c9584304ad0b6a267a5d8ffbfa2ff4272e85',
  'maennchen/zipstream-php' => '2.1.0@c4c5803cc1f93df3d2448478ef79394a5981cc58',
  'markbaker/complex' => '2.0.0@9999f1432fae467bc93c53f357105b4c31bb994c',
  'markbaker/matrix' => '2.0.0@9567d9c4c519fbe40de01dbd1e4469dbbb66f46a',
  'mavinoo/laravel-batch' => 'v2.2.3@063d73f1e7982eab7f0c8f3c3943c37b97eff7c4',
  'mews/purifier' => '3.3.3@8e0b3d87c79b38b8d88aeb3c0ba8b000a393a74c',
  'mike42/escpos-php' => 'v3.0@dcb569a123d75f9f6a4a927aae7625ca6b7fdcf3',
  'mike42/gfx-php' => 'v0.6@ed9ded2a9298e4084a9c557ab74a89b71e43dbdb',
  'monolog/monolog' => '2.2.0@1cb1cde8e8dd0f70cc0fe51354a59acad9302084',
  'mpdf/mpdf' => 'v8.0.8@4ce221329d0918146514605db1644b2771c5e308',
  'myclabs/deep-copy' => '1.10.2@776f831124e9c62e1a2c601ecc52e776d8bb7220',
  'myclabs/php-enum' => '1.7.7@d178027d1e679832db9f38248fcc7200647dc2b7',
  'nesbot/carbon' => '2.43.0@d32c57d8389113742f4a88725a170236470012e2',
  'nikic/php-parser' => 'v4.10.4@c6d052fc58cb876152f89f532b95a8d7907e7f0e',
  'nyholm/psr7' => '1.3.2@a272953743c454ac4af9626634daaf5ab3ce1173',
  'opis/closure' => '3.6.1@943b5d70cc5ae7483f6aff6ff43d7e34592ca0f5',
  'paragonie/random_compat' => 'v9.99.100@996434e5492cb4c3edcb9168db6fbb1359ef965a',
  'paypal/paypal-checkout-sdk' => '1.0.1@ed6a55075448308b87a8b59dcb7fedf04a048cb1',
  'paypal/paypalhttp' => '1.0.0@1ad9b846a046f09d6135cbf2cbaa7701bbc630a3',
  'php-http/message-factory' => 'v1.0.2@a478cb11f66a6ac48d8954216cfed9aa06a501a1',
  'phpoffice/phpspreadsheet' => '1.16.1@76d4323b85129d0c368149c831a07a3e258b2b50',
  'phpoption/phpoption' => '1.7.5@994ecccd8f3283ecf5ac33254543eb0ac946d525',
  'phpseclib/phpseclib' => '2.0.30@136b9ca7eebef78be14abf90d65c5e57b6bc5d36',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/event-dispatcher' => '1.0.0@dbefd12671e8a14ec7f180cab83036ed26714bb0',
  'psr/http-client' => '1.0.1@2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
  'psr/http-factory' => '1.0.1@12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc',
  'psr/simple-cache' => '1.0.1@408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
  'psy/psysh' => 'v0.10.5@7c710551d4a2653afa259c544508dc18a9098956',
  'rajeshdk/laravel-installer' => '4.0.2@8063eda959fdee8b337e6ea543603e169e843897',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  'ramsey/collection' => '1.1.1@24d93aefb2cd786b7edd9f45b554aea20b28b9b1',
  'ramsey/uuid' => '4.1.1@cd4032040a750077205918c86049aa0f43d22947',
  'razorpay/razorpay' => '2.5.0@96c0167176cf53e3da15640622e9b993a3450ec7',
  'rmccue/requests' => 'v1.7.0@87932f52ffad70504d93f04f15690cf16a089546',
  'setasign/fpdi' => 'v2.3.5@f2246c8669bd25834f5c264425eb0e250d7a9312',
  'shivella/laravel-bitly' => '1.1.9@9abe97cc7d1cc8447b610556d4aac8a38d337777',
  'stripe/stripe-php' => 'v7.67.0@935d2c67912007f6d17b6c08a62050252c509129',
  'swiftmailer/swiftmailer' => 'v6.2.4@56f0ab23f54c4ccbb0d5dcc67ff8552e0c98d59e',
  'symfony/console' => 'v5.2.1@47c02526c532fb381374dab26df05e7313978976',
  'symfony/css-selector' => 'v5.2.1@f789e7ead4c79e04ca9a6d6162fc629c89bd8054',
  'symfony/deprecation-contracts' => 'v2.2.0@5fa56b4074d1ae755beb55617ddafe6f5d78f665',
  'symfony/error-handler' => 'v5.2.1@59b190ce16ddf32771a22087b60f6dafd3407147',
  'symfony/event-dispatcher' => 'v5.2.1@1c93f7a1dff592c252574c79a8635a8a80856042',
  'symfony/event-dispatcher-contracts' => 'v2.2.0@0ba7d54483095a198fa51781bc608d17e84dffa2',
  'symfony/finder' => 'v5.2.1@0b9231a5922fd7287ba5b411893c0ecd2733e5ba',
  'symfony/http-client-contracts' => 'v2.3.1@41db680a15018f9c1d4b23516059633ce280ca33',
  'symfony/http-foundation' => 'v5.2.1@a1f6218b29897ab52acba58cfa905b83625bef8d',
  'symfony/http-kernel' => 'v5.2.1@1feb619286d819180f7b8bc0dc44f516d9c62647',
  'symfony/mime' => 'v5.2.1@de97005aef7426ba008c46ba840fc301df577ada',
  'symfony/options-resolver' => 'v5.2.1@87a2a4a766244e796dd9cb9d6f58c123358cd986',
  'symfony/polyfill-ctype' => 'v1.20.0@f4ba089a5b6366e453971d3aad5fe8e897b37f41',
  'symfony/polyfill-iconv' => 'v1.20.0@c536646fdb4f29104dd26effc2fdcb9a5b085024',
  'symfony/polyfill-intl-grapheme' => 'v1.20.0@c7cf3f858ec7d70b89559d6e6eb1f7c2517d479c',
  'symfony/polyfill-intl-idn' => 'v1.20.0@3b75acd829741c768bc8b1f84eb33265e7cc5117',
  'symfony/polyfill-intl-normalizer' => 'v1.20.0@727d1096295d807c309fb01a851577302394c897',
  'symfony/polyfill-mbstring' => 'v1.20.0@39d483bdf39be819deabf04ec872eb0b2410b531',
  'symfony/polyfill-php72' => 'v1.20.0@cede45fcdfabdd6043b3592e83678e42ec69e930',
  'symfony/polyfill-php73' => 'v1.20.0@8ff431c517be11c78c48a39a66d37431e26a6bed',
  'symfony/polyfill-php80' => 'v1.20.0@e70aa8b064c5b72d3df2abd5ab1e90464ad009de',
  'symfony/process' => 'v5.2.1@bd8815b8b6705298beaa384f04fabd459c10bedd',
  'symfony/property-access' => 'v5.2.1@243dcdda2f276cb31efa31a015d0fdb5076931ce',
  'symfony/property-info' => 'v5.2.1@f65694a05eb7742c5f2951f20676de367ffaaaea',
  'symfony/psr-http-message-bridge' => 'v2.0.2@51a21cb3ba3927d4b4bf8f25cc55763351af5f2e',
  'symfony/routing' => 'v5.2.1@934ac2720dcc878a47a45c986b483a7ee7193620',
  'symfony/service-contracts' => 'v2.2.0@d15da7ba4957ffb8f1747218be9e1a121fd298a1',
  'symfony/string' => 'v5.2.1@5bd67751d2e3f7d6f770c9154b8fbcb2aa05f7ed',
  'symfony/translation' => 'v5.2.1@a04209ba0d1391c828e5b2373181dac63c52ee70',
  'symfony/translation-contracts' => 'v2.3.0@e2eaa60b558f26a4b0354e1bbb25636efaaad105',
  'symfony/var-dumper' => 'v5.2.1@13e7e882eaa55863faa7c4ad7c60f12f1a8b5089',
  'tijsverkoyen/css-to-inline-styles' => '2.2.3@b43b05cf43c1b6d849478965062b6ef73e223bb5',
  'twilio/sdk' => '6.15.1@09e8cf28d1c53cb53472a917cddfdaeb4d8105f5',
  'vlucas/phpdotenv' => 'v5.2.0@fba64139db67123c7a57072e5f8d3db10d160b66',
  'voku/portable-ascii' => '1.5.6@80953678b19901e5165c56752d087fc11526017c',
  'webmozart/assert' => '1.9.1@bafc69caeb4d49c39fd0779086c03a3738cbb389',
  'yajra/laravel-datatables-oracle' => 'v9.15.2@e0b416d8b7d4472b16217c40e74284074cc34dde',
  'barryvdh/laravel-ide-helper' => 'v2.9.0@64a6b902583802c162cdccf7e76dc8619368bf1a',
  'barryvdh/reflection-docblock' => 'v2.0.6@6b69015d83d3daf9004a71a89f26e27d27ef6a16',
  'composer/ca-bundle' => '1.2.8@8a7ecad675253e4654ea05505233285377405215',
  'composer/composer' => '2.0.8@62139b2806178adb979d76bd3437534a1a9fd490',
  'composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6',
  'composer/semver' => '3.2.4@a02fdf930a3c1c3ed3a49b5f63859c0c20e10464',
  'composer/spdx-licenses' => '1.5.5@de30328a7af8680efdc03e396aad24befd513200',
  'composer/xdebug-handler' => '1.4.5@f28d44c286812c714741478d968104c5e604a1d4',
  'doctrine/cache' => '1.10.2@13e3381b25847283a91948d04640543941309727',
  'doctrine/dbal' => '3.0.0@ee6d1260d5cc20ec506455a585945d7bdb98662c',
  'doctrine/event-manager' => '1.1.1@41370af6a30faa9dc0368c4a6814d596e81aba7f',
  'doctrine/instantiator' => '1.4.0@d56bf6102915de5702778fe20f2de3b2fe570b5b',
  'facade/flare-client-php' => '1.3.7@fd688d3c06658f2b3b5f7bb19f051ee4ddf02492',
  'facade/ignition' => '2.5.8@8e907d81244649c5ea746e2ec30c32c5f59df472',
  'facade/ignition-contracts' => '1.0.2@3c921a1cdba35b68a7f0ccffc6dffc1995b18267',
  'fakerphp/faker' => 'v1.13.0@ab3f5364d01f2c2c16113442fb987d26e4004913',
  'filp/whoops' => '2.9.1@307fb34a5ab697461ec4c9db865b20ff2fd40771',
  'hamcrest/hamcrest-php' => 'v2.0.1@8c3d0a3f6af734494ad8f6fbbee0ba92422859f3',
  'justinrainbow/json-schema' => '5.2.10@2ba9c8c862ecd5510ed16c6340aa9f6eadb4f31b',
  'laravel/sail' => 'v0.0.5@d9b0575ece889a35b9741789452c1c7abca5bc2f',
  'mockery/mockery' => '1.4.2@20cab678faed06fac225193be281ea0fddb43b93',
  'nunomaduro/collision' => 'v5.1.0@7c2b95589bf81e274e61e47f7672a1b2c3e06eaa',
  'phar-io/manifest' => '2.0.1@85265efd3af7ba3ca4b2a2c34dbfc5788dd29133',
  'phar-io/version' => '3.0.4@e4782611070e50613683d2b9a57730e9a3ba5451',
  'phpdocumentor/reflection-common' => '2.2.0@1d01c49d4ed62f25aa84a747ad35d5a16924662b',
  'phpdocumentor/reflection-docblock' => '5.2.2@069a785b2141f5bcf49f3e353548dc1cce6df556',
  'phpdocumentor/type-resolver' => '1.4.0@6a467b8989322d92aa1c8bf2bebcc6e5c2ba55c0',
  'phpspec/prophecy' => '1.12.2@245710e971a030f42e08f4912863805570f23d39',
  'phpunit/php-code-coverage' => '9.2.5@f3e026641cc91909d421802dd3ac7827ebfd97e1',
  'phpunit/php-file-iterator' => '3.0.5@aa4be8575f26070b100fccb67faabb28f21f66f8',
  'phpunit/php-invoker' => '3.1.1@5a10147d0aaf65b58940a0b72f71c9ac0423cc67',
  'phpunit/php-text-template' => '2.0.4@5da5f67fc95621df9ff4c4e5a84d6a8a2acf7c28',
  'phpunit/php-timer' => '5.0.3@5a63ce20ed1b5bf577850e2c4e87f4aa902afbd2',
  'phpunit/phpunit' => '9.5.0@8e16c225d57c3d6808014df6b1dd7598d0a5bbbe',
  'react/promise' => 'v2.8.0@f3cff96a19736714524ca0dd1d4130de73dbbbc4',
  'sebastian/cli-parser' => '1.0.1@442e7c7e687e42adc03470c7b668bc4b2402c0b2',
  'sebastian/code-unit' => '1.0.8@1fc9f64c0927627ef78ba436c9b17d967e68e120',
  'sebastian/code-unit-reverse-lookup' => '2.0.3@ac91f01ccec49fb77bdc6fd1e548bc70f7faa3e5',
  'sebastian/comparator' => '4.0.6@55f4261989e546dc112258c7a75935a81a7ce382',
  'sebastian/complexity' => '2.0.2@739b35e53379900cc9ac327b2147867b8b6efd88',
  'sebastian/diff' => '4.0.4@3461e3fccc7cfdfc2720be910d3bd73c69be590d',
  'sebastian/environment' => '5.1.3@388b6ced16caa751030f6a69e588299fa09200ac',
  'sebastian/exporter' => '4.0.3@d89cc98761b8cb5a1a235a6b703ae50d34080e65',
  'sebastian/global-state' => '5.0.2@a90ccbddffa067b51f574dea6eb25d5680839455',
  'sebastian/lines-of-code' => '1.0.3@c1c2e997aa3146983ed888ad08b15470a2e22ecc',
  'sebastian/object-enumerator' => '4.0.4@5c9eeac41b290a3712d88851518825ad78f45c71',
  'sebastian/object-reflector' => '2.0.4@b4f479ebdbf63ac605d183ece17d8d7fe49c15c7',
  'sebastian/recursion-context' => '4.0.4@cd9d8cf3c5804de4341c283ed787f099f5506172',
  'sebastian/resource-operations' => '3.0.3@0f4443cb3a1d92ce809899753bc0d5d5a8dd19a8',
  'sebastian/type' => '2.3.1@81cd61ab7bbf2de744aba0ea61fae32f721df3d2',
  'sebastian/version' => '3.0.2@c6c1022351a901512170118436c764e473f6de8c',
  'seld/jsonlint' => '1.8.3@9ad6ce79c342fbd44df10ea95511a1b24dee5b57',
  'seld/phar-utils' => '1.1.1@8674b1d84ffb47cc59a101f5d5a3b61e87d23796',
  'symfony/filesystem' => 'v5.2.1@fa8f8cab6b65e2d99a118e082935344c5ba8c60d',
  'theseer/tokenizer' => '1.2.0@75a63c33a8577608444246075ea0af0d052e452a',
  'laravel/laravel' => '1.0.0+no-version-set@',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!class_exists(InstalledVersions::class, false) || !InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (class_exists(InstalledVersions::class, false) && InstalledVersions::getRawData()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
