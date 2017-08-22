<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class CopdController extends Controller
{
    public $mText = "คลินิกผู้ป่วยโรคเรื้อรัง(COPD)";
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
        $names="คลินิกผู้ป่วยโรคเรื้อรัง(COPD)"; 
         return $this -> render('/site/copd/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionCopd1Index() {
        $names="รายงานแบบประเมิณตนเอง ด้านผู้ป่วยโรค COPD (J440,J441,J449)";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
              return $this->redirect(['copd1-preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                   
        }
            return $this -> render('/site/copd/copd1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
     }
    public function actionCopd1Preview($name,$d1,$d2) {
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
                         select 'จำนวนผู้ป่วย COPD(J440,J441,J449) ที่มา OPD ทั้งหมด(คน)' as pname,count(*) total,
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
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 in ('J440','J441','J449') group by o.hn
                             ) as pt 
                       ) as ds;";                                                       
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
/*        $sql2="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนผู้ป่วย COPD(J440,J441,J449) ที่มา OPD CLINIC ทั้งหมด(คน)' as pname,count(*) total,
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
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 in ('J440','J441','J449') group by o.hn
                             ) as pt 
                       ) as ds;";                                                       
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
*/       
       $sql3="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนผู้ป่วย COPD(J440) ที่มา ER ด้วย exacerbation ได้พ่นยา แล้วกลับบ้าน(ครั้ง)' as pname,count(*) total,
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
                                   inner join er_regist_oper eo on eo.vn=o.vn
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 in ('J440') and eo.er_oper_code='10'
                             ) as pt 
                       ) as ds;";                                                       
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
                         select 'จำนวนผู้ป่วย COPD(J441) ที่มา ER ด้วย exacerbation ได้พ่นยา แล้วกลับบ้าน(ครั้ง)' as pname,count(*) total,
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
                                   inner join er_regist_oper eo on eo.vn=o.vn
                                   where o.vstdate between '{$date1}' and '{$date2}' 
                                   and o.icd10 in ('J441') and eo.er_oper_code='10'
                             ) as pt 
                       ) as ds;";                                                       
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
       $sql5="select pname,sum(total) total,sum(Oct) Oct,sum(Nov) Nov,sum(Dece) Dece,sum(Jan) Jan,sum(Feb) Feb,sum(Mar) Mar,
                  sum(Apr) Apr,sum(May) May,sum(Jun) Jun,sum(Jul) Jul,sum(Aug) Aug,sum(Sep) Sep 
                  from (
                        select  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                         from (
                         select 'จำนวนผู้ป่วย COPD(J440,J441,J449) ที่ได้ admit ด้วย exacerbation นับรวม pneumonia J440 (ครั้ง) ' as pname,count(*) total,
                             count(if(month(ip.dchdate)=10,1,null)) as Oct,
                             count(if(month(ip.dchdate)=11,1,null)) as Nov,
                             count(if(month(ip.dchdate)=12,1,null))  as Dece,
                             count(if(month(ip.dchdate)=1,1,null))  as Jan,
                             count(if(month(ip.dchdate)=2,1,null))  as Feb,
                             count(if(month(ip.dchdate)=3,1,null))  as Mar,
                             count(if(month(ip.dchdate)=4,1,null))  as Apr,
                             count(if(month(ip.dchdate)=5,1,null))  as May,
                             count(if(month(ip.dchdate)=6,1,null))  as Jun,
                             count(if(month(ip.dchdate)=7,1,null))  as Jul,
                             count(if(month(ip.dchdate)=8,1,null))  as Aug,
                             count(if(month(ip.dchdate)=9,1,null)) as Sep
                                   from iptdiag i inner join ipt ip on i.an=ip.an
                                   where ip.dchdate between '{$date1}' and '{$date2}' 
                                   and i.icd10 in ('J440','J441','J449') group by i.an
                             ) as pt 
                       ) as ds;";                                                       
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
                         select 'จำนวนผู้ป่วย COPD(J440,J449) ที่ได้ admit ด้วย exacerbation ไม่นับรวม pneumonia J441 (ครั้ง) ' as pname,count(*) total,
                             count(if(month(ip.dchdate)=10,1,null)) as Oct,
                             count(if(month(ip.dchdate)=11,1,null)) as Nov,
                             count(if(month(ip.dchdate)=12,1,null))  as Dece,
                             count(if(month(ip.dchdate)=1,1,null))  as Jan,
                             count(if(month(ip.dchdate)=2,1,null))  as Feb,
                             count(if(month(ip.dchdate)=3,1,null))  as Mar,
                             count(if(month(ip.dchdate)=4,1,null))  as Apr,
                             count(if(month(ip.dchdate)=5,1,null))  as May,
                             count(if(month(ip.dchdate)=6,1,null))  as Jun,
                             count(if(month(ip.dchdate)=7,1,null))  as Jul,
                             count(if(month(ip.dchdate)=8,1,null))  as Aug,
                             count(if(month(ip.dchdate)=9,1,null)) as Sep
                                   from iptdiag i inner join ipt ip on i.an=ip.an
                                   where ip.dchdate between '{$date1}' and '{$date2}' 
                                   and i.icd10 in ('J440','J449') group by i.an
                             ) as pt 
                       ) as ds;";                                                       
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
        return $this -> render('/site/copd/copd1-preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'date1' => $date1, 'date2' => $date2,'yrs' => $yrs]);          
        
    }

}

