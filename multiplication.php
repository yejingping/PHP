<?php
//九九乘法表
    header("content-type:text/html;charset=uft-8");
    for($i=1;$i<10;$i++)
    {
        for($j=0;$j<$i;$j++)
        {
            echo $i.'X'.($j+1).'='.$i*($j+1);
            echo "&nbsp;&nbsp;";

        }
        echo "<br/>";

    }
?>
