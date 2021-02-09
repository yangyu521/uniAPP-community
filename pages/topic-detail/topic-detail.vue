<template>
	<view>
		<topic-info :info="info"></topic-info>
		<divider></divider>
		
		<view class="p-2 flex align-center border-bottom" hover-class="bg-light" v-for="(item,index) in hotList" :key="index">
			<text class="iconfont icon-xihuan text-main"></text>
			<text class="font text-dark text-ellipsis">
				{{item.title}}
			</text>
		</view>
		<divider></divider>
		
		<!-- tab -->
		<view class="flex align-center py-2">
			<view class="flex-1  flex align-center justify-center " v-for="(item,index) in tabBars" :key="index" @click="clickChange(index)" :class="tabBarIndex === index ? 'font-lg font-weight-bold text-main' : ''">
				{{item.name}}
			</view>
			<!-- <view class="flex-1 font-md flex align-center justify-center">最新</view> -->
		</view>
		<!-- 列表 -->
		<template v-if="listDate.length > 0">
			<block v-for="(item,index) in listDate" :key="index">
				<common-list :item="item" :index="index"></common-list>
				<divider></divider>
			</block>
		</template>
		<template v-else>
			<no-thing></no-thing>
		</template>
		<load-more :loadMore="loadtext1"></load-more>
	</view>
</template>

<script>
	const demo = [{
			username:"昵称",
			userpic:"/static/default.jpg",
			newstime:"2019-10-30 下午04:30",
			isFollow:false,
			title:"我是标题",
			titlepic:"/static/demo/banner1.jpg",
			support:{
				type:"",
				support_count:0,
				unsupport_count:2
			},
			comment_count:2,
			share_num:2
		},
		{
			username:"杨雨",
			userpic:"/static/default.jpg",
			newstime:"2019-10-30 下午04:30",
			isFollow:false,
			title:"我是标题",
			titlepic:"",
			support:{
				type:"unsupport",
				support_count:1,
				unsupport_count:2
			},
			comment_count:2,
			share_num:2
		},
		{
			username:"杨雨",
			userpic:"/static/default.jpg",
			newstime:"2019-10-30 下午04:30",
			isFollow:false,
			title:"我是标题",
			titlepic:"",
			support:{
				type:"",
				support_count:1,
				unsupport_count:2
			},
			comment_count:2,
			share_num:2
		}]
		
	import topicInfo from "@/components/topic-detail/topic-info.vue"
	import commonList from "@/components/common/common-list.vue"
	import noThing from "@/components/common/no-thing.vue"
	import loadMore from "@/components/common/load-more.vue"
	export default {
		components:{
			topicInfo,
			commonList,
			noThing,
			loadMore
		},
		data() {
			return {
				info:{
						cover:"/static/demo/topicpic/4.jpeg",
						title:"#话题名称#",
						desc:"话题描述",
						today_count:0,
						news_count:10
				},
				hotList:[{
					title:"【杨雨加油】uni-app社区交友项目实操"
				},
				{
					title:"【致自己】努力就会有收获，态度决定高度，好好学习，天天向上"
				}],
				tabBars:[{
					name:"默认",
				},
				{
					name:"最新"
				}],
				//默认
				list1:[],
				loadtext1:"上拉加载更多",
				//最新
				list2:[],
				tabBarIndex:0,
				loadtext2:"上拉加载更多"
			}
		},
		methods: {
			clickChange(index){
				this.tabBarIndex = index;
			},
			loadMore(){
				//拿到当前的列表
				let index = this.tabBarIndex;
				if(this.loadtext !== "上拉加载更多") return;
				this['loadtext'+(index+1)] = "加载中"
				//设置上拉加载状态处于加载中
				setTimeout(()=>{
					this['list'+(index+1)] = [...this['list'+(index+1)],...this['list'+(index+1)]]
					this['loadtext'+(index+1)] = "上拉加载更多"
				},3000)
			}
		},
		computed:{
			//当前列表数据
			listDate(){
				if(this.tabBarIndex === 0){
					return this.list1
				}else{
					return this.list2
				}
				// return this['list'+this.tabBarIndex+1]
			},
			//上拉加载更多
			loadtext(){
				if(this.tabBarIndex === 0){
					return this.loadtext1
				}else{
					return this.loadtext2
				}
			}
		},
		onLoad(e){
			if(e.detail){
				let res = JSON.parse(e.detail)
				console.log(res)
			}
			this.list1 = demo;
			
		},
		onReachBottom(){
			this.loadMore();
		}
	}
</script>

<style>

</style>
