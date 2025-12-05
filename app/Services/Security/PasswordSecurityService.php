<?php

namespace App\Services\Security;

/**
 * Service dedicated to password security validation.
 *
 * This class is intentionally incomplete.
 * Students will implement ANSSI password rules here.
 */
class PasswordSecurityService
{
    /**
     * Validate password strength according to ANSSI.
     *
     * TODO (students):
     *  - Min length >= 12
     *  - Uppercase letter
     *  - Lowercase letter
     *  - Digit
     *  - Special character
     *  - Reject common passwords
     *
     * Current behavior → weak validation (voluntary...).
     */
    public function validatePasswordStrength(string $password): bool
    {

        return strlen($password) >= 8;
    }
}
