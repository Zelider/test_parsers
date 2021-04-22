<?php


class yulaResponceHandler implements iResponseHandler
{
    /**
     * yulaResponceHandler constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $resp_str
     * @return array
     */
    public function handleResponce($resp_str)
    {
        $price = json_decode($resp_str['data-discount'], true);

        $arr[0] = $resp_str['data-id'];
        $arr[1] = $price['price_after_discount'];
        $arr[2] = 'https://youla.ru/moskva/zhivotnye'.$resp_str['href'];
        $arr[3] = $this->encodingDetector($resp_str['title']);

        return $arr;
    }

    /**
     * @param $enc_str
     * @param string $res_enc_name
     * @return array|false|string
     */
    protected function encodingDetector($enc_str, $res_enc_name = 'UTF-8'){
        if (!mb_detect_encoding($enc_str, $res_enc_name, true)) {
            return mb_convert_encoding((string) $enc_str, mb_detect_encoding($enc_str), $res_enc_name);
        }
        return $enc_str;
    }
}