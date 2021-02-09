<template>
	<view>
		<scroll-view scroll-x class="scroll-row" :scroll-into-view="scrollInto" scroll-with-animation="true" style="height: 100rpx;">
			<view v-for="(item,index) in tabBars" :key="index" :id="'tab'+index" class="scroll-row-item px-3 py-2" :class="tabBarIndex === index ? 'tabBarActive' : ''" @click="changeTab(index)">{{item.name}}</view>
		</scroll-view>
		
		<swiper :duration="150" :current="tabBarIndex" @change="onChangeTab" :style="'height:'+scrollH+'px'">
			<swiper-item v-for="(item,index) in newslist" :key="index">
				<scroll-view scroll-y="true" :style="'height:'+scrollH+'px'" @scrolltolower="loadMore(index)">
					<!-- 有数据的情况下 -->
					<template v-if="item.list.length > 0">
						<block v-for="(item2,index2) in item.list" :key="index2">
							<topic-list :item="item2" :index="index2"></topic-list>
							</block>
							<load-more :loadMore="item.loadMore"></load-more>
					</template>
					<!-- 无数据的情况下 -->
					<template v-else>
						<no-thing></no-thing>
					</template>
				</scroll-view>
			</swiper-item>
		</swiper>
		
	
	</view>
</template>

<script>
	const demo = [ {
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
				 }]
		
	import topicList from "../../components/news/topic-list.vue"
	import loadMore from "@/components/common/load-more.vue"
	export default {
		components:{
			 topicList,
			 loadMore
		},
		data() {
			return {
				scrollH:600,
				tabBarIndex:0,
				scrollInto:'',
				tabBars:[{
					name:"关注"
				},
				{
					name:"推荐"
				},{
					name:"体育"
				},{
					name:"热点"
				},{
					name:"财经"
				},{
					name:"娱乐"
				},{
					name:"军事"
				}],
			newslist:[]
			}
		},
		methods:{
			// newslist[{
			// 	list:[{}]
			// },list:[{}]]
			getData(){
				let arr = [];
				for(let i=0;i<this.tabBars.length;i++){
					let obj = {
						loadMore:"上拉加载更多...",
						list:[]
					}
					arr.push(obj)
					this.newslist = arr
					if(i<3){
						obj.list = demo;
					}
				}
			},
			onChangeTab(e){
				this.changeTab(e.detail.current)
			},
			follow(e){
				//拿到选项卡对应的list
				let list = this.newslist[this.tabBarIndex].list
				console.log(this.newslist[this.tabBarIndex].list[e])
				console.log(e)
				// this.newslist[2].isFollow = true;
				list[e].isFollow = true
				uni.showToast({title:"关注成功"})
			},
			doSupport(e){
				//拿到选项卡对应的list
				let list = this.newslist[this.tabBarIndex].list
				let item = list[e.index]
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
			changeTab(index){
				this.tabBarIndex = index;
				this.scrollInto = 'tab'+index
			},
			loadMore(index){
				//判断是否处于可加载状态（上拉加载更多）
				// this.newslist[index].loadMore = "加载中"
				let item = this.newslist[index];
				item.loadMore = "加载中";
				setTimeout(()=>{
					//加载数据
					item.list = [...item.list,...item.list]
					//恢复加载状态
					item.loadMore = "上拉加载更多"
					
				},3000)
			}
		},
		//监听导航栏点击搜索框
		onNavigationBarSearchInputClicked(){
			uni.navigateTo({
				url: '../search/search',
			});
		},
		onNavigationBarButtonTap(){
			uni.navigateTo({
				url: '../add-input/add-input',
			});
		},
		onLoad(){
			uni.getSystemInfo({
				success:res=>{
					this.scrollH = res.windowHeight - uni.upx2px(100)
				}
			});
			this.getData();
		}
	}
</script>
<style>
.tabBarActive{
	color: #FF4A6A;
	font-size: 40rpx;
	font-weight: 700;
}
</style>
