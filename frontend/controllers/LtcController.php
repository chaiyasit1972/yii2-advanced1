<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class LtcController extends Controller
{
    public $mText = "งาน Long Term Care(LTC)";
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
        $names="งาน Long Term Care(LTC)"; 
         return $this -> render('/site/ltc/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionLtc1Index() {
        $model = new Formmodel();
        $names="รายชื่อประชากรในเขตรับผิดชอบ(บัญชี 1)";
        if($model->load(Yii::$app->request->post())){
               $check = $model->radio_list;
               if($check==0){
                      $age1=0;
                      $age2=0;
               }else{
                      $age1 = $model->text1;
                      $age2 = $model->text2;
               }
               return $this->redirect(['ltc1_preview', 'name' =>$names, 'c' =>$check, 'a1' =>$age1, 'a2' =>$age2]);
        }
            return $this -> render('/site/ltc/ltc1-index',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    } 
    public function actionLtc1_preview($name,$c,$a1,$a2) {
          $names = $name;
          $age1=$a1;$age2=$a2;
          if ($c==0){
            $text="ทั้งหมด";  
            $sql="select ps.cid,concat(ps.pname,ps.fname,' ',ps.lname) pname,concat(substr(ps.birthdate,9,2),'-',substr(ps.birthdate,6,2),'-',
                    substr(ps.birthdate,1,4)+543) as birthdate,s.name sex,timestampdiff(year,ps.birthdate,curdate()) age_y,pt.addrpart,
                    pt.moopart,v.village_name,h.house_regist_type_name from person ps inner join patient pt on ps.cid=pt.cid 
                    inner join village v on v.village_id=ps.village_id
                    inner join house_regist_type h on ps.house_regist_type_id=h.house_regist_type_id
                    inner join sex s on s.code=ps.sex
                    where ps.village_id !=9 and ps.cid !='0000000000001'  and ps.death !='Y' order by ps.village_id;";                   
          }else{
            $age1=$a1;$age2=$a2;
            $text="ระหว่งอายุ " . $age1 . "-" . $age2 . "  ปี";
            $sql="select ps.cid,concat(ps.pname,ps.fname,' ',ps.lname) pname,concat(substr(ps.birthdate,9,2),'-',substr(ps.birthdate,6,2),'-',
                    substr(ps.birthdate,1,4)+543) as birthdate,s.name sex,timestampdiff(year,ps.birthdate,curdate()) age_y,pt.addrpart,
                    pt.moopart,v.village_name,h.house_regist_type_name from person ps inner join patient pt on ps.cid=pt.cid 
                    inner join village v on v.village_id=ps.village_id
                    inner join house_regist_type h on ps.house_regist_type_id=h.house_regist_type_id
                    inner join sex s on s.code=ps.sex
                    where ps.village_id !=9 and ps.cid !='0000000000001'  and ps.death !='Y' 
                    and timestampdiff(year,ps.birthdate,curdate()) between '{$age1}' and '{$age2}' order by ps.village_id;";                             
          }
       try {
            $rawData = \Yii::$app->db1->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }        
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);  
        return $this -> render('/site/ltc/ltc1-preview',['dataProvider' => $dataProvider, 'names' => $names, 
                                       'mText' => $this->mText, 'text' => $text]);            
    }    
    public function actionLtc2Index() {
        $model = new Formmodel();
        $names="รายชื่อผู้สูงอายุเสียชีวิต";
        if($model->load(Yii::$app->request->post())){
               $check = $model->radio_list;
               $date1 = $model->date1;
               $date2 = $model->date2;
               return $this->redirect(['ltc2_preview', 'name' =>$names, 'c' =>$check, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/ltc/ltc2-index',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }      
    public function actionLtc2_preview($name,$c,$d1,$d2) {
        $model = new Formmodel();
        $names=$name;
        $date1=$d1;$date2=$d2;
        switch ($c) {
            case 0:
                $text="ในเขตรับผิดชอบ";
                $sql1="select d.hn,d.cid,concat(p.pname,p.fname,' ',p.lname) pname,p.birthdate,d.death_date,
                          timestampdiff(year,p.birthdate,curdate()) age_y,pt.addrpart,v.village_moo,v.village_name,s.name sex from death d 
                          inner join patient pt on d.hn=pt.hn inner join person p on pt.cid=p.cid inner join village v on v.village_id=p.village_id
                          inner join sex s on pt.sex=s.code where p.village_id !='9' and timestampdiff(year,p.birthdate,curdate()) >=60 
                          and d.death_date between '{$date1}' and '{$date2}';";
            break;
            case 1:
                $text="นอกเขตรับผิดชอบ(หมู่ 0)";
                $sql1="select d.hn,d.cid,concat(p.pname,p.fname,' ',p.lname) pname,p.birthdate,d.death_date,
                          timestampdiff(year,p.birthdate,curdate()) age_y,pt.addrpart,v.village_moo,v.village_name,s.name sex from death d 
                          inner join patient pt on d.hn=pt.hn inner join person p on pt.cid=p.cid inner join village v on v.village_id=p.village_id
                          inner join sex s on pt.sex=s.code where p.village_id ='9' and timestampdiff(year,p.birthdate,curdate()) >=60 
                          and d.death_date between '{$date1}' and '{$date2}';";
            break;
            default:
            break;
        }
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
        return $this -> render('/site/ltc/ltc2-preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'text' => $text]);           
    } 
     public function actionLtc3Index()
    {
        $model = new Formmodel();         
        $names = "รายงานการเยี่ยมบ้านผู้สูงอายุกลุ่มติดบ้านติดเตียง";
        $sql1="select concat(village_id,',',village_moo,',',if(village_moo=0,'ทั้งหมด',village_name)) id,
                  if(village_moo=0,'ทั้งหมด',village_name) names from village  order by village_id;";
        $locations = \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','names');        
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;  
               $type = Yii::$app->request->post('type');
               $village=Yii::$app->request->post('village');
            return $this->redirect(['ltc3_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'t1'=>$type,'v1'=>$village]);
        }
         return $this->render('/site/ltc/ltc3-index',['mText' => $this->mText,'names' => $names,
                                    'data'=>$listData, 'model' => $model]);       
    }    
   public function actionLtc3_preview($name,$d1,$d2,$t1,$v1) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $type=  explode(',',$t1);$type_c=$type[0];$type_n=$type[1];
        $village=  explode(',',$v1);$village_id=$village[0];$village_moo=$village[1];$village_name=$village[2];
        switch ($village_moo) {
            case 0:
                $sql1="select pp.vn,pp.hn,pp.pname,pp.visitdate,pp.vstdate,October,November,December,January,February,March,April,May,June,July,
                  August,September,pp.birthdate from person_health_club_member pm inner join (select o.vn,v.hn,
                  concat(p.pname,p.fname,' ',p.lname) pname,p.birthdate ,p.person_id,substr(o.entry_datetime,1,10) visitdate,v.vstdate,
                             IF(MONTH(substr(o.entry_datetime,1,10))=10,substr(o.entry_datetime,1,10),'') as October,
                             IF(MONTH(substr(o.entry_datetime,1,10))=11,substr(o.entry_datetime,1,10),'') as November,
                             IF(MONTH(substr(o.entry_datetime,1,10))=12,substr(o.entry_datetime,1,10),'') as December,
                             IF(MONTH(substr(o.entry_datetime,1,10))=1,substr(o.entry_datetime,1,10),'') as January,
                             IF(MONTH(substr(o.entry_datetime,1,10))=2,substr(o.entry_datetime,1,10),'') as February,
                             IF(MONTH(substr(o.entry_datetime,1,10))=3,substr(o.entry_datetime,1,10),'') as March,
                             IF(MONTH(substr(o.entry_datetime,1,10))=4,substr(o.entry_datetime,1,10),'') as April,
                             IF(MONTH(substr(o.entry_datetime,1,10))=5,substr(o.entry_datetime,1,10),'') as May,
                             IF(MONTH(substr(o.entry_datetime,1,10))=6,substr(o.entry_datetime,1,10),'') as June,
                             IF(MONTH(substr(o.entry_datetime,1,10))=7,substr(o.entry_datetime,1,10),'') as July,
                             IF(MONTH(substr(o.entry_datetime,1,10))=8,substr(o.entry_datetime,1,10),'') as August,
                             IF(MONTH(substr(o.entry_datetime,1,10))=9,substr(o.entry_datetime,1,10),'') as September
                             from ovst_community_service o,vn_stat v,person p where o.vn=v.vn and v.hn=p.patient_hn                              
                             and substr(o.entry_datetime,1,10) between '{$date1}' and '{$date2}' 
                             and o.ovst_community_service_type_id in ('92','93','94') and p.village_id !='{$village_id}') pp
                             on pm.person_id=pp.person_id where pm.person_health_club_id='{$type_c}'  ;";
               $village_moo='';              
            break;
            default:
               $sql1="select pp.vn,pp.hn,pp.pname,pp.visitdate,pp.vstdate,October,November,December,January,February,March,April,May,June,July,
                  August,September,pp.birthdate from person_health_club_member pm inner join (select o.vn,v.hn,
                  concat(p.pname,p.fname,' ',p.lname) pname,p.birthdate ,p.person_id,substr(o.entry_datetime,1,10) visitdate,v.vstdate,
                             IF(MONTH(substr(o.entry_datetime,1,10))=10,substr(o.entry_datetime,1,10),'') as October,
                             IF(MONTH(substr(o.entry_datetime,1,10))=11,substr(o.entry_datetime,1,10),'') as November,
                             IF(MONTH(substr(o.entry_datetime,1,10))=12,substr(o.entry_datetime,1,10),'') as December,
                             IF(MONTH(substr(o.entry_datetime,1,10))=1,substr(o.entry_datetime,1,10),'') as January,
                             IF(MONTH(substr(o.entry_datetime,1,10))=2,substr(o.entry_datetime,1,10),'') as February,
                             IF(MONTH(substr(o.entry_datetime,1,10))=3,substr(o.entry_datetime,1,10),'') as March,
                             IF(MONTH(substr(o.entry_datetime,1,10))=4,substr(o.entry_datetime,1,10),'') as April,
                             IF(MONTH(substr(o.entry_datetime,1,10))=5,substr(o.entry_datetime,1,10),'') as May,
                             IF(MONTH(substr(o.entry_datetime,1,10))=6,substr(o.entry_datetime,1,10),'') as June,
                             IF(MONTH(substr(o.entry_datetime,1,10))=7,substr(o.entry_datetime,1,10),'') as July,
                             IF(MONTH(substr(o.entry_datetime,1,10))=8,substr(o.entry_datetime,1,10),'') as August,
                             IF(MONTH(substr(o.entry_datetime,1,10))=9,substr(o.entry_datetime,1,10),'') as September
                             from ovst_community_service o,vn_stat v,person p where o.vn=v.vn and v.hn=p.patient_hn                              
                             and substr(o.entry_datetime,1,10) between '{$date1}' and '{$date2}' 
                             and o.ovst_community_service_type_id in ('92','93','94') and p.village_id='{$village_id}') pp
                             on pm.person_id=pp.person_id where pm.person_health_club_id='{$type_c}'  ;";       
            break;
        }
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
        return $this -> render('/site/ltc/ltc3-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type_n'=>$type_n,
                                    'village_moo'=>$village_moo,'village_name'=>$village_name]);                                
    }        
     public function actionLtc4Index()
    {
        $model = new Formmodel();
        $names = "รายงานทะเบียนชมรมสร้างสุขภาพ";
        $sql1="select concat(person_health_club_id,',',person_health_club_name) id,person_health_club_name names "
                . "from person_health_club;";
        $locations = \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','names');        
        if($model->load(Yii::$app->request->post())){
            $date1 = $model->date1;
            $type = $model->select1;           
            return $this->redirect(['ltc4_preview','name'=>$names,'d1'=>$date1,'t1'=>$type]);
        }
         return $this->render('/site/ltc/ltc4-index',['mText' => $this->mText,'names' => $names, 
                             'model'=>$model, 'data'=>$listData]);       
    }  
    public function actionLtc4_preview($name,$d1,$t1) {
        $names=$name;
        $date1=$d1;
        $type=  explode(',', $t1);$type_c=$type[0];$type_name=$type[1];
        $sql1="select a.*,b.clinic 
                    from 
                    (select p.cid,pt.hn,concat(p.pname,p.fname,' ',p.lname) pname, timestampdiff(year,pt.birthday,curdate()) age_y,
                             pt.addrpart,pt.moopart,t1.name tmb,t2.name amp,t3.name chw,
                             p1.register_date,p1.discharge_date,p1.discharge,p1.person_remark remark from person_health_club_member p1 
                             left outer join person p on p.person_id=p1.person_id 
                             left outer join patient pt on p.cid=pt.cid 
                             left outer join thaiaddress t1 on t1.addressid=concat(pt.chwpart,pt.amppart,pt.tmbpart)
                             left outer join thaiaddress t2 on t2.addressid=concat(pt.chwpart,pt.amppart,'00')
                             left outer join thaiaddress t3 on t3.addressid=concat(pt.chwpart,'0000')
                             where p1.person_health_club_id = '{$type_c}'
                    ) a 
                    left outer join 
                    (select c.hn,group_concat(c1.name) clinic from clinicmember c inner join clinic c1 on c.clinic=c1.clinic group by hn 
                    ) b
                    on a.hn=b.hn;";
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
        return $this -> render('/site/ltc/ltc4-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'type_name'=>$type_name]);                           
    }      
    public function actionLtc5Index() {
        $model = new Formmodel();
        $names="รายงานทะเบียนผู้เสียชีวิต(บัญชี 1)";
        if($model->load(Yii::$app->request->post())){
               $check = $model->radio_list;
               $date1 = $model->date1;
               $date2 = $model->date2;
               return $this->redirect(['ltc5_preview', 'name' =>$names, 'c' =>$check, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/ltc/ltc5-index',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }     
    public function actionLtc5_preview($name,$c,$d1,$d2) {
        $model = new Formmodel();
        $names=$name;
        $date1=$d1;$date2=$d2;
        switch ($c) {
            case 0:
                $text="ทั้งหมด";
                $sql1="select p.cid,concat(p.pname,p.fname,'  ',p.lname) as pname,v.village_moo,v.village_name,
                          p.birthdate,pt.death_date,  c1.name1 as name504  ,i1.name as icdname
                          from person_death pt 
                          left outer join person p on p.person_id = pt.person_id 
                          left outer join village v on v.village_id=p.village_id
                          left outer join rpt_504_name c1 on c1.id=pt.death_cause 
                          left outer join icd101 i1 on i1.code=pt.death_diag_1 
                         where pt.death_date between '{$date1}' and '{$date2}';";
            break;            
            case 1:
                $text="ในเขตรับผิดชอบ";
                $sql1="select p.cid,concat(p.pname,p.fname,'  ',p.lname) as pname,v.village_moo,v.village_name,
                          p.birthdate,pt.death_date,  c1.name1 as name504  ,i1.name as icdname
                          from person_death pt 
                          left outer join person p on p.person_id = pt.person_id 
                          left outer join village v on v.village_id=p.village_id
                          left outer join rpt_504_name c1 on c1.id=pt.death_cause 
                          left outer join icd101 i1 on i1.code=pt.death_diag_1 
                         where pt.death_date between '{$date1}' and '{$date2}' and p.village_id !=9  ;";
            break;
            case 2:
                $text="นอกเขตรับผิดชอบ(หมู่ 0)";
                $sql1="select p.cid,concat(p.pname,p.fname,'  ',p.lname) as pname,v.village_moo,v.village_name,
                          p.birthdate,pt.death_date,  c1.name1 as name504  ,i1.name as icdname
                          from person_death pt 
                          left outer join person p on p.person_id = pt.person_id 
                          left outer join village v on v.village_id=p.village_id
                          left outer join rpt_504_name c1 on c1.id=pt.death_cause 
                          left outer join icd101 i1 on i1.code=pt.death_diag_1 
                         where pt.death_date between '{$date1}' and '{$date2}' and p.village_id=9  ;";
            break;
            default:
            break;
        }
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
        return $this -> render('/site/ltc/ltc5-preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'text' => $text]);           
    }            
    public function actionLtc6Index() {
        $model = new Formmodel();
        $names="รายงานทะเบียนผู้ป่วย stroke"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $check = $model->radio_list;
               if ($check==0){               
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ltc/";   
               return $this->redirect($url.'ltc1_in.mrt&d1='.$date1);                     
               }else{
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ltc/";   
               return $this->redirect($url.'ltc1_out.mrt&d1='.$date1);                           
               }
        }
            return $this -> render('/site/ltc/ltc6-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionLtc7Index() {
        $model = new Formmodel();
        $names="รายงานทะเบียนผู้ป่วยคลินิกสุขภาพจิต"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $check = $model->radio_list;
               if ($check==0){               
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ltc/";   
               return $this->redirect($url.'ltc2_in.mrt&d1='.$date1);                            
               }else{
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ltc/";   
               return $this->redirect($url.'ltc2_out.mrt&d1='.$date1);                           
               }
        }
            return $this -> render('/site/ltc/ltc7-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionLtc8Index() {
        $model = new Formmodel();
        $names="รายงานทะเบียนผู้ป่วย(สูงอายุ)โรคเรื้อรัง ในเขตรับผิดชอบ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $s1= $model->select1;
               return $this->redirect(['ltc8_preview', 'name' => $names, 'd1' => $date1, 's1' => $s1]);                                         
        }
            return $this -> render('/site/ltc/ltc8-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }
     public function actionLtc8_preview($name,$d1,$s1) {
        $names=$name;
        $date1=$d1;  
        $type=  explode(',', $s1);$type_c=$type[0];$type_n=$type[1];
        
        switch ($type_c) {
            case 1:
               $sql1 ="select  a.*, b.bmi, b.bmi_n  from 
                         (select max(o.vn) vn, pt.hn, concat(pt.pname,pt.fname,' ',pt.lname) pname, timestampdiff(year,pt.birthday,curdate()) age_y, 
                            pt.addrpart, pt.moopart, v.village_name, min(o.vstdate) vstdate, o.icd10, i.name diag, v.village_id
                            from ovstdiag o 
                            left outer join patient pt on o.hn=pt.hn
                            left outer join person ps on pt.cid=ps.cid
                            left outer join icd101 i on o.icd10=i.code
                            left outer join village v on v.village_id=ps.village_id
                            where (pt.cid is not null or pt.cid !='') and ps.village_id !='9'  and
                            timestampdiff(year,pt.birthday,curdate()) >= '60' and o.icd10 between 'E10' and 'E149' 
                            group by pt.cid order by v.village_id 
                          ) a
                            left outer join
                           (select vn,hn,bmi,
                              if((bmi is null or bmi = 0),' ', if(bmi between 0 and 18.59,'ผอม', if(bmi between 18.6 and 22.99,'ปกติ',
                                    if(bmi between 23.0 and 24.99,'ท้วม', if(bmi between 25.0 and 29.99,'อ้วน',
                                    if(bmi >= 30,'อ้วนมาก',null ) ) ) ) ) ) bmi_n 
                              from opdscreen 
                           ) b
                           on a.vn=b.vn 
                           order by a.village_id "; 
                
            break;
            case 2:
               $sql1 ="select  a.*, b.bmi, b.bmi_n  from 
                          (select max(o.vn) vn, pt.hn, concat(pt.pname,pt.fname,' ',pt.lname) pname, timestampdiff(year,pt.birthday,curdate()) age_y, 
                            pt.addrpart, pt.moopart, v.village_name, min(o.vstdate) vstdate, o.icd10, i.name diag ,v.village_id 
                            from ovstdiag o 
                            left outer join patient pt on o.hn=pt.hn
                            left outer join person ps on pt.cid=ps.cid
                            left outer join icd101 i on o.icd10=i.code
                            left outer join village v on v.village_id=ps.village_id
                            where (pt.cid is not null or pt.cid !='') and ps.village_id !='9'  and
                            timestampdiff(year,pt.birthday,curdate()) >= '60' and o.icd10 between 'I10' and 'I159' 
                            group by pt.cid order by v.village_id 
                          ) a
                            left outer join
                           (select vn,hn,bmi,
                              if((bmi is null or bmi = 0),' ', if(bmi between 0 and 18.59,'ผอม', if(bmi between 18.6 and 22.99,'ปกติ',
                                    if(bmi between 23.0 and 24.99,'ท้วม', if(bmi between 25.0 and 29.99,'อ้วน',
                                    if(bmi >= 30,'อ้วนมาก',null ) ) ) ) ) ) bmi_n 
                              from opdscreen 
                           ) b
                           on a.vn=b.vn 
                           order by a.village_id ;"; 
            break;
            case 3:
               $sql1 ="select  a.*, b.bmi, b.bmi_n  from 
                          (select max(o.vn) vn, pt.hn, concat(pt.pname,pt.fname,' ',pt.lname) pname, timestampdiff(year,pt.birthday,curdate()) age_y, 
                            pt.addrpart, pt.moopart, v.village_name, min(o.vstdate) vstdate, o.icd10, i.name diag ,v.village_id
                            from ovstdiag o 
                            left outer join patient pt on o.hn=pt.hn
                            left outer join person ps on pt.cid=ps.cid
                            left outer join icd101 i on o.icd10=i.code
                            left outer join village v on v.village_id=ps.village_id
                            where (pt.cid is not null or pt.cid !='') and ps.village_id !='9'  and
                            timestampdiff(year,pt.birthday,curdate()) >= '60' and o.icd10 between 'I20' and 'I259' 
                            group by pt.cid order by v.village_id 
                          ) a
                            left outer join
                           (select vn,hn,bmi,
                              if((bmi is null or bmi = 0),' ', if(bmi between 0 and 18.59,'ผอม', if(bmi between 18.6 and 22.99,'ปกติ',
                                    if(bmi between 23.0 and 24.99,'ท้วม', if(bmi between 25.0 and 29.99,'อ้วน',
                                    if(bmi >= 30,'อ้วนมาก',null ) ) ) ) ) ) bmi_n 
                              from opdscreen 
                           ) b
                           on a.vn=b.vn 
                           order by a.village_id ;"; 
            break;
            case 4:
               $sql1 ="select  a.*, b.bmi, b.bmi_n  from 
                          (select max(o.vn) vn, pt.hn, concat(pt.pname,pt.fname,' ',pt.lname) pname, timestampdiff(year,pt.birthday,curdate()) age_y, 
                            pt.addrpart, pt.moopart, v.village_name, min(o.vstdate) vstdate, o.icd10, i.name diag, v.village_id
                            from ovstdiag o 
                            left outer join patient pt on o.hn=pt.hn
                            left outer join person ps on pt.cid=ps.cid
                            left outer join icd101 i on o.icd10=i.code
                            left outer join village v on v.village_id=ps.village_id
                            where (pt.cid is not null or pt.cid !='') and ps.village_id !='9'  and
                            timestampdiff(year,pt.birthday,curdate()) >= '60' and o.icd10 between 'I60' and 'I649' 
                            group by pt.cid order by v.village_id 
                          ) a
                            left outer join
                           (select vn,hn,bmi,
                              if((bmi is null or bmi = 0),' ', if(bmi between 0 and 18.59,'ผอม', if(bmi between 18.6 and 22.99,'ปกติ',
                                    if(bmi between 23.0 and 24.99,'ท้วม', if(bmi between 25.0 and 29.99,'อ้วน',
                                    if(bmi >= 30,'อ้วนมาก',null ) ) ) ) ) ) bmi_n 
                              from opdscreen 
                           ) b
                           on a.vn=b.vn 
                           order by a.village_id ;"; 
            break;
            case 5:
               $sql1 ="select  a.*, b.bmi, b.bmi_n  from 
                          (select max(o.vn) vn,pt.hn, concat(pt.pname,pt.fname,' ',pt.lname) pname, timestampdiff(year,pt.birthday,
                            curdate()) age_y, pt.addrpart, pt.moopart, v.village_name, min(o.vstdate) vstdate, o.icd10, i.name diag,
                            v.village_id from ovstdiag o 
                            left outer join patient pt on o.hn=pt.hn
                            left outer join person ps on pt.cid=ps.cid
                            left outer join icd101 i on o.icd10=i.code
                            left outer join village v on v.village_id=ps.village_id
                            where (pt.cid is not null or pt.cid !='') and ps.village_id !='9'  and
                            timestampdiff(year,pt.birthday,curdate()) >= '60' and o.icd10 between 'N183' and 'N189' 
                            group by pt.cid order by v.village_id 
                          ) a
                            left outer join
                           (select vn,hn,bmi,
                              if((bmi is null or bmi = 0),' ', if(bmi between 0 and 18.59,'ผอม', if(bmi between 18.6 and 22.99,'ปกติ',
                                    if(bmi between 23.0 and 24.99,'ท้วม', if(bmi between 25.0 and 29.99,'อ้วน',
                                    if(bmi >= 30,'อ้วนมาก',null ) ) ) ) ) ) bmi_n 
                              from opdscreen 
                           ) b
                           on a.vn=b.vn 
                           order by a.village_id ;"; 
            break;
            default:
            break;
        }
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
        return $this->render('/site/ltc/ltc8-preview',['mText'=>$this->mText,'names'=>$names,
                                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'sname' =>$type_n]);      
    }    
    public function actionLtc9Index() {
        $model = new Formmodel();
        $names="รายงานทะเบียนผู้ป่วยสูงอายุ >= 100 ปีขึ้นไป"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $check = $model->radio_list;
               if ($check==0){               
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ltc/";   
               return $this->redirect($url.'ltc3_in.mrt&d1='.$date1);                            
               }else{
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ltc/";   
               return $this->redirect($url.'ltc3_out.mrt&d1='.$date1);                           
               }
        }
            return $this -> render('/site/ltc/ltc9-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    
    public function actionLtc10Index() {
        $model = new Formmodel();
        $names="รายงานประชากรแยกตามกลุ่มอายุ/เพศ รายหมู่บ้าน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;        
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ltc/";   
               return $this->redirect($url.'ltc4.mrt&d1='.$date1);                            
        }
            return $this -> render('/site/ltc/ltc10-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionLtc11Index() {
        $model = new Formmodel();
        $names="รายงานข้อมูลทั่วไปและผลการประเมินการคัดกรองภาวะสุขภาพในผู้สูงอายุ"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;        
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=ltc/";   
               return $this->redirect($url.'ltc5.mrt&d1='.$date1.'&d2='.$date2);                            
        }
            return $this -> render('/site/ltc/ltc11-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }       
    
}    