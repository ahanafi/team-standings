<?php

namespace App\DataTables;

use App\Models\MatchResult;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MatchResultsDataTable extends DataTable
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
    public function query(MatchResult $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->with(['homeTeam', 'awayTeam'])
            ->latest('match_results.created_at');

        if (request()->filled('search') && request('search')['value'] !== '') {
            $value = request('search')['value'];

            $query = $query->whereHas('homeTeam', function ($q) use ($value) {
                return $q->where('name', 'LIKE', "%" . $value . "%");
            })
            ->orWhereHas('awayTeam', function ($q) use ($value) {
                return $q->where('name', 'LIKE', "%" . $value . "%");
            });
        }

        return $query;

    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('match-results-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0)
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('row_number')
                ->title('#')
                ->render('meta.row + meta.settings._iDisplayStart + 1;')
                ->width(50)
                ->orderable(false)
                ->searchable(false),
            Column::make('home_team.name')
                ->title('Home Team')
                ->addClass('text-start'),
            Column::make('away_team.name')
                ->title('Away Team')
                ->addClass('text-start'),
            Column::make('home_score')->searchable(false),
            Column::make('away_score')->searchable(false),
            Column::make('created_at')->searchable(false),
            Column::make('updated_at')->searchable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'MatchResults_' . date('YmdHis');
    }
}
