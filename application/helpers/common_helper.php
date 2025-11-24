<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('print_pre')) {
  		function print_pre($data,$die=false) {
            echo '<pre>'; print_r($data); echo "</pre>";
            if($die){ die; }
		}  
	}

	if(!function_exists('success_msg')) {
  		function success_msg($key='msg') {
            $CI = get_instance();
            $message=$CI->session->flashdata($key);
            $message=$message??'';
            return $message;
		}  
	}

	if(!function_exists('error_msg')) {
  		function error_msg($key='err_msg') {
            $CI = get_instance();
            $message=$CI->session->flashdata($key);
            $message=$message??'';
            return $message;
		}  
	}

    if(!function_exists('logrequest')) {
  		function logrequest() {
            if(REQUEST_LOG==TRUE){
                $CI = get_instance();
                $post=[$CI->input->post()];
                if(method_exists($CI, 'post')){
                   $post[]= $CI->post();
                }
                $post=json_encode($post);
                $server=json_encode($_SERVER);
                $files=json_encode($_FILES);
                $cookie=json_encode($_COOKIE);
                $headers=function_exists('getallheaders')?json_encode(getallheaders()):array();
                $ip= get_visitor_IP();
                $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $CI->db->insert("request_log",array("url"=>$url,"ip_address"=>$ip,"post"=>$post,"files"=>$files,"server"=>$server,
                                                    "cookie"=>$cookie,"headers"=>$headers,"added_on"=>date('Y-m-d H:i:s')));
                //sleep(1);
            }
        }
    }

    if(!function_exists('strWordCut')) {
        function strWordCut($string,$length,$end='....'){
            if(!empty($string)){
                $string = strip_tags($string);

                if (strlen($string) > $length) {

                    // truncate string
                    $stringCut = substr($string, 0, $length);

                    // make sure it ends in a word so assassinate doesn't become ass...
                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')).$end;
                }
            }
            return $string;
        }
    }

    if(!function_exists('stripTagsExceptParagraphs')) {
        function stripTagsExceptParagraphs($html) {
            
            $strippedText = strip_tags($html); // Remove HTML tags
            $strippedTextWithLineBreaks = nl2br($strippedText); // Preserve line breaks
            $strippedTextWithLineBreaks=str_replace('<br />',"",$strippedTextWithLineBreaks);
            $strippedTextWithLineBreaks=str_replace('&nbsp;'," ",$strippedTextWithLineBreaks);
            return $strippedTextWithLineBreaks;
        }
    }

    if(!function_exists('emptyToNull')) {
        function emptyToNull($array) {
            return array_map(function($value) {
                return $value === '' ? NULL : $value;
            }, $array);
        }
    }

    if(!function_exists('haversineDistance')) {
        function haversineDistance($lat1, $lon1, $lat2, $lon2) {
            $earthRadius = 6371000; // meters

            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);

            $a = sin($dLat/2) * sin($dLat/2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                sin($dLon/2) * sin($dLon/2);

            $c = 2 * atan2(sqrt($a), sqrt(1-$a));

            return $earthRadius * $c;
        }

    }

    if(!function_exists('encryptData')) {
        function encryptData($data) {
            $jsonData = json_encode($data);
            // Encrypt the JSON data
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $skey = SITE_SALT; // Change this to your secret key
            $encryptedData = openssl_encrypt($jsonData, 'aes-256-cbc', $skey, 0, $iv);

            // Convert binary data to hexadecimal string
            $encryptedHex = bin2hex($encryptedData);
            $ivHex = bin2hex($iv);
            return array('enc'=>$encryptedHex,'iv'=>$ivHex);
        }
    }

	if(!function_exists('getuser')) {
  		function getuser($redirect=true) {
    		$CI = get_instance();
            $getuser=$CI->account->getuser(array("md5(id)"=>$CI->session->user));
            if($getuser['status']==true){
                return $getuser['user'];
            }
            elseif($redirect){
                redirect('home/');
            }
            else{
                return array();
            }
		}  
	}

    function redirectToAppOrPlayStore($customSchemeUrl, $playStoreUrl) {
        // Check if the request is from a mobile device
        if (isMobileDevice()) {
            // Attempt to redirect to custom scheme
            header("Location: $customSchemeUrl");
            exit;
        } else {
            // Redirect to Play Store URL
            header("Location: $playStoreUrl");
            exit;
        }
    }

    // Function to check if a user agent is a mobile device
    function isMobileDevice() {
        return preg_match("/(android|iphone|ipod|ipad)/i", $_SERVER['HTTP_USER_AGENT']);
    }

    if (! function_exists('get_visitor_IP')){
        /**
         * Get the real IP address from visitors proxy. e.g. Cloudflare
         *
         * @return string IP
         */
        function get_visitor_IP()
        {
            // Get real visitor IP behind CloudFlare network
            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            }

            // Sometimes the `HTTP_CLIENT_IP` can be used by proxy servers
            $ip = @$_SERVER['HTTP_CLIENT_IP'];
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
               return $ip;
            }

            // Sometimes the `HTTP_X_FORWARDED_FOR` can contain more than IPs 
            $forward_ips = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            if ($forward_ips) {
                $all_ips = explode(',', $forward_ips);

                foreach ($all_ips as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)){
                        return $ip;
                    }
                }
            }

            return $_SERVER['REMOTE_ADDR'];
        }
    }

	if(!function_exists('getdeliverycharge')) {
  		function getdeliverycharge($amount) {
    		$CI = get_instance();
            $where=array("min_amount<="=>$amount,"max_amount>="=>$amount);
            $getdeliverycharge=$CI->db->get_where("delivery_charge",$where);
            if($getdeliverycharge->num_rows()==0){
                return 0;
            }
            else{
                $array=$getdeliverycharge->unbuffered_row('array');
                return $array['amount'];
            }
        }
    }

    if(!function_exists('logupdateoperations')) {
        function logupdateoperations($table,$data,$where,$parent_id=NULL) {
            $CI = get_instance();
            $class=$CI->router->class;
            $method=$CI->router->method;
            $ref=array('class'=>$class,'method'=>$method);
            $CI->load->library('DBOperations');
            $result=$CI->dboperations->log_update($table,$data,$where,$ref,$parent_id);
            return $result;
        }
    }

    if(!function_exists('logdeleteoperations')) {
        function logdeleteoperations($table,$where,$parent_id=NULL) {
            $CI = get_instance();
            $class=$CI->router->class;
            $method=$CI->router->method;
            $ref=array('class'=>$class,'method'=>$method);
            $CI->load->library('DBOperations');
            $result=$CI->dboperations->log_delete($table,$where,$ref,$parent_id);
            return $result;
        }
    }

    if(!function_exists('isValidDate')) {
        function isValidDate($date) {
            // Null, empty, or not a string at all
            if (empty($date) || !is_string($date)) {
                return false;
            }

            // Try converting to timestamp
            $timestamp = strtotime($date);
            if ($timestamp === false) {
                return false;
            }

            // Optional: return formatted date for consistency
            return true;
        }
    }
