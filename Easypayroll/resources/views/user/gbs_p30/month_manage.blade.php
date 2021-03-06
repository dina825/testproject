@extends('userheader')
@section('content')
<style>
.table_bg>thead>tr>th
{
    text-align:left;
}
.select_button table tbody tr td a{
    background: #000;
    text-align: center;
    padding: 8px 12px;
    color: #fff;
    float: left;
    width: 100%;
}
.select_button table tbody tr td a:hover{
    background: #000;
    text-align: center;
    padding: 8px 12px;
    color: #fff;
    float: left;
    width: 100%;
}
.select_button table tbody tr td label{
    color:#000 !important;
    font-weight:800;
    margin-top:6px;
}
</style>
<div class="content_section">
  <div class="page_title">
    SELECT MONTH
    
  </div>
    <div class="select_button">
        <table class="table table_bg">
          <thead>
            <tr class="background_bg">
                <th>P30 Periods <?php echo $year->year_name; ?></th>
                <th>NO OF TASKS</th>
                <th>NO OF TASKS COMPLETED</th>
                <th>NO OF TASKS INCOMPLETE</th>
                <th>DATES</th>

            </tr>
          </thead>
          <tbody>
            <?php
            $end_date = $year->end_date;
            $arraydate = array();
            if(count($monthlist)){
              foreach($monthlist as $month){
                $start_month_date = date('Y-F-01',strtotime($end_date));
                $end_month_date = date('Y-F-t',strtotime($end_date));

                $explode_start = explode('-',$start_month_date);
                $explode_end = explode('-',$end_month_date);
                $start_month_date = $explode_start[1].' '.$explode_start[2].' '.$explode_start[0];
                $end_month_date = $explode_end[1].' '.$explode_end[2].' '.$explode_end[0];

                array_push($arraydate,$start_month_date.' - '.$end_month_date);
                $end_date = date('Y-m-d', strtotime("+2 days", strtotime(date('Y-m-t',strtotime($end_date)))));
              }
            }
            if(count($monthlist)){
                $count = count($arraydate) - 1;
              foreach($monthlist as $month){
                $task_count = DB::table('p30_task')->where('task_month',$month->month_id)->count();
                $task_completed = DB::table('p30_task')->where('task_month',$month->month_id)->where('task_status',1)->count();
                $task_incomplete = DB::table('p30_task')->where('task_month',$month->month_id)->where('task_status',0)->count();

                if($month->month == 1) { $month_name = "January"; }
                if($month->month == 2) { $month_name = "February"; }
                if($month->month == 3) { $month_name = "March"; }
                if($month->month == 4) { $month_name = "April"; }
                if($month->month == 5) { $month_name = "May"; }
                if($month->month == 6) { $month_name = "June"; }
                if($month->month == 7) { $month_name = "July"; }
                if($month->month == 8) { $month_name = "August"; }
                if($month->month == 9) { $month_name = "September"; }
                if($month->month == 10) { $month_name = "October"; }
                if($month->month == 11) { $month_name = "November"; }
                if($month->month == 12) { $month_name = "December"; }
            ?>

            <tr>
                <td style="text-align:left; border:1px solid #000"><a href="<?php echo URL::to('user/gbs_p30_select_month/'.base64_encode($month->month_id))?>" class="btn" style="text-align:left;"><?php echo $month->month.'. '.$month_name; ?> P30</a></td>
                <td style="text-align:center; border:1px solid #000"><label><?php echo $task_count; ?></label></td>
                <td style="text-align:center; border:1px solid #000"><label><?php echo $task_completed; ?></label></td>
                <td style="text-align:center; border:1px solid #000"><label><?php echo $task_incomplete; ?></label></td>
                <td style="text-align:left; margin-left:15px;  border:1px solid #000"><label><?php echo $arraydate[$count]; ?></label></td>
            </tr>
            <?php 
            $count = $count - 1;
            } } 
            else{
                echo "Month Not Found";
            }?>
          </tbody>            
        </table>
        
    </div>
</div>
@stop