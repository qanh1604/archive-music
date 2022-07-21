<?php

namespace App\Models;

use App\Models\Translation;
use App\Models\Translationv2;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;

class TranslationImport implements ToModel
{
    public function model(array $row)
    {
        $new_translation = new Translation;
        $new_translation->lang = 'vn';
        $new_translation->lang_key = $row[0];
        $new_translation->lang_value = $row[1];
        $new_translation->save();
        
        return $new_translation;
    }
}
