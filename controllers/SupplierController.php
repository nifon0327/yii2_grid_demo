<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Supplier;
use app\common\helps\ExportTool;

class SupplierController extends Controller
{
    /**
     * 供应商列表页
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new Supplier();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 导出前筛选条件展示页
     * @return string
     */
    public function actionBeforeExport()
    {
        // 获取数据表字段
        $searchModel = new Supplier();
        $column = $searchModel->attributes();
        // 获取搜索框条件
        $params = Yii::$app->request->get('Supplier');
        return $this->render('beforeExport', ['column' => $column, 'params' => $params]);
    }

    /**
     * 导出列表.
     * @return void|array
     */
    public function actionExportSupplier()
    {
        // 获取参数
        $params = $this->request->get();
        $title = $params['filter'] . "\n";
        $fileName = '供应商' . date('Ymd') . '.csv';
        $filter_arr = explode(',', $params['filter']);
        // 简单校验
        if (!in_array('id', $filter_arr)) {
            return [false, 'id为必填项'];
        }
        // 获取数据
        $dataArr = Supplier::find()->select($params['filter']);

        // 查询条件
        !empty($params['id']) && $dataArr->andFilterWhere(['id' => $params['id']]);
        !empty($params['name']) && $dataArr->andFilterWhere(['like', 'name', urldecode($params['name'])]);
        !empty($params['code']) && $dataArr->andFilterWhere(['like', 'code', $params['code']]);
        !empty($params['t_status']) && $dataArr->andFilterWhere(['t_status' => $params['t_status']]);

        $dataArr = $dataArr->asArray()->all();

        $dataStr = '';
        // 将数据拟合成CSV需要的格式
        if (!empty($dataArr)) {
            foreach ($dataArr as $value) {
                foreach ($filter_arr as $key => $item) {
                    if ($key == 0) {
                        $dataStr .= $value[$item];
                    } else {
                        $dataStr .= ',' . $value[$item];
                    }
                }
                $dataStr = ltrim($dataStr, ',');
                $dataStr .= "\n";
            }
        }
        // 导出
        ExportTool::exportCSV($dataStr, $fileName, $title);
    }
}