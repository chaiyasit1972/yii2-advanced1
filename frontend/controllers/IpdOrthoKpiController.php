<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class IpdOrthoKpiController extends Controller
{
    public $mText = "งานศัลกรรมกระดูก";
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
    public function actionKpi1Index() {
        $model = new Formmodel();
        $names="อัตราการผ่าตัดภายใน 4 ช.ม.(open fracture long bone)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
               return $this->redirect($url.'kpi1.mrt&d1='.$date1.'&d2='.$date2);                             
        }
            return $this -> render('/site/ipd-ortho/kpi/kpi1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionKpi2Index() {
        $model = new Formmodel();
        $names="รายงานร้อยละของการดูแลรักษาของผู้ป่วยที่มีกระดูกหักไม่ซับซ้อน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
              return $this->redirect(['kpi2_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                         
        }
            return $this -> render('/site/ipd-ortho/kpi/kpi2-index',
                                            ['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionKpi2_preview($name,$d1,$d2) {
       $names = $name;
       $date1 = $d1;$date2 = $d2;
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }       
       $rawData = [];    
       $sql1="select  pname,sum(total) total, sum(Oct) Oct, sum(Nov) Nov, sum(Dece) Dece, sum(Jan) Jan, sum(Feb) Feb, sum(Mar) Mar, sum(Apr) Apr, sum(May) May, sum(Jun) Jun, sum(Jul) Jul, sum(Aug) Aug, sum(Sep) Sep 
                      from (
                      select 'จำนวนผู้ป่วย S4200-S42009 Fx clavicle ทั้งหมดใน รพ.' as pname,count(*) total,
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
                               and i.icd10 between 'S4200' and 'S42009'
                    UNION All
                      select 'จำนวนผู้ป่วย S4200-S42009 Fx clavicle ทั้งหมดใน รพ.' as pname,count(*) total,
                             count(if(month(vstdate)=10,1,null)) as Oct,
                             count(if(month(vstdate)=11,1,null)) as Nov,
                             count(if(month(vstdate)=12,1,null))  as Dece,
                             count(if(month(vstdate)=1,1,null))  as Jan,
                             count(if(month(vstdate)=2,1,null))  as Feb,
                             count(if(month(vstdate)=3,1,null))  as Mar,
                             count(if(month(vstdate)=4,1,null))  as Apr,
                             count(if(month(vstdate)=5,1,null))  as May,
                             count(if(month(vstdate)=6,1,null))  as Jun,
                             count(if(month(vstdate)=7,1,null))  as Jul,
                             count(if(month(vstdate)=8,1,null))  as Aug,
                             count(if(month(vstdate)=9,1,null)) as Sep
                             from ovstdiag  where vstdate between '{$date1}' and '{$date2}' 
                               and icd10 between 'S4200' and 'S42009'                    
 
                      ) as pta ;";
   
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
       $sql2="select  pname,sum(total) total, sum(Oct) Oct, sum(Nov) Nov, sum(Dece) Dece, sum(Jan) Jan, sum(Feb) Feb, sum(Mar) Mar, sum(Apr) Apr, sum(May) May, sum(Jun) Jun, sum(Jul) Jul, sum(Aug) Aug, sum(Sep) Sep 
                      from (
                      select 'จำนวนผู้ป่วย S6250 Fx นิ้วหัวแม่มือ ทั้งหมดใน รพ.' as pname,count(*) total,
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
                               and i.icd10 = 'S6250'
                    UNION All
                      select 'จำนวนผู้ป่วย S6250 Fx นิ้วหัวแม่มือ ทั้งหมดใน รพ.' as pname,count(*) total,
                             count(if(month(vstdate)=10,1,null)) as Oct,
                             count(if(month(vstdate)=11,1,null)) as Nov,
                             count(if(month(vstdate)=12,1,null))  as Dece,
                             count(if(month(vstdate)=1,1,null))  as Jan,
                             count(if(month(vstdate)=2,1,null))  as Feb,
                             count(if(month(vstdate)=3,1,null))  as Mar,
                             count(if(month(vstdate)=4,1,null))  as Apr,
                             count(if(month(vstdate)=5,1,null))  as May,
                             count(if(month(vstdate)=6,1,null))  as Jun,
                             count(if(month(vstdate)=7,1,null))  as Jul,
                             count(if(month(vstdate)=8,1,null))  as Aug,
                             count(if(month(vstdate)=9,1,null)) as Sep
                             from ovstdiag  where vstdate between '{$date1}' and '{$date2}' 
                               and icd10 = 'S6250'                     
 
                      ) as pta ;";   
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
       $sql3="select  pname,sum(total) total, sum(Oct) Oct, sum(Nov) Nov, sum(Dece) Dece, sum(Jan) Jan, sum(Feb) Feb, sum(Mar) Mar, sum(Apr) Apr, sum(May) May, sum(Jun) Jun, sum(Jul) Jul, sum(Aug) Aug, sum(Sep) Sep 
                      from (
                      select 'จำนวนผู้ป่วย S6260 Fx นิ้วหัวมืออื่น ทั้งหมดใน รพ.' as pname,count(*) total,
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
                               and i.icd10 = 'S6260'
                    UNION All
                      select 'จำนวนผู้ป่วย S6260 Fx นิ้วหัวมืออื่น ทั้งหมดใน รพ.' as pname,count(*) total,
                             count(if(month(vstdate)=10,1,null)) as Oct,
                             count(if(month(vstdate)=11,1,null)) as Nov,
                             count(if(month(vstdate)=12,1,null))  as Dece,
                             count(if(month(vstdate)=1,1,null))  as Jan,
                             count(if(month(vstdate)=2,1,null))  as Feb,
                             count(if(month(vstdate)=3,1,null))  as Mar,
                             count(if(month(vstdate)=4,1,null))  as Apr,
                             count(if(month(vstdate)=5,1,null))  as May,
                             count(if(month(vstdate)=6,1,null))  as Jun,
                             count(if(month(vstdate)=7,1,null))  as Jul,
                             count(if(month(vstdate)=8,1,null))  as Aug,
                             count(if(month(vstdate)=9,1,null)) as Sep
                             from ovstdiag  where vstdate between '{$date1}' and '{$date2}' 
                               and icd10 = 'S6260'                     
 
                      ) as pta ;";   
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
       $sql4="select  pname,sum(total) total, sum(Oct) Oct, sum(Nov) Nov, sum(Dece) Dece, sum(Jan) Jan, sum(Feb) Feb, sum(Mar) Mar, sum(Apr) Apr, sum(May) May, sum(Jun) Jun, sum(Jul) Jul, sum(Aug) Aug, sum(Sep) Sep 
                      from (
                      select 'จำนวนผู้ป่วย S9240 Fx นิ้วหัวแม่เท้า ทั้งหมดใน รพ.' as pname,count(*) total,
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
                               and i.icd10 = 'S9240'
                    UNION All
                      select 'จำนวนผู้ป่วย S9240 Fx นิ้วหัวแม่เท้า ทั้งหมดใน รพ.' as pname,count(*) total,
                             count(if(month(vstdate)=10,1,null)) as Oct,
                             count(if(month(vstdate)=11,1,null)) as Nov,
                             count(if(month(vstdate)=12,1,null))  as Dece,
                             count(if(month(vstdate)=1,1,null))  as Jan,
                             count(if(month(vstdate)=2,1,null))  as Feb,
                             count(if(month(vstdate)=3,1,null))  as Mar,
                             count(if(month(vstdate)=4,1,null))  as Apr,
                             count(if(month(vstdate)=5,1,null))  as May,
                             count(if(month(vstdate)=6,1,null))  as Jun,
                             count(if(month(vstdate)=7,1,null))  as Jul,
                             count(if(month(vstdate)=8,1,null))  as Aug,
                             count(if(month(vstdate)=9,1,null)) as Sep
                             from ovstdiag  where vstdate between '{$date1}' and '{$date2}' 
                               and icd10 = 'S9240'                     
 
                      ) as pta ;";   
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
       $sql5="select  pname,sum(total) total, sum(Oct) Oct, sum(Nov) Nov, sum(Dece) Dece, sum(Jan) Jan, sum(Feb) Feb, sum(Mar) Mar, sum(Apr) Apr, sum(May) May, sum(Jun) Jun, sum(Jul) Jul, sum(Aug) Aug, sum(Sep) Sep 
                      from (
                      select 'จำนวนผู้ป่วย S9250 Fx นิ้วหัวเท้าอื่น ทั้งหมดใน รพ.' as pname,count(*) total,
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
                               and i.icd10 = 'S9250'
                    UNION All
                      select 'จำนวนผู้ป่วย S9250 Fx นิ้วหัวเท้าอื่น ทั้งหมดใน รพ.' as pname,count(*) total,
                             count(if(month(vstdate)=10,1,null)) as Oct,
                             count(if(month(vstdate)=11,1,null)) as Nov,
                             count(if(month(vstdate)=12,1,null))  as Dece,
                             count(if(month(vstdate)=1,1,null))  as Jan,
                             count(if(month(vstdate)=2,1,null))  as Feb,
                             count(if(month(vstdate)=3,1,null))  as Mar,
                             count(if(month(vstdate)=4,1,null))  as Apr,
                             count(if(month(vstdate)=5,1,null))  as May,
                             count(if(month(vstdate)=6,1,null))  as Jun,
                             count(if(month(vstdate)=7,1,null))  as Jul,
                             count(if(month(vstdate)=8,1,null))  as Aug,
                             count(if(month(vstdate)=9,1,null)) as Sep
                             from ovstdiag  where vstdate between '{$date1}' and '{$date2}' 
                               and icd10 = 'S9250'                     
 
                      ) as pta ;";   
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
       $sql6="select  pname,sum(total) total, sum(Oct) Oct, sum(Nov) Nov, sum(Dece) Dece, sum(Jan) Jan, sum(Feb) Feb, sum(Mar) Mar, sum(Apr) Apr, sum(May) May, sum(Jun) Jun, sum(Jul) Jul, sum(Aug) Aug, sum(Sep) Sep 
                      from (
                      select 'จำนวนผู้ป่วย S5250 - S52509  Fx dis radius  ทั้งหมดใน รพ.' as pname,count(*) total,
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
                               and i.icd10 between 'S5250' and 'S52509'
                    UNION All
                      select 'จำนวนผู้ป่วย S5250 - S52509  Fx dis radius  ทั้งหมดใน รพ.' as pname,count(*) total,
                             count(if(month(vstdate)=10,1,null)) as Oct,
                             count(if(month(vstdate)=11,1,null)) as Nov,
                             count(if(month(vstdate)=12,1,null))  as Dece,
                             count(if(month(vstdate)=1,1,null))  as Jan,
                             count(if(month(vstdate)=2,1,null))  as Feb,
                             count(if(month(vstdate)=3,1,null))  as Mar,
                             count(if(month(vstdate)=4,1,null))  as Apr,
                             count(if(month(vstdate)=5,1,null))  as May,
                             count(if(month(vstdate)=6,1,null))  as Jun,
                             count(if(month(vstdate)=7,1,null))  as Jul,
                             count(if(month(vstdate)=8,1,null))  as Aug,
                             count(if(month(vstdate)=9,1,null)) as Sep
                             from ovstdiag  where vstdate between '{$date1}' and '{$date2}' 
                               and icd10 between 'S5250' and 'S52509'                    
 
                      ) as pta ;";   
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
       $sql7="select  pname,sum(total) total, sum(Oct) Oct, sum(Nov) Nov, sum(Dece) Dece, sum(Jan) Jan, sum(Feb) Feb, sum(Mar) Mar, sum(Apr) Apr, sum(May) May, sum(Jun) Jun, sum(Jul) Jul, sum(Aug) Aug, sum(Sep) Sep 
                      from (
                      select 'จำนวนผู้ป่วย S5260 Fx dis ulna and radius  ทั้งหมดใน รพ.' as pname,count(*) total,
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
                               and i.icd10 = 'S5260'
                    UNION All
                      select 'จำนวนผู้ป่วย S5260 Fx dis ulna and radius  ทั้งหมดใน รพ.' as pname,count(*) total,
                             count(if(month(vstdate)=10,1,null)) as Oct,
                             count(if(month(vstdate)=11,1,null)) as Nov,
                             count(if(month(vstdate)=12,1,null))  as Dece,
                             count(if(month(vstdate)=1,1,null))  as Jan,
                             count(if(month(vstdate)=2,1,null))  as Feb,
                             count(if(month(vstdate)=3,1,null))  as Mar,
                             count(if(month(vstdate)=4,1,null))  as Apr,
                             count(if(month(vstdate)=5,1,null))  as May,
                             count(if(month(vstdate)=6,1,null))  as Jun,
                             count(if(month(vstdate)=7,1,null))  as Jul,
                             count(if(month(vstdate)=8,1,null))  as Aug,
                             count(if(month(vstdate)=9,1,null)) as Sep
                             from ovstdiag  where vstdate between '{$date1}' and '{$date2}' 
                               and icd10 = 'S5260'                     
 
                      ) as pta ;";   
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
       $sql8="select  pname,sum(total) total, sum(Oct) Oct, sum(Nov) Nov, sum(Dece) Dece, sum(Jan) Jan, sum(Feb) Feb, sum(Mar) Mar, sum(Apr) Apr, sum(May) May, sum(Jun) Jun, sum(Jul) Jul, sum(Aug) Aug, sum(Sep) Sep 
                      from (
                      select 'จำนวนผู้ป่วย S52800 - S52809 Fx แขนท่อนปลาย ทั้งหมดใน รพ.' as pname,count(*) total,
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
                               and i.icd10 between 'S5280' and 'S52809'
                    UNION All
                      select 'จำนวนผู้ป่วย S52800 - S52809 Fx แขนท่อนปลายทั้งหมดใน รพ.' as pname,count(*) total,
                             count(if(month(vstdate)=10,1,null)) as Oct,
                             count(if(month(vstdate)=11,1,null)) as Nov,
                             count(if(month(vstdate)=12,1,null))  as Dece,
                             count(if(month(vstdate)=1,1,null))  as Jan,
                             count(if(month(vstdate)=2,1,null))  as Feb,
                             count(if(month(vstdate)=3,1,null))  as Mar,
                             count(if(month(vstdate)=4,1,null))  as Apr,
                             count(if(month(vstdate)=5,1,null))  as May,
                             count(if(month(vstdate)=6,1,null))  as Jun,
                             count(if(month(vstdate)=7,1,null))  as Jul,
                             count(if(month(vstdate)=8,1,null))  as Aug,
                             count(if(month(vstdate)=9,1,null)) as Sep
                             from ovstdiag  where vstdate between '{$date1}' and '{$date2}' 
                               and icd10 between 'S5280' and 'S52809'                   
 
                      ) as pta ;";   
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
        $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 30,
                ],
        ]);          
        return $this->render('/site/ipd-ortho/kpi/kpi2-preview',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'yrs' => $yrs]);          
    }    
    public function actionKpi3Index() {
        $model = new Formmodel();
        $names="รายงานสาเหตุการตายสูงสุด(แยก ทั้งหมด/รายโรค/รายชื่อ)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ipd_ortho/";   
               return $this->redirect($url.'kpi3.mrt&d1='.$date1.'&d2='.$date2);                             
        }
            return $this -> render('/site/ipd-ortho/kpi/kpi1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
}    

