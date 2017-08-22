<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class PracticeController extends Controller
{
    public $mText = "งานเวชปฎิบัติชุมชนและครอบครัว";
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
        $names="งานเวชปฎิบัติชุมชนและครอบครัว"; 
         return $this -> render('/site/practice/index',['mText'=>$this->mText,'names'=>$names]);
    } 
     public function actionPractice1Index()
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
            return $this->redirect(['practice1_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2,'t1'=>$type,'v1'=>$village]);
        }
         return $this->render('/site/practice/practice1-index',['mText' => $this->mText,'names' => $names,
                                    'data'=>$listData, 'model' => $model]);       
    }
    public function actionPractice1_preview($name,$d1,$d2,$t1,$v1) {
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
                'pageSize' => 10,
                ],
        ]);  
        return $this -> render('/site/practice/practice1-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2,'type_n'=>$type_n,
                                    'village_moo'=>$village_moo,'village_name'=>$village_name]);                                
    }    
    public function actionPractice2Index()
    {
        $model = new Formmodel();
        $names = "รายงานข้อมูลทั่วไป/ผลการประเมิณ/คัดกรองภาวะสุขภาพในผู้สูงอายุ";     
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
            return $this->redirect(['practice2_preview', 'name' => $names, 'd1' => $date1, 'd2' => $date2]);
        }
         return $this->render('/site/practice/practice2-index',['mText' => $this->mText, 'names' => $names, 'model' => $model]);       
    } 
    public function actionPractice2_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $rawData=array();
        $rawData[]=[
            'id'=>1,
            'names'=>'จำนวนหมู่บ้านทั้งหมด',
            'units'=>'หมู่',
            'total'=>'34'
        ];
        $sql1="select count(*) cc from person where house_regist_type_id in ('1','3') and age_y >= 60 and village_id !='9' and death !='Y';";
        $total1 = \Yii::$app->db1->createCommand($sql1)->queryScalar();
        $rawData[]=[
            'id'=>2,
            'names'=>'จำนวนผู้สูงอายุในพื้นที่รับผิดชอบทั้งหมด',
            'units'=>'คน',
            'total'=>  number_format($total1)
        ];
        $rawData[]=[
            'id'=>3,
            'names'=>'จำนวนชมรมผู้สูงอายุทั้งหมด',
            'units'=>'ชมรม',
            'total'=>'1'
        ];
        $rawData[]=[
            'id'=>4,
            'names'=>'จำนวนสมาชิกในชมรมผู้สูงอายุ',
            'units'=>'คน',
            'total'=>'886'
        ];
        $rawData[]=[
            'id'=>5,
            'names'=>'จำนวนชมรมผู้สูงอายุที่ผ่านเกณฑ์คุณภาพ',
            'units'=>'ชมรม',
            'total'=>'1'
        ];
        $rawData[]=[
            'id'=>6,
            'names'=>'จำนวนวัดที่มีทั่งหมด',
            'units'=>'วัด',
            'total'=>'14'
        ];   
        $rawData[]=[
            'id'=>7,
            'names'=>'จำนวนวัดที่ผ่านเกณฑ์ประเมินวัดส่งเสริมสุขภาพ',
            'units'=>'วัด',
            'total'=>'-'
        ];
        $rawData[]=[
            'id'=>8,
            'names'=>'จำนวนอาสาสมัครดูแลผู้สูงอายุ(อผส./อสม.)',
            'units'=>'คน',
            'total'=>'120'
        ];
        $rawData[]=[
            'id'=>9,
            'names'=>'จำนวน อผส./อสม. ที่ผ่านการอบรมหลักสูตรดูแลผู้สูงอายุ',
            'units'=>'คน',
            'total'=>'120'
        ];
        $rawData[]=[
            'id'=>10,
            'names'=>'จำนวนเจ้าหน้าที่สาธารณสุขที่ผ่านการอบรมหลักสูตร Care manger',
            'units'=>'คน',
            'total'=>'1'
        ];
        $sql2="select count(*) cc from person_health_club_member where person_health_club_id in ('51','52','53')
                  and (discharge !='Y' or discharge is null);";
        $total2 = \Yii::$app->db1->createCommand($sql2)->queryScalar();        
        $rawData[]=[
            'id'=>11,
            'names'=>'ผู้สูงอายุแบ่งตามความสามารถในการประกอบกิจวัตรประจำวัน(ADL)',
            'units'=>'',
            'total'=> number_format($total2)
        ];
        $sql3="select count(*) cc from person_health_club_member where person_health_club_id in ('53')
                  and (discharge !='Y' or discharge is null);";
        $total3 = \Yii::$app->db1->createCommand($sql3)->queryScalar();           
        $rawData[]=[
            'id'=>12,
            'names'=>'&nbsp;&nbsp;&nbsp;11.1 กลุ่มที่1 ติดสังคม ',
            'units'=>'คน',
            'total'=> number_format($total3)
        ];
        $sql4="select count(*) cc from person_health_club_member where person_health_club_id in ('51')
                  and (discharge !='Y' or discharge is null);";
        $total4 = \Yii::$app->db1->createCommand($sql4)->queryScalar();           
        $rawData[]=[
            'id'=>13,
            'names'=>'&nbsp;&nbsp;&nbsp;11.2 กลุ่มที่2 ติดบ้าน',
            'units'=>'คน',
            'total'=> number_format($total4)
        ];
        $sql5="select count(*) cc from person_health_club_member where person_health_club_id in ('52')
                  and (discharge !='Y' or discharge is null);";
        $total5 = \Yii::$app->db1->createCommand($sql5)->queryScalar();           
        $rawData[]=[
            'id'=>14,
            'names'=>'&nbsp;&nbsp;&nbsp;11.3 กลุ่มที่3 ติดเตียง(ปีงบ 58 มีเพิ่ม 44 คน ตาย 7 คน เหลือ 37 คน)',
            'units'=>'คน',
            'total'=> number_format($total5)
        ];
        $sql6="select count(*) cc from person_dmht_screen_summary p1,person_dmht_risk_screen_head p2,person p3 
                  where p1.person_dmht_screen_summary_id=p2.person_dmht_screen_summary_id and p1.person_id=p3.person_id
                  and p3.age_y >='60' and p3.house_regist_type_id in ('1','3') and p2.screen_date between '{$date1}' and '{$date2}';";
        $total6 = \Yii::$app->db1->createCommand($sql6)->queryScalar();                     
        $rawData[]=[
            'id'=>15,
            'names'=>'ผู้สูงอายุที่ได้รับการคัดกรองโรคความดันโลหิตสูง',
            'units'=>'คน',
            'total'=> number_format($total6)
        ];
        $sql7="select count(*) cc from person_dmht_screen_summary p1,person_dmht_risk_screen_head p2,person p3 
                  where p1.person_dmht_screen_summary_id=p2.person_dmht_screen_summary_id and p1.person_id=p3.person_id
                  and p3.age_y >='60' and p3.house_regist_type_id in ('1','3') and p2.screen_date between '{$date1}' and '{$date2}'
                  and p2.last_bps>=140 and p2.last_bpd>=90 ;";
        $total7 = \Yii::$app->db1->createCommand($sql7)->queryScalar();           
        $rawData[]=[
            'id'=>16,
            'names'=>'&nbsp;&nbsp;&nbsp;12.1 ผู้สูงอายุที่มีระดับความดัน>=140/90 มม. ปรอท',
            'units'=>'คน',
            'total'=> number_format($total7)
        ];
        $sql8="select count(*) cc from person_dmht_screen_summary p1,person_dmht_risk_screen_head p2,person p3 
                  where p1.person_dmht_screen_summary_id=p2.person_dmht_screen_summary_id and p1.person_id=p3.person_id
                  and p3.age_y >='60' and p3.house_regist_type_id in ('1','3') and p2.screen_date between '{$date1}' and '{$date2}';";
        $total8 = \Yii::$app->db1->createCommand($sql8)->queryScalar();             
        $rawData[]=[
            'id'=>17,
            'names'=>'ผู้สูงอายุที่ได้รับการคัดกรองโรคเบาหวาน',
            'units'=>'คน',
            'total'=> number_format($total8)
        ];
        $sql9="select count(*) cc from person_dmht_screen_summary p1,person_dmht_risk_screen_head p2,person p3 
                  where p1.person_dmht_screen_summary_id=p2.person_dmht_screen_summary_id and p1.person_id=p3.person_id
                  and p3.age_y >='60' and p3.house_regist_type_id in ('1','3') and p2.screen_date between '{$date1}' and '{$date2}'
                  and p2.last_fgc >=126 ;";
        $total9 = \Yii::$app->db1->createCommand($sql9)->queryScalar();            
        $rawData[]=[
            'id'=>18,
            'names'=>'&nbsp;&nbsp;&nbsp;13.1 ผู้สูงอายุที่มีค่าพลาสมากลูโคสขณะลดอาหาร>=126มก./ดล.',
            'units'=>'คน',
            'total'=> number_format($total9)
        ];  
        $rawData[]=[
            'id'=>19,
            'names'=>'ผู้สูงอายุที่ได้รับการตรวจสุขภาพช่องปาก',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>20,
            'names'=>'&nbsp;&nbsp;&nbsp;14.1 มีฟันใช้งานได้อย่างน้อย 20 ซี่ หรือ 4 คู่สบ (รวมฟันแท้และฟันเทียม)',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>21,
            'names'=>'ผู้สูงอายุที่ได้รับการคัดกรองสุขภาวะทางตา',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>22,
            'names'=>'&nbsp;&nbsp;&nbsp;15.1 ผู้สุงอายุที่ทีปัญหาการมองเห็น',
            'units'=>'คน',
            'total'=>''
        ];
        $sql14="select count(*) cc from depression_screen dp left outer join patient_depression pd on 
                    dp.patient_depression_id=pd.patient_depression_id left outer join person p on p.patient_hn=pd.hn
                    left outer join vn_stat v on dp.vn=v.vn  where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}'
                    and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and v.age_y >='60' 
                    and house_regist_type_id in ('1','3') and p.village_id !='9' ;";
        $total14 = \Yii::$app->db1->createCommand($sql14)->queryScalar();                              
        $rawData[]=[
            'id'=>23,
            'names'=>'ผู้สูงอายุที่ได้รับการคัดกรองโรคซึมเศร้าด้วย 2 คำถาม',
            'units'=>'คน',
            'total'=> number_format($total14)
        ];
        $sql15="select count(*) cc from depression_screen dp left outer join patient_depression pd on 
                    dp.patient_depression_id=pd.patient_depression_id left outer join person p on p.patient_hn=pd.hn
                    left outer join vn_stat v on dp.vn=v.vn  where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}'
                    and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and dp.depression_score >=7  and v.age_y >='60' 
                    and house_regist_type_id in ('1','3') and p.village_id !='9' ;";
        $total15 = \Yii::$app->db1->createCommand($sql15)->queryScalar();          
        $rawData[]=[
            'id'=>24,
            'names'=>'&nbsp;&nbsp;&nbsp;16.1 ผู้สูงอายุที่มีความเสี่ยงหรือมีแนวโน้มที่จะเป็นโรคซึมเศร้า 2.7%',
            'units'=>'คน',
            'total'=> number_format($total15)
        ]; 
        $sql16="select count(*) cc from depression_screen dp left outer join patient_depression pd on 
                    dp.patient_depression_id=pd.patient_depression_id left outer join person p on p.patient_hn=pd.hn
                    left outer join vn_stat v on dp.vn=v.vn  where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}'
                    and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and dp.depression_score >=0  and v.age_y >='60' 
                    and house_regist_type_id in ('1','3') and p.village_id !='9' ;";
        $total16 = \Yii::$app->db1->createCommand($sql16)->queryScalar();           
        $rawData[]=[
            'id'=>23,
            'names'=>'ผู้สูงอายุที่ได้รับการคัดกรองโรคซึมเศร้าด้วย 9 คำถาม',
            'units'=>'คน',
            'total'=> number_format($total16)
        ];
        $sql17="select count(*) cc from depression_screen dp left outer join patient_depression pd on 
                    dp.patient_depression_id=pd.patient_depression_id left outer join person p on p.patient_hn=pd.hn
                    left outer join vn_stat v on dp.vn=v.vn  where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}'
                    and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and dp.depression_score < 7  and v.age_y >='60' 
                    and house_regist_type_id in ('1','3') and p.village_id !='9' ;";
        $total17 = \Yii::$app->db1->createCommand($sql17)->queryScalar();             
        $rawData[]=[
            'id'=>24,
            'names'=>'&nbsp;&nbsp;&nbsp;17.1 ไม่มีอาการของโรคซึมเศร้าหรือมีอาการโรคซึมเศร้าระดับน้อยมาก <7',
            'units'=>'คน',
            'total'=> number_format($total17)
        ]; 
        $sql18="select count(*) cc from depression_screen dp left outer join patient_depression pd on 
                    dp.patient_depression_id=pd.patient_depression_id left outer join person p on p.patient_hn=pd.hn
                    left outer join vn_stat v on dp.vn=v.vn  where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}'
                    and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and dp.depression_score between 7 and 12
                    and v.age_y >='60' and house_regist_type_id in ('1','3') and p.village_id !='9' ;";
        $total18 = \Yii::$app->db1->createCommand($sql18)->queryScalar();           
        $rawData[]=[
            'id'=>25,
            'names'=>'&nbsp;&nbsp;&nbsp;17.2 มีอาการของโรคซึมเศร้าระดับน้อย 7-12',
            'units'=>'คน',
            'total'=> number_format($total18)
        ];
        $sql19="select count(*) cc from depression_screen dp left outer join patient_depression pd on 
                    dp.patient_depression_id=pd.patient_depression_id left outer join person p on p.patient_hn=pd.hn
                    left outer join vn_stat v on dp.vn=v.vn  where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}'
                    and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and dp.depression_score between 13 and 18
                    and v.age_y >='60' and house_regist_type_id in ('1','3') and p.village_id !='9' ;";
        $total19 = \Yii::$app->db1->createCommand($sql19)->queryScalar();               
        $rawData[]=[
            'id'=>26,
            'names'=>'&nbsp;&nbsp;&nbsp;17.3 มีอาการของโรคซึมเศร้าระดับปานกลาง 13-18',
            'units'=>'คน',
            'total'=> number_format($total19)
        ];
        $sql20="select count(*) cc from depression_screen dp left outer join patient_depression pd on 
                    dp.patient_depression_id=pd.patient_depression_id left outer join person p on p.patient_hn=pd.hn
                    left outer join vn_stat v on dp.vn=v.vn  where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}'
                    and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and dp.depression_score >=19
                    and v.age_y >='60' and house_regist_type_id in ('1','3') and p.village_id !='9' ;";
        $total20 = \Yii::$app->db1->createCommand($sql20)->queryScalar();               
        $rawData[]=[
            'id'=>27,
            'names'=>'&nbsp;&nbsp;&nbsp;17.4 มีอาการของโรคซึมเศร้าระดับรุนแรง >=19',
            'units'=>'คน',
            'total'=> number_format($total20)
        ]; 
        $rawData[]=[
            'id'=>28,
            'names'=>'ผู้สูงอายุได้รับการคัดกรองข้อเข่าเสื่อม(Thai-KOA-SQ)เบื้องต้นในชุมชน',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>29,
            'names'=>'&nbsp;&nbsp;&nbsp;18.1 มีภาวะสงสัยหรือมีโอกาสเป็นข้อเข่าเสื่อม M170-M179',
            'units'=>'คน',
            'total'=>''
        ]; 
        $rawData[]=[
            'id'=>30,
            'names'=>'ผู้สูงอายุได้รับการทดสอบสภาพสมองเสื่อม โดยใช้ MMSE-Thai 2002',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>31,
            'names'=>'&nbsp;&nbsp;&nbsp;19.1 เป็นผู้สงสัยว่ามีภาวะสมองเสื่อม(cognitive inpairment)F00-F03',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>32,
            'names'=>'ผู้สูงอายุได้รับการคัดกรองภาวะหกล้ม: Timed Up and Go Test (TUGT)',
            'units'=>'คน',
            'total'=>''
        ]; 
        $rawData[]=[
            'id'=>33,
            'names'=>'&nbsp;&nbsp;&nbsp;20.1 มีความเสี่ยงต่อภาวะหกล้ม W 00- W 19',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>34,
            'names'=>'&nbsp;&nbsp;&nbsp;20.2 เดินไม่ได้',
            'units'=>'คน',
            'total'=>''
        ]; 
        $rawData[]=[
            'id'=>35,
            'names'=>'ผู้สูงอายุที่ได้รับการคัดกรองภาวะกลั้นปัสสาวะ',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>36,
            'names'=>'&nbsp;&nbsp;&nbsp;21.1 มีภาวะกลั้นปัสสาวะไม่อยู่ N 393,N 394',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>37,
            'names'=>'ผู้สูงอายุที่ได้รับการคัดกรองภาวะโภชนาการ:',
            'units'=>'คน',
            'total'=>''
        ]; 
        $rawData[]=[
            'id'=>38,
            'names'=>'&nbsp;&nbsp;&nbsp;22.1 ดัชนีมวลกาย(BMI:Body Mass Index)',
            'units'=>'',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>39,
            'names'=>'&nbsp;&nbsp;&nbsp;22.1.1 ผอม(BMI <18.5)',
            'units'=>'คน',
            'total'=>''
        ]; 
        $rawData[]=[
            'id'=>40,
            'names'=>'&nbsp;&nbsp;&nbsp;22.1.2  ปกติ(BMI=18.5-22.9) ',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>41,
            'names'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;22.1.3  ท้วม(BMi=23.0-24.9)',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>42,
            'names'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;22.1.4  อ้วน(BMI=25.0-29.9)',
            'units'=>'คน',
            'total'=>''
        ]; 
        $rawData[]=[
            'id'=>43,
            'names'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;22.1.5  อ้วนมาก(BMI มากกว่า 30)',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>44,
            'names'=>'&nbsp;&nbsp;&nbsp;22.2 ได้รับการประเมินภาวะโภชนาการ',
            'units'=>'คน',
            'total'=>''
        ]; 
        $rawData[]=[
            'id'=>45,
            'names'=>'&nbsp;&nbsp;&nbsp;22.2.1 มีภาวะโภชนาการปกติ',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>46,
            'names'=>'&nbsp;&nbsp;&nbsp;22.2.2 มีความเสี่ยงต่อการเกิดภาวะทุพโภชนาการ',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>47,
            'names'=>'&nbsp;&nbsp;&nbsp;22.2.3 มีภาวะทุพโภชนาการ(ขาดสารอาหาร)',
            'units'=>'คน',
            'total'=>''
        ]; 
        $rawData[]=[
            'id'=>48,
            'names'=>'ผู้สูงอายุได้รับการประเมินปัญหาการนอน',
            'units'=>'คน',
            'total'=>''
        ];
        $rawData[]=[
            'id'=>49,
            'names'=>'&nbsp;&nbsp;&nbsp;23.1 มีปัญหาการนอนหลับ',
            'units'=>'คน',
            'total'=>''    
        ];    
         $rawData[]=[
            'id'=>50,
            'names'=>'ผู้สูงอายุได้รับการสำรวจพฤติกรรมสุขภาพที่พึงประสงค์',
            'units'=>'คน',
            'total'=>''    
        ];
         $rawData[]=[
            'id'=>51,
            'names'=>'&nbsp;&nbsp;&nbsp;24.1 ผู้สูงอายุที่มีพฤติกรรมสุขภาพที่พึงประสงค์',
            'units'=>'คน',
            'total'=>''       
        ]; 
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 10,
                ],
        ]);          
        return $this->render('/site/practice/practice2-preview',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2]);         
         
    }
    public function actionPractice3Index()
    {
        $model = new Formmodel();
        $names = "รายงานผลการดูแลเฝ้าระวังโรคซึมเศร้าและเสี่ยงต่อการฆ่าตัวตาย";     
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
            return $this->redirect(['practice3_preview', 'name' => $names, 'd1' => $date1, 'd2' => $date2]);
        }
         return $this->render('/site/practice/practice3-index',['mText' => $this->mText, 'names' => $names, 'model' => $model]);       
    }
    public function actionPractice3_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $rawData=array(); 
 	 $sql1="select count(*) num from person where timestampdiff(year,birthdate,curdate()) > 15 and village_id !=9 and 
                          house_regist_type_id in ('1','3') and sex='1' and death='N';";    
	 $sql2="select count(*) num from person where timestampdiff(year,birthdate,curdate()) > 15 and village_id !=9 and
                         house_regist_type_id in ('1','3')  and sex='2' and death='N';";           
               $num1=\Yii::$app->db1->createCommand($sql1)->queryScalar();
               $num2=\Yii::$app->db1->createCommand($sql2)->queryScalar();               
               $rawData[]=array(
                      'id'=>'1',
                      'name'=>'ประชารอายุ 15 ปีขึ้นไปในเขตรับผิดชอบ',
                      'numm'=>$num1,
                      'numf'=>$num2,
               );
	$sql3 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id 
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}'
                           and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='1';";        
	$sql4 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id 
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}'
                           and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='2';";    
               $num3=\Yii::$app->db1->createCommand($sql3)->queryScalar();if(!$num3){ $num3a=0;}else{$num3a=$num3;}
               $num4=\Yii::$app->db1->createCommand($sql4)->queryScalar();if(!$num4){ $num4a=0;}else{$num4a=$num4;} 
               $rawData[]=array(
                      'id'=>'2',
                      'name'=>'ได้รับการคัดกรองโรคซึมเศร้าด้วย 2Q,15Q',
                      'numm'=>$num3a,
                      'numf'=>$num4a,
               );               
               $rawData[]=array(
                      'id'=>'',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;ผู้ที่คัดกรองพบความเสี่ยง(ผล +ve)',
                      'numm'=>$num3a,
                      'numf'=>$num4a,
               ); 
	$sql5 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='1' and dp.depression_score > 0;";  
	$sql6 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='2' and dp.depression_score > 0;";   
               $num5=\Yii::$app->db1->createCommand($sql5)->queryScalar();if(!$num5){ $num5a=0;}else{$num5a=$num5;}
               $num6=\Yii::$app->db1->createCommand($sql6)->queryScalar();if(!$num6){ $num6a=0;}else{$num6a=$num6;}                           
               $rawData[]=array(
                      'id'=>'3',
                      'name'=>'ได้รับการประเมิณโรคซึมเศร้าด้วย 9Q (ผู้ที่ผล 2 Q +ve)',
                      'numm'=>$num5a,
                      'numf'=>$num6a,
               );  
	$sql7 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='1' and dp.depression_score between 7 and 12;";  
	$sql8 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='2' and dp.depression_score between 7 and 12;";   
               $num7=\Yii::$app->db1->createCommand($sql7)->queryScalar();if(!$num7){ $num7a=0;}else{$num7a=$num7;}
               $num8=\Yii::$app->db1->createCommand($sql8)->queryScalar();if(!$num8){ $num8a=0;}else{$num8a=$num8;} 
               $rawData[]=array(
                      'id'=>'',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;จำนวนผู้ที่มีคะแนน  7-12 ระดับน้อย',
                      'numm'=>$num7a,
                      'numf'=>$num8a,
               ); 
	$sql9 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='1' and dp.depression_score between 13 and 18;";  
	$sql10 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='2' and dp.depression_score between 13 and 18;";   
               $num9=\Yii::$app->db1->createCommand($sql9)->queryScalar();if(!$num9){ $num9a=0;}else{$num9a=$num9;}
               $num10=\Yii::$app->db1->createCommand($sql10)->queryScalar();if(!$num10){ $num10a=0;}else{$num10a=$num10;} 
               $rawData[]=array(
                      'id'=>'',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;จำนวนผู้ที่มีคะแนน  13-18 ระดับปานกลาง',
                      'numm'=>$num9a,
                      'numf'=>$num10a,
               );                
	$sql11 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='1' and dp.depression_score >=19;";  
	$sql12 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='2' and dp.depression_score >=19;";   
               $num11=\Yii::$app->db1->createCommand($sql11)->queryScalar();if(!$num11){ $num11a=0;}else{$num11a=$num11;}
               $num12=\Yii::$app->db1->createCommand($sql12)->queryScalar();if(!$num12){ $num12a=0;}else{$num12a=$num12;} 
               $rawData[]=array(
                      'id'=>'',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;จำนวนผู้ที่มีคะแนน >= 19 ระดับมาก',
                      'numm'=>$num11a,
                      'numf'=>$num12a,
               );                 
 	$sql13 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='1' and dp.suicide_score > 0;";  
	$sql14 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='2' and dp.suicide_score > 0;";   
               $num13=\Yii::$app->db1->createCommand($sql13)->queryScalar();if(!$num13){ $num13a=0;}else{$num13a=$num13;}
               $num14=\Yii::$app->db1->createCommand($sql14)->queryScalar();if(!$num14){ $num14a=0;}else{$num14a=$num14;} 
               $rawData[]=array(
                      'id'=>'4',
                      'name'=>'ได้รับการประเมิณการฆ่าตัวตายด้วย 8Q,10Q (9Q>=7)',
                      'numm'=>$num13a,
                      'numf'=>$num14a,
               );                 
 	$sql15 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='1' and dp.suicide_score between 1 and 8;";  
	$sql16 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='2' and dp.suicide_score between 1 and 8;";   
               $num15=\Yii::$app->db1->createCommand($sql15)->queryScalar();if(!$num15){ $num15a=0;}else{$num15a=$num15;}
               $num16=\Yii::$app->db1->createCommand($sql16)->queryScalar();if(!$num16){ $num16a=0;}else{$num16a=$num16;} 
               $rawData[]=array(
                      'id'=>'',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;จำนวนผู้ที่มีคะแนน  1-8 ระดับน้อย',
                      'numm'=>$num15a,
                      'numf'=>$num16a,
               );
 	$sql17 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='1' and dp.suicide_score between 9 and 16;";  
	$sql18 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='2' and dp.suicide_score between 9 and 16;";   
               $num17=\Yii::$app->db1->createCommand($sql17)->queryScalar();if(!$num17){ $num17a=0;}else{$num17a=$num17;}
               $num18=\Yii::$app->db1->createCommand($sql18)->queryScalar();if(!$num18){ $num18a=0;}else{$num18a=$num18;} 
               $rawData[]=array(
                      'id'=>'',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;จำนวนผู้ที่มีคะแนน  9-16 ระดับปานกลาง',
                      'numm'=>$num17a,
                      'numf'=>$num18a,
               );               
 	$sql19 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='1' and dp.suicide_score >= 17;";  
	$sql20 = "select count(*) num from depression_screen dp left outer join patient_depression pd on dp.patient_depression_id=pd.patient_depression_id
                          left outer join patient p on p.hn=pd.hn where substr(dp.screen_datetime,1,10) between '{$date1}' and '{$date2}' 
                          and (dp.feel_depression_2_week = 'Y' or dp.feel_boring_2_week='Y') and p.sex='2' and dp.suicide_score >= 17;";   
               $num19=\Yii::$app->db1->createCommand($sql19)->queryScalar();if(!$num19){ $num19a=0;}else{$num19a=$num19;}
               $num20=\Yii::$app->db1->createCommand($sql20)->queryScalar();if(!$num20){ $num20a=0;}else{$num20a=$num20;} 
               $rawData[]=array(
                      'id'=>'',
                      'name'=>'&nbsp;&nbsp;&nbsp;&nbsp;จำนวนผู้ที่มีคะแนน >= 17 ระดับมาก',
                      'numm'=>$num19a,
                      'numf'=>$num20a,
               );          
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);          
        return $this->render('/site/practice/practice3-preview',['mText'=>$this->mText,'names'=>$names,
                 'dataProvider'=>$dataProvider, 'date1' =>$date1,'date2' =>$date2]);              
    }   
    public function actionPractice4Index()
    {
        $model = new Formmodel();
        $names = "รายงานวัคซีน wbc-vaccine (บัญชี 3 เด็ก 0-11 เดือน 29วัน)";       
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
            return $this->redirect(['practice4_preview', 'name' => $names, 'd1' => $date1, 'd2' => $date2]);
        }
         return $this->render('/site/practice/practice4-index',['mText' => $this->mText, 'names' => $names, 'model' => $model]);       
    }    
    public function actionPractice4_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;      
        $sql1="select p.cid,v.hn,concat(p.pname,p.fname,' ',p.lname) pname,p.birthdate,p4.addrpart,p4.moopart,t1.`name` tmb,t2.name amp,
                  t3.name chw,p1.service_date,w.wbc_vaccine_name
                  from person_wbc_service p1 inner join person_wbc_vaccine_detail p2 on p1.person_wbc_service_id=p2.person_wbc_service_id
                  inner join person_wbc p3 on p3.person_wbc_id=p1.person_wbc_id
                  inner join wbc_vaccine w on p2.wbc_vaccine_id=w.wbc_vaccine_id left outer join vn_stat v on v.vn=p1.vn
                  left outer join person p on p.person_id=p3.person_id left outer join patient p4 on p.cid=p4.cid
                  left outer join thaiaddress t1 on t1.addressid=v.aid left outer join thaiaddress t2 on t2.addressid=concat(substr(v.aid,1,4),'00') 
                  left outer join thaiaddress t3 on t3.addressid=concat(substr(v.aid,1,2),'0000')
                  where  p1.service_date between '{$date1}'  and '{$date2}' order by p.person_id;";
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
        return $this -> render('/site/practice/practice4-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);                       
    }    
    public function actionPractice5Index()
    {
        $model = new Formmodel();
        $names = "รายงานวัคซีน epi-vaccine (บัญชี 4 เด็ก 1-5 ปี)";         
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
            return $this->redirect(['practice5_preview', 'name' => $names, 'd1' => $date1, 'd2' => $date2]);
        }
         return $this->render('/site/practice/practice5-index',['mText' => $this->mText, 'names' => $names, 'model' => $model]);       
    }    
    public function actionPractice5_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;  
        $sql1="select p.cid,v.hn,concat(p.pname,p.fname,' ',p.lname) pname,p.birthdate,pt.addrpart,pt.moopart,t1.name tmb,t2.name amp,
                  t3.name chw,p1.vaccine_date,e.epi_vaccine_name from person_epi_vaccine p1
                  left outer join person_epi_vaccine_list p2 on p1.person_epi_vaccine_id=p2.person_epi_vaccine_id 
                  left outer join epi_vaccine e on p2.epi_vaccine_id=e.epi_vaccine_id left outer join person_epi p3 on p1.person_epi_id=p3.person_epi_id left outer join person p on p.person_id=p3.person_id
                  left outer join vn_stat v on v.vn=p1.vn left outer join patient pt on v.hn=pt.hn
                  inner join thaiaddress t1 on t1.addressid=v.aid inner join thaiaddress t2 on t2.addressid=concat(substr(v.aid,1,4),'00') 
                  inner join thaiaddress t3 on t3.addressid=concat(substr(v.aid,1,2),'0000')
                  where p1.vaccine_date between '{$date1}' and '{$date2}' ;";
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
        return $this -> render('/site/practice/practice5-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);          
    }        
    public function actionPractice6Index()
    {
        $model = new Formmodel();
        $names = "รายงานวัคซีน student-vaccine (บัญชี 5 เด็ก ป.1-ป.6)";           
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2; 
            return $this->redirect(['practice6_preview', 'name' => $names, 'd1' => $date1, 'd2' => $date2]);
        }
         return $this->render('/site/practice/practice6-index',['mText' => $this->mText, 'names' => $names, 'model' => $model]);       
    }     
    public function actionPractice6_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;      
        $sql1 = "select p.cid,v.hn,concat(p.pname,p.fname,' ',p.lname) pname,pt.addrpart,pt.moopart,t1.name tmb,t2.name amp,
                    t3.name chw,v2.vaccine_date,s.student_vaccine_name,s.vaccine_code,pt.birthday
                    from village_student_vaccine_list v1 
                    left outer join village_student_vaccine v2 on v1.village_student_vaccine_id=v2.village_student_vaccine_id
                    left outer join student_vaccine s on s.student_vaccine_id=v1.student_vaccine_id 
                    left outer join village_student v3 on v3.village_student_id=v2.village_student_id 
                    left outer join person p on v3.person_id=p.person_id 
                    left outer join vn_stat v on v.vn=v2.vn left outer join patient pt on pt.hn=v.hn
                    left outer join thaiaddress t1 on t1.addressid=v.aid
                    left outer join thaiaddress t2 on t2.addressid=concat(substr(v.aid,1,4),'00')
                    left outer join thaiaddress t3 on t3.addressid=concat(substr(v.aid,1,2),'0000')
                    where v2.vaccine_date between '{$date1}' and '{$date2}';";
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
        return $this -> render('/site/practice/practice6-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);         
    }    
    public function actionPractice7Index()
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
            return $this->redirect(['practice7_preview','name'=>$names,'d1'=>$date1,'t1'=>$type]);
        }
         return $this->render('/site/practice/practice7-index',['mText' => $this->mText,'names' => $names, 
                             'model'=>$model, 'data'=>$listData]);       
    }    
    public function actionPractice7_preview($name,$d1,$t1) {
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
        return $this -> render('/site/practice/practice7-preview',['dataProvider' => $dataProvider,'names' => $names,
                                    'mText' => $this->mText,'date1'=>$date1,'type_name'=>$type_name]);                           
    }    
    public function actionPractice8Index() {
        $model = new Formmodel();
        $names="รายงานทะเบียนผู้เสียชีวิต(บัญชี 1)";
        if($model->load(Yii::$app->request->post())){
               $check = $model->radio_list;
               $date1 = $model->date1;
               $date2 = $model->date2;
               return $this->redirect(['practice8_preview', 'name' =>$names, 'c' =>$check, 'd1' =>$date1, 'd2' =>$date2]);
        }
            return $this -> render('/site/practice/practice8-index',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }     
    public function actionPractice8_preview($name,$c,$d1,$d2) {
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
        return $this -> render('/site/practice/practice8-preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'text' => $text]);           
    }        
    public function actionPractice9Index() {
        $model = new Formmodel();
        $names="รายงานทะเบียนหญิงหลังคลอด(ในเขตรับผิดชอบของ รพ.นางรอง)";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Practice/";
               //$url="http://localhost:8080/stimulja/?report=Practice/";    
                return $this->redirect($url.'Practice9.mrt&d1='.$date1.'&d2='.$date2);                  
               //return $this->redirect(['practice8_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
        return $this -> render('/site/practice/practice9-index',['mText'=>$this->mText, 'names'=>$names, 'model' =>$model]);            
    }        
    public function actionPractice10Index() {
        $model = new Formmodel();
        $names=" รายงานทะเบียนผู้ป่วยจำหน่าย(ในเขตรับผิดชอบ)";
        $sql1="select concat(ward,',',name) id,name from ward where ward in ('03','04','05','06');";
        $locations =  \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','name');           
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $code = explode(',', $model->select1);$ward=$code[0];$nward=$code[1];
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Practice/";
               //$url="http://localhost:8080/stimulja/?report=Practice/";    
                return $this->redirect($url.'Practice10.mrt&d1='.$date1.'&d2='.$date2.'&w1='.$ward.'&w2='.$nward);                  
               //return $this->redirect(['practice8_preview', 'name' =>$names, 'd1' =>$date1, 'd2' =>$date2]);
        }
        return $this -> render('/site/practice/practice10-index',['mText'=>$this->mText, 'names'=>$names,
                              'model' =>$model,'listData'=>$listData]);            
    }     
    public function actionPractice11Index() {
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
               $year = $model->text1;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=Practice/"; 
                return $this->redirect($url.'Practice11.mrt&year='.$year);                  
        }
        return $this -> render('/site/practice/practice11-index',['mText'=>$this->mText, 'names'=>$names,'model' =>$model]);            
    }     
    public function actionPractice12Index()
    {
        $model = new Formmodel();        
        $names = "รายงานตำบลจัดการสุขภาพ";
        $sql1="select concat(village_id,',',village_moo,',',if(village_moo=0,'ทั้งหมด ในเขตรับผิดชอบ',village_name)) id,if(village_moo=0,'ทั้งหมด ในเขตรับผิดชอบ',village_name) names 
                  from village  order by village_id;";
        $locations = \Yii::$app->db1->createCommand($sql1)->queryAll();    
        $listData=ArrayHelper::map($locations,'id','names');        
        if($model->load(Yii::$app->request->post())){
            $date1 = $model -> date1;
            $type = Yii::$app->request->post('type');            
            $village=Yii::$app->request->post('village');
            return $this->redirect(['practice12_preview', 'name'=>$names, 'd1'=>$date1, 't' => $type, 'v1'=>$village]);
        }
         return $this->render('/site/practice/practice12-index',['mText' => $this->mText, 
                                       'names' => $names, 'data'=>$listData, 'model' => $model]);       
    }    
    public function actionPractice12_preview($name, $d1, $t, $v1) {
        $names=$name;
        $date1=$d1;
        $type=  explode(',',$t);$type_c=$type[0];$type_n=$type[1];        
        $village=  explode(',',$v1);$village_id=$village[0];$village_moo=$village[1];$village_name=$village[2];
        switch ($village_moo) {
            case 0: // ทั้งหมดในเขตรับผิดชอบ คือ village_moo =1 - 34, village_id != 9                
                switch ($type_c) {
                      case 1: //เบาหวาน
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name from clinicmember c
                                         left outer join patient p on c.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where c.clinic = '001' and ps.village_id != 9  and ps.death != 'Y' order by ps.village_id;";
                      break;
                      case 2: // ความดันโลหิต
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name from clinicmember c
                                         left outer join patient p on c.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where c.clinic = '002' and ps.village_id != 9  and ps.death != 'Y' order by ps.village_id;";

                      break;
                      case 3: // เบาหวาน + ความดัน
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart,
                                         p.moopart, v.village_name from clinicmember c
                                         left outer join patient p on c.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where c.clinic = '001' and ps.village_id != 9  and ps.death != 'Y' 
                                         and c.hn in (select hn from clinicmember where clinic = '002')
                                         order by ps.village_id;";
                      break;
                      case 4: // หัวใจ
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10 from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where o.icd10 in ('I340','I050','I38','I48','I259','I00') and ps.village_id != 9  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";

                      break;                  
                      case 5: // stroke
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10 from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where o.icd10 in ('I64','I639','I679','I694') and ps.village_id != 9  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";
                      break;
                      case 6: // มะเร็ง
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10 from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where o.icd10 between 'C00' and 'C489' and ps.village_id != 9  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";
                      break;
                      case 7: // โรคไต
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10 from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where o.icd10 in ('N179','N181','N182','N183','N184','N185','N189') and ps.village_id != 9  
                                         and ps.death != 'Y' group by p.cid order by ps.village_id;";
                      break;                  
                      default:
                      break;
                }
            break;
            default:
                    // หมู่ตาม village_id
                switch ($type_c) {
                      case 1: //เบาหวาน
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname,  ' ', p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name from clinicmember c
                                         left outer join patient p on c.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where c.clinic = '001' and ps.village_id = '{$village_id}' and ps.death != 'Y' 
                                         order by ps.village_id;";
                                         
                      break;
                      case 2: // ความดันโลหิต
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name from clinicmember c
                                         left outer join patient p on c.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where c.clinic = '002' and ps.village_id = '{$village_id}' and ps.death != 'Y' 
                                         order by ps.village_id;";

                      break;
                      case 3: // เบาหวาน + ความดัน
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ', p.lname) pname, p.birthday, p.addrpart,
                                         p.moopart, v.village_name from clinicmember c
                                         left outer join patient p on c.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where c.clinic = '001' and ps.village_id = '{$village_id}'  and ps.death != 'Y' 
                                         and c.hn in (select hn from clinicmember where clinic = '002')
                                         order by ps.village_id;";
                      break;
                      case 4: // หัวใจ
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10 from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where o.icd10 in ('I340','I050','I38','I48','I259','I00') and ps.village_id = '{$village_id}'
                                         and ps.death != 'Y' group by p.cid order by ps.village_id;";
                      break;                  
                      case 5: // stroke
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10 from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where o.icd10 in ('I64','I639','I679','I694') and ps.village_id = '{$village_id}' 
                                         and ps.death != 'Y' group by p.cid order by ps.village_id;";
                      break;
                      case 6: // มะเร็ง
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10 from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where o.icd10 between 'C00' and 'C489' and ps.village_id = '{$village_id}'  and ps.death != 'Y' 
                                         group by p.cid order by ps.village_id;";
                      break;
                      case 7: // โรคไต
                             $sql1 = "select p.cid, p.hn, concat(p.pname, p.fname, ' ',  p.lname) pname, p.birthday, p.addrpart, 
                                         p.moopart, v.village_name, o.icd10 from ovstdiag o
                                         left outer join patient p on o.hn = p.hn
                                         left outer join person ps on p.cid = ps.cid 
                                         left outer join village v on ps.village_id = v.village_id
                                         where o.icd10 in ('N179','N181','N182','N183','N184','N185','N189') and ps.village_id = '{$village_id}'  
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
        return $this -> render('/site/practice/practice12-preview',['dataProvider' => $dataProvider, 'names' => $names,
                                       'mText' => $this->mText, 'moo' => $village_name, 'type' => $type_n]);            
    }        
}    

