<?php

namespace App\DataTables;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TeamStandingsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Team $model): QueryBuilder
    {
        return $model->newQuery()
            ->select('id', 'name', 'played', 'won', 'drawn', 'lost', 'goal_for', 'goal_against', 'points')
            ->orderBy('points', 'DESC')
            ->orderBy('goal_for', 'DESC')
            ->orderBy('goal_against', 'ASC');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('team-standings-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('played'),
            Column::make('won'),
            Column::make('drawn'),
            Column::make('lost'),
            Column::make('goal_for'),
            Column::make('goal_against'),
            Column::make('points'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'TeamStandings_' . date('YmdHis');
    }
}
