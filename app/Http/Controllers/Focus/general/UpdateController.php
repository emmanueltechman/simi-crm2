<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
namespace App\Http\Controllers\Focus\general;


use App\Repositories\Focus\general\CompanyRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Focus\general\ManageCompanyRequest;
use App\Http\Responses\ViewResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use DB;

class UpdateController extends Controller
{
    /**
     * variable to store the repository object
     * @var CompanyRepository
     */
    protected $repository;

    /**
     * contructor to initialize repository object
     * @param CompanyRepository $repository ;
     */
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;

    }

    public function index(ManageCompanyRequest $request)
    {
        if (!single_ton()) return new ViewResponse('focus.general.not_applicable');
        $v_file = base_path() . DIRECTORY_SEPARATOR . 'version.json';
        $version = File::get($v_file);
        $version = json_decode($version, true);
        return view('focus.general.update.index', compact('version'));
    }

    public function about(ManageCompanyRequest $request)
    {

        $v_file = base_path() . DIRECTORY_SEPARATOR . 'version.json';
        $version = File::get($v_file);
        $version = json_decode($version, true);
        return view('focus.general.update.about', compact('version'));
    }


    public function server_info(ManageCompanyRequest $request)
    {
        if (!single_ton()) return new ViewResponse('focus.general.not_applicable');
        phpinfo();
    }


    public function download_update(ManageCompanyRequest $request)
    {

        if (!single_ton()) return new ViewResponse('focus.general.not_applicable');
        $version = base_path() . DIRECTORY_SEPARATOR . 'version.json';
        $url = File::get($version);
        $version = json_decode($url, true);
        $code = public_path() . DIRECTORY_SEPARATOR . 'conf.json';

        session(['build' => $version['build']]);
        session(['step' => 0]);
        $next_version = $version['build'] + 1;
        session(['upto' => true]);
        $time_temp = rand(19, 999);
        session(['temp_id' => $time_temp]);
        if ($version['build']) {
            echo '<h5>' . trans('update.download_update') . '</h5>';
            echo '<pre>';

            $url = config('version.zone') . '/update/';
            $zipFile = base_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'update' . DIRECTORY_SEPARATOR . 'update_' . $next_version . '_' . $time_temp . '.zip'; // Local Zip File Path

            $zipResource = fopen($zipFile, "w");
            if ($zipResource) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "url=" . urlencode(url('/')) . "&version=" . $version['build'] . "&code=" . $code);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FILE, $zipResource);
                $page = curl_exec($ch);
                sleep(10);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


                if ($httpcode == 511) {
                    fclose($zipResource);
                    chmod($zipFile, 0755);
                    session(['upto' => false]);
                    @unlink($zipFile);
                    exit('Invalid License! Or Duplicate Installation Detected!');
                }

                if ($httpcode == 418) {
                    fclose($zipResource);
                    chmod($zipFile, 0755);
                    session(['upto' => false]);
                    @unlink($zipFile);
                    exit('You are using latest update!');
                }
                if ($httpcode == 424) {
                    fclose($zipResource);
                    chmod($zipFile, 0755);
                    session(['upto' => false]);
                    @unlink($zipFile);
                    header('HTTP/1.1 424 Service Unavailable.', TRUE, 424);
                    exit('Manual update Required! You need to update the application manually to access available auto web updates!');
                }


                if ($httpcode == 200) {

                    echo trans('update.license_check') . '
';
                    echo trans('update.downloading_files') . '
';
                    echo trans('update.update_available') . ' - Build ' . $next_version . '
';
                    curl_close($ch);

                    fclose($zipResource);
                    echo trans('update.extracting_download_files') . '
';

                    $extractPath = base_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'update' . DIRECTORY_SEPARATOR . 'update_' . $next_version . '_' . $time_temp;

                    if (!@mkdir($extractPath, 0777, true)) {

                        if (!file_exists($extractPath)) {

                            exit(trans('update.failed_to_create_directory') . ' ' . $extractPath);
                        }
                    }

                    $zip = new \ZipArchive();

                    if ($zip->open($zipFile) != "true") {

                        echo trans('update.zip_extracting_failed');

                        exit(trans('update.update_process_halted_extraction'));
                    }
                    /* Extract Zip File */
                    if ($zip->extractTo($extractPath)) {

                        echo trans('update.extracting_success');

                        echo '</pre>';

                        echo '<h5>' . trans('update.update_downloaded') . '</h5>';

                    } else {
                        echo '</pre>';
                    }
                    $zip->close();
                }
            } else {
                exit(trans('update.restricted_access_permissions'));
            }
        }

    }


    public function install_update()
    {
        if (!single_ton()) return new ViewResponse('focus.general.not_applicable');
        $build = session('build');
        $upto = session('upto');
        $temp_id = session('temp_id');
        $build = $build + 1;
        $base_path = base_path() . DIRECTORY_SEPARATOR;
        $update_path = base_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'update' . DIRECTORY_SEPARATOR;
        $public_path=public_path();
        $zipFile = $update_path . 'update_' . $build . '_' . $temp_id . '.zip';
        unlink($zipFile);
        // $base_path .= 'virtual' . DIRECTORY_SEPARATOR;
        if ($build && $upto) {

        //    Artisan::call('route:clear');

            echo '<h5>' . trans('update.installing_update') . '</h5>';
            echo '<pre  style="height: 400px;overflow: scroll;">';
            echo trans('update.updating_files') . ' Build ' . $build . '
';
            if (file_exists($update_path . 'update_' . $build . '_' . $temp_id . '' . DIRECTORY_SEPARATOR . 'files.json')) {
                $url = file_get_contents($update_path . 'update_' . $build . '_' . $temp_id . '' . DIRECTORY_SEPARATOR . 'files.json');
                $files = json_decode($url, true);
                $i = 0;
                $count_f = count($files);
                $b = 0;
                //backup process
                echo trans('update.file_backup_started') . '
';
                $last_build = $build - 1;

                foreach ($files as $row) {
                    $row['path'] = str_replace("/", DIRECTORY_SEPARATOR, $row['path']);
                    echo '
' . $base_path . $row['path'] . $row['file'] . '
';

                    if (strpos($row['path'], 'public') !== false) {
                        $pub_row=$row['path'];
                        $pub_row = str_replace("public", '', $pub_row);
                        if (@copy($public_path . $pub_row . $row['file'], $update_path . 'update_' . $build . '_' . $temp_id . '' . DIRECTORY_SEPARATOR . '' . $row['path'] . 'bak_v_' . $last_build . '_' . $row['file'])) {

                            echo $public_path . $pub_row . $row['file'].' Public Ok (B)
    ';
                        }
                    }

                    if (@copy($base_path . $row['path'] . $row['file'], $update_path . 'update_' . $build . '_' . $temp_id . '' . DIRECTORY_SEPARATOR . '' . $row['path'] . 'bak_v_' . $last_build . '_' . $row['file'])) {
                        $b++;
                        echo 'Ok
    ';
                    } else {
                        if (!is_dir($base_path . $row['path'])) {
                            if (mkdir($base_path . $row['path'], 0777, true)) {
                                echo trans('update.new_directory_created') . ' ' . $base_path . $row['path'] . '
	';
                            } else {
                                echo trans('update.error_new_directory_creation') . ' ' . $base_path . $row['path'] . ' Failed!
	';
                                exit(trans('update.update_process_halted_backup'));
                            }

                        } else {
                            $z = $b + 1;

                            if (is_file($base_path . $row['path'] . $row['file'])) {
                                echo trans('update.critical_notice_files_backup_failed..') . ' ' . $z . '
	';
                                exit(trans('update.update_process_halted_backup'));
                            } else {
                                echo trans('update.ordinary_notice_files_backup_failed') . ' ' . $z . '
	';

                            }
                        }
                    }
                }
            } else {
                exit(trans('update.restricted_access_permissions'));
            }
//update files
            $f = 0;
            echo trans('update.updating_files') . '
';
            foreach ($files as $row) {
                $row['path'] = str_replace("/", DIRECTORY_SEPARATOR, $row['path']);
                echo '
' . $base_path . $row['path'] . $row['file'] . '
';
                if (!file_exists($base_path . $row['path'])) {
                    mkdir($base_path . $row['path'], 0755, true);
                }
                if (@copy($update_path . 'update_' . $build . '_' . $temp_id . '/' . $row['path'] . $row['file'], $base_path . $row['path'] . $row['file'])) {

                    echo 'Ok
    ';
                    $f++;
                } else {
                    $z = $f + 1;
                    echo trans('update.files_update_failed') . $z . '
 ';
                }
            }

            if ($count_f = $f) {
                session(['dbupdate' => true]);
                session(['step' => 2]);

                echo '<h5>' . trans('update.files_updated') . '</h5>';

            } else {
                echo trans('update.some_files_update_failed') . '
 ';

             //   Artisan::call('cache:clear');
            //    Artisan::call('route:cache');
           //    Artisan::call('config:cache');

                exit(trans('update.update_process_halted_file_update'));
            }
            //update ends


        } else {
            exit('Your application is already up to date.');
        }

        echo '
</pre>';
        exit;
    }

    public function update_db()
    {
        if (!single_ton()) return new ViewResponse('focus.general.not_applicable');
        ini_set('memory_limit', '-1');
        $ver = session('build');
        $upto = session('upto');
        $temp_id = session('temp_id');
        $ver = $ver + 1;
        $update_path = base_path() . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'update' . DIRECTORY_SEPARATOR;
        if ($ver && $upto) {

            echo '
<pre>';
            echo trans('update.database_update_process_started') .
                '';

// Set the url
            $url = @file_get_contents($update_path . 'update_' . $ver . '_' . $temp_id . '' . DIRECTORY_SEPARATOR . 'update_build_' . $ver . '.sql');
            if ($url) DB::unprepared($url);


            echo trans('update.database_update_done') .
                '';
            echo '
</pre>';
            session(['step' => 0]);
        } else {
            exit(trans('update.already_updated'));
        }
        exit;
    }

        public function optimize(Request $request)
    {
        if($request->type='backup'){
            $this->db_backup();
        } else {


            try {

                Artisan::call('route:clear');
                Artisan::call('route:cache');
                Artisan::call('cache:clear');
                Artisan::call('config:cache');
            } catch (\Exception $e) {
                print_r($e);
            }
        }
       // exit;
    }
    private function db_backup()
    {
        $rose_all_table_list = "SHOW TABLES";
        $rose_all_list = \Illuminate\Support\Facades\DB::select(DB::raw($rose_all_table_list));
        $r_conn = \Illuminate\Support\Facades\DB::connection('mysql');


        $orgin = "Tables_in_".$r_conn->getDatabaseName();
        foreach ($rose_all_list as $item){
            $tables[] =  $item->$orgin;
        }

        $db_structure = "SET GLOBAL sql_mode = '';
SET SESSION sql_mode = '';
SET FOREIGN_KEY_CHECKS=0;
        ";
        $data = '';
        foreach ($tables as $table) {

            $show_table_query = "SHOW CREATE TABLE " . $table . "";

            $show_table_result = DB::select(DB::raw($show_table_query));

            foreach ($show_table_result as $show_table_row) {
                $show_table_row = (array)$show_table_row;
                $db_structure .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table;
            $stack = DB::select(DB::raw($select_query));

            foreach ($stack as $block) {
                $block = (array)$block;
                $t_c_stack = array_keys($block);
                foreach ($t_c_stack as $key => $name) {
                    $t_c_stack[$key] = '`' . $t_c_stack[$key] . '`';
                }

                $table_value_array = array_values($block);
                $data .= "\nINSERT INTO $table (";

                $data .= "" . implode(", ", $t_c_stack) . ") VALUES \n";

                foreach($table_value_array as $key => $block_column)
                    $table_value_array[$key] = addslashes($block_column);

                $data .= "('" . implode("','", $table_value_array) . "');\n";
            }
        }
        $file_name = storage_path() . '/db_b_' . date('y_m_d_H_i_s') . '.sql';
        $file_handle = fopen($file_name, 'w + ');

        $output = $db_structure . $data;
        fwrite($file_handle, $output);
        fclose($file_handle);
        echo "DB backup is available in storage";
        exit;
    }


}
