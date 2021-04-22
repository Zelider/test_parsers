<?php

namespace src;

class yulaResponceHandler implements IResponseHandler
{
    protected string $adress;
    /**
     * Конструктор по умолчанию для класса
     * yulaResponceHandler constructor.
     */
    public function __construct($adr_str)
    {
        $this->adress = $adr_str;
    }


    /**
     * Получает строку с ответом и перерабатывает ее в единый ответа для дальнейшего использования
     * @param $resp_str
     *
     * @return array
     */
    public function handleResponce($resp_str): array
    {
        $price = json_decode($resp_str['data-discount'], true);

        $arr[0] = $resp_str['data-id'];
        $arr[1] = $price['price_after_discount'];
        $arr[2] = $this->adress.$resp_str['href'];
        $arr[3] = $this->encodingDetector($resp_str['title']);

        return $arr;
    }

    /**
     * Проверяет соответствие кодировки полученной строки с входной кодировкой (по умолчанию UTF-8)
     * @param $enc_str
     * @param string $res_enc_name
     *
     * @return array|false|string
     */
    protected function encodingDetector($enc_str, $res_enc_name = 'UTF-8')
    {
        if (!mb_detect_encoding($enc_str, $res_enc_name, true)) {
            return mb_convert_encoding((string) $enc_str, mb_detect_encoding($enc_str), $res_enc_name);
        }

        return $enc_str;
    }
}