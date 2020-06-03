<?

// set error reporting level
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE);

// save file
if ($_POST['data'] != '') {

    $files = glob("cache/*.jpg");
    foreach($files as $file) {
        if(is_file($file) && time() - filemtime($file) >= 2*24*60*60) {
            @unlink($file);
        }
    }

    $sRand = rand(100000, 999999);
    $sOrigPath = 'cache/result'.$sRand.'.jpg';
    @unlink($sOrigPath);

    $img = $_POST['data'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = strip_tags($img);
    $img = str_replace(' ', '+', $img);
    $decodedData = base64_decode($img);

    file_put_contents($sOrigPath, $decodedData);
    echo $sRand;
}