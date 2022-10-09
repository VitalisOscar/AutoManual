<?php

namespace App\Models;

use App\Traits\Misc\FormatedTime;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel{
    use FormatedTime;

    const MODEL_NAME = null;

    const TABLE_NAME = null;


    // Common Accessors

    /**
     * Datetime the model was created
     */
    function getFmtDateAttribute(){
        return $this->prettyDate($this->created_at);
    }
}
