<?php
/**
 * Created by PhpStorm.
 * User: pritesh
 * Date: 21/5/16
 * Time: 9:40 PM
 */

namespace backend\models;


class ArticleStatistics
{

    public static function getStats($data){
        $return_array = [
            'total' => 0,
            'current' => 0,
            'accepted' => 0,
            'rejected' => 0,
            'payment_done' => 0,
            'published' => 0,
        ];
        if(isset($data['voliss_id']) || isset($data['conf_id'])){
            $vc_label = isset($data['voliss_id'])? 'voliss_id' : 'conf_id';
            $vc_id = isset($data['voliss_id'])? $data['voliss_id'] : $data['conf_id'];
            if(empty($vc_id)){
                $vc_id = 0;
                $operator = "!=";
            }else{
                $operator = "=";
            }
            $total = Article::find()->where([$operator, $vc_label, $vc_id])->count();
            $published = Article::find()->with('published')->where(['is_deleted'=>0, 'status'=>'15'])->andWhere([$operator, $vc_label, $vc_id])->count();
            $rejected = Article::find()->where(['status'=>6, 'is_deleted'=>0])->andWhere([$operator, $vc_label, $vc_id])->count();
            $deleted = Article::find()->where(['is_deleted'=>1])->andWhere([$operator, $vc_label, $vc_id])->count();
            $current = $total - $published - $rejected - $deleted;
            $accepted = Article::find()->where(['status'=>5, 'is_deleted'=>0])->andWhere([$operator, $vc_label, $vc_id])->count();
            $payment_done = Article::find()->where(['status'=>7, 'is_deleted'=>0])->andWhere([$operator, $vc_label, $vc_id])->count();

            $return_array = [
                'total' => $total,
                'current' => $current,
                'accepted' => $accepted,
                'rejected' => $rejected,
                'payment_done' => $payment_done,
                'published' => $published,
            ];
        }

        return $return_array;
    }
}