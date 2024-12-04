<?php

$having = "";

if($filter)
{
    $filter_query = [];
    foreach($filter as $f_key => $f_value)
    {
        $filter_query[] = "$f_key = '$f_value'";
    }

    $filter_query = implode(' AND ', $filter_query);

    $having = (empty($having) ? 'HAVING ' : ' AND ') . $filter_query;
}

$where = $where ." ". $having;

$order_clause = "ORDER BY ".$col_order." ".$order[0]['dir'];
if($draw == 1)
{
    $order_clause = "ORDER BY outgoing_date desc, code asc";
}

$this->db->query = "SELECT * FROM $this->table $where $order_clause LIMIT $start,$length";
$data  = $this->db->exec('all');

$total = $this->db->exists($this->table,$where);

return compact('data', 'total');