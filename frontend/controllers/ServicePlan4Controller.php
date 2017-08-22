<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class ServicePlan4Controller extends Controller
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
        $names="ผลการดำเนินงานการให้บริการ Copd&Asthma"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
               $type = Yii::$app->request->post('select1');   ;
              return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'t'=>$type]);
        }
            return $this -> render('/site/service_plan4/index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionPreview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $type = explode(',', $t);
        $code = $type[0];
        $tnames = $type[1];
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        $rawData=[];
        switch ($code) {
               case 1: // ในเขตอำเภอ
        $rawData[]=[
               'id' => '',
               'pname' => 'มีการจัดตั้ง COPD & Asthma Clinic และ คลินิกอดบุหรี่ใน รพช. ทุกระดับ',
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
        $sql1="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'จำนวนผู้ป่วย COPD ทั้งหมด' as pname,count(*) total,
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
                       from ovstdiag o inner join vn_stat v on o.vn=v.vn where o.vstdate between '{$date1}' and '{$date2}' 
                       and o.icd10 between 'J440' and 'J449' and v.age_y >=15 and substr(v.aid,1,4)='3104') pt ;";                                                       
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
        $sql2="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'จำนวนผู้ป่วย Asthma ทั้งหมด' as pname,count(*) total,
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
                       from ovstdiag o inner join vn_stat v on o.vn=v.vn where o.vstdate between '{$date1}' and '{$date2}' 
                       and substr(v.aid,1,4) = '3104'      
                       and o.icd10 in ('J450','J451','J452','J453','J454','J455','J456','J457','J458','J459','J46') and v.age_y >=15 ) pt ;";                                                       
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
        $sql3="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,yrs 
                      from (select 'จำนวนผู้ป่วยที่เสียชีวิตด้วย COPD ทั้งหมด' as pname,count(*) total,
                             count(if(month(o.death_date)=10,1,null)) as Oct,
                             count(if(month(o.death_date)=11,1,null)) as Nov,
                             count(if(month(o.death_date)=12,1,null))  as Dece,
                             count(if(month(o.death_date)=1,1,null))  as Jan,
                             count(if(month(o.death_date)=2,1,null))  as Feb,
                             count(if(month(o.death_date)=3,1,null))  as Mar,
                             count(if(month(o.death_date)=4,1,null))  as Apr,
                             count(if(month(o.death_date)=5,1,null))  as May,
                             count(if(month(o.death_date)=6,1,null))  as Jun,
                             count(if(month(o.death_date)=7,1,null))  as Jul,
                             count(if(month(o.death_date)=8,1,null))  as Aug,
                             count(if(month(o.death_date)=9,1,null)) as Sep,														 IF(MONTH(o.death_date)>=10,YEAR(o.death_date)+1 ,YEAR(o.death_date))+543 AS yrs	
                       from  death o inner join patient p on p.hn=o.hn
                       where o.death_date between '{$date1}' and '{$date2}'  and concat(p.chwpart,p.amppart) = '3104'
                       and o.death_diag_1 between 'J440' and 'J449' ) pt ;";                                                       
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
        $sql4="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,yrs 
                      from (select 'จำนวนผู้ป่วยที่เสียชีวิตด้วย Asthma ทั้งหมด' as pname,count(*) total,
                             count(if(month(o.death_date)=10,1,null)) as Oct,
                             count(if(month(o.death_date)=11,1,null)) as Nov,
                             count(if(month(o.death_date)=12,1,null))  as Dece,
                             count(if(month(o.death_date)=1,1,null))  as Jan,
                             count(if(month(o.death_date)=2,1,null))  as Feb,
                             count(if(month(o.death_date)=3,1,null))  as Mar,
                             count(if(month(o.death_date)=4,1,null))  as Apr,
                             count(if(month(o.death_date)=5,1,null))  as May,
                             count(if(month(o.death_date)=6,1,null))  as Jun,
                             count(if(month(o.death_date)=7,1,null))  as Jul,
                             count(if(month(o.death_date)=8,1,null))  as Aug,
                             count(if(month(o.death_date)=9,1,null)) as Sep,														 IF(MONTH(o.death_date)>=10,YEAR(o.death_date)+1 ,YEAR(o.death_date))+543 AS yrs	
                       from  death o inner join patient p on p.hn=o.hn
                       where o.death_date between '{$date1}' and '{$date2}' and concat(p.chwpart,p.amppart) = '3104'
                      and o.death_diag_1  in ('J450','J451','J452','J453','J454','J455','J456','J457','J458','J459','J46') ) pt;";                                                       
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
        $sql5="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยที่ Admit ด้วยโรค Asthma' as pname,count(*) total,
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
                       from an_stat a where dchdate between '{$date1}' and '{$date2}' and substr(a.aid,1,4) = '3104'
                       and a.pdx in ('J450','J451','J452','J453','J454','J455','J456','J457','J458','J459','J46') and a.age_y>=15 ) pt ;";                                                       
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
                      from (select 'จำนวนผู้ป่วยที่ Re-Admit ด้วยโรค Asthma ใน 28 วัน' as pname,count(*) total,
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
                       from an_stat a 
                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                       and a.pdx in ('J450','J451','J452','J453','J454','J455','J456','J457','J458','J459','J46') 
                       and substr(a.aid,1,4) = '3104' group by a.pdx  ) pt ;";                                                       
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
                      from (select 'จำนวนผู้สูบบุหรี่ ทั้งหมด' as pname,count(*) total,
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
                       from opdscreen o inner join vn_stat v on o.vn=v.vn where o.vstdate between '{$date1}' and '{$date2}' 
                       and substr(v.aid,1,4) = '3104' and o.smoking_type_id in ('2','5') ) pt ;";                                                       
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
        $sql8="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้สูบบุหรี่ และเข้ารับบริการอดบุหรี่ในคลินิกอดบุหรี่' as pname,count(*) total,
                             count(if(month(c.regdate)=10,1,null)) as Oct,
                             count(if(month(c.regdate)=11,1,null)) as Nov,
                             count(if(month(c.regdate)=12,1,null))  as Dece,
                             count(if(month(c.regdate)=1,1,null))  as Jan,
                             count(if(month(c.regdate)=2,1,null))  as Feb,
                             count(if(month(c.regdate)=3,1,null))  as Mar,
                             count(if(month(c.regdate)=4,1,null))  as Apr,
                             count(if(month(c.regdate)=5,1,null))  as May,
                             count(if(month(c.regdate)=6,1,null))  as Jun,
                             count(if(month(c.regdate)=7,1,null))  as Jul,
                             count(if(month(c.regdate)=8,1,null))  as Aug,
                             count(if(month(c.regdate)=9,1,null)) as Sep
                       from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                             and c.clinic='042' and concat(p.chwpart,p.amppart)='3104' ) pt ;";                                                       
        $result8 = \Yii::$app->db1->createCommand($sql8)->queryAll();
        foreach ($result8 as $value8) {
        $rawData[]=[
               'id' => '',
               'pname' => $value8['pname'],
               'goal' => '80 %',
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
               'pname' => 'จำนวนผู้สูบบุหรี่ที่สามารถเลิกบุหรี่ได้ (อย่างน้อย 6 เดือน)',
               'goal' => '10 %',
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
        $sql9="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยในที่จำหน่ายกลับบ้านด้วยโรค COPD ( ICD 10=J44-J449 )' as pname,count(*) total,
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
                       from an_stat a 
                       where a.dchdate between '{$date1}' and '{$date2}' and substr(a.aid,1,4) ='3104' 
                       and a.pdx between 'J44' and 'J449' ) pt;";
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
        $sql10="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยที่ Readmission ใน 28 วัน ด้วยโรค COPD ( ICD 10=J44-J449 ) โดยไม่ได้วางแผนการรักษา' as pname,
                             count(*) total,
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
                       from an_stat a 
                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                       and a.pdx between 'J44' and 'J449' and substr(a.aid,1,4) ='3104' group by a.pdx  ) pt";
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
        $sql11="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยโรค COPD ที่สูบบุหรี ที่เข้ารับบริการคลินิกอดบุหรี่ ( รหัส ICD 10=J44-J449 ร่วมกับ ICD 10=Z 716 
                             ร่วมกับ Z 720 หรือ F 172.0 หรือ F 172.2 )' as pname,count(*) total,
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
                       from vn_stat v 
                       where v.vstdate between '{$date1}' and '{$date2}' and substr(v.aid,1,4) ='3104'
                             and (v.pdx between 'J44' and 'J449' or v.pdx in ('Z716','Z720','F1720','F1722'))) pt;";
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
        $sql12="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยโรค COPDที่สูบบุหรี ที่เข้ารับบริการคลินิกอดบุหรี่และสามารถเลิกบุหรี่ได้ 
                              ( รหัส ICD 10=J44-J449 ร่วมกับ ICD 10=Z 716 ร่วมกับ Z 720 หรือ F 172.0 หรือ F 172.2 )
                              และอดบุหรี่ได้ (รหัสICD 10= Z 508)' as pname,count(*) total,
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
                       from vn_stat v 
                       where v.vstdate between '{$date1}' and '{$date2}' and substr(v.aid,1,4) ='3104' and
                       (v.pdx between 'J44' and 'J449' or v.pdx in ('Z716','Z720','F1720','F1722')) and v.dx0 ='Z508' ) pt;";
        $result12 = \Yii::$app->db1->createCommand($sql12)->queryAll();
        foreach ($result12 as $value12) {
        $rawData[]=[
               'id' => '',
               'pname' => $value12['pname'],
               'goal' => '',
               'oct' => $value12['Oct'],
               'nov' => $value12['Nov'],
               'dec' => $value12['Dece'],
               'jan' => $value12['Jan'],
               'feb' => $value12['Feb'],
               'mar' => $value12['Mar'],
               'apr' => $value12['Apr'],
               'may' => $value12['May'],
               'jun' => $value12['Jun'],
               'jul' => $value12['Jul'],
               'aug' => $value12['Aug'],
               'sep' => $value12['Sep'],
               'total' => $value12['total'], 
        ];   
        }
        $sql13 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนการรับการส่งต่อ(Refer in) ผู้ป่วยโรค COPD' as pname,count(*) total,
                             count(if(month(refer_date)=10,1,null)) as Oct,
                             count(if(month(refer_date)=11,1,null)) as Nov,
                             count(if(month(refer_date)=12,1,null))  as Dece,
                             count(if(month(refer_date)=1,1,null))  as Jan,
                             count(if(month(refer_date)=2,1,null))  as Feb,
                             count(if(month(refer_date)=3,1,null))  as Mar,
                             count(if(month(refer_date)=4,1,null))  as Apr,
                             count(if(month(refer_date)=5,1,null))  as May,
                             count(if(month(refer_date)=6,1,null))  as Jun,
                             count(if(month(refer_date)=7,1,null))  as Jul,
                             count(if(month(refer_date)=8,1,null))  as Aug,
                             count(if(month(refer_date)=9,1,null)) as Sep
                       from referin where refer_date between '{$date1}' and '{$date2}' and icd10 between 'J44' and 'J449' ) pt;";
        $result13 = \Yii::$app->db1->createCommand($sql13)->queryAll();
        foreach ($result13 as $value13) {
        $rawData[]=[
               'id' => '',
               'pname' => $value13['pname'],
               'goal' => '',
               'oct' => $value13['Oct'],
               'nov' => $value13['Nov'],
               'dec' => $value13['Dece'],
               'jan' => $value13['Jan'],
               'feb' => $value13['Feb'],
               'mar' => $value13['Mar'],
               'apr' => $value13['Apr'],
               'may' => $value13['May'],
               'jun' => $value13['Jun'],
               'jul' => $value13['Jul'],
               'aug' => $value13['Aug'],
               'sep' => $value13['Sep'],
               'total' => $value13['total'], 
        ];   
        }  
        $sql14 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนการส่งต่อ(Refer out) ผู้ป่วยโรค COPD' as pname,count(*) total,
                             count(if(month(refer_date)=10,1,null)) as Oct,
                             count(if(month(refer_date)=11,1,null)) as Nov,
                             count(if(month(refer_date)=12,1,null))  as Dece,
                             count(if(month(refer_date)=1,1,null))  as Jan,
                             count(if(month(refer_date)=2,1,null))  as Feb,
                             count(if(month(refer_date)=3,1,null))  as Mar,
                             count(if(month(refer_date)=4,1,null))  as Apr,
                             count(if(month(refer_date)=5,1,null))  as May,
                             count(if(month(refer_date)=6,1,null))  as Jun,
                             count(if(month(refer_date)=7,1,null))  as Jul,
                             count(if(month(refer_date)=8,1,null))  as Aug,
                             count(if(month(refer_date)=9,1,null)) as Sep
                       from referout where refer_date between '{$date1}' and '{$date2}' and pdx between 'J44' and 'J449' ) pt;";
        $result14 = \Yii::$app->db1->createCommand($sql14)->queryAll();
        foreach ($result14 as $value14) {
        $rawData[]=[
               'id' => '',
               'pname' => $value14['pname'],
               'goal' => '',
               'oct' => $value14['Oct'],
               'nov' => $value14['Nov'],
               'dec' => $value14['Dece'],
               'jan' => $value14['Jan'],
               'feb' => $value14['Feb'],
               'mar' => $value14['Mar'],
               'apr' => $value14['Apr'],
               'may' => $value14['May'],
               'jun' => $value14['Jun'],
               'jul' => $value14['Jul'],
               'aug' => $value14['Aug'],
               'sep' => $value14['Sep'],
               'total' => $value14['total'], 
        ];   
        }                        
               break;
               case 2: // นอกเขตอำเภอ
        $rawData[]=[
               'id' => '',
               'pname' => 'มีการจัดตั้ง COPD & Asthma Clinic และ คลินิกอดบุหรี่ใน รพช. ทุกระดับ',
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
        $sql1="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'จำนวนผู้ป่วย COPD ทั้งหมด' as pname,count(*) total,
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
                       from ovstdiag o inner join vn_stat v on o.vn=v.vn where o.vstdate between '{$date1}' and '{$date2}' 
                       and o.icd10 between 'J440' and 'J449' and v.age_y >=15 and substr(v.aid,1,4) !='3104') pt ;";                                                       
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
        $sql2="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (select 'จำนวนผู้ป่วย Asthma ทั้งหมด' as pname,count(*) total,
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
                       from ovstdiag o inner join vn_stat v on o.vn=v.vn where o.vstdate between '{$date1}' and '{$date2}' 
                       and substr(v.aid,1,4) != '3104'      
                       and o.icd10 in ('J450','J451','J452','J453','J454','J455','J456','J457','J458','J459','J46') and v.age_y >=15 ) pt ;";                                                       
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
        $sql3="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,yrs 
                      from (select 'จำนวนผู้ป่วยที่เสียชีวิตด้วย COPD ทั้งหมด' as pname,count(*) total,
                             count(if(month(o.death_date)=10,1,null)) as Oct,
                             count(if(month(o.death_date)=11,1,null)) as Nov,
                             count(if(month(o.death_date)=12,1,null))  as Dece,
                             count(if(month(o.death_date)=1,1,null))  as Jan,
                             count(if(month(o.death_date)=2,1,null))  as Feb,
                             count(if(month(o.death_date)=3,1,null))  as Mar,
                             count(if(month(o.death_date)=4,1,null))  as Apr,
                             count(if(month(o.death_date)=5,1,null))  as May,
                             count(if(month(o.death_date)=6,1,null))  as Jun,
                             count(if(month(o.death_date)=7,1,null))  as Jul,
                             count(if(month(o.death_date)=8,1,null))  as Aug,
                             count(if(month(o.death_date)=9,1,null)) as Sep,														 IF(MONTH(o.death_date)>=10,YEAR(o.death_date)+1 ,YEAR(o.death_date))+543 AS yrs	
                       from  death o inner join patient p on p.hn=o.hn
                       where o.death_date between '{$date1}' and '{$date2}'  and concat(p.chwpart,p.amppart) != '3104'
                       and o.death_diag_1 between 'J440' and 'J449' ) pt ;";                                                       
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
        $sql4="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,yrs 
                      from (select 'จำนวนผู้ป่วยที่เสียชีวิตด้วย Asthma ทั้งหมด' as pname,count(*) total,
                             count(if(month(o.death_date)=10,1,null)) as Oct,
                             count(if(month(o.death_date)=11,1,null)) as Nov,
                             count(if(month(o.death_date)=12,1,null))  as Dece,
                             count(if(month(o.death_date)=1,1,null))  as Jan,
                             count(if(month(o.death_date)=2,1,null))  as Feb,
                             count(if(month(o.death_date)=3,1,null))  as Mar,
                             count(if(month(o.death_date)=4,1,null))  as Apr,
                             count(if(month(o.death_date)=5,1,null))  as May,
                             count(if(month(o.death_date)=6,1,null))  as Jun,
                             count(if(month(o.death_date)=7,1,null))  as Jul,
                             count(if(month(o.death_date)=8,1,null))  as Aug,
                             count(if(month(o.death_date)=9,1,null)) as Sep,														 IF(MONTH(o.death_date)>=10,YEAR(o.death_date)+1 ,YEAR(o.death_date))+543 AS yrs	
                       from  death o inner join patient p on p.hn=o.hn
                       where o.death_date between '{$date1}' and '{$date2}' and concat(p.chwpart,p.amppart) != '3104'
                      and o.death_diag_1  in ('J450','J451','J452','J453','J454','J455','J456','J457','J458','J459','J46') ) pt;";                                                       
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
        $sql5="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยที่ Admit ด้วยโรค Asthma' as pname,count(*) total,
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
                       from an_stat a where dchdate between '{$date1}' and '{$date2}' and substr(a.aid,1,4) != '3104'
                       and a.pdx in ('J450','J451','J452','J453','J454','J455','J456','J457','J458','J459','J46') and a.age_y>=15 ) pt ;";                                                       
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
                      from (select 'จำนวนผู้ป่วยที่ Re-Admit ด้วยโรค Asthma ใน 28 วัน' as pname,count(*) total,
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
                       from an_stat a 
                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                       and a.pdx in ('J450','J451','J452','J453','J454','J455','J456','J457','J458','J459','J46') 
                       and substr(a.aid,1,4) != '3104' group by a.pdx  ) pt ;";                                                       
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
                      from (select 'จำนวนผู้สูบบุหรี่ ทั้งหมด' as pname,count(*) total,
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
                       from opdscreen o inner join vn_stat v on o.vn=v.vn where o.vstdate between '{$date1}' and '{$date2}' 
                       and substr(v.aid,1,4) != '3104' and o.smoking_type_id in ('2','5') ) pt ;";                                                       
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
        $sql8="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้สูบบุหรี่ และเข้ารับบริการอดบุหรี่ในคลินิกอดบุหรี่' as pname,count(*) total,
                             count(if(month(c.regdate)=10,1,null)) as Oct,
                             count(if(month(c.regdate)=11,1,null)) as Nov,
                             count(if(month(c.regdate)=12,1,null))  as Dece,
                             count(if(month(c.regdate)=1,1,null))  as Jan,
                             count(if(month(c.regdate)=2,1,null))  as Feb,
                             count(if(month(c.regdate)=3,1,null))  as Mar,
                             count(if(month(c.regdate)=4,1,null))  as Apr,
                             count(if(month(c.regdate)=5,1,null))  as May,
                             count(if(month(c.regdate)=6,1,null))  as Jun,
                             count(if(month(c.regdate)=7,1,null))  as Jul,
                             count(if(month(c.regdate)=8,1,null))  as Aug,
                             count(if(month(c.regdate)=9,1,null)) as Sep
                       from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                             and c.clinic='042' and concat(p.chwpart,p.amppart) !='3104' ) pt ;";                                                       
        $result8 = \Yii::$app->db1->createCommand($sql8)->queryAll();
        foreach ($result8 as $value8) {
        $rawData[]=[
               'id' => '',
               'pname' => $value8['pname'],
               'goal' => '80 %',
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
               'pname' => 'จำนวนผู้สูบบุหรี่ที่สามารถเลิกบุหรี่ได้ (อย่างน้อย 6 เดือน)',
               'goal' => '10 %',
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
        $sql9="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยในที่จำหน่ายกลับบ้านด้วยโรค COPD ( ICD 10=J44-J449 )' as pname,count(*) total,
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
                       from an_stat a 
                       where a.dchdate between '{$date1}' and '{$date2}' and substr(a.aid,1,4) !='3104' 
                       and a.pdx between 'J44' and 'J449' ) pt;";
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
        $sql10="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยที่ Readmission ใน 28 วัน ด้วยโรค COPD ( ICD 10=J44-J449 ) โดยไม่ได้วางแผนการรักษา' as pname,
                             count(*) total,
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
                       from an_stat a 
                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                       and a.pdx between 'J44' and 'J449' and substr(a.aid,1,4) !='3104' group by a.pdx  ) pt";
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
        $sql11="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยโรค COPD ที่สูบบุหรี ที่เข้ารับบริการคลินิกอดบุหรี่ ( รหัส ICD 10=J44-J449 ร่วมกับ ICD 10=Z 716 
                             ร่วมกับ Z 720 หรือ F 172.0 หรือ F 172.2 )' as pname,count(*) total,
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
                       from vn_stat v 
                       where v.vstdate between '{$date1}' and '{$date2}' and substr(v.aid,1,4) !='3104'
                             and (v.pdx between 'J44' and 'J449' or v.pdx in ('Z716','Z720','F1720','F1722'))) pt;";
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
        $sql12="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนผู้ป่วยโรค COPDที่สูบบุหรี ที่เข้ารับบริการคลินิกอดบุหรี่และสามารถเลิกบุหรี่ได้ 
                              ( รหัส ICD 10=J44-J449 ร่วมกับ ICD 10=Z 716 ร่วมกับ Z 720 หรือ F 172.0 หรือ F 172.2 )
                              และอดบุหรี่ได้ (รหัสICD 10= Z 508)' as pname,count(*) total,
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
                       from vn_stat v 
                       where v.vstdate between '{$date1}' and '{$date2}' and substr(v.aid,1,4) !='3104' and
                       (v.pdx between 'J44' and 'J449' or v.pdx in ('Z716','Z720','F1720','F1722')) and v.dx0 ='Z508' ) pt;";
        $result12 = \Yii::$app->db1->createCommand($sql12)->queryAll();
        foreach ($result12 as $value12) {
        $rawData[]=[
               'id' => '',
               'pname' => $value12['pname'],
               'goal' => '',
               'oct' => $value12['Oct'],
               'nov' => $value12['Nov'],
               'dec' => $value12['Dece'],
               'jan' => $value12['Jan'],
               'feb' => $value12['Feb'],
               'mar' => $value12['Mar'],
               'apr' => $value12['Apr'],
               'may' => $value12['May'],
               'jun' => $value12['Jun'],
               'jul' => $value12['Jul'],
               'aug' => $value12['Aug'],
               'sep' => $value12['Sep'],
               'total' => $value12['total'], 
        ];   
        }
        $sql13 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนการรับการส่งต่อ(Refer in) ผู้ป่วยโรค COPD' as pname,count(*) total,
                             count(if(month(refer_date)=10,1,null)) as Oct,
                             count(if(month(refer_date)=11,1,null)) as Nov,
                             count(if(month(refer_date)=12,1,null))  as Dece,
                             count(if(month(refer_date)=1,1,null))  as Jan,
                             count(if(month(refer_date)=2,1,null))  as Feb,
                             count(if(month(refer_date)=3,1,null))  as Mar,
                             count(if(month(refer_date)=4,1,null))  as Apr,
                             count(if(month(refer_date)=5,1,null))  as May,
                             count(if(month(refer_date)=6,1,null))  as Jun,
                             count(if(month(refer_date)=7,1,null))  as Jul,
                             count(if(month(refer_date)=8,1,null))  as Aug,
                             count(if(month(refer_date)=9,1,null)) as Sep
                       from referin where refer_date between '{$date1}' and '{$date2}' and icd10 between 'J44' and 'J449' ) pt;";
        $result13 = \Yii::$app->db1->createCommand($sql13)->queryAll();
        foreach ($result13 as $value13) {
        $rawData[]=[
               'id' => '',
               'pname' => $value13['pname'],
               'goal' => '',
               'oct' => $value13['Oct'],
               'nov' => $value13['Nov'],
               'dec' => $value13['Dece'],
               'jan' => $value13['Jan'],
               'feb' => $value13['Feb'],
               'mar' => $value13['Mar'],
               'apr' => $value13['Apr'],
               'may' => $value13['May'],
               'jun' => $value13['Jun'],
               'jul' => $value13['Jul'],
               'aug' => $value13['Aug'],
               'sep' => $value13['Sep'],
               'total' => $value13['total'], 
        ];   
        }       
        $sql14 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep
                      from (select 'จำนวนการส่งต่อ(Refer out) ผู้ป่วยโรค COPD' as pname,count(*) total,
                             count(if(month(refer_date)=10,1,null)) as Oct,
                             count(if(month(refer_date)=11,1,null)) as Nov,
                             count(if(month(refer_date)=12,1,null))  as Dece,
                             count(if(month(refer_date)=1,1,null))  as Jan,
                             count(if(month(refer_date)=2,1,null))  as Feb,
                             count(if(month(refer_date)=3,1,null))  as Mar,
                             count(if(month(refer_date)=4,1,null))  as Apr,
                             count(if(month(refer_date)=5,1,null))  as May,
                             count(if(month(refer_date)=6,1,null))  as Jun,
                             count(if(month(refer_date)=7,1,null))  as Jul,
                             count(if(month(refer_date)=8,1,null))  as Aug,
                             count(if(month(refer_date)=9,1,null)) as Sep
                       from referout where refer_date between '{$date1}' and '{$date2}' and pdx between 'J44' and 'J449' ) pt;";
        $result14 = \Yii::$app->db1->createCommand($sql14)->queryAll();
        foreach ($result14 as $value14) {
        $rawData[]=[
               'id' => '',
               'pname' => $value14['pname'],
               'goal' => '',
               'oct' => $value14['Oct'],
               'nov' => $value14['Nov'],
               'dec' => $value14['Dece'],
               'jan' => $value14['Jan'],
               'feb' => $value14['Feb'],
               'mar' => $value14['Mar'],
               'apr' => $value14['Apr'],
               'may' => $value14['May'],
               'jun' => $value14['Jun'],
               'jul' => $value14['Jul'],
               'aug' => $value14['Aug'],
               'sep' => $value14['Sep'],
               'total' => $value14['total'], 
        ];   
        }         
               break;    
               default:
               break;
        }                                        
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);  
        return $this -> render('/site/service_plan4/preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'date1' => $date1, 'date2' => $date2,'yrs' => $yrs,
                                        'tnames' => $tnames]);              
    }
    
}