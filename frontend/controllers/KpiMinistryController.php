<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class KpiMinistryController extends Controller
{
    public $mText = "รายงานตัวชี้วัด";
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
    public function actionIndex59() {
        $model = new Formmodel();        
        $names="รายงานตัวชี้วัดกระทรวง ปีงบประมาณ 2559";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               return $this->redirect(['preview59', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);                
        }
              return $this -> render('/site/kpi/kpi-ministry/index-59',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);        
    }
    public function actionPreview59($name,$d1,$d2) {
       $names = $name;
       $date1 = $d1;$date2 = $d2;
       $rawData = [];
 
       $rawData[] = [
             'id' => '1',
             'pname' => 'อัตราส่วนการตายมารดา(ไม่เกิน 15ต่อการเกิดมีชีพแสนคน)',
             'goal' => '< 15 ',
             'result' => '',
             'total' => '',                                                               
       ];        
       $sql2A = "select sum(cc) as total from 
                    (
                        select  count(*) cc from person_wbc_nutrition  
                        where nutrition_date between '{$date1}' and '{$date2}' and person_nutrition_childdevelop_type_id = '1' 
                       union 
                        select count(*) cc from person_epi_nutrition 
                        where nutrition_date between '{$date1}' and '{$date2}' and person_nutrition_childdevelop_type_id = '1' 
                    ) as df;";
       $result2A = \Yii::$app->db1->createCommand($sql2A)->queryScalar();    
       $sql2B = "select sum(cc) as total from 
                    (
                        select  count(*) cc from person_wbc_nutrition  
                        where nutrition_date between '{$date1}' and '{$date2}' and person_nutrition_childdevelop_type_id between '1' and '3' 
                       union 
                        select count(*) cc from person_epi_nutrition 
                        where nutrition_date between '{$date1}' and '{$date2}' and person_nutrition_childdevelop_type_id between '1' and '3' 
                    ) as df;";
       $result2B = \Yii::$app->db1->createCommand($sql2B)->queryScalar();           
       $result2 = ($result2A/$result2B)*100;                         
       $rawData[] = [
             'id' => '2',
             'pname' => 'ร้อยละของเด็กอายุ 0 - 5 ปี มีพัฒนาการสมวัย (ไม่น้อยกว่าร้อยละ 85)',
             'goal' => '>= 85%',
             'result' => $result2A,
             'total' => $result2,                                                               
       ];            
       $sql3A = "select count(*) cc from village_student_screen
                     where screen_date between '{$date1}' and '{$date2}' and age_y between '5' and '14' 
                     and body_weight is not null and height is not null and bmi_level in ('5','6');";
       $result3A = \Yii::$app->db1->createCommand($sql3A)->queryScalar();    
       $sql3B = "select count(*) cc from village_student_screen
                     where screen_date between '{$date1}' and '{$date2}' and age_y between '5' and '14' 
                     and body_weight is not null and height is not null ;";
       $result3B = \Yii::$app->db1->createCommand($sql3B)->queryScalar();    
       $result3 = ($result3A/$result3B)*100;              
       $rawData[] = [
             'id' => '3',
             'pname' => 'เด็กนักเรียนเริ่มอ้วนและอ้วน (ไม่เกินร้อยละ 10 ภายในปี 2560)',
             'goal' => '< 10%',
             'result' => $result3A,
             'total' => $result3,                                                                 
       ];            
     
       $rawData[] = [
             'id' => '4',
             'pname' => 'อัตราการเสียชีวิตจากการจมน้าของเด็กอายุต่ ากว่า 15 ปี (ไม่เกิน 6.5 ต่อประชากรเด็กอายุต่ำกว่า 15 ปี แสนคน)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];        
       $sql5A = "select count(*) cc from ipt_labour il 
                     left outer join ipt_labour_infant ili on il.ipt_labour_id=ili.ipt_labour_id 
                     left outer join an_stat a on il.an=a.an 
                     where ili.infant_dchstts in ('04','05') and  ili.birth_date between '{$date1}' and '{$date2}' and a.age_y between '15' and '19' ;";
       $result5A = \Yii::$app->db1->createCommand($sql5A)->queryScalar();       
       $result5B = "";//จ านวนหญิงอายุ 15 - 19 ปี ทั้งหมด (จำนวนประชากรกลางปีจากฐานข้อมูลทะเบียนราษฎร์)
       $result5 = ($result3A/$result3B)*100;            
       $rawData[] = [
             'id' => '5',
             'pname' => 'อัตราการคลอดมีชีพในหญิงอายุ 15-19 ปี (ไม่เกิน 50 ต่อประชากรหญิงอายุ 15-19 ปี พันคน ภายในปี 2561)',
             'goal' => '',
             'result' => $result5A,
             'total' => '',                                                               
       ];            
       
       $rawData[] = [
             'id' => '6',
             'pname' => 'ความชุกผู้บริโภคเครื่องดื่มแอลกอฮอล์ในประชากรอายุ 15 – 19 ปี 
                              (ไม่เพิ่มขึ้นจากผลการเฝ้าระวังพฤติกรรมเสี่ยง (BSS) ในปี 2558)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];   

       $rawData[] = [
             'id' => '7',
             'pname' => 'อัตราตายจากอุบัติเหตุทางถนน (ไม่เกิน 16 ต่อประชากร แสนคน ในปีงบประมาณ 2559)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];        
       $sql8A = "select count(*) cc from death where death_diag_1 between 'I20' and 'I259' and death_date between '{$date1}' and '{$date2}';";
       $result8A = \Yii::$app->db1->createCommand($sql8A)->queryScalar();         
       $result8B = 70922;
       $result8 = ($result8A/$result8B)*100000;          
       $rawData[] = [
             'id' => '8',
             'pname' => 'อัตราตายจากโรคหลอดเลือดหัวใจ (ลดลง ร้อยละ 10 ภายในปี 2562)',
             'goal' => '10 %',
             'result' => $result8A,
             'total' => $result8,                                                               
       ];            
       
       $rawData[] = [
             'id' => '9',
             'pname' => 'ร้อยละของผู้สูงอายุต้องการความช่วยเหลือในการด าเนิน กิจวัตรประจำวันพื้นฐาน (ไม่เกินร้อยละ 15)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];   

       $rawData[] = [
             'id' => '10',
             'pname' => 'ร้อยละของอ าเภอที่มี District Health System (DHS) ที่เชื่อมโยงระบบบริการปฐมภูมิกับชุมชนและท้องถิ่น 
                              อย่างมีคุณภาพ (ไม่น้อยกว่าร้อยละ 85)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];        
       
       $rawData[] = [
             'id' => '11',
             'pname' => 'ตำบลจัดการสุขภาพแบบบูรณาการ (ร้อยละ 70)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];            
       
       $rawData[] = [
             'id' => '12',
             'pname' => 'การส่งต่อผู้ป่วยออกนอกเขตสุขภาพลดลง (ร้อยละ 50)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];   

       $rawData[] = [
             'id' => '13',
             'pname' => 'ร้อยละของอำเภอที่สามารถควบคุมโรคติดต่อสำคัญของ พื้นที่ได้ (ร้อยละ 50)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];        
       
       $rawData[] = [
             'id' => '14',
             'pname' => 'ระดับความสำเร็จของการดำเนินงานคุ้มครองผู้บริโภค ด้านผลิตภัณฑ์สุขภาพและบริการสุขภาพ (ระดับ 5)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];            
       
       $rawData[] = [
             'id' => '15',
             'pname' => 'ร้อยละของผู้ป่วยยาเสพติดที่หยุดเสพต่อเนื่อง 3 เดือน หลังจำหน่ายจากการบำบัดรักษา (3 month remission rate) (ร้อยละ 92 )',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];   

       $rawData[] = [
             'id' => '16',
             'pname' => 'มีเครือข่ายนักกฎหมายที่เข้มแข็งและบังคับใช้กฎหมาย ในเรื่องที่สำคัญ',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];        
       
       $rawData[] = [
             'id' => '17',
             'pname' => 'ร้อยละ 50 ของจังหวัดมีระบบการจัดการปัจจัยเสี่ยงและ สุขภาพผ่านเกณฑ์ในระดับดีขึ้นไป',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];            
       
       $rawData[] = [
             'id' => '18',
             'pname' => 'ร้อยละของจังหวัดในเขตสุขภาพที่ผ่านเกณฑ์คุณภาพ การบริหารจัดการการพัฒนาบุคลากร (ร้อยละ 70)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];   

       $rawData[] = [
             'id' => '19',
             'pname' => 'ประสิทธิภาพของการบริหารการเงินสามารถควบคุม ปัญหาการเงินระดับ 7 ของหน่วยบริการในพื้นที่ (ไม่เกินร้อยละ 10)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];        
       
       $rawData[] = [
             'id' => '20',
             'pname' => 'มูลค่าการจัดซื้อร่วมยาและเวชภัณฑ์ฯ ของหน่วยงาน (ร้อยละ 20)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];            
       
       $rawData[] = [
             'id' => '21',
             'pname' => ' ร้อยละของหน่วยงานในสังกัด กสธ.ผ่านเกณฑ์ประเมิน ระดับคุณธรรมและความโปร่งใสในการดำเนินงานของ
                                หน่วยงาน เฉพาะหลักฐ',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];   
       
       
        $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 30,
                ],
        ]);          
        return $this->render('/site/kpi/kpi-ministry/preview-59',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2]);       
    }


    
    
    
    
}