<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/26 0026
 * Time: 16:34
 */
class Taglib_Car
{
    private static $_typeid = 3;
    private static $basefield = 'a.id,
                                a.webid,
                                a.sellpoint,
                                a.aid,
                                a.kindlist,
                                a.title,
                                a.litpic,
                                a.shownum,
                                a.price,
                                a.price_date,
                                a.satisfyscore,
                                a.bookcount,
                                a.attrid,
                                a.iconlist,
                                a.carkindid';
    /**
     * @description  租车类型
     */
	 /**
     * 检测该产品模块是否安装
     * @return bool
     */
    public function right()
    {

        $bool = true;
        if (!St_Functions::is_system_app_install(self::$_typeid))
        {
            $bool = false;
        }

        return $bool;
    }
    public static function kind($params)
    {
      
        //$list=ORM::factory('car_kind')->get_all();
        $list = DB::select('id', 'kindname', 'title', 'keyword', 'description')
            ->from('car_kind')
            ->execute()
            ->as_array();

        foreach ($list as &$v)
        {
            $v['seotitle'] = $v['title'];
            $v['title'] = $v['kindname'];
        }
        return $list;
    }

    /**
     * @description 租车列表
     */
    public static function query($params)
    {



        $default = array(
            'row' => '4',
            'offset' => 0,
            'flag' => 'new',
            'kindid' => 0,
            'tagword' => ''

        );
        $params = array_merge($default, $params);
        extract($params);

        $list = null;
        switch ($flag)
        {
            case 'new':
                $list = self::query_new($params);
                break;
            case 'recommend':
                $list = self::query_recommend($params);
                break;
            case 'order':
                $list = self::query_recommend($params);
                break;
            case 'tagrelative':
                $list = self::get_car_by_tagword($row, $offset, $tagword);
                break;
            case 'theme':
                $list = self::get_car_by_themeid($row, $offset, $themeid);
                break;

        }
        foreach ($list as $k => &$v)
        {
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], self::$_typeid) + intval($v['bookcount']); //销售数量

            $v['url'] = Common::get_web_url($v['webid']) . '/cars/show_' . $v['aid'] . '.html';
            //价格
            $v['price'] = Model_Car::get_minprice($v['id'], array('info' => $v));
            //车辆属性
            $v['attrlist'] = Model_Car_attr::get_attr_list($v['attrid']);
            //车型
            $v['kindname'] = Model_Car_Kind::get_carkindname($v['carkindid']);
            $v['satisfyscore'] =St_Functions::get_satisfy(self::$_typeid,$v['id'],$v['satisfyscore'],array('suffix'=>''));
        }



        return $list;
    }

    /**
     * 获取租车套餐类型
     * @param $params
     * @return Array
     */

    public static function suit_type($params)
    {
        
        $default = array('row' => '10', 'productid' => 0);
        $params = array_merge($default, $params);
        extract($params);
        $suit = DB::select('id', 'kindname', 'description')->from('car_suit_type')
            ->where('carid', '=', ':productid')
            ->order_by('displayorder','asc')
            ->bind(':productid', $productid)
            ->execute()
            ->as_array();


        foreach ($suit as $k=>&$r)
        {
            $r['title'] = $r['kindname'];
            $rs =DB::select(array(DB::expr('count(*)'),'num'))->from('car_suit')->where('carid','=',$productid)->and_where('suittypeid','=',$r['id'])->execute()->current();
            if($rs['num']<1){
                unset($suit[$k]);
            }
        }
        return $suit;

    }


    /**
     * 获取租车套餐
     * @param $params
     * @return Array
     */

    public static function suit($params)
    {
        
        $default = array(
            'row' => '10',
            'productid' => 0,
            'suittypeid' => 0
        );

        $params = array_merge($default, $params);
        extract($params);
        $where = "WHERE carid=:productid";
        $where .= !empty($suittypeid) ? " AND suittypeid=:suittypeid" : '';
        $sql = "SELECT * FROM `sline_car_suit` $where order by displayorder asc";
        $suit = DB::query(1, $sql)->parameters(array(':productid' => $productid, ':suittypeid' => $suittypeid))->execute()->as_array();

        foreach ($suit as &$r)
        {
            $r['title'] = $r['suitname'];
            $r['price'] = Model_Car::get_minprice($r['carid'],$r['id']);//最低价
            $time=DB::select('day')->from('car_suit_price')->where("carid={$productid} and suitid={$r['id']} and number!=0 and day>".strtotime(date('Y-m-d')))->order_by('day','asc')->execute()->current();
            $r['startTime']=!empty($time)?$time['day']:time();
            $r['paytype_name'] = Model_Member_Order::get_paytype_name($r['paytype']);
        }
        unset($r);
        usort($suit,function ($a,$b){
            if($a['price']==$b['price'])
            {
                return 0 ;
            }
            return $a['price'] < $b['price'] ? -1 : 1;
        });
        return $suit;

    }

    /**
     * @desc 最新排序
     * @param $params
     * @return mixed
     */
    public static function query_new($params)
    {
        
        extract($params);
        $w = 'where a.ishidden=0';
        $orderBy = "ORDER BY a.modtime DESC";
        $values = array();

        //属性参数
        if (!empty($attrid))
        {
            $values[':attrid'] = $attrid;
            $w .= " and FIND_IN_SET(:attrid,a.attrid)";
        }
        //车型参数
        if (!empty($kindid))
        {
            $values[':carkindid'] = $kindid;
            $w .= " and carkindid=:carkindid";
        }
        //判断目的地
        if (empty($destid))
        {
            $sql = "SELECT " . self::$basefield . " FROM sline_car a LEFT JOIN sline_allorderlist b";
            $sql .= " ON(a.id=b.aid AND b.typeid=3) {$w} {$orderBy},IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC limit {$offset},{$row}";
        }
        else
        {
            $w .= " AND FIND_IN_SET(:destid,kindlist)";
            $values[':destid'] = $destid;
            $sql = "SELECT " . self::$basefield . " FROM sline_car a LEFT JOIN sline_kindorderlist b";
            $sql .= " ON(a.id=b.aid AND b.typeid=3 AND b.classid=:destid) {$w} {$orderBy} ,IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC  limit {$offset},{$row}";
        }

        $list = DB::query(Database::SELECT, $sql)->parameters($values)->execute()->as_array();


        return $list;
    }

    /**
     * @desc 按displayorder排序
     * @param $params
     */
    public static function query_recommend($params)
    {
       
        extract($params);
        $w='where a.ishidden=0';
        $orderBy="ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime desc";
        $values=array();

        //属性参数
        if (!empty($attrid))
        {
            $values[':attrid'] = $attrid;
            $w .= " and FIND_IN_SET(:attrid,a.attrid)";
        }

        if (!empty($kindid))
        {
            $values[':carkindid'] = $kindid;
            $w .= " and carkindid=:carkindid";
        }
        //判断目的地
        if (empty($destid))
        {
            $sql = "SELECT " . self::$basefield . " FROM sline_car a LEFT JOIN sline_allorderlist b";
            $sql .= " ON(a.id=b.aid AND b.typeid=3) {$w} {$orderBy}  limit {$offset},{$row}";
        }
        else
        {
            $w .= " AND FIND_IN_SET(:destid,kindlist)";
            $values[':destid'] = $destid;
            $sql = "SELECT " . self::$basefield . " FROM sline_car a LEFT JOIN sline_kindorderlist b";
            $sql .= " ON(a.id=b.aid AND b.typeid=3 AND b.classid=:destid) {$w} {$orderBy} limit {$offset},{$row}";
        }

        $list = DB::query(Database::SELECT, $sql)->parameters($values)->execute()->as_array();
        return $list;
    }

    public static function get_car_by_tagword($row, $offset, $tagword)
    {
        $offset = intval($offset);
        $row = intval($row);
        $tagword_arr = explode(",", $tagword);
        if (count($tagword_arr) <= 0)
            return array();

        $sql = "SELECT " . self::$basefield . " FROM sline_car a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=3) ";
        $sql .= "WHERE a.ishidden=0 AND ( ";
        foreach ($tagword_arr as $tagword_item)
        {
            $sql .= "FIND_IN_SET('{$tagword_item}',a.tagword) OR ";
        }
        $sql = rtrim($sql, " OR ");
        $sql .= ") ";
        $sql .= "ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        $sql .= "LIMIT {$offset},{$row}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }

    /**
     * 获取租车类型
     * @param $params
     * @return array
     */
    public static function kind_list($params)
    {


        $default = array('row' => '10');
        $params = array_merge($default, $params);
        extract($params);

        $arr = DB::select('id', 'kindname', 'title', 'keyword', 'description')
            ->from('car_kind')
            ->where('webid', '=', 0)
            ->order_by('displayorder','asc')
            ->limit($row)
            ->execute()
            ->as_array();
        foreach ($arr as &$row)
        {
            $row['seotitle'] = $row['title'];
            $row['title'] = $row['kindname'];
        }
        return $arr;
    }

    /**
     * 获取车辆属性
     * @param $params
     * @return array
     */
    public static function attr_list($params)
    {
        
        $default = array('row' => '10');
        $params = array_merge($default, $params);
        extract($params);
        $arr = ORM::factory('car_attr')
            ->where("webid=0 AND isopen=1 AND pid>0")
            ->order_by('displayorder','asc')
            ->limit($row)
            ->get_all();
        foreach ($arr as &$v)
        {
            $v['title'] = $v['attrname'];
        }
        return $arr;
    }

    public static function get_car_by_themeid($row, $offset, $themeid)
    {
        $sql = "SELECT " . self::$basefield . " FROM sline_car a ";
        $sql .= "LEFT JOIN `sline_allorderlist` b ";
        $sql .= "ON (a.id=b.aid and b.typeid=3) ";
        $sql .= "WHERE a.ishidden=0 AND FIND_IN_SET($themeid,a.themelist) ORDER BY IFNULL(b.displayorder,9999) asc,a.modtime desc,a.addtime DESC ";
        return DB::query(1, $sql)->execute()->as_array();

    }

    /**
     * 获取租车的价格区间
     * 
     */
    public static function price_list()
    {
        $suit = ORM::factory('car_pricelist')
            ->order_by('min', 'asc')
            ->get_all();
        $result = array();
       foreach ($suit as $key => $val) 
       {
            $result[$key]['id'] = $val['id'];
            $result[$key]['title'] = '￥'.$val['min'].'-￥'.$val['max'];
       }
       return $result;
    }
}