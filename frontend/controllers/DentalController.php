<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class DentalController extends Controller
{
    public $mText = "งานทันตกรรม";
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
        $names="งานทันตกรรม"; 
         return $this -> render('/site/dental/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionDental1Index(){
        $model = new Formmodel();        
        $names="รายงานตรวจสุขภาพช่องปาก(dental care)";  
        $sql1="select concat(dental_care_type_id,',',dental_care_type_name) id,dental_care_type_name dname
                  from dental_care_type order by 1;";
        $locations =  \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','dname');               
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type =  $model->select1;            
            return $this->redirect(['dental1_preview','d1' => $date1,'d2' => $date2,'t' => $type]); 
        }        
        return $this->render('/site/dental/dental1-index',['mText'=>$this->mText,'names'=>$names,
                         'listData'=>$listData, 'model' => $model]);                
    }
    public function actionDental1_preview($d1,$d2,$t) {
        $names="รายงานตรวจสุขภาพช่องปาก(dental care)";  
        $date1=$d1;$date2=$d2;$type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];
        $sql1="select  v.hn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y,p.addrpart,v.vstdate,substr(d.entry_datetime,1,10) ddate,
                  dt.dental_care_type_name,ps.patient_hn,ps.patient_link,ps.house_regist_type_id,vs1.school_name,
                  vc.village_school_class_name,p.moopart,t1.name tmb,t2.`name` amp,t3.`name` chw
                  from dental_care d left outer join vn_stat v on d.vn=v.vn left outer join patient p on p.hn=v.hn
                  left outer join dental_care_type dt on d.dental_care_type_id=dt.dental_care_type_id left outer join person ps on ps.cid=p.cid
                  left outer join village_student vs on ps.person_id=vs.person_id 
                  left outer join village_school vs1 on vs.village_school_id=vs1.village_school_id 
                  left outer join village_school_class vc on vc.village_school_class_id=vs.village_school_class_id
                  left outer join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                  left outer join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                  left outer join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                  where d.dental_care_type_id='{$type_c}' and v.vstdate between '{$date1}' and '{$date2}'  order by ddate ;";
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
        return $this -> render('/site/dental/dental1-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type_n'=>$type_n]);         
    }    
    public function actionDental2Index(){
        $model = new Formmodel();             
        $names="หญิงมีครรภ์ได้รับการตรวจสุขภาพช่องปากไม่น้อยกว่าร้อยละ 90(คนที่คลอดในช่วง)(kpi 1.1)";           
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental2_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental2-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    }      
    public function actionDental2_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $date0=date("Y-m-d",strtotime("-365 days",strtotime($date1)));
        $type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1]; 
        switch ($type_c) {
               case 1:
                       $sql1 = "select p.cid,p.patient_hn hn,p.person_id,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.birthdate,
                                   p.house_regist_type_id,p.death,p.person_discharge_id,v.village_moo,v.village_name,pa.lmp,pa.anc_register_date,
                                   pa.labor_date,d.vstdate,d.icd10tm_operation_code,d.`name` dname
	               from (select pa.person_id,pa.lmp,pa.anc_register_date,pa.labor_date from person_anc pa where
                                    pa.labor_date between '{$date1}' and '{$date2}' and pa.labor_status_id in('2') group by pa.person_id
                            ) as pa 
                            inner join person p on p.person_id = pa.person_id 
                            left outer join village v on v.village_id = p.village_id
                            left outer join (
                                 select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code 
                                        from (
                                              select d.`name`,d.icd10tm_operation_code,d.`code` 
                                                 from dttm d where d.icd10tm_operation_code in('2330011')
                                         ) as d
                                         inner join  (select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date0}' and '{$date2}') as dt 
                                         on dt.tmcode = d.`code` group by dt.hn
                             ) as d on d.hn = p.patient_hn 
                            where if(d.icd10tm_operation_code is not null or d.icd10tm_operation_code <>'' ,'T','F')='T' 
                            order by p.house_regist_type_id;";
               break;
               case 2:
                       $sql1 = "select p.cid,p.patient_hn hn,p.person_id,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.birthdate,
                                   p.house_regist_type_id,p.death,p.person_discharge_id,v.village_moo,v.village_name,pa.lmp,pa.anc_register_date,
                                   pa.labor_date,d.vstdate,d.icd10tm_operation_code,d.`name` dname
	                    from (select pa.person_id,pa.lmp,pa.anc_register_date,pa.labor_date from person_anc pa where
                                    pa.labor_date between '{$date1}' and '{$date2}' and pa.labor_status_id in('2') group by pa.person_id) as pa 
                                    inner join person p on p.person_id = pa.person_id left outer join village v on v.village_id = p.village_id
                                     left outer join (select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code 
                                    from (select d.`name`,d.icd10tm_operation_code,d.`code` 
                                    from dttm d where d.icd10tm_operation_code in('2330011')) as d
                                    inner join  (select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date0}' and '{$date2}') as dt 
                                    on dt.tmcode = d.`code` group by dt.hn) as d on d.hn = p.patient_hn where p.house_regist_type_id in('1','3')
                                    and v.village_moo <> 0 and p.death <> 'Y' and p.person_discharge_id='9' 
                                    and if(d.icd10tm_operation_code is not null or d.icd10tm_operation_code <>'' ,'T','F')='T';";
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
        return $this -> render('/site/dental/dental2-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type'=>$type_n]);                                         
    }    
    public function actionDental3Index(){
        $model = new Formmodel();             
        $names="หญิงมีครรภ์ได้รับการตรวจสุขภาพช่องปากไม่น้อยกว่าร้อยละ 90(คนตั้งครรภ์ที่ LMP ในช่วง)(kpi 1.1.1)";            
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental3_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental3-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    }    
    public function actionDental3_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1]; 
        switch ($type_c) {
            case 1:
        $sql1 = "select p.cid,p.patient_hn hn,p.person_id,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.birthdate,
                    p.house_regist_type_id, p.death,p.person_discharge_id,v.village_moo,v.village_name,pa.lmp,pa.anc_register_date,
                    pa.labor_date,d.vstdate, d.icd10tm_operation_code,d.`name` dname
	     from (select pa.person_id,pa.lmp,pa.anc_register_date,pa.labor_date from person_anc pa where
                   pa.lmp between '{$date1}' and '{$date2}'  group by pa.person_id) as pa 
                   inner join person p on p.person_id = pa.person_id left outer join village v on v.village_id = p.village_id
	     left outer join (select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code 
                   from (select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2330011')) as d
                   inner join  (select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}') as dt 
                   on dt.tmcode = d.`code` group by dt.hn) as d on d.hn = p.patient_hn 
                   where if(d.icd10tm_operation_code is not null or d.icd10tm_operation_code <>'' ,'T','F')='T'
                   order by p.house_regist_type_id;";

           break;
            case 2:
        $sql1 = "select p.cid,p.patient_hn hn,p.person_id,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.birthdate,p.house_regist_type_id,
                    p.death,p.person_discharge_id,v.village_moo,v.village_name,pa.lmp,pa.anc_register_date,pa.labor_date,d.vstdate,
	     d.icd10tm_operation_code,d.`name` dname
	     from (select pa.person_id,pa.lmp,pa.anc_register_date,pa.labor_date from person_anc pa where
                   pa.lmp between '{$date1}' and '{$date2}'  group by pa.person_id) as pa 
                   inner join person p on p.person_id = pa.person_id left outer join village v on v.village_id = p.village_id
	     left outer join (select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code 
                   from (select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2330011')) as d
                   inner join  (select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}') as dt 
                   on dt.tmcode = d.`code` group by dt.hn) as d on d.hn = p.patient_hn where p.house_regist_type_id in('1','3')
	     and v.village_moo <> 0 and p.death <> 'Y' and p.person_discharge_id='9' 
                   and if(d.icd10tm_operation_code is not null or d.icd10tm_operation_code <>'' ,'T','F')='T';";
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
        return $this -> render('/site/dental/dental3-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type'=>$type_n]);           
    }

        public function actionDental4Index(){
        $model = new Formmodel();             
        $names="เด็กต่ำกว่า 3 ปี ได้รับการตรวจสุขภาพช่องปากไม่น้อยกว่าร้อยละ 80(kpi 1.2)";                
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental4_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental4-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    }  
    public function actionDental4_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];        
        switch ($type_c) {
            case 1:
        $sql1="select  d.hn,p.pname,p.age_y,p.age_m,p.vstdate,ps.house_regist_type_id,v.village_moo,v.village_name,d.`name` dname							
	   from (
                    select v.vn,v.hn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y,v.age_m,v.vstdate
                             from vn_stat v inner join patient p on v.hn=p.hn
                             where v.age_y < 3
                ) as p 
                inner join (
                        select dt.vn,dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from
                            (select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2330011')) as d 
                               inner join (select vn, hn,vstdate,tmcode from dtmain dt where dt.vstdate between '2014-10-01' and '2015-08-19') as dt
                               on dt.tmcode = d.`code` group by dt.hn
                ) as d on d.vn = p.vn
                left outer join person ps on ps.patient_hn=p.hn
                left outer join village v on ps.village_id = v.village_id
                order by ps.house_regist_type_id desc;";
            break;
            case 2:
        $sql1="select p.cid,p.patient_hn hn,p.person_id,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.age_y,p.age_m,p.birthdate,
                 p.house_regist_type_id,p.death,p.person_discharge_id,p.village_moo,p.village_name,d.vstdate,d.icd10tm_operation_code,
                 d.`name` dname							
	   from (select p.cid,p.patient_hn,p.person_id,p.pname,p.fname,p.lname,p.sex,p.birthdate,p.house_regist_type_id,p.death,
                 p.person_discharge_id,v.village_moo,v.village_name, substr(LPAD(timestampdiff(year,p.birthdate,'{$date1}'),2,'0'),2,1) age_y,
                 LPAD(timestampdiff(month,p.birthdate,'{$date1}')-(timestampdiff(year,p.birthdate,'{$date1}')*12),2,'0') age_m    
                 from person p left outer join village v on p.village_id = v.village_id
                 where  concat( LPAD(timestampdiff(year,p.birthdate,'{$date1}'),2,'0'),
                 LPAD(timestampdiff(month,p.birthdate,'{$date1}')-(timestampdiff(year,p.birthdate,'{$date1}')*12),2,'0'),
                 LPAD(timestampdiff(day,date_add(p.birthdate,interval (timestampdiff(month,p.birthdate,'{$date1}')) month),'{$date1}'),2,'0')
	  ) between '000000' and '021129' and p.house_regist_type_id in('1','3') and p.person_discharge_id='9' 
                and p.death <> 'Y' and v.village_moo <> 0 group by cid) as p 
                 left outer join (select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from
                 (select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2330011')) as d 
                    inner join (select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}') as dt
                    on dt.tmcode = d.`code` group by dt.hn) as d on d.hn = p.patient_hn 
               where if(d.icd10tm_operation_code is not null or d.icd10tm_operation_code <>'' ,'T','F') = 'T';";  
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
        return $this -> render('/site/dental/dental4-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type'=>$type_n]);           
    }       
        public function actionDental5Index(){
        $model = new Formmodel();             
        $names="เด็กต่ำกว่า 3 ปี ได้รับการฝึกทักษะการแปรงฟันไม่น้อยกว่าร้อยละ 80(kpi 1.3)";                 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental5_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental5-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    }      
    public function actionDental5_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];        
        switch ($type_c) {
            case 1:
        $sql1="select d.hn,p.pname,p.age_y,p.age_m,d.vstdate,ps.house_regist_type_id,v.village_moo,v.village_name,d.`name` dname							
	   from (
                 select  v.vn,v.hn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y,v.age_m from vn_stat v 
                  inner join patient p on p.hn=v.hn where v.age_y<3
                    ) as p 
                    inner join (
                      select dt.vn,dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from (
                            select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2338610')) as d 
                            inner join (select vn, hn,vstdate,tmcode from dtmain dt where dt.vstdate between  '{$date1}' and '{$date2}') as dt
                            on dt.tmcode = d.`code` group by dt.hn
                    ) as d on d.vn = p.vn 
                    left outer join person ps on ps.patient_hn=p.hn
                    left outer join village v on ps.village_id = v.village_id
                    order by ps.house_regist_type_id desc;";        
            break;
            case 2:
        $sql1="select p.cid,p.patient_hn hn,p.person_id,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.age_y,p.age_m,p.birthdate,
                 p.house_regist_type_id,p.death,p.person_discharge_id,p.village_moo,p.village_name,d.vstdate,d.icd10tm_operation_code,
                 d.`name` dname							
	   from (select p.cid,p.patient_hn,p.person_id,p.pname,p.fname,p.lname,p.sex,p.birthdate,p.house_regist_type_id,p.death,
                 p.person_discharge_id,v.village_moo,v.village_name, substr(LPAD(timestampdiff(year,p.birthdate,'{$date1}'),2,'0'),2,1) age_y,
                 LPAD(timestampdiff(month,p.birthdate,'{$date1}')-(timestampdiff(year,p.birthdate,'{$date1}')*12),2,'0') age_m    
                 from person p left outer join village v on p.village_id = v.village_id
                 where  concat( LPAD(timestampdiff(year,p.birthdate,'{$date1}'),2,'0'),
                 LPAD(timestampdiff(month,p.birthdate,'{$date1}')-(timestampdiff(year,p.birthdate,'{$date1}')*12),2,'0'),
                 LPAD(timestampdiff(day,date_add(p.birthdate,interval (timestampdiff(month,p.birthdate,'{$date1}')) month),'{$date1}'),2,'0')
	  ) between '000000' and '021129' and p.house_regist_type_id in('1','3') and p.person_discharge_id='9' 
                and p.death <> 'Y' and v.village_moo <> 0 group by cid) as p 
                 left outer join (select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from
                 (select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2338610')) as d 
                    inner join (select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}') as dt
                    on dt.tmcode = d.`code` group by dt.hn) as d on d.hn = p.patient_hn 
               where if(d.icd10tm_operation_code is not null or d.icd10tm_operation_code <>'' ,'T','F') = 'T';";                  
            break;
            default :
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
        return $this -> render('/site/dental/dental5-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type'=>$type_n]);           
    }         
        public function actionDental6Index(){
        $model = new Formmodel();             
        $names="เด็กต่ำกว่า 3 ปี ได้รับฟลูออไรด์ไม่น้อยกว่าร้อยละ 50(kpi 1.4)";                   
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental6_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental6-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    }      
    public function actionDental6_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];        
        switch ($type_c) {
            case 1:
       $sql1="select d.hn,p.pname,p.age_y,p.age_m,d.vstdate,ps.house_regist_type_id,v.village_moo,v.village_name,d.`name` dname							
	   from (
                 select  v.vn,v.hn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y,v.age_m from vn_stat v 
                  inner join patient p on p.hn=v.hn where v.age_y<3
                ) as p 
                inner join (
                  select dt.vn,dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from (
                        select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2377021','2377020')) as d 
                        inner join (select vn, hn,vstdate,tmcode from dtmain dt where dt.vstdate between  '{$date1}' and '{$date2}') as dt
                        on dt.tmcode = d.`code` group by dt.hn
                ) as d on d.vn = p.vn 
                left outer join person ps on ps.patient_hn=p.hn
                left outer join village v on ps.village_id = v.village_id
                order by ps.house_regist_type_id desc;";         
            break;
            case 2:
        $sql1="select p.cid,p.patient_hn hn,p.person_id,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.age_y,p.age_m,p.birthdate,
                 p.house_regist_type_id,p.death,p.person_discharge_id,p.village_moo,p.village_name,d.vstdate,d.icd10tm_operation_code,
                 d.`name` dname							
	   from (select p.cid,p.patient_hn,p.person_id,p.pname,p.fname,p.lname,p.sex,p.birthdate,p.house_regist_type_id,p.death,
                 p.person_discharge_id,v.village_moo,v.village_name, substr(LPAD(timestampdiff(year,p.birthdate,'{$date1}'),2,'0'),2,1) age_y,
                 LPAD(timestampdiff(month,p.birthdate,'{$date1}')-(timestampdiff(year,p.birthdate,'{$date1}')*12),2,'0') age_m    
                 from person p left outer join village v on p.village_id = v.village_id
                 where  concat( LPAD(timestampdiff(year,p.birthdate,'{$date1}'),2,'0'),
                 LPAD(timestampdiff(month,p.birthdate,'{$date1}')-(timestampdiff(year,p.birthdate,'{$date1}')*12),2,'0'),
                 LPAD(timestampdiff(day,date_add(p.birthdate,interval (timestampdiff(month,p.birthdate,'{$date1}')) month),'{$date1}'),2,'0')
	  ) between '000000' and '021129' and p.house_regist_type_id in('1','3') and p.person_discharge_id='9' 
                and p.death <> 'Y' and v.village_moo <> 0 group by cid) as p 
                 left outer join (select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from
               (select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2377021','2377020')) as d 
                    inner join (select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}') as dt
                    on dt.tmcode = d.`code` group by dt.hn) as d on d.hn = p.patient_hn 
               where if(d.icd10tm_operation_code is not null or d.icd10tm_operation_code <>'' ,'T','F') = 'T';";       
        break;
        default :
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
        return $this -> render('/site/dental/dental6-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type'=>$type_n]);           
    }      
        public function actionDental7Index(){
        $model = new Formmodel();             
        $names="เด็กนักเรียน ป. 1 ได้รับการตรวจสุขภาพช่องปากไม่น้อยกว่าร้อยละ 90(kpi 2.1)";                   
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;        
            return $this->redirect(['dental7_preview','name'=>$names,'d1' => $date1,'d2' => $date2]); 
        }         
        return $this->render('/site/dental/dental7-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    }   
    public function actionDental7_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select p.cid,p.patient_hn hn,p.person_id,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.birthdate,p.house_regist_type_id,
                  p.death,p.person_discharge_id,v.village_moo,vs.village_school_class_name,vs.school_name,d.vstdate,d.icd10tm_operation_code,
                  d.`name` dname	from (select vs.person_id,vsc.village_school_class_name,vsch.school_name 
	    from village_student vs left outer join village_school_class vsc on vs.village_school_class_id = vsc.village_school_class_id
	    left outer join village_school vsch on vsch.village_school_id = vs.village_school_id
	    where (vs.discharge is null or vs.discharge='' or vs.discharge='N') and vsc.village_school_class_id in('4')) as vs 
	    inner join person p on p.person_id  = vs.person_id left outer join village v on v.village_id = p.village_id
	    left outer join (select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from (
	    select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2330011')) as d
                  inner join (select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}') as dt
                  on dt.tmcode = d.`code` group by dt.hn) as d on d.hn = p.patient_hn
	   where p.death <> 'Y' and p.person_discharge_id='9' and
                 if(d.icd10tm_operation_code is not null or  d.icd10tm_operation_code <>'' ,'T','F') ='T' group by p.cid;";
        try {
            $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }                  
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 10,
                ],
        ]);  
        return $this -> render('/site/dental/dental7-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);           
    }
        public function actionDental8Index(){
        $model = new Formmodel();             
        $names="เด็กนักเรียน ป. 1 ได้รับการเคลือบปิดหลุมร่องฟันไม่น้อยกว่าร้อยละ 50(kpi 2.2)";                     
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;        
            return $this->redirect(['dental8_preview','name'=>$names,'d1' => $date1,'d2' => $date2]); 
        }         
        return $this->render('/site/dental/dental8-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    }  
    public function actionDental8_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select p.cid,p.patient_hn hn,p.person_id,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.birthdate,p.house_regist_type_id,
                  p.death,p.person_discharge_id,v.village_moo,vs.village_school_class_name,vs.school_name,d.vstdate,d.icd10tm_operation_code,
                  d.`name` dname	from (select vs.person_id,vsc.village_school_class_name,vsch.school_name 
	    from village_student vs left outer join village_school_class vsc on vs.village_school_class_id = vsc.village_school_class_id
	    left outer join village_school vsch on vsch.village_school_id = vs.village_school_id
	    where (vs.discharge is null or vs.discharge='' or vs.discharge='N') and vsc.village_school_class_id in('4')) as vs 
	    inner join person p on p.person_id  = vs.person_id left outer join village v on v.village_id = p.village_id
	    left outer join (select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from (
	    select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code in('2387030')) as d
                  inner join (select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}') as dt
                  on dt.tmcode = d.`code` group by dt.hn) as d on d.hn = p.patient_hn
	   where p.death <> 'Y' and p.person_discharge_id='9' and
                 if(d.icd10tm_operation_code is not null or  d.icd10tm_operation_code <>'' ,'T','F') ='T' group by p.cid;";
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
        return $this -> render('/site/dental/dental8-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);           
    }    
        public function actionDental9Index(){
        $model = new Formmodel();             
        $names="รายงานเด็ก ป.1 - ป.6 (อายุ 6-12 ปี) ได้รับบริการทันตกรรม(kpi 2.3)";                 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental9_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental9-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    } 
    public function actionDental9_preview($d1,$d2,$t) {
        $names="รายงานเด็ก ป.1-6 (อายุ 6-12 ปี) ได้รับบริการทันตกรรม(kpi 2.3)";  
        $date1=$d1;$date2=$d2;$type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];    
        switch ($type_c) {
               case 1:
                      $sql1="select  concat(p.pname,p.fname,' ',p.lname) pname,d.hn,v.age_y,d.vstdate,
                               group_concat(d1.icd10tm_operation_code) icd10tm,group_concat(d1.`name`) dname,ps.house_regist_type_id,
                               vh.school_name,vc.village_school_class_name
                               from dtmain d left outer join dttm d1 on d.tmcode=d1.`code` left outer join vn_stat v on d.vn=v.vn
                               left outer join patient p on d.hn=p.hn left outer join person ps on p.hn=ps.patient_hn
                               left outer join village_student vs on ps.person_id=vs.person_id
                               left outer join village_school vh on vs.village_school_id=vh.village_school_id
                               left outer join village_school_class vc on vs.village_school_class_id=vc.village_school_class_id
                               where d1.icd10tm_operation_code in ('2330010','2330011','2338610') 
                               and d.vstdate between  '{$date1}' and '{$date2}' and v.age_y between '6' and '12'  group by d.hn;";                                                         
               break;
               case 2:
                      $sql1="select  concat(p.pname,p.fname,' ',p.lname) pname,d.hn,v.age_y,d.vstdate,
                                group_concat(d1.icd10tm_operation_code) icd10tm,group_concat(d1.`name`) dname,vh.school_name,
                                village_school_class_name,p.house_regist_type_id
                                from dtmain d inner join dttm d1 on d.tmcode=d1.`code` inner join vn_stat v on d.vn=v.vn
                                inner join person p on p.patient_hn=d.hn inner join village_student vs on p.person_id=vs.person_id
                                inner join village_school vh on vs.village_school_id=vh.village_school_id
                                inner join village_school_class vsc on vs.village_school_class_id=vsc.village_school_class_id
                                where d1.icd10tm_operation_code in ('2330010','2330011','2338610') and d.vstdate between '{$date1}' and '{$date2}' 
                                and vsc.village_school_class_id between '4' and '9' and (vs.discharge = '' or vs.discharge is null or vs.discharge='N')
                                and p.death <> 'Y' and p.person_discharge_id='9'  group by d.hn;";
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
        return $this -> render('/site/dental/dental9-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type_n'=>$type_n]);           
    }
        public function actionDental10Index(){
        $model = new Formmodel();             
        $names="ร้อยละเด็กนักเรียน ป.1 และ ป.6 ที่ได้รับบริการทันตกรรม(kpi 2.4)";                     
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental10_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental10-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    }     
    public function actionDental10_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select  concat(p.pname,p.fname,' ',p.lname) pname,d.hn,v.age_y,d.vstdate,
                  group_concat(d1.icd10tm_operation_code) icd10tm,group_concat(d1.`name`) dname,vh.school_name,
                  village_school_class_name,p.house_regist_type_id
                  from dtmain d inner join dttm d1 on d.tmcode=d1.`code` inner join vn_stat v on d.vn=v.vn
                  inner join person p on p.patient_hn=d.hn inner join village_student vs on p.person_id=vs.person_id
                  inner join village_school vh on vs.village_school_id=vh.village_school_id
                  inner join village_school_class vsc on vs.village_school_class_id=vsc.village_school_class_id
                 where d1.icd10tm_operation_code in ('2330010','2330011','2338610') and d.vstdate between '{$date1}' and '{$date2}' 
                  and vsc.village_school_class_id in('4','9') and (vs.discharge = '' or vs.discharge is null or vs.discharge='N')
                  and p.death <> 'Y' and p.person_discharge_id='9'  group by d.hn;";        
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
        return $this -> render('/site/dental/dental10-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);                   
    }    
        public function actionDental11Index(){
        $model = new Formmodel();             
        $names="ประชาชนได้รับบริการทางทันตกรรม(คน)ไม่น้อยกว่าร้อยละ 20(kpi 3.1)";                       
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental11_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental11-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    } 

    public function actionDental11_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;        
        $date1=$d1;$date2=$d2;$type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];    
        switch ($type_c) {
        case 1:   
        $sql1="select 
	        d.hn,p.pname,d.vstdate,ps.house_regist_type_id ,v.village_moo,v.village_name, d.`name` dname
	   from (
 	       select
	                p.hn,concat(p.pname,p.fname,' ',p.lname) pname
 	            from  patient p
	   ) as p
                inner join (
                            select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from (
                                  select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d 
                                         where d.icd10tm_operation_code in ('2330011','2330010')
                             ) as d 
                      inner join (
	              select  hn,vn,vstdate,tmcode from dtmain dt where dt.vstdate between  '{$date1}' and '{$date2}' 
	         ) as dt on dt.tmcode = d.`code` group by dt.hn
                ) as d on d.hn = p.hn 
                left outer join person ps on ps.patient_hn=p.hn
                left outer join village v on ps.village_id = v.village_id
                group by p.hn  order by ps.house_regist_type_id ;";
        break;
        case 2:
        $sql1="select 
	        p.cid,p.patient_hn hn,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.birthdate,p.house_regist_type_id,p.death,
                      p.person_discharge_id,p.village_moo,p.village_name,d.vstdate,d.icd10tm_operation_code,d.`name` dname
	   from (
 	       select
	           p.cid,p.patient_hn,p.person_id,p.pname,p.fname,p.lname,p.sex,p.birthdate,p.house_regist_type_id,
	           p.death,p.person_discharge_id,v.village_moo,v.village_name
 	       from person p 
	           left outer join village v on p.village_id = v.village_id
	                where p.house_regist_type_id in('1','3')  and p.person_discharge_id='9' and p.death <> 'Y' and v.village_moo <> 0
	                group by p.cid
	   ) as p
                left outer join (
	         select dt.hn,count(DISTINCT dt.vn) as count_vn,dt.vstdate,d.name,d.icd10tm_operation_code from (
	               select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d where d.icd10tm_operation_code
                              in ('2330011','2330010')
	          ) as d 
                         inner join (
	              select  hn,vn,vstdate,tmcode from dtmain dt where dt.vstdate between  '{$date1}' and '{$date2}' 
	         ) as dt ON dt.tmcode = d.`code` group by dt.hn
	) as d on d.hn = p.patient_hn 
               where if(d.icd10tm_operation_code is not null or d.icd10tm_operation_code <>'' ,'T','F') ='T'  order by p.patient_hn;";
        break;
        default :
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
        return $this -> render('/site/dental/dental11-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type'=>$type_n]);          
    }
        public function actionDental12Index(){
        $model = new Formmodel();             
        $names="ประชาชนได้รับบริการทางทันตกรรม(ครั้ง)ไม่น้อยกว่าร้อยละ 20(kpi 3.2)";                   
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental12_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental12-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    } 
    public function actionDental12_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;  
        $date1=$d1;$date2=$d2;$type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];            
        switch ($type_c) {
        case 1:   
        $sql1="select 
	        p.vn,d.hn,p.pname,d.vstdate,ps.house_regist_type_id ,v.village_moo,v.village_name, d.`name` dname
	   from (
 	       select
	       	                v.vn,p.hn,concat(p.pname,p.fname,' ',p.lname) pname
 	            from  patient p inner join vn_stat v on v.hn=p.hn
	   ) as p
                inner join (
                            select dt.vn,dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from (
                                  select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d 
                                         where d.icd10tm_operation_code in ('2330011','2330010')
                             ) as d 
                      inner join (
                                 select  hn,vn,vstdate,tmcode from dtmain dt where dt.vstdate between  '{$date1}' and '{$date2}' 
                            ) as dt on dt.tmcode = d.`code` group by dt.vn
                   ) as d on d.vn = p.vn 
                left outer join person ps on ps.patient_hn=p.hn
                left outer join village v on ps.village_id = v.village_id
                order by ps.house_regist_type_id ;";
        break;
        case 2:        
        $sql1="SELECT 
	        p.cid,p.patient_hn hn,concat(p.pname,p.fname,' ',p.lname) pname,p.sex,p.birthdate,p.house_regist_type_id,p.death,
                      p.person_discharge_id,p.village_moo,p.village_name,d.vstdate,d.icd10tm_operation_code,d.`name` dname,d.count_vn
	  FROM (
 	  SELECT 
	        p.cid,p.patient_hn,p.person_id,p.pname,p.fname,p.lname,p.sex,p.birthdate,p.house_regist_type_id,
	        p.death,p.person_discharge_id,v.village_moo,v.village_name
 	  FROM person p 
	  LEFT OUTER JOIN village v on p.village_id = v.village_id
	 WHERE p.house_regist_type_id IN('1','3')  AND p.person_discharge_id='9' AND p.death <> 'Y' AND v.village_moo <> 0
	 GROUP BY cid
	 ) as p LEFT OUTER JOIN (
	 SELECT dt.hn,count(dt.vn) as count_vn,dt.vstdate,d.name,d.icd10tm_operation_code FROM (
	SELECT d.`name`,d.icd10tm_operation_code,d.`code` FROM dttm d WHERE d.icd10tm_operation_code IN('2330011','2330010')
	) as d INNER JOIN (
	SELECT hn,vn,vstdate,tmcode FROM dtmain dt WHERE dt.vstdate BETWEEN '{$date1}' AND '{$date2}'
	) as dt ON dt.tmcode = d.`code` GROUP BY dt.vn
	) as d ON d.hn = p.patient_hn where if(d.icd10tm_operation_code IS NOT NULL OR d.icd10tm_operation_code <>'' ,'T','F') ='T'
	ORDER BY p.patient_hn;";
        break;
        default :
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
        return $this -> render('/site/dental/dental12-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type'=>$type_n]);          
    }  
        public function actionDental13Index(){
        $model = new Formmodel();             
        $names="ผู้สูงอายุได้รับการตรวจคัดกรองสุขภาพช่องปากไม่น้อยกว่าร้อยละ 50(kpi 4.1)";                     
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental13_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental13-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    } 


    public function actionDental13_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $date1=$d1;$date2=$d2;$type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];          
        switch ($type_c) {
        case 1: 
        $sql1="select  
                      p.hn,p.pname,ps.house_regist_type_id,v.village_moo,v.village_name,d.vstdate,d.`name` dname
		from (
		       select  
                      p.hn,concat(p.pname,p.fname,' ',p.lname) pname
	                    from patient p inner join vn_stat v on p.hn=v.hn where v.age_y>=60
               ) as p
                      inner join (
		 select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code from (
	                       select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d 
                                      where d.icd10tm_operation_code in ('2330011')
                              ) as d 
                     inner join (
		select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}'
	        ) as dt on dt.tmcode = d.`code` group by dt.hn
               ) as d on d.hn = p.hn 
               left outer join person ps on ps.patient_hn=p.hn
               left outer join village v on ps.village_id = v.village_id
               group by p.hn order by ps.house_regist_type_id    ;";    
        break;    
        case 2:
        $sql1="SELECT 
		p.cid,p.patient_hn hn,concat(p.pname,p.fname,' ',p.lname) pname,
		p.sex,p.birthdate,p.house_regist_type_id,p.death,
		p.person_discharge_id,p.village_moo,p.village_name,
		d.vstdate,d.icd10tm_operation_code,d.`name` dname
		FROM (
		       SELECT 
			p.cid,p.patient_hn,p.person_id,p.pname,p.fname,p.lname,p.sex,p.birthdate,
			p.house_regist_type_id,p.death,p.person_discharge_id,	v.village_moo,v.village_name
			FROM person p LEFT OUTER JOIN village v on p.village_id = v.village_id
			WHERE  CONCAT( 
                                                   LPAD(timestampdiff(year,p.birthdate,'2014-10-01'),2,'0'),
			        LPAD(timestampdiff(month,p.birthdate,'2014-10-01')-(timestampdiff(year,p.birthdate,'2014-10-01')*12),2,'0'),
                                                   LPAD(timestampdiff(day,date_add(p.birthdate,interval (timestampdiff(month,p.birthdate,'2014-10-01')) 
                                                          month),'2014-10-01'),2,'0')
			) >= '600000' 
			AND p.house_regist_type_id IN('1','3') AND p.person_discharge_id='9' AND p.death <> 'Y' 
			AND v.village_moo <> 0 GROUP BY cid) as p
                             LEFT OUTER JOIN (
		       SELECT dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code FROM (
			SELECT d.`name`,d.icd10tm_operation_code,d.`code` FROM dttm d 
                                           WHERE d.icd10tm_operation_code IN('2330011')) as d 
                                    INNER JOIN (
			SELECT hn,vstdate,tmcode FROM dtmain dt WHERE dt.vstdate BETWEEN '{$date1}' AND '{$date2}'
			) as dt ON dt.tmcode = d.`code` GROUP BY dt.hn) as d 
                             ON d.hn = p.patient_hn 
                             where if(d.icd10tm_operation_code IS NOT NULL OR d.icd10tm_operation_code <>'' ,'T','F') = 'T' GROUP BY p.cid;";
        break;
        default :
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
        return $this -> render('/site/dental/dental13-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type'=>$type_n]);          
    }
        public function actionDental14Index(){
        $model = new Formmodel();             
        $names="ผู้สูงอายุที่มีสภาวะการเกิดโรคเบาหวานและความดันได้รับการคัดกรองสุขภาพช่องปาก ไม่น้อยกว่าร้อยละ 50(kpi 4.2)";                    
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');            
            return $this->redirect(['dental14_preview','name'=>$names,'d1' => $date1,'d2' => $date2,'t' => $type]); 
        }         
        return $this->render('/site/dental/dental14-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    } 
    public function actionDental14_preview($name,$d1,$d2,$t) {
        $names=$name;  
        $date1=$d1;$date2=$d2;$type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];            
        switch ($type_c) {
             case 1:
                      $sql1="select  
                                   d.hn,p.pname,p.age_y,d.vstdate,c.`name` clinicname,ps.house_regist_type_id,v.village_moo,
                                   v.village_name,d.`name` dname 
                                from (
                                    select v.hn,v.vn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_y,v.vstdate from vn_stat v 
                                    inner join patient p on p.hn=v.hn where v.age_y >= 60
                                ) as p 
                                inner join clinicmember cm on cm.hn=p.hn and cm.clinic in ('001','002')
                                left outer join clinic c on cm.clinic=c.clinic 
		   inner join (
		       select dt.vn,dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code 
                                       from (
			 select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d 
                                             where d.icd10tm_operation_code in('2330011')
		   ) as d 
                                inner join (
		        select vn,hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}'
		       ) as dt on dt.tmcode = d.`code` group by dt.hn
		   ) as d on d.vn=p.vn
                               left outer join person ps on p.hn=ps.patient_hn
                               left outer join village v on ps.village_id = v.village_id
                               order by ps.house_regist_type_id desc;";
             break;
             case 2:
                      $sql1="select
		        p.patient_hn hn,concat(p.pname,p.fname,' ',p.lname) pname,p.birthdate,
                                     LPAD(timestampdiff(year,p.birthdate,'2014-10-01'),2,'0') age_y,p.house_regist_type_id,p.village_moo,
                                     p.village_name,	c.name as clinicname,d.vstdate,d.`name` dname
		        from (
		          select	 
			p.cid,p.patient_hn,p.person_id,p.pname,p.fname,p.lname,p.sex,p.birthdate,p.house_regist_type_id,p.death,
			p.person_discharge_id,v.village_moo,v.village_name
		          from person p left outer join village v on p.village_id = v.village_id
			where  concat(
			   LPAD(timestampdiff(year,p.birthdate,'{$date1}'),2,'0'),
			   LPAD(timestampdiff(month,p.birthdate,'{$date1}')-(timestampdiff(year,p.birthdate,'{$date1}')*12),2,'0'),
			   LPAD(timestampdiff(day,date_add(p.birthdate,interval (timestampdiff(month,p.birthdate,'{$date1}')) 
                                                   month),'{$date1}'),2,'0')
			) >= '600000' 
			and p.house_regist_type_id in('1','3') and p.person_discharge_id='9' and p.death <> 'Y' 
			and v.village_moo <> 0 group by p.cid 
                                     ) as p 
			inner join clinicmember cm on cm.hn  = p.patient_hn and cm.clinic IN('001','002')
			left outer join clinic c on c.clinic = cm.clinic
			left outer join (
			  select dt.hn,dt.vstdate,d.name,d.icd10tm_operation_code 
                                                from (
			       select d.`name`,d.icd10tm_operation_code,d.`code` from dttm d 
                                                   where d.icd10tm_operation_code in('2330011')
		              ) as d 
                                           inner join (
			   select hn,vstdate,tmcode from dtmain dt where dt.vstdate between '{$date1}' and '{$date2}'
			    ) as dt on dt.tmcode = d.`code` group by dt.hn
		       ) as d   on d.hn = p.patient_hn 
                                     where if(d.icd10tm_operation_code is not null or d.icd10tm_operation_code <>'' ,'T','F') ='T'	group by p.cid;";
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
        return $this -> render('/site/dental/dental14-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type'=>$type_n]);            
    }
        public function actionDental15Index(){
        $model = new Formmodel();             
        $names="รายงานบริการทันตกรรม แยกตามกลุ่มกิจกรรมบริการ";                    
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;      
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=dental/";   
                return $this->redirect($url.'dental15.mrt&d1='.$date1.'&d2='.$date2);  
        }         
        return $this->render('/site/dental/dental15-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    } 
        public function actionDental16Index(){
        $model = new Formmodel();             
        $names="รายงานมะเร็งช่องปาก แยก(ทั้งหมด/ในอำเภอ)";                    
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');          
               if($type==1){
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=dental/";   
                return $this->redirect($url.'dental16a.mrt&d1='.$date1.'&d2='.$date2);                     
               }else{
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=dental/";   
                return $this->redirect($url.'dental16b.mrt&d1='.$date1.'&d2='.$date2);                     
               }
        }         
        return $this->render('/site/dental/dental16-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    } 
        public function actionDental17Index(){
        $model = new Formmodel();             
        $names="รายงานภาระงาน (FTE) สำหรับทันตแพทย์";                    
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;      
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=dental/";   
                return $this->redirect($url.'dental17.mrt&d1='.$date1.'&d2='.$date2);  
        }         
        return $this->render('/site/dental/dental17-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);                
    } 
    
}    
