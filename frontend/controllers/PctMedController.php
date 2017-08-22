<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use frontend\models\Formmodel;

class PctMedController extends Controller
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
        $names="อายุรกรรม - โรค Stemi(I21-I214)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['med1_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-med/med1-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
    public function actionMed1_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $sql1="select 'จำนวนผู้ป่วย Stemi ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'I21' and 'I214' and spclty='01';";
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
        $sql2="select a.icd10,a.pnames,count(*) cc  from 
                     (select i.an,i.icd10,ic.name pnames from iptdiag i inner join icd101 ic on i.icd10=ic.`code` where i.diagtype=3
                     ) a 
                     inner join  
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' and pdx between 'I21' and 'I214' 
                             and spclty='01'
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
        $sql3="select 'จำนวนผู้ป่วย Stemi เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'I21' and 'I214' and spclty='01'
                        ) b on a.an=b.an ;";   
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
        $sql4="select 'จำนวนผู้ป่วย Stemi  ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                        and pdx between 'I21' and 'I214' and spclty='01'
                        ) b on a.vn=b.an ;";   
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
         $sql5="select 'จำนวนผู้ป่วย Stemi ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'I21' and 'I214' and a.spclty='01';";   
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
                
        return $this->render('/site/pct-med/med1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                  
    }
    public function actionIndex2() {
        $model = new Formmodel();        
        $names="อายุรกรรม - โรค Stroke(I60-I69)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['med2_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-med/med2-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
   public function actionMed2_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $sql1="select 'จำนวนผู้ป่วย Stroke ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'I60' and 'I69' and spclty='01';";
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
        $sql2="select a.icd10,a.pnames,count(*) cc  from 
                     (select i.an,i.icd10,ic.name pnames from iptdiag i inner join icd101 ic on i.icd10=ic.`code` where i.diagtype=3
                     ) a 
                     inner join  
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' and pdx between 'I60' and 'I69' 
                             and spclty='01'
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
        $sql3="select 'จำนวนผู้ป่วย Stroke เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'I60' and 'I69' and spclty='01'
                        ) b on a.an=b.an ;";   
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
        $sql4="select 'จำนวนผู้ป่วย Stroke  ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                        and pdx between 'I60' and 'I69' and spclty='01'
                        ) b on a.vn=b.an ;";   
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
         $sql5="select 'จำนวนผู้ป่วย Stroke ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'I60' and 'I69' and a.spclty='01';";   
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
        return $this->render('/site/pct-med/med2-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                  
    }        
    public function actionIndex3() {
        $model = new Formmodel();        
        $names="อายุรกรรม - โรคเบาหวาน Dm(E11-E119)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['med3_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-med/med3-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
   public function actionMed3_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $sql1="select 'จำนวนผู้ป่วยเบาหวาน(Dm) ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'E11' and 'E119' and spclty='01';";
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
        $sql2="select a.icd10,a.pnames,count(*) cc  from 
                     (select i.an,i.icd10,ic.name pnames from iptdiag i inner join icd101 ic on i.icd10=ic.`code` where i.diagtype=3
                     ) a 
                     inner join  
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' and pdx between 'E11' and 'E119' 
                             and spclty='01'
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
        $sql3="select 'จำนวนผู้ป่วยเบาหวาน(Dm) เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'E11' and 'E119' and spclty='01'
                        ) b on a.an=b.an ;";   
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
        $sql4="select 'จำนวนผู้ป่วยเบาหวาน(Dm)  ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                        and pdx between 'E11' and 'E119' and spclty='01'
                        ) b on a.vn=b.an ;";   
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
         $sql5="select 'จำนวนผู้ป่วยเบาหวาน(Dm) ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'E11' and 'E119' and a.spclty='01';";   
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
        return $this->render('/site/pct-med/med3-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                  
    } 
    public function actionIndex4() {
        $model = new Formmodel();        
        $names="อายุรกรรม - โรคความดันโลหิต Ht(I10-I15)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['med4_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-med/med4-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
     public function actionMed4_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $sql1="select 'จำนวนผู้ป่วยความดันโลหิต(Ht) ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'I10' and 'I15' and spclty='01';";
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
        $sql2="select a.icd10,a.pnames,count(*) cc  from 
                     (select i.an,i.icd10,ic.name pnames from iptdiag i inner join icd101 ic on i.icd10=ic.`code` where i.diagtype=3
                     ) a 
                     inner join  
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' and pdx between 'I10' and 'I15' 
                             and spclty='01'
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
        $sql3="select 'จำนวนผู้ป่วยความดันโลหิต(Ht) เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'I10' and 'I15' and spclty='01'
                        ) b on a.an=b.an ;";   
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
        $sql4="select 'จำนวนผู้ป่วยความดันโลหิต(Ht) ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                        and pdx between 'I10' and 'I15' and spclty='01'
                        ) b on a.vn=b.an ;";   
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
         $sql5="select 'จำนวนผู้ป่วยความดันโลหิต(Ht) ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'I10' and 'I15' and a.spclty='01';";   
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
        return $this->render('/site/pct-med/med4-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                  
    }        
    public function actionIndex5() {
        $model = new Formmodel();        
        $names="อายุรกรรม - โรค Copd(J44-J449)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['med5_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-med/med5-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
    public function actionMed5_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $sql1="select 'จำนวนผู้ป่วย COPD ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'J44' and 'J449' and spclty='01';";
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
        $sql2="select a.icd10,a.pnames,count(*) cc  from 
                     (select i.an,i.icd10,ic.name pnames from iptdiag i inner join icd101 ic on i.icd10=ic.`code` where i.diagtype=3
                     ) a 
                     inner join  
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' and pdx between 'J44' and 'J449' 
                             and spclty='01'
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
        $sql3="select 'จำนวนผู้ป่วย COPD เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'J44' and 'J449' and spclty='01'
                        ) b on a.an=b.an ;";   
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
        $sql4="select 'จำนวนผู้ป่วย COPD ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                        and pdx between 'J44' and 'J449' and spclty='01'
                        ) b on a.vn=b.an ;";   
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
         $sql5="select 'จำนวนผู้ป่วย COPD ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'J44' and 'J449' and a.spclty='01';";   
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
        return $this->render('/site/pct-med/med5-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                  
    }     
    public function actionIndex6() {
        $model = new Formmodel();        
        $names="อายุรกรรม - โรค Sepsis(A41-A419)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['med6_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-med/med6-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
    public function actionMed6_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;
        $sql1="select 'จำนวนผู้ป่วย Sepsis ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'A41' and 'A419' and spclty='01';";
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
        $sql2="select a.icd10,a.pnames,count(*) cc  from 
                     (select i.an,i.icd10,ic.name pnames from iptdiag i inner join icd101 ic on i.icd10=ic.`code` where i.diagtype=3
                     ) a 
                     inner join  
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' and pdx between 'A41' and 'A419'
                             and spclty='01'
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
        $sql3="select 'จำนวนผู้ป่วย Sepsis เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'A41' and 'A419' and spclty='01'
                        ) b on a.an=b.an ;";   
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
        $sql4="select 'จำนวนผู้ป่วย Sepsis ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                        and pdx between 'A41' and 'A419' and spclty='01'
                        ) b on a.vn=b.an ;";   
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
         $sql5="select 'จำนวนผู้ป่วย Sepsis ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'A41' and 'A419' and a.spclty='01';";   
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
        return $this->render('/site/pct-med/med6-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                  
    }     
}    