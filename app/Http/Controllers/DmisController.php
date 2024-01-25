<?php

namespace App\Http\Controllers;

use App\Classes\ModelHelper;
use App\Http\Controllers\Api\ApiController;
use App\Models\Bank;
use App\Models\Dmis\DmisBank;
use App\Models\Dmis\DmisFinancialYear;
use App\Models\Dmis\DmisProjectIndustry;
use App\Models\Dmis\DmisQuarter;
use App\Models\Dmis\DmisUnitMeasure;
use App\Models\FinancialYear;
use App\Models\ProjectIndustry;
use App\Models\Quarter;
use App\Models\UnitMeasure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DmisController extends ApiController
{
    public function import_dmis_data()
    {
        // $this->import_financial_years();
        // $this->import_quarters();
        // $this->import_banks();
        // $this->import_project_Industries();
        $this->import_unit_measures();


        return $this->successMessage("Data successfully Imported");
    }

    /**
     * import financial years
     */
    public function import_financial_years()
    {
        $records = DmisFinancialYear::all();
        FinancialYear::truncate();
        foreach ($records as $record) {
            $data = [
                'dmis_financial_year_id' => @$record->id,
                'name' => @$record->name,
                'actual_year' => @$record->actual_year,
                'start_date' => @$record->start_date,
                'end_date' => @$record->end_date,
                'status' => @$record->status,
                'is_current' => @$record->is_current,
                'used' => @$record->used,
                'deleted_at' => @$record->deleted_at,
            ];

            ModelHelper::save_model(FinancialYear::class, $data);
        }
    }


    /**
     * import financial years
     */
    public function import_quarters()
    {
        $records = DmisQuarter::all();
        // dd($records);
        Quarter::truncate();
        foreach ($records as $record) {
            $data = [
                'dmis_quarter_id' => @$record->id,
                'name' => @$record->name,
                'abbreviation' => @$record->abbreviation,
                'start_date' => @$record->start_date,
                'end_date' => @$record->end_date,
                'used' => @$record->used,
                'deleted_at' => @$record->deleted_at,
            ];

            ModelHelper::save_model(Quarter::class, $data);
        }
    }


    /**
     * import banks
     */
    public function import_banks()
    {
        $records = DmisBank::all();
        Bank::truncate();
        foreach ($records as $record) {
            $data = [
                'dmis_bank_id' => @$record->id,
                'name' => @$record->name,
                'abbreviation' => @$record->abbreviation,
                'deleted_at' => @$record->deleted_at,
            ];

            ModelHelper::save_model(Bank::class, $data);
        }
    }

    /**
     * import project industries
     */
    public function import_project_Industries()
    {
        $records = DmisProjectIndustry::all();
        ProjectIndustry::truncate();
        foreach ($records as $record) {
            $data = [
                'dmis_project_industry_id' => @$record->id,
                'abbreviation' => @$record->abbreviation,
                'name' => @$record->name,
                'deleted_at' => @$record->deleted_at,
            ];

            ModelHelper::save_model(ProjectIndustry::class, $data);
        }
    }


    /**
     * import project industries
     */
    public function import_unit_measures()
    {
        $records = DmisUnitMeasure::all();
        UnitMeasure::truncate();
        foreach ($records as $record) {
            $data = [
                'dmis_unit_measure_id' => @$record->id,
                'abbreviation' => @$record->abbreviation,
                'name' => @$record->name,
                'deleted_at' => @$record->deleted_at,
            ];

            ModelHelper::save_model(UnitMeasure::class, $data);
        }
    }
}
