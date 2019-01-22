<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
        {if $seoinfo['keyword']}
        <meta name="keywords" content="{$seoinfo['keyword']}" />
        {/if}
        {if $seoinfo['description']}
        <meta name="description" content="{$seoinfo['description']}" />
        {/if}
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        {Common::get_user_css('GJX_Templets_NO279_wap_lineIndex/css/base.css')}
        {Common::get_user_css('GJX_Templets_NO279_wap_lineIndex/css/header.css')}
        {Common::get_user_css('GJX_Templets_NO279_wap_lineIndex/css/home.css')}
        {Common::get_user_css('GJX_Templets_NO279_wap_lineIndex/css/footer.css')}
        {Common::get_user_css('GJX_Templets_NO279_wap_lineIndex/css/swiper.min.css')}
        {Common::get_user_js('GJX_Templets_NO279_wap_lineIndex/js/lib-flexible.js')}
	</head>

	<body>

		{request "pub/header_new/default_tpl/header_new2/typeid/$typeid"}
		<!-- 头部 -->

		<div class="search-area-bar">
			<input class="search-area-text" type="text" name="" placeholder="搜索{$channelname}" />
			<i class="search-btn-icon"></i>
		</div>
		<!-- 搜索 -->

		<div class="swiper-container swiper-banner-container">
			<ul class="swiper-wrapper">
                {st:ad action="getad" name="lineCarousel-Ad"}
                {loop $data['aditems'] $v}
                    <li class="swiper-slide">
                        <a class="item" href="{$v['adlink']}"><img src="{Common::img($v['adsrc'],375,95)}" alt="" /></a>
                    </li>
				{/loop}
                {/st}
			</ul>
            <!-- 分页器 -->
            <div class="swiper-pagination"></div>
		</div>
		<!-- banner -->

		<div class="theme-module-block">
			<ul class="tmb-list clearfix">
                {st:attr action="query" typeid="1" flag="subordinate" row="9" limit="1" return="info"}
                {loop $info $in}
				    <li><a class="item" href="{$cmsurl}lines/all-0-0-0-0-0-{$in['id']}-1">{St_Functions::cut_html_str(strip_tags($in['attrname']),'7')}</a></li>
				{/loop}
                {/st}
			</ul>
		</div>
		<!-- 主题模块 -->

		<div class="destination-module">
			<div class="destination-bar">热门目的地</div>
			<div class="destination-wrap">
				<ul class="destination-list clearfix">
                    {st:dest action="query" typeid="1" flag="channel_nav" row="6"}
                    {loop $data $li}
                        <li>
                            <a class="item" href="{$li['pinyin']}">
                                <img src="{Common::img($li['litpic'],109,109)}" alt="">
                                <div class="name">{St_Functions::cut_html_str(strip_tags($li['kindname']),'4')}</div>
                            </a>
                        </li>
                    {/loop}
                    {/st}
				</ul>
			</div>
		</div>
		<!-- 目的地模块 -->
		
		<div class="product-recommend-module">
			<div class="product-recommend-bar">线路推荐</div>
			<div class="swiper-container product-recommend-block">
				<ul class="swiper-wrapper">
                    {st:line action="query" flag="order" row="6" return="line"}
                    {loop $line $li}
                        <li class="swiper-slide">
                            <a href="{$li['url']}" class="item">
                                <div class="pic"><img src="{Common::img($li['litpic'],138,94)}" alt=""></div>
                                <div class="info">
                                    <div class="tit">{$li['title']}</div>
                                    <div class="price">{if !empty($li['price'])}&yen;<span class="num">{$li['price']}</span>起{else}电询{/if}</div>
                                </div>
                            </a>
                        </li>
                    {/loop}
                    {/st}
				</ul>
			</div>
		</div>
		<!-- 线路推荐 -->

		<div class="product-container" id="productContainer">
			<div class="swiper-container product-tab-bar" id="productTabBar">
				<ul class="swiper-wrapper">
                    {st:attr action="query" typeid="1" flag="subordinate" row="5" limit="2" return="info"}
                    {loop $info $dt}
					    <li {if $n==1} class="swiper-slide active"{else} class="swiper-slide"{/if}>{$dt['attrname']}</li>
                    {/loop}
				</ul>
			</div>
			<div class="product-tab-box" id="productTabBox">
                {loop $info $ds}
				<div class="product-tab-wrap">
					<ul class="product-mass-list">
                        {st:line action="query" flag="attr" attrid="$ds['id']" return="list" row="5"}
                        {loop $list $lt}
						<li>
							<a class="pdt-item" href="{$lt['url']}">
								<div class="info-hd">
									<img class="img" src="{Common::img($lt['litpic'],374,187)}" alt="{$lt['title']}">
									{if !empty($lt['startcity'])}<span class="label">{St_Functions::cut_html_str(strip_tags($lt['startcity']),'4')}出发</span>{/if}
									<span class="price">{if !empty($lt['price'])}&yen;<span class="num">{$lt['price']}</span>起{else}电询{/if}</span>
									<div class="data">
										<span class="db">{if !empty($lt['bookcount'])}{$lt['bookcount']}人出游{/if}</span>
										<span class="db">
                                            {if substr($lt['satisfyscore'],-1)=='%'}
                                                {$lt['satisfyscore']}满意
                                            {else}
                                                {$lt['satisfyscore']}%满意
                                            {/if}
                                        </span>
									</div>
								</div>
								<div class="info-bd">
								{if !empty($lt['title'])}
									<div class="name">{$lt['title']}</div>
								{/if}
								{if !empty($lt['sellpoint'])}
									<div class="txt">{$lt['sellpoint']}</div>
								{/if}
								{if !empty($lt['attrlist'])}
									<div class="attr">
                                        {loop $lt['attrlist'] $attr_info}
                                        <span class="sx">{$attr_info['attrname']}</span>
                                        {/loop}
									</div>
								{/if}
								</div>
							</a>
						</li>
                        {/loop}
                        
					</ul>
					
					<div class="module-more-bar">
						{if empty($list) || count($list)<5}
						{else}
						<a class="module-more-link" href="{$cmsurl}lines/all-0-0-0-0-0-{$ds['id']}-1">查看更多线路</a>
						{/if}
					</div>
					
				</div>
				{/st}
				<!-- 国内游 -->
                {/loop}
			</div>
		</div>
		<!-- 产品列表 -->

        {request "pub/footer/default_tpl/footer2"}
		<!-- 公用底部 -->

		<a href="javascript:;" class="back-top" id="backTop"></a>

        {Common::get_user_js('GJX_Templets_NO279_wap_lineIndex/js/swiper.min.js')}
        {Common::get_user_js('GJX_Templets_NO279_wap_lineIndex/js/zepto.js')}
		<script type="text/javascript">
            var SITEURL = "{$cmsurl}";

            //搜索
            $('.search-btn-icon').click(function(){
                var keyword = $('.search-area-text').val();
                var url = SITEURL + 'lines/all';

                if(keyword!=''){
                    url+="?keyword="+encodeURIComponent(keyword);
                }
                window.location.href = url;
            })

			//头部下拉导航
			$(".st-user-menu").on("click", function() {
				$(".header-menu-bg,.st-down-bar").show();
					$("body").css("overflow", "hidden")
				});

			$(".header-menu-bg").on("click", function() {
				$(".header-menu-bg,.st-down-bar").hide();
				$("body").css("overflow", "auto");
			});
			
			//轮播图
            var BannerSwiper = new Swiper ('.swiper-banner-container', {
				autoplay:3000,
				autoplayDisableOnInteraction : false,
                pagination: '.swiper-banner-container .swiper-pagination',
                observer:true,
			    observeParents:true
			});

			//推荐产品
            var productRecommend = new Swiper ('.product-recommend-block', {
            	slidesPerView:2.45,
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

			//产品切换
            var myProductTabBar = new Swiper ('.product-tab-bar', {
            	slidesPerView: "auto",
                observer:true,
			    observeParents:true
			});

			//模块切换
			var tabBarNav = productTabBar.getElementsByClassName("swiper-slide"),
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