<?php
class Validator
{
    //check if the field is empty
    public static function isEmpty($field): bool
    {
        return empty($field);
    }

    //validate the email
    public static function isValidEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    //validate the contact number
    public static function isValidContactNo($mobile): bool
    {
        return preg_match('/^[0][0-9]{9}$/', $mobile);
    }

    //validate the name
    public static function isValidName($name): bool
    {
        return preg_match('/^[a-zA-Z\s]+$/', $name);
    }

    //validate the company name
    public static function isValidCompanyName($companyName): bool
    {
        return preg_match('/^[a-zA-Z0-9\s\-\.\&\,\'\(\)\/\+]+$/', $companyName);
    }


    //validate the password
    public static function isValidPassword($password): bool
    {
        return strlen($password) >= 8 &&
            preg_match('/[a-z]/', $password) &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[0-9]/', $password);
    }

    //validate the confirm password
    public static function isValidConfirmPassword($password, $confirmPassword): bool
    {
        return $password === $confirmPassword;
    }

    //validate the birthdate
    public static function isValidBirthdate($birthdate): bool
    {
        $today = new DateTime();
        $dob = new DateTime($birthdate);
        $age = $today->diff($dob)->y;
        return $age >= 18;
    }

    //validate the NIC
    public static function isValidNIC($nic): bool
    {
        return preg_match('/^[0-9]{9}[vVxX]$/', $nic) || preg_match('/^[0-9]{12}$/', $nic);
    }

    //validate the role
    public static function isValidRole($role): bool
    {
        return in_array($role, ['Admin', 'VT-Member', 'Company', 'Student']);
    }

    //validate the status
    public static function isValidStatus($status): bool
    {
        return in_array($status, ['Pending', 'Active', 'Deactivate', 'Not Approved']);
    }

    //validate the gender
    public static function isValidGender($gender): bool
    {
        return in_array($gender, ['Male', 'Female']);
    }

    //validate the terms and conditions
    public static function isValidTerms($terms): bool
    {
        return $terms === 'accepted';
    }

    //validate the website
    public static function isValidWebsite($website): bool
    {
        return filter_var($website, FILTER_VALIDATE_URL);
    }

    //validate the registration data
    public static function isValidRegistrationData(array $data): array
    {
        $errors = [];

        if (self::isEmpty($data['email'])) {
            $errors['email_err'] = 'Email is required';
        } else if (!self::isValidEmail($data['email'])) {
            $errors['email_err'] = 'Invalid email format';
        }

        if (self::isEmpty($data['password'])) {
            $errors['password_err'] = 'Password is required';
        } else if (!self::isValidPassword($data['password'])) {
            $errors['password_err'] = 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number';
        }

        if (self::isEmpty($data['confirm_password'])) {
            $errors['confirm_password_err'] = 'Confirm password is required';
        } else if (!self::isValidConfirmPassword($data['password'], $data['confirm_password'])) {
            $errors['confirm_password_err'] = 'Passwords do not match';
        }

        if (self::isEmpty($data['role'])) {
            $errors['role_err'] = 'Role is required';
        } else if (!self::isValidRole($data['role'])) {
            $errors['role_err'] = 'Invalid role';
        }

        if (self::isEmpty($data['status'])) {
            $errors['status_err'] = 'Status is required';
        } else if (!self::isValidStatus($data['status'])) {
            $errors['status_err'] = 'Invalid status';
        }

        if (self::isEmpty($data['contactNo'])) {
            $errors['contactNo_err'] = 'Contact number is required';
        } else if (!self::isValidContactNo($data['contactNo'])) {
            $errors['contactNo_err'] = 'Invalid contact number';
        }

        // Check if the data is for a student
        if ($data['role'] === 'Student') {
            if (self::isEmpty($data['firstName'])) {
                $errors['firstName_err'] = 'First name is required';
            } else if (!self::isValidName($data['firstName'])) {
                $errors['firstName_err'] = 'First name can only contain letters and spaces';
            }

            if (self::isEmpty($data['lastName'])) {
                $errors['lastName_err'] = 'Last name is required';
            } else if (!self::isValidName($data['lastName'])) {
                $errors['lastName_err'] = 'Last name can only contain letters and spaces';
            }

            if (self::isEmpty($data['gender'])) {
                $errors['gender_err'] = 'Gender is required';
            } else if (!self::isValidGender($data['gender'])) {
                $errors['gender_err'] = 'Invalid gender';
            }

            if (self::isEmpty($data['dob'])) {
                $errors['dob_err'] = 'Date of birth is required';
            } else if (!self::isValidBirthdate($data['dob'])) {
                $errors['dob_err'] = 'You must be at least 18 years old';
            }

            if (self::isEmpty($data['nicNo'])) {
                $errors['nicNo_err'] = 'NIC number is required';
            } else if (!self::isValidNIC($data['nicNo'])) {
                $errors['nicNo_err'] = 'Invalid NIC number';
            }

            if (self::isEmpty($data['nicCopy'])) {
                $errors['nicCopy_err'] = 'NIC copy is required';
            }

            if (self::isEmpty($data['university'])) {
                $errors['university_err'] = 'University is required';
            }

            if (self::isEmpty($data['universityID'])) {
                $errors['universityID_err'] = 'University ID is required';
            }

            if (self::isEmpty($data['universityIDCopy'])) {
                $errors['universityIDCopy_err'] = 'University ID copy is required';
            }

            if (self::isEmpty($data['streetNo'])) {
                $errors['streetNo_err'] = 'Street number is required';
            }

            if (self::isEmpty($data['addressLine1'])) {
                $errors['addressLine1_err'] = 'Address line 1 is required';
            }

            if (self::isEmpty($data['city'])) {
                $errors['city_err'] = 'City is required';
            }

            if (self::isEmpty($data['terms'])) {
                $errors['terms_err'] = 'You must accept the terms and conditions';
            } else if (!self::isValidTerms($data['terms'])) {
                $errors['terms_err'] = 'You must accept the terms and conditions';
            }
        }

        // Check if the data is for a company
        if ($data['role'] === 'Company') {
            if (self::isEmpty($data['companyName'])) {
                $errors['companyName_err'] = 'Company name is required';
            } else if (!self::isValidCompanyName($data['companyName'])) {
                $errors['companyName_err'] = 'Company name can only contain letters, numbers, and spaces';
            }

            if (self::isEmpty($data['streetNo'])) {
                $errors['streetNo_err'] = 'Street number is required';
            }

            if (self::isEmpty($data['addressLine1'])) {
                $errors['addressLine1_err'] = 'Address line 1 is required';
            }

            if (self::isEmpty($data['cityID'])) {
                $errors['city_err'] = 'City is required';
            }

            if (self::isEmpty($data['industryID'])) {
                $errors['industry_err'] = 'Industry is required';
            }

            if (self::isEmpty($data['terms'])) {
                $errors['terms_err'] = 'You must accept the terms and conditions';
            } else if (!self::isValidTerms($data['terms'])) {
                $errors['terms_err'] = 'You must accept the terms and conditions';
            }
        }

        //check if the data is for a VT-Member
        if ($data['role'] === 'VT-Member') {
            if (self::isEmpty($data['firstName'])) {
                $errors['firstName_err'] = 'First name is required';
            } else if (!self::isValidName($data['firstName'])) {
                $errors['firstName_err'] = 'First name can only contain letters and spaces';
            }

            if (self::isEmpty($data['lastName'])) {
                $errors['lastName_err'] = 'Last name is required';
            } else if (!self::isValidName($data['lastName'])) {
                $errors['lastName_err'] = 'Last name can only contain letters and spaces';
            }
        }

        // If there are no errors, return true; otherwise, return the errors
        return empty($errors) ? ['is_valid' => true] : ['is_valid' => false, 'error' => $errors];
    }

    //validate the edit profile data
    public static function isValidEditProfileData(array $data): array
    {
        $errors = [];

        if (self::isEmpty($data['contactNo'])) {
            $errors['contactNo_err'] = 'Contact number is required';
        } else if (!self::isValidContactNo($data['contactNo'])) {
            $errors['contactNo_err'] = 'Invalid contact number';
        }

        if ($data['role'] === 'Student') {

            if (self::isEmpty($data['firstName'])) {
                $errors['firstName_err'] = 'First name is required';
            } else if (!self::isValidName($data['firstName'])) {
                $errors['firstName_err'] = 'First name can only contain letters and spaces';
            }

            if (self::isEmpty($data['lastName'])) {
                $errors['lastName_err'] = 'Last name is required';
            } else if (!self::isValidName($data['lastName'])) {
                $errors['lastName_err'] = 'Last name can only contain letters and spaces';
            }

            if (self::isEmpty($data['streetNo'])) {
                $errors['streetNo_err'] = 'Street number is required';
            }

            if (self::isEmpty($data['addressLine1'])) {
                $errors['addressLine1_err'] = 'Address line 1 is required';
            }

            if (self::isEmpty($data['city'])) {
                $errors['city_err'] = 'City is required';
            }
        } else if ($data['role'] === 'Company') {

            if (self::isEmpty($data['companyName'])) {
                $errors['companyName_err'] = 'Company name is required';
            } else if (!self::isValidCompanyName($data['companyName'])) {
                $errors['companyName_err'] = 'Company name can only contain letters, numbers, and spaces';
            }

            if (self::isEmpty($data['streetNo'])) {
                $errors['streetNo_err'] = 'Street number is required';
            }

            if (self::isEmpty($data['addressLine1'])) {
                $errors['addressLine1_err'] = 'Address line 1 is required';
            }

            if (self::isEmpty($data['cityID'])) {
                $errors['city_err'] = 'City is required';
            }
        }

        // If there are no errors, return true; otherwise, return the errors
        return empty($errors) ? ['is_valid' => true] : ['is_valid' => false, 'error' => $errors];
    }
}
