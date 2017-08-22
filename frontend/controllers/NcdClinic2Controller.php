<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class NcdClinic2Controller extends Controller
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
    public function actionClinic8Index() {
        $model = new Formmodel();
        $names="รายงานคัดกรองกลุ่มเสี่ยงโรคเรื้อรัง(DM/HT/Stroke/Obesity) ในเขตรับผิดชอบ";
        $sql1='DROP TABLE if EXISTS nhso_screen';
        \Yii::$app->db1->createCommand($sql1)->execute();     
        \Yii::$app->db1->createCommand(
                      'CREATE  TABLE nhso_screen (person_dmht_screen_summary_id INTEGER NOT NULL, 
                                     PRIMARY KEY(person_dmht_screen_summary_id), 
                                    INDEX(person_dmht_screen_summary_id)) (SELECT * FROM person_dmht_nhso_screen)'         
         )->execute();  
        if($model->load(Yii::$app->request->post())){
               $year =  $model->text1;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ncd/"; 
                return $this->redirect($url.'ncd6.mrt&year='.$year);                  
        }
        return $this -> render('/site/ncd/clinic8-index',['mText'=>$this->mText, 'names'=>$names, 'model' => $model]);            
    }
    public function actionClinic9Index() {
        $model = new Formmodel();        
        $names="รายงานสรุปผลการคัดกรอง(ภาวะแทรกซ้อน โรคหลอดเลือดสมอง)";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;           
               $clinic = Yii::$app->request->post('clinic');    
            return $this->redirect(['clinic9_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'c'=>$clinic]);
        }
            return $this -> render('/site/ncd/clinic9-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    } 
    public function actionClinic9_preview($name,$d1,$d2,$c) {
        $names = $name;   
        $date1=$d1;$date2=$d2;
        $clinic=  explode(',',$c);$clinic_c=$clinic[0];$clinic_n=$clinic[1];    
        switch ($clinic_c) {
           case 1:
                        $sql1="select cs.clinicmember_cormobidity_screen_id,cs.clinicmember_id,cs.vn,cs.hn,p.cid,
                                  concat(p.pname,p.fname,' ',p.lname) pname,v.age_y,c1.clinic,css.father_mother_or_parent_stroke_id,
                                  css.smoking,css.bps_avg,css.bpd_avg,css.capillary_blood_level,css.lipid_abnormal_id,
                                  css.waist_cm,css.bmi,css.has_stroke_history,css.has_heart_disease_history,cs.screen_date,v.sex,
                                  p.addrpart,concat('  ม. ',vl.village_moo,' ',vl.village_name) moo
                                  from clinicmember_cormobidity_screen cs  
                                  left outer join clinicmember c1 on cs.clinicmember_id=c1.clinicmember_id
                                  left outer join patient p on cs.hn=p.hn left outer join vn_stat v on cs.vn=v.vn
                                  left outer join person ps on p.hn=ps.patient_hn left outer join house h on h.house_id=ps.house_id
                                  left outer join village vl on vl.village_id=ps.village_id	
                                  left outer join clinicmember_cormobidity_stroke_screen css 
                                  on css.clinicmember_cormobidity_screen_id=cs.clinicmember_cormobidity_screen_id         
                                  where cs.screen_date between '{$date1}' and '{$date2}' and c1.clinic='001' 
                                  and c1.hn not in (select c2.hn from clinicmember c2 where c2.clinic='002')
                                  and cs.do_cerebrovascular_screen='Y';";
          break;
           case 2:
                          $sql1="select cs.clinicmember_cormobidity_screen_id,cs.clinicmember_id,cs.vn,cs.hn,p.cid,
                              concat(p.pname,p.fname,' ',p.lname) pname,v.age_y,
                                      c1.clinic,css.father_mother_or_parent_stroke_id,css.smoking,css.bps_avg,css.bpd_avg,css.capillary_blood_level,css.lipid_abnormal_id,
                                      css.waist_cm,css.bmi,css.has_stroke_history,css.has_heart_disease_history,cs.screen_date,v.sex,p.addrpart,concat('  ม. ',vl.village_moo,' ',vl.village_name) moo
                                      from clinicmember_cormobidity_screen cs  
                                      left outer join clinicmember c1 on cs.clinicmember_id=c1.clinicmember_id
                                      left outer join patient p on cs.hn=p.hn left outer join vn_stat v on cs.vn=v.vn
                                      left outer join person ps on p.hn=ps.patient_hn left outer join house h on h.house_id=ps.house_id
                               left outer join village vl on vl.village_id=ps.village_id	
                                     left outer join clinicmember_cormobidity_stroke_screen css on css.clinicmember_cormobidity_screen_id=cs.clinicmember_cormobidity_screen_id         
                                     where cs.screen_date between '{$date1}' and '{$date2}' and c1.clinic='002' 
                                     and c1.hn not in (select c2.hn from clinicmember c2 where c2.clinic='001') and cs.do_cerebrovascular_screen='Y';";

          break;
           case 3:
        $sql1="select cs.clinicmember_cormobidity_screen_id,cs.clinicmember_id,cs.vn,cs.hn,p.cid,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y,
                  c1.clinic,css.father_mother_or_parent_stroke_id,css.smoking,css.bps_avg,css.bpd_avg,css.capillary_blood_level,css.lipid_abnormal_id,
                  css.waist_cm,css.bmi,css.has_stroke_history,css.has_heart_disease_history,cs.screen_date,v.sex,p.addrpart,concat('  ม. ',vl.village_moo,' ',vl.village_name) moo
                  from clinicmember_cormobidity_screen cs  
                  left outer join clinicmember c1 on cs.clinicmember_id=c1.clinicmember_id
                  left outer join patient p on cs.hn=p.hn left outer join vn_stat v on cs.vn=v.vn
                  left outer join person ps on p.hn=ps.patient_hn left outer join house h on h.house_id=ps.house_id
	   left outer join village vl on vl.village_id=ps.village_id	
                 left outer join clinicmember_cormobidity_stroke_screen css on css.clinicmember_cormobidity_screen_id=cs.clinicmember_cormobidity_screen_id         
                 where cs.screen_date between '{$date1}' and '{$date2}' and c1.clinic='001' 
                 and c1.hn in (select c2.hn from clinicmember c2 where c2.clinic='002') and cs.do_cerebrovascular_screen='Y';";
          break;      
          default:
          break;
        }
              $data1=\Yii::$app->db1->createCommand($sql1)->queryAll(); 
              $i=0;$total=0;$a=0;$b=0;$c=0;$d=0;$e=0;$f=0;$g=0;$h=0;$text15="มี";$text16="ไม่มี";$text19="สูบ";$text20="ไม่สูบ";
               foreach ($data1 as $value1) {
                      $i=$i+1;
                      $dan = $value1['father_mother_or_parent_stroke_id'];
                      if($dan=='1' || $dan=='2'){$dna=$text15;$a=1;}else{$dna=$text16;$a=0;}	 
                      $smoking=$value1['smoking'];if($smoking=="Y"){$smok=$text19; $b=1;}else{$smok=$text20;$b=0;}
                      switch ($clinic_c) {
                             case 1:
		        if($value1['bps_avg'] >='140' || $value1['bpd_avg']>=90){$bp='ไม่ปกติ' ;$c=1;}else{$bp='ปกติ';$c=0;}
		       $dm="ไม่ปกติ";
		       $d=1;
		break;
                             case 2:
                                    $bp="ไม่ปกติ";
                                    $c=1;
                                    if($value1['capillary_blood_level'] >='120'){$dm='ไม่ปกติ'; $d=1;}else{$dm='ปกติ';$d=0;}		
		break;
                             case 3:
                                    $bp="ไม่ปกติ";
                                    $dm="ไม่ปกติ";
                                    $c=1;$d=1;				
		break;	
                            default:
		break;
                      }
                      if($value1['lipid_abnormal_id']=='1'){$lipid='มี'; $e=1;}else{$lipid='ไมีมี';$e=0;}
                      if($value1['sex']=='1'){
                             if($value1['waist_cm']>='90' || $value1['bmi'] >='25'){$waist="เกิน";$f=1;}else{$waist="ปกติ";$f=0;}
                      }else{
                             if($value1['waist_cm']>='80' || $value1['bmi'] >='25'){$waist="เกิน";$f=1;}else{$waist="ปกติ";$f=0;} 	
                      }
                      if($value1['has_stroke_history']=='Y'){$stro='มี';$g=1;}else{$stro='ไม่มี';$g=0;}
                      if($value1['has_heart_disease_history']=='Y'){$hear='มี';$h=1;}else{$hear='ไม่มี';$h=0;}
                      $total=$a+$b+$c+$d+$e+$f+$g+$h;    
                      $rawData[]=array(
                      'id'=>$i,
                      'cid'=>$value1['cid'],
                      'pname'=>$value1['pname'],
                      'age_y'=>$value1['age_y'],
                      'screen_date'=>$value1['screen_date'],
                      'addrpart'=>$value1['addrpart'],
                      'moo'=>$value1['moo'],
                      'dna'=>$dna,
                      'smok'=>$smok,
                      'bp'=>$bp,
                      'dm'=>$dm,
                      'lipid'=>$lipid,
                      'waist'=>$waist,
                      'stro'=>$stro,
                      'hear'=>$hear,
                      'total'=>$total                                            
               );                      
               }     
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                 'attributes' => ['screen_date', 'pname'],
            ],            
        ]);         
     return $this->render('/site/ncd/clinic9-preview',['mText'=>$this->mText,'names'=>$names,
                                    'dataProvider'=>$dataProvider,'date1'=>$date1,'date2'=>$date2,'clinic'=>$clinic_n]);                                                       
    }  
    public function actionClinic10Index() {
        $model = new Formmodel();        
        $names=" รายงานคัดกรองภาวะแทรงซ้อนทางไต (GFR)";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;           
               $clinic = Yii::$app->request->post('clinic');    
            return $this->redirect(['clinic10_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'c'=>$clinic]);
        }
            return $this -> render('/site/ncd/clinic10-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }     
    public function actionClinic10_preview($d1,$d2,$c) {
        $names = "รายงานคัดกรองภาวะแทรงซ้อนทางไต (GFR)";   
        $date1=$d1;$date2=$d2;$clinic=  explode(',',$c);$clinic_c=$clinic[0];$clinic_n=$clinic[1];
        $rawData = array();
        switch ($clinic_c) {
            case 1:
                $sql1 = "select v.hn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y ,if(v.sex='1','ช','ญ') sex,p.addrpart,p.moopart,t.name tmb,
	                      truncate(o.bw,2) weight,v.vstdate,c.clinic,lo.lab_order_result creatinine,v.pdx , 
                                    if(v.sex='1',truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),
                                    141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),
                                    144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) gfr,
                             case when if(v.sex='1',
                                    truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) >='120' 
                             then  '0'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '90' and  '119'
                             then  '1'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))
                             between '60' and  '89'
                             then  '2' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '30' and '59'
                             then  '3' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '16' and '29'
                             then  '4'                          
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))  <= '15'
                             then  '5' 
                             else 'Unknow'         
                             end as stage 
                             from vn_stat v 
                             left outer join patient p on p.hn=v.hn left outer join opdscreen o on o.vn=v.vn
                             left outer join clinicmember c on c.hn=v.hn left outer join lab_head lh on lh.vn=v.vn  left outer join thaiaddress t on v.aid=t.addressid
		left outer join lab_order lo on lo.lab_order_number=lh.lab_order_number
                             where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='001'  and c.hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             and lo.lab_items_code='78' and lo.lab_order_result  REGEXP '^[0-9]'";
                $query1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
                foreach ($query1 as $value1) {
                    $hn = $value1['hn'];
                    $vstdate = $value1['vstdate'];
                    $sql2 = "select v.vstdate,lo.lab_order_result creatinine,v.pdx , 
                                    if(v.sex='1',truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),
                                    141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),
                                    144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) gfr,
                             case when if(v.sex='1',
                                    truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) >='120' 
                             then  '0'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '90' and  '119'
                             then  '1'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))
                             between '60' and  '89'
                             then  '2' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '30' and '59'
                             then  '3' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '16' and '29'
                             then  '4'                          
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))  <= '15'
                             then  '5' 
                             else 'Unknow'         
                             end as stage 
                             from vn_stat v 
                             left outer join patient p on p.hn=v.hn left outer join lab_head lh on lh.vn=v.vn 
                             left outer join lab_order lo on lo.lab_order_number=lh.lab_order_number
                             where v.vstdate < '{$vstdate}' and lo.lab_items_code='78' and lo.lab_order_result  REGEXP '^[0-9]' and v.hn='{$hn}' order by v.vn desc limit 1;";
                    $result = \Yii::$app->db1->createCommand($sql2)->queryAll();
                    if (!$result) {
                        $bf_vstdate = '';
                        $bf_cre = '';
                        $bf_gfr = '';
                        $bf_stage = '';
                    } else {
                        foreach ($result as $value2) {
                            $bf_vstdate = $value2['vstdate'];
                            $bf_cre = $value2['creatinine'];
                            $bf_gfr = $value2['gfr'];
                            $bf_stage = $value2['stage'];
                        }
                    }
                    $rawData[] = array(
                        'hn' => $value1['hn'],
                        'pname' => $value1['pname'],
                        'sex' => $value1['sex'],
                        'age_y' => $value1['age_y'],
                        'addrpart' => $value1['addrpart'],
                        'moopart' => $value1['moopart'],
                        'tmb' => $value1['tmb'],
                        'vstdate' => $value1['vstdate'],
                        'weight' => $value1['weight'],
                        'creatinine' => $value1['creatinine'],
                        'pdx' => $value1['pdx'],
                        'gfr' => $value1['gfr'],
                        'stage' => $value1['stage'],
                        'bf_vstdate' => $bf_vstdate,
                        'bf_cre' => $bf_cre,
                        'bf_gfr' => $bf_gfr,
                        'bf_stage' => $bf_stage,
                    );
                }
                break;
            case 2:
                $sql1 = "select v.hn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y ,if(v.sex='1','ช','ญ') sex,p.addrpart,p.moopart,t.name tmb,
	                      truncate(o.bw,2) weight,v.vstdate,c.clinic,lo.lab_order_result creatinine,v.pdx , 
                                    if(v.sex='1',truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),
                                    141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),
                                    144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) gfr,
                             case when if(v.sex='1',
                                    truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) >='120' 
                             then  '0'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '90' and  '119'
                             then  '1'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))
                             between '60' and  '89'
                             then  '2' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '30' and '59'
                             then  '3' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '16' and '29'
                             then  '4'                          
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))  <= '15'
                             then  '5' 
                             else 'Unknow'         
                             end as stage 
                             from vn_stat v 
                             left outer join patient p on p.hn=v.hn left outer join opdscreen o on o.vn=v.vn
                             left outer join clinicmember c on c.hn=v.hn left outer join lab_head lh on lh.vn=v.vn  left outer join thaiaddress t on v.aid=t.addressid
		left outer join lab_order lo on lo.lab_order_number=lh.lab_order_number
                             where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='002'  and c.hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                             and lo.lab_items_code='78' and lo.lab_order_result  REGEXP '^[0-9]'";
                $query1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
                foreach ($query1 as $value1) {
                    $hn = $value1['hn'];
                    $vstdate = $value1['vstdate'];
                    $sql2 = "select v.vstdate,lo.lab_order_result creatinine,v.pdx , 
                                    if(v.sex='1',truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),
                                    141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),
                                    144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) gfr,
                             case when if(v.sex='1',
                                    truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) >='120' 
                             then  '0'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '90' and  '119'
                             then  '1'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))
                             between '60' and  '89'
                             then  '2' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '30' and '59'
                             then  '3' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '16' and '29'
                             then  '4'                          
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))  <= '15'
                             then  '5' 
                             else 'Unknow'         
                             end as stage 
                             from vn_stat v 
                             left outer join patient p on p.hn=v.hn left outer join lab_head lh on lh.vn=v.vn 
                             left outer join lab_order lo on lo.lab_order_number=lh.lab_order_number
                             where v.vstdate < '{$vstdate}' and lo.lab_items_code='78' and lo.lab_order_result  REGEXP '^[0-9]' and v.hn='{$hn}' order by v.vn desc limit 1;";
                    $result = \Yii::$app->db1->createCommand($sql2)->queryAll();
                    if (!$result) {
                        $bf_vstdate = '';
                        $bf_cre = '';
                        $bf_gfr = '';
                        $bf_stage = '';
                    } else {
                        foreach ($result as $value2) {
                            $bf_vstdate = $value2['vstdate'];
                            $bf_cre = $value2['creatinine'];
                            $bf_gfr = $value2['gfr'];
                            $bf_stage = $value2['stage'];
                        }
                    }
                    $rawData[] = array(
                        'hn' => $value1['hn'],
                        'pname' => $value1['pname'],
                        'sex' => $value1['sex'],
                        'age_y' => $value1['age_y'],
                        'addrpart' => $value1['addrpart'],
                        'moopart' => $value1['moopart'],
                        'tmb' => $value1['tmb'],
                        'vstdate' => $value1['vstdate'],
                        'weight' => $value1['weight'],
                        'creatinine' => $value1['creatinine'],
                        'pdx' => $value1['pdx'],
                        'gfr' => $value1['gfr'],
                        'stage' => $value1['stage'],
                        'bf_vstdate' => $bf_vstdate,
                        'bf_cre' => $bf_cre,
                        'bf_gfr' => $bf_gfr,
                        'bf_stage' => $bf_stage,
                    );
                }
                break;
            case 3:
                $sql1 = "select v.hn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y ,if(v.sex='1','ช','ญ') sex,p.addrpart,p.moopart,t.name tmb,
	                      truncate(o.bw,2) weight,v.vstdate,c.clinic,lo.lab_order_result creatinine,v.pdx , 
                                    if(v.sex='1',truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),
                                    141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),
                                    144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) gfr,
                             case when if(v.sex='1',
                                    truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) >='120' 
                             then  '0'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '90' and  '119'
                             then  '1'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))
                             between '60' and  '89'
                             then  '2' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '30' and '59'
                             then  '3' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '16' and '29'
                             then  '4'                          
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))  <= '15'
                             then  '5' 
                             else 'Unknow'         
                             end as stage 
                             from vn_stat v 
                             left outer join patient p on p.hn=v.hn left outer join opdscreen o on o.vn=v.vn
                             left outer join clinicmember c on c.hn=v.hn left outer join lab_head lh on lh.vn=v.vn  left outer join thaiaddress t on v.aid=t.addressid
		left outer join lab_order lo on lo.lab_order_number=lh.lab_order_number
                             where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='001'  and c.hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             and lo.lab_items_code='78' and lo.lab_order_result  REGEXP '^[0-9]'";
                $query1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
                foreach ($query1 as $value1) {
                    $hn = $value1['hn'];
                    $vstdate = $value1['vstdate'];
                    $sql2 = "select v.vstdate,lo.lab_order_result creatinine,v.pdx , 
                                    if(v.sex='1',truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),
                                    141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),
                                    144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) gfr,
                             case when if(v.sex='1',
                                    truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                                    truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) >='120' 
                             then  '0'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '90' and  '119'
                             then  '1'
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))
                             between '60' and  '89'
                             then  '2' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '30' and '59'
                             then  '3' 
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0)) 
                             between '16' and '29'
                             then  '4'                          
                             when if(v.sex='1',
                             truncate(if(v.age_y<=80,141*power((lo.lab_order_result/0.9),-0.411)*power(0.993,v.age_y),141*power((lo.lab_order_result/0.9),-1.209)*power(0.993,v.age_y)),0),
                             truncate(if(v.age_y<=62,144*power((lo.lab_order_result/0.7),-0.329)*power(0.993,v.age_y),144*power((lo.lab_order_result/0.7),-1.209)*power(0.993,v.age_y)),0))  <= '15'
                             then  '5' 
                             else 'Unknow'         
                             end as stage 
                             from vn_stat v 
                             left outer join patient p on p.hn=v.hn left outer join lab_head lh on lh.vn=v.vn 
                             left outer join lab_order lo on lo.lab_order_number=lh.lab_order_number
                             where v.vstdate < '{$vstdate}' and lo.lab_items_code='78' and lo.lab_order_result  REGEXP '^[0-9]' and v.hn='{$hn}' order by v.vn desc limit 1;";
                    $result = \Yii::$app->db1->createCommand($sql2)->queryAll();
                    if (!$result) {
                        $bf_vstdate = '';
                        $bf_cre = '';
                        $bf_gfr = '';
                        $bf_stage = '';
                    } else {
                        foreach ($result as $value2) {
                            $bf_vstdate = $value2['vstdate'];
                            $bf_cre = $value2['creatinine'];
                            $bf_gfr = $value2['gfr'];
                            $bf_stage = $value2['stage'];
                        }
                    }
                    $rawData[] = array(
                        'hn' => $value1['hn'],
                        'pname' => $value1['pname'],
                        'sex' => $value1['sex'],
                        'age_y' => $value1['age_y'],
                        'addrpart' => $value1['addrpart'],
                        'moopart' => $value1['moopart'],
                        'tmb' => $value1['tmb'],
                        'vstdate' => $value1['vstdate'],
                        'weight' => $value1['weight'],
                        'creatinine' => $value1['creatinine'],
                        'pdx' => $value1['pdx'],
                        'gfr' => $value1['gfr'],
                        'stage' => $value1['stage'],
                        'bf_vstdate' => $bf_vstdate,
                        'bf_cre' => $bf_cre,
                        'bf_gfr' => $bf_gfr,
                        'bf_stage' => $bf_stage,
                    );
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
        return $this -> render('/site/ncd/clinic10-preview',['dataProvider' => $dataProvider,'names' => $names,'mText' => $this->mText,
                                        'clinic_n'=>$clinic_n,'date1'=>$date1,'date2'=>$date2]);      
    }    
    public function actionClinic11Index() {
        $model = new Formmodel();        
        $names="รายงาน BSA ผู้ป่วยไต";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;           
            return $this->redirect(['clinic11_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/ncd/clinic11-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }
    public function actionClinic11_preview($d1,$d2) {
        $names = "รายงาน BSA ผู้ป่วยไต";  
        $date1 = $d1;
        $date2 = $d2;
        $sql1 = "select v.hn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y,if(v.sex='1','ช','ญ') sex,truncate(o.bw,2) weight,
	     date_format(v.vstdate,'%d/%m/%Y') vstdate,lo.lab_order_result,v.pdx ,v.dx0,
	     truncate(if(v.sex='1',((140-v.age_y)*o.bw)/(72*lo.lab_order_result),(((140-v.age_y)*o.bw)/(72*lo.lab_order_result))*0.85),2) ccr,
                             case 
                                when(truncate(if(v.sex='1',((140-v.age_y)*o.bw)/(72*lo.lab_order_result),(((140-v.age_y)*o.bw)/(72*lo.lab_order_result))*0.85),0)  <= '14' ) 
                                    then '5' 
                                when (truncate(if(v.sex='1',((140-v.age_y)*o.bw)/(72*lo.lab_order_result),(((140-v.age_y)*o.bw)/(72*lo.lab_order_result))*0.85),0) 
                                    between '15' and '29') then '4' 
                                when (truncate(if(v.sex='1',((140-v.age_y)*o.bw)/(72*lo.lab_order_result),(((140-v.age_y)*o.bw)/(72*lo.lab_order_result))*0.85),0)  
                                    between '30' and '59') then '3'    
                                when (truncate(if(v.sex='1',((140-v.age_y)*o.bw)/(72*lo.lab_order_result),(((140-v.age_y)*o.bw)/(72*lo.lab_order_result))*0.85),0)  
                                    between '60' and '89') then '2'  
                                when (truncate(if(v.sex='1',((140-v.age_y)*o.bw)/(72*lo.lab_order_result),(((140-v.age_y)*o.bw)/(72*lo.lab_order_result))*0.85),0)  >= '90')
                                    then '1'           
                             else 'unknow'  
                    end as stage,gfr.ckd_epi,gfr.egfr as thai_egfr,gfr.mdrd from vn_stat v 
                    left outer join patient p on p.hn=v.hn left outer join opdscreen o on o.vn=v.vn left outer join clinicmember c on c.hn=v.hn 
                    left outer join lab_head lh on lh.vn=v.vn  left outer join ovst_gfr gfr on gfr.vn=v.vn
	     left outer join lab_order lo on lo.lab_order_number=lh.lab_order_number
                   where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='004'  and lo.lab_items_code='78' ;";
       try {
            $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);  
        return $this -> render('/site/ncd/clinic11-preview',['dataProvider' => $dataProvider,'names' => $names,
                                      'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);                       
    }   
     public function actionClinic12Index() {
        $model = new Formmodel();
        $names="รายงานคัดกรองภาวะแทรกซ้อนทางตา(เบาหวาน) "; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
               $station = $model->select1;
        return $this->redirect(['clinic12_preview','name' => $names,'d1' => $date1,'d2' => $date2,'s' => $station]);               
        }         
        return $this -> render('/site/ncd/clinic12-index',['mText' => $this->mText,'names' => $names,'model' => $model]);         
    }  
    public function actionClinic12_preview($name,$d1,$d2,$s) {
        $names = $name;
        $date1 = $d1;
        $date2 = $d2;
        $text="";
        $station=  explode(',', $s);$hospcode=$station[0];$hname=$station[1];
        switch ($hospcode) {
               case '02921':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310403' and 
                              p.moopart in ('1','01','2','02','3','03','6','06','7','07','8','08','9','09','10','13','14','15')) ";
               break;
               case '02922':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310403' and p.moopart in ('4','04','5','05','11','12','16','17'))";
               break;
               case '02923':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310405'";
               break;
               case '02924':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310406' and p.moopart in ('1','01','3','03','4','04','9','09','11','12','14'))";
               break;
               case '02925':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310408' and p.moopart in ('1','01','2','02','5','05','7','07','11'))";
               break;
               case '02926':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310413'";
               break;
               case '02927':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310414'";
               break;
               case '02928':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310415'";
               break;
               case '02929':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310416'";
               break;
               case '02930':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310417'";
               break;
               case '02931':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310418'";
               break;
               case '02932':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310424'";
               break;
               case '02933':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310425'";
               break;
               case '02934':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310426'";
               break;           
               case '02935':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310427'";
               break;
               case '13837':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310406' and p.moopart in ('2','02','5','05','6','06','7','07','8','08','10','13'))";
               break;
               case '14275':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310408' and p.moopart in ('3','03','4','04','6','06','8','08','09','10')) ";
               break;
               case '10897':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310401'";
               break;                   
               default:
               break;
        }
        $sql1 = "select a.hn,a.pname,b.clinicmember_id,b.screen_date,a.addrpart,a.moopart,concat(a.chwpart,a.amppart,a.tmbpart) aid,
                    v.hospsub,
                    substring_index(substring_index(t.full_name ,' ' , 1 ),'.',-1) tmb,
                    substring_index(substring_index(substring_index(t.full_name,' ',-2),' ' ,1),'.',-1) amp,
                    substring_index(substring_index(substring_index(t.full_name,' ',-1),' ' ,1),'.',-1) chw,
                    b.do_eye_screen,
                    desr1.dmht_eye_screen_result_name eye_left,desr2.dmht_eye_screen_result_name eye_right,
                    cces.va_left_text,cces.va_right_text,cces.iop_left_text,cces.iop_right_text,desm.dmht_eye_screen_macular_name macular,
                    desl.dmht_eye_screen_laser_name laser,dest.dmht_eye_screen_cataract_name cataract,
                    desb.dmht_eye_screen_blindness_name blindness,cces.treatment_text,cces.remark_text,a.station
                    from
                    (select concat(p.pname,p.fname,' ',p.lname) pname,c.clinic,c.clinicmember_id,c.hn,p.addrpart,p.moopart,tmbpart,amppart,
                            chwpart,
                    case 
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310403' 
                             and p.moopart in ('1','01','2','02','3','03','6','06','7','07','8','08','9','09','10','13','14','15')) then 'รพ.สต.หนองกก'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310403' 
                             and p.moopart in ('4','04','5','05','11','12','16','17')) then 'รพ.สต.บ้านเขว้า'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310405' then 'รพ.สต.ทุ่งโพธิ์'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310406' 
                             and p.moopart in ('1','01','3','03','4','04','9','09','11','12','14')) then 'รพ.สต.หนองทองลิ่ม'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310406' 
                             and p.moopart in ('2','02','5','05','6','06','7','07','8','08','10','13')) then 'รพ.สต.หนองยาง(หนองโบสถ์)'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310408' 
                              and p.moopart in ('1','01','2','02','5','05','7','07','11')) then 'รพ.สต.โคกศรีพัฒนา'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310408' 
                              and p.moopart in ('3','03','4','04','6','06','8','08','09','10')) then 'รพ.สต.หนองตาไก้'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310413' then 'รพ.สต.ผักหวาน'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310414' then 'รพ.สต.หนองไทร'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310415' then 'รพ.สต.ก้านเหลือง'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310416' then 'รพ.สต.บ้านสิงห์'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310417' then 'รพ.สต.โคกแร่'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310418' then 'รพ.สต.โคกยาง'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310424' then 'รพ.สต.หนองยาง(หนองยายพิมพ์)'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310425' then 'รพ.สต.หัวถนน'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310426' then 'รพ.สต.ชุมแสง'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310427' then 'รพ.สต.หนองโสน'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310401' then 'รพ.นางรอง'
                        else '' 
                    end  as station  
                     from clinicmember c
                        left outer join patient p on c.hn=p.hn
                        where c.clinic='001' and (c.discharge='N' or c.discharge='') and $text order by c.clinicmember_id
                    ) as a 
                    left outer join  
                    (select vn,clinicmember_id,do_eye_screen,screen_date,clinicmember_cormobidity_screen_id from clinicmember_cormobidity_screen 
                     where screen_date between '{$date1}' and '{$date2}' and do_eye_screen='Y' order by clinicmember_id 
                    ) as b 
                    on a.clinicmember_id=b.clinicmember_id
                    left outer join vn_stat v on v.vn=b.vn
                    left outer join clinicmember_cormobidity_eye_screen cces on b.clinicmember_cormobidity_screen_id=cces.clinicmember_cormobidity_screen_id
                    left outer join dmht_eye_screen_result desr1 on desr1.dmht_eye_screen_result_id=cces.dmht_eye_screen_result_left_id
                    left outer join dmht_eye_screen_result desr2 on desr2.dmht_eye_screen_result_id=cces.dmht_eye_screen_result_right_id
                    left outer join dmht_eye_screen_macular desm on desm.dmht_eye_screen_macular_id=cces.dmht_eye_screen_macular_id
                    left outer join dmht_eye_screen_laser desl on desl.dmht_eye_screen_laser_id=cces.dmht_eye_screen_laser_id
                    left outer join dmht_eye_screen_cataract dest on dest.dmht_eye_screen_cataract_id=cces.dmht_eye_screen_cataract_id
                    left outer join dmht_eye_screen_blindness desb on desb.dmht_eye_screen_blindness_id=cces.dmht_eye_screen_blindness_id
                    left outer join thaiaddress t on concat(a.chwpart,a.amppart,a.tmbpart)=t.addressid
                    order by aid;";
        try {
            $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);  
        return $this -> render('/site/ncd/clinic12-preview',['dataProvider' => $dataProvider,'names' => $names,
                                      'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);           
    }   
     public function actionClinic13Index() {
        $model = new Formmodel();
        $names="รายงานสรุปโรคเรื้อรัง(ผล Lab) ตรวจครั้งล่าสุด"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $clinic =$model->select1;
               $station =$model->select2;   
               $c = explode(',', $model->select1);$ccode=$c[0];
               $h=  explode(',', $model->select2);$hcode=$h[0];
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ncd/"; 
               return $this->redirect($url.'ncd11.mrt&d1='.$date1.'&d2='.$date2.'&c1='.$ccode.'&h1='.$hcode);                           
        }
            return $this -> render('/site/ncd/clinic13-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
     public function actionClinic14Index() {
        $model = new Formmodel();
        $names="รายงานผู้ป่วยเบาหวานตรวจ HB A1C"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
        return $this->redirect(['clinic14_preview','name' => $names,'d1' => $date1,'d2' => $date2]);               
        }         
        return $this -> render('/site/ncd/clinic14-index',['mText' => $this->mText,'names' => $names,'model' => $model]);         
    }     
    public function actionClinic14_preview($name, $d1, $d2) {
        $names = $name;
        $date1 = $d1;
        $date2 = $d2;
        $sql1 = "select v.hn, concat(p.pname, p.fname, ' ', p.lname) pname, s.name sex, v.age_y, p.addrpart, p.moopart,
                    t1.name tmb, t2.name amp, t3.name chw, v.vstdate, v.pdx, i.name diag, lo.lab_order_result result from vn_stat v 
                    left outer join patient p on p.hn=v.hn
                    left outer join sex s on p.sex=s.`code`
                    left outer join clinicmember c on c.hn=v.hn
                    left outer join lab_head lh on v.vn=lh.vn
                    left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                    left outer join icd101 i on v.pdx=i.code
                    left outer join thaiaddress t1 on t1.addressid=v.aid
                    left outer join thaiaddress t2 on t2.addressid=concat(substr(v.aid,1,4),'00')
                    left outer join thaiaddress t3 on t3.addressid=concat(substr(v.aid,1,2),'0000')
                    where c.clinic = '001' and v.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code = '193'";
        try {
            $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);  
        return $this -> render('/site/ncd/clinic14-preview',['dataProvider' => $dataProvider,'names' => $names,
                                        'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);                                           
    }
     public function actionClinic15Index() {
        $model = new Formmodel();
        $names="รายงานอัตราการรับไว้รักษา(Admission Rate) ด้วยโรคไม่ติดต่อเรื้อรังที่มีภาวะแทรกซ้อน สิทธิ UC"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
               $c = explode(',', $model->select1);
               if($c[0]=='1') {
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ncd/"; 
               return $this->redirect($url.'ncd15-1.mrt&d1='.$date1.'&d2='.$date2);     
               }else{
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ncd/"; 
               return $this->redirect($url.'ncd15-2.mrt&d1='.$date1.'&d2='.$date2);                       
               }
        }         
        return $this -> render('/site/ncd/clinic15-index',['mText' => $this->mText,'names' => $names,'model' => $model]);         
    }     
     public function actionClinic16Index() {
        $model = new Formmodel();
        $names="รายงานการลดลงของอัตราการนอน รพ. ด้วยภาวะที่ควรควบคุมด้วยบริการผู้ป่วยนอก(ACSC) ใน
                      โรค epilepsy,copd,asthma,dm,ht"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
               $date3 = $model->date3;
               $date4 = $model->date4;                  
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ncd/"; 
               return $this->redirect($url.'ncd16.mrt&d1='.$date1.'&d2='.$date2.'&d3='.$date3.'&d4='.$date4);     
          
        }         
        return $this -> render('/site/ncd/clinic16-index',['mText' => $this->mText,'names' => $names,'model' => $model]);         
    }         
     public function actionClinic17Index() {
        $model = new Formmodel();
        $names="รายงานคัดกรองภาวะแทรกซ้อนทางเท้า(เบาหวาน) "; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
               $station = $model->select1;
        return $this->redirect(['clinic17_preview','name' => $names,'d1' => $date1,'d2' => $date2,'s' => $station]);               
        }         
        return $this -> render('/site/ncd/clinic17-index',['mText' => $this->mText,'names' => $names,'model' => $model]);         
    }     
    public function actionClinic17_preview($name,$d1,$d2,$s) {
        $names = $name;
        $date1 = $d1;
        $date2 = $d2;
        $text="";
        $station=  explode(',', $s);$hospcode=$station[0];$hname=$station[1];
        switch ($hospcode) {
               case '02921':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310403' and 
                              p.moopart in ('1','01','2','02','3','03','6','06','7','07','8','08','9','09','10','13','14','15')) ";
               break;
               case '02922':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310403' and p.moopart in ('4','04','5','05','11','12','16','17'))";
               break;
               case '02923':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310405'";
               break;
               case '02924':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310406' and p.moopart in ('1','01','3','03','4','04','9','09','11','12','14'))";
               break;
               case '02925':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310408' and p.moopart in ('1','01','2','02','5','05','7','07','11'))";
               break;
               case '02926':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310413'";
               break;
               case '02927':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310414'";
               break;
               case '02928':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310415'";
               break;
               case '02929':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310416'";
               break;
               case '02930':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310417'";
               break;
               case '02931':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310418'";
               break;
               case '02932':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310424'";
               break;
               case '02933':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310425'";
               break;
               case '02934':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310426'";
               break;           
               case '02935':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310427'";
               break;
               case '13837':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310406' and p.moopart in ('2','02','5','05','6','06','7','07','8','08','10','13'))";
               break;
               case '14275':
                      $text="(concat(p.chwpart,p.amppart,p.tmbpart)='310408' and p.moopart in ('3','03','4','04','6','06','8','08','09','10')) ";
               break;
               case '10897':
                      $text="concat(p.chwpart,p.amppart,p.tmbpart)='310401'";
               break;                   
               default:
               break;
        }
        $sql1 = "select a.hn,a.pname,b.clinicmember_id,b.screen_date,a.addrpart,a.moopart,concat(a.chwpart,a.amppart,a.tmbpart) aid,
                    v.hospsub,
                    substring_index(substring_index(t.full_name ,' ' , 1 ),'.',-1) tmb,
                    substring_index(substring_index(substring_index(t.full_name,' ',-2),' ' ,1),'.',-1) amp,
                    substring_index(substring_index(substring_index(t.full_name,' ',-1),' ' ,1),'.',-1) chw,
                    b.do_foot_screen, dfsr.dmht_foot_screen_result_name result_left, dfsr1.dmht_foot_screen_result_name result_right, 
                    fsu.dmht_foot_screen_ulcer_name foot_ulcer,fsa.dmht_foot_screen_history_amputation_name foot_amp,
                    fsn.dmht_foot_screen_nail_name foot_nail,fsf.dmht_foot_screen_footshape_name foot_foot,
                    fst.dmht_foot_screen_temperature_name foot_temp,fss.dmht_foot_screen_skin_color_name foot_skin,
                     fsd.dmht_foot_screen_die_skin_name foot_die,fsh.dmht_foot_screen_history_sensory_name foot_sens,





                    a.station
                    from
                    (select concat(p.pname,p.fname,' ',p.lname) pname,c.clinic,c.clinicmember_id,c.hn,p.addrpart,p.moopart,tmbpart,amppart,
                            chwpart,
                    case 
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310403' 
                             and p.moopart in ('1','01','2','02','3','03','6','06','7','07','8','08','9','09','10','13','14','15')) then 'รพ.สต.หนองกก'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310403' 
                             and p.moopart in ('4','04','5','05','11','12','16','17')) then 'รพ.สต.บ้านเขว้า'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310405' then 'รพ.สต.ทุ่งโพธิ์'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310406' 
                             and p.moopart in ('1','01','3','03','4','04','9','09','11','12','14')) then 'รพ.สต.หนองทองลิ่ม'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310406' 
                             and p.moopart in ('2','02','5','05','6','06','7','07','8','08','10','13')) then 'รพ.สต.หนองยาง(หนองโบสถ์)'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310408' 
                              and p.moopart in ('1','01','2','02','5','05','7','07','11')) then 'รพ.สต.โคกศรีพัฒนา'
                        when (concat(p.chwpart,p.amppart,p.tmbpart)='310408' 
                              and p.moopart in ('3','03','4','04','6','06','8','08','09','10')) then 'รพ.สต.หนองตาไก้'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310413' then 'รพ.สต.ผักหวาน'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310414' then 'รพ.สต.หนองไทร'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310415' then 'รพ.สต.ก้านเหลือง'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310416' then 'รพ.สต.บ้านสิงห์'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310417' then 'รพ.สต.โคกแร่'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310418' then 'รพ.สต.โคกยาง'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310424' then 'รพ.สต.หนองยาง(หนองยายพิมพ์)'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310425' then 'รพ.สต.หัวถนน'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310426' then 'รพ.สต.ชุมแสง'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310427' then 'รพ.สต.หนองโสน'
                        when concat(p.chwpart,p.amppart,p.tmbpart)='310401' then 'รพ.นางรอง'
                        else '' 
                    end  as station  
                     from clinicmember c
                        left outer join patient p on c.hn=p.hn
                        where c.clinic='001' and (c.discharge='N' or c.discharge='') and $text order by c.clinicmember_id
                    ) as a 
                    inner join  
                    (select vn,clinicmember_id,do_foot_screen,screen_date,clinicmember_cormobidity_screen_id from clinicmember_cormobidity_screen 
                     where screen_date between '{$date1}' and '{$date2}' and do_foot_screen='Y' order by clinicmember_id 
                    ) as b 
                    on a.clinicmember_id=b.clinicmember_id
                    inner join vn_stat v on v.vn=b.vn
                    inner join clinicmember_cormobidity_foot_screen ccfs on ccfs.clinicmember_cormobidity_screen_id = b.clinicmember_cormobidity_screen_id
                    inner join dmht_foot_screen_result dfsr on ccfs.dmht_foot_screen_result_left_id=dfsr.dmht_foot_screen_result_id
                    inner join dmht_foot_screen_result dfsr1 on ccfs.dmht_foot_screen_result_right_id=dfsr1.dmht_foot_screen_result_id
                    inner join thaiaddress t on concat(a.chwpart,a.amppart,a.tmbpart)=t.addressid
                    inner join dmht_foot_screen_ulcer fsu on fsu.dmht_foot_screen_ulcer_id=ccfs.dmht_foot_screen_ulcer_id
                    inner join dmht_foot_screen_history_amputation fsa on fsa.dmht_foot_screen_history_amputation_id=ccfs.dmht_foot_screen_history_amputation_id 
                    inner join dmht_foot_screen_nail fsn on fsn.dmht_foot_screen_nail_id=ccfs.dmht_foot_screen_nail_id 
                    inner join dmht_foot_screen_footshape fsf on fsf.dmht_foot_screen_footshape_id=ccfs.dmht_foot_screen_footshape_id 
                    inner join dmht_foot_screen_temperature fst on fst.dmht_foot_screen_temperature_id=ccfs.dmht_foot_screen_temperature_id
                    inner join dmht_foot_screen_skin_color fss on fss.dmht_foot_screen_skin_color_id=ccfs.dmht_foot_screen_skin_color_id 
                    inner join dmht_foot_screen_die_skin fsd on fsd.dmht_foot_screen_die_skin_id=ccfs.dmht_foot_screen_die_skin_id
                    inner join dmht_foot_screen_history_sensory fsh on fsh.dmht_foot_screen_history_sensory_id=ccfs.dmht_foot_screen_history_sensory_id   

                    order by aid;";
        try {
            $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);  
        return $this -> render('/site/ncd/clinic17-preview',['dataProvider' => $dataProvider,'names' => $names,
                                      'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);           
    }     
     public function actionClinic18Index() {
        $model = new Formmodel();
        $names="รายงานผู้ป่วยเบาหวานชนิดที่ 1 E10.0 - E10.9 (Dm Type I)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ncd/"; 
               return $this->redirect($url.'ncd18.mrt&d1='.$date1.'&d2='.$date2);                 
        }         
        return $this -> render('/site/ncd/clinic18',['mText' => $this->mText,'names' => $names,'model' => $model]);         
    }      
    
    
    
    
}    

