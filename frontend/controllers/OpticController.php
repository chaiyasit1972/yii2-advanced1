<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class OpticController extends Controller
{
    public $mText = "งานห้องตรวจตา(จักษุ)";
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
        $names="งานห้องตรวจตา(จักษุ)"; 
         return $this -> render('/site/optic/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionOptic1Index() {
        $model = new Formmodel();
        $names="รายงานการส่งต่อ(refer-out) ผู้ป่วยโรคตา"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['optic1_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/optic/optic1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionOptic1_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1 = "select v.aid, r.hn, r.refer_number, concat(p.pname,p.fname,' ',p.lname) pname, r.refer_date, r.pre_diagnosis, r.pdx, 
                    i.name diag,d.name doctor,h.`name` hospital,if(substr(v.aid,1,4)='3104','ในเขต','นอกเขต') status from referout r 
                    inner join patient p on r.hn=p.hn
                    inner join vn_stat v on r.vn=v.vn
                    inner join hospcode h on r.refer_hospcode=h.hospcode
                    inner join doctor d on r.doctor=d.`code`
                    left outer join icd101 i on r.pdx=i.code
                    where r.spclty='07' and r.refer_date between '{$date1}' and '{$date2}' ;";
        $sql2 = "select v.aid, r.hn, r.refer_number, concat(p.pname,p.fname,' ',p.lname) pname, r.refer_date, r.pre_diagnosis, r.pdx, 
                    i.name diag,d.name doctor,h.`name` hospital,if(substr(v.aid,1,4)='3104','ในเขต','นอกเขต') status from referout r 
                    inner join patient p on r.hn=p.hn
                    inner join vn_stat v on r.vn=v.vn
                    inner join hospcode h on r.refer_hospcode=h.hospcode
                    inner join doctor d on r.doctor=d.`code`
                    left outer join icd101 i on r.pdx=i.code
                    where r.spclty='07' and substr(v.aid,1,4) = '3104' and r.refer_date between '{$date1}' and '{$date2}' ;"; 
        $sql3 = "select v.aid, r.hn, r.refer_number, concat(p.pname,p.fname,' ',p.lname) pname, r.refer_date, r.pre_diagnosis, r.pdx, 
                    i.name diag,d.name doctor,h.`name` hospital,if(substr(v.aid,1,4)='3104','ในเขต','นอกเขต') status from referout r 
                    inner join patient p on r.hn=p.hn
                    inner join vn_stat v on r.vn=v.vn
                    inner join hospcode h on r.refer_hospcode=h.hospcode
                    inner join doctor d on r.doctor=d.`code`
                    left outer join icd101 i on r.pdx=i.code
                    where r.spclty='07' and substr(v.aid,1,4) != '3104' and r.refer_date between '{$date1}' and '{$date2}' ;";                         
        try {
            $rawData1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }    
        try {
            $rawData2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        try {
            $rawData3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }        
        $dataProvider1 = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData1,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);  
        $dataProvider2 = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData2,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]); 
        $dataProvider3 = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData3,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);         
        return $this -> render('/site/optic/optic1-preview',
                             [
                                    'dataProvider1' => $dataProvider1,
                                    'dataProvider2' => $dataProvider2,
                                    'dataProvider3' => $dataProvider3,                                 
                                     'names' => $names,
                                     'mText' => $this->mText,
                                     'date1'=>$date1,
                                     'date2'=>$date2
                             ]);                 
    } 
      public function actionOptic2Index() {
        $model = new Formmodel();
        $names=" รายงานผู้ป่วยต้อกระจก(ผู้ป่วยนอก) H544 ที่ยังไม่ได้รับการผ่าตัด"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=optic/";   
            return $this->redirect($url.'optic1.mrt&d1='.$date1.'&d2='.$date2);  
        }
            return $this -> render('/site/optic/optic2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  
      public function actionOptic3Index() {
        $model = new Formmodel();
        $names=" รายงาน 10 อันดับ ผู้ป่วยนอกแผนกจักษุ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=optic/";   
            return $this->redirect($url.'optic3.mrt&d1='.$date1.'&d2='.$date2);  
        }
            return $this -> render('/site/optic/optic3-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
}    
