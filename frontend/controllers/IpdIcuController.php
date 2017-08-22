<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class IpdIcuController extends Controller
{
    public $mText = "งานหอผู้ป่วยหนัก(ICU)";
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
        $names="งานหอผู้ป่วยหนัก(ICU)"; 
         return $this -> render('/site/ipd-icu/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionIcu1Index() {
        $model = new Formmodel();
        $names="รายงานข้อมูลผู้ป่วยใน(sepsis,sepsis shock)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;            
              return $this->redirect(['icu1_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-icu/icu1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionIcu1_preview($name,$d1,$d2) {
       $names = $name;
       $date1 = $d1;$date2 = $d2;
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }       
       $rawData = [];    
       $sql1="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                      select 'จำนวนผู้ป่วย sepsis ที่ Admit ทั้งหมดใน รพ.' as pname,count(*) total,
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
                             from iptdiag i left outer join an_stat a on i.an=a.an  where a.dchdate between '{$date1}' and '{$date2}' 
                               and (pdx ='R572'  or (dx0 between 'A40' and 'A419') or (pdx between 'A40' and 'A419') or dx0 ='R572')
                      ) as pt ;";
                      // (i.icd10 like 'R651%' or i.icd10 like 'R572%' or (i.icd10 between 'A40' and 'A4199'))        
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pname' => $value1['pname'],
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
                      from (
                      select 'จำนวนผู้ป่วย Severe sepsis (R651)' as pname,count(*) total,
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
                             from iptdiag i left outer join an_stat a on i.an=a.an where a.dchdate between '{$date1}' and '{$date2}'
                                    and (a.pdx='R651' or a.dx0='R651')
                      ) as pt ;";
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();        
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
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
       $sql3="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                      select 'จำนวนผู้ป่วย Sepsis Shock (R572)' as pname,count(*) total,
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
                             from iptdiag i left outer join an_stat a on i.an=a.an where a.dchdate between '{$date1}' and '{$date2}'
                                     and (a.pdx='R572' or a.dx0='R572')
                      ) as pt ;"; 
        $result3 = \Yii::$app->db1->createCommand($sql3)->queryAll();            
        foreach ($result3 as $value3) {
        $rawData[]=[
               'id' => '',
               'pname' => $value3['pname'],
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
       $sql4="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                      select 'จำนวนผู้ป่วย Septicemia (A40-A419) ' as pname,count(*) total,
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
                             from  iptdiag i left outer join an_stat a on i.an=a.an where a.dchdate between '{$date1}' and '{$date2}'
                               and ((pdx between 'A40' and 'A419') and dx0 !='R572' or pdx !='R572' and (dx0 between 'A40' and 'A419'))   
                      ) as pt ;";     
        $result4 = \Yii::$app->db1->createCommand($sql4)->queryAll();         
        foreach ($result4 as $value4) {
        $rawData[]=[
               'id' => '',
               'pname' => $value4['pname'],
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
                      from (
                      select 'จำนวนผู้ป่วยเสียชีวิตด้วย Severe sepsis (R651)' as pname,count(*) total,
                             count(if(month(death_date)=10,1,null)) as Oct,
                             count(if(month(death_date)=11,1,null)) as Nov,
                             count(if(month(death_date)=12,1,null))  as Dece,
                             count(if(month(death_date)=1,1,null))  as Jan,
                             count(if(month(death_date)=2,1,null))  as Feb,
                             count(if(month(death_date)=3,1,null))  as Mar,
                             count(if(month(death_date)=4,1,null))  as Apr,
                             count(if(month(death_date)=5,1,null))  as May,
                             count(if(month(death_date)=6,1,null))  as Jun,
                             count(if(month(death_date)=7,1,null))  as Jul,
                             count(if(month(death_date)=8,1,null))  as Aug,
                             count(if(month(death_date)=9,1,null)) as Sep
                             from death where death_date between '{$date1}' and '{$date2}' and death_diag_1 like 'R651%' 
                      ) as pt ;";
        $result5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
        foreach ($result5 as $value5) {
        $rawData[]=[
               'id' => '',
               'pname' => $value5['pname'],
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
                      from (
                      select 'จำนวนผู้ป่วยเสียชีวิตด้วย Sepsis Shock (R572)' as pname,count(*) total,
                             count(if(month(death_date)=10,1,null)) as Oct,
                             count(if(month(death_date)=11,1,null)) as Nov,
                             count(if(month(death_date)=12,1,null))  as Dece,
                             count(if(month(death_date)=1,1,null))  as Jan,
                             count(if(month(death_date)=2,1,null))  as Feb,
                             count(if(month(death_date)=3,1,null))  as Mar,
                             count(if(month(death_date)=4,1,null))  as Apr,
                             count(if(month(death_date)=5,1,null))  as May,
                             count(if(month(death_date)=6,1,null))  as Jun,
                             count(if(month(death_date)=7,1,null))  as Jul,
                             count(if(month(death_date)=8,1,null))  as Aug,
                             count(if(month(death_date)=9,1,null)) as Sep
                             from death where death_date between '{$date1}' and '{$date2}' and death_diag_1 like 'R572%' 
                      ) as pt ;";        
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
                      from (
                      select 'จำนวนผู้ป่วยเสียชีวิตด้วย (A40-A419)' as pname,count(*) total,
                             count(if(month(death_date)=10,1,null)) as Oct,
                             count(if(month(death_date)=11,1,null)) as Nov,
                             count(if(month(death_date)=12,1,null))  as Dece,
                             count(if(month(death_date)=1,1,null))  as Jan,
                             count(if(month(death_date)=2,1,null))  as Feb,
                             count(if(month(death_date)=3,1,null))  as Mar,
                             count(if(month(death_date)=4,1,null))  as Apr,
                             count(if(month(death_date)=5,1,null))  as May,
                             count(if(month(death_date)=6,1,null))  as Jun,
                             count(if(month(death_date)=7,1,null))  as Jul,
                             count(if(month(death_date)=8,1,null))  as Aug,
                             count(if(month(death_date)=9,1,null)) as Sep
                             from death where death_date between '{$date1}' and '{$date2}' and death_diag_1 between 'A40' and 'A4199' 
                      ) as pt ;";             
        $result7 = \Yii::$app->db1->createCommand($sql7)->queryAll();
        foreach ($result7 as $value7) {
        $rawData[]=[
               'id' => '',
               'pname' => $value7['pname'],
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
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Sepsis' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join ovst o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    (v.icd10 like 'R651%' or v.icd10 like 'R572%' or (v.icd10 between 'A40' and 'A4199')) 
                      ) as pt ;";        
        $result8 = \Yii::$app->db1->createCommand($sql8)->queryAll();
        foreach ($result8 as $value8) {
        $rawData[]=[
               'id' => '',
               'pname' => $value8['pname'],
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
        $sql9="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนผู้ป่วยเด็ก(1 เดือน-15 ปี) Sepsis ที่ Admit ทั้งหมด' as pname,count(*) total,
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
                             from  iptdiag i left outer join an_stat a on i.an=a.an  where a.dchdate between '{$date1}' and '{$date2}' and
                                    (i.icd10 like 'R651%' or i.icd10 like 'R572%' or (i.icd10 between 'A40' and 'A4199')) and (a.age_y between '0' and '15') 
                                    and a.age_m >=1
                      ) as pt ;";
        $result9 = \Yii::$app->db1->createCommand($sql9)->queryAll();
        foreach ($result9 as $value9) {
        $rawData[]=[
               'id' => '',
               'pname' => $value9['pname'],
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
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วยป่วย Sepsis เด็ก(1 เดือน-15 ปี)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join vn_stat v on r.vn=v.vn inner join ovst o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    (v.pdx like 'R651%' or v.pdx like 'R572%' or (v.pdx between 'A40' and 'A4199')) 
                                    and (v.age_y between '0' and '15') and v.age_m >='1'
                      ) as pt ;";
        $result10 = \Yii::$app->db1->createCommand($sql10)->queryAll();
        foreach ($result10 as $value10) {
        $rawData[]=[
               'id' => '',
               'pname' => $value10['pname'],
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
        $sql11="select  pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                      sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                      from (
                             select 'จำนวนการส่งต่อ ReferOut ผู้ป่วย Sepsis ทั้งหมด' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referout r inner join vn_stat v on r.vn=v.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    (v.pdx like 'R651%' or v.pdx like 'R572%' or (v.pdx between 'A40' and 'A4199')) 
                      union all
                             select 'จำนวนการส่งต่อ ReferOut ผู้ป่วย Sepsis ทั้งหมด' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referout r inner join an_stat v on r.vn=v.an  
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    (v.pdx like 'R651%' or v.pdx like 'R572%' or (v.pdx between 'A40' and 'A4199')) 
                      ) as pt ;"; 
        $result11 = \Yii::$app->db1->createCommand($sql11)->queryAll();
        foreach ($result11 as $value11) {
        $rawData[]=[
               'id' => '',
               'pname' => $value11['pname'],
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
        $sql12="select  pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                      sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                      from (
                             select 'จำนวนการส่งต่อ ReferOut ผู้ป่วย Sepsis เด็ก(1 เดือน-15 ปี) ทั้งหมด' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referout r inner join vn_stat v on r.vn=v.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    (v.pdx like 'R651%' or v.pdx like 'R572%' or (v.pdx between 'A40' and 'A4199')) 
                                    and (v.age_y between '0' and '15') and v.age_m >='1'
                      union all
                             select 'จำนวนการส่งต่อ ReferOut ผู้ป่วย Sepsis เด็ก(1 เดือน-15 ปี) ทั้งหมด' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referout r inner join an_stat v on r.vn=v.an  
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    (v.pdx like 'R651%' or v.pdx like 'R572%' or (v.pdx between 'A40' and 'A4199'))
                                    and (v.age_y between '0' and '15') and v.age_m >='1'
                      ) as pt ;";         
        $result12 = \Yii::$app->db1->createCommand($sql12)->queryAll();
        foreach ($result12 as $value12) {
        $rawData[]=[
               'id' => '',
               'pname' => $value12['pname'],
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
        $sql13="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนค่ายาปฎิชีวะนะ Sepsis (บาท)' as pname,sum(o.sum_price) total,
                             format(sum(if(month(a.dchdate)=10,o.sum_price,0)),0) as Oct,
                             format(sum(if(month(a.dchdate)=11,o.sum_price,0)),0) as Nov,
                             format(sum(if(month(a.dchdate)=12,o.sum_price,0)),0)  as Dece,
                             format(sum(if(month(a.dchdate)=1,o.sum_price,0)),0)  as Jan,
                             format(sum(if(month(a.dchdate)=2,o.sum_price,0)),0)  as Feb,
                             format(sum(if(month(a.dchdate)=3,o.sum_price,0)),0)  as Mar,
                             format(sum(if(month(a.dchdate)=4,o.sum_price,0)),0)  as Apr,
                             format(sum(if(month(a.dchdate)=5,o.sum_price,0)),0)  as May,
                             format(sum(if(month(a.dchdate)=6,o.sum_price,0)),0)  as Jun,
                             format(sum(if(month(a.dchdate)=7,o.sum_price,0)),0)  as Jul,
                             format(sum(if(month(a.dchdate)=8,o.sum_price,0)),0)  as Aug,
                             format(sum(if(month(a.dchdate)=9,o.sum_price,0)),0) as Sep
                          from an_stat a left outer join opitemrece o on a.an=o.an left outer join drugitems d on o.icode = d.icode 
                          where dchdate between '{$date1}' and '{$date2}' and 
                          (a.pdx like 'R651%' or a.pdx like 'R572%' or (a.pdx between 'A40' and 'A4199')) and d.antibiotic='Y'
                      ) as pt ;";
        $result13 = \Yii::$app->db1->createCommand($sql13)->queryAll();
        foreach ($result13 as $value13) {
        $rawData[]=[
               'id' => '',
               'pname' => $value13['pname'],
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
        $sql14="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนผู้ป่วยเด็ก(1 เดือน-15 ปี) Admit ด้วย (J96) ทั้งหมด' as pname,count(*) total,
                             count(if(month(dchdate)=10,1,null)) as Oct,
                             count(if(month(dchdate)=11,1,null)) as Nov,
                             count(if(month(dchdate)=12,1,null))  as Dece,
                             count(if(month(dchdate)=1,1,null))  as Jan,
                             count(if(month(dchdate)=2,1,null))  as Feb,
                             count(if(month(dchdate)=3,1,null))  as Mar,
                             count(if(month(dchdate)=4,1,null))  as Apr,
                             count(if(month(dchdate)=5,1,null))  as May,
                             count(if(month(dchdate)=6,1,null))  as Jun,
                             count(if(month(dchdate)=7,1,null))  as Jul,
                             count(if(month(dchdate)=8,1,null))  as Aug,
                             count(if(month(dchdate)=9,1,null)) as Sep
                             from an_stat  where dchdate between '{$date1}' and '{$date2}' and pdx like 'J96%' and (age_y between '0' and '15') 
                                    and age_m >=1
                      ) as pt;";
        $result14 = \Yii::$app->db1->createCommand($sql14)->queryAll();
        foreach ($result14 as $value14) {
        $rawData[]=[
               'id' => '',
               'pname' => $value14['pname'],
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
        $sql15="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วยป่วย(J96) เด็ก(1 เดือน-15 ปี)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join vn_stat v on r.vn=v.vn inner join ovst o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    v.pdx like 'J96%' and (v.age_y between '0' and '15') and v.age_m >='1'
                      ) as pt ;";        
        $result15 = \Yii::$app->db1->createCommand($sql15)->queryAll();
        foreach ($result15 as $value15) {
        $rawData[]=[
               'id' => '',
               'pname' => $value15['pname'],
               'oct' => $value15['Oct'],
               'nov' => $value15['Nov'],
               'dec' => $value15['Dece'],
               'jan' => $value15['Jan'],
               'feb' => $value15['Feb'],
               'mar' => $value15['Mar'],
               'apr' => $value15['Apr'],
               'may' => $value15['May'],
               'jun' => $value15['Jun'],
               'jul' => $value15['Jul'],
               'aug' => $value15['Aug'],
               'sep' => $value15['Sep'],
               'total' => $value15['total'], 
        ];               
        } 
        $sql16="select  pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                      sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                      from (
                             select 'จำนวนการส่งต่อ ReferOut ผู้ป่วย(J96) เด็ก(1 เดือน-15 ปี)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referout r inner join vn_stat v on r.vn=v.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    v.pdx like 'J96%' and (v.age_y between '0' and '15') and v.age_m >='1'
                      union all
                             select 'จำนวนการส่งต่อ ReferOut ผู้ป่วย(J96) เด็ก(1 เดือน-15 ปี)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referout r inner join an_stat v on r.vn=v.an  
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                     v.pdx like 'J96%' and (v.age_y between '0' and '15') and v.age_m >='1'
                      ) as pt ;";                 
       $result16 = \Yii::$app->db1->createCommand($sql16)->queryAll();
        foreach ($result16 as $value16) {
        $rawData[]=[
               'id' => '',
               'pname' => $value16['pname'],
               'oct' => $value16['Oct'],
               'nov' => $value16['Nov'],
               'dec' => $value16['Dece'],
               'jan' => $value16['Jan'],
               'feb' => $value16['Feb'],
               'mar' => $value16['Mar'],
               'apr' => $value16['Apr'],
               'may' => $value16['May'],
               'jun' => $value16['Jun'],
               'jul' => $value16['Jul'],
               'aug' => $value16['Aug'],
               'sep' => $value16['Sep'],
               'total' => $value16['total'], 
        ];               
        } 
        $sql17 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Sepsis อายุ > 15 ปี(R572)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join vn_stat o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and v.icd10 like 'R572%' 
                                          and o.age_y > '15'
                      ) as pt ;";
       $result17 = \Yii::$app->db1->createCommand($sql17)->queryAll();
        foreach ($result17 as $value17) {
        $rawData[]=[
               'id' => '',
               'pname' => $value17['pname'],
               'oct' => $value17['Oct'],
               'nov' => $value17['Nov'],
               'dec' => $value17['Dece'],
               'jan' => $value17['Jan'],
               'feb' => $value17['Feb'],
               'mar' => $value17['Mar'],
               'apr' => $value17['Apr'],
               'may' => $value17['May'],
               'jun' => $value17['Jun'],
               'jul' => $value17['Jul'],
               'aug' => $value17['Aug'],
               'sep' => $value17['Sep'],
               'total' => $value17['total'], 
        ];               
        }     
        $sql18 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Sepsis อายุ > 15 ปี(A40-A419)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join vn_stat o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and v.icd10 between 'A40' and 'A4199' 
                                          and o.age_y > '15'
                      ) as pt ;";
       $result18 = \Yii::$app->db1->createCommand($sql18)->queryAll();
        foreach ($result18 as $value18) {
        $rawData[]=[
               'id' => '',
               'pname' => $value18['pname'],
               'oct' => $value18['Oct'],
               'nov' => $value18['Nov'],
               'dec' => $value18['Dece'],
               'jan' => $value18['Jan'],
               'feb' => $value18['Feb'],
               'mar' => $value18['Mar'],
               'apr' => $value18['Apr'],
               'may' => $value18['May'],
               'jun' => $value18['Jun'],
               'jul' => $value18['Jul'],
               'aug' => $value18['Aug'],
               'sep' => $value18['Sep'],
               'total' => $value18['total'], 
        ];               
        }   
        $sql19 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Sepsis อายุ > 15 ปี(R651)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join vn_stat o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and v.icd10 like 'R651%' 
                                          and o.age_y > '15'
                      ) as pt ;";
       $result19 = \Yii::$app->db1->createCommand($sql19)->queryAll();
        foreach ($result19 as $value19) {
        $rawData[]=[
               'id' => '',
               'pname' => $value19['pname'],
               'oct' => $value19['Oct'],
               'nov' => $value19['Nov'],
               'dec' => $value19['Dece'],
               'jan' => $value19['Jan'],
               'feb' => $value19['Feb'],
               'mar' => $value19['Mar'],
               'apr' => $value19['Apr'],
               'may' => $value19['May'],
               'jun' => $value19['Jun'],
               'jul' => $value19['Jul'],
               'aug' => $value19['Aug'],
               'sep' => $value19['Sep'],
               'total' => $value19['total'], 
        ];               
        }  
        $sql20 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Sepsis อายุ < 15 ปี(R572)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join vn_stat o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and v.icd10 like 'R572%' 
                                          and o.age_y < '15'
                      ) as pt ;";
       $result20 = \Yii::$app->db1->createCommand($sql20)->queryAll();
        foreach ($result20 as $value20) {
        $rawData[]=[
               'id' => '',
               'pname' => $value20['pname'],
               'oct' => $value20['Oct'],
               'nov' => $value20['Nov'],
               'dec' => $value20['Dece'],
               'jan' => $value20['Jan'],
               'feb' => $value20['Feb'],
               'mar' => $value20['Mar'],
               'apr' => $value20['Apr'],
               'may' => $value20['May'],
               'jun' => $value20['Jun'],
               'jul' => $value20['Jul'],
               'aug' => $value20['Aug'],
               'sep' => $value20['Sep'],
               'total' => $value20['total'], 
        ];               
        }       
        $sql21 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Sepsis อายุ < 15 ปี(A40-A419)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join vn_stat o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and v.icd10 between 'A40' and 'A4199' 
                                          and o.age_y < '15'
                      ) as pt ;";
       $result21 = \Yii::$app->db1->createCommand($sql21)->queryAll();
        foreach ($result21 as $value21) {
        $rawData[]=[
               'id' => '',
               'pname' => $value21['pname'],
               'oct' => $value21['Oct'],
               'nov' => $value21['Nov'],
               'dec' => $value21['Dece'],
               'jan' => $value21['Jan'],
               'feb' => $value21['Feb'],
               'mar' => $value21['Mar'],
               'apr' => $value21['Apr'],
               'may' => $value21['May'],
               'jun' => $value21['Jun'],
               'jul' => $value21['Jul'],
               'aug' => $value21['Aug'],
               'sep' => $value21['Sep'],
               'total' => $value21['total'], 
        ];               
        }  
        $sql22 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Sepsis อายุ < 15 ปี(R651)' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join vn_stat o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and v.icd10 like 'R651%' 
                                          and o.age_y < '15'
                      ) as pt ;";
       $result22 = \Yii::$app->db1->createCommand($sql22)->queryAll();
        foreach ($result22 as $value22) {
        $rawData[]=[
               'id' => '',
               'pname' => $value22['pname'],
               'oct' => $value22['Oct'],
               'nov' => $value22['Nov'],
               'dec' => $value22['Dece'],
               'jan' => $value22['Jan'],
               'feb' => $value22['Feb'],
               'mar' => $value22['Mar'],
               'apr' => $value22['Apr'],
               'may' => $value22['May'],
               'jun' => $value22['Jun'],
               'jul' => $value22['Jul'],
               'aug' => $value22['Aug'],
               'sep' => $value22['Sep'],
               'total' => $value22['total'], 
        ];               
        }      
$sql23="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                      select 'จำนวนผู้ป่วย Severe sepsis (R651) โรคหลัก' as pname,count(*) total,
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
                             from iptdiag i left outer join an_stat a on i.an=a.an where a.dchdate between '{$date1}' and '{$date2}'
                                    and a.pdx='R651' 
                      ) as pt ;";
        $result23 = \Yii::$app->db1->createCommand($sql23)->queryAll();        
        foreach ($result23 as $value23) {
        $rawData[]=[
               'id' => '',
               'pname' => $value23['pname'],
               'oct' => $value23['Oct'],
               'nov' => $value23['Nov'],
               'dec' => $value23['Dece'],
               'jan' => $value23['Jan'],
               'feb' => $value23['Feb'],
               'mar' => $value23['Mar'],
               'apr' => $value23['Apr'],
               'may' => $value23['May'],
               'jun' => $value23['Jun'],
               'jul' => $value23['Jul'],
               'aug' => $value23['Aug'],
               'sep' => $value23['Sep'],
               'total' => $value23['total'], 
        ];       
        }                 
       $sql24="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                      select 'จำนวนผู้ป่วย Sepsis Shock (R572) โรคหลัก' as pname,count(*) total,
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
                             from iptdiag i left outer join an_stat a on i.an=a.an where a.dchdate between '{$date1}' and '{$date2}'
                                     and a.pdx='R572' 
                      ) as pt ;"; 
        $result24 = \Yii::$app->db1->createCommand($sql24)->queryAll();            
        foreach ($result24 as $value24) {
        $rawData[]=[
               'id' => '',
               'pname' => $value24['pname'],
               'oct' => $value24['Oct'],
               'nov' => $value24['Nov'],
               'dec' => $value24['Dece'],
               'jan' => $value24['Jan'],
               'feb' => $value24['Feb'],
               'mar' => $value24['Mar'],
               'apr' => $value24['Apr'],
               'may' => $value24['May'],
               'jun' => $value24['Jun'],
               'jul' => $value24['Jul'],
               'aug' => $value24['Aug'],
               'sep' => $value24['Sep'],
               'total' => $value24['total'], 
        ];               
        }         
       $sql25="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                      select 'จำนวนผู้ป่วย Septicemia (A40-A419) โรคหลัก' as pname,count(*) total,
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
                             from  iptdiag i left outer join an_stat a on i.an=a.an where a.dchdate between '{$date1}' and '{$date2}'
                               and a.pdx between 'A40' and 'A419' 
                      ) as pt ;";     
        $result25 = \Yii::$app->db1->createCommand($sql25)->queryAll();         
        foreach ($result25 as $value25) {
        $rawData[]=[
               'id' => '',
               'pname' => $value25['pname'],
               'oct' => $value25['Oct'],
               'nov' => $value25['Nov'],
               'dec' => $value25['Dece'],
               'jan' => $value25['Jan'],
               'feb' => $value25['Feb'],
               'mar' => $value25['Mar'],
               'apr' => $value25['Apr'],
               'may' => $value25['May'],
               'jun' => $value25['Jun'],
               'jul' => $value25['Jul'],
               'aug' => $value25['Aug'],
               'sep' => $value25['Sep'],
               'total' => $value25['total'], 
        ];               
        }         
        $sql26="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                      select 'จำนวนผู้ป่วยเสียชีวิตด้วย Severe sepsis (R651) โรคหลัก' as pname,count(*) total,
                             count(if(month(death_date)=10,1,null)) as Oct,
                             count(if(month(death_date)=11,1,null)) as Nov,
                             count(if(month(death_date)=12,1,null))  as Dece,
                             count(if(month(death_date)=1,1,null))  as Jan,
                             count(if(month(death_date)=2,1,null))  as Feb,
                             count(if(month(death_date)=3,1,null))  as Mar,
                             count(if(month(death_date)=4,1,null))  as Apr,
                             count(if(month(death_date)=5,1,null))  as May,
                             count(if(month(death_date)=6,1,null))  as Jun,
                             count(if(month(death_date)=7,1,null))  as Jul,
                             count(if(month(death_date)=8,1,null))  as Aug,
                             count(if(month(death_date)=9,1,null)) as Sep
                             from death where death_date between '{$date1}' and '{$date2}' and death_diag_1 = 'R651' 
                      ) as pt ;";
        $result26 = \Yii::$app->db1->createCommand($sql26)->queryAll();
        foreach ($result26 as $value26) {
        $rawData[]=[
               'id' => '',
               'pname' => $value26['pname'],
               'oct' => $value26['Oct'],
               'nov' => $value26['Nov'],
               'dec' => $value26['Dece'],
               'jan' => $value26['Jan'],
               'feb' => $value26['Feb'],
               'mar' => $value26['Mar'],
               'apr' => $value26['Apr'],
               'may' => $value26['May'],
               'jun' => $value26['Jun'],
               'jul' => $value26['Jul'],
               'aug' => $value26['Aug'],
               'sep' => $value26['Sep'],
               'total' => $value26['total'], 
        ];               
        }          
        $sql27="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                      select 'จำนวนผู้ป่วยเสียชีวิตด้วย Sepsis Shock (R572) โรคหลัก' as pname,count(*) total,
                             count(if(month(death_date)=10,1,null)) as Oct,
                             count(if(month(death_date)=11,1,null)) as Nov,
                             count(if(month(death_date)=12,1,null))  as Dece,
                             count(if(month(death_date)=1,1,null))  as Jan,
                             count(if(month(death_date)=2,1,null))  as Feb,
                             count(if(month(death_date)=3,1,null))  as Mar,
                             count(if(month(death_date)=4,1,null))  as Apr,
                             count(if(month(death_date)=5,1,null))  as May,
                             count(if(month(death_date)=6,1,null))  as Jun,
                             count(if(month(death_date)=7,1,null))  as Jul,
                             count(if(month(death_date)=8,1,null))  as Aug,
                             count(if(month(death_date)=9,1,null)) as Sep
                             from death where death_date between '{$date1}' and '{$date2}' and death_diag_1 = 'R572' 
                      ) as pt ;";        
        $result27 = \Yii::$app->db1->createCommand($sql27)->queryAll();
        foreach ($result27 as $value27) {
        $rawData[]=[
               'id' => '',
               'pname' => $value27['pname'],
               'goal' => '',
               'oct' => $value27['Oct'],
               'nov' => $value27['Nov'],
               'dec' => $value27['Dece'],
               'jan' => $value27['Jan'],
               'feb' => $value27['Feb'],
               'mar' => $value27['Mar'],
               'apr' => $value27['Apr'],
               'may' => $value27['May'],
               'jun' => $value27['Jun'],
               'jul' => $value27['Jul'],
               'aug' => $value27['Aug'],
               'sep' => $value27['Sep'],
               'total' => $value27['total'], 
        ];               
        }           
        $sql28="select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                      select 'จำนวนผู้ป่วยเสียชีวิตด้วย (A40-A419) โรคหลัก' as pname,count(*) total,
                             count(if(month(death_date)=10,1,null)) as Oct,
                             count(if(month(death_date)=11,1,null)) as Nov,
                             count(if(month(death_date)=12,1,null))  as Dece,
                             count(if(month(death_date)=1,1,null))  as Jan,
                             count(if(month(death_date)=2,1,null))  as Feb,
                             count(if(month(death_date)=3,1,null))  as Mar,
                             count(if(month(death_date)=4,1,null))  as Apr,
                             count(if(month(death_date)=5,1,null))  as May,
                             count(if(month(death_date)=6,1,null))  as Jun,
                             count(if(month(death_date)=7,1,null))  as Jul,
                             count(if(month(death_date)=8,1,null))  as Aug,
                             count(if(month(death_date)=9,1,null)) as Sep
                             from death where death_date between '{$date1}' and '{$date2}' 
                                    and death_diag_1 between 'A40' and 'A4199' 
                      ) as pt ;";             
        $result28 = \Yii::$app->db1->createCommand($sql28)->queryAll();
        foreach ($result28 as $value28) {
        $rawData[]=[
               'id' => '',
               'pname' => $value28['pname'],
               'oct' => $value28['Oct'],
               'nov' => $value28['Nov'],
               'dec' => $value28['Dece'],
               'jan' => $value28['Jan'],
               'feb' => $value28['Feb'],
               'mar' => $value28['Mar'],
               'apr' => $value28['Apr'],
               'may' => $value28['May'],
               'jun' => $value28['Jun'],
               'jul' => $value28['Jul'],
               'aug' => $value28['Aug'],
               'sep' => $value28['Sep'],
               'total' => $value28['total'], 
        ];               
        }                
        $sql29 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Severe Sepsis (R651) โรคหลัก' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join vn_stat o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and v.icd10 = 'R651' 
                      ) as pt ;";
       $result29 = \Yii::$app->db1->createCommand($sql29)->queryAll();
        foreach ($result29 as $value29) {
        $rawData[]=[
               'id' => '',
               'pname' => $value29['pname'],
               'oct' => $value29['Oct'],
               'nov' => $value29['Nov'],
               'dec' => $value29['Dece'],
               'jan' => $value29['Jan'],
               'feb' => $value29['Feb'],
               'mar' => $value29['Mar'],
               'apr' => $value29['Apr'],
               'may' => $value29['May'],
               'jun' => $value29['Jun'],
               'jul' => $value29['Jul'],
               'aug' => $value29['Aug'],
               'sep' => $value29['Sep'],
               'total' => $value29['total'], 
        ];               
        }              
        $sql30 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Sepsis Shock (R572) โรคหลัก' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join vn_stat o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and v.icd10 = 'R572' 
                      ) as pt ;";
       $result30 = \Yii::$app->db1->createCommand($sql30)->queryAll();
        foreach ($result30 as $value30) {
        $rawData[]=[
               'id' => '',
               'pname' => $value30['pname'],
               'oct' => $value30['Oct'],
               'nov' => $value30['Nov'],
               'dec' => $value30['Dece'],
               'jan' => $value30['Jan'],
               'feb' => $value30['Feb'],
               'mar' => $value30['Mar'],
               'apr' => $value30['Apr'],
               'may' => $value30['May'],
               'jun' => $value30['Jun'],
               'jul' => $value30['Jul'],
               'aug' => $value30['Aug'],
               'sep' => $value30['Sep'],
               'total' => $value30['total'], 
        ];               
        }       
        $sql31 = "select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                      from (
                             select 'จำนวนการรับ ReferIn ผู้ป่วย Septicemia (A40-A419) โรคหลัก' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referin r inner join ovstdiag v on r.vn=v.vn inner join vn_stat o on v.vn=o.vn 
                                    where r.refer_date between '{$date1}' and '{$date2}' and v.icd10 between 'A40' and 'A4199' 
                      ) as pt ;";
       $result31 = \Yii::$app->db1->createCommand($sql31)->queryAll();
        foreach ($result31 as $value31) {
        $rawData[]=[
               'id' => '',
               'pname' => $value31['pname'],
               'oct' => $value31['Oct'],
               'nov' => $value31['Nov'],
               'dec' => $value31['Dece'],
               'jan' => $value31['Jan'],
               'feb' => $value31['Feb'],
               'mar' => $value31['Mar'],
               'apr' => $value31['Apr'],
               'may' => $value31['May'],
               'jun' => $value31['Jun'],
               'jul' => $value31['Jul'],
               'aug' => $value31['Aug'],
               'sep' => $value31['Sep'],
               'total' => $value31['total'], 
        ];               
        }          
        $sql32="select  pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                      sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                      from (
                             select 'จำนวนการส่งต่อ ReferOut รพ.ลูกข่าย(ยกเว็น รพ.บุรีรัมย์) ผู้ป่วย Sepsis ทั้งหมด' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referout r inner join vn_stat v on r.vn=v.vn inner join hospcode h on r.refer_hospcode=h.hospcode
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    (v.pdx like 'R651%' or v.pdx like 'R572%' or (v.pdx between 'A40' and 'A4199')) 
                                    and h.chwpart='31' and h.hospital_type_id=7
                      union all
                             select 'จำนวนการส่งต่อ ReferOut รพ.ลูกข่าย(ยกเว็น รพ.บุรีรัมย์) ผู้ป่วย Sepsis ทั้งหมด' as pname,count(*) total,
                             count(if(month(r.refer_date)=10,1,null)) as Oct,
                             count(if(month(r.refer_date)=11,1,null)) as Nov,
                             count(if(month(r.refer_date)=12,1,null))  as Dece,
                             count(if(month(r.refer_date)=1,1,null))  as Jan,
                             count(if(month(r.refer_date)=2,1,null))  as Feb,
                             count(if(month(r.refer_date)=3,1,null))  as Mar,
                             count(if(month(r.refer_date)=4,1,null))  as Apr,
                             count(if(month(r.refer_date)=5,1,null))  as May,
                             count(if(month(r.refer_date)=6,1,null))  as Jun,
                             count(if(month(r.refer_date)=7,1,null))  as Jul,
                             count(if(month(r.refer_date)=8,1,null))  as Aug,
                             count(if(month(r.refer_date)=9,1,null)) as Sep
                             from referout r inner join an_stat v on r.vn=v.an inner join hospcode h on r.refer_hospcode=h.hospcode 
                                    where r.refer_date between '{$date1}' and '{$date2}' and
                                    (v.pdx like 'R651%' or v.pdx like 'R572%' or (v.pdx between 'A40' and 'A4199')) 
                                    and h.chwpart='31' and h.hospital_type_id=7
                      ) as pt ;"; 
        $result32 = \Yii::$app->db1->createCommand($sql32)->queryAll();
        foreach ($result32 as $value32) {
        $rawData[]=[
               'id' => '',
               'pname' => $value32['pname'],
               'oct' => $value32['Oct'],
               'nov' => $value32['Nov'],
               'dec' => $value32['Dece'],
               'jan' => $value32['Jan'],
               'feb' => $value32['Feb'],
               'mar' => $value32['Mar'],
               'apr' => $value32['Apr'],
               'may' => $value32['May'],
               'jun' => $value32['Jun'],
               'jul' => $value32['Jul'],
               'aug' => $value32['Aug'],
               'sep' => $value32['Sep'],
               'total' => $value32['total'], 
        ];               
        }         
        
        
        $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 40,
                ],
        ]);          
        return $this->render('/site/ipd-icu/icu1-preview',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'yrs' => $yrs]);          
    }
     public function actionIcu2Index() {
        $model = new Formmodel();
        $names=" รายงานโรคหลักของภาวะ sepsis shock (R572)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;            
              return $this->redirect(['icu2_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ipd-icu/icu2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
     public function actionIcu2_preview($name,$d1,$d2) {
       $names = $name;
       $date1 = $d1;$date2 = $d2;
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs,
                IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate)) AS yers from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];    
               $yers = $value['yers'];
        }       
       $rawData = [];  
       $sql1 = "select  pdx, diag, total, Oct, Nov, Dece, Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep 
                      from (
                      select a.pdx, i.name diag, count(*) total,
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
                             from an_stat a  inner join icd101 i on i.code=a.pdx where a.dchdate between '{$date1}' and '{$date2}' 
                                     and  a.dx0='R572' group by a.pdx order by total desc
                      ) as pt;";
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pdx' => $value1['pdx'],            
               'diag' => $value1['diag'],
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
        $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 30,
                ],
        ]);                
        return $this->render('/site/ipd-icu/icu2-preview',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'yrs' => $yrs,'yers' => $yers]);          
     }
     public function actionIcu2_detail($m,$y) {
         
     }     
     public function actionIcu2_detail_total($m,$y) {
         
     }       
     
}    