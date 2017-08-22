<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class BasicGenController extends Controller
{
    public $mText = "ข้อมูลพื้นฐาน & ข้อมูลทั่วไป";
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
    public function actionBasicGen1() {
        $names="รายงานประชากรในเขตรับผิดชอบ(บัญชี 1)"; 
        $sql="select count(*) as cc,count(if(sex='1',1,null)) as man,count(if(sex='2',1,null)) as fman
                 from person where house_regist_type_id in ('1','3') and village_id !=9 and death !='Y';";    
        $rawD = \Yii::$app->db1->createCommand($sql)->queryAll();
        foreach ($rawD as $value) {
            $total=  number_format($value['cc']);
            $man=  number_format($value['man']);
            $fman=  number_format($value['fman']);
        }
        $sql1="select v.village_id,v.village_moo,v.village_name pname,p.totalm,p.totalf,p.total from village v inner join (select p1.village_id,
                    count(if(p1.sex='1',1,null)) as totalm,count(if(p1.sex='2',1,null)) as totalf,count(*) as total  
                    from person p1 where p1.house_regist_type_id in ('1','3') and p1.village_id !=9 and p1.death !='Y' 
                    group by p1.village_id) p on v.village_id=p.village_id;";
        try {
            $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }  
        $main_data=[];
        foreach ($rawData as $data1) {
               $main_data[]=[
                         'name' => $data1['pname'],
                         'y' => $data1['total'] * 1,
                         'drilldown' => $data1['village_id']
               ];
        }
        $main=  json_encode($main_data);
        $sql2="select v.village_id,v.village_moo,v.village_name pname,p.totalm,p.totalf,p.total from village v inner join (select p1.village_id,
                    count(if(p1.sex='1',1,null)) as totalm,count(if(p1.sex='2',1,null)) as totalf,count(*) as total  
                    from person p1 where p1.house_regist_type_id in ('1','3') and p1.village_id !=9 and p1.death !='Y' 
                    group by p1.village_id) p on v.village_id=p.village_id;";
        try {
            $rawData1 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }        
        $sub_data=[];
        foreach ($rawData1 as $data2) {
            $sub_data[]=[
                 'id' => $data2['village_id'],
                 'name' => $data2['pname'],
                 'data' => [['ชาย', $data2['totalm'] * 1], ['หญิง', $data2['totalf'] * 1]]               
            ];
        }
        $sub=json_encode($sub_data);
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 2,
                ],
        ]);  
        return $this -> render('/site/basic-gen/basic-gen-1',['dataProvider' => $dataProvider,'names' => $names,'mText' => $this->mText,
                             'main'=>$main,'sub'=>$sub,'total'=> $total,'man'=>$man,'fman'=>$fman]);  
    } 
    public function actionBasicGen2() {
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
               return $this->redirect(['basic-gen2_preview', 'name' =>$names, 'c' =>$check, 'a1' =>$age1, 'a2' =>$age2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-2',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }    
    public function actionBasicGen2_preview($name,$c,$a1,$a2) {
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
                'pageSize' => 10,
                ],
        ]);  
        return $this -> render('/site/basic-gen/basic-gen-2-preview',['dataProvider' => $dataProvider, 'names' => $names, 
                                       'mText' => $this->mText, 'text' => $text]);            
    }
    public function actionBasicGen3() {
        $names="ข้อมูลการเกิด(การคลอด) ในเขตรับผิดชอบ(5 ปีย้อนหลัง)";
        $sql1="select year,total,totalm,totalf 
                      from (select if(MONTH(i3.dchdate)>=10,YEAR(i3.dchdate)+1 ,YEAR(i3.dchdate))+543 as year,
	               count(*) as total,
                             count(if(i4.sex='1',1,null)) as totalm,
                             count(if(i4.sex='2',1,null)) as totalf
                  from ipt i3,ipt_pregnancy i1,ipt_labour i2,ipt_labour_infant i4,person p where i1.an = i3.an and i1.an = i2.an and i2.an = i3.an 
                  and i2.ipt_labour_id=i4.ipt_labour_id and i3.hn=p.patient_hn and i1.deliver_type in (1,2)
                  and (if(month(i3.dchdate)>=10,year(i3.dchdate)+1 ,year(i3.dchdate)) between year(curdate())-4 and year(curdate())) 
                  and p.house_regist_type_id in ('1','3') and p.village_id !='9'  group by year order by year ) lb ;";
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
        $year=[];
        $man=[];
        $fman=[];
        $total=[];
        foreach ($rawData as $value) {
            array_push($year, (int)$value['year']);
            array_push($man, (int)$value['totalm']);
            array_push($fman, (int)$value['totalf']);       
            array_push($total, (int)$value['total']);              
        }
       return $this -> render('/site/basic-gen/basic-gen-3',['mText'=>$this->mText,'names'=>$names,'dataProvider' => $dataProvider,
                           'year'=>$year,'man'=>$man,'fman'=>$fman,'total'=>$total]);             
    }
    
    public function actionBasicGen4() {
        $model = new Formmodel();        
        $names="รายงานข้อมูลหญิงตั้งครรภ์คลอด";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person5.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-4',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);        
    }
    public function actionBasicGen5() {
        $model = new Formmodel();
        $names="รายงานสถิติจำนวนผู้ป่วยนอก(ยกเว้น งานส่งเสริมสุขภาพ)ต่อวัน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               return $this->redirect(['basic-gen5_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-5',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }     
    public function actionBasicGen5_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select  count(*) total,DATEDIFF('{$date2}','{$date1}')+1 days,(count(*)/(DATEDIFF('{$date2}','{$date1}')+1)) rate
                  from ovst  
                  where vstdate  between '{$date1}' and '{$date2}' and 
                  (spclty between '01' and '11' or spclty in ('16','17') or spclty between '25' and '29');";
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
        return $this->render('/site/basic-gen/basic-gen-5-preview',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$rawData, 'date1' =>$date1,'date2' =>$date2]);                         
    }
    public function actionBasicGen6() {
        $model = new Formmodel();
        $names="รายงานสาเหตุการตายสูงสุด(แยก ทั้งหมด/รายโรค)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');  
               return $this->redirect(['basic-gen6_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2,'t'=>$type]);
        }
            return $this -> render('/site/basic-gen/basic-gen-6',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }      
    public function actionBasicGen6_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;   
        $type=  explode(',', $t);$type_c=$type[0];$type_n=$type[1];
        $rawData=[];        
        switch ($type_c) {
               case 1:
                   $sql1="select  death_cause,death_cause_text,count(*) dtotal, count(if(death_place=1, 1, null)) as in_hos, 
                             count(if(death_place=2, 1, null)) as out_hos from death 
                             where death_date between '{$date1}' and '{$date2}'  and (death_cause is not null and death_cause != '')
                             group by death_cause order by dtotal desc;";
                   $result=\Yii::$app->db1->createCommand($sql1)->queryAll(); 
                   foreach ($result as $value1) {
                       $rawData[]=[
                             'death_cause_text' => $value1['death_cause_text'],
                             'dtotal' => $value1['dtotal'],
                             'in_hos' => $value1['in_hos'],
                             'out_hos' => $value1['out_hos'],                           
                       ];
                   }
               break;
               case 2:
                   $sql1="select pp.death_cause,pp.death_cause_text,pp.cc total,(select death_diag_1 from death 
                            where death_date between '{$date1}' and '{$date2}' 
                            and death_cause=pp.death_cause and (death_diag_1 not in ('P285','R092') and death_diag_1 not between 'I46' and 'I469') 
                            group by 1 order by count(*) desc limit 1 ) icd10,
                            (select count(*) aa from death where death_date  between '{$date1}' and '{$date2}' 
                            and death_cause=pp.death_cause and (death_diag_1 not in ('P285','R092') and death_diag_1 not between 'I46' and 'I469')  
                            group by death_diag_1 order by aa desc limit 1 ) dtotal
                            from (select  death_cause,death_cause_text,count(*) cc from death where death_date between '{$date1}' and '{$date2}'
                             group by death_cause order by cc desc ) pp   order by pp.cc desc;";
                   $result=\Yii::$app->db1->createCommand($sql1)->queryAll(); 
                   foreach ($result as $value1) {
                       $code=$value1['icd10'];
                       $sql2="select name from icd101 where code='{$code}';"; 
                       $result1=\Yii::$app->db1->createCommand($sql2)->queryAll(); 
                       foreach ($result1 as $value2) {
                             $inames=$value2['name'];
                       }
                       $rawData[]=[
                             'death_cause' =>$value1['death_cause'],
                             'death_cause_text' => $value1['death_cause_text'],
                             'total' => $value1['total'],
                             'icd10' => $value1['icd10'],
                             'inames' => $inames,
                             'dtotal' => $value1['dtotal'],
                             'date1'=>$date1,
                             'date2'=>$date2,              
                       ];
                   }
                            
               break;           
               default:
               break;
        }
        
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);     
        return $this->render('/site/basic-gen/basic-gen-6-preview',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'type'=>$type_c]);        
    }    
    public function actionBasicGen6_detail($id,$d1,$d2,$tx) {
               $sql1="select d.death_cause_text,d.death_diag_1 icd10,i.name diag,count(*) cc  
                         from death d inner join icd101 i on d.death_diag_1=i.code 
                         where d.death_date between '{$d1}' and '{$d2}' and d.death_cause='{$id}' 
                         and (death_diag_1 not in ('P285','R092') and death_diag_1 not between 'I46' and 'I469') 
                         group by d.death_diag_1 order by cc desc;";

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
        return $this->renderAjax('/site/basic-gen/basic-gen-6-detail',['dataProvider' => $dataProvider,'date1'=>$d1,'date2'=>$d2,'tx'=>$tx]);   
 
    }     
    public function actionBasicGen7() {
        $model = new Formmodel();
        $names="รายงานสถิติการส่งออก(refer-out)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type1 = Yii::$app->request->post('type1');   
               $type2 = Yii::$app->request->post('type2');   
               return $this->redirect(['basic-gen7_preview', 'name'=>$names, 'd1'=>$date1, 'd2'=>$date2, 't1'=>$type1, 't2'=>$type2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-7',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    } 
    public function actionBasicGen7_preview($name,$d1,$d2,$t1,$t2) {
        $names=$name;
        $date1=$d1;$date2=$d2;       
        $type1=  explode(',', $t1);$type1_c=$type1[0];$type1_n=$type1[1];
        $type2=  explode(',', $t2);$type2_c=$type2[0];$type2_n=$type2[1];     
        $type=$type1_c.$type2_c;
        switch ($type) {
             case 11:
             $sql1="select count(*) total,count(if(r.department='OPD',1,null)) ropd,count(if(r.department='IPD',1,null)) ripd from referout r
                       inner join hospcode h on r.refer_hospcode=h.hospcode where r.refer_date between '{$date1}' and '{$date2}'
                       and concat(h.chwpart,h.amppart) !='3104' ;";
                try {
                    $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
                }  
                return $this->render('/site/basic-gen/basic-gen-7-preview',['mText'=>$this->mText,'names'=>$names,
                     'dataProvider'=>$rawData, 'date1' =>$date1,'date2' =>$date2,'type'=>$type,'type1'=>$type1_n,'type2'=>$type2_n]);         
             break;
             case 12:
             $sql1="select count(*) total,count(if(r.department='OPD',1,null)) ropd,count(if(r.department='IPD',1,null)) ripd from referout r
                       inner join hospcode h on r.refer_hospcode=h.hospcode where r.refer_date between '{$date1}' and '{$date2}'
                       and concat(h.chwpart,h.amppart) !='3104' and r.with_ambulance='Y';";
                try {
                    $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
                }  
                 return $this->render('/site/basic-gen/basic-gen-7-preview',['mText'=>$this->mText,'names'=>$names,
                      'dataProvider'=>$rawData, 'date1' =>$date1,'date2' =>$date2,'type'=>$type,'type1'=>$type1_n,'type2'=>$type2_n]); 
             break;
             case 13:
             $sql1="select count(*) total,count(if(r.department='OPD',1,null)) ropd,count(if(r.department='IPD',1,null)) ripd from referout r
                       inner join hospcode h on r.refer_hospcode=h.hospcode where r.refer_date between '{$date1}' and '{$date2}' and
                       (r.with_ambulance is null or r.with_ambulance = '' or r.with_ambulance !='Y' or r.with_ambulance = 'N') 
                       and concat(h.chwpart,h.amppart) !='3104';";
                try {
                    $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
                }  
                 return $this->render('/site/basic-gen/basic-gen-7-preview',['mText'=>$this->mText,'names'=>$names,
                     'dataProvider'=>$rawData, 'date1' =>$date1,'date2' =>$date2,'type'=>$type,'type1'=>$type1_n,'type2'=>$type2_n]); 
             break;         
             case 21:
               $sql1="select s.`name` spclty,count(*) total,count(if(department='OPD',1,null)) ropd,count(if(department='IPD',1,null)) ripd  
                         from referout  r inner join spclty s on r.spclty=s.spclty  inner join hospcode h on r.refer_hospcode=h.hospcode
                         where r.refer_date between '{$date1}' and '{$date2}' and concat(h.chwpart,h.amppart) !='3104' 
                         group by r.spclty order by total desc;";  
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
                 return $this->render('/site/basic-gen/basic-gen-7-preview',['mText'=>$this->mText,'names'=>$names,
                     'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'type'=>$type,'type1'=>$type1_n,'type2'=>$type2_n]); 
             break; 
             case 22:
               $sql1="select s.`name` spclty,count(*) total,count(if(department='OPD',1,null)) ropd,count(if(department='IPD',1,null)) ripd  
                         from referout  r inner join spclty s on r.spclty=s.spclty inner join hospcode h on r.refer_hospcode=h.hospcode 
                         where r.refer_date between '{$date1}' and '{$date2}' and concat(h.chwpart,h.amppart) !='3104' 
                         and r.with_ambulance='Y' group by r.spclty order by total desc;";  
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
                 return $this->render('/site/basic-gen/basic-gen-7-preview',['mText'=>$this->mText,'names'=>$names,
                     'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'type'=>$type,'type1'=>$type1_n,'type2'=>$type2_n]); 

             break; 
             case 23:
               $sql1="select s.`name` spclty,count(*) total,count(if(department='OPD',1,null)) ropd,count(if(department='IPD',1,null)) ripd  
                         from referout  r inner join spclty s on r.spclty=s.spclty  inner join hospcode h on r.refer_hospcode=h.hospcode 
                         where r.refer_date between '{$date1}' and '{$date2}' and concat(h.chwpart,h.amppart) !='3104' 
                         and (r.with_ambulance is null or r.with_ambulance = '' or r.with_ambulance !='Y' or r.with_ambulance = 'N')
                         group by r.spclty order by total desc;";  
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
                 return $this->render('/site/basic-gen/basic-gen-7-preview',['mText'=>$this->mText,'names'=>$names,
                     'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'type'=>$type,'type1'=>$type1_n,'type2'=>$type2_n]); 

             break;   
             case 31:
               $sql1="select r.pdx icd10,i.name diag,count(*) total,count(if(r.department='OPD',1,null)) ropd, 
                         count(if(r.department='IPD',1,null)) ripd from referout r inner join icd101 i on r.pdx=i.code
                         inner join hospcode h on r.refer_hospcode=h.hospcode where r.refer_date between '{$date1}' and '{$date2}'
                         and concat(h.chwpart,h.amppart) !='3104' group by r.pdx order by total desc;"; 
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
                 return $this->render('/site/basic-gen/basic-gen-7-preview',['mText'=>$this->mText,'names'=>$names,
                     'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'type'=>$type,'type1'=>$type1_n,'type2'=>$type2_n]);                          
             break; 
             case 32:
               $sql1="select r.pdx icd10,i.name diag,count(*) total,count(if(r.department='OPD',1,null)) ropd, 
                         count(if(r.department='IPD',1,null)) ripd from referout r inner join icd101 i on r.pdx=i.code
                         inner join hospcode h on r.refer_hospcode=h.hospcode where r.refer_date between '{$date1}' and '{$date2}'
                         and concat(h.chwpart,h.amppart) !='3104' and r.with_ambulance='Y' group by r.pdx order by total desc;"; 
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
                 return $this->render('/site/basic-gen/basic-gen-7-preview',['mText'=>$this->mText,'names'=>$names,
                     'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'type'=>$type,'type1'=>$type1_n,'type2'=>$type2_n]); 
             break; 
             case 33:
               $sql1="select r.pdx icd10,i.name diag,count(*) total,count(if(r.department='OPD',1,null)) ropd, 
                         count(if(r.department='IPD',1,null)) ripd from referout r inner join icd101 i on r.pdx=i.code
                         inner join hospcode h on r.refer_hospcode=h.hospcode where r.refer_date between '{$date1}' and '{$date2}'
                         and concat(h.chwpart,h.amppart) !='3104'  
                         and (r.with_ambulance is null or r.with_ambulance = '' or r.with_ambulance !='Y' or r.with_ambulance = 'N')  
                         group by r.pdx order by total desc;"; 
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
                 return $this->render('/site/basic-gen/basic-gen-7-preview',['mText'=>$this->mText,'names'=>$names,
                     'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'type'=>$type,'type1'=>$type1_n,'type2'=>$type2_n]); 
             break;      
             default:
             break;
        }         
    }
    public function actionBasicGen8() {
        $model = new Formmodel();
        $names="รายงานสถิติการรับส่งต่อ(refer-in)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type1 = Yii::$app->request->post('type');   
               return $this->redirect(['basic-gen8_preview', 'name'=>$names, 'd1'=>$date1, 'd2'=>$date2, 't1'=>$type1]);
        }
            return $this -> render('/site/basic-gen/basic-gen-8',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    } 
    public function actionBasicGen8_preview($name,$d1,$d2,$t1) {
        $names=$name;
        $date1=$d1;$date2=$d2;       
        $type1=  explode(',', $t1);$type1_c=$type1[0];$type1_n=$type1[1];    
        switch ($type1_c) {
                case 1:
                    $sql1="select count(*) total,count(if(refer_point='OPD',1,null)) ropd,count(if(refer_point='ER',1,null)) repd,
                              count(if(refer_point='IPD',1,null)) ripd,count(if(refer_point='',1,null)) rnpd 
                              from referin where date_in  between '{$date1}' and '{$date2}' ;";
                try {
                    $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
                }               
                 return $this->render('/site/basic-gen/basic-gen-8-preview',['mText'=>$this->mText,'names'=>$names,
                                            'dataProvider'=>$rawData, 'date1' =>$date1,'date2' =>$date2,'type1'=>$type1_c,'type2'=>$type1_n]); 
                break;
                case 2:
                    $sql1="select s.name spclty,count(*) total,count(if(r.refer_point='OPD',1,null)) ropd,count(if(r.refer_point='ER',1,null)) repd,
                              count(if(r.refer_point='IPD',1,null)) ripd,count(if(r.refer_point='',1,null)) rnpd 
                              from referin r inner join vn_stat v on v.vn=r.vn inner join spclty s on v.spclty=s.spclty 
                              where r.date_in  between '{$date1}' and '{$date2}' group by v.spclty order by total desc;";
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
                 return $this->render('/site/basic-gen/basic-gen-8-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                            'date1' =>$date1,'date2' =>$date2,'type1'=>$type1_c,'type2'=>$type1_n]); 
                break;
                case 3:
                    $sql1="select v.pdx icd10,i.name diag,count(*) total,count(if(r.refer_point='OPD',1,null)) ropd,
                              count(if(r.refer_point='ER',1,null)) repd,count(if(r.refer_point='IPD',1,null)) ripd,count(if(r.refer_point='',1,null)) rnpd 
                              from referin r inner join vn_stat v on v.vn=r.vn inner join icd101 i on i.code=v.pdx 
                              where r.date_in  between '{$date1}' and '{$date2}'  group by v.pdx order by total desc;";
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
                 return $this->render('/site/basic-gen/basic-gen-8-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                            'date1' =>$date1,'date2' =>$date2,'type1'=>$type1_c,'type2'=>$type1_n]); 
                break;            
                default:
                break;
        }        
    }    
    public function actionBasicGen9() {
        $model = new Formmodel();
        $names="รายงาน 5 อันดับโรคการส่งต่อผู้ป่วยนอก(ยกเว้น งานส่งเสริมสุขภาพ)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               return $this->redirect(['basic-gen9_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-9',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }     
    public function actionBasicGen9_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;     
        $sql1="select r.pdx icd10,i.name diag,count(*) cc  from referout r inner join hospcode h on r.refer_hospcode=h.hospcode
                  inner join icd101 i on r.pdx=i.code inner join vn_stat v on r.vn=v.vn
                  where r.refer_date between '{$date1}' and '{$date2}' and concat(h.chwpart,h.amppart) !='3104'
                  and  (v.spclty between '01' and '11' or v.spclty in ('16','17') or v.spclty between '25' and '29') and r.department='OPD'  
                  and r.with_ambulance='Y' group by r.pdx order by cc desc limit 5;";
                try {
                    $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
                }    
        $main_data=[];
        foreach ($rawData as $data1) {
               $main_data[]=[
                         'name' => $data1['diag'],
                         'y' => $data1['cc'] * 1,
                        // 'drilldown' => $data1['village_id']
               ];
        }
        $main=  json_encode($main_data);                  
                $dataProvider = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData,
                     'pagination' => [
                        'pageSize' => 10,
                      ],
                ]);                  
                 return $this->render('/site/basic-gen/basic-gen-9-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                            'date1' =>$date1,'date2' =>$date2,'main'=>$main]);         
    }    
    public function actionBasicGen10() {
        $names="รายงานโรคที่พบบ่อยสุดผู้ป่วยนอก(ยกเว้น งานส่งเสริมสุขภาพ)"; 
        $model = new Formmodel();        
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type1 = Yii::$app->request->post('type1');         
               $s1=Yii::$app->request->post('s1'); 
               $s2=Yii::$app->request->post('s2');               
            return $this->redirect(['basic-gen10_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'t1'=>$type1,'s1'=>$s1,'s2'=>$s2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-10',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionBasicGen10_preview($name,$d1,$d2,$t1,$s1,$s2) {
        $names=$name;
        $date1=$d1;$date2=$d2;       
        $type1=  explode(',', $t1);$type1_c=$type1[0];$type1_n=$type1[1];    
        $se1=$s1;$se2=$s2;
        switch ($type1_c) {
               case 1:
                      if($se1==1){
                             $sql1 = "select i.code icd10,i.name diag,pp.man total from icd101 i inner join 
                            (select icd10,count(distinct(o.hn)) man,count(*) men from ovstdiag o inner join vn_stat v on v.vn=o.vn 
                            where v.vstdate between '{$date1}' and '{$date2}' and 
                             (v.spclty between '01' and '11' or v.spclty in ('16','17') or v.spclty between '25' and '29')
                            group by o.icd10 order by man desc) pp on i.code=pp.icd10  order by man desc limit 5;";   
                       $time='ตามคน';   
                        try {
                            $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                        } catch (\yii\db\Exception $e) {
                            throw new \yii\web\ConflictHttpException('sql error');
                        }         
                        $main_data=[];
                        foreach ($rawData as $data1) {
                               $main_data[]=[
                                         'name' => $data1['icd10'],
                                         'y' => $data1['total'] * 1,
                                        // 'drilldown' => $data1['village_id']
                               ];
                        }
                        $main=  json_encode($main_data);          
                        $dataProvider = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);   
                        return $this->render('/site/basic-gen/basic-gen-10-preview',['mText'=>$this->mText,'names'=>$names,'main'=>$main,
                                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'time'=>$time]);                            
                      }  else {
                          $sql1="select i.code icd10,i.name diag,pp.men total from icd101 i inner join 
                                    (select icd10,count(distinct(o.hn)) man,count(*) men from ovstdiag o inner join vn_stat v on v.vn=o.vn 
                                    where v.vstdate between '{$date1}' and '{$date2}' and 
                                    (v.spclty between '01' and '11' or v.spclty in ('16','17') or v.spclty between '25' and '29')    
                                    group by o.icd10 order by man desc) pp on i.code=pp.icd10  order by men desc limit 5;"; 
                        $time='ตามครั้ง';   
                      try {
                            $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
                        } catch (\yii\db\Exception $e) {
                            throw new \yii\web\ConflictHttpException('sql error');
                        }         
                        $main_data=[];
                        foreach ($rawData as $data1) {
                               $main_data[]=[
                                         'name' => $data1['icd10'],
                                         'y' => $data1['total'] * 1,
                                        // 'drilldown' => $data1['village_id']
                               ];
                        }
                        $main=  json_encode($main_data);          
                        $dataProvider = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);   
                        return $this->render('/site/basic-gen/basic-gen-10-preview',['mText'=>$this->mText,'names'=>$names,'main'=>$main,
                                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'time'=>$time]);                             
                      }

               break;
               case 2:
                      $rawData=[];
                      if($se1==1){
                             $time='ตามคน';   
                             $sql1="select pp.spclty,s.`name` sname,pp.man,pp.men
                                           from spclty s inner join (select o.spclty,count(distinct(hn)) man,count(*) men          
                                           from vn_stat o where vstdate between '{$date1}' and '{$date2}' and
                                            (o.spclty between '01' and '11' or o.spclty in ('16','17') or o.spclty between '25' and '29') 
                                            group by o.spclty  ) pp on s.spclty=pp.spclty order by pp.man desc;";
                             $result=Yii::$app->db1->createCommand($sql1)->queryAll();
                             foreach ($result as $value1) {
                                    $spclty=$value1['spclty'];
                                    $sql2="select o.pdx,i.name diag,count(distinct(hn)) man1
                                              from vn_stat o inner join icd101 i on o.pdx=i.code where o.vstdate between '{$date1}' and '{$date2}'
                                               and o.spclty='{$spclty}'  group by o.pdx order by man1 desc limit 1;";
                                    $result2=Yii::$app->db1->createCommand($sql2)->queryAll();           
                                    foreach ($result2 as $value2) {
                                            $icd10=$value2['pdx'];
                                            $diag=$value2['diag'];
                                            $man1=$value2['man1'];
                                    }    
                                    $rawData[]=[
                                            'spclty'=>$spclty,
                                            'sname'=>$value1['sname'],
                                            'man'=>$value1['man'],
                                            'icd10'=>$icd10,
                                            'diag'=>$diag,
                                            'man1'=> $man1,
                                            'date1'=>$date1,
                                            'date2'=>$date2,
                                            'type'=>$se1
                                    ];    
                             }
                        $dataProvider = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData,
                                                         'sort' => [
                                'attributes' => ['man1 DESC'],
                             ],                            
                            'pagination' => [
                                'pageSize' => 20,
                                ],
                        ]);   
                        return $this->render('/site/basic-gen/basic-gen-10a-preview',['mText'=>$this->mText,'names'=>$names,
                                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'time'=>$time]);                                
                      }else{
                             $time='ตามครั้ง';  
                             $sql1="select pp.spclty,s.`name` sname,pp.man,pp.men
                                           from spclty s inner join (select o.spclty,count(distinct(hn)) man,count(*) men          
                                           from vn_stat o where vstdate between '{$date1}' and '{$date2}' and
                                            (o.spclty between '01' and '11' or o.spclty in ('16','17') or o.spclty between '25' and '29') 
                                            group by o.spclty  ) pp on s.spclty=pp.spclty order by pp.men desc;";
                             $result=Yii::$app->db1->createCommand($sql1)->queryAll();
                             foreach ($result as $value1) {
                                    $spclty=$value1['spclty'];
                                    $sql2="select o.pdx,i.name diag,count(*) man1
                                              from vn_stat o inner join icd101 i on o.pdx=i.code where o.vstdate between '{$date1}' and '{$date2}'
                                               and o.spclty='{$spclty}'  group by o.pdx order by man1 desc limit 1;";
                                    if(!$result2=Yii::$app->db1->createCommand($sql2)->queryAll()){
                                                        $icd10='-';
                                                        $diag='-';
                                                        $man1='-';
                                    }else{          
                                                foreach ($result2 as $value2) {
                                                        $icd10=$value2['pdx'];
                                                        $diag=$value2['diag'];
                                                        $man1=$value2['man1'];
                                                } 
                                    }
                                    $rawData[]=[
                                            'spclty'=>$spclty,
                                            'sname'=>$value1['sname'],
                                            'man'=>$value1['men'],
                                            'icd10'=>$icd10,
                                            'diag'=>$diag,
                                            'man1'=> $man1,
                                            'date1'=>$date1,
                                            'date2'=>$date2,
                                            'type'=>$se1                                        
                                    ];    
                             }
                        $dataProvider = new \yii\data\ArrayDataProvider([
                             'allModels' => $rawData,
                                'sort' => [
                                'attributes' => ['man1 DESC'],
                             ],
                             'pagination' => [
                                'pageSize' => 20,
                             ],
                        ]);   
                      
                      
                       
                       return $this->render('/site/basic-gen/basic-gen-10a-preview',['mText'=>$this->mText,'names'=>$names,
                                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'time'=>$time]);              
                        
                      }
               break;
               default:
               break;
        }       
    }
    function actionBasicGen10_detail($id,$d1,$d2,$sname,$type) {
        if($type==1){
               $sql1="select v.pdx icd10,i.name diag ,count(distinct(v.hn)) cc  
                         from vn_stat v inner join icd101 i on v.pdx=i.code  where v.vstdate between '{$d1}' and '{$d2}' 
                         and v.spclty ='{$id}' group by v.pdx order by cc desc limit 10";              
        }  else {
               $sql1="select v.pdx icd10,i.name diag ,count(*) cc  
                         from vn_stat v inner join icd101 i on v.pdx=i.code  where v.vstdate between '{$d1}' and '{$d2}' 
                         and v.spclty ='{$id}' group by v.pdx order by cc desc limit 10";              
        }

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
        return $this->renderAjax('/site/basic-gen/basic-gen-10-detail',['dataProvider' => $dataProvider,'sname'=>$sname,'date1'=>$d1,'date2'=>$d2]);   
 
    }
    public function actionBasicGen11() {
        $model = new Formmodel();
        $names="รายงานสถิติผู้ป่วยใน 5 อันดับโรคแรก"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $type = Yii::$app->request->post('type');  
               return $this->redirect(['basic-gen11_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2,'t'=>$type]);
        }
            return $this -> render('/site/basic-gen/basic-gen-11',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }     
    public function actionBasicGen11_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $type=  explode(',', $t);$type_c=$type[0];$type_n=$type[1];
        switch ($type_c) {
               case 1:
               $sql1="select  v.pdx,i1.name diag,count(v.pdx) cc from ovst o inner join vn_stat v on o.vn=v.vn  inner join ipt i on o.an=i.an 
                         inner join icd101 i1 on v.pdx=i1.`code` where o.vstdate between '{$date1}' and '{$date2}' and o.an is not null 
                         group by v.pdx  order by cc desc limit 5;";

               break;
               case 2:
               $sql1="select a.pdx,i.name diag,count(a.pdx) cc from an_stat a inner join icd101 i on i.code=a.pdx
                         where a.dchdate between '{$date1}' and '{$date2}' and a.pdx not like 'Z%' group by a.pdx order by cc desc limit 10;";

               break;
               default:
               break;
       }
        try {
              $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }    
        $main_data=[];
        foreach ($rawData as $data1) {
               $main_data[]=[
                         'name' => $data1['diag'],
                         'y' => $data1['cc'] * 1,
                        // 'drilldown' => $data1['village_id']
               ];
        }
        $main=  json_encode($main_data);                  
                $dataProvider = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData,
                     'pagination' => [
                        'pageSize' => 10,
                      ],
                ]);                  
        return $this->render('/site/basic-gen/basic-gen-11-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                   'date1' =>$date1,'date2' =>$date2,'main'=>$main,'type'=>$type_n]);      
  }    
    public function actionBasicGen12() {
        $model = new Formmodel();
        $names="รายงานอัตราการครองเตียง"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $bed = Yii::$app->request->post('bed');     
               return $this->redirect(['basic-gen12_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2,'b'=>$bed]);
        }
            return $this -> render('/site/basic-gen/basic-gen-12',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }      
    public function actionBasicGen12_preview($name,$d1,$d2,$b) {
        $names=$name;
        $date1=$d1;$date2=$d2;  
        $bed=  explode(',', $b);$bed_c=$bed[0];$bed_n=$bed[1];
        $rawData=[];
        switch ($bed_c) {
                case 1:
                      $bedA='355';  
                      $sql1="select DATEDIFF('{$date2}','{$date1}')+1 as days,sum(admdate) day_slp from an_stat 
                                where dchdate between '{$date1}' and '{$date2}' ;";
                     $result=\Yii::$app->db1->createCommand($sql1)->queryAll();
                     foreach ($result as $value1) {
                             $day_slp = $value1['day_slp'];
                             $days = $value1['days'];
                     }
                     $bed_rate = ($day_slp*100)/($bedA*$days);
                     $rawData[]=[
                             'names' =>'อัตราการครองเตียง',
                             'days' =>$days,
                             'day_slp' =>$day_slp,
                             'bed_rate' =>$bed_rate
                     ];
                break;
                case 2:
                      $bedA='300';  
                      $sql1="select DATEDIFF('{$date2}','{$date1}')+1 as days,sum(admdate) day_slp from an_stat 
                                where dchdate between '{$date1}' and '{$date2}' ;";
                     $result=\Yii::$app->db1->createCommand($sql1)->queryAll();
                     foreach ($result as $value1) {
                             $day_slp = $value1['day_slp'];
                             $days = $value1['days'];
                     }
                     $bed_rate = ($day_slp*100)/($bedA*$days);
                     $rawData[]=[
                             'names' =>'อัตราการครองเตียง',
                             'days' =>$days,
                             'day_slp' =>$day_slp,
                             'bed_rate' =>$bed_rate
                     ];                   
                break;
                default:
                break;
        } 
        return $this->render('/site/basic-gen/basic-gen-12-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$rawData,
                                   'date1' =>$date1,'date2' =>$date2,'bed_n'=>$bed_n,'bed_c'=>$bedA]);                  
    }  
    public function actionBasicGen13() {
        $model = new Formmodel();
        $names="รายงานจำนวนวันนอนเฉลี่ยต่อคนต่อวัน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               return $this->redirect(['basic-gen13_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-13',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }    
    public function actionBasicGen13_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;      
        $sql1="select count(*) man,sum(admdate) days,(sum(admdate)/count(*)) rate from an_stat 
                  where dchdate  between '{$date1}' and '{$date2}'  ;";
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
        return $this->render('/site/basic-gen/basic-gen-13-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$rawData,
                                   'date1' =>$date1,'date2' =>$date2]);             
    }
    public function actionBasicGen14() {
        $model = new Formmodel();
        $names="รายงานค่าใช้จ่ายสูงสุดรายโรค(20 รายโรค) ผู้ป่วยใน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               return $this->redirect(['basic-gen14_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-14',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    } 
    public function actionBasicGen14_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;     
        $sql1="select a.pdx,i.name diag,count(pdx) num,sum(a.income) total,(sum(a.income)/count(pdx)) rate from an_stat a 
                  left outer join icd101 i on i.code=a.pdx where a.dchdate  between '{$date1}' and '{$date2}' 
                  group by a.pdx order by rate desc limit 20;";
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
        return $this->render('/site/basic-gen/basic-gen-14-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                   'date1' =>$date1,'date2' =>$date2]);                     
    }
    public function actionBasicGen15() {
        $model = new Formmodel();
        $names="รายงานค่าใช้จ่ายสูงสุด(20 รายหัตถการ) ผู้ป่วยใน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               return $this->redirect(['basic-gen15_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-15',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    } 
    public function actionBasicGen15_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;         
        $sql1="select n.name oper,count(*) num,sum(sum_price) price,(sum(sum_price)/count(*)) rate  from opitemrece o 
                  inner join nondrugitems n on o.icode=n.icode 
                  where o.vstdate between '{$date1}' and '{$date2}'  and o.sub_type='3' and o.an is not null 
                  group by o.icode order by rate desc limit 20;";
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
        return $this->render('/site/basic-gen/basic-gen-15-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                   'date1' =>$date1,'date2' =>$date2]);                    
    }
    public function actionBasicGen16() {
        $model = new Formmodel();
        $names="รายงานวันนอนสูงสุดรายโรค(20 รายโรค)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               return $this->redirect(['basic-gen16_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-16',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    } 
    public function actionBasicGen16_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;     
        $sql1="select a.pdx,i.name diag,count(*) num,sum(a.admdate) total,(sum(a.admdate)/count(*)) rate from an_stat a 
              inner join icd101 i on i.code=a.pdx where a.dchdate between '{$date1}' and '{$date2}'  group by a.pdx order by rate desc limit 20;";
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
        return $this->render('/site/basic-gen/basic-gen-16-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                   'date1' =>$date1,'date2' =>$date2]);              
    }
    public function actionBasicGen17() {
        $model = new Formmodel();
        $names = "รายงานสรุปรายงานผู้ป่วยใน (แยกตามตึกผู้ป่วย)";
        $sql="select  concat('00',',','ทั้งหมด') ward, 'ทั้งหมด' as name union select concat(ward,',',name) ward, name 
                from ward where ward not in ('01','02','09','10','11','14') order by ward;";
        $locations =  \Yii::$app->db1->createCommand($sql)->queryAll();    
        $listData=ArrayHelper::map($locations,'ward','name');       
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person17_1.mrt&d1='.$date1.'&d2='.$date2);                      

               //return $this->redirect(['basic-gen17_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'t'=>$type]);
        }
            return $this -> render('/site/basic-gen/basic-gen-17',['mText'=>$this->mText, 'names'=>$names,
                                          'model' => $model, 'data'=>$listData]);        
    }
    public function actionBasicGen17_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;   
        $type=  explode(',', $t);$ward_c=$type[0];$ward_n=$type[1];
        $rawData=[];
        switch ($ward_c) {
            case 00:
                $sqla1 = "select count(distinct an) total from an_stat where regdate < '{$date1}' and (dchdate >= '{$date1}' or dchdate IS NULL) 
	                and sex = '1'; ";  
                $sqla2 = "select count(distinct an) total from an_stat where regdate < '{$date1}' and (dchdate >= '{$date1}' or dchdate IS NULL) 
	                and sex = '2'; ";  
                $numa1=\Yii::$app->db1->createCommand($sqla1)->queryScalar();if(!$numa1){$num1=0;}else{$num1=$numa1;}
                $numa2=\Yii::$app->db1->createCommand($sqla2)->queryScalar();if(!$numa2){$num2=0;}else{$num2=$numa2;}     
                $rawData[]=array(
                      'id'=>'1',
                      'name'=>'ยอดยกมาจากเดือนที่แล้ว',
                      'man'=>$num1,
                      'female'=>$num2,
                      'unit'=>'คน'  
                );
	  $sql1 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.regdate between '{$date1}' and '{$date2}' 
	               and a.sex='1';";  
	  $sql2 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.regdate between '{$date1}' and '{$date2}' 
	               and a.sex='2';";            
                $numa3=\Yii::$app->db1->createCommand($sql1)->queryScalar();if(!$numa3){$num3=0;}else{$num3=$numa3;}
                $numa4=\Yii::$app->db1->createCommand($sql2)->queryScalar();if(!$numa4){$num4=0;}else{$num4=$numa4;}     
                $rawData[]=array(
                      'id'=>'2',
                      'name'=>'จำนวนผู้ป่วยรับใหม่ในเดือน',
                      'man'=>$num3,
                      'female'=>$num4,
                      'unit'=>'คน'  
                );
	  $sql3 = "select count(*) total from iptbedmove i left outer join an_stat a on i.an=a.an where 
                             i.movedate between '{$date1}' and '{$date2}' and a.sex='1';";    
	  $sql4 = "select count(*) total from iptbedmove i left outer join an_stat a on i.an=a.an where  
                             i.movedate between '{$date1}' and '{$date2}' and a.sex='2';";  
                $numa5=\Yii::$app->db1->createCommand($sql3)->queryScalar();if(!$numa5){$num5=0;}else{$num5=$numa5;}
                $numa6=\Yii::$app->db1->createCommand($sql4)->queryScalar();if(!$numa6){$num6=0;}else{$num6=$numa6;}     
                $rawData[]=array(
                      'id'=>'3',
                      'name'=>'จำนวนผู้ป่วยรับย้ายในเดือน',
                      'man'=>$num5,
                      'female'=>$num6,
                      'unit'=>'คน'  
                );
	  $sql5 = "select count(*) total from iptbedmove i left outer join an_stat a on i.an=a.an where
                             i.movedate between '{$date1}' and '{$date2}' and a.sex='1';";
	  $sql6 = "select count(*) total from iptbedmove i left outer join an_stat a on i.an=a.an where 
                             i.movedate between '{$date1}' and '{$date2}' and a.sex='2';";                                  
                $numa7=\Yii::$app->db1->createCommand($sql5)->queryScalar();if(!$numa7){$num7=0;}else{$num7=$numa7;}
                $numa8=\Yii::$app->db1->createCommand($sql6)->queryScalar();if(!$numa8){$num8=0;}else{$num8=$numa8;}     
                $rawData[]=array(
                      'id'=>'4',
                      'name'=>'จำนวนผู้ป่วยย้ายในเดือน',
                      'man'=>$num7,
                      'female'=>$num8,
                      'unit'=>'คน'  
                );                            
	  $sql7 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.dchdate between '{$date1}' AND '{$date2}' 
	               and a.sex='1';";
	  $sql8 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.dchdate between '{$date1}' AND '{$date2}' 
	               and a.sex='2';";                
                $numa9=\Yii::$app->db1->createCommand($sql7)->queryScalar();if(!$numa9){$num9=0;}else{$num9=$numa9;}
                $numa10=\Yii::$app->db1->createCommand($sql8)->queryScalar();if(!$numa10){$num10=0;}else{$num10=$numa10;}     
                $rawData[]=array(
                      'id'=>'5',
                      'name'=>'จำนวนผู้จำหน่ายทั้งหมดในเดือน',
                      'man'=>$num9,
                      'female'=>$num10,
                      'unit'=>'คน'  
                );                 
	$sql9 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.regdate <= '{$date2}' and (i.dchdate > '{$date2}' or i.dchdate IS NULL) 
                           and a.sex = '1'";       
	$sql10 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.regdate <= '{$date2}' and (i.dchdate > '{$date2}' or i.dchdate IS NULL) 
                           and a.sex = '2'";              
               $numa11=\Yii::$app->db1->createCommand($sql9)->queryScalar();if(!$numa11){$num11=0;}else{$num11=$numa11;}
               $numa12=\Yii::$app->db1->createCommand($sql10)->queryScalar();if(!$numa12){$num12=0;}else{$num12=$numa12;}     
               $rawData[]=array(
                      'id'=>'6',
                      'name'=>'จำนวนผู้ป่วยยกยอดเดือนถัดไป',
                      'man'=>$num11,
                      'female'=>$num12,
                      'unit'=>'คน'  
                ); 
	$sql11 = "select sum(a.admdate) total from an_stat a where a.dchdate between '{$date1}' and '{$date2}' ;";
               $numa13=\Yii::$app->db1->createCommand($sql11)->queryScalar();if(!$numa13){$num13=0;}else{$num13=$numa13;}        
               $rawData[]=array(
                      'id'=>'7',
                      'name'=>'จำนวนวันนอนของผู้ป่วยจำหน่ายทั้งหมดในเดือน',
                      'man'=>$num13,
                      'female'=>'',
                      'unit'=>'วัน'  
                );          
               $rawData[]=array(
                      'id'=>'8',
                      'name'=>'จำนวนผู้ป่วยติดเชื้อใหม่ระหว่างนอนโรงพยาบาล',
                      'man'=>'',
                      'female'=>'',
                      'unit'=>'คน'  
                );                     
	 $sql12 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.dchdate between '{$date1}' and '{$date2}' and 
	               i.dchtype in ('08','09') and a.age_y='0' and a.age_m='0' and a.age_d between '0' and '7'  ;";   
               $numa14=\Yii::$app->db1->createCommand($sql12)->queryScalar();if(!$numa14){$num14=0;}else{$num14=$numa14;}             
               $rawData[]=array(
                      'id'=>'9',
                      'name'=>'จำนวนเด็ก 0-7 วัน ตาย',
                      'man'=>$num14,
                      'female'=>'',
                      'unit'=>'คน'  
                );     
	 $sql13 = "select count(*) total from ipt where dchdate between '{$date1}' and '{$date2}' and dchtype='02' ;";   
               $numa15=\Yii::$app->db1->createCommand($sql13)->queryScalar();if(!$numa15){$num15=0;}else{$num15=$numa15;}             
               $rawData[]=array(
                      'id'=>'10',
                      'name'=>'จำนวนผู้ป่วยไม่สมัครใจอยู่',
                      'man'=>$num15,
                      'female'=>'',
                      'unit'=>'คน'  
                );            
	 $sql14 = "select count(*) total from ipt where dchdate between '{$date1}' and '{$date2}' and dchtype='03' ;";   
               $numa16=\Yii::$app->db1->createCommand($sql14)->queryScalar();if(!$numa16){$num16=0;}else{$num16=$numa16;}             
               $rawData[]=array(
                      'id'=>'11',
                      'name'=>'จำนวนผู้ป่วยหนีกลับบ้าน',
                      'man'=>$num16,
                      'female'=>'',
                      'unit'=>'คน'  
                );                
               $sql15 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn where d.death_date between '{$date1}' and '{$date2}' 
	              and i.dchtype in ('08','09') ;";
               $numa17=\Yii::$app->db1->createCommand($sql15)->queryScalar();if(!$numa17){$num17=0;}else{$num17=$numa17;}             
               $rawData[]=array(
                      'id'=>'12',
                      'name'=>'จำนวนผู้ป่วยเสียชีวิตทั้งหมดในเดือน',
                      'man'=>$num17,
                      'female'=>'',
                      'unit'=>'คน'  
                );                 
	 $sql16 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode='A2' and i.dchtype in ('08','09') ;";  
	 $sql17 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode='A7' and i.dchtype in ('08','09') ;";                        
	 $sql18 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode='UC' and i.dchtype in ('08','09') ;";     
	 $sql19 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode='A1' and i.dchtype in ('08','09') ;";                        
	 $sql20 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode not in ('A1','A2','A7','UC') and i.dchtype in ('08','09') ;";                        
               $numa18=\Yii::$app->db1->createCommand($sql16)->queryScalar();if(!$numa18){$num18=0;}else{$num18=$numa18;}   
               $numa19=\Yii::$app->db1->createCommand($sql17)->queryScalar();if(!$numa19){$num19=0;}else{$num19=$numa19;}                  
               $numa20=\Yii::$app->db1->createCommand($sql18)->queryScalar();if(!$numa20){$num20=0;}else{$num20=$numa20;}                                
               $numa21=\Yii::$app->db1->createCommand($sql19)->queryScalar();if(!$numa21){$num21=0;}else{$num21=$numa21;}     
               $numa22=\Yii::$app->db1->createCommand($sql20)->queryScalar();if(!$numa22){$num22=0;}else{$num22=$numa22;}  
               $rawData[]=array(
                      'id'=>'13',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- ข้าราชการ/รัฐวิสาหกิจ',
                      'man'=>$num18,
                      'female'=>'',
                      'unit'=>'คน'  
                );                  
               $rawData[]=array(
                      'id'=>'14',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- ประกันสังคม',
                      'man'=>$num19,
                      'female'=>'',
                      'unit'=>'คน'  
                );                  
               $rawData[]=array(
                      'id'=>'15',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- UC ในเครือข่าย',
                      'man'=>$num20,
                      'female'=>'',
                      'unit'=>'คน'  
                );        
               $rawData[]=array(
                      'id'=>'16',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- UC นอกเครือข่าย',
                      'man'=>$num21,
                      'female'=>'',
                      'unit'=>'คน'  
                );                  
               $rawData[]=array(
                      'id'=>'17',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- สิทธิอื่นๆ',
                      'man'=>$num22,
                      'female'=>'',
                      'unit'=>'คน'  
                );   
 	 $sqlday = "select datediff('{$date2}','{$date1}')+1 as cc";
	 $day=\Yii::$app->db1->createCommand($sqlday)->queryScalar();         
               $sqlbed = "select count(b.bedno) as cc from roomno r,bedno b where r.roomno = b.roomno  and substr(b.bedno,1,1) !='I';"; 
	 $bed=\Yii::$app->db1->createCommand($sqlbed)->queryScalar();              
               $disch=$num9+$num10;
               $admdate=$num13;
               $value1 = @number_format(($admdate*100)/($bed*$day),2);
               $rawData[]=array(
                      'id'=>'18',
                      'name'=>'อัตราการครองเตียงทั้งหมด(ไม่นรวม LR,Observe)',
                      'man'=>$value1,
                      'female'=>'',
                      'unit'=>''  
                );     
               $value2 = @number_format(($disch/$bed),2);
               $value3 = @number_format(($admdate/$disch),2);
               $rawData[]=array(
                      'id'=>'19',
                      'name'=>'อัตราการใช้เตียง',
                      'man'=>$value2,
                      'female'=>'',
                      'unit'=>''  
                ); 
               $rawData[]=array(
                      'id'=>'20',
                      'name'=>'วันนอนเฉลี่ย',
                      'man'=>$value3,
                      'female'=>'',
                      'unit'=>''  
                );                
               $dataProvider = new \yii\data\ArrayDataProvider([
                    'allModels' => $rawData,
                    'pagination' => [
                        'pageSize' => 30,
                    ],
                ]);
                break;
            default:
                $sqla1 = "select count(distinct an) total from an_stat where regdate < '{$date1}' and (dchdate >= '{$date1}' or dchdate IS NULL) 
	               and ward in ($ward_c) and sex = '1'; ";  
                $sqla2 = "select count(distinct an) total from an_stat where regdate < '{$date1}' and (dchdate >= '{$date1}' or dchdate IS NULL) 
	               and ward in ($ward_c) and sex = '2'; ";  
                $numa1=\Yii::$app->db1->createCommand($sqla1)->queryScalar();if(!$numa1){$num1=0;}else{$num1=$numa1;}
                $numa2=\Yii::$app->db1->createCommand($sqla2)->queryScalar();if(!$numa2){$num2=0;}else{$num2=$numa2;}     
                $rawData[]=array(
                      'id'=>'1',
                      'name'=>'ยอดยกมาจากเดือนที่แล้ว',
                      'man'=>$num1,
                      'female'=>$num2,
                      'unit'=>'คน'  
                );
	  $sql1 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.regdate between '{$date1}' and '{$date2}' 
	              and i.ward in ($ward_c) and a.sex='1';";  
	  $sql2 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.regdate between '{$date1}' and '{$date2}' 
	              and i.ward in ($ward_c) and a.sex='2';";            
                $numa3=\Yii::$app->db1->createCommand($sql1)->queryScalar();if(!$numa3){$num3=0;}else{$num3=$numa3;}
                $numa4=\Yii::$app->db1->createCommand($sql2)->queryScalar();if(!$numa4){$num4=0;}else{$num4=$numa4;}     
                $rawData[]=array(
                      'id'=>'2',
                      'name'=>'จำนวนผู้ป่วยรับใหม่ในเดือน',
                      'man'=>$num3,
                      'female'=>$num4,
                      'unit'=>'คน'  
                );
	  $sql3 = "select count(*) total from iptbedmove i left outer join an_stat a on i.an=a.an where i.nward in ($ward_c) and i.oward not in ($ward_c) 
                            and i.movedate between '{$date1}' and '{$date2}' and a.sex='1';";    
	  $sql4 = "select count(*) total from iptbedmove i left outer join an_stat a on i.an=a.an where i.nward in ($ward_c) and i.oward not in ($ward_c) 
                            and i.movedate between '{$date1}' and '{$date2}' and a.sex='2';";  
                $numa5=\Yii::$app->db1->createCommand($sql3)->queryScalar();if(!$numa5){$num5=0;}else{$num5=$numa5;}
                $numa6=\Yii::$app->db1->createCommand($sql4)->queryScalar();if(!$numa6){$num6=0;}else{$num6=$numa6;}     
                $rawData[]=array(
                      'id'=>'3',
                      'name'=>'จำนวนผู้ป่วยรับย้ายในเดือน',
                      'man'=>$num5,
                      'female'=>$num6,
                      'unit'=>'คน'  
                );
	  $sql5 = "select count(*) total from iptbedmove i left outer join an_stat a on i.an=a.an where i.oward IN ($ward_c) and i.nward not in ($ward_c) 
                            and i.movedate between '{$date1}' and '{$date2}' and a.sex='1';";
	  $sql6 = "select count(*) total from iptbedmove i left outer join an_stat a on i.an=a.an where i.oward IN ($ward_c) and i.nward not in ($ward_c) 
                            and i.movedate between '{$date1}' and '{$date2}' and a.sex='2';";                                  
                $numa7=\Yii::$app->db1->createCommand($sql5)->queryScalar();if(!$numa7){$num7=0;}else{$num7=$numa7;}
                $numa8=\Yii::$app->db1->createCommand($sql6)->queryScalar();if(!$numa8){$num8=0;}else{$num8=$numa8;}     
                $rawData[]=array(
                      'id'=>'4',
                      'name'=>'จำนวนผู้ป่วยย้ายในเดือน',
                      'man'=>$num7,
                      'female'=>$num8,
                      'unit'=>'คน'  
                );                            
	  $sql7 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.dchdate between '{$date1}' AND '{$date2}' 
	              and i.ward in ($ward_c) and a.sex='1';";
	  $sql8 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.dchdate between '{$date1}' AND '{$date2}' 
	              and i.ward in ($ward_c) and a.sex='2';";                
                $numa9=\Yii::$app->db1->createCommand($sql7)->queryScalar();if(!$numa9){$num9=0;}else{$num9=$numa9;}
                $numa10=\Yii::$app->db1->createCommand($sql8)->queryScalar();if(!$numa10){$num10=0;}else{$num10=$numa10;}     
                $rawData[]=array(
                      'id'=>'5',
                      'name'=>'จำนวนผู้จำหน่ายทั้งหมดในเดือน',
                      'man'=>$num9,
                      'female'=>$num10,
                      'unit'=>'คน'  
                );                 
	$sql9 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.regdate <= '{$date2}' and (i.dchdate > '{$date2}' or i.dchdate IS NULL) 
                          and i.ward in ($ward_c) and a.sex = '1'";       
	$sql10 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.regdate <= '{$date2}' and (i.dchdate > '{$date2}' or i.dchdate IS NULL) 
                          and i.ward in ($ward_c) and a.sex = '2'";              
               $numa11=\Yii::$app->db1->createCommand($sql9)->queryScalar();if(!$numa11){$num11=0;}else{$num11=$numa11;}
               $numa12=\Yii::$app->db1->createCommand($sql10)->queryScalar();if(!$numa12){$num12=0;}else{$num12=$numa12;}     
               $rawData[]=array(
                      'id'=>'6',
                      'name'=>'จำนวนผู้ป่วยยกยอดเดือนถัดไป',
                      'man'=>$num11,
                      'female'=>$num12,
                      'unit'=>'คน'  
                ); 
	$sql11 = "select sum(a.admdate) total from an_stat a where a.ward in ($ward_c) and a.dchdate between '{$date1}' and '{$date2}' ;";
               $numa13=\Yii::$app->db1->createCommand($sql11)->queryScalar();if(!$numa13){$num13=0;}else{$num13=$numa13;}        
               $rawData[]=array(
                      'id'=>'7',
                      'name'=>'จำนวนวันนอนของผู้ป่วยจำหน่ายทั้งหมดในเดือน',
                      'man'=>$num13,
                      'female'=>'',
                      'unit'=>'วัน'  
                );          
               $rawData[]=array(
                      'id'=>'8',
                      'name'=>'จำนวนผู้ป่วยติดเชื้อใหม่ระหว่างนอนโรงพยาบาล',
                      'man'=>'',
                      'female'=>'',
                      'unit'=>'คน'  
                );                     
	 $sql12 = "select count(*) total from ipt i left outer join an_stat a on i.an=a.an where i.dchdate between '{$date1}' and '{$date2}' and 
	               i.dchtype in ('08','09') and a.age_y='0' and a.age_m='0' and a.age_d between '0' and '7' and i.ward in ($ward_c) ;";   
               $numa14=\Yii::$app->db1->createCommand($sql12)->queryScalar();if(!$numa14){$num14=0;}else{$num14=$numa14;}             
               $rawData[]=array(
                      'id'=>'9',
                      'name'=>'จำนวนเด็ก 0-7 วัน ตาย',
                      'man'=>$num14,
                      'female'=>'',
                      'unit'=>'คน'  
                );     
	 $sql13 = "select count(*) total from ipt where dchdate between '{$date1}' and '{$date2}' and dchtype='02' and ward in ($ward_c);";   
               $numa15=\Yii::$app->db1->createCommand($sql13)->queryScalar();if(!$numa15){$num15=0;}else{$num15=$numa15;}             
               $rawData[]=array(
                      'id'=>'10',
                      'name'=>'จำนวนผู้ป่วยไม่สมัครใจอยู่',
                      'man'=>$num15,
                      'female'=>'',
                      'unit'=>'คน'  
                );            
	 $sql14 = "select count(*) total from ipt where dchdate between '{$date1}' and '{$date2}' and dchtype='03' and ward in ($ward_c);";   
               $numa16=\Yii::$app->db1->createCommand($sql14)->queryScalar();if(!$numa16){$num16=0;}else{$num16=$numa16;}             
               $rawData[]=array(
                      'id'=>'11',
                      'name'=>'จำนวนผู้ป่วยหนีกลับบ้าน',
                      'man'=>$num16,
                      'female'=>'',
                      'unit'=>'คน'  
                );                
               $sql15 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn where d.death_date between '{$date1}' and '{$date2}' 
	              and i.dchtype in ('08','09') and i.ward in ($ward_c);";
               $numa17=\Yii::$app->db1->createCommand($sql15)->queryScalar();if(!$numa17){$num17=0;}else{$num17=$numa17;}             
               $rawData[]=array(
                      'id'=>'12',
                      'name'=>'จำนวนผู้ป่วยเสียชีวิตทั้งหมดในเดือน',
                      'man'=>$num17,
                      'female'=>'',
                      'unit'=>'คน'  
                );                 
	 $sql16 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode='A2' and i.dchtype in ('08','09') and i.ward in ($ward_c);";  
	 $sql17 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode='A7' and i.dchtype in ('08','09') and i.ward in ($ward_c);";                        
	 $sql18 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode='UC' and i.dchtype in ('08','09') and i.ward in ($ward_c);";     
	 $sql19 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode='A1' and i.dchtype in ('08','09') and i.ward in ($ward_c);";                        
	 $sql20 = "select count(*) total from ipt i left outer join death d on i.hn=d.hn left outer join pttype p on i.pttype=p.pttype 
	               where d.death_date between '{$date1}' and '{$date2}' and p.pcode not in ('A1','A2','A7','UC') and i.dchtype in ('08','09') and i.ward in ($ward_c);";                        
               $numa18=\Yii::$app->db1->createCommand($sql16)->queryScalar();if(!$numa18){$num18=0;}else{$num18=$numa18;}   
               $numa19=\Yii::$app->db1->createCommand($sql17)->queryScalar();if(!$numa19){$num19=0;}else{$num19=$numa19;}                  
               $numa20=\Yii::$app->db1->createCommand($sql18)->queryScalar();if(!$numa20){$num20=0;}else{$num20=$numa20;}                                
               $numa21=\Yii::$app->db1->createCommand($sql19)->queryScalar();if(!$numa21){$num21=0;}else{$num21=$numa21;}     
               $numa22=\Yii::$app->db1->createCommand($sql20)->queryScalar();if(!$numa22){$num22=0;}else{$num22=$numa22;}  
               $rawData[]=array(
                      'id'=>'13',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- ข้าราชการ/รัฐวิสาหกิจ',
                      'man'=>$num18,
                      'female'=>'',
                      'unit'=>'คน'  
                );                  
               $rawData[]=array(
                      'id'=>'14',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- ประกันสังคม',
                      'man'=>$num19,
                      'female'=>'',
                      'unit'=>'คน'  
                );                  
               $rawData[]=array(
                      'id'=>'15',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- UC ในเครือข่าย',
                      'man'=>$num20,
                      'female'=>'',
                      'unit'=>'คน'  
                );        
               $rawData[]=array(
                      'id'=>'16',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- UC นอกเครือข่าย',
                      'man'=>$num21,
                      'female'=>'',
                      'unit'=>'คน'  
                );                  
               $rawData[]=array(
                      'id'=>'17',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;- สิทธิอื่นๆ',
                      'man'=>$num22,
                      'female'=>'',
                      'unit'=>'คน'  
                );   
 	 $sqlday = "select datediff('{$date2}','{$date1}')+1 as cc";
	 $day=\Yii::$app->db1->createCommand($sqlday)->queryScalar();         
               $sqlbed = "select count(b.bedno) as cc from roomno r,bedno b where r.roomno = b.roomno and r.ward in ($ward_c) and substr(b.bedno,1,1) !='I';"; 
	 $bed=\Yii::$app->db1->createCommand($sqlbed)->queryScalar();              
               $disch=$num9+$num10;
               $admdate=$num13;
               $value1 = @number_format(($admdate*100)/($bed*$day),2);
               $rawData[]=array(
                      'id'=>'18',
                      'name'=>'อัตราการครองเตียงทั้งหมด(ไม่นรวม LR,Observe)',
                      'man'=>$value1,
                      'female'=>'',
                      'unit'=>''  
                );     
               $value2 = @number_format(($disch/$bed),2);
               $value3 = @number_format(($admdate/$disch),2);
               $rawData[]=array(
                      'id'=>'19',
                      'name'=>'อัตราการใช้เตียง',
                      'man'=>$value2,
                      'female'=>'',
                      'unit'=>''  
                ); 
               $rawData[]=array(
                      'id'=>'20',
                      'name'=>'วันนอนเฉลี่ย',
                      'man'=>$value3,
                      'female'=>'',
                      'unit'=>''  
                ); 
               $dataProvider = new \yii\data\ArrayDataProvider([
                    'allModels' => $rawData,
                    'pagination' => [
                        'pageSize' => 30,
                    ],
                ]);               
            break;
        }
        
        return $this->render('/site/basic-gen/basic-gen-17-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                   'date1' =>$date1,'date2' =>$date2,'wname' => $ward_n]);              
    }
    public function actionBasicGen18() {
        $model = new Formmodel();
        $names="รายงานโรคที่พบบ่อยสุด - ผู้ป่วยใน (ทั้งหมด,แยกสาขา/แผนก)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               return $this->redirect(['basic-gen18_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-18',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    } 
    public function actionBasicGen18_preview($name,$d1,$d2) {
        $names="รายงานโรคที่พบบ่อยสุด";
        $date1=$d1;$date2=$d2;    
        $sql1="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                  where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' group by a.pdx order by total desc limit 10;";
        try {
              $rawData1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data1=[];
               foreach ($rawData1 as $data1) {
                      $main_data1[]=[
                             'name' => $data1['icd10'],
                             'y' => $data1['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main1=  json_encode($main_data1);          
                        $dataProvider1 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData1,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);    
        $sql2="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                  where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' and a.spclty='01'
                   group by a.pdx order by total desc limit 10;";
        try {
              $rawData2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data2=[];
               foreach ($rawData2 as $data2) {
                      $main_data2[]=[
                             'name' => $data2['icd10'],
                             'y' => $data2['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main2=  json_encode($main_data2);          
                        $dataProvider2 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData2,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);                          
        $sql3="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                  where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' and a.spclty='02'
                   group by a.pdx order by total desc limit 10;";
        try {
              $rawData3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data3=[];
               foreach ($rawData3 as $data3) {
                      $main_data3[]=[
                             'name' => $data3['icd10'],
                             'y' => $data3['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main3=  json_encode($main_data3);          
                        $dataProvider3 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData3,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);               
        $sql4="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                  where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' and a.spclty='03'
                   group by a.pdx order by total desc limit 10;";
        try {
              $rawData4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data4=[];
               foreach ($rawData4 as $data4) {
                      $main_data4[]=[
                             'name' => $data4['icd10'],
                             'y' => $data4['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main4=  json_encode($main_data4);          
                        $dataProvider4 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData4,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);
        $sql5="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                  where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' and a.spclty='04'
                   group by a.pdx order by total desc limit 10;";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data5=[];
               foreach ($rawData5 as $data5) {
                      $main_data5[]=[
                             'name' => $data5['icd10'],
                             'y' => $data5['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main5=  json_encode($main_data5);          
                        $dataProvider5 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData5,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);                        
        $sql6="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                  where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' and a.spclty='05' and a.ward !='12'
                   group by a.pdx order by total desc limit 10;";
        try {
              $rawData6 = \Yii::$app->db1->createCommand($sql6)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data6=[];
               foreach ($rawData6 as $data6) {
                      $main_data6[]=[
                             'name' => $data6['icd10'],
                             'y' => $data6['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main6=  json_encode($main_data6);          
                        $dataProvider6 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData6,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);                         
        $sql7="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                  where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' and a.spclty='06'
                   group by a.pdx order by total desc limit 10;";
        try {
              $rawData7 = \Yii::$app->db1->createCommand($sql7)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data7=[];
               foreach ($rawData7 as $data7) {
                      $main_data7[]=[
                             'name' => $data7['icd10'],
                             'y' => $data7['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main7=  json_encode($main_data7);          
                        $dataProvider7 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData7,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);   
        $sql8="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                  where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' and a.spclty='07'
                   group by a.pdx order by total desc limit 10;";
        try {
              $rawData8 = \Yii::$app->db1->createCommand($sql8)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data8=[];
               foreach ($rawData8 as $data8) {
                      $main_data8[]=[
                             'name' => $data8['icd10'],
                             'y' => $data8['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main8=  json_encode($main_data8);          
                        $dataProvider8 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData8,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);  
        $sql9="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                  where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' and a.spclty='08'
                   group by a.pdx order by total desc limit 10;";
        try {
              $rawData9 = \Yii::$app->db1->createCommand($sql9)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data9=[];
               foreach ($rawData9 as $data9) {
                      $main_data9[]=[
                             'name' => $data9['icd10'],
                             'y' => $data9['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main9=  json_encode($main_data9);          
                        $dataProvider9 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData9,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);                          
        $sql10="select a.pdx icd10,i.name diag,count(*) total from an_stat a inner join icd101 i on a.pdx=i.code
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.pdx not like 'Z%' 
                   and (a.spclty='15' or a.spclty='05') and a.ward ='12' group by a.pdx order by total desc limit 10;";
        try {
              $rawData10 = \Yii::$app->db1->createCommand($sql10)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }     
        $main_data10=[];
               foreach ($rawData10 as $data10) {
                      $main_data10[]=[
                             'name' => $data10['icd10'],
                             'y' => $data10['total'] * 1,
                             // 'drilldown' => $data1['village_id']
                      ];
               }
                        $main10=  json_encode($main_data10);          
                        $dataProvider10 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData10,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);                            
                        
         return $this->render('/site/basic-gen/basic-gen-18-preview',['mText'=>$this->mText,'names'=>$names, 'date1' =>$date1,'date2' =>$date2,
                                    'main1'=>$main1,'main2'=>$main2,'main3'=>$main3,'main4'=>$main4,'main5'=>$main5,
                                    'main6'=>$main6,'main7'=>$main7,'main8'=>$main8,'main9'=>$main9,'main10'=>$main10,
                                    'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                                    'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5,'dataProvider6'=>$dataProvider6,
                                    'dataProvider7'=>$dataProvider7,'dataProvider8'=>$dataProvider8,'dataProvider9'=>$dataProvider9,
                                    'dataProvider10'=>$dataProvider10
                             ]);                           
    }
    public function actionBasicGen19() {
        $model = new Formmodel();
        $names="รายงาน Re admit 28 วัน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               return $this->redirect(['basic-gen19_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-19',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    } 
    public function actionBasicGen19_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;   
        $sql1="select a.pdx pdx1,b.pdx pdx2,i.`name` icdname,count(*) as num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>'' group by a.pdx order by num desc limit 20;";
        try {
              $rawData1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }    
       $dataProvider1 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData1,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]);              
       $sql2="select a.pdx pdx1,i.name icdname,count(*) num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.spclty=b.spclty and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}'  and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>''  and a.spclty='01' group by a. pdx order by num desc limit 20;";
        try {
              $rawData2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }             
       $dataProvider2 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData2,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]);         
       $sql3="select a.pdx pdx1,i.name icdname,count(*) num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.spclty=b.spclty and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>''  and a.spclty='02' group by a. pdx order by num desc limit 20;";
        try {
              $rawData3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }             
       $dataProvider3 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData3,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]);           
       $sql4="select a.pdx pdx1,i.name icdname,count(*) num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.spclty=b.spclty and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>''  and a.spclty='03' group by a. pdx order by num desc limit 20;";
        try {
              $rawData4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }             
       $dataProvider4 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData4,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]);   
       $sql5="select a.pdx pdx1,i.name icdname,count(*) num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.spclty=b.spclty and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>''  and a.spclty='04' group by a. pdx order by num desc limit 20;";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }             
       $dataProvider5 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData5,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]);       
       $sql6="select a.pdx pdx1,i.name icdname,count(*) num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.spclty=b.spclty and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>''  and a.spclty='05' and a.ward !='12' 
                                       group by a. pdx order by num desc limit 20;";
        try {
              $rawData6 = \Yii::$app->db1->createCommand($sql6)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }             
       $dataProvider6 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData6,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]);        
       $sql7="select a.pdx pdx1,i.name icdname,count(*) num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.spclty=b.spclty and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>''  and a.spclty='06' group by a. pdx order by num desc limit 20;";
        try {
              $rawData7 = \Yii::$app->db1->createCommand($sql7)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }             
       $dataProvider7 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData7,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]);          
       $sql8="select a.pdx pdx1,i.name icdname,count(*) num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.spclty=b.spclty and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>''  and a.spclty='07' group by a. pdx order by num desc limit 20;";
        try {
              $rawData8 = \Yii::$app->db1->createCommand($sql8)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }             
       $dataProvider8 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData8,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]); 
       $sql9="select a.pdx pdx1,i.name icdname,count(*) num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.spclty=b.spclty and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>''  and a.spclty='08' group by a. pdx order by num desc limit 20;";
        try {
              $rawData9 = \Yii::$app->db1->createCommand($sql9)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }             
       $dataProvider9 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData9,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]);        
      $sql10="select a.pdx pdx1,i.name icdname,count(*) num from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.spclty=b.spclty and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx is not null and a.pdx<>'' and (a.spclty='15' or a.spclty='05') and a.ward ='12' 
                                       group by a. pdx order by num desc limit 20;";
        try {
              $rawData10 = \Yii::$app->db1->createCommand($sql10)->queryAll();
             } catch (\yii\db\Exception $e) {
              throw new \yii\web\ConflictHttpException('sql error');
            }             
       $dataProvider10 = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData10,
                            'pagination' => [
                                'pageSize' => 10,
                             ],
        ]);       
        return $this->render('/site/basic-gen/basic-gen-19-preview',['mText'=>$this->mText,'names'=>$names, 'date1' =>$date1,'date2' =>$date2,
                                            'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                                            'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5,'dataProvider6'=>$dataProvider6,
                                            'dataProvider7'=>$dataProvider7,'dataProvider8'=>$dataProvider8,'dataProvider9'=>$dataProvider9,
                                            'dataProvider10'=>$dataProvider10
                                    ]);        
    }    
    public function actionBasicGen20() {
        $model = new Formmodel();        
        $names="รายงานดัชนีส่วนผสมผู้ป่วยใน Case Mixed Index  (CMI)";  
        $sql="SELECT  '0,ทั้งหมด' AS id,'ทั้งหมด' AS name FROM pttype_spp UNION 
                  SELECT concat(pttype_spp_id,',',pttype_spp_name) id, pttype_spp_name as name FROM pttype_spp order by id;";
        $locations =  \Yii::$app->db1->createCommand($sql)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','name');             
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
               $type = Yii::$app->request->post('type');               
            return $this->redirect(['basic-gen20_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'t'=>$type]);
        }
            return $this -> render('/site/basic-gen/basic-gen-20',['mText'=>$this->mText, 'names'=>$names,
                                          'model' => $model, 'data'=>$listData]);
    }    
    public function actionBasicGen20_preview($name,$d1,$d2,$t) {
        $names=$name;
        $date1=$d1;$date2=$d2;   
        $type=  explode(',', $t);$type_c=$type[0];$type_n=$type[1];
        $rawData=[];
        switch ($type_c) {
               case 0:
                  $sql1a="select pp.total,October,November,December,January,February,March,April,May,June,July,August,September  
                       from (select ps.pttype_spp_name as pttype,count(*) total,
                             count(if(month(dchdate)=10,1,null)) as October,
                             count(if(month(dchdate)=11,1,null)) as November,
                             count(if(month(dchdate)=12,1,null))  as December,
                             count(if(month(dchdate)=1,1,null))  as January,
                             count(if(month(dchdate)=2,1,null))  as February,
                             count(if(month(dchdate)=3,1,null))  as March,
                             count(if(month(dchdate)=4,1,null))  as April,
                             count(if(month(dchdate)=5,1,null))  as May,
                             count(if(month(dchdate)=6,1,null))  as June,
                             count(if(month(dchdate)=7,1,null))  as July,
                             count(if(month(dchdate)=8,1,null))  as August,
                             count(if(month(dchdate)=9,1,null)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id
                       where i.dchdate between '{$date1}' and '{$date2}' ) pp;";
                   $result1=\Yii::$app->db1->createCommand($sql1a)->queryAll();       
               foreach ($result1 as $value1) {
                  $rawData[]=[
                      'id' => '1',
                      'names' => '',
                      'detail' => 'จำนวนผู้ป่วยใน',
                      'October' => $value1['October'],
                      'November' => $value1['November'],
                      'December' => $value1['December'],
                      'January' => $value1['January'],
                      'February' => $value1['February'],
                      'March' => $value1['March'],
                      'April' => $value1['April'],
                      'May' => $value1['May'],
                      'June' => $value1['June'],
                      'July' => $value1['July'],
                      'August' => $value1['August'],
                      'September' => $value1['September'],
                      'total' => $value1['total']
                  ];
                }
                $sql1b="select pp.adjrw,October,November,December,January,February,March,April,May,June,July,August,September  
                          from (select ps.pttype_spp_name as pttype,sum(i.adjrw) adjrw,
                             sum(if(month(dchdate)=10,i.adjrw,0)) as October,
                             sum(if(month(dchdate)=11,i.adjrw,0)) as November,
                             sum(if(month(dchdate)=12,i.adjrw,0))  as December,
                             sum(if(month(dchdate)=1,i.adjrw,0))  as January,
                             sum(if(month(dchdate)=2,i.adjrw,0))  as February,
                             sum(if(month(dchdate)=3,i.adjrw,0))  as March,
                             sum(if(month(dchdate)=4,i.adjrw,0))  as April,
                             sum(if(month(dchdate)=5,i.adjrw,0))  as May,
                             sum(if(month(dchdate)=6,i.adjrw,0))  as June,
                             sum(if(month(dchdate)=7,i.adjrw,0))  as July,
                             sum(if(month(dchdate)=8,i.adjrw,0))  as August,
                             sum(if(month(dchdate)=9,i.adjrw,0)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id 
                       where i.dchdate between '{$date1}' and '{$date2}') pp;";
        $result2=\Yii::$app->db1->createCommand($sql1b)->queryAll();       
        foreach ($result2 as $value2) {
               $rawData[]=[
                      'id' => '2',
                      'names' => '',
                      'detail' => 'จำนวน adjrw',
                      'October' => $value2['October'],
                      'November' => $value2['November'],
                      'December' => $value2['December'],
                      'January' => $value2['January'],
                      'February' => $value2['February'],
                      'March' => $value2['March'],
                      'April' => $value2['April'],
                      'May' => $value2['May'],
                      'June' => $value2['June'],
                      'July' => $value2['July'],
                      'August' => $value2['August'],
                      'September' => $value2['September'],
                      'total' => $value2['adjrw']
               ];
        }                       
        $sql1c="select pp.noper,October,November,December,January,February,March,April,May,June,July,August,September  
                       from (select ps.pttype_spp_name as pttype,count(*) noper,
                             count(if(month(dchdate)=10,1,null)) as October,
                             count(if(month(dchdate)=11,1,null)) as November,
                             count(if(month(dchdate)=12,1,null))  as December,
                             count(if(month(dchdate)=1,1,null))  as January,
                             count(if(month(dchdate)=2,1,null))  as February,
                             count(if(month(dchdate)=3,1,null))  as March,
                             count(if(month(dchdate)=4,1,null))  as April,
                             count(if(month(dchdate)=5,1,null))  as May,
                             count(if(month(dchdate)=6,1,null))  as June,
                             count(if(month(dchdate)=7,1,null))  as July,
                             count(if(month(dchdate)=8,1,null))  as August,
                             count(if(month(dchdate)=9,1,null)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id 
                       where i.dchdate between '{$date1}' and '{$date2}' and substr(i.drg,3,2)>=50) pp;";
        $result3=\Yii::$app->db1->createCommand($sql1c)->queryAll();       
        foreach ($result3 as $value3) {
               $rawData[]=[
                      'id' => '3',
                      'names' => 'รวมทั้งหมด',
                      'detail' => 'กลุ่มไม่ผ่าตัด',
                      'October' => $value3['October'],
                      'November' => $value3['November'],
                      'December' => $value3['December'],
                      'January' => $value3['January'],
                      'February' => $value3['February'],
                      'March' => $value3['March'],
                      'April' => $value3['April'],
                      'May' => $value3['May'],
                      'June' => $value3['June'],
                      'July' => $value3['July'],
                      'August' => $value3['August'],
                      'September' => $value3['September'],
                      'total' => $value3['noper']
               ];
        }         
        $sql1d="select pp.oper,October,November,December,January,February,March,April,May,June,July,August,September  
                       from (select ps.pttype_spp_name as pttype,count(*) oper,
                             count(if(month(dchdate)=10,1,null)) as October,
                             count(if(month(dchdate)=11,1,null)) as November,
                             count(if(month(dchdate)=12,1,null))  as December,
                             count(if(month(dchdate)=1,1,null))  as January,
                             count(if(month(dchdate)=2,1,null))  as February,
                             count(if(month(dchdate)=3,1,null))  as March,
                             count(if(month(dchdate)=4,1,null))  as April,
                             count(if(month(dchdate)=5,1,null))  as May,
                             count(if(month(dchdate)=6,1,null))  as June,
                             count(if(month(dchdate)=7,1,null))  as July,
                             count(if(month(dchdate)=8,1,null))  as August,
                             count(if(month(dchdate)=9,1,null)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id 
                       where i.dchdate between '{$date1}' and '{$date2}' and substr(i.drg,3,2)<50) pp;";
        $result4=\Yii::$app->db1->createCommand($sql1d)->queryAll();       
        foreach ($result4 as $value4) {
               $rawData[]=[
                      'id' => '4',
                      'names' => '',
                      'detail' => 'กลุ่มผ่าตัด',
                      'October' => $value4['October'],
                      'November' => $value4['November'],
                      'December' => $value4['December'],
                      'January' => $value4['January'],
                      'February' => $value4['February'],
                      'March' => $value4['March'],
                      'April' => $value4['April'],
                      'May' => $value4['May'],
                      'June' => $value4['June'],
                      'July' => $value4['July'],
                      'August' => $value4['August'],
                      'September' => $value4['September'],
                      'total' => $value4['oper']
               ];
        }         
        $sql1e="select pp.cmi,October,November,December,January,February,March,April,May,June,July,August,September  
                       from (select ps.pttype_spp_name as pttype,AVG(adjrw) cmi,
                             sum(if(month(dchdate)=10,i.adjrw,0))/count(if(month(i.dchdate)=10,1,null)) as October,
                             sum(if(month(dchdate)=11,i.adjrw,0))/count(if(month(i.dchdate)=11,1,null))as November,
                             sum(if(month(dchdate)=12,i.adjrw,0))/count(if(month(i.dchdate)=12,1,null))  as December,
                             sum(if(month(dchdate)=1,i.adjrw,0))/count(if(month(i.dchdate)=1,1,null))  as January,
                             sum(if(month(dchdate)=2,i.adjrw,0))/count(if(month(i.dchdate)=2,1,null))  as February,
                             sum(if(month(dchdate)=3,i.adjrw,0))/count(if(month(i.dchdate)=3,1,null))  as March,
                             sum(if(month(dchdate)=4,i.adjrw,0))/count(if(month(i.dchdate)=4,1,null))  as April,
                             sum(if(month(dchdate)=5,i.adjrw,0))/count(if(month(i.dchdate)=5,1,null))  as May,
                             sum(if(month(dchdate)=6,i.adjrw,0))/count(if(month(i.dchdate)=6,1,null))  as June,
                             sum(if(month(dchdate)=7,i.adjrw,0))/count(if(month(i.dchdate)=7,1,null)) as July,
                             sum(if(month(dchdate)=8,i.adjrw,0))/count(if(month(i.dchdate)=8,1,null)) as August,
                            sum(if(month(dchdate)=9,i.adjrw,0))/count(if(month(i.dchdate)=9,1,null)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id 
                       where i.dchdate between '{$date1}' and '{$date2}' ) pp;";   
        $result5=\Yii::$app->db1->createCommand($sql1e)->queryAll();       
        foreach ($result5 as $value5) {
               $rawData[]=[
                      'id' => '5',
                      'names' => '',
                      'detail' => 'CMI',
                      'October' => $value5['October'],
                      'November' => $value5['November'],
                      'December' => $value5['December'],
                      'January' => $value5['January'],
                      'February' => $value5['February'],
                      'March' => $value5['March'],
                      'April' => $value5['April'],
                      'May' => $value5['May'],
                      'June' => $value5['June'],
                      'July' => $value5['July'],
                      'August' => $value5['August'],
                      'September' => $value5['September'],
                      'total' => $value5['cmi']
                ];
               }   
               break;
               default:
        $sql1a="select pp.total,October,November,December,January,February,March,April,May,June,July,August,September  
                       from (select ps.pttype_spp_name as pttype,count(*) total,
                             count(if(month(dchdate)=10,1,null)) as October,
                             count(if(month(dchdate)=11,1,null)) as November,
                             count(if(month(dchdate)=12,1,null))  as December,
                             count(if(month(dchdate)=1,1,null))  as January,
                             count(if(month(dchdate)=2,1,null))  as February,
                             count(if(month(dchdate)=3,1,null))  as March,
                             count(if(month(dchdate)=4,1,null))  as April,
                             count(if(month(dchdate)=5,1,null))  as May,
                             count(if(month(dchdate)=6,1,null))  as June,
                             count(if(month(dchdate)=7,1,null))  as July,
                             count(if(month(dchdate)=8,1,null))  as August,
                             count(if(month(dchdate)=9,1,null)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id
                       where i.dchdate between '{$date1}' and '{$date2}' and ps.pttype_spp_id='{$type_c}') pp;";
        $result1=\Yii::$app->db1->createCommand($sql1a)->queryAll();       
        foreach ($result1 as $value1) {
               $rawData[]=[
                      'id' => '1',
                      'names' => '',
                      'detail' => 'จำนวนผู้ป่วยใน',
                      'October' => $value1['October'],
                      'November' => $value1['November'],
                      'December' => $value1['December'],
                      'January' => $value1['January'],
                      'February' => $value1['February'],
                      'March' => $value1['March'],
                      'April' => $value1['April'],
                      'May' => $value1['May'],
                      'June' => $value1['June'],
                      'July' => $value1['July'],
                      'August' => $value1['August'],
                      'September' => $value1['September'],
                      'total' => $value1['total']
               ];
        }
        $sql1b="select pp.adjrw,October,November,December,January,February,March,April,May,June,July,August,September  
                       from (select ps.pttype_spp_name as pttype,sum(i.adjrw) adjrw,
                             sum(if(month(dchdate)=10,i.adjrw,0)) as October,
                             sum(if(month(dchdate)=11,i.adjrw,0)) as November,
                             sum(if(month(dchdate)=12,i.adjrw,0))  as December,
                             sum(if(month(dchdate)=1,i.adjrw,0))  as January,
                             sum(if(month(dchdate)=2,i.adjrw,0))  as February,
                             sum(if(month(dchdate)=3,i.adjrw,0))  as March,
                             sum(if(month(dchdate)=4,i.adjrw,0))  as April,
                             sum(if(month(dchdate)=5,i.adjrw,0))  as May,
                             sum(if(month(dchdate)=6,i.adjrw,0))  as June,
                             sum(if(month(dchdate)=7,i.adjrw,0))  as July,
                             sum(if(month(dchdate)=8,i.adjrw,0))  as August,
                             sum(if(month(dchdate)=9,i.adjrw,0)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id 
                       where i.dchdate between '{$date1}' and '{$date2}' and ps.pttype_spp_id='{$type_c}') pp;";
        $result2=\Yii::$app->db1->createCommand($sql1b)->queryAll();       
        foreach ($result2 as $value2) {
               $rawData[]=[
                      'id' => '2',
                      'names' => '',
                      'detail' => 'จำนวน adjrw',
                      'October' => $value2['October'],
                      'November' => $value2['November'],
                      'December' => $value2['December'],
                      'January' => $value2['January'],
                      'February' => $value2['February'],
                      'March' => $value2['March'],
                      'April' => $value2['April'],
                      'May' => $value2['May'],
                      'June' => $value2['June'],
                      'July' => $value2['July'],
                      'August' => $value2['August'],
                      'September' => $value2['September'],
                      'total' => $value2['adjrw']
               ];
        }                       
        $sql1c="select pp.noper,October,November,December,January,February,March,April,May,June,July,August,September  
                       from (select ps.pttype_spp_name as pttype,count(*) noper,
                             count(if(month(dchdate)=10,1,null)) as October,
                             count(if(month(dchdate)=11,1,null)) as November,
                             count(if(month(dchdate)=12,1,null))  as December,
                             count(if(month(dchdate)=1,1,null))  as January,
                             count(if(month(dchdate)=2,1,null))  as February,
                             count(if(month(dchdate)=3,1,null))  as March,
                             count(if(month(dchdate)=4,1,null))  as April,
                             count(if(month(dchdate)=5,1,null))  as May,
                             count(if(month(dchdate)=6,1,null))  as June,
                             count(if(month(dchdate)=7,1,null))  as July,
                             count(if(month(dchdate)=8,1,null))  as August,
                             count(if(month(dchdate)=9,1,null)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id 
                       where i.dchdate between '{$date1}' and '{$date2}' and substr(i.drg,3,2)>=50 and ps.pttype_spp_id='{$type_c}' ) pp;";
        $result3=\Yii::$app->db1->createCommand($sql1c)->queryAll();       
        foreach ($result3 as $value3) {
               $rawData[]=[
                      'id' => '3',
                      'names' => $type_n,
                      'detail' => 'กลุ่มไม่ผ่าตัด',
                      'October' => $value3['October'],
                      'November' => $value3['November'],
                      'December' => $value3['December'],
                      'January' => $value3['January'],
                      'February' => $value3['February'],
                      'March' => $value3['March'],
                      'April' => $value3['April'],
                      'May' => $value3['May'],
                      'June' => $value3['June'],
                      'July' => $value3['July'],
                      'August' => $value3['August'],
                      'September' => $value3['September'],
                      'total' => $value3['noper']
               ];
        }         
        $sql1d="select pp.oper,October,November,December,January,February,March,April,May,June,July,August,September  
                       from (select ps.pttype_spp_name as pttype,count(*) oper,
                             count(if(month(dchdate)=10,1,null)) as October,
                             count(if(month(dchdate)=11,1,null)) as November,
                             count(if(month(dchdate)=12,1,null))  as December,
                             count(if(month(dchdate)=1,1,null))  as January,
                             count(if(month(dchdate)=2,1,null))  as February,
                             count(if(month(dchdate)=3,1,null))  as March,
                             count(if(month(dchdate)=4,1,null))  as April,
                             count(if(month(dchdate)=5,1,null))  as May,
                             count(if(month(dchdate)=6,1,null))  as June,
                             count(if(month(dchdate)=7,1,null))  as July,
                             count(if(month(dchdate)=8,1,null))  as August,
                             count(if(month(dchdate)=9,1,null)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id 
                       where i.dchdate between '{$date1}' and '{$date2}' and substr(i.drg,3,2)<50 and ps.pttype_spp_id='{$type_c}' ) pp;";
        $result4=\Yii::$app->db1->createCommand($sql1d)->queryAll();       
        foreach ($result4 as $value4) {
               $rawData[]=[
                      'id' => '4',
                      'names' => '',
                      'detail' => 'กลุ่มผ่าตัด',
                      'October' => $value4['October'],
                      'November' => $value4['November'],
                      'December' => $value4['December'],
                      'January' => $value4['January'],
                      'February' => $value4['February'],
                      'March' => $value4['March'],
                      'April' => $value4['April'],
                      'May' => $value4['May'],
                      'June' => $value4['June'],
                      'July' => $value4['July'],
                      'August' => $value4['August'],
                      'September' => $value4['September'],
                      'total' => $value4['oper']
               ];
        }         
        $sql1e="select pp.cmi,October,November,December,January,February,March,April,May,June,July,August,September  
                       from (select ps.pttype_spp_name as pttype,AVG(adjrw) cmi,
                             sum(if(month(dchdate)=10,i.adjrw,0))/count(if(month(i.dchdate)=10,1,null)) as October,
                             sum(if(month(dchdate)=11,i.adjrw,0))/count(if(month(i.dchdate)=11,1,null))as November,
                             sum(if(month(dchdate)=12,i.adjrw,0))/count(if(month(i.dchdate)=12,1,null))  as December,
                             sum(if(month(dchdate)=1,i.adjrw,0))/count(if(month(i.dchdate)=1,1,null))  as January,
                             sum(if(month(dchdate)=2,i.adjrw,0))/count(if(month(i.dchdate)=2,1,null))  as February,
                             sum(if(month(dchdate)=3,i.adjrw,0))/count(if(month(i.dchdate)=3,1,null))  as March,
                             sum(if(month(dchdate)=4,i.adjrw,0))/count(if(month(i.dchdate)=4,1,null))  as April,
                             sum(if(month(dchdate)=5,i.adjrw,0))/count(if(month(i.dchdate)=5,1,null))  as May,
                             sum(if(month(dchdate)=6,i.adjrw,0))/count(if(month(i.dchdate)=6,1,null))  as June,
                             sum(if(month(dchdate)=7,i.adjrw,0))/count(if(month(i.dchdate)=7,1,null)) as July,
                             sum(if(month(dchdate)=8,i.adjrw,0))/count(if(month(i.dchdate)=8,1,null)) as August,
                            sum(if(month(dchdate)=9,i.adjrw,0))/count(if(month(i.dchdate)=9,1,null)) as September
                       from ipt i inner join pttype p on i.pttype=p.pttype inner join pttype_spp ps on p.pttype_spp_id=ps.pttype_spp_id 
                       where i.dchdate between '{$date1}' and '{$date2}' and ps.pttype_spp_id='{$type_c}' ) pp;";   
        $result5=\Yii::$app->db1->createCommand($sql1e)->queryAll();       
        foreach ($result5 as $value5) {
               $rawData[]=[
                      'id' => '5',
                      'names' => '',
                      'detail' => 'CMI',
                      'October' => $value5['October'],
                      'November' => $value5['November'],
                      'December' => $value5['December'],
                      'January' => $value5['January'],
                      'February' => $value5['February'],
                      'March' => $value5['March'],
                      'April' => $value5['April'],
                      'May' => $value5['May'],
                      'June' => $value5['June'],
                      'July' => $value5['July'],
                      'August' => $value5['August'],
                      'September' => $value5['September'],
                      'total' => $value5['cmi']
               ];
        }                 
               break;
        }

                        $dataProvider = new \yii\data\ArrayDataProvider([
                            'allModels' => $rawData,
                            'pagination' => [
                                'pageSize' => 10,
                                ],
                        ]);           
        
        return $this->render('/site/basic-gen/basic-gen-20-preview',['names'=>$names,'mText'=>$this->mText,'dataProvider'=>$dataProvider,
                          'date1'=>$date1,'date2'=>$date2,'tname'=>$type_n]);
    }    
    public function actionBasicGen21() {
        $model = new Formmodel();        
        $names="รายงานดัชนีส่วนผสมผู้ป่วยใน Case Mixed Index(CMI) แยกแผนก";       
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;              
            return $this->redirect(['basic-gen21_preview', 'name'=>$names, 'd1'=>$date1, 'd2'=>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-21', ['mText'=>$this->mText, 'names'=>$names,
                                          'model' => $model]);
    }      
    public function actionBasicGen21_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select  s.name spname,count(*) total,format(sum(i.adjrw),2) adjrw,count(if(substr(i.drg,3,2)>=50,1,null)) noper,
                  count(if(substr(i.drg,3,2)<50,1,null)) oper,AVG(i.adjrw) cmi, sum(a.income) income 
                  from ipt i inner join spclty s on i.spclty=s.spclty inner join an_stat a on i.an=a.an
                  where i.dchdate  between '{$date1}' and '{$date2}'  group by i.spclty order by s.spclty;";     
        try {
              $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }    
        $dataProvider = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData,
                     'pagination' => [
                     'pageSize' => 30,
                      ],
        ]);                 
        return $this->render('/site/basic-gen/basic-gen-21-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                   'date1' =>$date1,'date2' =>$date2]);                 
    }    
    public function actionBasicGen22() {
        $model = new Formmodel();        
        $names="รายงาน 20 กลุ่มโรค(MDC)ตาม DRG ";  
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;              
            return $this->redirect(['basic-gen22_preview', 'name'=>$names, 'd1'=>$date1, 'd2'=>$date2]);
        }
            return $this -> render('/site/basic-gen/basic-gen-22', ['mText'=>$this->mText, 'names'=>$names,
                                          'model' => $model]);
    }      
    public function actionBasicGen22_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;  
        $sql1="select m.mdc,m.mdc_name,count(*) total,format(sum(i.adjrw),2) adjrw,format(avg(i.adjrw),2) cmi,
                  count(if(substr(i.drg,3,2)>=50,1,null)) noper,format(sum(if(substr(i.drg,3,2)>=50,i.adjrw,0)),2) noper_adjrw,
                  format(avg(if(substr(i.drg,3,2)>=50,i.adjrw,0)),2) noper_cmi,count(if(substr(i.drg,3,2)<50,1,null)) oper,
                  format(sum(if(substr(i.drg,3,2)<50,i.adjrw,0)),2)  oper_adjrw,
                  format((format(sum(if(substr(i.drg,3,2)<50,i.adjrw,0)),2)/count(if(substr(i.drg,3,2)<50,1,null))),2) oper_cmi
                  from ipt i inner join mdc m on i.mdc=m.mdc where i.dchdate  between '{$date1}' and '{$date2}'
                   group by i.mdc order by m.mdc;";
        try {
              $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }    
        $dataProvider = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData,
                     'pagination' => [
                     'pageSize' => 30,
                      ],
        ]);                  
        return $this->render('/site/basic-gen/basic-gen-22-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                   'date1' =>$date1,'date2' =>$date2]);            
   }    
    public function actionBasicGen23() {
        $model = new Formmodel();        
        $names="รายงานส่งต่อผู้ป่วย(refer out) แยกตามสถานบริการส่งต่อ";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person9.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-23',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }   
    public function actionBasicGen24() {
        $model = new Formmodel();        
        $names="รายงานการรับส่งต่อผู้ป่วย(refer in) แยกตามสถานบริการส่งต่อ";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person10.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }  
    public function actionBasicGen25() {
        $model = new Formmodel();        
        $names="รายงานการรับส่งต่อผู้ป่วย(refer out) โรงพยาบาลเครือข่าย";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person11.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }      
    public function actionBasicGen26() {
        $model = new Formmodel();        
        $names="รายงานการรับส่งต่อผู้ป่วย(refer in) โรงพยาบาลเครือข่าย";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person12.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }      
    public function actionBasicGen27() {
        $model = new Formmodel();        
        $names="รายงานการรับส่งต่อผู้ป่วย(refer out) โรงพยาบาลเครือข่าย ที่มี Adj RW <=0.5";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person13.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }     
    public function actionBasicGen28() {
        $model = new Formmodel();        
        $names="รายงานการรับส่งต่อผู้ป่วย(refer in) โรงพยาบาลเครือข่าย ที่มี Adj RW <=0.5";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person14.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }       
    public function actionBasicGen29() {
        $model = new Formmodel();        
        $names="รายงานจำนวนผู้รับบริการผู้ป่วยนอก(ในเครือข่าย 7 อำเภอ)";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person15.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }        
    public function actionBasicGen30() {
        $model = new Formmodel();        
        $names="รายงานจำนวนผู้รับบริการผู้ป่วยนอก(ในเขตรับผิดชอบ[20 ชุมชน + 14 หมู่] )";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person16.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }     
    public function actionBasicGen31() {
        $model = new Formmodel();        
        $names="รายงานจำนวนผู้รับบริการผู้ป่วยนอก(ในเขตอำเภอ[ ไม่รวม 20 ชุมชน + 14 หมู่] )";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person17.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }     
    public function actionBasicGen32() {
        $model = new Formmodel();        
        $names="รายงานจำนวนผู้รับบริการ(ในเขตรับผิดชอบ[20 ชุมชน + 14 หมู่]) แยกตามสิทธิ์การรักษา";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person18.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }       
    public function actionBasicGen33() {
        $model = new Formmodel();        
        $names="รายงานจำนวนผู้รับบริการ(ทั้งหมด) แยกตามสิทธิ์การรักษา";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=basic/"; 
                return $this->redirect($url.'person19.mrt&d1='.$date1.'&d2='.$date2);                  
        }
            return $this -> render('/site/basic-gen/basic-gen-24',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }       
    
}    

