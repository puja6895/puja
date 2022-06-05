<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Demo;
use Illuminate\Support\Facades\Http;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

class FileExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $res = Http::get('https://opencontext.org/subjects-search/Turkey/Kenan+Tepe.json');
        $result = $res->collect()->collapse()->filter(function ($value, $key) {
            return is_array($value) ? true : false;
        });
        // $result_with_id = $result->pluck('id')->all();
        // dd($result);

        // $return_result = collect($result_with_id);
        // $demo = Demo::all();
        // dd($demo,$return_result);
        return collect($result);
       
    }
}
