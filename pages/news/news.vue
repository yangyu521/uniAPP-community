<template>
	<view>
		<!-- 导航栏 -->
		<uni-nav-bar :border="false" :fixed="true" :statusBar="true" @clickRight="openAddInput">
			<view class="flex align-center justify-center w-100">
				<!-- <view class="font-lg text-main mx-1">关注</view> -->
				<view class="mx-1" v-for="(item,index) in tabBars" :key="index" :class="tabIndex === index ? 'font-lg text-main' : 'font-md text-light-muted'"
				 @click="changeTab(index)">{{item.name}}</view>
			</view>
			<text class="iconfont icon-fatie_icon" slot="right"></text>
		</uni-nav-bar>

		<swiper :current="tabIndex" :duration="150" :style="'height:'+scrollH+'px'" @change="onChangeTab">
			<!-- 关注 -->
			<swiper-item>
				<scroll-view scroll-y="true" :style="'height:'+scrollH+'px'"@scrolltolower="loadmoreEvent">
					<block v-for="(item,index) in list" :key="index">
						<common-list :item="item" :index="index" @doSupport="doSupport"></common-list>
						<divider></divider>
					</block>
					<load-more :loadMore="loadMore"></load-more>
				</scroll-view>
			</swiper-item>
			<!-- 话题 -->
			<swiper-item>
				<scroll-view scroll-y="true" :style="'height:'+scrollH+'px'">
					<!-- 热门分类 -->
					<hot-cate :hotCate="hotCate"></hot-cate>
					<view class="p-2">
						<view class="bg-light rounded flex justify-center align-center text-secondary" @click="openSearch">
							<text class="iconfont icon-sousuo mr-2"></text>
							搜索话题
						</view>
					</view>
					<!-- 轮播图 -->
					<swiper :indicator-dots="true" :autoplay="true" :interval="3000" :duration="1000" :circular="true" class="px-2 pb-2">
						<swiper-item>
							<image src="@/static/demo/banner1.jpg" style="height: 300rpx;" class="w-100 rounded"></image>
						</swiper-item>
						<swiper-item>
							<image src="@/static/demo/banner2.jpg" style="height: 300rpx;" class="w-100 rounded"></image>
						</swiper-item>
						<swiper-item>
							<image src="@/static/demo/banner3.jpg" style="height: 300rpx;" class="w-100 rounded"></image>
						</swiper-item>
					</swiper>
					<divider></divider>
					<!-- 最近更新 -->
					<view class="p-2 font-ms">最近更新</view>
					<!-- 话题列表组件 -->
					<block v-for="(item,index) in topicList" :key="index">
						<topic-list :item="item" :index="index"></topic-list>
					</block>
				</scroll-view>
			</swiper-item>
		</swiper>


	</view>
</template>

<script>
	import uniNavBar from "@/components/uni-ui/uni-nav-bar/uni-nav-bar.vue"
	import commonList from "@/components/common/common-list.vue"
	import loadMore from "@/components/common/load-more.vue"
	import hotCate from "@/components/news/hot-cate.vue"
	import topicList from "@/components/news/topic-list.vue"
	const demo = [{
			username: "昵称",
			userpic: "/static/default.jpg",
			newstime: "2019-10-30 下午04:30",
			isFollow: true,
			title: "我是标题",
			titlepic: "/static/demo/banner1.jpg",
			support: {
				type: "",
				support_count: 0,
				unsupport_count: 2
			},
			comment_count: 2,
			share_num: 2
		},
		{
			username: "杨雨",
			userpic: "/static/default.jpg",
			newstime: "2019-10-30 下午04:30",
			isFollow: true,
			title: "我是标题",
			titlepic: "",
			support: {
				type: "unsupport",
				support_count: 1,
				unsupport_count: 2
			},
			comment_count: 2,
			share_num: 2
		},
		{
			username: "杨雨",
			userpic: "/static/default.jpg",
			newstime: "2019-10-30 下午04:30",
			isFollow: true,
			title: "我是标题",
			titlepic: "",
			support: {
				type: "",
				support_count: 1,
				unsupport_count: 2
			},
			comment_count: 2,
			share_num: 2
		}
	]
	export default {
		components: {
			uniNavBar,
			commonList,
			loadMore,
			hotCate,
			topicList
		},
		data() {
			return {
				scrollH: 500,
				tabIndex: 0,
				tabBars: [{
					name: "关注"
				}, {
					name: "话题"
				}],
				list:[],
				//1.上拉加载更多，2.加载中 3.没有更多了
				 loadMore:'上拉加载更多',
				 hotCate:[
			     {
					 name:"关注"
				 },
				 {
				 	name:"推荐"
				 },
				 {
				 	name:"体育"
				 },
				 {
				 	name:"热点"
				 },
				 {
				 	name:"财经"
				 },
				 {
				 	name:"娱乐"
				 },
				 ],
				 topicList:[
					 {
					 cover:"/static/demo/topicpic/1.jpeg",
					 title:"#话题名称#",
					 desc:"话题描述",
					 today_count:0,
					 news_count:10
				 },
				 {
				    cover:"/static/demo/topicpic/2.jpeg",
				 	title:"#话题名称#",
				 	desc:"话题描述",
				 	today_count:0,
				 	news_count:10
				 },
				 {
				 	cover:"/static/demo/topicpic/3.jpeg",
				 	title:"#话题名称#",
				 	desc:"话题描述",
				 	today_count:0,
				 	news_count:10
				 },
				 {
				 	cover:"/static/demo/topicpic/4.jpeg",
				 	title:"#话题名称#",
				 	desc:"话题描述",
				 	today_count:0,
				 	news_count:10
				 },
				 {
				 	cover:"/static/demo/topicpic/5.jpeg",
				 	title:"#话题名称#",
				 	desc:"话题描述",
				 	today_count:0,
				 	news_count:10
				 },
				 {
				 	cover:"/static/demo/topicpic/6.jpeg",
				 	title:"#话题名称#",
				 	desc:"话题描述",
				 	today_count:0,
				 	news_count:10
				 },
				 {
				 	cover:"/static/demo/topicpic/7.jpeg",
				 	title:"#话题名称#",
				 	desc:"话题描述",
				 	today_count:0,
				 	news_count:10
				 },
				 {
				 	cover:"/static/demo/topicpic/8.jpeg",
				 	title:"#话题名称#",
				 	desc:"话题描述",
				 	today_count:0,
				 	news_count:10
				 },
				 ]
			}
		},
		methods: {
			
			loadmoreEvent(){
				//验证当前是否处于可加载状态
				if(this.loadMore !== '上拉加载更多') return;
				//设置加载状态
				this.loadMore = "加载中"
				setTimeout(()=>{
					//加载数据
					this.list = [...this.list,...this.list]
					//设置加载状态
					this.loadMore = '上拉加载更多'
				},3000)
			},
			//顶踩操作
			doSupport(e){
				//拿到选项卡对应的list
				console.log(e)
				let item = this.list[e.index]
				let msg = e.type === 'support' ? '顶' :'踩'
				if(item.support.type===''){
					item.support[e.type+'_count']++
				}else if(item.support.type==="support" && e.type==='unsupport'){
					item.support.support_count--;
					item.support.unsupport_count++
				}else if(item.support.type==="unsupport" && e.type==='support'){
					item.support.support_count++;
					item.support.unsupport_count--;
				}
				item.support.type = e.type
				uni.showToast({
					title:msg+"成功"
				})
			},
			onChangeTab(e){
				this.tabIndex = e.detail.current
			},
			changeTab(index) {
				this.tabIndex = index
			},
			openAddInput() {
				uni.navigateTo({
					url: "../add-input/add-input"
				})
			},
			openSearch(){
				uni.navigateTo({
					url:"../search/search?type=topic"
				})
			}
		},
		onLoad() {
			uni.getSystemInfo({
				success: res => {
					this.scrollH = res.windowHeight - res.statusBarHeight - 44
				}
			})
			this.list = demo
		}
	}
</script>

<style>

</style>
