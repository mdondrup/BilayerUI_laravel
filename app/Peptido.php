<?php
// ICICIC Remove this file if not needed, it is just a template for showing the details of a single Peptido entity. You can customize it as needed.
namespace App;

use Illuminate\Database\Eloquent\Model;

class Peptido extends AppModel
{
    protected $table = 'peptides';

    public function getForeignKey() {
        return 'peptide_id';
    }
}