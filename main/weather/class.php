<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


class BX_Weather extends CBitrixComponent {
    public function executeComponent()
    {
        
        $this->arResult['RESULT_API'] = $this->weather_api();

        foreach($this->arResult['RESULT_API']->hourly->time as $key => $value){
            $_val = explode('T', $value);
            if($this->time_long($_val[1]) >= 480 && $this->time_long($_val[1]) <= 1320){
                $this->arResult["TIME"][$_val[0]]['precipitation'][] = $this->arResult['RESULT_API']['precipitationv'][$key];
            }
        }

        $this->includeComponentTemplate();
    }


    private static function time_long($time){
        $str_time = $time;
        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
        $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
        return $time_seconds;
    }

    private static function weather_api(){
        
        $ch = curl_init('http://ip-api.com/json/' . $_SERVER['REMOTE_ADDR'] . '?lang=ru');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $_res = curl_exec($ch);
        curl_close($ch);
        
        $_res = json_decode($_res, true);

        $_http_string = 'https://api.open-meteo.com/v1/forecast?latitude=' . $_res['lat'] . '&longitude=' . $_res['lon'] . '&hourly=precipitation&timezone=' . str_replace("/", "%2F", $_res['timezone']);

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $_http_string,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        unset($_res);
        return json_decode($response);

        ///\CAgent::AddAgent( "\\Your\\Module\\SuperClass::superAgent();", "your.module", "N", 10 * 24 * 3600, "", "Y");

    }
}