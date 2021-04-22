<?php

namespace src;

interface IResponseHandler
{
    /**
     * Метод для управления ответами
     */
    public function handleResponce($resp_str);
}