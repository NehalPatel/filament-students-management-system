<?php

namespace App\Imports;

use App\Models\Division;
use App\Models\Stream;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $stream_id = self::getStreamId($row['stream']);

        return new Student([
            'name' => $row['name'],
            'email' => $row['email'],
            'stream_id' => $stream_id,
            'division_id' => self::getDivisionId($stream_id, $row['division']),
        ]);
    }

    /**
     * Get the stream ID based on the stream name.
     *
     * @param mixed $stream
     * @return int|null
     */
    private static function getStreamId(mixed $stream): ?int
    {
        $streamRecord = Stream::where('name', $stream)->first();

        return $streamRecord?->id;
    }
    /**
     * Get the division ID based on stream ID and division name.
     *
     * @param int $stream_id
     * @param string $division
     * @return int|null
     */
    private static function getDivisionId(?int $stream_id, ?string $division): ?int
    {
        if ($stream_id === null || $division === null)
            return null;

        $division = Division::where('name', $division)
            ->where('stream_id', $stream_id)
            ->first();

        // return $division ? $division->id : null;
        return $division?->id;
    }
}
