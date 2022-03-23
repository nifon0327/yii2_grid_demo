<?php
use kartik\grid\GridView;

// 字段展示
$gridColumns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    'id',
    'name',
    'code',
    [
        'attribute' => 't_status',
        'label' => '状态',
        'value' =>
            function ($model) {
                return $model['t_status'];
            },
        'filter' => ['ok' => 'ok', 'hold' => 'hold'],
    ],
];

echo '<button class="btn btn-large btn-primary" onclick="beforeExport()" type="button">导出全部结果</button>';

// grid view 渲染页面
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns
]);

?>

<script>
    // 获取url形参
    function GetRequest() {
        const url = location.search;
        let theRequest = new Object();
        if (url.indexOf("?") != -1) {
            let str = url.substr(1);
            strs = str.split("&");
            for (let i = 0; i < strs.length; i++) {
                theRequest[strs[i].split("=")[0]] = decodeURI(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    }
    // 跳转导出前筛选条件页面
    function beforeExport() {
        var url = 'index.php?r=supplier/before-export'
        var params = (GetRequest());
        Object.keys(params).forEach(function (key) {
            if (params[key] && key !== 'r') {
                url += '&' + key + '=' + params[key]
            }
        })
        window.open(url, "_blank");
    }
</script>

