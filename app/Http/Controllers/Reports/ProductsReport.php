<?php


namespace App\Http\Controllers\Reports;


use App\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsReport implements FromQuery, WithHeadings, WithMapping,ShouldQueue
{
    use Exportable;

    /**
     * @return Builder
     */
    public function query()
    {
        return Product::query();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ["#ID", "NAME", "DESCRIPTION", "TYPE", "PRICE", "QUANTITY", "CREATED_AT"];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->name,
            $row->description,
            $row->type,
            $row->price,
            $row->quantity,
            $row->created_at
        ];
    }
}
