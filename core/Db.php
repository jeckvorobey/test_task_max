<?php

namespace core;

use PDO;
use PDOException;
use core\Error;

class Db
{
    private static $_instance = null;

    private $db; // Ресурс работы с БД

    /**
     * Получаем объект для работы с БД
     */
    public static function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new Db();
        }
        return self::$_instance;
    }

    /**
     * Запрещаем копировать объект
     */
    private function __construct()
    {
    }
    private function __sleep()
    {
    }
    private function __wakeup()
    {
    }
    private function __clone()
    {
    }

    /**
     * Выполняем соединение с базой данных
     */
    public function Connect($user, $password, $base, $host, $port)
    {
        try {
            // Формируем строку соединения с сервером
            $connectString = 'mysql:host=' . $host . ';port= ' . $port . ';dbname=' . $base . ';charset=UTF8;';
            $this->db = new PDO(
                $connectString,
                $user,
                $password,
                [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // возвращать ассоциативные массивы
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // возвращать Exception в случае ошибки
            ]
            );
        } catch (PDOException $e) {
            new Error();
            die;
        }
    }

    /**
     * Выполнить запрос к БД
     */
    public function Query($query, $params = [])
    {
        $res = $this->db->prepare($query);
        $res->execute($params);
        return $res;
        $this->db->close();
    }

    /**
     * Выполнить запрос с выборкой данных
     */
    public function Select($query, $params = [])
    {
        $result = $this->Query($query, $params);
        if ($result) {
            return $result->fetchAll();
            $this->db->close();
        }
    }
}
