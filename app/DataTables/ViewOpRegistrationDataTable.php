<?php

namespace App\DataTables;

use App\Classes\GeneralHelper;
use App\Models\Views\ViewOpRegistration;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ViewOpRegistrationDataTable extends DataTable
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

        $datatable->addColumn('date_established', function ($record) {
            return GeneralHelper::normal_date($record->date_established);
        });

        $datatable->addColumn('males', function ($record) {
        });

        $datatable->addColumn('females', function ($record) {
        });
        
        $datatable->addColumn('telephone', function ($record) {
        });

        $datatable->addColumn('action', function ($record) {
            // return view(GeneralHelper::DashboardPath('project_management.dt_columns.project_action'), compact('record'));
        });

        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Views\ViewOpRegistration $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ViewOpRegistration $model)
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
            ->minifiedAjax()
            ->addAction([
                'buttons' => ['Edit', 'Delete'],
            ]);
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
            Column::make('full_name')->title('Name'),
            Column::make('district'),
            Column::make('nin'),
            Column::make('elder_number')->title('Elder No.'),
            // Column::make('age'),
            Column::make('sex_text'),
            Column::make('person_type')->title('Type'),
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
