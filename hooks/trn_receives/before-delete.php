<?php

if($data->status != 'NEW')
{
    redirectBack(['error' => 'Maaf, tidak bisa Hapus Penerimaan.. Karena Status bukan NEW lagi..','old' => $data]);
    die;
}