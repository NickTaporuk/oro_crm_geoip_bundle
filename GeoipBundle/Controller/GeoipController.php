<?php

namespace Nabludai\GeoipBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class GeoipController
 * @package Nabludai\GeoipBundle\Controller
 */
class GeoipController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function countryStateAction(Request $request)
    {
        try {
            $geo_country  = $this->container->getParameter('geo_country');

            $geo        = $this->container->get('nabludai_geoip.manager');
            $user_ip    = $request->getClientIp();
            ($user_ip =='127.0.0.1')?$user_ip = $geo_country[4]['default_ip']:false;
            $country    = ($geo->getCountry($user_ip))?:$geo_country[3]['default_country'];

            $state      = in_array($country,$geo_country[2]["not_visible_block_security"]);
            if(!$country) throw new Exception('No session country variable');
            return new JsonResponse(['status'=>'success','country'=>$country,'ua_block_visible'=>$state]);

        } catch(Exception $e) {
            error_log('[GEO IP ERROR:]'.$e->getTraceAsString());
            return new JsonResponse([   'status'=>'error',
                                        'error'=>'server error',
                                        'text'=>$e->getMessage()],500);
        }
    }

}
