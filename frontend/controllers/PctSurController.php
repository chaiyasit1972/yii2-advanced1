<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use frontend\models\Formmodel;

class PctSurController extends Controller
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
        $names="ศัลยกรรม - Acute appendicitis(K35-K389) "; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['sur1_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-sur/sur1-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
    public function actionSur1_preview($name,$d1,$d2) {
       $names=$name;
        $date1=$d1;$date2=$d2; 
        $sql1="select 'จำนวนผู้ป่วย Acute appendicitis ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'K35' and 'K389' and spclty in ('02');";
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
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' 
                             and pdx between 'K35' and 'K389' and spclty in ('02')
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
        $sql3="select 'จำนวนผู้ป่วย Acute appendicitis เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'K35' and 'K389' and spclty in ('02')
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
        $sql4="select 'จำนวนผู้ป่วย Acute appendicitis ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                                    and pdx between 'K35' and 'K389' and spclty in ('02')
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
         $sql5="select 'จำนวนผู้ป่วย Acute appendicitis ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'K35' and 'K389' and a.spclty in ('02');";   
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
        return $this->render('/site/pct-sur/sur1-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);         
        
    }
    public function actionIndex2() {
        $model = new Formmodel();        
        $names="ศัลยกรรม - โรค Ugih(K922-K929)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['sur2_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-sur/sur2-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }
    public function actionSur2_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2; 
        $sql1="select 'จำนวนผู้ป่วย Ugih ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'K922' and 'K929' and spclty in ('02');";
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
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' 
                             and pdx between 'K922' and 'K929'  and spclty in ('02')
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
        $sql3="select 'จำนวนผู้ป่วย Ugih เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'K922' and 'K929'  and spclty in ('02')
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
        $sql4="select 'จำนวนผู้ป่วย Ugih ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                                    and pdx between 'K922' and 'K929' and spclty in ('02')
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
         $sql5="select 'จำนวนผู้ป่วย Ugih ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'K922' and 'K929' and a.spclty in ('02');";   
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
        return $this->render('/site/pct-sur/sur2-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                  
    }     
    public function actionIndex3() {
        $model = new Formmodel();        
        $names="ศัลยกรรม - Necrotizing Fasciitis(M72-M726)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['sur3_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-sur/sur3-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    }    
   public function actionSur3_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2; 
        $sql1="select 'จำนวนผู้ป่วย Necrotizing Fasciitis ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'M72' and 'M726' and spclty in ('02');";
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
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' 
                             and pdx between 'M72' and 'M726' and spclty in ('02')
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
        $sql3="select 'จำนวนผู้ป่วย Necrotizing Fasciitis เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'M72' and 'M726' and spclty in ('02')
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
        $sql4="select 'จำนวนผู้ป่วย Necrotizing Fasciitis ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                                    and pdx between 'M72' and 'M726' and spclty in ('02')
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
         $sql5="select 'จำนวนผู้ป่วย Necrotizing Fasciitis ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'M72' and 'M726' and a.spclty in ('02');";   
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
        return $this->render('/site/pct-sur/sur3-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                   
    }  
    public function actionIndex4() {
        $model = new Formmodel();        
        $names="ศัลยกรรม - Head injury(S00-S09)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;
            return $this->redirect(['sur4_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }        
        return $this->render('/site/pct-sur/sur4-index',['names'=>$names,'mText'=>$this->mText, 'model' => $model]);
    } 
   public function actionSur4_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2; 
        $sql1="select 'จำนวนผู้ป่วย Head injury ทั้งหมด' as pnames,count(*) cc from an_stat where dchdate between '{$date1}' and '{$date2}'
                       and pdx between 'S00' and 'S09' and spclty in ('02');";
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
                    (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}' 
                             and pdx between 'S00' and 'S09' and spclty in ('02')
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
        $sql3="select 'จำนวนผู้ป่วย Head injury เสียชีวิตทั้งหมด' as pnames,count(*) cc  from 
                        (select an,death_date from death 
                        ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                            and pdx between 'S00' and 'S09' and spclty in ('02')
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
        $sql4="select 'จำนวนผู้ป่วย Head injury ส่งต่อ ทั้งหมด' as pnames,count(*) cc  from 
                        (select * from referout
                         ) a 
                         inner join  
                        (select an,pdx from an_stat where dchdate between '{$date1}' and '{$date2}'  
                                    and pdx between 'S00' and 'S09' and spclty in ('02')
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
         $sql5="select 'จำนวนผู้ป่วย Head injury ที่ Re admit ภายใน 28 วัน' as pnames,count(*) cc from an_stat a 
                                       left outer join an_stat b on a.hn=b.hn and a.pdx=b.pdx and a.an>b.an
                                       left outer join patient p on a.hn=p.hn  left outer join icd101 i on i.code=a.pdx left outer join ipt ip on ip.an=a.an  
                                       left outer join ward w on w.ward=a.ward 
                                       where a.dchdate between '{$date1}' and '{$date2}' and a.lastvisit <= 28  and a.regdate-b.dchdate<=28  
                                       and a.pdx between 'S00' and 'S09' and a.spclty in ('02');";   
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
        return $this->render('/site/pct-sur/sur4-preview',['names'=>$names,'mText'=>$this->mText,'date1'=>$date1,'date2'=>$date2,
                      'dataProvider1'=>$dataProvider1,'dataProvider2'=>$dataProvider2,'dataProvider3'=>$dataProvider3,
                      'dataProvider4'=>$dataProvider4,'dataProvider5'=>$dataProvider5
                      ]);                  
    }        
    
    public function actionNf_index() {
        $model = new Formmodel();
        $names="ผลการดำเนินงานการให้บริการ PCT-ศัลยกรรม (Necrotising fasciitis)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['nf_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/pct-sur/nf_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionNf_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t1;")->execute();
        $dt1="CREATE TEMPORARY TABLE t1 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd10 BETWEEN 'M7261'  AND 'M7269' 
                GROUP BY i.an
                );";
        $rt1 = \Yii::$app->db1->createCommand($dt1)->execute();      
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t2;")->execute();
        $dt2="CREATE TEMPORARY TABLE t2 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd10 = 'R572' 
                GROUP BY i.an
                );";
        $rt2 = \Yii::$app->db1->createCommand($dt2)->execute();      
        
        $rawData=[];
        $sql1="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
		      ) pt;";                                                       
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pname' => $value1['pname'],
               'goal' => '',
               'oct' => $value1['Oct'],
               'nov' => $value1['Nov'],
               'dec' => $value1['Dece'],
               'jan' => $value1['Jan'],
               'feb' => $value1['Feb'],
               'mar' => $value1['Mar'],
               'apr' => $value1['Apr'],
               'may' => $value1['May'],
               'jun' => $value1['Jun'],
               'jul' => $value1['Jul'],
               'aug' => $value1['Aug'],
               'sep' => $value1['Sep'],
               'total' => $value1['total'], 
        ];               
        }      
        $sql2="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis With Shock' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
			INNER JOIN t2 ON t1.an=t2.an 
		      ) pt;";                                                       
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
               'goal' => '',
               'oct' => $value2['Oct'],
               'nov' => $value2['Nov'],
               'dec' => $value2['Dece'],
               'jan' => $value2['Jan'],
               'feb' => $value2['Feb'],
               'mar' => $value2['Mar'],
               'apr' => $value2['Apr'],
               'may' => $value2['May'],
               'jun' => $value2['Jun'],
               'jul' => $value2['Jul'],
               'aug' => $value2['Aug'],
               'sep' => $value2['Sep'],
               'total' => $value2['total'], 
        ];               
        }      
        $sql3="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis เสียชีวิต' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('08','09')
		      ) pt;";                                                       
        $result3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
        foreach ($result3 as $value3) {
        $rawData[]=[
               'id' => '',
               'pname' => $value3['pname'],
               'goal' => '',
               'oct' => $value3['Oct'],
               'nov' => $value3['Nov'],
               'dec' => $value3['Dece'],
               'jan' => $value3['Jan'],
               'feb' => $value3['Feb'],
               'mar' => $value3['Mar'],
               'apr' => $value3['Apr'],
               'may' => $value3['May'],
               'jun' => $value3['Jun'],
               'jul' => $value3['Jul'],
               'aug' => $value3['Aug'],
               'sep' => $value3['Sep'],
               'total' => $value3['total'], 
        ];               
        }      
        $sql4="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis ที่รับไว้รักษาต่อ (Refer In)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    INNER JOIN referin r ON t1.vn=r.vn
		    ) pt;";                                                       
        $result4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
        foreach ($result4 as $value4) {
        $rawData[]=[
               'id' => '',
               'pname' => $value4['pname'],
               'goal' => '',
               'oct' => $value4['Oct'],
               'nov' => $value4['Nov'],
               'dec' => $value4['Dece'],
               'jan' => $value4['Jan'],
               'feb' => $value4['Feb'],
               'mar' => $value4['Mar'],
               'apr' => $value4['Apr'],
               'may' => $value4['May'],
               'jun' => $value4['Jun'],
               'jul' => $value4['Jul'],
               'aug' => $value4['Aug'],
               'sep' => $value4['Sep'],
               'total' => $value4['total'], 
        ];               
        }      
        $sql5="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Necrotising fasciitis ที่ได้รับการส่งต่อ (Refer Out)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('04')
		    ) pt;";                                                       
        $result5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
        foreach ($result5 as $value5) {
        $rawData[]=[
               'id' => '',
               'pname' => $value5['pname'],
               'goal' => '',
               'oct' => $value5['Oct'],
               'nov' => $value5['Nov'],
               'dec' => $value5['Dece'],
               'jan' => $value5['Jan'],
               'feb' => $value5['Feb'],
               'mar' => $value5['Mar'],
               'apr' => $value5['Apr'],
               'may' => $value5['May'],
               'jun' => $value5['Jun'],
               'jul' => $value5['Jul'],
               'aug' => $value5['Aug'],
               'sep' => $value5['Sep'],
               'total' => $value5['total'], 
        ];               
        }      

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/pct-sur/nf_preview',
                    ['dataProvider' => $dataProvider,
                        'names' => $names,
                        'mText' => $this->mText, 
                        'date1' => $date1, 
                        'date2' => $date2,
                        'yrs' => $yrs]);          
    }
    
    public function actionAppendicitis_index() {
        $model = new Formmodel();
        $names="ผลการดำเนินงานการให้บริการ PCT-ศัลยกรรม (Appendicitis)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['appendicitis_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/pct-sur/appendicitis_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionAppendicitis_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t1;")->execute();
        $dt1="CREATE TEMPORARY TABLE t1 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd10 IN('K352','K353','K358','K36','K37','K38') 
                GROUP BY i.an
                );";
        $rt1 = \Yii::$app->db1->createCommand($dt1)->execute();      
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t2;")->execute();
        $dt2="CREATE TEMPORARY TABLE t2 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptoprt o ON i.an=o.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND o.icd9 IN('4701','4709') 
                GROUP BY i.an
                );";
        $rt2 = \Yii::$app->db1->createCommand($dt2)->execute();      
        
        $rawData=[];
        $sql1="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendicitis ' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
		      ) pt;";                                                       
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pname' => $value1['pname'],
               'goal' => '',
               'oct' => $value1['Oct'],
               'nov' => $value1['Nov'],
               'dec' => $value1['Dece'],
               'jan' => $value1['Jan'],
               'feb' => $value1['Feb'],
               'mar' => $value1['Mar'],
               'apr' => $value1['Apr'],
               'may' => $value1['May'],
               'jun' => $value1['Jun'],
               'jul' => $value1['Jul'],
               'aug' => $value1['Aug'],
               'sep' => $value1['Sep'],
               'total' => $value1['total'], 
        ];               
        }      
        $sql2="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendectomy' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
			INNER JOIN t2 ON t1.an=t2.an 
		      ) pt;";                                                       
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
               'goal' => '',
               'oct' => $value2['Oct'],
               'nov' => $value2['Nov'],
               'dec' => $value2['Dece'],
               'jan' => $value2['Jan'],
               'feb' => $value2['Feb'],
               'mar' => $value2['Mar'],
               'apr' => $value2['Apr'],
               'may' => $value2['May'],
               'jun' => $value2['Jun'],
               'jul' => $value2['Jul'],
               'aug' => $value2['Aug'],
               'sep' => $value2['Sep'],
               'total' => $value2['total'], 
        ];               
        }      
        $sql3="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendicitis เสียชีวิต' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('08','09')
		      ) pt;";                                                       
        $result3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
        foreach ($result3 as $value3) {
        $rawData[]=[
               'id' => '',
               'pname' => $value3['pname'],
               'goal' => '',
               'oct' => $value3['Oct'],
               'nov' => $value3['Nov'],
               'dec' => $value3['Dece'],
               'jan' => $value3['Jan'],
               'feb' => $value3['Feb'],
               'mar' => $value3['Mar'],
               'apr' => $value3['Apr'],
               'may' => $value3['May'],
               'jun' => $value3['Jun'],
               'jul' => $value3['Jul'],
               'aug' => $value3['Aug'],
               'sep' => $value3['Sep'],
               'total' => $value3['total'], 
        ];               
        }      
        $sql4="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendicitis ที่รับไว้รักษาต่อ (Refer In)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    INNER JOIN referin r ON t1.vn=r.vn
		    ) pt;";                                                       
        $result4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
        foreach ($result4 as $value4) {
        $rawData[]=[
               'id' => '',
               'pname' => $value4['pname'],
               'goal' => '',
               'oct' => $value4['Oct'],
               'nov' => $value4['Nov'],
               'dec' => $value4['Dece'],
               'jan' => $value4['Jan'],
               'feb' => $value4['Feb'],
               'mar' => $value4['Mar'],
               'apr' => $value4['Apr'],
               'may' => $value4['May'],
               'jun' => $value4['Jun'],
               'jul' => $value4['Jul'],
               'aug' => $value4['Aug'],
               'sep' => $value4['Sep'],
               'total' => $value4['total'], 
        ];               
        }      
        $sql5="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย Appendicitis ที่ได้รับการส่งต่อ (Refer Out)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('04')
		    ) pt;";                                                       
        $result5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
        foreach ($result5 as $value5) {
        $rawData[]=[
               'id' => '',
               'pname' => $value5['pname'],
               'goal' => '',
               'oct' => $value5['Oct'],
               'nov' => $value5['Nov'],
               'dec' => $value5['Dece'],
               'jan' => $value5['Jan'],
               'feb' => $value5['Feb'],
               'mar' => $value5['Mar'],
               'apr' => $value5['Apr'],
               'may' => $value5['May'],
               'jun' => $value5['Jun'],
               'jul' => $value5['Jul'],
               'aug' => $value5['Aug'],
               'sep' => $value5['Sep'],
               'total' => $value5['total'], 
        ];               
        }      

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/pct-sur/appendicitis_preview',
                    ['dataProvider' => $dataProvider,
                        'names' => $names,
                        'mText' => $this->mText, 
                        'date1' => $date1, 
                        'date2' => $date2,
                        'yrs' => $yrs]);          
    }
    
    public function actionOperation_index() {
        $model = new Formmodel();
        $names="ผลการดำเนินงานการให้บริการ PCT-ศัลยกรรม (ที่ทำหัตถการ EGD/Colonoscope/Hernioraphy/Wipple Operation)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['operation_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/pct-sur/operation_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionOperation_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t1;")->execute();
        $dt1="CREATE TEMPORARY TABLE t1 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype,d.icd9
                FROM ipt i
                INNER JOIN iptoprt d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd9 IN('4513','4523','4516','5300','5302','5310','5253') 
                GROUP BY i.an
                );";
        $rt1 = \Yii::$app->db1->createCommand($dt1)->execute();      
        
        $rawData=[];
        $sql1="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'EGD (ICD9CM=4513)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE icd9='4513'
		      ) pt;";                                                       
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pname' => $value1['pname'],
               'goal' => '',
               'oct' => $value1['Oct'],
               'nov' => $value1['Nov'],
               'dec' => $value1['Dece'],
               'jan' => $value1['Jan'],
               'feb' => $value1['Feb'],
               'mar' => $value1['Mar'],
               'apr' => $value1['Apr'],
               'may' => $value1['May'],
               'jun' => $value1['Jun'],
               'jul' => $value1['Jul'],
               'aug' => $value1['Aug'],
               'sep' => $value1['Sep'],
               'total' => $value1['total'], 
        ];               
        }      
        $sql2="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'Colonoscope (ICD9CM=4516)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE icd9='4516'
		    ) pt;";                                                       
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
               'goal' => '',
               'oct' => $value2['Oct'],
               'nov' => $value2['Nov'],
               'dec' => $value2['Dece'],
               'jan' => $value2['Jan'],
               'feb' => $value2['Feb'],
               'mar' => $value2['Mar'],
               'apr' => $value2['Apr'],
               'may' => $value2['May'],
               'jun' => $value2['Jun'],
               'jul' => $value2['Jul'],
               'aug' => $value2['Aug'],
               'sep' => $value2['Sep'],
               'total' => $value2['total'], 
        ];               
        }      
        $sql3="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'EGD With Biobsy (ICD9CM=4516)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.icd9='4516'
		      ) pt;";                                                       
        $result3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
        foreach ($result3 as $value3) {
        $rawData[]=[
               'id' => '',
               'pname' => $value3['pname'],
               'goal' => '',
               'oct' => $value3['Oct'],
               'nov' => $value3['Nov'],
               'dec' => $value3['Dece'],
               'jan' => $value3['Jan'],
               'feb' => $value3['Feb'],
               'mar' => $value3['Mar'],
               'apr' => $value3['Apr'],
               'may' => $value3['May'],
               'jun' => $value3['Jun'],
               'jul' => $value3['Jul'],
               'aug' => $value3['Aug'],
               'sep' => $value3['Sep'],
               'total' => $value3['total'], 
        ];               
        }      
        $sql4="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'Hernioraphy (ICD9CM=5300,5302,5310)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.icd9 IN('5300','5302','5310')
		      ) pt;";                                                       
        $result4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
        foreach ($result4 as $value4) {
        $rawData[]=[
               'id' => '',
               'pname' => $value4['pname'],
               'goal' => '',
               'oct' => $value4['Oct'],
               'nov' => $value4['Nov'],
               'dec' => $value4['Dece'],
               'jan' => $value4['Jan'],
               'feb' => $value4['Feb'],
               'mar' => $value4['Mar'],
               'apr' => $value4['Apr'],
               'may' => $value4['May'],
               'jun' => $value4['Jun'],
               'jul' => $value4['Jul'],
               'aug' => $value4['Aug'],
               'sep' => $value4['Sep'],
               'total' => $value4['total'], 
        ];               
        }      
        $sql5="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'Wipple Operation (ICD9CM=5253)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.icd9='5253'
		    ) pt;";                                                       
        $result5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
        foreach ($result5 as $value5) {
        $rawData[]=[
               'id' => '',
               'pname' => $value5['pname'],
               'goal' => '',
               'oct' => $value5['Oct'],
               'nov' => $value5['Nov'],
               'dec' => $value5['Dece'],
               'jan' => $value5['Jan'],
               'feb' => $value5['Feb'],
               'mar' => $value5['Mar'],
               'apr' => $value5['Apr'],
               'may' => $value5['May'],
               'jun' => $value5['Jun'],
               'jul' => $value5['Jul'],
               'aug' => $value5['Aug'],
               'sep' => $value5['Sep'],
               'total' => $value5['total'], 
        ];               
        }      

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/pct-sur/operation_preview',
                    ['dataProvider' => $dataProvider,
                        'names' => $names,
                        'mText' => $this->mText, 
                        'date1' => $date1, 
                        'date2' => $date2,
                        'yrs' => $yrs]);          
    }
    
    public function actionUgibleeding_index() {
        $model = new Formmodel();
        $names="ผลการดำเนินงานการให้บริการ PCT-ศัลยกรรม (UGI Bleeding)"; 
        if($model->load(Yii::$app->request->post())){
               $date1 = $model->date1;
               $date2 = $model->date2;                   
              return $this->redirect(['ugibleeding_preview','name'=>$names,'d1'=>$date1,'d2'=>$date2]);
        }
            return $this -> render('/site/pct-sur/ugibleeding_index',['mText'=>$this->mText,'names'=>$names,'model' => $model]);
    }    
    public function actionUgibleeding_preview($name,$d1,$d2) {
        $names=$name;
        $date1=$d1;$date2=$d2;    
        $sql="select  IF(MONTH(o.vstdate)>=10,YEAR(o.vstdate)+1 ,YEAR(o.vstdate))+543 AS yrs from ovstdiag o
                where o.vstdate between '{$date1}' and '{$date2}' group by yrs;";
        $result = \Yii::$app->db1->createCommand($sql)->queryAll();      
        foreach ($result as $value) {
               $yrs = $value['yrs'];                                              
        }
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t1;")->execute();
        $dt1="CREATE TEMPORARY TABLE t1 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype,a.admdate
                FROM ipt i
                INNER JOIN an_stat a ON i.an=a.an
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND (d.icd10 BETWEEN 'K250' AND 'K269')
                    OR (d.icd10 BETWEEN 'K290' AND 'K299')
                    OR (d.icd10 BETWEEN 'K850' AND 'K859')                    
                GROUP BY i.an
                );";
        $rt1 = \Yii::$app->db1->createCommand($dt1)->execute();      
        \Yii::$app->db1->createCommand("DROP TABLE IF EXISTS t2;")->execute();
        $dt2="CREATE TEMPORARY TABLE t2 AS
                (
                SELECT i.vn,i.an,i.dchdate,i.dchtype
                FROM ipt i
                INNER JOIN iptdiag d ON i.an=d.an
                WHERE i.dchdate BETWEEN '{$date1}' AND '{$date2}'
                AND d.icd10='R571' 
                GROUP BY i.an
                );";
        $rt2 = \Yii::$app->db1->createCommand($dt2)->execute();      
        
        $rawData=[];
        $sql1="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding ' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE admdate>1
		      ) pt;";                                                       
        $result1 = \Yii::$app->db1->createCommand($sql1)->queryAll();
        foreach ($result1 as $value1) {
        $rawData[]=[
               'id' => '',
               'pname' => $value1['pname'],
               'goal' => '',
               'oct' => $value1['Oct'],
               'nov' => $value1['Nov'],
               'dec' => $value1['Dece'],
               'jan' => $value1['Jan'],
               'feb' => $value1['Feb'],
               'mar' => $value1['Mar'],
               'apr' => $value1['Apr'],
               'may' => $value1['May'],
               'jun' => $value1['Jun'],
               'jul' => $value1['Jul'],
               'aug' => $value1['Aug'],
               'sep' => $value1['Sep'],
               'total' => $value1['total'], 
        ];               
        }      
        $sql2="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding With Shock' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
			INNER JOIN t2 ON t1.an=t2.an 
		      ) pt;";                                                       
        $result2 = \Yii::$app->db1->createCommand($sql2)->queryAll();
        foreach ($result2 as $value2) {
        $rawData[]=[
               'id' => '',
               'pname' => $value2['pname'],
               'goal' => '',
               'oct' => $value2['Oct'],
               'nov' => $value2['Nov'],
               'dec' => $value2['Dece'],
               'jan' => $value2['Jan'],
               'feb' => $value2['Feb'],
               'mar' => $value2['Mar'],
               'apr' => $value2['Apr'],
               'may' => $value2['May'],
               'jun' => $value2['Jun'],
               'jul' => $value2['Jul'],
               'aug' => $value2['Aug'],
               'sep' => $value2['Sep'],
               'total' => $value2['total'], 
        ];               
        }      
        $sql3="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding With EGD' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
			INNER JOIN iptoprt i ON t1.an=i.an
                    WHERE i.icd9='4513'
		      ) pt;";                                                       
        $result3 = \Yii::$app->db1->createCommand($sql3)->queryAll();
        foreach ($result3 as $value3) {
        $rawData[]=[
               'id' => '',
               'pname' => $value3['pname'],
               'goal' => '',
               'oct' => $value3['Oct'],
               'nov' => $value3['Nov'],
               'dec' => $value3['Dece'],
               'jan' => $value3['Jan'],
               'feb' => $value3['Feb'],
               'mar' => $value3['Mar'],
               'apr' => $value3['Apr'],
               'may' => $value3['May'],
               'jun' => $value3['Jun'],
               'jul' => $value3['Jul'],
               'aug' => $value3['Aug'],
               'sep' => $value3['Sep'],
               'total' => $value3['total'], 
        ];               
        }      

        $sql4="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding เสียชีวิต' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('08','09')
		      ) pt;";                                                       
        $result4 = \Yii::$app->db1->createCommand($sql4)->queryAll();
        foreach ($result4 as $value4) {
        $rawData[]=[
               'id' => '',
               'pname' => $value4['pname'],
               'goal' => '',
               'oct' => $value4['Oct'],
               'nov' => $value4['Nov'],
               'dec' => $value4['Dece'],
               'jan' => $value4['Jan'],
               'feb' => $value4['Feb'],
               'mar' => $value4['Mar'],
               'apr' => $value4['Apr'],
               'may' => $value4['May'],
               'jun' => $value4['Jun'],
               'jul' => $value4['Jul'],
               'aug' => $value4['Aug'],
               'sep' => $value4['Sep'],
               'total' => $value4['total'], 
        ];               
        }      
        $sql5="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding ที่รับไว้รักษาต่อ (Refer In)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    INNER JOIN referin r ON t1.vn=r.vn
		    ) pt;";                                                       
        $result5 = \Yii::$app->db1->createCommand($sql5)->queryAll();
        foreach ($result5 as $value5) {
        $rawData[]=[
               'id' => '',
               'pname' => $value5['pname'],
               'goal' => '',
               'oct' => $value5['Oct'],
               'nov' => $value5['Nov'],
               'dec' => $value5['Dece'],
               'jan' => $value5['Jan'],
               'feb' => $value5['Feb'],
               'mar' => $value5['Mar'],
               'apr' => $value5['Apr'],
               'may' => $value5['May'],
               'jun' => $value5['Jun'],
               'jul' => $value5['Jul'],
               'aug' => $value5['Aug'],
               'sep' => $value5['Sep'],
               'total' => $value5['total'], 
        ];               
        }      
        $sql6="SELECT  pname,total,Oct,Nov,Dece,Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep 
                    FROM (
			SELECT 'จำนวนผู้ป่วย UGI Bleeding ที่ได้รับการส่งต่อ (Refer Out)' AS pname,
                        COUNT(t1.an) total,
                        COUNT(IF(MONTH(t1.dchdate)=10,1,NULL)) AS Oct,
                        COUNT(IF(MONTH(t1.dchdate)=11,1,NULL)) AS Nov,
                        COUNT(IF(MONTH(t1.dchdate)=12,1,NULL)) AS Dece,
                        COUNT(IF(MONTH(t1.dchdate)=1,1,NULL)) AS Jan,
                        COUNT(IF(MONTH(t1.dchdate)=2,1,NULL)) AS Feb,
                        COUNT(IF(MONTH(t1.dchdate)=3,1,NULL)) AS Mar,
                        COUNT(IF(MONTH(t1.dchdate)=4,1,NULL)) AS Apr,
                        COUNT(IF(MONTH(t1.dchdate)=5,1,NULL)) AS May,
                        COUNT(IF(MONTH(t1.dchdate)=6,1,NULL)) AS Jun,
                        COUNT(IF(MONTH(t1.dchdate)=7,1,NULL)) AS Jul,
                        COUNT(IF(MONTH(t1.dchdate)=8,1,NULL)) AS Aug,
                        COUNT(IF(MONTH(t1.dchdate)=9,1,NULL)) AS Sep
                    FROM t1 
                    WHERE t1.dchtype IN('04')
		    ) pt;";                                                       
        $result6 = \Yii::$app->db1->createCommand($sql6)->queryAll();
        foreach ($result6 as $value6) {
        $rawData[]=[
               'id' => '',
               'pname' => $value6['pname'],
               'goal' => '',
               'oct' => $value6['Oct'],
               'nov' => $value6['Nov'],
               'dec' => $value6['Dece'],
               'jan' => $value6['Jan'],
               'feb' => $value6['Feb'],
               'mar' => $value6['Mar'],
               'apr' => $value6['Apr'],
               'may' => $value6['May'],
               'jun' => $value6['Jun'],
               'jul' => $value6['Jul'],
               'aug' => $value6['Aug'],
               'sep' => $value6['Sep'],
               'total' => $value6['total'], 
        ];               
        }      

        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pageSize' => 15,
                ],
        ]);  
        return $this -> render('/site/pct-sur/ugibleeding_preview',
                    ['dataProvider' => $dataProvider,
                        'names' => $names,
                        'mText' => $this->mText, 
                        'date1' => $date1, 
                        'date2' => $date2,
                        'yrs' => $yrs]);          
    }
    
    



}