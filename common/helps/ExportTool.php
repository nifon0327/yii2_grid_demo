<?php

namespace app\common\helps;

class ExportTool
{
    /**
     * 导出CSV文件.
     * @param string $file
     * @param string $title
     * @param $data
     * @return void
     */
    public static function exportCSV($data, string $file = '', string $title = '')
    {
        header("Content-Disposition:attachment;filename=" . $file);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        //表头
        $wrstr = $title;

        //内容
        $wrstr .= $data;

        $wrstr = iconv("utf-8", "GBK//ignore", $wrstr);

        echo $wrstr;
        die;
    }
}