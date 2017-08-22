<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use frontend\models\Formmodel;

class IpdSurPctController extends Controller
{
    public $mText = "งานศัลยกรรมทั่วไป โรคที่น่าสนใจ(PCT) ";
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }          
    public function actionPct1Index() {
        $model = new Formmodel();
        $names="ผลการดำเนินงานการให้บริการ PCT-ศัลยกรรม (Necrotising fasciitis)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['pct1_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-sur/pct/pct1_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionPct1_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t1;")->execute();
        $dt1="CREATE TEMPORARY TABLE t1 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd10 BETWEEN 'M7261'  AND 'M7269' 
                GROUP BY i.an
                );";
        $rt1 = \Yii::$app->db1->createCommand($dt1)->execute();      
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t2;")->execute();
        $dt2="CREATE TEMPORARY TABLE t2 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd10 = 'R572' 
                GROUP BY i.an
                );";
        $rt2 = \Yii::$app->db1->createCommand($dt2)->execute();      
        
        $rawData=[];
        $sql1="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
		      ) pt;";                                                       
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pname' => $value1['pname'],
               'goal' => '',
               'oct' => $value1['Oct'],
               'nov' => $value1['Nov'],
               'dec' => $value1['Dece'],
               'jan' => $value1['Jan'],
               'feb' => $value1['Feb'],
               'mar' => $value1['Mar'],
               'apr' => $value1['Apr'],
               'may' => $value1['May'],
               'jun' => $value1['Jun'],
               'jul' => $value1['Jul'],
               'aug' => $value1['Aug'],
               'sep' => $value1['Sep'],
               'total' => $value1['total'], 
        ];               
        }      
        $sql2="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis With Shock' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
			INNER JOIN t2 ON t1.an=t2.an 
		      ) pt;";                                                       
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
               'goal' => '',
               'oct' => $value2['Oct'],
               'nov' => $value2['Nov'],
               'dec' => $value2['Dece'],
               'jan' => $value2['Jan'],
               'feb' => $value2['Feb'],
               'mar' => $value2['Mar'],
               'apr' => $value2['Apr'],
               'may' => $value2['May'],
               'jun' => $value2['Jun'],
               'jul' => $value2['Jul'],
               'aug' => $value2['Aug'],
               'sep' => $value2['Sep'],
               'total' => $value2['total'], 
        ];               
        }      
        $sql3="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis เสียชีวิต' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('08','09')
		      ) pt;";                                                       
        $result3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
        foreach ($result3 as $value3) {
        $rawData[]=[
               'id' => '',
               'pname' => $value3['pname'],
               'goal' => '',
               'oct' => $value3['Oct'],
               'nov' => $value3['Nov'],
               'dec' => $value3['Dece'],
               'jan' => $value3['Jan'],
               'feb' => $value3['Feb'],
               'mar' => $value3['Mar'],
               'apr' => $value3['Apr'],
               'may' => $value3['May'],
               'jun' => $value3['Jun'],
               'jul' => $value3['Jul'],
               'aug' => $value3['Aug'],
               'sep' => $value3['Sep'],
               'total' => $value3['total'], 
        ];               
        }      
        $sql4="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis ที่รับไว้รักษาต่อ (Refer In)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    INNER JOIN referin r ON t1.vn=r.vn
		    ) pt;";                                                       
        $result4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
        foreach ($result4 as $value4) {
        $rawData[]=[
               'id' => '',
               'pname' => $value4['pname'],
               'goal' => '',
               'oct' => $value4['Oct'],
               'nov' => $value4['Nov'],
               'dec' => $value4['Dece'],
               'jan' => $value4['Jan'],
               'feb' => $value4['Feb'],
               'mar' => $value4['Mar'],
               'apr' => $value4['Apr'],
               'may' => $value4['May'],
               'jun' => $value4['Jun'],
               'jul' => $value4['Jul'],
               'aug' => $value4['Aug'],
               'sep' => $value4['Sep'],
               'total' => $value4['total'], 
        ];               
        }      
        $sql5="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis ที่ได้รับการส่งต่อ (Refer Out)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('04')
		    ) pt;";                                                       
        $result5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
        foreach ($result5 as $value5) {
        $rawData[]=[
               'id' => '',
               'pname' => $value5['pname'],
               'goal' => '',
               'oct' => $value5['Oct'],
               'nov' => $value5['Nov'],
               'dec' => $value5['Dece'],
               'jan' => $value5['Jan'],
               'feb' => $value5['Feb'],
               'mar' => $value5['Mar'],
               'apr' => $value5['Apr'],
               'may' => $value5['May'],
               'jun' => $value5['Jun'],
               'jul' => $value5['Jul'],
               'aug' => $value5['Aug'],
               'sep' => $value5['Sep'],
               'total' => $value5['total'], 
        ];               
        }      

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/ipd-sur/pct/pct1_preview',
                    ['dataProvider' => $dataProvider,
                        'names' => $names,
                        'mText' => $this->mText, 
                        'date1' => $date1, 
                        'date2' => $date2,
                        'yrs' => $yrs]);          
    }
    
    public function actionPct2Index() {
        $model = new Formmodel();
        $names="ผลการดำเนินงานการให้บริการ PCT-ศัลยกรรม (Appendicitis)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['pct2_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-sur/pct/pct2_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionPct2_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t1;")->execute();
        $dt1="CREATE TEMPORARY TABLE t1 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd10 IN('K352','K353','K358','K36','K37','K38') 
                GROUP BY i.an
                );";
        $rt1 = \Yii::$app->db1->createCommand($dt1)->execute();      
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t2;")->execute();
        $dt2="CREATE TEMPORARY TABLE t2 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptoprt o ON i.an=o.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND o.icd9 IN('4701','4709') 
                GROUP BY i.an
                );";
        $rt2 = \Yii::$app->db1->createCommand($dt2)->execute();      
        
        $rawData=[];
        $sql1="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendicitis ' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
		      ) pt;";                                                       
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pname' => $value1['pname'],
               'goal' => '',
               'oct' => $value1['Oct'],
               'nov' => $value1['Nov'],
               'dec' => $value1['Dece'],
               'jan' => $value1['Jan'],
               'feb' => $value1['Feb'],
               'mar' => $value1['Mar'],
               'apr' => $value1['Apr'],
               'may' => $value1['May'],
               'jun' => $value1['Jun'],
               'jul' => $value1['Jul'],
               'aug' => $value1['Aug'],
               'sep' => $value1['Sep'],
               'total' => $value1['total'], 
        ];               
        }      
        $sql2="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendectomy' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
			INNER JOIN t2 ON t1.an=t2.an 
		      ) pt;";                                                       
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
               'goal' => '',
               'oct' => $value2['Oct'],
               'nov' => $value2['Nov'],
               'dec' => $value2['Dece'],
               'jan' => $value2['Jan'],
               'feb' => $value2['Feb'],
               'mar' => $value2['Mar'],
               'apr' => $value2['Apr'],
               'may' => $value2['May'],
               'jun' => $value2['Jun'],
               'jul' => $value2['Jul'],
               'aug' => $value2['Aug'],
               'sep' => $value2['Sep'],
               'total' => $value2['total'], 
        ];               
        }      
        $sql3="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendicitis เสียชีวิต' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('08','09')
		      ) pt;";                                                       
        $result3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
        foreach ($result3 as $value3) {
        $rawData[]=[
               'id' => '',
               'pname' => $value3['pname'],
               'goal' => '',
               'oct' => $value3['Oct'],
               'nov' => $value3['Nov'],
               'dec' => $value3['Dece'],
               'jan' => $value3['Jan'],
               'feb' => $value3['Feb'],
               'mar' => $value3['Mar'],
               'apr' => $value3['Apr'],
               'may' => $value3['May'],
               'jun' => $value3['Jun'],
               'jul' => $value3['Jul'],
               'aug' => $value3['Aug'],
               'sep' => $value3['Sep'],
               'total' => $value3['total'], 
        ];               
        }      
        $sql4="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendicitis ที่รับไว้รักษาต่อ (Refer In)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    INNER JOIN referin r ON t1.vn=r.vn
		    ) pt;";                                                       
        $result4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
        foreach ($result4 as $value4) {
        $rawData[]=[
               'id' => '',
               'pname' => $value4['pname'],
               'goal' => '',
               'oct' => $value4['Oct'],
               'nov' => $value4['Nov'],
               'dec' => $value4['Dece'],
               'jan' => $value4['Jan'],
               'feb' => $value4['Feb'],
               'mar' => $value4['Mar'],
               'apr' => $value4['Apr'],
               'may' => $value4['May'],
               'jun' => $value4['Jun'],
               'jul' => $value4['Jul'],
               'aug' => $value4['Aug'],
               'sep' => $value4['Sep'],
               'total' => $value4['total'], 
        ];               
        }      
        $sql5="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendicitis ที่ได้รับการส่งต่อ (Refer Out)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('04')
		    ) pt;";                                                       
        $result5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
        foreach ($result5 as $value5) {
        $rawData[]=[
               'id' => '',
               'pname' => $value5['pname'],
               'goal' => '',
               'oct' => $value5['Oct'],
               'nov' => $value5['Nov'],
               'dec' => $value5['Dece'],
               'jan' => $value5['Jan'],
               'feb' => $value5['Feb'],
               'mar' => $value5['Mar'],
               'apr' => $value5['Apr'],
               'may' => $value5['May'],
               'jun' => $value5['Jun'],
               'jul' => $value5['Jul'],
               'aug' => $value5['Aug'],
               'sep' => $value5['Sep'],
               'total' => $value5['total'], 
        ];               
        }      

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/ipd-sur/pct/pct2_preview',
                    ['dataProvider' => $dataProvider,
                        'names' => $names,
                        'mText' => $this->mText, 
                        'date1' => $date1, 
                        'date2' => $date2,
                        'yrs' => $yrs]);          
    }
    
    public function actionPct3Index() {
        $model = new Formmodel();
        $names="ผลการดำเนินงานการให้บริการ PCT-ศัลยกรรม (ที่ทำหัตถการ EGD/Colonoscope/Hernioraphy/Wipple Operation)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['pct3_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-sur/pct/pct3_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionPct3_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t1;")->execute();
        $dt1="CREATE TEMPORARY TABLE t1 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype,d.icd9
                FROM ipt i
                INNER JOIN iptoprt d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd9 IN('4513','4523','4516','5300','5302','5310','5253') 
                GROUP BY i.an
                );";
        $rt1 = \Yii::$app->db1->createCommand($dt1)->execute();      
        
        $rawData=[];
        $sql1="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'EGD (ICD9CM=4513)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE icd9='4513'
		      ) pt;";                                                       
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pname' => $value1['pname'],
               'goal' => '',
               'oct' => $value1['Oct'],
               'nov' => $value1['Nov'],
               'dec' => $value1['Dece'],
               'jan' => $value1['Jan'],
               'feb' => $value1['Feb'],
               'mar' => $value1['Mar'],
               'apr' => $value1['Apr'],
               'may' => $value1['May'],
               'jun' => $value1['Jun'],
               'jul' => $value1['Jul'],
               'aug' => $value1['Aug'],
               'sep' => $value1['Sep'],
               'total' => $value1['total'], 
        ];               
        }      
        $sql2="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'Colonoscope (ICD9CM=4516)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE icd9='4516'
		    ) pt;";                                                       
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
               'goal' => '',
               'oct' => $value2['Oct'],
               'nov' => $value2['Nov'],
               'dec' => $value2['Dece'],
               'jan' => $value2['Jan'],
               'feb' => $value2['Feb'],
               'mar' => $value2['Mar'],
               'apr' => $value2['Apr'],
               'may' => $value2['May'],
               'jun' => $value2['Jun'],
               'jul' => $value2['Jul'],
               'aug' => $value2['Aug'],
               'sep' => $value2['Sep'],
               'total' => $value2['total'], 
        ];               
        }      
        $sql3="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'EGD With Biobsy (ICD9CM=4516)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.icd9='4516'
		      ) pt;";                                                       
        $result3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
        foreach ($result3 as $value3) {
        $rawData[]=[
               'id' => '',
               'pname' => $value3['pname'],
               'goal' => '',
               'oct' => $value3['Oct'],
               'nov' => $value3['Nov'],
               'dec' => $value3['Dece'],
               'jan' => $value3['Jan'],
               'feb' => $value3['Feb'],
               'mar' => $value3['Mar'],
               'apr' => $value3['Apr'],
               'may' => $value3['May'],
               'jun' => $value3['Jun'],
               'jul' => $value3['Jul'],
               'aug' => $value3['Aug'],
               'sep' => $value3['Sep'],
               'total' => $value3['total'], 
        ];               
        }      
        $sql4="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'Hernioraphy (ICD9CM=5300,5302,5310)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.icd9 IN('5300','5302','5310')
		      ) pt;";                                                       
        $result4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
        foreach ($result4 as $value4) {
        $rawData[]=[
               'id' => '',
               'pname' => $value4['pname'],
               'goal' => '',
               'oct' => $value4['Oct'],
               'nov' => $value4['Nov'],
               'dec' => $value4['Dece'],
               'jan' => $value4['Jan'],
               'feb' => $value4['Feb'],
               'mar' => $value4['Mar'],
               'apr' => $value4['Apr'],
               'may' => $value4['May'],
               'jun' => $value4['Jun'],
               'jul' => $value4['Jul'],
               'aug' => $value4['Aug'],
               'sep' => $value4['Sep'],
               'total' => $value4['total'], 
        ];               
        }      
        $sql5="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'Wipple Operation (ICD9CM=5253)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.icd9='5253'
		    ) pt;";                                                       
        $result5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
        foreach ($result5 as $value5) {
        $rawData[]=[
               'id' => '',
               'pname' => $value5['pname'],
               'goal' => '',
               'oct' => $value5['Oct'],
               'nov' => $value5['Nov'],
               'dec' => $value5['Dece'],
               'jan' => $value5['Jan'],
               'feb' => $value5['Feb'],
               'mar' => $value5['Mar'],
               'apr' => $value5['Apr'],
               'may' => $value5['May'],
               'jun' => $value5['Jun'],
               'jul' => $value5['Jul'],
               'aug' => $value5['Aug'],
               'sep' => $value5['Sep'],
               'total' => $value5['total'], 
        ];               
        }      

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/ipd-sur/pct/pct3_preview',
                    ['dataProvider' => $dataProvider,
                        'names' => $names,
                        'mText' => $this->mText, 
                        'date1' => $date1, 
                        'date2' => $date2,
                        'yrs' => $yrs]);          
    }
    
    public function actionPct4Index() {
        $model = new Formmodel();
        $names="ผลการดำเนินงานการให้บริการ PCT-ศัลยกรรม (UGI Bleeding)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['pct4_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-sur/pct/pct4_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionPct4_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t1;")->execute();
        $dt1="CREATE TEMPORARY TABLE t1 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype,a.admdate,i.spclty
                FROM ipt i
                INNER JOIN an_stat a ON i.an=a.an
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND ((d.icd10 BETWEEN 'K262' AND 'K269') OR d.icd10 = 'K260' OR (d.icd10 BETWEEN 'K290' AND 'K299') 
                OR (d.icd10 BETWEEN 'K252' AND 'K259')  OR d.icd10 = 'K250' OR d.icd10 in ('I850','I859','K226'))               
                GROUP BY i.an
                );";
        $rt1 = \Yii::$app->db1->createCommand($dt1)->execute();      
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t2;")->execute();
        $dt2="CREATE TEMPORARY TABLE t2 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd10='R571' 
                GROUP BY i.an
                );";
        $rt2 = \Yii::$app->db1->createCommand($dt2)->execute();      
        
        $rawData=[];
        $sql1="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding ' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE admdate>1 AND spclty = '02'
		      ) pt;";                                                       
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pname' => $value1['pname'],
               'goal' => '',
               'oct' => $value1['Oct'],
               'nov' => $value1['Nov'],
               'dec' => $value1['Dece'],
               'jan' => $value1['Jan'],
               'feb' => $value1['Feb'],
               'mar' => $value1['Mar'],
               'apr' => $value1['Apr'],
               'may' => $value1['May'],
               'jun' => $value1['Jun'],
               'jul' => $value1['Jul'],
               'aug' => $value1['Aug'],
               'sep' => $value1['Sep'],
               'total' => $value1['total'], 
        ];               
        }      
        $sql2="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding With Shock' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                      FROM t1 
	        INNER JOIN t2 ON t1.an=t2.an 
                      WHERE t1.spclty='02'  
		      ) pt;";                                                       
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
               'goal' => '',
               'oct' => $value2['Oct'],
               'nov' => $value2['Nov'],
               'dec' => $value2['Dece'],
               'jan' => $value2['Jan'],
               'feb' => $value2['Feb'],
               'mar' => $value2['Mar'],
               'apr' => $value2['Apr'],
               'may' => $value2['May'],
               'jun' => $value2['Jun'],
               'jul' => $value2['Jul'],
               'aug' => $value2['Aug'],
               'sep' => $value2['Sep'],
               'total' => $value2['total'], 
        ];               
        }      
        $sql3="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding With EGD' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                       FROM t1 
	        INNER JOIN iptoprt i ON t1.an=i.an
                    WHERE i.icd9='4513' and t1.spclty='02' and t1.admdate>1
		      ) pt;";                                                       
        $result3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
        foreach ($result3 as $value3) {
        $rawData[]=[
               'id' => '',
               'pname' => $value3['pname'],
               'goal' => '',
               'oct' => $value3['Oct'],
               'nov' => $value3['Nov'],
               'dec' => $value3['Dece'],
               'jan' => $value3['Jan'],
               'feb' => $value3['Feb'],
               'mar' => $value3['Mar'],
               'apr' => $value3['Apr'],
               'may' => $value3['May'],
               'jun' => $value3['Jun'],
               'jul' => $value3['Jul'],
               'aug' => $value3['Aug'],
               'sep' => $value3['Sep'],
               'total' => $value3['total'], 
        ];               
        }      

        $sql4="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding เสียชีวิต' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('08','09') and t1.spclty='02'
		      ) pt;";                                                       
        $result4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
        foreach ($result4 as $value4) {
        $rawData[]=[
               'id' => '',
               'pname' => $value4['pname'],
               'goal' => '',
               'oct' => $value4['Oct'],
               'nov' => $value4['Nov'],
               'dec' => $value4['Dece'],
               'jan' => $value4['Jan'],
               'feb' => $value4['Feb'],
               'mar' => $value4['Mar'],
               'apr' => $value4['Apr'],
               'may' => $value4['May'],
               'jun' => $value4['Jun'],
               'jul' => $value4['Jul'],
               'aug' => $value4['Aug'],
               'sep' => $value4['Sep'],
               'total' => $value4['total'], 
        ];               
        }      
        $sql5="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding ที่รับไว้รักษาต่อ (Refer In)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    INNER JOIN referin r ON t1.vn=r.vn WHERE t1.spclty='02'
		    ) pt;";                                                       
        $result5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
        foreach ($result5 as $value5) {
        $rawData[]=[
               'id' => '',
               'pname' => $value5['pname'],
               'goal' => '',
               'oct' => $value5['Oct'],
               'nov' => $value5['Nov'],
               'dec' => $value5['Dece'],
               'jan' => $value5['Jan'],
               'feb' => $value5['Feb'],
               'mar' => $value5['Mar'],
               'apr' => $value5['Apr'],
               'may' => $value5['May'],
               'jun' => $value5['Jun'],
               'jul' => $value5['Jul'],
               'aug' => $value5['Aug'],
               'sep' => $value5['Sep'],
               'total' => $value5['total'], 
        ];               
        }      
        $sql6="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding ที่ได้รับการส่งต่อ (Refer Out)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('04') AND t1.spclty='02'
		    ) pt;";                                                       
        $result6 = \Yii::$app->db1->createCommand($sql6)->queryAll();
        foreach ($result6 as $value6) {
        $rawData[]=[
               'id' => '',
               'pname' => $value6['pname'],
               'goal' => '',
               'oct' => $value6['Oct'],
               'nov' => $value6['Nov'],
               'dec' => $value6['Dece'],
               'jan' => $value6['Jan'],
               'feb' => $value6['Feb'],
               'mar' => $value6['Mar'],
               'apr' => $value6['Apr'],
               'may' => $value6['May'],
               'jun' => $value6['Jun'],
               'jul' => $value6['Jul'],
               'aug' => $value6['Aug'],
               'sep' => $value6['Sep'],
               'total' => $value6['total'], 
        ];               
        }      

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/ipd-sur/pct/pct4_preview',
                    ['dataProvider' => $dataProvider,
                        'names' => $names,
                        'mText' => $this->mText, 
                        'date1' => $date1, 
                        'date2' => $date2,
                        'yrs' => $yrs]);          
    }
    
    



}