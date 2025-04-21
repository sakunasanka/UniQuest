<? class LoginModel extends Model
{
    public function findUserByEmail($email)
    {
        try {
            $user = $this->select('user', [['Email', "=", $email]]);
            if ($user && $user->Status !== 'Deleted') {
                return $user;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function login($email, $password)
    {
        try {
            $user = $this->findUserByEmail($email);
            if ($user) {
                if (password_verify($password, $user->Password)) {
                    return $user;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    //add login log
    public function addLoginLog($userId, $status, $reason)
    {
        try {
            $this->insert('user_login_activity', [
                'UserId' => $userId,
                'LoginStatus' => $status,
                'Reason' => $reason,
                'LoginTime' => date('Y-m-d H:i:s')
            ]);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
        }
    }

    //update user last login time
    public function updateLastLogin($userId)
    {
        try {
            $this->update('user', ['LastLogin' => date('Y-m-d H:i:s')], [['UserId', '=', $userId]]);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
        }
    }
}
