<?php
class Auth_Token extends Db
{
    public function validateToken($userId, $token)
    {
        try {
            $sql = "SELECT * FROM user_tokens WHERE user_id = :user_id AND token = :token LIMIT 01";

            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([
                "user_id" => $userId,
                "token"   => $token
            ]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
