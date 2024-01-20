<?php

namespace App\Classes;

class SystemCodesHelper
{

  public static function error_codes()
  {
    return array(
      /**
       * These error codes will show if parameter is missing in request
       * They all prefix with "REQUEST_MISSING"
       */

      "REQUEST_MISSING_EMAIL" => "email is missing from request",
      "REQUEST_MISSING_PHONE_NUMBER" => "phone_number is missing from request",
      "REQUEST_MISSING_PRIMARY_PHONE_NUMBER" => "primary phone number is missing from request",
      "REQUEST_MISSING_PASSWORD" => "password is missing from request",
      "REQUEST_MISSING_NAME" => "name is missing from request",
      "REQUEST_MISSING_USER" => "user_id is missing from request",
      "REQUEST_MISSING_VERIFICATION_CODE" => "verification_code is missing from request",
      "REQUEST_MISSING_AMOUNT" => "amount is missing from request",
      "REQUEST_MISSING_PWD_NUMBER" => "pwd number is missing from request",
      "REQUEST_MISSING_FINANCIAL_YEAR" => "financial year is missing from request",
      "REQUEST_MISSING_QUARTER" => "quarter is missing from request",
      "REQUEST_MISSING_SURNAME" => "surname is missing from request",
      "REQUEST_MISSING_GIVEN_NAME" => "given_name is missing from request",
      "REQUEST_MISSING_SEX" => "sex is missing from request",
      "REQUEST_MISSING_NIN" => "nin is missing from request",
      "REQUEST_MISSING_CARETAKER_STATUS" => "caretaker status is missing from request",
      "REQUEST_MISSING_DISTRICT_CODE" => "district is missing from request",
      "REQUEST_MISSING_COUNTY_CODE" => "county is missing from request",
      "REQUEST_MISSING_SUBCOUNTY_CODE" => "subcounty is missing from request",
      "REQUEST_MISSING_VILLAGE" => "village is missing from request",
      "REQUEST_MISSING_PARISH" => "parish is missing from request",
      "REQUEST_MISSING_ADDRESS" => "address is missing from request",
      "REQUEST_MISSING_EDUCATIONAL_LEVEL" => "educational level is missing from request",
      "REQUEST_MISSING_EDUCATIONAL_CERTIFICATE" => "educational certificate is missing from request",
      "REQUEST_MISSING_COMMENT" => "comment is missing from request",
      "REQUEST_MISSING_EDUCATIONAL_COMMENT" => "educational comment is missing from request",
      "REQUEST_MISSING_DISABILITY_TYPE" => "disability type is missing from request",
      "REQUEST_MISSING_DISABILITY_CAUSES" => "disability causes are missing from request",
      "REQUEST_MISSING_DISABILITY_SEVERITY" => "disability severity is missing from request",
      "REQUEST_MISSING_HOUSE_HOLD_SIZE" => "household size is missing from request",
      "REQUEST_MISSING_SLUMS" => "living in slums status is missing from request",
      "REQUEST_MISSING_HIV_STATUS" => "HIV status is missing from request",
      "REQUEST_MISSING_SINGLE_PARENT_STATUS" => "single parent status is missing from request",
      "REQUEST_MISSING_PASSPORT_PHOTOGRAPH" => "passport photograph is missing from request",
      "REQUEST_MISSING_DISABILITY_PHOTOGRAPH" => "disability photograph is missing from request",
      "REQUEST_MISSING_CARETAKERS_PHOTOGRAPH" => "caretakers photograph is missing from request",
      "REQUEST_MISSING_DEVICE_PWD_NUMBER" => "device pwd number is missing from request",
      "REQUEST_MISSING_DEVICE_GROUP_NUMBER" => "device group number is missing from request",
      "REQUEST_MISSING_GROUP_NAME" => "group name is missing from request",
      "REQUEST_MISSING_PWD_GROUP_NUMBER" => "pwd group number is missing from request",
      "REQUEST_MISSING_PWD" => "pwd is missing from request",
      "REQUEST_MISSING_DEVICE_GROUP_APPLICATION_NUMBER" => "device group application number is missing from request",
      "REQUEST_MISSING_GROUP_APPLICATION_NUMBER" => "group application number is missing from request",
      "REQUEST_MISSING_PROJECT_INDUSTRY" => "project industry is missing from request",
      "REQUEST_MISSING_BUDGET" => "budget is missing from request",
      "REQUEST_MISSING_SALES_PROJECTION" => "sales projection is missing from request",
      "REQUEST_MISSING_BANK" => "a bank is missing from request",
      "REQUEST_MISSING_BANK_ACCOUNT_NUMBER" => "bank account number is missing from request",
      "REQUEST_MISSING_BANK_ACCOUNT_NAME" => "bank account name is missing from request",
      "REQUEST_MISSING_BANK_BRANCH" => "bank branch is missing from request",
      "REQUEST_MISSING_GROUP_PREPAREDNESS" => "group preparedness is missing from request",
      "REQUEST_MISSING_ROLE" => "role is missing from request",


      "REQUEST_MISSING_COMPLAINT_CATEGORY" => "complaint category is missing from request",
      "REQUEST_MISSING_REPORTER_TYPE" => "reporter type is missing from request",
      "REQUEST_MISSING_COMPLAINER_TYPE" => "complainer type is missing from request",
      "REQUEST_MISSING_COMPLAINT" => "complaint is missing from request",

      "EMAIL_ALREADY_VERIFIED" => "email is already verified",
      "EMAIL_EXISTS" => "email address is already registered",
      "EMAIL_NOT_FOUND" => "email address not found",
      "EMAIL_VERIFICATION_FAILED" => "email verification failed",
      "PWD_EXISTS" => "pwd is already registered",

      /**
       * Invalid errors codes
       */
      "INVALID_EMAIL" => "email address is invalid",
      "INVALID_NAME" => "name field is invalid",
      "INVALID_DATE_OF_BIRTH" => "date of birth is invalid",
      "INVALID_SEX" => "sex is invalid",
      "INVALID_FINANCIAL_YEAR" => "financial year is invalid",
      "INVALID_PWD_NUMBER" => "pwd number is invalid",
      "INVALID_VERIFICATION_CODE" => "Invalid verification code",
      "INVALID_PWD_NUMBER" => "pwd number is invalid",
      "INVALID_PHONE_NUMBER" => "phone number is invalid",
      "INVALID_EDUCATIONAL_LEVEL" => "educational level is invalid",
      "INVALID_EDUCATIONAL_CERTIFICATE" => "educational certificate is invalid",

      "INVALID_TYPE_FOR_SLUMS" => "data type for slums is invalid",
      "INVALID_TYPE_FOR_HIV_STATUS" => "data type for hiv is invalid",
      "INVALID_TYPE_FOR_SINGLE_PARENT_STATUS" => "data type for single_parent is invalid",

      /**
       * not found codes
       */
      "USER_NOT_FOUND" => "user not found",
      "DISTRICT_NOT_FOUND" => "district not found",
      "COUNTY_NOT_FOUND" => "county not found",
      "SUBCOUNTY_NOT_FOUND" => "subcounty not found",
      "POSITION_NOT_FOUND" => "position not found",
      "FINANCIAL_YEAR_NOT_FOUND" => "financial year not found",
      "QUARTER_NOT_FOUND" => "quarter not found",
      "PWD_NUMBER_NOT_FOUND" => "pwd_number not found",
      "PWD_NOT_FOUND" => "pwd not found",
      "EDUCATIONAL_LEVEL_NOT_FOUND" => "educational level not found",
      "EDUCATIONAL_CERTIFICATE_NOT_FOUND" => "educational certificate not found",
      "DISABILITY_TYPE_NOT_FOUND" => "disability type not found",
      "DISABILITY_SEVERITY_NOT_FOUND" => "disability severity not found",
      "DISABILITY_CAUSE_NOT_FOUND" => "disability cause not found",
      "ROLE_NOT_FOUND" => "role not found",
      "PWD_GROUP_NOT_FOUND" => "pwd group not found",
      "PROJECT_INDUSTRY_NOT_FOUND" => "project industry not found",
      "BANK_NOT_FOUND" => "bank not found",
      "UNIT_MEASURE_NOT_FOUND" => "unit measure not found",
      "ROLE_NOT_FOUND" => "role not found",
      "GROUP_APPLICATION_NOT_FOUND" => "group application not found",
      "COMPLAINT_CATEGORY_NOT_FOUND" => "complaint category not found",
      "COMPLAINT_NOT_FOUND" => "complaint not found",
      "VILLAGE_NOT_FOUND" => "village not found",
      "CARETAKER_NOT_FOUND" => "caretaker not found",

      /**
       * Others
       */
      "PASSWORD_MIN_LENGTH" => "Password should be a minimum of 6 characters",
      "UNAUTHORIZED" => "Access denied",
      "AUTHENTICATION_FAILED" => "Invalid username or password",

      "UNKNOWN_ERROR" => "Something went wrong... please try again later",
      "NOT_ALLOWED" => "action terminated",
      "NO_LONGER_AVAILABLE" => "this resource is no longer available",
    );
  }
}
