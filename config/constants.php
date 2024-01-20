<?php

/**
 * Common tags
 */
defined('LOCAL_CURRENCY')                       or define('LOCAL_CURRENCY', 'UGX');
defined('CURRENT_DATE')                         or define('CURRENT_DATE', date('Y-m-d'));
defined('CURRENT_DATE_DATE_PICKER')    or define('CURRENT_DATE_DATE_PICKER', date('d M Y'));
defined('SERVER_TIME')                         or define('SERVER_TIME', date('Y-m-d H:i:s'));
defined('CURRENT_YEAR')                         or define('CURRENT_YEAR', date('Y'));
defined('CLIENT_NAME')                         or define('CLIENT_NAME', 'MINISTRY OF GENDER LABOUR AND SOCIAL DEVELOPMENT');
defined('APP_ABBRIV')                                or define('APP_ABBRIV', 'DMIS');
defined('APP_NAME')                         or define('APP_NAME', 'Disability Management Information System');
defined('TEMP_DOCUMENT_DIR')               or define('TEMP_DOCUMENT_DIR', 'Documents/temp');
defined('DEFAULT_CREATOR_ID')               or define('DEFAULT_CREATOR_ID', 1);

defined('PWDS_TAG')               or define('PWDS_TAG', 'pwds');
defined('FINANCIAL_YEARS')               or define('FINANCIAL_YEARS', 'Financial Years');
defined('DOCUMENTS_DIR')                                or define('DOCUMENTS_DIR', 'documents');
defined('PUBLICATIONS_DIR')               or define('PUBLICATIONS_DIR', DOCUMENTS_DIR . '/publications');
defined('CONTACT_PHONE_NUMBER')                                or define('CONTACT_PHONE_NUMBER', '041 4347854');
defined('CONTACT_EMAIL')                                or define('CONTACT_EMAIL', 'ps@mglsd.go.ug, william.majwara@mglsd.go.ug');
defined('CONTACT_PO_BOX')                                or define('CONTACT_PO_BOX', '7136 George St');
defined('CONTACT_LOCATION')                                or define('CONTACT_LOCATION', 'Plot 2, Simbamanyo House');
defined('SOCIAL_PROJECTION')                                or define('SOCIAL_PROJECTION', 'Plot9 Lourdel Rd, Kampala, 031');
defined('CHAIRPERSON')                                or define('CHAIRPERSON', 'chairperson');
defined('SECRETARY')                                or define('SECRETARY', 'secretary');
defined('PDF_FILE')                                or define('PDF_FILE', 'pdf');
defined('EXCEL_FILE')                                or define('EXCEL_FILE', 'excel');
defined('IS_CARETAKER')                                or define('IS_CARETAKER', 'is_caretaker');
defined('NOT_CARETAKER')                                or define('NOT_CARETAKER', 'not_caretaker');
defined('HAS_CARETAKER')                                or define('HAS_CARETAKER', 'has_caretaker');
defined('MAX_FILE_UPLOAD_SIZE_MBS')                                or define('MAX_FILE_UPLOAD_SIZE_MBS', 6);
defined('MAX_FILE_IMAGE_SIZE')                                or define('MAX_FILE_IMAGE_SIZE', 2);

defined('SUPER_ADMIN_ACCOUNT')                                or define('SUPER_ADMIN_ACCOUNT', 'superadmin@dmis.mglsd.go.ug');

defined('PAGE_HEADER_CUSTOM')                                or define('PAGE_HEADER_CUSTOM', true);


defined('SYSTEM_PRIVACY_POLICY_TAG')                                or define('SYSTEM_PRIVACY_POLICY_TAG', "privacy_policy");
defined('SYSTEM_TERMS_OF_USE_TAG')                                or define('SYSTEM_TERMS_OF_USE_TAG', "terms_of_use");
defined('SYSTEM_SUPPORT_EMAIL_TAG')                                or define('SYSTEM_SUPPORT_EMAIL_TAG', "support_email");
defined('SYSTEM_GENDER_LOCATION_TAG')                                or define('SYSTEM_GENDER_LOCATION_TAG', "gender_location");
defined('SYSTEM_GENDER_EMAIL')                                or define('SYSTEM_GENDER_EMAIL', "gender_email");
defined('SYSTEM_GENDER_WEBSITE_TAG')                                or define('SYSTEM_GENDER_WEBSITE_TAG', "gender_website");
defined('SYSTEM_GENDER_BOX_TAG')                                or define('SYSTEM_GENDER_BOX_TAG', "gender_box");
defined('SYSTEM_GENDER_NAME_TAG')                                or define('SYSTEM_GENDER_NAME_TAG', "gender_name");
defined('MINIMUM_AGE_NIN')                                or define('MINIMUM_AGE_NIN', 15);
defined('MINIMUM_GROUP_MEMBERS_COUNT')                                or define('MINIMUM_GROUP_MEMBERS_COUNT', 5);
defined('USE_APPRAISAL_NEW_PROCESS')                                or define('USE_APPRAISAL_NEW_PROCESS', true);