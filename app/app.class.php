<?php
date_default_timezone_set('Africa/Lagos');
require(__DIR__ . '/../vendor/autoload.php');
// // Looing for .env at the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
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
        // $host     = "localhost";
        // $username = "root";
        // $password = "";
        // $dbname   = "xpay";
        $charset  = "utf8mb4";
        try {
            $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ";charset=" . $charset;
            $pdo = new PDO($dsn, $_ENV['USERNAME'], $_ENV['PASSWORD']);
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
                    'Authorization' => 'Bearer '.$_ENV['SEERBIT_TOKEN']
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
        if (count($options) > 0) { // Check if WHERE fields are assigned
            $query  = "SELECT * FROM `users` WHERE ";
            $parts = array();
            foreach ($options as $key => $value) { // loop through the arrays and set the conditions
                $parts[] = "`" . $key . "` = '$value' ORDER BY `id` DESC";
            }
            $query  = $query . implode(" AND ", $parts);
        } else { // or just fetch all users
            $query  = "SELECT * FROM `users`";
        }
        $stmt   = $this->connect()->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
        } else {
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
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch();
        } else {
            $result = "404";
        }

        return $result;
    }

    public function registerUser($firstName, $lastName, $phone, $country = "NG", $currency = "NGN", $email = null, $password, $uuid, $type = null, $agent = null)
    {
        $query  = "INSERT INTO `users` (`first_name`, `last_name`, `phone`, `country`, `currency`, `email`, `password`, `uuid`, `type`, `agent`)
                                VALUES (:firstName, :lastName, :phone, :country, :currency, :email, :password, :uuid, :type, :agent)";
        $stmt   = $this->connect()->prepare($query);
        if ($stmt->execute(['firstName' => $firstName, 'lastName' => $lastName, 'phone' => $phone, 'email' => $email, 'password' => $password, 'uuid' => $uuid, 'type' => $type, 'agent' => $agent, 'country' => $country, 'currency' => $currency])) {
            $result = "success";
        } else {
            $result = "error";
        }

        return $result;
    }

    public function loginUser($phone, $password)
    {
        $query  = "SELECT * FROM `users` WHERE `phone` = :phone AND `password` = :password";
        $stmt   = $this->connect()->prepare($query);
        $stmt->execute(['phone' => $phone, 'password' => $password]);
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch();
        } else {
            $result = "error";
        }

        return $result;
    }

    public function getWallets(array $options)
    {
        if (count($options) > 0) { // Check if WHERE fields are assigned
            $query  = "SELECT * FROM `wallets` WHERE ";
            $parts = array();
            foreach ($options as $key => $value) { // loop through the arrays and set the conditions
                $parts[] = "`" . $key . "` = '$value' ";
            }
            $query  = $query . implode(" AND ", $parts);
        } else { // or just fetch all wallets
            $query  = "SELECT * FROM `wallets`";
        }
        $stmt   = $this->connect()->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
        } else {
            $result = "404";
        }

        return $result;
    }

    public function getWallet(array $options)
    {
        $query  = "SELECT * FROM `wallets` WHERE ";
        $parts = array();
        foreach ($options as $key => $value) { // loop through the array and set the conditions
            $parts[] = "`" . $key . "` = '$value' LIMIT 1";
        }
        $query  = $query . implode(" AND ", $parts);

        $stmt   = $this->connect()->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch();
        } else {
            $result = "404";
        }

        return $result;
    }

    public function createWallet($userId, $currency, $externalReference = null)
    {
        $user       = $this->getUser(['id' => $userId]);
        $key        = rand(001, 999).rand(001, 999).rand(001, 999).rand(1, 9);
        $key        = md5($key.$user->uuid);
        $url        = "/api/v2/virtual-accounts";
        $data       = array(
            "publicKey" => $_ENV['SEERBIT_PUB'],
            "fullName" => $user->first_name." ".$user->last_name,
            "bankVerificationNumber" => "",
            "currency" => $currency,
            "country" => $user->country,
            "reference" => $key,
            "email" => $user->email
        );
        $request    = $this->sendRequest('seerbit', 'POST', $url, ['body' => json_encode($data)], "");
        $request    = json_decode($request, true);
        if(strtolower($request['status']) == "success"){
            $accountNumber  = $request['data']['payments']['accountNumber'];
            $bank           = $request['data']['payments']['bankName'];
            $query  = "INSERT INTO `wallets`(`user`, `reference`, `account_number`, `bank`, `external_reference`, `currency`) 
                                    VALUES (:user, :reference, :account, :bank, :external, :currency)";
            $stmt   = $this->connect()->prepare($query);
            if ($stmt->execute(['user' => $userId, 'reference' => $key, 'account' => $accountNumber, 'bank' => $bank, 'external' => $externalReference, 'currency' => $currency])) {
                $result = "success";
            } else {
                $result = "error";
            }
        }

        return $result;
    }

    public function saveTransaction($type, $wallet, $reference, $user, $data, $amount, $oldBalance, $newBalance, $status)
    {
        if($reference == null){
            $reference  = rand(100,9999).chr(rand(65,90)).chr(rand(65,90)).rand(10,99).rand(000110, 999999);
        }
        $query  = "INSERT INTO `transactions`(`type`, `wallet`, `reference`, `user`, `data`, `amount`, `balance_before`, `balance_after`, `status`) 
                                        VALUES (:type, :wallet, :reference, :user, :data, :amount, :before, :after, :status)";
        $stmt   = $this->connect()->prepare($query);
        if($stmt->execute(['type' => $type, 'wallet' => $wallet, 'reference' => $reference, 'user' => $user, 'data' => $data, 'amount' => $amount, 'before' => $oldBalance, 'after' => $newBalance, 'status' => $status])){
            $result = "success";
        }else{
            $result = "error";
        }

        return $result;
    }

    public function getTransactions(array $options)
    {
        if (count($options) > 0) { // Check if WHERE fields are assigned
            $query  = "SELECT * FROM `transactions` WHERE ";
            $parts = array();
            foreach ($options as $key => $value) { // loop through the arrays and set the conditions
                $parts[] = "`" . $key . "` = '$value' ORDER BY `id` DESC";
            }
            $query  = $query . implode(" AND ", $parts);
        } else { // or just fetch all transactions
            $query  = "SELECT * FROM `transactions` ORDER BY `id` DESC";
        }
        $stmt   = $this->connect()->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
        } else {
            $result = "404";
        }

        return $result;
    }

    public function getTransaction(array $options){
        $query  = "SELECT * FROM `transactions` WHERE ";
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

    public function createInvoice($user, $receiverName, $receiverEmail, array $items, $currency, $total, $dueDate)
    {
        $url        = '/invoice/create';
        $reference  = rand(100,9999).chr(rand(65,90)).chr(rand(65,90)).rand(10,99).rand(000110, 999999);
        $orderId    = $currency.$reference;
        $data       = array(
            'publicKey' => $_ENV['SEERBIT_PUB'],
            'orderNo' => $orderId,
            'dueDate' => $dueDate,
            'currency' => $currency,
            'receiversName' => $receiverName,
            'customerEmail' => $receiverEmail,
            "invoiceItems" => $items
        );
        $request    = $this->sendRequest('seerbit', 'POST', $url, ['body' => json_encode($data)], '');
        $request    = json_decode($request, true);
        if($request['code'] == "00"){
            $query  = "INSERT INTO `invoices`(`user`, `external_reference`, `order_number`, `receiver_name`, `receiver_email`, `items`, `total`, `currency`, `due_date`) 
                                    VALUES (:user, :ref, :order, :name, :email, :items, :total, :currency, :due)";
            $stmt   = $this->connect()->prepare($query);
            if($stmt->execute(['user' => $user, 'ref' => $request['payload']['InvoiceNo'], 'order' => $orderId, 'name' => $receiverName, 'email' => $receiverEmail, 'items' => json_encode($items), 'total' => $total, 'currency' => $currency, 'due' => $dueDate])){
                $result = "success";
            }else{
                $result = "error";
            }
        }

        return $result;
    } 

    public function getInvoices(array $options)
    {
        if (count($options) > 0) { // Check if WHERE fields are assigned
            $query  = "SELECT * FROM `invoices` WHERE ";
            $parts = array();
            foreach ($options as $key => $value) { // loop through the arrays and set the conditions
                $parts[] = "`" . $key . "` = '$value' ";
            }
            $query  = $query . implode(" AND ", $parts);
        } else { // or just fetch all invoices
            $query  = "SELECT * FROM `invoices`";
        }
        $stmt   = $this->connect()->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
        } else {
            $result = "404";
        }

        return $result;
    }

    public function getInvoice(array $options){
        $query  = "SELECT * FROM `invoices` WHERE ";
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

    public function updateInvoice($invoice, array $options){
        $query  = "UPDATE `invoices` SET `updated_at` = NOW(), ";
        $parts = array();
        foreach ($options as $key => $value) { // loop through the array and set the conditions
            $parts[] = "`" . $key . "` = '$value' WHERE `id` = :invoice";
        }
        $query  = $query . implode(", ", $parts);

        $stmt   = $this->connect()->prepare($query);
        if($stmt->execute(['invoice' => $invoice])){
            $result = "success";
        }else{
            $result = "404";
        }

        return $result;
    }

    public function invoiceStatus($invoiceId)
    {
        $invoice = $this->getInvoice(['id' => $invoiceId]);
        if($invoice != "404"){
            // {
            //     "payload": {
            //         "invoiceId": 146,
            //         "invoiceNo": "SBT-INV-000146",
            //         "totalAmount": 107.50,
            //         "subTotal": 100.00,
            //         "publicKey": "SBPUBK_ZNUONZZSC7VK9PGWG9QWNNHWLKK0INNP",
            //         "testKey": "SBTESTPUBK_afXR5UIYCD26aNXBFePI3dBdhaq2pAz0",
            //         "supportEmail": "omacys2@gmail.com",
            //         "receiversName": "Shamsuddeen Omacy",
            //         "customerEmail": "omacys2@gmail.com",
            //         "businessName": "xPay [Hackathon]",
            //         "tax": 7.50,
            //         "dueDate": "2022-11-15",
            //         "currency": "NGN",
            //         "invoiceItems": [{
            //             "itemName": "Hublot",
            //             "unitPrice": 100.00,
            //             "vat": 7.50,
            //             "amount": 100.00,
            //             "quantity": 1
            //         }],
            //         "customer": {},
            //         "billingCycle": false,
            //         "payButtonOnInvoices": false,
            //         "enableAdvancedOptions": false,
            //         "partialPayment": false,
            //         "status": "PAID",
            //         "createdAt": "2022-11-15T14:29:14.351"
            //     },
            //     "code": "00"
            // }
            $url = "/invoice/".$_ENV['SEERBIT_PUB']."/$invoice->external_reference";
            $request = $this->sendRequest('seerbit', 'get', $url, [], "");
            $request = json_decode($request, true);
            if($request['code'] == "00"){
                $update = $this->updateInvoice(
                    $invoiceId, [
                        'status' => $request['payload']['status']
                    ]);
                if($update == "success"){
                    $result = "success";
                }else{
                    $result = "error";
                }
            }

        }else{
            $result = "error";
        }

        return $result;
    }

    public function fundWallet($walletId, $amount, $oldBalance, $newBalance, array $data, $reference = null)
    {
        if($reference == null){
            $reference  = rand(100,9999).chr(rand(65,90)).chr(rand(65,90)).rand(10,99).rand(000110, 999999);
        }

        $wallet     = $this->getWallet(['id' => $walletId]);
        $balance    = $wallet->balance;
        $newBalance = $balance + $amount;

        $data       = json_encode($data);
        $query      = "UPDATE `wallets` SET `balance` = :balance WHERE `id` = :wallet";
        $stmt       = $this->connect()->prepare($query);
        if($stmt->execute(['wallet' => $walletId, 'balance' => $newBalance])){
            $this->saveTransaction('credit', $walletId, $reference, $wallet->user, $data, $amount, $oldBalance, $newBalance, 'successful');
            $result = "success";
        }else{
            $result = "error";
        }

        return $result;
    }

    public function debitWallet($walletId, $amount, $oldBalance, $newBalance, array $data, $reference = null)
    {
        if($reference == null){
            $reference  = rand(100,9999).chr(rand(65,90)).chr(rand(65,90)).rand(10,99).rand(000110, 999999);
        }
        $wallet     = $this->getWallet(['id' => $walletId]);
        $balance    = $wallet->balance;
        $newBalance = $balance - $amount;

        $data       = json_encode($data);
        $query      = "UPDATE `wallets` SET `balance` = :balance WHERE `id` = :wallet";
        $stmt       = $this->connect()->prepare($query);
        if($stmt->execute(['wallet' => $walletId, 'balance' => $newBalance])){
            $this->saveTransaction('debit', $walletId, $reference, $wallet->user, $data, $amount, $balance, $newBalance, 'successful');
            $result = "success";
        }else{
            $result = "error";
        }

        return $result;
    }

    public function createStore($name, $phone, $email, $address, $country, $currency, $owner)
    {
        $query  = "INSERT INTO `stores`(`name`, `phone`, `email`, `address`, `country`, `currency`, `owner`) 
                                VALUES (:name, :phone, :email, :address, :country, :currency, :owner)";
        $stmt   = $this->connect()->prepare($query);
        if($stmt->execute(['name' => $name, 'phone' => $phone, 'email' => $email, 'address' => $address, 'country' => $country, 'owner' => $owner, 'currency' => $currency])){
            $result = "success";
        }else{
            $result = "error";
        }

        return $result;
    } 

    public function getStores(array $options)
    {
        if (count($options) > 0) { // Check if WHERE fields are assigned
            $query  = "SELECT * FROM `stores` WHERE ";
            $parts = array();
            foreach ($options as $key => $value) { // loop through the arrays and set the conditions
                $parts[] = "`" . $key . "` = '$value' ";
            }
            $query  = $query . implode(" AND ", $parts);
        } else { // or just fetch all Stores
            $query  = "SELECT * FROM `stores`";
        }
        $stmt   = $this->connect()->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
        } else {
            $result = "404";
        }

        return $result;
    }

    public function getStore(array $options){
        $query  = "SELECT * FROM `stores` WHERE ";
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

    public function updateStore($store, array $options){
        $query  = "UPDATE `stores` SET `updated_at` = NOW(), ";
        $parts = array();
        foreach ($options as $key => $value) { // loop through the array and set the conditions
            $parts[] = "`" . $key . "` = '$value' WHERE `id` = :store";
        }
        $query  = $query . implode(", ", $parts);

        $stmt   = $this->connect()->prepare($query);
        if($stmt->execute(['store' => $store])){
            $result = "success";
        }else{
            $result = "error";
        }

        return $result;
    }

    public function addProduct($name, $description, $price, $tax = 0, $quantity, $store)
    {
        $query  = "INSERT INTO `products`(`title`, `description`, `price`, `tax`, `quantity`, `store`) 
                                VALUES (:name, :description, :price, :tax, :quantity, :store)";
        $stmt   = $this->connect()->prepare($query);
        if($stmt->execute(['name' => $name, 'description' => $description, 'price' => $price, 'tax' => $tax, 'quantity' => $quantity, 'store' => $store])){
            $result = "success";
        }else{
            $result = "error";
        }

        return $result;
    } 

    public function getProducts(array $options)
    {
        if (count($options) > 0) { // Check if WHERE fields are assigned
            $query  = "SELECT * FROM `products` WHERE ";
            $parts = array();
            foreach ($options as $key => $value) { // loop through the arrays and set the conditions
                $parts[] = "`" . $key . "` = '$value' ";
            }
            $query  = $query . implode(" AND ", $parts);
        } else { // or just fetch all Stores
            $query  = "SELECT * FROM `products`";
        }
        $stmt   = $this->connect()->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
        } else {
            $result = "404";
        }

        return $result;
    }

    public function getProduct(array $options){
        $query  = "SELECT * FROM `products` WHERE ";
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

    public function updateProduct($store, array $options){
        $query  = "UPDATE `products` SET `updated_at` = NOW(), ";
        $parts = array();
        foreach ($options as $key => $value) { // loop through the array and set the conditions
            $parts[] = "`" . $key . "` = '$value' WHERE `id` = :store";
        }
        $query  = $query . implode(", ", $parts);

        $stmt   = $this->connect()->prepare($query);
        if($stmt->execute(['store' => $store])){
            $result = "success";
        }else{
            $result = "error";
        }

        return $result;
    }
}