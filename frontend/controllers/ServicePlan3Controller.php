<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class ServicePlan3Controller extends Controller
{
    public $mText = "ผลการดำเนินงานการให้บริการ(Service Plan)";
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
    public function actionIndex() {
        $model = new Formmodel();
        $names="ผลการดำเนินงานการให้บริการโรคไต"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/service_plan3/index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionPreview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        $rawData=[];
        $rawData[]=[
               'id' => '',
               'pname' => 'มีการจัดตั้ง CKD Clinic ในรพช. ทุกระดับ',
               'goal' => '100 %',
               'oct' => '',
               'nov' => '',
               'dec' => '',
               'jan' => '',
               'feb' => '',
               'mar' => '',
               'apr' => '',
               'may' => '',
               'jun' => '',
               'jul' => '',
               'aug' => '',
               'sep' => '',
               'total' => '', 
        ];   
        $sql2 = "select 'จำนวนผู้ป่วย CKD ทั้งหมด' as pname,count(*) total from clinicmember where clinic='029' 
                    and (dchdate is null or dchdate = '');";
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
               'goal' => '',
               'oct' => '',
               'nov' => '',
               'dec' => '',
               'jan' => '',
               'feb' => '',
               'mar' => '',
               'apr' => '',
               'may' => '',
               'jun' => '',
               'jul' => '',
               'aug' => '',
               'sep' => '',
               'total' => $value2['total'], 
        ];               
        }     
        $rawData[]=[
               'id' => '',
               'pname' => 'จำนวนผู้ป่วย Continuous Ambulatory Pedtoneal Dialysis (C.A.P.D) ทั้งหมด',
               'goal' => '',
               'oct' => '',
               'nov' => '',
               'dec' => '',
               'jan' => '',
               'feb' => '',
               'mar' => '',
               'apr' => '',
               'may' => '',
               'jun' => '',
               'jul' => '',
               'aug' => '',
               'sep' => '',
               'total' => '', 
        ];  
        $rawData[]=[
               'id' => '',
               'pname' => 'จำนวนผู้ป่วย Hemodialysis (H.K) ทั้งหมด',
               'goal' => '',
               'oct' => '',
               'nov' => '',
               'dec' => '',
               'jan' => '',
               'feb' => '',
               'mar' => '',
               'apr' => '',
               'may' => '',
               'jun' => '',
               'jul' => '',
               'aug' => '',
               'sep' => '',
               'total' => '', 
        ];  
        $sql5 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'จำนวนผู้ป่วย CKD ที่ได้รับการตรวจ eGFR ทั้งหมด (GFR-EPI)' as pname,count(*) total,
                             count(if(month(v.vstdate)=10,1,null)) as Oct,
                             count(if(month(v.vstdate)=11,1,null)) as Nov,
                             count(if(month(v.vstdate)=12,1,null))  as Dece,
                             count(if(month(v.vstdate)=1,1,null))  as Jan,
                             count(if(month(v.vstdate)=2,1,null))  as Feb,
                             count(if(month(v.vstdate)=3,1,null))  as Mar,
                             count(if(month(v.vstdate)=4,1,null))  as Apr,
                             count(if(month(v.vstdate)=5,1,null))  as May,
                             count(if(month(v.vstdate)=6,1,null))  as Jun,
                             count(if(month(v.vstdate)=7,1,null))  as Jul,
                             count(if(month(v.vstdate)=8,1,null))  as Aug,
                             count(if(month(v.vstdate)=9,1,null)) as Sep
                             from clinicmember c inner join vn_stat v on c.hn=v.hn 
                             inner join ovst_gfr o on v.vn=o.vn where clinic = '029' and v.vstdate between '{$date1}' and '{$date2}' ) pt;";
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
        $sql6 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'ระยะที่ 1 (GFR > 90.00 ml/min)' as pname,count(*) total,
                             count(if(month(v.vstdate)=10,1,null)) as Oct,
                             count(if(month(v.vstdate)=11,1,null)) as Nov,
                             count(if(month(v.vstdate)=12,1,null))  as Dece,
                             count(if(month(v.vstdate)=1,1,null))  as Jan,
                             count(if(month(v.vstdate)=2,1,null))  as Feb,
                             count(if(month(v.vstdate)=3,1,null))  as Mar,
                             count(if(month(v.vstdate)=4,1,null))  as Apr,
                             count(if(month(v.vstdate)=5,1,null))  as May,
                             count(if(month(v.vstdate)=6,1,null))  as Jun,
                             count(if(month(v.vstdate)=7,1,null))  as Jul,
                             count(if(month(v.vstdate)=8,1,null))  as Aug,
                             count(if(month(v.vstdate)=9,1,null)) as Sep
                             from clinicmember c inner join vn_stat v on c.hn=v.hn 
                             inner join ovst_gfr o on v.vn=o.vn where clinic = '029' and v.vstdate between  '{$date1}' and '{$date2}' 
                             and o.egfr >= 90 ) pt;";
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
        $sql7 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'ระยะที่ 2 (GFR  60.00 - 89.99 ml/min)' as pname,count(*) total,
                             count(if(month(v.vstdate)=10,1,null)) as Oct,
                             count(if(month(v.vstdate)=11,1,null)) as Nov,
                             count(if(month(v.vstdate)=12,1,null))  as Dece,
                             count(if(month(v.vstdate)=1,1,null))  as Jan,
                             count(if(month(v.vstdate)=2,1,null))  as Feb,
                             count(if(month(v.vstdate)=3,1,null))  as Mar,
                             count(if(month(v.vstdate)=4,1,null))  as Apr,
                             count(if(month(v.vstdate)=5,1,null))  as May,
                             count(if(month(v.vstdate)=6,1,null))  as Jun,
                             count(if(month(v.vstdate)=7,1,null))  as Jul,
                             count(if(month(v.vstdate)=8,1,null))  as Aug,
                             count(if(month(v.vstdate)=9,1,null)) as Sep
                             from clinicmember c inner join vn_stat v on c.hn=v.hn 
                             inner join ovst_gfr o on v.vn=o.vn where clinic = '029' and v.vstdate between '{$date1}' and '{$date2}' 
                             and o.egfr between 60 and 89.99 ) pt;";
        $result7 = \Yii::$app->db1->createCommand($sql7)->queryAll();
        foreach ($result7 as $value7) {
        $rawData[]=[
               'id' => '',
               'pname' => $value7['pname'],
               'goal' => '',
               'oct' => $value7['Oct'],
               'nov' => $value7['Nov'],
               'dec' => $value7['Dece'],
               'jan' => $value7['Jan'],
               'feb' => $value7['Feb'],
               'mar' => $value7['Mar'],
               'apr' => $value7['Apr'],
               'may' => $value7['May'],
               'jun' => $value7['Jun'],
               'jul' => $value7['Jul'],
               'aug' => $value7['Aug'],
               'sep' => $value7['Sep'],
               'total' => $value7['total'], 
        ];               
        }  
        $sql8 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'ระยะที่ 3A (GFR 45.00 - 59.99 ml/min)' as pname,count(*) total,
                             count(if(month(v.vstdate)=10,1,null)) as Oct,
                             count(if(month(v.vstdate)=11,1,null)) as Nov,
                             count(if(month(v.vstdate)=12,1,null))  as Dece,
                             count(if(month(v.vstdate)=1,1,null))  as Jan,
                             count(if(month(v.vstdate)=2,1,null))  as Feb,
                             count(if(month(v.vstdate)=3,1,null))  as Mar,
                             count(if(month(v.vstdate)=4,1,null))  as Apr,
                             count(if(month(v.vstdate)=5,1,null))  as May,
                             count(if(month(v.vstdate)=6,1,null))  as Jun,
                             count(if(month(v.vstdate)=7,1,null))  as Jul,
                             count(if(month(v.vstdate)=8,1,null))  as Aug,
                             count(if(month(v.vstdate)=9,1,null)) as Sep
                             from clinicmember c inner join vn_stat v on c.hn=v.hn 
                             inner join ovst_gfr o on v.vn=o.vn where clinic = '029' and v.vstdate between '{$date1}' and '{$date2}' 
                             and o.egfr between 45 and 59.99 ) pt;";        
        $result8 = \Yii::$app->db1->createCommand($sql8)->queryAll();
        foreach ($result8 as $value8) {
        $rawData[]=[
               'id' => '',
               'pname' => $value8['pname'],
               'goal' => '',
               'oct' => $value8['Oct'],
               'nov' => $value8['Nov'],
               'dec' => $value8['Dece'],
               'jan' => $value8['Jan'],
               'feb' => $value8['Feb'],
               'mar' => $value8['Mar'],
               'apr' => $value8['Apr'],
               'may' => $value8['May'],
               'jun' => $value8['Jun'],
               'jul' => $value8['Jul'],
               'aug' => $value8['Aug'],
               'sep' => $value8['Sep'],
               'total' => $value8['total'], 
        ];               
        }
        $sql9 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'ระยะที่ 3B (GFR 30.00 - 44.99 ml/min)' as pname,count(*) total,
                             count(if(month(v.vstdate)=10,1,null)) as Oct,
                             count(if(month(v.vstdate)=11,1,null)) as Nov,
                             count(if(month(v.vstdate)=12,1,null))  as Dece,
                             count(if(month(v.vstdate)=1,1,null))  as Jan,
                             count(if(month(v.vstdate)=2,1,null))  as Feb,
                             count(if(month(v.vstdate)=3,1,null))  as Mar,
                             count(if(month(v.vstdate)=4,1,null))  as Apr,
                             count(if(month(v.vstdate)=5,1,null))  as May,
                             count(if(month(v.vstdate)=6,1,null))  as Jun,
                             count(if(month(v.vstdate)=7,1,null))  as Jul,
                             count(if(month(v.vstdate)=8,1,null))  as Aug,
                             count(if(month(v.vstdate)=9,1,null)) as Sep
                             from clinicmember c inner join vn_stat v on c.hn=v.hn 
                             inner join ovst_gfr o on v.vn=o.vn where clinic = '029' and v.vstdate between '{$date1}' and '{$date2}' 
                             and o.egfr between 30 and 44.99 ) pt;";             
        $result9 = \Yii::$app->db1->createCommand($sql9)->queryAll();
        foreach ($result9 as $value9) {
        $rawData[]=[
               'id' => '',
               'pname' => $value9['pname'],
               'goal' => '',
               'oct' => $value9['Oct'],
               'nov' => $value9['Nov'],
               'dec' => $value9['Dece'],
               'jan' => $value9['Jan'],
               'feb' => $value9['Feb'],
               'mar' => $value9['Mar'],
               'apr' => $value9['Apr'],
               'may' => $value9['May'],
               'jun' => $value9['Jun'],
               'jul' => $value9['Jul'],
               'aug' => $value9['Aug'],
               'sep' => $value9['Sep'],
               'total' => $value9['total'], 
        ];               
        }  
        $sql10 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'ระยะที่ 4 (GFR 15.00 - 29.99 ml/min)' as pname,count(*) total,
                             count(if(month(v.vstdate)=10,1,null)) as Oct,
                             count(if(month(v.vstdate)=11,1,null)) as Nov,
                             count(if(month(v.vstdate)=12,1,null))  as Dece,
                             count(if(month(v.vstdate)=1,1,null))  as Jan,
                             count(if(month(v.vstdate)=2,1,null))  as Feb,
                             count(if(month(v.vstdate)=3,1,null))  as Mar,
                             count(if(month(v.vstdate)=4,1,null))  as Apr,
                             count(if(month(v.vstdate)=5,1,null))  as May,
                             count(if(month(v.vstdate)=6,1,null))  as Jun,
                             count(if(month(v.vstdate)=7,1,null))  as Jul,
                             count(if(month(v.vstdate)=8,1,null))  as Aug,
                             count(if(month(v.vstdate)=9,1,null)) as Sep
                             from clinicmember c inner join vn_stat v on c.hn=v.hn 
                             inner join ovst_gfr o on v.vn=o.vn where clinic = '029' and v.vstdate between '{$date1}' and '{$date2}' 
                             and o.egfr between 15 and 29.99 ) pt;";          
        $result10 = \Yii::$app->db1->createCommand($sql10)->queryAll();
        foreach ($result10 as $value10) {
        $rawData[]=[
               'id' => '',
               'pname' => $value10['pname'],
               'goal' => '',
               'oct' => $value10['Oct'],
               'nov' => $value10['Nov'],
               'dec' => $value10['Dece'],
               'jan' => $value10['Jan'],
               'feb' => $value10['Feb'],
               'mar' => $value10['Mar'],
               'apr' => $value10['Apr'],
               'may' => $value10['May'],
               'jun' => $value10['Jun'],
               'jul' => $value10['Jul'],
               'aug' => $value10['Aug'],
               'sep' => $value10['Sep'],
               'total' => $value10['total'], 
        ];               
        }  
        $sql11 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'ระยะที่ 5 (GFR < 15 ml/min)' as pname,count(*) total,
                             count(if(month(v.vstdate)=10,1,null)) as Oct,
                             count(if(month(v.vstdate)=11,1,null)) as Nov,
                             count(if(month(v.vstdate)=12,1,null))  as Dece,
                             count(if(month(v.vstdate)=1,1,null))  as Jan,
                             count(if(month(v.vstdate)=2,1,null))  as Feb,
                             count(if(month(v.vstdate)=3,1,null))  as Mar,
                             count(if(month(v.vstdate)=4,1,null))  as Apr,
                             count(if(month(v.vstdate)=5,1,null))  as May,
                             count(if(month(v.vstdate)=6,1,null))  as Jun,
                             count(if(month(v.vstdate)=7,1,null))  as Jul,
                             count(if(month(v.vstdate)=8,1,null))  as Aug,
                             count(if(month(v.vstdate)=9,1,null)) as Sep
                             from clinicmember c inner join vn_stat v on c.hn=v.hn 
                             inner join ovst_gfr o on v.vn=o.vn where clinic = '029' and v.vstdate between '{$date1}' and '{$date2}' 
                             and o.egfr < 15 ) pt;";            
        $result11 = \Yii::$app->db1->createCommand($sql11)->queryAll();
        foreach ($result11 as $value11) {
        $rawData[]=[
               'id' => '',
               'pname' => $value11['pname'],
               'goal' => '',
               'oct' => $value11['Oct'],
               'nov' => $value11['Nov'],
               'dec' => $value11['Dece'],
               'jan' => $value11['Jan'],
               'feb' => $value11['Feb'],
               'mar' => $value11['Mar'],
               'apr' => $value11['Apr'],
               'may' => $value11['May'],
               'jun' => $value11['Jun'],
               'jul' => $value11['Jul'],
               'aug' => $value11['Aug'],
               'sep' => $value11['Sep'],
               'total' => $value11['total'], 
        ];               
        }   
        $rawData[]=[
               'id' => '',
               'pname' => 'ร้อยละของผู้ป่วยที่มีอัตราการลดของ eGFR < 4 ml/min/1.72m2/yr',
               'goal' => '',
               'oct' => '',
               'nov' => '',
               'dec' => '',
               'jan' => '',
               'feb' => '',
               'mar' => '',
               'apr' => '',
               'may' => '',
               'jun' => '',
               'jul' => '',
               'aug' => '',
               'sep' => '',
               'total' => '', 
        ];     
        $rawData[]=[
               'id' => '',
               'pname' => 'ร้อยละการเยี่ยมบ้านของผู้ป่วย C.A.P.D และ H.D.',
               'goal' => '',
               'oct' => '',
               'nov' => '',
               'dec' => '',
               'jan' => '',
               'feb' => '',
               'mar' => '',
               'apr' => '',
               'may' => '',
               'jun' => '',
               'jul' => '',
               'aug' => '',
               'sep' => '',
               'total' => '', 
        ];          
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/service_plan3/preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'date1' => $date1, 'date2' => $date2,'yrs' => $yrs]);          
    }
    
}