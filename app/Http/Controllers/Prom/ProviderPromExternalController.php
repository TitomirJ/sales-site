<?php

namespace App\Http\Controllers\Prom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Company;
use App\PromExternal;

use App\Autoupdate;

class ProviderPromExternalController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        $company = Company::find($user->company_id);

		//добавлена переменная настроек автообновления февраль2020г
        $setting_autoupdate = $company->update_auto;

        $info_updates = NULL;

        if($company->update_auto !=NULL){
            $info_update_set = json_decode($company->update_auto);
            $id_url_xml = $info_update_set[2];
            //инфо об автообновлении
        $info_updates = Autoupdate::find($id_url_xml);
       
        }
        
        $company->load('externals');
        return view('provider.company.external.index', compact('company','setting_autoupdate','info_updates'));
    }

    public function create(Request $request){
        if($request->ajax()){
            $data = [];
            $action = $request->action;

            $data['status'] = 'success';

if($action == 'link'){
    $data['title'] = 'Укажите ссылку на XML файл';
 }elseif($action == 'linkxml'){
     $data['title'] = 'Выберите для загрузки XML файл';
 }

            $data['render'] = view('provider.company.external.layouts.modalContent', compact('action'))->render();

            return json_encode($data);
        }else{
            abort('404');
        }
    }

    public function store(Request $request){
        if($request->ajax()){
            $data = [];
            $action = $request->action;

    /**определение расширения файла загруженного пользователем
     * файл приходит из формы
     *  */
    if($request->linkxml != null && $request->linkxml !=''){
        $extensionxml1 = $request->linkxml;
			 $extensionxml = $extensionxml1->getClientOriginalExtension();

    }

/**
 * в зависимости от того какая форма была отправелена , определяется путь к фалу $url
 * если получена форма которая присылает файл загруженный пользователем, а не ссылка на файл
 * то требуется произвести загрузку этого файла на сервер методом uploadFile если расширение этого файла xml
 */

if($action == 'link'){
    $url = $request->link;

}elseif($action == 'linkxml' && $extensionxml == 'xml'){
    $url = self::uploadFile($request->linkxml);
    }else{
        $data['status'] = 'danger';
        $data['msg'] = 'Файл не является XML файлом!';
        return json_encode($data);
    }



                $user = Auth::user();
                $flag_public = self::checkPublicPathForFileOrLinkXML($url);

                if($flag_public){
                    if(self::isXMLFileValid($url)){
                        PromExternal::create([
                            'unload_url' => $url,
                            'company_id' => $user->company_id
                        ]);
                        $data['status'] = 'success';
                        $data['msg'] = 'Ссылка добавлена и отправлена на проверку!';
                    }else{
                        $data['status'] = 'danger';
                        $data['msg'] = 'Файл не прошел валидацию, XML файл составлен не правильно или ссылка не является XML файлом!';
                    }
                }else{
                    $data['status'] = 'danger';
                    $data['msg'] = 'Ссылка на XML файл не доступна, убидитесь что к файлу есть публичный доступ!';
                }

                return json_encode($data);
            }
        else{
            abort('404');
        }
    }

    private function isXMLFileValid($xmlFilename, $version = '1.0', $encoding = 'utf-8')
    {
        $xmlContent = file_get_contents($xmlFilename);
        return self::isXMLContentValid($xmlContent, $version, $encoding);
    }


    private function isXMLContentValid($xmlContent, $version = '1.0', $encoding = 'utf-8')
    {
        if (trim($xmlContent) == '') {
            return false;
        }

        libxml_use_internal_errors(true);

        $doc = new \DOMDocument($version, $encoding);
        $doc->loadXML($xmlContent);

        $errors = libxml_get_errors();
        libxml_clear_errors();

        return empty($errors);
    }

    private function checkPublicPathForFileOrLinkXML($public_path){
        $headers = @get_headers($public_path);
        if (preg_match("|200|", $headers[0])) {
            return true;
        }else{
            return false;
        }
    }

    public function rules(Request $request){

        return view('provider.company.external.rules');
    }

    // загрузка файла на сервер
    private function uploadFile($file){
        $name = sha1(date('YmdHis') . str_random(30));
        $resize_name = $name . str_random(2) . '.' . $file->getClientOriginalExtension();
        $path = public_path().'/files/xml/';
        $file->move($path, $resize_name);

        return asset('files/xml/'.$resize_name);
    }

}