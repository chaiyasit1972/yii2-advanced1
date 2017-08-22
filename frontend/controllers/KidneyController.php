<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class KidneyController extends Controller
{
    public $mText = "งานคลินิกโรคไต(N17-N19)";
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
        $names="รายงานคลินิกโรคไต(N17-N19)"; 
         return $this -> render('/site/kidney/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionKidney1Index(){
        $names="รายงานทะเบียนผู้ป่วยคลินิกโรคไต";
        $sql1="select c.hn,concat(p.pname,p.fname,' ',p.lname) pnames,c.regdate,c.dchdate,c.discharge,
                  cm.clinic_member_status_name as 'status',p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                  if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  or p.moopart in ('','0','00'))) or
                       (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),
                       'ในเขต','นอกเขต') statusx   
                    from clinicmember c inner join patient p on c.hn=p.hn
                    inner join clinic_member_status cm on c.clinic_member_status_id=cm.clinic_member_status_id
                    inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                    inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                    inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                    where c.clinic='029' and c.clinic_member_status_id in ('3','11');";
       try {
              $rawData1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
                $dataProvider1 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData1,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
                ]);  
        $sql2="select c.hn,concat(p.pname,p.fname,' ',p.lname) pnames,c.regdate,c.dchdate,c.discharge,
                  cm.clinic_member_status_name as 'status',p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                  if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  or p.moopart in ('','0','00'))) or
                       (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),
                       'ในเขต','นอกเขต') statusx   
                    from clinicmember c inner join patient p on c.hn=p.hn 
                    inner join clinic_member_status cm on c.clinic_member_status_id=cm.clinic_member_status_id
                    inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                    inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                    inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                    where c.clinic='029' and c.clinic_member_status_id in ('3','11') 
                    and c.hn in(select patient_hn hn from person where patient_hn is not null);";     
       try {
              $rawData2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
                $dataProvider2 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData2,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
                ]);         
        $sql3="select c.hn,concat(p.pname,p.fname,' ',p.lname) pnames,c.regdate,c.dchdate,c.discharge,
                  cm.clinic_member_status_name as 'status',p.addrpart,p.moopart,t1.`name` tmb,t2.`name` amp,t3.`name` chw,
                  if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  or p.moopart in ('','0','00'))) or
                       (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),
                       'ในเขต','นอกเขต') statusx   
                    from clinicmember c inner join patient p on c.hn=p.hn 
                    inner join clinic_member_status cm on c.clinic_member_status_id=cm.clinic_member_status_id
                    inner join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                    inner join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                    inner join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
                    where c.clinic='029' and c.clinic_member_status_id in ('3','11') 
                    and p.hn not in(select patient_hn hn from person where patient_hn is not null);";     
       try {
              $rawData3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
                $dataProvider3 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData3,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
                ]); 
        return $this->render('/site/kidney/kidney1-preview',['names'=>$names,'mText'=>$this->mText,
                                       'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,
                                       'dataProvider3'=>$dataProvider3]);                                                
    }
    public function actionKidney2Index() {
        $model = new Formmodel();        
        $names = "รายงานคัดกรองภาวะไตวาย (eGFR)";   
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;           
            return $this->redirect(['kidney2_preview','name'=>$names, 'd1'=>$date1, 'd2'=>$date2]);
        }
            return $this -> render('/site/kidney/kidney2-index',['mText'=>$this->mText, 'names'=>$names, 'model'=>$model]);
    }     
    public function actionKidney2_preview($d1,$d2) {
        $names = "รายงานคัดกรองภาวะไตวาย (eGFR)";   
        $date1=$d1;$date2=$d2;
        $rawData1=[];
        $rawData2=[];        
        $sql0="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr >120 and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn;";
        $num0=\Yii::$app->db1->createCommand($sql0)->queryScalar();
        if(!$num0){$data0=0;}else{$data0=$num0;}        
        $sql1="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '90' and '120.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn ;";
        $num1=\Yii::$app->db1->createCommand($sql1)->queryScalar();
        if(!$num1){$data1=0;}else{$data1=$num1;}      
        $sql2="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029'  and o.egfr between '60' and '89.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn;";
        $num2=\Yii::$app->db1->createCommand($sql2)->queryScalar();
        if(!$num2){$data2=0;}else{$data2=$num2;}        
        $sql3="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '30' and '59.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn;";
        $num3=\Yii::$app->db1->createCommand($sql3)->queryScalar();
        if(!$num3){$data3=0;}else{$data3=$num3;}    
        $sql4="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '15' and '29.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn;";
        $num4=\Yii::$app->db1->createCommand($sql4)->queryScalar();
        if(!$num4){$data4=0;}else{$data4=$num4;}     
        $sql5="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr <15
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn ;";
        $num5=\Yii::$app->db1->createCommand($sql5)->queryScalar();
        if(!$num5){$data5=0;}else{$data5=$num5;}        
        $rawData1[]=[
                'id' =>1,
                'names' =>'ผู้ป่วยเบาหวานอย่างเดียว',
                'stage0' => $data0,
                'stage1' => $data1,
                'stage2' => $data2,
                'stage3' => $data3,
                'stage4' => $data4,        
                'stage5' => $data5,                
        ];
        $sql6="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr >120 and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                             ) b on a.hn=b.hn;";
        $num6=\Yii::$app->db1->createCommand($sql6)->queryScalar();
        if(!$num6){$data6=0;}else{$data6=$num6;}        
        $sql7="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '90' and '120.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                             ) b on a.hn=b.hn;";
        $num7=\Yii::$app->db1->createCommand($sql7)->queryScalar();
        if(!$num7){$data7=0;}else{$data7=$num7;}      
        $sql8="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029'  and o.egfr between '60' and '89.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                             ) b on a.hn=b.hn;";
        $num8=\Yii::$app->db1->createCommand($sql8)->queryScalar();
        if(!$num8){$data8=0;}else{$data8=$num8;}        
        $sql9="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '30' and '59.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                             ) b on a.hn=b.hn;";
        $num9=\Yii::$app->db1->createCommand($sql9)->queryScalar();
        if(!$num9){$data9=0;}else{$data9=$num9;}    
        $sql10="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '15' and '29.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                             ) b on a.hn=b.hn;";
        $num10=\Yii::$app->db1->createCommand($sql10)->queryScalar();
        if(!$num10){$data10=0;}else{$data10=$num10;}     
        $sql11="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr <15
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                             ) b on a.hn=b.hn;";
        $num11=\Yii::$app->db1->createCommand($sql11)->queryScalar();
        if(!$num11){$data11=0;}else{$data11=$num11;}        
        $rawData1[]=[
                'id' =>2,
                'names' =>'ผู้ป่วยความดันโลหิตอย่างเดียว',
                'stage0' => $data6,
                'stage1' => $data7,
                'stage2' => $data8,
                'stage3' => $data9,
                'stage4' => $data10,        
                'stage5' => $data11,                
        ];        
        $sql12=" select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr >120 and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn";
        $num12=\Yii::$app->db1->createCommand($sql12)->queryScalar();
        if(!$num12){$data12=0;}else{$data12=$num12;}        
        $sql13=" select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '90' and '120.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn";
        $num13=\Yii::$app->db1->createCommand($sql13)->queryScalar();
        if(!$num13){$data13=0;}else{$data13=$num13;}      
        $sql14="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '60' and '89.99'
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn";                              
        $num14=\Yii::$app->db1->createCommand($sql14)->queryScalar();
        if(!$num14){$data14=0;}else{$data14=$num14;}        
        $sql15="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '30' and '59.99' 
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn";   
        $num15=\Yii::$app->db1->createCommand($sql15)->queryScalar();
        if(!$num15){$data15=0;}else{$data15=$num15;}    
        $sql16="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '15' and '29.99' 
                              and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn";                                       
        $num16=\Yii::$app->db1->createCommand($sql16)->queryScalar();
        if(!$num16){$data16=0;}else{$data16=$num16;}     
        $sql17="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr <15 and substr(v.aid,1,4)='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn";                                     
        $num17=\Yii::$app->db1->createCommand($sql17)->queryScalar();
        if(!$num17){$data17=0;}else{$data17=$num17;}        
        $rawData1[]=[
                'id' =>3,
                'names' =>'ผู้ป่วยเบาหวานและความดันโลหิตร่วมกัน',
                'stage0' => $data12,
                'stage1' => $data13,
                'stage2' => $data14,
                'stage3' => $data15,
                'stage4' => $data16,        
                'stage5' => $data17,                
        ];                
        $dataProvider1 = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData1,
            'pagination' => [
                'pageSize' => 10,
                ],
        ]);    
        $sql0a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                          where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr >120 and substr(v.aid,1,4) !='3104'
                          ) a inner join 
                          (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                          ) b on a.hn=b.hn;";
        $num0a=\Yii::$app->db1->createCommand($sql0a)->queryScalar();
        if(!$num0a){$data0a=0;}else{$data0a=$num0a;}        
        $sql1a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                          where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '90' and '120.99' 
                           and substr(v.aid,1,4) !='3104'
                          ) a inner join 
                          (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                          ) b on a.hn=b.hn ;";
        $num1a=\Yii::$app->db1->createCommand($sql1a)->queryScalar();
        if(!$num1a){$data1a=0;}else{$data1a=$num1a;}      
        $sql2a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                          where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '60' and '89.99' 
                          and substr(v.aid,1,4) !='3104'
                          ) a inner join 
                          (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                          ) b on a.hn=b.hn ;";
        $num2a=\Yii::$app->db1->createCommand($sql2a)->queryScalar();
        if(!$num2a){$data2a=0;}else{$data2a=$num2a;}        
        $sql3a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                          where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '30' and '59.99'
                          and substr(v.aid,1,4) !='3104'
                          ) a inner join 
                          (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                          ) b on a.hn=b.hn;";
        $num3a=\Yii::$app->db1->createCommand($sql3a)->queryScalar();
        if(!$num3a){$data3a=0;}else{$data3a=$num3a;}    
        $sql4a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                          where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029'and o.egfr between '15' and '29.99'
                          and substr(v.aid,1,4) !='3104'
                          ) a inner join 
                          (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                          ) b on a.hn=b.hn ;";
        $num4a=\Yii::$app->db1->createCommand($sql4a)->queryScalar();
        if(!$num4a){$data4a=0;}else{$data4a=$num4a;}     
        $sql5a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                          where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029'and o.egfr <15
                          and substr(v.aid,1,4) !='3104'
                          ) a inner join 
                          (select hn,clinic from clinicmember where clinic='001' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='002')
                          ) b on a.hn=b.hn ;";
        $num5a=\Yii::$app->db1->createCommand($sql5a)->queryScalar();
        if(!$num5a){$data5a=0;}else{$data5a=$num5a;}        
        $rawData2[]=[
                'id' =>1,
                'names' =>'ผู้ป่วยเบาหวานอย่างเดียว',
                'stage0' => $data0a,
                'stage1' => $data1a,
                'stage2' => $data2a,
                'stage3' => $data3a,
                'stage4' => $data4a,        
                'stage5' => $data5a,                
        ];
        $sql6a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                           where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr >120 
                           and substr(v.aid,1,4) !='3104'
                           ) a inner join 
                          (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                          ) b on a.hn=b.hn ;";
        $num6a=\Yii::$app->db1->createCommand($sql6a)->queryScalar();
        if(!$num6a){$data6a=0;}else{$data6a=$num6a;}        
        $sql7a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                           where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '90' and '120.99'
                           and substr(v.aid,1,4) !='3104'
                           ) a inner join 
                          (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                          ) b on a.hn=b.hn ;";
        $num7a=\Yii::$app->db1->createCommand($sql7a)->queryScalar();
        if(!$num7a){$data7a=0;}else{$data7a=$num7a;}      
        $sql8a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                           where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '60' and '89.99'
                           and substr(v.aid,1,4) !='3104'
                           ) a inner join 
                          (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                          ) b on a.hn=b.hn;";
        $num8a=\Yii::$app->db1->createCommand($sql8a)->queryScalar();
        if(!$num8a){$data8a=0;}else{$data8a=$num8a;}        
        $sql9a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                           where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '30' and '59.99'
                           and substr(v.aid,1,4) !='3104'
                           ) a inner join 
                          (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                          ) b on a.hn=b.hn ;";
        $num9a=\Yii::$app->db1->createCommand($sql9a)->queryScalar();
        if(!$num9a){$data9a=0;}else{$data9a=$num9a;}    
        $sql10a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                           where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '15' and '29.99'
                           and substr(v.aid,1,4) !='3104'
                           ) a inner join 
                          (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                          ) b on a.hn=b.hn ;";
        $num10a=\Yii::$app->db1->createCommand($sql10a)->queryScalar();
        if(!$num10a){$data10a=0;}else{$data10a=$num10a;}     
        $sql11a="select count(*) cc from     
                          (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                           where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr < 15
                           and substr(v.aid,1,4) !='3104'
                           ) a inner join 
                          (select hn,clinic from clinicmember where clinic='002' and hn not in (select c1.hn from clinicmember c1 where c1.clinic='001')
                          ) b on a.hn=b.hn;";
        $num11a=\Yii::$app->db1->createCommand($sql11a)->queryScalar();
        if(!$num11a){$data11a=0;}else{$data11a=$num11a;}        
        $rawData2[]=[
                'id' =>2,
                'names' =>'ผู้ป่วยความดันโลหิตอย่างเดียว',
                'stage0' => $data6a,
                'stage1' => $data7a,
                'stage2' => $data8a,
                'stage3' => $data9a,
                'stage4' => $data10a,        
                'stage5' => $data11a,                
        ];        
        $sql12a="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr > 120 and substr(v.aid,1,4) !='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn;";
        $num12a=\Yii::$app->db1->createCommand($sql12a)->queryScalar();
        if(!$num12a){$data12a=0;}else{$data12a=$num12a;}        
        $sql13a="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '90' and '120.99'  
                              and substr(v.aid,1,4) !='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn ;";
        $num13a=\Yii::$app->db1->createCommand($sql13a)->queryScalar();
        if(!$num13a){$data13a=0;}else{$data13a=$num13a;}      
        $sql14a="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029'  and o.egfr between '60' and '89.99' 
                              and substr(v.aid,1,4) !='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn ;";
        $num14a=\Yii::$app->db1->createCommand($sql14a)->queryScalar();
        if(!$num14a){$data14a=0;}else{$data14a=$num14a;}        
        $sql15a="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029'   and o.egfr between '30' and '59.99'
                              and substr(v.aid,1,4) !='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn ;";
        $num15a=\Yii::$app->db1->createCommand($sql15a)->queryScalar();
        if(!$num15a){$data15a=0;}else{$data15a=$num15a;}    
        $sql16a="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029' and o.egfr between '15' and '29.99'
                              and substr(v.aid,1,4) !='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn ;";
        $num16a=\Yii::$app->db1->createCommand($sql16a)->queryScalar();
        if(!$num16a){$data16a=0;}else{$data16a=$num16a;}     
        $sql17a="select count(*) cc from     
                             (select c.hn,c.clinic,o.egfr from ovst_gfr o inner join vn_stat v on v.vn=o.vn  inner join clinicmember c on c.hn=v.hn
                              where v.vstdate between '{$date1}' and '{$date2}' and c.clinic='029'  and o.egfr <15
                              and substr(v.aid,1,4) !='3104'
                             ) a inner join 
                             (select hn,clinic from clinicmember where clinic='001' and hn in (select c1.hn from clinicmember c1 where c1.clinic='002')
                             ) b on a.hn=b.hn ;";
        $num17a=\Yii::$app->db1->createCommand($sql17a)->queryScalar();
        if(!$num17a){$data17a=0;}else{$data17a=$num17a;}        
        $rawData2[]=[
                'id' =>3,
                'names' =>'ผู้ป่วยเบาหวานและความดันโลหิตร่วมกัน',
                'stage0' => $data12a,
                'stage1' => $data13a,
                'stage2' => $data14a,
                'stage3' => $data15a,
                'stage4' => $data16a,        
                'stage5' => $data17a,                
        ];                
        $dataProvider2 = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData2,
            'pagination' => [
                'pageSize' => 10,
                ],
        ]);                           
        return $this -> render('/site/kidney/kidney2-preview',['dataProvider1' => $dataProvider1,'names' => $names,
                                    'mText' => $this->mText, 'date1'=>$date1,'date2'=>$date2,'dataProvider2' => $dataProvider2]);      
    }    
    public function actionKidney3Index() {
        $model = new Formmodel();        
        $names = "รายงานมาตรฐานตัวชี้วัดตามสมาคมโรคไต(15 ตัวชี้วัด)";    
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;           
            return $this->redirect(['kidney3_preview','name'=>$names, 'd1'=>$date1, 'd2'=>$date2]);
        }
            return $this -> render('/site/kidney/kidney3-index',['mText'=>$this->mText, 'names'=>$names, 'model'=>$model]);
    }       
    public function actionKidney3_preview($d1,$d2) {
        $names = "รายงานมาตรฐานตัวชี้วัดตามสมาคมโรคไต(15 ตัวชี้วัด)";   
        $date1 = $d1;$date2 = $d2;
        $rawData=[];
        $sql1="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn where c.clinic='029' and 
                  o.vstdate between '{$date1}' and '{$date2}';";
        $num1=\Yii::$app->db1->createCommand($sql1)->queryScalar();   
        if(!$num1){$total1=0;}else{$total1=$num1;}     
        $sql1a="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn where c.clinic='029' and 
                   o.vstdate between '{$date1}' and '{$date2}' and (o.bps between 1 and 130) and (o.bpd between 1 and 80) ;";
        $num1a=\Yii::$app->db1->createCommand($sql1a)->queryScalar();   
        if(!$num1a){$result1=0;}else{$result1=$num1a;}            
        $rawData[]=[
                'id' => 1,
                'names' => 'ผู้ป่วย Mean BP <130/80 nmHg',
                'goal' => '',
                'total' => $total1,
                'result' => $result1
        ];
        $sql2="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn inner join opitemrece d on o.vn=d.vn
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and d.icode in 
                  ('1510054','1510053','1520066','1570020') group by o.vn;";
        $num2=\Yii::$app->db1->createCommand($sql2)->query()->rowCount;    
        if(!$num2){$result2=0;}else{$result2=$num2;}            
        $rawData[]=[
                'id' => 2,
                'names' => 'ผู้ป่วยได้รับ ACEi/ARBs',
                'goal' => '',
                'total' => $total1,
                'result' => $result2
        ];
        $sql3="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn inner join ovst_gfr g on o.vn=g.vn
                  where c.clinic='029' and o.vstdate between  '{$date1}' and '{$date2}' ;";
        $num3=\Yii::$app->db1->createCommand($sql3)->queryScalar();   
        if(!$num3){$total3=0;}else{$total3=$num3;}    
        $sql3a=";";
        
        $rawData[]=[
                'id' => 3,
                'names' => 'ผู้ป่วยมี Rate decline of eGFR < 4 ml/min/1.73m2/Year',
                'goal' => '',
                'total' => '',
                'result' => ''
        ];
        $sql4="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('263','708') ;";
        $num4=\Yii::$app->db1->createCommand($sql4)->queryScalar();   
        if(!$num4){$total4=0;}else{$total4=$num4;}   
        $sql4a="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                    inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                    where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('263','708') 
                    and lo.lab_order_result > 10;";
        $num4a=\Yii::$app->db1->createCommand($sql4a)->queryScalar();                       
        if(!$num4a){$result4=0;}else{$result4=$num4a;}                        
        $rawData[]=[
                'id' => 4,
                'names' => 'ผู้ป่วยได้รับการตรวจ Hb>10 g/dl',
                'goal' => '',
                'total' => $total4,
                'result' => $result4
        ];
        $sql5="select count(*) cc  from 
	       (select o.vn,o.hn,c.clinic,lo.lab_items_code,lo.lab_order_result from opdscreen o inner join clinicmember c on o.hn=c.hn 
		inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
		where c.clinic='029' and o.vstdate between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('193')
	       ) a  inner join 
                     (select hn,clinic from clinicmember where clinic='001' and hn not in (select hn from clinicmember c1 where clinic='002')
                     ) b
                     on a.hn=b.hn ;";
        $num5=\Yii::$app->db1->createCommand($sql5)->queryScalar();   
        if(!$num5){$total5=0;}else{$total5=$num5;}      
        $sql5a="select count(*) cc  from 
	       (select o.vn,o.hn,c.clinic,lo.lab_items_code,lo.lab_order_result from opdscreen o inner join clinicmember c on o.hn=c.hn 
		inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
		where c.clinic='029' and o.vstdate between  '{$date1}' and '{$date2}' and lo.lab_items_code in ('193')
                             and lo.lab_order_result <7
	       ) a  inner join 
                     (select hn,clinic from clinicmember where clinic='001' and hn not in (select hn from clinicmember c1 where clinic='002')
                     ) b
                     on a.hn=b.hn  ;";
        $num5a=\Yii::$app->db1->createCommand($sql5a)->queryScalar();   
        if(!$num5a){$result5=0;}else{$result5=$num5a;}             
        $rawData[]=[
                'id' => 5,
                'names' => 'ผู้ป่วยได้รับการตรวจ HbA1C <7%(เฉพาะผู้ป่วยเบาหวาน)',
                'goal' => '',
                'total' => $total5,
                'result' => $result5
        ];        
        $sql6="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('92') ;";
        $num6=\Yii::$app->db1->createCommand($sql6)->queryScalar();   
        if(!$num6){$total6=0;}else{$total6=$num6;}  
        $sql6a="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('92')
                  and lo.lab_order_result <100 ;"; 
        $num6a=\Yii::$app->db1->createCommand($sql6a)->queryScalar();   
        if(!$num6a){$result6=0;}else{$result6=$num6a;}                     
        $rawData[]=[
                'id' => 6,
                'names' => 'ผู้ป่วยได้รับการตรวจ LDL cholesterol <100 mg/dl',
                'goal' => '',
                'total' => $total6,
                'result' => $result6
        ];
        $sql7="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('81') ;";
        $num7=\Yii::$app->db1->createCommand($sql7)->queryScalar();   
        if(!$num7){$total7=0;}else{$total7=$num7;}  
        $sql7a="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('81')
                  and lo.lab_order_result < 5.5 ;"; 
        $num7a=\Yii::$app->db1->createCommand($sql7a)->queryScalar();   
        if(!$num7a){$result7=0;}else{$result7=$num7a;}              
        $rawData[]=[
                'id' => 7,
                'names' => 'ผู้ป่วยได้รับการตรวจ serum potassium < 5.5 mEg/L',
                'goal' => '',
                'total' => $total7,
                'result' => $result7
        ];        
        $sql8="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('82') ;";
        $num8=\Yii::$app->db1->createCommand($sql8)->queryScalar();   
        if(!$num8){$total8=0;}else{$total8=$num8;}  
        $sql8a="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('82')
                  and lo.lab_order_result > 22 ;"; 
        $num8a=\Yii::$app->db1->createCommand($sql8a)->queryScalar();   
        if(!$num8a){$result8=0;}else{$result8=$num8a;}           
        $rawData[]=[
                'id' => 8,
                'names' => 'ผู้ป่วยได้รับการตรวจ serum bicarbonate > 22 mEg/L',
                'goal' => '',
                'total' => $total8,
                'result' => $result8
        ];        
        $sql9="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn inner join lab_head lh on o.vn=lh.vn 
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}'  ;";
        $num9=\Yii::$app->db1->createCommand($sql9)->queryScalar();   
        if(!$num9){$total9=0;}else{$total9=$num9;} 
        $sql9a="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('486') ;";   
        $num9a=\Yii::$app->db1->createCommand($sql9a)->queryScalar();   
        if(!$num9a){$result9=0;}else{$result9=$num9a;}                       
        $rawData[]=[
                'id' => 9,
                'names' => 'ผู้ป่วยได้รับการตรวจ Urine protein โดยใช้แถบสีจุ่ม(dipstick)',
                'goal' => '',
                'total' => $total9,
                'result' => $result9
        ];             
        $sql10="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn inner join lab_head lh on o.vn=lh.vn 
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}'  ;";
        $num10=\Yii::$app->db1->createCommand($sql10)->queryScalar();   
        if(!$num10){$total10=0;}else{$total10=$num10;} 
        $sql10a="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('463','723','794') ;";   
        $num10a=\Yii::$app->db1->createCommand($sql10a)->queryScalar();   
        if(!$num10a){$result10=0;}else{$result10=$num10a;}            
        $rawData[]=[
                'id' => 10,
                'names' => 'ผู้ป่วยได้รับการตรวจ Urine protein-creatinine ratio(UPCR) หรือ Urine protein 24 hr.',
                'goal' => '',
                'total' => $total10,
                'result' => $result10
        ];         
        $sql11="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in('463','723','794') ;";   
        $num11=\Yii::$app->db1->createCommand($sql11)->queryScalar();   
        if(!$num11){$total11=0;}else{$total11=$num11;}    
        $sql11a="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in('463','723','794')
                  and lo.lab_order_result < 500 ;"; 
        $num11a=\Yii::$app->db1->createCommand($sql11a)->queryScalar();   
        if(!$num11a){$result11=0;}else{$result11=$num11a;}         
        $rawData[]=[
                'id' => 11,
                'names' => 'ผู้ป่วยได้รับการตรวจ Urine protein-creatinine ratio(UPCR)<500 mg/g หรือ Urine protein 24 hr. < 500 mg/day',
                'goal' => '',
                'total' => $total11,
                'result' => $result11
        ];       
        $sql12="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('85') ;";   
        $num12=\Yii::$app->db1->createCommand($sql12)->queryScalar();   
        if(!$num12){$total12=0;}else{$total12=$num12;}   
        $sql12a="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('85')
                  and lo.lab_order_result < 4.5 ;"; 
        $num12a=\Yii::$app->db1->createCommand($sql12a)->queryScalar();   
        if(!$num12a){$result12=0;}else{$result12=$num12a;}          
        $rawData[]=[
                'id' => 12,
                'names' => 'ผู้ป่วยได้รับการตรวจ Serum phosphate < 4.5 mg/dl',
                'goal' => '',
                'total' => $total12,
                'result' => $result12
        ];           
        
        $rawData[]=[
                'id' => 13,
                'names' => 'ผู้ป่วยมีค่า serum parathyroid hormone อยู่ในระดับ',
                'goal' => '',
                'total' => '',
                'result' => ''
        ];                 
        $sql14="select count(*) cc from opdscreen o inner join clinicmember c on o.hn=c.hn 
                  inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                  where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}' and lo.lab_items_code in ('418') ;";   
        $num14=\Yii::$app->db1->createCommand($sql14)->queryScalar();   
        if(!$num14){$total14=0;}else{$total14=$num14;}   
        $sql14a="  select count(*) cc from 
                        (select o.vn,lo.lab_items_code from opdscreen o inner join clinicmember c on o.hn=c.hn 
                               inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                               where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('418')
                         ) a inner join  
                         (select vn,egfr from ovst_gfr where egfr between 30 and 59
                         ) b on a.vn=b.vn;";
        $num14a=\Yii::$app->db1->createCommand($sql14a)->queryScalar();   
        if(!$num14a){$result14=0;}else{$result14=$num14a;}                                  
        $rawData[]=[
                'id' => 14,
                'names' => '13.1 CKD stage3 (eGFR 30-59)',
                'goal' => '',
                'total' => $total14,
                'result' => $result14
        ];               
        $sql15a="  select count(*) cc from 
                        (select o.vn,lo.lab_items_code from opdscreen o inner join clinicmember c on o.hn=c.hn 
                               inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                               where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('418')
                         ) a inner join  
                         (select vn,egfr from ovst_gfr where egfr between 15 and 29
                         ) b on a.vn=b.vn;";
        $num15a=\Yii::$app->db1->createCommand($sql15a)->queryScalar();   
        if(!$num15a){$result15=0;}else{$result15=$num15a;}            
        $rawData[]=[
                'id' => 15,
                'names' => '13.2 CKD stage4 (eGFR 15-29)',
                'goal' => '',
                'total' => $total14,
                'result' => $result15
        ];         
        $sql16a="  select count(*) cc from 
                        (select o.vn,lo.lab_items_code from opdscreen o inner join clinicmember c on o.hn=c.hn 
                               inner join lab_head lh on o.vn=lh.vn left outer join lab_order lo on lh.lab_order_number=lo.lab_order_number
                               where c.clinic='029' and o.vstdate between '{$date1}' and '{$date2}'  and lo.lab_items_code in ('418')
                         ) a inner join  
                         (select vn,egfr from ovst_gfr where egfr <15
                         ) b on a.vn=b.vn;";
        $num16a=\Yii::$app->db1->createCommand($sql16a)->queryScalar();   
        if(!$num16a){$result16=0;}else{$result16=$num16a;}          
        $rawData[]=[
                'id' => 16,
                'names' => '13.3 CKD stage5 (eGFR <15)',
                'goal' => '',
                'total' => $total14,
                'result' => $result16
        ];   

        $rawData[]=[
                'id' => 17,
                'names' => 'ผู้ป่วยได้รับการตรวจ Emergency vascular access ก่อนเริ่ม Renal replacement therapy',
                'goal' => '',
                'total' => '',
                'result' => ''
        ];          
        
        $rawData[]=[
                'id' => 18,
                'names' => 'ผู้ป่วยได้รับความรู้ในการชละไตเสื่อมครบตาม Modules ของสมาคมโรคไต',
                'goal' => '',
                'total' => '',
                'result' => ''
        ];             
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 20,
                ],
        ]);  
        return $this -> render('/site/kidney/kidney3-preview',['dataProvider' => $dataProvider,'names' => $names,
                                        'mText' => $this->mText,'date1'=>$date1,'date2'=>$date2]);                       
    }    
        
}    