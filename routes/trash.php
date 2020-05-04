<?
Route::get('list', function() {


//    $url = "http://img11.lostpic.net/2018/08/16/f5430bfb612fcb3de70fcc432a29e68f.jpg";
//    $contents = file_get_contents($url);
//    $name = substr($url, strrpos($url, '/') + 1);
//    $storagePath = Storage::disk('s3')->put($name, $contents, 'public');
//$q =Storage::disk('s3')->delete('f5430bfb612fcb3de70fcc432a29e68f.jpg');
//    dd($q);
echo asset('/');
});


Route::get('list2', function() {

$client = new \GuzzleHttp\Client();
$response = $client->request('POST', 'http://lostpic.net/api/1/upload', [
'form_params' => [
'key' => '8fda0f020c89a1fe53d117deef24ab03',
'source' => 'https://bigsales.pro/images/uploads/0d99590c477c6474afa78a7738e3ac80294b70af0e.jpg',
'login' => 'Imarket',
'password' => 'zk.,k.cdj.hf,jne',
'format'=> 'json'


]
]);
$response = $response->getBody()->getContents();
//    $d = json_decode($response);
//    echo $d->image->url;
echo '<pre>';
    print_r(json_decode($response));
    echo '</pre>';
});

Route::get('list3', function() {

$client = new \GuzzleHttp\Client();
$response = $client->request('POST', 'http://lostpic.net/api/1/delete', [
'form_params' => [
'key' => '8fda0f020c89a1fe53d117deef24ab03',
'image_id' => 'nnvk',
'login' => 'Imarket',
'password' => 'zk.,k.cdj.hf,jne',



]
]);
$response = $response->getBody()->getContents();
echo '<pre>';
    print_r($response);
    echo '</pre>';
});