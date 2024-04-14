<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudentsExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct(public Collection $records) {}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->records;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Stream',
            'Division'
        ];
    }

    public function map($student): array
    {
        return [
            $student->name,
            $student->email,
            $student->stream->name,
            $student->division->name,

        ];
    }
}
