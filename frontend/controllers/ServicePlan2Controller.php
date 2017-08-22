<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class ServicePlan2Controller extends Controller
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
        $names="ผลการดำเนินงานการให้บริการ โรคหลอดเลือดหัวใจ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/service_plan2/index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
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
        $sql1="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'จำนวนการตายด้วยโรคหลอดเลือดหัวใจตามรหัส I20-I25' as pname,count(*) total,
                             count(if(month(d.death_date)=10,1,null)) as Oct,
                             count(if(month(d.death_date)=11,1,null)) as Nov,
                             count(if(month(d.death_date)=12,1,null))  as Dece,
                             count(if(month(d.death_date)=1,1,null))  as Jan,
                             count(if(month(d.death_date)=2,1,null))  as Feb,
                             count(if(month(d.death_date)=3,1,null))  as Mar,
                             count(if(month(d.death_date)=4,1,null))  as Apr,
                             count(if(month(d.death_date)=5,1,null))  as May,
                             count(if(month(d.death_date)=6,1,null))  as Jun,
                             count(if(month(d.death_date)=7,1,null))  as Jul,
                             count(if(month(d.death_date)=8,1,null))  as Aug,
                             count(if(month(d.death_date)=9,1,null)) as Sep
                       from death d where d.death_date between '{$date1}' and '{$date2}' and d.death_diag_1 between 'I200' and 'I259') pt;";                                                       
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
        $rawData[]=[
               'id' => '',
               'pname' => 'รพช. ทุกระดับ มียาละลายลิ่มเลือด SK',
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
        $rawData[]=[
               'id' => '',
               'pname' => 'การจัดตั้ง Warfarin Clinic ในรพช. ทุกระดับ',
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
        $rawData[]=[
               'id' => '',
               'pname' => 'ร้อยละของรพ.ระดับ F2 สามารถให้ยาละลายลิ่มเลือดได้ (moph)',
               'goal' => '75 %',
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
        $sql5="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'จำนวนผู้ป่วยโรคกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน STEMI ทั้งหมด (I210-I213)' as pname,count(*) total,
                             count(if(month(o.vstdate)=10,1,null)) as Oct,
                             count(if(month(o.vstdate)=11,1,null)) as Nov,
                             count(if(month(o.vstdate)=12,1,null))  as Dece,
                             count(if(month(o.vstdate)=1,1,null))  as Jan,
                             count(if(month(o.vstdate)=2,1,null))  as Feb,
                             count(if(month(o.vstdate)=3,1,null))  as Mar,
                             count(if(month(o.vstdate)=4,1,null))  as Apr,
                             count(if(month(o.vstdate)=5,1,null))  as May,
                             count(if(month(o.vstdate)=6,1,null))  as Jun,
                             count(if(month(o.vstdate)=7,1,null))  as Jul,
                             count(if(month(o.vstdate)=8,1,null))  as Aug,
                             count(if(month(o.vstdate)=9,1,null)) as Sep
                       from ovstdiag o where o.vstdate between '{$date1}' and '{$date2}' and o.icd10 between 'I210' and 'I213') pt;";                                                       
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
        $sql6="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'จำนวนผู้ป่วยที่ Admit โรคกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน STEMI (I210-I213)' as pname,count(*) total,
                             count(if(month(a.dchdate)=10,1,null)) as Oct,
                             count(if(month(a.dchdate)=11,1,null)) as Nov,
                             count(if(month(a.dchdate)=12,1,null))  as Dece,
                             count(if(month(a.dchdate)=1,1,null))  as Jan,
                             count(if(month(a.dchdate)=2,1,null))  as Feb,
                             count(if(month(a.dchdate)=3,1,null))  as Mar,
                             count(if(month(a.dchdate)=4,1,null))  as Apr,
                             count(if(month(a.dchdate)=5,1,null))  as May,
                             count(if(month(a.dchdate)=6,1,null))  as Jun,
                             count(if(month(a.dchdate)=7,1,null))  as Jul,
                             count(if(month(a.dchdate)=8,1,null))  as Aug,
                             count(if(month(a.dchdate)=9,1,null)) as Sep
                       from an_stat a where a.dchdate between '{$date1}' and '{$date2}' and a.pdx between 'I210' and 'I213') pt;";                                                       
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
        $sql7="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'ร้อยละของผู้ป่วยโรคกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน STEMI (I210-I213) เสียชีวิตใน รพ.' as pname,count(*) total,
                             count(if(month(d.death_date)=10,1,null)) as Oct,
                             count(if(month(d.death_date)=11,1,null)) as Nov,
                             count(if(month(d.death_date)=12,1,null))  as Dece,
                             count(if(month(d.death_date)=1,1,null))  as Jan,
                             count(if(month(d.death_date)=2,1,null))  as Feb,
                             count(if(month(d.death_date)=3,1,null))  as Mar,
                             count(if(month(d.death_date)=4,1,null))  as Apr,
                             count(if(month(d.death_date)=5,1,null))  as May,
                             count(if(month(d.death_date)=6,1,null))  as Jun,
                             count(if(month(d.death_date)=7,1,null))  as Jul,
                             count(if(month(d.death_date)=8,1,null))  as Aug,
                             count(if(month(d.death_date)=9,1,null)) as Sep
                       from death d where d.death_date between '{$date1}' and '{$date2}' and d.death_diag_1 between 'I210' and 'I213') pt;";                                                       
        $result7 = \Yii::$app->db1->createCommand($sql7)->queryAll();
        foreach ($result7 as $value7) {
        $rawData[]=[
               'id' => '',
               'pname' => $value7['pname'],
               'goal' => '<10 %',
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
        $rawData[]=[
               'id' => '',
               'pname' => 'อัตรา Door to EKG ภายใน 10 นาทีเพิ่มขึ้น',
               'goal' => '>80 %',
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
               'pname' => 'อัตรา Door toTreatment ภายใน 15 นาที',
               'goal' => '>80 %',
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
               'pname' => 'อัตรา Door to Refer ภายใน 30 นาที (non STEMI)',
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
               'pname' => 'ผู้ป่วยโรคกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน STEMI ได้รับยาละลายลิ่มเลือดและ/หรือการขยายหลอดเลือดหัวใจ
                                (PPCI-Primary Percutaneous Cardiac Intervention) (รพ.ทุกแห่ง)',
               'goal' => '>75 %',
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
        $sql8="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'จำนวนผู้ป่วยที่ได้รับยา Warfarin' as pname,count(*) total,
                             count(if(month(o.vstdate)=10,1,null)) as Oct,
                             count(if(month(o.vstdate)=11,1,null)) as Nov,
                             count(if(month(o.vstdate)=12,1,null))  as Dece,
                             count(if(month(o.vstdate)=1,1,null))  as Jan,
                             count(if(month(o.vstdate)=2,1,null))  as Feb,
                             count(if(month(o.vstdate)=3,1,null))  as Mar,
                             count(if(month(o.vstdate)=4,1,null))  as Apr,
                             count(if(month(o.vstdate)=5,1,null))  as May,
                             count(if(month(o.vstdate)=6,1,null))  as Jun,
                             count(if(month(o.vstdate)=7,1,null))  as Jul,
                             count(if(month(o.vstdate)=8,1,null))  as Aug,
                             count(if(month(o.vstdate)=9,1,null)) as Sep
                       from opitemrece o where o.vstdate between '{$date1}' and '{$date2}' and o.icode in ('1510072','1510073','1540025')) pt;";                                                       
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
        $rawData[]=[
               'id' => '',
               'pname' => 'ร้อยละของผู้ป่วย Warfarin ได้รับการเยี่ยมบ้าน',
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
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/service_plan2/preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'date1' => $date1, 'date2' => $date2,'yrs' => $yrs]);          
    }
    
}