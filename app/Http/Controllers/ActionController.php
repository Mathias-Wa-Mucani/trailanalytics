<?php

namespace App\Http\Controllers;

use App\Classes\ActionHelper;
use App\Classes\GeneralHelper;
use App\Classes\ModelHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\EmailController;
use App\Models\BudgetItem;
use App\Models\FinancialYear;
use App\Models\SystemSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use View;

class ActionController extends ApiController
{
  public $_arr_input_fields = array();
  public $_input_table;
  public $arrayTimeStampFields = [];
  public $arrayValueSplit = array('shipTo');
  public $arrayPasswords = [];
  public $arrayImageFolders = [];
  public $arrayPhoneNumberFields = [];
  public $arrayAutoDates = [];
  public $arrayNumericFields = [];
  public $arrayTablesAllowDuplicates = [];
  public $_transactionId;
  public $modelService;
  public $_post_data;
  public $_message;
  public $_record;

  /**
   * Create a new controller instance.
   */
  protected $emailService;
  protected $fileService;
  protected $workFlowController;
  public function __construct(EmailController $emailService, FileUploadController $fileService, ModelController $modelService)
  {
    $this->middleware('auth');
    $this->emailService = $emailService;
    $this->fileService = $fileService;
    $this->modelService = $modelService;
    $this->arrayTimeStampFields = ActionHelper::ArrayTimeStampFields();
    $this->arrayPasswords = ActionHelper::ArrayPasswords();
    $this->arrayImageFolders = ActionHelper::ArrayImageFolders();
    $this->arrayNumericFields = ActionHelper::ArrayNumericFields();
    $this->arrayTablesAllowDuplicates = ActionHelper::ArrayTablesAllowDuplicates();
    $this->arrayPhoneNumberFields = ActionHelper::ArrayPhoneNumberFields();
    $this->arrayAutoDates = ActionHelper::ArrayAutoDates();
  }

  /**
   * Store record from the form
   * It calls the _addNewRec function with the right input tag array
   * returns last insert id for new record
   */
  public function store()
  {
    $this->_post_data = request()->all();
    $table = $this->_post_data['table'];

    // dd($this->_post_data);  
    //

    /**
     * saving system settings
     */

    if ($table == '' && @$this->_post_data['system_settings_count']) {
      // return 0;
      // $this->multipleSave('system_settings', 'system_settings_count', class_basename(SystemSetting::class), @$this->_post_data['required_field']);
    }

    /**
     * direct saving
     */
    else {

      /**
       * if we are registering or updating pwd CF71018102JMJL, CM63026100FYLA
       */
      if ($table == 'registration') {
        // dd(@$this->_post_data['r_fld']['nin']);
        // $pwd = PwdRegistration::find(@$this->_post_data['fld_id']);
        // $ninExisting = false;
        // if (@$pwd) {
        //   $ninExisting = PwdRegistration::where('nin', @$this->_post_data['r_fld']['nin'])->whereNotIn('id', [@$pwd->id])->whereNotNull('nin')->first();
        // } else {
        //   $ninExisting = PwdRegistration::whereNotNull('nin')->where('nin', @$this->_post_data['r_fld']['nin'])->first();
        // }

        // if ($ninExisting) {
        //   return $this->errorResponse("NIN is already registered");
        // }
        // /**
        //  * Converts contact data to json
        //  */
        // if (@$this->_post_data['contact_info']) {
        //   foreach (@$this->_post_data['contact_info'] as $key => $contact) {
        //     if (in_array($key, $this->arrayPhoneNumberFields)) {
        //       $this->_post_data['contact_info'][$key] = GeneralHelper::PhoneFormatter($contact);
        //     }
        //   }
        //   $this->_post_data['r_fld']['contact'] = json_encode(@$this->_post_data['contact_info']);
        // }
      }

      /**
       * if we are saving a group
       */
      else if ($table == 'GroupRegistration') {
        // dd(@$this->_post_data['group_members']);
        // $members = @$this->_post_data['group_members']['pwd_registration_id'] ?? [];
        // $members = array_filter($members, function ($id) {
        //   return $id;
        // });

        // $num_members = count($members);
        // if ($num_members < MINIMUM_GROUP_MEMBERS_COUNT) {
        //   return $this->errorResponse("Group should contain a minimum of " . MINIMUM_GROUP_MEMBERS_COUNT . ' individuals');
        // }
      }

      /**
       * if we are saving a group application
       */
      else if ($table == 'PwdGroupApplication') {
        // $statistics = PwdGroupStats::where('id', @$this->_post_data['r_fld']['pwd_grp_a_registration_id'])->first();
        // // dd((int)$table);
        // if ((int)@$statistics->num_members < MINIMUM_GROUP_MEMBERS_COUNT) {
        //   return $this->errorResponse("Group should contain a minimum of " . MINIMUM_GROUP_MEMBERS_COUNT . ' individuals');
        // }
      }
      // dd($this->_post_data);
      /*****************************************************************************************************
       * save to database
       * ***************************************************************************************************
       */

      DB::beginTransaction();
      try {

        $this->_transactionId = $this->_addNewRec('r_fld');

        if ($table == "PwdRegistration" && @$this->_post_data['pwd_services_received']) {
          // $this->multipleSave('pwd_services_received', 'pwd_services_received_count', class_basename(PwdRegistrationService::class));
        }


        // add to budget
        if (@$this->_post_data['budget_item']) {
          $this->multipleSave('budget_item', 'budget_item_count', class_basename(BudgetItem::class));
        }

        // 
        if ($table == "FinancialYear" && @$this->_post_data['is_current']) {
          FinancialYear::setCurrentFinancialYear($this->_record);
        }

        /**
         * Check if deletion is set for record
         */
        if (@$this->_post_data['r_fld']['delete_reason_id']) {
          $this->delete($table, $this->_transactionId);
        }

        DB::commit();
      } catch (\Throwable $th) {
        DB::rollback();
        throw $th;
      }

      // unset($this->_post_data['fld_id']);
      /**
       * ***************************************************************************************************
       */
    }


    return response()->json([
      'success' => true,
      'message' => $this->_message,
      'id' => $this->_transactionId
    ]);
  }

  /**
   * _addNewRec()
   * responsible for adding a new record into the system
   * Parameters: _input_table, _arr_input_fields, arrayId
   * Returns: 1 (on fail), array() (on success)
   */
  function _addNewRec($arrayId = 'r_fld')
  {
    $this->_arr_input_fields = $this->_post_data[$arrayId];
    $this->_input_table = $this->_post_data['table'];

    $model = "App\\Models\\" . $this->_input_table;

    /**
     * Check if record exists, create a new one if it does'nt
     */
    @$this->_post_data['fld_id'];
    $record = @$this->_post_data['fld_id'] ? $model::find(@$this->_post_data['fld_id']) : new $model();

    /**
     * Set creator of this record to current logged in user
     */
    if (ModelHelper::modelHasField($record, 'created_by')) $record->created_by = @auth()->user()->id;

    /**
     * Check if record is updating
     * Set current logged in user as record updater
     */

    if (ModelHelper::modelHasField($record, 'updated_by')) $record->updated_by = @auth()->user()->id;

    /**
     * Check if record is related to a financial year
     * and set its recording to current fy
     */


    foreach ($this->_arr_input_fields as $field => $value) {
      if (is_array($value)) {
        $value = implode(':::', $value);
      }
      /////////////////////////////////////
      if (in_array($field, $this->arrayTimeStampFields)) {
        $value = GeneralHelper::db_date_format($value);
      } elseif (in_array($field, $this->arrayPasswords)) {
        $value = Hash::make($value);
      } elseif (in_array($field, $this->arrayNumericFields)) {
        $value = (int) str_replace(',', '', $value);
      } elseif (in_array($field, $this->arrayPhoneNumberFields)) {
        $value = GeneralHelper::PhoneFormatter($value);
      } elseif (in_array($field, $this->arrayAutoDates)) {
        $value = Carbon::now();
      } elseif (in_array($field, $this->arrayValueSplit)) {
        $_a_values = $value;
        if (is_array($value)) {
          $value = '';
          foreach ($_a_values as $_val) {
            $value .= $_val . ':::';
          }
        }
      }
      $record->$field = $value;
    }

    if (@$record->id == '' || @$record->id == null) unset($record->id);
    // dd($record);
    $record->save();

    $this->_record = $record;

    //check if record is not intended to be deleted with reason
    if (!@$this->_post_data['r_fld']['delete_reason_id']) {
      $this->_message .= '<br>' . $this->_input_table . ' successfully saved <br>';
    }
    return $record->id;
  }


  function multipleSave($input_array, $row_count_array, $table, $required_field = '')
  {
    // we shall use upsert method here
    // dd($input_array);



    // $this->_post_data[$input_array] = &$this->_post_data[$input_array];

    $this->_post_data[$input_array] = unserialize(serialize($this->_post_data[$input_array]));

    // dd($this->_post_data[$input_array]);
    unset($this->_post_data['new_array_']);
    $required_fields = @$this->_post_data['multiple_save_required_fields'];

    if (@$required_fields) {
      $required_fields = explode(',', $required_fields);
    } else {
      $required_fields = [];
    }
    // dd($required_fields);

    $updateIds = ActionHelper::UpdateIds();
    $important_fields = ActionHelper::ImportantFields();

    $foreign_keys = ActionHelper::ForeignKeys();

    $items = $this->_post_data[$row_count_array];
    // $this->_post_data[$input_array]["id"][1] = 1;
    // dd($this->_post_data[$input_array]["id"]);

    $items_new = [];

    $num = count($items);
    for ($i = 0; $i < $num; $i++) {
      // dd(@$this->_post_data[$input_array]);
      // $id = $this->_post_data['fld_id'] = $this->_post_data[$input_array][$updateIds[$table]][$i];

      // dd(@$this->_post_data[$input_array][$important_fields[$table]]);

      if (@$important_fields[$table] && !@$this->_post_data[$input_array][$important_fields[$table]][$i]) continue;

      foreach ($this->_post_data[$input_array] as $_fld => $val) {

        if ($required_field && !@$this->_post_data[$input_array][$important_fields[$table]][$i]) continue;

        if (@$this->_post_data[$input_array][$_fld]) {
          // $items_new[$i][$_fld] = $val[$i];
          $items_new[$i][$_fld] = @$val[$i];
        }
        if ($_fld == @$foreign_keys[@$table] && !@$val[$i]) {
          $items_new[$i][$_fld] = @$this->_transactionId;
        }
      }
    }


    // dd($items_new);
    $model = "App\\Models\\" . $table;
    $ids = array();
    $id = '';

    // foreach ($required_fields as $required_field) {
    // }

    // foreach ($items_new as $key => $value) {
    //   // if ($items_new[$key]['id'] == null) unset($items_new[$key]['id']);
    // }
    // dd($items_new);
    // $model::upsert($items_new, 'id');
    // return;


    foreach ($items_new as $item) {
      $continue = false;
      // dd($required_fields);
      // dd($item);
      if (count($required_fields)) {
        foreach ($required_fields as $required_field) {
          if (!@$item[$required_field]) {
            $continue = true;
            continue 1;
          }
        }
      }

      // dd($continue);

      if ($continue) continue;
      // // dd($item);
      // if (in_array() && !@$item[$required_field]) continue;

      $record = ModelHelper::save_model($model, $item);
      !in_array($record->id, $ids) ? array_push($ids, $record->id) : '';
    }

    if (@$this->_post_data['delete_rows'] || @$foreign_keys[$table] && !@$this->_post_data['multiple_save_retain_current_data']) {
      $foreignId = @$this->_transactionId ?? @$this->_post_data[$input_array][$foreign_keys[$table]][0];

      // dd($model);

      $model = "App\\Models\\" . $table;


      $model::where($foreign_keys[$table], $foreignId)->whereNotIn('id', $ids)->delete();
      $result = $model::where($foreign_keys[$table], $foreignId);
      $result->whereNotIn('id', $ids)->each(function ($part) {
        $part->delete();
      });
    }
    $this->_message .= $table . ' successfully saved <br>';
  }

  /**
   * delete()
   * responsible for deleting a record from the system
   * Parameters: table, id
   * Returns: 1 (on fail), array() (on success)
   */
  function delete($table = '', $id = 0)
  {
    // $model->relation()->exists()
    $model = "App\\Models\\" . $table;
    $record = $model::find($id);

    /**
     * Set current as responsible for record deletion
     */
    if (ModelHelper::modelHasField($record, 'deleted_by')) {
      $record->deleted_by = auth()->user()->id;
      $record->save();
    }

    $record->delete();
    $this->_message .= $table . ' deleted successfully';

    return response()->json([
      'success' => true,
      'message' => $this->_message,
      'id' => $this->_transactionId
    ]);
  }

  /**
   * deleles model parts/relationships
   */
  function delete_table_parts($model, $part = '', $id = 0)
  {
    $model = "App\\Models\\" . $model;
    $record = $model::find($id);

    $this->_message .= $part . ' deleted successfully';

    return response()->json([
      'success' => true,
      'message' => $this->_message,
      'id' => $this->_transactionId
    ]);
  }
}
