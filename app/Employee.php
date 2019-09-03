<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    public static function get_list()
    {
        $get = $_GET;
        foreach ($get as $key => $value) {
            $get[$key] = strtolower(htmlspecialchars($get[$key], ENT_QUOTES));
        }
        $search_date= $get['search_date'];
        $limit = 20;
        $offset = 0;
        if (!empty($_GET["iDisplayLength"])) {
            $limit = $_GET['iDisplayLength'];
            $offset = $_GET["iDisplayStart"];
        }
        $nquery = \DB::table('employees as e');
        if (!empty($get['sSearch_1'])) {
            $nquery->where('full_name', 'like', "%" . $get['sSearch_1'] . "%");
        }
        if (!empty($get['sSearch_2'])) {
            $nquery->where('dob', 'like', "%" . $get['sSearch_2'] . "%");
        }
        if (!empty($get['sSearch_3'])) {
            $nquery->where('gender', 'like', "%" . $get['sSearch_3'] . "%");

        }
        if (!empty($get['sSearch_4'])) {
            $nquery->where('salary', 'like', "%" . $get['sSearch_4'] . "%");
        }
        if (!empty($get['sSearch_5'])) {
            $nquery->where('designation', 'like', "%" . $get['sSearch_5'] . "%");
        }
        if(!empty($search_date)){
            $nquery->where('import_date','=',$search_date);
        }

        $query = \DB::table('employees as e');
        if (!empty($get['sSearch_1'])) {
            $query->where('full_name', 'like', "%" . $get['sSearch_1'] . "%");
        }
        if (!empty($get['sSearch_2'])) {
            $query->where('dob', 'like', "%" . $get['sSearch_2'] . "%");
        }
        if (!empty($get['sSearch_3'])) {
            $query->where('gender', 'like', "%" . $get['sSearch_3'] . "%");

        }
        if (!empty($get['sSearch_4'])) {
            $query->where('salary', 'like', "%" . $get['sSearch_4'] . "%");
        }
        if (!empty($get['sSearch_5'])) {
            $query->where('designation', 'like', "%" . $get['sSearch_5'] . "%");
        }
         if(!empty($search_date)){
            $query->where('import_date','=',$search_date);
        }
        $order_by = 'id';
        $order = 'asc';
        if ($get['sSortDir_0']) {
            $order = $get['sSortDir_0'];
        }
        if ($get['sSortDir_0'] == 1) {
            $order_by = 'full_name';
        }

        if ($get['sSortDir_0'] == 2) {
            $order_by = 'dob';
        }
        if ($get['sSortDir_0'] == 3) {
            $order_by = 'gender';
        }
        if ($get['sSortDir_0'] == 4) {
            $order_by = 'salary';
        }
        if ($get['sSortDir_0'] == 5) {
            $order_by = 'designation';
        }

        $query->orderBy($order_by, $order);
        if (!empty($offset)) {
            $query->offset($offset);
        }

        if ($limit) {
            $query->limit($limit);
        }

        $data = $query->get();

        $count = $nquery->count();

        $no_of_pages = ceil($count / $limit);
        if ($count > 0) {
            $ndata = $data;
            $ndata['totalrecs'] = $count;
            $ndata['totalfilteredrecs'] = $count;
        } else {
            $ndata = array();
            $ndata['totalrecs'] = 0;
            $ndata['totalfilteredrecs'] = 0;
        }
        return $ndata;
    }
}
