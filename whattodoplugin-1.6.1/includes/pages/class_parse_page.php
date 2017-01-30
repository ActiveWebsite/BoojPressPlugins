<?php

class wtd_parse_page{

    protected $twig;
    protected $wtd_plugin;

    function __construct(){
        $loader = new Twig_Loader_Filesystem(WTD_PLUGIN_PATH.'/templates');
        $debug = true;
        $this->twig = new Twig_Environment($loader, array(
            //'cache' => WTD_PLUGIN_PATH.'/twig_cache',
            'debug' => $debug
        ));
        if($debug)
            $this->twig->addExtension(new Twig_Extension_Debug());
        $this->wtd_plugin = get_option('wtd_plugin');
    }

    protected function get_addresses($addresses){
        ob_start();
        if(!empty($addresses)):
            if(count($addresses) == 1):
                $address = $addresses[0];?>
                <div flex><?php
                $display_address = '';
                if(!empty($address->address))
                    $street = $address->address;
                if(!empty($street))
                    $display_address .= $street;
                if(!empty($address->city))
                    $city = $address->city;
                if(!empty($city)){
                    if(!$display_address)
                        $display_address .= $city;
                    else
                        $display_address .= ' in ' . $city;
                }
                if(!empty($address->state))
                    $state = $address->state;
                if(!empty($state)){
                    if(empty($display_address))
                        $display_address .= $state;
                    else
                        $display_address .= ', ' . $state;
                }
                if(!empty($address->phone))
                    $phone = $address->phone;
                if(!empty($phone))
                    $display_address .= " (" . substr($phone, 0, 3) . ") " . substr($phone, 3, 3) . "-" . substr($phone, 6);
                else
                    $display_address .= '';
                echo $display_address;?>
                </div><?php
            else:
                $locations = array();
                foreach($addresses as $add){
                    if(!empty($add->location)){
                        if(!in_array(ucfirst($add->location), $locations))
                            $locations[] = ucfirst($add->location);
                    }elseif(!empty($add->city)){
                        if(!in_array(ucfirst($add->city), $locations))
                            $locations[] = ucfirst($add->city);
                    }
                }
                $address = 'Various Locations in '.implode(', ', $locations);?>
                <div flex><?php echo $address;?></div><?php
            endif;
        endif;
        $response = ob_get_contents();
        ob_end_clean();
        return $response;
    }

}