<?php

namespace App\Classes;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\SurveyEvalCriteria;
use DateTime;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class GeneralHelper
{
  public static function DashboardPath($path = '')
  {
    return  @$path ? "dashboard." . $path : 'dashboard';
  }

  public static function date_picker_format_date($date)
  {
    if (!$date || $date == '1970-01-01' || $date == '' || $date == '0000-00-00') return '';
    return date("M/j/Y", strtotime($date));
  }

  public static function AppOnline()
  {
    // return false;
    $connected = @fopen("http://www.google.com:80/", "r");
    return @$connected ? true : false;
  }

  public static function to_db_timestamp($date)
  {
    return (@$date) ? @$date->toArray()["formatted"] : null;
  }

  public static function short_year_format_date($date)
  {
    if (!$date) {
      return '- -- ----';
    }
    return date("j M y", strtotime($date));
  }

  public static function filter_website_url($website)
  {
    $website = str_replace('http:/', '', $website);
    $website = str_replace('https:/', '', $website);

    return $website;
  }

  public static function generate_random_number_short()
  {
    return uniqid() . rand();
  }

  public static function current_date()
  {
    return date('jS F, Y');
  }

  public static function print_date($date = null)
  {
    if ($date) {
      return date("jS F Y", strtotime($date));
    }
    return date('jS, F, Y');
  }

  public static function add_days_to_date($date, $number_of_days)
  {
    if (!$date) {
      return '- -- ----';
    }
    return date('jS M Y', strtotime($date . ' + ' . $number_of_days . ' days'));
  }


  public static function add_working_days_to_date($date, $number_of_days, $holiday_dates_ymd = [])
  {
    if (!$date) {
      return '- -- ----';
    }

    $num_business_days = $number_of_days;
    $num_business_days = min($num_business_days, 1000);
    $business_day_count = 0;
    $current_timestamp = empty($date) ? time() : strtotime($date);
    while ($business_day_count < $num_business_days) {
      $next1WD = strtotime('+1 weekday', $current_timestamp);
      $next1WDDate = date('Y-m-d', $next1WD);
      if (!in_array($next1WDDate, $holiday_dates_ymd)) {
        $business_day_count++;
      }
      $current_timestamp = $next1WD;
    }
    return date('Y-m-d', $current_timestamp);
  }

  public static function normal_date($date)
  {
    if (!$date) {
      return '- -- ----';
    }
    return date("jS M Y", strtotime($date));
  }

  public static function normal_date_full_date($date)
  {
    if (!$date) {
      return '- -- ----';
    }
    return date("jS M Y, h:i a", strtotime($date));
  }

  public static function month_year_date($date)
  {
    if (!$date) {
      return '- -- ----';
    }
    return date("M Y", strtotime($date));
  }

  public static function mbs_to_bits($mbs = 2)
  {
    return 8000000 * $mbs;
  }

  public static function bits_to_mbs($bits = 1)
  {
    return 8000000 / $bits;
  }

  public static function date_to_time($date)
  {
    if (!$date) {
      return '- -- ----';
    }
    return date("H:i a", strtotime($date));
  }

  public static function full_year_format_date($date)
  {
    if (!$date) {
      return '- -- ----';
    }
    return date("j M Y", strtotime($date));
  }

  // change date to database date format
  public static function db_date_format($date)
  {
    if ($date == '') return null;
    return date("Y-m-d", strtotime($date));
  }

  // change date to database date format
  public static function db_date_format_timestamp($date = null)
  {
    if ($date) {
      return date("Y-m-d h:i:s", strtotime($date));
    }
    return date("Y-m-d h:i:s");
  }

  public static function db_date_format_timestamp_24_hours($date = null)
  {
    if ($date) {
      return date("Y-m-d H:i:s", strtotime($date));
    }
    return date("Y-m-d H:i:s");
  }

  public static function to_money_format($number)
  {
    return number_format($number, 0);
  }

  public static function get_years_between_dates($date1, $date2)
  {
    $d1 = new DateTime($date1);
    $d2 = new DateTime($date2);
    $diff = $d2->diff($d1);
    return $diff->y;
  }

  public static function get_picture_path($model, $file_name)
  {
    return 'Pictures/' . $model . '/' . $file_name;
  }

  public static function number_to_words($num)
  {

    $ones = array(
      0 => "Zero",
      1 => "One",
      2 => "Two",
      3 => "There",
      4 => "Four",
      5 => "Five",
      6 => "Six",
      7 => "Seven",
      8 => "Eight",
      9 => "Nine",
      10 => "Ten",
      11 => "Eleven",
      12 => "Twelve",
      13 => "Thirteen",
      14 => "Fourteen",
      15 => "Fifteen",
      16 => "Sixteen",
      17 => "Seventeen",
      18 => "Eigthteen",
      19 => "Nineteen",
      "014" => "Fourteen"
    );
    $tens = array(
      0 => "Zero",
      1 => "Ten",
      2 => "Twenty",
      3 => "Thirty",
      4 => "Forty",
      5 => "Fifty",
      6 => "Sixty",
      7 => "Seventy",
      8 => "Eighty",
      9 => "Ninety"
    );
    $hundreds = array(
      "Hundred",
      "Thousand",
      "Million",
      "Billion",
      "Trillion",
      "Quadrillion"
    ); /*limit t quadrillion */
    $num = number_format($num, 2, ".", ",");
    $num_arr = explode(".", $num);
    $wholenum = $num_arr[0];
    $decnum = $num_arr[1];
    $whole_arr = array_reverse(explode(",", $wholenum));
    krsort($whole_arr, 1);
    $rettxt = "";
    foreach ($whole_arr as $key => $i) {

      while (substr($i, 0, 1) == "0")
        $i = substr($i, 1, 5);
      if ($i < 20) {
        /* echo "getting:".$i; */
        $rettxt .= $ones[$i];
      } elseif ($i < 100) {
        if (substr($i, 0, 1) != "0")  $rettxt .= $tens[substr($i, 0, 1)];
        if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
      } else {
        if (substr($i, 0, 1) != "0") $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
        if (substr($i, 1, 1) != "0") $rettxt .= " " . $tens[substr($i, 1, 1)];
        if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
      }
      if ($key > 0) {
        $rettxt .= " " . $hundreds[$key] . " ";
      }
    }
    if ($decnum > 0) {
      $rettxt .= " and ";
      if ($decnum < 20) {
        $rettxt .= $ones[$decnum];
      } elseif ($decnum < 100) {
        $rettxt .= $tens[substr($decnum, 0, 1)];
        $rettxt .= " " . $ones[substr($decnum, 1, 1)];
      }
    }
    return $rettxt;
  }

  public static function to_singular($string)
  {
    return Str::singular($string);
  }

  public static function app_is_live()
  {
    return (App::environment(['production', 'staging'])) ? true : false;
  }

  public static function app_is_dev()
  {
    return (App::environment(['local'])) ? true : false;
  }

  public static function to_plural($string)
  {
    return Str::plural($string);
  }


  public static function encrypt_data($param)
  {
    return Crypt::encrypt($param);
  }

  public static function decrypt_data($param)
  {
    return Crypt::decrypt($param);
  }

  public static function replaceHyphenWithUnderScore($string)
  {
    return str_replace('-', '_', $string);
  }

  public static function StringifyWord($string)
  {
    $string = self::replaceHyphenWithUnderScore($string);
    return str_replace('_', ' ', $string);
  }

  public static function stripUnderScore($string)
  {
    return str_replace('_', ' ', $string);
  }

  public static function ucwords_strip_underscore($string, $char = '_')
  {
    return ucwords(str_replace($char, ' ', $string));
  }

  public static function ReplaceString($string, $find, $replace)
  {
    return str_replace($find, $replace, $string);
  }

  public static function UppercaseSubstring($string, $substring)
  {
    // return str_replace($find, $replace, $string);
  }

  public static function request_loader()
  {
    return '
      <div id="" class="request_loader_ form-group row hide">
      <div class="col-md-6 col-md-offset-5">
      <i class="ace-icon fa fa-spinner fa-spin orange bigger-225"></i> Please wait...
      </div>
      </div>
      ';
  }

  public static function SmartRecord($data = null)
  {
    return (!$data || $data == '') ? '-' : $data;
  }

  public static function clear_model_commentable($model)
  {
    return str_replace("App\\", "", $model);
  }

  public static function add_leading_zeros($number, $digits = 4)
  {
    return sprintf('%0' . $digits . 'd', $number);
  }

  public static function PwdDisabilityPhotographTypes()
  {
    return ['passport_photograph', 'disability_photograph', 'caretakers_photograph'];
  }

  public static function ComplaintDocumentTypes()
  {
    return ['issue_doc', 'issue_photo', 'response_doc', 'response_photo'];
  }

  public static function PwdGroupDocumentTypes()
  {
    return ['group_certificate', 'group_photograph', 'beneficiary_selection_meeting_minutes', 'group_constitution'];
  }

  public static function PwdGroupApplicationDocumentTypes()
  {
    return ['land_availability_proof', 'meeting_minutes', 'bank_statement'];
  }

  /**
   * Compares the similarity or two arrays
   * return true is are the same
   */
  public static function array_equal($a, $b)
  {
    return (is_array($a)
      && is_array($b)
      && count($a) == count($b)
      && array_diff($a, $b) === array_diff($b, $a));
  }

  public static function array_contains($a, $b)
  {
    if (is_array($a) && is_array($b)) {
      foreach ($a as $key) {
        if (!in_array($key, $b)) return false;
      }
      return true;
    }

    return false;
  }

  public static function AccordionTitle($title = '')
  {
    return $title = str_replace(str_split('\\. :'), '_', @$title);
  }

  public static function PhoneFormatter($phone)
  {
    $phone = str_replace(str_split('\\. ()-+'), '', @$phone);
    return $phone;
  }

  public static function PwdRegistrationSections()
  {
    return ['pwd_identification', 'pwd_contact', 'pwd_location', 'pwd_education', 'pwd_disability_identification', 'pwd_disability_description', 'pwd_disability_photographs', 'pwd_other_info', 'pwd_services_received', 'pwd_support_required'];
  }

  public static function getDocLocation($record, $tag, $useServerDocumentRoot = false)
  {
    if ($record && $record->documents) {
      // dd($tag);
      $document = @$record->documents->where('document_tag', $tag)->first();
      // dd ($document);
      if ($document) {
        // dd(@$document);
        // return 'sdfsdfsd';
        $path =  "/" . DOCUMENTS_DIR . '/' . ModelHelper::TableFromView(class_basename(@$document->documentable)) . '/' . @$document->paths;
        if ($useServerDocumentRoot) {
          return $_SERVER['DOCUMENT_ROOT'] . $path;
        }
        return asset($path);
      }
    }
    return false;
  }

  public static function document_tags()
  {
    return [
      /**
       * PWDs
       */
      'passport_photograph' => ['description' => 'Passport Photograph'],
      'disability_photograph' => ['description' => 'Disability Photograph'],
      'caretakers_photograph' => ['description' => 'Caretakers Photo with Beneficiaries'],

      /**
       * Groups
       */
      'group_photograph' => ['description' => 'Group Photograph'],
      'group_certificate' => ['description' => 'Group Registration/Certificate'],
      'beneficiary_selection_meeting_minutes' => ['description' => 'Minutes of Beneficiary Selection Meeting'],
      'land_availability_proof' => ['description' => 'Proof of Land Availability'],
      'publication' => ['description' => 'Publication'],
      'meeting_minutes' => ['description' => 'Meeting Minutes'],
      'bank_statement' => ['description' => 'Bank Statement'],
      'group_constitution' => ['description' => 'Group Constitution'],
      'ds_app_forwading_letter_cao' => ['description' => 'Forwarding Letter form CAO/Town Clerk'],
      'project_funding_request_schedule' => ['description' => 'Project Funding Request Schedule'],
      'minutes_dec_dptc' => ['description' => 'Minutes (DEC and/or DPTC)'],
      'issue_doc' => ['description' => 'Document'],
      'issue_photo' => ['description' => 'Photo'],
      'response_doc' => ['description' => 'Document'],
      'response_photo' => ['description' => 'Photo'],
    ];
  }

  public static function NationalDeskGroupAssessmentCriteria()
  {
    return [
      "Number of Group Members is within the recommended range of groups",
      "Pictures of the Disabled Members is credible i.e they show disability and the memebers present",
      "National IDS's of Members are present and Credible",
      "Inception Minutes are available and credible",
      "Project Type and Name are Credible, viable and legal",
      "Amount applied for is accepted",
      "Bank Account Name is Credible",
      "Bank Account Signotories are accepted",
      "The Leaders of the Group seem Credible"
    ];
  }

  public static function DeletableModules()
  {
    return [
      "pwds",
      "groups",
      "applications",
      // ""
    ];
  }

  public static function from_camel_case($input)
  {
    $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
    preg_match_all($pattern, $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
      $match = $match == strtoupper($match) ?
        strtolower($match) :
        lcfirst($match);
    }
    return implode('_', $ret);
  }

  public static function getPublicationDocument($record)
  {
    // return asset(PUBLICATIONS_DIR . '/' . $record->path);
  }

  public static function LogViewInfo($view)
  {
    Log::info('view: ' . $view . ' successfully created');
  }

  public static function CareakingParts()
  {
    /**
     * please maintain constant indexes, dont change any of them
     * we shall store them in the database and use them to build right reference to the users
     * If you want to add here another part, use a different index eg 'index'=> 4
     */

    // return array(
    //   array('index' => 1, 'text' => 'Beneficiary', 'slug' => NOT_CARETAKER,  'is_pwd' => true, "has_caretaker" => false),
    //   array('index' => 3, 'text' => 'Beneficiary with Caretaker', 'slug' => HAS_CARETAKER,  'is_pwd' => true, "has_caretaker" => true),
    //   array('index' => 2, 'text' => 'Is Caretaker who is Not a Beneficiary (i.e. NOT a PWD)', 'slug' => IS_CARETAKER,  'is_pwd' => false, "has_caretaker" => false),
    //   array('index' => 4, 'text' => 'Is Caretaker who is a Beneficiary (i.e. PWD)', 'slug' => IS_CARETAKER,  'is_pwd' => true, "has_caretaker" => false),
    // );
  }

  public static function CaretakingIndices()
  {
    // $indices = array();
    // foreach (self::CareakingParts() as $key => $part) {
    //   if (in_array(@$part['index'], [2, 4])) {
    //     array_push($indices, @$part['index']);
    //   }
    // }
    // return $indices;
  }

  public static function SearchMDArrayByValue($array, $columnm, $value)
  {
    return $key = array_search($value, array_column($array, $columnm));
  }

  public static function StringToArray($string, $case = 'strtoupper')
  {
    $searchWords = explode(' ', $string);
    return $searchWords = array_map($case, $searchWords);
  }

  public static function YesNo($string)
  {
    return $string ? "Yes" : "No";
  }

  public static function IdleTimeOutDuration()
  {
    return self::app_is_dev() ? config('session.lifetime') : 15;
  }


  public static function getRecordId($id, $allow_numeric = false)
  {
    if (is_numeric($id) && $allow_numeric) return 0;
    if (!@$id) return null;
    return is_numeric($id) ? $id : self::decrypt_data($id);
  }
}
