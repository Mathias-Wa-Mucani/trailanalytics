<?php

namespace App\Repositories;

use App\Classes\ActionHelper;
use App\Classes\GeneralHelper;
use App\Classes\ModelHelper;
use App\Models\FinancialYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class Repository implements RepositoryInterface
{
    protected $user;

    /**      
     * @var Model      
     */
    protected $model;

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */
    public function __construct(Model $model)
    {
        // var_dump(request()->url());
        // var_dump(strpos(request()->url(), 'sisdfsdgnup', 0));
        // if (strpos(request()->url(), 'signup') == false) {
        //     @auth()->user() = JWTAuth::parseToken()->authenticate();
        // }

        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        DB::beginTransaction();

        try {
            //code...

            // var_dump($attributes);
            // return $this->model->create($attributes);
            foreach ($attributes as $field => $value) {
                if (ModelHelper::modelHasField($this->model, $field)) {
                    $this->model->{$field} = $value;
                }

                if (in_array($field, ActionHelper::ArrayAutoDates())) {
                    $this->model->{$field} = now();
                }

                if (in_array($field, ActionHelper::ArrayTimeStampFields())) {
                    $this->model->{$field} = GeneralHelper::db_date_format($value);
                }
            }

            /**
             *  check if user is logged in and whether this model/table has created_by column 
             *  then make them creaters of this record
             */
            if (ModelHelper::modelHasField($this->model, 'created_by')) {
                $this->model->created_by = @auth()->id();
            }

            /**
             * Check if record is related to a financial year
             * and set its recording to current fy
             */
            if (ModelHelper::modelHasField($this->model, 'stp_financial_year_id')) {
                $this->model->stp_financial_year_id = @FinancialYear::getCurrentFY()->id;
            }

            if (ModelHelper::modelHasField($this->model, 'stp_quarter_id')) {
                $this->model->stp_quarter_id = ModelHelper::getCurrentFinancialYearQuarter()->id;
            }



            $this->model->save();
            DB::commit();

            return $this->model;
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }
    }

    // update record in the database
    public function update(array $attributes, $id)
    {
        DB::beginTransaction();

        try {
            $record = $this->find($id);

            foreach ($attributes as $field => $value) {
                if (ModelHelper::modelHasField($record, $field)) {
                    $record->{$field} = $value;
                }

                if (in_array($field, ActionHelper::ArrayAutoDates())) {
                    $this->model->{$field} = now();
                }

                if (in_array($field, ActionHelper::ArrayTimeStampFields())) {
                    $this->model->{$field} = GeneralHelper::db_date_format($value);
                }
            }
            /**
             *  check if user is logged in 
             *  and make them creaters of this record
             */
            if (@auth()->user() && ModelHelper::modelHasField($record, 'updated_by')) {
                $record->updated_by = @auth()->id();
            }

            $record->save();
            DB::commit();
            return $record;
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }
    }

    // update record in the database
    public function update_by_field(array $attributes, $field, $fied_id)
    {
        DB::beginTransaction();

        try {
            // var_dump($attributes);
            $record = $this->model->where($field, $fied_id)->first();
            // return $record;

            foreach ($attributes as $field => $value) {
                if (ModelHelper::modelHasField($record, $field)) {
                    $record->{$field} = $value;
                }

                if (in_array($field, ActionHelper::ArrayAutoDates())) {
                    $this->model->{$field} = now();
                }

                if (in_array($field, ActionHelper::ArrayTimeStampFields())) {
                    $this->model->{$field} = GeneralHelper::db_date_format($value);
                }
            }

            if (@auth()->user() && ModelHelper::modelHasField($record, 'updated_by')) {
                $record->updated_by = @auth()->id();
            }

            // var_dump($record);

            $record->save();
            DB::commit();
            return $record;
            return $record;
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }
    }

    public function save_data($data)
    {
        return (@$data['id']) ? $this->update($data, @$data['id']) :  $this->create($data);
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
