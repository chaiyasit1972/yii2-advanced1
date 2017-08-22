<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class ServicePlan1Controller extends Controller
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
        $names="ผลการดำเนินงานการให้บริการ โรคหลอดเลือดสมอง"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/service_plan1/index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
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
        $sql1="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนผู้ป่วย Stroke รหัส ICD 10 หมวด I60-I69' as pname,count(*) total,
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
                                   from ovstdiag o 
                                   inner join er_regist e on o.vn=e.vn 
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 between 'I60' and 'I699' 
                                   and o.diagtype='1'
                         union
                         select 'จำนวนผู้ป่วย Stroke รหัส ICD 10 หมวด I60-I69' as pname,count(*) total,
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
                                   from ipt a 
                                   inner join iptdiag i on a.an=i.an 
                                   where a.dchdate between '{$date1}' and '{$date2}' 
                                   and i.icd10 between 'I60' and 'I699'   
                                   and i.diagtype='1'
                                   and a.vn NOT IN(
                                        select vn
                                        from ovstdiag  
                                        where vstdate between '{$date1}' and '{$date2}' 
                                        and icd10 between 'I60' and 'I699' 
                                        and diagtype='1'
                                         )
                             ) as pt 
                       ) as ds ;";                                                       
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
               'pname' => 'ร้อยละของผู้ป่วยที่เข้าถึงบริการ Stroke fast track',
               'goal' => '20 %',
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
               'pname' => 'สถานบริการระดับ M1/S/A ที่สามารถให้ยาละลายลิ่มเลือดได้',
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
               'pname' => 'อัตราการได้รับยาละลายลิ่มเลือด (Thrombolytic agent) ของผู้ป่วยหลอดเลือดสมองตีบ/อุดตัน 
                                 ภายใน 4.30 ชั่วโมง ตั้งแต่เริ่มมีอาการภาวะหลอดเลือด',
               'goal' => '3 %',
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
               'pname' => 'มีการจัดตั้ง Stroke corner',
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
        $sql2="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนการตายด้วยโรคหลอดเลือดสมองตามรหัส I60-I69' as pname,count(*) total,
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
                                   from ovstdiag o 
                                   inner join er_regist e on o.vn=e.vn 
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 between 'I60' and 'I699'                                   
                                   and o.diagtype='1'
                                   and e.er_dch_type='4'
                         union
                         select 'จำนวนการตายด้วยโรคหลอดเลือดสมองตามรหัส I60-I69' as pname,count(*) total,
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
                                   from ipt a 
                                   inner join iptdiag i on a.an=i.an 
                                   where a.dchdate between '{$date1}' and '{$date2}' 
                                   and i.icd10 between 'I60' and 'I699'   
                                   and i.diagtype='1'
                                   AND a.dchtype IN('08','09')
                                   and a.vn NOT IN(
                                        select vn
                                        from ovstdiag  
                                        where vstdate between '{$date1}' and '{$date2}' 
                                        and icd10 between 'I60' and 'I699' 
                                        and diagtype='1'
                                         )
                             ) as pt 
                       ) as ds ;";                                                       
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
        $sql3="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนผู้ป่วย Stroke ที่ refer ไปรพ.ที่มีศักยภาพ (ราย)' as pname,count(*) total,
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
                                   from ovstdiag o 
                                   inner join er_regist e on o.vn=e.vn 
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 between 'I60' and 'I699'                                   
                                   and o.diagtype='1'
                                   and e.er_dch_type='2'
                         union
                         select 'จำนวนผู้ป่วย Stroke ที่ refer ไปรพ.ที่มีศักยภาพ (ราย)' as pname,count(*) total,
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
                                   from ipt a 
                                   inner join iptdiag i on a.an=i.an 
                                   where a.dchdate between '{$date1}' and '{$date2}' 
                                   and i.icd10 between 'I60' and 'I699'   
                                   and i.diagtype='1'
                                   AND a.dchtype IN('04')
                                   and a.vn NOT IN(
                                        select vn
                                        from ovstdiag  
                                        where vstdate between '{$date1}' and '{$date2}' 
                                        and icd10 between 'I60' and 'I699' 
                                        and diagtype='1'
                                         )
                             ) as pt 
                       ) as ds ;";                                                       
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
        $sql4="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนผู้ป่วย Cerebral infarction อายุ 15 ปีขึ้นไป (ICD-10 หมวด I63)' as pname,count(*) total,
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
                                   from ovstdiag o 
                                   inner join er_regist e on o.vn=e.vn 
                                   inner join vn_stat v on e.vn=v.vn
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 between 'I63' and 'I639'                                   
                                   and o.diagtype='1'
                                   and v.age_y > 15
                         union
                         select 'จำนวนผู้ป่วย Cerebral infarction อายุ 15 ปีขึ้นไป (ICD-10 หมวด I63)' as pname,count(*) total,
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
                                   from ipt a 
                                   inner join an_stat s on a.an=s.an 
                                   inner join iptdiag i on a.an=i.an 
                                   where a.dchdate between '{$date1}' and '{$date2}' 
                                   and i.icd10 between 'I63' and 'I639'   
                                   and i.diagtype='1'
                                   AND s.age_y>15
                                   and a.vn NOT IN(
                                        select vn
                                        from ovstdiag  
                                        where vstdate between '{$date1}' and '{$date2}' 
                                        and icd10 between 'I63' and 'I639' 
                                        and diagtype='1'
                                         )
                             ) as pt 
                       ) as ds ;";                                                       

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
                      from (select 'จำนวนผู้ป่วยที่ Admit ด้วย ICD-10 (I63) ที่มีอายุ 15 ปีขึ้นไป และได้รับยาละลายลิ้มเลือด ICD-9 (9910)' as pname,
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
                      from iptdiag i left outer join an_stat a on a.an=i.an left outer join opitemrece o on a.an=o.an
                      where a.dchdate between '{$date1}' and '{$date2}' and i.icd10 between 'I630'  and 'I639' 
                      and o.icode in ('1570009','1510076') and a.age_y > 15 ) pt;";                                                       
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
        $sql6="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนผู้เสียชีวิตของ Cerebral infarction อายุ 15 ปีขึ้นไป (ICD-10 หมวด I63)' as pname,count(*) total,
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
                                   from ovstdiag o 
                                   inner join er_regist e on o.vn=e.vn 
                                   inner join vn_stat v on e.vn=v.vn
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 between 'I63' and 'I639'                                   
                                   and o.diagtype='1'
                                   and v.age_y>15
                                   and e.er_dch_type='4'
                         union
                         select 'จำนวนผู้เสียชีวิตของ Cerebral infarction อายุ 15 ปีขึ้นไป (ICD-10 หมวด I63)' as pname,count(*) total,
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
                                   from ipt a 
                                   inner join an_stat s on a.an=s.an 
                                   inner join iptdiag i on a.an=i.an 
                                   where a.dchdate between '{$date1}' and '{$date2}' 
                                   and i.icd10 between 'I63' and 'I639'   
                                   and i.diagtype='1'
                                   and s.age_y>15
                                   and a.dchtype IN('08','09')
                                   and a.vn NOT IN(
                                        select vn
                                        from ovstdiag  
                                        where vstdate between '{$date1}' and '{$date2}' 
                                        and icd10 between 'I63' and 'I639' 
                                        and diagtype='1'
                                         )
                             ) as pt 
                       ) as ds ;";                                                       
        
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
        $rawData[]=[
               'id' => '',
               'pname' => 'อัตราการเสียชีวิตของ Cerebral infarction อายุ 15 ปีขึ้นไป (ICD-10 หมวด I63)',
               'goal' => 'ลดลงจากปีที่ผ่านมา',
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
               'pname' => 'ร้อยละของผู้ป่วย Cerebral infarction (ICD-10 หมวด I63) ได้รับการติดตามเยี่ยม',
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
        $sql7="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนผู้ป่วย เลือดออกในสมอง รหัส ICD 10 หมวด I621,I629' as pname,count(*) total,
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
                                   from ovstdiag o 
                                   inner join er_regist e on o.vn=e.vn 
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 in('I621','I629')   
                                   and o.diagtype='1'
                         union
                         select 'จำนวนผู้ป่วย เลือดออกในสมอง รหัส ICD 10 หมวด I621,I629' as pname,count(*) total,
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
                                   from ipt a 
                                   inner join iptdiag i on a.an=i.an 
                                   where a.dchdate between '{$date1}' and '{$date2}' 
                                   and i.icd10 in('I621','I629')   
                                   and i.diagtype='1'
                                   and a.vn NOT IN(
                                        select vn
                                        from ovstdiag  
                                        where vstdate between '{$date1}' and '{$date2}' 
                                        and icd10 in('I621','I629')   
                                        and diagtype='1'
                                         )
                             ) as pt 
                       ) as ds ;";                                                       
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
        $sql8="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนผู้ป่วยเสียชีวิตของโรค เลือดออกในสมอง อายุ 15 ปีขึ้นไป รหัส ICD 10 หมวด I621,I629' as pname,count(*) total,
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
                                   from ovstdiag o 
                                   inner join er_regist e on o.vn=e.vn 
                                   inner join vn_stat v on v.vn=o.vn
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 in('I621','I629')   
                                   and v.age_y >=15
                                   and o.diagtype='1'
                                   and e.er_dch_type='4'
                         union
                         select 'จำนวนผู้ป่วยเสียชีวิตของโรค เลือดออกในสมอง อายุ 15 ปีขึ้นไป รหัส ICD 10 หมวด I621,I629' as pname,count(*) total,
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
                                   from ipt a 
                                   inner join iptdiag i on a.an=i.an 
                                   where a.dchdate between '{$date1}' and '{$date2}' 
                                   and i.icd10 in('I621','I629')    
                                   and i.diagtype='1'
                                   and a.dchtype IN('08','09')
                                   and a.vn NOT IN(
                                        select vn
                                        from ovstdiag  
                                        where vstdate between '{$date1}' and '{$date2}' 
                                        and icd10 in('I621','I629')   
                                        and diagtype='1'
                                         )
                             ) as pt 
                       ) as ds ;";                                                       
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
        
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/service_plan1/preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'date1' => $date1, 'date2' => $date2,'yrs' => $yrs]);          
    }
    
}