<?php
    date_default_timezone_set('Africa/Lagos');
    require(__DIR__.'/../vendor/autoload.php');

    use GuzzleHttp\Client;

    if (!function_exists('array_get')) {
        /*
             *
             * @param array  $data
             * @param string $key
             * @param string $default
             *
             * @return mixed
             */
        function array_get($data, $key, $default = false)
        {
            if (!is_array($data)) {
                return $default;
            }
            return isset($data[$key]) ? $data[$key] : $default;
        }
    }
    
    if (!function_exists('array_keys_exist')) {
        /**
         * Checks if multiple keys exist in an array
         *
         * @param array $array
         * @param array|string $keys
         *
         * @return bool
         */
        function array_keys_exist(array $array, $keys)
        {
            $count = 0;
            if (!is_array($keys)) {
                $keys = func_get_args();
                array_shift($keys);
            }
            foreach ($keys as $key) {
                if (array_key_exists($key, $array)) {
                    $count++;
                }
            }
    
            return count($keys) === $count;
        }
    }
    class xPay
    {
        public function connect()
        {
            date_default_timezone_set("Africa/Lagos");
            $host     = "localhost";
            $username = "root";
            $password = "";
            $dbname   = "xpay";
            $charset  = "utf8mb4";
            try {
                $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ";charset=" . $charset;
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                return $pdo;
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }

        public function cleanResponse($response)
        {
            $result = $response->getBody()->getContents();
            return $result;
        }

        public function sendRequest($vendor, $method, $url, $params = [], $token)
        {
            if ($vendor == 'seerbit') {
                $client = new Client([
                    'base_uri' => "https://seerbitapi.com",
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer i4a4nLkcye2qkL5hLSqCR/gIpXkCVHqc2lYsZf0CdS2vK9tIpe1vaURcRS/9XPtkmFsPJRH0DJo9yKDUdhX1HST8Dx0e45RKeCig6cCEU8jX3LXjiMSS5e3udMPTtsLF'
                    ]
                ]);
            }
            try {
                if (strtolower($method) == 'get') {
                    $result = $client->request('GET', $url);
                    return $this->cleanResponse($result);
                } elseif (strtolower($method) == 'post') {
                    $result = $client->request('POST', $url, $params);
                    return $this->cleanResponse($result);
                } elseif (strtolower($method) == 'patch') {
                    $result = $client->request('PATCH', $url, $params);
                    return $this->cleanResponse($result);
                }
            } catch (Exception $e) {
                // echo $e->getRequest();
                // var_dump($e->getResponse());
                throw $e;
            }
        }

        public function getUsers(array $options)
        {
            if(count($options) > 0){ // Check if WHERE fields are assigned
                $query  = "SELECT * FROM `users` WHERE ";
                $parts = array();
                foreach ($options as $key => $value) { // loop through the arrays and set the conditions
                    $parts[] = "`" . $key . "` = '$value' ";
                }
                $query  = $query . implode(" AND ", $parts);
            }else{ // or just fetch all users
                $query  = "SELECT * FROM `users`";
            }
            $stmt   = $this->connect()->prepare($query);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $result = $stmt->fetchAll();
            }else{
                $result = "404";
            }

            return $result;
        }

        public function getUser(array $options)
        {
            $query  = "SELECT * FROM `users` WHERE ";
            $parts = array();
            foreach ($options as $key => $value) { // loop through the array and set the conditions
                $parts[] = "`" . $key . "` = '$value' LIMIT 1";
            }
            $query  = $query . implode(" AND ", $parts);

            $stmt   = $this->connect()->prepare($query);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $result = $stmt->fetch();
            }else{
                $result = "404";
            }

            return $result;
        }

        public function registerUser($firstName, $lastName, $phone, $email = null, $password, $uuid, $type = null, $agent = null)
        {
            $query  = "INSERT INTO `users` (`first_name`, `last_name`, `phone`, `email`, `password`, `uuid`, `type`, `agent`)
                                VALUES (:firstName, :lastName, :phone, :email, :password, :uuid, :type, :agent)";
            $stmt   = $this->connect()->prepare($query);
            if($stmt->execute(['firstName' => $firstName, 'lastName' => $lastName, 'phone' => $phone, 'email' => $email, 'password' => $password, 'uuid' => $uuid, 'type' => $type, 'agent' => $agent])){
                $result = "success";
            }else{
                $result = "error";
            }

            return $result;
        }

        public function loginUser($phone, $password){
            $query  = "SELECT * FROM `users` WHERE `phone` = :phone AND `password` = :password";
            $stmt   = $this->connect()->prepare($query);
            $stmt->execute(['phone' => $phone, 'password' => $password]);
            if($stmt->rowCount() > 0){
                $result = $stmt->fetch();
            }else{
                $result = "error";
            }

            return $result;
        }

    }

?>