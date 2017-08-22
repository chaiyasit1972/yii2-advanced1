<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class KpiAreaController extends Controller
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
    public function actionIndex() {
        $model = new Formmodel();        
        $names="รายงานตัวชี้วัด"; 
        if($model->load(Yii::$app->request->post())){
               $select1 = $model->select1;
               return $this->redirect(['preview59', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);                
        }
              return $this -> render('/site/kpi/kpi-area/index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);        
    }
    public function actionIndex59() {
        $model = new Formmodel();        
        $names="รายงานตัวชี้วัดปีงบประมาณ 2559 เขตสุขภาพที่ 9 นครชัยบุรินทร์"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               return $this->redirect(['preview59', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);                
        }
              return $this -> render('/site/kpi/kpi-area/index-59',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);        
    }
     public function actionPreview59($name,$d1,$d2) {
       $names = $name;
       $date1 = $d1;$date2 = $d2;
       $rawData = [];
       $sql1A="select  sum(total) as cc from
                    (
                      select count(*) total from vn_stat o1 inner join ovstdiag o2 on o1.vn=o2.vn 
                             where o1.vstdate between '{$date1}' and '{$date2}' and (o1.pdx between 'I210' and 'I2139') 
                             and (o2.icd10 = '9910' or o2.icd10 = '3768')
                    union 
                      select count(*) total from an_stat i1 inner join iptdiag i2 on i1.an=i2.an 
		where i1.dchdate between '{$date1}' and '{$date2}' and (i1.pdx between 'I210' and 'I2139') 
		and (i2.icd10 = '9910' or i2.icd10 = '3768')
                    ) as cc";
       $result1A = \Yii::$app->db1->createCommand($sql1A)->queryScalar();   
       $sql1B="select  sum(total) as cc from
                    (
                      select count(*) total from vn_stat o1 
                      where o1.vstdate between '{$date1}' and '{$date2}' and (o1.pdx between 'I210' and 'I2139') 
                    union 
                      select count(*) total from an_stat a
		where a.dchdate between '{$date1}' and '{$date2}' and (a.pdx between 'I210' and 'I2139') 
                    ) as cc";    
       $result1B = \Yii::$app->db1->createCommand($sql1B)->queryScalar();          
       $result1 = ($result1A/$result1B)*100;
       $rawData[] = [
             'id' => '1',
             'pname' => 'ร้อยละของผู้ป่วยกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน (STEMI) ได้รับยาละลายลิ่มเลือด 
                              และ/หรือการขยายหลอดเลือดหัวใจ (PPCI) ร้อยละ 75',
             'goal' => '',
             'result' => $result1A,
             'total' => $result1,                                                               
       ];
       $sql2A = "select count(*) cc from ipt i inner join an_stat i1 on i.an=i1.an
                     where i.dchdate between '{$date1}' and '{$date2}' and i.dchtype in ('08','09') and i1.pdx between 'I210' and 'I2139';";
       $result2A = \Yii::$app->db1->createCommand($sql2A)->queryScalar();   
       $sql2B = "select count(*) cc from an_stat i1
                     where i1.dchdate between '{$date1}' and '{$date2}' and i1.pdx between 'I210' and 'I2139';";
       $result2B = \Yii::$app->db1->createCommand($sql2B)->queryScalar();          
       $result2 = ($result2A/$result2B)*100;                     
       $rawData[] = [
             'id' => '2',
             'pname' => 'ร้อยละของผู้ป่วยกล้ามเนื้อหัวใจขาดเลือดเฉียบพลัน (STEMI) เสียชีวิตในโรงพยาบาลน้อยกว่าร้อยละ 10',
             'goal' => '<10%',
             'result' => $result2A,
             'total' => $result2,                                                               
       ];              
       $rawData[] = [
             'id' => '3',
             'pname' => 'ร้อยละการได้รับ Thrombolytic agent ภายใน 4.5 ชั่วโมง ตั้งแต่เริ่มมีอาการภาวะหลอดเลือดสมองตีบมากกว่าร้อยละ 3',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];           
       $sql4A="select count(*) cc from an_stat a inner join iptdiag i on a.an=i.an
                     where a.dchdate between '{$date1}' and '{$date2}' and a.pdx like 'I63%' and a.age_y >= '15' and i.icd10='9910';";
       $result4A = \Yii::$app->db1->createCommand($sql4A)->queryScalar();      
       $sql4B = "select count(*) cc from an_stat a 
                     where a.dchdate between '{$date1}' and '{$date2}' and a.pdx like 'I63%' and a.age_y >= '15' ;";
       $result4B = \Yii::$app->db1->createCommand($sql4B)->queryScalar();          
       $result4 = ($result4A/$result4B)*100;          
       $rawData[] = [
             'id' => '4',
             'pname' => 'โรงพยาบาลระดับ A มี stroke unit ร้อยละ 100 และระดับ S มี stroke unitร้อยละ 50',
             'goal' => '>3%',
             'result' => $result4A,
             'total' => $result4,                                                               
       ];               
       $rawData[] = [
             'id' => '5',
             'pname' => 'สัดส่วนของผู้ป่วยมะเร็งเต้านมและมะเร็งปากมดลูกระยะที่ 1 และ 2 ไม่น้อยกว่า ร้อยละ 70',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ]; 
       $rawData[] = [
             'id' => '6',
             'pname' => 'ร้อยละของผู้ป่วยมะเร็งเต้านมและมะเร็งปากมดลูกที่มีระยะเวลาการรอคอยการรักษาด้วยรังสี ≤6 สัปดาห์ มากกว่าร้อยละ 70',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ];
       $sql7A = "select count(*) cc from death d where d.death_date between '{$date1}' and '{$date2}' and d.death_cause='20' ;";
       $result7A = \Yii::$app->db1->createCommand($sql7A)->queryScalar();
       $result7B=70922; // ประชากรกลางปี
       $result7=($result7A/$result7B)*100000;
       $rawData[] = [
             'id' => '7',
             'pname' => ' อัตราตายของอุบัติเหตุทางถนนไม่เกิน 16 ต่อแสนประชากร (ICD 10=V01-V89)',
             'goal' => '',
             'result' => $result7A,
             'total' => $result7,                                                               
       ];       
       $sql8A = "select count(*) cc from an_stat a inner join ipt i on i.an=a.an where a.dchdate between '{$date1}' and '{$date2}'
                     and a.pdx between 'S0600' and 'S0699' and i.dchtype in ('08','09');";
       $result8A = \Yii::$app->db1->createCommand($sql8A)->queryScalar();      
       $sql8B = "select count(*) cc from an_stat a inner join ipt i on i.an=a.an where a.dchdate between '{$date1}' and '{$date2}'
                     and a.pdx between 'S0600' and 'S0699';";
       $result8B = \Yii::$app->db1->createCommand($sql8B)->queryScalar();          
       $result8 = ($result8A/$result8B)*100;           
       $rawData[] = [
             'id' => '8',
             'pname' => 'อัตราตายผู้ป่วยบาดเจ็บต่อสมองลดลง (Fatality Rate)',
             'goal' => '',
             'result' => $result8A,
             'total' => $result8,                                                               
       ];     
       $sql9A = "select count(*) cc from ipt_labour_infant ilf left outer join ipt_labour il on ilf.ipt_labour_id=il.ipt_labour_id
                     left outer join ipt_pregnancy ip on ip.an=il.an where birth_date between '{$date1}' and '{$date2}' 
                     and ilf.infant_dchstts in ('04','05');";
       $result9A = \Yii::$app->db1->createCommand($sql9A)->queryScalar();      
       $sql9B = "select count(*) cc from bedno where bedtype = '15';";    // จำนวนเตียง NICU
       $result9B = \Yii::$app->db1->createCommand($sql9B)->queryScalar();           
       $result9 = ($result9A/$result9B);                             
       $rawData[] = [
             'id' => '9',
             'pname' => 'เพิ่มจำนวนเตียง NICU อัตราส่วน 1:500 Live birth ในโรงพยาบาลระดับ A และ S',
             'goal' => '',
             'result' => $result9A,
             'total' => $result9,                                                               
       ]; 
       $sql10A = "select count(*) cc from ipt i inner join an_stat a on i.an=a.an
                      where dchtype in ('08','09') and dchstts in ('08','09') and a.dchdate between '{$date1}' and '{$date2}'
                      and (a.age_y < 1 and a.age_m < 1 and a.age_d <=28) and i.bw < 2500;";
       $result10A = \Yii::$app->db1->createCommand($sql10A)->queryScalar();      
       $sql10B = "select count(*) cc from ipt_labour_infant ilf left outer join ipt_labour il on ilf.ipt_labour_id=il.ipt_labour_id 
                       left outer join ipt_pregnancy ip on ip.an=il.an
                       where ilf.birth_date between '{$date1}' and '{$date2}' and ilf.infant_dchstts in ('04','05') and ilf.birth_weight < 2500;";    
       $result10B = \Yii::$app->db1->createCommand($sql10B)->queryScalar();           
       $result10 = ($result10A/$result10B);                        
       $rawData[] = [
             'id' => '10',
             'pname' => 'อัตราตายทารกอายุน้อยกว่า 28 วัน ≤ 5 ต่อทารกเกิดมีชีพ 1,000 ราย',
             'goal' => '',
             'result' => $result10A,
             'total' => $result10,                                                               
       ]; 
       $sql11A = "select count(*) from ovstdiag where vstdate between '{$date1}' and '{$date2}' and icd10 between 'F200' and 'F299';";
       $result11A = \Yii::$app->db1->createCommand($sql11A)->queryScalar();      
       $result11B = (70922/100)*0.8; // (ประชากรกลางปี 2557 / 100)*0.8,16117,70922
       $result11 = ($result11A/$result11B)*100;       
       $rawData[] = [
             'id' => '11',
             'pname' => 'ผู้ป่วยโรคจิตเข้าถึงบริการ ร้อยละ 55',
             'goal' => '55 %',
             'result' => $result11A,
             'total' => $result11,                                                               
       ]; 
       $sql12A = "select count(*) from ovstdiag where vstdate between '2009-10-01' and '{$date2}' 
                     and (icd10 like 'F32%' or icd10 like 'F33%' or icd10 like 'F341%' or icd10 like 'F38%' or icd10 like 'F39%') ;";
       $result12A = \Yii::$app->db1->createCommand($sql12A)->queryScalar();      
       $result12B = (2.7/100)*70922; // (ประชากรกลางปี 2557 / 100)*0.8,16117,70922
       $result12 = ($result12A/$result12B)*100;           
       $rawData[] = [
             'id' => '12',
             'pname' => 'ผู้ป่วยโรคซึมเศร้าเข้าถึงบริการ ร้อยละ 43',
             'goal' => '43 %',
             'result' => $result12A,
             'total' => $result12,                                                               
       ];        
       
       $rawData[] = [
             'id' => '13',
             'pname' => 'เพิ่มอัตราบริการเข้าถึงสุขภาพช่องปากในทุกกลุ่มวัยมากกว่าร้อยละ 40',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ]; 

       $rawData[] = [
             'id' => '14',
             'pname' => 'รพ.สต.จัดบริการสุขภาพช่องปากที่มีคุณภาพ ไม่น้อยกว่าร้อยละ 55',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ]; 
       $sql15 = ";";
       
       $rawData[] = [
             'id' => '15',
             'pname' => 'Blinding cataract ได้รับการผ่าตัดภายใน 30 วัน มากกว่าร้อยละ 80',
             'goal' => '> 80%',
             'result' => '',
             'total' => '',                                                               
       ]; 

       $rawData[] = [
             'id' => '16',
             'pname' => 'โรงพยาบาลระดับ A , S , M1 – M2 มีการจัดบริการ CKD Clinic ที่มี Function 
                               ครบตามกาหนด ร้อยละ 100 โรงพยาบาลระดับ F1 - F3 มีการจัดบริการ CKD Clinic ที่มี Function ครบตามกาหนดร้อยละ 80',
             'goal' => '80 %',
             'result' => '',
             'total' => '',                                                               
       ]; 

       $rawData[] = [
             'id' => '17',
             'pname' => 'อัตราส่วนการตายมารดา ไม่เกิน 15 ต่อการเกิดมีชีพแสนคน',
             'goal' => '< 15',
             'result' => '',
             'total' => '',                                                               
       ]; 

       $rawData[] = [
             'id' => '18',
             'pname' => 'โรงพยาบาลระดับ M1–M2 ทุกแห่งสามารถผ่าตัดไส้ติ่งได้และผ่าตัดได้ร้อยละ 25 ของ case ที่มีในจังหวัด',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ]; 
       $sql19A = "select count(DISTINCT(a.hn)) cc  from death a 
                      where ((a.death_diag_1 between 'A40' and 'A4199') or a.death_diag_1 like 'R651%' or a.death_diag_1 like 'R572%') 
                      and a.death_date between '{$date1}' and '{$date2}';";
       $result19A = \Yii::$app->db1->createCommand($sql19A)->queryScalar();       
       $sql19B = "select count(DISTINCT(a.hn)) cc  from an_stat a 
                      where ((a.pdx between 'A40' and 'A4199') or a.pdx like 'R651%' or a.pdx like 'R572%') 
                      and a.dchdate between '{$date1}' and '{$date2}';"; 
       $result19B = \Yii::$app->db1->createCommand($sql19B)->queryScalar();          
       $result19B = \Yii::$app->db1->createCommand($sql19B)->queryScalar();           
       $result19 = ($result19A/$result19B)*100;           
       $rawData[] = [
             'id' => '19',
             'pname' => 'อัตราเสียชีวิตในผู้ป่วย Severe Sepsis / Septic shock รายใหม่น้อยกว่าร้อยละ 30',
             'goal' => '< 30%',
             'result' => $result19A,
             'total' => $result19,                                                               
       ]; 

       $rawData[] = [
             'id' => '20',
             'pname' => 'ผู้ป่วยเด็กที่ใส่ท่อช่วยหายใจและส่งต่อมาที่โรงพยาบาล ระดับ A และ S ได้รับการดูแลถูกต้องตาม Care map ร้อยละ 80',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ]; 

       $rawData[] = [
             'id' => '21',
             'pname' => 'อัตราการส่งต่อผู้ป่วย Adjust RW น้อยกว่า 0.5 จาก รพช.แม่ข่าย ไป รพศ./รพท.ลดลง จากปีที่ผ่านมา ร้อยละ 10',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ]; 

       $rawData[] = [
             'id' => '22',
             'pname' => 'โรงพยาบาลของรัฐมีการจัดให้บริการทางการแพทย์แผนไทยคู่ขนานแผนกผู้ป่วยนอกของโรงพยาบาล (OPD) 
                               คู่ขนาน ไม่น้อยกว่าร้อยละ 70',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ]; 

       $rawData[] = [
             'id' => '23',
             'pname' => 'ร้อยละของอาเภอที่มีระดับความสาเร็จการดาเนินงาน District Health System – Primary Care Award (DHS-PCA)
                              ที่เชื่อมโยงระบบบริการปฐมภูมิกับชุมชนและท้องถิ่นอย่างมีคุณภาพ ระดับ ๓ ขึ้นไป (ร้อยละ ๘๕)',
             'goal' => '',
             'result' => '',
             'total' => '',                                                               
       ]; 
       $sql24A = "select  count(*) cc
                        from 
                            (select c.hn,max(v.vn) vn,max(v.vstdate) vstdate from clinicmember c left outer join vn_stat v on c.hn=v.hn 
                                where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('1','3') 
                                group by v.hn order by v.hn,v.vstdate
                            ) a 
                            inner join 
                            (select lh.lab_order_number,lh.vn,lh.order_date,lo.lab_items_code,lo.lab_order_result from lab_head lh
                                left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number where lo.lab_items_code='193'
                            ) b
                            on a.vn=b.vn     
                        where b.lab_order_result < 7 ;";
       $result24A = \Yii::$app->db1->createCommand($sql24A)->queryScalar();      
       $sql24B = "select count(*) cc from clinicmember c left outer join vn_stat v on c.hn=v.hn 
                       left outer join patient p on p.hn=c.hn
                       where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='001' and c.clinic_member_status_id in ('1','3') 
	          and ((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  
                         or p.moopart in ('','0','00'))) or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                         and (p.moopart between '29' and '34' or p.moopart in ('','0','00'))))   ;";
       $result24B = \Yii::$app->db1->createCommand($sql24B)->queryScalar();           
       $result24 = ($result24A/$result24B)*100;                               
       $rawData[] = [
             'id' => '24',
             'pname' => 'ผู้ป่วยเบาหวานสามารถควบคุมระดับน้าตาลได้ร้อยละ 40',
             'goal' => '40 %',
             'result' =>$result24A,
             'total' => $result24,                                                               
       ]; 

       $rawData[] = [
             'id' => '25',
             'pname' => 'ผู้ป่วยความดันโลหิตสูงสามารถควบคุมความดันโลหิตสูงได้ ร้อยละ 50',
             'goal' => '50 %',
             'result' => '',
             'total' => '',                                                               
       ]; 
       $sql26A = "select count(*) cc from an_stat v inner join death d on v.hn=d.hn where d.death_diag_1 between 'J440' and 'J4499' 
                      and v.dchdate between '{$date1}' and '{$date2}' and substr(v.aid,1,4)='3104' ;";
       $result26A = \Yii::$app->db1->createCommand($sql26A)->queryScalar();                         
       $sql26B = "select count(*) cc from death where death_date between '{$date1}' and '{$date2}' ;";
       $result26B = \Yii::$app->db1->createCommand($sql26B)->queryScalar();           
       $result26 = ($result26A/$result26B)*100;        
       $rawData[] = [
             'id' => '26',
             'pname' => 'อัตราตายของผู้ป่วย COPD ที่รับไว้รักษาในโรงพยาบาลน้อยกว่าร้อยละ 4',
             'goal' => '< 4%',
             'result' => $result26A,
             'total' => $result26,                                                               
       ]; 
       $sql27A = "select count(*) cc from an_stat  where dchdate between '{$date1}' and '{$date2}' and age_y >= '15'
                       and pdx between 'J440' and 'J449' and substr(aid,1,4)='3104';";
       $result27A = \Yii::$app->db1->createCommand($sql27A)->queryScalar();  
       $sql27B = "select mid_year from mid_year_population where year='2559';";
       $result27B =  \Yii::$app->db->createCommand($sql27B)->queryAll();
       foreach ($result27B as $value27B) {
                    $mid_year = $value27B['mid_year'];
       }
       $result27 = ($result27A/$mid_year)*100000; 
       $rawData[] = [
             'id' => '27',
             'pname' => 'อัตราการรับไว้รักษาในโรงพยาบาลของผู้ป่วย COPD น้อยกว่า 130 ต่อ 100,000ประชากรกลางปี',
             'goal' => '130',
             'result' => $result27A,
             'total' => $result27,                                                               
       ];        
       
       
       
       
        $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => $rawData,
                'pagination' => [
                    'pageSize' => 30,
                ],
        ]);          
        return $this->render('/site/kpi/kpi-area/preview-59',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2]);       
    }


    
    
    
    
}