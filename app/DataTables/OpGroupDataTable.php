<?php

namespace App\DataTables;

use App\Classes\GeneralHelper;
use App\Models\OpGroupRegistration;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OpGroupDataTable extends DataTable
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

        $datatable->addColumn('district', function ($record) {
            return @$record->district->district;
        });

        $datatable->addColumn('action', function ($record) {
            // return view(GeneralHelper::DashboardPath('project_management.dt_columns.project_action'), compact('record'));
        });

        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Views\OpGroupRegistration $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OpGroupRegistration $model)
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
            ->setTableId('projects-table')
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
            Column::computed('district')->title("District"),
            Column::make('tin')->title("TIN/REG No."),
            Column::computed('established'),
            Column::computed('males'),
            Column::computed('females'),
            Column::computed('telephone'),
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
        return 'Projects_' . date('YmdHis');
    }
}
