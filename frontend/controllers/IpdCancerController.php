<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class IpdCancerController extends Controller
{
    public $mText = "งานเคมีบำบัด(ตึกผู้ป่วย 5/4)";
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
        $names="งานเคมีบำบัด(ตึกผู้ป่วย 5/4)"; 
         return $this -> render('/site/ipd-cancer/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionCancer1Index() {
        $model = new Formmodel();
        $names="รายงานทะเบียนผู้ป่วยมะเร็ง"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               if($model->radio_list=='1'){
               #   $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=cancer/";   
               #  return $this->redirect($url.'cancer1-opd.mrt&d1='.$date1.'&d2='.$date2);  
               return $this->redirect(['cancer1_preview_opd', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);    
               }else{
               #  $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=cancer/";   
               #  return $this->redirect($url.'cancer1-ipd.mrt&d1='.$date1.'&d2='.$date2);                     
               return $this->redirect(['cancer1_preview_ipd', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);                       
               }  
        }
            return $this -> render('/site/ipd-cancer/cancer1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  
    public function actionCancer1_preview_opd($name,$d1,$d2){
        $rawData = [];
        $sql1 = "select  a.*, b.enddate, b.icd10
                      from 
                      (
                        select p.hn, p.cid, concat(p.pname,p.fname,' ',p.lname) as pname, p.birthday, m.name marrystatus, 
                             timestampdiff(year,p.birthday,curdate()) age_y,p.addrpart, p.moopart, t1.name tmb, t2.name amp, t3.name chw,
	              min(o.vstdate) strdate, o.icd10, i.name diag, pt.name pttype, d.name doctor, c.regdate
		from  patient p 
		left outer join ovstdiag o on p.hn=o.hn
		left outer join marrystatus m on p.marrystatus=m.`code`
		left outer join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
		left outer join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
		left outer join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
		left outer join icd101 i on o.icd10=i.code 
		left outer join clinicmember c on c.hn=p.hn and c.clinic='027'
		left outer join pttype pt on p.pttype=pt.pttype
		left outer join doctor d on d.`code`=o.doctor
		where (p.cid is not null or p.cid !='') and p.death !='Y' and o.icd10 between 'C00' and 'D4899' 
                             group by p.cid
                    ) a 
                    inner join 
                    (
                     select hn, max(vstdate) enddate, icd10 from ovstdiag where icd10 between 'C00' and 'D4899'  and hn is not null 
                         and vstdate between '{$d1}' and '{$d2}' group by hn
                    ) b
                    on a.hn=b.hn";
        try {
            $rawData1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }      
        foreach ($rawData1 as $value) {
               $cid  = $value['cid'];
               $sql2 = "select hn_code from data_patient where REPLACE(card_id,'-','') = '{$cid}' ";
               $result =  \Yii::$app->db2->createCommand($sql2)->queryAll();
               if(!$result){
                   $text = "ยังไม่คีย์";
               }else{
                   $text = "คีย์แล้ว";
               }
       /*       foreach ($result as $value1) {
                $hn = $value1['hn_code'];    
               }
        if(empty($hn)){
              $text = "ยังไม่คีย์";
        }else{
              $text = "คีย์แล้ว";
        }       */
        $rawData[] = [
               'cid' => $value['cid'],
               'hn' => $value['hn'],
               'pname' => $value['pname'],
               'birthday' => $value['birthday'],
               'marrystatus' => $value['marrystatus'],
               'age_y' => $value['age_y'],
               'addrpart' => $value['addrpart'],
               'moopart' => $value['moopart'],
               'tmb' => $value['tmb'],
               'amp' => $value['amp'],
               'chw' => $value['chw'],
               'strdate' => $value['strdate'],
               'icd10' => $value['icd10'],
               'diag' => $value['diag'],    
               'pttype' => $value['pttype'],
               'doctor' => $value['doctor'],
               'enddate' => $value['enddate'],
               'regdate' => $value['regdate'],
               'text' => $text,                
        ];
        $text="";
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);     
        return $this->render('/site/ipd-cancer/ipd-cancer-opd-preview',['mText'=>$this->mText,'names'=>$name,
               'dataProvider'=>$dataProvider, 'date1' =>$d1,'date2' =>$d2]);          
    }
    public function actionCancer1_preview_ipd($name,$d1,$d2){
        $rawData = [];
        $sql1 = "select  a.*, b.enddate
                      from 
                     (
                        select p.hn, p.cid, concat(p.pname,p.fname,' ',p.lname) as pname, p.birthday, m.name marrystatus, 
                        timestampdiff(year,p.birthday,curdate()) age_y, p.addrpart, p.moopart, t1.name tmb, t2.name amp, t3.name chw,
	         min(a.dchdate) strdate, o.icd10, i.name diag, pt.name pttype, d.name doctor, c.regdate
		from  iptdiag o  
		left outer join an_stat a on o.an=a.an
                             left outer join patient p  on p.hn=a.hn
		left outer join marrystatus m on p.marrystatus=m.`code`
		left outer join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
		left outer join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
		left outer join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
		left outer join icd101 i on o.icd10=i.code 
		left outer join clinicmember c on c.hn=p.hn and c.clinic='027'
		left outer join pttype pt on p.pttype=pt.pttype
		left outer join doctor d on d.`code`=o.doctor
		where (p.cid is not null or p.cid !='') and p.death !='Y' and o.icd10 between 'C00' and 'D4899' group by p.cid
                      ) a 
                      inner join 
                     (
                        select a.hn, max(a.dchdate) enddate, i.icd10 from iptdiag i left outer join an_stat a on i.an=a.an 
                        where i.icd10 between 'C00' and 'D4899'  and a.dchdate between '{$d1}' and '{$d2}' group by a.hn
                      ) b
                      on a.hn=b.hn";
        try {
            $rawData1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }      
        foreach ($rawData1 as $value) {
               $cid  = $value['cid'];
               $sql2 = "select hn_code from data_patient where REPLACE(card_id,'-','') = '{$cid}' ";
               $result =  \Yii::$app->db2->createCommand($sql2)->queryAll();
               if(!$result){
                   $text = "ยังไม่คีย์";
               }else{
                   $text = "คีย์แล้ว";
               }               
/*               foreach ($result as $value1) {
                $hn = $value1['hn_code'];    
               }
        if(empty($hn)){
              $text = "ยังไม่คีย์";
        }else{
              $text = "คีย์แล้ว";
        }       
 * 
 */
        $rawData[] = [
               'cid' => $value['cid'],
               'hn' => $value['hn'],
               'pname' => $value['pname'],
               'birthday' => $value['birthday'],
               'marrystatus' => $value['marrystatus'],
               'age_y' => $value['age_y'],
               'addrpart' => $value['addrpart'],
               'moopart' => $value['moopart'],
               'tmb' => $value['tmb'],
               'amp' => $value['amp'],
               'chw' => $value['chw'],
               'strdate' => $value['strdate'],
               'icd10' => $value['icd10'],
               'diag' => $value['diag'],    
               'pttype' => $value['pttype'],
               'doctor' => $value['doctor'],
               'enddate' => $value['enddate'],
               'regdate' => $value['regdate'],
               'text' => $text,                
        ];
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);     
        return $this->render('/site/ipd-cancer/ipd-cancer-ipd-preview',['mText'=>$this->mText,'names'=>$name,
               'dataProvider'=>$dataProvider, 'date1' =>$d1,'date2' =>$d2]);          
    }
    public function actionCancer2Index() {
        $model = new Formmodel();
        $names="รายงานทะเบียนผู้ป่วยมะเร็งรายใหม่(ผู้ป่วยนอก)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
                 $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=cancer/";   
                 return $this->redirect($url.'cancer2-opd.mrt&d1='.$date1.'&d2='.$date2);  

        }
            return $this -> render('/site/ipd-cancer/cancer2-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }      
    public function actionCancer3Index() {
        $model = new Formmodel();
        $names="อัตราการนอนนานเกิน 45 วัน"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
                 $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=cancer/";   
                 return $this->redirect($url.'cancer3.mrt&d1='.$date1.'&d2='.$date2);  

        }
            return $this -> render('/site/ipd-cancer/cancer-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionCancer4Index() {
        $model = new Formmodel();
        $names="รายงานผู้ที่เสียชีวิตจากมะเร็ง (C00-C970)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
                 $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=cancer/";   
                 return $this->redirect($url.'cancer4.mrt&d1='.$date1.'&d2='.$date2);  
        }
            return $this -> render('/site/ipd-cancer/cancer-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    
}    