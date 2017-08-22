<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class OpdController extends Controller
{
    public $mText = "งานผู้ป่วยนอก";
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
        $names="งานผู้ป่วยนอก"; 
         return $this -> render('/site/opd/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionOpd1Index() {
        $model = new Formmodel();               
        $names="รายงานยอดผู้ป่วยนอก(9 แผนกหลัก)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
            return $this->redirect(['opd1_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/opd/opd1-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);
    } 
    public function actionOpd1_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $rawData=[];
        $sql1 = "select  count(distinct(v.hn)) tman,count(*) tmen,count(distinct(if(o.visit_type='I',o.hn,''))) inman,
                    count(if(o.visit_type='I',1,null)) inmen,count(distinct(if(o.visit_type='O',o.hn,''))) outman,
                    count(if(o.visit_type='O',1,null)) outmen 
                    from vn_stat v inner join ovst o on o.vn=v.vn 
                    where v.vstdate between '{$date1}' and '{$date2}' and v.spclty in ('01','02','03','04','05','06','07','08','25') ";  
        $result1=\Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
               $tman=$value1['tman'];
               $tmen=$value1['tmen'];
               $inman=$value1['inman'];
               $inmen=$value1['inmen'];
               $outman=$value1['outman'];
               $outmen=$value1['outmen'];
        }
        $sql2="select count(if(count_in_year=0,1,null)) newman,count(distinct(if(count_in_year>0,hn,''))) oldman,
                  count(if(count_in_year>0,1,null)) oldmen
                  from vn_stat 
                 where vstdate between '{$date1}' and '{$date2}' and spclty in ('01','02','03','04','05','06','07','08','25') ;";
        $result2=\Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
              $newman=$value2['newman'];
              $oldman=$value2['oldman'];
              $oldmen=$value2['oldmen'];
        }       
        $sql3=";";
        $rawData[]=[
            'names'=>'รายการแสดงจำนวนผู้ป่วยนอก',
            'tman'=>$tman,//คนทั้งหมด
            'tmen'=>$tmen,//ครั้งทั้งหมด
            'newman'=>$newman,//รายใหม่คน
            'oldman'=>$oldman,//รายเก่าคน
            'oldmen'=>$oldmen,//รายเก่าครั้ง
            'inman'=>$inman,//ในเวลาคน
            'inmen'=>$inmen,//ในเวลาครั้ง
            'outman'=>$outman,//นอกเวลาคน
            'outmen'=>$outmen,//นอกเวลาครั้ง
        ];               
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 10,
                ],
        ]);  
        return $this -> render('/site/opd/opd1-preview',['dataProvider' => $rawData,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);                     
    }     
    public function actionOpd2Index() {
        $model = new Formmodel();               
        $names="รายงานผู้ป่วยนอกแยกตามแผนก(9 แผนกหลัก)";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
            return $this->redirect(['opd2_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/opd/opd2-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);
    }     
    public function actionOpd2_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $sql1="select s.`name` spclty,pp.man,pp.men  
                  from spclty s inner join (select spclty,count(distinct(hn)) man,count(*) men from ovst 
                  where vstdate between '{$date1}' and '{$date2}' and spclty in ('01','02','03','04','05','06','07','08','25') group by spclty) pp 
                  on s.spclty=pp.spclty order by s.spclty;";
        try {
            $rawData = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }    
        $main_data=[];
        foreach ($rawData as $data1) {
               $main_data[]=[
                         'name' => $data1['spclty'],
                         'y' => $data1['men'] * 1,
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
        return $this->render('/site/opd/opd2-preview',['mText'=>$this->mText,'names'=>$names,'main'=>$main,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2]);                      
    }    
    public function actionOpd3Index() {
        $model = new Formmodel();               
        $names="รายงาน 10 อันดับโรคผู้ป่วยนอก(9 แผนกหลัก)";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
               $s1=Yii::$app->request->post('s1'); 
               $s2=Yii::$app->request->post('s2');                 
             return $this->redirect(['opd3_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'s1'=>$s1,'s2'=>$s2]);
        }
            return $this -> render('/site/opd/opd3-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);
    }       
    public function actionOpd3_preview($name,$d1,$d2,$s1,$s2) {
        $names=$name;
        $date1=$d1;$date2=$d2;$se1=$s1;$se2=$s2;
       if($s1==1){
               $sql1="select i.code icd10,i.name diag,pp.man total from icd101 i inner join 
                            (select icd10,count(distinct(o.hn)) man,count(*) men from ovstdiag o inner join vn_stat v on v.vn=o.vn 
                            where v.vstdate between '{$date1}' and '{$date2}' and v.spclty in ('01','02','03','04','05','06','07','08','25')
                            group by o.icd10 order by man desc) pp on i.code=pp.icd10  order by man desc limit 10;"; 
               $time='ตามคน';             
        }elseif ($s2==1) {
               $sql1="select i.code icd10,i.name diag,pp.men total from icd101 i inner join 
                            (select icd10,count(distinct(o.hn)) man,count(*) men from ovstdiag o inner join vn_stat v on v.vn=o.vn 
                            where v.vstdate between '{$date1}' and '{$date2}' and v.spclty in ('01','02','03','04','05','06','07','08','25')
                            group by o.icd10 order by man desc) pp on i.code=pp.icd10  order by men desc limit 10;"; 
               $time='ตามครั้ง';                                
        }
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
        return $this->render('/site/opd/opd3-preview',['mText'=>$this->mText,'names'=>$names,'main'=>$main,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2,'time'=>$time]);    
    }   
    public function actionOpd4Index() {
        $model = new Formmodel();               
        $names="รายงานการกลับมารักษาซ้ำภายใน 48 ชม.ด้วยโรคเดิม ผู้ป่วยนอก(9 แผนกหลัก)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
            return $this->redirect(['opd4_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/opd/opd4-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);
    }      
    public function actionOpd4_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select a.hn,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.pdx icd10_now,a.vstdate vstdate_now,
                  o1.vsttime vsttime_now,sp1.name station_now,b.pdx icd10_befor,b.vstdate vstdate_before,o2.vsttime vsttime_before,
                  sp2.name station_before,a.lastvisit_hour,a.vstdate-b.vstdate days from vn_stat a 
	    left outer join vn_stat b on a.hn=b.hn and a.pdx=b.pdx and a.vn>b.vn left outer join patient p on p.hn=a.hn 
                  left outer join ovst o1 on a.vn=o1.vn left outer join ovst o2 on b.vn=o2.vn left outer join spclty sp1 on sp1.spclty=o1.spclty
                  left outer join spclty sp2 on sp2.spclty=o2.spclty left outer join thaiaddress th on th.addressid=a.aid
                  where a.vstdate between '{$date1}' and '{$date2}' and a.lastvisit_hour <= 48  and a.vstdate-b.vstdate<=2 
                  and a.pdx is not null and a.pdx<>'' and a.pdx not like '%Z%'  and a.spclty in ('01','02','03','04','05','06','07','08','25') 
                  order by a.hn,a.vstdate;";
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
        return $this->render('/site/opd/opd4-preview',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2]);   
    }    
    public function actionOpd5Index() {
        $model = new Formmodel();               
        $names="รายงาน 10 อันดับโรคการส่งต่อผู้ป่วยนอก(9 แผนกหลัก)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;   
            return $this->redirect(['opd5_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/opd/opd5-index',['mText'=>$this->mText,'names'=>$names, 'model' => $model]);
    }      
    public function actionOpd5_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;     
        $sql1="select r.pdx icd10,i.name diag,count(*) cc  from referout r inner join hospcode h on r.refer_hospcode=h.hospcode
                  inner join icd101 i on r.pdx=i.code inner join vn_stat v on r.vn=v.vn
                  where r.refer_date between '{$date1}' and '{$date2}' and concat(h.chwpart,h.amppart) !='3104'
                   and v.spclty in ('01','02','03','04','05','06','07','08','25') and r.department='OPD'  group by r.pdx order by cc desc limit 10;";
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
        return $this->render('/site/opd/opd5-preview',['mText'=>$this->mText,'names'=>$names,'main'=>$main,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2]);          
    }    
    
}    

