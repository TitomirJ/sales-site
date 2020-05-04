<?//проверка изображений
$json_array_image = json_decode($product->gallery);
//    echo '<pre>';
//print_r($json_array_image);
//    echo '</pre>';

foreach ($json_array_image as $image){
?>
<img src="{{ $image->public_path }}" width="50">

<?

if(preg_match('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)([^\s]+(\.(?i)(jpg|png|gif|bmp))$)@', $image->public_path)){
    echo 'img';
    $headers = @get_headers($image->public_path);
    if (preg_match("|200|", $headers[0])) {
        echo 'true</br>';
    } else {
        echo 'false </br>';
    }
}else{
    echo 'no-img</br>';
}
}



?>