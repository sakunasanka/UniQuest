
<?php
class Validator {
    //check if the field is empty
    public static function isEmpty($field) {
        return empty($field);
    }

    //validate the email
    public static function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    //validate the contact number
    public static function isValidContactNo($mobile) {
        return preg_match('/^[0][0-9]{9}$/', $mobile);
    }

    //validate the name
    public static function isValidName($name) {
        return preg_match('/^[a-zA-Z\s]+$/', $name);
    }

    //validate the password
    public static function isValidPassword($password) {
        return strlen($password) >= 8 &&
               preg_match('/[a-z]/', $password) &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[0-9]/', $password);
    }

    //validate the confirm password
    public static function isValidConfirmPassword($password, $confirmPassword) {
        return $password === $confirmPassword;
    }

    //validate the birthdate
    public static function isValidBirthdate($birthdate) {
        $today = new DateTime();
        $dob = new DateTime($birthdate);
        $age = $today->diff($dob)->y;
        return $age >= 18;
    }

    //validate the NIC
    public static function isValidNIC($nic) {
        return preg_match('/^[0-9]{9}[vVxX]$/', $nic) || preg_match('/^[0-9]{12}$/', $nic);
    }

    //validate the role
    public static function isValidRole($role) {
        return $role === 'Admin' || 
            $role === 'VT-Member' ||
            $role === 'Company' ||
            $role === 'Student';
    }

    //validate the status
    public static function isValidStatus($status) {
        return $status === 'Pending' || 
            $status === 'Active' ||
            $status === 'Deactivate' ||
            $status === 'Not Approved';  
    }

}
