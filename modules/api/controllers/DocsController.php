<?php

namespace app\modules\api\controllers;

use app\models\AppUser;
use app\models\Availability;
use app\models\Booking;
use app\models\BookingReports;
use app\models\BookingService;
use app\models\BookingType;
use app\models\CarDetails;
use app\models\Feedback;
use app\models\PaymentDetails;
use Yii;
use yii\helpers\Json as Json;
use yii\helpers\Url as Url;

class DocsController extends \yii\web\Controller
{
    public $defaultResponseParams;

    public function init()
    {
        parent::init();
        $this->defaultResponseParams = [
            "parameters" => [
                'result' => '<b>success</b>,<b>error</b>',
                'status' => 'Request Status Code',
                'message' => 'Request Status Description',
                'data' => [
                    '<span class="label label-success">String</span>' => 'Server proccessing results (optional)'
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $methods = [
            'Oauth: user authentication and access/refresh tokens' =>
                ['api_url' => $this->route('oauth2', true), 'docs_url' => $this->route('oauth2')],
            'User: user management' =>
                ['api_url' => $this->route('user', true), 'docs_url' => $this->route('user')],
            'Booking: bookings management' =>
                ['api_url' => $this->route('booking', true), 'docs_url' => $this->route('booking')],
            'Payment Details: payment details management' =>
                ['api_url' => $this->route('payment_details', true), 'docs_url' => $this->route('payment_details')],
            'Car Details: car details management' =>
                ['api_url' => $this->route('car_details', true), 'docs_url' => $this->route('car_details')],
            'Booking Reports: booking reports management' =>
                ['api_url' => $this->route('booking_reports', true), 'docs_url' => $this->route('booking_reports')],
            'Feedbacks: booking feedback management' =>
                ['api_url' => $this->route('feedback', true), 'docs_url' => $this->route('feedback')],

        ];
        return $this->render('index', ['data' => $methods]);
    }

    public function route($action, $api = false)
    {

        if ($api) {
            return Url::toRoute('/api/' . $action, true);
        }

        return Url::toRoute(Yii::$app->controller->id . '/' . $action, true);
    }

    public function actionOauth2()
    {

        /* Generate Access Token */

        $parameters1 = [
            'grant_type' => 'Authentication type; <b> password </b>',
            'client_id' => 'Client identification; Supported clients: <b> mobileapp </b>',
            'client_secret' => 'Client secret token; Mobile apps: <b> mobileappsecret </b>',
            'username' => 'User login email',
            'password' => 'User login password',
        ];

        $responseParameters1 = [
            "parameters" => [
                'access_token' => 'Authentication token for user',
                'token_type' => 'Authentication token type',
                'expires_in' => ' Information about when the token will expire (24h)',
                'refresh_token' => 'Token that can be used to get renewed access token (expires in 2419200s)',
                'scope' => 'App which generated the token'

            ],
            "errorParameters" => [
                'error' => 'Error type',
                'error_description' => 'Error Description'
            ]
        ];
        $example1 = "grant_type=password&username=customer1%40gmail.com&password=1&client_id=mobileapp&client_secret=mobileappsecret";
        $responseExample1 = [
            'success' =>
                Json::encode(json_decode('{"access_token":"49b50808aaf0f7be4f8d378b7c2ab5b92edd06b6","expires_in":86400,"token_type":"Bearer","scope":null,"refresh_token":"df656fc287dd3bb007f7de76779e42898cc47371"}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"error":"invalid_client","error_description":"The client credentials are invalid"}'), JSON_PRETTY_PRINT)

        ];

        /* Refresh Token */

        $parameters2 = [
            'grant_type' => 'Authentication type;  <b> refresh_token </b>',
            'refresh_token' => 'Refresh token',
            'client_id' => 'Client identification; Supported clients: <b> mobileapp </b>',
            'client_secret' => 'Client secret token; Mobile apps: <b> mobileappsecret </b>'
        ];

        $example2 = "grant_type=refresh_token&refresh_token=4bb6180b92c03fa42b50bc8ab1ba9dfa9aef88ed&client_id=mobileapp&client_secret=mobileappsecret";
        $responseExample2 = [
            'success' =>
                Json::encode(json_decode('{"access_token":"49b50808aaf0f7be4f8d378b7c2ab5b92edd06b6","expires_in":86400,"token_type":"Bearer","scope":null,"refresh_token":"df656fc287dd3bb007f7de76779e42898cc47371"}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"error":"invalid_client","error_description":"The client credentials are invalid"}'), JSON_PRETTY_PRINT)

        ];

        $token = Yii::$app->api->createDocs('POST', $this->route('oauth2/token', true), $parameters1, $responseParameters1, $example1, $responseExample1, 'application/x-www-form-urlencoded');
        $refreshToken = Yii::$app->api->createDocs('POST', $this->route('oauth2/token', true), $parameters2, $responseParameters1, $example2, $responseExample2, 'application/x-www-form-urlencoded');
        $data = ["Access token" => $token, "Refresh token" => $refreshToken];
        return $this->render('resource_docs', ['data' => $data, 'name' => 'Oauth']);
    }

    public function actionUser()
    {

        /* Create */

        $parametersCreate = Yii::$app->api->docLabels(new AppUser, ['longitude' => false, 'latitude' => false, 'cars' => false, 'payment_details' => false, 'api_endpoint' => false], ['user_id' => ' (optional, if supplied authentication check is performed)', 'password' => ' (raw)', 'telephone' => ' (optional)']);
        $parametersCreate['availability'] = ['<span class="label label-success">Object</span>' => '<span class="text-danger">if user role is <b>washer</b>; Flags: <b>0,1</b></span>'] + Yii::$app->api->docLabels(new Availability, ['user_id' => false, 'availability_id' => false, 'api_endpoint' => false]);

        $exampleCreate = Json::encode(json_decode('{"name":"apiwasher1","email":"apiwasher1@gmail.com","role":"washer","password":"1", "address":"Cerska 30","postcode":"11000"}'), JSON_PRETTY_PRINT);
        $responseExampleCreate = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok"}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"result":"error","status":10000,"message":"Supplied data is not correct.","data":["Postal code and address not correct!"]}'), JSON_PRETTY_PRINT)

        ];

        /* View */

        $responseParametersView = $this->defaultResponseParams;

        $responseParametersView['parameters']['data'] = ['<span class="label label-success">Object</span>' => ''] + Yii::$app->api->docLabels(new AppUser, ['user_id' => true, 'password' => false]);
        $responseParametersView['parameters']['data']['cars'] = ['<span class="label label-success">Array</span>' => '<span class="text-danger">if user role is <b>customer</b></span>'] + Yii::$app->api->docLabels(new CarDetails, ['user_id' => false, 'car_details_id' => false]);
        $responseParametersView['parameters']['data']['payment_details'] = ['<span class="label label-success">Array</span>' => '<span class="text-danger">if user role is <b>customer</b></span>'] + Yii::$app->api->docLabels(new PaymentDetails, ['user_id' => false]);
        $responseParametersView['parameters']['data']['availability'] = ['<span class="label label-success">Object</span>' => '<span class="text-danger">if user role is <b>washer</b>; Flags: <b>0,1</b></span>'] + Yii::$app->api->docLabels(new Availability, ['user_id' => false]);

        $exampleView = "http://kurb.casovi-informatike.rs/api/user";
        $responseExampleView = [
            'success' => [
                '<span class="label label-default"><b>customer</b></span>' =>
                    Json::encode(json_decode('{"result":"success","status":200,"message":"ok","data":{"name":"customer1","email":"customer1@gmail.com","role":"customer","address":"address1","postcode":"11000","telephone":"1","longitude":100.4941285,"latitude":13.8658492,"cars":[{"car_details_id":"1","registration":"123"},{"car_details_id":"2","registration":"456"}],"payment_details":[{"payment_details_id":"2","name":"Visa","expiry_date":"2016-02-26","card_number":"1122334","code":777,"user_id":"20"},{"payment_details_id":"3","name":"mastercard","expiry_date":"2015-11-27","card_number":"555622323","code":333,"user_id":"20"}]}}'), JSON_PRETTY_PRINT),
                '<span class="label label-default"><b>washer</b></span>' =>
                    Json::encode(json_decode('{"result":"success","status":200,"message":"ok","data":{"user_id":"34","name":"washer1","email":"washer1@gmail.com","password":"356a192b7913b04c54574d18c28d46e6395428ab","role":"washer","address":"Knez Mihailova 20","postcode":"11000","telephone":null,"longitude":21.3803735,"latitude":43.9819438,"availability":{"monday":"1","tuesday":"1","wednesday":"1","thursday":"1","friday":"1","saturday":"1","sunday":"1"}}}'), JSON_PRETTY_PRINT)
            ],
            'error' =>
                Json::encode(json_decode('{"result":"error","status":401,"message":"You must be authorized to view this page.","data":[{"error":"invalid_token","error_description":"The access token provided is invalid"}]}'), JSON_PRETTY_PRINT)

        ];

        /* Edit */
        $parametersEdit = Yii::$app->api->docLabels(new AppUser, ['user_id' => false, 'role' => false, 'telephone' => false, 'longitude' => false, 'latitude' => false, 'cars' => false, 'payment_details' => false, 'api_endpoint' => false], ' (optional)');

        $exampleEdit = '{"name":"customer1"}';
        $responseExampleEdit = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok"}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"result":"error","status":10000,"message":"Supplied data is not correct.","data":["Postal code and address not correct!"]}'), JSON_PRETTY_PRINT)

        ];

        /* Payment Details */

        $examplePd = 'http://casovi-informatike.rs/kurb/api/user/payment_details';
        $responseExamplePd = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok","data":[{"payment_details_id":"2","name":"Visa","expiry_date":"2016-02-26","card_number":"1122334","code":777,"user_id":"20"},{"payment_details_id":"3","name":"mastercard","expiry_date":"2015-11-27","card_number":"555622323","code":333,"user_id":"20"}]}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"result":"error","status":401,"message":"You must be authorized to view this page.","data":[{"error":"invalid_token","error_description":"The access token provided is invalid"}]}'), JSON_PRETTY_PRINT)

        ];

        $responseParametersPd = $this->defaultResponseParams;
        $responseParametersPd['parameters']['data'] = ['<span class="label label-success">Array</span>' => ''] + Yii::$app->api->docLabels(new PaymentDetails);

        /* Car Details */

        $exampleCd = 'http://casovi-informatike.rs/kurb/api/user/cars';
        $responseExampleCd = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok","data":[{"car_details_id":"1","registration":"123"},{"car_details_id":"2","registration":"456"}]}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"result":"error","status":401,"message":"You must be authorized to view this page.","data":[{"error":"invalid_token","error_description":"The access token provided is invalid"}]}'), JSON_PRETTY_PRINT)

        ];

        $responseParametersCd = $this->defaultResponseParams;
        $responseParametersCd['parameters']['data'] = ['<span class="label label-success">Array</span>' => ''] + Yii::$app->api->docLabels(new CarDetails, ['user_id' => false, 'booking_id' => false]);

        /* Availability View */

        $exampleAvailabilityView = 'http://casovi-informatike.rs/kurb/api/user/availability';
        $responseExampleAvailabilityView = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok","data":{"availability_id":"1","monday":"0","tuesday":"1","wednesday":"0","thursday":"1","friday":"1","saturday":"1","sunday":"1"}}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"result":"error","status":10002,"message":"Invalid role.","data":[{"error":"invalid_user_dole","error_description":"User with this role does not have requested attributes."}]}'), JSON_PRETTY_PRINT)

        ];

        $responseParametersAvailabilityView = $this->defaultResponseParams;
        $responseParametersAvailabilityView['parameters']['data'] = ['<span class="label label-success">Object</span>' => ''] + Yii::$app->api->docLabels(new Availability);

        /* Availability Update */

        $parametersAvailabilityUpdate = Yii::$app->api->docLabels(new Availability, ['availability_id' => false], ' (optional)');


        $exampleAvailabilityUpdate = 'http://casovi-informatike.rs/kurb/api/user/availability';
        $responseExampleAvailabilityUpdate = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok"}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"result":"error","status":10002,"message":"Invalid role.","data":[{"error":"invalid_user_dole","error_description":"User with this role does not have requested attributes."}]}'), JSON_PRETTY_PRINT)

        ];

        /* Bookings */

        $exampleBookings = 'http://casovi-informatike.rs/kurb/api/user/bookings/&lt;past&gt;';
        $responseExampleBookings = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok","data":[{"booking_id":"12","type_id":"1","service_id":"1","customer_id":"20","washer_id":null,"name":"test","address":"Cerska 30","postcode":"OX49 5NU","telephone":"112233","date":"2015-08-10","time":"13:00:00","status":"completed","longitude":"-1.0699388132","latitude":"51.6562791295","carDetails":[{"car_details_id":"14","user_id":null,"booking_id":"12","registration":"booking test 1"},{"car_details_id":"15","user_id":null,"booking_id":"12","registration":"booking test 2"}]}]}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"result":"error","status":10002,"message":"Invalid role.","data":[{"error":"bad_request","error_description":"Customers do not have invitations."}]}'), JSON_PRETTY_PRINT)

        ];

        $parametersBookings = ["type" => "<b> past, upcoming, invitations </b>"];

        $responseParametersBookings['parameters']['data'] = ['<span class="label label-success">Object</span>' => ''] + Yii::$app->api->docLabels(new Booking, []);
        $responseParametersBookings['parameters']['data']['carDetails'] = ['<span class="label label-success">Array</span>' => ''] + Yii::$app->api->docLabels(new CarDetails, ['user_id' => false]);


        $createUser = Yii::$app->api->createDocs('POST', $this->route('user', true), $parametersCreate, $this->defaultResponseParams, $exampleCreate, $responseExampleCreate);
        $viewUser = Yii::$app->api->createDocs('GET', $this->route('user', true), [], $responseParametersView, $exampleView, $responseExampleView);
        $editUser = Yii::$app->api->createDocs('PUT', $this->route('user', true), $parametersEdit, $this->defaultResponseParams, $exampleEdit, $responseExampleEdit);
        $paymentDetails = Yii::$app->api->createDocs('GET', $this->route('user/payment_details', true), [], $responseParametersPd, $examplePd, $responseExamplePd);
        $carDetails = Yii::$app->api->createDocs('GET', $this->route('user/cars', true), [], $responseParametersCd, $exampleCd, $responseExampleCd);
        $availabilityView = Yii::$app->api->createDocs('GET', $this->route('user/availability', true), [], $responseParametersAvailabilityView, $exampleAvailabilityView, $responseExampleAvailabilityView);
        $availabilityUpdate = Yii::$app->api->createDocs('PUT', $this->route('user/availability', true), $parametersAvailabilityUpdate, $this->defaultResponseParams, $exampleAvailabilityUpdate, $responseExampleAvailabilityUpdate);
        $bookings = Yii::$app->api->createDocs('GET', $this->route('user/bookings/&lt;type&gt;', true), $parametersBookings, $responseParametersBookings, $exampleBookings, $responseExampleBookings);

        $data = ["User Signup" => $createUser, "User Details" => $viewUser, "Edit User Details" => $editUser, "Payment Details" => $paymentDetails, "User Cars" => $carDetails, "User Availability Details" => $availabilityView, "User Availability Details Edit" => $availabilityUpdate, "User Bookings" => $bookings];
        return $this->render('resource_docs', ['data' => $data, 'name' => 'User']);
    }

    public function actionBooking()
    {

        /* Create Booking */

        $parametersCreate = Yii::$app->api->docLabels(new Booking, ['booking_id' => false, 'washer_id' => false, 'api_endpoint' => false], ['customer_id' => ' (optional, if supplied authentication check is performed)']);

        $exampleCreate = Json::encode(json_decode('{"booking_type":"1","booking_service":"1","name":"test","time":"13:00:00","date":"2015-08-12","address":"Cerska 30","postcode":"M32 0JG","telephone":"112233", "cars":[{"registration":"test1"}]}'), JSON_PRETTY_PRINT);
        $responseExampleCreate = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok"}'), JSON_PRETTY_PRINT),
            'errors' => '???' // postcode
        ];

        /* View Booking */

        $responseParametersView = $this->defaultResponseParams;

        $responseParametersView['parameters']['data'] = ['<span class="label label-success">Object</span>' => ''] + Yii::$app->api->docLabels(new Booking);
        $responseParametersView['parameters']['data']['cars'] = ['<span class="label label-success">Array</span>' => ''] + Yii::$app->api->docLabels(new CarDetails);

        $exampleView = "http://kurb.casovi-informatike.rs/api/booking/12";
        $responseExampleView = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok","data":[{"booking_id":"12","type_id":"1","service_id":"1","customer_id":"20","washer_id":null,"name":"test","address":"Cerska 30","postcode":"OX49 5NU","telephone":"112233","date":"2015-08-12","time":"13:00:00","status":"open","longitude":-1.0699388132,"latitude":51.6562791295,"cars":[{"car_details_id":"14","user_id":null,"booking_id":"12","registration":"booking test 1"},{"car_details_id":"15","user_id":null,"booking_id":"12","registration":"booking test 2"}]}]}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"result":"error","status":401,"message":"You must be authorized to view this page.","data":[{"error":"invalid_token","error_description":"The access token provided is invalid"}]}'), JSON_PRETTY_PRINT)

        ];

        /* Booking Types */

        $exampleTypes = 'http://casovi-informatike.rs/kurb/api/booking/types';
        $responseExampleTypes = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok","data":[{"type_id":"1","type":"Advanced","price":"50"},{"type_id":"2","type":"Same-Day","price":"60"}]}'), JSON_PRETTY_PRINT)
        ];

        $responseParametersTypes = $this->defaultResponseParams;
        $responseParametersTypes['parameters']['data'] = ['<span class="label label-success">Array</span>' => ''] + Yii::$app->api->docLabels(new BookingType);

        /* Booking Services */

        $exampleServices = 'http://casovi-informatike.rs/kurb/api/booking/services';
        $responseExampleServices = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok","data":[{"service_id":"1","service":"Exterior only","price":"10"},{"service_id":"2","service":"Exterior and Interior","price":"20"}]}'), JSON_PRETTY_PRINT),

        ];

        $responseParametersServices = $this->defaultResponseParams;
        $responseParametersServices['parameters']['data'] = ['<span class="label label-success">Array</span>' => ''] + Yii::$app->api->docLabels(new BookingService);

        /* Status Change */

        $parametersStatus = ["booking_id" => "Booking ID", "status" => ["Booking Status" => "", "Supported statuses: " => "", "<b>open</b>" => "<i>job is created and washers are selected; no washer accepted job; <br> <span class='text-danger'> this status is set only when booking is created and can not be set explicitly </span></i>  ", "in_progress" => "<i>Job is accepted by washer <br> <span class='text-danger'> only washer can set this status by accepting job </span></i> ", "<b>completed</b>" => "<i>Washer marked job as completed <br> <span class='text-danger'> only washer can mark job as completed </span></i>", "<b> confirmed</b>" => "<i> Customer confirmed job is completed and payment is processed <br> <span class='text-danger'> only customer can confirm job is completed </span></i> "]];

        $exampleStatus = '{"status":"in_progress", "booking_id":"14"}';
        $responseExampleStatus = [
            'success' =>
                Json::encode(json_decode('{"result":"success","status":200,"message":"ok"}'), JSON_PRETTY_PRINT),
            'error' =>
                Json::encode(json_decode('{"result":"error","status":10003,"message":"Invalid operation.","data":[{"error":"invalid_operation","error_description":"Booking invitation is no longer active."}]}'), JSON_PRETTY_PRINT)

        ];


        $createBooking = Yii::$app->api->createDocs('POST', $this->route('booking', true), $parametersCreate, $this->defaultResponseParams, $exampleCreate, $responseExampleCreate);
        $viewBooking = Yii::$app->api->createDocs('GET', $this->route('booking/&lt;booking_id&gt;', true), [], $responseParametersView, $exampleView, $responseExampleView);
        $types = Yii::$app->api->createDocs('GET', $this->route('booking/types', true), [], $responseParametersTypes, $exampleTypes, $responseExampleTypes);
        $services = Yii::$app->api->createDocs('GET', $this->route('booking/services', true), [], $responseParametersServices, $exampleServices, $responseExampleServices);
        $statusUpdate = Yii::$app->api->createDocs('PUT', $this->route('booking/status', true), $parametersStatus, $this->defaultResponseParams, $exampleStatus, $responseExampleStatus);

        $data = ["Create Booking" => $createBooking, "Booking Details" => $viewBooking, "Available booking types" => $types, "Available booking services" => $services, "Booking Status Update" => $statusUpdate];
        return $this->render('resource_docs', ['data' => $data, 'name' => 'Booking']);
    }

    public function actionPayment_details()
    {

        $data = PaymentDetails::createDocs();
        return $this->render('resource_docs', ['data' => $data, 'name' => 'Payment Details']);

    }

    public function actionBooking_reports()
    {
        $data = BookingReports::createDocs();
        return $this->render('resource_docs', ['data' => $data, 'name' => 'Booking Report']);
    }

    public function actionCar_details()
    {
        $data = CarDetails::createDocs();
        return $this->render('resource_docs', ['data' => $data, 'name' => 'Car Details']);
    }

    public function actionFeedback()
    {
        $data = Feedback::createDocs(false);
        return $this->render('resource_docs', ['data' => $data, 'name' => 'Feedback']);
    }


}
