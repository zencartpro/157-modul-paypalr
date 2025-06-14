<?php
/**

 * Zen Cart German Specific (158 code in 157 / zencartpro adaptations)
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: admin_access.php for paypalr 2025-06-07 19:46:21Z webchills $
 */

if (!defined('ADMIN_PASSWORD_MIN_LENGTH')) define('ADMIN_PASSWORD_MIN_LENGTH', 7);
/**
 * Checks whether the currently logged on user has permission to access
 * the page passed as parameter $page, with GET $params . The function returns boolean
 * true if the user is allowed access to the page, and boolean false otherwise.
 * @param string $page FILENAME_XYZ page name
 * @param array $params
 * @return bool
 */
function check_page($page, $params = [])
{
    global $db;
    if (!isset($_SESSION['admin_id'])) return false;
    
    $page_params = '';
    // Most entries (normal case) have their own pages. However, everything on the Configuration
    // and Modules menus are handled by the single pages configuration.php and modules.php. So for
    // these pages we check their respective get params too.
    if (!empty($params)) {
        if ($page == 'modules') {
            $page_params = 'set=' . $params['set'];
        }
        if ($page == 'configuration') {
            $page_params = 'gID=' . $params['gID'];
        }
    }

    $sql = "SELECT ap.main_page, ap.page_params
            FROM " . TABLE_ADMIN . " a
            LEFT JOIN " . TABLE_ADMIN_PAGES_TO_PROFILES . " ap2p ON ap2p.profile_id = a.admin_profile
            LEFT JOIN " . TABLE_ADMIN_PAGES . " ap ON ap.page_key = ap2p.page_key
            WHERE admin_id = :adminId:
            AND ap2p.page_key NOT LIKE '_productTypes_%'";
    $sql = $db->bindVars($sql, ':adminId:', $_SESSION['admin_id'], 'integer');
    $result = $db->Execute($sql);
    foreach ($result as $row) {
        if (!empty($row['main_page']) && defined($row['main_page']) && basename(constant($row['main_page']), '.php') === $page && $row['page_params'] === $page_params) {
            return true;
        }
    }
    $sql = "SELECT *
            FROM " . TABLE_ADMIN . " a
            LEFT JOIN " . TABLE_ADMIN_PAGES_TO_PROFILES . " ap2p ON ap2p.profile_id = a.admin_profile
            WHERE admin_id = :adminId:";
    $sql = $db->bindVars($sql, ':adminId:', $_SESSION['admin_id'], 'integer');
    $result = $db->Execute($sql);
    foreach ($result as $row) {
        $adjustedPageKey = preg_replace('/_productTypes_/', '', $row['page_key']);
        if ($adjustedPageKey === $page) {
            return true;
        }
    }
    return false;
}

/**
 * Some pages have sub-pages. This function checks for those and responds accordingly.
 * This way permission profiles only need to register the parent page.
 *
 * @param string $page FILENAME_XYZ page name
 * @param array $params
 * @return bool
 */
function check_related_page($page, $params)
{
    if ($page == FILENAME_BANNER_STATISTICS) {
        return check_page(FILENAME_BANNER_MANAGER, $params);
    }
    return false;
}

function zen_is_superuser()
{
    global $db;
    if (!isset($_SESSION['admin_id'])) return false;
    $sql = 'SELECT admin_id from ' . TABLE_ADMIN . '
            WHERE admin_id = :adminId:
            AND admin_profile = ' . SUPERUSER_PROFILE;
    $sql = $db->bindVars($sql, ':adminId:', $_SESSION['admin_id'], 'integer');
    $result = $db->Execute($sql);
    return $result->RecordCount() > 0;
}

/**
 * Get array of registered admin users
 * @param int $limit
 * @return array of Admin Users
 */
function zen_get_users($limit = null)
{
    global $db;
    $retVal = array();
    $sql = 'SELECT a.*, p.profile_name FROM ' . TABLE_ADMIN . ' a
            LEFT JOIN ' . TABLE_ADMIN_PROFILES . ' p ON p.profile_id = a.admin_profile';
    if (!empty($limit)) {
        $sql .= ' WHERE a.admin_id = :adminid: LIMIT 1 ';
        $sql = $db->bindVars($sql, ':adminid:', $limit, 'integer');
    }
    $result = $db->Execute($sql);
    foreach ($result as $row) {
        $retVal[] = array(
            'id' => $row['admin_id'],
            'name' => $row['admin_name'],
            'email' => $row['admin_email'],
            'profile' => $row['admin_profile'],
            'profileName' => $row['profile_name'],
        );
    }
    return $retVal;
}

function zen_delete_user($id)
{
    global $db, $messageStack;
    $result = $db->Execute("SELECT COUNT(admin_id) AS count FROM " . TABLE_ADMIN . " WHERE admin_id != " . (int)$id);
    if ($result->fields['count'] < 1) {
        $messageStack->add(ERROR_CANNOT_DELETE_LAST_ADMIN, 'error');
    } elseif ($id == $_SESSION['admin_id']) {
        $messageStack->add(ERROR_CANNOT_DELETE_SELF, 'error');
    } else {
        $delname = preg_replace('/[^\w._-]/', '*', zen_get_admin_name($id)) . ' [id: ' . (int)$id . ']';
        $sql = "DELETE FROM " . TABLE_ADMIN . " WHERE admin_id = :user:";
        $sql = $db->bindVars($sql, ':user:', $id, 'integer');
        $db->Execute($sql);
        $admname = '{' . preg_replace('/[^\w._-]/', '*', zen_get_admin_name()) . ' [id: ' . (int)$_SESSION['admin_id'] . ']}';
        zen_record_admin_activity(sprintf(TEXT_EMAIL_MESSAGE_ADMIN_USER_DELETED, $delname, $admname), 'warning');
        $email_text = sprintf(TEXT_EMAIL_MESSAGE_ADMIN_USER_DELETED, $delname, $admname);
        $block = array('EMAIL_MESSAGE_HTML' => $email_text);
        zen_mail(STORE_NAME, STORE_OWNER_EMAIL_ADDRESS, TEXT_EMAIL_SUBJECT_ADMIN_USER_DELETED, $email_text, STORE_NAME, EMAIL_FROM, $block, 'admin_settings_changed');
    }
}

function zen_check_for_invalid_admin_chars($val)
{
    $matchstring = '[\d\w._-]'; // could expand this regex to allow other than non-accented latin chars
    $isValid = false;
    if (preg_match('|' . $matchstring . '|', $val)) $isValid = true;
    return $isValid;
}

function zen_insert_user($name, $email, $password, $confirm, $profile)
{
    global $db;
    $errors = array();
    if (zen_check_for_invalid_admin_chars($name) == false) {
        $errors[] = ERROR_ADMIN_INVALID_CHARS_IN_USERNAME;
    }
    $name = zen_db_prepare_input($name);
    if (strlen($name) < ((int)ADMIN_NAME_MINIMUM_LENGTH < 4 ? 4 : (int)ADMIN_NAME_MINIMUM_LENGTH)) {
        $errors[] = sprintf(ERROR_ADMIN_NAME_TOO_SHORT, ((int)ADMIN_NAME_MINIMUM_LENGTH < 4 ? 4 : (int)ADMIN_NAME_MINIMUM_LENGTH));
    }
    $existingCheck = zen_read_user($name);
    if ($existingCheck !== false) {
        $errors[] = ERROR_DUPLICATE_USER;
    }
    $email = zen_db_prepare_input($email);
    if (zen_validate_email($email) == false) {
        $errors[] = ERROR_ADMIN_INVALID_EMAIL_ADDRESS;
    }
    $password = zen_db_prepare_input($password);
    $confirm = zen_db_prepare_input($confirm);
    $profile = (int)$profile;
    if ($password != $confirm) {
        $errors[] = ERROR_PASSWORDS_NOT_MATCHING;
    }
    if (zen_check_for_password_problems($password, 0)) {
        $errors[] = ENTRY_PASSWORD_CHANGE_ERROR . ' ' . sprintf(ERROR_PASSWORD_RULES, ((int)ADMIN_PASSWORD_MIN_LENGTH < 7 ? 7 : (int)ADMIN_PASSWORD_MIN_LENGTH));
    }
    if (empty($profile)) {
        $errors[] = ERROR_USER_MUST_HAVE_PROFILE;
    }
    if (empty($errors)) {
        $sql = "INSERT INTO " . TABLE_ADMIN . "
                SET admin_name = :name:,
                    admin_email = :email:,
                    admin_pass = :password:,
                    admin_profile = :profile:,
                    pwd_last_change_date = now(),
                    last_modified = now()";
        $sql = $db->bindVars($sql, ':name:', $name, 'stringIgnoreNull');
        $sql = $db->bindVars($sql, ':email:', $email, 'stringIgnoreNull');
        $sql = $db->bindVars($sql, ':password:', password_hash($password, PASSWORD_DEFAULT), 'stringIgnoreNull');
        $sql = $db->bindVars($sql, ':profile:', $profile, 'integer');
        $db->Execute($sql);

        $newname = preg_replace('/[^\w._-]/', '*', $name);
        $admname = '{' . preg_replace('/[^\w._-]/', '*', zen_get_admin_name()) . ' [id: ' . (int)$_SESSION['admin_id'] . ']}';
        zen_record_admin_activity(sprintf(TEXT_EMAIL_MESSAGE_ADMIN_USER_ADDED, $newname, $admname), 'warning');
        $email_text = sprintf(TEXT_EMAIL_MESSAGE_ADMIN_USER_ADDED, $newname, $admname);
        $block = array('EMAIL_MESSAGE_HTML' => $email_text);
        zen_mail(STORE_NAME, STORE_OWNER_EMAIL_ADDRESS, TEXT_EMAIL_SUBJECT_ADMIN_USER_ADDED, $email_text, STORE_NAME, EMAIL_FROM, $block, 'admin_settings_changed');
    }
    return $errors;
}

function zen_update_user($name, $email, $id, $profile)
{
    global $db;
    $errors = array();
    if ($name !== false) {
        if (strlen($name) >= ((int)ADMIN_NAME_MINIMUM_LENGTH < 4 ? 4 : (int)ADMIN_NAME_MINIMUM_LENGTH)) {
            $name = zen_db_prepare_input($name);
        } else {
            $errors[] = sprintf(ERROR_ADMIN_NAME_TOO_SHORT, ((int)ADMIN_NAME_MINIMUM_LENGTH < 4 ? 4 : (int)ADMIN_NAME_MINIMUM_LENGTH));
        }
        if (zen_check_for_invalid_admin_chars($name) == false) {
            $errors[] = ERROR_ADMIN_INVALID_CHARS_IN_USERNAME;
        }
    }
    $email = zen_db_prepare_input($email);
    if (zen_validate_email($email) == false) {
        $errors[] = ERROR_ADMIN_INVALID_EMAIL_ADDRESS;
    }
    if (count($errors) == 0) {
        $id = (int)$id;
        $oldData = zen_read_user(zen_get_admin_name($id));
        if ($oldData === false) {
            $errors[] = TEXT_ERROR_FAILED_ADMIN_LOGIN_FOR_USER;
            return $errors;
        }
        $sql = "UPDATE " . TABLE_ADMIN . "
                SET admin_email = :email:, ";
        if (isset($name) && $name !== false && $name != $oldData['admin_name']) $sql .= "admin_name = :name:, ";
        if (isset($profile) && $profile > 0 && $profile != $oldData['admin_profile']) $sql .= "admin_profile = :profile:, ";
        $sql .= "last_modified = NOW() WHERE admin_id=" . $id;
        $sql = $db->bindVars($sql, ':name:', $name, 'stringIgnoreNull');
        $sql = $db->bindVars($sql, ':email:', $email, 'stringIgnoreNull');
        $sql = $db->bindVars($sql, ':profile:', $profile, 'integer');
        $db->Execute($sql);
        // Now notify admin and user of changes
        $newData = zen_read_user(zen_get_admin_name($id));
        $admname = preg_replace('/[^\w._-]/', '*', zen_get_admin_name()) . '[' . (int)$_SESSION['admin_id'] . ']';
        $changes = array();
        if ($oldData['admin_email'] != $newData['admin_email']) {
            $changes['email'] = array('old' => $oldData['admin_email'], 'new' => $newData['admin_email']);
        }
        if ($oldData['admin_name'] != $newData['admin_name']) {
            $changes['name'] = array('old' => $oldData['admin_name'], 'new' => $newData['admin_name']);
        }
        if ($oldData['admin_profile'] != $newData['admin_profile']) {
            $changes['profile'] = array('old' => zen_get_profile_name($oldData['admin_profile']) . '(' . $oldData['admin_profile'] . ')', 'new' => zen_get_profile_name($newData['admin_profile']) . '(' . $newData['admin_profile'] . ')');
        }
        $alertText = '';
        if (isset($changes['email'])) $alertText .= sprintf(TEXT_EMAIL_ALERT_ADM_EMAIL_CHANGED, $oldData['admin_name'], $changes['email']['old'], $changes['email']['new'], $admname) . "\n";
        if (isset($changes['name'])) $alertText .= sprintf(TEXT_EMAIL_ALERT_ADM_NAME_CHANGED, $oldData['admin_name'], $changes['name']['old'], $changes['name']['new'], $admname) . "\n";
        if (isset($changes['profile'])) $alertText .= sprintf(TEXT_EMAIL_ALERT_ADM_PROFILE_CHANGED, $oldData['admin_name'], $changes['profile']['old'], $changes['profile']['new'], $admname) . "\n";
        if ($alertText != '') zen_mail(STORE_NAME, STORE_OWNER_EMAIL_ADDRESS, TEXT_EMAIL_SUBJECT_ADMIN_USER_CHANGED, $alertText, STORE_NAME, EMAIL_FROM, array('EMAIL_MESSAGE_HTML' => $alertText, 'EMAIL_SPAM_DISCLAIMER' => ' ', 'EMAIL_DISCLAIMER' => ' '), 'admin_settings_changed');
        if ($alertText != '') zen_mail(STORE_NAME, $oldData['admin_email'], TEXT_EMAIL_SUBJECT_ADMIN_USER_CHANGED, $alertText, STORE_NAME, EMAIL_FROM, array('EMAIL_MESSAGE_HTML' => $alertText, 'EMAIL_SPAM_DISCLAIMER' => ' ', 'EMAIL_DISCLAIMER' => ' '), 'admin_settings_changed');
        if ($alertText != '') zen_record_admin_activity(TEXT_EMAIL_SUBJECT_ADMIN_USER_CHANGED . ' ' . $alertText, 'warning');
    }
    return $errors;
}

/**
 * Lookup admin user login details based on admin username
 * @param string $name
 */
function zen_read_user($name)
{
    global $db;
    $sql = "SELECT admin_id, admin_name, admin_email, admin_pass, pwd_last_change_date, reset_token, failed_logins, lockout_expires, admin_profile, last_login_date, last_login_ip
            FROM " . TABLE_ADMIN . " WHERE admin_name = :adminname:  LIMIT 1";
    $sql = $db->bindVars($sql, ':adminname:', $name, 'stringIgnoreNull');
    $result = $db->Execute($sql);
    if ($result->EOF || $result->RecordCount() < 1) return false;
    return $result->fields;
}

/**
 * Verify login according to security requirements
 * @param string $admin_name
 * @param string $admin_pass
 * @return array
 */
function zen_validate_user_login($admin_name, $admin_pass)
{
    global $db;
  unset ($_SESSION['last_login_date']);
  unset ($_SESSION['last_login_ip']);
    $camefrom = $_GET['camefrom'] ?? FILENAME_DEFAULT;
    $error = $expired = false;
    $message = $redirect = '';
    $expired_token = 0;
    $result = zen_read_user($admin_name);
    if (empty($result) || $admin_name !== $result['admin_name']) {
        // invalid login
        $error = true;
        $message = ERROR_WRONG_LOGIN;
        zen_record_admin_activity(sprintf(TEXT_ERROR_FAILED_ADMIN_LOGIN_FOR_USER) . ' ' . $admin_name, 'warning');
    } else {
        if ($result['lockout_expires'] > time()) {
            // account locked
            $error = true;
            $message = ERROR_SECURITY_ERROR; // account locked. Simply give generic error, since otherwise we alert that the account name is correct
            zen_record_admin_activity(TEXT_ERROR_ATTEMPTED_TO_LOG_IN_TO_LOCKED_ACCOUNT . ' ' . $admin_name, 'warning');
        }
        if ($result['reset_token'] !== '') {
            list ($token_expires_at, $token) = explode('}', $result['reset_token']);
            if ($token_expires_at > 0) {
                if ($token_expires_at <= time() && $result['admin_pass'] != '') {
                    // reset the reset_token field to blank, since token has expired
                    $sql = "UPDATE " . TABLE_ADMIN . " SET reset_token = '' WHERE admin_name = :adminname: ";
                    $sql = $db->bindVars($sql, ':adminname:', $admin_name, 'stringIgnoreNull');
                    $db->Execute($sql);
                    $expired = false;
                } else {
                    if (!zen_validate_password($admin_pass, $token)) {
                        $error = true;
                        $message = ERROR_WRONG_LOGIN;
                        zen_record_admin_activity(sprintf(TEXT_ERROR_INCORRECT_PASSWORD_DURING_RESET_FOR_USER) . ' ' . $admin_name, 'warning');

                    } else {
                        $error = true;
                        $expired = true;
                        $message = TEXT_TEMPORARY_PASSWORD_MUST_BE_CHANGED;
                    }

                }
            }
        }
        if (empty($result['admin_pass'])) {
            $error = true;
            $expired = true;
            $message = TEXT_TEMPORARY_PASSWORD_MUST_BE_CHANGED;
        } else {
            $token = $result['admin_pass'];
            if (!zen_validate_password($admin_pass, $token)) {
                $error = true;
                if (!$expired) {
                    $message = ERROR_WRONG_LOGIN;
                    zen_record_admin_activity(sprintf(TEXT_ERROR_FAILED_ADMIN_LOGIN_FOR_USER) . ' ' . $admin_name, 'warning');
                }
            } else {
                $error = false;
            }
        }
        // BEGIN 2-factor authentication
        if ($error === false && defined('ZC_ADMIN_TWO_FACTOR_AUTHENTICATION_SERVICE') && ZC_ADMIN_TWO_FACTOR_AUTHENTICATION_SERVICE !== '') {
            if (function_exists(ZC_ADMIN_TWO_FACTOR_AUTHENTICATION_SERVICE)) {
                $response = zen_call_function(ZC_ADMIN_TWO_FACTOR_AUTHENTICATION_SERVICE, [$result['admin_id'], $result['admin_email'], $result['admin_name']]);
                if ($response !== true) {
                    $error = true;
                    $message = ERROR_WRONG_LOGIN;
                    zen_record_admin_activity('TFA Failure - Two-factor authentication failed', 'warning');
                } elseif ($response === true) {
                    zen_record_admin_activity('TFA Passed - Two-factor authentication passed', 'warning');
                }
            }
        }
    }

    // BEGIN LOGIN SLAM PREVENTION
    if ($error) {
        if (!isset($_SESSION['login_attempt'])) $_SESSION['login_attempt'] = 0;
        $_SESSION['login_attempt']++;
        $sql = "UPDATE " . TABLE_ADMIN . " SET failed_logins = failed_logins + 1, last_failed_attempt = now(), last_failed_ip = :ip: WHERE admin_name = :adminname: ";
        $sql = $db->bindVars($sql, ':adminname:', $admin_name, 'stringIgnoreNull');
        $sql = $db->bindVars($sql, ':ip:', $_SERVER['REMOTE_ADDR'], 'string');
        $db->Execute($sql);
        if (!empty($result) && ($_SESSION['login_attempt'] > 3 || $result['failed_logins'] > 3) && !empty($result['admin_email']) && ADMIN_SWITCH_SEND_LOGIN_FAILURE_EMAILS == 'Yes') {
            $html_msg['EMAIL_CUSTOMERS_NAME'] = $result['admin_name'];
            $html_msg['EMAIL_MESSAGE_HTML'] = sprintf(TEXT_EMAIL_MULTIPLE_LOGIN_FAILURES, $_SERVER['REMOTE_ADDR']);
            zen_record_admin_activity(sprintf(TEXT_EMAIL_MULTIPLE_LOGIN_FAILURES, $_SERVER['REMOTE_ADDR']), 'warning');
            zen_mail($result['admin_name'], $result['admin_email'], TEXT_EMAIL_SUBJECT_LOGIN_FAILURES, sprintf(TEXT_EMAIL_MULTIPLE_LOGIN_FAILURES, $_SERVER['REMOTE_ADDR']), STORE_NAME, EMAIL_FROM, $html_msg, 'no_archive');
        }
        if ($expired_token < 10000) {
            if ($_SESSION['login_attempt'] > 6 || (!empty($result) && $result['failed_logins'] > 6)) {
                $sql = "UPDATE " . TABLE_ADMIN . " SET lockout_expires = " . (time() + ADMIN_LOGIN_LOCKOUT_TIMER) . " WHERE admin_name = :adminname: ";
                $sql = $db->bindVars($sql, ':adminname:', $admin_name, 'stringIgnoreNull');
                $db->Execute($sql);
                zen_session_destroy();
                zen_record_admin_activity('Too many login failures. Account locked for ' . ADMIN_LOGIN_LOCKOUT_TIMER / 60 . ' minutes', 'warning');
                sleep(15);
                $redirect = zen_href_link(FILENAME_DEFAULT, '', 'SSL');
                return array($error, $expired, $message, $redirect);
            } else {
                sleep(4);
            }
        }
    } // END LOGIN SLAM PREVENTION
    // deal with expireds for SSL change
    if (PADSS_PWD_EXPIRY_ENFORCED == 1 && $error == false && $result['pwd_last_change_date'] == '1990-01-01 14:02:22') {
        $expired = true;
        $error = true;
        $message = ($message === '' ? '' : $message . '<br><br>') . EXPIRED_DUE_TO_SSL;
    }
    // deal with expireds for PA-DSS
    if ($error == false && PADSS_PWD_EXPIRY_ENFORCED == 1 && $result['pwd_last_change_date'] < date('Y-m-d H:i:s', ADMIN_PASSWORD_EXPIRES_INTERVAL)) {
        $expired = true;
        $error = true;
    }
    if ($error == false) {
        if (password_needs_rehash($token, PASSWORD_DEFAULT)) {
            $token = zcPassword::getInstance(PHP_VERSION)->updateNotLoggedInAdminPassword($admin_pass, $admin_name);
        }
        unset($_SESSION['login_attempt']);
        $_SESSION['last_login_date'] = $result['last_login_date'];
        $_SESSION['last_login_ip'] = $result['last_login_ip'];
        $sql = "UPDATE " . TABLE_ADMIN . " SET failed_logins = 0, lockout_expires = 0, last_login_date = now(), last_login_ip = :ip: WHERE admin_name = :adminname: ";
        $sql = $db->bindVars($sql, ':adminname:', $admin_name, 'stringIgnoreNull');
        $sql = $db->bindVars($sql, ':ip:', $_SERVER['REMOTE_ADDR'], 'string');
        $db->Execute($sql);
        $_SESSION['admin_id'] = $result['admin_id'];
        if (SESSION_RECREATE == 'True') {
            zen_session_recreate();
        }
        $redirect = zen_href_link($camefrom, zen_get_all_get_params(array('camefrom')), 'SSL');
    }
    return array($error, $expired, $message, $redirect);
}

/**
 * Check whether the specified password validates according to PA-DSS requirements:
 * Must be minimum 7 characters
 * Must use both letters and numbers
 * Must not use any of the last 4 passwords
 * THESE ARE PA-DSS REQUIREMENTS AND ARE NOT TO BE RELAXED
 *
 * @param string $password
 * @param int $adminID
 * @return bool Error status
 */
function zen_check_for_password_problems($password, $adminID = 0)
{
    global $db;
    $error = false;

    // admin passwords must be 7 chars long at the very least
    $minLength = (int)ADMIN_PASSWORD_MIN_LENGTH < 7 ? 7 : (int)ADMIN_PASSWORD_MIN_LENGTH;

    // admin passwords must contain at least 1 letter and 1 number and be of required minimum length
    if (!preg_match('/^(?=.*[a-zA-Z]+.*)(?=.*[\d]+.*)[\d\w\s[:punct:]]{' . $minLength . ',}$/', $password)) {
        $error = true;
    }
    // if no user specified, skip checking history
    if ($adminID == 0) return $error;
    // passwords cannot be same as last 4
    if (PADSS_PWD_EXPIRY_ENFORCED == 0) return $error; // skip the check if flag disabled
    $sql = "SELECT admin_pass, prev_pass1, prev_pass2, prev_pass3 FROM " . TABLE_ADMIN . "
            WHERE admin_id = :adminID:";
    $sql = $db->bindVars($sql, ':adminID:', $adminID, 'integer');
    $result = $db->Execute($sql);
    if ($result->RecordCount()) {
        foreach ($result->fields as $key => $val) {
            if (zen_validate_password($password, $val)) {
                $error = true;
            }
        }
    }
    return $error;
}

/**
 * Check whether the specified admin user's password expired more than 90 days ago
 * THIS IS A PA-DSS REQUIREMENT AND MUST NOT BE CHANGED WITHOUT VOIDING COMPLIANCE
 *
 * @param string $adminID
 * @return bool
 */
function zen_check_for_expired_pwd($adminID)
{
    if (PADSS_PWD_EXPIRY_ENFORCED == 0) return false;
    global $db;
    $sql = "SELECT admin_id FROM " . TABLE_ADMIN . "
            WHERE admin_id = :adminID:
            AND pwd_last_change_date < DATE_SUB(CURDATE(),INTERVAL 90 DAY)";
    $sql = $db->bindVars($sql, ':adminID:', $adminID, 'integer');
    $result = $db->Execute($sql);
    return (bool)$result->RecordCount();
}

function zen_reset_password($id, $password, $compare)
{
    global $db;
    $errors = array();
    $id = (int)$id;
    if ($password != 'no password' || $compare != 'no password') {
        $password = zen_db_prepare_input($password);
        $compare = zen_db_prepare_input($compare);
        if ($password != $compare) {
            $errors[] = ERROR_PASSWORDS_NOT_MATCHING;
        }
        if (zen_check_for_password_problems($password, $id)) {
            $errors[] = ENTRY_PASSWORD_CHANGE_ERROR . ' ' . sprintf(ERROR_PASSWORD_RULES, ((int)ADMIN_PASSWORD_MIN_LENGTH < 7 ? 7 : (int)ADMIN_PASSWORD_MIN_LENGTH));
        }
    }
    if (empty($errors)) {
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE " . TABLE_ADMIN . "
                SET prev_pass3 = prev_pass2, prev_pass2 = prev_pass1, prev_pass1 = admin_pass, admin_pass = :newpwd:,
                    failed_logins=0, lockout_expires = 0,
                    pwd_last_change_date = now()
                WHERE admin_id = :adminID:";
        $sql = $db->bindVars($sql, ':adminID:', $id, 'integer');
        $sql = $db->bindVars($sql, ':newpwd:', $encryptedPassword, 'string');
        $db->Execute($sql);
        zen_record_admin_activity('Account password change saved.', 'warning');
    }
    return $errors;
}

/**
 * Validate whether the password-reset request is permissible
 * @param string $admin_name
 * @param string $adm_old_pwd
 * @param string $adm_new_pwd
 * @param string $adm_conf_pwd
 * @return array error messages
 */
function zen_validate_pwd_reset_request($admin_name, $adm_old_pwd, $adm_new_pwd, $adm_conf_pwd)
{
    global $db;
    $errors = array();
    $result = zen_read_user($admin_name);
    if (empty($result) || $admin_name != $result['admin_name']) {
        $errors[] = ERROR_WRONG_LOGIN;
        return $errors;
    }
    if ($result['lockout_expires'] > time()) {
        $errors[] = ERROR_SECURITY_ERROR;
    }
    // if entered password doesn't match current password, check for reset token
    if (!zen_validate_password($adm_old_pwd, $result['admin_pass'])) {
        if ($result['reset_token'] != '') {
            list ($expired_token, $token) = explode('}', $result['reset_token']);
            if ($expired_token > 0) {
                if ($expired_token <= time()) {
                    // reset the reset_token field to blank, since token has expired
                    $sql = "UPDATE " . TABLE_ADMIN . " SET reset_token = '' WHERE admin_name = :adminname: ";
                    $sql = $db->bindVars($sql, ':adminname:', $admin_name, 'stringIgnoreNull');
                    $db->Execute($sql);
                } else { // if we have a token and it hasn't expired, check password against token
                    if (!zen_validate_password($adm_old_pwd, $token)) {
                        $errors[] = ERROR_WRONG_LOGIN;
                    } else { // temporary password is good, so attempt to reset using new password
                        $moreErrors = zen_reset_password($result['admin_id'], $adm_new_pwd, $adm_conf_pwd);
                        if (count($moreErrors)) {
                            $errors = array_merge($errors, $moreErrors);
                        } else {
                            // password change was accepted, so reset token
                            $sql = "UPDATE " . TABLE_ADMIN . " SET reset_token = '', failed_logins = 0 WHERE admin_name = :adminname: ";
                            $sql = $db->bindVars($sql, ':adminname:', $admin_name, 'stringIgnoreNull');
                            $db->Execute($sql);
                        }
                    }
                }
            }
        } else {
            $errors[] = ENTRY_PASSWORD_CHANGE_ERROR . ' ' . sprintf(ERROR_PASSWORD_RULES, ((int)ADMIN_PASSWORD_MIN_LENGTH < 7 ? 7 : (int)ADMIN_PASSWORD_MIN_LENGTH));
        }
    } else { // password matched, so proceed with reset
        $moreErrors = zen_reset_password($result['admin_id'], $adm_new_pwd, $adm_conf_pwd);
        if (count($moreErrors)) {
            $errors = array_merge($errors, $moreErrors);
        } else {
            $sql = "UPDATE " . TABLE_ADMIN . " SET reset_token = '' WHERE admin_name = :adminname: ";
            $sql = $db->bindVars($sql, ':adminname:', $admin_name, 'stringIgnoreNull');
            $db->Execute($sql);
        }
    }
    return $errors;
}

/**
 * Retrieve profiles list
 * @param bool $withUsers
 * @return array
 */
function zen_get_profiles($withUsers = false)
{
    global $db;
    $retVal = array();
    if ($withUsers) {
        $sql = "SELECT p.profile_id, p.profile_name, COUNT(a.admin_profile) as profile_users
                FROM " . TABLE_ADMIN_PROFILES . " p
                LEFT JOIN " . TABLE_ADMIN . " a ON a.admin_profile = p.profile_id
                GROUP BY p.profile_id, p.profile_name";
        $result = $db->Execute($sql);
        foreach ($result as $row) {
            $retVal[] = [
                'id' => $row['profile_id'],
                'name' => $row['profile_name'],
                'users' => $row['profile_users'],
                ];
        }
    } else {
        $sql = 'SELECT * FROM ' . TABLE_ADMIN_PROFILES;
        $result = $db->Execute($sql);
        foreach ($result as $row) {
            $retVal[] = [
                'id' => $row['profile_id'],
                'text' => $row['profile_name'],
            ];
        }
    }
    return $retVal;
}

function zen_get_profile_name($profile)
{
    global $db;
    $sql = "SELECT profile_name FROM " . TABLE_ADMIN_PROFILES . " WHERE profile_id = :profile:";
    $sql = $db->bindVars($sql, ':profile:', $profile, 'integer');
    $result = $db->Execute($sql);
    return $result->fields['profile_name'];
}

function zen_update_profile_name($profile, $profile_name)
{
    global $db;
    $sql = "UPDATE " . TABLE_ADMIN_PROFILES . "
            SET profile_name = :profileName:
            WHERE profile_id = :profile:";
    $sql = $db->bindVars($sql, ':profileName:', zen_db_prepare_input($profile_name), 'stringIgnoreNull');
    $sql = $db->bindVars($sql, ':profile:', $profile, 'integer');
    $db->Execute($sql);
    zen_record_admin_activity('Admin profile renamed.', 'notice');
}

function zen_get_admin_pages($menu_only)
{
    global $db;

    /**
     * First we'll get all the pages
     */
    $sql = "SELECT * FROM " . TABLE_PRODUCT_TYPES . " WHERE type_handler != 'product'";
    $result = $db->Execute($sql);
    foreach ($result as $row) {
        $productTypes['_productTypes_' . $row['type_handler']] = [
            'name' => $row['type_name'],
            'file' => $row['type_handler'],
            'params' => '',
        ];
    }
    $sql = "SELECT ap.menu_key, ap.page_key, ap.main_page, ap.page_params, ap.language_key as page_name
            FROM " . TABLE_ADMIN_PAGES . " ap
            LEFT JOIN " . TABLE_ADMIN_MENUS . " am ON am.menu_key = ap.menu_key ";
    if ($menu_only) $sql .= "WHERE ap.display_on_menu = 'Y' ";
    $sql .= "ORDER BY am.sort_order, ap.sort_order";
    $result = $db->Execute($sql);
    foreach ($result as $row) {
        if (defined($row['main_page']) && defined($row['page_name'])) {
            $retVal[$row['menu_key']][$row['page_key']] = [
                'name' => constant($row['page_name']),
                'file' => constant($row['main_page']),
                'params' => $row['page_params'],
            ];

        }
    }
    if ($menu_only) {
        if (defined('MENU_CATEGORIES_TO_SORT_BY_NAME') && !empty(MENU_CATEGORIES_TO_SORT_BY_NAME)) {
            $sorted_menus = explode(",", MENU_CATEGORIES_TO_SORT_BY_NAME);
            foreach (array_keys($retVal) as $key) {
                if (in_array($key, $sorted_menus)) {
                    usort($retVal[$key], 'admin_menu_name_sort_callback');
                }
            }
        }
    }
    if (!$menu_only) {
        foreach ($productTypes as $pageName => $productType) {
            if (!isset($retVal['_productTypes']['_productTypes_' . $pageName])) {
                $retVal['_productTypes'][$pageName] = $productType;
            }
        }
    }
    /**
     * Then we'll deal with the exceptions
     */
    // Include paypal ipn menu only if the payment mod is enabled
    if (!(defined('MODULE_PAYMENT_PAYPAL_STATUS') && MODULE_PAYMENT_PAYPAL_STATUS == 'True') &&
        !(defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS == 'True') &&
        !(defined('MODULE_PAYMENT_PAYPALR_STATUS') && MODULE_PAYMENT_PAYPALR_STATUS == 'True') &&
        !(defined('MODULE_PAYMENT_PAYPALDP_STATUS') && MODULE_PAYMENT_PAYPALDP_STATUS == 'True')) {
        unset ($retVal['customers']['paypal']);
    }

    // don't show Coupon Admin unless installed
    if (!defined('MODULE_ORDER_TOTAL_COUPON_STATUS') || MODULE_ORDER_TOTAL_COUPON_STATUS != 'true') {
        unset ($retVal['gv']['couponAdmin']);
    }
    // don't show Gift Vouchers unless installed
    if (!defined('MODULE_ORDER_TOTAL_GV_STATUS') || MODULE_ORDER_TOTAL_GV_STATUS != 'true') {
        unset ($retVal['gv']['gvQueue']);
        unset ($retVal['gv']['gvMail']);
        unset ($retVal['gv']['gvSent']);
    }
    // if Coupons and Gift Vouchers are off display msg
    if (!defined('MODULE_ORDER_TOTAL_COUPON_STATUS') && !defined('MODULE_ORDER_TOTAL_GV_STATUS')) {
        $retVal['gv']['message'] = array(
            'name' => NOT_INSTALLED_TEXT,
            'file' => FILENAME_MODULES,
            'params' => 'set=ordertotal',
        );
    }

    return $retVal;
}

function zen_get_permitted_pages_for_profile($profile)
{
    global $db;
    $retVal = array();
    $sql = "SELECT page_key FROM " . TABLE_ADMIN_PAGES_TO_PROFILES . " WHERE profile_id = :profile:";
    $sql = $db->bindVars($sql, ':profile:', $profile, 'integer');
    $result = $db->Execute($sql);
    foreach ($result as $row) {
        $retVal[] = $row['page_key'];
    }
    return $retVal;
}

function zen_delete_profile($profile)
{
    global $db;
    $error = '';
    $sql = "SELECT admin_id FROM " . TABLE_ADMIN . " WHERE admin_profile = :profile:";
    $sql = $db->bindVars($sql, ':profile:', $profile, 'integer');
    $result = $db->Execute($sql);
    if ($result->RecordCount() == 0) {
        $sql = "DELETE FROM " . TABLE_ADMIN_PAGES_TO_PROFILES . " WHERE profile_id = :profile:";
        $sql = $db->bindVars($sql, ':profile:', $profile, 'integer');
        $db->Execute($sql);
        $sql = "DELETE FROM " . TABLE_ADMIN_PROFILES . " WHERE profile_id = :profile:";
        $sql = $db->bindVars($sql, ':profile:', $profile, 'integer');
        $db->Execute($sql);
        zen_record_admin_activity('Deleted Admin Profile "' . (int)$profile . '"', 'warning');
    } else {
        $error = ERROR_PROFILE_HAS_USERS_ATTACHED;
    }
    return $error;
}

function zen_create_profile($profileData)
{
    global $db;
    $retVal = '';
    if (!isset($profileData['name'])) {
        $retVal = ERROR_NO_PROFILE_NAME;
    } else {
        $name = zen_db_prepare_input($profileData['name']);
        if (empty($name)) {
            $retVal = ERROR_INVALID_PROFILE_NAME;
        } else {
            $sql = "SELECT profile_id FROM " . TABLE_ADMIN_PROFILES . " WHERE profile_name = :name:";
            $sql = $db->bindVars($sql, ':name:', $name, 'stringIgnoreNull');
            $result = $db->Execute($sql);
            if ($result->RecordCount() > 0) {
                $retVal = ERROR_DUPLICATE_PROFILE_NAME;
            } else if (!isset($profileData['p']) || !is_array($profileData['p']) || sizeof($profileData['p']) == 0) {
                $retVal = ERROR_NO_PAGES_IN_PROFILE;
            } else {
                $sql = "INSERT INTO " . TABLE_ADMIN_PROFILES . " SET profile_name = :name:";
                $sql = $db->bindVars($sql, ':name:', $name, 'stringIgnoreNull');
                $db->Execute($sql);
                $profileId = $db->Insert_ID();
                if (is_numeric($profileId)) {
                    // suceeded in creating the profile so result returned was the profile ID
                    zen_insert_pages_into_profile($profileId, $profileData['p']);
                    zen_record_admin_activity('Created new admin Profile "' . (int)$profileId . '"', 'warning');
                } else {
                    // failed to create the profile return error message
                    $retVal = ERROR_UNABLE_TO_CREATE_PROFILE;
                }
            }
        }
    }
    return $retVal;
}

function zen_remove_profile_permits($profile)
{
    global $db;
    $sql = "DELETE FROM " . TABLE_ADMIN_PAGES_TO_PROFILES . " WHERE profile_id = :profile:";
    $sql = $db->bindVars($sql, ':profile:', $profile, 'integer');
    $db->Execute($sql);
    zen_record_admin_activity('Deleted profile permissions from profile #' . (int)$profile, 'warning');
}

function zen_insert_pages_into_profile($id, $pages)
{
    global $db;
    foreach ($pages as $page) {
        $sql = "INSERT INTO " . TABLE_ADMIN_PAGES_TO_PROFILES . "
                SET page_key=:page:,
                    profile_id=:profileId:";
        $sql = $db->bindVars($sql, ':page:', $page, 'stringIgnoreNull');
        $sql = $db->bindVars($sql, ':profileId:', $id, 'integer');
        $db->Execute($sql);
        zen_record_admin_activity('Added pages to profile #' . (int)$id, 'warning');
    }
}

function zen_get_admin_menu_for_user()
{
    global $db;
    if (zen_is_superuser()) {
        // get all registered admin pages that should appear in the menu
        $retVal = zen_get_admin_pages(true);
    } else {
        // get only those registered pages allowed by the current user's profile
        $retVal = array();
        $sql = "SELECT ap.menu_key, ap.page_key, ap.main_page, ap.page_params, ap.language_key as pageName
                FROM " . TABLE_ADMIN . " a
                LEFT JOIN " . TABLE_ADMIN_PAGES_TO_PROFILES . " ap2p ON ap2p.profile_id = a.admin_profile
                LEFT JOIN " . TABLE_ADMIN_PAGES . " ap ON ap.page_key = ap2p.page_key
                LEFT JOIN " . TABLE_ADMIN_MENUS . " am ON am.menu_key = ap.menu_key
                WHERE a.admin_id = :user:
                AND   ap.display_on_menu = 'Y'
                ORDER BY am.sort_order, ap.sort_order";
        $sql = $db->bindVars($sql, ':user:', $_SESSION['admin_id'], 'integer');
        $result = $db->Execute($sql);
        foreach ($result as $row) {
            if (defined($row['pageName']) && defined($row['main_page'])) {
                $retVal[$row['menu_key']][$row['page_key']] = array(
                    'name' => constant($row['pageName']),
                    'file' => constant($row['main_page']),
                    'params' => $row['page_params'],
                );
            }
        }
    }
    return $retVal;
}

function zen_get_menu_titles()
{
    global $db;
    $retval = array();
    $sql = "SELECT menu_key, language_key FROM " . TABLE_ADMIN_MENUS . " ORDER BY sort_order";
    $result = $db->Execute($sql);
    foreach ($result as $row) {
       if (defined($row['language_key'])) {
          $retVal[$row['menu_key']] = constant($row['language_key']);
       }
    }
    $retVal['_productTypes'] = BOX_HEADING_PRODUCT_TYPES;
    return $retVal;
}

function zen_page_key_exists($page_key)
{
    global $db;
    $sql = "SELECT page_key FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = :page_key:";
    $sql = $db->bindVars($sql, ':page_key:', $page_key, 'stringIgnoreNull');
    $result = $db->Execute($sql);
    return $result->RecordCount() > 0;
}

function zen_register_admin_page($page_key, $language_key, $main_page, $page_params, $menu_key, $display_on_menu, $sort_order = -1)
{
    global $db;
    if ($sort_order == -1) {
        $sql = "SELECT MAX(sort_order) AS sort_order_max FROM " . TABLE_ADMIN_PAGES . " WHERE menu_key = :menu_key:";
        $sql = $db->bindVars($sql, ':menu_key:', $menu_key, 'stringIgnoreNull');
        $result = $db->Execute($sql);
        $sort_order = $result->fields['sort_order_max'] + 1;
    }
    $sql = "INSERT INTO " . TABLE_ADMIN_PAGES . "
            SET page_key = :page_key:,
                language_key = :language_key:,
                main_page = :main_page:,
                page_params = :page_params:,
                menu_key = :menu_key:,
                display_on_menu = :display_on_menu:,
                sort_order = :sort_order:";
    $sql = $db->bindVars($sql, ':page_key:', $page_key, 'stringIgnoreNull');
    $sql = $db->bindVars($sql, ':language_key:', $language_key, 'stringIgnoreNull');
    $sql = $db->bindVars($sql, ':main_page:', $main_page, 'stringIgnoreNull');
    $sql = $db->bindVars($sql, ':page_params:', $page_params, 'stringIgnoreNull');
    $sql = $db->bindVars($sql, ':menu_key:', $menu_key, 'stringIgnoreNull');
    $sql = $db->bindVars($sql, ':display_on_menu:', $display_on_menu, 'stringIgnoreNull');
    $sql = $db->bindVars($sql, ':sort_order:', $sort_order, 'integer');
    $db->Execute($sql);
    zen_record_admin_activity('Registered new admin menu page "' . $page_key . '"', 'warning');
}

function zen_deregister_admin_pages($pages)
{
    global $db;
    if (!empty($pages)) {
        if (is_array($pages)) {
            $sql = "DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key IN (";
            foreach ($pages as $page) {
                $sql .= ":page_key:,";
                $sql = $db->bindVars($sql, ':page_key:', $page, 'stringIgnoreNull');
            }
            $sql = trim($sql, ',') . ")";
        } else {
            $sql = "DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = :page_key:";
            $sql = $db->bindVars($sql, ':page_key:', $pages, 'stringIgnoreNull');
        }
        $db->Execute($sql);
        zen_record_admin_activity('Deleted admin pages for page keys: ' . print_r($pages, true), 'warning');
    }
}

function zen_admin_authorized_to_place_order()
{
    global $db;
    $admin_in_profile = false;
    if (!empty(EMP_LOGIN_ADMIN_PROFILE_ID)) {
        $admin_profiles = explode(',', str_replace(' ', '', EMP_LOGIN_ADMIN_PROFILE_ID));
        $profile_list = [];
        foreach ($admin_profiles as $current_profile) {
            if (((int)$current_profile) !== 0) {
                $profile_list[] = (int)$current_profile;
            }
        }
        if (count($profile_list) > 0) {
            $profile_clause = ' AND admin_profile IN (' . implode(',', $profile_list) . ')';
            $emp_sql =
                "SELECT admin_profile, admin_pass
                 FROM " . TABLE_ADMIN . "
                 WHERE admin_id = :adminId:$profile_clause
                 LIMIT 1";
            $emp_sql = $db->bindVars($emp_sql, ':adminId:', $_SESSION['admin_id'], 'integer');
            $emp_result = $db->Execute($emp_sql);
            $admin_in_profile = !$emp_result->EOF;
        }
    }
    return ((int)$_SESSION['admin_id'] === (int)EMP_LOGIN_ADMIN_ID || $admin_in_profile);
}

/**
 * callback function for sorting admin menu entries
 */
function admin_menu_name_sort_callback($a, $b)
{
    if ($a['name'] == $b['name'])
        return 0;
    if ($a['name'] < $b['name'])
        return -1;
    return 1;
}
