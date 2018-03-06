<?php

namespace App\Models\Students;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Student extends Model
{
    use SoftDeletes;
    use Userstamps;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function certificate()
    {
        return $this->belongsTo(StudentListCertificate::class);
    }

    public function gender()
    {
        return $this->belongsTo(StudentListGender::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(StudentListPaymentMethod::class);
    }

    public function position()
    {
        return $this->belongsTo(StudentListPosition::class);
    }

    public function store()
    {
        return $this->belongsTo(StudentListStore::class);
    }

    public function study()
    {
        return $this->belongsTo(StudentListStudy::class);
    }
}