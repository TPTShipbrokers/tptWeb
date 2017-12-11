<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\Model;

/**
 * Class Api
 * @package app\components
 */
class Api extends Component
{
    public $publicRoutes = [
        'user/team' => ['GET'],
    ];

    /**
     * @param $raw_data
     * @return array
     */
    public static function parseFormData($raw_data)
    {
        //    $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

        // Fetch each part
        $parts = array_slice(explode('---b---', $raw_data), 1);
        $data = [];

        foreach ($parts as $part) {
            // If this is the last part, break
            if ($part == "--\r\n") break;

            // Separate content from headers
            $part = ltrim($part, "\r\n");
            list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

            // Parse the headers list
            $raw_headers = explode("\r\n", $raw_headers);
            $headers = [];
            foreach ($raw_headers as $header) {
                list($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }

            // Parse the Content-Disposition to get the field name, etc.
            if (isset($headers['content-disposition'])) {
                $filename = null;
                preg_match(
                    '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                list(, $type, $name) = $matches;
                isset($matches[4]) and $filename = $matches[4];

                // handle your fields here
                switch ($name) {
                    // this is a file upload
                    case 'userfile':
                        file_put_contents($filename, $body);
                        break;

                    // default for all other files is to populate $data
                    default:
                        $data[$name] = substr($body, 0, strlen($body) - 2);
                        break;
                }
            }

        }

        return $data;
    }

    /**
     * @param $requestData
     * @return array
     */
    public function processRequest($requestData)
    {

        $request = Yii::$app->request;

        if ($request->getIsPost()) {
            return $this->handlePost('create', ['json' => $requestData]);
        } elseif ($request->getIsPut()) {
            return $this->handlePut('edit', ['json' => $requestData]);
        } elseif ($request->getIsGet()) {
            return ['action' => "viewRecord"];
        } elseif ($request->getIsDelete()) {
            return $this->handleDelete('delete', ['json' => $requestData]);
        }
    }

    /**
     * @param $action
     * @param array $data
     * @return array
     */
    public function handlePost($action, $data = [])
    {

        $json = file_get_contents('php://input');

        if (empty($json)) {
            $json = $data['json'];
        }

        $obj = json_decode($json, true);

        return ['action' => "createRecord", 'object' => $obj];

    }

    /**
     * @param $action
     * @param array $data
     * @return array
     */
    public function handlePut($action, $data = [])
    {
        $json = file_get_contents('php://input');
        if (empty($json)) {
            $json = $data['json'];
        }

        $obj = json_decode($json, true);

        return ['action' => "updateRecord", 'object' => $obj];
    }

    /**
     * @param $action
     * @param array $data
     * @return array
     */
    public function handleDelete($action, $data = [])
    {
        $json = file_get_contents('php://input');
        if (empty($json)) {
            $json = $data['json'];
        }

        $obj = json_decode($json, true);

        return ['action' => "deleteRecord", 'object' => $obj];
    }

    /**
     * @param int $status
     * @param string $data
     * @param bool $success
     * @param bool $return
     * @return array
     */
    public function _sendResponse($status = 200, $data = '', $success = true, $return = false)
    {
        $content_type = 'application/json';

        if ($success) {
            $result = 'success';
            $message = 'ok';

        } else {
            $message = '';

            switch ($status) {
                case 200:
                    $message = isset($data['error']) && $data['error'] ? $data['error'] : (isset($data['error_description']) && $data['error_description'] ? $data['error_description'] : "The server encountered an error processing your request.");
                    break;
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
                case 10000:
                    $message = 'Supplied data is not correct.';
                    break;
                case 10001:
                    $message = 'Data malformed.';
                    break;
                case 10002:
                    $message = 'Invalid role.';
                    break;
                case 10003:
                    $message = 'Invalid operation.';
                    break;
            }

            $result = 'error';

            // servers don't always have a signature turned on
            // (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

        }


        $arr = ['result' => $result, 'status' => $status, 'message' => $message];

        if ($data != '' && !$success) {
            $arr['data']['error_description'] = $data['error_description'];
        } else if ($data) {
            $arr['data'] = $data;
        }


        if ($return) {
            return $arr;
        } else {
            $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
            header($status_header);
            header('Content-type: ' . $content_type);
            echo json_encode($arr);
        }
        exit();
    }

    /**
     * @param $status
     * @return mixed|string
     */
    private function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... 
        $codes = [
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        ];
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /**
     * @param $errors
     * @return array
     */
    public function processErrors($errors)
    {

        $res = [];

        if (is_array($errors)) {
            foreach ($errors as $key => $value) {
                if (is_array($value))
                    $res[] = $value[0];
                else
                    $res[] = $value;
            }
        } else
            $res[] = $errors;

        return $res;
    }

    /**
     * @param $method
     * @param $route
     * @param $parameters
     * @param $responseParameters
     * @param $example
     * @param $responseExample
     * @param string $contentType
     * @param string $responseContentType
     * @return array
     */
    public function createDocs($method, $route, $parameters, $responseParameters, $example, $responseExample, $contentType = 'application/json', $responseContentType = 'application/json')
    {
        $request = [

            'request' => [
                'Method' => $method,
                'Content-Type' => $contentType,
                'Authorization' => 'Bearer &lt;access_token&gt;',
                'Url' => $route,
                'Parameters' => $parameters
            ],
            'response' => [
                'Content-Type' => $responseContentType,
                'Parameters' => $responseParameters['parameters'],
                'Error Parameters' => $responseParameters['errorParameters'],
            ],
            'examples' => [
                'Request' => $example,
                'Response' => $responseExample['success'],
                'Error' => $responseExample['error']

            ]
        ];

        if ($this->checkPublicActions()) {
            unset($request['request']['Authorization']);
        }

        return $request;
    }

    /**
     * @return bool
     */
    public function checkPublicActions()
    {
        $action = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
        $pub = $this->publicRoutes;
        $publicRoutes = in_array($action, array_keys($pub));

        $method = $pub[$action] && in_array(Yii::$app->request->method, $pub[$action]);

        return $publicRoutes && $method;


    }

    /**
     * @param Model $model
     * @param array $display
     * @param bool $suffixes
     * @param bool $prefixes
     * @return mixed
     */
    public function docLabels($model, $display = [], $suffixes = false, $prefixes = false)
    {

        $labels = $model->attributeLabels();

        foreach ($labels as $key => $value) {


            if (is_array($suffixes) && isset($suffixes[$key])) {
                $labels[$key] = $labels[$key] . $suffixes[$key];
            } else if (!is_array($suffixes) && $suffixes) {
                $labels[$key] = $labels[$key] . $suffixes;
            }

            if (is_array($prefixes) && isset($prefixes[$key])) {
                $labels[$key] = $prefixes[$key] . $labels[$key];
            } else if (!is_array($prefixes) && $prefixes) {
                $labels[$key] = $prefixes . $labels[$key];
            }

            if (isset($display[$key]) && !$display[$key]) {
                unset($labels[$key]);
            }

        }
        return $labels;

    }

    /**
     * @param $v
     */
    public function displayFormat($v)
    {
        if (!is_array($v)) {

            echo "<div class='col-md-8'>$v</div>";

        } else {
            echo '<div class="col-md-10 pull-right"><div class="well">';


            foreach ($v as $k1 => $v1) {
                echo "<div class='row padtb5'><div class='col-md-4'><b>$k1</b></div>";
                $this->displayFormat($v1);
                echo '</div>';
            }
            echo '</div></div>';
        }
    }

    /**
     * @param $notif
     * @param $emails
     * @return mixed
     */
    public function send_push_notification($notif, $emails)
    {
        $APPLICATION_ID = "oZMGHWT4yPLp5kDpOMMsbmvPOBrH54rDYuJrC39m";
        $REST_API_KEY = "tFe4JTjhPw8Q7QMVonDwWHdNfRRsdp0DD7Yc3g8l";
        $MESSAGE = $notif;

        $url = 'https://api.parse.com/1/push';
        $data = [
            'where' => [
                'email' => ['$in' => $emails]
            ],
            'data' => [
                'alert' => $MESSAGE,
                "badge" => "Increment",
                "sound" => "default",
            ],
        ];

        $_data = json_encode($data);
        $headers = [
            'X-Parse-Application-Id: ' . $APPLICATION_ID,
            'X-Parse-REST-API-Key: ' . $REST_API_KEY,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($_data),
        ];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $_data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        $response = json_decode($response);

        if (isset($response->error)) {
            return Yii::$app->api->_sendResponse(200, ['error' => 'Parse error', 'error_description' => $response->error], false);
        } else
            return $response->result;
    }

}

