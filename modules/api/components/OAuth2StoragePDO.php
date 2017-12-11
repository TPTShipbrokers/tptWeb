<?php

namespace app\modules\api\components;

/**
 * Class OAuth2StoragePDO
 * @package app\modules\api\components
 */
class OAuth2StoragePDO extends \OAuth2\Storage\Pdo
{
    /**
     * @param $username
     * @return array|bool
     */
    public function getUser($username)
    {
        $stmt = $this->db->prepare($sql = sprintf('SELECT * from %s where email=:email', $this->config['user_table']));
        $stmt->execute(['email' => $username]);
        if (!$userInfo = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return false;
        }
        // the default behavior is to use "username" as the user_id
        return array_merge([
            'user_id' => $username
        ], $userInfo);
    }

    /**
     * @param $username
     * @param $password
     * @param null $firstName
     * @param null $lastName
     * @return bool
     */
    public function setUser($username, $password, $firstName = null, $lastName = null)
    {
        // do not store in plaintext
        $password = sha1($password);
        // if it exists, update it.
        if ($this->getUser($username)) {
            $stmt = $this->db->prepare($sql = sprintf('UPDATE %s SET password=:password, first_name=:firstName, last_name=:lastName where email=:username',
                $this->config['user_table']));
        } else {
            $stmt = $this->db->prepare(sprintf('INSERT INTO %s (email, password, first_name, last_name) VALUES (:username, :password, :firstName, :lastName)',
                $this->config['user_table']));
        }
        return $stmt->execute(compact('username', 'password', 'firstName', 'lastName'));
    }
}