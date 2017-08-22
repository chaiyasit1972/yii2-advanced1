<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class PharDrugController extends Controller
{
    public $mText = "งานเภสัชกรรม(งานผลิตยา)";
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
        $names="งานเภสัชกรรม(งานผลิตยา)"; 
         return $this -> render('/site/phar-drug/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionPharDrug1Index() {
        $model = new Formmodel();
        $names="รายงาน Extemporaneous Fomulations For Pediatric"; 
        $sql1 = "select concat(icode,',',name) id, name names from drugitems where
                     icode in ('1520061','1520062','1520064','1520060','1520063','1520082','1520036','1570010') order by icode;";
        $locations = \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','names');          
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               $drug = explode(',', $model->select1);
               $icode = $drug[0];               
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Phar_drug/";   
            return $this->redirect($url.'Phar_drug1.mrt&d1='.$date1.'&d2='.$date2.'&i1='.$icode);                     
        }
            return $this -> render('/site/phar-drug/phar-drug1-index',['mText'=>$this->mText,'names'=>$names, 
                                             'model' => $model, 'data' => $listData]);
    }   
    public function actionPharDrug2Index() {
        $model = new Formmodel();
        $names="รายงานยาตาเฉพาะราย"; 
        $sql1 = "select concat(icode,',',name) id, name names from drugitems where
                     icode in ('1550017','1550013','1550012','1550019','1550018','1550016','1550020','1550014',
                     '1550015','1560024') order by icode;";
        $locations = \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','names');          
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               $drug = explode(',', $model->select1);
               $icode = $drug[0];               
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Phar_drug/";   
            return $this->redirect($url.'Phar_drug2.mrt&d1='.$date1.'&d2='.$date2.'&i1='.$icode);                     
        }
            return $this -> render('/site/phar-drug/phar-drug2-index',['mText'=>$this->mText,'names'=>$names, 
                                             'model' => $model, 'data' => $listData]);
    }       
    public function actionPharDrug3Index() {
        $model = new Formmodel();
        $names=" รายงานยาเคมีบำบัด"; 
        $sql1 = "select concat(icode,',',if(icode in('1560050','1520083'),concat(name, '  ',strength),name)  ) id,
                      if(icode in('1560050','1520083'),concat(name, '  ',strength),name) names  from drugitems where
                      icode in ('1550046','1560043','1560047','1560044','1560048','1560046','1560045','1560050','1520083') 
                      order by name;";
        $locations = \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','names');          
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               $drug = explode(',', $model->select1);
               $icode = $drug[0];
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Phar_drug/";   
            return $this->redirect($url.'Phar_drug3.mrt&d1='.$date1.'&d2='.$date2.'&i1='.$icode);                     
        }
            return $this -> render('/site/phar-drug/phar-drug3-index',['mText'=>$this->mText,'names'=>$names, 
                                             'model' => $model, 'data' => $listData]);
    }       
    
}    

