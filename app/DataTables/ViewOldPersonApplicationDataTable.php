<?php

namespace App\DataTables;

use App\Classes\GeneralHelper;
use App\Models\Views\ViewOldPersonApplication;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ViewOldPersonApplicationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $datatable = datatables()->eloquent($query);

        $datatable->addColumn('estimated_budget', function ($record) {
            return GeneralHelper::to_money_format($record->est_total_cost);
        });

        $datatable->addColumn('amount_requested', function ($record) {
            return GeneralHelper::to_money_format($record->total_budget);
        });

        $datatable->addColumn('males', function ($record) {
        });

        $datatable->addColumn('females', function ($record) {
        });

        $datatable->addColumn('telephone', function ($record) {
            return @$record->contact_info->contact_sec_telephone;
        });

        $datatable->addColumn('action', function ($record) {
            return view(GeneralHelper::DashboardPath('applications.dt_columns.application_action'), compact('record'));
        });

        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Views\ViewOldPersonApplication $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ViewOldPersonApplication $model)
    {
        return $model->newQuery()->orderBy('created_at', 'DESC');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('ViewOldPersonApplication-table')
            ->columns($this->getColumns())
            ->minifiedAjax();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('group_name'),
            // Column::make('district'),
            Column::make('project_industry'),
            Column::computed('estimated_budget'),
            Column::computed('amount_requested'),
            Column::make('implementation_period')->title('Est. Period'),
            Column::computed('action')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ViewOldPersonApplication' . date('YmdHis');
    }
}
