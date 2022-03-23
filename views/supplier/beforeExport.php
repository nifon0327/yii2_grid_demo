<?php
echo '<form id="filter_form">';
foreach ($column as $c) {
    echo '<input type="checkbox" id="' . $c . '" name="' . $c . '" checked> ' . $c;
}
echo '</form>';
echo '<button onclick="exportCSV()">确认</button>';
?>
<script>
    // 获取参数php传参（对象）
    var params = '<?php echo json_encode($params);?>';
    var column = '<?php echo json_encode($column);?>';
    params = JSON.parse(params);
    column = JSON.parse(column);

    // 拼接导出参数后导出
    function exportCSV() {
        var form = document.getElementById("filter_form");
        var formData = new FormData(form);
        var filter = [];
        var num = 0;
        console.log(formData.get('id'));
        for (var i = 0; i < column.length; ++i) {
            if (formData.get(column[i]) === 'on') {
                filter[num] = column[i]
                num++;
            }
        }
        var filter_str = filter.join(',')

        var url = 'index.php?r=supplier/export-supplier'

        url += '&filter=' + filter_str
        // 判断下有没有参数
        if (params) {
            Object.keys(params).forEach(function (key) {
                url += '&' + key + '=' + params[key]
            })
        }
        window.location.href = encodeURI(url)
    }

    // 防止id点击事件
    var oId = document.getElementById('id');
    oId.onclick = function () {
        //未选中事件
        if (!this.checked) {
            alert('ID为必选项');
            oId.click();
        }
    }
</script>
