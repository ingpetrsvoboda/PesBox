<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Framework\Di;

/**
 * Description of ExceptionHelper
 *
 * @author pes2704
 */
class ExceptionHelper {
    public static function ServiceNotFound($service) {
        throw new NotFoundException('Požadovaná služba kontejneru nebyla nastavena: '.$service);
    }
}