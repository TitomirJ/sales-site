<?
    require_once 'hamtim-amocrm.php';

    if(isset($_POST['data']['login']) && isset($_POST['data']['key']) && isset($_POST['data']['subdomen'])){
        $amo = new HamtimAmocrm($_POST['data']['login'], $_POST['data']['key'], $_POST['data']['subdomen']);

        if($amo->auth){
            //получаем список сделок в работе
            $path = '/api/v2/leads';
            $ifModifiedSince = date('D, d M Y H:i:s', (time()-1*24*3600));
            $fields = array('id' => 6482289);

            $leads = $amo->q($path, $fields, $ifModifiedSince);
            echo json_encode(['status' => 'success',
                'msg' => 'Есть подключение к AmoCRM',
                'data' => $leads
            ]);
        }else{
            echo json_encode(['status' => 'error',
                'msg' => 'Нет подключения к AmoCRM'
            ]);
        }
    }else{
        echo json_encode(['status' => 'error',
                            'msg' => 'Нет подключения к AmoCRM'
        ]);
    }


