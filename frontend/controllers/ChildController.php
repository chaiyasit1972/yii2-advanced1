<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class ChildController extends Controller
{
    public $mText = "งานคลินิกสุขภาพเด็กดี";
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
        $names="งานคลินิกสุขภาพเด็กดี"; 
         return $this -> render('/site/child/index',['mText'=>$this->mText,'names'=>$names]);
    } 
    public function actionChild1Index() {
        $model = new Formmodel();            
        $names="รายงานผู้รับบริการบัญชี 3";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=child/"; 
              //  return $this->redirect($url.'child1.mrt&d1='.$date1.'&d2='.$date2);
               return $this->redirect(['child1_preview','name'=>$names,'d1' => $date1,'d2' => $date2]);                
        }        
            return $this -> render('/site/child/child1-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);                
    } 
    public function actionChild1_preview($name,$d1,$d2) {
        $names=$name;        
        $date1=$d1;$date2=$d2;
               $sql1="select a.*,b.*,c.*,e.*,f.*,g.*,h.*,j.*,i.*,k.*,d.drug from 
                            (select v.vn,v.hn,concat(p.pname,p.fname,' ',p.lname) pname,v.age_d,v.age_m,v.age_y,pws.service_date,
                                    pt.`name` pttype,p.addrpart,p.moopart,t1.name tmb,t2.name amp,t3.name chw,
                                    if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28'  
                                           or p.moopart in ('','0','00'))) or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                                           and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),'ในเขต','นอกเขต') statusx,
                                           pws.head_length,w.wbc_development_assess_name development,wb.wbc_breast_feed_type_name breast,
                                           n.`name` nutrition,h.`name` height_level,b.`name` bmi_level,
                                           group_concat(wv.wbc_vaccine_name,'[',pv.vaccine_lotno,']') vaccine
                             from person_wbc_service pws 
		left outer join person_wbc pw on pws.person_wbc_id=pw.person_wbc_id 
		left outer join person ps on pw.person_id=ps.person_id
		left outer join vn_stat v on pws.vn=v.vn
		left outer join pttype pt on v.pttype=pt.pttype
		left outer join patient p on v.hn=p.hn
	      left outer join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
	      left outer join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
	      left outer join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
	      left outer join wbc_development_assess w on pws.wbc_development_assess_id=w.wbc_development_assess_id
	      left outer join wbc_breast_feed_type wb on wb.wbc_breast_feed_type_id=pws.wbc_breast_feed_type_id
	      left outer join nutrition_level n on pws.nutrition_level=n.nutrition_level
	      left outer join height_level h on h.height_level=pws.height_level
	      left outer join bmi_level b on pws.bmi_level=b.bmi_level
	      left outer join person_wbc_vaccine_detail pv on pws.person_wbc_service_id=pv.person_wbc_service_id
	      left outer join wbc_vaccine wv on pv.wbc_vaccine_id=wv.wbc_vaccine_id
	     where pws.service_date between '{$date1}' and '{$date2}'  and pws.vn is not null group by pws.person_wbc_service_id
        ) a
        left outer join        
        (select lh.vn,lo.lab_order_result result from lab_head lh left outer join lab_order lo
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('264','671')  group by lh.vn
         ) b
         on a.vn=b.vn
         left outer join 
        (select lh.vn,lo.lab_order_result result1 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('486')  group by lh.vn  
         ) c
         on a.vn=c.vn
         left outer join          
        (select lh.vn,lo.lab_order_result result2 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('487')  group by lh.vn  
         ) e
         on a.vn=e.vn        
         left outer join          
        (select lh.vn,lo.lab_order_result result3 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('488')  group by lh.vn  
         ) f
         on a.vn=f.vn      
         left outer join          
        (select lh.vn,lo.lab_order_result result4 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('489')  group by lh.vn  
         ) g
         on a.vn=g.vn    
         left outer join          
        (select lh.vn,lo.lab_order_result result5 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('490')  group by lh.vn  
         ) h
         on a.vn=h.vn      
         left outer join          
        (select lh.vn,lo.lab_order_result result6 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('499')  group by lh.vn  
         ) i
         on a.vn=i.vn      
         left outer join          
        (select lh.vn,lo.lab_order_result result7 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('902')  group by lh.vn  
         ) j
         on a.vn=j.vn   
         left outer join          
        (select lh.vn,lo.lab_order_result result8 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('904')  group by lh.vn  
         ) k
         on a.vn=k.vn            
         left outer join 
         (select o.vn,d.`name` drug from opitemrece o left outer join drugitems d on o.icode=d.icode where o.icode='1510368'
         ) d
         on a.vn=d.vn;"; 
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
        return $this->render('/site/child/child1-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                   'date1' =>$date1,'date2' =>$date2]);         
    }
    public function actionChild2Index() {
        $model = new Formmodel();            
        $names="รายงานผู้รับบริการบัญชี 4";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=child/"; 
               // return $this->redirect($url.'child2.mrt&d1='.$date1.'&d2='.$date2);
               return $this->redirect(['child2_preview','name'=>$names,'d1' => $date1,'d2' => $date2]);                   
        }  
            return $this -> render('/site/child/child2-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);                
    }
    public function actionChild2_preview($name,$d1,$d2) {
        $names=$name;        
        $date1=$d1;$date2=$d2;
               $sql1="select a.vn,v.hn,a.person_epi_id,concat(p.pname,p.fname,' ',p.lname) pname,pt.`name` pttype,t1.name tmb,
                             t2.name amp,t3.name chw,p.addrpart,p.moopart,
                             if(((concat(p.chwpart,p.amppart,p.tmbpart)='310401' and (p.moopart between '01' and '28' 
                               or p.moopart in ('','0','00'))) or (concat(p.chwpart,p.amppart,p.tmbpart)='310413'  
                               and (p.moopart between '29' and '34' or  p.moopart in ('','0','00')))),'ในเขต','นอกเขต') statusx,
                             b.nutrition_date,v.age_y,v.age_m,b.development,b.food,b.bottle,b.nutrition_level nutrition,b.height_level,b.bmi_level,
                             a.vaccine_date,a.vaccine,c.*,e.drug,d.*,f.*,g.*,h.*,i.*,j.*,k.*,l.*  from 
                        (select  pev.person_epi_id,pev.vn,pev.vaccine_date,group_concat(ev.epi_vaccine_name,'[',pevl.vaccine_lotno,']') vaccine 
                             from person_epi_vaccine pev 
		left outer join person_epi_vaccine_list pevl on pev.person_epi_vaccine_id=pevl.person_epi_vaccine_id 
                             left outer join epi_vaccine ev on ev.epi_vaccine_id=pevl.epi_vaccine_id            
                             where pev.vaccine_date between '{$date1}' and '{$date2}' group by pevl.person_epi_vaccine_id
                        ) a  left outer join 
	         (select pen.person_epi_id,pen.nutrition_date,pen.age_y,pen.age_m,n.`name` nutrition_level,h.`name` height_level,
                             b.name bmi_level,pnct.person_nutrition_childdevelop_type_name development,
                             pf.person_nutrition_food_type_name food,pb.person_nutrition_bottle_type_name bottle  from person_epi pe
		left outer join person_epi_nutrition pen on pen.person_epi_id=pe.person_epi_id
		left outer join nutrition_level n on pen.nutrition_level=n.nutrition_level
		left outer join height_level h on h.height_level=pen.height_level
		left outer join bmi_level b on b.bmi_level=pen.bmi_level
                             left outer join person_nutrition_childdevelop_type pnct 
                                    on pen.person_nutrition_childdevelop_type_id=pnct.person_nutrition_childdevelop_type_id
                             left outer join person_nutrition_food_type pf on pen.person_nutrition_food_type_id=pf.person_nutrition_food_type_id
                             left outer join person_nutrition_bottle_type pb on pen.person_nutrition_bottle_type_id=pb.person_nutrition_bottle_type_id 
		where pen.nutrition_date between '{$date1}' and '{$date2}' 
                         ) b on a.person_epi_id=b.person_epi_id
                            left outer join vn_stat v on a.vn=v.vn
                            left outer join patient p on p.hn=v.hn
	              left outer join pttype pt on v.pttype=pt.pttype
                            left outer join thaiaddress t1 on t1.addressid=concat(p.chwpart,p.amppart,p.tmbpart)
                            left outer join thaiaddress t2 on t2.addressid=concat(p.chwpart,p.amppart,'00')
                            left outer join thaiaddress t3 on t3.addressid=concat(p.chwpart,'0000')
	             left outer join        
                        (select lh.vn,lo.lab_order_result result from lab_head lh left outer join lab_order lo 
                            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
                            where lo.lab_items_code in ('264','671')  group by lh.vn  
                         ) c on a.vn=c.vn
         left outer join 
        (select lh.vn,lo.lab_order_result result1 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('486')  group by lh.vn  
         ) d
         on a.vn=d.vn
         left outer join          
        (select lh.vn,lo.lab_order_result result2 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('487')  group by lh.vn  
         ) f
         on a.vn=f.vn        
         left outer join          
        (select lh.vn,lo.lab_order_result result3 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('488')  group by lh.vn  
         ) g
         on a.vn=g.vn      
         left outer join          
        (select lh.vn,lo.lab_order_result result4 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('489')  group by lh.vn  
         ) h
         on a.vn=h.vn    
         left outer join          
        (select lh.vn,lo.lab_order_result result5 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('490')  group by lh.vn  
         ) i
         on a.vn=i.vn      
         left outer join          
        (select lh.vn,lo.lab_order_result result6 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('499')  group by lh.vn  
         ) j
         on a.vn=j.vn      
         left outer join          
        (select lh.vn,lo.lab_order_result result7 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('902')  group by lh.vn  
         ) k
         on a.vn=k.vn   
         left outer join          
        (select lh.vn,lo.lab_order_result result8 from lab_head lh left outer join lab_order lo 
            on lh.lab_order_number=lo.lab_order_number left outer join lab_items l on l.lab_items_code=lo.lab_items_code
            where lo.lab_items_code in ('904')  group by lh.vn  
         ) l
         on a.vn=l.vn            
         left outer join 
         (select o.vn,d.`name` drug from opitemrece o left outer join drugitems d on o.icode=d.icode 
         where o.icode='1510368' 
         ) e 
         on a.vn=e.vn group by a.vn;"; 
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
        return $this->render('/site/child/child2-preview',['mText'=>$this->mText,'names'=>$names,'dataProvider'=>$dataProvider,
                                   'date1' =>$date1,'date2' =>$date2]);         
    }
    public function actionChild3Index() {
        $model = new Formmodel();            
        $names="รายงาน pp-special";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
               $url="http://192.168.3.8/stimulrep/stimulsoft/index.php?stimulsoft_client_key=ViewerFx&stimulsoft_report_key=child/"; 
                return $this->redirect($url.'child3.mrt&d1='.$date1.'&d2='.$date2);        
        }        
            return $this -> render('/site/child/child3-index',['mText'=>$this->mText,'names'=>$names,'model'=>$model]);                
    } 

    
}  