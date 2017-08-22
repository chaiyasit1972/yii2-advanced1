<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class ArvController extends Controller
{
    public $mText = "งานคลินิกยาต้านผู้ป่วยโรคเรื้อรัง(ARV)";
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
        $names="งานคลินิกยาต้านผู้ป่วยโรคเรื้อรัง(ARV)"; 
         return $this -> render('/site/arv/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionArv0Index() {
        $names="รายงานทะเบียนผู้ป่วยคลินิก ARV แยกตามหน่วยบริการ";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $h=  explode(',', $model->select1);$hcode=$h[0];               
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv0.mrt&d1='.$date1.'&h1='.$hcode);                       
        }
            return $this -> render('/site/arv/arv0-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}    
     public function actionArv1Index() {
        $names="รายงานเวชระเบียนผู้ป่วยคลินิก ARV";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv1.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv2Index() {
        $names="รายงานผู้ป่วย(ARV) ที่เริ่มกินยาวัณโรคครั้งแรก ";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv2.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv3Index() {
        $names="รายงานผู้ป่วยวัณโรคที่เจาะ HIV (TB A160-A199)";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv3.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv3-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv4Index() {
        $names="รายงานผู้ป่วยวัณโรคที่มีผล HIV เป็นบวก(B200) ได้รับการเจาะ CD4";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv4.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv4-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv5Index() {
        $names="รายงานผู้ป่วยวัณโรคที่มีผล HIV เป็นบวก(B200) และได้เริ่มกินยาต้านไวรัส";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv5.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv5-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv6Index() {
        $names="รายงานผู้ป่วยติดเชื้อ HIV รายใหม่ที่ได้เจาะ CD4 และผลการเจาะ";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv6.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv6-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv7Index() {
        $names="รายงานผู้ป่วยติดเชื้อ HIV รายใหม่และได้เริ่มกินยาต้านไวรัสครั้งแรก";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv7.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv7-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv8Index() {
        $names="รายงานผู้ป่วยนอกที่มาตรวจเลือด HIV";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv8.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv8-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv9Index() {
        $names="รายงานผู้ป่วยในที่มาตรวจเลือด HIV (Anti-Hiv 235)";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv9.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv9-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv10Index() {
        $names="รายงานผู้ป่วย(ARV) รับยาต้านไวรัส มารับยาต่อเนื่อง";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv10.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv10-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv11Index() {
        $names="รายงานผู้ป่วย(ARV) รับยาต้านไวรัส มารับยาไม่ต่อเนื่อง(ขาดนัด)";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv11.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv11-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv12Index() {
        $names="รายงานผู้ป่วย HIV รายใหม่ แยกเพศ อายุ";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv12.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv12-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv13Index() {
        $names="รายงานผลการดำเนินงานผสมผสานวัณโรคและโรคเอดส์";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv13.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv13-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv14Index() {
        $names="รายงานผู้ที่มารับบริการฝังยาคุมกำเนิด";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv14.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv14-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv15Index() {
        $names="รายงานหญิงมีครรภ์ที่ Abortion(O04-O08)";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv15.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv15-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
}
     public function actionArv16Index() {
        $names="รายงานการเข้าคลินิก ARV ของผู้ป่วย ARV(B24) รายใหม่";
        $model = new Formmodel();
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv16.mrt&d1='.$date1.'&d2='.$date2);                       
        }
            return $this -> render('/site/arv/arv16-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
     }
     public function actionArv17Index() {
        $names="รายงานผู้ป่วยคลินิก ARV แยกตามสถานะ";
        $model = new Formmodel();
        $sql="select clinic_member_status_id id,clinic_member_status_name cname from clinic_member_status 
                where clinic_member_status_id in ('2','3','4','10','11') order by 1";
        $locations =  \Yii::$app->db1->createCommand($sql)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','cname');          
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $status = Yii::$app->request->post('select1');  
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=arv/";   
               return $this->redirect($url.'arv17.mrt&d1='.$date1.'&st='.$status);                       
        }
            return $this -> render('/site/arv/arv17-index',['mText'=>$this->mText,'names'=>$names,
                                             'model' => $model, 'data'=>$listData]);
     }     
}    