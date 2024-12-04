<?php

use Modules\Crud\Libraries\Sdk\CrudGuardIndex;
use Core\Database;

CrudGuardIndex::set('master', 'crud/edit', function(){

    if($_GET['table'] == 'trn_receives')
    {
        $db = new Database;
        $receive = $db->exists('trn_receives', [
            'status' => 'NEW',
            'id' => $_GET['id']
        ]);
        
        if(!$receive)
        {
            redirectBack(['error' => 'Maaf, tidak bisa Edit Penerimaan.. Karena Status bukan NEW lagi..']);
            return;
        }
    }
    
    if($_GET['table'] == 'trn_outgoings')
    {
        $db = new Database;
        $outgoing = $db->exists('trn_outgoings', [
            'status' => 'NEW',
            'id' => $_GET['id']
        ]);
        
        if(!$outgoing)
        {
            redirectBack(['error' => 'Maaf, tidak bisa Edit Pengeluaran.. Karena Status bukan NEW lagi..']);
            return;
        }
    }
});