<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class SukaController extends Controller
{
    public $mText = "งานสุขาภิบาลและป้องกันโรค";
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
        $names="งานสุขาภิบาลและป้องกันโรค"; 
         return $this -> render('/site/suka/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionSuka1Index() {
        $model = new Formmodel();             
        $names="รายงาน 506";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=suka/"; 
                return $this->redirect($url.'suka1.mrt&d1='.$date1.'&d2='.$date2);
        }   
            return $this -> render('/site/suka/suka1-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);
    }  
    public function actionSuka2Index()
    {
        $names = "รายงานผู้ป่วยโรคเรื้อรังในเขตรับผิดชอบ";
        $sql1="select concat(village_id,',',village_moo,',',if(village_moo=0,'ทั้งหมด ในเขตรับผิดชอบ',village_name)) id,if(village_moo=0,'ทั้งหมด ในเขตรับผิดชอบ',village_name) names 
                  from village  order by village_id;";
        $locations = \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','names');        
        if(Yii::$app->request->post()){
            $date1 = Yii::$app->request->post('date1');
            $type = Yii::$app->request->post('type');            
            $village=Yii::$app->request->post('village');
            return $this->redirect(['suka2_preview', 'name'=>$names, 'd1'=>$date1, 't' => $type, 'v1'=>$village]);
        }
         return $this->render('/site/suka/suka2-index',['mText' => $this->mText,'names' => $names,'data'=>$listData]);       
    } 
   public function actionSuka2_preview($name, $d1, $t, $v1) {
        $names=$name;
        $date1=$d1;
        $type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];        
        $village=  explode(',',$v1);$village_id=$village[0];$village_moo=$village[1];$village_name=$village[2];
        switch ($village_moo) {
            case 0: // ทั้งหมดในเขตรับผิดชอบ คือ village_moo =1 - 34, village_id != 9                
                switch ($type_c) {
                      case 1: //COPD
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate,
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'J440' and 'J449' and ps.village_id != 9  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";
                      break;
                      case 2: // ASTHMA
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'J450' and 'J459' and ps.village_id != 9  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";

                      break;
                      case 3: // CVA
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'I600' and 'I699' and ps.village_id != 9  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";
                      break;
                      case 4: // KIDNEY
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'N180' and 'N189' and ps.village_id != 9  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";

                      break;                  
                      case 5: // DM
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'E100' and 'E149' and ps.village_id != 9  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";
                      break;       
                      case 6: // CHF
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'I500' and 'I509' and ps.village_id != 9  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";
                      break;                    
                      default:
                      break;
                }
            break;
            default:
                    // หมู่ตาม village_id
                switch ($type_c) {
                      case 1: // COPD
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'J440' and 'J449' and ps.village_id = '{$village_id}'
                                         and ps.death != 'Y' group by p.cid order by ps.village_id;";
                                         
                      break;
                      case 2: // ASTHMA
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'J450' and 'J459' and ps.village_id = '{$village_id}'
                                         and ps.death != 'Y' group by p.cid order by ps.village_id;";

                      break;
                      case 3: // CVA
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'I600' and 'I699' and ps.village_id = '{$village_id}'
                                         and ps.death != 'Y' group by p.cid order by ps.village_id;";
                      break;
                      case 4: // KIDNEY
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'N180' and 'N189' and ps.village_id = '{$village_id}'
                                         and ps.death != 'Y' group by p.cid order by ps.village_id;";
                      break;                  
                      case 5: // DM
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'E100' and 'E149' and ps.village_id = '{$village_id}'
                                         and ps.death != 'Y' group by p.cid order by ps.village_id;";
                      break;          
                      case 6: // CHF
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10, i.name diag, min(o.vstdate) vstdate, 
                                         timestampdiff(year,p.birthday,curdate()) age_y from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         left outer join icd101 i on i.code=o.icd10
                                         where o.icd10 between 'I500' and 'I509' and ps.village_id = '{$village_id}'
                                         and ps.death != 'Y' group by p.cid order by ps.village_id;";
                      break;                       
                      default:
                      break;
                }                
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
        return $this -> render('/site/suka/suka2-preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'moo' => $village_name, 'type' => $type_n]);            
    }            
}    

