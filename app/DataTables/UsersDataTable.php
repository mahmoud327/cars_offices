<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
   /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('العمليات', 'admin.users.actions')
            ->rawColumns(['العمليات']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->with('office')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {


        return $this->builder()
        ->setTableId('admindatatable-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('Blfrtip')
        ->orderBy(1)
        ->parameters([
            'dom'          => 'Blfrtip',
            'buttons'      => [


                [ 'extend' => 'reload', 'className' => 'btn btn-primary' , 'text' => '<i class="fa fa-retweet">' ],


            ],
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
                [

                    'name'              => 'id',
                    'data'              => 'id',
                    'title'             => '#',

                ],
                [

                    'name'              => 'name',
                    'data'              => 'name',
                    'title'             => 'الاسم',

                ],
                [

                    'name'              => 'email',
                    'data'              => 'email',
                    'title'             => 'البريد',

                ],
                [

                    'name'              => 'phone',
                    'data'              => 'phone',
                    'title'             => 'الهاتف',

                ],
                [

                    'name'              => 'office.name',
                    'data'              => 'office.name',
                    'title'             => 'المكتب',

                ],
                [

                    'name'              => 'العمليات',
                    'data'              => 'العمليات',
                    'title'             => 'العمليات',
                    'exportable'        => false,
                    'printable'         => false,
                    'orderable'         => false,
                    'searchable'        => false,
                ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'User_' . date('YmdHis');
    }
}
