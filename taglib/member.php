<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/10
 * Time: 9:48
 * 游记
 */
class Taglib_member {
    //用户
    public static function a($member)
    {
        $sql = "SELECT litpic ,nickname  FROM sline_member  where mid = $member ";
        $list = DB::query(1, $sql)->execute()->as_array();
        return $list;
    }
    //目的地
    public static function destinations($id)
    {
        $sql = "SELECT count(*) as tongji  FROM sline_photo_picture  where pid = $id ";
        $num = DB::query(1, $sql)->execute()->as_array();
        return $num;

    }
   //文章
    public static function article()
    {
        $true =St_Functions::is_system_app_install(4);
        if ($true == 1){
            $sql = "SELECT count(*) as tongji FROM sline_article where ishidden = 0 ";
            $list1 = DB::query(1, $sql)->execute()->as_array();
        }
        $true =St_Functions::is_system_app_install(101);
        if($true == 1){
            $sql = "SELECT count(*) as tongji FROM sline_notes where status = 1 ";
            $list2 = DB::query(1, $sql)->execute()->as_array();
        }
       $list =$list1[0]['tongji']+$list2[0]['tongji'];
        return $list;
    }
    //评论
    public static function comment()
    {
        $sql = "SELECT count(*) as tongji  FROM sline_comment  ";
        $list = DB::query(1, $sql)->execute()->as_array();
        return $list;
    }

    //报名人数
    public static function count($id)
    {
        $count =0;
        $sql = "SELECT sum(adultnum + childnum) as count  FROM sline_jieban_join where jiebanid = $id ";
        $list = DB::query(1, $sql)->execute()->as_array();
        return $list;
    }
    //剩余天数
    public static function time($id)
    {
        $t =time();
        $sql = "SELECT (UNIX_TIMESTAMP(startdate)-$t) as time  FROM sline_jieban where id = $id ";
        $list = DB::query(1, $sql)->execute()->as_array();
        return $list;
    }

    public static function channel_nav()
    {
        $pinyin =DB::select('pinyin')->from('model')->where('id','=',1)->execute()->get('pinyin');
        $arr = array();
        if ($pinyin)
        {
            //对应目的地表
            $table = 'sline_' . $pinyin . '_kindlist';
            $sql = "SELECT a.id,a.kindname,a.pinyin FROM `sline_destinations` a LEFT JOIN ";
            $sql .= "`$table` b ON (a.id=b.kindid) ";
            $sql .= "WHERE FIND_IN_SET(1,a.opentypeids) AND b.isnav=1 AND a.isopen=1 ";
            $sql .= "ORDER BY IFNULL(a.displayorder,9999) ASC ";
            $sql .= "LIMIT 0,5";
            $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();
        }
        return $arr;
    }



}
