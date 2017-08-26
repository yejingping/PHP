<?php
date_default_timezone_set('PRC');
//修改字符集
header("content-type:text/html;charset=utf-8");
//H:24小时 h:12小时 i:05分钟 s:05秒 w:0-6周日到周六 t:31 一个月多少天 L：是否为闰年。 microtime微秒
//万年历
//1.几年几月几日
//2.周日到周六
//3.一号是星期几
//4.这个月有多少天
//5.上一年和下一年
//6.上一月和下一月

//获取当前年
$year=$_GET['y']?$_GET['y']:date('Y');

//获取当前月
$month=$_GET['m']?$_GET['m']:date('m');

//获取当前月的天数
$days=date('t',strtotime("{$year}-{$month}-1"));

//当前一号是周几
$week=date('w',strtotime("{$year}-{$month}-1"));

//所有内容居中
echo "<center>";
//输出表头
echo "<h2>{$year}年{$month}月</h2>";
//输出日期表格
echo "<table width='700px' border='1px'>";
echo "<tr>";
echo "<th>周日</th>";
echo "<th>周一</th>";
echo "<th>周二</th>";
echo "<th>周三</th>";
echo "<th>周四</th>";
echo "<th>周五</th>";
echo "<th>周六</th>";
echo "</tr>";

//具体的天数
for($i=1-$week;$i<$days;)
{
    echo "<tr>";
    for($j=0;$j<7;$j++)
    {
        if($i>$days||$i<1)
        {
            echo "<td>&nbsp;</td>";
        }
        else
         {
            echo "<td>{$i}</td>";
         }
        $i++;

    }
    echo "</tr>";
}
echo "</table>";
//实现上一年和上一月
if($month==1)
{
    $prevyear=$year-1;
    $prevmonth=12;
}else{
    $prevmonth=$month-1;
}

if($month==12)
{
    $nextyear=$year+1;
    $nextmonth=1;
}
else
{
    $nextyear=$year;
    $nextmonth=$month+1;
}

//输出上一月和下一月
echo "<h2><a href='perCalendar.php?y={$prevyear}&m={$prevmonth}'>上一月</a>|<a href='perCalendar.php?y={$nextyear}&m={$nextmonth}'>下一月</a></h2>";
echo "</center>";

?>
