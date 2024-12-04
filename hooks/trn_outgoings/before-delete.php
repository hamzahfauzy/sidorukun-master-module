<?php

if($data->status != 'NEW')
{
    redirectBack(['error' => 'Maaf, tidak bisa Hapus Pengeluaran.. Karena Status bukan NEW lagi..','old' => $data]);
    die;
}