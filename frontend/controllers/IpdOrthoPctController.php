<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use frontend\models\Formmodel;

class IpdOrthoPctController extends Controller
{
    public $mText = "งานศัลกรรมกระดูก";
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
    public function actionPct1Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ ข้อเสื่อม(Arthosis)-Polyarthrosis(M150-M159)";       
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct1_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPct1_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ ข้อเสื่อม(Arthosis)"; 
        $namet = "Polyarthrosis(M150-M159)";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Arthosis of hip(M160-M169) ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and pdx between 'M160' and 'M1699';";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where a.pdx between 'M160' and 'M1699' 
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Arthosis of hip(M160-M169) ที่เสียชีวิต' as pnames,count(*) cc from death d 
                    inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and a.pdx between 'M160' and 'M1699' ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Arthosis of hip(M160-M169) ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and a.pdx  between 'M160' and 'M1699' ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and a.pdx between 'M160' and 'M1699';";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2, 'namet' => $namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }    
  
    
    public function actionPct2Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ ข้อเสื่อม(Arthosis) - Gonathrosis(M170-M179)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct2_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
   public function actionPct2_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ ข้อเสื่อม(Arthosis)";
        $namet = "Gonathrosis(M170-M179)";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Gonathrosis(M170-M179)ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and pdx between 'M170' and 'M1799';";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where a.pdx between 'M170' and 'M1799' 
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Gonathrosis(M170-M179) ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and a.pdx between 'M170' and 'M1799' ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Gonathrosis(M170-M179) ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and a.pdx  between 'M170' and 'M1799' ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and a.pdx between 'M170' and 'M1799';";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2, 'namet' => $namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }
    public function actionPct3Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ ข้อเสื่อม(Arthosis) - Arthosis of hip(M160-M169)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct3_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPct3_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ ข้อเสื่อม(Arthosis)";
        $namet = "Arthosis of hip(M160-M169)";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Arthosis of hip(M160-M169) ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and pdx between 'M160' and 'M1699';";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where a.pdx between 'M160' and 'M1699' 
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Arthosis of hip(M160-M169) ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and a.pdx between 'M160' and 'M1699' ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Arthosis of hip(M160-M169) ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and a.pdx  between 'M160' and 'M1699' ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and a.pdx between 'M160' and 'M1699';";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' => $namet ,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }
    public function actionPct4Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Spine discease - Spondylolysis(M430-M439)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct4_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPct4_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Spine discease";
        $namet = "Spondylolysis(M430-M439)";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Spondylolysis(M430-M439) ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and pdx between 'M430' and 'M4399';";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where a.pdx between 'M430' and 'M4399' 
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Spondylolysis(M430-M439) ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and a.pdx between 'M430' and 'M4399' ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Spondylolysis(M430-M439) ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and a.pdx  between 'M430' and 'M4399' ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and a.pdx between 'M430' and 'M4399';";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' => $namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   } 
    public function actionPct5Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Spine discease - Spondylopathies(M450-M459)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct5_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionPct5_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Spine discease";
        $namet = "Spondylopathies(M450-M459)";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Spondylopathies(M450-M459) ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and pdx between 'M450' and 'M4599';";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where a.pdx between 'M450' and 'M4599' 
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Spondylopathies(M450-M459) ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and a.pdx between 'M450' and 'M4599' ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Spondylopathies(M450-M459) ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and a.pdx  between 'M450' and 'M4599' ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and a.pdx between 'M450' and 'M4599';";
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
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' => $namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);        
        
    }        
    public function actionPct6Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Spine discease - Spondylosis(M470-M479)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct6_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPct6_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Spine discease";
        $namet = "Spondylosis(M470-M479)";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Spondylosis(M470-M479) ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and pdx between 'M470' and 'M4799';";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where a.pdx between 'M470' and 'M4799' 
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Spondylosis(M470-M479) ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and a.pdx between 'M470' and 'M4799' ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Spondylosis(M470-M479) ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and a.pdx  between 'M470' and 'M4799' ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and a.pdx between 'M470' and 'M4799';";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' => $namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }    
    public function actionPct7Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Spine discease - Spinal stenosis(M480-M489)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct7_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }  
    public function actionPct7_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Spine discease";
        $namet = "Spinal stenosis(M480-M489)";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Spinal stenosis(M480-M489) ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and pdx between 'M480' and 'M4899';";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where a.pdx between 'M480' and 'M4899' 
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Spinal stenosis(M480-M489) ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and a.pdx between 'M480' and 'M4899' ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Spinal stenosis(M480-M489) ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and a.pdx  between 'M480' and 'M4899' ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and a.pdx between 'M480' and 'M4899';";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' =>$namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }    
    public function actionPct8Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Spinal injury"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct8_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
   public function actionPct8_preview($name, $d1, $d2) {
        $names=$name;
        $namet = "";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Spinal injury ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and ((pdx between 'T08' and 'T0819')  or pdx like 'T093%' 
                      or pdx like 'S120%' or (pdx between 'S130' and 'S1349') or pdx like 'S32%');";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where ((a.pdx between 'T08' and 'T0819')  
                                            or a.pdx like 'T093%' or a.pdx like 'S120%' or (a.pdx between 'S130' and 'S1349') or a.pdx like 'S32%')
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Spinal injury ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and ((a.pdx between 'T08' and 'T0819')  
                              or a.pdx like 'T093%' or a.pdx like 'S120%' or (a.pdx between 'S130' and 'S1349') or a.pdx like 'S32%') ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Spinal injury ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and ((a.pdx between 'T08' and 'T0819')  
                     or a.pdx like 'T093%' or a.pdx like 'S120%' or (a.pdx between 'S130' and 'S1349') or a.pdx like 'S32%') ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and ((a.pdx between 'T08' and 'T0819')  
                            or a.pdx like 'T093%' or a.pdx like 'S120%' or (a.pdx between 'S130' and 'S1349') or a.pdx like 'S32%');";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' => $namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }
    public function actionPct9Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Fracture Around the hips(S720-S722)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct9_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPct9_preview($name, $d1, $d2) {
        $names=$name;$namet="";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Fracture Around the hips(S720-S722)ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and pdx between 'S720' and 'S7229';";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where a.pdx between 'S720' and 'S7229' 
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Fracture Around the hips(S720-S722)ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and a.pdx between 'S720' and 'S7229' ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Fracture Around the hips(S720-S722)ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and a.pdx  between 'S720' and 'S7229' ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and a.pdx between 'S720' and 'S7229';";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet'=>$namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }
    public function actionPct10Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ(Closed fracture long bone)-Closed fracture femur"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct10_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPct10_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Closed fracture long bone";
        $namet = "Closed fracture femur";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Closed fracture femur ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' 
                    and ((pdx between 'S7230' and 'S72309') or (pdx between 'S7240' and 'S72409') or pdx like 'S7270%');";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where 
                                        ((a.pdx between 'S7230' and 'S72309') or (a.pdx between 'S7240' and 'S72409') or a.pdx like 'S7270%')                                    
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Closed fracture femur ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and 
                      ((a.pdx between 'S7230' and 'S72309') or (a.pdx between 'S7240' and 'S72409') or a.pdx like 'S7270%') ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Closed fracture femur ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and ((a.pdx between 'S7230' and 'S72309') or (a.pdx between 'S7240' and 'S72409') or a.pdx like 'S7270%')  ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and 
                    ((a.pdx between 'S7230' and 'S72309') or (a.pdx between 'S7240' and 'S72409') or a.pdx like 'S7270%') ;";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet'=>$namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }    
    public function actionPct11Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Closed Fracture Long Bone - Closed Fracture Tibia"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct11_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPct11_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Closed Fracture Long Bone";
        $namet = "Closed Fracture Tibia";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Closed fracture tibia ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' 
                    and ((pdx between 'S8210' and 'S82109') or (pdx between 'S8220' and 'S82209') or (pdx between 'S8230' and 'S82309') 
                       or pdx like 'S8240%');";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where 
                                       ((a.pdx between 'S8210' and 'S82109') or (a.pdx between 'S8220' and 'S82209') or
                                       (a.pdx between 'S8230' and 'S82309') or a.pdx like 'S8240%')                                 
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Closed fracture tibia ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and 
                             ((a.pdx between 'S8210' and 'S82109') or (a.pdx between 'S8220' and 'S82209') or
                             (a.pdx between 'S8230' and 'S82309') or a.pdx like 'S8240%')    ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Closed fracture tibia ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and ((a.pdx between 'S8210' and 'S82109') or (a.pdx between 'S8220' and 'S82209') or
                         (a.pdx between 'S8230' and 'S82309') or a.pdx like 'S8240%')    ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and 
                             ((a.pdx between 'S8210' and 'S82109') or (a.pdx between 'S8220' and 'S82209') or
                             (a.pdx between 'S8230' and 'S82309') or a.pdx like 'S8240%')    ;";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' =>$namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }
    public function actionPct12Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Closed Fracture Long Bone - Closed Fracture Forarm"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct12_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPct12_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Closed Fracture Long Bone";
        $namet = "Closed Fracture Forarm";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Closed fracture forarm ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' 
                    and ((pdx between 'S5200' and 'S52009') or (pdx between 'S5210' and 'S52109') or
                    (pdx between 'S5220' and 'S52209') or (pdx between 'S5230' and 'S52309') or pdx like 'S5240%');";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where 
                      ((a.pdx between 'S5200' and 'S52009') or (a.pdx between 'S5210' and 'S52109') or
                      (a.pdx between 'S5220' and 'S52209') or (a.pdx between 'S5230' and 'S52309') or a.pdx like 'S5240%')                                
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Closed fracture forarm ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and 
                      ((a.pdx between 'S5200' and 'S52009') or (a.pdx between 'S5210' and 'S52109') or
                      (a.pdx between 'S5220' and 'S52209') or (a.pdx between 'S5230' and 'S52309') or a.pdx like 'S5240%')    ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Closed fracture forarm ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and ((a.pdx between 'S5200' and 'S52009') or (a.pdx between 'S5210' and 'S52109') or
                      (a.pdx between 'S5220' and 'S52209') or (a.pdx between 'S5230' and 'S52309') or a.pdx like 'S5240%')    ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and 
                      ((a.pdx between 'S5200' and 'S52009') or (a.pdx between 'S5210' and 'S52109') or
                      (a.pdx between 'S5220' and 'S52209') or (a.pdx between 'S5230' and 'S52309') or a.pdx like 'S5240%')   ;";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' =>$namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }
    public function actionPct13Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Closed Fracture Long Bone - Closed Fracture Humerus"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct13_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionPct13_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Closed Fracture Long Bone";
        $namet = "Closed Fracture Humerus";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Closed fracture humerus ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' 
                    and ((pdx between 'S4220' and 'S42209') or (pdx between 'S4230' and 'S42309') or (pdx between 'S4240' and 'S42409'));";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where 
                                        ((a.pdx between 'S4220' and 'S42209') or (a.pdx between 'S4230' and 'S42309') or
                                         (a.pdx between 'S4240' and 'S42409'))                                
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Closed fracture humerus ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and 
                     ((a.pdx between 'S4220' and 'S42209') or (a.pdx between 'S4230' and 'S42309') or
                     (a.pdx between 'S4240' and 'S42409')) ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Closed fracture humerus ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and ((a.pdx between 'S4220' and 'S42209') or (a.pdx between 'S4230' and 'S42309') or
                     (a.pdx between 'S4240' and 'S42409')) ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and 
                    ((a.pdx between 'S4220' and 'S42209') or (a.pdx between 'S4230' and 'S42309') or
                    (a.pdx between 'S4240' and 'S42409'));";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' =>$namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }    
    public function actionPct14Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Open Fracture Long Bone - Open Fracture Femur"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct14_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }     
    public function actionPct14_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Open Fracture Long Bone";
        $namet = "Open Fracture Femur";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Open fracture femur ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' 
                    and ((pdx between 'S7231' and 'S72319') or (pdx between 'S7241' and 'S72419') or pdx like 'S7271%');";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where 
                                    ((a.pdx between 'S7231' and 'S72319') or (a.pdx between 'S7241' and 'S72419') or a.pdx like 'S7271%')                                           
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Open fracture femur ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and 
                      ((a.pdx between 'S7231' and 'S72319') or (a.pdx between 'S7241' and 'S72419') or a.pdx like 'S7271%') ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Open fracture femur ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                   and ((a.pdx between 'S7231' and 'S72319') or (a.pdx between 'S7241' and 'S72419') or a.pdx like 'S7271%') ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and 
                     ((a.pdx between 'S7231' and 'S72319') or (a.pdx between 'S7241' and 'S72419') or a.pdx like 'S7271%') ;";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' =>$namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }   
    public function actionPct15Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Open Fracture Long Bone - Open Fracture Tibia"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct15_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }
    public function actionPct15_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Open Fracture Long Bone";
        $namet = "Open Fracture Tibia";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน ผู้ป่วย Open fracture tibia ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and 
                      ((pdx between 'S8211' and 'S82119') or (pdx between 'S8221' and 'S82219') or
                      (pdx between 'S8231' and 'S82319')  or pdx like 'S8241%');";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where 
                                    ((a.pdx between 'S8211' and 'S82119') or (a.pdx between 'S8221' and 'S82219') or
                                    (a.pdx between 'S8231' and 'S82319')  or a.pdx like 'S8241%')                                           
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Open fracture tibia ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and 
                      ((a.pdx between 'S8211' and 'S82119') or (a.pdx between 'S8221' and 'S82219') or
                                    (a.pdx between 'S8231' and 'S82319')  or a.pdx like 'S8241%')  ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Open fracture tibia ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28 and  
                   ((a.pdx between 'S8211' and 'S82119') or (a.pdx between 'S8221' and 'S82219') or
                                    (a.pdx between 'S8231' and 'S82319')  or a.pdx like 'S8241%')   ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and 
                      ((a.pdx between 'S8211' and 'S82119') or (a.pdx between 'S8221' and 'S82219') or
                                    (a.pdx between 'S8231' and 'S82319')  or a.pdx like 'S8241%')  ;";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' =>$namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }    
    public function actionPct16Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Open Fracture Long Bone - Open Fracture Forarm"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct16_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }   
    public function actionPct16_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Open Fracture Long Bone";
        $namet = "Open Fracture Forarm";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน Open fracture forarm ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and 
                      ((pdx between 'S5201' and 'S52019') or (pdx between 'S5211' and 'S521109') or 
                       (pdx between 'S5221' and 'S52219') or (pdx between 'S5231' and 'S52319') or pdx like 'S5241%');";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where 
                                     ((a.pdx between 'S5201' and 'S52019') or (a.pdx between 'S5211' and 'S521109') or 
                                     (a.pdx between 'S5221' and 'S52219') or (a.pdx between 'S5231' and 'S52319') or a.pdx like 'S5241%')                                          
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Open fracture forarm ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and 
                      ((a.pdx between 'S5201' and 'S52019') or (a.pdx between 'S5211' and 'S521109') or 
                                     (a.pdx between 'S5221' and 'S52219') or (a.pdx between 'S5231' and 'S52319') or a.pdx like 'S5241%')   ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Open fracture forarm ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28 and  
                  ((a.pdx between 'S5201' and 'S52019') or (a.pdx between 'S5211' and 'S521109') or 
                                     (a.pdx between 'S5221' and 'S52219') or (a.pdx between 'S5231' and 'S52319') or a.pdx like 'S5241%')    ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and 
                     ((a.pdx between 'S5201' and 'S52019') or (a.pdx between 'S5211' and 'S521109') or 
                                     (a.pdx between 'S5221' and 'S52219') or (a.pdx between 'S5231' and 'S52319') or a.pdx like 'S5241%')   ;";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' => $namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }   
    public function actionPct17Index() {
        $model = new Formmodel();
        $names="รายงานโรคที่สนใจ Open Fracture Long Bone - Open Fracture Humerus"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['pct17_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);                          
        }
            return $this -> render('/site/ipd-ortho/pct/pct1-index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    } 
    public function actionPct17_preview($name, $d1, $d2) {
        $names = "รายงานโรคที่สนใจ Open Fracture Long Bone";
        $namet = "Open Fracture Humerus";
        $date1=$d1;$date2=$d2;
        $sql1 = "select  'จำนวน/วันนอน Closed fracture humerus ทั้งหมด' as pname, count(*) man, sum(admdate) men from an_stat 
                    where dchdate between '{$date1}' and '{$date2}' and 
                      ((pdx between 'S4221' and 'S42219') or (pdx between 'S4231' and 'S42319') 
                       or (pdx between 'S4241' and 'S42419'));";        
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
        $sql2 = "select c.icd10,i.name pnames,count(*) cc from icd101 i 
                    inner join 
                      (
                           select  a.an,a.pdx,b.icd10,b.diagtype  
                                 from 
                                    (select a.an,a.pdx from an_stat a where 
                                    ((a.pdx between 'S4221' and 'S42219') or (a.pdx between 'S4231' and 'S42319') 
                                    or (a.pdx between 'S4241' and 'S42419'))                                        
                                      and a.dchdate between '{$date1}' and '{$date2}'
                                     ) a
                                 inner join 
                                  (select an,icd10,diagtype  from iptdiag where diagtype='3'
                                  ) b 
                                  on a.an=b.an 
                   ) c
                   on i.code=c.icd10 group by c.icd10  order by cc desc limit 10;";            
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
        $sql3 = "select 'จำนวนผู้ป่วย Closed fracture humerus ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                    where d.death_date between '{$date1}' and '{$date2}' and 
                        ((a.pdx between 'S4221' and 'S42219') or (a.pdx between 'S4231' and 'S42319') 
                                    or (a.pdx between 'S4241' and 'S42419')) ;";
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
       $sql4 = "select 'จำนวนผู้ป่วย Closed fracture humerus ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                   left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                   left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                   where a.dchdate between  '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28 and  
                   ((a.pdx between 'S4221' and 'S42219') or (a.pdx between 'S4231' and 'S42319') 
                                    or (a.pdx between 'S4241' and 'S42419'))  ;";
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
        $sql5 = "select a.hn,a.an,concat(p.pname,p.fname,' ',p.lname) pname,a.age_y,a.regdate,a.dchdate,a.pdx,i.name diag 
                    from an_stat a 
                    inner join patient p on p.hn=a.hn inner join icd101 i on a.pdx=i.code 
                    where dchdate between  '{$date1}' and '{$date2}' and 
                     ((a.pdx between 'S4221' and 'S42219') or (a.pdx between 'S4231' and 'S42319') 
                                    or (a.pdx between 'S4241' and 'S42419')) ;";
        try {
              $rawData5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
            } catch (\yii\db\Exception $e) {
                  throw new \yii\web\ConflictHttpException('sql error');
         }                               
        $dataProvider5 = new \yii\data\ArrayDataProvider([
                     'allModels' => $rawData5,
                     'pagination' => [
                        'pageSize' => 20,
                      ],
        ]);    
        return $this->render('/site/ipd-ortho/pct/pct1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,
                      'date2'=>$date2,'namet' => $namet,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);             
   }    
}    

