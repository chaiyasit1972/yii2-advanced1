<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use frontend\models\Formmodel;

class PctChildController extends Controller
{
    public $mText = "โรคที่น่าสนใจ(PCT) ผป.ใน";
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
    public function actionIndex1() {
        $model = new Formmodel();        
        $names="กุมารเวชกรรม - DHF(A91/A91)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['child1_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-child/child1-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
    public function actionChild1_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $sql1="select 'จำนวนผู้ป่วย DHF ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'A90' and 'A91' and pdx not like 'Z%' and spclty='05';";
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
        $sql2="select c.icd10,i.name pnames,count(*) cc  from icd101 i inner join 
                      (select  b.an,b.pdx,a.icd10,a.diagtype  from (select an,icd10,diagtype  from iptdiag where diagtype='3'
                      ) a  inner join 
                      (select a.an,a.pdx from an_stat a where a.pdx between 'A90' and 'A91' and a.pdx not like 'Z%' and a.spclty='05'
                      and a.dchdate between '{$date1}' and '{$date2}'
                      ) b on a.an=b.an 
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
        $sql3="select 'จำนวนผู้ป่วย DHF ที่เสียชีวิต' as pnames,count(*) cc from death d inner join an_stat a on d.an=a.an
                 where d.death_date between '{$date1}' and '{$date2}' and a.pdx between 'A90' and 'A919' ;";   
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
        $sql4="select 'จำนวนผู้ป่วย DHF ที่ส่งต่อ' as pnames,count(*) cc from referout  r inner join iptdiag i on r.vn=i.an
                  inner join an_stat a on i.an=a.an
                  where i.icd10 between 'A90' and 'A91' and i.icd10 not like 'Z%' and r.refer_date between '{$date1}' and '{$date2} ' 
                  and a.spclty='05';";   
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
        $sql5="select 'จำนวนผู้ป่วย DHF ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx  between 'A90' and 'A91' and a.pdx not like 'Z%' and a.spclty='05';";   
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
        
        return $this->render('/site/pct-child/child1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);        
    }         
    public function actionIndex2() {
        $model = new Formmodel();        
        $names="กุมารเวชกรรม - VLBW 0-999 กรัม"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['child2_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-child/child2-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
    public function actionChild2_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select 'จำนวนเด็กเกิดน้ำหนัก 0-999 กรัม ทั้งหมด' as pnames,count(*) cc from ipt_newborn i
                  inner join ipt l on i.an=l.an inner join an_stat a on i.an=a.an
                  where i.born_date between '{$date1}' and '{$date2}' and i.birth_weight between 0 and 999;";
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
        $sql2="select t.icd10,ic.name pnames,count(*) cc from ipt_newborn i inner join an_stat a on i.an=a.an 
                  inner join iptdiag t on i.an=t.an inner join icd101 ic on t.icd10=ic.code
                  where i.born_date between '{$date1}' and '{$date2}' and i.birth_weight between 0 and 999 and t.diagtype=3
                  and t.icd10 not like 'Z%' group by t.icd10 order by cc desc limit 10;";   
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
        $sql3="select 'จำนวนเด็กแรกเกิดน้ำหนัก 0-999 กรัม เสียชีวิต' as pnames,count(*) cc from ipt_newborn i
                  inner join death d on i.an=d.an where d.death_date between '{$date1}' and '{$date2}' and i.birth_weight between 0 and 999 ;";   
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
        $sql4="select 'จำนวนเด็กแรกเกิดน้ำหนัก 0-999 กรัม ส่งตอ' as pnames,count(*) cc from ipt_newborn i
                  inner join referout r on r.vn=i.an
                  where r.refer_date between '{$date1}' and '{$date2}' and i.birth_weight between 0 and 999 ;";   
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
        $sql5="select 'จำนวนเด็กเกิดน้ำหนัก 0-999 กรัม ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                      left outer join an_stat b on a.hn=b.hn and a.an>b.an
                      left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an
                      inner join ipt_newborn n on a.an=n.an
                      where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28 
                      and n.birth_weight between 0 and 999;";   
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
        return $this->render('/site/pct-child/child2-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);          
    }    
    public function actionIndex3() {
        $model = new Formmodel();        
        $names="กุมารเวชกรรม - VLBW 1000-1499 กรัม"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['child3_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-child/child3-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
    public function actionChild3_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select 'จำนวนเด็กเกิดน้ำหนัก 1000-1499 กรัม ทั้งหมด' as pnames,count(*) cc from ipt_newborn i
                  inner join ipt l on i.an=l.an inner join an_stat a on i.an=a.an
                  where i.born_date between '{$date1}' and '{$date2}' and i.birth_weight between 1000 and 1499;";
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
        $sql2="select t.icd10,ic.name pnames,count(*) cc from ipt_newborn i inner join an_stat a on i.an=a.an 
                  inner join iptdiag t on i.an=t.an inner join icd101 ic on t.icd10=ic.code
                  where i.born_date between '{$date1}' and '{$date2}' and i.birth_weight between 1000 and 1499 and t.diagtype=3
                  and t.icd10 not like 'Z%' group by t.icd10 order by cc desc limit 10;";   
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
        $sql3="select 'จำนวนเด็กแรกเกิดน้ำหนัก 1000-1499 กรัม เสียชีวิต' as pnames,count(*) cc from ipt_newborn i
                  inner join death d on i.an=d.an where d.death_date between '{$date1}' and '{$date2}'
                  and i.birth_weight between 1000 and 1499 ;";   
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
        $sql4="select 'จำนวนเด็กแรกเกิดน้ำหนัก 1000-1499 กรัม ส่งตอ' as pnames,count(*) cc from ipt_newborn i
                  inner join referout r on r.vn=i.an
                  where r.refer_date between '{$date1}' and '{$date2}' and i.birth_weight between 1000 and 1499 ;";   
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
        $sql5="select 'จำนวนเด็กเกิดน้ำหนัก 1000-1499 กรัม ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                      left outer join an_stat b on a.hn=b.hn and a.an>b.an
                      left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an
                      inner join ipt_newborn n on a.an=n.an
                      where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28 
                      and n.birth_weight between 1000 and 1499;";   
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
        return $this->render('/site/pct-child/child3-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                
    }    
     public function actionIndex4() {
        $model = new Formmodel();        
        $names="กุมารเวชกรรม - VLBW 1500-2499 กรัม";
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['child4_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-child/child4-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
   public function actionChild4_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select 'จำนวนเด็กเกิดน้ำหนัก 1500-2499 กรัม ทั้งหมด' as pnames,count(*) cc from ipt_newborn i
                  inner join ipt l on i.an=l.an inner join an_stat a on i.an=a.an
                  where i.born_date between '{$date1}' and '{$date2}' and i.birth_weight between 1500 and 2499;";
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
        $sql2="select t.icd10,ic.name pnames,count(*) cc from ipt_newborn i inner join an_stat a on i.an=a.an 
                  inner join iptdiag t on i.an=t.an inner join icd101 ic on t.icd10=ic.code
                  where i.born_date between '{$date1}' and '{$date2}' and i.birth_weight between 1500 and 2499 and t.diagtype=3
                  and t.icd10 not like 'Z%' group by t.icd10 order by cc desc limit 10;";   
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
        $sql3="select 'จำนวนเด็กแรกเกิดน้ำหนัก 1500-2499 กรัม เสียชีวิต' as pnames,count(*) cc from ipt_newborn i
                  inner join death d on i.an=d.an where d.death_date between '{$date1}' and '{$date2}'
                  and i.birth_weight between 1500 and 2499 ;";   
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
        $sql4="select 'จำนวนเด็กแรกเกิดน้ำหนัก 1500-2499 กรัม ส่งตอ' as pnames,count(*) cc from ipt_newborn i
                  inner join referout r on r.vn=i.an
                  where r.refer_date between '{$date1}' and '{$date2}' and i.birth_weight between 1500 and 2499 ;";   
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
        $sql5="select 'จำนวนเด็กเกิดน้ำหนัก 1500-2499 กรัม ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                      left outer join an_stat b on a.hn=b.hn and a.an>b.an
                      left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an
                      inner join ipt_newborn n on a.an=n.an
                      where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28 
                      and n.birth_weight between 1500 and 2499;";   
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
        return $this->render('/site/pct-child/child4-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);            
    }            
     public function actionIndex5() {
        $model = new Formmodel();        
        $names="กุมารเวชกรรม - Asthma(J45,J452-J455,J459)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['child5_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-child/child5-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }    
   public function actionChild5_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql1="select 'จำนวนผู้ป่วย Asthma ทั้งหมด' as pnames,count(*) cc from an_stat a inner join icd101 i on a.pdx=i.code 
                  where ((a.pdx between 'J45' and 'J450') or (a.pdx between 'J452' and 'J455') or (a.pdx between 'J459' and 'J4599'))
                  and a.dchdate between '{$date1}' and '{$date2}' and a.spclty='05';";
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
        $sql2="select a.icd10,a.pnames,count(*) cc from
                    (select i.an,i.icd10,i.diagtype,ic.name pnames  from iptdiag i inner join icd101 ic on i.icd10=ic.`code` where i.diagtype=3                
                    ) a 
                    inner join 
                   (select a.an,a.pdx from an_stat a  where ((a.pdx between 'J45' and 'J450') or (a.pdx between 'J452' and 'J455') 
                           or (a.pdx between 'J459' and 'J4599')) and a.dchdate between '{$date1}' and '{$date2}' and a.spclty='05' 
                   ) b
                   on a.an=b.an group by a.icd10 order by cc desc limit 10;";   
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
        $sql3="select 'จำนวนผู้ป่วย Asthma ที่เสียชีวิต' as pnames,count(*) cc from
                       (select * from death        
                       ) a 
                        inner join 
                       (select a.an,a.pdx from an_stat a  where ((a.pdx between 'J45' and 'J450') or (a.pdx between 'J452' and 'J455')
                         or (a.pdx between 'J459' and 'J4599')) and a.dchdate between '{$date1}' and '{$date2}' and a.spclty='05'
                       ) b
                       on a.an=b.an ;";   
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
        $sql4="select 'จำนวนผู้ป่วย Asthma ส่งต่อ' as pnames,count(*) cc from
                        (select * from referout       
                        ) a 
                        inner join 
                        (select a.an,a.pdx from an_stat a  where ((a.pdx between 'J45' and 'J450') or (a.pdx between 'J452' and 'J455')
                              or (a.pdx between 'J459' and 'J4599')) and a.dchdate between '{$date1}' and '{$date2}' and a.spclty='05'
                        ) b
                         on a.vn=b.an ;";   
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
        $sql5="select 'จำนวนผู้ป่วย Athma ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and ((a.pdx between 'J45' and 'J450') or (a.pdx between 'J452' and 'J455') 
                                       or (a.pdx between 'J459' and 'J4599')) and a.spclty='05' ;";   
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
        return $this->render('/site/pct-child/child5-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);          
    }     
    
    
    
    
    
    
    
    
    
}    