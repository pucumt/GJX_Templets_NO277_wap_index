<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>{$seoinfo['seotitle']}-{$webname}</title>
        {if $seoinfo['keyword']}
        <meta name="keywords" content="{$seoinfo['keyword']}"/>
        {/if}
        {if $seoinfo['description']}
        <meta name="description" content="{$seoinfo['description']}"/>
        {/if}
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        {Common::get_user_css('GJX_Templets_NO277_wap_index/css/base.css')}
        {Common::get_user_css('GJX_Templets_NO277_wap_index/css/header.css')}
        {Common::get_user_css('GJX_Templets_NO277_wap_index/css/home.css')}
        {Common::get_user_css('GJX_Templets_NO277_wap_index/css/footer.css')}
        {Common::get_user_css('GJX_Templets_NO277_wap_index/css/swiper.min.css')}
        {Common::get_user_js('GJX_Templets_NO277_wap_index/js/lib-flexible.js')}
        {Common::get_user_js('GJX_Templets_NO277_wap_index/js/jquery.min.js')}
        {Common::get_user_js('GJX_Templets_NO277_wap_index/js/swiper.min.js')}
        {Common::get_user_js('GJX_Templets_NO277_wap_index/js/slideTabs.js')}
        {Common::get_user_js('GJX_Templets_NO277_wap_index/js/layer.js')}
	</head>

	<body>

        {request "pub/header_new/default_tpl/header_new2/typeid/$typeid"}
		<!-- 头部 -->

		<div class="swiper-container swiper-banner-container">
			<ul class="swiper-wrapper">
                {st:ad action="getad" name="carousel-277-Ad"}
                {loop $data['aditems'] $v}
				<li class="swiper-slide">
					<a class="item" href="{$v['adlink']}"><img src="{Common::img($v['adsrc'])}" alt="" /></a>
				</li>
                {/loop}
                {/st}
			</ul>
            <!-- 分页器 -->
            <div class="swiper-pagination"></div>
		</div>
		<!-- banner -->

		<div class="swiper-container swiper-menu-container">
            {st:channel action="getchannel" row="100"}
            {php}
            $check_arr = array_chunk($data,10);
            {/php}
            {/st}
			<ul class="swiper-wrapper">
                {loop $check_arr $rows}
				<li class="swiper-slide">
                    {loop $rows $row}
					<a class="item" href="{$row['url']}">
						<img src="{$row['ico']}" style="max-width:45px;max-height:45px;" alt="" />
						<span class="menu-name">{$row['title']}</span>
					</a>
                    {/loop}
				</li>
                {/loop}
			</ul>
            <!-- 分页器 -->
            <div class="swiper-pagination"></div>
		</div>
		<!-- nav -->

		<div class="hot-module">
			<div class="hot-module-con clearfix">
				<div class="hot-module-b-ad">
                    {st:ad action="getad" name="Navigation-Lower-Ad1" return="img"}
					<a class="ad-item" href="{$img['adlink']}"><img src="{Common::img($img['adsrc'])}" alt=""></a>
                    {/st}
				</div>
				<div class="hot-module-s-ad">
                    {st:ad action="getad" name="Navigation-Lower-Ad2"}
                    {loop $data['aditems'] $v}
					<a class="ad-item" href="{$v['adlink']}"><img src="{Common::img($v['adsrc'])}" alt=""></a>
                    {/loop}
                    {/st}
				</div>
			</div>
		</div>
		<!--广告模块 -->
<!-- 
		<div class="destination-module">
			<div class="destination-bar"><span class="bar-tit">推荐目的地</span></div>
			<div class="destination-wrap">
				<ul class="destination-list clearfix">
                    {st:destination action="query" flag="order"  row="9" return="destlist"}
                    {loop $destlist $dest}
					<li>
						<a class="item" href="{$cmsurl}{$dest['pinyin']}">
							<div class="txt">{St_Functions::cut_html_str(strip_tags($dest['kindname']),'7')}</div>
						</a>
					</li>
                    {/loop}
                    {/st}
				</ul>
				<div class="module-more-bar">
					<a class="module-more-link" href="{$cmsurl}destination/">目的地大全</a>
				</div>
			</div>
		</div> -->
		<!-- 目的地模块 -->

		<!--<div class="ad-module-bar">
			<a class="ad-item" href="">
                {st:ad action="getad" name="Destination-Lower-Ad" return="img"}
                
				<img src="{Common::img($img['adsrc'],405,97)}" alt="">
               
                {/st}
			</a>
		</div>-->
		<!-- 广告 -->
		{if $channel['article']['isopen']}
		<div class="article-module-container">
			<div class="article-module-bar">热门攻略</div>
			<div class="article-module-wrap">
                {st:article action="query" flag="order" row="1" return="article"  }
                {loop $article  $a}
					<div class="article-module-list">
						<a class="article-item" href="{$a['url']}">
							<img src="{Common::img($a['litpic'],350,150)}" alt="{$a['title']}">
							<div class="item-name">{$a['title']}</div>
						</a>
					</div>
                {/loop}
                {/st}
				<ul class="article-list-box clearfix">
                    {st:article action="query" flag="order" row="3" return="article"  }
					{loop $article  $at}
					{if $n!=1}
						<li>
							<a class="article-item" href="{$at['url']}">
								<div class="pic"><img src="{Common::img($at['litpic'],170,85)}" alt="{$at['title']}"></div>
								<div class="item-name">{$at['title']}</div>
							</a>
						</li>
					{/if}
                    {/loop}
                    {/st}
				</ul>
			</div>
			<div class="module-more-bar">
				<a class="module-more-link" href="{$cmsurl}raiders/all">查看更多</a>
			</div>
		</div>
		<!-- 攻略模块 -->
		{/if}
		<div class="product-container" id="productContainer">
			<div class="product-tab-bar" id="productTabBar">
                {st:channel action="getchannel" row="3"}
				{php}$k=0;{/php}
                {loop $data $da}				
				{if in_array($da['m_typeid'],array(1))}
					<span {if $k==0} class="item active"{else}  class="item" {/if}>
						热门{$da['title']}				
					</span>
					{php}$k++;{/php}
				{/if}
                {/loop}

			</div>
			<div class="product-tab-box" id="productTabBox">

            {loop $data $da}

            {if $da['m_typeid']==1}
                {st:line action="query" flag="order" row="5" return="info"}<!--线路-->
            {elseif $da['m_typeid']==2}
                {st:hotel action="query" flag="order" row="5" return="info"}<!--酒店-->
            {elseif $da['m_typeid']==3}
                {st:car action="query" flag="order" row="5" return="info"}<!--租车-->
            {elseif $da['m_typeid']==5}
                {st:spot action="query" flag="order" row="5" return="info"}<!--景点门票-->
            {elseif $da['m_typeid']==13}
                {st:tuan action="query" flag="order" row="5" return="info"}<!--团购-->
			{elseif $da['m_typeid']==104}
                {st:ship action="query" flag="order" row="5" return="info"}<!--邮轮-->
            {elseif $da['m_typeid']==114}
                {st:outdoor action="query" flag="order" row="5" return="info" }<!--户外活动-->
			{elseif $da['m_typeid']==105}
                {st:outdoor action="query" flag="order" row="5" return="info" }<!--活动-->
			{elseif $da['m_typeid']==8}
                {st:visa action="query" flag="order" row="5" return="info" }<!--签证-->
            {/if}
				<div class="product-tab-wrap">
					<ul class="product-mass-list">
                        {loop $info $io}
						<li>
						{if $da['m_typeid']!=13}
							<a class="pdt-item" href="{$io['url']}">
								<div class="info-hd">
									<img class="img" src="{Common::img($io['litpic'],375,187)}" alt="">
									{if !empty($io['startcity'])}
										<span class="label">
												{St_Functions::cut_html_str(strip_tags($io['startcity']),'7')}出发
										</span>
									{/if}
										<span class="price">
											{if !empty($io['price'])}&yen;<span class="num">{$io['price']}</span>起{else}<span class="num">电询</span>{/if}
										</span>
									<div class="data">
										<span class="db">
										{if !empty($io['bookcount'])}
											{if $da[m_typeid]==2 || $da[m_typeid]==3 || $da[m_typeid]==5 || $da[m_typeid]==229 || $da[m_typeid]==8}
												{$io['bookcount']}人点评
											{else}
												{$io['bookcount']}人出游
											{/if}
										{/if}
										</span>
										<span class="db">
										{if !empty($io['satisfyscore'])}
                                            {if substr($io['satisfyscore'],-1)=='%'}
                                                {$io['satisfyscore']}满意
                                            {else}
                                                {$io['satisfyscore']}%满意
                                            {/if}
										{/if}
                                        </span>
									</div>
								</div>
								<div class="info-bd">
									{if !empty($io['title'])}
										<div class="name">{$io['title']}</div>
									{/if}
									{if !empty($io['sellpoint'])}
										<div class="txt">{$io['sellpoint']}</div>
									{/if}
									{if !empty($io['attrlist'])}
										<div class="attr">
											{loop $io['attrlist'] $attr_info}
												<span class="sx">{$attr_info['attrname']}</span>
											{/loop}
										</div>
									{/if}
								</div>
							</a>
						{else}
							<a class="pdt-item" href="{$io['url']}">
								<div class="info-hd">
									<img class="img" src="{Common::img($io['litpic'],375,187)}" alt="">
									{if $io['starttime'] > time()}
										<span class="comming"></span>
									{elseif $io['totalnum']==0}
										<span class="sold-out"></span>
									{/if}
									{if !empty($io['price'])}<span class="price">&yen;<span class="num">{$io['price']}</span></span>{else}<span class="num">电询</span>{/if}
									<div class="data">
										<span class="db">
											{if !empty($io['virtualnum'])}
												{$io['virtualnum']}人已购
											{/if}
										</span>
										<span class="db">
										{if !empty($io['satisfyscore'])}
                                            {if substr($io['satisfyscore'],-1)=='%'}
                                                {$io['satisfyscore']}满意
                                            {else}
                                                {$io['satisfyscore']}%满意
                                            {/if}
										{/if}
										</span>
									</div>
								</div>
								<div class="info-bd">
									{if !empty($io['title'])}
										<div class="name">{$io['title']}</div>
									{/if}
									{if !empty($io['sellpoint'])}
										<div class="txt">{$io['sellpoint']}</div>
									{/if}
									{if !empty($io['endtime']) || !empty($io['starttime'])}
									{if $io['totalnum']!=0}
										<div class="count-down-bar">
											<span class="th">{if $io['starttime'] > time()} 距离开始 {else} 距离结束 {/if}</span>
											<span id="day_show_{$n}" class="item"></span>
											<span class="fh">:</span>
											<span id="hour_show_{$n}" class="item"></span>
											<span class="fh">:</span>
											<span id="minute_show_{$n}" class="item"></span>
											<span class="fh">:</span>
											<span id="second_show_{$n}" class="item"></span>
										</div>
									{/if}
									{/if}
								</div>
							</a>
							{if $io['starttime'] > time()}
								{php $time = $io['starttime']-time();}
							{else}
								{php $time = $io['endtime']-time();}
							{/if}
						{/if}
						</li>
						{if $da['m_typeid']==13}
						<script type="text/javascript">
							var time = {$time};
							if(time>0){
								timer(time);
							}else{
								timer(0)
							}
							function timer(intDiff) {
								window.setInterval(function () {
									var day = 0,
										hour = 0,
										minute = 0,
										second = 0;//时间默认值
									if (intDiff > 0) {
										day = Math.floor(intDiff / (60 * 60 * 24));
										hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
										//hour = Math.floor(intDiff / (60 * 60));
										minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
										second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
									}
									if (minute <= 9) minute = '0' + minute;
									if (second <= 9) second = '0' + second;
									$('#day_show_{$n}').html(day);
									$('#hour_show_{$n}').text(hour);
									$('#minute_show_{$n}').html(minute);
									$('#second_show_{$n}').html(second);
									intDiff--;
								}, 1000);
							}
						</script>
						{/if}
                        {/loop}
					</ul>
					<div class="module-more-bar">
					{if empty($info) || count($info)<5}
						
					{else}
						<a class="module-more-link" href="{$da['m_url']}all">查看更多{$da['title']}</a>
					{/if}
					</div>
				</div>
            {/st}
            {/loop}
			</div>
		</div>
		<!-- 产品列表 -->
		
		{request "pub/code"}
		{request "pub/footer/default_tpl/footer2"}
		{if !empty($GLOBALS['cfg_m_phone'])}
        <a href="tel:{$GLOBALS['cfg_m_phone']}" class="call-telephone"></a>
		{/if}
		<!-- 公用底部 -->

		

		<a href="javascript:;" class="back-top" id="backTop"></a>


		<script type="text/javascript">
            var SITEURL = "{$cmsurl}";

			//轮播图
            var BannerSwiper = new Swiper ('.swiper-banner-container', {
				autoplay:3000,
				autoplayDisableOnInteraction : false,
                pagination: '.swiper-banner-container .swiper-pagination',
                observer:true,
			    observeParents:true
			});

			//导航
            var MenuSwiper = new Swiper ('.swiper-menu-container', {
                pagination: '.swiper-menu-container .swiper-pagination',
                observer:true,
			    observeParents:true
			});

			//定位导航
			var productContainer = document.getElementById("productContainer"),
				productTabBar = document.getElementById("productTabBar"),
				offsetTop = productContainer.offsetTop;

			window.onscroll = function(){
				var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
				
				if( scrollTop > offsetTop ){
					productTabBar.classList.add("fixed")
				}
				else{
					productTabBar.classList.remove("fixed")
				};

				if( scrollTop > 300 )
					backTop.style.display = 'block'
				else
					backTop.style.display = 'none'

			};

			//模块切换
			var tabBarNav = productTabBar.getElementsByClassName("item"),
				productTabWrap = document.getElementsByClassName("product-tab-wrap"),
				pdtOffsetTop = productContainer.offsetTop;

			productTabWrap[0].style.display = 'block';
			for(i=0;i<tabBarNav.length;i++){
				tabBarNav[i].index = i;
				tabBarNav[i].onclick = function(){

					document.body.scrollTop = document.documentElement.scrollTop = pdtOffsetTop;

					for(i=0;i<tabBarNav.length;i++){
						tabBarNav[i].classList.remove('active');
						productTabWrap[i].style.display = 'none'
					}
					this.classList.add('active');
					productTabWrap[this.index].style.display = 'block'
				}
			};

			//返回顶部
			var backTop = document.getElementById("backTop");
			backTop.onclick = function(){
				document.documentElement.scrollTop = document.body.scrollTop = 0
			}

		</script>
	</body>

</html>