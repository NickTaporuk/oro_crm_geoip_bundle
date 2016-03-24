<?php
/**
 * Created by IntelliJ IDEA.
 * User: nkuropatkin
 * Date: 25.02.16
 * Time: 11:44
 */

namespace Nabludai\GeoipBundle\Twig;


use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables as BaseGlobalVariables;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * reappointed class GlobalVariable Twig
 * Class GlobalVariables
 * @package Nabludai\GeoipBundle\Twig
 */
class GlobalVariables extends BaseGlobalVariables
{

    /**
     * <p>Add geoip to global variable twig</p>
     *<p>use in twig as app.geoip</p>
     * @return bool
     */
    public function  getGeoIp()
    {
        $local = $this->getRequest()->getClientIp().'<----';
        $geo = $this->container->get('nabludai_geoip.manager');
        //visible block
        $geo_country    = $this->container->getParameter('geo_country');
        $user_ip        = $this->container->get('request')->getClientIp();
        ($user_ip == '127.0.0.1' ) ? $user_ip = $geo_country[4]['default_ip'] : false;
        $city_data      = ($geo->getCountry($user_ip))?:$geo_country[3]["default_country"];

        $state      = in_array($city_data,$geo_country[2]["not_visible_block_security"]);
        return $state ;
    }
}