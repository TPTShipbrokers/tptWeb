<?php

namespace app\components;

use app\models\CronJobs;
use Yii;
use yii\base\Component;

class Utils extends Component
{
    public $GoogleAuthCode;
    public $GoogleAccessToken;

    public function createCron($date, $command, $param)
    {
        // Obrisi postojece cron jobs
        // Kreiraj cron job u bazi
        // izlistaj sve cron jobs iz baze i ubaci u crontab

        $output = shell_exec('crontab -l');
        $lines = '';
        //   shell_exec('crontab -u apache -r');
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $output) as $line) {

            $pattern = '/^\d\d\s\d\d\s\d\d\s\d\d\s\*\s+php\s+\/var\/www\/html\/borne.io\/tpt\/yii.*/';
            // 30 12 23 03 *  php /var/www/html/borne.io/tpt/yii cron/subs 18 >/dev/null 2>&1

            preg_match($pattern, $line, $matches);

            if (empty($matches) && !empty($line)) {

                $lines .= $line . PHP_EOL;
            }
        }


        $oldCron = CronJobs::find()->where(['chartering_id' => $param])->one();
        if ($oldCron)
            $oldCron->tryDeleteGeneral();

        $model = new CronJobs;
        $model->executed_at = null;
        $model->succeeded = 1;
        $model->action = 'cron job created';
        $model->parameters = $command;
        $model->chartering_id = $param;
        $model->datetime = $date;

        $model->trySaveGeneral();

        $cronJobs = CronJobs::find()->all();

        $uniqid = uniqid();

        foreach ($cronJobs as $cron) {
            $date = date("y-m-d H:i:s", strtotime($model->datetime) - 60 * 60 * 4);

            $min = date("i", strtotime($date));
            $hour = date("H", strtotime($date));
            $day = date("d", strtotime($date));
            $month = date("m", strtotime($date));

            $result = file_put_contents("/tmp/crontab" . $uniqid . ".txt", $lines . "$min $hour $day $month *  php /var/www/html/borne.io/tpt/yii " . $command . " >/dev/null 2>&1" . PHP_EOL);
        }


        exec('crontab /tmp/crontab' . $uniqid . ".txt");

    }

    public function deleteCron($date, $command, $param = null)
    {
        $output = shell_exec('crontab -l');
        $lines = '';

        foreach (preg_split("/((\r?\n)|(\r\n?))/", $output) as $line) {

            $pattern = '/^\d\d\s\d\d\s\d\d\s\d\d\s\*\s+php\s+\/var\/www\/html\/borne.io\/tpt\/yii\s+cron\/subs\s+' . $param . '.*/';
            // 30 12 23 03 *  php /var/www/html/borne.io/nurture/yii cron/activity 18 >/dev/null 2>&1

            preg_match($pattern, $line, $matches);

            if (empty($matches) && !empty($line)) {

                $lines .= $line . PHP_EOL;
            }
        }

        $uniqid = uniqid();

        $result = file_put_contents("/tmp/crontab" . $uniqid . ".txt", $lines);


        exec('crontab /tmp/crontab' . $uniqid . ".txt");
    }


    function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    public function checkExistence($record, $return = false)
    {
        if (!$record) {
            return Yii::$app->api->_sendResponse(200, ['error' => 'invalid_data', 'error_description' => 'No entry matching requested record.'], false, $return);
        }

        return ["result" => "success"];
    }

    function generatePassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if (strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if (!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public function saveFile($req_data, $filename)
    {

        if (!isset($req_data['name']) || !isset($req_data['file'])) {
            return Yii::$app->api->_sendResponse(200, ['error' => 'invalid_user_data', 'error_description' => 'User data malformed! Required fields: name, file'], false);
        }


        $fp = fopen($filename, "w");
        fwrite($fp, $req_data['file']);
        fclose($fp);
    }

    public function sendFile($file)
    {
        header('Content-Description: File Transfer');
        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        die();
    }
}

