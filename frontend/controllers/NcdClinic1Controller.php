<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class NcdClinic1Controller extends Controller
{
    public $mText = "งานคลินิกผู้ป่วยโรคเรื้อรัง(NCD)";
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
    public function actionClinic1Index() {
        $model = new Formmodel();
        $names="รายงานสภาวะผู้ป่วยโรคเรื้อรัง"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               if($model->select1 == '1'){
                      $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ncd/";   
                      return $this->redirect($url.'ncd_dm.mrt&d1='.$date1);                     
               }else{
                      $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ncd/";   
                      return $this->redirect($url.'ncd_ht.mrt&d1='.$date1);                       
               }       
        }
            return $this -> render('/site/ncd/clinic1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);        
    } 
    public function actionClinic2Index(){
        $names="รายงานทะเบียนผู้ป่วยโรคเรื้อรัง";
        $sql1="select c.hn,concat(p.pname,p.fname,' ',p.lname) pnames,c.regdate,c.dchdate,c.discharge,
                  cm.clinic_member_status_name as 'status',p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                  if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  or p.moopart in ('','0','00'))) or
                       (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),
                       'ในเขต','นอกเขต') statusx   
                    from clinicmember c inner join patient p on c.hn=p.hn
                    inner join clinic_member_status cm on c.clinic_member_status_id=cm.clinic_member_status_id
                    inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                    inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                    inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                    where c.clinic='001' and c.clinic_member_status_id in ('3','11');";
       try {
              $rawData1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
                $dataProvider1 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData1,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
                ]);  
        $sql2="select c.hn,concat(p.pname,p.fname,' ',p.lname) pnames,c.regdate,c.dchdate,c.discharge,
                  cm.clinic_member_status_name as 'status',p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                  if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  or p.moopart in ('','0','00'))) or
                       (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),
                       'ในเขต','นอกเขต') statusx   
                    from clinicmember c inner join patient p on c.hn=p.hn 
                    inner join clinic_member_status cm on c.clinic_member_status_id=cm.clinic_member_status_id
                    inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                    inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                    inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                    where c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                    and c.hn in(select patient_hn hn from person where patient_hn is not null);";     
       try {
              $rawData2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
                $dataProvider2 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData2,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
                ]);         
        $sql3="select c.hn,concat(p.pname,p.fname,' ',p.lname) pnames,c.regdate,c.dchdate,c.discharge,
                  cm.clinic_member_status_name as 'status',p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                  if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  or p.moopart in ('','0','00'))) or
                       (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),
                       'ในเขต','นอกเขต') statusx   
                    from clinicmember c inner join patient p on c.hn=p.hn 
                    inner join clinic_member_status cm on c.clinic_member_status_id=cm.clinic_member_status_id
                    inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                    inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                    inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                    where c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                    and p.hn not in(select patient_hn hn from person where patient_hn is not null);";     
       try {
              $rawData3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
                $dataProvider3 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData3,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
                ]);                                                                   
        $sql4="select c.hn,concat(p.pname,p.fname,' ',p.lname) pnames,c.regdate,c.dchdate,c.discharge,
                  cm.clinic_member_status_name as 'status',p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                  if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  or p.moopart in ('','0','00'))) or
                       (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),
                       'ในเขต','นอกเขต') statusx   
                    from clinicmember c inner join patient p on c.hn=p.hn
                    inner join clinic_member_status cm on c.clinic_member_status_id=cm.clinic_member_status_id
                    inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                    inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                    inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                    where c.clinic='002' and c.clinic_member_status_id in ('3','11');";
       try {
              $rawData4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
                $dataProvider4 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData4,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
                ]);  
        $sql5="select c.hn,concat(p.pname,p.fname,' ',p.lname) pnames,c.regdate,c.dchdate,c.discharge,
                  cm.clinic_member_status_name as 'status',p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                  if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  or p.moopart in ('','0','00'))) or
                       (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),
                       'ในเขต','นอกเขต') statusx   
                    from clinicmember c inner join patient p on c.hn=p.hn
                    inner join clinic_member_status cm on c.clinic_member_status_id=cm.clinic_member_status_id
                    inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                    inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                    inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                    where c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                    and c.hn in(select patient_hn hn from person where patient_hn is not null);";     
       try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
                $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
                ]);         
        $sql6="select c.hn,concat(p.pname,p.fname,' ',p.lname) pnames,c.regdate,c.dchdate,c.discharge,
                  cm.clinic_member_status_name as 'status',p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                  if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  or p.moopart in ('','0','00'))) or
                       (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),
                       'ในเขต','นอกเขต') statusx   
                    from clinicmember c inner join patient p on c.hn=p.hn 
                    inner join clinic_member_status cm on c.clinic_member_status_id=cm.clinic_member_status_id
                    inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                    inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                    inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                    where c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                    and p.hn not in(select patient_hn hn from person where patient_hn is not null);";     
       try {
              $rawData6 = \Yii::$app->db1->createCommand($sql6)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
                $dataProvider6 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData6,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
                ]);                 
        return $this->render('/site/ncd/clinic2-index',['names'=>$names,'mText'=>$this->mText,
                                    'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                                    'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5,'dataProvider6'=>$dataProvider6,           
                                   ]);
    }    
    public function actionClinic3Index() {
        $model = new Formmodel();        
        $names="รายงานผู้ป่วยโรคเรื้อรัง ที่ยังไม่เข้าคลินิก";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;           
               $clinic = Yii::$app->request->post('clinic');    
            return $this->redirect(['clinic3_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'c'=>$clinic]);
        }
            return $this -> render('/site/ncd/clinic3-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }
    public function actionClinic3_preview($name,$d1,$d2,$c){
        $names=$name;
        $date1=$d1;$date2=$d2;
        $clinic=  explode(',',$c);$clinic_c=$clinic[0];$clinic_n=$clinic[1];                 
        switch ($clinic_c) {
            case 1:
                $sql1 = "select p.hn,concat(p.pname,p.fname,' ',p.lname) pname,p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                            o.vstdate,o.icd10,(select vstdate from ovstdiag where hn=p.hn and icd10 between 'E10' and 'E19' order by vn asc limit 1) first_date  from ovstdiag o 
                            inner join patient p on o.hn=p.hn inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                            inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00') inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                            where o.vstdate between '{$date1}' and '{$date2}' and o.icd10 between 'E10' and 'E19' and o.hn not in (select  hn from clinicmember where clinic = '001')";
                    $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();                                    
                break;
            case 2:
                $rawData=[];
                $sql1 = "select p.hn,concat(p.pname,p.fname,' ',p.lname) pname,p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                            o.vstdate,o.icd10
                            
                            from ovstdiag o 
                            inner join patient p on o.hn=p.hn inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                            inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00') inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                            where o.vstdate between '{$date1}' and '{$date2}' and o.icd10 between 'I10' and 'I159' and o.hn not in (select  hn from clinicmember where clinic = '002')";
                            // ,(select vstdate from ovstdiag where hn=p.hn and icd10 between 'I10' and 'I159' order by vn asc limit 1) first_date
                      $raw= \Yii::$app->db1->createCommand($sql1)->queryAll();    
                      foreach ($raw as $value) {
                         $sql2="select vstdate from ovstdiag where hn='{$value["hn"]}' and icd10 between 'I10' and 'I159' order by vn asc limit 1";
                         $raw1= \Yii::$app->db1->createCommand($sql2)->queryAll();   
                             foreach ($raw1 as $value1){
                                 $vst=$value1['vstdate'];
                             }
                             $rawData[]=[
                                 'hn'=>$value['hn'],
                                 'pname'=>$value['pname'],
                                 'addrpart'=>$value['addrpart'],
                                 'moopart'=>$value['moopart'],
                                 'tmb'=>$value['tmb'],
                                 'amp'=>$value['amp'],
                                 'chw'=>$value['chw'],
                                 'vstdate'=>$value['vstdate'],
                                 'icd10'=>$value['icd10'],
                                 'first_date'=>$vst
                             ];
                      }
                break;
            case 3:
                $sql1 = "select p.hn,concat(p.pname,p.fname,' ',p.lname) pname,p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                            o.vstdate,o.icd10,(select vstdate from ovstdiag where hn=p.hn and icd10 between 'I60' and 'I69' order by vn asc limit 1) first_date  from ovstdiag o 
                            inner join patient p on o.hn=p.hn inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                            inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00') inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                            where o.vstdate between '{$date1}' and '{$date2}' and o.icd10 between 'I60' and 'I69' and o.hn not in (select  hn from clinicmember where clinic = '004')";
                        $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();        
            break;
            case 4:
                $sql1 = "select p.hn,concat(p.pname,p.fname,' ',p.lname) pname,p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                            o.vstdate,o.icd10,(select vstdate from ovstdiag where hn=p.hn and icd10 between 'I20' and 'I259' order by vn asc limit 1) first_date  from ovstdiag o 
                            inner join patient p on o.hn=p.hn inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                            inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00') inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                            where o.vstdate between '{$date1}' and '{$date2}' and o.icd10 between 'I20' and 'I259' and o.hn not in (select  hn from clinicmember where clinic = '003')";
                        $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();        
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
        return $this -> render('/site/ncd/clinic3-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2, 'clinic_n'=>$clinic_n]);   
    }
    public function actionClinic4Index() {
        $model = new Formmodel();       
        $names="รายงานการประเมินโอกาสเสี่ยงต่อโรค(CVD)ของผู้ป่วยโรคเรื้อรัง(ทราบผลคลอเรตเตอรอล)";
        if($model->load(Yii::$app->request->post())){
            $date1 = $model->date1; 
            $date2 = $model->date2;             
            $type = Yii::$app->request->post('type');    
            return $this->redirect(['clinic4_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'t'=>$type]);
        }
            return $this -> render('/site/ncd/clinic4-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    } 
    public function actionClinic4_preview($name,$d1,$d2,$t) {
        $names = $name;   
        $date1=$d1;$date2=$d2;
        $type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];
         switch ($type_c) {
            case 1:
                $sql1 = "select o.vn,o.hn,o.vstdate,concat(p.pname,p.fname,' ',p.lname) as pname,if(v.sex='1','ช','ญ') as sex,v.age_y,l1.lab_order_result as cholesterol,
                                       if(o.smoking_type_id in ('2','5','6'),'สูบ','ไม่สูบ') as smoking,round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) as bpsx,round(if(o1.bpd is null,o.bpd,
                                       (o.bpd+o1.bpd)/2)) as bpdx,if(v.sex='1',if(v.age_y <=49,if(o.smoking_type_id in('1','3','4','7'),if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=320,'ต่ำ',''),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result <=319,'ต่ำ','สูง'),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between '240' and '279','ปานกลาง',if(l1.lab_order_result between '280' and '319','สูง',if(l1.lab_order_result >=320,'สูงอันตราย','')))),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >'180',if(l1.lab_order_result <=199,'สูง',if(l1.lab_order_result between '200' and '239','สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),'')) )),
                                       if(o.smoking_type_id in('2','5','6'),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'สูง','')),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between '280' and '319','ปานกลาง',if(l1.lab_order_result>=320,'สูงอันตราย',''))),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between '240' and '279','สูง',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),
                                       if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                       if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),'')))),
                                        if(o.smoking_type_id in ('2','5','6'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),
                                        if(v.age_y between '60' and '69',if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result>=280,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),'')))),
                                        if(o.smoking_type_id in ('2','5','6'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),
                                        if(v.age_y >=70,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=239,'สูง',if(l1.lab_order_result between 240 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),
                                        if(o.smoking_type_id in('2','5','6'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result <=239,'ปานกลาง',if(l1.lab_order_result between 240 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),'')))),
                                        if(v.age_y<=49,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=280,'ต่ำ',if(l1.lab_order_result>=281,'สูง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=200,'ต่ำ',if(l1.lab_order_result between '201' and '240','ปานกลาง',if(l1.lab_order_result>=241,'สูง','สิ้นสุด ญ 40/140 ไม่สูบ'))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=160,'ต่ำ',if(l1.lab_order_result between '161' and '200','ปานกลาง',if(l1.lab_order_result between '201' and '240','สูงมาก',if(l1.lab_order_result>=241,'สูงอันตราย','สิ้นสุด ญ40/160ไม่สูบ')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=160,'สูงมาก',if(l1.lab_order_result>=161,'สูงอันตราย','สิ้นสุด ญ 40/180ไม่สูบ')),'สิ้นสุด ญ 40/180ไม่สูบ')))),
                                        if(o.smoking_type_id in ('2','5','6'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=240,'ต่ำ',if(l1.lab_order_result between '241' and '280','ปานกลาง',if(l1.lab_order_result>=281,'สูง','สิ้นสุด ญ 40/120สูบ'))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=160,'ต่ำ',if(l1.lab_order_result between '161' and '240','ปานกลาง',if(l1.lab_order_result between '241' and '280','สูงมาก',if(l1.lab_order_result>=281,'สูงอันตราย','สิ้นสุด ญ 40/140สูบ')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=160,'ต่ำ',if(l1.lab_order_result between '161' and '200','สูงมาก',if(l1.lab_order_result>=201,'สูงอันตราย','สิ้นสุด ญ40/160 สูบ'))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),
                                        if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=199,'สูงมาก','สูงอันตราย'),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',
                                             if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย',''))))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),''))))),
                                        if(v.age_y between 60 and 69,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 278,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=199,'สูงมาก','สูงอันตราย'),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result>=280,'สูงมาก','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=199,'สูงอันตราย',''),''))))),
                                        if(v.age_y>=70,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 279,'ปานกลาง',if(l1.lab_order_result >=280,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=199,'สูงอันตราย',''),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูงมาก','สูงอันตราย'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),''))))),''))))) as stage,
                                        p.addrpart,p.moopart,t1.name tmb,t2.name amp,t3.name chw
                                        from opdscreen o
                                        left outer join patient p on o.hn=p.hn 
                                        left outer join clinicmember c on o.hn=c.hn 
                                        left outer join opdscreen_bp o1 on o.vn=o1.vn 
                                        left outer join lab_head l on l.vn=o.vn 
                                        left outer join lab_order l1 on l.lab_order_number=l1.lab_order_number
                                        left outer join vn_stat v on o.vn=v.vn
                                        inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                                        inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                                        inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')                                        
                                        where o.vstdate between '{$date1}' and '{$date2}' and (l.report_date !='' or l.report_date is not null) and
                                        c.clinic = '001' and c.hn not in (select hn from clinicmember where clinic ='002')   and l1.lab_items_code='102' 
                                         and c.discharge !='Y' group by o.vn order by v.sex,v.age_y;";
                $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                break;
            case 2:
                $sql1 = "select o.vn,o.hn,o.vstdate,concat(p.pname,p.fname,' ',p.lname) as pname,if(v.sex='1','ช','ญ') as sex,v.age_y,l1.lab_order_result as cholesterol,if(o.smoking_type_id in ('2','5','6'),'สูบ','ไม่สูบ') as smoking,
                                        round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) as bpsx,round(if(o1.bpd is null,o.bpd,(o.bpd+o1.bpd)/2)) as bpdx,
                                        if(v.sex='1',if(v.age_y<=49,if(o.smoking_type_id in('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=320,'ต่ำ',''),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result >= 320 ,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result>=280,'สูงอันตราย',''))),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ','ปานกลาง'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=319,'ต่ำ','สูง'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง','สูงอันตราย'))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),''))))),
                                        if(v.age_y between 50 and 59,if(o.smoking_type_id in('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=320,'ต่ำ',''),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 279,'สูง',if(l1.lab_order_result>=280,'สูงอันตราย',''))),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),'สิ้นสุด50สูบ'))))),
                                        if(v.age_y between '60' and '69',if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=320,'ต่ำ',''),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result >=280,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),''))))),
                                        if(v.age_y>=70,if(o.smoking_type_id in('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result >=240,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result <=279,'ปานกลาง',if(l1.lab_order_result >=280,'สูง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result>=240,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=279,'ปานกลาง',if(l1.lab_order_result>=280,'สูง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),''))))),'')))),
                                        if(v.age_y<=49,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 239,'สูง',if(l1.lab_order_result>=240,'ศูงอันตราย',''))),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',
                                           if(l1.lab_order_result>=320,'สูงอันตราย',''))))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),''))))),
                                        if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),''))))),
                                        if(v.age_y between 60 and 69,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'ศูงอันตราย',''))),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),''))))),
                                        if(v.age_y>=70,if(o.smoking_type_id in('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,if(l1.lab_order_result<=279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),''))))),''))))) as stage,
                                        p.addrpart,p.moopart,t1.name tmb,t2.name amp,t3.name chw                                        
                                        from opdscreen o
                                        left outer join patient p on o.hn=p.hn 
                                        left outer join clinicmember c on o.hn=c.hn 
                                        left outer join opdscreen_bp o1 on o.vn=o1.vn 
                                        left outer join lab_head l on l.vn=o.vn 
                                        left outer join lab_order l1 on l.lab_order_number=l1.lab_order_number
                                        left outer join vn_stat v on o.vn=v.vn
                                        inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                                        inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                                        inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')                                           
                                        where o.vstdate between '{$date1}' and '{$date2}' and (l.report_date !='' or l.report_date is not null) and 
                                        c.clinic = '002' and c.hn not in (select hn from clinicmember where clinic ='001')  and l1.lab_items_code='102' 
                                         and c.discharge !='Y' group by o.vn order by v.sex,v.age_y;";
                $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                break;
            case 3:
                $sql1 = "select o.vn,o.hn,o.vstdate,concat(p.pname,p.fname,' ',p.lname) as pname,if(v.sex='1','ช','ญ') as sex,v.age_y,l1.lab_order_result as cholesterol,if(o.smoking_type_id in ('2','5','6'),'สูบ','ไม่สูบ') as smoking,
                                        round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) as bpsx,round(if(o1.bpd is null,o.bpd,(o.bpd+o1.bpd)/2)) as bpdx,
                                        if(v.sex='1',if(v.age_y <=49,if(o.smoking_type_id in('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=320,'ต่ำ',''),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result <=319,'ต่ำ','สูง'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between '240' and '279','ปานกลาง',if(l1.lab_order_result between '280' and '319','สูง',if(l1.lab_order_result >=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >'180',if(l1.lab_order_result <=199,'สูง',if(l1.lab_order_result between '200' and '239','สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),'')) )),
                                        if(o.smoking_type_id in('2','5','6'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'สูง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between '280' and '319','ปานกลาง',if(l1.lab_order_result>=320,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between '240' and '279','สูง',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))>180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),
                                        if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=319,'ต่ำ',if(l1.lab_order_result>=320,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),'')))),
                                        if(o.smoking_type_id in ('2','5','6'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),
                                        if(v.age_y between '60' and '69',if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result>=280,'ปานกลาง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),'')))),
                                        if(o.smoking_type_id in ('2','5','6'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),
                                        if(v.age_y >=70,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=239,'สูง',if(l1.lab_order_result between 240 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),
                                        if(o.smoking_type_id in('2','5','6'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result <=239,'ปานกลาง',if(l1.lab_order_result between 240 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),'')))),
                                        if(v.age_y<=49,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=280,'ต่ำ',if(l1.lab_order_result>=281,'สูง','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=200,'ต่ำ',if(l1.lab_order_result between '201' and '240','ปานกลาง',if(l1.lab_order_result>=241,'สูง','สิ้นสุด ญ 40/140 ไม่สูบ'))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=160,'ต่ำ',if(l1.lab_order_result between '161' and '200','ปานกลาง',if(l1.lab_order_result between '201' and '240','สูงมาก',if(l1.lab_order_result>=241,'สูงอันตราย','สิ้นสุด ญ40/160ไม่สูบ')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=160,'สูงมาก',if(l1.lab_order_result>=161,'สูงอันตราย','สิ้นสุด ญ 40/180ไม่สูบ')),'สิ้นสุด ญ 40/180ไม่สูบ')))),
                                        if(o.smoking_type_id in ('2','5','6'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=240,'ต่ำ',if(l1.lab_order_result between '241' and '280','ปานกลาง',if(l1.lab_order_result>=281,'สูง','สิ้นสุด ญ 40/120สูบ'))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=160,'ต่ำ',if(l1.lab_order_result between '161' and '240','ปานกลาง',if(l1.lab_order_result between '241' and '280','สูงมาก',if(l1.lab_order_result>=281,'สูงอันตราย','สิ้นสุด ญ 40/140สูบ')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=160,'ต่ำ',if(l1.lab_order_result between '161' and '200','สูงมาก',if(l1.lab_order_result>=201,'สูงอันตราย','สิ้นสุด ญ40/160 สูบ'))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),'')))),'')),
                                        if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 279,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=199,'สูงมาก','สูงอันตราย'),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=239,'ต่ำ',if(l1.lab_order_result between 240 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',
                                             if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย',''))))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 239,'สูงมาก',if(l1.lab_order_result>=240,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),''))))),
                                        if(v.age_y between 60 and 69,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=279,'ต่ำ',if(l1.lab_order_result between 280 and 319,'ปานกลาง',if(l1.lab_order_result>=320,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 278,'ปานกลาง',if(l1.lab_order_result between 280 and 319,'สูง',if(l1.lab_order_result>=320,'สูงมาก','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result<=199,'สูงมาก','สูงอันตราย'),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result>=280,'สูงมาก','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 239,'สูง',if(l1.lab_order_result between 240 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูงมาก',if(l1.lab_order_result>=200,'สูงอันตราย','')),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=199,'สูงอันตราย',''),''))))),
                                        if(v.age_y>=70,if(o.smoking_type_id in ('1','3','4','7'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=199,'ต่ำ',if(l1.lab_order_result between 200 and 279,'ปานกลาง',if(l1.lab_order_result >=280,'สูง',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'ปานกลาง',if(l1.lab_order_result between 200 and 279,'สูง',if(l1.lab_order_result between 280 and 319,'สูงมาก',if(l1.lab_order_result>=320,'สูงอันตราย','')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=199,'สูงอันตราย',''),'')))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,if(l1.lab_order_result<=239,'ปานกลาง',if(l1.lab_order_result between 240 and 279,'สูง',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '140' and '159',if(l1.lab_order_result<=199,'สูง',if(l1.lab_order_result between 200 and 279,'สูงมาก',if(l1.lab_order_result>=280,'สูงอันตราย',''))),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between '160' and '179',if(l1.lab_order_result<=199,'สูงมาก','สูงอันตราย'),
                                        if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,if(l1.lab_order_result>=160,'สูงอันตราย',''),''))))),''))))) as stage,
                                        p.addrpart,p.moopart,t1.name tmb,t2.name amp,t3.name chw                                             
                                        from opdscreen o
                                        left outer join patient p on o.hn=p.hn 
                                        left outer join clinicmember c on o.hn=c.hn 
                                        left outer join opdscreen_bp o1 on o.vn=o1.vn 
                                        left outer join lab_head l on l.vn=o.vn 
                                        left outer join lab_order l1 on l.lab_order_number=l1.lab_order_number
                                        left outer join vn_stat v on o.vn=v.vn
                                        inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                                        inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                                        inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')                                           
                                        where o.vstdate between '{$date1}' and '{$date2}' and (l.report_date !='' or l.report_date is not null) and 
                                        c.clinic = '001' and c.hn  in (select hn from clinicmember where clinic ='002')   and l1.lab_items_code='102' 
                                        and c.discharge !='Y' group by o.vn order by v.sex,v.age_y;";
                $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
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
        return $this -> render('/site/ncd/clinic4-preview', ['dataProvider' => $dataProvider, 'names' => $names,
                                     'mText' => $this->mText, 'date1'=>$date1, 'date2'=>$date2, 'type_n'=>$type_n]);             
    }    
    public function actionClinic5Index() {
        $model = new Formmodel();       
        $names = "รายงานการประเมินโอกาสเสี่ยงต่อโรค(CVD) ของผู้ป่วยโรคเรื้อรัง(ไม่ทราบผลคลอเรตเตอรอล)";   
        if($model->load(Yii::$app->request->post())){
            $date1 = $model->date1; 
            $date2 = $model->date2;             
            $type = Yii::$app->request->post('type');    
            return $this->redirect(['clinic5_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'t'=>$type]);
        }
            return $this -> render('/site/ncd/clinic5-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    } 
    public function actionClinic5_preview($name,$d1,$d2,$t) {
        $names = $name;   
        $date1=$d1;$date2=$d2;
        $type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];
       switch ($type_c) {
            case 1:
                $sql1 = "select o.vn,o.hn,o.vstdate,concat(p.pname,p.fname,' ',p.lname) as pname,if(v.sex='1','ช','ญ') as sex,v.age_y,
                                            if(o.smoking_type_id in ('2','5','6'),'สูบ','ไม่สูบ') as smoking,round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) as bpsx,
                                            round(if(o1.bpd is null,o.bpd,(o.bpd+o1.bpd)/2)) as bpdx,if(v.sex='1',if(v.age_y<=49,if(o.smoking_type_id in ('1','3','4','7'),
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูง','')))),
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y between 60 and 69,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูงมาก',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y >=70,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูงอันตราย',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),'')))),
                                            if(v.age_y<=49,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงมาก','')))),
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงมาก',''))))),
                                            if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y between 60 and 69,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูงอันตราย',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y>=70,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูงอันตราย',
	  		 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),''))))) as stage,
                                            p.addrpart,p.moopart,t1.name tmb,t2.name amp,t3.name chw 
                                            from opdscreen o left outer join patient p on o.hn=p.hn left outer join clinicmember c on o.hn=c.hn 
                                            left outer join opdscreen_bp o1 on o.vn=o1.vn left outer join vn_stat v on o.vn=v.vn left outer join lab_head l on o.vn=l.vn
                                            left outer join lab_order l1 on l.lab_order_number=l1.lab_order_number    
                                            inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                                            inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                                            inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')                                       
                                            where o.vstdate between '{$date1}' and '{$date2}' and c.clinic = '001' and c.discharge !='Y'
                                            and c.hn not in (select hn from clinicmember where clinic ='002')  
                                            and (l1.lab_items_code !=102 or l1.lab_items_code is null or l1.lab_items_code ='') 
                                            group by o.vn order by v.sex,v.age_y";
                $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                break;
            case 2:
                $sql1 = "select o.vn,o.hn,o.vstdate,concat(p.pname,p.fname,' ',p.lname) as pname,if(v.sex='1','ช','ญ') as sex,v.age_y,
                                            if(o.smoking_type_id in ('2','5','6'),'สูบ','ไม่สูบ') as smoking,round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) as bpsx,
                                            round(if(o1.bpd is null,o.bpd,(o.bpd+o1.bpd)/2)) as bpdx,if(v.sex='1',if(v.age_y<=49,if(o.smoking_type_id in ('1','3','4','7'),
                                           	 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'ปานกลาง','')))),
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงมาก',''))))),
                                            if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูง','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y between 60 and 69,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูง','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y >=70,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูง','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),'')))),
                                            if(v.age_y<=49,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'ปานกลาง','')))),
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูง',''))))),
                                            if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูง','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y between 60 and 69,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูง','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y>=70,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูง','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
	  		 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),''))))) as stage,
                                            p.addrpart,p.moopart,t1.name tmb,t2.name amp,t3.name chw                          
                                            from opdscreen o left outer join patient p on o.hn=p.hn left outer join clinicmember c on o.hn=c.hn 
                                            left outer join opdscreen_bp o1 on o.vn=o1.vn left outer join vn_stat v on o.vn=v.vn left outer join lab_head l on o.vn=l.vn  
                                            left outer join lab_order l1 on l.lab_order_number=l1.lab_order_number  
                                            inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                                            inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                                            inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')                                               
                                            where o.vstdate between '{$date1}' and '{$date2}' and c.clinic = '002'  and c.discharge !='Y'
                                            and c.hn not in (select hn from clinicmember where clinic ='001') 
                                            and (l1.lab_items_code !=102 or l1.lab_items_code is null or l1.lab_items_code ='')
                                            group by o.vn order by v.sex,v.age_y";
                $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                break;
            case 3:
                $sql1 = "select o.vn,o.hn,o.vstdate,concat(p.pname,p.fname,' ',p.lname) as pname,if(v.sex='1','ช','ญ') as sex,v.age_y,
                                            if(o.smoking_type_id in ('2','5','6'),'สูบ','ไม่สูบ') as smoking,round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) as bpsx,
                                            round(if(o1.bpd is null,o.bpd,(o.bpd+o1.bpd)/2)) as bpdx,if(v.sex='1',if(v.age_y<=49,if(o.smoking_type_id in ('1','3','4','7'),
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูง','')))),
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y between 60 and 69,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูงมาก',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y >=70,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูงอันตราย',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),'')))),
                                            if(v.age_y<=49,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงมาก','')))),
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) <=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงมาก',''))))),
                                            if(v.age_y between 50 and 59,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ต่ำ',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y between 60 and 69,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูงอันตราย',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),
                                            if(v.age_y>=70,if(o.smoking_type_id in ('1','3','4','7'),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ต่ำ',
                                            if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย','')))),
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2))<=139,'ปานกลาง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 140 and 159,'สูง',
			 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) between 160 and 179,'สูงอันตราย',
	  		 if(round(if(o1.bps is null,o.bps,(o.bps+o1.bps)/2)) >=180,'สูงอันตราย',''))))),''))))) as stage,
                                            p.addrpart,p.moopart,t1.name tmb,t2.name amp,t3.name chw                              
                                            from opdscreen o left outer join patient p on o.hn=p.hn left outer join clinicmember c on o.hn=c.hn
                                            left outer join opdscreen_bp o1 on o.vn=o1.vn left outer join vn_stat v on o.vn=v.vn left outer join lab_head l on o.vn=l.vn
                                            left outer join lab_order l1 on l.lab_order_number=l1.lab_order_number        
                                            inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                                            inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                                            inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')                                                
                                            where o.vstdate between '{$date1}' and '{$date2}' and c.clinic = '001'  and c.discharge !='Y'
                                            and c.hn  in (select hn from clinicmember where clinic ='002')  
                                            and (l1.lab_items_code !=102 or l1.lab_items_code is null or l1.lab_items_code ='')
                                            group by o.vn order by v.sex,v.age_y";
                $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                break;
            default :
                break;
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);          
        return $this -> render('/site/ncd/clinic5-preview', ['dataProvider' => $dataProvider, 'names' => $names,
                                     'mText' => $this->mText, 'date1'=>$date1, 'date2'=>$date2, 'type_n'=>$type_n]);            
    }  
    public function actionClinic6Index() {
        $model = new Formmodel();       
        $names=" รายงานผลการดำเนินงานผู้ป่วยโรคเรื้อรัง(อิงบัญชี 1)";
        if($model->load(Yii::$app->request->post())){
            $date1 = $model->date1; 
            $date2 = $model->date2;             
            $clinic = Yii::$app->request->post('clinic');    
            return $this->redirect(['clinic6_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'c'=>$clinic]);
        }
            return $this -> render('/site/ncd/clinic6-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    } 
    public function actionClinic6_preview($name,$d1,$d2,$c) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $clinic=  explode(',',$c);$clinic_c=$clinic[0];$clinic_n=$clinic[1];
        $rawData=array();        
        switch ($clinic_c) {
            case 1:
                $sql1 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3');";
                $sql2 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  not in ('1','3');;";
                $numi1 = \Yii::$app->db1->createCommand($sql1)->queryScalar();
                $numo1 = \Yii::$app->db1->createCommand($sql2)->queryScalar();
                $total1 = $numi1 + $numo1;
                $rawData[] = array(
                    'id' => 1,
                    'pname' => '1.&nbsp;&nbsp;จำนวนผู้ป่วยเบาหวานทั้งหมด',
                    'numi' => @number_format($numi1),
                    'numo' => @number_format($numo1),
                    'total' => @number_format($total1)
                );
               $sql3="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002');"; 
               $sql4="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002');";    
                $numi2 = \Yii::$app->db1->createCommand($sql3)->queryScalar();
                $numo2 = \Yii::$app->db1->createCommand($sql4)->queryScalar();
                $total2 = $numi2 + $numo2;                            
                          $rawData[]=array(                              
                             'id'=>2,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;1.1&nbsp;&nbsp;จำนวนผู้ป่วยบาหวานอย่างเดียว รายใหม่',
                             'numi'=>@number_format($numi2),
                             'numo'=>@number_format($numo2),
                             'total'=>@number_format($total2) 
                          ); 
               $sql5="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='1';"; 
               $sql6="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='1';";
                          $numi3=\Yii::$app->db1->createCommand($sql5)->queryScalar();    
                          $numo3=\Yii::$app->db1->createCommand($sql6)->queryScalar();   
                          $total3=$numi3+$numo3;                           
                          $rawData[]=array(
                             'id'=>3,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1.1&nbsp;&nbsp;Type I',
                             'numi'=>@number_format($numi3),
                             'numo'=>@number_format($numo3),
                             'total'=>@number_format($total3) 
                          );  
               $sql7="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='2';"; 
               $sql8="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='2';";
                          $numi4=\Yii::$app->db1->createCommand($sql7)->queryScalar();    
                          $numo4=\Yii::$app->db1->createCommand($sql8)->queryScalar();   
                          $total4=$numi4+$numo4;                             
                          $rawData[]=array(
                             'id'=>4,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1.2&nbsp;&nbsp;Type II',
                             'numi'=>@number_format($numi4),
                             'numo'=>@number_format($numo4),
                             'total'=>@number_format($total4) 
                          );  
               $sql11="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and 
                          (c.clinic_subtype_id='3' or with_pregnancy='Y');"; 
               $sql12="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and
                          (c.clinic_subtype_id='3' or with_pregnancy='Y');";
                          $numi6=\Yii::$app->db1->createCommand($sql11)->queryScalar();    
                          $numo6=\Yii::$app->db1->createCommand($sql12)->queryScalar();   
                          $total6=$numi6+$numo6;                           
                          $rawData[]=array(
                             'id'=>6,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1.3 &nbsp;&nbsp;GDM',
                             'numi'=>@number_format($numi6),
                             'numo'=>@number_format($numo6),
                             'total'=>$total6 
                          );  
               $sql15="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') 
                          and c.clinic_subtype_id='4';"; 
               $sql16="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='4';";
                          $numi8=\Yii::$app->db1->createCommand($sql15)->queryScalar();    
                          $numo8=\Yii::$app->db1->createCommand($sql16)->queryScalar();   
                          $total8=$numi8+$numo8;                           
                          $rawData[]=array(
                             'id'=>8,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1.4&nbsp;&nbsp; อื่น ๆ',
                             'numi'=>@number_format($numi8),
                             'numo'=>@number_format($numo8),
                             'total'=>@number_format($total8) 
                          );  
               $sql17="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002');"; 
               $sql18="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002');";  
                          $numi9=\Yii::$app->db1->createCommand($sql17)->queryScalar();    
                          $numo9=\Yii::$app->db1->createCommand($sql18)->queryScalar();   
                          $total9=$numi9+$numo9;                          
                          $rawData[]=array(
                             'id'=>9,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;1.2&nbsp;&nbsp;จำนวนผู้ป่วยบาหวานอย่างเดียว รายเก่า',
                             'numi'=>@number_format($numi9),
                             'numo'=>@number_format($numo9),
                             'total'=>@number_format($total9) 
                          ); 
               $sql19="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='1';"; 
               $sql20="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='1';";
                          $numi10=\Yii::$app->db1->createCommand($sql19)->queryScalar();    
                          $numo10=\Yii::$app->db1->createCommand($sql20)->queryScalar();   
                          $total10=$numi10+$numo10;                              
                          $rawData[]=array(
                             'id'=>10,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.2.1&nbsp;&nbsp;Type I',
                             'numi'=>@number_format($numi10),
                             'numo'=>@number_format($numo10),
                             'total'=>@number_format($total10) 
                          );  
               $sql21="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='2';"; 
               $sql22="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='2';";
                          $numi11=\Yii::$app->db1->createCommand($sql21)->queryScalar();    
                          $numo11=\Yii::$app->db1->createCommand($sql22)->queryScalar();   
                          $total11=$numi11+$numo11;                            
                          $rawData[]=array(
                             'id'=>11,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.2.2&nbsp;&nbsp;Type II',
                             'numi'=>@number_format($numi11),
                             'numo'=>@number_format($numo11),
                             'total'=>@number_format($total11) 
                          );  
               $sql25="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002')
                            and (c.clinic_subtype_id='3' or with_pregnancy='Y');"; 
               $sql26="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002')
                            and (c.clinic_subtype_id='3' or with_pregnancy='Y');";
                          $numi13=\Yii::$app->db1->createCommand($sql25)->queryScalar();    
                          $numo13=\Yii::$app->db1->createCommand($sql26)->queryScalar();   
                          $total13=$numi13+$numo13;                            
                          $rawData[]=array(
                             'id'=>13,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.2.3&nbsp;&nbsp;   GDM',
                             'numi'=>@number_format($numi13),
                             'numo'=>@number_format($numo13),
                             'total'=>@number_format($total13) 
                          );  
               $sql29="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='4';"; 
               $sql30="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='002') and c.clinic_subtype_id='4';";
                          $numi15=\Yii::$app->db1->createCommand($sql29)->queryScalar();    
                          $numo15=\Yii::$app->db1->createCommand($sql30)->queryScalar();   
                          $total15=$numi15+$numo15;                             
                          $rawData[]=array(
                             'id'=>15,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.2.4&nbsp;&nbsp;อื่น ๆ',
                             'numi'=>@number_format($numi15),
                             'numo'=>@number_format($numo15),
                             'total'=>@number_format($total15) 
                          );    
            $sql31="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between '{$date1}' and '{$date2}'
                                     and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id  in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";
            $sql32="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between '{$date1}' and '{$date2}'
                                     and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";        
                          $numi16=\Yii::$app->db1->createCommand($sql31)->queryScalar();    
                          $numo16=\Yii::$app->db1->createCommand($sql32)->queryScalar();   
                          $total16=$numi16+$numo16;                                           
                          $rawData[]=array(
                             'id'=>16,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;1.3&nbsp;&nbsp; จำนวนผู้ป่วยที่เป็นเบาหวาน รายใหม่ และเป็นผู้ป่วยความดันร่วม',
                             'numi'=>@number_format($numi16),
                             'numo'=>@number_format($numo16),
                             'total'=>@number_format($total16) 
                          );  
            $sql33="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                                     and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id  in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";
            $sql34="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                                     and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";         
                          $numi17=\Yii::$app->db1->createCommand($sql33)->queryScalar();    
                          $numo17=\Yii::$app->db1->createCommand($sql34)->queryScalar();   
                          $total17=$numi17+$numo17;                            
                          $rawData[]=array(
                             'id'=>17,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;1.4&nbsp;&nbsp; จำนวนผู้ป่วยที่เป็นเบาหวาน รายเก่า และเป็นผู้ป่วยความดันร่วม',
                             'numi'=>@number_format($numi17),
                             'numo'=>@number_format($numo17),
                             'total'=>@number_format($total17) 
                          );  
                $sql35 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3');";
                $sql36 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  not in ('1','3');;";       
                          $numi18=\Yii::$app->db1->createCommand($sql35)->queryScalar();    
                          $numo18=\Yii::$app->db1->createCommand($sql36)->queryScalar();   
                          $total18=$numi18+$numo18;                            
                          $rawData[]=array(
                             'id'=>18,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;1.5&nbsp;&nbsp; จำนวนผู้ป่วยที่เป็นเบาหวาน ที่ยังรักษาอยู่',
                             'numi'=>@number_format($numi18),
                             'numo'=>@number_format($numo18),
                             'total'=>@number_format($total18) 
                          );  
            $sql37="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                                     and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id  in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";
            $sql38="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                                     and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";    
                          $numi19=\Yii::$app->db1->createCommand($sql37)->queryScalar();    
                          $numo19=\Yii::$app->db1->createCommand($sql38)->queryScalar();   
                          $total19=$numi19+$numo19;                            
                          $rawData[]=array(
                             'id'=>19,
                             'pname'=>'2.&nbsp;&nbsp;จำนวนผู้ป่วยที่เป็นความดันและเบาหวาน(เป็นทั้ง 2 โรค)',
                             'numi'=>@number_format($numi19),
                             'numo'=>@number_format($numo19),
                             'total'=>@number_format($total19) 
                          );  
               $sql41="select lo.lab_items_code,lo.lab_order_result from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id  in ('1','3')  and lo.lab_items_code='76' 
                           and lo.lab_order_result>0 group by l.hn;";
               $sql42="select lo.lab_items_code,lo.lab_order_result from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id not in ('1','3')  and lo.lab_items_code='76' 
                           and lo.lab_order_result>0 group by l.hn;";       
                          $numi21=\Yii::$app->db1->createCommand($sql41)->query()->rowCount;    
                          $numo21=\Yii::$app->db1->createCommand($sql42)->query()->rowCount;   
                          $total21=$numi21+$numo21;                              
                          $rawData[]=array(
                             'id'=>21,
                             'pname'=>'3.&nbsp;&nbsp;จำนวนผู้ป่วยเบาหวานที่ได้รับการเจาะ Fasting Blood Sugar ทั้งหมด(คน)',
                             'numi'=>@number_format($numi21),
                             'numo'=>@number_format($numo21),
                             'total'=>@number_format($total21) 
                          );    
               $sql43="select  count(*) cc
                           from (select c.clinic,c.hn from clinicmember c  where  c.clinic='001' and c.clinic_member_status_id in ('3','11')  ) as c
                            inner join person p on p.patient_hn=c.hn          
                            inner join (select  hn,max(vn) vn from lab_head where receive_date between  '{$date1}'  and '{$date2}' group by hn)
                            as l on c.hn=l.hn
                            inner join (select l.vn,lo.lab_order_result from lab_head l
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                            where lo.lab_items_code='76' and lo.lab_order_result between 70 and 130 ) 
                            as l1 on l1.vn=l.vn
                            where p.person_discharge_id='9' and p.house_regist_type_id  in ('1','3')  order by c.hn;";
               $sql44="select  count(*) cc
                           from (select c.clinic,c.hn from clinicmember c  where  c.clinic='001' and c.clinic_member_status_id in ('3','11')  ) as c
                            inner join person p on p.patient_hn=c.hn          
                            inner join (select  hn,max(vn) vn from lab_head where receive_date between  '{$date1}'  and '{$date2}' group by hn)
                            as l on c.hn=l.hn
                            inner join (select l.vn,lo.lab_order_result from lab_head l
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                            where lo.lab_items_code='76' and lo.lab_order_result between 70 and 130 ) 
                            as l1 on l1.vn=l.vn
                            where p.person_discharge_id='9' and p.house_regist_type_id not in ('1','3')  order by c.hn;";       
                          $numi22=\Yii::$app->db1->createCommand($sql43)->queryScalar();    
                          $numo22=\Yii::$app->db1->createCommand($sql44)->queryScalar();     
                          $total22=$numi22+$numo22;                           
                          $rawData[]=array(
                             'id'=>22,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;3.1&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานที่ได้รับการเจาะ Fasting Blood Sugar อยู่ในเกณฑ์ที่ควบคุมได้ (70-130 mg/dl)(ครั้งล่าสุด คน)',
                             'numi'=>@number_format($numi22),
                             'numo'=>@number_format($numo22),
                             'total'=>@number_format($total22) 
                          );  
               $sql45="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id  in ('1','3')  and lo.lab_items_code='76' 
                           and lo.lab_order_result>0 ;";
               $sql46="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id not in ('1','3')  and lo.lab_items_code='76' 
                           and lo.lab_order_result>0;";       
                          $numi23=\Yii::$app->db1->createCommand($sql45)->queryScalar();    
                          $numo23=\Yii::$app->db1->createCommand($sql46)->queryScalar();   
                          $total23=$numi23+$numo23;                            
                          $rawData[]=array(
                             'id'=>23,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;3.2&nbsp;&nbsp; จำนวนครั้งของผู้ป่วยเบาหวานที่ได้รับการเจาะ Fasting Blood Sugar',
                             'numi'=>@number_format($numi23),
                             'numo'=>@number_format($numo23),
                             'total'=>@number_format($total23) 
                          );  
               $sql47="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id  in ('1','3')  and lo.lab_items_code='76' 
                           and lo.lab_order_result between 70 and 130;";
               $sql48="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id not in ('1','3')  and lo.lab_items_code='76' 
                           and lo.lab_order_result between 70 and 130;";       
                          $numi24=\Yii::$app->db1->createCommand($sql47)->queryScalar();    
                          $numo24=\Yii::$app->db1->createCommand($sql48)->queryScalar();   
                          $total24=$numi24+$numo24;                               
                          $rawData[]=array(
                             'id'=>24,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;3.3&nbsp;&nbsp; จำนวนครั้งของผู้ป่วยเบาหวานที่มีระดับ Fasting Blood Sugar อยู่ในเกณฑ์ที่ควบคุมได้ (70-130 mg/dl) ',
                             'numi'=>@number_format($numi24),
                             'numo'=>@number_format($numo24),
                             'total'=>@number_format($total24) 
                          );  
               $sql49="select lo.lab_items_code,lo.lab_order_result from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id  in ('1','3')  and lo.lab_items_code='193' 
                           and lo.lab_order_result>0 group by l.hn;";
               $sql50="select lo.lab_items_code,lo.lab_order_result from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id not in ('1','3')  and lo.lab_items_code='193' 
                           and lo.lab_order_result>0 group by l.hn;";          
                          $numi25=\Yii::$app->db1->createCommand($sql49)->execute();    
                          $numo25=\Yii::$app->db1->createCommand($sql50)->execute();   
                          $total25=$numi25+$numo25;                            
                          $rawData[]=array(
                             'id'=>25,
                             'pname'=>'4.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานมีการตรวจหาระดับ HbA1c ทั้งหมด (คน)',
                             'numi'=>@number_format($numi25),
                             'numo'=>@number_format($numo25),
                             'total'=>@number_format($total25) 
                          );
               $sql51="select  count(*) cc
                           from (select c.clinic,c.hn from clinicmember c  where  c.clinic='001' and c.clinic_member_status_id in ('3','11')  ) as c
                            inner join person p on p.patient_hn=c.hn          
                            inner join (select  hn,max(vn) vn from lab_head where receive_date between  '{$date1}'  and '{$date2}' group by hn)
                            as l on c.hn=l.hn
                            inner join (select l.vn,lo.lab_order_result from lab_head l
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                            where lo.lab_items_code='193' and lo.lab_order_result <7) 
                            as l1 on l1.vn=l.vn
                            where p.person_discharge_id='9' and p.house_regist_type_id  in ('1','3')  order by c.hn;";
               $sql52="select  count(*) cc
                           from (select c.clinic,c.hn from clinicmember c  where  c.clinic='001' and c.clinic_member_status_id in ('3','11')  ) as c
                            inner join person p on p.patient_hn=c.hn          
                            inner join (select  hn,max(vn) vn from lab_head where receive_date between  '{$date1}'  and '{$date2}' group by hn)
                            as l on c.hn=l.hn
                            inner join (select l.vn,lo.lab_order_result from lab_head l
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                            where lo.lab_items_code='193' and lo.lab_order_result <7) 
                            as l1 on l1.vn=l.vn
                            where p.person_discharge_id='9' and p.house_regist_type_id not in ('1','3')  order by c.hn;";      
                          $numi26=\Yii::$app->db1->createCommand($sql51)->queryScalar();    
                          $numo26=\Yii::$app->db1->createCommand($sql52)->queryScalar();   
                          $total26=$numi26+$numo26;                            
                          $rawData[]=array(
                             'id'=>26,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;4.1&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานที่มีการตรวจหาระดับ HbA1c < 7% (ครั้งล่าสุด คน)',
                             'numi'=>@number_format($numi26),
                             'numo'=>@number_format($numo26),
                             'total'=>@number_format($total26) 
                          );  
               $sql53="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id  in ('1','3')  and lo.lab_items_code='193' 
                           and lo.lab_order_result>0;";
               $sql54="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id not in ('1','3')  and lo.lab_items_code='193' 
                           and lo.lab_order_result>0;";      
                          $numi27=\Yii::$app->db1->createCommand($sql53)->queryScalar();  
                          $numo27=\Yii::$app->db1->createCommand($sql54)->queryScalar();   
                          $total27=$numi27+$numo27;                              
                          $rawData[]=array(
                             'id'=>27,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;4.2&nbsp;&nbsp; จำนวนครั้งของผู้ป่วยเบาหวานมีการตรวจหาระดับ HbA1c',
                             'numi'=>@number_format($numi27),
                             'numo'=>@number_format($numo27),
                             'total'=>@number_format($total27) 
                          );  
               $sql55="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id  in ('1','3')  and lo.lab_items_code='193' 
                           and lo.lab_order_result<7;";
               $sql56="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                           and p.person_discharge_id='9' and p.house_regist_type_id not in ('1','3')  and lo.lab_items_code='193' 
                           and lo.lab_order_result<7;";   
                          $numi28=\Yii::$app->db1->createCommand($sql55)->queryScalar();    
                          $numo28=\Yii::$app->db1->createCommand($sql56)->queryScalar();   
                          $total28=$numi28+$numo28;                           
                          $rawData[]=array(
                             'id'=>28,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;4.3&nbsp;&nbsp; จำนวนครั้งของผู้ป่วยเบาหวานมีการตรวจหาระดับ HbA1c < 7%',
                             'numi'=>@number_format($numi28),
                             'numo'=>@number_format($numo28),
                             'total'=>@number_format($total28) 
                          ); 
               $sql57="select count(*) cc from an_stat a left outer join person p on p.patient_hn=a.hn 
                          where a.dchdate between  '{$date1}'  and '{$date2}' and 
                          (a.pdx in ('E160','E100','E110','E101') or(a.pdx='E162' or a.dx0 between 'E10' and 'E149')) 
                           and p.person_discharge_id='9' and p.house_regist_type_id  in ('1','3');";
               
               $sql58="select count(*) cc from an_stat a left outer join person p on p.patient_hn=a.hn 
                          where a.dchdate between '{$date1}'  and '{$date2}' and 
                          (a.pdx in ('E160','E100','E110','E101') or(a.pdx='E162' or a.dx0 between 'E10' and 'E149')) 
                           and p.person_discharge_id='9' and p.house_regist_type_id not in ('1','3');";
                          $numi29=\Yii::$app->db1->createCommand($sql57)->queryScalar();    
                          $numo29=\Yii::$app->db1->createCommand($sql58)->queryScalar();   
                          $total29=$numi29+$numo29;                             
                          $rawData[]=array(
                             'id'=>29,
                             'pname'=>'5.&nbsp;&nbsp; การเข้ารักษาในโรงพยาบาลเนื่องจากภาวะแทรกซ้อนเฉียบพลันจากโรคเบาหวาน(IPD)',
                             'numi'=>@number_format($numi29),
                             'numo'=>@number_format($numo29),
                             'total'=>@number_format($total29) 
                          );  
               $sql59="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}'  and '{$date2}' and lo.lab_items_code in  ('102','92','91','103')
                                    and lo.lab_order_result>0 group by l.hn having cc>=4
                             ) as b
                             on a.vn=b.vn;";
               $sql60="select  count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}'  and '{$date2}' and lo.lab_items_code in  ('102','92','91','103')
                                    and lo.lab_order_result>0 group by l.hn having cc>=4
                             ) as b
                             on a.vn=b.vn;";  
                          $numi30=\Yii::$app->db1->createCommand($sql59)->queryScalar();    
                          $numo30=\Yii::$app->db1->createCommand($sql60)->queryScalar();   
                          $total30=$numi30+$numo30;                           
                          $rawData[]=array(
                             'id'=>30,
                             'pname'=>'6.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานได้รับการตรวจวิเคราะห์ Lipid profile (คน)',
                             'numi'=>@number_format($numi30),
                             'numo'=>@number_format($numo30),
                             'total'=>@number_format($total30) 
                          ); 
               $sql59a="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';";
               $sql60a="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id not in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';"; 
                          $numi30a=\Yii::$app->db1->createCommand($sql59a)->queryScalar();    
                          $numo30a=\Yii::$app->db1->createCommand($sql60a)->queryScalar();   
                          $total30a=$numi30a+$numo30a;                               
                          $rawData[]=array(
                             'id'=>311,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;6.1&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานได้รับการตรวจ  LDL(คน) ',
                             'numi'=>@number_format($numi30a),
                             'numo'=>@number_format($numo30a),
                             'total'=>@number_format($total30a) 
                          );                            
               $sql61="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";
               $sql62="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id not in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";    
                          $numi31=\Yii::$app->db1->createCommand($sql61)->queryScalar();    
                          $numo31=\Yii::$app->db1->createCommand($sql62)->queryScalar();   
                          $total31=$numi31+$numo31;                           
                          $rawData[]=array(
                             'id'=>31,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;6.2&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานได้รับการตรวจ  LDL< 100 mg/dl (คน) ',
                             'numi'=>@number_format($numi31),
                             'numo'=>@number_format($numo31),
                             'total'=>@number_format($total31) 
                          );  
               $sql63="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';";
               $sql64="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id not in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';";  
                          $numi32=\Yii::$app->db1->createCommand($sql63)->queryScalar();    
                          $numo32=\Yii::$app->db1->createCommand($sql64)->queryScalar();   
                          $total32=$numi32+$numo32;                           
                          $rawData[]=array(
                             'id'=>32,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;6.3&nbsp;&nbsp; จำนวนครั้งผู้ป่วยเบาหวาน ได้รับการตรวจ LDL',
                             'numi'=>@number_format($numi32),
                             'numo'=>@number_format($numo32),
                             'total'=>@number_format($total32) 
                          );  
               $sql65="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";
               $sql66="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='001' and c.clinic_member_status_id not in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";  
                          $numi33=\Yii::$app->db1->createCommand($sql65)->queryScalar();    
                          $numo33=\Yii::$app->db1->createCommand($sql66)->queryScalar();   
                          $total33=$numi33+$numo33;                            
                          $rawData[]=array(
                             'id'=>33,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;6.4&nbsp;&nbsp; จำนวนครั้งของผู้ป่วยเบาหวานที่มีระดับ LDL< 100 mg/dl ',
                             'numi'=>@number_format($numi33),
                             'numo'=>@number_format($numo33),
                             'total'=>@number_format($total33) 
                          );
               $sql67="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') and o.bps>0 and o.bpd>0 group by o.hn ;";
               $sql68="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') and o.bps>0 and o.bpd>0 group by o.hn ;";     
                          $numi34=\Yii::$app->db1->createCommand($sql67)->query()->rowCount;    
                          $numo34=\Yii::$app->db1->createCommand($sql68)->query()->rowCount;   
                          $total34=$numi34+$numo34;                                        
                          $rawData[]=array(
                             'id'=>34,
                             'pname'=>'7.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานและเบาหวานร่วมความดัน ได้รับการวัดระดับความดันโลหิต(คน)',
                             'numi'=>@number_format($numi34),
                             'numo'=>@number_format($numo34),
                             'total'=>@number_format($total34) 
                          );  
               $sql69="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join person p on c.hn=p.patient_hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                       and p.house_regist_type_id  in ('1','3') and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                             where o.bps<130 and o.bpd<80;";
               $sql70="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join person p on c.hn=p.patient_hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id not in ('3','11') and p.person_discharge_id='9' 
                                       and p.house_regist_type_id  in ('1','3') and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                             where o.bps<130 and o.bpd<80;";  
                          $numi35=\Yii::$app->db1->createCommand($sql69)->queryScalar();    
                          $numo35=\Yii::$app->db1->createCommand($sql70)->queryScalar();   
                          $total35=$numi35+$numo35;                            
                          $rawData[]=array(
                             'id'=>35,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;7.1&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานร่วมความดันที่มีระดับความดันโลหิต  อยู่ในเกณฑ์ที่ควบคุมได้(<= 130/80 mmHg)ครั้งสุดท้าย(คน)',
                             'numi'=>@number_format($numi35),
                             'numo'=>@number_format($numo35),
                             'total'=>@number_format($total35) 
                          );   
               $sql71="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join person p on c.hn=p.patient_hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                       and p.house_regist_type_id not  in ('1','3') and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                             where o.bps<140 and o.bpd<80;";
               $sql72="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join person p on c.hn=p.patient_hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                       and p.house_regist_type_id  in ('1','3') and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                             where o.bps<140 and o.bpd<80;";   
                          $numi36=\Yii::$app->db1->createCommand($sql71)->queryScalar();    
                          $numo36=\Yii::$app->db1->createCommand($sql72)->queryScalar();   
                          $total36=$numi36+$numo36;                           
                          $rawData[]=array(
                             'id'=>36,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;7.2&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานที่มีระดับความดันโลหิต<140/80(คน)',
                             'numi'=>@number_format($numi36),
                             'numo'=>@number_format($numo36),
                             'total'=>@number_format($total36) 
                          );  
               $sql73="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') and o.bps>0 and o.bpd>0 ;";
               $sql74="select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') and o.bps>0 and o.bpd>0 ;";   
                          $numi37=\Yii::$app->db1->createCommand($sql73)->queryScalar();    
                          $numo37=\Yii::$app->db1->createCommand($sql74)->queryScalar();   
                          $total37=$numi37+$numo37;                           
                          $rawData[]=array(
                             'id'=>37,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;7.3&nbsp;&nbsp; จำนวนครั้งของผู้ป่วยเบาหวานที่ได้รับการวัดระดับความดันโลหิต',
                             'numi'=>@number_format($numi37),
                             'numo'=>@number_format($numo37),
                             'total'=>@number_format($total37) 
                          ); 
               $sql73a="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join person p on c.hn=p.patient_hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3') and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn 
                             where o.bps<130 and o.bpd<80 ;";
               $sql74a="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join person p on c.hn=p.patient_hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3') and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn 
                             where o.bps<130 and o.bpd<80 ;";
                          $numi37a=\Yii::$app->db1->createCommand($sql73a)->queryScalar();    
                          $numo37a=\Yii::$app->db1->createCommand($sql74a)->queryScalar();   
                          $total37a=$numi37a+$numo37a;                           
                          $rawData[]=array(
                             'id'=>371,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;7.4&nbsp;&nbsp; จำนวนครั้งของผู้ป่วยเบาหวานร่วมความดันที่มีระดับความดันโลหิต<130/80',
                             'numi'=>@number_format($numi37a),
                             'numo'=>@number_format($numo37a),
                             'total'=>@number_format($total37a) 
                          );                           
               $sql73b="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join person p on c.hn=p.patient_hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3') and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn
                             where o.bps<140 and o.bpd<80 ;";
               $sql74b="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join person p on c.hn=p.patient_hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3') and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn 
                             where o.bps<140 and o.bpd<80 ;"; 
                          $numi37b=\Yii::$app->db1->createCommand($sql73b)->queryScalar();    
                          $numo37b=\Yii::$app->db1->createCommand($sql74b)->queryScalar();   
                          $total37b=$numi37b+$numo37b;                           
                          $rawData[]=array(
                             'id'=>372,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;7.5&nbsp;&nbsp; จำนวนครั้งของผู้ป่วยเบาหวานร่วมความดันที่มีระดับความดันโลหิต<140/80',
                             'numi'=>@number_format($numi37b),
                             'numo'=>@number_format($numo37b),
                             'total'=>@number_format($total37b) 
                          );                               
                          
               $sql75="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn
                            where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') and p.sex='1' and
                            TIMESTAMPDIFF(YEAR, p.birthdate, concat(IF(MONTH('{$date2}')>=10,YEAR('{$date2}')+1 ,
                            YEAR('{$date2}'))-1,'-','10','-','01')) >=50;";
               $sql76="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn
                            where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') and p.sex='1' and
                            TIMESTAMPDIFF(YEAR, p.birthdate, concat(IF(MONTH('{$date2}')>=10,YEAR('{$date2}')+1 ,
                            YEAR('{$date2}'))-1,'-','10','-','01')) >=50;";
                          $numi38=\Yii::$app->db1->createCommand($sql75)->queryScalar();    
                          $numo38=\Yii::$app->db1->createCommand($sql76)->queryScalar();   
                          $total38=$numi38+$numo38;     
                         $rawData[]=array(
                             'id'=>38,
                             'pname'=>'8.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานเพศชาย ที่มีอายุ 50 ปีขึ้นไป',
                             'numi'=>@number_format($numi38),
                             'numo'=>@number_format($numo38),
                             'total'=>@number_format($total38) 
                          );  
               $sql77=" select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join person p on c.hn=p.patient_hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3') and p.sex='1' and
                                        TIMESTAMPDIFF(YEAR, p.birthdate, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                       YEAR('{$date2}'))-1,'-','10','-','01')) >=50 and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";
               $sql78=" select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join person p on c.hn=p.patient_hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not in ('1','3') and p.sex='1' and
                                        TIMESTAMPDIFF(YEAR, p.birthdate, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                       YEAR('{$date2}'))-1,'-','10','-','01')) >=50 and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";
                          $numi39=\Yii::$app->db1->createCommand($sql77)->queryScalar();    
                          $numo39=\Yii::$app->db1->createCommand($sql78)->queryScalar();   
                          $total39=$numi39+$numo39;                                      
                          $rawData[]=array(
                             'id'=>39,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;8.1&nbsp;&nbsp;  จำนวนผู้ป่วยเบาหวานเพศชายที่มีอายุ 50 ปีขึ้นไปและได้รับยาแอสไพริน',
                             'numi'=>@number_format($numi39),
                             'numo'=>@number_format($numo39),
                             'total'=>@number_format($total39) 
                          );   
                          $sql79="select count(*) cc
                                        from clinicmember c inner join person p on c.hn=p.patient_hn
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3') and p.sex='2' and
                                        TIMESTAMPDIFF(YEAR, p.birthdate, concat(IF(MONTH('{$date2}')>=10,YEAR('{$date2}')+1 ,
                                        YEAR('{$date2}'))-1,'-','10','-','01')) >=60;";
                          $sql80="select count(*) cc
                                        from clinicmember c inner join person p on c.hn=p.patient_hn
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not in ('1','3') and p.sex='2' and
                                        TIMESTAMPDIFF(YEAR, p.birthdate, concat(IF(MONTH('{$date2}')>=10,YEAR('{$date2}')+1 ,
                                        YEAR('{$date2}'))-1,'-','10','-','01')) >=60;;";    
                          $numi40=\Yii::$app->db1->createCommand($sql79)->queryScalar();    
                          $numo40=\Yii::$app->db1->createCommand($sql80)->queryScalar();   
                          $total40=$numi40+$numo40;                           
                          $rawData[]=array(
                             'id'=>40,
                             'pname'=>'9.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานเพศหญิง ที่มีอายุ 60 ปีขึ้นไป',
                             'numi'=>@number_format($numi40),
                             'numo'=>@number_format($numo40),
                             'total'=>@number_format($total40) 
                          );  
                          $sql81=" select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join person p on c.hn=p.patient_hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3') and p.sex='2' and
                                        TIMESTAMPDIFF(YEAR, p.birthdate, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                       YEAR('{$date2}'))-1,'-','10','-','01')) >=60 and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";
                          $sql82="select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join person p on c.hn=p.patient_hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not in ('1','3') and p.sex='2' and
                                        TIMESTAMPDIFF(YEAR, p.birthdate, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                       YEAR('{$date2}'))-1,'-','10','-','01')) >=60 and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";  
                          $numi41=\Yii::$app->db1->createCommand($sql81)->queryScalar();    
                          $numo41=\Yii::$app->db1->createCommand($sql82)->queryScalar();   
                          $total41=$numi41+$numo41;                             
                          $rawData[]=array(
                             'id'=>41,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;9.1&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานเพศหญิงที่มีอายุ 60 ปีขึ้นไปได้รับยาแอสไพริน',
                             'numi'=>@number_format($numi41),
                             'numo'=>@number_format($numo41),
                             'total'=>@number_format($total41) 
                          );   
                      $sql83="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('710','985','486') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";    
                      $sql84="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('710','985','486') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";     
                          $numi42=\Yii::$app->db1->createCommand($sql83)->queryScalar();    
                          $numo42=\Yii::$app->db1->createCommand($sql84)->queryScalar();   
                          $total42=$numi42+$numo42;                                               
                          $rawData[]=array(
                             'id'=>42,
                             'pname'=>'10.&nbsp;&nbsp; ผู้ป่วยเบาหวานที่ได้รับการตรวจ Microalbumin/Urine Albumin(Macroalbumin)(คน)',
                             'numi'=>@number_format($numi42),
                             'numo'=>@number_format($numo42),
                             'total'=>@number_format($total42) 
                          );  
                      $sql85="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('985','710') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";    
                      $sql86="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('985','710') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";     
                          $numi43=\Yii::$app->db1->createCommand($sql85)->queryScalar();    
                          $numo43=\Yii::$app->db1->createCommand($sql86)->queryScalar();   
                          $total43=$numi43+$numo43;                               
                          $rawData[]=array(
                             'id'=>43,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;10.1&nbsp;&nbsp; ผู้ป่วยเบาหวานที่ได้รับการตรวจ Microalbumin',
                             'numi'=>@number_format($numi43),
                             'numo'=>@number_format($numo43),
                             'total'=>@number_format($total43) 
                          );  
                     $sql87="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('486') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";    
                      $sql88="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('486') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";     
                          $numi44=\Yii::$app->db1->createCommand($sql87)->queryScalar();    
                          $numo44=\Yii::$app->db1->createCommand($sql88)->queryScalar();   
                          $total44=$numi44+$numo44;                              
                          $rawData[]=array(
                             'id'=>44,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;10.2&nbsp;&nbsp; ผู้ป่วยเบาหวานที่ได้รับการตรวจ Macroalbumin',
                             'numi'=>@number_format($numi44),
                             'numo'=>@number_format($numo44),
                             'total'=>@number_format($total44) 
                          );  
                      $sql89="select count(*) cc
                                     from (
                                        select c.hn,max(v.vn) vn from clinicmember c inner join person p on c.hn=p.patient_hn
                                        inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                       and p.house_regist_type_id  in ('1','3') group by c.hn
                                    ) as a
                                    inner join
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from
                                                lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number
                                               where lab_items_code in ('1030') and lo.lab_order_result <60 
                                    ) as b
                                    on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode not in ('1510053','1510054','1510055','1510066','1570020') group by o.vn order by a.hn;";
                      
                      $sql90="select count(*) cc
                                     from (
                                        select c.hn,max(v.vn) vn from clinicmember c inner join person p on c.hn=p.patient_hn
                                        inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                       and p.house_regist_type_id not in ('1','3') group by c.hn
                                    ) as a
                                    inner join
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from
                                                lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number
                                               where lab_items_code in ('1030') and lo.lab_order_result <60 
                                    ) as b
                                    on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode not in ('1510053','1510054','1510055','1510066','1570020') group by o.vn order by a.hn;";
                          $numi45=\Yii::$app->db1->createCommand($sql89)->queryScalar();    
                          $numo45=\Yii::$app->db1->createCommand($sql90)->queryScalar();   
                          $total45=$numi45+$numo45;                                             
                          $rawData[]=array(
                             'id'=>45,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;10.3&nbsp;&nbsp; ผู้ป่วยเบาหวานทั้งหมดที่มีภาวะแทรกซ้อนทางไต
                                           และไม่ได้รับยากลุ่ม ACE inhibitor หรือ ARB ',
                             'numi'=>@number_format($numi45),
                             'numo'=>@number_format($numo45),
                             'total'=>@number_format($total45) 
                          );
                      $sql91="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn;";  
                      $sql92="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn;";   
                          $numi46=\Yii::$app->db1->createCommand($sql91)->queryScalar();    
                          $numo46=\Yii::$app->db1->createCommand($sql92)->queryScalar();   
                          $total46=$numi46+$numo46;                                             
                          $rawData[]=array(
                             'id'=>46,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;10.4&nbsp;&nbsp; ผู้ป่วยเบาหวานที่มีภาวะ Microalbuminuria',
                             'numi'=>@number_format($numi46),
                             'numo'=>@number_format($numo46),
                             'total'=>@number_format($total46) 
                          );
                      $sql93="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode in ('1510053','1510054','1510055','1510066','1570020')  group by o.vn;";    
                      $sql94="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode in ('1510053','1510054','1510055','1510066','1570020')  group by o.vn;";  
                          $numi47=\Yii::$app->db1->createCommand($sql93)->queryScalar();    
                          $numo47=\Yii::$app->db1->createCommand($sql94)->queryScalar();   
                          $total47=$numi47+$numo47;                          
                          $rawData[]=array(
                             'id'=>47,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;10.5&nbsp;&nbsp; ผู้ป่วยเบาหวานที่มีภาวะ Microalbuminuria แล้วได้รับยากลุ่ม
                                             ACE inhibitor หรือ ARB' ,
                             'numi'=>@number_format($numi47),
                             'numo'=>@number_format($numo47),
                             'total'=>@number_format($total47) 
                          );
                     $sql95="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";    
                     $sql96="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";   
                          $numi48=\Yii::$app->db1->createCommand($sql95)->queryScalar();    
                          $numo48=\Yii::$app->db1->createCommand($sql96)->queryScalar();   
                          $total48=$numi48+$numo48;                        
                          $rawData[]=array(
                             'id'=>48,
                             'pname'=>'11.&nbsp;&nbsp; ผู้ป่วยเบาหวานที่มีภาวะแทรกซ้อนทางไต(CKD-EPI)(คน)',
                             'numi'=>@number_format($numi48),
                             'numo'=>@number_format($numo48),
                             'total'=>@number_format($total48) 
                          );   
                     $sql97="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}'  
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result>=90 
                                     ) as b     
                                     on a.vn=b.vn;";    
                     $sql98="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result>=90  
                                     ) as b     
                                     on a.vn=b.vn;";    
                          $numi49=\Yii::$app->db1->createCommand($sql97)->queryScalar();    
                          $numo49=\Yii::$app->db1->createCommand($sql98)->queryScalar();   
                          $total49=$numi49+$numo49;                      
                          $rawData[]=array(
                             'id'=>49,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;11.1&nbsp;&nbsp;ระยะที่ 1 (GFR>=90 ml/min)',
                             'numi'=>@number_format($numi49),
                             'numo'=>@number_format($numo49),
                             'total'=>@number_format($total49) 
                          ); 
                     $sql99="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 60 and 89 
                                     ) as b     
                                     on a.vn=b.vn;";    
                     $sql100="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 60 and 89 
                                     ) as b     
                                     on a.vn=b.vn;";    
                          $numi50=\Yii::$app->db1->createCommand($sql99)->queryScalar();    
                          $numo50=\Yii::$app->db1->createCommand($sql100)->queryScalar();   
                          $total50=$numi50+$numo50;                            
                          $rawData[]=array(
                             'id'=>50,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;11.2&nbsp;&nbsp;ระยะที่ 2 (GFR 60-89 ml/min)',
                             'numi'=>@number_format($numi50),
                             'numo'=>@number_format($numo50),
                             'total'=>@number_format($total50) 
                          );  
                    $sql101="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 30 and 59 
                                     ) as b     
                                     on a.vn=b.vn;";    
                     $sql102="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 30 and 59 
                                     ) as b     
                                     on a.vn=b.vn;";    
                          $numi51=\Yii::$app->db1->createCommand($sql101)->queryScalar();    
                          $numo51=\Yii::$app->db1->createCommand($sql102)->queryScalar();   
                          $total51=$numi51+$numo51;                            
                          $rawData[]=array(
                             'id'=>51,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;11.3&nbsp;&nbsp;ระยะที่ 3 (GFR 30-59 ml/min)',
                             'numi'=>@number_format($numi51),
                             'numo'=>@number_format($numo51),
                             'total'=>@number_format($total51) 
                          ); 
                   $sql103="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 15 and 29 
                                     ) as b     
                                     on a.vn=b.vn;";    
                     $sql104="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 15 and 29 
                                     ) as b     
                                     on a.vn=b.vn;";    
                          $numi52=\Yii::$app->db1->createCommand($sql103)->queryScalar();    
                          $numo52=\Yii::$app->db1->createCommand($sql104)->queryScalar();   
                          $total52=$numi52+$numo52;                             
                          $rawData[]=array(
                             'id'=>52,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;11.4&nbsp;&nbsp;ระยะที่ 4 (GFR 15-29 ml/min)',
                             'numi'=>@number_format($numi52),
                             'numo'=>@number_format($numo52),
                             'total'=>@number_format($total52) 
                          ); 
                   $sql105="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result<15
                                     ) as b     
                                     on a.vn=b.vn;";    
                     $sql106="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result<15
                                     ) as b     
                                     on a.vn=b.vn;";    
                          $numi53=\Yii::$app->db1->createCommand($sql105)->queryScalar();    
                          $numo53=\Yii::$app->db1->createCommand($sql106)->queryScalar();   
                          $total53=$numi53+$numo53;                             
                          $rawData[]=array(
                             'id'=>53,
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;11.5&nbsp;&nbsp;ระยะที่ 5 (GFR<15 ml/min)',
                             'numi'=>@number_format($numi53),
                             'numo'=>@number_format($numo53),
                             'total'=>@number_format($total53) 
                          ); 
              $sql107=" select count(*) cc
                                    from (
                                        select cs.do_eye_screen,cs.has_eye_cormobidity,cs.clinicmember_cormobidity_screen_id
                                            from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3') and cs.do_eye_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                       select clinicmember_cormobidity_screen_id,clinicmember_cormobidity_eye_screen_id,
                                                   dmht_eye_screen_result_left_id,dmht_eye_screen_result_right_id
                                            from        
                                            clinicmember_cormobidity_eye_screen where 
                                                  (dmht_eye_screen_result_left_id is not null and dmht_eye_screen_result_left_id !='' 
                                                          and dmht_eye_screen_result_left_id !=0) and 
                                                 (dmht_eye_screen_result_right_id is not null and dmht_eye_screen_result_right_id !='' 
                                                          and dmht_eye_screen_result_right_id !=0)
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;"; 
              $sql108=" select count(*) cc
                                    from (
                                        select cs.do_eye_screen,cs.has_eye_cormobidity,cs.clinicmember_cormobidity_screen_id
                                            from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3') and cs.do_eye_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                       select clinicmember_cormobidity_screen_id,clinicmember_cormobidity_eye_screen_id,
                                                   dmht_eye_screen_result_left_id,dmht_eye_screen_result_right_id
                                            from        
                                            clinicmember_cormobidity_eye_screen where 
                                                  (dmht_eye_screen_result_left_id is not null and dmht_eye_screen_result_left_id !='' 
                                                          and dmht_eye_screen_result_left_id !=0) and 
                                                 (dmht_eye_screen_result_right_id is not null and dmht_eye_screen_result_right_id !='' 
                                                          and dmht_eye_screen_result_right_id !=0)
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";    
                          $numi54=\Yii::$app->db1->createCommand($sql107)->queryScalar();    
                          $numo54=\Yii::$app->db1->createCommand($sql108)->queryScalar();   
                          $total54=$numi54+$numo54;                 
                          $rawData[]=array(
                             'id'=>'54',
                             'pname'=>'12.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานได้รับการตรวจจอประสาทตา',
                             'numi'=>@number_format($numi54),
                             'numo'=>@number_format($numo54),
                             'total'=>@number_format($total54) 
                          );   
               $sql109=" select count(*) cc
                                    from (
                                            select cs.do_dental_screen,cs.has_dental_cormobidity,cs.clinicmember_cormobidity_screen_id 
                                            from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3') and cs.do_dental_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                            select clinicmember_cormobidity_screen_id,oral_cavity_educate
                                            from
                                                   clinicmember_cormobidity_dental_screen where oral_cavity_educate='Y'
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;"; 
               $sql110=" select count(*) cc
                                    from (
                                            select cs.do_dental_screen,cs.has_dental_cormobidity,cs.clinicmember_cormobidity_screen_id 
                                            from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3') and cs.do_dental_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                            select clinicmember_cormobidity_screen_id,oral_cavity_educate
                                            from
                                                   clinicmember_cormobidity_dental_screen where oral_cavity_educate='Y'
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";  
                          $numi55=\Yii::$app->db1->createCommand($sql109)->queryScalar();    
                          $numo55=\Yii::$app->db1->createCommand($sql110)->queryScalar();   
                          $total55=$numi55+$numo55;                                             
                          $rawData[]=array(
                             'id'=>'55',
                             'pname'=>'13.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานได้รับการตรวจสุขภาพช่องปาก',
                             'numi'=>@number_format($numi55),
                             'numo'=>@number_format($numo55),
                             'total'=>@number_format($total55) 
                          ); 
        $sql111=" select count(*) cc
                              from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join person p on c.hn=p.patient_hn
                                    inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                    where cs.screen_date between '{$date1}'  and '{$date2}' 
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                    and p.house_regist_type_id in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id
                                     from
                                        clinicmember_cormobidity_foot_screen 
                                        where dmht_foot_screen_result_left_id <> 0 and dmht_foot_screen_result_right_id <> 0 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";   
        $sql112=" select count(*) cc
                              from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join person p on c.hn=p.patient_hn
                                    inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                    where cs.screen_date between '{$date1}'  and '{$date2}' 
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                    and p.house_regist_type_id not in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id
                                     from
                                        clinicmember_cormobidity_foot_screen 
                                        where dmht_foot_screen_result_left_id <> 0 and dmht_foot_screen_result_right_id <> 0 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";         
                          $numi56=\Yii::$app->db1->createCommand($sql111)->queryScalar();    
                          $numo56=\Yii::$app->db1->createCommand($sql112)->queryScalar();   
                          $total56=$numi56+$numo56;                                        
                          $rawData[]=array(
                             'id'=>'56',
                             'pname'=>'14.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานได้รับการตรวจเท้า',
                             'numi'=>@number_format($numi56),
                             'numo'=>@number_format($numo56),
                             'total'=>@number_format($total56) 
                          ); 
        $sql113=" select count(*) cc
                             from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_ulcer_id in (1,2,3) 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";         
        $sql114=" select count(*) cc
                             from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_ulcer_id in (1,2,3) 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";   
                          $numi57=\Yii::$app->db1->createCommand($sql113)->queryScalar();    
                          $numo57=\Yii::$app->db1->createCommand($sql114)->queryScalar();   
                          $total57=$numi57+$numo57;                                                
                          $rawData[]=array(
                             'id'=>'57',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;14.1&nbsp;&nbsp; การตรวจพบแผลที่เท้า',
                             'numi'=>@number_format($numi57),
                             'numo'=>@number_format($numo57),
                             'total'=>@number_format($total57) 
                          );
        $sql115=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                           inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '2010-01-01'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;";         
        $sql116=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                            inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '2010-01-01'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;";    
                          $numi58=\Yii::$app->db1->createCommand($sql115)->execute();    
                          $numo58=\Yii::$app->db1->createCommand($sql116)->execute();   
                          $total58=$numi58+$numo58;                                             
                          $rawData[]=array(
                             'id'=>'58',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;14.2&nbsp;&nbsp; มีประวัติตัดนิ้วเท้า เท้า หรือขา
                                            (ภาพรวม)หมายเหตุ:14.2.1+14.2.2 อาจไม่เท่ากับ 14.2 เพราะคนที่มีการตัด >1ครั้งอาจจะถูกนับทั้ง 2 ที่',
                             'numi'=>@number_format($numi58),
                             'numo'=>@number_format($numo58),
                             'total'=>@number_format($total58) 
                          ); 
        $sql117=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c 
                                            inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;";         
        $sql118=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                            inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;";    
                          $numi59=\Yii::$app->db1->createCommand($sql117)->execute();    
                          $numo59=\Yii::$app->db1->createCommand($sql118)->execute();   
                          $total59=$numi59+$numo59;                               
                          $rawData[]=array(
                             'id'=>'59',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14.2.1 มีการตัดนิ้วเท้า เท้า หรือขา รายใหม่',
                             'numi'=>@number_format($numi59),
                             'numo'=>@number_format($numo59),
                             'total'=>@number_format($total59) 
                          ); 
        $sql119=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                            inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;";         
        $sql120=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c 
                                            inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3') and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id ;";    
                          $numi60=\Yii::$app->db1->createCommand($sql119)->execute();    
                          $numo60=\Yii::$app->db1->createCommand($sql120)->execute();   
                          $total60=$numi60+$numo60;                            
                          $rawData[]=array(
                             'id'=>'60',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;14.2.2 มีการตัดนิ้วเท้า เท้า หรือขา รายเก่า',
                             'numi'=>@number_format($numi60),
                             'numo'=>@number_format($numo60),
                             'total'=>@number_format($total60) 
                          ); 
        $sql121=" select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join opdscreen o on c.hn=o.hn
                                            where o.vstdate between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3')  and o.smoking_type_id in (2,5) group by c.hn;";      
        $sql122=" select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join opdscreen o on c.hn=o.hn
                                            where o.vstdate between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3')  and o.smoking_type_id in (2,5) group by c.hn;";    
                          $numi61=\Yii::$app->db1->createCommand($sql121)->query()->rowCount;    
                          $numo61=\Yii::$app->db1->createCommand($sql122)->query()->rowCount;   
                          $total61=$numi61+$numo61;                                                 
                          $rawData[]=array(
                             'id'=>'61',
                             'pname'=>'15.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานสูบบุหรี่(คน)',
                             'numi'=>@number_format($numi61),
                             'numo'=>@number_format($numo61),
                             'total'=>@number_format($total61) 
                          );
        $sql123=" select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join opdscreen o on c.hn=o.hn
                                            where o.vstdate between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3')  and o.smoking_type_id in (5) group by c.hn;";      
        $sql124=" select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join opdscreen o on c.hn=o.hn
                                            where o.vstdate between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3')  and o.smoking_type_id in (5) group by c.hn;";    
                          $numi62=\Yii::$app->db1->createCommand($sql123)->query()->rowCount;    
                          $numo62=\Yii::$app->db1->createCommand($sql124)->query()->rowCount;   
                          $total62=$numi62+$numo62;                             
                          $rawData[]=array(
                             'id'=>'62',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;15.1&nbsp;&nbsp;มีการได้รับคำแนะนำปรึกษาให้เลิกสูบบุหรี่(คน)',
                             'numi'=>@number_format($numi62),
                             'numo'=>@number_format($numo62),
                             'total'=>@number_format($total62) 
                          );
        $sql125=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3') and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";
        $sql126=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3') and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";      
                          $numi63=\Yii::$app->db1->createCommand($sql125)->queryScalar();    
                          $numo63=\Yii::$app->db1->createCommand($sql126)->queryScalar();   
                          $total63=$numi63+$numo63;                                              
                          $rawData[]=array(
                             'id'=>'63',
                             'pname'=>'16.&nbsp;&nbsp; การได้รับการวินิจฉัยว่าเป็น Diabetic retinopathy(พบภาวะแทรกซ้อนตา)ตรวจสอบย้อน ตั้งแต่ 2553',
                             'numi'=>@number_format($numi63),
                             'numo'=>@number_format($numo63),
                             'total'=>@number_format($total63) 
                          );
        $sql127=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3') and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";
        $sql128=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3') and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";      
                          $numi64=\Yii::$app->db1->createCommand($sql127)->queryScalar();    
                          $numo64=\Yii::$app->db1->createCommand($sql128)->queryScalar();   
                          $total64=$numi64+$numo64;                            
                          $rawData[]=array(
                             'id'=>'64',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;16.1&nbsp;&nbsp;ได้รับการวินิจฉัยว่าเป็น Diabetic retinopathy รายใหม่ ',
                             'numi'=>@number_format($numi64),
                             'numo'=>@number_format($numo64),
                             'total'=>@number_format($total64) 
                          ); 
        $sql129=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id in ('1','3') and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";
        $sql130=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c inner join person p on c.hn=p.patient_hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9'
                                            and p.house_regist_type_id not in ('1','3') and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";      
                          $numi65=\Yii::$app->db1->createCommand($sql129)->queryScalar();    
                          $numo65=\Yii::$app->db1->createCommand($sql130)->queryScalar();   
                          $total65=$numi65+$numo65;                            
                          $rawData[]=array(
                             'id'=>'65',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;16.2&nbsp;&nbsp;ได้รับการวินิจฉัยว่าเป็น Diabetic retinopathy รายเก่า ',
                             'numi'=>@number_format($numi65),
                             'numo'=>@number_format($numo65),
                             'total'=>@number_format($total65) 
                          ); 
                     $sql131="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";    
                     $sql132="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";   
                          $numi66=\Yii::$app->db1->createCommand($sql131)->queryScalar();    
                          $numo66=\Yii::$app->db1->createCommand($sql132)->queryScalar();   
                          $total66=$numi66+$numo66;                              
                          $rawData[]=array(
                             'id'=>'66',
                             'pname'=>'17.&nbsp;&nbsp; การได้รับการวินิจฉัยว่าเป็น Diabetic nephropathy(พบภาวะแทรกซ้อนไต)ตรวจสอบย้อนตั้งแต่ 2553',
                             'numi'=>@number_format($numi66),
                             'numo'=>@number_format($numo66),
                             'total'=>@number_format($total66) 
                          );
                     $sql133="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";    
                     $sql134="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";   
                          $numi67=\Yii::$app->db1->createCommand($sql133)->queryScalar();    
                          $numo67=\Yii::$app->db1->createCommand($sql134)->queryScalar();   
                          $total67=$numi67+$numo67;                                                 
                          $rawData[]=array(
                             'id'=>'67',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;17.1&nbsp;&nbsp;ได้รับการวินิจฉัยว่าเป็น Diabetic nephropathy รายใหม่ ',
                             'numi'=>@number_format($numi67),
                             'numo'=>@number_format($numo67),
                             'total'=>@number_format($total67) 
                          ); 
                     $sql135="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date1}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";    
                     $sql136="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date1}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";   
                          $numi68=\Yii::$app->db1->createCommand($sql135)->queryScalar();    
                          $numo68=\Yii::$app->db1->createCommand($sql136)->queryScalar();   
                          $total68=$numi68+$numo68;                           
                          $rawData[]=array(
                             'id'=>'68',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;17.2&nbsp;&nbsp;ได้รับการวินิจฉัยว่าเป็น  Diabetic nephropathy รายเก่า ',
                             'numi'=>@number_format($numi68),
                             'numo'=>@number_format($numo68),
                             'total'=>@number_format($total68) 
                          );  
        $sql137="select count(*) cc from referout where refer_date between '{$date1}'  and '{$date2}' and pre_diagnosis='DM';";   
                          $total69=\Yii::$app->db1->createCommand($sql137)->queryScalar(); 
                          $rawData[]=array(
                             'id'=>'69',
                             'pname'=>'18.&nbsp;&nbsp; จำนวนผู้ป่วยที่ รพ.ส่งกลับ รพ.สต(เบาหวาน)(คน)',
                             'numi'=>'-',
                             'numo'=>'-',
                             'total'=>'-'
                          );  
        $sql138="select count(*) cc from referout where refer_date between '{$date1}'  and '{$date2}' and pre_diagnosis='DMHT';";   
                          $total70=\Yii::$app->db1->createCommand($sql138)->queryScalar();                           
                          $rawData[]=array(
                             'id'=>'70',
                             'pname'=>'19.&nbsp;&nbsp; จำนวนผู้ป่วยที่ รพ.ส่งกลับ รพ.สต(เบาหวาน-ความดัน)(คน)',
                             'numi'=>'-',
                             'numo'=>'-',
                             'total'=>'-'
                          );    
        $sql139=";"; 
        $sql140=";";
                          $rawData[]=array(
                             'id'=>'71',
                             'pname'=>'20.&nbsp;&nbsp; จำนวนผู้ป่วยที่ได้รับการปรับเปลี่ยน 3อ2ส.(คน)',
                             'numi'=>'',
                             'numo'=>'',
                             'total'=>'' 
                          );  
                          $rawData[]=array(
                             'id'=>'71a',
                             'pname'=>'<h4>ปัจจัยเสี่ยงต่อโรคหัวใจและหลอดเลือด</h4>',
                             'numi'=>'',
                             'numo'=>'',
                             'total'=>''
                          );                            
        $sql141="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn
                             group by a.hn;";  
        $sql142="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn
                             group by a.hn;";     
                          $numi72=\Yii::$app->db1->createCommand($sql141)->query()->rowCount;    
                          $numo72=\Yii::$app->db1->createCommand($sql142)->query()->rowCount;    
                          $total72=$numi72+$numo72;                                             
                          $rawData[]=array(
                             'id'=>'72',
                             'pname'=>'21.&nbsp;&nbsp; จำนวนคนที่ได้รับการตรวจภาวะแทรกซ้อนของหลอดเลือดสมอง(คน)',
                             'numi'=>@number_format($numi72),
                             'numo'=>@number_format($numo72),
                             'total'=>@number_format($total72) 
                          );  
        $sql143="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn
                             group by a.hn;";  
        $sql144="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn
                             group by a.hn;";     
                          $numi73=\Yii::$app->db1->createCommand($sql143)->query()->rowCount;    
                          $numo73=\Yii::$app->db1->createCommand($sql144)->query()->rowCount;    
                          $total73=$numi73+$numo73;             
                          $rawData[]=array(
                             'id'=>'73',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;21.1&nbsp;&nbsp;จำนวนคนที่ตรวจพบภาวะแทรกซ้อนของหลอดเลือดสมองทั้งหมด(คน)',
                             'numi'=>@number_format($numi73),
                             'numo'=>@number_format($numo73),
                             'total'=>@number_format($total73) 
                          ); 
        $sql145="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn
                             group by a.hn;";  
        $sql146="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn
                             group by a.hn;";     
                          $numi74=\Yii::$app->db1->createCommand($sql145)->query()->rowCount;    
                          $numo74=\Yii::$app->db1->createCommand($sql146)->query()->rowCount;    
                          $total74=$numi74+$numo74;                             
                          $rawData[]=array(
                             'id'=>'74',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;21.2&nbsp;&nbsp;จำนวนคนที่ตรวจพบภาวะแทรกซ้อนของหลอดเลือดสมอง รายใหม่(คน)',
                             'numi'=>@number_format($numi74),
                             'numo'=>@number_format($numo74),
                             'total'=>@number_format($total74) 
                          );  
        $sql147="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";     
        $sql148="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";     
                          $numi75=\Yii::$app->db1->createCommand($sql147)->query()->rowCount;    
                          $numo75=\Yii::$app->db1->createCommand($sql148)->query()->rowCount;    
                          $total75=$numi75+$numo75;                                              
                          $rawData[]=array(
                             'id'=>'75',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;21.3&nbsp;&nbsp;กลุ่มปกติ(ไม่เสี่ยงต่ออัมพฤกษ์ อัมพาต)(ผิดปกติ 0-1 ข้อ)',
                             'numi'=>@number_format($numi75),
                             'numo'=>@number_format($numo75),
                             'total'=>@number_format($total75) 
                          ); 
        $sql149="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;";     
        $sql150="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;";     
                          $numi76=\Yii::$app->db1->createCommand($sql149)->query()->rowCount;    
                          $numo76=\Yii::$app->db1->createCommand($sql150)->query()->rowCount;    
                          $total76=$numi76+$numo76;                             
                          $rawData[]=array(
                             'id'=>'76',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;21.4&nbsp;&nbsp;กลุ่มเสี่ยงสูง(ผิดปกติ 2 ข้อ)',
                             'numi'=>@number_format($numi76),
                             'numo'=>@number_format($numo76),
                             'total'=>@number_format($total76) 
                          );   
        $sql151="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;";     
        $sql152="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;";     
                          $numi77=\Yii::$app->db1->createCommand($sql151)->query()->rowCount;    
                          $numo77=\Yii::$app->db1->createCommand($sql152)->query()->rowCount;    
                          $total77=$numi77+$numo77;                              
                          $rawData[]=array(
                             'id'=>'77',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;21.5&nbsp;&nbsp;กลุ่มเสี่ยงสูงปานกลาง(ผิดปกติ 3-5 ข้อ)',
                             'numi'=>@number_format($numi77),
                             'numo'=>@number_format($numo77),
                             'total'=>@number_format($total77) 
                          );  
        $sql153="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;";     
        $sql154="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;";     
                          $numi78=\Yii::$app->db1->createCommand($sql153)->query()->rowCount;    
                          $numo78=\Yii::$app->db1->createCommand($sql154)->query()->rowCount;    
                          $total78=$numi78+$numo78;                            
                          $rawData[]=array(
                             'id'=>'78',
                             'pname'=>'&nbsp;&nbsp;&nbsp;&nbsp;21.6&nbsp;&nbsp;กลุ่มเสี่ยงสูงมาก(ผิดปกติ 6-9 ข้อ หรือมีปัจจัยข้อ 8 หรือ 9)',
                             'numi'=>@number_format($numi78),
                             'numo'=>@number_format($numo78),
                             'total'=>@number_format($total78) 
                          );                               
            break;
            case 2:
                $sql1 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3');";
                $sql2 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  not in ('1','3');";
                $numi1 = \Yii::$app->db1->createCommand($sql1)->queryScalar();
                $numo1 = \Yii::$app->db1->createCommand($sql2)->queryScalar();
                $total1 = $numi1 + $numo1;
                $rawData[] = array(
                    'id' => 1,
                    'pname' => '1.&nbsp;&nbsp;จำนวนผู้ป่วยความดันทั้งหมด',
                             'numi'=>@number_format($numi1),
                             'numo'=>@number_format($numo1),
                             'total'=>@number_format($total1) 
                );  
               $sql3="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='001');"; 
               $sql4="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='001');"; 
                          $numi2=\Yii::$app->db1->createCommand($sql3)->queryScalar();    
                          $numo2=\Yii::$app->db1->createCommand($sql4)->queryScalar();    
                          $total2=$numi2+$numo2;                 
                $rawData[] = array(
                    'id' => 2,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;1.1&nbsp;&nbsp;จำนวนผู้ป่วยความดันอย่างเดียว รายใหม่',
                             'numi'=>@number_format($numi2),
                             'numo'=>@number_format($numo2),
                             'total'=>@number_format($total2) 
                );
               $sql5="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}'  
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='001');"; 
               $sql6="select count(*) cc
                            from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id not in ('1','3') 
                            and c.hn not in (select hn from clinicmember where clinic='001');"; 
                          $numi3=\Yii::$app->db1->createCommand($sql5)->queryScalar();    
                          $numo3=\Yii::$app->db1->createCommand($sql6)->queryScalar();    
                          $total3=$numi3+$numo3;                   
                $rawData[] = array(
                    'id' => 3,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;1.2&nbsp;&nbsp;จำนวนผู้ป่วยความดันอย่างเดียว รายเก่า',
                             'numi'=>@number_format($numi3),
                             'numo'=>@number_format($numo3),
                             'total'=>@number_format($total3) 
                );   
            $sql7="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between '{$date1}' and '{$date2}'
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id  in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";
            $sql8="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate between '{$date1}' and '{$date2}'
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";
                          $numi4=\Yii::$app->db1->createCommand($sql7)->queryScalar();    
                          $numo4=\Yii::$app->db1->createCommand($sql8)->queryScalar();    
                          $total4=$numi4+$numo4;                                        
                $rawData[] = array(
                    'id' => 4,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;1.3&nbsp;&nbsp;จำนวนผู้ป่วยความดัน รายใหม่และเป็นผู้ป่วยเบาหวานร่วม',
                             'numi'=>@number_format($numi4),
                             'numo'=>@number_format($numo4),
                             'total'=>@number_format($total4) 
                );
            $sql9="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id  in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";
            $sql10="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate < '{$date1}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";
                          $numi5=\Yii::$app->db1->createCommand($sql9)->queryScalar();    
                          $numo5=\Yii::$app->db1->createCommand($sql10)->queryScalar();    
                          $total5=$numi5+$numo5;                 
                $rawData[] = array(
                    'id' => 5,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;1.4&nbsp;&nbsp;จำนวนผู้ป่วยความดัน รายเก่าและเป็นผู้ป่วยเบาหวานร่วม',
                             'numi'=>@number_format($numi5),
                             'numo'=>@number_format($numo5),
                             'total'=>@number_format($total5) 
                );
                $sql11 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3');";
                $sql12 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  not in ('1','3');";
                $numi6 = \Yii::$app->db1->createCommand($sql11)->queryScalar();
                $numo6 = \Yii::$app->db1->createCommand($sql12)->queryScalar();
                $total6 = $numi6 + $numo6;                
                $rawData[] = array(
                    'id' => 6,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;1.5&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ยังรักษาอยู่',
                             'numi'=>@number_format($numi6),
                             'numo'=>@number_format($numo6),
                             'total'=>@number_format($total6) 
                ); 
            $sql13="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id  in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";
            $sql14="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic,c.with_insulin
                                     from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";
                          $numi7=\Yii::$app->db1->createCommand($sql13)->queryScalar();    
                          $numo7=\Yii::$app->db1->createCommand($sql14)->queryScalar();    
                          $total7=$numi7+$numo7;                  
                $rawData[] = array(
                    'id' => 7,
                    'pname' => '2.&nbsp;&nbsp;จำนวนผู้ป่วยความดันและเบาหวาน(เป็นทั้ง 2 โรค)',
                             'numi'=>@number_format($numi7),
                             'numo'=>@number_format($numo7),
                             'total'=>@number_format($total7) 
                );  
        $sql15="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join person p on c.hn=p.patient_hn 
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                and p.house_regist_type_id  in ('1','3')  order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn  group by a.hn;";  
        $sql16="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join person p on c.hn=p.patient_hn 
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                and p.house_regist_type_id not in ('1','3')  order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn  group by a.hn;";      
               $numi8=\Yii::$app->db1->createCommand($sql15)->query()->rowCount;    
               $numo8=\Yii::$app->db1->createCommand($sql16)->query()->rowCount;    
               $total8=$numi8+$numo8;                               
                $rawData[] = array(
                    'id' => 8,
                    'pname' => '3.&nbsp;&nbsp;จำนวนผู้ป่วยความดันโลหิตสูงที่มารับบริการในช่วงเวลาที่กำหนดและได้วัดความดันโลหิต(คน)',
                    'numi'=>@number_format($numi8),
                    'numo'=>@number_format($numo8),
                    'total'=>@number_format($total8) 
                );
        $sql17="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn,o.bps,o.bpd from clinicmember c inner join person p on c.hn=p.patient_hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between '{$date1}' and '{$date2}' 
                                       and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                       and p.house_regist_type_id  in ('1','3') and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                              where o.bps<140 and o.bpd<90;"; 
        $sql18="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn,o.bps,o.bpd from clinicmember c inner join person p on c.hn=p.patient_hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between '{$date1}' and '{$date2}' 
                                       and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                       and p.house_regist_type_id not in ('1','3') and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                              where o.bps<140 and o.bpd<90;";  
               $numi9=\Yii::$app->db1->createCommand($sql17)->queryScalar();    
               $numo9=\Yii::$app->db1->createCommand($sql18)->queryScalar();    
               $total9=$numi9+$numo9;                                        
                $rawData[] = array(
                    'id' => 9,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;3.1&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่มีระดับความดันโลหิตครั้งล่าสุดอยู่ในเกณฑ์
                                     ที่ควบคุมได้(SBP<140,DBP<90 mmHg)(คน)',
                    'numi'=>@number_format($numi9),
                    'numo'=>@number_format($numo9),
                    'total'=>@number_format($total9) 
                );
        $sql19="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join person p on c.hn=p.patient_hn 
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                and p.house_regist_type_id  in ('1','3')  order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn ;";  
        $sql20="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join person p on c.hn=p.patient_hn 
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                and p.house_regist_type_id not in ('1','3')  order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn ;";    
               $numi10=\Yii::$app->db1->createCommand($sql19)->queryScalar();    
               $numo10=\Yii::$app->db1->createCommand($sql20)->queryScalar();    
               $total10=$numi10+$numo10;                              
                $rawData[] = array(
                    'id' => 10,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;3.2&nbsp;&nbsp;จำนวนครั้งที่มารับบริการและได้รับการวัดความดันโลหิต',
                    'numi'=>@number_format($numi10),
                    'numo'=>@number_format($numo10),
                    'total'=>@number_format($total10) 
                );
        $sql21="select count(*) cc
                        from ( 
                            select a.hn,b.vn,b.vstdate,b.bps,b.bpd
                                 from 
                                     (select c.hn,c.clinic from clinicmember c inner join person p on c.hn=p.patient_hn 
                                    where  c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                     and p.house_regist_type_id  in ('1','3')  order by c.hn
                             ) as a
                             inner join
                                    (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                                        and bps>0 and bpd>0
                             ) as b  on a.hn=b.hn
                        ) as c
                        inner join opdscreen o on o.vn=c.vn where  o.bps<140 and o.bpd<90;";    
        $sql22="select count(*) cc
                        from ( 
                            select a.hn,b.vn,b.vstdate,b.bps,b.bpd
                                 from 
                                     (select c.hn,c.clinic from clinicmember c inner join person p on c.hn=p.patient_hn 
                                    where  c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                     and p.house_regist_type_id not in ('1','3')  order by c.hn
                             ) as a
                             inner join
                                    (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                                        and bps>0 and bpd>0
                             ) as b  on a.hn=b.hn
                        ) as c
                        inner join opdscreen o on o.vn=c.vn where  o.bps<140 and o.bpd<90;";         
               $numi11=\Yii::$app->db1->createCommand($sql21)->queryScalar();    
               $numo11=\Yii::$app->db1->createCommand($sql22)->queryScalar();    
               $total11=$numi11+$numo11;                                       
                $rawData[] = array(
                    'id' => 11,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;3.3&nbsp;&nbsp;จำนวนครั้งที่มารับบริการและได้รับการวัดความดันโลหิตและ
                                    และค่าความดันอยู่ในเกณฑ์ที่ควบคุมได้(SBP<140,DBP<90 mmHg)',
                    'numi'=>@number_format($numi11),
                    'numo'=>@number_format($numo11),
                    'total'=>@number_format($total11) 
                ); 
        $sql23="select count(*) cc
                             from 
                                (select c.hn,c.clinic from clinicmember c inner join person p on c.hn=p.patient_hn 
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                and p.house_regist_type_id  in ('1','3')  order by c.hn
                             ) as a
                             inner join
                                (select hn,vn,bps,bpd,vstdate,pe from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                             ) as b  on a.hn=b.hn
                             inner join clinic_visit v on b.vn=v.vn where v.clinic='002' and v.visit_type in (1,2);";   
        $sql24="select count(*) cc
                             from 
                                (select c.hn,c.clinic from clinicmember c inner join person p on c.hn=p.patient_hn 
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                and p.house_regist_type_id not in ('1','3')  order by c.hn
                             ) as a
                             inner join
                                (select hn,vn,bps,bpd,vstdate,pe from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                             ) as b  on a.hn=b.hn
                             inner join clinic_visit v on b.vn=v.vn where v.clinic='002' and v.visit_type in (1,2);";   
               $numi12=\Yii::$app->db1->createCommand($sql23)->queryScalar();    
               $numo12=\Yii::$app->db1->createCommand($sql24)->queryScalar();    
               $total12=$numi12+$numo12;                                    
                $rawData[] = array(
                    'id' => 12,
                    'pname' => '4.&nbsp;&nbsp;การได้รับการตรวจร่างกายประจำปี(คน)',
                    'numi'=>@number_format($numi12),
                    'numo'=>@number_format($numo12),
                    'total'=>@number_format($total12) 
                );    
        $sql25="select  count(*) cc
                        from
                            (select a.hn,b.vn,b.lab_order_number,b.code,b.cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn order by b.hn
                        ) as c 
                        inner join 
                                 (select l.vn,group_concat(lo.lab_items_code) code,count(*) cc from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number  
                                    where lo.lab_items_code in  ('92','78','486') group by lo.lab_order_number having cc>=3
                        ) as d
                       on c.vn=d.vn;";   
        $sql26="select  count(*) cc
                        from
                            (select a.hn,b.vn,b.lab_order_number,b.code,b.cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn order by b.hn
                        ) as c 
                        inner join 
                                 (select l.vn,group_concat(lo.lab_items_code) code,count(*) cc from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number  
                                    where lo.lab_items_code in  ('92','78','486') group by lo.lab_order_number having cc>=3
                        ) as d
                       on c.vn=d.vn;";   
               $numi13=\Yii::$app->db1->createCommand($sql25)->queryScalar();    
               $numo13=\Yii::$app->db1->createCommand($sql26)->queryScalar();    
               $total13=$numi13+$numo13;                                      
                $rawData[] = array(
                    'id' => 13,
                    'pname' => '5.&nbsp;&nbsp;การได้รับการตรวจทางห้องปฎิบัติการประจำปี(Electrolyte,LDL,Cr,Urine Albumin(Macroalbumin))(คน)',
                    'numi'=>@number_format($numi13),
                    'numo'=>@number_format($numo13),
                    'total'=>@number_format($total13) 
                );  
        $sql27="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";   
        $sql28="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";    
               $numi14=\Yii::$app->db1->createCommand($sql27)->query()->rowCount;    
               $numo14=\Yii::$app->db1->createCommand($sql28)->query()->rowCount;    
               $total14=$numi14+$numo14;                                        
                $rawData[] = array(
                    'id' => 14,
                    'pname' => '6.&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจ Electrolyte(คน)',
                    'numi'=>@number_format($numi14),
                    'numo'=>@number_format($numo14),
                    'total'=>@number_format($total14) 
                );
        $sql29="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";   
        $sql30="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";    
               $numi15=\Yii::$app->db1->createCommand($sql29)->query()->rowCount;    
               $numo15=\Yii::$app->db1->createCommand($sql30)->query()->rowCount;    
               $total15=$numi15+$numo15;                    
                $rawData[] = array(
                    'id' => 15,
                    'pname' => '7.&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจ Lipid Profile(คน)',
                    'numi'=>@number_format($numi15),
                    'numo'=>@number_format($numo15),
                    'total'=>@number_format($total15) 
                );
        $sql31="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' group by c.hn  order by c.hn;";        
        $sql32="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' group by c.hn  order by c.hn;"; 
               $numi16=\Yii::$app->db1->createCommand($sql31)->query()->rowCount;    
               $numo16=\Yii::$app->db1->createCommand($sql32)->query()->rowCount;    
               $total16=$numi16+$numo16;                                       
                $rawData[] = array(
                    'id' => 16,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;7.1&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจ LDL (คน)',
                    'numi'=>@number_format($numi16),
                    'numo'=>@number_format($numo16),
                    'total'=>@number_format($total16) 
                ); 
        $sql33="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92'and lo.lab_order_result<100 group by c.hn order by c.hn;";        
        $sql34="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' and lo.lab_order_result<100 group by c.hn order by c.hn;"; 
               $numi17=\Yii::$app->db1->createCommand($sql33)->query()->rowCount;    
               $numo17=\Yii::$app->db1->createCommand($sql34)->query()->rowCount;    
               $total17=$numi17+$numo17;                      
                $rawData[] = array(
                    'id' => 17,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;7.2&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจ LDL และมีค่า <100 mg/dl(คน)',
                    'numi'=>@number_format($numi17),
                    'numo'=>@number_format($numo17),
                    'total'=>@number_format($total17) 
                );
        $sql35="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92';";        
        $sql36="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92';"; 
               $numi18=\Yii::$app->db1->createCommand($sql35)->queryScalar();    
               $numo18=\Yii::$app->db1->createCommand($sql36)->queryScalar();    
               $total18=$numi18+$numo18;                    
                $rawData[] = array(
                    'id' => 18,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;7.3&nbsp;&nbsp;จำนวนครั้งของผู้ป่วยความดันที่ได้รับการตรวจ LDL',
                    'numi'=>@number_format($numi18),
                    'numo'=>@number_format($numo18),
                    'total'=>@number_format($total18) 
                ); 
        $sql37="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' and lo.lab_order_result<100 ;";        
        $sql38="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92'  and lo.lab_order_result<100 ;"; 
               $numi19=\Yii::$app->db1->createCommand($sql37)->queryScalar();    
               $numo19=\Yii::$app->db1->createCommand($sql38)->queryScalar();    
               $total19=$numi19+$numo19;                     
                $rawData[] = array(
                    'id' => 19,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;7.4&nbsp;&nbsp;จำนวนครั้งของผู้ป่วยความดันที่ได้รับการตรวจ LDL และมีค่า <100 mg/dl',
                    'numi'=>@number_format($numi19),
                    'numo'=>@number_format($numo19),
                    'total'=>@number_format($total19) 
                );
        $sql39="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>0 
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;"; 
        $sql40="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>0 
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";   
               $numi20=\Yii::$app->db1->createCommand($sql39)->query()->rowCount;    
               $numo20=\Yii::$app->db1->createCommand($sql40)->query()->rowCount;    
               $total20=$numi20+$numo20;                                         
                $rawData[] = array(
                    'id' => 20,
                    'pname' => '8.&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจ Creatinine (คน)',
                    'numi'=>@number_format($numi20),
                    'numo'=>@number_format($numo20),
                    'total'=>@number_format($total20) 
                );
        $sql41="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') and p.sex='2'
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.4
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";
        $sql42="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') and p.sex='2'
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.4
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";  
               $numi21=\Yii::$app->db1->createCommand($sql41)->query()->rowCount;    
               $numo21=\Yii::$app->db1->createCommand($sql42)->query()->rowCount;    
               $total21=$numi21+$numo21;                                       
                $rawData[] = array(
                    'id' => 21,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;8.1&nbsp;&nbsp;จำนวนผู้ป่วยความดันเพศหญิงที่มี Creatinine>=1.4 (คน)',
                    'numi'=>@number_format($numi21),
                    'numo'=>@number_format($numo21),
                    'total'=>@number_format($total21) 
                ); 
        $sql43="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') and p.sex='1'
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.5
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";
        $sql44="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') and p.sex='1'
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.5
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";  
               $numi22=\Yii::$app->db1->createCommand($sql43)->query()->rowCount;    
               $numo22=\Yii::$app->db1->createCommand($sql44)->query()->rowCount;    
               $total22=$numi22+$numo22;                  
                $rawData[] = array(
                    'id' => 22,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;8.2&nbsp;&nbsp;จำนวนผู้ป่วยความดันเพศชายที่มี Creatinine>=1.5 (คน)',
                    'numi'=>@number_format($numi22),
                    'numo'=>@number_format($numo22),
                    'total'=>@number_format($total22) 
                ); 
        $sql45="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('486')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='')
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;"; 
        $sql46="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('486')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='')
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";  
               $numi23=\Yii::$app->db1->createCommand($sql45)->query()->rowCount;    
               $numo23=\Yii::$app->db1->createCommand($sql46)->query()->rowCount;    
               $total23=$numi23+$numo23;                                       
                $rawData[] = array(
                    'id' => 23,
                    'pname' => '9.&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจ Urine Protient (คน)',
                    'numi'=>@number_format($numi23),
                    'numo'=>@number_format($numo23),
                    'total'=>@number_format($total23) 
                );
        $sql47="select count(*) cc
                        from                
                             (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                        where lo.lab_items_code in ('1030')
                        ) as d  on c.vn=d.vn ;";        
        $sql48="select count(*) cc
                        from                
                             (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                        where lo.lab_items_code in ('1030')
                        ) as d  on c.vn=d.vn ;";   
               $numi24=\Yii::$app->db1->createCommand($sql47)->queryScalar();    
               $numo24=\Yii::$app->db1->createCommand($sql48)->queryScalar();    
               $total24=$numi24+$numo24;                                       
                $rawData[] = array(
                    'id' => 24,
                    'pname' => '10.&nbsp;&nbsp;ผู้ป่วยความดันโลหิตที่มีภาวะแทรกซ้อนทางไต(CKD-EPI) (คน)',
                    'numi'=>@number_format($numi24),
                    'numo'=>@number_format($numo24),
                    'total'=>@number_format($total24) 
                );    
        $sql49="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result>=90;";      
        $sql50="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result>=90;";    
               $numi25=\Yii::$app->db1->createCommand($sql49)->queryScalar();    
               $numo25=\Yii::$app->db1->createCommand($sql50)->queryScalar();    
               $total25=$numi25+$numo25;                                         
                $rawData[] = array(
                    'id' => 25,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;10.1&nbsp;&nbsp;ระยะที่ 1 (GFR>=90 ml/min)',
                    'numi'=>@number_format($numi25),
                    'numo'=>@number_format($numo25),
                    'total'=>@number_format($total25) 
                ); 
        $sql51="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 60 and 89;";      
        $sql52="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 60 and 89;";    
               $numi26=\Yii::$app->db1->createCommand($sql51)->queryScalar();    
               $numo26=\Yii::$app->db1->createCommand($sql52)->queryScalar();    
               $total26=$numi26+$numo26;                    
                $rawData[] = array(
                    'id' => 26,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;10.2&nbsp;&nbsp;ระยะที่ 2 (GFR 60-89 ml/min)',
                    'numi'=>@number_format($numi26),
                    'numo'=>@number_format($numo26),
                    'total'=>@number_format($total26) 
                ); 
        $sql53="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 30 and 59;";      
        $sql54="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 30 and 59;";    
               $numi27=\Yii::$app->db1->createCommand($sql53)->queryScalar();    
               $numo27=\Yii::$app->db1->createCommand($sql54)->queryScalar();    
               $total27=$numi27+$numo27;                    
                $rawData[] = array(
                    'id' => 27,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;10.3&nbsp;&nbsp;ระยะที่ 3 (GFR 30-59 ml/min)',
                    'numi'=>@number_format($numi27),
                    'numo'=>@number_format($numo27),
                    'total'=>@number_format($total27) 
                ); 
        $sql55="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 15 and 29;";      
        $sql56="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 15 and 29;";    
               $numi28=\Yii::$app->db1->createCommand($sql55)->queryScalar();    
               $numo28=\Yii::$app->db1->createCommand($sql56)->queryScalar();    
               $total28=$numi28+$numo28;                   
                $rawData[] = array(
                    'id' => 28,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;10.4&nbsp;&nbsp;ระยะที่ 4 (GFR 15-29 ml/min)',
                    'numi'=>@number_format($numi28),
                    'numo'=>@number_format($numo28),
                    'total'=>@number_format($total28) 
                );   
        $sql57="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result <15;";      
        $sql58="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result <15;";    
               $numi29=\Yii::$app->db1->createCommand($sql57)->queryScalar();    
               $numo29=\Yii::$app->db1->createCommand($sql58)->queryScalar();    
               $total29=$numi29+$numo29;                 
                $rawData[] = array(
                    'id' => 29,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;10.5&nbsp;&nbsp;ระยะที่ 5 (GFR<15 ml/min)',
                    'numi'=>@number_format($numi29),
                    'numo'=>@number_format($numo29),
                    'total'=>@number_format($total29) 
                );
        $sql59="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0
                             ) as b
                             on a.vn=b.vn group by a.hn order by b.hn;";   
        $sql60="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0
                             ) as b
                             on a.vn=b.vn group by a.hn order by b.hn;";    
               $numi30=\Yii::$app->db1->createCommand($sql59)->query()->rowCount;    
               $numo30=\Yii::$app->db1->createCommand($sql60)->query()->rowCount;    
               $total30=$numi30+$numo30;                                      
                $rawData[] = array(
                    'id' => 30,
                    'pname' => '11.&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจระดับน้ำตาลในเลือดแบบอดอาหาร(FBS) (คน)',
                    'numi'=>@number_format($numi30),
                    'numo'=>@number_format($numo30),
                    'total'=>@number_format($total30) 
                ); 
        $sql61="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result <100;";   
        $sql62="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result <100;";  
               $numi31=\Yii::$app->db1->createCommand($sql61)->queryScalar();    
               $numo31=\Yii::$app->db1->createCommand($sql62)->queryScalar();    
               $total31=$numi31+$numo31;                                        
                $rawData[] = array(
                    'id' => 31,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;11.1&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจระดับน้ำตาลในเลือดแบบอดอาหาร
                                     และม่ค่า<100 (คน)',
                    'numi'=>@number_format($numi31),
                    'numo'=>@number_format($numo31),
                    'total'=>@number_format($total31) 
                );  
        $sql63="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result between 100 and 125;";   
        $sql64="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result between 100 and 125;";  
               $numi32=\Yii::$app->db1->createCommand($sql63)->queryScalar();    
               $numo32=\Yii::$app->db1->createCommand($sql64)->queryScalar();    
               $total32=$numi32+$numo32;                   
                $rawData[] = array(
                    'id' => 32,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;11.2&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจระดับน้ำตาลในเลือดแบบอดอาหาร
                                     และม่ค่า 100-125 (คน)',
                    'numi'=>@number_format($numi32),
                    'numo'=>@number_format($numo32),
                    'total'=>@number_format($total32) 
                ); 
        $sql65="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result>=126;";   
        $sql66="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join person p 
                                    on c.hn=p.patient_hn where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.person_discharge_id='9' 
                                    and p.house_regist_type_id not in ('1','3') 
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result>=126;";  
               $numi33=\Yii::$app->db1->createCommand($sql65)->queryScalar();    
               $numo33=\Yii::$app->db1->createCommand($sql66)->queryScalar();    
               $total33=$numi32+$numo32;                  
                $rawData[] = array(
                    'id' => 33,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;11.3&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจระดับน้ำตาลในเลือดแบบอดอาหาร
                                     และม่ค่า >=126 (คน)',
                    'numi'=>@number_format($numi33),
                    'numo'=>@number_format($numo33),
                    'total'=>@number_format($total33) 
                ); 
        $sql67="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}' and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
        $sql68="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}' and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";          
               $numi34=\Yii::$app->db1->createCommand($sql67)->query()->rowCount;    
               $numo34=\Yii::$app->db1->createCommand($sql68)->query()->rowCount;    
               $total34=$numi34+$numo34;          
                $rawData[] = array(
                    'id' => 34,
                    'pname' => '12.&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจภาวะแทรกซ้อนของหลอดเลือดหัวใจ (คน)',
                    'numi'=>@number_format($numi34),
                    'numo'=>@number_format($numo34),
                    'total'=>@number_format($total34) 
                ); 
        $sql69="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where (do_cardiovascular_screen='Y' 
                                          or has_cardiovascular_cormobidity='Y')
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
        $sql70="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where (do_cardiovascular_screen='Y' 
                                          or has_cardiovascular_cormobidity='Y')
                             ) as b
                             on a.vn=b.vn group by a.hn;";          
               $numi35=\Yii::$app->db1->createCommand($sql69)->query()->rowCount;    
               $numo35=\Yii::$app->db1->createCommand($sql70)->query()->rowCount;    
               $total35=$numi35+$numo35;                 
                $rawData[] = array(
                    'id' => 35,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;12.1&nbsp;&nbsp;จำนวนคนที่พบภาวะแทรกซ้อนของหลอดเลือดหัวใจทั้งหมด (คน)',
                    'numi'=>@number_format($numi35),
                    'numo'=>@number_format($numo35),
                    'total'=>@number_format($total35) 
                );  
        $sql71="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y' 
                             ) as b
                             on a.vn=b.vn 
                              inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                             where cs.has_cardiovascular_cormobidity='Y' group by a.hn;";  
        $sql72="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y' 
                             ) as b
                             on a.vn=b.vn 
                             inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                             where cs.has_cardiovascular_cormobidity='Y' group by a.hn;";          
               $numi36=\Yii::$app->db1->createCommand($sql71)->query()->rowCount;    
               $numo36=\Yii::$app->db1->createCommand($sql72)->query()->rowCount;    
               $total36=$numi36+$numo36;                   
                $rawData[] = array(
                    'id' => 36,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;12.2&nbsp;&nbsp;จำนวนคนที่พบภาวะแทรกซ้อนของหลอดเลือดหัวใจ รายใหม่ (คน)',
                    'numi'=>@number_format($numi36),
                    'numo'=>@number_format($numo36),
                    'total'=>@number_format($total36) 
                );
        $sql73="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
        $sql74="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";   
               $numi37=\Yii::$app->db1->createCommand($sql73)->query()->rowCount;    
               $numo37=\Yii::$app->db1->createCommand($sql74)->query()->rowCount;    
               $total37=$numi37+$numo37;                                              
                $rawData[] = array(
                    'id' => 37,
                    'pname' => '13.&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการตรวจภาวะแทรกซ้อนของหลอดเลือดสมอง (คน)',
                    'numi'=>@number_format($numi37),
                    'numo'=>@number_format($numo37),
                    'total'=>@number_format($total37) 
                ); 
        $sql75="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                            and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
        $sql76="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                           and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";    
               $numi38=\Yii::$app->db1->createCommand($sql75)->query()->rowCount;    
               $numo38=\Yii::$app->db1->createCommand($sql76)->query()->rowCount;    
               $total38=$numi38+$numo38;                                              
                $rawData[] = array(
                    'id' => 38,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;13.1&nbsp;&nbsp;จำนวนคนที่พบภาวะแทรกซ้อนของหลอดเลือดสมองทั้งหมด (คน)',
                    'numi'=>@number_format($numi38),
                    'numo'=>@number_format($numo38),
                    'total'=>@number_format($total38) 
                );   
        $sql77="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                            and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
        $sql78="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                         and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                           and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";    
               $numi39=\Yii::$app->db1->createCommand($sql77)->query()->rowCount;    
               $numo39=\Yii::$app->db1->createCommand($sql78)->query()->rowCount;    
               $total39=$numi39+$numo39;                  
                $rawData[] = array(
                    'id' => 39,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;13.2&nbsp;&nbsp;จำนวนคนที่พบภาวะแทรกซ้อนของหลอดเลือดสมอง รายใหม่ (คน)',
                    'numi'=>@number_format($numi39),
                    'numo'=>@number_format($numo39),
                    'total'=>@number_format($total39) 
                ); 
        $sql79="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";   
        $sql80="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";    
               $numi40=\Yii::$app->db1->createCommand($sql79)->query()->rowCount;    
               $numo40=\Yii::$app->db1->createCommand($sql80)->query()->rowCount;    
               $total40=$numi40+$numo40;                                           
                $rawData[] = array(
                    'id' => 40,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;13.3&nbsp;&nbsp;กลุ่มปกติ(ผิดปกติ 0-1 ข้อ) (คน)',
                    'numi'=>@number_format($numi40),
                    'numo'=>@number_format($numo40),
                    'total'=>@number_format($total40) 
                ); 
        $sql81="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;";   
        $sql82="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;";    
               $numi41=\Yii::$app->db1->createCommand($sql81)->query()->rowCount;    
               $numo41=\Yii::$app->db1->createCommand($sql82)->query()->rowCount;    
               $total41=$numi41+$numo41;                 
                $rawData[] = array(
                    'id' => 41,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;13.4&nbsp;&nbsp;กลุ่มเสี่ยงสูง(ผิดปกติ 2 ข้อ) (คน)',
                    'numi'=>@number_format($numi41),
                    'numo'=>@number_format($numo41),
                    'total'=>@number_format($total41) 
                ); 
        $sql83="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;";   
        $sql84="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;";    
               $numi42=\Yii::$app->db1->createCommand($sql83)->query()->rowCount;    
               $numo42=\Yii::$app->db1->createCommand($sql84)->query()->rowCount;    
               $total42=$numi42+$numo42;                 
                $rawData[] = array(
                    'id' => 42,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;13.5&nbsp;&nbsp;กลุ่มเสี่ยงสูงปานกลาง(ผิดปกติ 3-5 ข้อ) (คน)',
                    'numi'=>@number_format($numi42),
                    'numo'=>@number_format($numo42),
                    'total'=>@number_format($total42) 
                );   
        $sql85="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id  in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;";   
        $sql86="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join person p on c.hn=p.patient_hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                        and p.house_regist_type_id not in ('1','3')
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;";    
               $numi43=\Yii::$app->db1->createCommand($sql85)->query()->rowCount;    
               $numo43=\Yii::$app->db1->createCommand($sql86)->query()->rowCount;    
               $total43=$numi43+$numo43;                    
                $rawData[] = array(
                    'id' => 43,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;13.6&nbsp;&nbsp;กลุ่มเสี่ยงสูงมาก(ผิดปกติ 6-9 ข้อ หรือ มีปัจจัยข้อ 8หรือ 9) (คน)',
                    'numi'=>@number_format($numi43),
                    'numo'=>@number_format($numo43),
                    'total'=>@number_format($total43) 
                ); 
        $sql87="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' 
                                                  and (lo.lab_order_result <> 0 or lo.lab_order_result is not null or lo.lab_order_result <> '')
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;";  
        $sql88="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' 
                                                  and (lo.lab_order_result <> 0 or lo.lab_order_result is not null or lo.lab_order_result <> '')
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;"; 
               $numi44=\Yii::$app->db1->createCommand($sql87)->query()->rowCount;    
               $numo44=\Yii::$app->db1->createCommand($sql88)->query()->rowCount;    
               $total44=$numi44+$numo44;              
                $rawData[] = array(
                    'id' => 44,
                    'pname' => '14.&nbsp;&nbsp;จำนวนคนที่ได้รับการตรวจภาวะแทรกซ้อนทางไต (คน)',
                    'numi'=>@number_format($numi44),
                    'numo'=>@number_format($numo44),
                    'total'=>@number_format($total44) 
                );   
        $sql89="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;";  
        $sql90="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60
                                                  
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;"; 
               $numi45=\Yii::$app->db1->createCommand($sql89)->query()->rowCount;    
               $numo45=\Yii::$app->db1->createCommand($sql90)->query()->rowCount;    
               $total45=$numi45+$numo45;                   
                $rawData[] = array(
                    'id' => 45,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;14.1&nbsp;&nbsp;จำนวนคนที่ตรวจพบภาวะแทรกซ้อนทางไตทั้งหมด (คน)',
                    'numi'=>@number_format($numi45),
                    'numo'=>@number_format($numo45),
                    'total'=>@number_format($total45) 
                ); 
        $sql91="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}' and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60
                                     ) as b     
                                     on a.vn=b.vn
                                    inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                                    where cs.has_kidney_cormobidity='Y' group by a.hn;";                                     
        $sql92="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}' and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3')
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60
                                                  
                                     ) as b    
                                     on a.vn=b.vn 
                                    inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                                    where cs.has_kidney_cormobidity='Y' group by a.hn;"; 
               $numi46=\Yii::$app->db1->createCommand($sql91)->query()->rowCount;    
               $numo46=\Yii::$app->db1->createCommand($sql92)->query()->rowCount;    
               $total46=$numi46+$numo46;                  
                $rawData[] = array(
                    'id' => 46,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;14.2&nbsp;&nbsp;จำนวนคนที่ตรวจพบภาวะแทรกซ้อนทางไต รายใหม่ (คน)',
                    'numi'=>@number_format($numi46),
                    'numo'=>@number_format($numo46),
                    'total'=>@number_format($total46) 
                );   
        $sql93="select count(*) cc from referout where refer_date between '{$date1}'  and '{$date2}' and pre_diagnosis='HT';";   
                          $total47=\Yii::$app->db1->createCommand($sql93)->queryScalar();                 
                $rawData[] = array(
                    'id' => 47,
                    'pname' => '15.&nbsp;&nbsp;จำนวนผู้ป่วยที่ รพ. ส่งกลับ รพ.สต.(ความดัน) (คน)',
                    'numi' =>'-',
                    'numo' =>'-',
                    'total' =>$total47
                ); 
        $sql94="select count(*) cc from referout where refer_date between '{$date1}'  and '{$date2}' and pre_diagnosis='DMHT';";   
                          $total48=\Yii::$app->db1->createCommand($sql94)->queryScalar();                    
                $rawData[] = array(
                    'id' => 48,
                    'pname' => '16.&nbsp;&nbsp;จำนวนผู้ป่วยที่ รพ. ส่งกลับ รพ.สต.(เบาหวาน-ความดัน) (คน)',
                    'numi' =>'-',
                    'numo' =>'-',
                    'total' =>$total48
                ); 
        $sql95="select  count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3') and o.smoking_type_id in ('2','5') group by o.hn;";   
        $sql96="select  count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3') and o.smoking_type_id in ('2','5') group by o.hn;";     
               $numi49=\Yii::$app->db1->createCommand($sql95)->query()->rowCount;    
               $numo49=\Yii::$app->db1->createCommand($sql96)->query()->rowCount;    
               $total49=$numi49+$numo49;                                                      
                $rawData[] = array(
                    'id' => 49,
                    'pname' => '17.&nbsp;&nbsp;จำนวนผู้ป่วยความดันสูบบุหรี่ (คน)',
                    'numi'=>@number_format($numi49),
                    'numo'=>@number_format($numo49),
                    'total'=>@number_format($total49) 
                ); 
        $sql97="select  count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id  in ('1','3') and o.smoking_type_id in ('5') group by o.hn;";   
        $sql98="select  count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn 
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                                           and p.house_regist_type_id not in ('1','3') and o.smoking_type_id in ('5') group by o.hn;";     
               $numi50=\Yii::$app->db1->createCommand($sql97)->query()->rowCount;    
               $numo50=\Yii::$app->db1->createCommand($sql98)->query()->rowCount;    
               $total50=$numi50+$numo50;                   
               $rawData[] = array(
                    'id' => 50,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;17.1&nbsp;&nbsp;มีการได้รับคำแนะนำปรึกษาให้เลิกสูบบุหรี่ (คน)',
                    'numi'=>@number_format($numi50),
                    'numo'=>@number_format($numo50),
                    'total'=>@number_format($total50) 
                );  
                $rawData[] = array(
                    'id' => 51,
                    'pname' => '18.&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการปรับเปลี่ยน 3อ2ส. (คน)',
                    'numi' =>'-',
                    'numo' =>'-',
                    'total' =>'-'
                );                                                 
            break;  
            case 3:
                $sql1 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='004' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  in ('1','3');";
                $sql2 = "select count(*) cc from clinicmember c inner join person p on c.hn=p.patient_hn where c.regdate <= '{$date2}' 
                            and c.clinic='004' and c.clinic_member_status_id in ('3','11') and p.person_discharge_id='9' 
                            and p.house_regist_type_id  not in ('1','3');";
                $numi1 = \Yii::$app->db1->createCommand($sql1)->queryScalar();
                $numo1 = \Yii::$app->db1->createCommand($sql2)->queryScalar();
                $total1 = $numi1 + $numo1;
                $rawData[] = array(
                    'id' => 1,
                    'pname' => '1.&nbsp;&nbsp;จำนวนผู้ป่วยโรคหลอดเลือดสมองทั้งหมด (คน)',
                    'numi'=>@number_format($numi1),
                    'numo'=>@number_format($numo1),
                    'total'=>@number_format($total1) 
                ); 
                $rawData[] = array(
                    'id' => 2,
                    'pname' => '2.&nbsp;&nbsp;จำนวนผู้ป่วยโรคหลอดเลือดสมองอุดตันหรือตีบ (คน)',
                    'numi' =>'',
                    'numo' =>'',
                    'total' =>''
                );                 
               $rawData[] = array(
                    'id' => 3,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;2.1&nbsp;&nbsp;จำนวนผู้ป่วยโรคหลอดเลือดสมองอุดตันหรือตีบ รายใหม่',
                    'numi' =>'',
                    'numo' =>'',
                    'total' =>''
                );                  
               $rawData[] = array(
                    'id' => 4,
                    'pname' => '&nbsp;&nbsp;&nbsp;&nbsp;2.2&nbsp;&nbsp;จำนวนผู้ป่วยโรคหลอดเลือดสมองอุดตันหรือตีบ รายเก่า',
                    'numi' =>'',
                    'numo' =>'',
                    'total' =>''
                );  
                $rawData[] = array(
                    'id' => 5,
                    'pname' => '3.&nbsp;&nbsp;จำนวนผู้ป่วยโรคหลอดเลือดสมองอุดตันได้รับยาต้านเกล็ดเลือดหรือยาละลายลิ่มเลือด ทั้งหมด',
                    'numi' =>'',
                    'numo' =>'',
                    'total' =>''
                );                                              
            break;    
            default:
            break;
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 80,
                ],
        ]);           
        return $this -> render('/site/ncd/clinic6-preview',['dataProvider' => $dataProvider,'names' => $names,'mText' => $this->mText,
                            'date1'=>$date1,'date2'=>$date2,'clinic_n'=>$clinic_n]);          
    }    
    public function actionClinic7Index() {
        $model = new Formmodel();       
        $names=" รายงานผลการดำเนินงานผู้ป่วยโรคเรื้อรัง(ไม่อิงบัญชี 1)";
        if($model->load(Yii::$app->request->post())){
            $date1 = $model->date1; 
            $date2 = $model->date2;             
            $clinic = Yii::$app->request->post('clinic');    
            return $this->redirect(['clinic7_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'c'=>$clinic]);
        }
            return $this -> render('/site/ncd/clinic7-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    } 
    public function actionClinic7_preview($name,$d1,$d2,$c) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $clinic=  explode(',',$c);$clinic_c=$clinic[0];$clinic_n=$clinic[1];
        $rawData=array();    
        switch ($clinic_c) {
            case 1:
               $sql1 = "select  count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11')  
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  
                                    or p.moopart in ('','0','00'))) or
                            (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or 
                                   p.moopart in ('','0','00')))) ;";
                $sql2 = "select  count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11')  and concat(p.chwpart,p.amppart) ='3104';";
                $sql3 = "select  count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and concat(p.chwpart,p.amppart) !='3104';";                
                $numh1 = \Yii::$app->db1->createCommand($sql1)->queryScalar();
                $numi1 = \Yii::$app->db1->createCommand($sql2)->queryScalar();                
                $numo1 = \Yii::$app->db1->createCommand($sql3)->queryScalar();
                $total1 = $numh1+$numi1+$numo1;
                $rawData[] = array(
                        'id' => 1,
                        'pname' => '1. จำนวนผู้ป่วยเบาหวานทั้งหมด',
                        'numh' => @number_format($numh1),
                        'numi' => @number_format($numi1),                    
                        'numo' => @number_format($numo1),
                        'total' => @number_format($total1)
                );
                $sql4="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11')   
                          and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28' 
                             or p.moopart in ('','0','00'))) or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                             and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))) 
                             and c.hn not in (select hn from clinicmember where clinic='002') ;";
                $sql5="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11')  
                          and concat(p.chwpart,p.amppart) ='3104' and c.hn not in (select hn from clinicmember where clinic='002') ;";    
                $sql6="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11')   
                          and concat(p.chwpart,p.amppart) !='3104' and c.hn not in (select hn from clinicmember where clinic='002') ;";                   
                $numh2 = \Yii::$app->db1->createCommand($sql4)->queryScalar();
                $numi2 = \Yii::$app->db1->createCommand($sql5)->queryScalar();                
                $numo2 = \Yii::$app->db1->createCommand($sql6)->queryScalar();
                $total2 = $numh2+$numi2+$numo2;
               $rawData[]=array(                              
                        'id'=>2,
                        'pname'=>'1.1    จำนวนผู้ป่วยบาหวานอย่างเดียว รายใหม่',
                        'numh' => @number_format($numh2),
                        'numi' => @number_format($numi2),                    
                        'numo' => @number_format($numo2),
                        'total' => @number_format($total2)
                );                 
               $sql7="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='1' 
                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28' or p.moopart in ('','0','00')))
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00')))) and c.hn not in (select hn from clinicmember where clinic='002') ;";
               $sql8="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='1' 
                          and concat(p.chwpart,p.amppart)='3104' and c.hn not in (select hn from clinicmember where clinic='002');";
               $sql9="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='1' 
                          and concat(p.chwpart,p.amppart) !='3104' and c.hn not in (select hn from clinicmember where clinic='002');";                
               $numh3 = \Yii::$app->db1->createCommand($sql7)->queryScalar();
               $numi3 = \Yii::$app->db1->createCommand($sql8)->queryScalar();                
               $numo3 = \Yii::$app->db1->createCommand($sql9)->queryScalar();
               $total3 = $numh3+$numi3+$numo3;                
               $rawData[]=array(
                        'id'=>3,
                        'pname'=>'1.1.1  Type I',
                        'numh' => @number_format($numh3),
                        'numi' => @number_format($numi3),                    
                        'numo' => @number_format($numo3),
                        'total' => @number_format($total3)
               );  
               $sql10="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='2' 
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00')))) and c.hn not in (select hn from clinicmember where clinic='002') ;";
               $sql11="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='2' 
                          and concat(p.chwpart,p.amppart)='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";
               $sql12="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='2' 
                          and concat(p.chwpart,p.amppart) !='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";                
               $numh4 = \Yii::$app->db1->createCommand($sql10)->queryScalar();
               $numi4 = \Yii::$app->db1->createCommand($sql11)->queryScalar();                
               $numo4 = \Yii::$app->db1->createCommand($sql12)->queryScalar();
               $total4 = $numh4+$numi4+$numo4;                
               $rawData[]=array(
                        'id'=>4,
                        'pname'=>'1.1.2  Type II',
                        'numh' => @number_format($numh4),
                        'numi' => @number_format($numi4),                    
                        'numo' => @number_format($numo4),
                        'total' => @number_format($total4)
               );                 
               $sql13="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='3' 
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00')))) and c.hn not in (select hn from clinicmember where clinic='002') ;";
               $sql14="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='3' 
                          and concat(p.chwpart,p.amppart)='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";
               $sql15="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='3' 
                          and concat(p.chwpart,p.amppart) !='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";                
               $numh5 = \Yii::$app->db1->createCommand($sql13)->queryScalar();
               $numi5 = \Yii::$app->db1->createCommand($sql14)->queryScalar();                
               $numo5 = \Yii::$app->db1->createCommand($sql15)->queryScalar();
               $total5 = $numh5+$numi5+$numo5;                
               $rawData[]=array(
                        'id'=>5,
                        'pname'=>'1.1.3  Type GDM',
                        'numh' => @number_format($numh5),
                        'numi' => @number_format($numi5),                    
                        'numo' => @number_format($numo5),
                        'total' => @number_format($total5)
               );                
               $sql16="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='4' 
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00')))) and c.hn not in (select hn from clinicmember where clinic='002') ;";
               $sql17="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='4' 
                          and concat(p.chwpart,p.amppart)='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";
               $sql18="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='4' 
                          and concat(p.chwpart,p.amppart) !='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";                
               $numh6 = \Yii::$app->db1->createCommand($sql16)->queryScalar();
               $numi6 = \Yii::$app->db1->createCommand($sql17)->queryScalar();                
               $numo6 = \Yii::$app->db1->createCommand($sql18)->queryScalar();
               $total6 = $numh6+$numi6+$numo6;                
               $rawData[]=array(
                        'id'=>6,
                        'pname'=>'1.1.4  Type อื่นๆ',
                        'numh' => @number_format($numh6),
                        'numi' => @number_format($numi6),                    
                        'numo' => @number_format($numo6),
                        'total' => @number_format($total6)
               );                
               $sql19="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}'
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11')   
                          and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28' 
                             or p.moopart in ('','0','00'))) or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                             and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))) 
                             and c.hn not in (select hn from clinicmember where clinic='002') ;";
               $sql20="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11')  
                          and concat(p.chwpart,p.amppart) ='3104' and c.hn not in (select hn from clinicmember where clinic='002') ;";    
               $sql21="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11')   
                          and concat(p.chwpart,p.amppart) !='3104' and c.hn not in (select hn from clinicmember where clinic='002') ;";  
               $numh7 = \Yii::$app->db1->createCommand($sql19)->queryScalar();
               $numi7 = \Yii::$app->db1->createCommand($sql20)->queryScalar();                
               $numo7 = \Yii::$app->db1->createCommand($sql21)->queryScalar();
               $total7 = $numh7+$numi7+$numo7;                   
               $rawData[]=array(
                       'id'=>7,
                       'pname'=>'1.2 จำนวนผู้ป่วยบาหวานอย่างเดียว รายเก่า',
                        'numh' => @number_format($numh7),
                        'numi' => @number_format($numi7),                    
                        'numo' => @number_format($numo7),
                        'total' => @number_format($total7)
               );                
               $sql22="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='1' 
                             and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00')))) and c.hn not in (select hn from clinicmember where clinic='002') ;";
               $sql23="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='1' 
                          and concat(p.chwpart,p.amppart)='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";
               $sql24="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='1' 
                          and concat(p.chwpart,p.amppart) !='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";                
               $numh8 = \Yii::$app->db1->createCommand($sql22)->queryScalar();
               $numi8 = \Yii::$app->db1->createCommand($sql23)->queryScalar();                
               $numo8 = \Yii::$app->db1->createCommand($sql24)->queryScalar();
               $total8 = $numh8+$numi8+$numo8;                
              $rawData[]=array(
                        'id'=>8,
                        'pname'=>'1.2.1  Type I',
                        'numh' => @number_format($numh8),
                        'numi' => @number_format($numi8),                    
                        'numo' => @number_format($numo8),
                        'total' => @number_format($total8)
               );                 
               $sql25="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='2' 
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00')))) and c.hn not in (select hn from clinicmember where clinic='002') ;";
               $sql26="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='2' 
                          and concat(p.chwpart,p.amppart)='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";
               $sql27="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='2' 
                          and concat(p.chwpart,p.amppart) !='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";                
               $numh9 = \Yii::$app->db1->createCommand($sql25)->queryScalar();
               $numi9 = \Yii::$app->db1->createCommand($sql26)->queryScalar();                
               $numo9 = \Yii::$app->db1->createCommand($sql27)->queryScalar();
               $total9 = $numh9+$numi9+$numo9;                
              $rawData[]=array(
                        'id'=>9,
                        'pname'=>'1.2.2  Type II',
                        'numh' => @number_format($numh9),
                        'numi' => @number_format($numi9),                    
                        'numo' => @number_format($numo9),
                        'total' => @number_format($total9)
               );                
               $sql28="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='3' 
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00')))) and c.hn not in (select hn from clinicmember where clinic='002') ;";
               $sql29="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='3' 
                          and concat(p.chwpart,p.amppart)='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";
               $sql30="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='3' 
                          and concat(p.chwpart,p.amppart) !='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";                
               $numh10 = \Yii::$app->db1->createCommand($sql28)->queryScalar();
               $numi10 = \Yii::$app->db1->createCommand($sql29)->queryScalar();                
               $numo10 = \Yii::$app->db1->createCommand($sql30)->queryScalar();
               $total10 = $numh10+$numi10+$numo10;                
              $rawData[]=array(
                        'id'=>10,
                        'pname'=>'1.2.3  Type GDM',
                        'numh' => @number_format($numh10),
                        'numi' => @number_format($numi10),                    
                        'numo' => @number_format($numo10),
                        'total' => @number_format($total10)
               );                 
               $sql31="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='4' 
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00')))) and c.hn not in (select hn from clinicmember where clinic='002') ;";
               $sql32="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='4' 
                          and concat(p.chwpart,p.amppart)='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";
               $sql33="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                          and c.clinic='001' and c.clinic_member_status_id in ('3','11') and c.clinic_subtype_id='4' 
                          and concat(p.chwpart,p.amppart) !='3104'
                          and c.hn not in (select hn from clinicmember where clinic='002');";                
               $numh11 = \Yii::$app->db1->createCommand($sql31)->queryScalar();
               $numi11 = \Yii::$app->db1->createCommand($sql32)->queryScalar();                
               $numo11 = \Yii::$app->db1->createCommand($sql33)->queryScalar();
               $total11 = $numh11+$numi11+$numo11;                
              $rawData[]=array(
                        'id'=>11,
                        'pname'=>'1.2.4  Type อื่นๆ',
                        'numh' => @number_format($numh11),
                        'numi' => @number_format($numi11),                    
                        'numo' => @number_format($numo11),
                        'total' => @number_format($total11)
               );                
               $sql34="select  count(*) cc
                            from 
                                 (select c.hn,c.clinic
                                    from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00'))))
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";
               $sql35="select  count(*) cc
                            from 
                                  (select c.hn,c.clinic
                                    from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";
               $sql36="select  count(*) cc
                            from 
                                  (select c.hn,c.clinic
                                    from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";                                     
               $numh12 = \Yii::$app->db1->createCommand($sql34)->queryScalar();
               $numi12 = \Yii::$app->db1->createCommand($sql35)->queryScalar();                
               $numo12 = \Yii::$app->db1->createCommand($sql36)->queryScalar();
               $total12 = $numh12+$numi12+$numo12;                
               $rawData[]=array(
                        'id'=>12,
                        'pname'=>'1.3   จำนวนผู้ป่วยที่เป็นเบาหวาน รายใหม่ และเป็นผู้ป่วยความดันร่วม',
                        'numh' => @number_format($numh12),
                        'numi' => @number_format($numi12),                    
                        'numo' => @number_format($numo12),
                        'total' => @number_format($total12)
                );                
               $sql37="select  count(*) cc
                            from 
                                 (select c.hn,c.clinic
                                    from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                    or p.moopart in ('','0','00'))))
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";
               $sql38="select  count(*) cc
                            from 
                                  (select c.hn,c.clinic
                                    from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";
               $sql39="select  count(*) cc
                            from 
                                  (select c.hn,c.clinic
                                    from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";                                     
               $numh13 = \Yii::$app->db1->createCommand($sql37)->queryScalar();
               $numi13 = \Yii::$app->db1->createCommand($sql38)->queryScalar();                
               $numo13 = \Yii::$app->db1->createCommand($sql39)->queryScalar();
               $total13 = $numh13+$numi13+$numo13;                
               $rawData[]=array(
                        'id'=>13,
                        'pname'=>'1.4   จำนวนผู้ป่วยที่เป็นเบาหวาน รายเก่า และเป็นผู้ป่วยความดันร่วม',
                        'numh' => @number_format($numh13),
                        'numi' => @number_format($numi13),                    
                        'numo' => @number_format($numo13),
                        'total' => @number_format($total13)
                ); 
                $sql40 = "select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                             and c.clinic='001' and c.clinic_member_status_id in ('3')  
                             and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                             and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                             or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                             or p.moopart in ('','0','00')))) ;";
                $sql41 = "select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                             and c.clinic='001' and c.clinic_member_status_id in ('3') 
                             and concat(p.chwpart,p.amppart)='3104' ;"; 
                $sql42 = "select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                             and c.clinic='001' and c.clinic_member_status_id in ('3') 
                             and concat(p.chwpart,p.amppart) !='3104' ;";                    
               $numh14 = \Yii::$app->db1->createCommand($sql40)->queryScalar();
               $numi14 = \Yii::$app->db1->createCommand($sql41)->queryScalar();                
               $numo14 = \Yii::$app->db1->createCommand($sql42)->queryScalar();
               $total14 = $numh14+$numi14+$numo14;                
               $rawData[]=array(
                        'id'=>14,
                        'pname'=>'1.5   จำนวนผู้ป่วยที่เป็นเบาหวาน ที่ยังรักษาอยู่',
                        'numh' => @number_format($numh14),
                        'numi' => @number_format($numi14),                    
                        'numo' => @number_format($numo14),
                        'total' => @number_format($total14)
                );                

               $sql43="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                                     and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                     and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                     and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                     or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                     or p.moopart in ('','0','00'))))
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";
            $sql44="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                                     and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                     and concat(p.chwpart,p.amppart)='3104'                                    
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";
            $sql45="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                                     and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                     and concat(p.chwpart,p.amppart) !='3104'                                    
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='002') as b
                              on a.hn=b.hn;";                                     
               $numh15 = \Yii::$app->db1->createCommand($sql43)->queryScalar();
               $numi15 = \Yii::$app->db1->createCommand($sql44)->queryScalar();                
               $numo15 = \Yii::$app->db1->createCommand($sql45)->queryScalar();
               $total15 = $numh15+$numi15+$numo15;                
               $rawData[]=array(
                        'id'=>15,
                        'pname'=>'2.  จำนวนผู้ป่วยที่เป็นความดันและเบาหวาน(เป็นทั้ง 2 โรค)',
                        'numh' => @number_format($numh15),
                        'numi' => @number_format($numi15),                    
                        'numo' => @number_format($numo15),
                        'total' => @number_format($total15)
                          );                  
               
               $sql46="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' 
                           and c.clinic_member_status_id in ('3','11')  
                           and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                           and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                           or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                           or p.moopart in ('','0','00'))))  and lo.lab_items_code='76' and lo.lab_order_result>0 group by l.hn;";
               $sql47="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' 
                           and c.clinic_member_status_id in ('3','11')  
                           and concat(p.chwpart,p.amppart)='3104' and lo.lab_items_code='76' and lo.lab_order_result>0 group by l.hn;";      
               $sql48="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' 
                           and c.clinic_member_status_id in ('3','11')  
                           and concat(p.chwpart,p.amppart) !='3104' and lo.lab_items_code='76' and lo.lab_order_result>0 group by l.hn;";                            
               $numh16 = \Yii::$app->db1->createCommand($sql46)->query()->rowCount;  
               $numi16 = \Yii::$app->db1->createCommand($sql47)->query()->rowCount;                
               $numo16 = \Yii::$app->db1->createCommand($sql48)->query()->rowCount;  
               $total16 = $numh16+$numi16+$numo16;                
               $rawData[]=array(
                        'id'=>16,
                        'pname'=>'3.  จำนวนผู้ป่วยเบาหวานที่ได้รับการเจาะ Fasting Blood Sugar ทั้งหมด(คน)',
                        'numh' => @number_format($numh16),
                        'numi' => @number_format($numi16),                    
                        'numo' => @number_format($numo16),
                        'total' => @number_format($total16)
                );                                             
               $sql49="select  count(*) cc
                              from (select c.clinic,c.hn from clinicmember c inner join patient p on c.hn=p.hn 
                                    where  c.clinic='001' and c.clinic_member_status_id in ('3','11')                                           
			and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
			and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
			or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
			or p.moopart in ('','0','00')))) ) as c
                                inner join patient p on p.hn=c.hn          
                                inner join (select  hn,max(vn) vn from lab_head where receive_date between '{$date1}' and '{$date2}' group by hn)
                                     as l on c.hn=l.hn
                                inner join (select l.vn,lo.lab_order_result from lab_head l
                                inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                where lo.lab_items_code='76' and lo.lab_order_result between 70 and 130 ) 
                                as l1 on l1.vn=l.vn;";
               $sql50="select  count(*) cc
                              from (select c.clinic,c.hn from clinicmember c inner join patient p on c.hn=p.hn 
                                    where  c.clinic='001' and c.clinic_member_status_id in ('3','11') 
			and concat(p.chwpart,p.amppart)='3104') as c
                                inner join patient p on p.hn=c.hn          
                                inner join (select  hn,max(vn) vn from lab_head where receive_date between '{$date1}' and '{$date2}' group by hn)
                                     as l on c.hn=l.hn
                                inner join (select l.vn,lo.lab_order_result from lab_head l
                                inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                where lo.lab_items_code='76' and lo.lab_order_result between 70 and 130 ) 
                                as l1 on l1.vn=l.vn;";     
               $sql51="select  count(*) cc
                              from (select c.clinic,c.hn from clinicmember c inner join patient p on c.hn=p.hn 
                                    where  c.clinic='001' and c.clinic_member_status_id in ('3','11') 
			and concat(p.chwpart,p.amppart) !='3104') as c
                                inner join patient p on p.hn=c.hn          
                                inner join (select  hn,max(vn) vn from lab_head where receive_date between '{$date1}' and '{$date2}' group by hn)
                                     as l on c.hn=l.hn
                                inner join (select l.vn,lo.lab_order_result from lab_head l
                                inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                where lo.lab_items_code='76' and lo.lab_order_result between 70 and 130 ) 
                                as l1 on l1.vn=l.vn;";                                   
               $numh17 = \Yii::$app->db1->createCommand($sql49)->queryScalar();
               $numi17 = \Yii::$app->db1->createCommand($sql50)->queryScalar();                
               $numo17 = \Yii::$app->db1->createCommand($sql51)->queryScalar();   
               $total17 = $numh17+$numi17+$numo17;                
               $rawData[]=array(
                        'id'=>17,
                        'pname'=>'3.1   จำนวนผู้ป่วยเบาหวานที่ได้รับการเจาะ Fasting Blood Sugar อยู่ในเกณฑ์ที่ควบคุมได้ (70-130 mg/dl)(ครั้งล่าสุด คน)',
                        'numh' => @number_format($numh17),
                        'numi' => @number_format($numi17),                    
                        'numo' => @number_format($numo17),
                        'total' => @number_format($total17)
               );                               
               $sql52="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                            inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                             where l.receive_date between '{$date1}' and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
		and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
		and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
		or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
		or p.moopart in ('','0','00')))) and lo.lab_items_code='76' and lo.lab_order_result>0  ;";
               $sql53="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                            inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                             where l.receive_date between '{$date1}' and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
		and concat(p.chwpart,p.amppart)='3104' and lo.lab_items_code='76' and lo.lab_order_result>0  ;";   
               $sql54="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                            inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                             where l.receive_date between '{$date1}' and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
		and concat(p.chwpart,p.amppart) !='3104' and lo.lab_items_code='76' and lo.lab_order_result>0  ;";                              
               $numh18 = \Yii::$app->db1->createCommand($sql52)->queryScalar();
               $numi18 = \Yii::$app->db1->createCommand($sql53)->queryScalar();                
               $numo18 = \Yii::$app->db1->createCommand($sql54)->queryScalar();   
               $total18 = $numh18+$numi18+$numo18;                
               $rawData[]=array(
                        'id'=>18,
                        'pname'=>'3.2  จำนวนครั้งของผู้ป่วยเบาหวานที่ได้รับการเจาะ Fasting Blood Sugar',   
                        'numh' => @number_format($numh18),
                        'numi' => @number_format($numi18),                    
                        'numo' => @number_format($numo18),
                        'total' => @number_format($total18)                              
            );

              $sql55="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
		and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
		and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
		or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
		or p.moopart in ('','0','00')))) and lo.lab_items_code='76' and lo.lab_order_result between 70 and 130;";
              $sql56="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
		and concat(p.chwpart,p.amppart)='3104'
                             and lo.lab_items_code='76' and lo.lab_order_result between 70 and 130;";
              $sql57="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
		and concat(p.chwpart,p.amppart) !='3104'
                             and lo.lab_items_code='76' and lo.lab_order_result between 70 and 130;";       
                           
               $numh19 = \Yii::$app->db1->createCommand($sql55)->queryScalar();
               $numi19 = \Yii::$app->db1->createCommand($sql56)->queryScalar();                
               $numo19 = \Yii::$app->db1->createCommand($sql57)->queryScalar();   
               $total19 = $numh19+$numi19+$numo19;                
               $rawData[]=array(
                        'id'=>19,
                        'pname'=>'3.3   จำนวนครั้งของผู้ป่วยเบาหวานที่มีระดับ Fasting Blood Sugar อยู่ในเกณฑ์ที่ควบคุมได้ (70-130 mg/dl) ',
                        'numh' => @number_format($numh19),
                        'numi' => @number_format($numi19),                    
                        'numo' => @number_format($numo19),
                        'total' => @number_format($total19)  
                );                
               $sql58="select lo.lab_items_code,lo.lab_order_result from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
		and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
		and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
		or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
		or p.moopart in ('','0','00')))) and lo.lab_items_code='193' and lo.lab_order_result>0 group by l.hn;";
               $sql59="select lo.lab_items_code,lo.lab_order_result from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
		and concat(p.chwpart,p.amppart)='3104' and lo.lab_items_code='193' and lo.lab_order_result>0 group by l.hn;";  
               $sql60="select lo.lab_items_code,lo.lab_order_result from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
		and concat(p.chwpart,p.amppart) !='3104' and lo.lab_items_code='193' and lo.lab_order_result>0 group by l.hn;";                             
               $numh20 = \Yii::$app->db1->createCommand($sql58)->query()->rowCount;  
               $numi20 = \Yii::$app->db1->createCommand($sql59)->query()->rowCount;                
               $numo20 = \Yii::$app->db1->createCommand($sql60)->query()->rowCount;   
               $total20 = $numh20+$numi20+$numo20;                
               $rawData[]=array(
                        'id'=>20,
                        'pname'=>'4.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานมีการตรวจหาระดับ HbA1c ทั้งหมด (คน)',
                        'numh' => @number_format($numh20),
                        'numi' => @number_format($numi20),                    
                        'numo' => @number_format($numo20),
                        'total' => @number_format($total20)  
               );                   
               $sql61="select  count(*) cc
                           from (select c.clinic,c.hn from clinicmember c inner join patient p on c.hn=p.hn
                                      where  c.clinic='001' and c.clinic_member_status_id in ('3','11')      
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                            or p.moopart in ('','0','00')))) ) as c    
                            inner join (select  hn,max(vn) vn from lab_head where receive_date between '{$date1}'  and '{$date2}' group by hn)
                            as l on c.hn=l.hn
                            inner join (select l.vn,lo.lab_order_result from lab_head l
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                            where lo.lab_items_code='193' and lo.lab_order_result <7) 
                            as l1 on l1.vn=l.vn order by c.hn;";
               $sql62="select  count(*) cc
                           from (select c.clinic,c.hn from clinicmember c inner join patient p on c.hn=p.hn
                                      where  c.clinic='001' and c.clinic_member_status_id in ('3','11') and concat(p.chwpart,p.amppart)='3104' ) as c    
                            inner join (select  hn,max(vn) vn from lab_head where receive_date between '{$date1}'  and '{$date2}' group by hn)
                            as l on c.hn=l.hn
                            inner join (select l.vn,lo.lab_order_result from lab_head l
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                            where lo.lab_items_code='193' and lo.lab_order_result <7) 
                            as l1 on l1.vn=l.vn order by c.hn;";
               $sql63="select  count(*) cc
                           from (select c.clinic,c.hn from clinicmember c inner join patient p on c.hn=p.hn
                                      where  c.clinic='001' and c.clinic_member_status_id in ('3','11') and concat(p.chwpart,p.amppart) !='3104' ) as c    
                            inner join (select  hn,max(vn) vn from lab_head where receive_date between '{$date1}'  and '{$date2}' group by hn)
                            as l on c.hn=l.hn
                            inner join (select l.vn,lo.lab_order_result from lab_head l
                            inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                            where lo.lab_items_code='193' and lo.lab_order_result <7) 
                            as l1 on l1.vn=l.vn order by c.hn;";                            
               $numh21 = \Yii::$app->db1->createCommand($sql61)->queryScalar();
               $numi21 = \Yii::$app->db1->createCommand($sql62)->queryScalar();                
               $numo21 = \Yii::$app->db1->createCommand($sql63)->queryScalar();  
               $total21 = $numh21+$numi21+$numo21;                
               $rawData[]=array(
                        'id'=>21,
                        'pname'=>'4.1   จำนวนผู้ป่วยเบาหวานที่มีการตรวจหาระดับ HbA1c < 7% (ครั้งล่าสุด คน)',
                        'numh' => @number_format($numh21),
                        'numi' => @number_format($numi21),                    
                        'numo' => @number_format($numo21),
                        'total' => @number_format($total21)  
               );                               
               $sql64="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                             and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                             and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                             or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                             or p.moopart in ('','0','00')))) and lo.lab_items_code='193' and lo.lab_order_result>0;";
               $sql65="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                             and concat(p.chwpart,p.amppart)='3104' and lo.lab_items_code='193' and lo.lab_order_result>0;";
               $sql66="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between  '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                             and concat(p.chwpart,p.amppart) !='3104' and lo.lab_items_code='193' and lo.lab_order_result>0;";                           
               $numh22 = \Yii::$app->db1->createCommand($sql64)->queryScalar();
               $numi22 = \Yii::$app->db1->createCommand($sql65)->queryScalar();                
               $numo22 = \Yii::$app->db1->createCommand($sql66)->queryScalar();  
               $total22 = $numh22+$numi22+$numo22;                
               $rawData[]=array(
                        'id'=>22,
                        'pname'=>'4.2    จำนวนครั้งของผู้ป่วยเบาหวานมีการตรวจหาระดับ HbA1c',
                        'numh' => @number_format($numh22),
                        'numi' => @number_format($numi22),                    
                        'numo' => @number_format($numo22),
                        'total' => @number_format($total22)  
               ); 
               $sql67="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                             and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                             and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                             or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                             or p.moopart in ('','0','00')))) and lo.lab_items_code='193' and lo.lab_order_result<7;";
               $sql68="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                             and concat(p.chwpart,p.amppart)='3104' and lo.lab_items_code='193' and lo.lab_order_result<7;";
               $sql69="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                           inner join vn_stat v on v.hn=c.hn inner join lab_head l on l.vn=v.vn
                           inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                           where l.receive_date between '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                             and concat(p.chwpart,p.amppart) !='3104' and lo.lab_items_code='193' and lo.lab_order_result<7;";                           
               $numh23 = \Yii::$app->db1->createCommand($sql67)->queryScalar();
               $numi23 = \Yii::$app->db1->createCommand($sql68)->queryScalar();                
               $numo23 = \Yii::$app->db1->createCommand($sql69)->queryScalar();  
               $total23 = $numh23+$numi23+$numo23;                
               $rawData[]=array(
                        'id'=>23,
                        'pname'=>'4.3   จำนวนครั้งของผู้ป่วยเบาหวานมีการตรวจหาระดับ HbA1c < 7%',
                        'numh' => @number_format($numh23),
                        'numi' => @number_format($numi23),                    
                        'numo' => @number_format($numo23),
                        'total' => @number_format($total23) 
               );                
               $sql70="select count(*) cc from an_stat a left outer join patient p on p.hn=a.hn 
                             where a.dchdate between  '{$date1}'  and '{$date2}' and 
                             (a.pdx in ('E160','E100','E110','E101') or(a.pdx='E162' or a.dx0 between 'E10' and 'E149')) 
                             and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                             and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                             or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                             or p.moopart in ('','0','00'))));";
               $sql71="select count(*) cc from an_stat a left outer join patient p on p.hn=a.hn 
                             where a.dchdate between  '{$date1}'  and '{$date2}' and 
                             (a.pdx in ('E160','E100','E110','E101') or(a.pdx='E162' or a.dx0 between 'E10' and 'E149')) 
                             and concat(p.chwpart,p.amppart)='3104';";               
               $sql72="select count(*) cc from an_stat a left outer join patient p on p.hn=a.hn 
                             where a.dchdate between  '{$date1}'  and '{$date2}' and 
                             (a.pdx in ('E160','E100','E110','E101') or(a.pdx='E162' or a.dx0 between 'E10' and 'E149')) 
                             and concat(p.chwpart,p.amppart) !='3104';"; 
               $numh24 = \Yii::$app->db1->createCommand($sql70)->queryScalar();
               $numi24 = \Yii::$app->db1->createCommand($sql71)->queryScalar();                
               $numo24 = \Yii::$app->db1->createCommand($sql72)->queryScalar();  
               $total24 = $numh24+$numi24+$numo24;                
               $rawData[]=array(
                        'id'=>24,
                        'pname'=>'5.   การเข้ารักษาในโรงพยาบาลเนื่องจากภาวะแทรกซ้อนเฉียบพลันจากโรคเบาหวาน(IPD)',
                        'numh' => @number_format($numh24),
                        'numi' => @number_format($numi24),                    
                        'numo' => @number_format($numo24),
                        'total' => @number_format($total24) 
               );                 
               $sql73="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p 
                                        on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3')  
                                        and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                        and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                        or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                        or p.moopart in ('','0','00'))))
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}'  and '{$date2}' and lo.lab_items_code in  ('102','92','91','103')
                                    and lo.lab_order_result>0 group by l.hn having cc>=4
                             ) as b
                             on a.vn=b.vn;";
               $sql74="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p 
                                        on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3')  
                                       and concat(p.chwpart,p.amppart)='3104'
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}'  and '{$date2}' and lo.lab_items_code in  ('102','92','91','103')
                                    and lo.lab_order_result>0 group by l.hn having cc>=4
                             ) as b
                             on a.vn=b.vn;";
               $sql75="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p 
                                        on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3')  
                                        and concat(p.chwpart,p.amppart) !='3104'
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}'  and '{$date2}' and lo.lab_items_code in  ('102','92','91','103')
                                    and lo.lab_order_result>0 group by l.hn having cc>=4
                             ) as b
                             on a.vn=b.vn;";                                    
               $numh25 = \Yii::$app->db1->createCommand($sql73)->queryScalar();
               $numi25 = \Yii::$app->db1->createCommand($sql74)->queryScalar();                
               $numo25 = \Yii::$app->db1->createCommand($sql75)->queryScalar();  
               $total25 = $numh25+$numi25+$numo25;                
               $rawData[]=array(
                        'id'=>25,
                        'pname'=>'6.   จำนวนผู้ป่วยเบาหวานได้รับการตรวจวิเคราะห์ Lipid profile (คน)',
                        'numh' => @number_format($numh25),
                        'numi' => @number_format($numi25),                    
                        'numo' => @number_format($numo25),
                        'total' => @number_format($total25) 
               );                
               $sql76="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                            on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                            or p.moopart in ('','0','00'))))
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';";
               $sql77="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                            on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                            and concat(p.chwpart,p.amppart)='3104'
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';";
               $sql78="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                            on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                            and concat(p.chwpart,p.amppart) !='3104'
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';";                                     
               $numh26 = \Yii::$app->db1->createCommand($sql76)->queryScalar();
               $numi26 = \Yii::$app->db1->createCommand($sql77)->queryScalar();                
               $numo26 = \Yii::$app->db1->createCommand($sql78)->queryScalar();  
               $total26 = $numh26+$numi26+$numo26;                
               $rawData[]=array(
                        'id'=>26,
                        'pname'=>'6.1 จำนวนผู้ป่วยเบาหวานได้รับการตรวจ  LDL(คน) ',
                        'numh' => @number_format($numh26),
                        'numi' => @number_format($numi26),                    
                        'numo' => @number_format($numo26),
                        'total' => @number_format($total26) 
               );   
               $sql79="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                              on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3')                                               
                                              and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                              and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                              or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                              or p.moopart in ('','0','00'))))                                    
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";
               $sql80="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                              on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3')                                               
                                              and concat(p.chwpart,p.amppart)='3104'                                  
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";
               $sql81="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                              on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3')                                               
                                              and concat(p.chwpart,p.amppart) !='3104'                                  
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.hn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";                                     
               $numh27 = \Yii::$app->db1->createCommand($sql79)->queryScalar();
               $numi27 = \Yii::$app->db1->createCommand($sql80)->queryScalar();                
               $numo27 = \Yii::$app->db1->createCommand($sql81)->queryScalar();  
               $total27 = $numh27+$numi27+$numo27;                
               $rawData[]=array(
                        'id'=>27,
                        'pname'=>'6.2  จำนวนผู้ป่วยเบาหวานได้รับการตรวจ  LDL< 100 mg/dl (คน) ',
                        'numh' => @number_format($numh27),
                        'numi' => @number_format($numi27),                    
                        'numo' => @number_format($numo27),
                        'total' => @number_format($total27)
               );  
               $sql82="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                           on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                              and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                              and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                              or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                              or p.moopart in ('','0','00'))))                                       
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';";
               $sql83="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                           on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                              and concat(p.chwpart,p.amppart)='3104'                                    
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';";
               $sql84="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                           on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                              and concat(p.chwpart,p.amppart) !='3104'                                    
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92';";                                     
               $numh28 = \Yii::$app->db1->createCommand($sql82)->queryScalar();
               $numi28 = \Yii::$app->db1->createCommand($sql83)->queryScalar();                
               $numo28 = \Yii::$app->db1->createCommand($sql84)->queryScalar();  
               $total28 = $numh28+$numi28+$numo28;                
               $rawData[]=array(
                        'id'=>28,
                        'pname'=>'6.3   จำนวนครั้งผู้ป่วยเบาหวาน ได้รับการตรวจ LDL',
                        'numh' => @number_format($numh28),
                        'numi' => @number_format($numi28),                    
                        'numo' => @number_format($numo28),
                        'total' => @number_format($total28)
               );                
               $sql85="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                    on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                              and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                              and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                              or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' 
                                              or p.moopart in ('','0','00'))))                                      
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";
                $sql86="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                    on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                              and concat(p.chwpart,p.amppart)='3104'                                  
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";
                $sql87="select count(*) cc
                                from  
                                (select  b.hn,b.vn,b.lab,b.`code`,b.cc
                                    from (select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn  inner join patient p 
                                    on c.hn=p.hn where c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                              and concat(p.chwpart,p.amppart) !='3104'                                  
                                ) a             
                                inner join 
                               (select  l.hn,max(l.vn) vn,max(lo.lab_order_number) lab,group_concat(lo.lab_items_code) code ,count(*) cc 
                                    from lab_head l 
                                     inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                     where l.receive_date between  '{$date1}'  and '{$date2}'  and lo.lab_items_code in  ('102','92','91','103')
                                     and lo.lab_order_result>0 group by l.vn having cc>=4
                               ) as b
                               on a.vn=b.vn
                             ) as c
                              inner join lab_order lo1 on lo1.lab_order_number=c.lab
                              where lo1.lab_items_code='92' and lo1.lab_order_result<100;";                                     
               $numh29 = \Yii::$app->db1->createCommand($sql85)->queryScalar();
               $numi29 = \Yii::$app->db1->createCommand($sql86)->queryScalar();                
               $numo29 = \Yii::$app->db1->createCommand($sql87)->queryScalar();  
               $total29 = $numh29+$numi29+$numo29;                
               $rawData[]=array(
                        'id'=>29,
                        'pname'=>'6.4  จำนวนครั้งของผู้ป่วยเบาหวานที่มีระดับ LDL< 100 mg/dl ',
                        'numh' => @number_format($numh29),
                        'numi' => @number_format($numi29),                    
                        'numo' => @number_format($numo29),
                        'total' => @number_format($total29)
               );     
               $sql88="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                     and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                     and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                     or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                     and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                              
                             and o.bps>0 and o.bpd>0 group by o.hn ;";
               $sql89="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                            and concat(p.chwpart,p.amppart)='3104' and o.bps>0 and o.bpd>0 group by o.hn ;";
               $sql90="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                            and concat(p.chwpart,p.amppart) !='3104' and o.bps>0 and o.bpd>0 group by o.hn ;";                                
               $numh30 = \Yii::$app->db1->createCommand($sql88)->query()->rowCount;
               $numi30 = \Yii::$app->db1->createCommand($sql89)->query()->rowCount;         
               $numo30 = \Yii::$app->db1->createCommand($sql90)->query()->rowCount;
               $total30 = $numh30+$numi30+$numo30;                
               $rawData[]=array(
                        'id'=>30,
                        'pname'=>'7.   จำนวนผู้ป่วยเบาหวานและเบาหวานร่วมความดัน ได้รับการวัดระดับความดันโลหิต(คน)',
                        'numh' => @number_format($numh30),
                        'numi' => @number_format($numi30),                    
                        'numo' => @number_format($numo30),
                        'total' => @number_format($total30)
               );                 
               $sql91="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join patient p on c.hn=p.hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                       and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                       and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                       or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                       and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                          
                                       and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                             where o.bps<130 and o.bpd<80;";
               $sql92="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join patient p on c.hn=p.hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                       and concat(p.chwpart,p.amppart)='3104'                                      
                                       and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                               where o.bps<130 and o.bpd<80;";
               $sql93="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join patient p on c.hn=p.hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                       and concat(p.chwpart,p.amppart) !='3104'                                      
                                       and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                               where o.bps<130 and o.bpd<80;";                                       
               $numh31 = \Yii::$app->db1->createCommand($sql91)->queryScalar();
               $numi31 = \Yii::$app->db1->createCommand($sql92)->queryScalar();
               $numo31 = \Yii::$app->db1->createCommand($sql93)->queryScalar();
               $total31 = $numh31+$numi31+$numo31;                
               $rawData[]=array(
                        'id'=>31,
                        'pname'=>'7.1   จำนวนผู้ป่วยเบาหวานร่วมความดันที่มีระดับความดันโลหิต  อยู่ในเกณฑ์ที่ควบคุมได้(<= 130/80 mmHg)ครั้งสุดท้าย(คน)',
                        'numh' => @number_format($numh31),
                        'numi' => @number_format($numi31),                    
                        'numo' => @number_format($numo31),
                        'total' => @number_format($total31)
                          );                  
               $sql94="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join patient p on c.hn=p.hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id  in ('3','11') 
                                       and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                       and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                       or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                       and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                         
                                       and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                             where o.bps<140 and o.bpd<80;"; 
               $sql95="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join patient p on c.hn=p.hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id  in ('3','11') 
                                       and concat(p.chwpart,p.amppart)='3104'                                       
                                       and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                             where o.bps<140 and o.bpd<80;"; 
               $sql96="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn from clinicmember c inner join patient p on c.hn=p.hn
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}'  
                                       and c.clinic='001' and c.clinic_member_status_id  in ('3','11') 
                                       and concat(p.chwpart,p.amppart) !='3104'                                       
                                       and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                             where o.bps<140 and o.bpd<80;";                                        
               $numh32 = \Yii::$app->db1->createCommand($sql94)->queryScalar();
               $numi32 = \Yii::$app->db1->createCommand($sql95)->queryScalar();
               $numo32 = \Yii::$app->db1->createCommand($sql96)->queryScalar();
               $total32 = $numh32+$numi32+$numo32;                
               $rawData[]=array(
                        'id'=>32,
                        'pname'=>'7.2   จำนวนผู้ป่วยเบาหวานที่มีระดับความดันโลหิต<140/80(คน)',
                        'numh' => @number_format($numh32),
                        'numi' => @number_format($numi32),                    
                        'numo' => @number_format($numo32),
                        'total' => @number_format($total32)
               );  
               $sql97="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                
                            and o.bps>0 and o.bpd>0 ;";   
               $sql98="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104' and o.bps>0 and o.bpd>0 ;";   
               $sql99="select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                            left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104' and o.bps>0 and o.bpd>0 ;";                               
               $numh33 = \Yii::$app->db1->createCommand($sql97)->queryScalar();
               $numi33 = \Yii::$app->db1->createCommand($sql98)->queryScalar();
               $numo33 = \Yii::$app->db1->createCommand($sql99)->queryScalar();
               $total33 = $numh33+$numi33+$numo33;                
               $rawData[]=array(
                        'id'=>33,
                        'pname'=>'7.3    จำนวนครั้งของผู้ป่วยเบาหวานที่ได้รับการวัดระดับความดันโลหิต',
                        'numh' => @number_format($numh33),
                        'numi' => @number_format($numi33),                    
                        'numo' => @number_format($numo33),
                        'total' => @number_format($total33)
                          );                           
               $sql100="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join patient p on c.hn=p.hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                                           and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn 
                             where o.bps<130 and o.bpd<80 ;";
               $sql101="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join patient p on c.hn=p.hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                         
                                           and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn 
                             where o.bps<130 and o.bpd<80 ;";
               $sql102="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join patient p on c.hn=p.hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                         
                                           and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn 
                             where o.bps<130 and o.bpd<80 ;";                                           
                                           
               $numh34 = \Yii::$app->db1->createCommand($sql100)->queryScalar();
               $numi34 = \Yii::$app->db1->createCommand($sql101)->queryScalar();
               $numo34 = \Yii::$app->db1->createCommand($sql102)->queryScalar();
               $total34 = $numh34+$numi34+$numo34;                
               $rawData[]=array(
                        'id'=>34,
                        'pname'=>'7.4   จำนวนครั้งของผู้ป่วยเบาหวานร่วมความดันที่มีระดับความดันโลหิต<130/80',
                        'numh' => @number_format($numh34),
                        'numi' => @number_format($numi34),                    
                        'numo' => @number_format($numo34),
                        'total' => @number_format($total34)
               );  
               $sql103="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join patient p on c.hn=p.hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                                           and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn 
                             where o.bps<140 and o.bpd<80 ;"; 
               $sql104="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join patient p on c.hn=p.hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                           
                                           and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn 
                             where o.bps<140 and o.bpd<80 ;"; 
               $sql105="select  count(*) cc
                                     from 
                                       (select  o.hn,o.vn
                                          from clinicmember c inner join patient p on c.hn=p.hn
                                           left outer join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                           
                                           and o.bps>0 and o.bpd>0 order by o.hn
                                         ) as a
                                  inner join opdscreen o on o.vn=a.vn 
                             where o.bps<140 and o.bpd<80 ;";                                            
                                           
               $numh35 = \Yii::$app->db1->createCommand($sql103)->queryScalar();
               $numi35 = \Yii::$app->db1->createCommand($sql104)->queryScalar();
               $numo35 = \Yii::$app->db1->createCommand($sql105)->queryScalar();
               $total35 = $numh35+$numi35+$numo35;                
               $rawData[]=array(
                        'id'=>35,
                        'pname'=>'7.5  จำนวนครั้งของผู้ป่วยเบาหวานร่วมความดันที่มีระดับความดันโลหิต<140/80',
                        'numh' => @number_format($numh35),
                        'numi' => @number_format($numi35),                    
                        'numo' => @number_format($numo35),
                        'total' => @number_format($total35)
                );    
               $sql106="select count(*) cc
                            from clinicmember c inner join patient p on c.hn=p.hn
                            where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.sex='1' and
                            TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-11-02')>=10,YEAR('2015-11-02')+1 ,
                            YEAR('2015-11-02'))-1,'-','10','-','01')) >=50 and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))));";
               $sql107="select count(*) cc
                            from clinicmember c inner join patient p on c.hn=p.hn
                            where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.sex='1' and
                            TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-11-02')>=10,YEAR('2015-11-02')+1 ,
                            YEAR('2015-11-02'))-1,'-','10','-','01')) >=50 and concat(p.chwpart,p.amppart)='3104';";   
               $sql108="select count(*) cc
                            from clinicmember c inner join patient p on c.hn=p.hn
                            where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.sex='1' and
                            TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-11-02')>=10,YEAR('2015-11-02')+1 ,
                            YEAR('2015-11-02'))-1,'-','10','-','01')) >=50 and concat(p.chwpart,p.amppart) !='3104';";                   
               $numh36 = \Yii::$app->db1->createCommand($sql106)->queryScalar();
               $numi36 = \Yii::$app->db1->createCommand($sql107)->queryScalar();
               $numo36 = \Yii::$app->db1->createCommand($sql108)->queryScalar();
               $total36 = $numh36+$numi36+$numo36;                
               $rawData[]=array(
                        'id'=>36,
                        'pname'=>'8.&nbsp;&nbsp; จำนวนผู้ป่วยเบาหวานเพศชาย ที่มีอายุ 50 ปีขึ้นไป',
                        'numh' => @number_format($numh36),
                        'numi' => @number_format($numi36),                    
                        'numo' => @number_format($numo36),
                        'total' => @number_format($total36)
               );               
               $sql109=" select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join patient p on c.hn=p.hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11')  and p.sex='1' and
                                        TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                       YEAR('{$date2}'))-1,'-','10','-','01')) >=50 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                       
                                        and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";
               $sql110=" select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join patient p on c.hn=p.hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11')  and p.sex='1' and
                                        TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                       YEAR('{$date2}'))-1,'-','10','-','01')) >=50 
                                            and concat(p.chwpart,p.amppart)='3104'                                    
                                        and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";        
               $sql111=" select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join patient p on c.hn=p.hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11')  and p.sex='1' and
                                        TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                       YEAR('{$date2}'))-1,'-','10','-','01')) >=50 
                                            and concat(p.chwpart,p.amppart) !='3104'                                    
                                        and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";                                          
               $numh37 = \Yii::$app->db1->createCommand($sql109)->queryScalar();
               $numi37 = \Yii::$app->db1->createCommand($sql110)->queryScalar();
               $numo37 = \Yii::$app->db1->createCommand($sql111)->queryScalar();
               $total37 = $numh37+$numi37+$numo37;                
               $rawData[]=array(
                        'id'=>37,
                        'pname'=>'8.1   จำนวนผู้ป่วยเบาหวานเพศชายที่มีอายุ 50 ปีขึ้นไปและได้รับยาแอสไพริน',
                        'numh' => @number_format($numh37),
                        'numi' => @number_format($numi37),                    
                        'numo' => @number_format($numo37),
                        'total' => @number_format($total37)
               );    
               $sql112="select count(*) cc
                            from clinicmember c inner join patient p on c.hn=p.hn
                            where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.sex='2' and
                            TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-11-02')>=10,YEAR('2015-11-02')+1 ,
                            YEAR('2015-11-02'))-1,'-','10','-','01')) >=60 and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))));";
               $sql113="select count(*) cc
                            from clinicmember c inner join patient p on c.hn=p.hn
                            where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.sex='2' and
                            TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-11-02')>=10,YEAR('2015-11-02')+1 ,
                            YEAR('2015-11-02'))-1,'-','10','-','01')) >=60 and concat(p.chwpart,p.amppart)='3104';";   
               $sql114="select count(*) cc
                            from clinicmember c inner join patient p on c.hn=p.hn
                            where c.clinic='001' and c.clinic_member_status_id in ('3','11') and p.sex='2' and
                            TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-11-02')>=10,YEAR('2015-11-02')+1 ,
                            YEAR('2015-11-02'))-1,'-','10','-','01')) >=60 and concat(p.chwpart,p.amppart) !='3104';";                   
               $numh38 = \Yii::$app->db1->createCommand($sql112)->queryScalar();
               $numi38 = \Yii::$app->db1->createCommand($sql113)->queryScalar();
               $numo38 = \Yii::$app->db1->createCommand($sql114)->queryScalar();
               $total38 = $numh38+$numi38+$numo38;                
               $rawData[]=array(
                        'id'=>38,
                        'pname'=>'9. จำนวนผู้ป่วยเบาหวานเพศหญิง ที่มีอายุ 60 ปีขึ้นไป',
                        'numh' => @number_format($numh38),
                        'numi' => @number_format($numi38),                    
                        'numo' => @number_format($numo38),
                        'total' => @number_format($total38)
               );   
               $sql115=" select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join patient p on c.hn=p.hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11')  and p.sex='2' and
                                        TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                        YEAR('{$date2}'))-1,'-','10','-','01')) >=60 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                   
                                            and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";
               $sql116=" select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join patient p on c.hn=p.hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11')  and p.sex='2' and
                                        TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                        YEAR('{$date2}'))-1,'-','10','-','01')) >=60 
                                            and concat(p.chwpart,p.amppart)='3104'                                 
                                            and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";
               $sql117=" select count(*) cc
                                from  
                                     (select  c.hn,v.vn
                                        from clinicmember c inner join patient p on c.hn=p.hn     
                                        inner join vn_stat v on c.hn=v.hn                       
                                        where c.clinic='001' and c.clinic_member_status_id in ('3','11')  and p.sex='2' and
                                        TIMESTAMPDIFF(YEAR, p.birthday, concat(IF(MONTH('2015-08-20')>=10,YEAR('2015-08-20')+1 ,
                                        YEAR('{$date2}'))-1,'-','10','-','01')) >=60 
                                            and concat(p.chwpart,p.amppart) !='3104'                                 
                                            and v.vstdate between '{$date1}'  and '{$date2}' 
                                     ) as a
                                 left outer join opitemrece o on o.vn=a.vn left outer join vn_stat v on o.vn=v.vn
                                 where o.icode in ('1510074','1510075') order by o.hn;";                                          
               $numh39 = \Yii::$app->db1->createCommand($sql115)->queryScalar();
               $numi39 = \Yii::$app->db1->createCommand($sql116)->queryScalar();
               $numo39 = \Yii::$app->db1->createCommand($sql117)->queryScalar();
               $total39 = $numh39+$numi39+$numo39;                
               $rawData[]=array(
                        'id'=>39,
                        'pname'=>'9.1    จำนวนผู้ป่วยเบาหวานเพศหญิงที่มีอายุ 60 ปีขึ้นไปได้รับยาแอสไพริน',
                        'numh' => @number_format($numh39),
                        'numi' => @number_format($numi39),                    
                        'numo' => @number_format($numo39),
                        'total' => @number_format($total39)
                );  
               $sql118="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                                
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('710','985','486') and
                                                         (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";     
               $sql119="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                             
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('710','985','486') and
                                                         (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";
               $sql120="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                             
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('710','985','486') and
                                                         (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";                                              
               $numh40 = \Yii::$app->db1->createCommand($sql118)->queryScalar();
               $numi40 = \Yii::$app->db1->createCommand($sql119)->queryScalar();
               $numo40 = \Yii::$app->db1->createCommand($sql120)->queryScalar();
               $total40 = $numh40+$numi40+$numo40;                
               $rawData[]=array(
                        'id'=>40,
                        'pname'=>'10.   ผู้ป่วยเบาหวานที่ได้รับการตรวจ Microalbumin/Urine Albumin(Macroalbumin)(คน)',
                        'numh' => @number_format($numh40),
                        'numi' => @number_format($numi40),                    
                        'numo' => @number_format($numo40),
                        'total' => @number_format($total40)
                );     
               $sql121="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('985','710') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;"; 
               $sql122="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('985','710') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";   
               $sql123="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('985','710') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";                                                
               $numh41 = \Yii::$app->db1->createCommand($sql121)->queryScalar();
               $numi41 = \Yii::$app->db1->createCommand($sql122)->queryScalar();
               $numo41 = \Yii::$app->db1->createCommand($sql123)->queryScalar();
               $total41 = $numh41+$numi41+$numo41;                
               $rawData[]=array(
                        'id'=>41,
                        'pname'=>'10.1   ผู้ป่วยเบาหวานที่ได้รับการตรวจ Microalbumin',
                        'numh' => @number_format($numh41),
                        'numi' => @number_format($numi41),                    
                        'numo' => @number_format($numo41),
                        'total' => @number_format($total41)
                );    
               $sql124="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('486') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";   
               $sql125="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('486') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;"; 
               $sql126="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lab_items_code in ('486') and (lo.lab_order_result is not null and lo.lab_order_result <>'')       
                                     ) as b     
                                     on a.vn=b.vn;";                                                
               $numh42 = \Yii::$app->db1->createCommand($sql124)->queryScalar();
               $numi42 = \Yii::$app->db1->createCommand($sql125)->queryScalar();
               $numo42 = \Yii::$app->db1->createCommand($sql126)->queryScalar();
               $total42 = $numh42+$numi42+$numo42;                
               $rawData[]=array(
                        'id'=>42,
                        'pname'=>'10.2  ผู้ป่วยเบาหวานที่ได้รับการตรวจ Macroalbumin',
                        'numh' => @number_format($numh42),
                        'numi' => @number_format($numi42),                    
                        'numo' => @number_format($numo42),
                        'total' => @number_format($total42)
                ); 
               $sql127="select count(*) cc
                                     from (
                                        select c.hn,max(v.vn) vn from clinicmember c inner join patient p on c.hn=p.hn
                                        inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                          
                                        group by c.hn
                                    ) as a
                                    inner join
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from
                                                lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number
                                               where lab_items_code in ('1030') and lo.lab_order_result <60 
                                    ) as b
                                    on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode not in ('1510053','1510054','1510055','1510066','1570020') 
                                    group by o.vn order by a.hn;";
               $sql128="select count(*) cc
                                     from (
                                        select c.hn,max(v.vn) vn from clinicmember c inner join patient p on c.hn=p.hn
                                        inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                        
                                        group by c.hn
                                    ) as a
                                    inner join
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from
                                                lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number
                                               where lab_items_code in ('1030') and lo.lab_order_result <60 
                                    ) as b
                                    on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode not in ('1510053','1510054','1510055','1510066','1570020') 
                                    group by o.vn order by a.hn;";   
               $sql129="select count(*) cc
                                     from (
                                        select c.hn,max(v.vn) vn from clinicmember c inner join patient p on c.hn=p.hn
                                        inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                       and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                        
                                        group by c.hn
                                    ) as a
                                    inner join
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from
                                                lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number
                                               where lab_items_code in ('1030') and lo.lab_order_result <60 
                                    ) as b
                                    on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode not in ('1510053','1510054','1510055','1510066','1570020') 
                                    group by o.vn order by a.hn;";                                           
               $numh43 = \Yii::$app->db1->createCommand($sql127)->query()->rowCount;
               $numi43 = \Yii::$app->db1->createCommand($sql128)->query()->rowCount;
               $numo43 = \Yii::$app->db1->createCommand($sql129)->query()->rowCount;
               $total43 = $numh43+$numi43+$numo43;                
               $rawData[]=array(
                        'id'=>43,
                        'pname'=>'10.3  ผู้ป่วยเบาหวานทั้งหมดที่มีภาวะแทรกซ้อนทางไต และไม่ได้รับยากลุ่ม ACE inhibitor หรือ ARB ',
                        'numh' => @number_format($numh43),
                        'numi' => @number_format($numi43),                    
                        'numo' => @number_format($numo43),
                        'total' => @number_format($total43)
                );   
               $sql130="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                                
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn;";   
               $sql131="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn;";   
               $sql132="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn;";                                                
               $numh44 = \Yii::$app->db1->createCommand($sql130)->queryScalar();
               $numi44 = \Yii::$app->db1->createCommand($sql131)->queryScalar();
               $numo44 = \Yii::$app->db1->createCommand($sql132)->queryScalar();
               $total44 = $numh44+$numi44+$numo44;                
               $rawData[]=array(
                        'id'=>44,
                        'pname'=>'10.4   ผู้ป่วยเบาหวานที่มีภาวะ Microalbuminuria',
                        'numh' => @number_format($numh44),
                        'numi' => @number_format($numi44),                    
                        'numo' => @number_format($numo44),
                        'total' => @number_format($total44)
                );  
               $sql133="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode in ('1510053','1510054','1510055','1510066','1570020')  group by o.vn;";  
               $sql134="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode in ('1510053','1510054','1510055','1510066','1570020')  group by o.vn;";  
               $sql135="select count(*) cc
                                    from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where (lo.lab_items_code = '710' and lo.lab_order_result >='20') or (lo.lab_items_code='985' 
                                                  and (lo.lab_order_result>300 or lo.lab_order_result>30)) or 
                                                            (lo.lab_items_code='486' and lo.lab_order_result in ('trace','1+','2+','3+'))  
                                     ) as b     
                                     on a.vn=b.vn
                                    left outer join opitemrece o on o.vn=b.vn
                                    where o.icode in ('1510053','1510054','1510055','1510066','1570020')  group by o.vn;";  
                                            
               $numh45 = \Yii::$app->db1->createCommand($sql133)->queryScalar();
               $numi45 = \Yii::$app->db1->createCommand($sql134)->queryScalar();
               $numo45 = \Yii::$app->db1->createCommand($sql135)->queryScalar();
               $total45 = $numh45+$numi45+$numo45;                
               $rawData[]=array(
                        'id'=>45,
                        'pname'=>'10.5   ผู้ป่วยเบาหวานที่มีภาวะ Microalbuminuria แล้วได้รับยากลุ่ม ACE inhibitor หรือ ARB' ,
                        'numh' => @number_format($numh45),
                        'numi' => @number_format($numi45),                    
                        'numo' => @number_format($numo45),
                        'total' => @number_format($total45)
                );  
               $sql136="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;"; 
               $sql137="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";   
               $sql138="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";                                               
               $numh46 = \Yii::$app->db1->createCommand($sql136)->queryScalar();
               $numi46 = \Yii::$app->db1->createCommand($sql137)->queryScalar();
               $numo46 = \Yii::$app->db1->createCommand($sql138)->queryScalar();
               $total46 = $numh46+$numi46+$numo46;                
               $rawData[]=array(
                        'id'=>46,
                        'pname'=>'11.   ผู้ป่วยเบาหวานที่มีภาวะแทรกซ้อนทางไต(CKD-EPI)(คน)',
                        'numh' => @number_format($numh46),
                        'numi' => @number_format($numi46),                    
                        'numo' => @number_format($numo46),
                        'total' => @number_format($total46)
               );   
               $sql139="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result>=90  
                                     ) as b     
                                     on a.vn=b.vn;";    
               $sql140="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result>=90  
                                     ) as b     
                                     on a.vn=b.vn;";  
               $sql141="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result>=90  
                                     ) as b     
                                     on a.vn=b.vn;";                                               
               $numh47 = \Yii::$app->db1->createCommand($sql139)->queryScalar();
               $numi47 = \Yii::$app->db1->createCommand($sql140)->queryScalar();
               $numo47 = \Yii::$app->db1->createCommand($sql141)->queryScalar();
               $total47 = $numh47+$numi47+$numo47;                
               $rawData[]=array(
                        'id'=>47,
                        'pname'=>'11.1  ระยะที่ 1 (GFR>=90 ml/min)',
                        'numh' => @number_format($numh47),
                        'numi' => @number_format($numi47),                    
                        'numo' => @number_format($numo47),
                        'total' => @number_format($total47)
                );   
               $sql142="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 60 and 89 
                                     ) as b     
                                     on a.vn=b.vn;"; 
               $sql143="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 60 and 89 
                                     ) as b     
                                     on a.vn=b.vn;";  
               $sql144="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 60 and 89 
                                     ) as b     
                                     on a.vn=b.vn;";                                              
               $numh48 = \Yii::$app->db1->createCommand($sql142)->queryScalar();
               $numi48 = \Yii::$app->db1->createCommand($sql143)->queryScalar();
               $numo48 = \Yii::$app->db1->createCommand($sql144)->queryScalar();
               $total48 = $numh48+$numi48+$numo48;                
               $rawData[]=array(
                        'id'=>48,
                        'pname'=>'11.2   ระยะที่ 2 (GFR 60-89 ml/min)',
                        'numh' => @number_format($numh48),
                        'numi' => @number_format($numi48),                    
                        'numo' => @number_format($numo48),
                        'total' => @number_format($total48)
                );  
               $sql145="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11')
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 30 and 59 
                                     ) as b     
                                     on a.vn=b.vn;";    
               $sql146="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11')
                                            and concat(p.chwpart,p.amppart)='3104'                                           
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 30 and 59 
                                     ) as b     
                                     on a.vn=b.vn;";   
               $sql147="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11')
                                            and concat(p.chwpart,p.amppart) !='3104'                                           
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 30 and 59 
                                     ) as b     
                                     on a.vn=b.vn;";                                               
               $numh49 = \Yii::$app->db1->createCommand($sql145)->queryScalar();
               $numi49 = \Yii::$app->db1->createCommand($sql146)->queryScalar();
               $numo49 = \Yii::$app->db1->createCommand($sql147)->queryScalar();
               $total49 = $numh49+$numi49+$numo49;                
               $rawData[]=array(
                        'id'=>49,
                        'pname'=>'11.3  ระยะที่ 3 (GFR 30-59 ml/min)',
                        'numh' => @number_format($numh49),
                        'numi' => @number_format($numi49),                    
                        'numo' => @number_format($numo49),
                        'total' => @number_format($total49)
                ); 
               $sql148="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 15 and 29 
                                     ) as b     
                                     on a.vn=b.vn;"; 
               $sql149="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                        
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 15 and 29 
                                     ) as b     
                                     on a.vn=b.vn;";  
               $sql150="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                        
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result between 15 and 29 
                                     ) as b     
                                     on a.vn=b.vn;";                                              
               $numh50 = \Yii::$app->db1->createCommand($sql148)->queryScalar();
               $numi50 = \Yii::$app->db1->createCommand($sql149)->queryScalar();
               $numo50 = \Yii::$app->db1->createCommand($sql150)->queryScalar();
               $total50 = $numh50+$numi50+$numo50;                
               $rawData[]=array(
                        'id'=>50,
                        'pname'=>'11.4   ระยะที่ 4 (GFR 15-29 ml/min)',
                        'numh' => @number_format($numh50),
                        'numi' => @number_format($numi50),                    
                        'numo' => @number_format($numo50),
                        'total' => @number_format($total50)
               );   
               $sql151="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result<15
                                     ) as b     
                                     on a.vn=b.vn;";    
               $sql152="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                           
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result<15
                                     ) as b     
                                     on a.vn=b.vn;";    
               $sql153="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                           
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result<15
                                     ) as b     
                                     on a.vn=b.vn;";                                             
               $numh51 = \Yii::$app->db1->createCommand($sql151)->queryScalar();
               $numi51 = \Yii::$app->db1->createCommand($sql152)->queryScalar();
               $numo51 = \Yii::$app->db1->createCommand($sql153)->queryScalar();
               $total51 = $numh51+$numi51+$numo51;                
               $rawData[]=array(
                        'id'=>51,
                        'pname'=>'11.5   ระยะที่ 5 (GFR<15 ml/min)',
                        'numh' => @number_format($numh51),
                        'numi' => @number_format($numi51),                    
                        'numo' => @number_format($numo51),
                        'total' => @number_format($total51)
                );  
              $sql154=" select count(*) cc
                                    from (
                                        select cs.do_eye_screen,cs.has_eye_cormobidity,cs.clinicmember_cormobidity_screen_id
                                            from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                               
                                            and cs.do_eye_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                       select clinicmember_cormobidity_screen_id,clinicmember_cormobidity_eye_screen_id,
                                                   dmht_eye_screen_result_left_id,dmht_eye_screen_result_right_id
                                            from        
                                            clinicmember_cormobidity_eye_screen where 
                                                  (dmht_eye_screen_result_left_id is not null and dmht_eye_screen_result_left_id !='' 
                                                          and dmht_eye_screen_result_left_id !=0) and 
                                                 (dmht_eye_screen_result_right_id is not null and dmht_eye_screen_result_right_id !='' 
                                                          and dmht_eye_screen_result_right_id !=0)
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";    
              $sql155=" select count(*) cc
                                    from (
                                        select cs.do_eye_screen,cs.has_eye_cormobidity,cs.clinicmember_cormobidity_screen_id
                                            from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                             
                                            and cs.do_eye_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                       select clinicmember_cormobidity_screen_id,clinicmember_cormobidity_eye_screen_id,
                                                   dmht_eye_screen_result_left_id,dmht_eye_screen_result_right_id
                                            from        
                                            clinicmember_cormobidity_eye_screen where 
                                                  (dmht_eye_screen_result_left_id is not null and dmht_eye_screen_result_left_id !='' 
                                                          and dmht_eye_screen_result_left_id !=0) and 
                                                 (dmht_eye_screen_result_right_id is not null and dmht_eye_screen_result_right_id !='' 
                                                          and dmht_eye_screen_result_right_id !=0)
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";    
              $sql156=" select count(*) cc
                                    from (
                                        select cs.do_eye_screen,cs.has_eye_cormobidity,cs.clinicmember_cormobidity_screen_id
                                            from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                             
                                            and cs.do_eye_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                       select clinicmember_cormobidity_screen_id,clinicmember_cormobidity_eye_screen_id,
                                                   dmht_eye_screen_result_left_id,dmht_eye_screen_result_right_id
                                            from        
                                            clinicmember_cormobidity_eye_screen where 
                                                  (dmht_eye_screen_result_left_id is not null and dmht_eye_screen_result_left_id !='' 
                                                          and dmht_eye_screen_result_left_id !=0) and 
                                                 (dmht_eye_screen_result_right_id is not null and dmht_eye_screen_result_right_id !='' 
                                                          and dmht_eye_screen_result_right_id !=0)
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";                                                
               $numh52 = \Yii::$app->db1->createCommand($sql154)->queryScalar();
               $numi52 = \Yii::$app->db1->createCommand($sql155)->queryScalar();
               $numo52 = \Yii::$app->db1->createCommand($sql156)->queryScalar();
               $total52 = $numh52+$numi52+$numo52;                
               $rawData[]=array(
                        'id'=>52,
                        'pname'=>'12.   จำนวนผู้ป่วยเบาหวานได้รับการตรวจจอประสาทตา',
                        'numh' => @number_format($numh52),
                        'numi' => @number_format($numi52),                    
                        'numo' => @number_format($numo52),
                        'total' => @number_format($total52)
                );
               $sql157=" select count(*) cc
                                    from (
                                            select cs.do_dental_screen,cs.has_dental_cormobidity,cs.clinicmember_cormobidity_screen_id 
                                            from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                                            and cs.do_dental_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                            select clinicmember_cormobidity_screen_id,oral_cavity_educate
                                            from
                                                   clinicmember_cormobidity_dental_screen where oral_cavity_educate='Y'
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";  
               $sql158=" select count(*) cc
                                    from (
                                            select cs.do_dental_screen,cs.has_dental_cormobidity,cs.clinicmember_cormobidity_screen_id 
                                            from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                             
                                            and cs.do_dental_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                            select clinicmember_cormobidity_screen_id,oral_cavity_educate
                                            from
                                                   clinicmember_cormobidity_dental_screen where oral_cavity_educate='Y'
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";                                              
               $sql159=" select count(*) cc
                                    from (
                                            select cs.do_dental_screen,cs.has_dental_cormobidity,cs.clinicmember_cormobidity_screen_id 
                                            from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                             
                                            and cs.do_dental_screen='Y'
                                    ) as a
                                    inner join
                                    (
                                            select clinicmember_cormobidity_screen_id,oral_cavity_educate
                                            from
                                                   clinicmember_cormobidity_dental_screen where oral_cavity_educate='Y'
                                    ) as b
                                    on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";                                                      
               $numh53 = \Yii::$app->db1->createCommand($sql157)->queryScalar();
               $numi53 = \Yii::$app->db1->createCommand($sql158)->queryScalar();
               $numo53 = \Yii::$app->db1->createCommand($sql159)->queryScalar();
               $total53 = $numh53+$numi53+$numo53;                
               $rawData[]=array(
                        'id'=>53,
                        'pname'=>'13.   จำนวนผู้ป่วยเบาหวานได้รับการตรวจสุขภาพช่องปาก',
                        'numh' => @number_format($numh53),
                        'numi' => @number_format($numi53),                    
                        'numo' => @number_format($numo53),
                        'total' => @number_format($total53)
                );
        $sql160=" select count(*) cc
                              from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join patient p on c.hn=p.hn
                                    inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                    where cs.screen_date between '{$date1}'  and '{$date2}' 
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                      
                                    and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id
                                     from
                                        clinicmember_cormobidity_foot_screen 
                                        where dmht_foot_screen_result_left_id <> 0 and dmht_foot_screen_result_right_id <> 0 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";   
        $sql161=" select count(*) cc
                              from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join patient p on c.hn=p.hn
                                    inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                    where cs.screen_date between '{$date1}'  and '{$date2}' 
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                   
                                    and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id
                                     from
                                        clinicmember_cormobidity_foot_screen 
                                        where dmht_foot_screen_result_left_id <> 0 and dmht_foot_screen_result_right_id <> 0 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";        
        $sql162=" select count(*) cc
                              from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join patient p on c.hn=p.hn
                                    inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                    where cs.screen_date between '{$date1}'  and '{$date2}' 
                                    and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'                               
                                    and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id
                                     from
                                        clinicmember_cormobidity_foot_screen 
                                        where dmht_foot_screen_result_left_id <> 0 and dmht_foot_screen_result_right_id <> 0 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";                                        
               $numh54 = \Yii::$app->db1->createCommand($sql160)->queryScalar();
               $numi54 = \Yii::$app->db1->createCommand($sql161)->queryScalar();
               $numo54 = \Yii::$app->db1->createCommand($sql162)->queryScalar();
               $total54 = $numh54+$numi54+$numo54;                
               $rawData[]=array(
                        'id'=>54,
                        'pname'=>'14.   จำนวนผู้ป่วยเบาหวานได้รับการตรวจเท้า',
                        'numh' => @number_format($numh54),
                        'numi' => @number_format($numi54),                    
                        'numo' => @number_format($numo54),
                        'total' => @number_format($total54)
               ); 
        $sql163=" select count(*) cc
                             from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                                    and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_ulcer_id in (1,2,3) 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";   
        $sql164=" select count(*) cc
                             from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                            
                                    and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_ulcer_id in (1,2,3) 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;"; 
        $sql165=" select count(*) cc
                             from (
                                    select cs.clinicmember_cormobidity_screen_id from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                            
                                    and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_ulcer_id in (1,2,3) 
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";                                             
               $numh55 = \Yii::$app->db1->createCommand($sql163)->queryScalar();
               $numi55 = \Yii::$app->db1->createCommand($sql164)->queryScalar();
               $numo55 = \Yii::$app->db1->createCommand($sql165)->queryScalar();
               $total55 = $numh55+$numi55+$numo55;                
               $rawData[]=array(
                        'id'=>55,
                        'pname'=>'14.1   การตรวจพบแผลที่เท้า',
                        'numh' => @number_format($numh55),
                        'numi' => @number_format($numi55),                    
                        'numo' => @number_format($numo55),
                        'total' => @number_format($total55)
                );
        $sql166=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                               
                                            and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;";    
        $sql167=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                          
                                            and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;"; 
        $sql168=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                          
                                            and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;";                                               
               $numh56 = \Yii::$app->db1->createCommand($sql166)->query()->rowCount;
               $numi56 = \Yii::$app->db1->createCommand($sql167)->query()->rowCount;
               $numo56 = \Yii::$app->db1->createCommand($sql168)->query()->rowCount;
               $total56 = $numh56+$numi56+$numo56;                
               $rawData[]=array(
                        'id'=>56,
                        'pname'=>'14.2   มีประวัติตัดนิ้วเท้า เท้า หรือขา(ภาพรวม)หมายเหตุ:14.2.1+14.2.2 อาจไม่เท่ากับ 14.2 
                                        เพราะคนที่มีการตัด >1ครั้งอาจจะถูกนับทั้ง 2 ที่',
                        'numh' => @number_format($numh56),
                        'numi' => @number_format($numi56),                    
                        'numo' => @number_format($numo56),
                        'total' => @number_format($total56)
                );   
        $sql169=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                                            and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;";  
        $sql170=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                             
                                            and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;"; 
        $sql171=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                             
                                            and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id;";                                               
               $numh57 = \Yii::$app->db1->createCommand($sql169)->query()->rowCount;
               $numi57 = \Yii::$app->db1->createCommand($sql170)->query()->rowCount;
               $numo57 = \Yii::$app->db1->createCommand($sql171)->query()->rowCount;
               $total57 = $numh57+$numi57+$numo57;                
               $rawData[]=array(
                        'id'=>57,
                        'pname'=>'   14.2.1    มีการตัดนิ้วเท้า เท้า หรือขา รายใหม่',
                        'numh' => @number_format($numh57),
                        'numi' => @number_format($numi57),                    
                        'numo' => @number_format($numo57),
                        'total' => @number_format($total57)
               ); 
        $sql172=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c 
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11')
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                               
                                            and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id ;";    
        $sql173=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c 
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11')
                                            and concat(p.chwpart,p.amppart)='3104'                                           
                                            and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id ;";  
        $sql174=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id from clinicmember c 
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between  '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11')
                                            and concat(p.chwpart,p.amppart) !='3104'                                           
                                            and cs.do_foot_screen='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_foot_screen_ulcer_id
                                            from
                                            clinicmember_cormobidity_foot_screen where dmht_foot_screen_result_left_id <> 0 
                                            and dmht_foot_screen_result_right_id <> 0 and dmht_foot_screen_history_amputation_id=1
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id group by a.clinicmember_id ;";                                              
               $numh58 = \Yii::$app->db1->createCommand($sql172)->query()->rowCount;
               $numi58 = \Yii::$app->db1->createCommand($sql173)->query()->rowCount;
               $numo58 = \Yii::$app->db1->createCommand($sql174)->query()->rowCount;
               $total58 = $numh58+$numi58+$numo58;                
               $rawData[]=array(
                        'id'=>58,
                        'pname'=>'14.2.2  มีการตัดนิ้วเท้า เท้า หรือขา รายเก่า',
                        'numh' => @number_format($numh58),
                        'numi' => @number_format($numi58),                    
                        'numo' => @number_format($numo58),
                        'total' => @number_format($total58)
                );   
               $sql175=" select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                             inner join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                             and c.clinic='001' and c.clinic_member_status_id in ('3','11') and o.smoking_type_id in (2,5) 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                               
                             group by c.hn;";    
               $sql176=" select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                             inner join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                             and c.clinic='001' and c.clinic_member_status_id in ('3','11') and o.smoking_type_id in (2,5) 
                                    and concat(p.chwpart,p.amppart)='3104' group by c.hn;";     
               $sql177=" select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                             inner join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                             and c.clinic='001' and c.clinic_member_status_id in ('3','11') and o.smoking_type_id in (2,5) 
                                    and concat(p.chwpart,p.amppart) !='3104' group by c.hn;";                                
               $numh59 = \Yii::$app->db1->createCommand($sql175)->query()->rowCount;
               $numi59 = \Yii::$app->db1->createCommand($sql176)->query()->rowCount;
               $numo59 = \Yii::$app->db1->createCommand($sql177)->query()->rowCount;
               $total59 = $numh59+$numi59+$numo59;                
               $rawData[]=array(
                        'id'=>59,
                             'pname'=>'15.  จำนวนผู้ป่วยเบาหวานสูบบุหรี่(คน)',
                        'numh' => @number_format($numh59),
                        'numi' => @number_format($numi59),                    
                        'numo' => @number_format($numo59),
                        'total' => @number_format($total59)
               );  
        $sql178=" select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                      inner join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                      and c.clinic='001' and c.clinic_member_status_id in ('3','11')
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                        
                      and o.smoking_type_id in (5) group by c.hn;";    
                $sql179=" select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                      inner join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                      and c.clinic='001' and c.clinic_member_status_id in ('3','11') and concat(p.chwpart,p.amppart)='3104'                     
                      and o.smoking_type_id in (5) group by c.hn;";            
                $sql180=" select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                      inner join opdscreen o on c.hn=o.hn where o.vstdate between  '{$date1}'  and '{$date2}' 
                      and c.clinic='001' and c.clinic_member_status_id in ('3','11') and concat(p.chwpart,p.amppart) !='3104'                     
                      and o.smoking_type_id in (5) group by c.hn;";                                  
               $numh60 = \Yii::$app->db1->createCommand($sql178)->query()->rowCount;
               $numi60 = \Yii::$app->db1->createCommand($sql179)->query()->rowCount;
               $numo60 = \Yii::$app->db1->createCommand($sql180)->query()->rowCount;
               $total60 = $numh60+$numi60+$numo60;                
               $rawData[]=array(
                        'id'=>60,
                        'pname'=>'15.1   มีการได้รับคำแนะนำปรึกษาให้เลิกสูบบุหรี่(คน)',
                        'numh' => @number_format($numh60),
                        'numi' => @number_format($numi60),                    
                        'numo' => @number_format($numo60),
                        'total' => @number_format($total60)
                );  
               $sql181=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity 
                                        from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                                            and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                                   clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) 
                                                         and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";      
                $sql182=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity 
                                        from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'                                         
                                            and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                                   clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) 
                                                         and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";         
               $sql183=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity 
                                        from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'                                         
                                            and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                                   clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) 
                                                         and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";                                                
               $numh61 = \Yii::$app->db1->createCommand($sql181)->queryScalar();
               $numi61 = \Yii::$app->db1->createCommand($sql182)->queryScalar();
               $numo61 = \Yii::$app->db1->createCommand($sql183)->queryScalar();
               $total61 = $numh61+$numi61+$numo61;                
               $rawData[]=array(
                        'id'=>61,
                        'pname'=>'16.  การได้รับการวินิจฉัยว่าเป็น Diabetic retinopathy(พบภาวะแทรกซ้อนตา)ตรวจสอบย้อน ตั้งแต่ 2553',
                        'numh' => @number_format($numh61),
                        'numi' => @number_format($numi61),                    
                        'numo' => @number_format($numo61),
                        'total' => @number_format($total61)
                );  
                $sql184=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c
                                           inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                                    and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) 
                                    and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";      
                $sql185=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c
                                           inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'                                            
                                    and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) 
                                    and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";    
                $sql186=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c
                                           inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'                                            
                                    and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) 
                                    and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";                                               
               $numh62 = \Yii::$app->db1->createCommand($sql184)->queryScalar();
               $numi62 = \Yii::$app->db1->createCommand($sql185)->queryScalar();
               $numo62 = \Yii::$app->db1->createCommand($sql186)->queryScalar();
               $total62 = $numh62+$numi62+$numo62;                
               $rawData[]=array(
                        'id'=>62,
                        'pname'=>'16.1   ได้รับการวินิจฉัยว่าเป็น Diabetic retinopathy รายใหม่ ',
                        'numh' => @number_format($numh62),
                        'numi' => @number_format($numi62),                    
                        'numo' => @number_format($numo62),
                        'total' => @number_format($total62)
               ); 
               $sql187=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c 
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                                 
                                    and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";      
               $sql188=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c 
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'
                                              
                                    and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) 
                                    and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;"; 
               $sql189=" select count(*) cc
                             from (
                                    select c.clinicmember_id,cs.clinicmember_cormobidity_screen_id,cs.has_eye_cormobidity from clinicmember c 
                                            inner join patient p on c.hn=p.hn
                                            inner join clinicmember_cormobidity_screen cs on c.clinicmember_id=cs.clinicmember_id
                                            where cs.screen_date between '2010-01-01'  and '{$date1}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'
                                              
                                    and cs.do_eye_screen='Y' and cs.has_eye_cormobidity='Y'
                             ) as a
                             inner join
                             (
                                    select clinicmember_cormobidity_screen_id,dmht_eye_screen_result_left_id
                                            from
                                    clinicmember_cormobidity_eye_screen where dmht_eye_screen_result_left_id not in (0,1) 
                                    and dmht_eye_screen_result_right_id not in (0,1)
                             ) as b
                             on a.clinicmember_cormobidity_screen_id=b.clinicmember_cormobidity_screen_id;";                                               
               $numh63 = \Yii::$app->db1->createCommand($sql187)->queryScalar();
               $numi63 = \Yii::$app->db1->createCommand($sql188)->queryScalar();
               $numo63 = \Yii::$app->db1->createCommand($sql189)->queryScalar();
               $total63 = $numh63+$numi63+$numo63;                
               $rawData[]=array(
                        'id'=>63,
                        'pname'=>'16.2   ได้รับการวินิจฉัยว่าเป็น Diabetic retinopathy รายเก่า ',
                        'numh' => @number_format($numh63),
                        'numi' => @number_format($numi63),                    
                        'numo' => @number_format($numo63),
                        'total' => @number_format($total63)
                ); 
               $sql190="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";   
               $sql191="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'                                           
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";  
               $sql192="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'                                           
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";                                              
               $numh64 = \Yii::$app->db1->createCommand($sql190)->queryScalar();
               $numi64 = \Yii::$app->db1->createCommand($sql191)->queryScalar();
               $numo64 = \Yii::$app->db1->createCommand($sql192)->queryScalar();
               $total64 = $numh64+$numi64+$numo64;                
               $rawData[]=array(
                        'id'=>64,
                        'pname'=>'17.   การได้รับการวินิจฉัยว่าเป็น Diabetic nephropathy(พบภาวะแทรกซ้อนไต)ตรวจสอบย้อนตั้งแต่ 2553',
                        'numh' => @number_format($numh64),
                        'numi' => @number_format($numi64),                    
                        'numo' => @number_format($numo64),
                        'total' => @number_format($total64)
               );    
               $sql193="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                            and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";   
               $sql194="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and concat(p.chwpart,p.amppart)='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";     
               $sql195="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and concat(p.chwpart,p.amppart) !='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";                                              
               $numh65 = \Yii::$app->db1->createCommand($sql193)->queryScalar();
               $numi65 = \Yii::$app->db1->createCommand($sql194)->queryScalar();
               $numo65 = \Yii::$app->db1->createCommand($sql195)->queryScalar();
               $total65 = $numh65+$numi65+$numo65;                
               $rawData[]=array(
                        'id'=>65,
                        'pname'=>'17.1  ได้รับการวินิจฉัยว่าเป็น Diabetic nephropathy รายใหม่ ',
                        'numh' => @number_format($numh65),
                        'numi' => @number_format($numi65),                    
                        'numo' => @number_format($numo65),
                        'total' => @number_format($total65)
                );    
               $sql196="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date1}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;"; 
               $sql197="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date1}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and concat(p.chwpart,p.amppart)='3104'                                        
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";  
               $sql198="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '2010-01-01'  and '{$date1}' 
                                           and c.clinic='001' and c.clinic_member_status_id in ('3','11') and concat(p.chwpart,p.amppart) !='3104'                                        
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030'  
                                     ) as b     
                                     on a.vn=b.vn;";                                               
               $numh66 = \Yii::$app->db1->createCommand($sql196)->queryScalar();
               $numi66 = \Yii::$app->db1->createCommand($sql197)->queryScalar();
               $numo66 = \Yii::$app->db1->createCommand($sql198)->queryScalar();
               $total66 = $numh66+$numi66+$numo66;                
               $rawData[]=array(
                        'id'=>66,
                        'pname'=>'17.2   ได้รับการวินิจฉัยว่าเป็น  Diabetic nephropathy รายเก่า ',
                        'numh' => @number_format($numh66),
                        'numi' => @number_format($numi66),                    
                        'numo' => @number_format($numo66),
                        'total' => @number_format($total66)
               ); 
               $sql199="select count(*) cc from referout where refer_date between '{$date1}'  and '{$date2}' and pre_diagnosis='DM';";   
                          $total67=\Yii::$app->db1->createCommand($sql199)->queryScalar(); 
                          $rawData[]=array(
                             'id'=>67,
                             'pname'=>'18.&nbsp;&nbsp; จำนวนผู้ป่วยที่ รพ.ส่งกลับ รพ.สต(เบาหวาน)(คน)',
                             'numh'=>'-',                              
                             'numi'=>'-',
                             'numo'=>'-',
                             'total'=>$total67
                          );  
        $sql200="select count(*) cc from referout where refer_date between '{$date1}'  and '{$date2}' and pre_diagnosis='DMHT';";   
                          $total68=\Yii::$app->db1->createCommand($sql200)->queryScalar();                           
                          $rawData[]=array(
                             'id'=>68,
                             'pname'=>'19.&nbsp;&nbsp; จำนวนผู้ป่วยที่ รพ.ส่งกลับ รพ.สต(เบาหวาน-ความดัน)(คน)',
                             'numh'=>'-',                                                  
                             'numi'=>'-',
                             'numo'=>'-',
                             'total'=>$total68
                          );        
                          $rawData[]=array(
                             'id'=>69,
                             'pname'=>'20.&nbsp;&nbsp; จำนวนผู้ป่วยที่ได้รับการปรับเปลี่ยน 3อ2ส.(คน)',
                             'numh'=>'',                                 
                             'numi'=>'',
                             'numo'=>'',
                             'total'=>'' 
                          );  
                          $rawData[]=array(
                             'id'=>70,
                             'pname'=>'<h4>ปัจจัยเสี่ยงต่อโรคหัวใจและหลอดเลือด</h4>',
                             'numh'=>'',                                 
                             'numi'=>'',
                             'numo'=>'',
                             'total'=>''
                          );    
               $sql201="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                       from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                       where vstdate between '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                              
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
               $sql202="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                       from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                       where vstdate between '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                           
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;"; 
               $sql203="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                       from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                       where vstdate between '{$date1}'  and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                           
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";                                           
               $numh71 = \Yii::$app->db1->createCommand($sql201)->query()->rowCount;
               $numi71 = \Yii::$app->db1->createCommand($sql202)->query()->rowCount;
               $numo71 = \Yii::$app->db1->createCommand($sql203)->query()->rowCount;
               $total71 = $numh71+$numi71+$numo71;                
               $rawData[]=array(
                        'id'=>71,
                        'pname'=>'21.   จำนวนคนที่ได้รับการตรวจภาวะแทรกซ้อนของหลอดเลือดสมอง(คน)',
                        'numh' => @number_format($numh71),
                        'numi' => @number_format($numi71),                    
                        'numo' => @number_format($numo71),
                        'total' => @number_format($total71)   
               ); 
               $sql204="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                          
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
               $sql205="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                         
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
               $sql206="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                         
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";                                           
               $numh72 = \Yii::$app->db1->createCommand($sql204)->query()->rowCount;
               $numi72 = \Yii::$app->db1->createCommand($sql205)->query()->rowCount;
               $numo72 = \Yii::$app->db1->createCommand($sql206)->query()->rowCount;
               $total72 = $numh72+$numi72+$numo72;                
               $rawData[]=array(
                        'id'=>72,
                        'pname'=>'21.1   จำนวนคนที่ตรวจพบภาวะแทรกซ้อนของหลอดเลือดสมองทั้งหมด(คน)',
                        'numh' => @number_format($numh72),
                        'numi' => @number_format($numi72),                    
                        'numo' => @number_format($numo72),
                        'total' => @number_format($total72)   
                ); 
               $sql207="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                            
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn  group by a.hn;";   
               $sql208="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                          
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn  group by a.hn;";    
               $sql209="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                          
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                                          and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn  group by a.hn;";                                              
               $numh73 = \Yii::$app->db1->createCommand($sql207)->query()->rowCount;
               $numi73 = \Yii::$app->db1->createCommand($sql208)->query()->rowCount;
               $numo73 = \Yii::$app->db1->createCommand($sql209)->query()->rowCount;
               $total73 = $numh73+$numi73+$numo73;                
               $rawData[]=array(
                        'id'=>73,
                        'pname'=>'21.2  จำนวนคนที่ตรวจพบภาวะแทรกซ้อนของหลอดเลือดสมอง รายใหม่(คน)',
                        'numh' => @number_format($numh73),
                        'numi' => @number_format($numi73),                    
                        'numo' => @number_format($numo73),
                        'total' => @number_format($total73)   
                );  
               $sql210="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";     
               $sql211="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                     
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";   
               $sql212="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                     
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";                                            
               $numh74 = \Yii::$app->db1->createCommand($sql210)->query()->rowCount;
               $numi74 = \Yii::$app->db1->createCommand($sql211)->query()->rowCount;
               $numo74 = \Yii::$app->db1->createCommand($sql212)->query()->rowCount;
               $total74 = $numh74+$numi74+$numo74;                
               $rawData[]=array(
                        'id'=>74,
                        'pname'=>'21.3  กลุ่มปกติ(ไม่เสี่ยงต่ออัมพฤกษ์ อัมพาต)(ผิดปกติ 0-1 ข้อ)',
                        'numh' => @number_format($numh74),
                        'numi' => @number_format($numi74),                    
                        'numo' => @number_format($numo74),
                        'total' => @number_format($total74)  
               );                
               $sql213="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;";    
               $sql214="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                          
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;";   
               $sql215="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                          
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;";                                           
               $numh75 = \Yii::$app->db1->createCommand($sql213)->query()->rowCount;
               $numi75 = \Yii::$app->db1->createCommand($sql214)->query()->rowCount;
               $numo75 = \Yii::$app->db1->createCommand($sql215)->query()->rowCount;
               $total75 = $numh75+$numi75+$numo75;                
               $rawData[]=array(
                        'id'=>75,
                        'pname'=>'21.4   กลุ่มเสี่ยงสูง(ผิดปกติ 2 ข้อ)',
                        'numh' => @number_format($numh75),
                        'numi' => @number_format($numi75),                    
                        'numo' => @number_format($numo75),
                        'total' => @number_format($total75)  
                );  
               $sql216="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;";    
               $sql217="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                          
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;";   
               $sql218="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                          
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;";                
               $numh76 = \Yii::$app->db1->createCommand($sql216)->query()->rowCount;
               $numi76 = \Yii::$app->db1->createCommand($sql217)->query()->rowCount;
               $numo76 = \Yii::$app->db1->createCommand($sql218)->query()->rowCount;
               $total76 = $numh76+$numi76+$numo76;                
               $rawData[]=array(
                        'id'=>76,
                        'pname'=>'21.5  กลุ่มเสี่ยงสูงปานกลาง(ผิดปกติ 3-5 ข้อ)',
                        'numh' => @number_format($numh76),
                        'numi' => @number_format($numi76),                    
                        'numo' => @number_format($numo76),
                        'total' => @number_format($total76)  
                          );                                              
               $sql219="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;";    
               $sql220="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart)='3104'                                          
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;";   
               $sql221="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='001' and c.clinic_member_status_id in ('3','11') 
                                            and concat(p.chwpart,p.amppart) !='3104'                                          
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;";                
               $numh77 = \Yii::$app->db1->createCommand($sql219)->query()->rowCount;
               $numi77 = \Yii::$app->db1->createCommand($sql220)->query()->rowCount;
               $numo77 = \Yii::$app->db1->createCommand($sql221)->query()->rowCount;
               $total77 = $numh77+$numi77+$numo77;                
               $rawData[]=array(
                        'id'=>77,
                        'pname'=>'21.6  กลุ่มเสี่ยงสูงมาก(ผิดปกติ 6-9 ข้อ หรือมีปัจจัยข้อ 8 หรือ 9)',
                        'numh' => @number_format($numh77),
                        'numi' => @number_format($numi77),                    
                        'numo' => @number_format($numo77),
                        'total' => @number_format($total77)  
                          );                 
            break;
            case 2:
                $sql1 = "select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00')))) ;";
                $sql2 = "select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                            and concat(p.chwpart,p.amppart)='3104' ;";      
                $sql3 = "select count(*) cc from clinicmember c inner join patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                            and concat(p.chwpart,p.amppart) !='3104' ;";                     
                $numh1 = \Yii::$app->db1->createCommand($sql1)->queryScalar();                
                $numi1 = \Yii::$app->db1->createCommand($sql2)->queryScalar();
                $numo1 = \Yii::$app->db1->createCommand($sql3)->queryScalar();
                $total1 = $numh1+$numi1 + $numo1;
                $rawData[] = array(
                      'id' => 1,
                      'pname' => '1.  จำนวนผู้ป่วยความดันทั้งหมด',
                      'numh' => @number_format($numh1),
                      'numi' => @number_format($numi1),                    
                      'numo' => @number_format($numo1),
                      'total' => @number_format($total1)  
                );  
               $sql4="select count(*) cc
                            from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))
                            and c.hn not in (select hn from clinicmember where clinic='001');"; 
               $sql5="select count(*) cc
                            from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                            and concat(p.chwpart,p.amppart)='3104'
                            and c.hn not in (select hn from clinicmember where clinic='001');"; 
               $sql6="select count(*) cc
                            from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between  '{$date1}'  and '{$date2}'
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                            and concat(p.chwpart,p.amppart) !='3104'
                            and c.hn not in (select hn from clinicmember where clinic='001');";                             
                $numh2 = \Yii::$app->db1->createCommand($sql4)->queryScalar();                
                $numi2 = \Yii::$app->db1->createCommand($sql5)->queryScalar();
                $numo2 = \Yii::$app->db1->createCommand($sql6)->queryScalar();
                $total2 = $numh2+$numi2 + $numo2;
                $rawData[] = array(
                      'id'=> 2,
                      'pname' => '1.1   จำนวนผู้ป่วยความดันอย่างเดียว รายใหม่',
                      'numh' => @number_format($numh2),
                      'numi' => @number_format($numi2),                    
                      'numo' => @number_format($numo2),
                      'total' => @number_format($total2)  
                );
               $sql7="select count(*) cc
                            from clinicmember c inner join  patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                            and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                            and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                            or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                            and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                            
                            and c.hn not in (select hn from clinicmember where clinic='001');"; 
               $sql8="select count(*) cc
                            from clinicmember c inner join  patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                            and concat(p.chwpart,p.amppart)='3104'                        
                            and c.hn not in (select hn from clinicmember where clinic='001');";   
               $sql9="select count(*) cc
                            from clinicmember c inner join  patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                            and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                            and concat(p.chwpart,p.amppart) !='3104'                        
                            and c.hn not in (select hn from clinicmember where clinic='001');";                              
                $numh3 = \Yii::$app->db1->createCommand($sql7)->queryScalar();                
                $numi3 = \Yii::$app->db1->createCommand($sql8)->queryScalar();
                $numo3 = \Yii::$app->db1->createCommand($sql9)->queryScalar();
                $total3 = $numh3+$numi3 + $numo3;
                $rawData[] = array(
                      'id' => 3,
                      'pname' => '1.2   จำนวนผู้ป่วยความดันอย่างเดียว รายเก่า',
                      'numh' => @number_format($numh3),
                      'numi' => @number_format($numi3),                    
                      'numo' => @number_format($numo3),
                      'total' => @number_format($total3)  
                );  
               $sql10="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                     and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                     and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                     or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                     and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                       
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";
               $sql11="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                     and concat(p.chwpart,p.amppart)='3104'                                     
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;"; 
               $sql12="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join patient p on c.hn=p.hn where c.regdate between '{$date1}' and '{$date2}'
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                     and concat(p.chwpart,p.amppart) !='3104'                                     
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";                                      
                $numh4 = \Yii::$app->db1->createCommand($sql10)->queryScalar();                
                $numi4 = \Yii::$app->db1->createCommand($sql11)->queryScalar();
                $numo4 = \Yii::$app->db1->createCommand($sql12)->queryScalar();
                $total4 = $numh4+$numi4 + $numo4;
                $rawData[] = array(
                      'id' => 4,
                      'pname' => '1.3   จำนวนผู้ป่วยความดัน รายใหม่และเป็นผู้ป่วยเบาหวานร่วม',
                      'numh' => @number_format($numh4),
                      'numi' => @number_format($numi4),                    
                      'numo' => @number_format($numo4),
                      'total' => @number_format($total4)  
                ); 
               $sql13="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                     and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                     and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                     or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                     and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                        
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;"; 
               $sql14="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                     and concat(p.chwpart,p.amppart)='3104'                                      
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;"; 
               $sql15="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join patient p on c.hn=p.hn where c.regdate < '{$date1}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                     and concat(p.chwpart,p.amppart) !='3104'                                      
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";                                          
                $numh5 = \Yii::$app->db1->createCommand($sql13)->queryScalar();                
                $numi5 = \Yii::$app->db1->createCommand($sql14)->queryScalar();
                $numo5 = \Yii::$app->db1->createCommand($sql15)->queryScalar();
                $total5 = $numh5+$numi5 + $numo5;
                $rawData[] = array(
                      'id' => 5,
                      'pname' => '1.4   จำนวนผู้ป่วยความดัน รายเก่าและเป็นผู้ป่วยเบาหวานร่วม',
                      'numh' => @number_format($numh5),
                      'numi' => @number_format($numi5),                    
                      'numo' => @number_format($numo5),
                      'total' => @number_format($total5)  
                );        
                $sql16 = "select count(*) cc from clinicmember c inner join  patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                             and c.clinic='002' and c.clinic_member_status_id in ('3')
                             and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                             and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                             or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                             and (p.moopart between '29' and '34' or p.moopart in ('','0','00')))) ;";   
                $sql17 = "select count(*) cc from clinicmember c inner join  patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                             and c.clinic='002' and c.clinic_member_status_id in ('3')
                             and concat(p.chwpart,p.amppart)='3104' ;";   
                $sql18 = "select count(*) cc from clinicmember c inner join  patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                             and c.clinic='002' and c.clinic_member_status_id in ('3')
                             and concat(p.chwpart,p.amppart) !='3104' ;";                   
                $numh6 = \Yii::$app->db1->createCommand($sql16)->queryScalar();                
                $numi6 = \Yii::$app->db1->createCommand($sql17)->queryScalar();
                $numo6 = \Yii::$app->db1->createCommand($sql18)->queryScalar();
                $total6 = $numh6+$numi6 + $numo6;
                $rawData[] = array(
                      'id' => 6,
                      'pname' => '1.5   จำนวนผู้ป่วยความดันที่ยังรักษาอยู่',
                      'numh' => @number_format($numh6),
                      'numi' => @number_format($numi6),                    
                      'numo' => @number_format($numo6),
                      'total' => @number_format($total6)  
                ); 
               $sql19="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join  patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                     
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";          
               $sql20="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join  patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'                                
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";     
               $sql21="select  count(*) cc
                            from 
                                    (select c.hn,c.clinic
                                     from clinicmember c inner join  patient p on c.hn=p.hn where c.regdate <= '{$date2}' 
                                     and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'                                
                             ) as a 
                              inner join (select hn,clinic from clinicmember where clinic='001') as b
                              on a.hn=b.hn;";                                          
                $numh7 = \Yii::$app->db1->createCommand($sql19)->queryScalar();                
                $numi7 = \Yii::$app->db1->createCommand($sql20)->queryScalar();
                $numo7 = \Yii::$app->db1->createCommand($sql21)->queryScalar();
                $total7 = $numh7+$numi7 + $numo7;
                $rawData[] = array(
                      'id' => 7,
                      'pname' => '2   จำนวนผู้ป่วยความดันและเบาหวาน(เป็นทั้ง 2 โรค)',
                      'numh' => @number_format($numh7),
                      'numi' => @number_format($numi7),                    
                      'numo' => @number_format($numo7),
                      'total' => @number_format($total7)  
                );  
               $sql22="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn  
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                   
                             order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn  group by a.hn;";  
               $sql23="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn  
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'                               
                             order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn  group by a.hn;"; 
               $sql24="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn  
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'                               
                             order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn  group by a.hn;";                                
                $numh8 = \Yii::$app->db1->createCommand($sql22)->query()->rowCount;                
                $numi8 = \Yii::$app->db1->createCommand($sql23)->query()->rowCount;
                $numo8 = \Yii::$app->db1->createCommand($sql24)->query()->rowCount;
                $total8 = $numh8+$numi8 + $numo8;
                $rawData[] = array(
                      'id' => 8,
                      'pname' => '3   จำนวนผู้ป่วยความดันโลหิตสูงที่มารับบริการในช่วงเวลาที่กำหนดและได้วัดความดันโลหิต(คน)',
                      'numh' => @number_format($numh8),
                      'numi' => @number_format($numi8),                    
                      'numo' => @number_format($numo8),
                      'total' => @number_format($total8)  
                );  
               $sql25="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn,o.bps,o.bpd from clinicmember c inner join patient p on c.hn=p.hn  
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between '{$date1}' and '{$date2}' 
                                       and c.clinic='002' and c.clinic_member_status_id in ('3','11')
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                        
                                    and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                              where o.bps<140 and o.bpd<90;";
               $sql26="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn,o.bps,o.bpd from clinicmember c inner join patient p on c.hn=p.hn  
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between '{$date1}' and '{$date2}' 
                                       and c.clinic='002' and c.clinic_member_status_id in ('3','11')
                                    and concat(p.chwpart,p.amppart)='3104'                                      
                                    and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                              where o.bps<140 and o.bpd<90;";   
               $sql27="select count(*) cc
                                from
                                     (select o.hn,max(o.vn) vn,o.bps,o.bpd from clinicmember c inner join patient p on c.hn=p.hn  
                                       left outer join opdscreen o on c.hn=o.hn where o.vstdate between '{$date1}' and '{$date2}' 
                                       and c.clinic='002' and c.clinic_member_status_id in ('3','11')
                                    and concat(p.chwpart,p.amppart) !='3104'                                      
                                    and o.bps>0 and o.bpd>0 group by o.hn
                               ) as a
                               inner join opdscreen o on a.vn=o.vn
                              where o.bps<140 and o.bpd<90;";                                         
                $numh9 = \Yii::$app->db1->createCommand($sql25)->queryScalar(); 
                $numi9 = \Yii::$app->db1->createCommand($sql26)->queryScalar();
                $numo9 = \Yii::$app->db1->createCommand($sql27)->queryScalar();
                $total9 = $numh9+$numi9 + $numo9;
                $rawData[] = array(
                      'id' => 9,
                      'pname' => '3.1  จำนวนผู้ป่วยความดันที่มีระดับความดันโลหิตครั้งล่าสุดอยู่ในเกณฑ์ ที่ควบคุมได้(SBP<140,DBP<90 mmHg)(คน)',
                      'numh' => @number_format($numh9),
                      'numi' => @number_format($numi9),                    
                      'numo' => @number_format($numo9),
                      'total' => @number_format($total9)  
                ); 
               $sql28="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn   
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                  
                             order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn ;";    
               $sql29="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn   
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'                          
                             order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn ;";        
               $sql30="select count(*) cc
                        from 
                             (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn   
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'                          
                             order by c.hn
                        ) as a
                        inner join
                            (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' and bps>0 and bpd>0 
                        ) as b  on a.hn=b.hn ;";                               
                $numh10 = \Yii::$app->db1->createCommand($sql28)->queryScalar(); 
                $numi10 = \Yii::$app->db1->createCommand($sql29)->queryScalar();
                $numo10 = \Yii::$app->db1->createCommand($sql30)->queryScalar();
                $total10 = $numh10+$numi10 + $numo10;
                $rawData[] = array(
                      'id' => 10,
                      'pname' => '3.2  จำนวนครั้งที่มารับบริการและได้รับการวัดความดันโลหิต',
                      'numh' => @number_format($numh10),
                      'numi' => @number_format($numi10),                    
                      'numo' => @number_format($numo10),
                      'total' => @number_format($total10)  
                );    
               $sql31="select count(*) cc
                        from ( 
                            select a.hn,b.vn,b.vstdate,b.bps,b.bpd
                                 from 
                                     (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn
                                    where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                      
                                    order by c.hn
                             ) as a
                             inner join
                                    (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                                        and bps>0 and bpd>0
                             ) as b  on a.hn=b.hn
                        ) as c
                        inner join opdscreen o on o.vn=c.vn where  o.bps<140 and o.bpd<90;";         
               $sql32="select count(*) cc
                        from ( 
                            select a.hn,b.vn,b.vstdate,b.bps,b.bpd
                                 from 
                                     (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn
                                    where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'                                 
                                    order by c.hn
                             ) as a
                             inner join
                                    (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                                        and bps>0 and bpd>0
                             ) as b  on a.hn=b.hn
                        ) as c
                        inner join opdscreen o on o.vn=c.vn where  o.bps<140 and o.bpd<90;";    
               $sql33="select count(*) cc
                        from ( 
                            select a.hn,b.vn,b.vstdate,b.bps,b.bpd
                                 from 
                                     (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn
                                    where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'                                 
                                    order by c.hn
                             ) as a
                             inner join
                                    (select hn,vn,bps,bpd,vstdate from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                                        and bps>0 and bpd>0
                             ) as b  on a.hn=b.hn
                        ) as c
                        inner join opdscreen o on o.vn=c.vn where  o.bps<140 and o.bpd<90;";                                      
                $numh11 = \Yii::$app->db1->createCommand($sql31)->queryScalar(); 
                $numi11 = \Yii::$app->db1->createCommand($sql32)->queryScalar();
                $numo11 = \Yii::$app->db1->createCommand($sql33)->queryScalar();
                $total11 = $numh11+$numi11 + $numo11;
                $rawData[] = array(
                      'id' => 11,
                      'pname' => '3.3  จำนวนครั้งที่มารับบริการและได้รับการวัดความดันโลหิตและ และค่าความดันอยู่ในเกณฑ์ที่ควบคุมได้(SBP<140,DBP<90 mmHg)',
                      'numh' => @number_format($numh11),
                      'numi' => @number_format($numi11),                    
                      'numo' => @number_format($numo11),
                      'total' => @number_format($total11)  
                );  
               $sql34="select count(*) cc
                             from 
                                (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                    and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                    or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                    and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                    
                                order by c.hn
                             ) as a
                             inner join
                                (select hn,vn,bps,bpd,vstdate,pe from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                             ) as b  on a.hn=b.hn
                             inner join clinic_visit v on b.vn=v.vn where v.clinic='002' and v.visit_type in (1,2);"; 
               $sql35="select count(*) cc
                             from 
                                (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart)='3104'                                  
                                order by c.hn
                             ) as a
                             inner join
                                (select hn,vn,bps,bpd,vstdate,pe from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                             ) as b  on a.hn=b.hn
                             inner join clinic_visit v on b.vn=v.vn where v.clinic='002' and v.visit_type in (1,2);";   
               $sql36="select count(*) cc
                             from 
                                (select c.hn,c.clinic from clinicmember c inner join patient p on c.hn=p.hn
                                where  c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                    and concat(p.chwpart,p.amppart) !='3104'                                  
                                order by c.hn
                             ) as a
                             inner join
                                (select hn,vn,bps,bpd,vstdate,pe from opdscreen where vstdate between '{$date1}' and '{$date2}' 
                             ) as b  on a.hn=b.hn
                             inner join clinic_visit v on b.vn=v.vn where v.clinic='002' and v.visit_type in (1,2);";                                   
                $numh12 = \Yii::$app->db1->createCommand($sql34)->queryScalar(); 
                $numi12 = \Yii::$app->db1->createCommand($sql35)->queryScalar();
                $numo12 = \Yii::$app->db1->createCommand($sql36)->queryScalar();
                $total12 = $numh12+$numi12 + $numo12;
                $rawData[] = array(
                      'id' => 12,
                      'pname' => '4.   การได้รับการตรวจร่างกายประจำปี(คน)',
                      'numh' => @number_format($numh12),
                      'numi' => @number_format($numi12),                    
                      'numo' => @number_format($numo12),
                      'total' => @number_format($total12)  
                );  
               $sql37="select  count(*) cc
                        from
                            (select a.hn,b.vn,b.lab_order_number,b.code,b.cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                        where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                        and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                        and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                        or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                        and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn order by b.hn
                        ) as c 
                        inner join 
                                 (select l.vn,group_concat(lo.lab_items_code) code,count(*) cc from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number  
                                    where lo.lab_items_code in  ('92','78','486') group by lo.lab_order_number having cc>=3
                        ) as d
                       on c.vn=d.vn;";   
               $sql38="select  count(*) cc
                        from
                            (select a.hn,b.vn,b.lab_order_number,b.code,b.cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                        where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                        and concat(p.chwpart,p.amppart)='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn order by b.hn
                        ) as c 
                        inner join 
                                 (select l.vn,group_concat(lo.lab_items_code) code,count(*) cc from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number  
                                    where lo.lab_items_code in  ('92','78','486') group by lo.lab_order_number having cc>=3
                        ) as d
                       on c.vn=d.vn;";    
               $sql39="select  count(*) cc
                        from
                            (select a.hn,b.vn,b.lab_order_number,b.code,b.cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                        where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                        and concat(p.chwpart,p.amppart) !='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn order by b.hn
                        ) as c 
                        inner join 
                                 (select l.vn,group_concat(lo.lab_items_code) code,count(*) cc from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number  
                                    where lo.lab_items_code in  ('92','78','486') group by lo.lab_order_number having cc>=3
                        ) as d
                       on c.vn=d.vn;";                                       
                $numh13 = \Yii::$app->db1->createCommand($sql37)->queryScalar(); 
                $numi13 = \Yii::$app->db1->createCommand($sql38)->queryScalar();
                $numo13 = \Yii::$app->db1->createCommand($sql39)->queryScalar();
                $total13 = $numh13+$numi13 + $numo13;
                $rawData[] = array(
                      'id' => 13,
                      'pname' => '5.   การได้รับการตรวจทางห้องปฎิบัติการประจำปี(Electrolyte,LDL,Cr,Urine Albumin(Macroalbumin))(คน)',
                      'numh' => @number_format($numh13),
                      'numi' => @number_format($numi13),                    
                      'numo' => @number_format($numo13),
                      'total' => @number_format($total13)                                      
               ); 
        $sql40="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                       where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                        and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                        and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                        or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                        and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                               
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";     
        $sql41="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                       where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                        and concat(p.chwpart,p.amppart)='3104'                                 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";   
        $sql42="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                       where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                        and concat(p.chwpart,p.amppart) !='3104'                                 
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in  ('80','81','82','83')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";                                       
                $numh14 = \Yii::$app->db1->createCommand($sql40)->query()->rowCount; 
                $numi14 = \Yii::$app->db1->createCommand($sql41)->query()->rowCount;
                $numo14 = \Yii::$app->db1->createCommand($sql42)->query()->rowCount;
                $total14 = $numh14+$numi14 + $numo14;
                $rawData[] = array(
                      'id' => 14,
                      'pname' => '6.  จำนวนผู้ป่วยความดันที่ได้รับการตรวจ Electrolyte(คน)',
                      'numh' => @number_format($numh14),
                      'numi' => @number_format($numi14),                    
                      'numo' => @number_format($numo14),
                      'total' => @number_format($total14)                     
               );      
               $sql43="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                        where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                        and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                        and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                        or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                        and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                       
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";  
               $sql44="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                        where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                        and concat(p.chwpart,p.amppart)='3104'                                    
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";     
               $sql45="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                        where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                        and concat(p.chwpart,p.amppart) !='3104'                                    
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn group by b.hn;";                                       
                $numh15 = \Yii::$app->db1->createCommand($sql43)->query()->rowCount; 
                $numi15 = \Yii::$app->db1->createCommand($sql44)->query()->rowCount;
                $numo15 = \Yii::$app->db1->createCommand($sql45)->query()->rowCount;
                $total15 = $numh15+$numi15 + $numo15;
                $rawData[] = array(
                      'id' => 15,
                      'pname' => '7.  จำนวนผู้ป่วยความดันที่ได้รับการตรวจ Lipid Profile(คน)',
                      'numh' => @number_format($numh15),
                      'numi' => @number_format($numi15),                    
                      'numo' => @number_format($numo15),
                      'total' => @number_format($total15)                     
               );                 
        $sql46="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join  patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                            
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' group by c.hn  order by c.hn;";   
        $sql47="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join  patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' group by c.hn  order by c.hn;";   
        $sql48="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' group by c.hn  order by c.hn;";                                      
                $numh16 = \Yii::$app->db1->createCommand($sql46)->query()->rowCount; 
                $numi16 = \Yii::$app->db1->createCommand($sql47)->query()->rowCount;
                $numo16 = \Yii::$app->db1->createCommand($sql48)->query()->rowCount;
                $total16 = $numh16+$numi16 + $numo16;
                $rawData[] = array(
                      'id' => 16,
                      'pname' => '7.1  จำนวนผู้ป่วยความดันที่ได้รับการตรวจ LDL (คน)',
                      'numh' => @number_format($numh16),
                      'numi' => @number_format($numi16),                    
                      'numo' => @number_format($numo16),
                      'total' => @number_format($total16)                     
               ); 
        $sql49="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                            
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' and lo.lab_order_result<100 group by c.hn order by c.hn;"; 
        $sql50="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                          
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' and lo.lab_order_result<100 group by c.hn order by c.hn;";                                    
        $sql51="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                          
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92' and lo.lab_order_result<100 group by c.hn order by c.hn;";                                      
                $numh17 = \Yii::$app->db1->createCommand($sql49)->query()->rowCount; 
                $numi17 = \Yii::$app->db1->createCommand($sql50)->query()->rowCount;
                $numo17 = \Yii::$app->db1->createCommand($sql51)->query()->rowCount;
                $total17 = $numh17+$numi17 + $numo17;
                $rawData[] = array(
                      'id' => 17,
                      'pname' => '7.2  จำนวนผู้ป่วยความดันที่ได้รับการตรวจ LDL และมีค่า <100 mg/dl(คน)',
                      'numh' => @number_format($numh17),
                      'numi' => @number_format($numi17),                    
                      'numo' => @number_format($numo17),
                      'total' => @number_format($total17)                     
               );      
        $sql52="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92';"; 
        $sql53="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                        
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92';"; 
        $sql54="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                        
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92';";                                     
                $numh18 = \Yii::$app->db1->createCommand($sql52)->queryScalar(); 
                $numi18 = \Yii::$app->db1->createCommand($sql53)->queryScalar();
                $numo18 = \Yii::$app->db1->createCommand($sql54)->queryScalar();
                $total18 = $numh18+$numi18 + $numo18;
                $rawData[] = array(
                      'id' => 18,
                      'pname' => '7.3   จำนวนครั้งของผู้ป่วยความดันที่ได้รับการตรวจ LDL',
                      'numh' => @number_format($numh18),
                      'numi' => @number_format($numi18),                    
                      'numo' => @number_format($numo18),
                      'total' => @number_format($total18)    
               );  
        $sql55="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                            
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92'  and lo.lab_order_result<100 ;"; 
        $sql56="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92'  and lo.lab_order_result<100 ;"; 
        $sql57="select count(*) cc
                        from 
                                (select b.hn,b.lab_order_number
                                   from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,group_concat(lo.lab_items_code) code ,count(*) cc
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('102','92','91','103')
                                    and lo.lab_order_result>0 group by lo.lab_order_number having cc>=4
                             ) as b
                             on a.vn=b.vn 
                         ) as c
                          inner join lab_order lo on c.lab_order_number=lo.lab_order_number
                       where lo.lab_items_code='92'  and lo.lab_order_result<100 ;";                                     
                $numh19 = \Yii::$app->db1->createCommand($sql55)->queryScalar(); 
                $numi19 = \Yii::$app->db1->createCommand($sql56)->queryScalar();
                $numo19 = \Yii::$app->db1->createCommand($sql57)->queryScalar();
                $total19 = $numh19+$numi19 + $numo19;
                $rawData[] = array(
                      'id' => 19,
                      'pname' => '7.4  จำนวนครั้งของผู้ป่วยความดันที่ได้รับการตรวจ LDL และมีค่า <100 mg/dl',
                      'numh' => @number_format($numh19),
                      'numi' => @number_format($numi19),                    
                      'numo' => @number_format($numo19),
                      'total' => @number_format($total19)    
               );  
               $sql58="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>0 
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";    
               $sql59="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                     
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>0 
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";    
               $sql60="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                     
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>0 
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";                                     
                $numh20 = \Yii::$app->db1->createCommand($sql58)->query()->rowCount; 
                $numi20 = \Yii::$app->db1->createCommand($sql59)->query()->rowCount;
                $numo20 = \Yii::$app->db1->createCommand($sql60)->query()->rowCount;
                $total20 = $numh20+$numi20 + $numo20;
                $rawData[] = array(
                      'id' => 20,
                      'pname' => '8.  จำนวนผู้ป่วยความดันที่ได้รับการตรวจ Creatinine (คน)',
                      'numh' => @number_format($numh20),
                      'numi' => @number_format($numi20),                    
                      'numo' => @number_format($numo20),
                      'total' => @number_format($total20)    
               );
               $sql61="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.sex='2'
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.4
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";    
               $sql62="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.sex='2'
                                         and concat(p.chwpart,p.amppart)='3104'                                     
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.4
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;"; 
               $sql63="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.sex='2'
                                         and concat(p.chwpart,p.amppart) !='3104'                                     
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.4
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";                                       
                $numh21 = \Yii::$app->db1->createCommand($sql61)->query()->rowCount; 
                $numi21 = \Yii::$app->db1->createCommand($sql62)->query()->rowCount;
                $numo21 = \Yii::$app->db1->createCommand($sql63)->query()->rowCount;
                $total21 = $numh21+$numi21 + $numo21;
                $rawData[] = array(
                      'id' => 21,
                      'pname' => '8.1  จำนวนผู้ป่วยความดันเพศหญิงที่มี Creatinine>=1.4 (คน)',
                      'numh' => @number_format($numh21),
                      'numi' => @number_format($numi21),                    
                      'numo' => @number_format($numo21),
                      'total' => @number_format($total21)     
               );
               $sql64="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.sex='1'
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                          
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.5
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";  
               $sql65="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.sex='1'
                                         and concat(p.chwpart,p.amppart)='3104'                                       
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.5
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";  
               $sql66="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') and p.sex='1'
                                         and concat(p.chwpart,p.amppart) !='3104'                                       
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('78')
                                    and lo.lab_order_result>=1.5
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";     
                $numh22 = \Yii::$app->db1->createCommand($sql64)->query()->rowCount; 
                $numi22 = \Yii::$app->db1->createCommand($sql65)->query()->rowCount;
                $numo22 = \Yii::$app->db1->createCommand($sql66)->query()->rowCount;
                $total22 = $numh22+$numi22 + $numo22;
                $rawData[] = array(
                      'id' => 22,
                      'pname' => '8.2  จำนวนผู้ป่วยความดันเพศชายที่มี Creatinine>=1.5 (คน)',
                      'numh' => @number_format($numh22),
                      'numi' => @number_format($numi22),                    
                      'numo' => @number_format($numo22),
                      'total' => @number_format($total22)     
               ); 
               $sql67="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                          
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('486')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='')
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";  
               $sql68="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('486')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='')
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";        
               $sql69="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('486')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='')
                             ) as b
                             on a.vn=b.vn  group by b.hn order by b.hn;";     
                $numh23 = \Yii::$app->db1->createCommand($sql67)->query()->rowCount; 
                $numi23 = \Yii::$app->db1->createCommand($sql68)->query()->rowCount;
                $numo23 = \Yii::$app->db1->createCommand($sql69)->query()->rowCount;
                $total23 = $numh23+$numi23 + $numo23;
                $rawData[] = array(
                      'id' => 23,
                      'pname' => '9.  จำนวนผู้ป่วยความดันที่ได้รับการตรวจ Urine Protient (คน)',
                      'numh' => @number_format($numh23),
                      'numi' => @number_format($numi23),                    
                      'numo' => @number_format($numo23),
                      'total' => @number_format($total23)     
               );  
                $sql70="select count(*) cc
                        from                
                             (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                            
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                        where lo.lab_items_code in ('1030')
                        ) as d  on c.vn=d.vn ;";  
                $sql71="select count(*) cc
                        from                
                             (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                       
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                        where lo.lab_items_code in ('1030')
                        ) as d  on c.vn=d.vn ;";  
                $sql72="select count(*) cc
                        from                
                             (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                       
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                        where lo.lab_items_code in ('1030')
                        ) as d  on c.vn=d.vn ;";    
                $numh24 = \Yii::$app->db1->createCommand($sql70)->queryScalar(); 
                $numi24 = \Yii::$app->db1->createCommand($sql71)->queryScalar();
                $numo24 = \Yii::$app->db1->createCommand($sql72)->queryScalar();
                $total24 = $numh24+$numi24 + $numo24;
                $rawData[] = array(
                      'id' => 24,
                      'pname' => '10.  ผู้ป่วยความดันโลหิตที่มีภาวะแทรกซ้อนทางไต(CKD-EPI) (คน)',
                      'numh' => @number_format($numh24),
                      'numi' => @number_format($numi24),                    
                      'numo' => @number_format($numo24),
                      'total' => @number_format($total24)     
               );                                     
               $sql73="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result>=90;";    
               $sql74="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result>=90;";                                        
               $sql75="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result>=90;";    
                $numh25 = \Yii::$app->db1->createCommand($sql73)->queryScalar(); 
                $numi25 = \Yii::$app->db1->createCommand($sql74)->queryScalar();
                $numo25 = \Yii::$app->db1->createCommand($sql75)->queryScalar();
                $total25 = $numh25+$numi25 + $numo25;
                $rawData[] = array(
                      'id' => 25,
                      'pname' => '10.1  ระยะที่ 1 (GFR>=90 ml/min)',
                      'numh' => @number_format($numh25),
                      'numi' => @number_format($numi25),                    
                      'numo' => @number_format($numo25),
                      'total' => @number_format($total25)     
               );  
               $sql76="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 60 and 89 ;";    
               $sql77="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 60 and 89 ;";                                        
               $sql78="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 60 and 89 ;";    
                $numh26 = \Yii::$app->db1->createCommand($sql76)->queryScalar(); 
                $numi26 = \Yii::$app->db1->createCommand($sql77)->queryScalar();
                $numo26 = \Yii::$app->db1->createCommand($sql78)->queryScalar();
                $total26 = $numh26+$numi26 + $numo26;
                $rawData[] = array(
                      'id' => 26,
                      'pname' => ' 10.2  ระยะที่ 2 (GFR 60-89 ml/min)',
                      'numh' => @number_format($numh26),
                      'numi' => @number_format($numi26),                    
                      'numo' => @number_format($numo26),
                      'total' => @number_format($total26)     
               );   
               $sql79="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 30 and 59 ;";    
               $sql80="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 30 and 59 ;";                                        
               $sql81="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 30 and 59 ;";    
                $numh27 = \Yii::$app->db1->createCommand($sql79)->queryScalar(); 
                $numi27 = \Yii::$app->db1->createCommand($sql80)->queryScalar();
                $numo27 = \Yii::$app->db1->createCommand($sql81)->queryScalar();
                $total27 = $numh27+$numi27 + $numo27;
                $rawData[] = array(
                      'id' => 27,
                      'pname' => '  10.3  ระยะที่ 3 (GFR 30-59 ml/min) ',
                      'numh' => @number_format($numh27),
                      'numi' => @number_format($numi27),                    
                      'numo' => @number_format($numo27),
                      'total' => @number_format($total27)     
               );   
               $sql82="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 15 and 29 ;";    
               $sql83="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 15 and 29 ;";                                        
               $sql84="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result between 15 and 29 ;";    
                $numh28 = \Yii::$app->db1->createCommand($sql82)->queryScalar(); 
                $numi28 = \Yii::$app->db1->createCommand($sql83)->queryScalar();
                $numo28 = \Yii::$app->db1->createCommand($sql84)->queryScalar();
                $total28 = $numh28+$numi28 + $numo28;
                $rawData[] = array(
                      'id' => 28,
                      'pname' => ' 10.4  ระยะที่ 4 (GFR 15-29 ml/min) ',
                      'numh' => @number_format($numh28),
                      'numi' => @number_format($numi28),                    
                      'numo' => @number_format($numo28),
                      'total' => @number_format($total28)     
               );   
               $sql85="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result <15 ;";    
               $sql86="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result <15 ;";                                        
               $sql87="select count(*) cc
                            from                
                                (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                    from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                         where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                         
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('1030')
                                    and (lo.lab_order_result is not null or lo.lab_order_result !='') group by l.hn
                             ) as b
                             on a.vn=b.vn   order by b.hn
                        ) as c
                        inner join 
                                 (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                        where lo.lab_items_code in ('1030')
                        ) as d   on c.vn=d.vn   where d.lab_order_result <15 ;";    
                $numh29 = \Yii::$app->db1->createCommand($sql85)->queryScalar(); 
                $numi29 = \Yii::$app->db1->createCommand($sql86)->queryScalar();
                $numo29 = \Yii::$app->db1->createCommand($sql87)->queryScalar();
                $total29 = $numh29+$numi29 + $numo29;
                $rawData[] = array(
                      'id' => 29,
                      'pname' => '10.5  ระยะที่ 5 (GFR<15 ml/min) ',
                      'numh' => @number_format($numh29),
                      'numi' => @number_format($numi29),                    
                      'numo' => @number_format($numo29),
                      'total' => @number_format($total29)     
               );   
               $sql88="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0
                             ) as b
                             on a.vn=b.vn group by a.hn order by b.hn;";   
               $sql89="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                          
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0
                             ) as b
                             on a.vn=b.vn group by a.hn order by b.hn;";  
               $sql90="select count(*) cc
                                from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                          
                             ) as a             
                             inner join 
                                    (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}' and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0
                             ) as b
                             on a.vn=b.vn group by a.hn order by b.hn;";       
                $numh30 = \Yii::$app->db1->createCommand($sql88)->query()->rowCount; 
                $numi30 = \Yii::$app->db1->createCommand($sql89)->query()->rowCount;
                $numo30 = \Yii::$app->db1->createCommand($sql90)->query()->rowCount;
                $total30 = $numh30+$numi30 + $numo30;
                $rawData[] = array(
                      'id' => 30,
                      'pname' => ' 11.  จำนวนผู้ป่วยความดันที่ได้รับการตรวจระดับน้ำตาลในเลือดแบบอดอาหาร(FBS) (คน) ',
                      'numh' => @number_format($numh30),
                      'numi' => @number_format($numi30),                    
                      'numo' => @number_format($numo30),
                      'total' => @number_format($total30)     
               ); 
               $sql91="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result <100;";  
               $sql92="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result <100;";  
               $sql93="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result <100;";  
                $numh31 = \Yii::$app->db1->createCommand($sql91)->queryScalar(); 
                $numi31 = \Yii::$app->db1->createCommand($sql92)->queryScalar();
                $numo31 = \Yii::$app->db1->createCommand($sql93)->queryScalar();
                $total31 = $numh31+$numi31 + $numo31;
                $rawData[] = array(
                      'id' => 31,
                      'pname' => ' 11.1  จำนวนผู้ป่วยความดันที่ได้รับการตรวจระดับน้ำตาลในเลือดแบบอดอาหาร และม่ค่า<100 (คน) ',
                      'numh' => @number_format($numh31),
                      'numi' => @number_format($numi31),                    
                      'numo' => @number_format($numo31),
                      'total' => @number_format($total31)     
               );   
               $sql94="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result between 100 and 125 ;";  
               $sql95="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result between 100 and 125 ;";  
               $sql96="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result between 100 and 125 ;";  
                $numh32 = \Yii::$app->db1->createCommand($sql94)->queryScalar(); 
                $numi32 = \Yii::$app->db1->createCommand($sql95)->queryScalar();
                $numo32 = \Yii::$app->db1->createCommand($sql96)->queryScalar();
                $total32 = $numh32+$numi32 + $numo32;
                $rawData[] = array(
                      'id' => 32,
                      'pname' => ' 11.2  จำนวนผู้ป่วยความดันที่ได้รับการตรวจระดับน้ำตาลในเลือดแบบอดอาหาร และม่ค่า 100-125 (คน) ',
                      'numh' => @number_format($numh32),
                      'numi' => @number_format($numi32),                    
                      'numo' => @number_format($numo32),
                      'total' => @number_format($total32)     
               );          
               $sql97="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result >=126 ;";  
               $sql98="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart)='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result >=126 ;";  
               $sql99="select  count(*) cc
                           from           
                              (select b.vn,b.hn,b.lab_order_number,b.lab_items_code,b.lab_order_result
                                  from 
                                    ( select v.vn,v.hn from clinicmember c inner join vn_stat v on c.hn=v.hn inner join patient p on c.hn=p.hn
                                          where c.clinic='002' and c.clinic_member_status_id in ('1','3') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                      
                             ) as a             
                             inner join 
                                    (select  l.hn,max(l.vn) vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l 
                                    inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where l.receive_date between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('76')
                                    and lo.lab_order_result >0 group by l.hn
                             ) as b
                             on a.vn=b.vn order by a.hn
                    ) as c
                    inner join 
                             (select  l.hn,l.vn,lo.lab_order_number,lo.lab_items_code,lo.lab_order_result
                                    from lab_head l inner join lab_order lo on l.lab_order_number=lo.lab_order_number
                                    where lo.lab_items_code in ('76')  and lo.lab_order_result >0
                    ) as d on c.vn=d.vn where d.lab_order_result>=126 ;";  
                $numh33 = \Yii::$app->db1->createCommand($sql97)->queryScalar(); 
                $numi33 = \Yii::$app->db1->createCommand($sql98)->queryScalar();
                $numo33 = \Yii::$app->db1->createCommand($sql99)->queryScalar();
                $total33 = $numh33+$numi33 + $numo33;
                $rawData[] = array(
                      'id' => 33,
                      'pname' => ' 11.3  จำนวนผู้ป่วยความดันที่ได้รับการตรวจระดับน้ำตาลในเลือดแบบอดอาหาร และม่ค่า >=126 (คน) ',
                      'numh' => @number_format($numh33),
                      'numi' => @number_format($numi33),                    
                      'numo' => @number_format($numo33),
                      'total' => @number_format($total33)     
               );
               $sql100="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}' and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                               
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
               $sql101="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}' and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                             
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
               $sql102="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}' and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                             
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";      
                $numh34 = \Yii::$app->db1->createCommand($sql100)->query()->rowCount; 
                $numi34 = \Yii::$app->db1->createCommand($sql101)->query()->rowCount;
                $numo34 = \Yii::$app->db1->createCommand($sql102)->query()->rowCount;
                $total34 = $numh34+$numi34 + $numo34;
                $rawData[] = array(
                      'id' => 34,
                      'pname' => ' 12.  จำนวนผู้ป่วยความดันที่ได้รับการตรวจภาวะแทรกซ้อนของหลอดเลือดหัวใจ (คน) ',
                      'numh' => @number_format($numh34),
                      'numi' => @number_format($numi34),                    
                      'numo' => @number_format($numo34),
                      'total' => @number_format($total34)     
               );     
               $sql103="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                                       
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where (do_cardiovascular_screen='Y' 
                                          or has_cardiovascular_cormobidity='Y')
                             ) as b
                             on a.vn=b.vn group by a.hn;"; 
               $sql104="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                                   
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where (do_cardiovascular_screen='Y' 
                                          or has_cardiovascular_cormobidity='Y')
                             ) as b
                             on a.vn=b.vn group by a.hn;";                                          
               $sql105="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                                   
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where (do_cardiovascular_screen='Y' 
                                          or has_cardiovascular_cormobidity='Y')
                             ) as b
                             on a.vn=b.vn group by a.hn;";                  
                $numh35 = \Yii::$app->db1->createCommand($sql103)->query()->rowCount; 
                $numi35 = \Yii::$app->db1->createCommand($sql104)->query()->rowCount;
                $numo35 = \Yii::$app->db1->createCommand($sql105)->query()->rowCount;
                $total35 = $numh35+$numi35 + $numo35;
                $rawData[] = array(
                      'id' => 35,
                      'pname' => ' 12.1  จำนวนคนที่พบภาวะแทรกซ้อนของหลอดเลือดหัวใจทั้งหมด (คน) ',
                      'numh' => @number_format($numh35),
                      'numi' => @number_format($numi35),                    
                      'numo' => @number_format($numo35),
                      'total' => @number_format($total35)     
               ); 
               $sql106="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y' 
                             ) as b
                             on a.vn=b.vn
                             inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                             where cs.has_cardiovascular_cormobidity='Y' group by a.hn;";  
               $sql107="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                          
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y' 
                             ) as b
                             on a.vn=b.vn 
                             inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                             where cs.has_cardiovascular_cormobidity='Y' group by a.hn;";  
               $sql108="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                          
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cardiovascular_screen,has_cardiovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cardiovascular_screen='Y' 
                             ) as b
                             on a.vn=b.vn 
                             inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                             where cs.has_cardiovascular_cormobidity='Y' group by a.hn;";                                           
                $numh36 = \Yii::$app->db1->createCommand($sql106)->query()->rowCount; 
                $numi36 = \Yii::$app->db1->createCommand($sql107)->query()->rowCount;
                $numo36 = \Yii::$app->db1->createCommand($sql108)->query()->rowCount;
                $total36 = $numh36+$numi36 + $numo36;
                $rawData[] = array(
                      'id' => 36,
                      'pname' => ' 12.2  จำนวนคนที่พบภาวะแทรกซ้อนของหลอดเลือดหัวใจ รายใหม่ (คน) ',
                      'numh' => @number_format($numh36),
                      'numi' => @number_format($numi36),                    
                      'numo' => @number_format($numo36),
                      'total' => @number_format($total36)     
               );    
               $sql109="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";   
               $sql110="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                        
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";     
               $sql111="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11')  
                                         and concat(p.chwpart,p.amppart) !='3104'                                        
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";                                            
                $numh37 = \Yii::$app->db1->createCommand($sql109)->query()->rowCount; 
                $numi37 = \Yii::$app->db1->createCommand($sql110)->query()->rowCount;
                $numo37 = \Yii::$app->db1->createCommand($sql111)->query()->rowCount;
                $total37 = $numh37+$numi37 + $numo37;
                $rawData[] = array(
                      'id' => 37,
                      'pname' => ' 13.  จำนวนผู้ป่วยความดันที่ได้รับการตรวจภาวะแทรกซ้อนของหลอดเลือดสมอง (คน)',
                      'numh' => @number_format($numh37),
                      'numi' => @number_format($numi37),                    
                      'numo' => @number_format($numo37),
                      'total' => @number_format($total37)     
               );    
               $sql112="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join  patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                           
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                           and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";  
               $sql113="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join  patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                         
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                           and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;"; 
               $sql114="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join  patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '2010-01-01'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                         
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                           and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";                                          
                $numh38 = \Yii::$app->db1->createCommand($sql112)->query()->rowCount; 
                $numi38 = \Yii::$app->db1->createCommand($sql113)->query()->rowCount;
                $numo38 = \Yii::$app->db1->createCommand($sql114)->query()->rowCount;
                $total38 = $numh38+$numi38 + $numo38;
                $rawData[] = array(
                      'id' => 38,
                      'pname' => ' 13.1  จำนวนคนที่พบภาวะแทรกซ้อนของหลอดเลือดสมองทั้งหมด (คน) ',
                      'numh' => @number_format($numh38),
                      'numi' => @number_format($numi38),                    
                      'numo' => @number_format($numo38),
                      'total' => @number_format($total38)     
               );  
               $sql115="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                          
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                           and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";     
               $sql116="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                      
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                           and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;"; 
               $sql117="select count(*) cc
                             from 
                                    (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                      
                             ) as a
                             inner join 
                                    (select vn,screen_date,do_cerebrovascular_screen,has_cerebrovascular_cormobidity
                                          from clinicmember_cormobidity_screen where do_cerebrovascular_screen='Y' 
                                           and has_cerebrovascular_cormobidity='Y'
                             ) as b
                             on a.vn=b.vn group by a.hn;";                                          
                $numh39 = \Yii::$app->db1->createCommand($sql115)->query()->rowCount; 
                $numi39 = \Yii::$app->db1->createCommand($sql116)->query()->rowCount;
                $numo39 = \Yii::$app->db1->createCommand($sql117)->query()->rowCount;
                $total39 = $numh39+$numi39 + $numo39;
                $rawData[] = array(
                      'id' => 39,
                      'pname' => ' 13.2  จำนวนคนที่พบภาวะแทรกซ้อนของหลอดเลือดสมอง รายใหม่ (คน) ',
                      'numh' => @number_format($numh39),
                      'numi' => @number_format($numi39),                    
                      'numo' => @number_format($numo39),
                      'total' => @number_format($total39)     
               );       
               $sql118="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                         
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";   
               $sql119="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                        
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";  
               $sql120="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                        
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total <=1 group by a.hn;";                                          
                $numh40 = \Yii::$app->db1->createCommand($sql118)->query()->rowCount; 
                $numi40 = \Yii::$app->db1->createCommand($sql119)->query()->rowCount;
                $numo40 = \Yii::$app->db1->createCommand($sql120)->query()->rowCount;
                $total40 = $numh40+$numi40+$numo40;
                $rawData[] = array(
                      'id' => 40,
                      'pname' => ' 13.3  กลุ่มปกติ(ผิดปกติ 0-1 ข้อ) (คน) ',
                      'numh' => @number_format($numh40),
                      'numi' => @number_format($numi40),                    
                      'numo' => @number_format($numo40),
                      'total' => @number_format($total40)     
               ); 
               $sql121="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                         
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;"; 
               $sql122="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                       
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;"; 
               $sql123="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                       
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total =2 group by a.hn;";                                          
                $numh41 = \Yii::$app->db1->createCommand($sql121)->query()->rowCount; 
                $numi41 = \Yii::$app->db1->createCommand($sql122)->query()->rowCount;
                $numo41 = \Yii::$app->db1->createCommand($sql123)->query()->rowCount;
                $total41 = $numh41+$numi41+$numo41;
                $rawData[] = array(
                      'id' => 41,
                      'pname' => ' 13.4  กลุ่มเสี่ยงสูง(ผิดปกติ 2 ข้อ) (คน) ',
                      'numh' => @number_format($numh41),
                      'numi' => @number_format($numi41),                    
                      'numo' => @number_format($numo41),
                      'total' => @number_format($total41)     
               );    
               $sql124="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                         
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;"; 
               $sql125="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                      
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;"; 
               $sql126="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                      
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 3 and 5 group by a.hn;";                                          
                $numh42 = \Yii::$app->db1->createCommand($sql124)->query()->rowCount; 
                $numi42 = \Yii::$app->db1->createCommand($sql125)->query()->rowCount;
                $numo42 = \Yii::$app->db1->createCommand($sql126)->query()->rowCount;
                $total42 = $numh42+$numi42+$numo42;
                $rawData[] = array(
                      'id' => 42,
                      'pname' => ' 13.5  กลุ่มเสี่ยงสูงปานกลาง(ผิดปกติ 3-5 ข้อ) (คน) ',
                      'numh' => @number_format($numh42),
                      'numi' => @number_format($numi42),                    
                      'numo' => @number_format($numo42),
                      'total' => @number_format($total42)     
               );  
               $sql127="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                         
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;";   
               $sql128="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                       
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;"; 
               $sql129="select count(*) cc
                             from 
                                 (select c.hn,v.vn
                                         from clinicmember c inner join patient p on c.hn=p.hn inner join vn_stat v on c.hn=v.hn 
                                         where vstdate between  '{$date1}'  and '{$date2}'
                                        and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                       
                             ) as a
                             inner join 
                                (select ccs.vn,(if(css.father_mother_or_parent_stroke_id in('1','2'),1,0)+if(css.smoking='Y',1,0)+
                                    if(css.bps_avg>140 and css.bpd_avg>90,1,0)+
                                    if(css.lipid_abnormal_id='1',1,0)+if(css.waist_cm>=80,1,0) +if(css.bmi>=25,1,0)+
                                    if(css.has_stroke_history='Y',1,0) +if(css.has_heart_disease_history='y',1,0)) total 
                                    from clinicmember_cormobidity_screen ccs 
                                    left outer join clinicmember_cormobidity_stroke_screen css 
                                    on ccs.clinicmember_cormobidity_screen_id=css.clinicmember_cormobidity_screen_id
                                     where ccs.do_cerebrovascular_screen='Y' 
                            ) as b
                            on a.vn=b.vn
                             where b.total between 6 and 9 group by a.hn;";                                          
                $numh43 = \Yii::$app->db1->createCommand($sql127)->query()->rowCount; 
                $numi43 = \Yii::$app->db1->createCommand($sql128)->query()->rowCount;
                $numo43 = \Yii::$app->db1->createCommand($sql129)->query()->rowCount;
                $total43 = $numh43+$numi43+$numo43;
                $rawData[] = array(
                      'id' => 43,
                      'pname' => ' 13.6  กลุ่มเสี่ยงสูงมาก(ผิดปกติ 6-9 ข้อ หรือ มีปัจจัยข้อ 8หรือ 9) (คน) ',
                      'numh' => @number_format($numh43),
                      'numi' => @number_format($numi43),                    
                      'numo' => @number_format($numo43),
                      'total' => @number_format($total43)     
               );  
               $sql130="select count(*) cc
                                     from (
                                         select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                         inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                             
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' 
                                                  and (lo.lab_order_result <> 0 or lo.lab_order_result is not null or lo.lab_order_result <> '')
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;";    
               $sql131="select count(*) cc
                                     from (
                                         select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                         inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' 
                                                  and (lo.lab_order_result <> 0 or lo.lab_order_result is not null or lo.lab_order_result <> '')
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;"; 
               $sql132="select count(*) cc
                                     from (
                                         select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                         inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}'
                                         and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                          
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' 
                                                  and (lo.lab_order_result <> 0 or lo.lab_order_result is not null or lo.lab_order_result <> '')
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;";                                          
                $numh44 = \Yii::$app->db1->createCommand($sql130)->query()->rowCount; 
                $numi44 = \Yii::$app->db1->createCommand($sql131)->query()->rowCount;
                $numo44 = \Yii::$app->db1->createCommand($sql132)->query()->rowCount;
                $total44 = $numh44+$numi44+$numo44;
                $rawData[] = array(
                      'id' => 44,
                      'pname' => ' 14.  จำนวนคนที่ได้รับการตรวจภาวะแทรกซ้อนทางไต (คน) ',
                      'numh' => @number_format($numh44),
                      'numi' => @number_format($numi44),                    
                      'numo' => @number_format($numo44),
                      'total' => @number_format($total44)     
               ); 
               $sql133="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;"; 
               $sql134="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                           
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;"; 
               $sql135="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}'  and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                           
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60                                                 
                                     ) as b     
                                     on a.vn=b.vn group by a.hn;";                                            
                $numh45 = \Yii::$app->db1->createCommand($sql133)->query()->rowCount; 
                $numi45 = \Yii::$app->db1->createCommand($sql134)->query()->rowCount;
                $numo45 = \Yii::$app->db1->createCommand($sql135)->query()->rowCount;
                $total45 = $numh45+$numi45+$numo45;
                $rawData[] = array(
                      'id' => 45,
                      'pname' => ' 14.1  จำนวนคนที่ตรวจพบภาวะแทรกซ้อนทางไตทั้งหมด (คน)  ',
                      'numh' => @number_format($numh45),
                      'numi' => @number_format($numi45),                    
                      'numo' => @number_format($numo45),
                      'total' => @number_format($total45)     
               );     
               $sql136="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}' and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))                                            
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60
                                                  
                                     ) as b     
                                     on a.vn=b.vn 
                                    inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                                    where cs.has_kidney_cormobidity='Y' group by a.hn;";  
               $sql137="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}' and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart)='3104'                                    
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60
                                                  
                                     ) as b     
                                     on a.vn=b.vn 
                                    inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                                    where cs.has_kidney_cormobidity='Y' group by a.hn;"; 
               $sql138="select count(*) cc
                                     from (
                                        select  c.hn,v.vn from clinicmember c inner join patient p on c.hn=p.hn 
                                            inner join vn_stat v on c.hn=v.hn where v.vstdate between '{$date1}' and '{$date2}' 
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') 
                                         and concat(p.chwpart,p.amppart) !='3104'                                    
                                    ) as a
                                     inner join  
                                    (
                                        select l.vn,lo.lab_items_code,lo.lab_order_result
                                            from 
                                                 lab_head l left outer join lab_order lo on l.lab_order_number=lo.lab_order_number 
                                                  where lo.lab_items_code = '1030' and lo.lab_order_result <60
                                                  
                                     ) as b     
                                     on a.vn=b.vn 
                                    inner join clinicmember_cormobidity_screen cs on cs.vn=b.vn 
                                    where cs.has_kidney_cormobidity='Y' group by a.hn;";                                             
                $numh46 = \Yii::$app->db1->createCommand($sql136)->query()->rowCount; 
                $numi46 = \Yii::$app->db1->createCommand($sql137)->query()->rowCount;
                $numo46 = \Yii::$app->db1->createCommand($sql138)->query()->rowCount;
                $total46 = $numh46+$numi46+$numo46;
                $rawData[] = array(
                      'id' => 46,
                      'pname' => ' 14.2  จำนวนคนที่ตรวจพบภาวะแทรกซ้อนทางไต รายใหม่ (คน)  ',
                      'numh' => @number_format($numh46),
                      'numi' => @number_format($numi46),                    
                      'numo' => @number_format($numo46),
                      'total' => @number_format($total46)     
               );         
               $sql139="select count(*) cc from referout where refer_date between '{$date1}'  and '{$date2}' and pre_diagnosis='HT';";   
               $total47=\Yii::$app->db1->createCommand($sql139)->queryScalar();                  
                $rawData[] = array(
                      'id' => 47,
                      'pname' => ' 15.  จำนวนผู้ป่วยที่ รพ. ส่งกลับ รพ.สต.(ความดัน) (คน)',
                      'numh' => '-',
                      'numi' => '-',                    
                      'numo' =>'-',
                      'total' => @number_format($total47)     
               );
               $sql140="select count(*) cc from referout where refer_date between '{$date1}'  and '{$date2}' and pre_diagnosis='DMHT';";   
               $total48=\Yii::$app->db1->createCommand($sql140)->queryScalar(); 
               $rawData[] = array(
                      'id' => 48,
                      'pname' => ' 16.  จำนวนผู้ป่วยที่ รพ. ส่งกลับ รพ.สต.(เบาหวาน-ความดัน) (คน)',
                      'numh' => '-',
                      'numi' => '-',                    
                      'numo' =>'-',
                      'total' => @number_format($total48)     
               );  
               $sql141="select  count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and o.smoking_type_id in ('2','5')
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00')))) group by o.hn;";              
               $sql142="select  count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and o.smoking_type_id in ('2','5')
                                         and concat(p.chwpart,p.amppart)='3104' group by o.hn;";     
               $sql143="select  count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and o.smoking_type_id in ('2','5')
                                         and concat(p.chwpart,p.amppart) !='3104' group by o.hn;"; 
                $numh49 = \Yii::$app->db1->createCommand($sql141)->query()->rowCount; 
                $numi49 = \Yii::$app->db1->createCommand($sql142)->query()->rowCount;
                $numo49 = \Yii::$app->db1->createCommand($sql143)->query()->rowCount; 
                $total49 = $numh49+$numi49+$numo49;                
                $rawData[] = array(
                      'id' => 49,
                      'pname' => ' 17.  จำนวนผู้ป่วยความดันสูบบุหรี่ (คน)',
                      'numh' => @number_format($numh49),
                      'numi' => @number_format($numi49),                    
                      'numo' => @number_format($numo49),
                      'total' => @number_format($total49)     
               ); 
               $sql144="select  count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and o.smoking_type_id in ('5') 
                                         and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401'
                                         and (p.moopart between '01' and '28'  or p.moopart in ('','0','00')))  
                                         or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00')))) group by o.hn;";  
               $sql145="select  count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and o.smoking_type_id in ('5') 
                                         and concat(p.chwpart,p.amppart)='3104' group by o.hn;";                                              
               $sql146="select  count(*) cc from clinicmember c inner join patient p on c.hn=p.hn
                                            inner join vn_stat v on c.hn=v.hn inner join opdscreen o on v.vn=o.vn 
                                            where v.vstdate between  '{$date1}'  and '{$date2}'
                                           and c.clinic='002' and c.clinic_member_status_id in ('3','11') and o.smoking_type_id in ('5') 
                                         and concat(p.chwpart,p.amppart) !='3104' group by o.hn;";                                              
                $numh50 = \Yii::$app->db1->createCommand($sql144)->query()->rowCount; 
                $numi50 = \Yii::$app->db1->createCommand($sql145)->query()->rowCount;
                $numo50 = \Yii::$app->db1->createCommand($sql146)->query()->rowCount; 
                $total50 = $numh50+$numi50+$numo50;                
                $rawData[] = array(
                      'id' => 50,
                      'pname' => ' 17.1  มีการได้รับคำแนะนำปรึกษาให้เลิกสูบบุหรี่ (คน) ',
                      'numh' => @number_format($numh50),
                      'numi' => @number_format($numi50),                    
                      'numo' => @number_format($numo50),
                      'total' => @number_format($total50)     
               );
                $rawData[] = array(
                    'id' => 51,
                    'pname' => '18.&nbsp;&nbsp;จำนวนผู้ป่วยความดันที่ได้รับการปรับเปลี่ยน 3อ2ส. (คน)',
                    'numh' =>'-',
                    'numi' =>'-',
                    'numo' =>'-',
                    'total' =>'-'
                );                  
            break;
            case 3:


            break;        
            default:
            break;
        }    
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 80,
                ],
        ]);           
        return $this -> render('/site/ncd/clinic7-preview',['dataProvider' => $dataProvider,'names' => $names,'mText' => $this->mText,
                            'date1'=>$date1,'date2'=>$date2,'clinic_n'=>$clinic_n]);         
    }        
}    

