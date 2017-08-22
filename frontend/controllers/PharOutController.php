<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class PharOutController extends Controller
{
    public $mText = "งานเภสัชกรรม(ห้องจ่ายยาผู้ป่วยนอก)";
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
        $names="งานเภสัชกรรม(ห้องจ่ายยาผู้ป่วยนอก)"; 
         return $this -> render('/site/phar-out/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionPharOut1Index() {
        $model = new Formmodel();
        $names="รายงานรายชื่อผู้ป่วยแพ้ยา"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar_out1.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPharOut2Index() {
        $model = new Formmodel();
        $names="รายงานรายชื่อผู้ป่วยใช้ยา Clopidogrel(เฉพาะสิทธิ์ UC)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar_out2.mrt&d1='.$date1.'&d2='.$date2);                
        }
            return $this -> render('/site/phar-out/phar-out2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }       
    public function actionPharOut3Index() {
        $model = new Formmodel();
        $names="รายงาน ASU"; 
        if($model->load(Yii::$app->request->post())){          
               $date1 = $model->date1;
               $date2 = $model->date2;
        $sql1='DROP TABLE if EXISTS opit';
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar_out3.mrt&d1='.$date1.'&d2='.$date2);                
        }
            return $this -> render('/site/phar-out/phar-out3-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }        
    public function actionPharOut4Index() {
        $model = new Formmodel();
        $names="รายงานผู้ป่วยที่ได้รับยา TB"; 
        $sql1 = "select  concat('0',',','สิทธิ์การรักษาทั้งหมด') pttype, 'สิทธิ์การรักษาทั้งหมด' as name union 
                    select concat(pttype_spp_id,',',pttype_spp_name) pttype, pttype_spp_name as name  
                    from pttype_spp order by pttype;";
        $locations =  \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'pttype','name');               
        if($model->load(Yii::$app->request->post())){          
               $date1 = $model->date1;
               $date2 = $model->date2;
               $ptype = Yii::$app->request->post('pttype');
               $type = explode(',', $ptype);
               $code=$type[0];
               if($code==0){
                      $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
                       return $this->redirect($url.'phar_out4-1.mrt&d1='.$date1.'&d2='.$date2);                    
               }else{
                      $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
                       return $this->redirect($url.'phar_out4-2.mrt&d1='.$date1.'&d2='.$date2.'&pttype='.$type[0].'&ptname='.$type[1]);                       
               }
        }
            return $this -> render('/site/phar-out/phar-out4-index',['mText'=>$this->mText,'names'=>$names,
                                             'model' => $model,'data' => $listData]);
    }      
    public function actionPharOut5Index() {
        $model = new Formmodel();
        $names="รายงานผู้ป่วยที่ได้รับยา Warfarin แยกราย รพ.สต."; 
        if($model->load(Yii::$app->request->post())){          
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar_out5.mrt&d1='.$date1.'&d2='.$date2);                
        }
            return $this -> render('/site/phar-out/phar-out3-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPharOut6Index() {
        $model = new Formmodel();
        $names="รายงานยาราคาสูงแจ้งคลังยา(OPD)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'Phar_out6.mrt&d1='.$date1.'&d2='.$date2);                     
        }
            return $this -> render('/site/phar-out/phar-out3-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    
    


    public function actionPharOutKpi1Index() {
        $model = new Formmodel();
        $names="ร้อยละการใช้ยาปฎิชีวนะในโรคติดเชื้อที่ระบบหายใจช่วงบนและหลอดลมอักเสบเฉียบพลันผู้ป่วยนอก"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi1.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPharOutKpi2Index() {
        $model = new Formmodel();
        $names="ร้อยละการใช้ยาปฎิชีวนะในโรคอุจาระร่วงเสบเฉียบพลัน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi2.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPharOutKpi3Index() {
        $model = new Formmodel();
        $names="อัตราการใช้ยาปฎิชีวนะในบาดแผลสดจากอุบัติเหตุ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi3.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPharOutKpi4Index() {
        $model = new Formmodel();
        $names="อัตราการใช้ยาปฎิชีวนะในหญิงคลอดปกติครบกำหนดทางช่องคลอด"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi4.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPharOutKpi5Index() {
        $model = new Formmodel();
        $names="ร้อยละของการใช้ RAS blockade (ACEL/ARB/Renin inhibitor) 2 ชนิดรวมกัน ในการรักษาความดันเลือดสูง"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi5.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionPharOutKpi6Index() {
        $model = new Formmodel();
        $names="ร้อยละของการใช้ glibenclamide ในผู้ป่วยที่มีอายุมากกว่า 65 ปี หรือมี eGFR < 60 มล./นาที/1.73 ตรม."; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi6.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }      
    public function actionPharOutKpi7Index() {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยเบาหวานที่ใช้ยา metformin เป็นยาชนิดเดียวกันหรือร่วมกับยาอื่น เพื่อควบคุมระดับน้ำตาล 
                      โดยไม่มีข้อห้ามใช้"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi7.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }       
    public function actionPharOutKpi8Index() {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยที่มีการใช้ยากลุ่ม NSAIDs ซ้ำซ้อน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi8.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  
    public function actionPharOutKpi9Index() {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยโรคไตเรื้อรังระดับ 3 ขึ้นไปที่ได้รับยา NSAIDs"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi9.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  
    public function actionPharOutKpi10Index() {
        $model = new Formmodel();
        $names="ร้อยละของผู้ป่วยโรคหืดเรื้อรังที่ได้รับยา inhaled corticosteroid"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi10.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  
    public function actionPharOutKpi11Index() {
        $model = new Formmodel();
        $names="ร้อยละผู้ป่วยนอกสูงอายุ(เกิน 65 ปี) ที่ใช้ยากลุ่ม long-acting benzodiazepine"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi11.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }
    public function actionPharOutKpi12Index() {
        $model = new Formmodel();
        $names="จำนวนสตรีตั้งครรภ์ที่ได้รับยาที่ควรหลีกเลี่ยง ได้แก่ Warfarin/Statins/Ergot"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi12.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionPharOutKpi13Index() {
        $model = new Formmodel();
        $names="อัตราการได้รับยาต้านฮีสตามีนชนิด non-sedating* ในเด็กที่ได้รับการวินิจฉัยเป็นโรคติดเชื้อของทางเดินหายใจ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi13.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }      
    public function actionPharOutKpi14Index() {
        $model = new Formmodel();
        $names="ต้นทุนค่ายาผู้ป่วยนอกต่อผู้ป่วย OPD Visit"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi14.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionPharOutKpi15Index() {
        $model = new Formmodel();
        $names="ต้นทุนค่ายาผู้ป่วยในต่อผลรวม Adj.Rw"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi15.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPharOutKpi16Index() {
        $model = new Formmodel();
        $names="รายงานร้อยละการสั่งยาในบัญชียาหลักแห่งชาติ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=phar_out/";   
            return $this->redirect($url.'phar-out-kpi16.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/phar-out/phar-out-kpi-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    
    
    
}    

